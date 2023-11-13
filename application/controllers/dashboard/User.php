<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('M_Auth');
        $this->load->model('M_Order');
        $this->load->model('M_Setting');
        $this->load->helper('string');
        $this->load->helper('date');
        $this->load->helper('form');

        if (!$this->session->userdata('is_logged_in')) {

            $this->session->set_flashdata('message_name', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			You have to login first.
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect('auth');
        } else {
            if ($this->session->userdata('role_id') == "2") {
                redirect('/');
            }
        }
    }

    public function index()
    {
        $data = [
            'title' => 'User Page',
            'style' => 'dashboard/layouts/_style',
            'pages' => 'dashboard/pages/user/v_user',
            'script' => 'dashboard/layouts/_script',
            'order' => $this->M_Order->order_count(),
            'orders' => $this->M_Order->order_notification(),
            'partners' => $this->M_Setting->partners(),
            'roles' => $this->M_Setting->roles(),
            'users' => $this->M_Auth->users_list(),
            'user' => $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array()
        ];

        $this->load->view('dashboard/index', $data);
    }

    public function add()
    {

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'The email has already registered'
        ]);
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]', [
            'is_unique' => 'The username has already registered'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        // $this->form_validation->set_message('is_unique', 'The %s is already taken');
        if ($this->form_validation->run() ==  false) {

            // $data = [
            //     'title' => 'User Registration',
            //     'style' => 'dashboard/layouts/_style',
            //     'pages' => 'dashboard/pages/user/v_add_user',
            //     'script' => 'dashboard/layouts/_script',
            //     'order' => $this->M_Order->order_count(),
            //     'orders' => $this->M_Order->order_notification(),
            //     'user' => $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array()
            // ];

            // $this->load->view('dashboard/index', $data);

            $message['status'] = 'failed';
            $message['message'] = strip_tags(validation_errors());

            $this->output->set_content_type('application/json')->set_output(json_encode($message));
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'username' => $this->input->post('username'),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => $this->input->post('member_role'),
                'is_active' => '1',
                'phone_number' => $this->input->post('phone_number'),
                'id_perusahaan' => $this->input->post('company'),
                'date_created' => time()
            ];

            if ($this->M_Auth->add_member_v2($data) > 0) {
                $message['status'] = 'success';
                $message['message'] = 'Member succesfully added';
            } else {
                $message['status'] = 'failed';
            }

            $this->output->set_content_type('application/json')->set_output(json_encode($message));
        }
    }

    public function edit($id)
    {
        $data = $this->M_Auth->cek_user($id);

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function insert_dumy()
    {
        // jumlah data yang akan di insert
        $jumlah_data = 1000;
        for ($i = 1; $i <= $jumlah_data; $i++) {
            $data   =   array(
                "nama_lengkap"  =>  "Karyawan Ke-" . $i,
                "email"         =>  "karyawan-$i@gmil.com",
                "no_hp"         =>  '089699935552',
                "foto"          =>  "foto-karyawan-$i.jpg"
            );
            $this->db->insert('karyawan', $data);
        }
        echo $i . ' Data Berhasil Di Insert';
    }

    public function getData()
    {
        $results = $this->M_Setting->getDataUser();

        $data = [];

        $no = $_POST['start'];

        foreach ($results as $r) {
            $row = array();
            $btn_edit = '<button type="button" class="btn btn-primary" title="Edit Data ' . $r->name . '" onclick="edit(' . "'" . $r->username . "', 'edit'" . ')"><i class="bi bi-pencil-square"></i></button>';

            $btn_password = '<button type="button" class="btn btn-warning" title="Change Password ' . $r->name . '" onclick="change_password(' . "'" . $r->username . "', 'change'" . ')"><i class="bi bi-key"></i></button>';
            $row[] = ++$no;
            $row[] = $r->name;
            $row[] = $r->email;
            $row[] = $r->username;
            $row[] = $r->nama_perusahaan;
            $row[] = '<div class="btn-group" role="group" aria-label="First group">' . $btn_edit . $btn_password . '</div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_Setting->count_all_data(),
            "recordsFiltered" => $this->M_Setting->count_filtered_data(),
            "data" => $data
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function update()
    {
        $data = [
            'name' => htmlspecialchars($this->input->post('name', true)),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'username' => $this->input->post('username'),
            'role_id' => $this->input->post('member_role'),
            'phone_number' => $this->input->post('phone_number'),
            'id_perusahaan' => $this->input->post('company'),
            'date_created' => time()
        ];

        $id = $this->input->post('id');
        if ($this->M_Auth->update_user($data, $id) > 0) {
            $message['status'] = 'success';
            $message['message'] = 'Data of ' . $data['name'] . ' succesfully updated';
        } else {
            $message['status'] = 'failed';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($message));
    }

    public function change_password()
    {
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {

            $message['status'] = 'failed';
            $message['message'] = strip_tags(validation_errors());

            $this->output->set_content_type('application/json')->set_output(json_encode($message));
        } else {
            $data = [
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'updated_at' => time()
            ];

            $id = $this->input->post('id');

            if ($this->M_Auth->update_user($data, $id) > 0) {
                $message['status'] = 'success';
                $message['message'] = 'Password changed succesfully';
            } else {
                $error = $this->db->error();
                $message['status'] = 'failed';
                // $message['message'] = $error['code'] . ' - ' . $error['message'] . ' - ' . $error['messageString'];
                $message['message'] = $error['message'];
            }

            $this->output->set_content_type('application/json')->set_output(json_encode($message));
        }
    }

    public function check_strength()
    {

        // if ($this->input->post('password1') == true) {
        $password = $this->input->post('password1');

        $strength = $this->getPasswordStrength($password);

        if ($strength == "strong") {
            $response = "<span style='color:green;'>Strong</span>";
        } elseif ($strength == "medium") {
            $response = "<span style='color:orange;'>Medium</span>";
        } else if ($strength == "weak") {
            $response = "<span style='color:red;'>Weak</span>";
        }

        echo $response;
        $output['strength'] = $response;
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
        // }
    }

    private function getPasswordStrength($password)
    {
        // Implement your password strength checking logic here
        // You can use regex, length checks, character types, etc.
        // Return "strong", "medium", or "weak" based on your criteria
        // Example: For demonstration purposes, just checking length

        if (strlen($password) >= 8) {
            return 'strong';
        } elseif (strlen($password) >= 6) {
            return 'medium';
        } else {
            return 'weak';
        }
    }
}

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
        $this->load->model('M_Partner');
        $this->load->model('M_Order');
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
            'title' => 'Partner Page',
            'style' => 'dashboard/layouts/_style',
            'pages' => 'dashboard/pages/partner/v_partner',
            'script' => 'dashboard/layouts/_script',
            'order' => $this->M_Order->order_count(),
            'orders' => $this->M_Order->order_notification(),
            'partners' => $this->M_Partner->partners_list(),
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

        if ($this->form_validation->run() ==  false) {

            $data = [
                'title' => 'User Registration',
                'style' => 'dashboard/layouts/_style',
                'pages' => 'dashboard/pages/user/v_add_user',
                'script' => 'dashboard/layouts/_script',
                'order' => $this->M_Order->order_count(),
                'orders' => $this->M_Order->order_notification(),
                'user' => $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array()
            ];

            $this->load->view('dashboard/index', $data);
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
                'date_created' => time()
            ];

            $this->M_Auth->add_member($data);
        }
    }

    public function edit($id)
    {
        $data = [
            'title' => 'User Page',
            'style' => 'dashboard/layouts/_style',
            'pages' => 'dashboard/pages/user/v_add_user',
            'script' => 'dashboard/layouts/_script',
            'order' => $this->M_Order->order_count(),
            'orders' => $this->M_Order->order_notification(),
            'user_detail' => $this->M_Auth->cek_user($id),
            'user' => $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array()
        ];

        $this->load->view('dashboard/index', $data);
    }
}

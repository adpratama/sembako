<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->helper('string');
        $this->load->model('M_Product');
        $this->load->model('M_Home');
        $this->load->model('M_Auth');
        $this->load->helper('date');
    }

    public function index()
    {
        $cart_content = $this->cart->contents();
        $jml_item = 0;

        foreach ($cart_content as $value) {
            $jml_item = $jml_item + $value['qty'];
        }

        $id = $this->session->userdata('username');

        $data = [
            'title' => 'Akun Saya',
            'style' => 'layouts/_style',
            'pages' => 'pages/profile/v_profile',
            'script' => 'layouts/_script',
            'cart_content' => $cart_content,
            'jml_item' => $jml_item,
            'total' => number_format($this->cart->total()),
            'user' => $this->M_Auth->cek_user($id)
        ];

        $this->load->view('index', $data);
    }

    public function update($old_username)
    {
        $cek_username = $this->M_Auth->cek_user($old_username);

        $now = date('Y-m-d H:i:s');

        if ($cek_username == true) {

            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'username' => $this->input->post('username'),
                'updated_at' => $now
            );

            $this->M_Auth->update_user($data, $old_username);
        } else {
            redirect('auth');
        }
    }
}

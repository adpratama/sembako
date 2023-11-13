<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->helper('string');
        $this->load->model('M_Product');
        $this->load->model('M_Home');
        $this->load->model('M_Order');
        $this->load->model('M_Category');
        $this->load->helper('date');
    }

    public function index()
    {
        $cart_content = $this->cart->contents();
        $jml_item = 0;

        foreach ($cart_content as $value) {
            $jml_item = $jml_item + $value['qty'];
        }

        // $id = $this->session->userdata('username');
        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data = [
            'title' => 'Riwayat Transaksi',
            'style' => 'layouts/_style',
            'pages' => 'pages/transaction/v_transaction',
            'category_section' => 'pages/product/v_category_section',
            'best_seller_section' => 'pages/product/v_best_seller',
            'script' => 'layouts/_script',
            'categories' => $this->M_Category->list_category(),
            'best' => $this->M_Product->best(),
            'testimonial' => $this->M_Home->testimonial(),
            'cart_content' => $cart_content,
            'jml_item' => $jml_item,
            'total' => number_format($this->cart->total()),
            'transactions' => $this->M_Order->transaction($user['Id']),
            'user' => $user
        ];

        // var_dump($data['transactions']);
        // exit;
        $this->load->view('index', $data);
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('string');
		$this->load->model('M_Home');
		$this->load->helper('date');
    }

    public function index()
    {
		$data = [
			'title' => 'Cart',
			'style' => 'layouts/_style',
			'pages' => 'pages/order/v_cart',
			'script' => 'layouts/_script',
			'product' => $this->db->order_by('menu_nama', 'ASC')->get('v_menu')->result()
		];

		$this->load->view('index', $data);
    }

    public function add()
    {
        $redirect_page = $this->input->post('redirect_page');

        $data = array(
            'id'      => $this->input->post('id'),
            'qty'     => $this->input->post('qty'),
            'price'   => $this->input->post('price'),
            'name'    => $this->input->post('name')
        );

        // foreach ($data as $d) {
        //     echo $d->name . '<br>';
        // }
        print_r($data);
        exit;

        $this->cart->insert($data);

        $this->session->set_flashdata('success', 'Added successfully');
        redirect($redirect_page, 'refresh');
    }
}

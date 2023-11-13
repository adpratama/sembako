<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('M_Order');
        $this->load->model('M_Auth');
        $this->load->model('M_Product');
        $this->load->model('M_Setting');
        $this->load->helper('date');

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
        $id = $this->session->userdata('username');

        $data = [
            'title' => 'Orders',
            'style' => 'dashboard/layouts/_style',
            'pages' => 'dashboard/pages/order/v_order',
            'script' => 'dashboard/layouts/_script',
            'order' => $this->M_Order->order_count(),
            'orders' => $this->M_Order->order_notification(),
            'transactions' => $this->M_Order->unprocessed_order(),
            'user' => $this->M_Auth->cek_user($id)
        ];
        $this->load->view('dashboard/index', $data);
    }

    public function view($id)
    {
        $data = [
            'title' => 'Transaction',
            'style' => 'dashboard/layouts/_style',
            'pages' => 'dashboard/pages/transaction/v_transaction_detail',
            'script' => 'dashboard/layouts/_script',
            'order' => $this->M_Order->order_count(),
            'orders' => $this->M_Order->order_notification(),
            'details' => $this->M_Order->transaction_detail($id),
            'user' => $this->M_Auth->cek_user($this->session->userdata('username'))
        ];
        $this->load->view('dashboard/index', $data);
    }

    public function getData()
    {
        $jenis = 0;
        $results = $this->M_Order->getDataOrder($jenis);

        $data = [];

        $no = $_POST['start'];

        foreach ($results as $r) {
            $row = array();

            $row[] = ++$no;
            $row[] = $r->menu_nama;
            $row[] = number_format($r->menu_harga);
            $row[] = $r->kategori_nama;
            $row[] = '
			<div class="btn-group" role="group" aria-label="First group">
				<!-- <a href="' . base_url('dashboard/product/stock/' . $r->menu_seo) . '" class="btn btn-success" title="Add stock"><i class="bi bi-plus-circle"></i></a> -->
				<a href="' . base_url('dashboard/product/edit/' . $r->menu_seo) . '" class="btn btn-primary" title="Edit product">
					<i class="bi bi-pencil-square"></i>
				</a>
				<a href="' . base_url('dashboard/product/delete/' . $r->menu_seo) . '" class="btn btn-danger btn-delete" title="Delete product">
					<i class="bi bi-trash"></i>
				</a>
			</div>';
            $data[] = $row;
        }


        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_Product->count_all_data($jenis),
            "recordsFiltered" => $this->M_Product->count_filtered_data($jenis),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
}

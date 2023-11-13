<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('string');
		$this->load->model('M_Auth');
		$this->load->model('M_Order');
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
		$data = [
			'title' => 'Dashboard',
			'style' => 'dashboard/layouts/_style',
			'pages' => 'dashboard/pages/dashboard/v_dashboard',
			'script' => 'dashboard/layouts/_script',
			'dashboard' => $this->M_Order->dashboard(),
			'customer' => $this->M_Auth->dashboard(),
			'admin' => $this->M_Auth->count_admin(),
			'member' => $this->M_Auth->count_member(),
			'order' => $this->M_Order->order_count(),
			'orders' => $this->M_Order->order_notification(),
			'packing' => $this->M_Order->packing(),
			'unpaid' => $this->M_Order->unpaid(),
			'received' => $this->M_Order->received(),
			'paid' => $this->M_Order->paid(),
			'payments' => $this->M_Order->payment_status(),
			'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
		];
		$this->load->view('dashboard/index', $data);
	}
}

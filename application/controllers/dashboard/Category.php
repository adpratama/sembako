<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->helper('string');
		$this->load->helper('url');
		$this->load->model('M_Category');
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
			"title" => "Dashboard",
			"style" => "dashboard/layouts/_style",
			"pages" => "dashboard/pages/category/v_category",
			"categories" => $this->M_Category->list_category(),
			"script" => "dashboard/layouts/_script",
			'order' => $this->M_Order->order_count(),
			'orders' => $this->M_Order->order_notification(),
			'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
		];
		$this->load->view('dashboard/index', $data);
	}

	public function add()
	{
		$data = [
			'title' => 'Add Cateory',
			'style' => 'dashboard/layouts/_style',
			'pages' => 'dashboard/pages/category/v_add_category',
			'categories' => $this->M_Category->list_category(),
			'order' => $this->M_Order->order_count(),
			'orders' => $this->M_Order->order_notification(),
			'script' => 'dashboard/layouts/_script',
			'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
		];

		$this->load->view('dashboard/index', $data);
	}

	public function store()
	{
		$category_name = $this->input->post('category_name');
		$out = explode(" ", $category_name);
		$slug = strtolower(implode("-", $out));

		$now = date('Y-m-d H:i:s');
		$old_slug = $this->uri->segment(4);

		if ($old_slug == true) {

			$data = array(
				'kategori_nama' => $category_name,
				'kategori_seo' => $slug,
				'kategori_update' => $now,
			);

			// var_dump($data);exit;

			$this->M_Category->update_category($data, $old_slug);
		} else {

			$data = array(
				'kategori_nama' => $category_name,
				'kategori_seo' => $slug,
				'kategori_create' => $now
			);

			// var_dump($data);exit;	
			$this->M_Category->add_category($data);
		}
	}

	public function edit($id)
	{
		$id = $this->uri->segment(4);

		$data = [
			'title' => 'Edit Category',
			'style' => 'dashboard/layouts/_style',
			'pages' => 'dashboard/pages/category/v_add_category',
			'category' => $this->M_Category->detail_category($id),
			'order' => $this->M_Order->order_count(),
			'orders' => $this->M_Order->order_notification(),
			'script' => 'dashboard/layouts/_script',
			'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
		];

		$this->load->view('dashboard/index', $data);
	}
}

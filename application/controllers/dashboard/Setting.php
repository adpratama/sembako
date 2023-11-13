<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('M_Auth');

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
			'title' => 'Settings',
			'style' => 'dashboard/layouts/_style',
			'pages' => 'dashboard/pages/setting/v_setting',
			'script' => 'dashboard/layouts/_script',
			'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
		];
		$this->load->view('dashboard/index', $data);
	}
}

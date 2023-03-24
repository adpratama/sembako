<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
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
			'title' => 'Home',
			'style' => 'layouts/_style',
			'pages' => 'pages/home/v_home',
			'script' => 'layouts/_script',
			'best' => $this->db->order_by('menu_jual', 'DESC')->order_by('menu_nama', 'ASC')->limit(3)->get('v_menu')->result()
		];

		$this->load->view('index', $data);
	}
}

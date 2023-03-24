<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

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
			'pages' => 'pages/product/v_browse_product',
			'script' => 'layouts/_script',
			'product' => $this->db->order_by('menu_nama', 'ASC')->get('v_menu')->result()
		];

		$this->load->view('index', $data);
	}
    
	public function show()
	{
        $id = $this->uri->segment(3);
		$data = [
			'title' => 'Home',
			'style' => 'layouts/_style',
			'pages' => 'pages/product/v_detail_product',
			'script' => 'layouts/_script',
			'product_detail' => $this->db->where('menu_seo', $id)->get('v_menu')->row_array(),
			'best' => $this->db->order_by('menu_jual', 'DESC')->order_by('menu_nama', 'ASC')->limit(3)->get('v_menu')->result()
		];

		$this->load->view('index', $data);
	}
}

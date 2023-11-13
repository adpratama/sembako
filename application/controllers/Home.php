<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->helper('string');
		$this->load->model('M_Product');
		$this->load->model('M_Home');
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

		$data = [
			'title' => 'Home',
			'style' => 'layouts/_style',
			'pages' => 'pages/home/v_home',
			'category_section' => 'pages/product/v_category_section',
			'best_seller_section' => 'pages/product/v_best_seller',
			'script' => 'layouts/_script',
			'categories' => $this->M_Category->list_category(),
			'best' => $this->M_Product->best(),
			'cart_content' => $cart_content,
			'jml_item' => $jml_item,
			'total' => number_format($this->cart->total())
		];

		$this->load->view('index', $data);
	}
}

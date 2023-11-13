<?php
defined('BASEPATH') or exit('No direct script access allowed');

class About extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->helper('string');
		$this->load->model('M_Product');
		$this->load->model('M_Home');
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
			'title' => 'About',
			'style' => 'layouts/_style',
			'pages' => 'pages/about/v_about',
			'script' => 'layouts/_script',
			'best' => $this->M_Product->best(),
			'testimonial' => $this->M_Home->testimonial(),
			'cart_content' => $cart_content,
			'jml_item' => $jml_item,
			'total' => number_format($this->cart->total())
		];

		$this->load->view('index', $data);
	}
}

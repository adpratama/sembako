<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{

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
		$this->load->library('pagination');
		$this->load->helper('string');
		$this->load->model('M_Product');
		$this->load->model('M_Home');
		$this->load->helper('date');
	}

	public function index()
	{
		$config['base_url'] = base_url('product/index');
		// $config['page_query_string'] = TRUE;
		// $config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $this->M_Product->get_published_count();
		$config['per_page'] = 12;
		$config['num_link'] = 2;
		$config['full_tag_open'] = '<div class="pagination-wrap"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = FALSE;
		$config['last_link'] = FALSE;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] =  '<li> <a href="#" class="active">';
		$config['cur_tag_close'] = '</a> </li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['display_pages'] = TRUE;
		$from = $this->uri->segment(3);
		$this->pagination->initialize($config);
		$limit = $config['per_page'];
		// $offset = html_escape($this->input->get('per_page'));

		$cart_content = $this->cart->contents();

		$jml_item = 0;

		foreach ($cart_content as $value) {
			$jml_item = $jml_item + $value['qty'];
		}

		$data = [
			'title' => 'Product',
			'style' => 'layouts/_style',
			'pages' => 'pages/product/v_browse_product',
			'script' => 'layouts/_script',
			'products' => $this->M_Product->list_product_limit($limit, $from),
			'cart_content' => $cart_content,
			'jml_item' => $jml_item,
			'total' => number_format($this->cart->total())
		];

		// var_dump($data);exit;

		$this->load->view('index', $data);
	}

	public function show()
	{
		$id = $this->uri->segment(3);

		$cart_content = $this->cart->contents();

		$jml_item = 0;

		foreach ($cart_content as $value) {
			$jml_item = $jml_item + $value['qty'];
		}

		$category = $this->db->select('kategori_seo')->where('menu_seo', $id)->get('v_menu')->row_array();

		$data = [
			'title' => 'Home',
			'style' => 'layouts/_style',
			'pages' => 'pages/product/v_detail_product',
			'related_product' => 'pages/product/v_related_product',
			'script' => 'layouts/_script',
			'product_detail' => $this->M_Product->detail_product($id),
			'products' => $this->M_Product->category($category["kategori_seo"]),
			'jml_item' => $jml_item,
			'cart_content' => $cart_content,
			'best' => $this->M_Product->best(),
			'total' => number_format($this->cart->total())
		];

		$this->load->view('index', $data);
	}

	public function category()
	{
		$id = $this->uri->segment(3);

		$cart_content = $this->cart->contents();

		$jml_item = count($cart_content);

		$data = [
			'title' => 'Home',
			'style' => 'layouts/_style',
			'pages' => 'pages/product/v_category',
			'script' => 'layouts/_script',
			'products' => $this->M_Product->category($id),
			'jml_item' => $jml_item,
			'cart_content' => $cart_content,
			'best' => $this->M_Product->best(),
			'total' => number_format($this->cart->total())
		];

		$this->load->view('index', $data);
	}
}

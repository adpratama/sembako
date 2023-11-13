<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Packet extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->model('M_Product');
        $this->load->model('M_Category');
        $this->load->model('M_Order');
        $this->load->model('M_Auth');
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
            'title' => 'Packets',
            'style' => 'dashboard/layouts/_style',
            'pages' => 'dashboard/pages/products/v_product',
            'script' => 'dashboard/layouts/_script',
            'order' => $this->M_Order->order_count(),
            'orders' => $this->M_Order->order_notification(),
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
        ];
        $this->load->view('dashboard/index', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Add Product',
            'style' => 'dashboard/layouts/_style',
            'pages' => 'dashboard/pages/products/v_add_product',
            'categories' => $this->M_Category->list_category(),
            'products' => $this->M_Product->list_product(),
            'script' => 'dashboard/layouts/_script',
            'order' => $this->M_Order->order_count(),
            'orders' => $this->M_Order->order_notification(),
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
        ];

        if (empty($data["categories"])) {
            $this->session->set_flashdata('message_name', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				Category list not available. Please add first
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');
            redirect('dashboard/category/add');
        }

        $this->load->view('dashboard/index', $data);
    }

    public function store()
    {
        // ambil nilai menu_kode terbesar
        $query = $this->M_Product->max_number();

        $new_code = $query["menu_kode"] + 1;

        $product_name = $this->input->post('product_name');

        // pembuatan slug dari nama produk
        $out = explode(" ", $product_name);
        $slug = preg_replace("/[^A-Za-z0-9\-]/", "", strtolower(implode("-", $out)));

        $now = date('Y-m-d H:i:s');

        $old_slug = $this->uri->segment(4);

        if ($old_slug == true) {

            $data = array(
                'menu_nama' => $product_name,
                'kategori_id' => $this->input->post('product_category'),
                'menu_seo' => $slug,
                'menu_deskripsi' => $this->input->post('product_description'),
                'menu_harga' => $this->input->post('product_price'),
                'menu_update' => $now,
                'jenis_produk' => $this->input->post('product_type'),
                'harga_modal' => $this->input->post('capital_price'),
                'diskon' => $this->input->post('discount')
            );

            $this->M_Product->update_product($data, $old_slug);
        } else {

            $data = array(
                'menu_nama' => $product_name,
                'kategori_id' => $this->input->post('product_category'),
                'menu_kode' => $new_code,
                'menu_seo' => $slug,
                'menu_deskripsi' => $this->input->post('product_description'),
                'menu_harga' => $this->input->post('product_price'),
                'menu_foto' => $_FILES["product_photo"]["name"],
                'menu_create' => $now,
                'jenis_produk' => $this->input->post('product_type'),
                'harga_modal' => $this->input->post('capital_price'),
                'diskon' => $this->input->post('discount')
            );
            // var_dump($data);exit;

            $this->M_Product->add_product($data);
        }
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Product',
            'style' => 'dashboard/layouts/_style',
            'pages' => 'dashboard/pages/products/v_add_product',
            'categories' => $this->M_Category->list_category(),
            'products' => $this->M_Product->detail_product($id),
            'order' => $this->M_Order->order_count(),
            'orders' => $this->M_Order->order_notification(),
            'script' => 'dashboard/layouts/_script',
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
        ];

        $this->load->view('dashboard/index', $data);
    }

    public function delete($id)
    {
        $this->M_Product->delete_product($id);
    }

    public function update_photo($menu_seo)
    {

        $now = date('Y-m-d H:i:s');

        $data = array(
            'menu_foto' => $_FILES["product_photo"]["name"],
            'menu_update' => $now
        );

        // var_dump($data);exit;

        $this->M_Product->update_photo($data, $menu_seo);
    }

    public function stock($id)
    {
        $id = $this->uri->segment(4);

        $data = [
            'slug' => $id,
            'product' => $this->M_Product->detail_product($id),
            'title' => 'Add Product Stock',
            'style' => 'dashboard/layouts/_style',
            'pages' => 'dashboard/pages/products/v_add_product_stock',
            'order' => $this->M_Order->order_count(),
            'orders' => $this->M_Order->order_notification(),
            'script' => 'dashboard/layouts/_script',
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
        ];

        $this->load->view('dashboard/index', $data);
    }

    public function add_stock($id)
    {
        $slug = $this->uri->segment(4);

        $product = $this->M_Product->detail_product($id);

        $now = date('Y-m-d H:i:s');


        $stok_awal = $product['menu_stok'];
        $stok_baru = $this->input->post('product_stock');
        $new_stock = $stok_awal + $stok_baru;

        $data = array(
            'menu_stok' => $new_stock,
            'menu_update' => $now
        );

        $data_history = array(
            'id_product' => $product['menu_id'],
            'qty' => $stok_baru,
            'add_by' => $this->session->userdata('username'),
            'added_at' => $now,
        );

        $this->M_Product->add_stock($slug, $data, $data_history);
    }

    public function detail($id)
    {
        $id_package = $this->M_Product->detail_product($id);

        $id_package = $id_package['menu_id'];
        $data = [
            'title' => 'Detail Product',
            'style' => 'dashboard/layouts/_style',
            'pages' => 'dashboard/pages/products/v_detail_product',
            'categories' => $this->M_Category->list_category(),
            'details' => $this->M_Product->detail_package($id_package),
            'product' => $this->M_Product->detail_product($id),
            'products' => $this->M_Product->nonpackaged_list_product(),
            'order' => $this->M_Order->order_count(),
            'orders' => $this->M_Order->order_notification(),
            'script' => 'dashboard/layouts/_script',
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
        ];

        $this->load->view('dashboard/index', $data);
    }

    public function add_package()
    {
        $slug = $this->uri->segment(4);

        $product = $this->M_Product->detail_product($slug);

        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $now = date('Y-m-d H:i:s');

        $data = array(
            'id_paket' => $product["menu_id"],
            'id_produk' => $this->input->post('id_product'),
            'qty' => $this->input->post('qty'),
            'created_by' => $user["Id"],
            'created_at' => $now,
        );

        $this->M_Product->add_package($data, $slug);
    }

    public function getData()
    {
        $jenis = 2;
        $results = $this->M_Product->getDataProduct($jenis);

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
				<a href="' . base_url('dashboard/packet/detail/' . $r->menu_seo) . '" class="btn btn-success" title="Delete product">
					<i class="bi bi-eye"></i>
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

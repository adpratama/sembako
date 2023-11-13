<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('string');
        $this->load->model('M_Order');
        $this->load->model('M_Product');
        $this->load->model('M_Auth');
        $this->load->helper('date');
        $this->load->helper('form');
    }

    public function index()
    {
        $cart_content = $this->cart->contents();

        if (empty($cart_content)) {
            redirect('home');
        }

        $jml_item = 0;

        foreach ($cart_content as $key => $value) {
            $jml_item = $jml_item + $value['qty'];
        }

        $subtotal = $this->cart->total();
        $ppn = $subtotal * 0.1;
        $grandtotal = $subtotal + $ppn;

        $data = [
            'title' => 'Cart',
            'style' => 'layouts/_style',
            'pages' => 'pages/order/v_cart',
            'script' => 'layouts/_script',
            'cart_content' => $cart_content,
            'jml_item' => $jml_item,
            'subtotal' => $subtotal,
            'total' => number_format($subtotal),
            'ppn' => $ppn,
            'grandtotal' => $grandtotal
        ];

        $this->load->view('index', $data);
    }

    public function add()
    {
        $redirect_page = $this->input->post('redirect_page');

        $item_name = $this->input->post('name');
        $item_name = str_replace(['(', ')'], '-', $item_name);

        $data = array(
            'id'      => $this->input->post('id'),
            'qty'     => $this->input->post('qty'),
            'price'   => $this->input->post('price'),
            'name'    => $item_name
        );

        $this->M_Order->add($data);

        $this->session->set_flashdata('message_name', 'The product add to cart successfully.');
        redirect($redirect_page, 'refresh');
    }

    public function update()
    {
        $items = $this->cart->contents();
        $i = 1;
        foreach ($items as $item) {
            $data = array(
                'rowid' => $item['rowid'],
                'qty' => $this->input->post($i . '[qty]')
            );

            $this->cart->update($data);
            $i++;
        }

        redirect('order');
    }

    public function delete($rowid)
    {
        $this->cart->remove($rowid);
        redirect('order');
    }

    public function clear()
    {
        $this->cart->destroy();
        redirect('order');
    }

    public function checkout()
    {
        if (!$this->session->userdata('is_logged_in')) {

            $this->session->set_flashdata('message_name', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			You have to login first.
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect('auth');
        }

        $cart_content = $this->cart->contents();

        if (empty($cart_content)) {
            redirect('home');
        }

        $jml_item = 0;

        foreach ($cart_content as $key => $value) {
            $jml_item = $jml_item + $value['qty'];
        }

        $subtotal = $this->cart->total();
        $ppn = $subtotal * 0.1;
        $grandtotal = $subtotal + $ppn;

        $data = [
            'title' => 'Cart',
            'style' => 'layouts/_style',
            'pages' => 'pages/order/v_checkout',
            'script' => 'layouts/_script',
            'members' => $this->M_Auth->member_list(),
            'cart_content' => $cart_content,
            'jml_item' => $jml_item,
            'subtotal' => $subtotal,
            'total' => number_format($subtotal, 2, ',', '.'),
            'ppn' => number_format($ppn, 2, ',', '.'),
            'grandtotal' => number_format($grandtotal, 2, ',', '.'),
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
        ];

        $this->load->view('index', $data);
    }

    public function send_order()
    {
        $this->form_validation->set_rules('id_pemesan', 'Pemesan', 'required|trim');

        if ($this->form_validation->run() ==  false) {
            redirect('order/checkout');
        }

        // ambil nilai menu_kode terbesar
        $query = $this->M_Order->max_number();

        $new_code = $query["no_invoice"] + 1;

        $cart = $this->cart->contents();

        $subtotal = $this->cart->total();

        $total_item  = $this->cart->total_items();
        $ppn = $subtotal * 0.1;
        $total = $subtotal + $ppn;

        $now = date('Y-m-d H:i:s');

        $user = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        $data = array(
            'no_invoice' => $new_code,
            'id_pemesan' => $this->input->post('id_pemesan'),
            'total_item' => $total_item,
            'subtotal' => $subtotal,
            'ppn' => $ppn,
            'grand_total' => $total,
            'order_time' => $now,
            'payment_status' => 0,
            'user_input' => $user['Id']
        );

        $this->M_Order->add_transaction($data);

        $no = 1;
        foreach ($cart as $c) {
            // ambil menu_jual sebelumnya sesuai id product
            $item_jual = $this->M_Product->check_qty($c['id']);

            // tambahkan menu_jual sebelumnya dengan qty yang dipesan
            $new_qty = $item_jual['menu_jual'] + $c['qty'];

            $update_qty = array(
                'menu_jual' => $new_qty
            );

            $this->M_Product->update_menu_jual($update_qty, $c['id']);

            $a[] = $no . '. ' . $c['qty'] . ' ' . $c['name'] . ' @ Rp' . number_format($c['price']) . ',- : Rp' . number_format($c['subtotal']) . ',-';
            $no++;
            $b = array(
                'id_transaction' => $new_code,
                'id_product' => $c["id"],
                'jumlah' => $c["qty"],
                'harga_satuan' => $c["price"],
                'subtotal' => $c["subtotal"],
                'created_at' => $now,
            );
            $this->M_Order->add_transaction_detail($b);
        }

        $b = implode('%0a', $a);

        $this->cart->destroy();

        $this->session->set_flashdata('message_name', 'The order has been added.');
        redirect('home');
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('M_Order');
        $this->load->model('M_Auth');
        $this->load->model('M_Product');
        $this->load->model('M_Setting');
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
        $id = $this->session->userdata('username');

        $data = [
            'title' => 'Transaction',
            'style' => 'dashboard/layouts/_style',
            'pages' => 'dashboard/pages/transaction/v_transaction',
            'script' => 'dashboard/layouts/_script',
            'order' => $this->M_Order->order_count(),
            'orders' => $this->M_Order->order_notification(),
            'transactions' => $this->M_Order->processed_order(),
            'packing' => $this->M_Order->packing(),
            'unpaid' => $this->M_Order->unpaid(),
            'received' => $this->M_Order->received(),
            'paid' => $this->M_Order->paid(),
            'payments' => $this->M_Order->payment_status(),
            'user' => $this->M_Auth->cek_user($id)
        ];
        $this->load->view('dashboard/index', $data);
    }

    public function view($id)
    {
        $data = [
            'title' => 'Transaction',
            'style' => 'dashboard/layouts/_style',
            'pages' => 'dashboard/pages/transaction/v_transaction_detail',
            'script' => 'dashboard/layouts/_script',
            'order' => $this->M_Order->order_count(),
            'orders' => $this->M_Order->order_notification(),
            'details' => $this->M_Order->transaction_detail($id),
            'user' => $this->M_Auth->cek_user($this->session->userdata('username'))
        ];
        $this->load->view('dashboard/index', $data);
    }

    public function process($id)
    {
        $redirect = "dashboard/order";

        $data = array(
            'payment_status' => "1",
        );

        $this->M_Order->process_order($id, $data, $redirect);
    }

    public function packing_done($id)
    {
        $redirect = "dashboard/transaction";

        $data = array(
            'payment_status' => "2",
        );

        $this->M_Order->process_order($id, $data, $redirect);
    }

    public function received($id)
    {
        $redirect = "dashboard/transaction";

        $data = array(
            'payment_status' => "3",
        );

        $this->M_Order->process_order($id, $data, $redirect);
    }

    public function paid($id)
    {
        $redirect = "dashboard/transaction";

        $data = array(
            'payment_status' => "4",
        );

        $this->M_Order->process_order($id, $data, $redirect);
    }

    public function print_label($id)
    {
        $order = $this->M_Order->transaction_id($id);
        $pemesan = $this->M_Auth->member_list_id($order['id_pemesan']);
        $details = $this->M_Order->transaction_detail($id);

        $data = [
            'title' => 'Label',
            'order' => $order,
            'pemesan' => $pemesan,
            'details' => $details,
            'user' => $this->M_Auth->cek_user($this->session->userdata('username'))
        ];

        $this->load->view('dashboard/pages/transaction/v_print_label', $data);
    }

    public function check_tanda_terima()
    {
        $check = $this->input->post('check');

        $redirect = "dashboard/transaction";

        $data = array(
            'payment_status' => "3",
        );

        $this->M_Order->process_order_checklist($check, $data, $redirect);
    }
}

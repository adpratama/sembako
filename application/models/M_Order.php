<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Order extends CI_Model
{
	var $table = 'transaction';
	var $column_order = array(null, 'menu_nama', 'menu_harga', 'menu_seo', 'kategori_nama');
	var $order = array(null, 'menu_nama', 'menu_harga', 'menu_seo', 'kategori_nama');
	public function add($data)
	{
		$query = $this->cart->insert($data);

		return $query;
	}

	public function max_number()
	{
		$this->db->select_max('no_invoice');
		$query = $this->db->get('transaction')->row_array();

		return $query;
	}

	public function add_transaction($data)
	{
		$query = $this->db->insert('transaction', $data);

		return $query;
	}

	public function add_transaction_detail($b)
	{
		$query = $this->db->insert('transaction_detail', $b);

		return $query;
	}

	public function transaction($id)
	{
		$query = $this->db->where('id_pemesan', $id)->order_by('order_time', 'DESC')->get('transaction')->result();

		return $query;
	}

	public function transaction_detail($id)
	{
		$query = $this->db->where('id_transaction', $id)->order_by('Id', 'ASC')->get('transaction_detail')->result();

		return $query;
	}

	public function unprocessed_order()
	{
		$query = $this->db->where('payment_status', '0')->order_by('order_time', 'DESC')->get('transaction')->result();

		return $query;
	}

	public function processed_order()
	{
		$query = $this->db->where('payment_status !=', '0')->order_by('order_time', 'DESC')->get('transaction')->result();

		return $query;
	}

	public function dashboard()
	{
		$this->db->select_sum('subtotal');
		$this->db->select_sum('total_item');
		$query = $this->db->get('transaction')->row_array();

		return $query;
	}

	public function order_notification()
	{
		$query = $this->db->where('payment_status', '0')->order_by('order_time', 'DESC')->get('transaction', '4', '0')->result();

		return $query;
	}

	public function order_count()
	{
		$query = $this->db->where('payment_status', '0')->get('transaction')->num_rows();

		return $query;
	}

	public function process_order($id, $data, $redirect)
	{
		$this->db->where('Id', $id);
		$this->db->update('transaction', $data);
		$this->session->set_flashdata('message_name', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			The order is being processed.
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
		// After that you need to used redirect function instead of load view such as 
		redirect("$redirect");
	}

	public function process_order_checklist($check, $data, $redirect)
	{
		foreach ($check as $c) {
			$this->db->where('Id', $c);
			$this->db->update('transaction', $data);
		}
		$this->session->set_flashdata('message_name', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			The order is being processed.
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
		// After that you need to used redirect function instead of load view such as 
		redirect("$redirect");
	}

	public function transaction_excel($id)
	{
		$query = $this->db->where('payment_status', $id)->get('transaction')->result();

		// echo '<pre>';
		// print_r($query);
		// echo '</pre>';
		// exit;
		return $query;
	}

	public function transaction_detail_excel($id)
	{
		$query = $this->db->select('id_product, sum(jumlah)')->where('id_transaction', $id)->group_by('id_product')->get('transaction_detail')->result();

		// echo '<pre>';
		// print_r($query);
		// echo '</pre>';
		// exit;

		return $query;
	}

	public function packing()
	{
		$query = $this->db->where('payment_status', '1')->get('transaction')->num_rows();

		return $query;
	}

	public function unpaid()
	{
		$query = $this->db->where('payment_status', '2')->get('transaction')->num_rows();

		return $query;
	}

	public function unpaid_list()
	{
		$query = $this->db->where('payment_status', '2')->get('transaction')->result();

		return $query;
	}

	public function received()
	{
		$query = $this->db->where('payment_status', '3')->get('transaction')->num_rows();

		return $query;
	}

	public function paid()
	{
		$query = $this->db->where('payment_status', '4')->get('transaction')->num_rows();

		return $query;
	}

	public function transaction_id($id)
	{
		$query = $this->db->where('Id', $id)->get('transaction')->row_array();

		return $query;
	}

	public function payment_status()
	{
		$query = $this->db->get('payment_status')->result();

		return $query;
	}

	public function getDataOrder($jenis)
	{
		$this->_get_data_query($jenis);

		if ($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}

		$query = $this->db->where('payment_status', $jenis)->get()->result();

		return $query;
	}

	private function _get_data_query($jenis)
	{
		$this->db->where('payment_status', $jenis)->from($this->table);

		if (isset($_POST['search']['value'])) {
			$this->db->like('menu_nama', $_POST['search']['value']);
			$this->db->or_like('kategori_nama', $_POST['search']['value']);
		}

		if (isset($_POST['order'])) {
			$this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else {
			$this->db->order_by('menu_nama', 'ASC');
		}
	}

	public function count_filtered_data($jenis)
	{
		$this->_get_data_query($jenis);

		$query = $this->db->where('payment_status', $jenis)->get();

		return $query->num_rows();
	}

	public function count_all_data($jenis)
	{
		$this->db->where('payment_status', $jenis)->from($this->table);

		return $this->db->count_all_results();
	}
}

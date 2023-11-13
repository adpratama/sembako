<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Product extends CI_Model
{
	var $table = 'v_menu';
	var $column_order = array(null, 'menu_nama', 'menu_harga', 'menu_seo', 'kategori_nama');
	var $order = array(null, 'menu_nama', 'menu_harga', 'menu_seo', 'kategori_nama');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function list_product()
	{
		$query = $this->db->where('jenis_produk', '1')->order_by('menu_nama', 'ASC')->get('v_menu')->result();
		return $query;
	}

	public function list_packet()
	{
		$query = $this->db->where('jenis_produk', '2')->order_by('menu_nama', 'ASC')->get('v_menu')->result();
		return $query;
	}

	public function list_product_limit($limit, $from)
	{
		$query = $this->db->where('jenis_produk', '2')->order_by('menu_nama', 'ASC')->get('v_menu', $limit, $from)->result();
		return $query;
	}

	public function add_product($data)
	{
		$this->db->select('count(menu_id) as id');
		$this->db->where('menu_seo', $data["menu_seo"]);
		$query_check = $this->db->get('menu')->row_array();

		$hasil = $query_check["id"];

		if ($hasil > 0) {
			$this->session->set_flashdata('message_name', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
			The product is already available.
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect('dashboard/product/add');
		} else {

			$config = array(
				'upload_path' => 'assets/img/products/',
				'allowed_types' => "gif|jpg|png|jpeg|JPEG|JPG|PNG|GIF",
				'overwrite' => TRUE,
				'max_size' => "99999999999",
				'max_height' => "800",
				'max_width' => "1500",
				'file_name' => $data["menu_foto"]
			);

			// var_dump($config);exit;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('product_photo')) {
				$error = array('error' => $this->upload->display_errors());

				$this->session->set_flashdata('message_name', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				The photo has not been uploaded yet. Error message: ' . $this->upload->display_errors() . '.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');
				// After that you need to used redirect function instead of load view such as 
				redirect("dashboard/product/add", $error);
			} else {

				$this->db->insert('menu', $data);
				$this->session->set_flashdata('message_name', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				The product inserted successfully.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');
				// After that you need to used redirect function instead of load view such as 
				redirect("dashboard/product/add");
			}
		}
	}

	public function update_product($data, $old_slug)
	{
		$this->db->where('menu_seo', $old_slug);
		$this->db->update('menu', $data);
		$this->session->set_flashdata('message_name', 'The product updated successfully.');
		// After that you need to used redirect function instead of load view such as 
		redirect("dashboard/product");
	}

	public function best()
	{
		$query = $this->db->order_by('menu_jual', 'DESC')->get('v_menu')->result();
		return $query;
	}

	public function detail_product($id)
	{
		$query = $this->db->where('menu_seo', $id)->get('v_menu')->row_array();
		return $query;
	}

	public function detail_product_id($id)
	{
		$query = $this->db->where('menu_id', $id)->get('v_menu')->row_array();
		return $query;
	}

	public function product_image($id_gambar)
	{
		$query = $this->db->select('menu_foto, menu_seo, menu_stok')->where('menu_id', $id_gambar)->get('v_menu')->row();
		return $query;
	}

	public function max_number()
	{
		$this->db->select_max('menu_kode');
		$query = $this->db->get('menu')->row_array();

		return $query;
	}

	public function check_qty($id)
	{
		$this->db->select('menu_jual')->where('menu_id', $id);
		$query = $this->db->get('menu')->row_array();

		return $query;
	}

	public function update_menu_jual($qty, $id)
	{
		$this->db->where('menu_id', $id);
		$query = $this->db->update('menu', $qty);

		return $query;
	}

	public function delete_product($id)
	{
		$query = $this->db->where('menu_seo', $id)->get('v_menu')->row_array();

		$foto = $query["menu_foto"];

		$path = "assets/img/products/" . $foto;

		if (file_exists($path)) {
			unlink($path);
			$this->db->where('menu_seo', $id);
			$this->db->delete('menu');
			$this->session->set_flashdata('message_name', 'dihapus');
			// After that you need to used redirect function instead of load view such as 
			redirect("dashboard/product");
		} else {
			echo "foto tidak ada";
		}
	}

	public function update_photo($data, $menu_seo)
	{
		$query = $this->db->where('menu_seo', $menu_seo)->get('v_menu')->row_array();

		$foto = $query["menu_foto"];
		$path = "assets/img/products/" . $foto;

		// var_dump($path);exit;

		if (file_exists($path)) {
			unlink($path);
		}

		$config = array(
			'upload_path' => 'assets/img/products/',
			'allowed_types' => "gif|jpg|png|jpeg|JPEG|JPG|PNG|GIF",
			'overwrite' => TRUE,
			'max_size' => "99999999999",
			'max_height' => "",
			'max_width' => "",
			'file_name' => $data["menu_foto"]
		);

		// var_dump($config);exit;
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('product_photo')) {
			$error = array('error' => $this->upload->display_errors());

			$this->session->set_flashdata('message_name', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			The photo has not been uploaded yet.
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			// After that you need to used redirect function instead of load view such as 
			redirect("dashboard/product/edit/" . $menu_seo, $error);
		} else {
			$this->db->where('menu_seo', $menu_seo);
			$this->db->update('menu', $data);
			$this->session->set_flashdata('message_name', 'The photo has been successfully modified.');
			// After that you need to used redirect function instead of load view such as 
			redirect("dashboard/product/edit/" . $menu_seo);
		}
	}

	public function category($id)
	{
		$query = $this->db->where('kategori_seo', $id)->order_by('menu_nama', 'ASC')->get('v_menu')->result();
		return $query;
	}

	public function add_stock($slug, $data, $data_history)
	{

		$this->db->where('menu_seo', $slug);
		$this->db->update('menu', $data);

		$this->db->insert('history_product', $data_history);

		$this->session->set_flashdata('message_name', $data_history['qty'] . ' stock added successfully.');
		// After that you need to used redirect function instead of load view such as 
		redirect("dashboard/product");
	}

	public function detail_package($id)
	{
		$query = $this->db->where('id_paket', $id)->get('detail_product')->result();
		return $query;
	}

	public function nonpackaged_list_product()
	{
		$query = $this->db->where('jenis_produk', '1')->order_by('menu_nama', 'ASC')->get('v_menu')->result();
		return $query;
	}

	public function add_package($data, $slug)
	{
		$this->db->insert('detail_product', $data);

		$this->session->set_flashdata('message_name', 'Package content added successfully.');
		// After that you need to used redirect function instead of load view such as 
		redirect("dashboard/product/detail/" . $slug);
	}

	public function getDataProduct($jenis)
	{
		$this->_get_data_query($jenis);

		if ($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}

		$query = $this->db->where('jenis_produk', $jenis)->get()->result();

		return $query;
	}

	private function _get_data_query($jenis)
	{
		$this->db->where('jenis_produk', $jenis)->from($this->table);

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

		$query = $this->db->where('jenis_produk', $jenis)->get();

		return $query->num_rows();
	}

	public function count_all_data($jenis)
	{
		$this->db->where('jenis_produk', $jenis)->from($this->table);

		return $this->db->count_all_results();
	}
}

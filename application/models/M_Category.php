<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Category extends CI_Model
{
    var $table = 'kategori';
    var $column_order = array(null, 'nama_paket');
    var $column_search = array(null, 'nama_paket');
    var $order = array('id' => 'asc');

    public function list_category()
    {
        $query = $this->db->order_by('kategori_nama', 'ASC')->get('kategori')->result();
        return $query;
    }

    public function add_category($data)
    {
        $this->db->select('count(kategori_id) as id');
        $this->db->where('kategori_seo', $data["kategori_seo"]);
        $query_check = $this->db->get('kategori')->row_array();

        $hasil = $query_check["id"];

        if ($hasil > 0) {
            $this->session->set_flashdata('message_name', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
			The category is already available.
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect('dashboard/category/add');
        } else {
            // $data2 = array('image_metadata' => $this->upload->data());
            $this->db->insert('kategori', $data);
            $this->session->set_flashdata('message_name', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				The category <strong>' . $data["kategori_nama"] . '</strong> inserted successfully.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');
            // After that you need to used redirect function instead of load view such as 
            redirect("dashboard/category/add");
        }
    }

    public function update_category($data, $old_slug)
    {
        $this->db->where('kategori_seo', $old_slug);
        $this->db->update('kategori', $data);
        // $this->session->set_flashdata('message_name', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        // 	The category updated successfully.
        // 	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        // 	</div>');
        $this->session->set_flashdata('message_name', 'The category updated successfully.');
        // After that you need to used redirect function instead of load view such as 
        redirect("dashboard/category");
    }

    public function detail_category($id)
    {
        $query = $this->db->where('kategori_seo', $id)->get('kategori')->row_array();
        return $query;
    }
}

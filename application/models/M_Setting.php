<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Setting extends CI_Model
{
    var $table = 'v_karyawan';
    var $column_order = array('id_karyawan', 'name', 'email', 'username', 'nama_perusahaan');
    var $order = array('id_karyawan', 'name', 'email', 'username', 'nama_perusahaan');


    public function payment_status($id)
    {
        $query = $this->db->where('status', $id)->get('payment_status')->row_array();

        return $query;
    }

    public function roles()
    {
        $query = $this->db->get('user_role')->result();

        return $query;
    }

    public function partners()
    {
        $query = $this->db->get('partner')->result();

        return $query;
    }

    public function download_tagihan($bulan, $perusahaan)
    {
        $sql = "SELECT a.Id, no_invoice, name, c.nama as nama_perusahaan, total_item, subtotal, order_time FROM transaction a INNER JOIN user b ON a.id_pemesan = b.Id INNER JOIN partner c ON b.id_perusahaan = c.Id WHERE payment_status = '3' AND id_perusahaan = '$perusahaan' AND order_time LIKE '$bulan%'";

        $query = $this->db->query($sql)->result();

        return $query;
    }

    public function getDataUser()
    {
        $this->_get_data_query();

        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get()->result();

        // print_r($query);
        // exit;

        return $query;
    }

    private function _get_data_query()
    {
        $this->db->from($this->table);

        if (isset($_POST['search']['value'])) {
            $this->db->like('name', $_POST['search']['value']);
            $this->db->or_like('email', $_POST['search']['value']);
            $this->db->or_like('username', $_POST['search']['value']);
            $this->db->or_like('nama_perusahaan', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('name', 'ASC');
        }
    }

    public function count_filtered_data()
    {
        $this->_get_data_query();

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function count_all_data()
    {
        $this->db->from($this->table);

        return $this->db->count_all_results();
    }
}

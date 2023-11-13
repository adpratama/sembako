<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Auth extends CI_Model
{
    var $table = 'user';

    public function registration($data)
    {
        $this->db->insert('user', $data);

        $this->session->set_flashdata('success', 'You have successfully registered. Please login!');
        redirect('auth');
    }

    public function cek_user($id)
    {
        if (empty($id)) {
            redirect('auth');
        }

        $query = $this->db->get_where('user', ['username' => $id])->row_array();

        return $query;
    }

    public function cek_user_id($id)
    {
        if (empty($id)) {
            redirect('auth');
        }

        $query = $this->db->get_where('user', ['Id' => $id])->row_array();

        return $query;
    }

    public function update_user($data, $id)
    {
        $this->db->where('Id', $id);
        $this->db->update('user', $data);

        return $this->db->affected_rows();
    }

    public function role($id)
    {

        $query = $this->db->get_where('user_role', ['Id' => $id])->row_array();

        return $query;
    }

    public function dashboard()
    {
        $query = $this->db->get_where('user')->num_rows();

        return $query;
    }

    public function count_admin()
    {
        $query = $this->db->get_where('user', ['role_id' => '1'])->num_rows();

        return $query;
    }

    public function count_member()
    {
        $query = $this->db->get_where('user', ['role_id' => '2'])->num_rows();

        return $query;
    }

    public function users_list()
    {
        $query = $this->db->get('user')->result();

        return $query;
    }

    public function add_member($data)
    {
        $this->db->insert('user', $data);

        $this->session->set_flashdata('message_name', 'Member succesfully added');

        redirect('dashboard/user');
    }

    public function add_member_v2($data)
    {
        $this->db->insert('user', $data);

        return $this->db->affected_rows();
    }

    public function member_list()
    {
        $array = array('role_id' => '2', 'is_active' => '1');
        $query = $this->db->select('id_karyawan, name, username, nama_perusahaan')->where($array)->get('v_karyawan')->result();

        return $query;
    }

    public function member_list_id($id)
    {
        $array = array('id_karyawan' => $id);
        $query = $this->db->select('id_karyawan, name, username, nama_perusahaan')->where($array)->get('v_karyawan')->row_array();

        return $query;
    }
}

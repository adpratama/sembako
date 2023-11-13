<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Partner extends CI_Model
{
    var $table = 'partner';
    var $column_order = array(null, 'nama_paket');
    var $column_search = array(null, 'nama_paket');
    var $order = array('id' => 'asc');

    public function partners_list()
    {
        $query = $this->db->get('partner')->result();

        return $query;
    }
}

<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Home extends CI_Model
{
   var $table = 'v_menu';
   var $column_order = array(null, 'nama_paket');
   var $column_search = array(null, 'nama_paket');
   var $order = array('id' => 'asc');

   public function testimonial()
   {
      $query = $this->db->order_by('created_at', 'DESC')->get('testimonial')->result();
      return $query;
   }
}

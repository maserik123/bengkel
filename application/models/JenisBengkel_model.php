<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JenisBengkel_model extends CI_Model
{
    function getAllJenisBengkel()
    {
        $this->db->select('*');
        $this->db->from('jenis_bengkel');
        $this->db->order_by('id_jenis_bengkel', 'desc');
        return $this->db->get()->result();
    }
}

/* End of file JenisBengkel_model.php */

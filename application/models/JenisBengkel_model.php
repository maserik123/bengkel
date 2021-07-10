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

    function getDataJenisBengkel()
    {
        $this->datatables->select('id_jenis_bengkel, judul, keterangan, keterangan');
        $this->datatables->from('jenis_bengkel');
        return $this->datatables->generate();
    }

    function getById($id)
    {
        $this->db->select('*');
        $this->db->from('jenis_bengkel');
        $this->db->where('id_jenis_bengkel', $id);
        return $this->db->get()->row();
    }

    public function getAllBengkel()
    {
        $this->db->select('*');
        $this->db->from('jenis_bengkel');
        $this->db->order_by('id_jenis_bengkel', 'desc');
        $this->db->get();
        return $this->db->result();
    }

    public function addData($data)
    {
        $this->db->insert('jenis_bengkel', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('jenis_bengkel ap', array('ap.id_jenis_bengkel' => $id))->result();
    }

    function update($id, $data)
    {
        $this->db->where('id_jenis_bengkel', $id);
        $this->db->update('jenis_bengkel', $data);
        return $this->db->affected_rows();
    }

    function delete($id)
    {
        $this->db->where('id_jenis_bengkel', $id);
        $this->db->delete('jenis_bengkel');
    }
}

/* End of file JenisBengkel_model.php */

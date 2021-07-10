<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PemilikBengkel_model extends CI_Model
{

    function getDataPemilikBengkel()
    {
        $this->datatables->select('id_pemilik_bengkel, nama_pemilik, alamat, no_hp, email, create_date');
        $this->datatables->from('pemilik_bengkel pb');
        return $this->datatables->generate();
    }

    function getById($id)
    {
        $this->db->select('*');
        $this->db->from('pemilik_bengkel');
        $this->db->where('id_pemilik_bengkel', $id);
        return $this->db->get()->row();
    }

    public function getAllBengkel()
    {
        $this->db->select('*');
        $this->db->from('pemilik_bengkel');
        $this->db->order_by('id_pemilik_bengkel', 'desc');
        $this->db->get();
        return $this->db->result();
    }

    public function addData($data)
    {
        $this->db->insert('pemilik_bengkel', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('pemilik_bengkel ap', array('ap.id_pemilik_bengkel' => $id))->result();
    }

    function update($id, $data)
    {
        $this->db->where('id_pemilik_bengkel', $id);
        $this->db->update('pemilik_bengkel', $data);
        return $this->db->affected_rows();
    }

    function delete($id)
    {
        $this->db->where('id_pemilik_bengkel', $id);
        $this->db->delete('pemilik_bengkel');
    }
}

/* End of file Bengkel_model.php */

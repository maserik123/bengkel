<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bengkel_model extends CI_Model
{

    function getDatatableBengkel()
    {
        $this->datatables->select('b.id_bengkel, b.nama_bengkel, b.alamat, b.no_hp, pb.nama_pemilik, jb.judul, b.layanan, b.jadwal_buka, b.jadwal_tutup, b.latitude, b.longitude, b.longitude');
        $this->datatables->from('bengkel b');
        $this->datatables->join('jenis_bengkel jb', 'jb.id_jenis_bengkel = b.id_jenis_bengkel', 'left');
        $this->datatables->join('pemilik_bengkel pb', 'pb.id_pemilik_bengkel = b.id_pemilik_bengkel', 'left');
        return $this->datatables->generate();
    }

    function getDataBengkelByIdPemilik($id_user)
    {
        $this->datatables->select('b.id_bengkel, b.nama_bengkel, b.alamat, b.no_hp, pb.nama_pemilik, jb.judul, b.layanan, b.jadwal_buka, b.jadwal_tutup, b.latitude, b.longitude, b.longitude');
        $this->datatables->from('bengkel b');
        $this->datatables->join('jenis_bengkel jb', 'jb.id_jenis_bengkel = b.id_jenis_bengkel', 'left');
        $this->datatables->join('pemilik_bengkel pb', 'pb.id_pemilik_bengkel = b.id_pemilik_bengkel', 'left');
        $this->datatables->where('pb.id_users', $id_user);
        return $this->datatables->generate();
    }

    function getById($id)
    {
        $this->db->select('*');
        $this->db->from('bengkel');
        $this->db->where('id_bengkel', $id);
        return $this->db->get()->row();
    }

    public function getAllBengkel()
    {
        $this->db->select('*');
        $this->db->from('bengkel b');
        $this->db->join('jenis_bengkel jb', 'jb.id_jenis_bengkel = b.id_jenis_bengkel', 'left');
        $this->db->join('pemilik_bengkel pb', 'pb.id_pemilik_bengkel = b.id_pemilik_bengkel', 'left');
        $this->db->order_by('id_bengkel', 'desc');
        return $this->db->get()->result_array();
    }

    public function addData($data)
    {
        $this->db->insert('bengkel', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('bengkel ap', array('ap.id_bengkel' => $id))->result();
    }

    function update($id, $data)
    {
        $this->db->where('id_bengkel', $id);
        $this->db->update('bengkel', $data);
        return $this->db->affected_rows();
    }

    function delete($id)
    {
        $this->db->where('id_bengkel', $id);
        $this->db->delete('bengkel');
    }
}

/* End of file Bengkel_model.php */

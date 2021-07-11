<?php defined('BASEPATH') or exit('No direct script access allowed');

class B_notif_model extends CI_model
{

    //====method mengambil seluruh data=========
    public function get_all_notif()
    {
        $id = $this->session->userdata('id');
        $query = $this->db->select("*")
            ->from('b_notif')
            ->order_by('notif_date_time', 'DESC')
            ->where('notif_status', 0)
            ->where('user_id', $id)
            ->get();
        return $query->result();
    }

    function count_new_notif()
    {
        $id = $this->session->userdata('id');
        $this->db->select('count(notif_id) as tot_new');
        $this->db->from('b_notif');
        $this->db->where('notif_status', 0);
        $this->db->where('user_id', $id);
        return $this->db->get()->result();
    }

    function get_data_notif()
    {
        # code...
        $id = $this->session->userdata('id');
        $this->datatables->select('notif_id,notif_isi,notif_date_time,notif_status,notif_fitur');
        $this->datatables->from('b_notif');
        $this->datatables->where('user_id', $id);
        return $this->datatables->generate();
    }

    function get_data_notif_manage()
    {
        # code...
        $this->datatables->select('notif_id,notif_isi,notif_date_time,notif_status,notif_fitur');
        $this->datatables->from('b_notif');
        return $this->datatables->generate();
    }

    function get_notif_by_id($id)
    {
        return $this->db->get_where('b_notif pd', array('pd.notif_id' => $id))->result();
    }

    function insert_notif($data)
    {
        $this->db->insert('b_notif', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    function change_read($id, $data)
    {
        $this->db->where('notif_id', $id);
        $this->db->update('b_notif', $data);
        return $this->db->affected_rows();
    }

    function delete_by_id($id)
    {
        $this->db->where('notif_id', $id);
        $this->db->delete('b_notif');
    }
}

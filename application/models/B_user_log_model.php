<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class B_user_log_model extends CI_Model
{

    function countAllActivity()
    {
        $this->db->select('count(*) as total');
        $this->db->from('b_user_log');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function getactivNow()
    {
        # code...
        $this->db->select('
        log_id,
        jenis_aksi,
        keterangan,
        tgl');
        $this->db->from('b_user_log');
        $this->db->where('tgl', date('Y-m-d H:i:s'));
        return $this->db->get()->result();
    }

    function delete_by_id($id)
    {
        $this->db->where('log_id', $id);
        $this->db->delete('b_user_log');
    }

    public function count_notification()
    {
        # code...
        $this->db->select('
        count(log_id) as jumlah');
        $this->db->from('b_user_log');
        // $this->db->where('tgl', date('Y-m-d H:i:s'));
        return $this->db->get()->row();
    }

    function getTop20Activity()
    {
        $this->db->select('log_id, jenis_aksi, keterangan, HOUR(tgl) as h, MINUTE(tgl) as m, SECOND(tgl) as s');
        $this->db->from('b_user_log');
        $this->db->order_by('log_id', 'desc');
        $this->db->limit(5);
        return $this->db->get()->result();
    }

    function addLog($data)
    {
        $this->db->insert('b_user_log', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function addLog_transact($data)
    {
        $this->db->insert('b_user_log', $data);
    }

    function getAllLog()
    {
        $this->datatables->select('
        log_id,
        jenis_aksi,
        keterangan,
        tgl');
        $this->datatables->from('b_user_log');

        return $this->datatables->generate();
    }

    function getAllLogDelete()
    {
        $this->datatables->select('
        log_id,
        jenis_aksi,
        keterangan,
        tgl, tgl');
        $this->datatables->from('b_user_log');

        return $this->datatables->generate();
    }

    function countUserLogbyJenisAksi($var1)
    {
        $this->db->select('jenis_aksi, count(jenis_aksi) as jlh_jenis');
        $this->db->from('b_user_log');
        $this->db->group_by($var1);
        return $this->db->get()->result_array();
    }

    function countUserLogbyName()
    {
        $this->db->select('ul.jenis_aksi, count(ul.user_id) as jlh_user, u.first_name as nama');
        $this->db->from('b_user_log ul');
        $this->db->join('users u', 'u.id = ul.user_id', 'left');
        $this->db->group_by('u.first_name');
        $this->db->order_by('tgl', 'desc');
        return $this->db->get()->result_array();
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Model
{

    function __construct()
    {
        $this->tableName = 'users';
        $this->primaryKey = 'id';
    }

    public function getAllData()
    {
        # code...
        $this->db->select('*');
        $this->db->from('users');
        $this->db->order_by('id');
        return $this->db->get()->result();
    }

    function get_all_data_ajax()
    {
        $this->datatables->select('id, first_name, last_name, username, address,phone_number,role,id_unit,address');
        $this->datatables->from('users');
        return $this->datatables->generate();
    }

    public function get_email_user()
    {
        # code...
        $this->db->select('email');
        $this->db->from('users');
        return $this->db->get()->result();
    }

    function change_on_off($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('users', $data);
        return $this->db->affected_rows();
    }

    function get_all_data_ajax_home()
    {
        $this->datatables->select('id, first_name, last_name,role, time_online,online_status');
        $this->datatables->from('users');
        $this->datatables->where('online_status = "online"');
        return $this->datatables->generate();
    }

    public function getuserById($id)
    {
        return $this->db->get_where('users ap', array('ap.id' => $id))->result();
    }

    public function get_by_id($id)
    {
        $this->db->select("*, md5(password) as password");
        $this->db->from("users");
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    function countAllUsers()
    {
        $this->db->select('count(*) as total');
        $this->db->from('users');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    function countUserAktif()
    {
        $this->db->select('count(*) as total');
        $this->db->from('users');
        $this->db->where('online_status = "online"');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    function countUsertdkAktif()
    {
        $this->db->select('count(*) as total');
        $this->db->from('users');
        $this->db->where('online_status = "offline"');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    function countUserBlocked()
    {
        $this->db->select('count(*) as total');
        $this->db->from('users');
        $this->db->where('block_status = 1');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    function get_all_data()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result();
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('users', $data);
        return $this->db->affected_rows();
    }

    function cek_user_pwd($username, $password)
    {
        # code...
        $this->db->where("username like binary", $username);
        $this->db->where("password like binary", $password);
        return $this->db->get("users");
    }

    public function cek_auth($email)
    {
        # code...
        $this->db->where('email', $email);
        return $this->db->get('users');
    }

    public function checkUser($data = array())
    {
        $this->db->select($this->primaryKey);
        $this->db->from($this->tableName);

        $con = array(
            'email'       => $data['email'],
        );
        $this->db->where($con);
        $query = $this->db->get();
        $check = $query->num_rows();

        if ($check != 0) {
            // Get prev user data
            $result = $query->row_array();

            $gpInfo = $this->google->getUserInfo();

            // Update user data
            $data['modified']         = date("Y-m-d H:i:s");
            $data['oauth_provider']   = 'google';
            $data['oauth_uid']        = $gpInfo['id'];
            $data['gender']           = !empty($gpInfo['gender']) ? $gpInfo['gender'] : '';
            $data['locale']           = !empty($gpInfo['locale']) ? $gpInfo['locale'] : '';
            $data['link']             = !empty($gpInfo['link']) ? $gpInfo['link'] : '';
            // $data['picture']          = !empty($gpInfo['picture']) ? $gpInfo['picture'] : '';

            $update = $this->db->update($this->tableName, $data, array('id' => $result['id']));

            // user id
            $userID = $result['id'];
        }
        // else {
        //     // Insert user data
        //     $data['created'] = date("Y-m-d H:i:s");
        //     $data['modified'] = date("Y-m-d H:i:s");
        //     $insert = $this->db->insert($this->tableName, $data);

        //     // user id
        //     $userID = $this->db->insert_id();
        // }

        // Return user id
        return $userID ? $userID : false;
    }

    function register()
    {
        # code...
        // Insert user data
        $data['created'] = date("Y-m-d H:i:s");
        $data['modified'] = date("Y-m-d H:i:s");
        $insert = $this->db->insert($this->tableName, $data);

        // user id
        $userID = $this->db->insert_id();
        // Return user id
        return $userID ? $userID : false;
    }

    public function addData($data)
    {
        # code...
        $this->db->insert('users', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users');
    }
}

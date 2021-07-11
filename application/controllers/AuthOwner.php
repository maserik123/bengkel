<?php
defined('BASEPATH') or exit('No direct script access allowed');

class authowner extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // Load google oauth library
        // $this->load->library('google');
        $this->load->helper('notif&log');
        $this->load->helper('my_function');
        // Load user model
        $this->load->model(array('user', 'B_notif_model', 'B_user_log_model'));
    }

    public function index()
    {
        // Redirect to profile page if the user already logged in
        if ($this->session->userdata('loggedIn') == true) {
            redirect('Owner');
        }
        //Melakukan validasi untuk username dan password
        $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|min_length[6]', array('min_length' => 'Karakter {field} terlalu pendek !', 'required' => '{field} wajib diisi !'));
        $this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean|min_length[6]', array('min_length' => 'Karakter {field} terlalu pendek !', 'required' => '{field} wajib diisi !'));
        $this->form_validation->set_error_delimiters('<span class="text-left" style="color:red;"> * ', '</span>');

        //Jika validasi input username dan password bernilai false
        if ($this->form_validation->run() == FALSE) {
        } else {
            $username = htmlspecialchars($this->input->post('username'));
            $password = htmlspecialchars($this->input->post('password'));

            $user = $username;
            $pass = md5($password);
            $cek = $this->user->cek_user_pwd($user, $pass);
            if ($cek->num_rows() != 0) {
                foreach ($cek->result() as $qad) {
                    $sess_data['id']              = $qad->id;
                    $sess_data['first_name']      = $qad->first_name;
                    $sess_data['last_name']       = $qad->last_name;
                    $sess_data['username']        = $qad->username;
                    $sess_data['email']           = $qad->email;
                    $sess_data['picture']         = $qad->picture;
                    $sess_data['role']            = $qad->role;
                    $sess_data['online_status']   = $qad->online_status;
                    $sess_data['block_status']    = $qad->block_status;
                    $sess_data['id_unit']         = $qad->id_unit;
                    $this->session->set_userdata($sess_data);
                }
                if (($sess_data['block_status'] != 1) && ($sess_data['role'] == 'owner')) {
                    $this->session->set_userdata('loggedIn', TRUE);
                    $this->session->set_flashdata('success', 'Selamat datang ' . $sess_data['first_name'] . ' ! <br> Anda telah login ke KBP Manajemen Dashboard');
                    $this->user->change_on_off($sess_data['id'], online_status('online'));
                    // $this->B_notif_model->insert_notif(notifLog('Login', 'Selamat Datang ' . $sess_data['first_name'] . ' ' . $sess_data['last_name'] . ' !', 'Login', $sess_data['id']));
                    $this->B_user_log_model->addLog(userLog('Login System',  $sess_data['first_name'] . ' ' . $sess_data['last_name'] . ' Login ke System', $sess_data['id']));
                    redirect(base_url('Owner'));
                } else {
                    $this->session->set_flashdata('result_login', 'This user has blocked, you can not login ! ');
                    redirect('AuthOwner/');
                }
            } else {
                $this->session->set_flashdata('result_login', 'Username atau Password salah !');
                redirect('AuthOwner/');
            }
        }


        // ini untuk konfirmasi pengguna apakah ada atau tidak
        $email = $this->user->get_email_user();
        foreach ($email as $row) {
            $var[] = $row->email;
        }
        // Google authentication url
        // $data['loginURL'] = $this->google->loginURL();
        $data['jenis_user_log'] = $this->B_user_log_model->countUserLogbyJenisAksi('jenis_aksi');
        // Load google login view

        $this->load->view('bengkel_owner/auth/index', $data);
    }

    public function registrasi($param = '', $id = '')
    {
        $view['title'] = 'Registrasi';
        if ($param == 'addData') {
            $this->form_validation->set_rules("first_name", "Nama Awalan", "trim|required", array('required' => '{field} Wajib diisi !'));
            $this->form_validation->set_rules("last_name", "Nama Akhiran", "trim|required", array('required' => '{field} Wajib diisi !'));
            $this->form_validation->set_rules("username", "Username", "trim|required", array('required' => '{field} Wajib diisi !'));
            $this->form_validation->set_rules("password", "Password", "trim|required", array('required' => '{field} Wajib diisi !'));
            $this->form_validation->set_rules("confirm", "Password Confirmation", "trim|required|matches[password]", array('required' => '{field} Wajib diisi !', 'matches' => 'Password tidak cocok !'));
            $this->form_validation->set_rules("email", "Email", "trim|required|valid_email", array('required' => '{field} Wajib diisi !'));
            $this->form_validation->set_rules("phone_number", "Nomor Handphone", "trim|required", array('required' => '{field} Wajib diisi !'));
            $this->form_validation->set_rules("address", "Tingkat Jabatan", "trim|required", array('required' => '{field} Wajib diisi !'));
            // $this->form_validation->set_rules("gender", "Tingkat Jabatan", "trim|required", array('required' => '{field} Wajib diisi !'));

            $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
            if ($this->form_validation->run() == FALSE) {
                $result = array('status' => 'error', 'msg' => 'Data yang anda isi Belum Benar!');
                foreach ($_POST as $key => $value) {
                    $result['messages'][$key] = form_error($key);
                }
            } else {
                $data['first_name']   = htmlspecialchars($this->input->post('first_name'));
                $data['last_name']    = htmlspecialchars($this->input->post('last_name'));
                $data['username']     = htmlspecialchars($this->input->post('username'));
                $data['password']     = htmlspecialchars(md5($this->input->post('password')));
                $data['email']        = htmlspecialchars($this->input->post('email'));
                $data['phone_number'] = htmlspecialchars($this->input->post('phone_number'));
                $data['address']      = htmlspecialchars($this->input->post('address'));
                // $data['gender']       = htmlspecialchars($this->input->post('gender'));
                $data['role']         = 'owner';
                $data['created']      = date('Y-m-d H:i:s');
                $result['messages']     = '';
                $checkUser = $this->User->cekByEmailUserNamePhone($this->input->post('email'), $this->input->post('phone_number'));
                if ($checkUser) {
                    $result         = array('status' => 'error', 'msg' => 'Gagal ! <br> <small>Pengguna sudah terdaftar !</small>');
                } else {
                    $result         = array('status' => 'success', 'msg' => 'Berhasil mendaftar ! <br> <small>Silahkan login untuk melanjutkan !</small>');
                    $this->User->addData($data);
                }
            }
            $csrf = array(
                'token' => $this->security->get_csrf_hash()
            );
            echo json_encode(array('result' => $result, 'csrf' => $csrf));
            die;
        }
        $this->load->view('bengkel_owner/auth/registrasi', $view);
    }

    public function logout()
    {
        // Remove token and user data from the session
        $this->session->unset_userdata('loggedIn');
        $this->session->unset_userdata('userData');
        // Destroy entire session data
        $this->session->sess_destroy();
        $user_id = $this->session->userdata('id');
        // $this->B_user_log_model->addLog(userLog('Logout System',  $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') . ' Logout dari System', $this->session->userdata('id')));
        $this->user->change_on_off($user_id, online_status('offline'));
        // Redirect to login page
        echo json_encode(array("status" => 'success', 'msg' => 'Thanks for using this system !'));
    }
    public function force_logout()
    {

        // Remove token and user data from the session
        $this->session->unset_userdata('loggedIn');
        $this->session->unset_userdata('userData');
        // Destroy entire session data
        $this->session->sess_destroy();

        // Redirect to login page
        redirect('AuthOwner/');
    }
}

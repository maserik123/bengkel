<?php
defined('BASEPATH') or exit('No direct script access allowed');

class auth extends CI_Controller
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
            redirect('Administrator');
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
                if ($sess_data['block_status'] != 1) {
                    $this->session->set_userdata('loggedIn', TRUE);
                    $this->session->set_flashdata('success', 'Selamat datang ' . $sess_data['first_name'] . ' ! <br> Anda telah login ke KBP Manajemen Dashboard');
                    $this->user->change_on_off($sess_data['id'], online_status('online'));
                    // $this->B_notif_model->insert_notif(notifLog('Login', 'Selamat Datang ' . $sess_data['first_name'] . ' ' . $sess_data['last_name'] . ' !', 'Login', $sess_data['id']));
                    $this->B_user_log_model->addLog(userLog('Login System',  $sess_data['first_name'] . ' ' . $sess_data['last_name'] . ' Login ke System', $sess_data['id']));
                    redirect(base_url('Administrator'));
                } else {
                    $this->session->set_flashdata('result_login', 'This user has blocked, you can not login ! ');
                    redirect('Auth/');
                }
            } else {
                $this->session->set_flashdata('result_login', 'Username atau Password salah !');
                redirect('Auth/');
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

        $this->load->view('administrator/auth/index', $data);
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
        redirect('auth/');
    }
}

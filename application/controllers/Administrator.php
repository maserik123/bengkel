<?php
defined('BASEPATH') or exit('No direct script access allowed');

class administrator extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('format', 'button', 'encrypt', 'datetime', 'upload', 'currency_format', 'my_function'));

        $this->load->model(['Bengkel_model', 'JenisBengkel_model', 'PemilikBengkel_model', 'User']);
    }


    public function index()
    {
        $temp = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $view['title']    = 'Beranda';
            $view['pageName'] = 'beranda';
            $this->load->view('administrator/index', $view);
        }
    }

    function bengkelTerdaftar($param = '', $id = '')
    {
        $temp = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $view['title']    = 'Bengkel terdaftar';
            $view['pageName'] = 'bengkelTerdaftar';


            if ($param == 'getAllData') {
                $dt    = $this->Bengkel_model->getDatatableBengkel();
                $start = $this->input->post('start');
                $data  = array();
                foreach ($dt['data'] as $row) {
                    $id   = ($row->id_bengkel);
                    $th1  = '<div style="font-size:12px;">' . ++$start . '</div>';
                    $th2  = '<div style="font-size:12px;">' . $row->nama_bengkel . '</div>';
                    $th3  = '<div style="font-size:12px;">' . $row->alamat . '</div>';
                    $th4  = '<div style="font-size:12px;">' . $row->no_hp . '</div>';
                    $th5  = '<div style="font-size:12px;">' . $row->nama_pemilik . '</div>';
                    $th6  = '<div style="font-size:12px;">' . $row->judul . '</div>';
                    $th7  = '<div style="font-size:12px;">' . $row->layanan . '</div>';
                    $th8  = '<div style="font-size:12px;">' . $row->jadwal_buka . '</div>';
                    $th9  = '<div style="font-size:12px;">' . $row->jadwal_tutup . '</div>';
                    $th10  = '<div style="font-size:12px;">' . $row->latitude . '</div>';
                    $th11 = '<div style="font-size:12px;">' . $row->longitude . '</div>';
                    $th12 = get_btn_group1('ubah("' . $id . '")', 'hapus("' . $id . '")');
                    $data[]     = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6, $th7, $th8, $th9, $th10, $th11, $th12));
                }
                $dt['data'] = $data;
                echo json_encode($dt);
                die;
            } else if ($param == 'addData') {
                $this->form_validation->set_rules("nama_bengkel", "Nama Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("alamat", "Alamat Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("no_hp", "No Hp", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("id_pemilik_bengkel", "Pemilik Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("id_jenis_bengkel", "Jenis Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("layanan", "Layanan Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("jadwal_bengkel", "Jadwal Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("latitude", "Latitude", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("longitude", "Longitude", "trim|required", array('required' => '{field} Wajib diisi !'));

                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi Belum Benar!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['nama_bengkel']       = htmlspecialchars($this->input->post('nama_bengkel'));
                    $data['alamat']             = htmlspecialchars($this->input->post('alamat'));
                    $data['no_hp']              = htmlspecialchars($this->input->post('no_hp'));
                    $data['id_pemilik_bengkel'] = htmlspecialchars($this->input->post('id_pemilik_bengkel'));
                    $data['id_jenis_bengkel']   = htmlspecialchars($this->input->post('id_jenis_bengkel'));
                    $data['layanan']            = htmlspecialchars($this->input->post('layanan'));
                    $data['jadwal_bengkel']     = htmlspecialchars($this->input->post('jadwal_bengkel'));
                    $data['latitude']           = htmlspecialchars($this->input->post('latitude'));
                    $data['longitude']          = htmlspecialchars($this->input->post('longitude'));

                    $result['messages'] = '';
                    $result     = array('status' => 'success', 'msg' => 'Data berhasil dikirimkan');
                    $this->Bengkel_model->addData($data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'getById') {
                $data = $this->Bengkel_model->getById($id);
                echo json_encode(array('data' => $data));
                die;
            } else if ($param == 'update') {
                $this->form_validation->set_rules("nama_bengkel", "Nama Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("alamat", "Alamat Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("no_hp", "No Hp", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("id_pemilik_bengkel", "Pemilik Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("id_jenis_bengkel", "Jenis Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("layanan", "Layanan Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("jadwal_bengkel", "Jadwal Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("latitude", "Latitude", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("longitude", "Longitude", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $id_js['id_bengkel']                 = ($this->input->post('id_bengkel'));
                    $data['nama_bengkel']       = htmlspecialchars($this->input->post('nama_bengkel'));
                    $data['alamat']             = htmlspecialchars($this->input->post('alamat'));
                    $data['no_hp']              = htmlspecialchars($this->input->post('no_hp'));
                    $data['id_pemilik_bengkel'] = htmlspecialchars($this->input->post('id_pemilik_bengkel'));
                    $data['id_jenis_bengkel']   = htmlspecialchars($this->input->post('id_jenis_bengkel'));
                    $data['layanan']            = htmlspecialchars($this->input->post('layanan'));
                    $data['jadwal_bengkel']     = htmlspecialchars($this->input->post('jadwal_bengkel'));
                    $data['latitude']           = htmlspecialchars($this->input->post('latitude'));
                    $data['longitude']          = htmlspecialchars($this->input->post('longitude'));
                    $result['messages']           = '';
                    $result               = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
                    $this->Bengkel_model->update($id_js['id_bengkel'], $data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'delete') {
                $this->Bengkel_model->delete($id);
                $result = array('status' => 'success', 'msg' => 'Data berhasil dihapus !');
                echo json_encode(array('result' => $result));
                die;
            }

            $this->load->view('administrator/index', $view);
        }
    }

    function pemilikBengkel($param = '', $id = '')
    {
        $temp = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {

            $view['title']    = 'Bengkel terdaftar';
            $view['pageName'] = 'pemilikBengkel';
            $view['getAllDataUser'] = $this->User->getAllData();

            if ($param == 'getAllData') {
                $dt    = $this->PemilikBengkel_model->getDataPemilikBengkel();
                $start = $this->input->post('start');
                $data  = array();
                foreach ($dt['data'] as $row) {
                    $id   = ($row->id_pemilik_bengkel);
                    $th1  = '<div style="font-size:12px;">' . ++$start . '</div>';
                    $th2  = '<div style="font-size:12px;">' . $row->nama_pemilik . '</div>';
                    $th3  = '<div style="font-size:12px;">' . $row->alamat . '</div>';
                    $th4  = '<div style="font-size:12px;">' . $row->no_hp . '</div>';
                    $th5  = '<div style="font-size:12px;">' . $row->email . '</div>';
                    $th6 = get_btn_group1('ubah("' . $id . '")', 'hapus("' . $id . '")');
                    $data[]     = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6));
                }
                $dt['data'] = $data;
                echo json_encode($dt);
                die;
            } else if ($param == 'addData') {
                $this->form_validation->set_rules("nama_pemilik", "Nama Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("alamat", "Alamat Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("no_hp", "No Hp", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("email", "Email Pemilik Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("id_users", "Nama Pemilik", "trim|required", array('required' => '{field} Wajib diisi !'));

                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi Belum Benar!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['nama_pemilik']       = htmlspecialchars($this->input->post('nama_pemilik'));
                    $data['alamat']             = htmlspecialchars($this->input->post('alamat'));
                    $data['no_hp']              = htmlspecialchars($this->input->post('no_hp'));
                    $data['email'] = htmlspecialchars($this->input->post('email'));
                    $data['id_users'] = htmlspecialchars($this->input->post('id_users'));

                    $data['create_date'] = date('Y-m-d');


                    $result['messages'] = '';
                    $result     = array('status' => 'success', 'msg' => 'Data berhasil dikirimkan');
                    $this->PemilikBengkel_model->addData($data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'getById') {
                $data = $this->PemilikBengkel_model->getById($id);
                echo json_encode(array('data' => $data));
                die;
            } else if ($param == 'update') {
                $this->form_validation->set_rules("nama_pemilik", "Nama Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("alamat", "Alamat Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("no_hp", "No Hp", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("email", "Email Pemilik Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $id_js['id_pemilik_bengkel']                 = ($this->input->post('id_pemilik_bengkel'));
                    $data['nama_pemilik']       = htmlspecialchars($this->input->post('nama_pemilik'));
                    $data['alamat']             = htmlspecialchars($this->input->post('alamat'));
                    $data['no_hp']              = htmlspecialchars($this->input->post('no_hp'));
                    $data['email'] = htmlspecialchars($this->input->post('email'));
                    $result['messages']           = '';
                    $result               = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
                    $this->PemilikBengkel_model->update($id_js['id_pemilik_bengkel'], $data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'delete') {
                $this->PemilikBengkel_model->delete($id);
                $result = array('status' => 'success', 'msg' => 'Data berhasil dihapus !');
                echo json_encode(array('result' => $result));
                die;
            }

            $this->load->view('administrator/index', $view);
        }
    }

    function jenisBengkel($param = '', $id = '')
    {

        $temp = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {

            $view['title']    = 'Bengkel terdaftar';
            $view['pageName'] = 'jenisBengkel';

            if ($param == 'getAllData') {
                $dt    = $this->JenisBengkel_model->getDataJenisBengkel();
                $start = $this->input->post('start');
                $data  = array();
                foreach ($dt['data'] as $row) {
                    $id   = ($row->id_jenis_bengkel);
                    $th1  = '<div style="font-size:12px;">' . ++$start . '</div>';
                    $th2  = '<div style="font-size:12px;">' . $row->judul . '</div>';
                    $th3  = '<div style="font-size:12px;">' . $row->keterangan . '</div>';
                    $th4 = get_btn_group1('ubah("' . $id . '")', 'hapus("' . $id . '")');
                    $data[]     = gathered_data(array($th1, $th2, $th3, $th4));
                }
                $dt['data'] = $data;
                echo json_encode($dt);
                die;
            } else if ($param == 'addData') {
                $this->form_validation->set_rules("judul", "Judul Jenis Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("keterangan", "Keterangan Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi Belum Benar!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['judul']       = htmlspecialchars($this->input->post('judul'));
                    $data['keterangan']             = htmlspecialchars($this->input->post('keterangan'));
                    $result['messages'] = '';
                    $result     = array('status' => 'success', 'msg' => 'Data berhasil dikirimkan');
                    $this->JenisBengkel_model->addData($data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'getById') {
                $data = $this->JenisBengkel_model->getById($id);
                echo json_encode(array('data' => $data));
                die;
            } else if ($param == 'update') {
                $this->form_validation->set_rules("judul", "Judul Jenis Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("keterangan", "Keterangan Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $id_js['id_jenis_bengkel']                 = ($this->input->post('id_jenis_bengkel'));
                    $data['judul']       = htmlspecialchars($this->input->post('judul'));
                    $data['keterangan']             = htmlspecialchars($this->input->post('keterangan'));
                    $result['messages']           = '';
                    $result               = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
                    $this->JenisBengkel_model->update($id_js['id_jenis_bengkel'], $data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'delete') {
                $this->JenisBengkel_model->delete($id);
                $result = array('status' => 'success', 'msg' => 'Data berhasil dihapus !');
                echo json_encode(array('result' => $result));
                die;
            }
            $this->load->view('administrator/index', $view);
        }
    }
}

/* End of file administrator.php */

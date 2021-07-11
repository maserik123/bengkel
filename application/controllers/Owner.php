<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Owner extends CI_Controller
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
            redirect('/AuthOwner/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $view['title']    = 'Beranda';
            $view['pageName'] = 'beranda';
            $this->load->view('bengkel_owner/index', $view);
        }
    }

    function dataBengkel($param = '', $id = '')
    {
        $temp = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/AuthOwner/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $view['title']    = 'Data Bengkel';
            $view['pageName'] = 'dataBengkel';
            $view['getAllJenisBengkel'] = $this->JenisBengkel_model->getAllJenisBengkel();

            if ($param == 'getAllData') {
                $dt    = $this->Bengkel_model->getDataBengkelByIdPemilik($this->session->userdata('id'));
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
                // $this->form_validation->set_rules("id_pemilik_bengkel", "Pemilik Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("id_jenis_bengkel", "Jenis Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("layanan", "Layanan Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("jadwal_buka", "Jadwal Buka", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("jadwal_tutup", "Jadwal Tutup", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("latitude", "Latitude", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("longitude", "Longitude", "trim|required", array('required' => '{field} Wajib diisi !'));

                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi Belum Benar!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $getIdPemilikBengkel = $this->PemilikBengkel_model->getPemilikBengkelByIdUser($this->session->userdata('id'));
                    $data['nama_bengkel']       = htmlspecialchars($this->input->post('nama_bengkel'));
                    $data['alamat']             = htmlspecialchars($this->input->post('alamat'));
                    $data['no_hp']              = htmlspecialchars($this->input->post('no_hp'));
                    $data['id_pemilik_bengkel'] = $getIdPemilikBengkel[0]->id_pemilik_bengkel;
                    $data['id_jenis_bengkel']   = htmlspecialchars($this->input->post('id_jenis_bengkel'));
                    $data['layanan']            = htmlspecialchars($this->input->post('layanan'));
                    $data['jadwal_buka']     = htmlspecialchars($this->input->post('jadwal_buka'));
                    $data['jadwal_tutup']     = htmlspecialchars($this->input->post('jadwal_tutup'));
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
                // $this->form_validation->set_rules("id_pemilik_bengkel", "Pemilik Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("id_jenis_bengkel", "Jenis Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("layanan", "Layanan Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("jadwal_buka", "Jadwal Buka", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("jadwal_tutup", "Jadwal Tutup", "trim|required", array('required' => '{field} Wajib diisi !'));

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
                    $getIdPemilikBengkel = $this->PemilikBengkel_model->getPemilikBengkelByIdUser($this->session->userdata('id'));
                    $data['nama_bengkel']       = htmlspecialchars($this->input->post('nama_bengkel'));
                    $data['alamat']             = htmlspecialchars($this->input->post('alamat'));
                    $data['no_hp']              = htmlspecialchars($this->input->post('no_hp'));
                    $data['id_pemilik_bengkel'] = $getIdPemilikBengkel[0]->id_pemilik_bengkel;
                    $data['id_jenis_bengkel']   = htmlspecialchars($this->input->post('id_jenis_bengkel'));
                    $data['layanan']            = htmlspecialchars($this->input->post('layanan'));
                    $data['jadwal_buka']     = htmlspecialchars($this->input->post('jadwal_buka'));
                    $data['jadwal_tutup']     = htmlspecialchars($this->input->post('jadwal_tutup'));
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

            $this->load->view('bengkel_owner/index', $view);
        }
    }

    function dataOwner($param = '', $id = '')
    {

        $view['title']    = 'Data Owner';
        $view['pageName'] = 'dataOwner';
        $view['getPemilikBengkelByIdUser'] = $this->PemilikBengkel_model->getPemilikBengkelByIdUser($this->session->userdata('id'));

        if ($param == 'update') {
            $this->form_validation->set_rules("nama_pemilik", "Nama Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
            $this->form_validation->set_rules("alamat", "Alamat Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
            $this->form_validation->set_rules("no_hp", "No Hp", "trim|required", array('required' => '{field} Wajib diisi !'));
            $this->form_validation->set_rules("email", "Pemilik Bengkel", "trim|required", array('required' => '{field} Wajib diisi !'));
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
        }

        $this->load->view('bengkel_owner/index', $view);
    }
}

/* End of file Owner.php */

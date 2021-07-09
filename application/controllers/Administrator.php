<?php
defined('BASEPATH') or exit('No direct script access allowed');

class administrator extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('format', 'button', 'encrypt', 'datetime', 'upload', 'currency_format', 'my_function'));

        $this->load->model(['Bengkel_model', 'JenisBengkel_model']);
    }


    public function index()
    {

        $view['title'] = 'Beranda';
        $view['pageName'] = 'beranda';
        $this->load->view('administrator/index', $view);
    }

    function bengkelTerdaftar($param = '', $id = '')
    {
        $view['title'] = 'Bengkel terdaftar';
        $view['pageName'] = 'bengkelTerdaftar';

        if ($param == 'getAllData') {
            $dt = $this->Bengkel_model->getDatatableBengkel();
            $start = $this->input->post('start');
            $data = array();
            foreach ($dt['data'] as $row) {
                $id = ($row->id_bengkel);
                $th1 = ++$start;
                $th2 = $row->nama_bengkel;
                $th3 = $row->alamat;
                $th4 = $row->no_hp;
                $th5 = $row->nama_pemilik;
                $th6 = $row->judul;
                $th7 = $row->layanan;
                $th8 = $row->jadwal_bengkel;
                $th9 = $row->latitude;
                $th10 = $row->longitude;
                $th11 = get_btn_group1('ubah("' . $id . '")', 'hapus("' . $id . '")');
                $data[] = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6, $th7, $th8, $th9, $th10, $th11));
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
                $data['nama_bengkel']        = htmlspecialchars($this->input->post('nama_bengkel'));
                $data['alamat']  = htmlspecialchars($this->input->post('alamat'));
                $data['no_hp']  = htmlspecialchars($this->input->post('no_hp'));
                $data['id_pemilik_bengkel'] = htmlspecialchars($this->input->post('id_pemilik_bengkel'));
                $data['id_jenis_bengkel'] = htmlspecialchars($this->input->post('id_jenis_bengkel'));
                $data['layanan'] = htmlspecialchars($this->input->post('layanan'));
                $data['jadwal_bengkel'] = htmlspecialchars($this->input->post('jadwal_bengkel'));
                $data['latitude'] = htmlspecialchars($this->input->post('latitude'));
                $data['longitude'] = htmlspecialchars($this->input->post('longitude'));

                $result['messages'] = '';
                $result             = array('status' => 'success', 'msg' => 'Data berhasil dikirimkan');
                $this->Bengkel_model->addData($data);
            }
            $csrf = array(
                'token' => $this->security->get_csrf_hash()
            );
            echo json_encode(array('result' => $result, 'csrf' => $csrf));
            die;
        } else if ($param == 'getById') {
            $data = $this->Barang_model->getById($id);
            echo json_encode(array('data' => $data));
            die;
        } else if ($param == 'update') {
            $this->form_validation->set_rules("id", "Kode Barang", "trim|required", array('required' => '{field} Wajib diisi !'));
            $this->form_validation->set_rules("brg_nama", "Nama Barang", "trim|required", array('required' => '{field} Wajib diisi !'));
            $this->form_validation->set_rules("brg_stok", "Stok Barang", "trim|required", array('required' => '{field} Wajib diisi !'));
            // $this->form_validation->set_rules("brg_harga", "Harga", "trim|required", array('required' => '{field} Wajib diisi !'));
            $this->form_validation->set_rules("satuan", "Satuan", "trim|required", array('required' => '{field} Wajib diisi !'));
            $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
            if ($this->form_validation->run() == FALSE) {
                $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                foreach ($_POST as $key => $value) {
                    $result['messages'][$key] = form_error($key);
                }
            } else {
                $id_js['id']            = ($this->input->post('id'));
                $data['brg_nama']       = htmlspecialchars($this->input->post('brg_nama'));
                $data['brg_stok']       = htmlspecialchars($this->input->post('brg_stok'));
                // $data['brg_harga']      = htmlspecialchars($this->input->post('brg_harga'));
                $data['satuan']      = htmlspecialchars($this->input->post('satuan'));
                $result['messages']     = '';
                $result = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
                $this->Barang_model->update($id_js['id'], $data);
            }
            $csrf = array(
                'token' => $this->security->get_csrf_hash()
            );
            echo json_encode(array('result' => $result, 'csrf' => $csrf));
            die;
        } else if ($param == 'delete') {
            $this->Barang_model->delete($id);
            $result = array('status' => 'success', 'msg' => 'Data berhasil dihapus !');
            echo json_encode(array('result' => $result));
            die;
        }

        $this->load->view('administrator/index', $view);
    }
}

/* End of file administrator.php */

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengunjung extends CI_Controller
{

    public function index()
    {
        $view['title'] = 'Halaman Beranda';
        $view['pageName'] = 'beranda';
        $this->load->view('pengunjung/index', $view);
    }


    public function find()
    {
        $view['title'] = 'Halaman Cari Bengkel';
        $view['pageName'] = 'cari';
        $this->load->view('pengunjung/index', $view);
    }
}

/* End of file pengunjung.php */

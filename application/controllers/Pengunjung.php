<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengunjung extends CI_Controller
{

    public function index()
    {
        $view['title'] = 'Halaman Beranda';
        $view['pageName'] = 'beranda';
        $this->load->view('pengunjung/index');
    }
}

/* End of file pengunjung.php */

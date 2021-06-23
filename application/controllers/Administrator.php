<?php
defined('BASEPATH') or exit('No direct script access allowed');

class administrator extends CI_Controller
{

    public function index()
    {

        $view['title'] = 'Beranda';
        $view['pageName'] = 'beranda';
        $this->load->view('administrator/index', $view);
    }
}

/* End of file administrator.php */

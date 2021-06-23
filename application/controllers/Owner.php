<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Owner extends CI_Controller
{

    public function index()
    {
        $this->load->view('bengkel_owner/index');
    }

    public function bengkel($param = '', $id = '')
    {
        # code...
    }
}

/* End of file Owner.php */

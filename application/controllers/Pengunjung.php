<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengunjung extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('format', 'button', 'encrypt'));

        $this->load->model('bengkel_model');
    }

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

    //Create geojson
    public function datageojson()
    {
        $dtbengkel = $this->bengkel_model->getAllBengkel();

        $geojson = array(
            'type'      => 'FeatureCollection',
            'features'  => array()
        );

        # Loop through rows to build feature arrays
        foreach ($dtbengkel as $row) {

            $feature = array(
                'id' => $row['id_bengkel'],
                'type' => 'Feature',
                'geometry' => array(
                    'type' => 'Point',
                    # Pass Longitude and Latitude Columns here
                    'coordinates' => array($row['longitude'], $row['latitude'])
                ),
                # Pass other attribute columns here
                'properties' => array(
                    'name' => $row['nama_bengkel'],
                    'address' => $row['alamat'],
                    'phone' => $row['no_hp'],
                    'jenis' => $row['judul'],
                    'ket_jenis' => $row['keterangan'],
                    'layanan' => $row['layanan'],
                    'jadwal_buka' => $row['jadwal_buka'],
                    'jadwal_tutup' => $row['jadwal_tutup']
                )
            );
            # Add feature arrays to feature collection array
            array_push($geojson['features'], $feature);
        }

        header('Content-type: application/json', true);
        $encode_data = json_encode($geojson, JSON_PRETTY_PRINT);
        echo $encode_data;
    }
}

/* End of file pengunjung.php */

<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

//Fungsi untuk membuat tanggal dengan format indonesia
function online_status($stat)
{
    # code...
    $status = array(
        'online_status'        => $stat,
        'time_online'          => date('Y-m-d H:i:s'),
    );
    return $status;
}

function verification_data($id_barang, $jumlah_barang, $tanggal_masuk)
{
    # code...
    $test = array(
        'id_barang'   => $id_barang,
        'jumlah_barang' => $jumlah_barang,
        'tanggal_masuk' => $tanggal_masuk,
        'status_verifikasi' => 1
    );

    return $test;
}

function tgl_indo($tgl)
{
    $tanggal    = substr($tgl, 8, 2);
    $bulan      = getBulan(substr($tgl, 5, 2));
    $tahun      = substr($tgl, 0, 4);
    return $tanggal . ' ' . $bulan . ' ' . $tahun;
}


//Fungsi untuk membuat bulan dengan format Indonesia
function getBulan($bln)
{
    switch ($bln) {
        case 1:
            return "Januari";
            break;

        case 2:
            return "Februari";
            break;

        case 3:
            return "Maret";
            break;

        case 4:
            return "April";
            break;

        case 5:
            return "Mei";
            break;

        case 6:
            return "Juni";
            break;

        case 7:
            return "Juli";
            break;

        case 8:
            return "Agustus";
            break;

        case 9:
            return "September";
            break;

        case 10:
            return "Oktober";
            break;

        case 11:
            return "November";
            break;

        case 12:
            return "Desember";
            break;
    }
}

//Fungsi untuk melakukan input data
function inputtext($name, $table, $field, $primary_key, $selected)
{
    $ci = get_instance();
    $data = $ci->db->get($table)->result();
    foreach ($data as $t) {
        if ($selected == $t->$primary_key) {
            $txt = $t->$field;
        }
    }
    return $txt;
}

//Fungsi untuk menampilkan data dalam bentuk combobox
function combobox($name, $table, $field, $primary_key, $selected)
{
    $ci     = get_instance();
    $cmb    = "<select name='$name' class='form-control'>";
    $data   = $ci->db->get($table)->result();
    $cmb    .= "<option value=''>-- PILIH --</option>";

    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->$primary_key . "'";
        $cmb .= $selected == $d->$primary_key ? "selected='selected'" : '';
        $cmb .= ">" . strtoupper($d->$field) . "</option>";
    }
    $cmb .= "</select>";
    return $cmb;
}

//Fungsi SEO
function seo_title($s)
{
    $c  = array(' ');
    $d  = array('- ', '/');
    $s = str_replace($d, '', $s); //Hilangkan karakter yang telah disebutkan di array $d
    $s = strtolower(str_replace($c, '-', $s)); //Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
    return $s;
}

function convert_to($array)
{
    foreach ($array as $key => $value) {
        if (empty($value)) {
            $array->$key = '-';
        } else {
            $array->$key = $value;
        }
    }
    return $array;
}
function convert_to_int($array)
{
    foreach ($array as $key => $value) {
        if (empty($value)) {
            $array->$key = '0';
        } else {
            $array->$key = $value;
        }
    }
    return $array;
}

function count_time_since($original)
{
    date_default_timezone_set('Asia/Jakarta');

    $today = time();
    $since = $today - $original;
    return $since;
}

function time_since($original)
{
    date_default_timezone_set('Asia/Jakarta');
    $chunks = array(
        array(60 * 60 * 24 * 365, 'tahun'),
        array(60 * 60 * 24 * 30, 'bulan'),
        array(60 * 60 * 24 * 7, 'minggu'),
        array(60 * 60 * 24, 'hari'),
        array(60 * 60, 'jam'),
        array(60, 'menit'),
        array(60 / 60, 'detik'),
    );

    $today = time();
    $since = $today - $original;

    if ($since > 604800) {
        $print = date("M jS", $original);
        if ($since > 31536000) {
            $print .= ", " . date("Y", $original);
        }
        return $print;
    }

    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];

        if (($count = floor($since / $seconds)) != 0)
            break;
    }

    $print = ($count == 1) ? '1 ' . $name : "$count {$name}";
    return $print;
}

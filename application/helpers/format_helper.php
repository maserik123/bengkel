<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
function echo_array($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function rupiah_format($angka)
{
    return "Rp " . number_format($angka, 0, ',', '.');
}

function commaToDot($angka)
{
    return str_replace(",", ".", $angka);
}

function remove_number_format($angka)
{
    $angka = str_replace(".", "", $angka);
    $angka = str_replace(",", "", $angka);
    return $angka;
}

function remove_rupiah_format($angka)
{
    $angka = str_replace("Rp ", "", $angka);
    $angka = str_replace(".", "", $angka);
    $angka = str_replace(",00", "", $angka);
    return $angka;
}

function word_cut($text, $num_char)
{

    return '<div title="' . $text . '">' . substr($text, 0, $num_char) . '...' . '</div>';
}

function str_cut($text, $num)
{
    return '<div title="' . $text . '">' . word_limiter($text, $num) . '</div>';
}

function cut_word($text, $num)
{
    return '<div>' . word_limiter($text, $num) . '</div>';
}

function first_char($word)
{
    $x = strip_tags(str_replace('...', '', word_cut($word, 1)));
    return $x[0];
}

function gathered_data($th = array())
{
    for ($i = 0; $i < count($th); $i++) {
        $row[]  = $th[$i];
    }
    return $row;
}

function number_format_decimal($angka)
{
    return number_format($angka, 2, '.', ',');
}

function number_format_satuan($angka)
{
    return number_format($angka, 0, ',', '.');
}

function generate_breadcrumb($link)
{
    $x = array('<a href="' . base_url() . 'administrator">Beranda</a>');
    $count = 0;
    foreach ($link as $lnk) {
        $count++;
        if ($count != count($link)) {
            //Jika sudah sama, berarti sampai pada page terakhir sehingga harus "active" 
            $lnk = '<a href="' . base_url() . 'administrator/' . strtolower(str_replace(" ", "_", $lnk)) . '">' . $lnk . '</a>';
        }

        array_push($x, $lnk);
    }

    return $x;
}

function check_empty_form($data, $exclude_list = array())
{
    $empty = 0;
    foreach ($data as $key => $val) {
        if (!$val && !in_array($key, $exclude_list))
            $empty++;
    }
    return $empty;
}

function getLatestSequence($jenis, $proyek_id = "")
{
    $CI    = get_instance();
    $digit = 3;

    //Tentukan Jenis Sequence
    if ($jenis == 'Proyek') {
        $x        = $CI->md_proyek->getLatestProyek();
        $used_seq = $x ? $x[0]->seq : 0;
    } else if ($jenis == 'Sub Proyek') {
        $x        = $CI->md_proyek->getLatestSubProyek($proyek_id);
        $used_seq = $x ? $x[0]->seq_sub : 0;
    } else if ($jenis == 'Kas' || $jenis == 'Bank') {
        $digit        = 4;
        $x            = $CI->md_transaksi_jurnal->getLatestTransaksiJurnalKasBank();
        $data['kode'] = 'CB';
        $used_seq = $x ? $x[0]->seq : 0;
    } else if ($jenis == 'Penjualan' || $jenis == 'Pembelian') {
        $digit        = 4;
        $x            = $CI->md_transaksi_jurnal->getLatestTransaksiJurnalPenjualanPembelian();
        $data['kode'] = 'PS';
        $used_seq = $x ? $x[0]->seq : 0;
    } else if ($jenis == 'Jurnal Umum') {
        $digit        = 4;
        $x            = $CI->md_transaksi_jurnal->getLatestTransaksiJurnalByJenis($jenis);
        $data['kode'] = 'JE';
        $used_seq = $x ? $x[0]->seq : 0;
    } else if ($jenis == 'Jurnal Penyesuaian') {
        $digit        = 4;
        $x            = $CI->md_transaksi_jurnal->getLatestTransaksiJurnalByJenis($jenis);
        $data['kode'] = 'AJ';
        $used_seq = $x ? $x[0]->seq : 0;
    } else if ($jenis == 'Jurnal Koreksi') {
        $digit        = 4;
        $x            = $CI->md_transaksi_jurnal->getLatestTransaksiJurnalByJenis($jenis);
        $data['kode'] = 'CJ';
        $used_seq = $x ? $x[0]->seq : 0;
    } else if ($jenis == 'Jurnal Penutup') {
        $digit        = 4;
        $x            = $CI->md_transaksi_jurnal->getLatestTransaksiJurnalByJenis($jenis);
        $data['kode'] = 'CE';
        $used_seq = $x ? $x[0]->seq : 0;
    }

    //Cek seq sebelumnya 
    if ($used_seq > 0) {
        $old_seq = $used_seq;
        $data['unformat_seq'] = $old_seq + 1;
        $length_seq = strlen($data['unformat_seq']);

        if ($length_seq == 1) {

            if ($digit == 3)
                $data['new_seq'] = '00' . $data['unformat_seq'];
            if ($digit == 4)
                $data['new_seq'] = '000' . $data['unformat_seq'];
        } else if ($length_seq == 2) {

            if ($digit == 3)
                $data['new_seq'] = '0' . $data['unformat_seq'];
            if ($digit == 4)
                $data['new_seq'] = '00' . $data['unformat_seq'];
        } else if ($length_seq == 3) {

            if ($digit == 3)
                $data['new_seq'] = $data['unformat_seq'];
            if ($digit == 4)
                $data['new_seq'] = '0' . $data['unformat_seq'];
        } else if ($length_seq == 4) {
            $data['new_seq'] = $data['unformat_seq'];
        }
    } else {
        $data['unformat_seq'] = 1;

        if ($digit == 3)
            $data['new_seq'] = '001';
        if ($digit == 4)
            $data['new_seq'] = '0001';
    }

    return $data;
}

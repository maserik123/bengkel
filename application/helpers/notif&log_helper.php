<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
function userLog($aksi = '', $ket = '', $user_id = '')
{
	$CI = get_instance();
	$log = array(
		'jenis_aksi'  => $aksi,
		'keterangan'  => $ket,
		'tgl'         => date('Y-m-d H:i:s'),
		//'pengguna_id' =>$CI->session->userdata('pengguna_id'),
		'status'      => 1,
		'ip_addr'     => $_SERVER['REMOTE_ADDR'],
		'user_id'	  => $user_id
	);
	return $log;
}

function notifLog($jenis = '', $isi = '', $fitur = '', $user_id)
{
	# code...
	$notif = array(
		'jenis_notif'		=> $jenis,
		'notif_isi'         => $isi,
		'notif_date_time'   => date('Y-m-d H:i:s'),
		'notif_status'      => 0,
		'notif_fitur'		=> $fitur,
		'user_id'			=> $user_id
	);
	return $notif;
}

function redirect_link($link)
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

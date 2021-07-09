<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

    function ImageUploadConfig($jenis=''){
        if($jenis != 'slideshow')
            $config['file_name'] = $jenis.'_'.time();

        $config['upload_path'] = './assets/file/';
        $config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
        $config['max_size']       = '5000';
        ini_set('memory_limit', '-1');
        return $config;
    }

    function ImageUploadToMedia($jenis='',$input_name='',$jenismedia='',$alt_teks=""){
        $CI = get_instance();

        if($jenismedia=='galeri') {
            $jenismedia         = 2;
            $width_pixel        = array(1024,650,320);
            $height_pixel       = array(706,448,221);
            $size_img           = array('large','medium','small');
            $data2['deskripsi'] = "Album Item";
            $data2['alt_teks']  = "Album Item";
        }
        else if($jenismedia=='album'){
            $jenismedia         = 4;
            $width_pixel        = array(1024,650,320);
            $height_pixel       = array(706,448,221);
            $size_img           = array('large','medium','small');
            $data2['deskripsi'] = "Album Thumbnail";
            $data2['alt_teks']  = $alt_teks;
        }
        else if($jenismedia=='media') {
            $jenismedia   = 1;
            $width_pixel  = array(650,320,160);
            $height_pixel = array(448,221,110);
            $size_img     = array('large','medium','small');
        }
        else if($jenismedia=='paket') {
            $jenismedia   = 7;
            $width_pixel  = array(650,320,160);
            $height_pixel = array(900,443,222);
            $size_img     = array('large','medium','small');
        }   
        else if($jenismedia=='paket_mobile') {
            $jenismedia   = 7;
            $width_pixel  = array(370,182,91);
            $height_pixel = array(650,320,160);
            $size_img     = array('large','medium','small');
        }     
        else if($jenismedia=='avatar') {
            $jenismedia         = 3;
            $width_pixel        = array(650,320,160);
            $height_pixel       = array(448,221,110);
            $size_img           = array('large','medium','small');
            $data2['deskripsi'] = "Avatar Image";
        }
        else if($jenismedia=='logo_hotel') {
            $jenismedia = 3;
            $width_pixel = array(650,320,160);
            $height_pixel = array(448,221,110);
            $size_img = array('large','medium','small');
            $data2['deskripsi'] = "Foto Hotel";
        }
        else if($jenismedia=='avatar_member') {
            $jenismedia         = 3;
            $width_pixel        = array(320,160,80);
            $height_pixel       = array(221,110,55);
            $size_img           = array('large','medium','small');
            $data2['deskripsi'] = "Member RWH Image";
            // echo "avatar_member";
            // die;
        }
        else if($jenismedia=='logo_maskapai') {
            $jenismedia         = 3;
            $width_pixel        = array(320,160,80);
            $height_pixel       = array(221,110,55);
            $size_img           = array('large','medium','small');
            $data2['deskripsi'] = "Logo Maskapai";
        }
        else if($jenismedia=='logo_merchant') {
            $jenismedia         = 3;
            $width_pixel        = array(320,160,80);
            $height_pixel       = array(221,110,55);
            $size_img           = array('large','medium','small');
            $data2['deskripsi'] = "Logo Merchant";
        }        
        else if($jenismedia=='avatar_testimoni') {
            $jenismedia         = 3;
            $width_pixel        = array(240,120,80);
            $height_pixel       = array(240,120,80);
            $size_img           = array('large','medium','small');
            $data2['deskripsi'] = "Testimoni Avatar";
        } 
        else if($jenismedia=='syarat') {
            $jenismedia         = 8;
            $width_pixel        = array(650,320,160);
            $height_pixel       = array(448,221,110);
            $size_img           = array('large','medium','small');
            $data2['deskripsi'] = "Syarat Jemaah";
        }
        else if($jenismedia=='logo_company') {
            $jenismedia         = 9;
            $width_pixel        = array(320,160,80);
            $height_pixel       = array(221,110,55);
            $size_img           = array('large','medium','small');
            $data2['deskripsi'] = "Logo Company";
        }
        $config_upload = ImageUploadConfig($jenis);
        $CI->load->library('upload',$config_upload);
        //Perlus initialize jika penggunaan library upload dilakukan  lebih dari sekali secar bersamaan
        $CI->upload->initialize($config_upload);
        if($CI->upload->do_upload($input_name)){
            $x = getimagesize($_FILES[$input_name]["tmp_name"]);
            $img_width = $x[0];
            $img_height = $x[1];

            if($CI->session->userdata('pengguna_id'))
                $data2['author']=$CI->session->userdata('pengguna_id');
            else if($CI->session->userdata('member_id'))
                $data2['author']=$CI->session->userdata('member_id');

            $data2 = array(
                'judul'         => $config_upload['file_name'],
                'tipe'          => 'gambar',
                'tgl_upload'    => date("Y-m-d H:i:s"),
                'tgl_perubahan' => date("Y-m-d H:i:s"),
                'jenismedia_id' => $jenismedia,
                'status'        => '1'
            );
            $CI->md_media->addMedia($data2);
            
            //Add Media detail and resized file
                $dt_upload = $CI->upload->data();
                // echo_array($dt_upload);
                $source_image = './assets/file/' . $dt_upload['file_name'];
                $new_image    = array(  'assets/file/large/large_'.$dt_upload['file_name'],
                                        'assets/file/medium/medium_'.$dt_upload['file_name'],
                                        'assets/file/small/small_'.$dt_upload['file_name']);

                for($i=0;$i<count($width_pixel);$i++){

                    if($img_width!=$img_height){

                        if($img_width>$img_height){

                            if($img_width <= $width_pixel[$i]){
                                $save_img_width = $img_width;
                                copy($source_image, $new_image[$i]);
                            } 
                            else {
                                //resize image
                                $config = array(
                                    'source_image'   => $source_image,
                                    'new_image'      => $new_image[$i],
                                    'maintain_ratio' => true,
                                    'width'          => $width_pixel[$i]
                                );
                                $CI->image_lib->initialize($config);
                                $CI->image_lib->resize();
                                $save_img_width = $width_pixel[$i];
                            }
                            //Add large,medium,small media_detail
                                $x = $CI->md_media->getLatestMedia();
                                $data3 = array(
                                    'media_id'     => $x[0]->media_id,
                                    'jenis_ukuran' => $size_img[$i],
                                    'media_link'   => $new_image[$i],
                                    'width'        => $save_img_width,
                                    'status'       => '1'
                                );
                                $CI->md_media_detail->addMediaDetail($data3);
                        } 
                        else if($img_width<$img_height){

                            if($img_height <= $height_pixel[$i]){
                                $save_img_height = $img_height;
                                copy($source_image, $new_image[$i]);
                            } 
                            else {
                                //resize image
                                $config = array(
                                    'source_image'   => $source_image,
                                    'new_image'      => $new_image[$i],
                                    'maintain_ratio' => true,
                                    'height'         => $height_pixel[$i]
                                );
                                $CI->image_lib->initialize($config);
                                $CI->image_lib->resize();
                                $save_img_height = $height_pixel[$i];
                            }
                            //Add large,medium,small media_detail
                                $x = $CI->md_media->getLatestMedia();
                                $data3 = array(
                                    'media_id'     => $x[0]->media_id,
                                    'jenis_ukuran' => $size_img[$i],
                                    'media_link'   => $new_image[$i],
                                    'height'       => $save_img_height,
                                    'status'       => '1'
                                );
                                $CI->md_media_detail->addMediaDetail($data3);
                        } 
                    }
                    else {

                        if($img_height > $height_pixel[$i]){
                            $config = array(
                                'source_image'   => $source_image,
                                'new_image'      => $new_image[$i],
                                'maintain_ratio' => true,
                                'height'         => $height_pixel[$i]
                            );
                            $CI->image_lib->initialize($config);
                            $CI->image_lib->resize();
                            $save_img_resol = $height_pixel[$i];
                        } 
                        else if($img_width > $width_pixel[$i]){
                            $config = array(
                                'source_image'   => $source_image,
                                'new_image'      => $new_image[$i],
                                'maintain_ratio' => true,
                                'width'          => $width_pixel[$i]
                            );
                            $CI->image_lib->initialize($config);
                            $CI->image_lib->resize();
                            $save_img_resol = $width_pixel[$i];
                        } 
                        else {
                            $save_img_resol = $img_height;
                            copy($source_image, $new_image[$i]);
                        }
                        //Add large,medium,small media_detail
                            $x = $CI->md_media->getLatestMedia();
                            $data3 = array(
                                'media_id'     => $x[0]->media_id,
                                'jenis_ukuran' => $size_img[$i],
                                'media_link'   => $new_image[$i],
                                'height'       => $save_img_resol,
                                'width'        => $save_img_resol,
                                'status'       => '1'
                            );
                            $CI->md_media_detail->addMediaDetail($data3);   
                    }    
                }
               
               unlink($source_image);
               return $x[0]->media_id;
                    
        } else {
            $error      = $CI->upload->display_errors();
            $jenis_eror = "did not select a file";
            if(strpos($error,$jenis_eror)){
                // echo json_encode($error);
                return NULL;
            } else {
                $pesan = "add_fail";
                // echo json_encode($error);
                echo json_encode($pesan);
            }
            die;
        }
    }

    function ImageUploadToSlide($dt='',$input_name='',$task=''){
        $CI = get_instance();
        $config = ImageUploadConfig('slideshow');
        $CI->load->library('upload', $config);
        if($task == 'add'){
            if($CI->upload->do_upload($input_name))
            {
                //Add media First
                    $data = array(
                        'judul' => $dt['judul'],
                        'link_slide' => $dt['link_slide'],
                        'tgl_post' => $dt['tgl_post'],
                        'keterangan' => $dt['keterangan'],
                        'author' => $dt['author'],
                        'status' => '1'
                    );
                    $CI->md_slide->addSlide($data);
                    
                //Update slideshow detail and resized file
                    $dt_upload    = $CI->upload->data();
                    $x            = $CI->md_slide->getLatestSlide();
                    $slide_id     = $x[0]->slide_id;
                    $name_file    = time().$dt_upload['file_ext'];
                    $source_image = './assets/file/' . $dt_upload['file_name'];
                    
                    $temp         = './assets/file/temp_' . $name_file;
                    ImageCompress($source_image, $temp, 80);

                    $new_image = array( 'assets/file/large/large_Slide_'.$name_file,
                                        'assets/file/small/small_Slide_' . $name_file);
                    $new_width = array(1920,1280);
                    $ukuran=array('large','small');
                    for($i=0;$i<2;$i++){

                        //resize for large,medium,small
                            $config = array(
                                'source_image'   => $temp,
                                'new_image'      => $new_image[$i],
                                'maintain_ratio' => true,
                                'width'          => $new_width[$i]
                            );
                            $CI->image_lib->initialize($config);
                            $CI->image_lib->resize();

                        //update url_slide & url_thumbnail
                        if($ukuran[$i] == 'large') $data2 = array('url_slide' => $new_image[$i]);
                        if($ukuran[$i] == 'small') $data2 = array('url_thumbnail' => $new_image[$i]);
                        $CI->md_slide->updateSlide($slide_id,$data2);
                    }
                // unlink($source_image);
                // unlink($temp);
                $pesan = "add_success";
            } else {
                $error = $CI->upload->display_errors();
                echo $error;
                $pesan = "add_fail";
            }
        } 
        else if($task == 'update'){
            $slide_id = $dt['slide_id'];
            $slide = $CI->md_slide->getSlideBySlideId($slide_id);
            if($CI->upload->do_upload($input_name)){
                //Update media First
                    $data = array(
                        'judul'      => $dt['judul'],
                        'link_slide' => $dt['link_slide'],
                        'tgl_post'   => $dt['tgl_post'],
                        'keterangan' => $dt['keterangan'],
                        'author'     => $dt['author'],
                        'status'     => '1'
                    );
                    $CI->md_slide->updateSlide($slide_id,$data);

                    unlink($slide[0]->url_slide);
                    unlink($slide[0]->url_thumbnail);
                    
                //Update slideshow detail and resized file
                    $dt_upload    = $CI->upload->data();
                    $x            = $CI->md_slide->getLatestSlide();
                    $name_file    = time().$dt_upload['file_ext'];
                    $source_image = './assets/file/' . $dt_upload['file_name'];
                    $new_image    = array( 'assets/file/large/large_Slide_'.$name_file,'assets/file/small/small_Slide_' . $name_file);
                    $new_width    = array(1920,350);
                    $ukuran       = array('large','small');
                    for($i=0;$i<2;$i++){
                        //resize for large,medium,small
                            $config = array(
                                'source_image'   => $source_image,
                                'new_image'      => $new_image[$i],
                                'maintain_ratio' => true,
                                'width'          => $new_width[$i]
                            );
                            $CI->image_lib->initialize($config);
                            $CI->image_lib->resize();

                        //update url_slide & url_thumbnail
                        if($ukuran[$i] == 'large') $data2 = array('url_slide' => $new_image[$i]);
                        if($ukuran[$i] == 'small') $data2 = array('url_thumbnail' => $new_image[$i]);
                        $CI->md_slide->updateSlide($slide_id,$data2);
                    }
                unlink($source_image);
                $pesan = "update_success";
            } else {
                $error = $CI->upload->display_errors();
                //JIka edit slideshow tanpa mengganti gambar
                if($error == "<p>You did not select a file to upload.</p>"){
                    //Update media First
                    $data = array(
                        'judul'      => $dt['judul'],
                        'link_slide' => $dt['link_slide'],
                        'tgl_post'   => $dt['tgl_post'],
                        'keterangan' => $dt['keterangan'],
                        'author'     => $dt['author'],
                        'status'     => '1'
                    );
                    $CI->md_slide->updateSlide($slide_id,$data);
                    $pesan = "update_success";
                } else {
                    $pesan = "add_fail";    
                }
            }
        }
        return $pesan;
    }

    function ImageCompress($source, $destination, $quality) {
        $info = getimagesize($source);
        if ($info['mime'] == 'image/jpeg') 
            $image = imagecreatefromjpeg($source);
        else if ($info['mime'] == 'image/gif') 
            $image = imagecreatefromgif($source);
        else if ($info['mime'] == 'image/png') 
            $image = imagecreatefrompng($source);
        imagejpeg($image, $destination, $quality);
        return $destination;
    }

    function FileUploadConfig($jenis=''){
        if($jenis == 'ppt_rwh'){
            $config['max_size']       = '2000';
            $config['allowed_types'] = 'ppt|pptx|PPT|PPTX';
        }
        else if($jenis == 'panduan_ibadah'){
            $config['max_size']       = '3000';
            $config['allowed_types'] = 'mp3|mp4';
        }

        $config['file_name'] = $jenis.'_'.time();
        $config['upload_path'] = './assets/file/';
        
        ini_set('memory_limit', '-1');
        return $config;
    }
	function FileUpload($jenis,$name_input){
		$CI = get_instance();
        $config = FileUploadConfig($jenis);

        $CI->load->library('upload', $config);
        if ($CI->upload->do_upload($name_input)){
            $dt = $CI->upload->data();
            //Jika judul tidak diisi, nama file akan digunakan
                $judul = $CI->input->post('judul');
                if($judul)
                    $judul = $judul.$dt['file_ext'];
                else
                    $judul = $dt['file_name'];

            //Add media First
            if($CI->session->userdata('pengguna_id'))
                $data2['author']=$CI->session->userdata('pengguna_id');
            else if($CI->session->userdata('member_id'))
                $data2['author']=$CI->session->userdata('member_id');
                                
                $data = array(
                    'judul' =>$judul,
                    'tipe' => 'file',
                    'tgl_upload' => date("Y-m-d H:i:s"),
                    'tgl_perubahan' => date("Y-m-d H:i:s"),
                    'status' => '1'
                );
                if($jenis == 'ppt_rwh')
                    $data['jenismedia_id'] = 5;
                if($jenis == 'panduan_ibadah'){
                    $data['jenismedia_id'] = 6;
                }

                $CI->md_media->addMedia($data);

            //Add Media detail and resized file
                $x = $CI->md_media->getLatestMedia();
                $data = $CI->upload->data();
                $data2 = array(
                    'media_id' => $x[0]->media_id,
                    'media_link' => 'assets/file/'.$data['file_name'],
                    'status' => '1'
                );
                $CI->md_media_detail->addMediaDetail($data2);
                
                return $x[0]->media_id;
        } else {
            $error = $CI->upload->display_errors();
            if($error == "<p>You did not select a file to upload.</p>"){
                $error="";
                return NULL;
            }
            else if($error=="<p>The filetype you are attempting to upload is not allowed.</p>"){
                $CI->session->set_flashdata('err_type',$error);
                return NULL;
            }
            else {
                $pesan = "add_fail";
                echo json_encode($pesan);
            }
            die;
        }
	}

    function deleteMedia($media_id){
        $data['status'] = 2;
        $CI = get_instance();
        $dt = $CI->md_media_detail->getMediaDetailByMediaId($media_id);
        //Hapus image di folder assets
            for($i=0;$i<count($dt);$i++){
                unlink($dt[$i]->media_link);
            }

        $CI->md_media->updateMedia($media_id,$data);
        $CI->md_media_detail->updateMediaDetailByMediaId($media_id,$data);
    }

// $image_info = getimagesize($_FILES["gambar"]["tmp_name"]);
//                 $image_width = $image_info[0];
//                 $image_height = $image_info[1];

//                 if ($_FILES["gambar"]["size"] <= 0) {
//                     $this->session->set_flashdata('msg', "success");
//                     $this->session->set_flashdata('flash_message', "<strong>Success! : </strong>Berita berhasil ditambahkan!");
//                     $this->session->set_flashdata('msg1', "warning");
//                     $this->session->set_flashdata('flash_message1', "<strong>Warning! : </strong>Gambar utama berita belum ditentukan!");
//                 } else if ($image_width <> 900 && $image_height <> 400) {
//                     $status_upload = 0;
//                     $this->session->set_flashdata('msg', "success");
//                     $this->session->set_flashdata('flash_message', "<strong>Success! : </strong>Berita berhasil ditambahkan!");
//                     $this->session->set_flashdata('msg1', "warning");
//                     $this->session->set_flashdata('flash_message1', "<strong>Warning! : </strong>Upload gambar gagal, ukuran gambar utama tidak 840 x 400 px!");
//                 } else {
//                     $status_upload = 1;
//                 }

?>
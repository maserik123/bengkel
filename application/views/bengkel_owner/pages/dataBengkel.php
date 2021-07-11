<script src="http://maps.googleapis.com/maps/api/js"></script>
<script>
    // variabel global marker
    var marker;

    function taruhMarker(peta, posisiTitik) {

        if (marker) {
            // pindahkan marker
            marker.setPosition(posisiTitik);
        } else {
            // buat marker baru
            marker = new google.maps.Marker({
                position: posisiTitik,
                map: peta
            });
        }

        // isi nilai koordinat ke form
        document.getElementById("latitude").value = posisiTitik.lat();
        document.getElementById("longitude").value = posisiTitik.lng();

    }

    function initialize() {
        var propertiPeta = {
            center: new google.maps.LatLng(0.48471913873406874, 101.44470103500504),
            zoom: 8,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);

        // even listner ketika peta diklik
        google.maps.event.addListener(peta, 'click', function(event) {
            taruhMarker(this, event.latLng);
        });

    }


    // event jendela di-load  
    google.maps.event.addDomListener(window, 'load', initialize);
</script>
<script>
    $(document).ready(function() {
        console.log('test');
        $('#peta').hide();
        $('#tombol_show').show();
        $('#tombol_hide').hide();
        $('#form').hide();

    });

    function showPeta() {
        $('#peta').show();
        $('#tombol_show').hide();
        $('#tombol_hide').show();
    }

    function hidePeta() {
        $('#peta').hide();
        $('#tombol_show').show();
        $('#tombol_hide').hide();
    }

    function showTabel() {
        $('#form').hide();
        $('#tabel').show();
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        table = $('#datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "responsive": true,
            "dataType": 'JSON',
            "ajax": {
                "url": "<?php echo site_url('owner/dataBengkel/getAllData') ?>",
                "type": "POST",
                "data": {
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                }
            },
            "order": [
                [0, "desc"]
            ],
            "columnDefs": [{
                "targets": [0],
                "className": "center"
            }]
        });
    });

    var save_method;

    function updateAllTable() {
        table.ajax.reload();
    }

    function tambah() {
        save_method = 'add';
        $('.form-group').removeClass('has-error')
            .removeClass('has-success')
            .find('#text-error').remove();
        $('#form').show();
        $('#tabel').hide();
    }

    function ubah(id) {
        save_method = 'update';
        $('#form_inputan')[0].reset();
        $('#form').show();
        $('#tabel').hide();
        $('.form-group').removeClass('has-error')
            .removeClass('has-success')
            .find('#text-error').remove();
        $.ajax({
            url: "<?php echo site_url('owner/dataBengkel/getById/'); ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(resp) {
                data = resp.data
                $('[name="id_bengkel"]').val(data.id_bengkel);
                $('[name="nama_bengkel"]').val(data.nama_bengkel);
                $('[name="alamat"]').val(data.alamat);
                $('[name="no_hp"]').val(data.no_hp);
                $('[name="id_pemilik_bengkel"]').val(data.id_pemilik_bengkel);
                $('[name="id_jenis_bengkel"]').val(data.id_jenis_bengkel);
                $('[name="layanan"]').val(data.layanan);
                $('[name="jadwal_buka"]').val(data.jadwal_buka);
                $('[name="jadwal_tutup"]').val(data.jadwal_tutup);
                $('[name="latitude"]').val(data.latitude);
                $('[name="longitude"]').val(data.longitude);

                $('.reset').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error Get Data From Ajax');
            }
        });

    }

    function hapus(id) {
        swal({
                title: "Apakah Yakin Akan Dihapus?",
                type: "warning",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonText: "Ya",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    url: "<?php echo site_url('owner/dataBengkel/delete'); ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    success: function(resp) {
                        data = resp.result;
                        updateAllTable();
                        return swal({
                            html: true,
                            timer: 1300,
                            showConfirmButton: false,
                            title: data['msg'],
                            type: data['status']
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error Deleting Data');
                    }
                });
            });
    }

    function simpan() {
        var token_name = '<?php echo $this->security->get_csrf_token_name(); ?>'
        var csrf_hash = ''
        var url;
        if (save_method == 'add') {
            url = '<?php echo base_url() ?>owner/dataBengkel/addData';
        } else {
            url = '<?php echo base_url() ?>owner/dataBengkel/update';
        }
        swal({
                title: "Apakah anda sudah yakin ?",
                type: "warning",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                cancelButtonText: "Kembali",
                confirmButtonText: "Ya",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: $('#form_inputan').serialize(),
                    dataType: "JSON",
                    success: function(resp) {
                        data = resp.result
                        csrf_hash = resp.csrf['token'];
                        $('#form_inputan input[name=' + token_name + ']').val(csrf_hash);
                        if (data['status'] == 'success') {
                            updateAllTable();
                            $('.form-group').removeClass('has-error')
                                .removeClass('has-success')
                                .find('#text-error').remove();
                            $("#form_inputan")[0].reset();
                            $('#form').hide();
                            $('#tabel').show();
                        } else {
                            $.each(data['messages'], function(key, value) {
                                var element = $('#' + key);
                                element.closest('div.form-group')
                                    .removeClass('has-error')
                                    .addClass(value.length > 0 ? 'has-error' : 'has-success')
                                    .find('#text-error')
                                    .remove();
                                element.after(value);
                            });
                        }
                        swal({
                            html: true,
                            timer: 1300,
                            showConfirmButton: false,
                            title: data['msg'],
                            type: data['status']
                        });
                    }

                });
            });
    }
</script>
<div class="container-fluid" id="tabel">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Daftar Bengkel Saya</h1>
    <p class="mb-4">Pada halaman ini menampilkan daftar bengkel saya yang ada pada sistem.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bengkel Terdaftar</h6>
            <div class="text-right">
                <button type="button" class="btn btn-primary btn-sm" id="btnTabel" onclick="tambah()"> <i class="fa fa-plus"></i> Tambah Data</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="font-size: 12px;">#</th>
                            <th style="font-size: 12px;">Nama Bengkel</th>
                            <th style="font-size: 12px;">Alamat</th>
                            <th style="font-size: 12px;">No Hp</th>
                            <th style="font-size: 12px;">Pemilik Bengkel</th>
                            <th style="font-size: 12px;">Jenis Bengkel</th>
                            <th style="font-size: 12px;">Layanan</th>
                            <th style="font-size: 12px;">Jadwal Buka</th>
                            <th style="font-size: 12px;">Jadwal Tutup</th>
                            <th style="font-size: 12px;">Latitude</th>
                            <th style="font-size: 12px;">Longitude</th>
                            <th style="font-size: 12px;">Tools</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="container" id="form">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-right">
                            <button type="button" onclick="showTabel()" id="btnForm" class="btn btn-success btn-sm"><i class="fa fa-arrow-left"></i> Kembali</button>
                        </div>
                        <div class="text-center">
                            <h5 class="h4 text-gray-900 mb-1">Data Bengkel</h5>
                            <small>Berikut keterangan data bengkel. Anda dapat melihat dan mengelola data bengkel sesuai dengan keterangan berikut.</small>
                        </div>
                        <br>
                        <?php echo form_open('', array('id' => 'form_inputan', 'class' => 'user', 'method' => 'post')); ?>

                        <input type="hidden" id="id_bengkel" name="id_bengkel">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="">Nama Bengkel :</label>
                                <input type="text" class="form-control form-control-user" name="nama_bengkel" id="nama_bengkel" placeholder="Nama Bengkel">
                            </div>
                            <div class="col-sm-6">
                                <label for="">Alamat :</label>
                                <input type="text" class="form-control form-control-user" id="alamat" name="alamat" placeholder="Alamat">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="">No Hp</label>
                                <input type="text" class="form-control form-control-user" id="no_hp" name="no_hp" placeholder="No Hp">
                            </div>
                            <div class="col-sm-6">
                                <label for="">Jenis Bengkel</label>
                                <select name="id_jenis_bengkel" id="id_jenis_bengkel" class="form-control" placeholder="Pilih Jenis Bengkel">
                                    <option value="">Pilih Jenis Bengkel</option>
                                    <?php foreach ($getAllJenisBengkel as $row) { ?>
                                        <option value="<?php echo $row->id_jenis_bengkel; ?>"><?php echo $row->judul; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="">Layanan Bengkel</label>
                                <input type="text" class="form-control form-control-user" id="layanan" name="layanan" placeholder="Layanan">
                            </div>
                            <div class="col-sm-3">
                                <label for="">Jadwal Buka</label>
                                <input type="time" class="form-control form-control-user" id="jadwal_buka" name="jadwal_buka" placeholder="Jadwal Buka">
                            </div>
                            <div class="col-sm-3">
                                <label for="">Jadwal Tutup</label>
                                <input type="time" class="form-control form-control-user" id="jadwal_tutup" name="jadwal_tutup" placeholder="Jadwal Tutup">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 mb-sm-0">
                                <button type="button" onclick="showPeta()" id="tombol_show" class="btn btn-primary btn-sm"><i class="fa fa-map"></i> Klik disini untuk mendapatkan Titik Koordinat Peta</button>
                                <button type="button" onclick="hidePeta()" id="tombol_hide" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Tutup Peta</button>
                                <br>
                            </div>
                            <div class="col-sm-12 mb-sm-0" id="peta">
                                <label for="">Silahkan klik wilayah untuk menambahkan titik koordinat wilayah bengkel anda.</label>
                                <div id="googleMap" style="width:100%;height:300px;"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-sm-0">
                                <label for="">Koordinat Latitude</label>
                                <input type="text" class="form-control form-control-user" value="" id="latitude" name="latitude" placeholder="Latitude">
                            </div>
                            <div class="col-sm-6">
                                <label for="">Koordinat Longitude</label>
                                <input type="text" class="form-control form-control-user" value="" id="longitude" name="longitude" placeholder="Longitude">
                            </div>
                        </div>
                        <button type="button" onclick="simpan()" class="btn btn-primary btn-user btn-block">
                            <i class="fa fa-save"></i> Simpan & Selesai
                        </button>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
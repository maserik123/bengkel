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
                "url": "<?php echo site_url('administrator/bengkelTerdaftar/getAllData') ?>",
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
        $('#modal').modal('show');
    }

    function ubah(id) {
        save_method = 'update';
        $('#form_inputan')[0].reset();
        $('#modal').modal('show');
        $('.form-group').removeClass('has-error')
            .removeClass('has-success')
            .find('#text-error').remove();
        $.ajax({
            url: "<?php echo site_url('administrator/bengkelTerdaftar/getById/'); ?>/" + id,
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
                $('[name="jadwal_bengkel"]').val(data.jadwal_bengkel);
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
                    url: "<?php echo site_url('administrator/bengkelTerdaftar/delete'); ?>/" + id,
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
            url = '<?php echo base_url() ?>administrator/bengkelTerdaftar/addData';
        } else {
            url = '<?php echo base_url() ?>administrator/bengkelTerdaftar/update';
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
                            $('#modal').modal('hide');
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

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Daftar Bengkel yang terdaftar</h1>
    <p class="mb-4">Pada halaman ini menampilkan daftar bengkel yang ada pada sistem.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bengkel Terdaftar</h6>
            <div class="text-right">
                <button type="button" class="btn btn-primary btn-sm" onclick="tambah()"> <i class="fa fa-plus"></i> Tambah Data</button>
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
    <!-- Modal -->
    <div id="modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"><i class="fa fa-table"></i> Daftar Bengkel</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <?php echo form_open('', array('id' => 'form_inputan', 'class' => 'user', 'method' => 'post')); ?>
                <input type="hidden" id="id_bengkel" name="id_bengkel">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <small for="">Nama Bengkel</small>
                                <input type="text" class="form-control form-control-user" id="nama_bengkel" name="nama_bengkel" placeholder="Nama Bengkel">
                            </div>
                            <div class="form-group">
                                <small for="">Alamat Bengkel</small>
                                <input type="text" class="form-control form-control-user" id="alamat" name="alamat" placeholder="Alamat">
                            </div>
                            <div class="form-group">
                                <small for="">No Hp</small>
                                <input type="text" class="form-control form-control-user" id="no_hp" name="no_hp" placeholder="No Hp">
                            </div>
                            <div class="form-group">
                                <small for="">Pemilik Bengkel</small>
                                <input type="text" class="form-control form-control-user" id="id_pemilik_bengkel" name="id_pemilik_bengkel" placeholder="Pemilik Bengkel">
                            </div>
                            <div class="form-group">
                                <small for="">Jenis Bengkel</small>
                                <input type="text" class="form-control form-control-user" id="id_jenis_bengkel" name="id_jenis_bengkel" placeholder="Jenis Bengkel">
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small for="">Layanan Bengkel</small>
                                <input type="text" class="form-control form-control-user" id="layanan" name="layanan" placeholder="Layanan Bengkel">
                            </div>
                            <div class="form-group">
                                <small for="">Jadwal Buka</small>
                                <input type="time" class="form-control form-control-user" id="jadwal_buka" name="jadwal_buka" placeholder="Jadwal Bengkel">
                            </div>
                            <div class="form-group">
                                <small for="">Jadwal Tutup</small>
                                <input type="time" class="form-control form-control-user" id="jadwal_tutup" name="jadwal_tutup" placeholder="Jadwal Bengkel">
                            </div>
                            <div class="form-group">
                                <small for="">Latitude Bengkel</small>
                                <input type="text" class="form-control form-control-user" id="latitude" name="latitude" placeholder="Latitude Bengkel">
                            </div>
                            <div class="form-group">
                                <small for="">Longitude Bengkel</small>
                                <input type="text" class="form-control form-control-user" id="longitude" name="longitude" placeholder="Longitude Bengkel">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="reset" class="btn btn-info btn-sm reset"><i class="fa fa-undo"></i> Reset</button>
                    <button type="button" class="btn btn-success btn-sm" onclick="simpan()"><i class="fa fa-save"></i> Save</button>
                </div>
                <?php echo form_close(); ?>
            </div>

        </div>
    </div>
</div>
<!-- /.container-fluid -->
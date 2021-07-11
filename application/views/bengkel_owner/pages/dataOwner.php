<script>
    function simpan() {
        var token_name = '<?php echo $this->security->get_csrf_token_name(); ?>'
        var csrf_hash = ''
        var url;
        url = '<?php echo base_url() ?>owner/dataOwner/update';
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
                            window.location.reload();
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
<div class="container" id="form">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h5 class="h4 text-gray-900 mb-1">Data Pemilik Bengkel</h5>
                            <small>Berikut keterangan data pemilik bengkel. Anda dapat melihat dan mengelola data pemilik bengkel sesuai dengan keterangan berikut.</small>
                        </div>
                        <br>
                        <?php echo form_open('', array('id' => 'form_inputan', 'class' => 'user', 'method' => 'post')); ?>

                        <input type="hidden" id="id_pemilik_bengkel" value="<?php echo $getPemilikBengkelByIdUser[0]->id_pemilik_bengkel; ?>" name="id_pemilik_bengkel">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="">Nama Pemilik :</label>
                                <input type="text" class="form-control form-control-user" name="nama_pemilik" id="nama_pemilik" value="<?php echo $getPemilikBengkelByIdUser[0]->nama_pemilik; ?>" placeholder="Nama Pemilik Bengkel">
                            </div>
                            <div class="col-sm-6">
                                <label for="">Alamat :</label>
                                <input type="text" class="form-control form-control-user" id="alamat" name="alamat" value="<?php echo $getPemilikBengkelByIdUser[0]->alamat; ?>" placeholder="Alamat">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="">No Hp</label>
                                <input type="text" class="form-control form-control-user" id="no_hp" name="no_hp" value="<?php echo $getPemilikBengkelByIdUser[0]->no_hp; ?>" placeholder="No Hp">
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="">Email</label>
                                <input type="text" class="form-control form-control-user" id="email" name="email" value="<?php echo $getPemilikBengkelByIdUser[0]->email; ?>" placeholder="Email">
                            </div>
                        </div>

                        <button type="button" onclick="simpan()" class="btn btn-primary btn-user btn-block">
                            <i class="fa fa-save"></i> Perbarui Data Saya
                        </button>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
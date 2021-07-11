<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Registrasi</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url('components_owner/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="<?php echo base_url('components_owner/') ?>plugins/sweetalert/sweetalert.css">
    <script src="<?php echo base_url('components_owner/') ?>vendor/jquery/jquery.min.js"></script>
    <link href="<?php echo base_url('components_owner/') ?>css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
    <script>
        console.log('test')

        function simpan() {
            var token_name = '<?php echo $this->security->get_csrf_token_name(); ?>'
            var csrf_hash = ''
            var url;
            url = '<?php echo base_url() ?>AuthOwner/registrasi/addData';

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
                        data: $('#form_regis').serialize(),
                        dataType: "JSON",
                        success: function(resp) {
                            data = resp.result
                            csrf_hash = resp.csrf['token'];
                            $('#form_regis input[name=' + token_name + ']').val(csrf_hash);
                            if (data['status'] == 'success') {
                                // updateAllTable();
                                $('.form-group').removeClass('has-error')
                                    .removeClass('has-success')
                                    .find('#text-error').remove();
                                $("#form_regis")[0].reset();
                                $url = '<?php echo base_url('/auth/') ?>';
                                setTimeout(() => {
                                    $(location).attr('href', $url)
                                }, 1400);
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

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <?php echo form_open('', array('id' => 'form_regis', 'method' => 'post', 'class' => 'user')); ?>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="first_name" placeholder="First Name">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" id="last_name" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="username" placeholder="Username">
                                </div>
                                <div class="col-sm-3">
                                    <input type="password" class="form-control form-control-user" id="password" placeholder="Password">
                                </div>
                                <div class="col-sm-3 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user" id="confirm" placeholder="Repeat Password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="email" class="form-control form-control-user" id="email" placeholder="Email">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" id="phone_number" placeholder="Phone Number">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="address" placeholder="Alamat">
                                </div>
                                <!-- <div class="col-sm-6">
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Male">Laki-laki</option>
                                        <option value="Female">Perempuan</option>
                                    </select>
                                </div> -->
                            </div>
                            <hr>
                            <a href="<?php echo base_url('AuthOwner') ?>" class="btn btn-danger btn-user">
                                <i class="fa fa-user"></i> Login
                            </a>
                            <button type="button" onclick="simpan()" class="btn btn-primary"><span class="icon-save"></span> Simpan</button>

                            <?php echo form_close(); ?>
                            <hr>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url('components_owner/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url('components_owner/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url('components_owner/') ?>js/sb-admin-2.min.js"></script>
    <script src="<?php echo base_url('components_owner/') ?>plugins/sweetalert/sweetalert.min.js"></script>


</body>

</html>
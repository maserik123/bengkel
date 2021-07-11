<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Halaman Login Owner</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url('components_administrator/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url('components_administrator/') ?>css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-right">
                                        <button type="button" onclick="window.location='<?php echo base_url('pengunjung/') ?>'" class="btn btn-primary btn-sm"><i class="fa fa-users"></i> Halaman Pengunjung</button>
                                    </div>
                                    <div class="text-center">
                                        <img src="<?php echo base_url('components_owner/img/undraw_profile_2.svg') ?>" height="120px" width="120px" alt=""><br><br>
                                        <h1 class="h4 text-gray-900 mb-4">Login Pemilik Bengkel</h1>

                                        <div class="text-center">
                                            <?php
                                            $message = $this->session->flashdata('result_login');
                                            if ($message) { ?>
                                                <small style="color: red;"><?php echo $message; ?></small>
                                            <?php } ?>
                                        </div>

                                    </div>
                                    <?php echo form_open("AuthOwner/", array('method' => 'POST', 'class' => 'user')); ?>

                                    <div class="form-group">
                                        <div class="text-left" style="font-size: 12px;"><?php echo form_error('username'); ?></div>
                                        <?php echo form_input(array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Username', 'name' => 'username', 'id' => 'username')); ?>
                                    </div>
                                    <div class="form-group">
                                        <div class="text-left" style="font-size: 12px;"> <?php echo form_error('password'); ?> </div>
                                        <?php echo form_input(array('type' => 'password', 'class' => 'form-control', 'placeholder' => 'Password', 'name' => 'password', 'id' => 'password')); ?>
                                    </div>

                                    <!-- <a href="index.html" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </a> -->
                                    <button class="btn btn-primary btn-sm" style="width: 100%;" type="submit"> <i class='fa fa-user'></i> Masuk</button>

                                    <?php echo form_close(); ?>
                                    <hr>

                                    <a href="<?php echo base_url('AuthOwner/registrasi') ?>" class="btn btn-info btn-user btn-block">
                                        <i class="fa fa-briefcase"></i> Daftarkan Bengkel Anda
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url('components_administrator/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url('components_administrator/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url('components_administrator/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url('components_administrator/') ?>js/sb-admin-2.min.js"></script>

</body>

</html>
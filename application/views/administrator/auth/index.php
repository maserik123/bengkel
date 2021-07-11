<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Halaman Login Administrator</title>

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
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <button type="button" onclick="window.location='<?php echo base_url('Owner/'); ?>'" class="btn btn-warning btn-sm"><i class="fa fa-user"></i> Akses Halaman Owner</button>
                                        <button type="button" onclick="window.location='<?php echo base_url('Pengunjung'); ?>'" class="btn btn-success btn-sm"><i class="fa fa-user"></i> Akses Halaman Pengunjung</button>
                                        <br><br>
                                        <img src="<?php echo base_url('components_owner/img/undraw_profile_3.svg') ?>" height="120px" width="120px" alt=""><br><br>

                                        <h1 class="h4 text-gray-900 mb-4">Login Administrator</h1>
                                    </div>
                                    <?php echo form_open("Auth/", array('method' => 'POST', 'class' => 'user')); ?>

                                    <div class="form-group">
                                        <div class="text-left" style="font-size: 10px;"><?php echo form_error('username'); ?></div>
                                        <?php echo form_input(array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Username', 'name' => 'username', 'id' => 'username')); ?>
                                    </div>
                                    <div class="form-group">
                                        <div class="text-left" style="font-size: 10px;"> <?php echo form_error('password'); ?> </div>
                                        <?php echo form_input(array('type' => 'password', 'class' => 'form-control', 'placeholder' => 'Password', 'name' => 'password', 'id' => 'password')); ?>
                                    </div>

                                    <!-- <a href="index.html" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </a> -->
                                    <button class="btn btn-danger btn-sm" style="width: 100%;" type="submit"> <i class='fa fa-user'></i> Masuk</button>

                                    <?php echo form_close(); ?>
                                    <hr>

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
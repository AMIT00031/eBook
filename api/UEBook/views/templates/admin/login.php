<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $title; ?>! | </title>

        <!-- Bootstrap -->
        <link href="<?php echo base_url() ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?php echo base_url() ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="<?php echo base_url() ?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- Animate.css -->
        <link href="<?php echo base_url() ?>assets/vendors/animate.css/animate.min.css" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="<?php echo base_url() ?>assets/build/css/custom.min.css" rel="stylesheet">
    </head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.8.1/parsley.min.js"></script>

    <body class="login">
        <div>
            <?php
            if ($this->session->userdata('message_type')) {
                ?>
                <div class="alert alert-<?= $this->session->userdata('message_type'); ?> fade in">
                    <button data-dismiss="alert" class="close">
                        ×
                    </button>
                    <i class="fa-fw fa fa-<?= $this->session->userdata('message_type'); ?> "></i>
                    <?= $this->session->userdata('message'); ?>
                </div>
            <?php } ?>


            <div class="login_wrapper">
                <?php
                echo $body;
                if ($this->session->userdata('message_type') != '') {
                    $this->session->unset_userdata('message_type');
                }
                if ($this->session->userdata('message') != '') {
                    $this->session->unset_userdata('message');
                }
                $this->session->set_userdata('message', '');
                $this->session->set_userdata('message_type', '');
                ?>
            </div>
        </div>
    </body>
</html>

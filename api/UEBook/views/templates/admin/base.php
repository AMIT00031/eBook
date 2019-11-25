<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="images/favicon.ico" type="image/ico" />

        <title><?= $title ?>! | </title>

        <!-- Bootstrap -->
        <link href="<?php echo base_url() ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?php echo base_url() ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="<?php echo base_url() ?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- iCheck -->
        <link href="<?php echo base_url() ?>assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

        <!-- bootstrap-progressbar -->
        <link href="<?php echo base_url() ?>assets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
        <!-- JQVMap -->
        <link href="<?php echo base_url() ?>assets/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
        <!-- bootstrap-daterangepicker -->
        <link href="<?php echo base_url() ?>assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        
        <link href="<?php echo base_url() ?>assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

        <link href="<?php echo base_url() ?>assets/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/build/css/custom.min.css" rel="stylesheet">
        <!-- Select2 -->
        <link href="<?php echo base_url() ?>assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
        <!-- Switchery -->
        <link href="<?php echo base_url() ?>assets/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
        <!-- starrr -->
        <link href="<?php echo base_url() ?>assets/vendors/starrr/dist/starrr.css" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="<?php echo base_url() ?>assets/build/css/custom.min.css" rel="stylesheet">
        <script src="<?php echo base_url() ?>assets/vendors/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url() ?>assets/vendors/ckeditor/ckeditor.js"></script>
    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <?php $this->load->view('header/header'); ?>

                <div class="right_col" role="main">
                    <div class="row">
                        <article class="col-sm-12 alert-message-base" id="show_alert_message">
                            <?php
                            if ($this->session->userdata('message_type')) {
                                ?>
                                <div class="alert alert-<?= $this->session->userdata('message_type'); ?> fade in">
                                    <button data-dismiss="alert" class="close">
                                        ×
                                    </button>
                                    <?= $this->session->userdata('message'); ?>
                                </div>
                            <?php } ?>
                        </article>
                    </div>

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

        </div>


        <?php $this->load->view('footer/footer'); ?>


        <!-- Bootstrap -->
        <script src="<?php echo base_url() ?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url() ?>assets/vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="<?php echo base_url() ?>assets/vendors/nprogress/nprogress.js"></script>
        <!-- Chart.js -->
        <script src="<?php echo base_url() ?>assets/vendors/Chart.js/dist/Chart.min.js"></script>
        <!-- gauge.js -->
        <script src="<?php echo base_url() ?>assets/vendors/gauge.js/dist/gauge.min.js"></script>
        <!-- bootstrap-progressbar -->
        <script src="<?php echo base_url() ?>assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url() ?>assets/vendors/iCheck/icheck.min.js"></script>
        <!-- Skycons -->
        <script src="<?php echo base_url() ?>assets/vendors/skycons/skycons.js"></script>
        <!-- Flot -->
        <script src="<?php echo base_url() ?>assets/vendors/Flot/jquery.flot.js"></script>
        <script src="<?php echo base_url() ?>assets/vendors/Flot/jquery.flot.pie.js"></script>
        <script src="<?php echo base_url() ?>assets/vendors/Flot/jquery.flot.time.js"></script>
        <script src="<?php echo base_url() ?>assets/vendors/Flot/jquery.flot.stack.js"></script>
        <script src="<?php echo base_url() ?>assets/vendors/Flot/jquery.flot.resize.js"></script>
        <!-- Flot plugins -->
        <script src="<?php echo base_url() ?>assets/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
        <script src="<?php echo base_url() ?>assets/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
        <script src="<?php echo base_url() ?>assets/vendors/flot.curvedlines/curvedLines.js"></script>
        <!-- DateJS -->
        <script src="<?php echo base_url() ?>assets/vendors/DateJS/build/date.js"></script>

        <!-- bootstrap-daterangepicker -->
        <script src="<?php echo base_url() ?>assets/vendors/moment/min/moment.min.js"></script>
        <script src="<?php echo base_url() ?>assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>


        <script src="<?php echo base_url() ?>assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url() ?>assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

        <script src="<?php echo base_url() ?>assets/vendors/moment/min/moment.min.js"></script>
        <script src="<?php echo base_url() ?>assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!-- bootstrap-wysiwyg -->
        <script src="<?php echo base_url() ?>assets/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
        <script src="<?php echo base_url() ?>assets/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
        <script src="<?php echo base_url() ?>assets/vendors/google-code-prettify/src/prettify.js"></script>
        <!-- jQuery Tags Input -->
        <script src="<?php echo base_url() ?>assets/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
        <!-- Switchery -->
        <script src="<?php echo base_url() ?>assets/vendors/switchery/dist/switchery.min.js"></script>
        <!-- Select2 -->
        <script src="<?php echo base_url() ?>assets/vendors/select2/dist/js/select2.full.min.js"></script>
        <!-- Parsley -->
        <script src="<?php echo base_url() ?>assets/vendors/parsleyjs/dist/parsley.min.js"></script>
        <!-- Autosize -->
        <script src="<?php echo base_url() ?>assets/vendors/autosize/dist/autosize.min.js"></script>
        <!-- jQuery autocomplete -->
        <script src="<?php echo base_url() ?>assets/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
        <!-- starrr -->
        <script src="<?php echo base_url() ?>assets/vendors/starrr/dist/starrr.js"></script>

        <!-- Custom Theme Scripts -->
        <script src="<?php echo base_url() ?>assets/build/js/custom.min.js"></script>
        
        <script>
            var base_url = "<?php echo base_url(); ?>";
         $('#language-convert').change(function (e) {
            e.preventDefault();
            var lang = $(this).val();
            location.href = base_url + 'LanguageSwitcher/switchLang/' + lang;
        });    
        </script>
        
        
    </body>

</html>

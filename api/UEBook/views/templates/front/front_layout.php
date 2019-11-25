<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo!empty($title) ? $title : 'Calculator' ?></title>
        <!-- responsive meta -->
         <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- For IE -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--Facebook meta tags for fetching information-->
        <meta property="og:site_name" content="<?php echo!empty($og_site_name) ? $og_site_name : '' ?>"/>
        <meta property="og:title" content="<?php echo!empty($og_title) ? $og_title : '' ?>"/>
        <meta property="og:type" content="<?php echo!empty($og_type) ? $og_type : '' ?>">
        <meta property="og:url" content="<?php echo!empty($og_url) ? $og_url : '' ?>"/>
        <meta property="og:image" content="<?php echo!empty($og_image) ? $og_image : '' ?>"/>
        <meta property="og:description" content="<?php echo!empty($og_title) ? $og_title : '' ?>"/>
        <meta property="og:image:width" content="400"/>
        <meta property="og:image:height" content="460"/>
		
	  <!-- ================== Font =================== -->
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/front/font/font-awesome/css/font-awesome.min.css">
	  <link rel="stylesheet" type="text/css" href="font/mdi-font/css/material-design-iconic-font.min.css">
	  
	  <!-- ================== Vendor CSS =================== -->
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/front/vendor/bootstrap4/bootstrap.min.css">
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/front/vendor/owl-carousel/animate.css">
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/front/vendor/owl-carousel/owl.carousel.min.css">
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/front/vendor/owl-carousel/owl.theme.default.min.css">
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/front/vendor/revolution/settings.css">
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/front/vendor/revolution/navigation.css">
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/front/vendor/revolution/layers.css">
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/front/vendor/lightbox2/src/css/lightbox.css">

	  <!-- Main CSS -->
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/front/css/font.css">
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/front/css/style.css">
  
        

        <?php /* <style type="text/css">
            .tp-bgimg.defaultimg {
                background-size: cover !important;
                background-position: bottom right !important;
            }
            .alert{
                position: absolute;
                z-index: 9999 !important;
                top: 0px !important;
                left: 0px !important;
                right: 0px !important;
                
            }
        </style> */ ?>
    </head>


    <script type="text/javascript">
        var baseUrl = "<?php echo base_url() ?>";
    </script>
    <script src="<?php echo base_url('assets/front/js/jquery-3.2.1.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/front/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/front/js/parsley.min.js') ?>"></script>

    <body>
	
        <?php
        if ($this->session->userdata('message_type')) {
            ?>
            <div class="alert alert-<?= $this->session->userdata('message_type'); ?> fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?= $this->session->userdata('message'); ?>
            </div>
        <?php } ?>
        <!--Start Preloader -->
		
        <?php /* <div class="loader">
            <div class="cssload-thecube">
                <div class="cssload-cube cssload-c1"></div>
                <div class="cssload-cube cssload-c2"></div>
                <div class="cssload-cube cssload-c4"></div>
                <div class="cssload-cube cssload-c3"></div>
            </div>
        </div>
        <div class="short-msg">
            <a href="#" class="back-to"><i class="icon-arrow-up2"></i></a>
            <a href="#" class="short-topup" data-toggle="modal" data-target="#myModal"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
        </div> */ ?>
	 <div class="page-wrap">
	
		 <?php $this->load->view('header/front_header'); ?>
       
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

        <?php $this->load->view('footer/front_footer'); ?>
		
		
		</div>
	
		

    </body>
</html>

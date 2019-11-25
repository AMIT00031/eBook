<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container" style="border:1px solid;">
            <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <img src="<?php echo base_url('assets/front/images/logo1.png') ?>" alt="logo" width="160" height="70"/>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <span style="color: #337ab7;"><?php echo base_url(); ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12" style="margin-top: 40px;">
                    <div><p style="font-size:16px;">Hi <strong>&nbsp;<?php echo ucfirst($mail['user_name']); ?></strong></p></div>
                    <a href="<?php echo ucfirst($mail['link']); ?>" class="">Activation Link</a>
                    <br>
                </div>
            </div>
            <br>
            <div class="row text-center">
                <a href="<?php echo base_url() ?>" target="_blank">Take me to <?= base_url() ?></a>
            </div>
        </div>
    </body>
</html>


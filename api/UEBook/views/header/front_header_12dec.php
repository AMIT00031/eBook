<?php
$isUserLoggedIn = $this->session->userdata('isUserLoggedIn');
if (!empty($isUserLoggedIn)) {
    $sMargin = '443px';
} else {
    $sMargin = '550px';
}
$userName = $this->session->userdata('userName');
?>

<header id="main_header" class="header_sev">
    <div id="header-top">
        <div class="container">
            <div class="row">
                <div class="col-md-2 hidden-xs hidden-sm logo-top_sev">
                    <a href="<?php echo base_url()?>">
                        <img src="<?php echo base_url('assets/front/images/logo.png') ?>" alt="logo"/>
                    </a>
                </div>
                <div class="col-md-10 col-sm-10 col-xs-12 text-right">
                    <div class="header-top-links">
                        <ul>
                           <!-- <li><a href="favorite-properties.html"><i class="icon-heart2"></i>Favourites</a></li>
                           <li class="af-line"></li> -->
                            <li><a href="<?php echo base_url('quotes/add_query')?>"><i class="icon-icons215"></i>Submit Property</a></li>
                            <li class="af-line"></li>
                            <li><a href="#"><i class="icon-icons215"></i>Welcome <?= $userName?> </a></li>
                            <li class="af-line"></li>
                            <?php if ($isUserLoggedIn) { ?>
                                        <li><a href="<?php echo base_url('agent/logout') ?>" class="header-login"><i class="icon-icons179"></i>Log out</a></li>
                                <?php } else { ?>
                                    <li><a href="<?php echo base_url('agent/login_register') ?>" class="header-login"><i class="icon-icons179"></i>Login / Register</a></li>
                                <?php } ?>
                            
                            
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-default navbar-sticky bootsnav">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="social-icons text-right">
                        <ul class="socials">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        </ul>
                    </div>
                    <!-- Start Header Navigation -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                            <i class="fa fa-bars"></i></button>
                        <a class="navbar-brand sticky_logo" href="#"><img src="<?php echo base_url('assets/front') ?>/images/logo_center.png" class="logo" alt=""></a>
                    </div>
                    <!-- End Header Navigation --> 
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <ul class="nav navbar-nav" data-in="fadeInDown" data-out="fadeOutUp">
                            <li class="dropdown active">
                                <a href="#">Homes</a>
                            </li>
                            <li class="dropdown">
                                <a href="#">About Us</a>
                            </li>
                            <li class="dropdown">
                                <a href="#">Properties</a>
                            </li>
                            <li class="dropdown">
                                <a href="#">Gallery</a>
                            </li>
                            <li class="dropdown">
                                <a href="#">Testimonials</a>
                            </li>
                            <li class="dropdown">
                                <a href="#">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
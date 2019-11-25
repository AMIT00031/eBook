<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/css/style.css" media="all">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/css/custom-bootstrap-margin-padding.css" media="all">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/css/main.css" media="all">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/css/custome.css" media="all">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" media="all">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container" style="border:1px solid;">
            <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <img src="<?php echo base_url('assets/front/images/logo.png') ?>" alt="logo" width="160" height="70"/>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <span style="color: #337ab7;float: right;margin: 15px 0px 0px 0px;"><?php echo base_url(); ?></span>
                </div>
            </div>
            <div class="col-sm-12 col-lg-12" style="text-align:center;margin-bottom: 8px;color:#38aebb;">
                <h3>Best on the Quirkstop</h3>
                </div>
            <div class="clearfix"></div>
            <div class="row">
                <section class="wow bounceInUp animated">
                    <div class="container pl-10 pr-10">

                        <div class="col-md-12 pl-0 pr-0 clearfix mt-0" style="display:block; clear:both"></div>
                        <div id="item_container" class="best-pro">

                            <?php
                            $user_id = '';
                            $uId = '';
                            $user_id = $this->session->userdata('userId');

                            if (!empty($user_id)) {
                                $uId = $user_id;
                            }

                            $share_url = '';


                            $img_path = '';
                            $counter = 0;
                            if (!empty($mail['products'])) {

                                foreach ($mail['products'] as $admin_product) {
//                                    dump($admin_product);die;
                                    if ($counter % 4 == 0) {
                                        echo '<div class = clearfix></div>';
                                    }
                                    $wishlistCount = getProductCountOnWishList($admin_product->products->id);
                                    $wishlist_exist = itemExistOnWishlist($admin_product->products->id, $uId);
                                    $storeName = getStoreNameById($admin_product->products->store);
//                                    dump($storeName);
                                    if ($wishlistCount > 0) {
                                        $wishClass = "item-exist";
                                    } else {
                                        $wishClass = "";
                                    }


                                    $out = strlen($admin_product->products->title) > 80 ? substr($admin_product->products->title, 0, 80) . "..." : $admin_product->products->title;
                                    if (!empty($admin_product->products->medium_image)) {
                                        if (filter_var(trim($admin_product->products->medium_image), FILTER_VALIDATE_URL)) {
                                            $img_path = trim($admin_product->products->medium_image);
                                        } else {
                                            $absolute_path = FCPATH . 'uploads/product/' . $admin_product->products->medium_image;
                                            if (file_exists($absolute_path)) {
                                                $img_path = base_url() . 'uploads/product/' . $admin_product->products->medium_image;
                                            } else {
                                                $img_path = base_url() . 'uploads/product/default.png';
                                            }
                                        }
                                    } else {
                                        $img_path = base_url() . 'uploads/product/default.png';
                                    }
                                    ?>

                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 pr-5 pl-5">
                                        <div class="productdiv">
                                            <div class="productprice"><?php echo!empty($admin_product->products->price) ? 'Rs. ' . $admin_product->products->price : '' ?></div>
                                            <a href="<?php echo base_url() . 'product/' . $admin_product->products->url; ?>" target="_blank">
                                                <img src="<?php echo base_url() . 'image_resize.php?&w=250&h=250&img=' . $img_path . ''; ?>" class="img-responsive">
                                            </a>

                                            <div class="producttitlename"><?php echo $out; ?></div>

                                            <div class="whitebgprd">

                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 p-0">
                                                    <div class="sellernaame"><?php echo $storeName ?></div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 p-0">
                                                    <span class="pull-right social-share" style="cursor:pointer">
                                                        <div class="shareicon" pid = "<?php echo $admin_product->products->id ?>"><i class="fa fa-share-alt"></i></div>
                                                    </span>
                                                    <span class="pull-right wishlist">
                                                        <a href="javascript:void(0)" pro-count="<?php echo $wishlistCount; ?>" pro-id ="<?php echo $admin_product->products->id; ?>"  class="product-btn btn-icon top-right <?php echo $wishClass ?>" title="Favorite"><i class="fa fa-heart"></i><div class="count wishC<?php echo $admin_product->products->id; ?>"><sub><?php echo $wishlistCount; ?></sub></div></a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    $counter++;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </section>
            </div>
            <br>
            <div class="row text-center">
                <a href="<?php echo base_url() ?>" target="_blank">Take me to quirkstop.com</a>
            </div>
        </div>
    </body>
</html>


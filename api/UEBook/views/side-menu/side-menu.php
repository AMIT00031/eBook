<?php

$urlSegment = $this->uri->segment_array();

if (!empty($urlSegment)) {

    $uriString = end($urlSegment);

}

?>

<aside id="left-panel">

    <div class="login-info">

        <span>

            <a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">

                <img src="<?php echo base_url(); ?>assets/admin/img/avatars/sunny.png" alt="me" class="online" /> 

                <span>

                    <?php

                    $user_info = $this->ion_auth->user()->row();

                    echo!empty($user_info->first_name) ? $user_info->first_name : '';

                    ?>

                </span>

                <i class="fa fa-angle-down"></i>

            </a> 

        </span>

    </div>

    <nav>

        <ul>

            <li class="">

                <a title="Dashboard" href="#">

                    <i class="fa fa-lg fa-fw fa-home"></i><span class="menu-item-parent">Dashboard </span>

                    <b class="collapse-sign"><em class="fa fa-minus-square-o"></em></b>

                </a>





            </li>



        </ul>

        <ul>

            <li class="">

                <a title="Location" href="#">

                    <i class="fa fa-lg fa-fw fa-location-arrow"></i><span class="menu-item-parent">Admin User </span>

                </a>

                <ul style="display: none;">

                    <li class="<?php echo ($uriString == 'users' || $uriString == 'create_user' || is_numeric($uriString)) ? 'active' : '' ?>"><a title="Admin Users" href="<?php echo base_url('admin/users') ?>">

                            Admin Users

                        </a>

                    </li>

                </ul>

            </li>

        </ul> 
		
		<ul>

            <li class="">

                <a title="Location" href="#">

                    <i class="fa fa-lg fa-fw fa-location-arrow"></i><span class="menu-item-parent">Category</span>

                </a>

                <ul style="display: none;">

                    <li class="<?php echo ($uriString == 'category' || $uriString == 'add' || $uriString == 'add' || is_numeric($uriString)) ? 'active' : '' ?>"><a title="Category" href="<?php echo base_url('admin/category') ?>">

                            Category Mgmt.

                        </a>

                    </li>

                </ul>

            </li>

        </ul> 

        

        <?php /*  <ul>

            <li class="">

                <a title="Location" href="#">

                    <i class="fa fa-lg fa-fw fa-location-arrow"></i><span class="menu-item-parent">Chat Users </span>

                </a>

                <ul style="display: none;">

                    <li class="<?php echo ($uriString == 'chatusers' || $uriString == 'chatcreate_user' || is_numeric($uriString)) ? 'active' : '' ?>"><a title="Admin chat Users" href="<?php echo base_url('admin/chatusers') ?>">

                           Chat Users

                        </a>

                    </li>

                </ul>

            </li>

        </ul>

        

        <ul>

            <li class="">

                <a title="Tour" href="#">

                    <i class="fa fa-lg fa-pencil"></i><span class="menu-item-parent">Catalogs Manger</span>

                </a>

                <ul style="display: none;">

                    <li class="<?php echo ($uriString == 'category') ? 'active' : '' ?>">

                        <a title="Category" href="<?php echo base_url('admin/category') ?>">

                            Category

                        </a>

                    </li>

                    <li class="<?php echo ($uriString == 'category') ? 'active' : '' ?>">

                        <a title="Category" href="<?php echo base_url('admin/catalog') ?>">

                            catalogs

                        </a>

                    </li>

                </ul>

            </li>

        </ul>

        

        <ul>

            <li class="">

                <a title="Location" href="#">

                    <i class="fa fa-lg fa-fw fa-table"></i><span class="menu-item-parent">Widgets Manger</span>

                </a>

                <ul style="display: none;">

                    <li class="<?php echo ($uriString == 'footer_managment' || $uriString == 'add_footer_content' || is_numeric($uriString)) ? 'active' : '' ?>"><a title="Wiget Manager" href="<?php echo base_url('admin/settings/footer_managment') ?>">

                            Manage Footer Widgets

                        </a>

                    </li>

                    <li class="<?php echo ($uriString == 'home_wiget' || $uriString == 'add_footer_content' || is_numeric($uriString)) ? 'active' : '' ?>"><a title="Wiget Manager" href="<?php echo base_url('admin/settings/home_wiget') ?>">

                            Manage Home Widgets

                        </a>

                    </li>

                </ul>

            </li>

        </ul>



        <ul>

            <li class="">

                <a title="Miscellaneous" href="#">

                    <i class="fa fa-lg fa-fw fa-location-arrow"></i>

                    <span class="menu-item-parent">Content Management</span>

                </a>

                <ul style="">

                    <li class="<?php echo ($uriString == 'cms') ? 'active' : '' ?>">

                        <a title="cms" href="<?php echo base_url() . 'admin/cms' ?>">

                            CMS Page Manager

                        </a>

                    </li>

                    <li class="<?php echo ($uriString == 'menu_manager') ? 'active' : '' ?>">

                        <a title="cms" href="<?php echo base_url() . 'admin/cms/menu_manager' ?>">

                            Menu Management

                        </a>

                    </li>

                    <li class="<?php echo ($uriString == 'blogs') ? 'active' : '' ?>">

                        <a title="Activities" href="<?php echo base_url() . 'admin/blogs' ?>">

                            Blog Manager

                        </a>

                    </li>

                    <li class="<?php echo ($uriString == 'testimonial') ? 'active' : '' ?>">

                        <a title="Testimonial" href="<?php echo base_url() . 'admin/testimonial' ?>">

                            Testimonial

                        </a>

                    </li>

                    

                    <li class="<?php echo ($uriString == 'faq') ? 'active' : '' ?>">

                        <a title="Attraction" href="<?php echo base_url() . 'admin/faq' ?>">

                            FAQs

                        </a>

                    </li>

                </ul>

            </li>

        </ul>



        <ul>

            <li class="">

                <a title="Tour" href="#">

                    <i class="fa fa-lg fa-fw fa-star"></i><span class="menu-item-parent">Settings</span>

                </a>

                <ul style="display: none;">





                    <li class="<?php echo ($uriString == 'store_category') ? 'active' : '' ?>">

                        <a title="Packages" href="<?php echo base_url('admin/banner') ?>">

                            Manage Slider

                        </a>

                    </li>



                </ul>

            </li>



        </ul> */?>



    </nav>

    <span class="minifyme" data-action="minifyMenu"><i class="fa fa-arrow-circle-left hit"></i></span>

</aside>

<!-- END NAVIGATION -->
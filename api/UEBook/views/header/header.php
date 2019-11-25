<?php
	$urlSegment = $this->uri->segment_array();
	if (!empty($urlSegment)) {
	    $uriString = end($urlSegment);
	}
?>
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
<style>
	.language{
	float: left;
	padding: 6px;
	width: 165px;
	position: relative;
	left: 63%;
	margin-top: 11px;
	background-color: #ededed;
	}
</style>
<div class="col-md-3 left_col">
	<div class="left_col scroll-view">
		<div class="navbar nav_title" style="border: 0;">
			<div><img src="<?=base_url()?>assets/front/images/logo.png" height="auto" width="100%"></div>
		</div>
		<br>
		<div class="clearfix"></div>
		<!-- menu profile quick info -->
		<div class="profile clearfix">
			<div class="profile_pic">
			</div>
			<div class="profile_info">
				<span><?php echo $this->lang->line('welcome'); ?>,<b> <?php echo  $this->session->userdata('admin_name'); ?>  </b></span>
			</div>
		</div>
		<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
			<div class="menu_section">
				<ul class="nav side-menu" style="">
					<li class="<?php echo ($uriString == 'dashboard') ? 'active' : '' ?>">
						<a><i class="fa fa-home"></i> <?php echo $this->lang->line('home'); ?> <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li class="<?php echo ($uriString == 'dashboard') ? 'current-page' : '' ?>"><a href="<?php echo base_url('admin/dashboard') ?>"><?php echo $this->lang->line('dashboard'); ?></a></li>
						</ul>
					</li>
					
					<li class="<?php echo ($uriString == 'users') ? 'active' : '' ?>">
						<a><i class="fa fa-edit"></i><?php echo $this->lang->line('admin'); ?><span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li class="<?php echo ($uriString == 'users' || $uriString == 'create_user' || is_numeric($uriString)) ? 'current-page' : '' ?>"><a href="<?php echo base_url('admin/users') ?>"><?php echo $this->lang->line('admin_user'); ?></a></li>
						</ul>
					</li>
				
					<li class="<?php echo ($uriString == 'product') ? 'active' : '' ?>">
						<a><i class="fa fa-edit"></i>Product<span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li class="<?php echo ($uriString == 'product' || $uriString == 'addedit' ||  $uriString == 'edit' || is_numeric($uriString)) ? 'current-page' : '' ?>"><a href="<?php echo base_url('admin/product') ?>">Product Mgmt</a></li>
							<li class="<?php echo ($uriString == 'category' || $uriString == 'add' ||  $uriString == 'edit' || is_numeric($uriString)) ? 'current-page' : '' ?>"><a href="<?php echo base_url('admin/category') ?>">Category Mgmt</a></li>
							
							<?php/*<li class="<?php echo ($uriString == 'model' || $uriString == 'addedit' ||  $uriString == 'edit' || is_numeric($uriString)) ? 'current-page' : '' ?>"><a href="<?php echo base_url('admin/model') ?>">Prod Model Mgmt</a></li> */?>
						</ul>
					</li>
					
					<li class="<?php echo ($uriString == 'chatusers') ? 'active' : '' ?>"><a><i class="fa fa-edit"></i><?php echo $this->lang->line('chatadmin_user'); ?><span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu">
						<li class="<?php echo ($uriString == 'chatusers' || $uriString == 'chatcreate_user' || is_numeric($uriString)) ? 'current-page' : '' ?>"><a href="<?php echo base_url('admin/chatusers') ?>"><?php echo $this->lang->line('chat_user'); ?></a></li>
					</ul>
					</li>
					
					
					<?php /*  <li class="<?php echo ($uriString == 'category') ? 'active' : '' ?>"><a><i class="fa fa-edit"></i>Category<span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu">
						<li class="<?php echo ($uriString == 'category' || $uriString == 'category_list' || is_numeric($uriString)) ? 'current-page' : '' ?>"><a href="<?php echo base_url('admin/category_list') ?>">Category</a></li>
					</ul>
					</li> */ ?>
					<?php /* <li class="<?php echo ($uriString == 'AdminInventory') ? 'active' : '' ?>"><a href="<?php echo base_url('admin/AdminInventory') ?>"><i class="fa fa-edit"></i>Inventory<span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu">
						<li class="<?php echo ($uriString == 'AdminInventory' || $uriString == 'AdminInventory' || is_numeric($uriString)) ? 'current-page' : '' ?>"><a href="<?php echo base_url('admin/AdminInventory') ?>">Inventory Mang</a></li>
					</ul>
					</li>*/?>
					<?php /*  <li class="<?php echo ($uriString == 'Globelrecuitment') ? 'active' : '' ?>"><a><i class="fa fa-home"></i>Globel recuitment <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu">
						<li class="<?php echo ($uriString == 'Globelrecuitment') ? 'current-page' : '' ?>"><a href="<?php echo base_url('admin/globelcompany') ?>">Company</a></li>
					</ul>
					</li> */?>
				 <li class="<?php echo ($uriString == 'frontusers') ? 'active' : '' ?>"><a><i class="fa fa-home"></i>Users <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu">
						<li class="<?php echo ($uriString == 'frontusers') ? 'current-page' : '' ?>"><a href="<?php echo base_url('admin/frontusers') ?>">Users</a></li>
					</ul>
					</li> 
				</ul>
			</div>
		</div>
		<!-- /menu footer buttons -->
		<div class="sidebar-footer hidden-small">
			<a data-toggle="tooltip" data-placement="top" title="Lock">
			<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
			</a>
			<a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo base_url('admin/auth/logout') ?>">
			<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
			</a>
		</div>
		<!-- /menu footer buttons -->
	</div>
</div>
<div class="top_nav">
	<div class="nav_menu">
		<nav>
			<div class="nav toggle">
				<a id="menu_toggle"><i class="fa fa-bars"></i></a>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<?php /* <div>
					<div><img src="<?=base_url()?>assets/front/images/logo.png" height="80" width="150">
	</div>
</div>
*/ ?>
<li class="">
<a href="#" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
Admin
</a>
<ul class="dropdown-menu dropdown-usermenu pull-right">
<li><a href="<?php echo base_url('admin/auth/logout') ?>"><i class="fa fa-sign-out pull-right"></i> <?php echo $this->lang->line('log_out'); ?></a></li>
</ul>
</li>
</ul>
</nav>
</div>
</div>
<script>
	$(document).ready(function() {
		  $('#summernote').summernote({
			  height: 300,   //set editable area's height
			  codemirror: { // codemirror options
				theme: 'monokai'
			  }
		  });
		});
</script>
<div class="container">
	<div class="row">
		<div class="col-md-4 login-sec">
			<h2 class="text-center">Login Now</h2>

			<form method="post" name="login" action="<?=base_url()?>login" class="login-form">
				<?php 
				if($this->session->flashdata('message_success')){
					echo  '<span class="success">'.$this->session->flashdata('message_success').'</span>';
				}
				if($this->session->flashdata('message_error')){
				   echo  '<span class="error">'.$this->session->flashdata('message_error').'</span>';
				}
				?>
				<div class="form-group">
				<label for="exampleInputEmail1" class="text-uppercase">Email</label>
				<input type="text" name="email_login" value="<?php if(set_value('email_login')) { echo set_value('email_login');} ?>" class="form-control" placeholder="Email" class="form-control">
				<?php echo form_error('email_login') ? '<span class="error">'.form_error('email_login').'</span>' : ''?>
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1" class="text-uppercase">Password</label>
					<input type="password" name="location_code" class="form-control" placeholder="Password">
					<?php echo form_error('location_code') ? '<span class="error">'.form_error('location_code').'</span>' : ''?>
				</div>
				<div class="form-check">
				<label class="container2">Remember Me
				<input type="checkbox" name="rem_me" checked="checked">
				<span class="checkmark"></span>
				</label>
				<button type="submit" class="btn btn-login ">Submit</button>
				<!-- <p class="text-center pointer font18 colorwhite"><a data-toggle="modal" data-target="#myModal">Request Login</a></p> -->

				<p class="text-center pointer font18 colorwhite"><a class="anchor-white" href="<?=base_url();?>welcome/register">Sign Up</a></p>
				</div>
			</form>
		</div>
		<div class="col-md-8 banner-sec">
		</div>
	</div>
</div>


<div class="modal" id="myModal">

	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header blue">
				<h4 class="modal-title colorwhite">Sign Up</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">

				<form  method="post" name="registration" action="<?=base_url()?>welcome" class="login-form">
					<div class="form-group">
						<label for="exampleInputCompany" class="text-uppercase">Company Name </label>
						<input type="text" name="company_name" class="form-control" placeholder="Company Name " value="<?php if(set_value('company_name')) { echo set_value('company_name');} ?>">
						<?php echo form_error('company_name') ? '<span class="error">'.form_error('company_name').'</span>' : ''?>
					</div>
					<div class="form-group">
						<label for="exampleInputFirstName" class="text-uppercase">First Name</label>
						<input type="text" name="first_name" value="<?php if(set_value('first_name')) { echo set_value('first_name');} ?>" class="form-control" placeholder="First Name">
						<?php echo form_error('first_name') ? '<span class="error">'.form_error('first_name').'</span>' : ''?>
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1" class="text-uppercase">Last Name</label>
						<input type="text" name="last_name" value="<?php if(set_value('last_name')) { echo set_value('last_name');} ?>" class="form-control" placeholder="Last Name">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail" class="text-uppercase">Email</label>
						<input type="email" name="email" value="<?php if(set_value('email')) { echo set_value('email');} ?>" class="form-control" placeholder="Email">
						<?php echo form_error('email') ? '<span class="error">'.form_error('email').'</span>' : ''?>
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1" class="text-uppercase">Location</label>
						<input type="password" name="location" class="form-control" placeholder="Location">
						<?php echo form_error('location') ? '<span class="error">'.form_error('location').'</span>' : ''?>
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1" class="text-uppercase">User Type</label>
						<select name="user_type" class="form-control">
							<option value="">User Type</option>
							<option value="1">Job Seeker</option>
							<option value="2">Recruiter</option>
						</select>
						<?php echo form_error('location') ? '<span class="error">'.form_error('location').'</span>' : ''?>
					</div>
					<button type="submit" class="btn btn-login ">Submit</button>

				</form>

			</div>
		</div>
	</div>
</div>


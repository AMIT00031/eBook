<?php  ?>
<div class="container">
	<div class="row">
		<div class="col-md-4 login-sec">
			<h2 class="text-center">Sign Up Now</h2>

			<form  method="post" name="registration" action="" class="login-form">
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
						<label for="exampleInputLastName" class="text-uppercase">Last Name</label>
						<input type="text" name="last_name" value="<?php if(set_value('last_name')) { echo set_value('last_name');} ?>" class="form-control" placeholder="Last Name">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail" class="text-uppercase">Email</label>
						<input type="email" name="email" value="<?php if(set_value('email')) { echo set_value('email');} ?>" class="form-control" placeholder="Email">
						<?php echo form_error('email') ? '<span class="error">'.form_error('email').'</span>' : ''?>
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1" class="text-uppercase">Password</label>
						<input type="password" name="password" class="form-control" placeholder="Password">
						<?php echo form_error('password') ? '<span class="error">'.form_error('password').'</span>' : ''?>
					</div>
					<div class="form-group">
						<label for="exampleInputLocation" class="text-uppercase">Location</label>
						<input type="text" name="location" class="form-control" placeholder="Location">
						<?php echo form_error('location') ? '<span class="error">'.form_error('location').'</span>' : ''?>
					</div>
					<div class="form-group">
						<label for="exampleInputUserType" class="text-uppercase">User Type</label>
						<select name="user_type" class="form-control">
							<option value="">User Type</option>
							<option value="1">Job Seeker</option>
							<option value="2">Recruiter</option>
						</select>
						<?php echo form_error('user_type') ? '<span class="error">'.form_error('user_type').'</span>' : ''?>
					</div>
					<button type="submit" class="btn btn-login ">Submit</button>

					<p class="text-center pointer font18 colorwhite">Already Registered? <a class="anchor-white" href="<?=base_url();?>welcome/login">Please Login </a></p>
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
<h4 class="modal-title colorwhite">Request Login</h4>
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
<button type="submit" class="btn btn-login ">Submit</button>

</form>

</div>
</div>
</div>
</div>


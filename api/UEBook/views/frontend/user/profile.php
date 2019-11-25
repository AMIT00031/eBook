<?php 
	if($this->session->flashdata('message_success')){
		echo  '<div class="msg_success">'.$this->session->flashdata('message_success').'</div>';
	}
	if($this->session->flashdata('message_error')){
	   echo  '<div class="msg_error">'.$this->session->flashdata('message_error').'</div>';
	}
	if($message_success){
		echo  '<div class="msg_success">'.$message_success.'</div>';
	}
	if($mssage_error){
	   echo  '<div class="msg_error">'.$mssage_error.'</div>';
	}
?>

<div class="logo">  <h1>User Profile</h1> </div>


<!--     <a class="logg" href="<?php base_url()?>welcome/logout">Logout</a> -->
<div class="container">
	<div class="row">
	    <div class="col-md-4"></div>
		<div class="col-md-4 login-sec">
            <div class="row-fluid user-infos cyruxx">
                <div class="span10 offset1">
                    <div class="panel panel-primary">
                        
                        <div class="panel-body">
                            <div class="row-fluid">
                                <div class="span3">
                                    <?php // print_r($userprofi); ?>
                                    <?php   if(!empty(trim($userprofi->profilephoto))){     ?>
                                        <img class="img-circle" src="<?php echo base_url();?>uploads/img/<?php echo $userprofi->profilephoto;?>" alt="User Pic">
                                    <?php }else{ ?>
                                        <img class="img-circle" src="<?php echo base_url();?>uploads/img/user-admin.png" alt="User Pic">
                                    <?php } ?>
                                    <?php   if(!empty(trim($userprofi->resume))){     ?>
                                        <a href="<?php echo base_url();?>/uploads/resume/<?php echo $userprofi->resume;?>" target="_blank" alt="View Resume" class="v_resume">View Resume</a>
                                    <?php } ?>
                                </div>
                                <div class="span6">
                                    <strong>Personal Details:</strong><br>
                                    <table class="table table-condensed table-responsive table-user-information">
                                        <tbody>
                                        <tr>
                                            <td>User Name:</td>
                                            <td><?php echo $userprofi->username; ?></td>
                                        </tr>
                                        <tr>
                                            <td>User Email:</td>
                                            <td><?php echo $userprofi->email; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Phone Number</td>
                                            <td><?php echo $userprofi->phone; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Company Name</td>
                                            <td><?php echo $userprofi->company_name; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                                <!-- <button class="btn  btn-primary" type="button"
                                        data-toggle="tooltip"
                                        data-original-title="Send message to user"><i class="fa fa-envelope icon-white"></i></button> -->
                            <span class="pull-right">
                                    <a class="btn btn-warning" type="button" href="<?=base_url('userprofile/edit');?>"
                                            data-toggle="tooltip"
                                            data-original-title="Edit this user"><i class="fa fa-edit icon-white"></i></a>
                            </span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
</div>
<div class="col-md-4"></div>

        
        
</div>
</div>



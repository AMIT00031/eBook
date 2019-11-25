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
<div class="logo">  <h1>Global Recruitment</h1> </div>
<div class="container">
	<h3 class="text-center">Search for job</h3>
	<form name="filterData" id="filterData">
		<div class="row">
			<div class="col-md-4 login-sec">
				<h3 class="text-center">Company Type</h3>
				<div class="form-group">
					<div class="slectDrop">
				    	<select name="selectcompany"  id="selectcompany"  class="form-control" required>
							<option value=""> Select Company Type</option>
							<?php  	foreach ($selectcompanyList as $key => $value) { $sel = ($_GET['selectcompany'] == $value->clasifiedcompany_id ) ?'selected':'';?>
								<option value="<?=$value->clasifiedcompany_id?>" <?=$sel;?>><?=$value->clasifiedcompany_name?></option>
							<?php 	}	 ?>
						</select>
					</div>
				</div>
	   		</div>
	    	<div class="col-md-4 login-sec">
	    		<h3 class="text-center">Region</h3>
	    		<div class="form-group">
					<div class="slectDrop">
			    		<select name="selectregion" id="selectregion"  class="form-control" required>
							<option value=""> Select Region</option>
							<?php  	foreach ($selectregionList as $key => $value) { $sel = ($_GET['selectregion'] == $value->clasifiedregion_id ) ?'selected':'';?>
								<option value="<?=$value->clasifiedregion_id?>" <?=$sel;?>><?=$value->clasifiedregion_name?></option>
							<?php 	}	 ?>
						</select>
					</div>
				</div>
		    </div>
	    	<div class="col-md-4 login-sec">
	    		<h3 class="text-center">Job Type</h3>
	    		<div class="form-group">
					<div class="slectDrop">
				    	<select name="jobtype" id="jobtype" class="form-control" required>
							<option value=""> Select Job Type</option>
							<?php  	foreach ($jobtypeList as $key => $value) { $sel = ($_GET['jobtype'] == $value->clasifiedjobs_id ) ?'selected':''; ?>
								<option value="<?=$value->clasifiedjobs_id?>" <?=$sel;?>><?=$value->clasifiedjobs_name?></option>
							<?php 	}	 ?>
						</select>
					</div>
				</div>
	   		</div>
   		</div>
	</form>
	<div class="row">
    	<?php  //echo "<pre>"; print_r($joblist); ?>
	    <?php  	//var_dump($joblist[0]); ?>
	    <?php //var_dump($this->session->userdata('userId'))?>
	    	
	    <?php 	$i = 0; ?>
	    <?php 	foreach($joblist as $jobs){ ?>
	    	<?php 	if(!empty($this->session->userdata('userId')) && $this->session->userdata('userType') == 2) { ?>
	    		<?php 	if($this->session->userdata('userId') == $jobs->userid) { ?>
	    			<?php 	if($i%3 == 0){ echo '<br/><div class="clearfix"></div>';}$i++;?>
				    	<div class="col-sm-4">
							<div class="job_post">
								<h3><a href="#"><i class="fa fa-briefcase"></i> <?php echo $jobs->jobtechnicaltitleval;?></a></h3>
								<div class="col-xs-6 col-sm-12 padd">
									<i class="fa fa-map-marker"></i> &nbsp;<?php echo $jobs->region;?>
								</div>
								
								<div class="col-xs-6 col-sm-12 padd">
									<i class="fa fa-clock-o"></i> <?php echo $jobs->created_at;?>
								</div>
								<div class="clearfix"></div>
								<hr>
								<div class="detail">
									<p>Company Type : <span> <?php echo $jobs->companyname;?></span></p>
									<p>Job Type : <span> <?php echo $jobs->jobtypes;?></span></p>
									<p>Job Sub Type : <span> <?php echo $jobs->subjobtype;?></span></p>
									<p>Posted By : <span> <?php echo $jobs->username;?></span></p>
									<p>Total Applied : <span> <?php echo $jobs->appliedstatus;?></span></p>
								</div>
								<div class="clearfix"></div>
								<hr>
								<div class="row">
									<?php if($this->session->userdata('userType') != 2){ ?>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<?php 	if($jobs->status == 1 && !empty($this->session->userdata('userId'))){ ?>
													<a class="btn btn-success apply hvr-icon-wobble-horizontal" onclick="applyJob(<?php echo $jobs->id;?>,<?php echo $this->session->userdata('userId')?>)">Applied <i class="fa fa-arrow-right hvr-icon"></i></a>
											<?php 	} else{?>
											<a class="btn btn-success apply hvr-icon-wobble-horizontal" onclick="applyJob(<?php echo $jobs->id;?>,<?php echo $this->session->userdata('userId')?>)">Apply <i class="fa fa-arrow-right hvr-icon"></i></a>
											<?php 	}?>
										</div>
									<?php 	}	?>
										
									<div class="col-md-6 col-sm-6 col-xs-6">
										<a href="<?php echo base_url().'global-recruitment-job/'.$jobs->id ?>" class="btn btn-info apply hvr-icon-wobble-horizontal" data-record-id="<?php echo $jobs->id ?>" data-record-title="<?php echo $jobs->title ?>" >View Details <i class="fa fa-arrow-right hvr-icon"></i></a>
										<!-- <a href="" class="btn btn-info apply hvr-icon-wobble-horizontal" data-record-id="<?php echo $jobs->id ?>" data-record-title="<?php echo $jobs->title ?>" data-toggle="modal" data-target="#confirm-delete<?php echo $jobs->id ?>">View Details <i class="fa fa-arrow-right hvr-icon"></i></a> -->
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
	        	<?php 	} ?>
    		<?php 	}else { ?>
    		<?php 	if($i%3 == 0){ echo '<br/><div class="clearfix"></div>';}$i++;?>
	    	<div class="col-sm-4">
				<div class="job_post">
					<h3><a href="#"><i class="fa fa-briefcase"></i> <?php echo $jobs->jobtechnicaltitleval;?></a></h3>
					<div class="col-xs-6 col-sm-12 padd">
						<i class="fa fa-map-marker"></i> &nbsp; <?php echo $jobs->region;?>
					</div>
					
					<div class="col-xs-6 col-sm-12 padd">
						<i class="fa fa-clock-o"></i> <?php echo $jobs->created_at;?>
					</div>
					<div class="clearfix"></div>
					<hr>
					<div class="detail">
						<p>Company Type : <span> <?php echo $jobs->companyname;?></span></p>
						<p>Job Type : <span> <?php echo $jobs->jobtypes;?></span></p>
						<p>Job Sub Type : <span> <?php echo $jobs->subjobtype;?></span></p>
						<p>Posted By : <span> <?php echo $jobs->username;?></span></p>
						<p>Total Applied : <span> <?php echo $jobs->appliedstatus;?></span></p>
					</div>
					<div class="clearfix"></div>
					<hr>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<?php 	if($jobs->appliedstatus == 1 && !empty($this->session->userdata('userId'))){ ?>
									<a class="btn btn-success apply hvr-icon-wobble-horizontal" onclick="applyJob(<?php echo $jobs->id;?>,<?php echo $this->session->userdata('userId')?>)">Applied <i class="fa fa-arrow-right hvr-icon"></i></a>
							<?php 	} else{?>
								<a class="btn btn-success apply hvr-icon-wobble-horizontal" onclick="applyJob(<?php echo $jobs->id;?>,<?php echo $this->session->userdata('userId')?>)">Apply <i class="fa fa-arrow-right hvr-icon"></i></a>
							<?php 	}?>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<a href="<?php echo base_url().'global-recruitment-job/'.$jobs->id ?>" class="btn btn-info apply hvr-icon-wobble-horizontal" data-record-id="<?php echo $jobs->id ?>" data-record-title="<?php echo $jobs->title ?>" >View Details <i class="fa fa-arrow-right hvr-icon"></i></a>
							<!-- <a href="" class="btn btn-info apply hvr-icon-wobble-horizontal" data-record-id="<?php echo $jobs->id ?>" data-record-title="<?php echo $jobs->title ?>" data-toggle="modal" data-target="#confirm-delete<?php echo $jobs->id ?>">View Details <i class="fa fa-arrow-right hvr-icon"></i></a> -->
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
	    	<?php 	} ?>
    	<?php  	} ?>
  	</div>
</div>

<script type="text/javascript">
	$( "#jobtype" ).change(function() {
	  	document.getElementById('filterData').submit();
	});
	$( "#selectcompany" ).change(function() {
	  	document.getElementById('filterData').submit();
	});
	$( "#selectregion" ).change(function() {
	  	document.getElementById('filterData').submit();
	});
	function applyJob(job_id,user_id){
		var base_url = "<?php echo base_url(); ?>";	
    
		$.ajax({
            //url: base_url + 'frontend/joblist/jobs_applybyclient',
            url: base_url + 'api/jobs/jobs_apply',
            type: "POST",
            data: {user_id: user_id,job_id:job_id},
            success: function (data) {
            	console.log(data);
                if (data.status == 1) {
					alert(data.message);
                    location.reload();
                }else {
                	alert(data.message);
                }
            }
        })
	}
		
</script>



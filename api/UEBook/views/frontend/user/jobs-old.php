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
<?php //var_dump($this->session->userdata());?>
<div class="logo">  <h1>Global Recruitment</h1> </div>
<style>
.dropbtn {  color: white;  padding: 16px;  font-size: 16px;  border: none;  cursor: pointer;}
.dropdown {  position: relative;  display: inline-block;}
.dropdown-content {  display: none;  position: absolute;  right: 0;  background-color: #f9f9f9;  min-width: 160px;  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);  z-index: 1;}
.dropdown-content a {  color: black;  padding: 12px 16px;  text-decoration: none;  display: block;}
.dropdown-content a:hover {background-color: #f1f1f1;}
.dropdown:hover .dropdown-content {  display: block;}
</style>
<?php  if($this->session->userdata('userId')){?>
<div class="dropdown logg" style="float:right;">
		<a class="dropbtn">Menu</a>
		<div class="dropdown-content">
			<a href="<?=base_url()?>global-recruitment-joblist">Global Recruitment</a>
			<a href="<?php base_url()?>userprofile/edit">Profile</a>
			<a href="<?php base_url()?>welcome/logout">Logout</a>
	  </div>
</div>
<?php  }else{ ?>
	<a class="logg" href="<?php base_url()?>welcome/loginjob">Login</a>
<?php  } ?>
<div class="container">
    <div class="row">
    <?php  //echo "<pre>"; print_r($joblist); ?>

    <?php  //var_dump($this->session->userdata('userId')); ?>
    <?php foreach($joblist as $jobs){ ?>
        <div class="col-sm-12">
        	<div class="job-list">
                    <div class="col-sm-1 padd">
                      	<a href="#">
                        	<img src="<?=base_url()?>assets/front/images/default.png" class="img-responsive compny">
                      	</a>
                    </div>
                    <div class="col-sm-9">
                      	<div class="content_res">
                        	<h4><a href="#"><?php echo $jobs->jobtechnicaltitleval;?></a></h4>
						 	<p class="deadline">Date:<?php echo $jobs->created_at;?></p>
                        </div>
						
						<div class="info">
							<ul>
							<li><i class="fa fa-briefcase"></i> <?php echo $jobs->companyname;?></li>
							<li><i class="fa fa-map-marker"></i> <?php echo $jobs->jobtypes;?></li>
							<li><i class="fa fa-clock-o"></i> <?php echo $jobs->subjobtype;?></li>
							<li><i class="fa fa-map-marker"></i> <?php echo $jobs->region;?></li>
							</ul>
						</div>
					</div>
					  
                    <div class="col-sm-2 text-center">
                        <div class="buttons">
                          	<!-- <p><a href="#" class="bk btn btn-success">Apply Now</a></p>
                          	<p><a href="#" class="bk btn btn-success">View Details</a></p> -->
                          	<p><a class="btn btn-success" onclick="applyJob(<?php echo $jobs->id;?>,<?php echo $this->session->userdata('userId')?>)">Apply Now</a></p>       
							<p><a href="" class="btn btn-success" data-record-id="<?php echo $jobs->id ?>" data-record-title="<?php echo $jobs->title ?>" data-toggle="modal" data-target="#confirm-delete<?php echo $jobs->id ?>">View Details</a></p>
                        </div>
                    </div>
                <div class="clearfix"></div>   
        	</div>
        </div>
        
		<div class="modal fade" id="confirm-delete<?php echo $jobs->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $jobs->id ?>" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h4 class="modal-title content_res" id="myModalLabel<?php echo $jobs->id ?>"><?php echo $jobs->jobtechnicaltitleval;?></h4>
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
		            </div>
		            <div class="modal-body">
		            	<div class="padd">
	                      		<img src="<?=base_url()?>assets/front/images/default.png" class="img-responsive compny">
	                    </div>
	                    <br/>
	                    <div>
		                    <p><b><i class="fa fa-briefcase"></i></b> <?php echo $jobs->companyname;?></p>
			                <p><b><i class="fa fa-map-marker"></i></b> <?php echo $jobs->jobtypes;?></p>
			                <p><b><i class="fa fa-clock-o"></i></b> <?php echo $jobs->subjobtype;?></p>
			                <p><b><i class="fa fa-map-marker"></i></b> <?php echo $jobs->region;?></p>
			                <p class="deadline">Date:<?php echo $jobs->created_at;?></p>
			            </div>
		            </div>
		        </div>
		    </div>
		</div>
  	<?php  } ?>
  	</div>
</div>

<script type="text/javascript">
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



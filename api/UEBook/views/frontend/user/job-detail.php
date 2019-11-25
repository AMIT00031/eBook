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
</style>

<?php   if($this->session->userdata('userType') == 2) { ?>
          <?php   if($this->session->userdata('userId') != $jobs->userid) { ?>

          <?php redirect(base_url('global-recruitment-joblist'));  } ?>
<?php   } ?>
<div class="container padd">
  <div class="jobs">
    <div class="col-sm-12">
      <div class="job_post">
        <h3><a href="#"><i class="fa fa-briefcase"></i> <?php echo $jobs->jobtechnicaltitleval;?></a></h3>
      
        <div class="col-xs-6 col-sm-12 padd countt">
            <i class="fa fa-map-marker"></i> &nbsp;<?php echo $jobs->region;?>
        </div>
         <div class="col-xs-6 col-sm-12 padd m5">
          <i class="fa fa-clock-o"></i> <?php echo $jobs->created_at;?>
         </div>
        <div class="clearfix"></div>
        <hr>
        <div class="detail">
          <p>Company Type : <span> <?php echo $jobs->companyname;?></span></p>
          <p>Job Type : <span> <?php echo $jobs->jobtypes;?></span></p>
          <p>Job Sub Type : <span> <?php echo $jobs->subjobtype;?></span></p>
          <p>Posted By : <span> <?php echo $jobs->username;?></span></p>
          <p class="m20"><b>Job Description</b></p>
          <p><?php echo $jobs->description;?></p>
          <p>Total Applied : <span> <?php echo $jobs->appliedstatus;?></span></p>
        </div>
        <div class="clearfix"></div>
        
        <hr>
        
        <div class="col-xs-6 col-sm-6">
          <?php   if($jobs->appliedstatus == 1 && !empty($this->session->userdata('userId'))){?>
              <?php if($this->session->userdata('userType') != 2){ ?>
                <a class="btn btn-success apply hvr-icon-wobble-horizontal" onclick="applyJob(<?php echo $jobs->id;?>,<?php echo $this->session->userdata('userId')?>)">Applied <i class="fa fa-arrow-right hvr-icon"></i></a>
              <?php } ?>
          <?php   } else{?>
            <a class="btn btn-success apply hvr-icon-wobble-horizontal" onclick="applyJob(<?php echo $jobs->id;?>,<?php echo $this->session->userdata('userId')?>)">Apply <i class="fa fa-arrow-right hvr-icon"></i></a>
          <?php   }?>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
    <div class="clearfix"></div>
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
                  window.location.href=base_url+"/global-recruitment-joblist";
                }else {
                	alert(data.message);
                }
            }
        })
	}
</script>
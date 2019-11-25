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
<div class="logo">  <h1><?=$title?></h1> </div>
<style>
</style>
<div class="container padd">
  <div class="jobs">
    <div class="col-sm-12">
      <div class="job_post">
        <div class="detail">
          <?php   $img = 'default.png';if(!empty($jobs->image)){$img = $jobs->image;}?>
          <div class="col-md-3">
            <div style="height:200px"><img src="<?php echo base_url('uploads/inventory/'.$img);?>" style="height:100%;width:100%;" class="img-responsive"></div>
          </div>
          <div class="col-md-12">
          <p><span><?php echo $jobs->title;?></span></p>
          <p>Type : <span> <?php if($jobs->inv_type == 1){echo 'Private';}else if($jobs->inv_type == 2){echo "Professional";}?></span></p>
          <p>Price : <span> <?php echo $jobs->price;?></span></p>
          <p>Posted At : <i class="fa fa-clock-o"></i> <span> <?php echo $jobs->created_at;?></span></p>
          <p>Location : <i class="fa fa-map-marker"></i> <span> <?php echo $jobs->country_code;?>,<?php echo $jobs->city_id;?></span></p>
          <p>Mail To: <span><a href="mailto:<?=$jobs->seller_email?>" target="_top"><?=$jobs->seller_email?></a></span></p>
          <p>Phone: <span><a href="tel:<?=$jobs->seller_phone?>"><?=$jobs->seller_phone?></a></span></p>
          <p>Tag: <?php echo $jobs->tags;?></p>
          <p>Description:</p>
          <p><?=$jobs->description;?></p>
          </div>
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
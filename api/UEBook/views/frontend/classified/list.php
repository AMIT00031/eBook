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

<div class="container">
	<div class="row">
    	<?php  //echo "<pre>"; print_r($joblist); ?>
	    <?php  	//var_dump($list); ?>
	    <?php //var_dump($this->session->userdata('userId'))?>
	    	
	    <?php 	$i = 0; ?>
	    <?php 	foreach($oilclassfied as $jobs){ ?>
	    			<?php 	if($i%3 == 0){ echo '<br/><div class="clearfix"></div>';}$i++;?>
				    	<div class="col-sm-3">
							<div class="job_post">
								<div class="detail">
									<?php 	$img = 'default.png';if(!empty($jobs->image)){$img = $jobs->image;}?>
									<div style="height:200px"><a href="<?php echo base_url().'classified-list/'.$jobs->id ?>"><img src="<?php echo base_url('uploads/inventory/'.$img);?>" style="height:100%;width:100%;" class="img-responsive"></a></div>
									<p class="text-center"><span><a href="<?php echo base_url().'classified-list/'.$jobs->id ?>"><?php echo $jobs->name;?></a></span></p>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
	        	<?php 	} ?>
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
            //url: base_url + 'frontend/list/jobs_applybyclient',
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



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
<?php //var_dump($oilclassfied[0]);?>
<div class="logo">  <h1><?=$title?> | <?=$oilclassfied[0]['category_name']?></h1> </div>
<style type="text/css">
	.nav-pills li a{
		padding: 10px!important;
		    margin-right: 1px;
	}
	
</style>
<div class="container">
	<ul class="nav nav-pills">
	    <li class="active"><a data-toggle="pill" href="#home">All</a></li>
	    <li><a data-toggle="pill" href="#menu1">Private</a></li>
	    <li><a data-toggle="pill" href="#menu2">Professional</a></li>
	</ul>
  
  	<div class="tab-content">
	    <div id="home" class="tab-pane fade active show">
	      	<div class="row">
	      	<?php 	$i = 0; ?>
			    <?php 	foreach($oilclassfied as $jobs){ ?>
					<?php 	if($i%3 == 0){ echo '<br/><div class="clearfix"></div>';}$i++;?>
				    	<div class="col-sm-3">
							<div class="job_post">
								<div class="detail">
									<?php 	$img = 'default.png';if(!empty($jobs['images'])){$img = $jobs['images'];}?>
									<div style="height:200px"><a href="<?php echo base_url().'classified-list-detail/'.$jobs['id'] ?>"><img src="<?php echo base_url('uploads/classified/'.$img);?>" style="height:100%;width:100%;" class="img-responsive"></a></div>
									<p class="text-center"><span><a href="<?php echo base_url().'classified-list-detail/'.$jobs['id'] ?>"><?php echo $jobs['title'];?></a></span></p>
									<p>Type : <span> <?php echo $jobs['post_type_id'];?></span></p>
									<p>Price : <span> <?php echo $jobs['price'];?></span></p>
									<p>Location : <span> <?php echo $jobs['city_name'];?></span></p>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
		    	<?php 	} ?>
		    </div>
	    </div>
	    <div id="menu1" class="tab-pane fade">
	      	<div class="row">
	      	<?php 	$i = 0; ?>
			    <?php 	foreach($oilclassfied as $jobs){ ?>
			    	<?php if(strtoupper($jobs['post_type_id']) == 'PRIVATE'){	?>
						<?php 	if($i%3 == 0){ echo '<br/><div class="clearfix"></div>';}$i++;?>
				    	<div class="col-sm-3">
							<div class="job_post">
								<div class="detail">
									<?php 	$img = 'default.png';if(!empty($jobs['images'])){$img = $jobs['images'];}?>
									<div style="height:200px"><a href="<?php echo base_url().'classified-list-detail/'.$jobs['id'] ?>"><img src="<?php echo base_url('uploads/classified/'.$img);?>" style="height:100%;width:100%;" class="img-responsive"></a></div>
									<p class="text-center"><span><a href="<?php echo base_url().'classified-list-detail/'.$jobs['id'] ?>"><?php echo $jobs['title'];?></a></span></p>
									<p>Type : <span> <?php echo $jobs['post_type_id'];?></span></p>
									<p>Price : <span> <?php echo $jobs['price'];?></span></p>
									<p>Location : <span> <?php echo $jobs['city_name'];?></span></p>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
			    	<?php 	} ?>
		    	<?php 	} ?>
		    </div>
	    </div>
	    <div id="menu2" class="tab-pane fade">
	      	<div class="row">
	      	<?php 	$i = 0; ?>
			    <?php 	foreach($oilclassfied as $jobs){ ?>
			    	<?php if(strtoupper($jobs['post_type_id']) == 'PROFESSIONAL'){	?>
						<?php 	if($i%3 == 0){ echo '<br/><div class="clearfix"></div>';}$i++;?>
				    	<div class="col-sm-3">
							<div class="job_post">
								<div class="detail">
									<?php 	$img = 'default.png';if(!empty($jobs['images'])){$img = $jobs['images'];}?>
									<div style="height:200px"><a href="<?php echo base_url().'classified-list-detail/'.$jobs['id'] ?>"><img src="<?php echo base_url('uploads/classified/'.$img);?>" style="height:100%;width:100%;" class="img-responsive"></a></div>
									<p class="text-center"><span><a href="<?php echo base_url().'classified-list-detail/'.$jobs['id'] ?>"><?php echo $jobs['title'];?></a></span></p>
									<p>Type : <span> <?php echo $jobs['post_type_id'];?></span></p>
									<p>Price : <span> <?php echo $jobs['price'];?></span></p>
									<p>Location : <span> <?php echo $jobs['city_name'];?></span></p>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
			    	<?php 	} ?>
		    	<?php 	} ?>
		    </div>
	    </div>
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



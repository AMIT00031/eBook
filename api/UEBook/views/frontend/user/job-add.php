<div class="logo">  <h1>Post Your Job</h1> </div>

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

<div class="container">
	<div class="row">
	    <div class="col-md-12 col-sm-12 col-xs-12">
	        <div class="col-md-12">
	            <?php //print_r($selectcompanyList);   ?>
				<?php //print_r($selectregionList);   ?>
				<?php //print_r($jobtypeList);   ?>
				<?php /* foreach($userprofi as $userprofi){
					$userprofi =$userprofi;
				 } */ ?>
	            <div class="x_content">
	                <br>
	                <form class="form-horizontal form-label-left"   data-parsley-validate=""  method="post" enctype="multipart/form-data" action="<?php echo current_url() ?>">
	                    
						<div class="form-group1">
							<div class="col-sm-2"><label class="control-label">Company Type *</label></div>
							<div class="col-sm-10">
								<select name="selectcompany"  class="form-control" required>
									<option> Select Company Type</option>
									<?php  	foreach ($selectcompanyList as $key => $value) { ?>
										<option value="<?=$value->clasifiedcompany_id?>"><?=$value->clasifiedcompany_name?></option>
									<?php 	}	 ?>
								</select>
							</div>
							<div class="col-sm-2"><label class="control-label">Region *</label></div>
							<div class="col-sm-10">
								<select name="selectregion"  class="form-control" required>
									<option> Select Region</option>
									<?php  	foreach ($selectregionList as $key => $value) { ?>
										<option value="<?=$value->clasifiedregion_id?>"><?=$value->clasifiedregion_name?></option>
									<?php 	}	 ?>
								</select>
							</div>

							<div class="col-sm-2"><label class="control-label">Job Type *</label></div>
							<div class="col-sm-10">
								<select name="jobtype" id="jobtype" class="form-control" required>
									<option> Select Job Type</option>
									<?php  	foreach ($jobtypeList as $key => $value) { ?>
										<option value="<?=$value->clasifiedjobs_id?>"><?=$value->clasifiedjobs_name?></option>
									<?php 	}	 ?>
								</select>
							</div>
							<div class="col-sm-2"><label class="control-label">Job Sub Type *</label></div>
							<div class="col-sm-10">
								<select name="jobsubtype" id="jobsubtype"  class="form-control" required>
									<option> Select Job Sub Type</option>
								</select>
							</div>
							<div class="col-sm-2"><label class="control-label">Technical Title *</label></div>
							<div class="col-sm-10">
								<select name="jobtechnicaltitle" id="jobtechnicaltitle"  class="form-control" required>
									<option> Select Technical Title</option>
								</select>
							</div>
							<div class="col-sm-2"><label class="control-label">Description</label></div>
							<div class="col-sm-10"><textarea  name="description" required="required" class="form-control" placeholder="Description"><?php if(set_value('last_name')) { echo set_value('last_name');} else { echo $userprofi->last_name; } ?></textarea>
							</div>
							
								<!-- <div class="form-group">
									<div class="col-sm-2"><label class="control-label">Profile Images</label></div>		
									<div class="col-sm-10">
										<?php if(!empty($userprofi->profilephoto)){ ?>
											<div class="col-md-2">
												<br/>
												<div class="row">
													<img src="<?php echo base_url().'uploads/img/'.$userprofi->profilephoto;?>" style="width:100%">
												</div>
												<br/>
											</div>
											<div class="clearfix"></div>
										<?php } ?>
										<div class="flexdiv">
										<label class="btn btn-primary mt-20"> Browse&hellip; <input type="file" name="profilephoto" multiple style="display: none;">
										</label>
										</div>
									<br>
									</div>
								</div> -->
						</div>
						


	                    <div class="ln_solid"></div>
	                    <div class="clearfix"></div>
	                    <div class="col-md-12">&nbsp;</div>
	                    <div class="form-group">
	                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
	                            <button type="submit" class="btn btn-success" name="submit">Submit</button>
	                        </div>
	                    </div>
					

	                </form>
					
					
	            </div>
	        </div>
	    </div>
	</div>

</div>

<script>
	
	$( "#jobtype" ).change(function() {
	  	var catid = $('#jobtype').val();
	  	var url= '<?php echo base_url()?>api/Globelrecuitment/clasifiedsubcat';
		$.ajax({  
			type: 'POST',  
			url: url, 
			data: { catid: catid },
			success: function(response) {
				console.log(response);
				//response = $.parseJSON(response);
				console.log(response);
				//alert(response);
				if(response.status=="1"){
				console.log(response.result.length);
					option = '<option value=""> Select Job Sub Type</option>';
				  	for (var i = 0; i < response.result.length; i++) {
						option += '<option value="'+response.result[i].clasifiedjobs_id+'">'+response.result[i].clasifiedjobs_name+'</option>';
				  	}
					$("#jobsubtype").html(option);
				}else{
					$("#jobsubtype").html('<option value=""> Select Job Sub Type</option>');
				}
				
			}
		});
	});
		$( "#jobsubtype" ).change(function() {
	  	var catid = $('#jobsubtype').val();
	  	var url= '<?php echo base_url()?>api/Globelrecuitment/clasifiedsubcat';
		$.ajax({  
			type: 'POST',  
			url: url, 
			data: { catid: catid },
			success: function(response) {
				console.log(response);
				//response = $.parseJSON(response);
				console.log(response);
				//alert(response);
				if(response.status=="1"){
				console.log(response.result.length);
					option = '<option value=""> Select Technical Title</option>';
				  	for (var i = 0; i < response.result.length; i++) {
						option += '<option value="'+response.result[i].clasifiedjobs_id+'">'+response.result[i].clasifiedjobs_name+'</option>';
				  	}
					$("#jobtechnicaltitle").html(option);
				}else{
					$("#jobtechnicaltitle").html('<option value=""> Select Technical Title</option>');
				}
				
			}
		});
	});

	function get_currency(country_currency_code){
		
		var url= '<?php echo base_url()?>admin/AdminInventory/get_currency_by_ajax';
		$.ajax({  
			type: 'POST',  
			url: url, 
			data: { country_currency_code: country_currency_code },
			success: function(data) {
				
				if(data=="No"){
				  	$("#currency_id").html('د.إ');
				  	$("#currency_id_input").val('د.إ');
				}else{
					var str_currency		= 	data.split(",");
					
					if( str_currency[0] !='' ){
						$("#currency_id").html(str_currency[0]);
						$("#currency_id_input").val(str_currency[0]);
						
					}else{
						$("#currency_id").html('د.إ');
						$("#currency_id_input").val('د.إ');
					}
					
				}
				
			}
		});
	}
	
	</script>
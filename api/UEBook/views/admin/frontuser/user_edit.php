<style>
.disp {
    width: 100%;
    height: 148px;
}
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit User</h2>
                <div class="clearfix"></div>
            </div>
			<?php //print_r($inv_detail);   ?>
			<?php /* foreach($inv_detail as $inv_detail){
				$inv_detail =$inv_detail;
			 } */ ?>
            <div class="x_content">
                <br>
                <form class="form-horizontal form-label-left"   data-parsley-validate=""  method="post" enctype="multipart/form-data" action="<?php echo current_url() ?>">
                    
					<div class="form-group">
					
							<div class="col-sm-2"><label class="control-label">First Name *</label></div>
							<div class="col-sm-10"><input type="text" name="user_name" value="<?php if(set_value('user_name')) { echo set_value('user_name');} else { echo $inv_detail->user_name; } ?>" required="required" class="form-control" placeholder="First Name" required>
							</div>
							<div class="col-sm-2"><label class="control-label">last Name *</label></div>
							<div class="col-sm-10"><input type="text" name="lastname" value="<?php if(set_value('lastname')) { echo set_value('lastname');} else { echo $inv_detail->lastname; } ?>" required="required" class="form-control" placeholder="last name">
							</div>
							<div class="col-sm-2"><label class="control-label">Password *</label></div>
							<div class="col-sm-10"><input type="password" name="password" value="<?php if(set_value('password')) { echo set_value('password');} else { echo base64_decode($inv_detail->password); } ?>" required="required" class="form-control" placeholder="*******">
							</div>
							<div class="col-sm-2"><label class="control-label">Location *</label></div>
							<div class="col-sm-10"><input type="text" name="country" value="<?php if(set_value('country')) { echo set_value('country');} else { echo $inv_detail->country; } ?>" required="required" class="form-control" placeholder="location">
							</div>
							<div class="col-sm-2"><label class="control-label">Email *</label></div>
							<div class="col-sm-10"><input type="text" name="email" value="<?php if(set_value('email')) { echo set_value('email');} else { echo $inv_detail->email; } ?>" required="required" class="form-control" placeholder="email">
							</div>
							<div class="col-sm-2"><label class="control-label">Phone *</label></div>
							<div class="col-sm-10"><input type="text" name="phone_no" value="<?php if(set_value('phone_no')) { echo set_value('phone_no');} else { echo $inv_detail->phone_no; } ?>" required="required" class="form-control" placeholder="phone">
							</div>
							<div class="col-sm-2"><label class="control-label">Company *</label></div>
							<div class="col-sm-10"><input type="text" name="company_name" value="<?php if(set_value('company_name')) { echo set_value('company_name');} else { echo $inv_detail->company_name; } ?>" required="required" class="form-control" placeholder="company">
							</div>
							<div class="form-group">
								<div class="col-sm-2"><label class="control-label">Profile Images</label></div>		
								<div class="col-sm-10">
									<?php if(!empty($inv_detail->profilephoto)){ ?>
										<div class="col-md-2">
											<br/>
											<div class="row">
												<img src="<?php echo base_url().'uploads/img/'.$inv_detail->url;?>" style="width:100%">
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
							</div>
							<div class="form-group">
								<div class="col-sm-2"><label class="control-label">Resume</label></div>		
								<div class="col-sm-10">
									<?php if(!empty($inv_detail->resume)){ ?>
										<div class="row">
											<a href="<?php echo base_url().'uploads/resume/'.$inv_detail->resume;?>"><?=$inv_detail->resume;?></a>
										</div>
										<div class="clearfix"></div>
									<?php } ?>
									<?php /*<div class="flexdiv">
									<label class="btn btn-primary mt-20"> Browse&hellip; <input type="file" name="resume" multiple style="display: none;">
											</label>
									</div>*/?>
								<br>
								</div>
							</div>
					</div>
					


                    <div class="ln_solid"></div>
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

<script>
	function get_city(city_val){  //country: id,asciiname,code,currency_code
		
		var strArray 				= 	city_val.split(",");
		var country_id				=	strArray[0];
		var country_name			=	strArray[1];
		var country_code			=	strArray[2];
		var country_currency_code	=	strArray[3];
		var url= '<?php echo base_url()?>admin/AdminInventory/get_city_by_ajax';
		$.ajax({  
			type: 'POST',  
			url: url, 
			//data: { country_id: country_id,country_name: country_name,country_code: country_code,country_currency_code: country_currency_code },
			data: { city_val: city_val },
			success: function(response) {
				//alert(response);
				if(response=="No"){
				  	$("#city_id").html("something went wrong pleae try again");
				}else{
					$("#city_id").html(response);
					get_currency(country_currency_code);
				}
				
			}
		});
		
	}
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
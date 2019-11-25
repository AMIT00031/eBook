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
                <h2>Edit Inventory</h2>
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
							<div class="col-sm-2"><label class="control-label">Category *</label></div>
							
							<div class="col-sm-10">
								<select class="form-control"  id="sel1" name="inv_cate_id" required>  <!--sellist1-->
								<option value="">Select Category</option>
								<?php foreach($category as $CATEGORYIES){
									  if($inv_detail->inv_cate_id==$CATEGORYIES->id) $category_sel="selected";
									  else  $category_sel="selected"	;?>
									 <option value="<?=$CATEGORYIES->id.'====='.$CATEGORYIES->name?>" <?=$category_sel?>><?=$CATEGORYIES->name?></option>
								<?php } ?>
								</select>
							
							</div>
					</div>
					<div class="form-group">
						<div class="col-sm-2"><label class="control-label">Type</label>	</div>
						<div class="col-sm-10"><div class="row">
							<div class="col-lg-3">
								<label class="container1">Private
									<input type="radio" name="inv_type" checked="checked" value="1">
									<span class="checkmark"></span>
								</label>
							</div>
							<div class="col-lg-3">
								<label class="container1">Professional
									<input type="radio" name="inv_type"  value="2">
									<span class="checkmark"></span>
								</label>
							</div>
						</div>
					</div>
					</div>
					<div class="form-group">
					
							<div class="col-sm-2"><label class="control-label">Title *</label></div>
							<div class="col-sm-10"><input maxlength="200" type="text" name="title" value="<?php if(set_value('title')) { echo set_value('title');} else { echo $inv_detail->title; } ?>" required="required" class="form-control" placeholder="Title">
						    <?php echo form_error('title') ? '<span class="error">'.form_error('title').'</span>' : ''?>
					</div></div>
					<div class="form-group">
					 
							<div class="col-sm-2">
 							<label class="control-label">Description *</label>
							</div>
							<div class="col-sm-10">
							<textarea class="disp" name="description"  placeholder="Description" required="required"><?php if(set_value('description')) { echo set_value('description');} else { echo $inv_detail->description;  } ?></textarea>
							<small>Describe what makes your ad unique...</small>
							<?php echo form_error('description') ? '<span class="error">'.form_error('description').'</span>' : ''?>
						    </div>
					</div>
					<div class="form-group">
							<div class="col-sm-2"><label class="control-label">Country *</label></div>
							<div class="col-sm-10">
								<select class="form-control"  id="inv_country_id" name="inv_country_id" onchange="get_city(this.value)" required>  <!--sellist1-->
								<option value="">Select Country</option>
								<?php foreach($country as $COUNTRIES){
									  if($inv_detail->country_code==$COUNTRIES->id) $country_sel="selected"	;
									  else  $country_sel="selected"	;?>
									<option value="<?=$COUNTRIES->id.','.$COUNTRIES->asciiname.','.$COUNTRIES->code.','.$COUNTRIES->currency_code?>" <?=$country_sel?>><?=$COUNTRIES->asciiname?></option>
								<?php } ?>
								</select>
								<?php echo form_error('inv_country_id') ? '<span class="error">'.form_error('inv_country_id').'</span>' : ''?>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-2"><label class="control-label">Price *</label></div>
							<div class="col-sm-10">
								<div class="row">
								<div class="col-lg-1 pr0"><span class="input-group-addon"><span id="currency_id">د.إ</span></span><input id="currency_id_input" type="hidden" name="currency" value="د.إ"></div>    
								<div class="col-lg-9 p0"> 
									<input name="price" maxlength="20" type="text" value="<?php if(set_value('price')) { echo set_value('price');}else { echo $inv_detail->price; } ?>" required="required" class="form-control neo" placeholder="Eg 15000">
									<?php echo form_error('price') ? '<span class="error">'.form_error('price').'</span>' : ''?>
								</div>
								<div class="col-lg-2 pl0"><span class="input-group-addonleft">
								<div class="col-sm-2"><label class="container2">Negotiable
								<input type="checkbox" id="negotiable" name="negotiable" value="Yes" checked="checked" onclick="is_negotiable();">
								<span class="checkmark"></span>
								<script>
								function is_negotiable(){ 
									 if( $("#negotiable").val()=="Yes" ){
										$("#negotiable").val("No");
									}else{
										$("#negotiable").val("Yes");
									} 
								}
								</script>
								</label></span></div>    
								</div>
							</div>
                          </div>
						<div class="form-group">
							<div class="col-sm-2"><label class="control-label">City *</label> </div>
							<div class="col-sm-10">
							<div id="city_id">
							   
								<select class="form-control" id="city" name="city" required>
									
									<option value="">Select City</option>
									
									<?php $city_datas = $this->common_model->get_city($inv_detail->country_code,'');
									
									 foreach( $city_datas as $CITYIS){
										 if($CITYIS->id==$inv_detail->city_id) $city_select = "selected";
										 else $city_select = "";
									    ?>
										<option value="<?=$CITYIS->id?>" <?=$city_select?>><?=$CITYIS->asciiname?></option>
									<?php } ?>
									
								</select>
							</div>
							</div>
							
							<?php echo form_error('city') ? '<span class="error">'.form_error('city').'</span>' : ''?>
							
						</div>

						<div class="form-group">
							<div class="col-sm-2"><label class="control-label">Tags </label></div>
							<div class="col-sm-10">
							<input name="tags" type="text"  class="form-control" value="<?php if(set_value('tags')) { echo set_value('tags');} else { echo $inv_detail->tags; } ?>" placeholder="Tags" maxlength="200">
							<small>Enter the tags separated by commas.</small>
						</div>
						</div>
						
						<div class="devedid">
							<h2><i class="fa fa-user"></i>  Seller information</h2> 
						</div>

						<div class="form-group">
							<div class="col-sm-2"><label class="control-label">Your name *</label></div>
							<div class="col-sm-10">
								<input name="seller_name" type="text" value="<?php if(set_value('seller_name')) { echo set_value('seller_name');}else { echo $inv_detail->seller_name; } ?>" required="required" class="form-control"  placeholder="Your name" maxlength="200" >
								<?php echo form_error('seller_name') ? '<span class="error">'.form_error('seller_name').'</span>' : ''?>
						
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-2"><label class="control-label">Email *</label></div>
							<div class="col-sm-10">
								<div class="row">
								<div class="col-lg-1 pr0"><span class="input-group-addon"><i class="fa fa-envelope"></i></span></div>    
								<div class="col-lg-11 p0"> 
									  <input  name="seller_email" type="text" value="<?php if(set_value('seller_email')) { echo set_value('seller_email');}else { echo $inv_detail->seller_email; } ?>" required="required"  class="form-control neo" placeholder="Email" maxlength="200">
									  <?php echo form_error('seller_email') ? '<span class="error">'.form_error('seller_email').'</span>' : ''?>
								</div>

								</div>
							</div>
							
						</div>

						<div class="form-group">
							<div class="col-sm-2"><label class="control-label">Phone Number</label></div>
							<div class="col-sm-10">
							<div class="row">
								<div class="col-lg-1 pr0"><span class="input-group-addon"><i class="fa fa-flag"></i></span></div>    
								<div class="col-lg-9 p0"> 
								   <input name="seller_phone" type="tel" value="<?php if(set_value('seller_phone')) { echo set_value('seller_phone');}else { echo $inv_detail->seller_phone; } ?>" required="required"  maxlength="30"  class="form-control neo" placeholder="+91-1234567890">
								   <?php echo form_error('seller_phone') ? '<span class="error">'.form_error('seller_phone').'</span>' : ''?>
								
								</div>
								<div class="col-lg-2 pl0"><span class="input-group-addonleft">
								<label class="container2">Hide
									<input type="checkbox" id="is_hide" name="is_hide" value="Yes" checked="checked" onclick="is_hide_phone();">
									<span class="checkmark"></span>
									<script>
									function is_hide_phone(){ 
										 if( $("#is_hide").val()=="Yes"){
											$("#is_hide").val("No");
										}else{
											$("#is_hide").val("Yes");
										}  
									}
								 </script>
								</label></span>
								
								</div>    
							</div>
							</div>
							
							
					</div>
					<div class="form-group">
								<div class="col-sm-2"><label class="control-label">Images</label></div>					
								
								<div class="col-sm-10">
									<div class="progress mt-20">
									
									</div>
									<div class="flexdiv">
									<label class="btn btn-primary mt-20"> Browse&hellip; <input type="file" name="image[]" multiple style="display: none;">
									</label>
									</div>
								<br>
								<small class="text-center flexdiv">Add up to 4 photos. Use a real image of your product, not catalogs. Allowed ext jpg,png,gif</small>
								</div>
						</div>	
					
						
                   


                    <?php /* if ($this->ion_auth->is_admin()) { ?>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Role 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php foreach ($groups as $group) { ?>
                                    <?php
                                    $gID = $group['id'];
                                    $checked = null;
                                    $item = null;
                                    foreach ($currentGroups as $grp) {
                                        if ($gID == $grp->id) {
                                            $checked = ' checked="checked"';
                                            break;
                                        }
                                    }
                                    ?>

                                    <input type="checkbox" name="groups[]"  class="flat" value="<?php echo $group['id']; ?>" <?php echo $checked; ?> data-parsley-multiple="hobbies" style="position: absolute; opacity: 0;"> <?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?>
                                <?php } ?>
                            </div>
                        </div>

                    <?php } */ ?>

                    <?php //echo form_hidden('id', $user->id); ?>
                    <?php //echo form_hidden($csrf); ?>


                   <?php /* <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Username <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="last-name" name="username" value="<?php echo $inv_detail->username ?>" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div> */?>

                    

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" type="button">Cancel</button>
                            <button class="btn btn-primary" type="reset">Reset</button>
                            <button type="submit" class="btn btn-success">Submit</button>
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
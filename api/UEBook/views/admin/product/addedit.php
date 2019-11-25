<style>
.disp {
    width: 100%;
    height: 148px;
}
</style>
<!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Add/Edit Product</h2>
                <div class="clearfix"></div>
            </div>
			<?php //print_r($data);   ?>
			<?php /* foreach($edit_data as $edit_data){
				$edit_data =$edit_data;
			 } */ ?>
            <div class="x_content">
                <br>
                <form class="form-horizontal form-label-left"   data-parsley-validate=""  method="post" enctype="multipart/form-data" action="<?php echo current_url() ?>">
                    
					<div class="form-group">
							<div class="col-sm-2"><label class="control-label">Category *</label></div>
							<div class="col-sm-10">
								<select class="form-control"  id="sel1" name="category_id" required>  <!--sellist1-->
								<option value="">Select Category</option>
								<?php foreach($category as $key=>$CATEGORYIES){ 
									  if($edit_data->category_id==$key) $category_sel="selected";
									  else  $category_sel="";?>
									 <option value="<?=$key.'====='.$CATEGORYIES?>" <?=$category_sel?>><?=$CATEGORYIES?></option>
								<?php } ?>
								</select>
							</div>
					    </div>
						
						<div class="form-group">
							<div class="col-sm-2"><label class="control-label">User *</label></div>
							<div class="col-sm-10">
								<select class="form-control" id="UserId" name="UserId" required>  <!--sellist1-->
								<option value="">Select User</option>
									<?php foreach($user_data as $key=>$value){ 
										if($edit_data->user_id==$key){
											$slected = 'selected';
										}else{
											$slected = '';
										}
									
									?>
									 <option value="<?= $value->id; ?>" <?= $slected; ?>><?= $value->user_name; ?></option>
									<?php } ?>
								</select>
							</div>
					    </div>
						
						<div class="form-group">
							<div class="col-sm-2">
							<label class="control-label">Title *</label></div>						
							<div class="col-sm-10">
								<input maxlength="200" type="text" name="name" value="<?php if(set_value('book_title')) { echo set_value('book_title');} else { echo $edit_data->book_title; } ?>" required="required" class="form-control" placeholder="Title">
								<?php echo form_error('book_title') ? '<span class="error">'.form_error('book_title').'</span>' : ''?>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-2">
							<label class="control-label">Author Name *</label></div>						
							<div class="col-sm-10">
								<input maxlength="200" type="text" name="authorName" class="form-control" value="" placeholder="Author Name" value="<?php if(set_value('authorName')) { echo set_value('authorName');} else { echo $edit_data->author_name; } ?>" required="required">
								<?php echo form_error('authorName') ? '<span class="error">'.form_error('authorName').'</span>' : ''?>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-2">
							<label class="control-label">ISBN Number *</label></div>						
							<div class="col-sm-10">
								<input maxlength="200" type="text" name="ISBNNumber" class="form-control" value="<?php if(set_value('ISBNNumber')) { echo set_value('ISBNNumber');} else { echo $edit_data->isbn_number; } ?>" placeholder="ISBN Number" required="required">
								<?php echo form_error('ISBNNumber') ? '<span class="error">'.form_error('ISBNNumber').'</span>' : ''?>
							</div>
						</div>
					
					   <div class="form-group">
							<div class="col-sm-2">
 							<label class="control-label">Description *</label>
							</div>
							<div class="col-sm-10">
							<textarea class="disp" name="description"  placeholder="Description" required="required" id="summernote">
							<?php if(set_value('description')) { echo set_value('description');} else { echo $edit_data->book_description;  } ?>
							</textarea>
							<small>Describe what makes your ad unique...</small>
							<?php echo form_error('description') ? '<span class="error">'.form_error('description').'</span>' : ''?>
						    </div>
					</div>
					
					    <div class="form-group">
							<div class="col-sm-2"><label class="control-label">Images</label></div>
							<div class="col-sm-10">
								<div class="flexdiv">
								<label class="btn btn-primary mt-20"> Browse&hellip; 
								<input type="file" name="image">
								</label>
								</div>
							<br>
							<small class="text-center flexdiv"> Use a real image of your product, not catalogs. Allowed ext jpg,png,gif</small>
							</div>
					   </div>
					   
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
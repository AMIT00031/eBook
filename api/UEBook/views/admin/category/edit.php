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
                <h2>Edit Category</h2>
                <div class="clearfix"></div>
            </div>
			<?php //print_r($edit_data);   ?>
			<?php /* foreach($edit_data as $edit_data){
				  $edit_data =$edit_data;
			 } */ ?>
            <div class="x_content">
                <br>
                <form class="form-horizontal form-label-left"   data-parsley-validate=""  method="post" enctype="multipart/form-data" action="<?php echo current_url() ?>">
					
					<div class="form-group">
						<div class="col-sm-2"><label class="control-label">Title *</label></div>			
						<div class="col-sm-10">
						<input maxlength="200" type="text" name="name" value="<?php if(set_value('name')) { echo set_value('name');} else { echo $edit_data->category_name; } ?>" required="required" class="form-control" placeholder="Title">	<?php echo form_error('name') ? '<span class="error">'.form_error('name').'</span>' : ''?></div>					
				  </div>
				  
					<div class="form-group">
						<div class="col-sm-2">
						  <label class="control-label">Description *</label>
						</div>
						<div class="col-sm-10">
							<textarea class="disp" name="description" id="summernote"  placeholder="Description" required="required"><?php if(set_value('description')) { echo set_value('description');} else { echo $edit_data->description;  } ?></textarea>
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
                            <a href="<?=base_url()?>admin/category"> <button class="btn btn-primary" type="button">Cancel</button></a>
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
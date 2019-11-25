<div class="logo">  <h1>Upload inventory</h1></div>
<!-- <a class="logg" href="<?php base_url()?>welcome/logout">Logout</a> -->

<div class="container trans">
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
				
	<script>
	function get_city(city_val){  //country: id,asciiname,code,currency_code
		
		var strArray 				= 	city_val.split(",");
		var country_id				=	strArray[0];
		var country_name			=	strArray[1];
		var country_code			=	strArray[2];
		var country_currency_code	=	strArray[3];
		var url= '<?php echo base_url()?>inventory/get_city_by_ajax';
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
		var url= '<?php echo base_url()?>inventory/get_currency_by_ajax';
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
	<div class="mainwizardiv">      
		<div class="row">
		  
			<div class="stepwizard">
				<div class="stepwizard-row setup-panel">
					<div class="stepwizard-step col-xs-3"> 
					<a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
					<p><small>Ad's Details</small></p>
					</div>
					<div class="stepwizard-step col-xs-3"> 
					<?php if($step=='step2'){  $btn_success2="btn-success"; }else{ $btn_success2=""; } ?>
						<a href="#step-2" type="button" class="btn btn-default btn-circle <?=$btn_success2?>" disabled="disabled">2</a>
						<p><small>Photos</small></p>
					
					</div>
					<?php if($step=='final'){ $btn_success3="btn-success"; }else{ $btn_success3=""; } ?>
					<div class="stepwizard-step col-xs-3"> 
						<a href="#step-3" type="button" class="btn btn-default btn-circle <?=$btn_success3?>" disabled="disabled">3</a>
						<p><small>Finish</small></p>
					</div>

				</div>
			</div>

			<form role="form" method="post" action="<?=base_url()?>upload">
				<input type="hidden" name="step" value="step1">
				<div class="panel panel-primary setup-content" id="step-1">
					<div class="panel-heading">
						<h3 class="panel-title">Post inventory</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label">Category *</label>
							<select class="form-control"  id="sel1" name="inv_cate_id" required>  <!--sellist1-->
							<option value="">Select Category</option>
							<?php foreach($category as $CATEGORYIES){
                                  if($inv_detail->inv_cate_id==$CATEGORYIES->id) $category_sel="selected";
                                  else  $category_sel="selected"	;?>
								 <option value="<?=$CATEGORYIES->id.'====='.$CATEGORYIES->name?>"><?=$CATEGORYIES->name?></option>
							<?php } ?>
							</select>
							
						</div>
						<div class="form-group">
						<label class="control-label">Type</label>
						<div class="row">
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
						<div class="form-group">
							<label class="control-label">Title *</label>
							<input maxlength="200" type="text" name="title" value="<?php if(set_value('title')) { echo set_value('title');} ?>" required="required" class="form-control" placeholder="Title">
						    <?php echo form_error('title') ? '<span class="error">'.form_error('title').'</span>' : ''?>
						</div>

						<div class="form-group">
							<label class="control-label">Description *</label>
							<textarea class="dis" name="description" value="<?php if(set_value('description')) { echo set_value('description');} ?>" placeholder="Description" required="required"></textarea>
							<small>Describe what makes your ad unique...</small>
							<?php echo form_error('description') ? '<span class="error">'.form_error('description').'</span>' : ''?>
						    
						</div>


						<div class="form-group">
							<label class="control-label">Country *</label>
							<select class="form-control"  id="inv_country_id" name="inv_country_id" onchange="get_city(this.value)" required>  <!--sellist1-->
							<option value="">Select Country</option>
							<?php foreach($country as $COUNTRIES){
                                  if($inv_detail->country_code==$COUNTRIES->id) $country_sel="selected"	;
                                  else  $country_sel="selected"	;?>
								<option value="<?=$COUNTRIES->id.','.$COUNTRIES->asciiname.','.$COUNTRIES->code.','.$COUNTRIES->currency_code?>"><?=$COUNTRIES->asciiname?></option>
							<?php } ?>
							</select>
							<?php echo form_error('inv_country_id') ? '<span class="error">'.form_error('inv_country_id').'</span>' : ''?>
						</div>
						
						<div class="form-group">
							<label class="control-label">Price *</label>
							<div class="row">
							<div class="col-lg-1 pr0"><span class="input-group-addon"><span id="currency_id">د.إ</span></span><input id="currency_id_input" type="hidden" name="currency" value="د.إ"></div>    
							<div class="col-lg-9 p0"> 
								<input name="price" maxlength="20" type="text" value="<?php if(set_value('price')) { echo set_value('price');} ?>" required="required" class="form-control neo" placeholder="Eg 15000">
								<?php echo form_error('price') ? '<span class="error">'.form_error('price').'</span>' : ''?>
							</div>
							<div class="col-lg-2 pl0"><span class="input-group-addonleft">
							<label class="container2">Negotiable
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

						<div class="form-group">
							<label class="control-label">City *</label>
							<div id="city_id">
								<select class="form-control" id="city" name="city" required>
									<option value="">Select City</option>
									<option value="city1">city1</option>
									<option value="city2">city2</option>
								</select>
							</div>
							<?php echo form_error('city') ? '<span class="error">'.form_error('city').'</span>' : ''?>
							
						</div>

						<div class="form-group">
							<label class="control-label">Tags </label>
							<input name="tags" type="text"  class="form-control" placeholder="Tags" maxlength="200">
							<small>Enter the tags separated by commas.</small>
						</div>
						<div class="devedid">
							<h2><i class="fa fa-user"></i>  Seller information</h2> 
						</div>

						<div class="form-group">
							<label class="control-label">Your name *</label>
							<input name="seller_name" type="text" value="<?php if(set_value('seller_name')) { echo set_value('seller_name');} ?>" required="required" class="form-control"  placeholder="Your name" maxlength="200" >
							<?php echo form_error('seller_name') ? '<span class="error">'.form_error('seller_name').'</span>' : ''?>
						</div>

						<div class="form-group">
							<label class="control-label">Email *</label>
							<div class="row">
							<div class="col-lg-1 pr0"><span class="input-group-addon"><i class="fa fa-envelope"></i></span></div>    
							<div class="col-lg-11 p0"> 
							      <input  name="seller_email" type="text" value="<?php if(set_value('seller_email')) { echo set_value('seller_email');} ?>" required="required"  class="form-control neo" placeholder="Email" maxlength="200">
							      <?php echo form_error('seller_email') ? '<span class="error">'.form_error('seller_email').'</span>' : ''?>
							</div>

							</div>
						</div>

						<div class="form-group">
							<label class="control-label">Phone Number</label>
							<div class="row">
								<div class="col-lg-1 pr0"><span class="input-group-addon"><i class="fa fa-flag"></i></span></div>    
								<div class="col-lg-9 p0"> 
								   <input name="seller_phone" type="tel" value="<?php if(set_value('seller_phone')) { echo set_value('seller_phone');} ?>" required="required"  maxlength="30"  class="form-control neo" placeholder="+91-1234567890">
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
							<small>By continuing on this website, you accept our<a href="#"> Terms of Use</a></small>
						</div>
						<input class="btn btn-primary nextBtn pull-right" type="submit" name="Submit" value="Next">
						<!--<button class="btn btn-primary nextBtn pull-right" type="button" name="">Next</button>-->
					</div>					
				</div>
				
			</form>
				
			<form role="form" method="post" action="<?=base_url()?>upload" enctype="multipart/form-data" >
				<input type="hidden" name="step" value="step2"> 
				
				<div class="panel panel-primary setup-content" id="step-2">
					<div class="panel-heading">
						<h3 class="panel-title"> Photos</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label">Pictures</label>

							<div class="mainpicture">
								<div class="row">
									<div class="col-lg-3">
										<div class="picture">
										<img src="<?=base_url()?>assets/front/images/1.jpg">
										<div class="imgtitle">Image 01</div>   
										<div class="editndelete">
										<ul>
										<li><a href="#"><i class="fa fa-trash"></i></a></li>
										<li><a href="#"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>     
										</ul>   
										</div>
										</div>    
									</div>

									<div class="col-lg-3">
										<div class="picture">
										<img src="<?=base_url()?>assets/front/images/2.jpg">
										<div class="imgtitle">Image 01</div>   
										<div class="editndelete">
										<ul>
										<li><a href="#"><i class="fa fa-trash"></i></a></li>
										<li><a href="#"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>     
										</ul>   
										</div>
										</div>    
									</div>

									<div class="col-lg-3">
										<div class="picture">
										<img src="<?=base_url()?>assets/front/images/3.jpg">
										<div class="imgtitle">Image 01</div>   
										<div class="editndelete">
										<ul>
										<li><a href="#"><i class="fa fa-trash"></i></a></li>
										<li><a href="#"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>     
										</ul>   
										</div>
										</div>    
									</div>

									<div class="col-lg-3">
										<div class="picture">
										<img src="<?=base_url()?>assets/front/images/4.jpg">
										<div class="imgtitle">Image 01</div>   
										<div class="editndelete">
										<ul>
										<li><a href="#"><i class="fa fa-trash"></i></a></li>
										<li><a href="#"><i class="fa fa-search-plus" aria-hidden="true"></i></a></li>     
										</ul>   
										</div>
										</div>    
									</div>
								</div>

							</div>

							<div class="progress mt-20">
							<div class="progress-bar" style="width:70%"></div>
							</div>
							<div class="flexdiv">
							<label class="btn btn-primary mt-20"> Browse&hellip; <input type="file" name="image[]" multiple style="display: none;">
							</label>
							</div>
							<small class="text-center flexdiv">Add up to 4 photos. Use a real image of your product, not catalogs. Allowed ext jpg,png,gif</small>
							
						</div>
						<input class="btn btn-primary nextBtn pull-right" type="submit" name="Submit" value="Next">
						<!--<button class="btn btn-primary nextBtn pull-right" type="button">Next</button>-->
					</div>
					
				</div>
				
			</form>
				
			<form role="form" method="post" action="<?=base_url()?>upload">
				<input type="hidden" name="step" value="final"> 
				<div class="panel panel-primary setup-content" id="step-3">
					<div class="panel-heading">
					<h3 class="panel-title"><?php echo ($inv_detail->title)?$inv_detail->title:"Inventory Title";?></h3>
					</div>
					<div class="panel-body">
						
						<div class="mainpicture">
							<div class="row">
								
							  <?php if(!empty($imagesData)){

  								    foreach($imagesData as  $images) {  ?>
									
										<div class="col-lg-3">
										<div class="picture">
											<img src="<?=base_url()?>uploads/inventory/<?=$images->filename?>" >

										</div>    
									</div>
									
									
									<?php } 
									
									} else {  ?>
								
									<div class="col-lg-3">
										<div class="picture">
											<img src="<?=base_url()?>assets/front/images/1.jpg">

										</div>    
									</div>

									<div class="col-lg-3">
										<div class="picture">
											<img src="<?=base_url()?>assets/front/images/2.jpg">
										</div>    
									</div>

									<div class="col-lg-3">
										<div class="picture">
											<img src="<?=base_url()?>assets/front/images/3.jpg">
										</div>    
									</div>

									<div class="col-lg-3">
										<div class="picture">
											<img src="<?=base_url()?>assets/front/images/4.jpg">
										</div>    
									</div>
									<?php } ?>
								
							</div>

						</div>
						<ul class="nav nav-tabs responsive mt-20" role="tablist">
							<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home" role="tab">Ads Details</a></li>

						</ul><!-- Tab panes -->
						<div class="tab-content responsive">
							<div class="tab-pane active" id="home" role="tabpanel">
								<div class="container-fluid">
									<div class="row ">


										<div class="col-12">
										<p class="h3">Ads Discription</p>
										<hr/>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi impedit, quae enim, id nobis et fugit aut voluptates reprehenderit, atque dolore, eveniet velit repellat. Explicabo sunt corporis in. Beatae, vel!</p>
										</div>
										<div class="col-lg-12"><h2> Category: <a href="#"><?php echo ($inv_detail->inv_cate)?$inv_detail->inv_cate:"category1";?></a></h2></div>

										<hr/>
										<div class="col-lg-12"><h2>Location: <a href="#"><?php echo ($inv_detail->city)?$inv_detail->city:"Dubai";?></a></h2></div>
										<hr/>
										<div class="col-lg-12"><h2> Type: <a href="#"><?php echo ($inv_detail->city==1)?"Private":"Professional";?></a></h2></div>
										<hr/>
										<div class="col-lg-12"><h2><i class="fa fa-tags"></i> <?php echo ($inv_detail->tags)?$inv_detail->tags:"";?></h2></div>
										<hr/>
										
										<div class="tages">
										<ul> 
										    <?php  
												 if($inv_detail->seller_name!='') {
													 $tags = explode(",",$inv_detail->seller_name);	
													 foreach($tags as $TAG){?>				 
														<li><a href="javascript(0)"><?=$TAG?></a></li>
													<?php } 
												 } else { ?>
												
													<li><a >N/A</a></li>
												 <?php } ?>
										</ul>
										</div>

										<hr/>

										<div class="col-lg-12"><h2>Price: -- د.إ <span class="button-sucess"><?php echo ($inv_detail->price)?$inv_detail->price:"";?> Negotiable <?php echo $inv_detail->negotiable; ?></span></h2></div>
										<hr/>
										<div class="col-lg-12"><p class="h3">Seller information</p></div>
										<hr/>
										<div class="col-lg-12"><h2> Name: <a href="#"><?php echo ($inv_detail->seller_name)?$inv_detail->seller_name:"N/A";?></a></h2></div>
										<hr/>
										<div class="col-lg-12"><h2> Email: <a href="#"><?php echo ($inv_detail->seller_email)?$inv_detail->seller_email:"N/A";?></a></h2></div>
										<hr/>
										<div class="col-lg-12"><h2> Phone: <a href="#">+91 <?php echo ($inv_detail->seller_phone)?$inv_detail->seller_phone:"N/A";?></a></h2></div>

									</div>
								</div>
								<hr/>
								<div class="text-center"><input type="submit" name="Submit" value="Submit" class="sendmsg"></div>
								<!--<div class="sendmsg">Submit</div>-->
							</div>

						</div>
						<br/>

					</div>
				</div>

			</form>

		</div>
	</div>
	
</div>

<script>
$(document).ready(function () {

var navListItems = $('div.setup-panel div a'),
allWells = $('.setup-content'),
allNextBtn = $('.nextBtn');

allWells.hide();

navListItems.click(function (e) {
e.preventDefault();
var $target = $($(this).attr('href')),
$item = $(this);

if (!$item.hasClass('disabled')) {
navListItems.removeClass('btn-success').addClass('btn-default');
$item.addClass('btn-success');
allWells.hide();
$target.show();
$target.find('input:eq(0)').focus();
}
});

allNextBtn.click(function () {
var curStep = $(this).closest(".setup-content"),
curStepBtn = curStep.attr("id"),
nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
curInputs = curStep.find("input[type='text'],input[type='url']"),
isValid = true;

$(".form-group").removeClass("has-error");
for (var i = 0; i < curInputs.length; i++) {
if (!curInputs[i].validity.valid) {
	isValid = false;
	$(curInputs[i]).closest(".form-group").addClass("has-error");
	}
}

if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
});

$('div.setup-panel div a.btn-success').trigger('click');
});
</script>



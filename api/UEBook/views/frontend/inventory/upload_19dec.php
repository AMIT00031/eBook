<div class="logo">  <h1>Upload inventory</h1></div>
<a class="logg" href="<?php base_url()?>welcome/logout">Logout</a>
<div class="container trans">
    <?php 

				if($this->session->flashdata('message_success')){
					echo  '<span class="success">'.$this->session->flashdata('message_success').'</span>';
				}
				if($this->session->flashdata('message_error')){
				   echo  '<span class="error">'.$this->session->flashdata('message_error').'</span>';
				}
				if($message_success){
					echo  '<span class="success">'.$message_success.'</span>';
				}
				if($mssage_error){
				   echo  '<span class="error">'.$mssage_error.'</span>';
				}
				
				?>
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
							<option>Select Category</option>
							<option value="Category 1">Category 1</option>
							<option value="Category 2">Category 2</option>
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
							<input maxlength="200" type="text" name="title" required="required" class="form-control" placeholder="Title">
						</div>

						<div class="form-group">
							<label class="control-label">Description *</label>
							<textarea class="dis" name="description" placeholder="Description" required="required"></textarea>
							<small>Describe what makes your ad unique...</small>
						</div>


						<div class="form-group">
							<label class="control-label">Country *</label>
							<select class="form-control"  id="inv_country_id" name="inv_country_id" required>  <!--sellist1-->
							<option value="">Select Country</option>
							<option value="Category 1">Country 1</option>
							<option value="Category 2">Country 2</option>
							</select>
						</div>
						
						<div class="form-group">
							<label class="control-label">Price *</label>
							<div class="row">
							<div class="col-lg-1 pr0"><span class="input-group-addon">د.إ</span><input type="hidden" name="currency" value="د.إ"></div>    
							<div class="col-lg-9 p0"> 
								<input name="price" maxlength="200" type="text" required="required" class="form-control neo" placeholder="Eg 15000">
								
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
							<select class="form-control" id="city" name="city" required>
								<option value="">Select</option>
								<option value="city1">city1</option>
								<option value="city2">city2</option>
							</select>
						</div>

						<div class="form-group">
							<label class="control-label">Tags *</label>
							<input name="tags" type="text" required="required" class="form-control" placeholder="Tags" maxlength="200">
							<small>Enter the tags separated by commas.</small>
						</div>
						<div class="devedid">
							<h2><i class="fa fa-user"></i>  Seller information</h2> 
						</div>

						<div class="form-group">
							<label class="control-label">Your name *</label>
							<input name="seller_name" type="text" required="required" class="form-control"  placeholder="Your name" maxlength="200" >

						</div>

						<div class="form-group">
							<label class="control-label">Email *</label>
							<div class="row">
							<div class="col-lg-1 pr0"><span class="input-group-addon"><i class="fa fa-envelope"></i></span></div>    
							<div class="col-lg-11 p0"> <input  name="seller_email" type="text" required="required"  class="form-control neo" placeholder="Email" maxlength="200"></div>

							</div>
						</div>

						<div class="form-group">
							<label class="control-label">Phone Number</label>
							<div class="row">
								<div class="col-lg-1 pr0"><span class="input-group-addon"><i class="fa fa-flag"></i></span></div>    
								<div class="col-lg-9 p0"> <input name="seller_phone" type="tel" required="required"  maxlength="30"  class="form-control neo" placeholder="+91-1234567890"></div>
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
				
			<form role="form" method="post" action="<?=base_url()?>upload" enctype="multipart-formdata">
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
					<label class="btn btn-primary mt-20"> Browse&hellip; <input type="file" style="display: none;">
					</label>
					</div>
					<small class="text-center flexdiv">Add up to 5 photos. Use a real image of your product, not catalogs.</small>
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
					<h3 class="panel-title">Product Title</h3>
					</div>
					<div class="panel-body">
					<div class="mainpicture">
					<div class="row">
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
					<li><a href="#">sad</a></li>
					<li><a href="#">sad</a></li>
					<li><a href="#">sad</a></li>
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
					<div class="sendmsg"><input type="submit" name="Submit" value="Submit"></div>
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



<?php 

if($this->session->flashdata('message_success')){
	echo  '<span class="success">'.$this->session->flashdata('message_success').'</span>';
}
if($this->session->flashdata('message_error')){
   echo  '<span class="error">'.$this->session->flashdata('message_error').'</span>';
}
?>

<div class="logo">  <h1>Upload inventory</h1></div>
<!-- <a class="logg" href="<?php base_url()?>welcome/logout">Logout</a> -->


<div class="container trans">
<div class="mainwizardiv">      
<div class="row">
<div class="stepwizard">
<div class="stepwizard-row setup-panel">
<div class="stepwizard-step col-xs-3"> 
<a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
<p><small>Ad's Details</small></p>
</div>
<div class="stepwizard-step col-xs-3"> 
<a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
<p><small>Photos</small></p>
</div>
<div class="stepwizard-step col-xs-3"> 
<a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
<p><small>Finish</small></p>
</div>

</div>
</div>

<form role="form">
<div class="panel panel-primary setup-content" id="step-1">
<div class="panel-heading">
<h3 class="panel-title">Post inventory</h3>
</div>
<div class="panel-body">
<div class="form-group">
<label class="control-label">Category *</label>
<select class="form-control" id="sel1" name="sellist1">
<option>Select Category</option>
<option>Category 1</option>
<option>Category 2</option>
</select>
</div>
<div class="form-group">
<label class="control-label">Type</label>
<div class="row">
<div class="col-lg-3">
<label class="container1">Private
<input type="checkbox" checked="checked">
<span class="checkmark"></span>
</label>
</div>
<div class="col-lg-3">
<label class="container1">Professional
<input type="checkbox" checked="checked">
<span class="checkmark"></span>
</label>
</div>
</div>
</div>
<div class="form-group">
<label class="control-label">Title *</label>
<input maxlength="200" type="text" required="required" class="form-control" placeholder="Title">
</div>

<div class="form-group">
<label class="control-label">Description *</label>
<textarea class="dis" placeholder="Description"></textarea>
<small>Describe what makes your ad unique...</small>
</div>


<div class="form-group">
<label class="control-label">Price *</label>
<div class="row">
<div class="col-lg-1 pr0"><span class="input-group-addon">د.إ</span></div>    
<div class="col-lg-9 p0"> <input maxlength="200" type="text" required="required" class="form-control neo" placeholder="Eg 15000"></div>
<div class="col-lg-2 pl0"><span class="input-group-addonleft">
<label class="container2">Negotiable
<input type="checkbox" checked="checked">
<span class="checkmark"></span>
</label></span></div>    
</div>
</div>

<div class="form-group">
<label class="control-label">City *</label>
<select class="form-control" id="sel1" name="sellist1">
<option>Select</option>
<option>Select Provider</option>
<option>Edit inventory</option>
</select>
</div>

<div class="form-group">
<label class="control-label">Tags *</label>
<input maxlength="200" type="text" required="required" class="form-control" placeholder="Tags">
<small>Enter the tags separated by commas.</small>
</div>
<div class="devedid">
<h2><i class="fa fa-user"></i>  Seller information</h2> 
</div>



<div class="form-group">
<label class="control-label">Your name *</label>
<input maxlength="200" type="text" required="required" class="form-control" placeholder="Your name">

</div>




<div class="form-group">
<label class="control-label">Email *</label>
<div class="row">
<div class="col-lg-1 pr0"><span class="input-group-addon"><i class="fa fa-envelope"></i></span></div>    
<div class="col-lg-11 p0"> <input maxlength="200" type="text" required="required" class="form-control neo" placeholder="Email"></div>

</div>
</div>

<div class="form-group">
<label class="control-label">Phone Number</label>
<div class="row">
<div class="col-lg-1 pr0"><span class="input-group-addon"><i class="fa fa-flag"></i></span></div>    
<div class="col-lg-9 p0"> <input maxlength="200" type="text" required="required" class="form-control neo" placeholder="+91-1234 567 890"></div>
<div class="col-lg-2 pl0"><span class="input-group-addonleft">
<label class="container2">Hide
<input type="checkbox" checked="checked">
<span class="checkmark"></span>
</label></span></div>    
</div>
<small>By continuing on this website, you accept our<a href="#"> Terms of Use</a></small>
</div>




<button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
</div>
</div>

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

<button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
</div>
</div>









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
<div class="col-lg-12"><h2> Category: <a href="#">Category One</a></h2></div>

<hr/>
<div class="col-lg-12"><h2>Location: <a href="#">Dubai</a></h2></div>
<hr/>
<div class="col-lg-12"><h2> Type: <a href="#">Private</a></h2></div>
<hr/>
<div class="col-lg-12"><h2><i class="fa fa-tags"></i> Tags</h2></div>
<hr/>
<div class="tages">
<ul>
<li><a href="#">sad</a></li>
<li><a href="#">sad</a></li>
<li><a href="#">sad</a></li>
</ul>
</div>

<hr/>

<div class="col-lg-12"><h2>Price: -- د.إ <span class="button-sucess">Negotiable</span></h2></div>
<hr/>
<div class="col-lg-12"><p class="h3">Seller information</p></div>
<hr/>
<div class="col-lg-12"><h2> Name: <a href="#">Ajad Rawat</a></h2></div>
<hr/>
<div class="col-lg-12"><h2> Email: <a href="#">Ajad@gmail.com</a></h2></div>
<hr/>
<div class="col-lg-12"><h2> Phone: <a href="#">+91 1234 567 890</a></h2></div>

</div>
</div>
<hr/>
<div class="sendmsg">Submit</div>
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



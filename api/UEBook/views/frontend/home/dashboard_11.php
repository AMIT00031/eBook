<?php 

if($this->session->flashdata('message_success')){
	echo  '<span class="success">'.$this->session->flashdata('message_success').'</span>';
}
if($this->session->flashdata('message_error')){
   echo  '<span class="error">'.$this->session->flashdata('message_error').'</span>';
}
?>

<div class="container">
<div class="row">
<div class="col-md-4 login-sec">
<h3 class="text-center">manage inventory</h3>
<form class="login-form">
<div class="custom-select">
<select class="form-control" id="sel1" name="sellist1">
<option>Select</option>
<option>Upload inventory</option>
<option>Edit inventory</option>
</select>
</div>
</form>     
</div>
  


<div class="col-md-4 login-sec">
<h3 class="text-center">generate reports</h3>
<form class="login-form">
<div class="form-group">
<div class="custom-select">
<select class="form-control" id="sel1" name="sellist1">
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
</select>
</div>
</div>
</form>     
</div>
<div class="col-md-4 login-sec">
<h3 class="text-center">Sales and Quotations</h3>
<form class="login-form">
<div class="form-group">
<div class="custom-select">
<select class="form-control" id="sel1" name="sellist1">
<option>Add Sales</option>
<option>Edit Sales</option>
<option>Upload Sales CSV File</option>
<option>Delivery Schedule </option>
<option>List All Quotations </option>
<option>Add Quotation </option>
<option>Generate Reports </option>
<option>Total Sales Report </option>
<option>Total Inventory Report </option>
</select>
</div>
</div>
</form>     
</div>


</div>
</div>



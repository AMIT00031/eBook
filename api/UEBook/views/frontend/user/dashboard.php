<?php 

if($this->session->flashdata('message_success')){
	echo  '<span class="success">'.$this->session->flashdata('message_success').'</span>';
}
if($this->session->flashdata('message_error')){
   echo  '<span class="error">'.$this->session->flashdata('message_error').'</span>';
}
?>

<div class="logo">  <h1>global warehouse dashboard</h1> </div>
<div class="container">
	<div class="row">
		<div class="col-md-4 login-sec">
			<h3 class="text-center">manage inventory</h3>
			<form class="login-form">
				<div class="slectDrop">
					<select  class="form-control" id="inventory" name="inventory" onchange="chnageAction(this.value);">
						<option value="">Select Action</option>
						<option value="upload">Upload inventory</option>
						<option value="inventory-list">Inventory List</option>
						<!--<option value="edit">Edit inventory</option>-->
					</select>
				</div>
			</form>     
		</div>
		 <script>
		 function chnageAction(value){
			  if(value==''){
				alert("Pleaes select action"); 
			 }else{
				document.location.href="<?=base_url()?>"+value;
			 }				 
		 }
		 
		 </script> 


		<div class="col-md-4 login-sec">
		<h3 class="text-center">generate reports</h3>
			<form class="login-form">
				<div class="form-group">
					<div class="slectDrop">
						<select class="form-control" id="reports" name="reports">
						    <option value="">Select Report</option>
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
					<div class="slectDrop">
						<select class="form-control" id="sales_quotations" name="sales_quotations">
						   <option value="">Select Action</option>
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




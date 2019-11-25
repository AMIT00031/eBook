<div class="logo">  <h1>Inventory List</h1></div>
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
		  
		    <table id="list" class="table table-striped table-bordered">
				<thead>			                
				<th>Title</th>
				<th>Category</th>
				<th>Country</th>
				<th>City</th>
				<th>Seller Name</th>
				<th>Seller Email</th>
				<th>Seller Phone</th>
				<th>Added Date</th>
				<!--<th>Status</th>
				<th>Action</th>-->
			</thead>
			<tbody>
				<?php
				$icon = '';
				if (!empty($inventory_list)) {
					foreach ($inventory_list as $inv_list) {
						
						?>
						<tr role="row" class="even">
							<td><?php echo!empty($inv_list->title) ? $inv_list->title : '' ?></td>
							<td><?php echo!empty($inv_list->inv_cate_name) ? $inv_list->inv_cate_name : 'N/A' ?></td>
							<td><?php echo!empty($inv_list->country_name) ? $inv_list->country_name : 'N/A' ?></td>
							<?php $city_datas = $this->common_model->get_city('',$inv_list->city_id); ?>
							<td><?php echo!empty($inv_list->city_id) ? $city_datas[0]->asciiname : 'N/A' ?></td>
							<td><?php echo!empty($inv_list->seller_name) ? $inv_list->seller_name : 'N/A' ?></td>
							<td><?php echo!empty($inv_list->seller_email) ? $inv_list->seller_email : 'N/A' ?></td>
							<td><?php echo!empty($inv_list->seller_phone) ? $inv_list->seller_phone : 'N/A' ?></td>
							<td><?php echo!empty($inv_list->created_at) ? date("m-d-Y", strtotime($inv_list->created_at)) : '' ?></td>
							
							<?php /* <td>
								<label class="switch switch-text switch-pill switch-primary">
									<input type="checkbox" name="chk-status" onclick="changeStatus(<?php echo $inv_list->id;?>)" class="switch-input" id="chk-status-<?php echo $inv_list->id;?>" <?php echo $inv_list->status=='1' ? 'checked' : '' ?>>
									<span class="switch-label" data-on="On" data-off="Off"></span>
									<span class="switch-handle"></span>
							   </label>
							</td> */ ?>
							<?php /* <td>
								<a class="btn btn-primary" href="<?php echo base_url('admin/AdminInventory/edit/' . $inv_list->id) ?>">Edit</a>       
								<a href="" class="btn btn-primary" data-record-id="<?php echo $inv_list->id ?>" data-record-title="<?php echo $inv_list->title ?>" data-toggle="modal" data-target="#confirm-delete">
									Delete
								</a>
							</td> */ ?>
							
							<!--<td>
								<a class="btn btn-primary" href="#">Edit</a>       
								<a href="#">Delete</a>																	
							</td>-->
							
						</tr>
						
						<?php
					}
				}
				?>
			</tbody>
			</table>
			
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



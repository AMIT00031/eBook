<div class="m-b-10">
    <div class="pull-left">
        <h3 class="pull-left">
            <strong>Proudct Model List</strong>
        </h3>
    </div>

    <div class="pull-right">
       <a href="<?php echo base_url('admin/model/addedit'); ?>" class="btn btn-primary">Add Model</a> 
     
    </div>
</div>


<table id="list" class="table table-striped table-bordered">
    <thead>			                
    <th>Title</th>
    <th>Added Date</th>
    <th>Status</th>
    <th>Action</th>
</thead>
<tbody>
    <?php
    $icon = '';
    if (!empty($lists)) {
        foreach ($lists as $list) {
            
            ?>
            <tr role="row" class="even">
				<td><?php echo!empty($list->name) ? $list->name : '' ?></td>
			  
                <td><?php echo!empty($list->created_at) ? date("m-d-Y", strtotime($list->created_at)) : '' ?></td>
                
				<td>
					<label class="switch switch-text switch-pill switch-primary">
						<input type="checkbox" name="chk-status" onclick="changeStatus(<?php echo $list->id;?>)" class="switch-input" id="chk-status-<?php echo $list->id;?>" <?php echo $list->status=='1' ? 'checked' : '' ?>>
						<span class="switch-label" data-on="On" data-off="Off"></span>
						<span class="switch-handle"></span>
				   </label>
				</td>
				<td>
                    <a class="btn btn-primary" href="<?php echo base_url('admin/model/addedit/' . $list->id) ?>">Edit</a>       
					<a href="" class="btn btn-primary" data-record-id="<?php echo $list->id ?>" data-record-title="<?php echo $list->title ?>" data-toggle="modal" data-target="#confirm-delete">
                        Delete
                    </a>
                </td>
				
            </tr>
			
            <?php
        }
    }
    ?>
</tbody>
</table>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('confirm_del_btn'); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('about_to_delete'); ?> <b><i class="title"></i></b> <?php echo $this->lang->line('irreversible'); ?></p>
                <p><?php echo $this->lang->line('do_you_want_to_proceed'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                <button type="button" class="btn btn-danger btn-ok"><?php echo $this->lang->line('delete'); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
function changeStatus(id){
    var base_url = "<?php echo base_url(); ?>";	
    var ckbox = $('#chk-status-'+id); 
	alert(ckbox.is(':checked')); 
	var r = confirm("Are you sure to chnage status!");
	if (r == true) {
        if (ckbox.is(':checked')) {
			$.ajax({
				type: 'post',
				url : base_url+'admin/model/changeStatus/'+id+'/1',
				success:function(data){  
					if(data==1){
						alert('Status changed successfully');
					}
				}	
			});
			
        } else {
			$.ajax({
				type: 'post',
				url : base_url+'admin/model/changeStatus/'+id+'/0',
				success:function(data){ 
					if(data==0){ 
						alert('Status changed successfully ff');
					}
				}	
			});						
        }
	}else{
		alert('OK');
	}
}
</script>


<script type="text/javascript">

    $(document).ready(function () { 
        var base_url = "<?php echo base_url(); ?>";
		
        /* TABLETOOLS */

        $('#list').dataTable();

        $('#confirm-delete').on('click', '.btn-ok', function (e) {
            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');
            var model = 'job_category_model';
            var msg = 'Something went wrong!';
            $.ajax({
                //url: base_url + 'ajax_controller/deleteCommonAttribute',
                url: base_url + 'admin/categroy/deleteRecord',
                type: "POST",
                data: {id: id},
                success: function (res) {
                    console.log(res);
                    var data = $.parseJSON(res); alert(data);
                    if (data.response === 'Yes') {
						alert('Successfully deleted.');
                        location.reload();
                    }else if(data.response === 'No'){
						alert('Sorry! not deleted, please try again');
					}else {
                        alert('Something went wrong.');
                    }
                }
            })

        });

        $('#confirm-delete').on('show.bs.modal', function (e) {
            var data = $(e.relatedTarget).data();
            $('.title', this).text(data.recordTitle);
            $('.btn-ok', this).data('recordId', data.recordId);
        });
    });
</script>
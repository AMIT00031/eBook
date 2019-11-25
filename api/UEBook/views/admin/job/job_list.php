<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<div class="m-b-10">
    <div class="pull-left">
        <h3 class="pull-left">
            <strong>Job List</strong>
        </h3>
    </div>
    
</div>


<table id="list" class="table table-striped table-bordered">
    <thead>			                
    <th>Job Title</th>
    <th>Category</th>
    <th>Location</th>
    <th>Experience</th>
    <th>Compony</th>
    <th>Type</th>
    <th>Action</th>
</thead>
<tbody>
    <?php
    if (!empty($vehicles)) {
        foreach ($vehicles as $vehicle) {
            ?>
            <tr role="row" class="even">
                <td><?php echo!empty($vehicle->job_title) ? $vehicle->job_title : '' ?></td>
                <td><?php echo!empty($vehicle->category) ? $vehicle->category->name : '' ?></td>
                <td><?php echo!empty($vehicle->location) ? $vehicle->location : '' ?></td>
                <td><?php echo!empty($vehicle->experience) ? $vehicle->experience : '' ?></td>
                <td><?php echo!empty($vehicle->compony) ? $vehicle->compony : '' ?></td>
                <td><?php echo!empty($vehicle->type) ? $vehicle->type : '' ?></td>
                <td>
                    <a href="" style="margin-right: 22px;" class="" data-record-id="<?php echo $vehicle->id ?>" data-record-title="<?php echo $vehicle->model ?>" data-toggle="modal" data-target="#confirm-delete">
                        <i class="fa fa-trash fa-2x"></i>
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

<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript">

    $(document).ready(function () {
        var base_url = "<?php echo base_url(); ?>";
        /* TABLETOOLS */

        $('#list').dataTable();

        $('#confirm-delete').on('click', '.btn-ok', function (e) {
            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');
            var model = 'job_model';
            var msg = 'Something went wrong!';

            $.ajax({
                url: base_url + 'ajax_controller/deleteCommonAttribute',
                type: "POST",
                data: {id: id, deleteModel: model, successMsg: msg},
                success: function (res) {
                    var data = $.parseJSON(res);

                    if (data.response === 'true') {
                        location.reload();
                    } else {
                        alert('Something went wrong.')
                    }
                }
            })

        });

        $('#confirm-delete').on('show.bs.modal', function (e) {
            var data = $(e.relatedTarget).data();
            $('.title', this).text(data.recordTitle);
            $('.btn-ok', this).data('recordId', data.recordId);
        });
        
             $(document).on('change', '.vehicle_status', function (e) {
                e.preventDefault();
                var id = $(this).attr('vehicle-id');
                var status = $(this).attr('vehcile_status');

            $.ajax({
                url: base_url + 'ajax_controller/vehicle_approved',
                type: "POST",
                data: {id: id, vehicle_status: status},
                success: function (res) {
                    var data = $.parseJSON(res);
                    if (data.response === 'true') {
                        alert(data.message);
//                        location.reload();
                    } else {
                        alert('Vehicle status not updated! Something went wrong.')
                    }
                }

            })
        })
    });
</script>
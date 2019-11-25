<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap2/bootstrap-switch.css"/>

<div class="m-b-10">
    <div class="pull-left">
        <h3 class="pull-left">
            <strong>Settings</strong>
        </h3>
    </div>

    <!--    <div class="pull-right">
            <a href="<?php echo base_url('admin/category/add'); ?>" class="btn btn-primary">Add Category</a>
        </div>-->

</div>

<table id="datatable" class="table table-striped table-bordered trip">
    <thead>			                
    <th>Trip Minimum Allotted(%)</th>
    <th>Action</th>
</thead>
<tbody>
    <?php
    if (!empty($settings)) {
        foreach ($settings as $set) {
            ?>
            <tr role="row" class="even">
                <td><?php echo!empty($set->minimum_passenger_ratio_trip) ? $set->minimum_passenger_ratio_trip : '' ?></td>

                <td>

                    <a href="<?php echo base_url('admin/settings/update/' . $set->id) ?>" title="Change Setting" style="padding:10px;">
                        <i class="fa fa-edit fa-2x "></i>
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                <p>You are about to delete <b><i class="title"></i></b> record, this procedure is irreversible.</p>
                <p>Do you want to proceed?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-ok">Delete</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.js"></script>
<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";

    $(document).ready(function () {

        /* TABLETOOLS */

        $('#list').dataTable();

        $('#confirm-delete').on('click', '.btn-ok', function (e) {
            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');
            var model = 'trip_model';
            var msg = 'Selected Category successfully deleted!';


            $.ajax({
                url: base_url + 'ajax_controller/deleteCommonAttribute',
                type: "POST",
                data: {id: id, deleteModel: model, successMsg: msg},
                success: function (res) {
                    var data = $.parseJSON(res);

                    if (data.response === 'true') {
                        location.reload();
                    } else {
                        alert('Category not deleted! Something went wrong.')
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
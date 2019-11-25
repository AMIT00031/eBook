<div class="m-b-10">
    <div class="pull-left">
        <h3 class="pull-left">
            <strong>Job category</strong>
        </h3>
    </div>

    <div class="pull-right">
        <a href="<?php echo base_url('admin/jobs/add_category'); ?>" class="btn btn-primary">Add Category</a>
    </div>
</div>


<table id="list" class="table table-striped table-bordered">
    <thead>			                
    <th>Category Name</th>
    <th>Parent Category</th>
    <th>Added Date</th>
    <th>Action</th>
</thead>
<tbody>
    <?php
    $icon = '';
    if (!empty($categories)) {
        foreach ($categories as $category) {
            
            ?>
            <tr role="row" class="even">
                <td><?php echo!empty($category->name) ? $category->name : '' ?></td>
                <td><?php echo $category->parent_id == 0 ? 'Yes' : 'No' ?></td>
                <td><?php echo!empty($category->created_at) ? date("m-d-Y", strtotime($category->created_at)) : '' ?></td>
                <td>
                    <a class="btn btn-primary" href="<?php echo base_url('admin/jobs/edit/' . $category->id) ?>">Edit</a>
                    <a href="" class="btn btn-primary" data-record-id="<?php echo $category->id ?>" data-record-title="<?php echo $category->name ?>" data-toggle="modal" data-target="#confirm-delete">
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
    });
</script>
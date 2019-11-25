<script src="<?php echo base_url(); ?>assets/admin/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<div id="main" role="main">
    <?php $this->load->view('header/breadcrumb'); ?>

    <div id="content">
        <div class="m-b-10">
            <div class="pull-left">
                <h3 class="pull-left">
                    <strong>Role</strong>
                </h3>
            </div>
            <div class="pull-right">
                <a href="<?php echo base_url('admin/auth/create_group'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i>Add Role</a>
            </div>
        </div>
        <section class="" id="widget-grid">

            <!-- row -->
            <div class="row">

                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">

                    <div data-widget-editbutton="false" id="wid-id-0" class="jarviswidget jarviswidget-color-darken" role="widget">
                        <header role="heading">
                            <h2><?= $list_heading ?></h2>
                        </header>
                        <div role="content">
                            <div class="widget-body no-padding">
                                <div id="dt_basic_wrapper" class="dataTables_wrapper form-inline no-footer">
                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer" id="list" role="grid">
                                        <thead>			                
                                            <tr role="row">
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($group_list)) {
                                                foreach ($group_list as $group) {
                                                    ?>
                                                    <tr role="row" class="even">
                                                        <td><?php echo!empty($group->name) ? htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8') : '' ?></td>
                                                        <td><?php echo!empty($group->description) ? htmlspecialchars($group->description, ENT_QUOTES, 'UTF-8') : '' ?></td>
                                                        <td class="text-center">
                                                            <a class="btn btn-primary" href="<?php echo base_url('admin/auth/edit_group/'.$group->id)?>">Edit</a>
                                                            <a class="btn btn-primary" href="<?php echo base_url('admin/users/permission_to_role/'.$group->id)?>">Permission</a>
                                                            <?php if ($this->ion_auth->is_admin()) { ?>
                                                                <a href="" class="btn btn-primary" data-record-id="<?php echo $group->id ?>" data-record-title="<?php echo $group->name ?>" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-times-circle"></i>
                                                                    Delete
                                                                </a>
                                                            <?php } ?>
                                                        </td>
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
                    </div>
                </article>
            </div>
        </section>
    </div>
</div>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Ã—</button>
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
<script type="text/javascript">

    $(document).ready(function () {

        var base_url = "<?php echo base_url(); ?>";

        $('#list').dataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" +
                    "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth": true,
        });


        $('#confirm-delete').on('click', '.btn-ok', function (e) {
            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');
            var model = 'Role_model';
            var msg = 'Selected Role successfully deleted!';


            $.ajax({
                url: base_url + 'AjaxController/deleteCommonAttribute',
                type: "POST",
                data: {id: id, deleteModel: model, successMsg: msg},
                success: function (res) {
                    var data = $.parseJSON(res);

                    if (data.response === 'true') {
                        location.reload();
                    } else {
                        alert('Role not deleted! Something went wrong.')
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
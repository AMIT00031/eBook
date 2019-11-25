 <meta http-equiv="refresh" content="15" />
<?php $this->load->view('header/breadcrumb'); ?>

<div class="m-b-10">
    <div class="pull-left">
        <h3 class="pull-left">
            <strong><?php echo $this->lang->line('user_user'); ?></strong>
        </h3>
    </div>
    <div class="pull-right">
       
    </div>
</div>

<!-- row -->
<div class="row">

    <table id="datatable" class="table table-striped table-bordered">
        <thead>			                
            <tr role="row">
                <th><?php echo $this->lang->line('user_name'); ?></th>
                <th><?php echo $this->lang->line('email'); ?></th>
            
                <th><?php echo $this->lang->line('action'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($users)) {
                foreach ($users as $user) {
                    ?>
                    <tr role="row" class="even">
                        <td class=""><?php echo!empty($user->user_name) ? $user->user_name : '' ?></td>
                        <td class=""><?php echo!empty($user->email) ? $user->email : '-' ?> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                        
                        
                        
                        <?php if($user->chatmessage>0) { ?><span style="color:green;" id="newmessages">New Message &nbsp; <i class="fa fa-envelope-o" aria-hidden="true"></i></span><?php } ?></td>
                      
                        <td>
                            <a href="userchat?id=<?php echo $user->id ?>" class="btn btn-primary" data-record-id="<?php echo $user->id ?>" data-record-title="<?php echo $user->username ?>" target="_blank" >
                                <?php echo $this->lang->line('updatechat'); ?>
                            </a>
                               
                            
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
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

        $('#confirm-delete').on('click', '.btn-ok', function (e) {
            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');
            var model = 'user_model';
            var msg = 'Selected Currency successfully deleted!';


            $.ajax({
                url: base_url + 'ajaxController/deleteCommonAttribute',
                type: "POST",
                data: {id: id, deleteModel: model, successMsg: msg},
                success: function (res) {
                    var data = $.parseJSON(res);

                    if (data.response === 'true') {
                        location.reload();
                    } else {
                        alert('User not deleted! Something went wrong.')
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
<script src="<?php echo base_url(); ?>assets/admin/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/plugin/datatables/dataTables.bootstrap.min.js"></script>

<div id="main" role="main">
    <?php $this->load->view('header/breadcrumb'); 
    
// dump($banner_list)
    ?>
    <div id="content">
        <div class="m-b-10">
           <div class="pull-left">
               <h3 class="pull-left">
                   <strong>Pages List</strong>
               </h3>
           </div>
         <?php/*  <div class="pull-right">
               <a href="<?php echo base_url('admin/pages/addPage');?>" class="btn btn-primary"><i class="fa fa-plus"></i>Add Page</a>
           </div> */?>
       </div>
        <section class="" id="widget-grid">
            
            <!-- row -->
            <div class="row">

                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">

                    <div data-widget-editbutton="false" id="wid-id-0" class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" role="widget">
                        <header role="heading">
                            <h2><?=$list_heading?></h2>
                        </header>
                        <div role="content">

                            <div class="widget-body no-padding">
                                <div id="dt_basic_wrapper" class="dataTables_wrapper form-inline no-footer">
                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer" id="dt_basic" role="grid" aria-describedby="dt_basic_info" style="width: 100%;">
                                        <thead>			                
                                                <th>Page</th>                                               
                                                <th>Status</th>
                                                <th class="sorting">Action</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($page_list)) {
                                                foreach ($page_list as $page) {
                                                       ?>
                                                    <tr role="row" class="even">
                                                        <td class=" expand"><span class="responsiveExpander"></span>
                                                            <?php echo !empty($page->page) ? $page->page : '' ?>
                                                        </td>
                                                      
                                                        <td class=" expand"><span class="responsiveExpander"></span>
                                                            <?php echo ($page->status == 1) ? 'Active' : 'Inactive'?>
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-primary" href="<?php echo base_url('admin/pages/addpage/'.$page->id)?>">Edit</a>
                                                          
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } ?>
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

<script type="text/javascript">

    $(document).ready(function () {
        var base_url = "<?php echo base_url(); ?>";
        /* TABLETOOLS */
        
         $('#dt_basic').dataTable({
             "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" +
            "t" +
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth": true,
        });
        
         $('#confirm-delete').on('click', '.btn-ok', function (e) {
            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');
            var model = 'Page_model';
            var msg = 'Selected Tour type successfully deleted!';
            
            
            $.ajax({
                url: base_url + 'AjaxController/deleteCommonAttribute',
                type: "POST",
                data: {id: id,deleteModel: model,successMsg: msg},
                success: function (res) {
                    var obj = $.parseJSON(res);
                    
                    if (obj.response === 'true') {
                        location.reload();
                    }else{
                        alert('Page Not Deleted!')
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
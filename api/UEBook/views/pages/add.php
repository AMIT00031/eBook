
<div id="main" role="main">
    <?php $this->load->view('header/breadcrumb');
    ?>
    <div id="content">

        <section id="widget-grid" class="">
            <div data-widget-editbutton="false" id="8521cbb7b77c1acb05ccf76f73014447" class="jarviswidget jarviswidget-sortable" role="widget">
                <div role="content">
                    <div class="widget-body ">
                        <div class="tabbable">
                            <ul class="nav nav-tabs bordered">
                                <li class="active">
                                    <a data-placement="top" rel="tooltip" data-toggle="tab" href="#tab1" data-original-title="" title="" aria-expanded="false">
                                        Basic Information
                                    </a>
                                </li>
                                <li class="">
                                    <a data-placement="top" rel="tooltip" data-toggle="tab" href="#tab2" data-original-title="" title="" aria-expanded="true">
                                        SEO
                                    </a>
                                </li>

                            </ul>
                            <form class="smart-form" id="country-form" novalidate="novalidate" data-parsley-validate="" novalidate="" method="post" enctype="multipart/form-data" action="<?php echo current_url() ?>">
                                <div class="tab-content padding-10">
                                    <div id="tab1" class="tab-pane active">
                                        <div class="row">
                                            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <fieldset>
                                                    <section>
                                                            <label class="label">Page Title</label>
                                                             <input type="text" placeholder="Page Title" name="page" required="" value="<?php echo!empty($page_data->page) ? $page_data->page : ''; ?>">
                                                                               
                                                        </section>

                                                   

                                                    <section>
                                                        <label class="label">Description</label>
                                                        <label class="textarea"> 										
                                                            <textarea class="custom-scroll" rows="60"  name="description"><?php echo!empty($page_data->description) ? $page_data->description : ''; ?></textarea> 
                                                        </label>
                                                    </section>

                                                    <section>
                                                        <div class="inline-group">
                                                            <label class="label">Status</label>
                                                            <label class="radio state-error">
                                                                <input type="radio" <?php echo isset($page_data->status) && ($page_data->status == 1) ? 'checked' : 'checked' ?> value= 1 name="status">
                                                                <i></i>Active</label>
                                                            <label class="radio state-error">
                                                                <input type="radio" name="status" value=0 <?php echo isset($page_data->status) && ($page_data->status == 0) ? 'checked' : '' ?>>
                                                                <i></i>Inactive</label>
                                                        </div>
                                                    </section>
                                                </fieldset>
                                            </article>
                                        </div>

                                    </div>
                                    <div id="tab2" class="tab-pane">
                                        <div class="row">
                                            <fieldset>
                                                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <fieldset>
                                                        <section>
                                                            <label class="label">Meta Title</label>
                                                            <label class="input"> 
                                                                <input type="text" placeholder="Meta Title" name="meta_title" required="" value="<?php echo!empty($page_data->meta_title) ? $page_data->meta_title : ''; ?>">
                                                            </label>
                                                        </section>


                                                        <section>
                                                            <label class="label">Meta Description</label>
                                                            <label class="textarea"> 										
                                                                <textarea rows="3" name="meta_description"><?php echo!empty($page_data->meta_description) ? $page_data->meta_description : ''; ?></textarea> 
                                                            </label>
                                                        </section>
                                                        
                                                        
                                                          <section>
                                                            <label class="label">Page Uri Segment</label>
                                                            <label class="input"> 
                                                                <input type="text" placeholder="page uri" name="page_uri" required="" value="<?php echo!empty($page_data->page_uri) ? $page_data->page_uri : ''; ?>">
                                                            </label>
                                                        </section>

                                                    </fieldset>
                                                </article>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <footer>
                                        <button class="btn btn-primary" type="submit">
                                            <?php echo!empty($activity_data->id) ? 'Update' : 'Submit'; ?>
                                        </button>
                                    </footer>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
<script src="<?php echo base_url(); ?>assets/admin/js/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
        var baseUrl = "<?php echo base_url(); ?>";
        $(document).ready(function() {
            CKEDITOR.replace('description');
});

</script>
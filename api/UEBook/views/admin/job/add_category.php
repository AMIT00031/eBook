<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_category'); ?></h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <form class="form-horizontal form-label-left"   data-parsley-validate=""  method="post" enctype="multipart/form-data" action="<?php echo current_url() ?>">

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">

                        <div class="x_content">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name<span class="required">*</span>
                                </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="Category Name" required="" name="name"  class="form-control col-md-7 col-xs-12">
                                    </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Parent Category<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="parent_id" class="form-control">
                                        <option value="0"> Select Parent Category</option>
                                        <?php foreach ($category as $key => $val): ?>
                                            <option value="<?php echo $key ?>" ><?php echo $val ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="description" rows="5" placeholder="Enter Description" class="form-control col-md-7 col-xs-12"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php echo $this->lang->line('status'); ?></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div style="margin-top: 10px;">
                                        Active
                                        <div class="iradio_flat-green"><input type="radio" class="flat" name="status"  value="1" checked=""></div> 
                                        Inactive:
                                        <div class="iradio_flat-green"><input type="radio" class="flat" name="status" value="0" ></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset"><?php echo $this->lang->line('reset'); ?></button>
                    <button type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                </div>
            </div>

        </form>
    </div>
</div>
</div>

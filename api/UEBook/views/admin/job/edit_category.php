<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-plus"></i> <?php echo $this->lang->line('edit_category'); ?></h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <form class="form-horizontal form-label-left"   data-parsley-validate=""  method="post" enctype="multipart/form-data" action="<?php echo current_url() ?>">

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">

                        <div class="x_content">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php echo $this->lang->line('name'); ?> <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" placeholder="Vehicle Category Name" value="<?php echo !empty($edit_data->name) ? $edit_data->name : ''?>" required="" name="name"  class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php echo $this->lang->line('maximum_seat_capacity'); ?><span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" placeholder="Maximum Seat Capacity" value="<?php echo !empty($edit_data->maximum_seat_capacity) ? $edit_data->maximum_seat_capacity : ''?>" required="" data-parsley-type="digits" name="maximum_seat_capacity"  class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php echo $this->lang->line('minimum_seat_capacity'); ?><span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" placeholder="Minimum Seat Capacity" required="" data-parsley-type="digits" value="<?php echo !empty($edit_data->minimum_seat_capacity) ? $edit_data->minimum_seat_capacity : ''?>" name="minimum_seat_capacity"  class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php echo $this->lang->line('small_trip_range'); ?><span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" placeholder="Small Trip Range" value="<?php echo !empty($edit_data->small_trip_range) ? $edit_data->small_trip_range : ''?>" required="" data-parsley-type="digits" name="small_trip_range"  class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php echo $this->lang->line('price_per_km_small'); ?><span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" placeholder="R$- Small Trip Price/Km" value="<?php echo !empty($edit_data->small_trip_price_per_km) ? $edit_data->small_trip_price_per_km : ''?>" required=""  name="small_trip_price_per_km"  class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            
                            
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php echo $this->lang->line('Price/km-(Large)'); ?><span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" placeholder="R$- Large Trip Price/Km" value="<?php echo !empty($edit_data->large_trip_price_per_km) ? $edit_data->large_trip_price_per_km : ''?>" required="" name="large_trip_price_per_km"  class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php echo $this->lang->line('descriptions'); ?></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="description" placeholder="Enter Description"  class="form-control col-md-7 col-xs-12"><?php echo !empty($edit_data->description) ? $edit_data->description : ''?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php echo $this->lang->line('status'); ?></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div style="margin-top: 10px;">
                                        <?php echo $this->lang->line('active'); ?>
                                        <div class="iradio_flat-green"><input type="radio" class="flat" name="status"  value="1" <?php echo $edit_data->status == 1 ? 'checked' : ''?>></div> 
                                        <?php echo $this->lang->line('inactive'); ?>:
                                        <div class="iradio_flat-green"><input type="radio" class="flat" name="status" value="0" <?php echo $edit_data->status == 0 ? 'checked' : ''?> ></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url('admin/vehicle/category')?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                    <button type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?></button>
                </div>
            </div>

        </form>
    </div>
</div>
</div>

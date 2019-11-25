<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-plus"></i> Update Settings</h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <form class="form-horizontal form-label-left"   data-parsley-validate=""  method="post" enctype="multipart/form-data" action="<?php echo current_url() ?>">

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">

                        <div class="x_content">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Trip Minimum Alloted(%)<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" placeholder="Enter Percentage" required="" value="<?php echo !empty($edit_data->minimum_passenger_ratio_trip) ? $edit_data->minimum_passenger_ratio_trip : ''?>" data-parsley-type="digits" name="minimum_passenger_ratio_trip"  class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url('admin/settings')?>" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>

        </form>
    </div>
</div>
</div>

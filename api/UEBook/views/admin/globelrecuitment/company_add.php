<style>
.disp {
    width: 100%;
    height: 148px;
}
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Add Company</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <br>
                <form class="form-horizontal form-label-left"   data-parsley-validate=""  method="post" enctype="multipart/form-data" action="<?php echo current_url() ?>">
              
				
					<div class="form-group">
					
							<div class="col-sm-2"><label class="control-label">Company *</label></div>
							<div class="col-sm-10"><input type="text" name="clasifiedcompany_name" value="" required="required" class="form-control" placeholder="Title">
						    <?php echo form_error('clasifiedcompany_name') ? '<span class="error">'.form_error('clasifiedcompany_name').'</span>' : ''?>
					</div></div>
					


                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                           
                            <button type="submit" class="btn btn-success" name="submit">Submit</button>
                        </div>
                    </div>

                </form>
				
				
            </div>
        </div>
    </div>
</div>

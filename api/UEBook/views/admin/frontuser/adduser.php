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
                <h2><?php echo $list_heading; ?></h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <br>
                <form class="form-horizontal form-label-left"   data-parsley-validate=""  method="post" enctype="multipart/form-data" action="<?php echo current_url() ?>">
              
				
					<div class="form-group">
					
							<div class="col-sm-2"><label class="control-label">First Name *</label></div>
							<div class="col-sm-10"><input type="text" name="username" value="" required="required" class="form-control" placeholder="First Name" required>
							</div>
							<div class="col-sm-2"><label class="control-label">last Name *</label></div>
							<div class="col-sm-10"><input type="text" name="lastname" value="" required="required" class="form-control" placeholder="last name">
							</div>
							<div class="col-sm-2"><label class="control-label">Password *</label></div>
							<div class="col-sm-10"><input type="text" name="password" value="" required="required" class="form-control" placeholder="password">
							</div>
							<div class="col-sm-2"><label class="control-label">Location *</label></div>
							<div class="col-sm-10"><input type="text" name="location" value="" required="required" class="form-control" placeholder="location">
							</div>
							<div class="col-sm-2"><label class="control-label">Email *</label></div>
							<div class="col-sm-10"><input type="text" name="email" value="" required="required" class="form-control" placeholder="email">
							</div>
							<div class="col-sm-2"><label class="control-label">Phone *</label></div>
							<div class="col-sm-10"><input type="text" name="phone" value="" required="required" class="form-control" placeholder="phone">
							</div>
							<div class="col-sm-2"><label class="control-label">Company *</label></div>
							<div class="col-sm-10"><input type="text" name="company" value="" required="required" class="form-control" placeholder="company">
							</div>
					</div>
					


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

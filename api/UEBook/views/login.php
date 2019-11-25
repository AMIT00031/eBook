<style>
    .parsley-errors-list filled{float:left !important;}
    .parsley-required{float:left !important;}
    
    
    .login_form{border: 1px solid;
    width: 130%;
    padding: 0px 30px 0px 30px;}
    
</style>


<div class="animate form login_form">
    <section class="login_content">
        <form action="<?php echo site_url() . 'admin/auth/login' ?>" data-parsley-validate="" method="post" id="login-form">
            <h1>Admin Login</h1>
            <div>
                <input type="text" name="email" class="form-control" placeholder="Username" required="" />
            </div>
            <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
            </div>
            <div>
                <input type="submit" class="btn btn-default submit" value="Login"/>
                <a class="reset_pass" href="#">Lost your password?</a>
            </div>

            <div class="clearfix"></div>

            <div class="separator">

                <div class="clearfix"></div>
                <br />

                <div>
                    <h1><i class="fa fa-paw"></i></h1>
                    <p>©<?php echo date('Y-m-d'); ?> All Rights Reserved. </p>
                </div>
            </div>
        </form>
    </section>
</div>
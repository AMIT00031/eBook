<style>

    .trip-number{

        text-align: center;

        font-size: 72px;

        font-weight: 600;

        padding: 13px;

        color: #1b3e63;

    }

    .head{text-align: center;

    text-transform: uppercase;

    font-weight: bold;

    color: #000;}

    .box_wrapper{}

</style>

<div class="row tile_count">

    <h1><?php echo $this->lang->line('welcome_admin_text'); ?></h1>

</div>

<div class="row">

    <div class="box_wrapper">

        

        <!--<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 box">

            <h3 class="head"><?php echo $this->lang->line('new_trip'); ?></h3>

            <h1 class="trip-number"><a href="<?php echo base_url()?>admin/chatusers"><?php echo !empty($new_customer->numrows) ? $new_customer->numrows  : '0'?></a></h1>

        </div>-->

    </div>



   <!-- <div class="box_wrapper">

        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 box">

            <h3 class="head"><?php echo $this->lang->line('total_trip'); ?></h3>

            <h1 class="trip-number"><?php echo !empty($total_trips->numrows) ? $total_trips->numrows  : '0'?></h1>

        </div>

    </div>



    <div class="box_wrapper">

        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 box">

            <h3 class="head"><?php echo $this->lang->line('new_customer'); ?></h3>

            <h1 class="trip-number"><?php echo !empty($new_customer->numrows) ? $new_customer->numrows  : '0'?></h1>

        </div>

    </div>-->

    <div class="clearfix"></div>

    <hr>

    

    

    <!--<div class="box_wrapper">

        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 box">

            <h3 class="head"><?php echo $this->lang->line('total_partner'); ?></h3>

            <h1 class="trip-number"><?php echo !empty($total_partners) ? $total_partners  : '0'?></h1>

        </div>

    </div>

    

    

    <div class="box_wrapper">

        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 box">

            <h3 class="head"><?php echo $this->lang->line('total_drivers'); ?></h3>

            <h1 class="trip-number"><?php echo !empty($total_drivers) ? $total_drivers->count  : '0'?></h1>

        </div>

    </div>-->

    

    

</div>




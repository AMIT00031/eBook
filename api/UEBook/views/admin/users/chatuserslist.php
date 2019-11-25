<?php $this->load->view('header/breadcrumb'); ?>
 <meta http-equiv="refresh" content="10" />
<style>
    .alert-danger, .alert-error {
    color: #000!important;
    font-size: 18px!important;
  
    background-color: #fff!important;
    border: 1px solid #000!important;
   
    margin-left: 200px!important;
}
.alert-success {
    color: #0c0c0c!important;
    font-size: 18px!important;
    font-weight: 500!important;

    background-color: #f1f1f1!important;
    border: 1px solid #000!important;
}
</style>
<div class="m-b-10">
    <div class="pull-left">
        <h3 class="pull-left">
            <strong><?php echo $this->lang->line('chatadmin_user'); ?></strong>
        </h3>
    </div>
    <div class="pull-right">
      
    </div>
</div>

<!-- row -->
<div class="row">
    <?php  if (!empty($message)) { ?>
<div class="alert-success"><?php echo $message; ?></div>
<?php  }?>
    <table width="100%">
         <?php
            if (!empty($users)) {
                foreach ($users as $user) {
                 if($user->bymessage=='admin') {
                 
                    ?>
                    <tr><td colspan='2'>&nbsp;</td></tr>
        <tr ><td width="20%"><b><?php echo!empty($user->bymessage) ? $user->bymessage : '-' ?></b></td><td width="10%"></td><td class="alert-success" width="60%"><?php echo!empty($user->message) ? $user->message : '-' ?></td></tr>
        <?php } else {?>
        <tr><td colspan='2'>&nbsp;</td></tr>
        <tr ><td  width="20%"><b><?php echo!empty($username) ? $username : '-' ?></b></td><td width="10%"></td><td class="alert-error" width="60%"><?php echo!empty($user->message) ? $user->message : '-' ?></td></tr>
        
        <?php } ?>
        
           <?php
                }
            }
            ?>
            <form action="" method="post">
             <tr><td colspan='3'>&nbsp;</td></tr>
            <tr><td colspan='3'>
                <input type="hidden" name="toid" value="<?php echo $_GET['id']; ?>">
                 <input type="hidden" name="fromid" value="2">
                  <input type="hidden" name="bymessage" value="admin">
                <textarea rows="3" name="message" style="width: 90%; "required></textarea></td></tr>
             <tr><td colspan='3'>&nbsp;</td></tr>
            <tr><td colspan='3'>
                <input type="submit" name="submit" class="btn btn-primary" value="Submit">
               </td></tr>
    </table>
</div>


 <script type="text/javascript">     $('.carousel').carousel();    </script>
 <!-- =================== PLUGIN JS ==================== -->
  <script src="<?php echo base_url()?>assets/front/vendor/jquery-3.2.1.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url()?>assets/front/vendor/wow/wow.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url()?>assets/front/vendor/lightbox2/src/<?php echo base_url()?>assets/front/js/lightbox.js" type="text/javascript"></script>
  <script src="<?php echo base_url()?>assets/front/vendor/bootstrap4/popper.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url()?>assets/front/vendor/bootstrap4/bootstrap.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url()?>assets/front/vendor/owl-carousel/owl.carousel.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url()?>assets/front/vendor/revolution/jquery.themepunch.revolution.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url()?>assets/front/vendor/revolution/jquery.themepunch.tools.min.js" type="text/javascript"></script>
  <!-- Local Revolution -->
  <script type="text/javascript" src="<?php echo base_url()?>assets/front/vendor/revolution/local/revolution.extension.migration.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/front/vendor/revolution/local/revolution.extension.actions.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/front/vendor/revolution/local/revolution.extension.carousel.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/front/vendor/revolution/local/revolution.extension.kenburn.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/front/vendor/revolution/local/revolution.extension.layeranimation.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/front/vendor/revolution/local/revolution.extension.navigation.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/front/vendor/revolution/local/revolution.extension.parallax.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/front/vendor/revolution/local/revolution.extension.slideanims.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/front/vendor/revolution/local/revolution.extension.video.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      lightbox.option({
        'resizeDuration': 200,
        'wrapAround': false,
        'alwaysShowNavOnTouchDevices': true,
      });
    });
  </script>

      <script type="text/javascript">
       // $(document).ready(function(){
       //   var h = window.innerHeight;
       //   $(".design_body").css({'height':h});

       // });
      /* $(window).on('load',function(){
        var headerh = 155;
         var windH = $(window).height();
         var orginalh = windH - headerh;
        $(".design_body").css({'height':orginalh});
       }); */
      
    </script>

    
    <script> 
    $(document).ready(function(){
      $("#flip1").click(function(){
        $("#design_tab_1").slideToggle("medium");
      });
    });
     </script>
     <script> 
    $(document).ready(function(){
      $("#flip2").click(function(){
        $("#design_tab_2").slideToggle("medium");
      });
    });
     </script>
     <script> 
    $(document).ready(function(){
      $("#flip3").click(function(){
        $("#design_tab_3").slideToggle("medium");
      });
    });
    </script>

  <!-- =================== CUSTOM JS ==================== -->
  <script type="text/javascript" src="<?php echo base_url()?>assets/front/js/main.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/front/js/revo-custom.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/front/js/wow-custom.js"></script>

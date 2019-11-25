<?php
//dump($sliders);
?>
<section class="rev_slider_wrapper">
    <div id="slider1" class="rev_slider"  data-version="5.0">
        <?php
        $slider_img_src = '';
        if (!empty($sliders)) {
            echo '<ul>';
            foreach ($sliders as $slider) {
                if (!empty($slider->banner_content)) {
                    $slider_img_src = base_url('uploads/banner/' . $slider->banner_content);
                }
                ?>
                <li data-transition="fade">
                    <img src="<?= $slider_img_src ?>"  alt="" width="1920" height="700" data-bgposition="top center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="1">
                    <div class="tp-caption  tp-resizeme" 
                         data-x="left" data-hoffset="0" 
                         data-y="top" data-voffset="270" 
                         data-transform_idle="o:1;"         
                         data-transform_in="x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0.01;s:3000;e:Power3.easeOut;" 
                         data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;" 
                         data-mask_in="x:[100%];y:0;s:inherit;e:inherit;" 
                         data-splitin="none" 
                         data-splitout="none"
                         data-responsive_offset="on"
                         data-start="1500">
                        <div class="slide-content left-slide">
                            <div class="title"><?= !empty($slider->heading) ? $slider->heading : '' ?></div>
                            <div class="big-title"><?= !empty($slider->bigtitle) ? $slider->bigtitle : '' ?></div>
                            <div class="text"><?= !empty($slider->small_title) ? $slider->small_title : '' ?></div>
                            <div class="btns-box">
                                <a href="<?= !empty($slider->button_1_link) ? $slider->button_1_link : '' ?>" class="thm-btn pdone"><?= !empty($slider->button1_text) ? ucfirst($slider->button1_text) : '' ?></a>&ensp; 
                                <a href="<?= !empty($slider->button_2_link) ? $slider->button_2_link : '' ?>" class="thm-btn btn-style-two pdtwo"><?= !empty($slider->button2_text) ? ucfirst($slider->button2_text) : '' ?></a> 
                            </div>
                        </div>
                    </div>
                </li>
                <?php
            }
            echo '</ul>';
        }
        ?>

    </div>
</section>
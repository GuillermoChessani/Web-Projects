<?php
/**
 * @package OS_ImageGallery_Free
 * @subpackage  OS_ImageGallery_Free
 * @copyright Andrey Kvasnevskiy-OrdaSoft(akbet@mail.ru); Anton Panchenko(nix-legend@mail.ru); 
 * @Homepage: http://www.ordasoft.com
 * @version: 1.0 
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * */
defined('_JEXEC') or die; ?>
 <noscript> Javascript is required to use OS Responsive Image Gallery <a href="http://ordasoft.com/os-image-gallery.html"> OS Responsive Image Gallery is free simple and easy Responsive Image Gallery Joomla module with drag and drop feature</a>, <a href="http://ordasoft.com/os-image-gallery.html"> OS Responsive Image Gallery has free and premium version </a></noscript>
<div id="osgallery<?php echo $module->id;?>" class="imageGallery <?php echo $sufix ?> os_gallery_<?php echo $module->id;?>">

          <?php
          $dir = "images/os_imagegallery_$module->id";
            $images = json_decode(base64_decode($params->get('imagezer')));

            if(isset($images) && count($images) > 0):

                $i=0;
                $seting_relation = abs($width/$height);
                $temp_relation = 0;
                $good_relation = 0;
                $best_relation =100;                

                foreach ($images as $image):
                    $temp_original_img = "{$dir}/original/{$image->file}";
                    if (JFile::exists($temp_original_img)) {
                        $info = getimagesize($temp_original_img);
                        $temp_relation = abs($info[0]/$info[1]);                      
                        $good_relation = abs($seting_relation-$temp_relation);
                        if($good_relation<$best_relation){
                            $best_relation = $good_relation;
                            $num_img = $i;
                        }
                    }
                    $i++;
              endforeach;
		            $i=0;
		         foreach ($images as $i=>$image):
                  createImage("{$dir}/original/{$image->file}", "{$dir}/thumbnail/{$image->file}", $width, $height, true,100);
                  $alt = ($image->alt) ? " alt='".$image->alt."' title='".$image->alt."' " :"";
                    if($i%$img_in_row==0 && $i!=0) echo '</div>';
                    if($i%$img_in_row==0) echo '<div class="rowImages">';
                    ?>
                      <a href="<?php echo  JURI::root() . $dir.'/original/'.$image->file; ?>" rel="group" class="fancybox"><!-- original img -->
                        <?php if(empty($image->name)): ?><span class="overlay"><i class="lens"></i></span><?php endif; ?>
                          <?php if(!empty($image->name)): ?><span class="overlay"><h3><?php echo $image->name ?></h3></span><?php endif; ?>
                        <img src="<?php echo JURI::root() . $dir.'/thumbnail/'.$image->file; ?>" <?php echo $alt; ?> /><!-- thumbnail img -->
                      </a>
                  <?php 
              endforeach;
            endif;
          ?>
      </div>
</div>

<script type="text/javascript">
  jQuery(document).ready(function(){
        var widwind = jQuery(window).width();
        var img = jQuery('#osgallery<?php echo $module->id;?> .fancybox');
        var iminrow = <?php echo $img_in_row;?>;
        var ele = Math.round((100/iminrow)-3.5);
            img.css({width: ele+'%'});

        if (widwind <= 1200) {img.css({width: '30%'});}
        if (widwind <= 1024) {img.css({width: '27%'});}
        if (widwind <= 980) {img.css({width: '46%'});}
        if (widwind <= 768) {img.css({width: '46%'});}
        if (widwind <= 600) {img.css({width: '62%'});}
        if (widwind <= 480) {img.css({width: '66%'});}
        if (widwind <= 320) {img.css({width: '93%'});}

      jQuery(window).resize(function() {
        var widwind = jQuery(window).width();
        var img = jQuery('#osgallery<?php echo $module->id;?> .fancybox');
        var iminrow = <?php echo $img_in_row;?>;
        var ele = Math.round((100/iminrow)-3.5);
            img.css({width: ele+'%'});

        if (widwind <= 1200) {img.css({width: '30%'});}
        if (widwind <= 1024) {img.css({width: '27%'});}
        if (widwind <= 980) {img.css({width: '46%'});}
        if (widwind <= 768) {img.css({width: '46%'});}
        if (widwind <= 600) {img.css({width: '62%'});}
        if (widwind <= 480) {img.css({width: '66%'});}
        if (widwind <= 320) {img.css({width: '93%'});}
      });
  });
</script>
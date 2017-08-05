<?php
/*
# ------------------------------------------------------------------------
# Extensions for Joomla 2.5.x - Joomla 3.x
# ------------------------------------------------------------------------
# Copyright (C) 2011-2013 Ext-Joom.com and Eco-Joom.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2.
# Author: Ext-Joom.com and Eco-Joom.com
# Websites:  http://www.ext-joom.com 
# Websites:  http://www.eco-joom.com 
# Date modified: 06/10/2013 - 13:00
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die;
if(!defined('DS')){
	define('DS',DIRECTORY_SEPARATOR);
}
?>


<?php
	
$document->addCustomTag('
<style type="text/css">
.box_skitter_'.$ext_id.', .box_skitter_'.$ext_id.' img {
	width: '.$width.'px;
	height: '.$height.'px;
	}		
.box_skitter_'.$ext_id.' .progressbar {
	background:'.$color_progressbar.';
}
</style>');
?>


<script type="text/javascript">
jQuery(document).ready(function() {	
    jQuery('.box_skitter_<?php echo $ext_id; ?>').skitter({
	velocity: <?php echo $velocity; ?>,
	interval: <?php echo $interval; ?>,
	animation: '<?php echo $animations; ?>',
	auto_play: <?php echo $auto_play;?>,
	focus: <?php echo $focus;?>,
	focus_position: '<?php echo $focus_position;?>',
	navigation: <?php echo $navigation?>,
	<?php if ($navigation_button != 'none') {
				if ($navigation_button == 'numbers') { echo 'numbers:true,';}
				if ($navigation_button == 'dots') {  echo 'dots:true,';}
				if ($navigation_button == 'thumbs') {  echo 'thumbs:true,';}
			} else { 
					echo 'numbers:false,';
				} ?>	
	label: <?php echo $label; ?>,
	labelAnimation: '<?php echo $label_animation;?>',
	hideTools: <?php echo $hideTools; ?>,
	fullscreen: <?php echo $fullscreen; ?>,
	width_label: '<?php echo $width_label; ?>',
	show_randomly: <?php echo $show_randomly; ?>,
	controls: <?php echo $controls;?>,
	controls_position: '<?php echo $controls_position;?>',
	progressbar: <?php echo $progressbar;?>,
	enable_navigation_keys: <?php echo $enable_nav_keys;?>,
	animateNumberOut: {backgroundColor:'<?php echo $background_Out; ?>', color:'<?php echo $color_Out; ?>'},
	animateNumberOver: {backgroundColor:'<?php echo $background_Over; ?>', color:'<?php echo $color_Over; ?>'},
	animateNumberActive: {backgroundColor:'<?php echo $background_Active; ?>', color:'<?php echo $color_Active; ?>'},
	numbers_align: '<?php echo $numbers_align; ?>',
	easing_default: '<?php echo $easing; ?>',
	theme: '<?php echo $theme; ?>'
	});
});
</script>

<div class="mod_ext_skitter_slideshow_phoca_gallery <?php echo $moduleclass_sfx ?>">	
	<div class="box_skitter box_skitter_<?php echo $ext_id; ?>">
		<ul>				
		<?php	
		foreach ($images as $k => $v) {
			$thumbLink	= PhocaGalleryFileThumbnail::getThumbnailName($v->filename, 'large');
			echo '<li>';
			echo '<a href="#"><img src="'.JURI::base(true).'/'.$thumbLink->rel.'" alt="'.htmlspecialchars($v->title).'" /></a>';
			if ($label == true) {
			echo '<div class="label_text">
						<h4>'.htmlspecialchars( $v->title).'</h4>
						<div>'.($v->description).'</div>
				 </div>';
			}
			echo '</li>';
		}	
		?>
		</ul>	
	</div>
	<div style="clear:both;"></div>
</div>
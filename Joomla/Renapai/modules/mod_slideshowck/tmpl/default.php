<?php
/**
 * @copyright	Copyright (C) 2012 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * Module Slideshow CK
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');

// définit la largeur du slideshow
$width = ($params->get('width') AND $params->get('width') != 'auto') ? ' style="width:' . $params->get('width') . 'px;"' : '';
?>
<!-- debut Slideshow CK -->
<div class="slideshowck<?php echo $params->get('moduleclass_sfx'); ?> camera_wrap <?php echo $params->get('skin'); ?>" id="camera_wrap_<?php echo $module->id; ?>"<?php echo $width; ?>>
	<?php
	for ($i = 0; $i < count($items); ++$i) {
		if ($params->get('displayorder', 'normal') == 'shuffle' && $params->get('limitslides', '') && $i >= $params->get('limitslides', ''))
			break;
		$item = $items[$i];
		if ($item->imgalignment != 'default') {
			$dataalignment = ' data-alignment="' . $item->imgalignment . '"';
		} else {
			$dataalignment = '';
		}
		$datacaption = str_replace("|dq|", "\"", $item->imgcaption);
		if ($item->article) {
			$articletitletag = $params->get('articletitle', 'h3');
			$articlelink = $params->get('articlelink', 'readmore');
			if ($params->get('showarticletitle', '1') == '1') {

				$datacaption .= '<' . $articletitletag . ' class="camera_caption_articletitle">'
						. (($articlelink == 'title') ? '<a href="' . $item->article->link . '">' . $item->article->title . '</a>' : $item->article->title)
						. '</' . $articletitletag . '>';
			}
			$datacaption .= '<div class="camera_caption_articlecontent">' . $item->article->text;
			if ($articlelink == 'readmore') {
				$datacaption .= '<a href="' . $item->article->link . '">' . JText::_('COM_CONTENT_READ_MORE_TITLE') . '</a>';
			}
			$datacaption .= '</div>';
		}
		$imgtarget = ($item->imgtarget == 'default') ? $params->get('imagetarget') : $item->imgtarget;
		$datatitle = ($params->get('lightboxcaption', 'caption') != 'caption') ? 'data-title="' . htmlspecialchars(str_replace("\"", "&quot;", str_replace(">", "&gt;", str_replace("<", "&lt;", $datacaption)))) . '" ' : '';
		$dataalbum = ($params->get('lightboxgroupalbum', '0')) ? '[albumslideshowck' .$module->id .']' : '';
		$datarel = ($imgtarget == 'lightbox') ? 'data-rel="lightbox' . $dataalbum . '" ' : '';
		$datatime = ($item->imgtime) ? ' data-time="' . $item->imgtime . '"' : '';
		?>
		<div <?php echo $datarel . $datatitle; ?>data-thumb="<?php echo $item->imgthumb; ?>" data-src="<?php echo $item->imgname; ?>" <?php if ($item->imglink) echo 'data-link="' . $item->imglink . '" data-target="' . $imgtarget . '"'; echo $dataalignment . $datatime; ?>>
			<?php if ($item->imgvideo AND $item->slideselect == 'video') { ?>
				<iframe src="<?php echo $item->imgvideo; ?>" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
			<?php
			}
			if (($item->imgcaption || $item->article) && (($params->get('lightboxcaption', 'caption') != 'title' || $imgtarget != 'lightbox') || !$item->imglink)) {
				echo '<div class="camera_caption ' . $params->get('captioneffect', 'moveFromBottom') . '">';
				echo $datacaption;
				echo '</div>';
			}
			?>
		</div>
<?php } ?>
</div>
<div style="clear:both;"></div>
<!-- fin Slideshow CK -->

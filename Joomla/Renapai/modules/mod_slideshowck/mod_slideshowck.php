<?php

/**
 * @copyright	Copyright (C) 2012 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * Module Slideshow CK
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.modal');
require_once dirname(__FILE__) . '/helper.php';

if ($params->get('slideshowckhikashop_enable', '0') == '1') {
	if (JFile::exists(JPATH_ROOT . '/plugins/system/slideshowckhikashop/helper/helper_slideshowckhikashop.php')) {
		require_once JPATH_ROOT . '/plugins/system/slideshowckhikashop/helper/helper_slideshowckhikashop.php';
		$items = modSlideshowckhikashopHelper::getItems($params);
	} else {
		echo '<p style="color:red;font-weight:bold;">File /plugins/system/slideshowckhikashop/helper/helper_slideshowckhikashop.php not found ! Please download the patch for Slideshow CK - Hikashop on <a href="http://www.joomlack.fr">http://www.joomlack.fr</a></p>';
		return false;
	}
} else {
	if ($params->get('slidesssource', 'slidesmanager') == 'folder') {
		$items = modSlideshowckHelper::getItemsFromfolder($params);
	} else if ($params->get('slidesssource', 'slidesmanager') == 'autoloadfolder') {
		$items = modSlideshowckHelper::getItemsAutoloadfolder($params);
	}else {
		$items = modSlideshowckHelper::getItems($params);
	}

	if ($params->get('displayorder', 'normal') == 'shuffle')
		shuffle($items);
}

$document = JFactory::getDocument();
if ($params->get('loadjquery', '1')) {
	JHTML::_("jquery.framework", true);
}
if ($params->get('loadjqueryeasing', '1')) {
	$document->addScript(JURI::base(true) . '/modules/mod_slideshowck/assets/jquery.easing.1.3.js');
}
if ($params->get('loadjquerymobile', '1')) {
	$document->addScript(JURI::base(true) . '/modules/mod_slideshowck/assets/jquery.mobile.customized.min.js');
}

$document->addScript(JURI::base(true) . '/modules/mod_slideshowck/assets/camera.min.js');

$theme = $params->get('theme', 'default');
$langdirection = $document->getDirection();
if ($langdirection == 'rtl' && JFile::exists('modules/mod_slideshowck/themes/' . $theme . '/css/camera_rtl.css')) {
	$document->addStyleSheet(JURI::base(true) . '/modules/mod_slideshowck/themes/' . $theme . '/css/camera_rtl.css');
} else {
	$document->addStyleSheet(JURI::base(true) . '/modules/mod_slideshowck/themes/' . $theme . '/css/camera.css');
}

if (JFile::exists('modules/mod_slideshowck/themes/' . $theme . '/css/camera_ie.css')) {
	echo '
		<!--[if lte IE 7]>
		<link href="' . JURI::base(true) . '/modules/mod_slideshowck/themes/' . $theme . '/css/camera_ie.css" rel="stylesheet" type="text/css" />
		<![endif]-->';
}

if (JFile::exists('modules/mod_slideshowck/themes/' . $theme . '/css/camera_ie8.css')) {
	echo '
		<!--[if IE 8]>
		<link href="' . JURI::base(true) . '/modules/mod_slideshowck/themes/' . $theme . '/css/camera_ie8.css" rel="stylesheet" type="text/css" />
		<![endif]-->';
}

// set the navigation variables
switch ($params->get('navigation', '2')) {
	case 0:
		// aucune
		$navigation = "navigationHover: false,
                navigation: false,
                playPause: false,";
		break;
	case 1:
		// toujours
		$navigation = "navigationHover: false,
                navigation: true,
                playPause: true,";
		break;
	case 2:
	default:
		// on mouseover
		$navigation = "navigationHover: true,
                navigation: true,
                playPause: true,";
		break;
}


// load the slideshow script
$js = "<script type=\"text/javascript\"> <!--
       jQuery(function(){
        jQuery('#camera_wrap_" . $module->id . "').camera({
                height: '" . $params->get('height', '400') . "',
                minHeight: '',
                pauseOnClick: false,
                hover: " . $params->get('hover', '1') . ",
                fx: '" . implode(",", $params->get('effect', array('linear'))) . "',
                loader: '" . $params->get('loader', 'pie') . "',
                pagination: " . $params->get('pagination', '1') . ",
                thumbnails: " . $params->get('thumbnails', '1') . ",
                thumbheight: " . $params->get('thumbnailheight', '100') . ",
                thumbwidth: " . $params->get('thumbnailwidth', '75') . ",
                time: " . $params->get('time', '7000') . ",
                transPeriod: " . $params->get('transperiod', '1500') . ",
                alignment: '" . $params->get('alignment', 'center') . "',
                autoAdvance: " . $params->get('autoAdvance', '1') . ",
                mobileAutoAdvance: " . $params->get('autoAdvance', '1') . ",
                portrait: " . $params->get('portrait', '0') . ",
                barDirection: '" . $params->get('barDirection', 'leftToRight') . "',
                imagePath: '" . JURI::base(true) . "/modules/mod_slideshowck/images/',
                lightbox: '" . $params->get('lightboxtype', 'mediaboxck') . "',
                fullpage: " . $params->get('fullpage', '0') . ",
				mobileimageresolution: '" . ($params->get('usemobileimage', '0') ? $params->get('mobileimageresolution', '640') : '0') . "',
                " . $navigation . "
                barPosition: '" . $params->get('barPosition', 'bottom') . "'
        });
}); //--> </script>";

echo $js;

// load some css
$css = "#camera_wrap_" . $module->id . " .camera_pag_ul li img {width:" . $params->get('thumbnailwidth', '100') . "px;height:" . $params->get('thumbnailheight', '75') . "px;}";

// load the caption styles
$captioncss = modSlideshowckHelper::createCss($params, 'captionstyles');
$fontfamily = ($params->get('captionstylesusefont','0') && $params->get('captionstylestextgfont', '0')) ? "font-family:'" . $params->get('captionstylestextgfont', 'Droid Sans') . "';" : '';
if ($fontfamily) {
	$gfonturl = str_replace(" ", "+", $params->get('captionstylestextgfont', 'Droid Sans'));
	$document->addStylesheet('https://fonts.googleapis.com/css?family=' . $gfonturl);
}

$css .= "
#camera_wrap_" . $module->id . " .camera_caption {
	display: block;
	position: absolute;
}
#camera_wrap_" . $module->id . " .camera_caption > div {
	" . $captioncss['padding'] . $captioncss['margin'] . $captioncss['background'] . $captioncss['gradient'] . $captioncss['borderradius'] . $captioncss['shadow'] . $captioncss['border'] . $captioncss['fontcolor'] . $captioncss['fontsize'] . $fontfamily . "
}
#camera_wrap_" . $module->id . " .camera_caption > div div.slideshowck_description {
	" . $captioncss['descfontcolor'] . $captioncss['descfontsize'] . "
}
";
$document->addStyleDeclaration($css);

// display the module
require JModuleHelper::getLayoutPath('mod_slideshowck', $params->get('layout', 'default'));

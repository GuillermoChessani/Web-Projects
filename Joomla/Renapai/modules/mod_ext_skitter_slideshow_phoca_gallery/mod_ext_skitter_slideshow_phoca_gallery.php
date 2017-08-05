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

	$document 				= JFactory::getDocument();
	$document->addStyleSheet(JURI::base() . 'modules/mod_ext_skitter_slideshow_phoca_gallery/css/skitter.styles.css');

if (!JComponentHelper::isEnabled('com_phocagallery', true)) {
	return JError::raiseError(JText::_('Phoca Gallery Error'), JText::_('Phoca Gallery is not installed on your system'));
}

if (! class_exists('PhocaGalleryLoader')) {
    //require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocagallery'.DS.'libraries'.DS.'loader.php');
	require_once (JPATH_ADMINISTRATOR.'/components/com_phocagallery/libraries/loader.php'); 
}

phocagalleryimport('phocagallery.path.path');
phocagalleryimport('phocagallery.file.file');
phocagalleryimport('phocagallery.file.filethumbnail');		
		
	
	
	$ext_jquery_ver			= $params->get('ext_jquery_ver');	
	$ext_load_jquery		= $params->get('ext_load_jquery', 1);	
	$ext_load_easing		= $params->get('ext_load_easing', 1);
	$ext_load_scripts		= $params->get('ext_load_scripts', 1);
	$easing					= $params->get('easing', 'null');
	/*
	*/
	$catId 					= (int)$params->get('category_id', 1);
	$count					= (int)$params->get('count_images', 5);
	$animations				= $params->get('animations', 'randomSmart');
	/*	
	*/
	$moduleclass_sfx		= $params->get('moduleclass_sfx');
	$ext_id					= $params->get('ext_id');
	$width					= $params->get('width');
	$height					= $params->get('height');
	$velocity				= $params->get('velocity');
	$interval				= $params->get('interval');
	$navigation				= $params->get('navigation', 'true');
	$label					= $params->get('label');
	$label_animation		= $params->get('label_animation', 'left');
	$hideTools				= $params->get('hideTools');
	$fullscreen				= $params->get('fullscreen');
	$width_label			= $params->get('width_label');
	$show_randomly 			= $params->get('show_randomly');
	$numbers_align 			= $params->get('numbers_align');
	$navigation_button		= $params->get('navigation_button', 'none');
	/*
	$pos 					= $params->get('pos');
	$ots 					= $params->get('ots'); 
	*/
	$color_Out 				= $params->get('color_Out', '#FFFFFF');
	$background_Out 		= $params->get('background_Out', '#333333');
	$color_Over 			= $params->get('color_Over', '#FFFFFF');
	$background_Over 		= $params->get('background_Over', '#000000');
	$color_Active			= $params->get('color_Active', '#FFFFFF');
	$background_Active 		= $params->get('background_Active', '#CC3333');
	$controls				= $params->get('controls');
	$controls_position		= $params->get('controls_position');
	$progressbar			= $params->get('progressbar');
	$color_progressbar		= $params->get('background_progressbar', '#000000');
	/*
	$progressbar_css 		= $params->get('progressbar_css', 0);
	$color_progressbar_css	= $params->get('color_progressbar_css', '#000000');
	*/
	$enable_nav_keys		= $params->get('enable_navigation_keys');
	$auto_play				= $params->get('auto_play');
	$focus					= $params->get('focus');
	$focus_position			= $params->get('focus_position');
	$theme					= $params->get('theme', 'null');

	
$ext_script = <<<SCRIPT


var jQ = false;
function initJQ() {
	if (typeof(jQuery) == 'undefined') {
		if (!jQ) {
			jQ = true;
			document.write('<scr' + 'ipt type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/$ext_jquery_ver/jquery.min.js"></scr' + 'ipt>');
		}
		setTimeout('initJQ()', 50);
	}
}
initJQ(); 


SCRIPT;

	if ($ext_load_jquery == 1) {
		$document->addScriptDeclaration($ext_script);
	}
	if ($ext_load_easing == 1 ) {
		$document->addCustomTag('<script type = "text/javascript" src = "'.JURI::root().'modules/mod_ext_skitter_slideshow_phoca_gallery/js/jquery.easing.1.3.js"></script>'); 
	}
	if ($ext_load_scripts == 1 ) {
		$document->addCustomTag('<script type = "text/javascript" src = "'.JURI::root().'modules/mod_ext_skitter_slideshow_phoca_gallery/js/jquery.skitter.min.js"></script>');	
	}	
	$document->addCustomTag('<script type = "text/javascript">if (jQuery) jQuery.noConflict();</script>');	
	
	
	
	

//SQL	
	$db 		= JFactory::getDBO();	
	$query      = ' SELECT a.title, a.description, a.filename'
			. ' FROM #__phocagallery_categories AS cc'
			. ' LEFT JOIN #__phocagallery AS a ON a.catid = cc.id'
			. ' WHERE a.published = 1 AND a.catid = ' . (int)$catId
			//. ' WHERE cc.published = 1 AND a.published = 1 AND a.catid = ' . (int)$catId
			//. ' ORDER BY RAND()'
			. ' ORDER BY a.ordering'
			. ' LIMIT '.(int)$count;
	$db->setQuery($query);
	$images = $db->loadObjectList();
		
	
	
require JModuleHelper::getLayoutPath('mod_ext_skitter_slideshow_phoca_gallery', $params->get('layout', 'default'));
echo JText::_(COP_JOOMLA);	
?>
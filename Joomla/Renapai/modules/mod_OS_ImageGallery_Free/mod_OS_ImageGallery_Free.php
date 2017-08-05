<?php
/**
 * @package OS_ImageGallery_Free
 * @subpackage  OS_ImageGallery_Free
 * @copyright Andrey Kvasnevskiy-OrdaSoft(akbet@mail.ru); Anton Panchenko(nix-legend@mail.ru); 
 * @Homepage: http://www.ordasoft.com
 * @version: 1.0 
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * */
defined('_JEXEC') or die;
require_once dirname(__FILE__).'/helpers/images.php';

JHtml::_('stylesheet',JURI::base()."/modules/mod_OS_ImageGallery_Free/assets/css/image.gallery.css");
JHtml::_('stylesheet',JURI::base()."/modules/mod_OS_ImageGallery_Free/assets/css/jquery.fancybox.css");

if($params->get('jquery-local',1) == "1" && $params->get('jquery',1) == "1") {
    JHtml::_('script',JURI::base()."/modules/mod_OS_ImageGallery_Free/assets/js/jquery-1.7.1.min.js");
} elseif ($params->get('jquery',1) == "1") {
    JHtml::_('script','//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
}
if($params->get('no-conflict',0) == '1') {
    $doc =JFactory::getDocument();
    $doc->addScriptDeclaration("jQuery.noConflict();");
}

JHtml::_('script',JURI::base()."/modules/mod_OS_ImageGallery_Free/assets/js/jquery.fancybox.js");
JHtml::_('script',JURI::base()."/modules/mod_OS_ImageGallery_Free/assets/js/jquery.fancybox-init.js");

if(!is_numeric($width = $params->get('width'))) $width = 350;
if(!is_numeric($height = $params->get('height'))) $height = 240;
if(!is_numeric($img_in_row = $params->get('img_in_row'))) $img_in_row = 3;

$button_name = $params->get('button_name');
$dir = JPATH_ROOT . '/images/os_imagegallery_' . $module->id;
$sufix = $params->get('sufix','');
require JModuleHelper::getLayoutPath('mod_OS_ImageGallery_Free', $params->get('layout', 'default'));
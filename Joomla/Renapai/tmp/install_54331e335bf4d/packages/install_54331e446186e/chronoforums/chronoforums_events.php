<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace GCore\Extensions\Chronoforums;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class ChronoforumsEvents {
	
	public static function on_before_dispatch(&$app){
		if(!empty($_POST['Extension']['chronoforums']['settings'])){
			$chronoforums_params = new \GCore\Libs\Parameter($_POST['Extension']['chronoforums']['settings']);
			if($chronoforums_params->get('board_display', 'default') == 'discussions' AND $app->extension == 'chronoforums' AND $app->controller == '' AND ($app->action == '' OR $app->action == 'index')){
				$app->controller = 'forums';
				$app->action = '';
			}
		}
	}
	
	public static function on_set_page_title($title = ''){
		if(!empty($title)){
			if(\GCore\C::get('GSITE_PLATFORM') == 'joomla'){
				$doc = \JFactory::getDocument();
				$doc->setTitle($title);
			}else{
				$doc = \GCore\Libs\Document::getInstance();
				$doc->setTitle($title);
			}
		}
	}
}
?>
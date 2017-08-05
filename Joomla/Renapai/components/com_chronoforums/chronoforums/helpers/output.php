<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace GCore\Extensions\Chronoforums\Helpers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Output {
	var $view;
	
	function rt($return = ''){
		$fparams = $this->view->vars['fparams'];
		if((bool)$fparams->get('rt_support', 0) === true){
			return ' '.$return;
		}
		return '';
	}
	
	function forum_icon($forum = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($forum)){
			return \GCore\C::get('GCORE_FRONT_URL').'extensions/chronoforums/styles/'.$fparams->get('theme', 'prosilver').'/imageset/forums_icons/'.(!empty($forum['params']['icon']) ? $forum['params']['icon'] : 'forum_read.gif');
		}
		return '';
	}
	
	function forum_class($forum = array()){
		if(!empty($forum)){
			return ' cfu-forum-'.$forum['alias'];
		}
		return '';
	}
	
	function cat_class($category = array()){
		if(!empty($category)){
			return ' cfu-cat-'.$category['alias'];
		}
		return '';
	}
	
	function date_time($date = ''){
		if(!empty($date)){
			return \GCore\Libs\Date::_(l_('CHRONOFORUMS_DATE_FORMAT'), strtotime($date));
		}
		return '';
	}
}
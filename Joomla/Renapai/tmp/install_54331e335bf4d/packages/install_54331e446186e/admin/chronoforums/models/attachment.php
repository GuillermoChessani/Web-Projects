<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace GCore\Admin\Extensions\Chronoforums\Models;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Attachment extends \GCore\Libs\GModel {
	var $tablename = '#__chronoengine_forums_posts_attachments';
	
	function beforeDelete(&$conditions, $params = array()){
		//$ids = $this->get_ids_of_conditions($conditions);
		$items = $this->find('all', array('conditions' => $conditions, 'recursive' => -1, 'fields' => array('id', 'vfilename')));
		if(!empty($items)){
			foreach($items as $item){
				$target = \GCore\C::get('GCORE_FRONT_PATH').'extensions'.DS.'chronoforums'.DS.'attachments'.DS.$item['Attachment']['vfilename'];
				\GCore\Libs\File::delete($target);
			}
		}
	}
}
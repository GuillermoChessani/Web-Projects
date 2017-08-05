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
class Forum extends \GCore\Libs\GModel {
	var $tablename = '#__chronoengine_forums_forums';
	
	function initialize(){
		$this->validate = array(
			'title' => array(
				'required' => true,
				'not_empty' => true,
				'message' => l_('FORUMS_FORUM_NAME_REQUIRED')
			),
		);
	}
	
	var $belongsTo = array(
		'Category' => array(
			'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Category',
			'foreignKey' => 'cat_id'
		),
		'LastForumPost' => array(
			'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Post',
			'foreignKey' => 'last_post',
		),
	);
	
	var $hasMany = array(
		'Topic' => array(
			'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Topic',
			'foreignKey' => 'forum_id'
		),
	);
	
	function beforeSave(&$data, &$params, $mode){
		parent::beforeSave($data, $params, $mode);
		if(isset($data['ordering']) AND !is_numeric($data['ordering'])){
			unset($data['ordering']);
		}
	}
}
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
class Post extends \GCore\Libs\GModel {
	var $tablename = '#__chronoengine_forums_posts';
	
	function initialize(){
		$this->validate = array(
			'subject' => array(
				'required' => true,
				'not_empty' => true,
				'message' => l_('FORUMS_POST_SUBJECT_REQUIRED')
			),
			'text' => array(
				'required' => true,
				'not_empty' => true,
				'message' => l_('FORUMS_POST_TEXT_REQUIRED')
			),
			'forum_id' => array(
				'required' => true,
				'not_empty' => true,
				'message' => l_('FORUMS_FORUM_REQUIRED')
			),
		);
	}
	
	var $belongsTo = array(
		'Forum' => array(
			'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Forum',
			'foreignKey' => 'forum_id',
			'counterCache' => 'post_count',
		),
		'Topic' => array(
			'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Topic',
			'foreignKey' => 'topic_id',
			'counterCache' => 'post_count',
		),
		'PostAuthor' => array(
			'className' => '\GCore\Admin\Models\User',
		),
	);
	
	var $hasMany = array(
		'Attachment' => array(
			'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Attachment',
			'save_on_save' => true,
			'delete_on_delete' => true,
			'delete_non_existent' => true,
		),
		'Report' => array(
			'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Report',
			'delete_on_delete' => true,
		),
	);
	
	function beforeSave(&$data, &$params, $mode){
		parent::beforeSave($data, $params, $mode);
		$user = \GCore\Libs\Base::getUser();
		if($mode == 'create'){			
			$data['created_by'] = $user['id'];
		}else{
			$data['modified_by'] = $user['id'];
		}
	}
	
	function afterSave(){
		if($this->created === true){
			$this->Topic->id = $this->data['topic_id'];
			$this->Topic->saveField('last_post', $this->id);
			$this->Forum->id = $this->data['forum_id'];
			$this->Forum->saveField('last_post', $this->id);
		}
	}
	
	function tag_topic($data = array()){
		$this->Tag = \GCore\Admin\Extensions\Chronoforums\Models\Tag::getInstance();
		$tags = $this->Tag->find('all', array('contain' => array('Tag'), 'conditions' => array('Tag.published' => 1), 'fields' => array('Tag.id', 'Tag.title', 'Tag.occurrences')));
		$tags_titles = \GCore\Libs\Arr::getVal($tags, array('[n]', 'Tag', 'title'));
		$possible_tags = array_intersect($tags_titles, explode(' ', $data['Post']['subject'].' '.$data['Post']['text']));
		if(!empty($possible_tags)){
			$tags_ids = array_intersect_key(\GCore\Libs\Arr::getVal($tags, array('[n]', 'Tag', 'id')), $possible_tags);
			$tags_counts = array_intersect_key(\GCore\Libs\Arr::getVal($tags, array('[n]', 'Tag', 'occurrences')), $possible_tags);
			foreach($tags_ids as $k => $tag_id){
				if($tags_counts[$k] > 1){
					if($tags_counts[$k] >= count(array_keys(explode(' ', $data['Post']['subject'].' '.$data['Post']['text']), $possible_tags[$k]))){
						$this->Tag->Tagged->save(array('tag_id' => $tag_id, 'topic_id' => $data['Post']['topic_id']), array('new' => true));
					}
				}else{
					$this->Tag->Tagged->save(array('tag_id' => $tag_id, 'topic_id' => $data['Post']['topic_id']), array('new' => true));
				}
			}
		}
	}
}
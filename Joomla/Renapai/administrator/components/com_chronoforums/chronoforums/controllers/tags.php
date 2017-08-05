<?php
/**
* COMPONENT FILE HEADER
**/
namespace GCore\Admin\Extensions\Chronoforums\Controllers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Tags extends \GCore\Libs\GController {
	var $models = array('\GCore\Admin\Extensions\Chronoforums\Models\Tag');
	var $libs = array('\GCore\Libs\Request');
	var $helpers= array(
		'\GCore\Helpers\DataTable', 
		'\GCore\Helpers\Assets', 
		'\GCore\Helpers\Html', 
		'\GCore\Helpers\Toolbar', 
		'\GCore\Helpers\Tasks', 
		'\GCore\Helpers\Paginator', 
		'\GCore\Helpers\Sorter'
	);
	
	function index(){
		$this->_sortable();
		$this->_paginate();
		
		\GCore\Libs\Model::generateModel('TagCounter', array(
			'tablename' => $this->Tag->Tagged->tablename,
		));
		$this->Tag->bindModels('hasMany', array(
			'TagCounter' => array(
				'className' => '\GCore\Models\TagCounter',
				'foreignKey' => 'tag_id',
				'fields' => array('COUNT(*)' => 'count', 'tag_id'),
				'group' => 'tag_id',
			),
		));
		$this->Tag->contain[] = 'TagCounter';
		
		$tags = $this->Tag->find('all');
		$this->set('tags', $tags);
	}
	
	function toggle(){
		parent::_toggle();
		$this->redirect(r_('index.php?ext=chronoforums&cont=tags'));
	}
	
	//data reading
	function edit(){
		$tag = $this->Tag->load($this->Request->data('id', null));
		if(!empty($tag)){			
			$this->data = $tag;
		}
		
		$this->set(array('tag' => $tag));
	}
	
	function save(){
		$this->data['Tag']['title'] = strtolower(trim($this->data['Tag']['title']));
		$exists = $this->Tag->field('id', array('title' => $this->data['Tag']['title']));
		if($exists){
			$this->edit();
			$this->view = 'edit';
			$session = \GCore\Libs\Base::getSession();
			$session->setFlash('error', l_('TAG_EXISTS'));
			return;
		}
		$result = parent::_save();
		if($result){
			if($this->Request->get('save_act') == 'apply'){
				$this->redirect(r_('index.php?ext=chronoforums&cont=tags&act=edit&id='.$this->Tag->id));
			}else{
				$this->redirect(r_('index.php?ext=chronoforums&cont=tags'));
			}
		}else{
			$this->edit();
			$this->view = 'edit';
			$session = \GCore\Libs\Base::getSession();
			$session->setFlash('error', \GCore\Libs\Arr::flatten($this->Tag->errors));
		}
	}
	
	function save_list(){
		parent::_save_list();
		$this->redirect(r_('index.php?ext=chronoforums&cont=tags'));
	}
	
	function delete(){
		parent::_delete();
		$this->redirect(r_('index.php?ext=chronoforums&cont=tags'));
	}
	
	function tag_topics(){
		$gcbs = \GCore\Libs\Request::data('gcb', array());
		$session = \GCore\Libs\Base::getSession();
		
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post')));
		
		foreach($gcbs as $gcb){
			//delete existing associations to this tag
			$this->Tag->Tagged->deleteAll(array('Tagged.tag_id' => $gcb));
			//find posts match this tag
			$tag = $this->Tag->load($gcb);
			$term = str_repeat('%'.$tag['Tag']['title'], (int)$tag['Tag']['occurrences']);
			$count = $this->Post->find('count', array('conditions' => array('Post.text LIKE' => $term.'%'), 'group' => array('Post.topic_id')));
			$i = 0;
			while($i <= $count){
				$posts = $this->Post->find('all', array('conditions' => array('OR' => array('Post.text LIKE' => $term.'%', 'Post.subject LIKE' => $term.'%')), 'fields' => array('Post.id', 'Post.topic_id'), 'group' => array('Post.topic_id'), 'limit' => 30, 'offset' => $i));
				//pr($posts);die();
				$i = $i + 30;
				foreach($posts as $post){
					$this->Tag->Tagged->save(array('tag_id' => $gcb, 'topic_id' => $post['Post']['topic_id']), array('new' => true));
				}
			}
		}
		$session->setFlash('info', l_('TOPICS_TAGGED_SUCCESS'));
		$this->redirect(r_('index.php?ext=chronoforums&cont=tags'));
	}
}
?>
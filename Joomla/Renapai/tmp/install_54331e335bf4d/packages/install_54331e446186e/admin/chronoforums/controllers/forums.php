<?php
/**
* COMPONENT FILE HEADER
**/
namespace GCore\Admin\Extensions\Chronoforums\Controllers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Forums extends \GCore\Libs\GController {
	var $models = array('\GCore\Admin\Extensions\Chronoforums\Models\Forum', '\GCore\Admin\Models\Group');
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
		$forums = $this->Forum->find('all', array('contain' => array('Category')));
		$this->set('forums', $forums);
	}
	
	function toggle(){
		parent::_toggle();
		$this->redirect(r_('index.php?ext=chronoforums&cont=forums'));
	}
	
	//data reading
	function edit(){
		$forum = $this->Forum->load($this->Request->data('id', null));
		if(!empty($forum)){			
			$this->data = $forum;
		}
		
		$this->set(array('forum' => $forum));
		
		$categories = $this->Forum->Category->find('list');
		$this->set(array('categories' => $categories));
		
		//permissions groups
		$groups = $this->Group->find('flat');
		$rules = array();
		foreach($groups as $k => $group){
			$rules[$group['Group']['id']] = /*str_repeat('-- ', (int)$group['Group']['depth']).*/$group['Group']['title'];
		}
		$this->set('rules', $rules);
		
		$perms = array(
			'display' => 'Display/Access',
			'make_topics' => 'Create New Topics',
			'make_posts' => 'Post Replies',
			'read_topics' => 'Read/View Topics',
			//'modify_topics' => 'Modify/Moderate Topics',
		);
		$this->set('perms', $perms);
		
		parent::_settings('chronoforums');
		$params = new \GCore\Libs\Parameter($this->data['Chronoforums']);
		$path = \GCore\C::ext_path('chronoforums', 'front').'styles'.DS.$params->get('theme', 'prosilver').DS.'imageset'.DS.'forums_icons'.DS;
		$files = \GCore\Libs\Folder::getFiles($path);
		$forums_icons = array();
		foreach($files as $file){
			$forums_icons[basename($file)] = \GCore\Helpers\Html::image(\GCore\C::ext_url('chronoforums', 'front').'styles/'.$params->get('theme', 'prosilver').'/imageset/forums_icons/'.basename($file));
		}
		//$forums_icons = array_map(create_function('$icon,', 'return \GCore\Helpers\Html::image(\GCore\Libs\Url::abs_to_url($icon));'), $forums_icons);
		$this->set('forums_icons', $forums_icons);
	}
	
	function save(){
		$result = parent::_save();
		if($result){
			if($this->Request->get('save_act') == 'apply'){
				$this->redirect(r_('index.php?ext=chronoforums&cont=forums&act=edit&id='.$this->Forum->id));
			}else{
				$this->redirect(r_('index.php?ext=chronoforums&cont=forums'));
			}
		}else{
			$this->edit();
			$this->view = 'edit';
			$session = \GCore\Libs\Base::getSession();
			$session->setFlash('error', \GCore\Libs\Arr::flatten($this->Forum->errors));
		}
	}
	
	function save_list(){
		parent::_save_list();
		$this->redirect(r_('index.php?ext=chronoforums&cont=forums'));
	}
	
	function delete(){
		parent::_delete();
		$this->redirect(r_('index.php?ext=chronoforums&cont=forums'));
	}
}
?>
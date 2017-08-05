<?php
/**
* COMPONENT FILE HEADER
**/
namespace GCore\Admin\Extensions\Chronoforums\Controllers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Categories extends \GCore\Libs\GController {
	var $models = array('\GCore\Admin\Extensions\Chronoforums\Models\Category', '\GCore\Admin\Models\Group');
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
		$categories = $this->Category->find('all');
		$this->set('categories', $categories);
	}
	
	function toggle(){
		parent::_toggle();
		$this->redirect(r_('index.php?ext=chronoforums&cont=categories'));
	}
	
	//data reading
	function edit(){
		$category = $this->Category->load($this->Request->data('id', null));
		if(!empty($category)){			
			$this->data = $category;
		}
		
		$this->set(array('category' => $category));
				
		//permissions groups
		$groups = $this->Group->find('flat');
		$rules = array();
		foreach($groups as $k => $group){
			$rules[$group['Group']['id']] = /*str_repeat('-- ', (int)$group['Group']['depth']).*/$group['Group']['title'];
		}
		$this->set('rules', $rules);
	}
	
	function save(){
		$result = parent::_save();
		if($result){
			if($this->Request->get('save_act') == 'apply'){
				$this->redirect(r_('index.php?ext=chronoforums&cont=categories&act=edit&id='.$this->Category->id));
			}else{
				$this->redirect(r_('index.php?ext=chronoforums&cont=categories'));
			}
		}else{
			$this->edit();
			$this->view = 'edit';
			$session = \GCore\Libs\Base::getSession();
			$session->setFlash('error', \GCore\Libs\Arr::flatten($this->Category->errors));
		}
	}
	
	function save_list(){
		parent::_save_list();
		$this->redirect(r_('index.php?ext=chronoforums&cont=categories'));
	}
	
	function delete(){
		parent::_delete();
		$this->redirect(r_('index.php?ext=chronoforums&cont=categories'));
	}
}
?>
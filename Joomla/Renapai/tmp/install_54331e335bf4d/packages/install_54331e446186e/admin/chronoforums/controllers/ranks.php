<?php
/**
* COMPONENT FILE HEADER
**/
namespace GCore\Admin\Extensions\Chronoforums\Controllers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Ranks extends \GCore\Libs\GController {
	var $models = array('\GCore\Admin\Extensions\Chronoforums\Models\Rank', '\GCore\Admin\Models\Group');
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
		
		$ranks = $this->Rank->find('all');
		$this->set('ranks', $ranks);
	}
	
	function toggle(){
		parent::_toggle();
		$this->redirect(r_('index.php?ext=chronoforums&cont=ranks'));
	}
	
	//data reading
	function edit(){
		$rank = $this->Rank->load($this->Request->data('id', null));
		if(!empty($rank)){			
			$this->data = $rank;
		}
		
		$this->set(array('rank' => $rank));
		
		$groups = $this->Group->find('list', array('fields' => array('id', 'title')));
		$this->set('groups', $groups);
	}
	
	function save(){
		$result = parent::_save();
		if($result){
			if($this->Request->get('save_act') == 'apply'){
				$this->redirect(r_('index.php?ext=chronoforums&cont=ranks&act=edit&id='.$this->Rank->id));
			}else{
				$this->redirect(r_('index.php?ext=chronoforums&cont=ranks'));
			}
		}else{
			$this->edit();
			$this->view = 'edit';
			$session = \GCore\Libs\Base::getSession();
			$session->setFlash('error', \GCore\Libs\Arr::flatten($this->Rank->errors));
		}
	}
	
	function save_list(){
		parent::_save_list();
		$this->redirect(r_('index.php?ext=chronoforums&cont=ranks'));
	}
	
	function delete(){
		parent::_delete();
		$this->redirect(r_('index.php?ext=chronoforums&cont=ranks'));
	}
}
?>
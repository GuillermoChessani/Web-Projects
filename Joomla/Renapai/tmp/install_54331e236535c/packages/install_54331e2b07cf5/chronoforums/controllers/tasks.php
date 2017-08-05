<?php
/**
* COMPONENT FILE HEADER
**/
namespace GCore\Extensions\Chronoforums\Controllers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Tasks extends \GCore\Libs\Controller {//extends \GCore\Extensions\Chronoforums\Chronoforums {
	var $helpers = array(
		'\GCore\Helpers\Html', 
		'\GCore\Extensions\Chronoforums\Helpers\TopicTasks',
	);
	
	function latest_posts(){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic', 'TopicAuthor', 'LastPost', 'PostAuthor')));
		$this->Topic->limit = $this->get('count', 10);
		$this->Topic->page_limit = $this->get('count', 10);
		$this->Topic->page = 1;
		$this->Topic->conditions = array('Topic.published' => 1);
		if($this->get('forum_id', '')){
			$this->Topic->conditions = array_merge($this->Topic->conditions, array('Topic.forum_id' => explode(',', $this->get('forum_id', ''))));
		}
		$this->Topic->group = array();
		$this->Topic->order_by = array('LastPost.created DESC');
		$this->Topic->contain = array('Topic', 'TopicAuthor', 'LastPost', 'PostAuthor');
		$find_params = array();
		$topics = $this->Topic->find('all', $find_params);
		$this->set('topics', $topics);
		$mainframe = \JFactory::getApplication();
		if($forums_menu = $mainframe->getMenu()->getItems('component', 'com_chronoforums', true)){
			$this->set('forums_menu_id', $forums_menu->id);
		}
	}
}
?>
<?php
/**
* COMPONENT FILE HEADER
**/
namespace GCore\Extensions\Chronoforums\Controllers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Search extends \GCore\Extensions\Chronoforums\Chronoforums {
	//var $models = array('\GCore\Admin\Extensions\Chronoforums\Models\Forum', '\GCore\Admin\Extensions\Chronoforums\Models\Topic', '\GCore\Admin\Extensions\Chronoforums\Models\Post', '\GCore\Admin\Models\Group');
	//var $libs = array('\GCore\Libs\Request');
	var $helpers= array(
		'\GCore\Helpers\Assets', 
		'\GCore\Helpers\Html', 
		'\GCore\Helpers\Paginator',
		'\GCore\Extensions\Chronoforums\Helpers\UserTasks',
		'\GCore\Extensions\Chronoforums\Helpers\TopicTasks',
		'\GCore\Extensions\Chronoforums\Helpers\Elements',
		'\GCore\Extensions\Chronoforums\Helpers\Output',
		//'\GCore\Helpers\Sorter'
	);
	
	function index(){
		//$this->Forum = \GCore\Admin\Extensions\Chronoforums\Models\Forum::getInstance(array('allowed_models' => array('Forum')));
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic', 'Forum', 'TopicAuthor', 'LastPost', 'PostAuthor')));
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post')));
		
		$fid = \GCore\Libs\Request::data('f', 0);
		$skeywords = \GCore\Libs\Request::data('skeywords');
		if(empty($skeywords)){
			$this->view = 'advanced';
		}
		if(!empty($this->data['cancel_search'])){
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
		
		$this->Topic->conditions = array();
		$this->Topic->conditions['Forum.published'] = 1;
		$this->Topic->conditions['published'] = 1;
		if(!empty($fid)){
			//$this->Topic->conditions['Forum.id'] = $fid;
			$this->Topic->conditions['forum_id'] = $fid;
		}
		
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') === true){
			unset($this->Topic->conditions['published']);
			unset($this->Topic->conditions['Forum.published']);
		}
		$this->Topic->order_by = array('Topic.announce DESC', 'Topic.sticky DESC', $this->fparams->get('topics_ordering', 'LastPost.created DESC'));
		$this->Topic->limit = $this->fparams->get('topics_limit', 20);
		$this->Topic->contain = array('Topic', 'TopicAuthor', 'LastPost', 'PostAuthor', 'Forum');
		$this->Topic->recursive = -1;
		$this->Topic->TopicAuthor->bindModels('hasOne', array(
				'TopicAuthorProfile' => array(
					'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Profile',
					'foreignKey' => 'user_id',
				),
			));
			$this->Topic->contain[] = 'TopicAuthorProfile';
			$this->Topic->LastPost->PostAuthor->bindModels('hasOne', array(
				'PostAuthorProfile' => array(
					'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Profile',
					'foreignKey' => 'user_id',
				),
			));
			$this->Topic->contain[] = 'PostAuthorProfile';
		//search
		if($this->fparams->get('search_method', 'deep') == 'deep'){
			$this->search_model = $this->Post;
			//$this->search_prefix = $fid;
			$this->Post->contain = array('Post');
			$searched = $this->_search(array('Post.text'), 'skeywords');
			$tids = array();
			if($searched !== false){
				$cond = array();
				if(!empty($fid)){
					$cond = array('Post.forum_id' => $fid);
				}
				$posts = $this->Post->find('all', array('conditions' => $cond, 'group' => array('Post.topic_id'), 'fields' => array('Post.id', 'Post.topic_id', 'Post.forum_id')));
				if(!empty($posts)){
					$tids = \GCore\Libs\Arr::getVal($posts, array('[n]', 'Post', 'topic_id'));
					$this->Topic->conditions['id'] = $tids;
				}else{
					$this->Topic->conditions[] = '1=0';
				}
				$this->set('searched', \GCore\Libs\Request::data('skeywords'));
			}
		}elseif($this->fparams->get('search_method', 'deep') == 'tags'){
			$session = \GCore\Libs\Base::getSession();
			$search_string = \GCore\Libs\Request::data('skeywords', $session->get('chronoforums.'.$fid.'.Tagged.search.skeywords', null));
			$search_string = trim(strtolower($search_string));
			if(empty($search_string)){
				$session->clear('chronoforums.'.$fid.'.Tagged.search.skeywords');
			}else{
				$session->set('chronoforums.'.$fid.'.Tagged.search.skeywords', $search_string);
				\GCore\Libs\Request::set('skeywords', $search_string);
				
				$this->Tag = \GCore\Admin\Extensions\Chronoforums\Models\Tag::getInstance();
				$tags = $this->Tag->find('all', array('contain' => array('Tag'), 'conditions' => array('Tag.title' => explode(' ', $search_string), /*'Tag.published' => 1*/)));
				
				if(!empty($tags)){
					if((bool)$this->fparams->get('save_search_tags', 0) === true){
						$unfound_tags = array_diff(explode(' ', $search_string), \GCore\Libs\Arr::getVal($tags, array('[n]', 'Tag', 'title')));
						if(!empty($unfound_tags)){
							foreach($unfound_tags as $unfound_tag){
								$this->Tag->save(array('title' => $unfound_tag, 'published' => 0, 'occurrences' => 1));
							}
						}
					}
					if((bool)$this->fparams->get('update_tags_hits', 0) === true){
						foreach($tags as $tag){
							$this->Tag->id = $tag['Tag']['id'];
							$this->Tag->updateField('hits', '+ 1', array('reset_cache' => false));
						}
					}
					$tag_ids = array();
					foreach($tags as $tag){
						if($tag['Tag']['published'] == 1){
							$tag_ids[] = $tag['Tag']['id'];
						}
					}
					if(!empty($tag_ids)){
						$this->Topic->bindModels('hasOne', array(
							'Tagged' => array(
								'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Tagged',
								'foreignKey' => 'topic_id',
								'type' => 'inner',
								'group' => 'topic_id',
								'conditions' => array('Tagged.tag_id' => $tag_ids),
							),
						));
						$this->Topic->contain[] = 'Tagged';
						$this->set('searched', \GCore\Libs\Request::data('skeywords'));
					}
				}
				if(empty($tag_ids)){
					$this->Topic->conditions[] = '1=0';
				}
				$this->Topic->recursive = 1;
			}
		}
		
		$this->paginate_model = $this->Topic;
		$this->paginate_prefix = $fid;
		$this->_paginate();
		$this->Topic->recursive = 1;
		if(empty($tids)){
			$topics = $this->Topic->find('all', array('cache' => true, 'fields' => array('Topic.*', 'Forum.id', 'Forum.title', 'TopicAuthor.id', 'TopicAuthor.username', 'TopicAuthor.name', 'LastPost.id', 'LastPost.user_id', 'LastPost.created', 'PostAuthor.id', 'PostAuthor.username', 'PostAuthor.name', 'TopicAuthorProfile.*', 'PostAuthorProfile.*')));
		}else{
			$topics = $this->Topic->find('all', array('cache' => true, 'conditions' => array('id' => $tids), 'fields' => array('Topic.*', 'Forum.id', 'Forum.title', 'TopicAuthor.id', 'TopicAuthor.username', 'TopicAuthor.name', 'LastPost.id', 'LastPost.user_id', 'LastPost.created', 'PostAuthor.id', 'PostAuthor.username', 'PostAuthor.name', 'TopicAuthorProfile.*', 'PostAuthorProfile.*')));
		}
		//pr($this->Topic->dbo->log);die();
		$this->set('topics', $topics);
		$this->set('user', \GCore\Libs\Base::getUser());
	}
}
?>
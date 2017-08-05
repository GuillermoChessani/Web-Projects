<?php
/**
* COMPONENT FILE HEADER
**/
namespace GCore\Extensions\Chronoforums\Controllers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Forums extends \GCore\Extensions\Chronoforums\Chronoforums {
	//var $models = array('\GCore\Admin\Extensions\Chronoforums\Models\Forum', '\GCore\Admin\Extensions\Chronoforums\Models\Post');
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
		$fid = \GCore\Libs\Request::data('f', 0);
		$user = \GCore\Libs\Base::getUser();
		$session = \GCore\Libs\Base::getSession();
		
		$seacrh_field = 'keywords';
		$global_listing = false;
		if(empty($fid)){
			$skeywords = \GCore\Libs\Request::data('skeywords');
			$list = \GCore\Libs\Request::data('list');
			if(empty($skeywords)){
				if($this->fparams->get('board_display', 'default') == 'discussions'){
					$global_listing = true;
				}else{
					if(!empty($list) AND in_array($list, array('noreplies', 'active', 'new', 'user', 'favorites', 'featured', 'unpublished'))){
						$global_listing = true;
						$this->set('custom_listing', true);
						goto process_forum;
					}
					$this->redirect(r_('index.php?option=com_chronoforums'));
					goto forum_not_exist;
				}
			}else{
				//continue, this is a global search
				$seacrh_field = 'skeywords';
				$global_listing = true;
			}
		}
		process_forum:
		$this->set('global_listing', $global_listing);
		//$this->set('board_display', $this->fparams->get('board_display', 'discussions'));
		
		$this->Forum = \GCore\Admin\Extensions\Chronoforums\Models\Forum::getInstance(array('allowed_models' => array('Forum')));
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic', 'TopicAuthor', 'LastPost', 'PostAuthor')));
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post')));
		
		if($global_listing === false){
			$forum = $this->Forum->find('first', array('cache' => true, 'conditions' => array('id' => $fid), 'contain' => array('Forum'), 'fields' => array('Forum.id', 'Forum.title', 'Forum.alias', 'Forum.published', 'Forum.description', 'Forum.rules')));
			$this->set('forum', $forum);
			
			if(empty($forum)){
				$this->set('offline_message', l_('CHRONOFORUMS_FORUM_DOESNT_EXIST'));
				\GCore\Libs\Env::e404();
				return;
			}
			if((bool)$this->fparams->get('forum_permissions', 0) === true AND !\GCore\Libs\Authorize::check_rules($forum['Forum']['rules']['display'])){
				$this->set('offline_message', l_('CHRONOFORUMS_FORUM_ACCESS_DENIED'));
				\GCore\Libs\Env::e404();
				return;
			}
			if(empty($forum['Forum']['published'])){
				$this->set('offline_message', l_('CHRONOFORUMS_FORUM_IS_OFFLINE'));
				\GCore\Libs\Env::e404();
				return;
			}
		}else{
			$this->set('forum', array());
		}
		
		//$this->_sortable();
		
		$this->Topic->conditions = array('forum_id' => $fid, 'published' => 1);
		if($global_listing === true){
			unset($this->Topic->conditions['forum_id']);
		}
		if(\GCore\Libs\Request::data('list') == 'noreplies'){
			$this->Topic->conditions['post_count'] = 1;
		}
		if(\GCore\Libs\Request::data('list') == 'new'){
			if(!empty($user['id'])){
				$this->Topic->conditions['Topic.created >'] = $user['last_login'];
			}else{
				$this->Topic->conditions[] = '1=0';	
			}
		}
		if(\GCore\Libs\Request::data('list') == 'active'){
			$start_time = time() - ((int)$this->fparams->get('active_topic_days', 7) * 24 * 60 * 60);
			$start_time = date('Y-m-d H:i:s', $start_time);
			$this->Topic->conditions['LastPost.created >'] = $start_time;
		}
		if(\GCore\Libs\Request::data('list') == 'user'){
			if(empty($user['id'])){
				$this->redirect(r_('index.php?option=com_chronoforums'));	
			}
			$uid = \GCore\Libs\Request::data('u', 0);
			$user_id = $user['id'];
			if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') === true){
				$user_id = !empty($uid) ? $uid : $user['id'];
			}
			//$this->Topic->conditions['user_id'] = $user_id;
			$this->Topic->bindModels('hasOne', array(
				'Subscribed' => array(
					'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Subscribed',
					'foreignKey' => 'topic_id',
					'join_conditions' => array('Subscribed.topic_id = Topic.id'),
				),
			));
			$this->Topic->contain[] = 'Subscribed';
			$this->Topic->conditions['OR']['Subscribed.user_id'] = $user_id;
			$this->Topic->conditions['OR']['Topic.user_id'] = $user_id;
		}
		if(\GCore\Libs\Request::data('list') == 'favorites' AND $this->fparams->get('enable_topics_favorites', 0)){
			if(empty($user['id'])){
				$this->redirect(r_('index.php?option=com_chronoforums'));	
			}
			$this->Topic->bindModels('hasOne', array(
				'Favorite' => array(
					'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Favorite',
					'foreignKey' => 'topic_id',
					'join_conditions' => array('Favorite.user_id' => $user['id'], 'Favorite.topic_id = Topic.id'),
				),
			));
			$this->Topic->contain[] = 'Favorite';
			$this->Topic->conditions['Favorite.user_id'] = $user['id'];
		}
		if($this->fparams->get('enable_topics_featured', 0)){
			$this->Topic->bindModels('hasOne', array(
				'Featured' => array(
					'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Featured',
					'foreignKey' => 'topic_id',
				),
			));
			$this->Topic->contain[] = 'Featured';
		}
		if(\GCore\Libs\Request::data('list') == 'featured'){
			$this->Topic->conditions['Featured.topic_id <>'] = 0;
		}
		if(\GCore\Libs\Request::data('list') == 'unpublished'){
			//$this->Topic->conditions['Topic.published'] = 0;
			//generate a virual post model without any relationships, using the default one would contain the related models which should be contained later in the JOIN
			\GCore\Libs\Model::generateModel('UnpublishedPost', array(
				'tablename' => $this->Post->tablename,
			));
			$this->Topic->bindModels('hasOne', array(
				'UnpublishedPost' => array(
					'className' => '\GCore\Models\UnpublishedPost',
					'foreignKey' => 'topic_id',
					'join_conditions' => array('UnpublishedPost.topic_id = Topic.id'),
				),
			));
			$this->Topic->contain[] = 'UnpublishedPost';
			$this->Topic->conditions['OR']['UnpublishedPost.published'] = 0;
			$this->Topic->conditions['OR']['Topic.published'] = 0;
		}
		
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') === true){
			unset($this->Topic->conditions['published']);
		}
		$this->Topic->order_by = array('Topic.announce DESC', 'Topic.sticky DESC', $this->fparams->get('topics_ordering', 'LastPost.created DESC'));
		if(\GCore\Libs\Request::data('list')){
			$this->Topic->order_by = array($this->fparams->get('topics_ordering', 'LastPost.created DESC'));
		}
		$this->Topic->page_limit = $this->fparams->get('topics_limit', 20);
		$this->Topic->contain = array_merge($this->Topic->contain, array('Topic', 'TopicAuthor', 'LastPost', 'PostAuthor'));
		//$this->Topic->recursive = -1;
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
		//limit the search words
		$search_term = trim(\GCore\Libs\Request::data($seacrh_field));
		$search_term = \GCore\Libs\Str::clean($search_term, 'A-Za-z0-9-_\* \'"');
		$search_conditions = array();
		if(!empty($search_term)){
			$search_term = implode(' ', array_slice(explode(' ', $search_term), 0, $this->fparams->get('search_words_limit', 4)));
			//check spoofing
			if((int)$this->fparams->get('search_flooding_limit', 20) > 0){
				$current_spoofing = $session->get('cfu_last_search', 0);
				$cfu_last_search_term = $session->get('cfu_last_search_term', '');
				if($cfu_last_search_term != $search_term AND !empty($current_spoofing) AND (int)$this->fparams->get('search_flooding_limit', 20) + $current_spoofing > time()){
					$session->setFlash('error', sprintf(l_('CHRONOFORUMS_SEARCH_SPOOFING_ERROR'), $this->fparams->get('search_flooding_limit', 20)));
					$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.$fid));
				}else{
					$session->set('cfu_last_search', time());
					$session->set('cfu_last_search_term', $search_term);
				}
			}
		}
		//pr($_SESSION['gcore']);
		\GCore\Libs\Request::set($seacrh_field, $search_term);
		if($this->fparams->get('search_method', 'deep') == 'deep'){
			$this->search_model = $this->Post;
			$this->Post->page_limit = /*$this->Post->limit =*/ $this->fparams->get('topics_limit', 20);//because we are searching the posts
			$this->Post->page = \GCore\Libs\Request::data('page', 1);//$session->get(get_class($this).'.Topic.page', 1);
			$this->search_prefix = $fid;
			$this->Post->contain = array('Post');
			$post_fields = array('Post.id', 'Post.topic_id', 'Post.forum_id');
			if($this->fparams->get('deep_search_type', 'match') == 'like'){
				$searched = $this->_search(array('Post.text', 'Post.subject'), $seacrh_field, 'like');
			}else if($this->fparams->get('deep_search_type', 'match') == 'match'){
				$searched = $this->_search(array('text', 'subject'), $seacrh_field, 'match');
				if($this->fparams->get('search_order', 'relevance') == 'relevance'){
					$post_fields[":MATCH (".$this->Topic->dbo->quoteName('text').",".$this->Topic->dbo->quoteName('subject').") AGAINST (".$this->Topic->dbo->quote(\GCore\Libs\Request::data($seacrh_field))." IN BOOLEAN MODE)"] = ':'.$this->Topic->dbo->quoteName('Post.relevance');
					$this->Post->order_by = array(':'.$this->Topic->dbo->quoteName('Post.relevance').' DESC', 'Post.created DESC');
				}
			}
			$tids = array();
			if($searched !== false){
				$cond = array();
				if(!empty($fid)){
					$cond = array('Post.forum_id' => $fid);
				}
				$cond = array_merge($cond, $this->_search_conditions('Post'));
				$this->Post->conditions = array_merge($cond, $this->Post->conditions);
				$posts = $this->Post->find('all', array('conditions' => $cond, 'group' => array('Post.topic_id'), 'fields' => $post_fields));
				$posts_count = $this->Post->find('count', array('conditions' => $cond, 'group' => array('Post.topic_id'), 'fields' => array('Post.topic_id')));
				$this->paginate_total = $posts_count;
				if(!empty($posts)){
					$tids = \GCore\Libs\Arr::getVal($posts, array('[n]', 'Post', 'topic_id'));
					$this->Topic->conditions['id'] = $tids;
					if($this->fparams->get('deep_search_type', 'match') == 'match'){
						$this->Topic->order_by = array();
						foreach($tids as $tid){
							$this->Topic->order_by[] = 'Topic.id = '.$this->Topic->dbo->quote($tid).' DESC';
						}
					}
				}else{
					$this->Topic->conditions[] = '1=0';
				}
				$this->set('searched', \GCore\Libs\Request::data($seacrh_field));
			}
		}elseif($this->fparams->get('search_method', 'deep') == 'tags'){
			$session = \GCore\Libs\Base::getSession();
			$search_string = \GCore\Libs\Request::data($seacrh_field, $session->get('chronoforums.'.$fid.'.Tagged.search.'.$seacrh_field, null));
			$search_string = trim(strtolower($search_string));
			if(empty($search_string)){
				$session->clear('chronoforums.'.$fid.'.Tagged.search.'.$seacrh_field);
			}else{
				$session->set('chronoforums.'.$fid.'.Tagged.search.'.$seacrh_field, $search_string);
				\GCore\Libs\Request::set($seacrh_field, $search_string);
				
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
						$this->Topic->conditions = array_merge($this->Topic->conditions, $this->_search_conditions('Topic'));
						if($this->fparams->get('search_order', 'relevance') == 'relevance'){
							$this->Topic->order_by = array(':'.$this->Topic->dbo->quoteName('Topic.tag_count').' DESC');
						}
						$this->set('searched', \GCore\Libs\Request::data($seacrh_field));
					}
				}
				if(empty($tag_ids)){
					$this->Topic->conditions[] = '1=0';
				}
				$this->Topic->recursive = 1;
			}
		}
		
		//$this->Topic->recursive = -1; // comment to include the tagged in search results
		$this->paginate_model = $this->Topic;
		$this->paginate_prefix = $fid;
		$this->_paginate();
		if(!empty($this->paginate_total)){
			$this->Topic->page = 1;//if this is a deep search and we have used the post model for searching, then we feed the topic model with a limited list of ids, we should always display the first page so that we can get 0 offset
		}
		$this->Topic->recursive = 1;
		
		$find_params = array('cache' => true, 'fields' => array('COUNT(*)' => 'tag_count', 'Topic.*', 'Featured.*', 'TopicAuthor.id', 'TopicAuthor.username', 'TopicAuthor.name', 'LastPost.id', 'LastPost.user_id', 'LastPost.created', 'PostAuthor.id', 'PostAuthor.username', 'PostAuthor.name', 'TopicAuthorProfile.*', 'PostAuthorProfile.*'));
		//$this->Topic->order_by = array($this->Topic->dbo->quoteName('Topic.tag_count').' DESC');
		
		if(!empty($tids)){
			$find_params['conditions'] = array('id' => $tids);
		}
		if($global_listing === true){
			$this->Topic->bindModels('belongsTo', array(
				'Forum' => array(
					'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Forum',
					'foreignKey' => 'forum_id',
				),
			));
			$this->Topic->contain[] = 'Forum';
			$find_params['fields'][] = 'Forum.id';
			$find_params['fields'][] = 'Forum.cat_id';
			$find_params['fields'][] = 'Forum.title';
			$find_params['fields'][] = 'Forum.alias';
			$this->Topic->Forum->bindModels('belongsTo', array(
				'Category' => array(
					'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Category',
					'foreignKey' => 'cat_id',
				),
			));
			$this->Topic->contain[] = 'Category';
			$find_params['fields'][] = 'Category.id';
			$find_params['fields'][] = 'Category.title';
		}
		//get answers
		$this->Topic->bindModels('hasOne', array(
			'Answer' => array(
				'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Answer',
				'foreignKey' => 'topic_id',
			),
		));
		$this->Topic->contain[] = 'Answer';
		$find_params['fields'][] = 'Answer.*';
		
		//get votes
		if($this->fparams->get('enable_votes', 0) == 'post'){
			$this->Topic->bindModels('hasMany', array(
				'Vote' => array(
					'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Vote',
					'fields' => array('SUM(vote)' => 'votes_sum', 'topic_id'),
					'group' => array('Vote.topic_id'),
				),
			));
			$this->Topic->contain[] = 'Vote';
		}
		
		//track topic read status
		if($this->uprofile->get('Profile.params.preferences.enable_topics_track', 0)){
			if(!empty($user['id']) AND (bool)$this->fparams->get('enable_topics_track', 0) === true){
				$this->Topic->bindModels('hasOne', array(
					'TopicTrack' => array(
						'className' => '\GCore\Admin\Extensions\Chronoforums\Models\TopicTrack',
						'foreignKey' => 'topic_id',
						'join_conditions' => array('TopicTrack.topic_id = Topic.id', 'TopicTrack.user_id' => $user['id']),
					),
				));
				$this->Topic->contain[] = 'TopicTrack';
				$find_params['fields'][] = 'TopicTrack.*';
			}
		}
		//$find_params['group'] = 'Topic.id';
		$topics = $this->Topic->find('all', $find_params);
		
		if(empty($topics) AND \GCore\Libs\Request::data($seacrh_field)){
			\GCore\Libs\Env::e404();
		}
		if(empty($topics) AND \GCore\Libs\Request::data('page') AND \GCore\Libs\Request::data('page') != '1'){
			\GCore\Libs\Env::e404();
		}
		//pr($this->Topic->dbo->log);die();
		$this->set('topics', $topics);
		$this->set('user', \GCore\Libs\Base::getUser());
		return;
		
		forum_not_exist:
		$this->set('offline_message', l_('CHRONOFORUMS_FORUM_DOESNT_EXIST'));
		\GCore\Libs\Env::e404();
	}
	
	function _search_conditions($model = 'Post'){
		$search_conditions = array();
		if(\GCore\Libs\Request::data('search_age')){
			$search_age = \GCore\Libs\Request::data('search_age');
			$time = substr($search_age, 1);
			$count = substr($search_age, 0, 1);
			switch($time){
				case 'm':
				$time = 30 * 24 * 60 * 60;
				break;
				case 'y':
				$time = 365 * 24 * 60 * 60;
				break;
				case 'w':
				$time = 7 * 24 * 60 * 60;
				break;
			}
			$search_age = date("Y-m-d H:i:s", time() - ($time * $count));
			$search_conditions[$model.'.created >='] = $search_age;
		}
		return $search_conditions;
	}
}
?>
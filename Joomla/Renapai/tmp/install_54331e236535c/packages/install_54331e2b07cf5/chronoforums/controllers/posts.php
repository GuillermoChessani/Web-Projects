<?php
/**
* COMPONENT FILE HEADER
**/
namespace GCore\Extensions\Chronoforums\Controllers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Posts extends \GCore\Extensions\Chronoforums\Chronoforums {
	//var $models = array('\GCore\Admin\Extensions\Chronoforums\Models\Post');
	//var $libs = array('\GCore\Libs\Request');
	var $helpers= array( 
		'\GCore\Helpers\Assets', 
		'\GCore\Helpers\Html', 
		'\GCore\Helpers\Paginator',
		'\GCore\Extensions\Chronoforums\Helpers\TopicTasks',
		'\GCore\Extensions\Chronoforums\Helpers\PostTasks',
		'\GCore\Extensions\Chronoforums\Helpers\UserTasks',
		'\GCore\Extensions\Chronoforums\Helpers\Elements',
		'\GCore\Extensions\Chronoforums\Helpers\Output',
		'\GCore\Extensions\Chronoforums\Helpers\Bbeditor',
		'\GCore\Extensions\Chronoforums\Helpers\PostEdit',
		//'\GCore\Helpers\Sorter'
	);
	
	function index(){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic', 'Forum')));
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post', 'PostAuthor', 'Attachment', 'Report', 'ReportAuthor')));
		
		$user = \GCore\Libs\Base::getUser();
		$fid = \GCore\Libs\Request::data('f', 0);
		$tid = \GCore\Libs\Request::data('t', 0);
		$pid = \GCore\Libs\Request::data('p', 0);
		$page = 0;
		$offset = 0;
		
		if(!empty($pid)){
			/*
			$all_posts = $this->Post->find('all', array('recursive' => -1, 'fields' => 'id', 'order' => $this->fparams->get('posts_ordering', 'Post.created ASC'), 'conditions' => array('topic_id' => $tid)));
			$keys = array_keys(\GCore\Libs\Arr::searchVal($all_posts, array('[n]', 'Post', 'id'), array($pid)));
			$page = ceil(($keys[0] + 1)/$this->fparams->get('posts_limit', 10));
			*/
			$order = $this->uprofile->get('Profile.params.preferences.posts_ordering', $this->fparams->get('posts_ordering', 'Post.created ASC'));
			$param = 'created >=';
			if($order == 'Post.created ASC'){
				$param = 'created >=';
			}else{
				$param = 'created <=';
			}
			$post_date = $this->Post->field('created', array('id' => $pid));
			$last_part = $this->Post->find('count', array('recursive' => -1, 'conditions' => array('topic_id' => $tid, $param => $post_date)));
			if($last_part > 0){
				$all_posts = $this->Post->find('count', array('recursive' => -1, 'conditions' => array('topic_id' => $tid)));
				$page = ceil(($all_posts - $last_part + 1)/$this->fparams->get('posts_limit', 10));
				$offset = $all_posts - $last_part + 1;
			}
		}
		if(!empty($tid)){
			if(((bool)$this->fparams->get('enable_topic_tags', 0) === true) OR (($this->fparams->get('search_method', 'deep') == 'tags') AND \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics'))){
				$this->Topic->bindModels('hasMany', array(
					'Tagged' => array(
						'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Tagged',
						'foreignKey' => 'topic_id',
					),
				));
				$this->Topic->Tagged->bindModels('belongsTo', array(
					'Tag' => array(
						'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Tag',
						'foreignKey' => 'tag_id',
					),
				));
				$this->Topic->contain[] = 'Tagged';
				$this->Topic->contain[] = 'Tag';
				if((((bool)$this->fparams->get('enable_topic_tags', 0) === true) OR ($this->fparams->get('search_method', 'deep') == 'tags')) AND \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics')){
					$this->set('tags', $this->Topic->Tagged->Tag->find('all', array('conditions' => array('Tag.published' => 1))));
				}
			}
			//get answers
			$this->Topic->bindModels('hasOne', array(
				'Answer' => array(
					'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Answer',
					'foreignKey' => 'topic_id',
				),
			));
			$this->Topic->contain[] = 'Answer';
			
			if(!empty($user['id']) AND $this->fparams->get('enable_topics_favorites', 0)){
				$this->Topic->bindModels('hasOne', array(
					'Favorite' => array(
						'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Favorite',
						'foreignKey' => 'topic_id',
						'join_conditions' => array('Favorite.user_id' => $user['id'], 'Favorite.topic_id = Topic.id'),
					),
				));
				$this->Topic->contain[] = 'Favorite';
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
			//get topic data
			$topic = $this->Topic->find('first', array('cache' => true, 'conditions' => array('id' => $tid), 'contain' => array('Forum'), 'fields' => array('Topic.*', 'Answer.*', 'Favorite.*', 'Featured.*', 'Forum.id', 'Forum.title', 'Forum.alias', 'Forum.published', 'Forum.description', 'Forum.rules')));
			//pr($topic);
			if(empty($topic)){
				$this->set('offline_message', l_('CHRONOFORUMS_TOPIC_DOESNT_EXIST'));
				\GCore\Libs\Env::e404();
				return;
			}
			
			$this->set('forum', array('Forum' => $topic['Forum']));
			if((bool)$this->fparams->get('forum_permissions', 0) === true AND !\GCore\Libs\Authorize::check_rules($topic['Forum']['rules']['display'])){
				$this->set('offline_message', l_('CHRONOFORUMS_FORUM_ACCESS_DENIED'));
				\GCore\Libs\Env::e404();
				return;
			}
			if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'read_topics', $topic['Topic']['user_id']) !== true){
				$this->set('offline_message', l_('CHRONOFORUMS_TOPIC_ACCESS_DENIED'));
				\GCore\Libs\Env::e404();
				return;
			}
			if((bool)$this->fparams->get('forum_permissions', 0) === true AND !\GCore\Libs\Authorize::check_rules($topic['Forum']['rules']['read_topics'], array(), $topic['Topic']['user_id'])){
				$this->set('offline_message', l_('CHRONOFORUMS_TOPIC_ACCESS_DENIED'));
				\GCore\Libs\Env::e404();
				return;
			}
			
			if(empty($topic['Forum']['published'])){
				$this->set('offline_message', l_('CHRONOFORUMS_FORUM_IS_OFFLINE'));
				\GCore\Libs\Env::e404();
				return;
			}
			if(empty($topic['Topic']['published']) AND \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') !== true){
				$this->set('offline_message', l_('CHRONOFORUMS_TOPIC_IS_OFFLINE'));
				\GCore\Libs\Env::e404();
				return;
			}
			$this->set('topic', $topic);
			$this->_sortable();
			
			$this->Post->contain = array('Post', 'PostAuthor', /*'GroupUser', *//*'Attachment',*/ /*'Report', 'ReportAuthor',*/ 'UserSession');
			
			if(!empty($topic['Topic']['has_attachments']) AND \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'list_attachments') === true){
				$this->Post->contain[] = 'Attachment';
			}
			
			if($this->fparams->get('enable_votes', 0) == 'post'){
				$this->Post->bindModels('hasMany', array(
					'Vote' => array(
						'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Vote',
						'fields' => array('SUM(vote)' => 'votes_sum', 'post_id'),
						'group' => array('Vote.post_id'),
					),
				));
				$this->Post->contain[] = 'Vote';
				
				$this->Post->bindModels('hasOne', array(
					'VoteOwner' => array(
						'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Vote',
						'join_conditions' => array('VoteOwner.post_id = Post.id', 'VoteOwner.user_id' => $user['id']),
					),
				));
				$this->Post->contain[] = 'VoteOwner';
			}
			//if((bool)$this->fparams->get('show_author_posts_count', 1)){
				/*\GCore\Libs\Model::generateModel('PostCounter', array(
					'tablename' => $this->Post->tablename,
				));
				$this->Post->PostAuthor->bindModels('hasMany', array(
					'PostCounter' => array(
						'className' => '\GCore\Models\PostCounter',
						'foreignKey' => 'user_id',
						'fields' => array('COUNT(*)' => 'count', 'user_id'),
						'group' => 'user_id',
					),
				));
				$this->Post->contain[] = 'PostCounter';*/
				$this->Post->PostAuthor->bindModels('hasOne', array(
					'Profile' => array(
						'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Profile',
						'foreignKey' => 'user_id',
					),
				));
				$this->Post->contain[] = 'Profile';
			//}
			/*$this->Post->PostAuthor->bindModels('hasOne', array(
				'UserSession' => array(
					'className' => '\GCore\Admin\Models\Session',
					'foreignKey' => 'userid',
					'join_conditions' => array('(UserSession.userid = PostAuthor.id AND UserSession.client_id = 0)')
				),
			));*/
			$online_ids = \GCore\Admin\Models\Session::getInstance()->find('list', array('fields' => array('userid'), 'conditions' => array('client_id' => 0, 'userid <>' => 0)));
			$this->set('online_ids', $online_ids);
			//$this->Post->contain = array('Post', 'PostAuthor', /*'GroupUser', */'PostCounter', 'Attachment', /*'Report', 'ReportAuthor',*/ 'UserSession');
			if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'view_reports')){
				$this->Post->contain[] = 'Report';
				$this->Post->contain[] = 'ReportAuthor';
				$this->Post->Report->ReportAuthor->bindModels('hasOne', array(
					'ReportAuthorProfile' => array(
						'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Profile',
						'foreignKey' => 'user_id',
					),
				));
				$this->Post->contain[] = 'ReportAuthorProfile';
			}
			
			$this->Post->conditions = array('topic_id' => $tid);
			if(!\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics')){
				$this->Post->conditions['published'] = 1;
			}
			$this->Post->limit = $this->fparams->get('posts_limit', 10);
			$this->Post->order_by = $this->uprofile->get('Profile.params.preferences.posts_ordering', $this->fparams->get('posts_ordering', 'Post.created ASC'));
			
			if(!empty($page)){
				$this->Post->page = $page;
			}
			$this->search_model = $this->Post;
			$this->search_prefix = $tid;
			$this->_search(array('Post.text'), 'keywords');
			$this->set('keywords', \GCore\Libs\Request::data('keywords'));
			
			$this->Post->recursive = -1;
			$this->paginate_model = $this->Post;
			$this->paginate_prefix = $tid;
			//if this is a posts loader request then abandon pages and just load posts
			if(!empty($this->data['posts_loader'])){
				$this->Post->page = 0;
				$this->Post->offset = $offset;
				$this->Post->limit = $this->fparams->get('posts_loader_limit', 3);
			}else{
				$this->_paginate();
			}
			$this->Post->recursive = 1;
			$posts = $this->Post->find('all', array('cache' => true, 'fields' => array('Post.*', 'Profile.*', /*'UserSession.userid',*/'VoteOwner.*', 'PostAuthor.id', 'PostAuthor.username', 'PostAuthor.name', 'PostAuthor.registerDate')));
			//pr($this->Post->dbo->log);
			
			//pr($posts);
			$this->set('posts', $posts);
			//$this->set('forum', array('Forum' => $topic['Forum']));
			$this->set('searched', \GCore\Libs\Request::data('hilit'));
			
			if(!empty($this->data['posts_loader'])){
				if(empty($posts)){
					echo '_END_';
					$this->view = false;
				}
				return;
			}
			
			if(empty($posts)){
				\GCore\Libs\Env::e404();
			}
			//add 1 hit
			if((bool)$this->fparams->get('enable_topic_views', 1) === true){
				$this->Topic->id = $tid;
				$this->Topic->updateField('hits', '+ 1', array('reset_cache' => false));
			}
			//track topic read status
			if($this->uprofile->get('Profile.params.preferences.enable_topics_track', 0)){
				if(!empty($user['id']) AND (bool)$this->fparams->get('enable_topics_track', 0) === true){
					$this->TopicTrack = \GCore\Admin\Extensions\Chronoforums\Models\TopicTrack::getInstance();
					$already_tracked = $this->TopicTrack->field('last_visit', array('topic_id' => $topic['Topic']['id'], 'user_id' => $user['id']));
					if(empty($already_tracked)){
						$last_post_author = $this->Post->field('user_id', array('Post.id' => $topic['Topic']['last_post']));
						if($last_post_author != $user['id']){
							//set topic as read for this user
							$this->TopicTrack->save(array('topic_id' => $topic['Topic']['id'], 'forum_id' => $topic['Forum']['id'], 'user_id' => $user['id'], 'last_visit' => date('Y-m-d H:i:s', time())), array('new' => true));
						}
					}else{
						//topic track record already exists, update it
						$this->TopicTrack->updateAll(array('last_visit' => date('Y-m-d H:i:s', time()), 'forum_id' => $topic['Forum']['id']), array('topic_id' => $topic['Topic']['id'], 'user_id' => $user['id']));
					}
				}
			}
			//auto fixing the count if there is a mismatch
			if(!empty($this->helpers['\GCore\Helpers\Paginator']['total']) AND $this->helpers['\GCore\Helpers\Paginator']['total'] != $topic['Topic']['post_count']){
				$this->Topic->id = $topic['Topic']['id'];
				$this->Topic->saveField('post_count', $this->helpers['\GCore\Helpers\Paginator']['total']);
			}
			
			
			if(empty($posts) AND \GCore\Libs\Request::data('keywords')){
				$this->set('offline_message', l_('CHRONOFORUMS_NO_POSTS_WERE_FOUND'));
			}
			
			if(!empty($user['id'])){
				$subscribed = \GCore\Admin\Extensions\Chronoforums\Models\Subscribed::getInstance()->find('first', array('conditions' => array(
					'topic_id' => $tid,
					'user_id' => $user['id'],
					'sub_type' => 'topic',
				)));
				$this->set('subscribed', $subscribed);
				//update subscription status
				if(!empty($subscribed['Subscribed']['notify_status'])){
					\GCore\Admin\Extensions\Chronoforums\Models\Subscribed::getInstance()->updateAll(array('notify_status' => 0), array(
						'topic_id' => $tid,
						'user_id' => $user['id'],
						'sub_type' => 'topic',
					));
				}
			}
			//set page title
			\GCore\Libs\Event::trigger('on_set_page_title', $topic['Topic']['title']);
			
			if($this->fparams->get('enable_extra_topic_info', 0) AND !empty($topic['Topic']['params']['fields'])){
				$this->data['topic_info'] = $topic['Topic']['params']['fields'];
			}
			
		}else{
			$this->set('offline_message', l_('CHRONOFORUMS_TOPIC_DOESNT_EXIST'));
		}
	}
	
	function reply_quote(){
		$this->reply(true);
		$this->view = 'reply';
	}
	
	function reply($quote = false, $auto_user = false){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic', 'Forum')));
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post', 'Topic', 'Forum', 'PostAuthor', 'GroupUser', 'Attachment', 'Report', 'ReportAuthor')));
		
		$session = \GCore\Libs\Base::getSession();
		$user = $auto_user ? $auto_user : \GCore\Libs\Base::getUser();
		$tid = \GCore\Libs\Request::data('t', 0);
		$pid = \GCore\Libs\Request::data('p', 0);
		if(!empty($tid)){
			$topic = $this->Topic->find('first', array('conditions' => array('id' => $tid), 'contain' => array('Forum')));
			$this->set('topic', $topic);
			if(!empty($topic)){
				if(!empty($topic['Topic']['locked'])){
					//topic is locked
					$session->setFlash('error', l_('CHRONOFORUMS_TOPIC_LOCKED_ERROR'));
					$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&&t='.$topic['Topic']['id'].'&f='.$topic['Forum']['id']));
				}
				//auto lock topic for inactivity
				if((int)$this->fparams->get('auto_lock_topic_inactive_limit', 0)){
					if(strtotime($topic['Topic']['created']) + ((int)$this->fparams->get('auto_lock_topic_inactive_limit', 0) * 24 * 60 * 60) < time()){
						$this->Topic->updateAll(array('locked' => 1), array('id' => $tid));
						$session->setFlash('error', l_('CHRONOFORUMS_TOPIC_AUTOLOCKED_ERROR'));
						$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&&t='.$topic['Topic']['id'].'&f='.$topic['Forum']['id']));
					}
				}
				//if this is an auto reply then skip permissions check
				if($this->fparams->get('enable_auto_reply', 0) AND $this->fparams->get('auto_reply_user_id', 0)){
					if($user['id'] == $this->fparams->get('auto_reply_user_id', 0) AND !empty($this->data['auto_reply_sec_token']) AND $this->data['auto_reply_sec_token'] == $this->fparams->get('auto_reply_sec_token', '')){
						$auto_reply_active = true;
						goto posts_reply_permissions_skipped;
					}
				}
				
				if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'make_posts') !== true){
					$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
					$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&&t='.$topic['Topic']['id'].'&f='.$topic['Forum']['id']));
				}
				if((bool)$this->fparams->get('forum_permissions', 0) === true AND !\GCore\Libs\Authorize::check_rules($topic['Forum']['rules']['make_posts'])){
					$session->setFlash('error', l_('CHRONOFORUMS_FORUM_ACTION_DENIED'));
					$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&&t='.$topic['Topic']['id'].'&f='.$topic['Forum']['id']));
				}
				posts_reply_permissions_skipped:
				if(!empty($this->data['Post'])){
					if(!empty($this->data['upload'])){
						$this->_upload_file();
					}else if(!empty($this->data['delete_file'])){
						$this->_delete_file();
					}else if(!empty($this->data['cancel_post'])){
						$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
					}else if(!empty($this->data['preview'])){
						$this->_preview();
					}else{
						if(!empty($this->data['quick_reply_submit'])){
							$this->data['Post']['subject'] = 'Re: '.$topic['Topic']['title'];
							if((bool)$this->fparams->get('topic_subscribe_enabled', 1) === true){
								$this->data['subscribe'] = 1;
							}
						}
						//check spoofing
						if((int)$this->fparams->get('spoofing_limit', 30) > 0){
							$current_spoofing = $session->get('cfu_last_post', 0);
							if(!empty($current_spoofing) AND (int)$this->fparams->get('spoofing_limit', 30) + $current_spoofing > time()){
								$session->setFlash('error', l_('CHRONOFORUMS_SPOOFING_ERROR'));
								$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$topic['Topic']['id'].'&f='.$topic['Forum']['id']));
							}else{
								$session->set('cfu_last_post', time());
							}
						}
						//upload any not uploaded files
						$quick_upload_result = $this->_upload_file();
						if($quick_upload_result === false){
							return;	
						}
						//save reply
						$this->data['Post']['topic_id'] = $tid;
						$this->data['Post']['forum_id'] = $topic['Topic']['forum_id'];
						
						$this->data['Post']['user_id'] = $user['id'];
						$this->data['Post']['author_name'] = $user['username'];
						//$this->data['Post']['published'] = 1;
						if((bool)$this->fparams->get('new_posts_published', 1) === true OR \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics')){
							$this->data['Post']['published'] = 1;
						}else{
							$this->data['Post']['published'] = 0;
							if((int)$this->fparams->get('auto_approval_threshold', 0)){
								$approved_posts = $this->Post->find('count', array('contain' => array('Post', 'Topic'), 'conditions' => array('Post.user_id' => $user['id'], 'Post.published' => 1, 'Topic.published' => 1)));
								if($approved_posts >= (int)$this->fparams->get('auto_approval_threshold', 0)){
									$this->data['Post']['published'] = 1;
								}
							}
							if((int)$this->fparams->get('non_approved_threshold', 0)){
								$non_approved_posts = $this->Post->find('count', array('contain' => array('Post', 'Topic'), 'conditions' => array('Post.user_id' => $user['id'], 'OR' => array('Post.published' => 0, 'Topic.published' => 0))));
								if($non_approved_posts >= (int)$this->fparams->get('non_approved_threshold', 0)){
									$session->setFlash('error', l_('CHRONOFORUMS_NON_APPROVED_LIMIT_REACHED'));
									$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
								}
							}
						}
						$this->data['Post']['params']['author_address'] = $_SERVER['REMOTE_ADDR'];
						
						$this->data['Topic']['title'] = $topic['Topic']['title'];//$this->data['Post']['subject'];
						//check topic uid
						if((bool)$this->fparams->get('enable_emails_posting') === true){
							$this->data['Topic']['params']['uid'] = !empty($topic['Topic']['params']['uid']) ? $topic['Topic']['params']['uid'] : '';
							if(empty($this->data['Topic']['params']['uid'])){
								//$this->Topic->id = $tid;
								$this->data['Topic']['params']['uid'] = \GCore\Libs\Str::uuid();
								//$this->Topic->saveField('params', array_merge($topic['Topic']['params'], array('uid' => $this->data['Topic']['params']['uid'])));
								$this->Topic->save(array(
									'id' => $tid, 
									'params' => array_merge($topic['Topic']['params'], array('uid' => $this->data['Topic']['params']['uid'])),
								), array('whitelist' => array('id', 'params'), 'modified' => false, 'validate' => false));
							}
						}
						
						if(!empty($this->data['Attachment'])){
							foreach($this->data['Attachment'] as $k => $attachment){
								$this->data['Attachment'][$k]['topic_id'] = $tid;
								$this->data['Attachment'][$k]['user_id'] = $user['id'];
							}
							$this->Topic->id = $tid;
							$this->Topic->saveField('has_attachments', 1);
						}
						//if topic is unpublished and this is not an auto reply then publish it
						if(empty($topic['Topic']['published']) AND !$auto_reply_active){
							$this->Topic->id = $tid;
							$result = $this->Topic->saveField('published', 1);
						}
						
						$result = $this->Post->save($this->data, array('validate' => true));
						
						$this->data['Topic']['title_link'] = \GCore\Helpers\Html::url($this->data['Topic']['title'], r_('index.php?option=com_chronoforums&cont=posts&p='.$this->Post->id.'&t='.$tid.'#p'.$this->Post->id, false, true));
						
						if($result !== false){
							//save subscription
							if(!empty($this->data['subscribe'])){
								\GCore\Admin\Extensions\Chronoforums\Models\Subscribed::getInstance()->deleteAll(array(
									'topic_id' => $tid,
									'user_id' => $user['id'],
									'sub_type' => 'topic',
								));
								\GCore\Admin\Extensions\Chronoforums\Models\Subscribed::getInstance()->save(array(
									'topic_id' => $tid,
									'user_id' => $user['id'],
									'sub_type' => 'topic',
									'notify_status' => 0,
								));
							}
							//update user posts
							$this->_update_user_posts(false, $user);
							//update owner reputation
							if($this->fparams->get('enable_reputation', 0) AND !empty($user['id']) AND (int)$this->fparams->get('post_reputation_weight', 0)){
								$this->_update_user_reputation($user['id'], (int)$this->fparams->get('post_reputation_weight', 0));
							}
							//reset topic read status
							if((bool)$this->fparams->get('enable_topics_track', 0) === true){
								\GCore\Admin\Extensions\Chronoforums\Models\TopicTrack::getInstance()->deleteAll(array(
									'topic_id' => $tid,
								));
							}
							//tag topic
							if((bool)$this->fparams->get('auto_tag_topics', 0) === true){
								$this->Post->tag_topic($this->data);
							}
							//add history
							if((bool)$this->fparams->get('enable_community_support', 0) === true AND !empty($user['id'])){
								\GCore\Libs\Event::trigger('on_history_add', array('ext' => 'chornoforums', 'cont' => 'posts', 'act' => 'reply', 'item_id' => $this->Post->id, 'user_id' => $user['id'], 'data' => array('tid' => $tid)));
							}
							//send emails
							if((bool)$this->fparams->get('send_email_on_reply', 1) === true){
								$users_ids = \GCore\Admin\Extensions\Chronoforums\Models\Subscribed::getInstance()->find('list', array('conditions' => array(
									'topic_id' => $tid, 
									'user_id <>' => $user['id'],
									'sub_type' => 'topic',
									'notify_status' => 0,
								), 'fields' => array('user_id', 'topic_id')));
								if(!empty($users_ids)){
									$tos = $this->Post->PostAuthor->find('list', array('conditions' => array('id' => array_keys($users_ids)), 'fields' => array('email', 'username'), 'contain' => array('PostAuthor')));
									foreach($tos as $email => $username){
										$this->_sendEmail('new_reply', array($email => $username));
									}
								}
								//update existing subscribers as notified
								\GCore\Admin\Extensions\Chronoforums\Models\Subscribed::getInstance()->updateAll(array('notify_status' => 1), array(
									'topic_id' => $tid,
									'user_id <>' => $user['id'],
									'sub_type' => 'topic',
								));
							}
							//send mass email
							if(((int)$this->fparams->get('send_email_on_post', 0) === 1 OR ((int)$this->fparams->get('send_email_on_post', 0) === 2 AND empty($this->data['Post']['published']))) AND $this->fparams->get('posts_notify_groups', array())){
								$emails_list = $this->Post->PostAuthor->find('list', array('fields' => array('email', 'name', 'id'), 'conditions' => array('GroupUser.group_id' => $this->fparams->get('posts_notify_groups', array()))));
								$mods = !empty($emails_list) ? array_keys($emails_list) : array();
								foreach($mods as $mod){
									$this->_sendEmail('new_post', array($mod => $mod));
								}
							}
							//$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$this->Post->id.'&t='.$tid.'#p'.$this->Post->id));
							if(!empty($this->data['Post']['published'])){
								$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$this->Post->id.'&t='.$tid.'#p'.$this->Post->id));
							}else{
								$session->setFlash('success', l_('CHRONOFORUMS_POST_POSTED_NOT_PUBLISHED'));
								$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$this->Post->id.'&t='.$tid));
							}
						}else{							
							$session->setFlash('error', l_('CHRONOFORUMS_SAVE_ERROR'));
						}
					}
				}else{
					//new reply
					$this->data['Post']['subject'] = 'Re: '.$topic['Topic']['title'];
					if($quote){
						$post = $this->Post->find('first', array('conditions' => array('id' => $pid), 'contain' => array('Post', 'PostAuthor')));
						$this->data['Post']['text'] = '[quote="'.$post['PostAuthor']['username'].'"]'.$post['Post']['text'].'[/quote]';
					}
				}
			}
		}else{
			//display error
			$session->setFlash('error', l_('CHRONOFORUMS_TOPIC_DOESNT_EXIST'));
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
	}
		
	function edit(){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic', 'Forum')));
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post', 'Topic', 'PostAuthor', 'Attachment', 'Report', 'ReportAuthor')));
		
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();		
		$pid = \GCore\Libs\Request::data('p', 0);
		$tid = \GCore\Libs\Request::data('t', 0);
		if(!empty($pid)){
			$this->Post->contain = array('Post', 'PostAuthor', 'Attachment', 'Topic');
			$post = $this->Post->find('first', array('conditions' => array('id' => $pid)));
			if(!empty($tid)){
				$topic = $this->Topic->find('first', array('conditions' => array('id' => $tid), 'contain' => array('Forum')));
				$this->set('topic', $topic);
			}
			if(!empty($post)){
				if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'edit_posts', $post['PostAuthor']['id']) !== true){
					$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
					$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
				}
				if(!empty($this->data['Post'])){
					if(!empty($this->data['upload'])){
						$this->_upload_file();
					}else if(!empty($this->data['delete_file'])){
						$this->_delete_file();
					}else if(!empty($this->data['cancel_post'])){
						$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
					}else if(!empty($this->data['preview'])){
						$this->_preview();
					}else{
						//save reply
						$this->data['Post']['topic_id'] = $post['Topic']['id'];
						$this->data['Post']['forum_id'] = $post['Topic']['forum_id'];
						
						//$this->data['Post']['user_id'] = $user['id'];
						$this->data['Post']['id'] = $post['Post']['id'];
						
						if(!empty($this->data['Attachment'])){
							foreach($this->data['Attachment'] as $k => $attachment){
								$this->data['Attachment'][$k]['topic_id'] = $post['Topic']['id'];
								$this->data['Attachment'][$k]['user_id'] = $user['id'];
							}
							$this->Topic->id = $post['Topic']['id'];
							$this->Topic->saveField('has_attachments', 1);
						}else{
							if(!empty($post['Attachment'])){
								//this post had attachments but now all deleted
								$this->data['Attachment'] = array();
								$this->Topic->id = $post['Topic']['id'];
								$this->Topic->saveField('has_attachments', 0);
							}
						}
						
						$result = $this->Post->save($this->data, array('validate' => true));
						
						$this->data['Topic']['title_link'] = \GCore\Helpers\Html::url($post['Topic']['title'], r_('index.php?option=com_chronoforums&cont=posts&p='.$this->Post->id.'&t='.$post['Topic']['id'].'#p'.$this->Post->id, false, true));
						
						if($result !== false){
							//check first topic post
							$first_topic_post = $this->Post->find('first', array('conditions' => array('topic_id' => $post['Topic']['id']), 'contain' => array('Post'), 'order' => array('Post.created ASC'), 'fields' => array('Post.id')));
							if(!empty($first_topic_post) AND $first_topic_post['Post']['id'] == $post['Post']['id']){
								$this->Topic->id = $post['Topic']['id'];
								$this->Topic->saveField('title', $this->data['Post']['subject']);
							}
							
							//send mass email
							if((bool)$this->fparams->get('send_email_on_post_edit', 0) === true AND $this->fparams->get('posts_edit_notify_groups', array())){
								$emails_list = $this->Post->PostAuthor->find('list', array('fields' => array('email', 'name', 'id'), 'conditions' => array('GroupUser.group_id' => $this->fparams->get('posts_edit_notify_groups', array()))));
								$mods = !empty($emails_list) ? array_keys($emails_list) : array();
								foreach($mods as $mod){
									$this->_sendEmail('post_edit', array($mod => $mod));
								}
							}
							$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$this->Post->id.'&t='.$post['Topic']['id'].'#p'.$this->Post->id));
						}else{							
							$session->setFlash('error', l_('CHRONOFORUMS_SAVE_ERROR'));
						}
					}
				}else{
					$this->data = $post;
				}
			}
		}
	}
	
	function delete(){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic', 'Forum')));
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post', 'Topic', 'PostAuthor', 'Attachment', 'Report', 'ReportAuthor')));
		
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		$pid = \GCore\Libs\Request::data('p', 0);
		
		if(!empty($pid)){
			$this->Post->contain = array('Post', 'PostAuthor', 'Attachment', 'Topic', 'Forum');
			$this->Post->PostAuthor->bindModels('hasOne', array(
				'Profile' => array(
					'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Profile',
					'foreignKey' => 'user_id',
				),
			));
			$this->Post->contain[] = 'Profile';
			$post = $this->Post->find('first', array('conditions' => array('id' => $pid)));
			if(!empty($post)){
				if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'delete_posts', $post['PostAuthor']['id']) !== true){
					$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
					$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
				}
				if(!empty($this->data['confirm_delete'])){
					@ini_set('memory_limit', -1);
					$result = $this->Post->delete($pid);
					if($result !== false){
						//set topic reported and attachments
						/*
						$this->Post->contain = array('Post', 'Report', 'Attachment');
						$topic_posts = $this->Post->find('all', array('conditions' => array('topic_id' => $post['Topic']['id'])));
						$reported = false;
						$attachments = false;
						foreach($topic_posts as $topic_post){
							if(!empty($topic_post['Report'])){
								$reported = true;
							}
							if(!empty($topic_post['Attachment'])){
								$attachments = true;
							}
						}
						*/
						$topic_has_reports = $this->Post->Report->field('id', array('Report.topic_id' => $post['Topic']['id']));
						$topic_has_attachments = $this->Post->Attachment->field('id', array('Attachment.topic_id' => $post['Topic']['id']));
						
						$this->Topic->id = $post['Topic']['id'];
						if(empty($topic_has_reports)){
							$this->Topic->saveField('reported', 0);
						}else{
							$this->Topic->saveField('reported', 1);
						}
						if(empty($topic_has_attachments)){
							$this->Topic->saveField('has_attachments', 0);
						}else{
							$this->Topic->saveField('has_attachments', 1);
						}
						//update last post
						if($pid == $post['Topic']['last_post']){
							//fix forum's last post
							$last_post = $this->Post->find('first', array('conditions' => array('forum_id' => $post['Post']['forum_id']), 'fields' => array('id'), 'order' => 'Post.created DESC'));
							if(!empty($last_post)){
								$this->Topic->Forum->saveField('last_post', $last_post['Post']['id']);
							}
							//fix topic's last post
							$last_post = $this->Post->find('first', array('conditions' => array('topic_id' => $post['Topic']['id']), 'fields' => array('id'), 'order' => 'Post.created DESC'));
							if(!empty($last_post)){
								$this->Topic->saveField('last_post', $last_post['Post']['id']);
							}else{
								//topic had this post only and it was the last one, delete topic
								$topic_deleted = $this->Topic->delete($post['Topic']['id']);
								if($topic_deleted){
									$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.$post['Post']['forum_id']));
								}
							}
						}
						//redirect to the host topic
						$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$post['Topic']['id']));
					}else{							
						$session->setFlash('error', l_('CHRONOFORUMS_DELETE_ERROR'));
					}
				}elseif(!empty($this->data['cancel_delete'])){
					$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
				}else{
					$this->data = $post;
					$this->set('post', $post);
				}
			}
		}
	}
	
	function report(){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic', 'Forum')));
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post', 'Topic', 'PostAuthor', 'GroupUser', 'Attachment', 'Report', 'ReportAuthor')));
		
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		$pid = \GCore\Libs\Request::data('p', 0);
		
		if(!empty($pid)){
			$this->Post->contain = array('Post', 'PostAuthor', 'Attachment', 'Topic');
			$this->Post->PostAuthor->bindModels('hasOne', array(
				'Profile' => array(
					'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Profile',
					'foreignKey' => 'user_id',
				),
			));
			$this->Post->contain[] = 'Profile';
			$post = $this->Post->find('first', array('conditions' => array('id' => $pid)));
			if(!empty($post)){
				if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'report_posts') !== true){
					$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
					$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
				}
				if(!empty($this->data['confirm_report'])){
					$this->data['Report']['post_id'] = $post['Post']['id'];
					$this->data['Report']['topic_id'] = $post['Topic']['id'];
					$this->data['Report']['user_id'] = $user['id'];
					$result = $this->Post->Report->save($this->data);
					
					if($result !== false){
						$this->Topic->id = $post['Topic']['id'];
						$this->Topic->saveField('reported', 1);
						if((bool)$this->fparams->get('send_email_on_report', 1) === true){
							$this->data['url'] = r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id'], false, true);
							//$this->_sendEmail('report');
							$emails_list = $this->Post->PostAuthor->find('list', array('fields' => array('email', 'name', 'id'), 'conditions' => array('GroupUser.group_id' => $this->fparams->get('reports_notify_groups', array()))));
							$mods = !empty($emails_list) ? array_keys($emails_list) : array();
							foreach($mods as $mod){
								$this->_sendEmail('report', array($mod => $mod));
							}
						}
						$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
					}else{							
						$session->setFlash('error', l_('CHRONOFORUMS_SAVE_ERROR'));
					}
				}elseif(!empty($this->data['cancel_report'])){
					$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
				}else{
					$this->data = $post;
					$this->set('post', $post);
				}
			}
		}
	}
	
	function unreport(){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic', 'Forum')));
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post', 'Topic', 'Report')));
		
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		$pid = \GCore\Libs\Request::data('p', 0);
		
		if(!empty($pid)){
			$post = $this->Post->find('first', array('conditions' => array('id' => $pid)));
			if(!empty($post)){
				if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') !== true){
					$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
					$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
				}
				if(!empty($this->data['report_id'])){
					$result = $this->Post->Report->delete($this->data['report_id']);
					
					if($result !== false){
						$has_reports = $this->Post->Report->find('count', array('conditions' => array('Report.topic_id' => $post['Topic']['id'])));
						if(!empty($has_reports)){
							$has_reports = 1;
						}else{
							$has_reports = 0;
						}
						$this->Topic->id = $post['Topic']['id'];
						$this->Topic->saveField('reported', $has_reports);
						$session->setFlash('success', l_('CHRONOFORUMS_REPORT_DELETED'));
						$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
					}else{							
						$session->setFlash('error', l_('CHRONOFORUMS_SAVE_ERROR'));
					}
				}
			}
		}
	}
	
	function publish(){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic', 'Forum')));
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post', 'Topic')));
		
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();		
		$pid = \GCore\Libs\Request::data('p', 0);
		if(!empty($pid)){
			$this->Post->contain = array('Post', 'Topic');
			$post = $this->Post->find('first', array('conditions' => array('id' => $pid)));
			if(!empty($post)){
				if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') !== true){
					$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
					$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
				}
				$published = $this->Post->updateAll(array('published' => 1), array('id' => $post['Post']['id']));
				$session->setFlash('success', l_('CHRONOFORUMS_POST_PUBLISHED'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
			}
		}
	}
	
	function unpublish(){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic', 'Forum')));
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post', 'Topic')));
		
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();		
		$pid = \GCore\Libs\Request::data('p', 0);
		if(!empty($pid)){
			$this->Post->contain = array('Post', 'Topic');
			$post = $this->Post->find('first', array('conditions' => array('id' => $pid)));
			if(!empty($post)){
				if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') !== true){
					$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
					$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
				}
				$unpublished = $this->Post->updateAll(array('published' => 0), array('id' => $post['Post']['id']));
				$session->setFlash('success', l_('CHRONOFORUMS_POST_UNPUBLISHED'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
			}
		}
	}
	
	function answer(){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic', 'Forum')));
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post', 'Topic', 'PostAuthor', 'Attachment', 'Report', 'ReportAuthor')));
		
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();		
		$pid = \GCore\Libs\Request::data('p', 0);
		if(!empty($pid)){
			$this->Post->contain = array('Post', 'PostAuthor', 'Topic');
			$post = $this->Post->find('first', array('conditions' => array('id' => $pid)));
			if(!empty($post)){
				if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'select_answers', $post['Topic']['user_id']) !== true){
					$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
					$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
				}
				$answered = \GCore\Admin\Extensions\Chronoforums\Models\Answer::getInstance()->field('post_id', array('topic_id' => $post['Topic']['id']));
				if(!empty($answered)){
					$session->setFlash('error', l_('CHRONOFORUMS_ANOTHER_ANSWER_SELECTED'));
					$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
				}
				//update owner reputation
				if($this->fparams->get('enable_reputation', 0) AND !empty($post['Post']['user_id']) AND $post['Post']['user_id'] != $user['id']){
					$this->_update_user_reputation($post['Post']['user_id'], $this->fparams->get('answer_reputation_weight', 10));
				}
				
				\GCore\Admin\Extensions\Chronoforums\Models\Answer::getInstance()->save(array('topic_id' => $post['Topic']['id'], 'post_id' => $post['Post']['id'], 'user_id' => $user['id']), array('new' => true));
				$session->setFlash('success', l_('CHRONOFORUMS_ANSWER_SELECTED'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
			}
		}
	}
	
	function vote(){
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post', 'Topic')));
		$this->Vote = \GCore\Admin\Extensions\Chronoforums\Models\Vote::getInstance();
		
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();		
		$pid = \GCore\Libs\Request::data('p', 0);
		$tid = \GCore\Libs\Request::data('t', 0);
		
		$valid_votes = array(1, -1);
		if(!$this->fparams->get('enable_down_votes', 1)){
			$valid_votes = array(1);
		}
		if($this->fparams->get('enable_votes', 0) == 'post' AND !empty($pid) AND !empty($this->data['val']) AND in_array((int)$this->data['val'], $valid_votes)){
			$this->Post->contain = array('Post', 'Topic');
			$post = $this->Post->find('first', array('conditions' => array('id' => $pid)));
			if(!empty($post)){
				if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'make_votes', $post['Post']['user_id']) !== true){
					$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
					$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
				}
				$existing_vote = $this->Vote->field('post_id', array('post_id' => $pid, 'user_id' => $user['id']));
				if(!empty($existing_vote)){
					$session->setFlash('error', l_('CHRONOFORUMS_POST_VOTED_BEFORE'));
					$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
				}
				//update owner reputation
				if($this->fparams->get('enable_reputation', 0) AND !empty($post['Post']['user_id']) AND $post['Post']['user_id'] != $user['id']){
					$this->_update_user_reputation($post['Post']['user_id'], (int)$this->data['val'] * (int)$this->fparams->get('vote_reputation_weight', 1));
				}
				
				$this->Vote->save(array('topic_id' => $post['Topic']['id'], 'post_id' => $post['Post']['id'], 'user_id' => $user['id'], 'vote' => $this->data['val']), array('new' => true));
				$session->setFlash('success', l_('CHRONOFORUMS_POST_VOTED'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Topic']['id'].'#p'.$post['Post']['id']));
			}
		}else{
			$session->setFlash('error', l_('CHRONOFORUMS_VOTE_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$pid.'&t='.$tid.'#p'.$pid));
		}
	}
	
	function email_reply(){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic', 'Forum')));
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post', 'PostAuthor', 'Attachment', 'Report', 'ReportAuthor')));
		
		require_once(\GCore\C::get('GCORE_FRONT_PATH').'vendors'.DS.'imap_mailbox'.DS.'imap_mailbox.php');
		
		$session = \GCore\Libs\Base::getSession();
		$secret = trim($this->fparams->get('emails_posting_secret', ''));
		if(!empty($secret) AND (empty($this->data['secret']) OR ($this->data['secret'] != $secret))){
			$session->setFlash('error', l_('CHRONOFORUMS_ACCESS_ERROR'));
			\GCore\Libs\Env::e404();
			return;
		}
		
		$mailbox = new \ImapMailbox($this->fparams->get('email_reply_path'), $this->fparams->get('email_reply_email'), $this->fparams->get('email_reply_password'));
		//$mailstream = $mailbox->getImapStream();
		$msgs = $mailbox->getMailsInfo($mailbox->searchMailbox());//'UNSEEN'));
		foreach($msgs as $k => $msg){
			if(preg_match('/\[TUID#(.*?)\]/', $msg->subject, $matches)){
				if(!empty($matches[1])){
					$tuid = $matches[1];
					$topic = $this->Topic->find('first', array('conditions' => array('params LIKE' => '%'.$tuid.'%'), 'contain' => array('Topic')));
					$mail = $mailbox->getMail($msg->uid);
					$user = $this->Post->PostAuthor->find('first', array('conditions' => array('email' => $mail->fromAddress), 'contain' => array('PostAuthor')));
					//pr($mail);
					$mailbox->deleteMail($msg->uid);
					if(!empty($topic) AND !empty($user)){
						$subscribed = \GCore\Admin\Extensions\Chronoforums\Models\Subscribed::getInstance()->find('first', array('conditions' => array(
							'topic_id' => $topic['Topic']['id'],
							'user_id' => $user['PostAuthor']['id'],
							'sub_type' => 'topic',
						)));
						if(!empty($subscribed)){
							//user is subscribed to this topic, make the new post
							$text = $mail->textPlain;
							$text = preg_replace('#(^\w.+:\n)?(^>.*(\n|$))+#mi', '', $text);
							//find last line
							$text_lines = explode("\n", $text);
							//pr($text_lines);
							pop_more:
							$last_line = array_pop($text_lines);
							$last_line = trim($last_line);
							if(empty($last_line)){
								goto pop_more;
							}else{
								if(strpos($last_line, $this->fparams->get('email_reply_email')) === false){
									array_push($text_lines, $last_line);
								}
							}
							//pr($text_lines);
							$text = implode("\n", $text_lines);
							
							if(!empty($topic['Topic']['locked'])){
								//topic is locked
								continue;
							}
							/*
							if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'make_posts', null, $user['PostAuthor']['id']) !== true){
								continue;
							}
							if((bool)$this->fparams->get('forum_permissions', 0) === true AND !\GCore\Libs\Authorize::check_rules($topic['Forum']['rules']['make_posts'], array(), null, $user['PostAuthor']['id'])){
								continue;
							}
							*/
							$this->data['Post']['subject'] = 'Re: '.$topic['Topic']['title'];
							$this->data['Post']['text'] = $text;
							
							if(!empty($this->data['Post'])){
								//save reply
								$tid = $topic['Topic']['id'];
								$this->data['Post']['topic_id'] = $tid;
								$this->data['Post']['forum_id'] = $topic['Topic']['forum_id'];
								
								$this->data['Post']['user_id'] = $user['PostAuthor']['id'];
								$this->data['Post']['author_name'] = $user['PostAuthor']['username'];
								$this->data['Post']['published'] = 1;
								$this->data['Post']['params']['author_address'] = '0.0.0.0';
								
								$this->data['Topic']['title'] = $topic['Topic']['title'];
								//check topic uid
								$this->data['Topic']['params']['uid'] = $topic['Topic']['params']['uid'];
								
								$result = $this->Post->save($this->data, array('validate' => true));
								
								$this->data['Topic']['title_link'] = \GCore\Helpers\Html::url($this->data['Topic']['title'], r_(\GCore\Libs\Url::root(true).'index.php?option=com_chronoforums&cont=posts&p='.$this->Post->id.'&t='.$tid.'#p'.$this->Post->id));
								
								if($result !== false){
									//save subscription
									if(!empty($this->data['subscribe'])){
										\GCore\Admin\Extensions\Chronoforums\Models\Subscribed::getInstance()->deleteAll(array(
											'topic_id' => $tid,
											'user_id' => $user['PostAuthor']['id'],
											'sub_type' => 'topic',
										));
										\GCore\Admin\Extensions\Chronoforums\Models\Subscribed::getInstance()->save(array(
											'topic_id' => $tid,
											'user_id' => $user['PostAuthor']['id'],
											'sub_type' => 'topic',
											'notify_status' => 0,
										));
									}
									if((bool)$this->fparams->get('send_email_on_reply', 1) === true){
										$users_ids = \GCore\Admin\Extensions\Chronoforums\Models\Subscribed::getInstance()->find('list', array('conditions' => array(
											'topic_id' => $tid, 
											'user_id <>' => $user['PostAuthor']['id'],
											'sub_type' => 'topic',
											'notify_status' => 0,
										), 'fields' => array('user_id', 'topic_id')));
										if(!empty($users_ids)){
											$tos = $this->Post->PostAuthor->find('list', array('conditions' => array('id' => array_keys($users_ids)), 'fields' => array('email', 'username'), 'contain' => array('PostAuthor')));
											foreach($tos as $email => $username){
												$this->_sendEmail('new_reply', array($email => $username));
											}
										}
									}
								}else{							
									continue;
								}
							}
						}
					}
				}
			}
			//delete topic
			$mailbox->deleteMail($msg->uid);
		}
		$mailbox->expungeDeletedMails();
		//pr($mailbox->getMail(40));
	}
	
	function auto_reply(){
		sleep(3);
		if($this->fparams->get('enable_auto_reply', 0) AND $this->fparams->get('auto_reply_user_id', 0)){
			$this->data['quick_reply_submit'] = true;
			if($this->fparams->get('auto_reply_content', '')){
				ob_start();
				eval('?>'.$this->fparams->get('auto_reply_content', ''));
				$content = ob_get_clean();
				if($content){
					$this->data['Post']['text'] = $content;
					$user = \GCore\Admin\Models\User::getInstance()->find('first', array('conditions' => array('id' => $this->fparams->get('auto_reply_user_id', 0))));
					if(!empty($user)){
						$user = $user['User'];
						$this->reply(false, $user);
					}
				}
			}
		}
	}
	
	function bbcode_preview(){
		
	}
	
	function topic_preview(){
		$this->data['posts_loader'] = 1;
		$this->data['topic_preview'] = 1;
		$this->uprofile->set('Profile.params.preferences.posts_ordering', 'Post.created DESC');
		//$this->uprofile->set('Profile.params.preferences.posts_ordering', $this->fparams->get('posts_ordering', 'Post.created ASC'));
		$this->index();
		if($this->view != false){
			$this->view = 'index';
		}
	}
}
?>
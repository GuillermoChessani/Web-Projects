<?php
/**
* COMPONENT FILE HEADER
**/
namespace GCore\Extensions\Chronoforums\Controllers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Topics extends \GCore\Extensions\Chronoforums\Chronoforums {
	//var $models = array('\GCore\Admin\Extensions\Chronoforums\Models\Topic', '\GCore\Admin\Extensions\Chronoforums\Models\Post');
	//var $libs = array('\GCore\Libs\Request');
	var $helpers= array(
		'\GCore\Helpers\Assets', 
		'\GCore\Helpers\Html', 
		'\GCore\Helpers\Paginator',
		'\GCore\Extensions\Chronoforums\Helpers\UserTasks',
		'\GCore\Extensions\Chronoforums\Helpers\Output',
		'\GCore\Extensions\Chronoforums\Helpers\Bbeditor',
		'\GCore\Extensions\Chronoforums\Helpers\Elements',
		'\GCore\Extensions\Chronoforums\Helpers\PostEdit',
		//'\GCore\Helpers\Sorter'
	);
	
	function index(){
		$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.\GCore\Libs\Request::data('f', 0)));
	}
	
	function add($quote = false){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic', 'Forum')));
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post', 'Topic', 'Forum', 'PostAuthor', 'GroupUser', 'Attachment', 'Report', 'ReportAuthor')));
		$this->Forum = \GCore\Admin\Extensions\Chronoforums\Models\Forum::getInstance(array('allowed_models' => array('Forum', 'Category')));
		
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		$fid = \GCore\Libs\Request::data('f', 0);
		
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'make_topics') !== true){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.$fid));
		}
		
		if(!empty($fid)){
			$forum = $this->Forum->find('first', array('conditions' => array('id' => $fid), 'contain' => array('Forum')));
			if(!empty($forum)){
				if((bool)$this->fparams->get('forum_permissions', 0) === true AND !\GCore\Libs\Authorize::check_rules($forum['Forum']['rules']['make_topics'])){
					$session->setFlash('error', l_('CHRONOFORUMS_FORUM_ACTION_DENIED'));
					$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.$forum['Forum']['id']));
				}
				if(!empty($this->data['Post'])){
					if(!empty($this->data['upload'])){
						$this->_upload_file();
					}else if(!empty($this->data['delete_file'])){
						$this->_delete_file();
					}else if(!empty($this->data['cancel_post'])){
						$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.$forum['Forum']['id']));
					}else if(!empty($this->data['preview'])){
						$this->_preview();
					}else{
						if(empty($this->data['Post']['subject']) OR empty($this->data['Post']['text'])){
							$session->setFlash('error', l_('CHRONOFORUMS_SAVE_ERROR'));
							if(empty($this->data['Post']['subject']))$session->setFlash('error', l_('FORUMS_TOPIC_TITLE_REQUIRED'));
							if(empty($this->data['Post']['text']))$session->setFlash('error', l_('FORUMS_POST_TEXT_REQUIRED'));
							goto add_view;
						}
						//check spoofing
						if((int)$this->fparams->get('spoofing_limit', 30) > 0){
							$current_spoofing = $session->get('cfu_last_post', 0);
							if(!empty($current_spoofing) AND (int)$this->fparams->get('spoofing_limit', 30) + $current_spoofing > time()){
								$session->setFlash('error', l_('CHRONOFORUMS_SPOOFING_ERROR'));
								$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.$forum['Forum']['id']));
							}else{
								$session->set('cfu_last_post', time());
							}
						}
						//save topic
						$this->data['Topic']['title'] = $this->data['Post']['subject'];
						if((bool)$this->fparams->get('new_topics_published', 1) === true OR \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics')){
							$this->data['Topic']['published'] = 1;
						}else{
							$this->data['Topic']['published'] = 0;
							if((int)$this->fparams->get('auto_approval_threshold', 0)){
								$approved_posts = $this->Post->find('count', array('contain' => array('Post', 'Topic'), 'conditions' => array('Post.user_id' => $user['id'], 'Post.published' => 1, 'Topic.published' => 1)));
								if($approved_posts >= (int)$this->fparams->get('auto_approval_threshold', 0)){
									$this->data['Topic']['published'] = 1;
								}
							}
							if((int)$this->fparams->get('non_approved_threshold', 0)){
								$non_approved_posts = $this->Post->find('count', array('contain' => array('Post', 'Topic'), 'conditions' => array('Post.user_id' => $user['id'], 'OR' => array('Post.published' => 0, 'Topic.published' => 0))));
								if($non_approved_posts >= (int)$this->fparams->get('non_approved_threshold', 0)){
									$session->setFlash('error', l_('CHRONOFORUMS_NON_APPROVED_LIMIT_REACHED'));
									$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.$forum['Forum']['id']));
								}
							}
						}
						$this->data['Topic']['forum_id'] = $forum['Forum']['id'];
						
						$this->data['Topic']['user_id'] = $user['id'];
						$this->data['Topic']['alias'] = '';
						$this->data['Topic']['params']['uid'] = \GCore\Libs\Str::uuid();
						
						if($this->fparams->get('enable_extra_topic_info', 0)){
							if(!empty($this->data['topic_info'])){
								$this->data['Topic']['params']['fields'] = $this->data['topic_info'];
							}
						}
						
						$result = $this->Topic->save($this->data['Topic'], array('validate' => true));
						//save subscription
						if(!empty($this->data['subscribe'])){
							\GCore\Admin\Extensions\Chronoforums\Models\Subscribed::getInstance()->save(array(
								'topic_id' => $this->Topic->id,
								'user_id' => $user['id'],
								'sub_type' => 'topic',
								'notify_status' => 0,
							));
						}
						//save reply
						$this->data['Post']['topic_id'] = $this->Topic->id;
						$this->data['Post']['forum_id'] = $forum['Forum']['id'];
						
						$this->data['Post']['user_id'] = $user['id'];
						$this->data['Post']['published'] = 1;
						$this->data['Post']['params']['author_address'] = $_SERVER['REMOTE_ADDR'];
						
						if(!empty($this->data['Attachment'])){
							foreach($this->data['Attachment'] as $k => $attachment){
								$this->data['Attachment'][$k]['topic_id'] = $this->Topic->id;
								$this->data['Attachment'][$k]['user_id'] = $user['id'];
							}
							$this->Topic->saveField('has_attachments', 1);
						}
						
						$result = $this->Post->save($this->data, array('validate' => true));
						if($result !== false){
							//update user posts
							if(!empty($user['id'])){
								$this->_update_user_posts(true);
							}
							//update owner reputation
							if($this->fparams->get('enable_reputation', 0) AND !empty($user['id']) AND (int)$this->fparams->get('topic_reputation_weight', 0)){
								$this->_update_user_reputation($user['id'], (int)$this->fparams->get('topic_reputation_weight', 0));
							}
							//tag topic
							if((bool)$this->fparams->get('auto_tag_topics', 0) === true){
								$this->Post->tag_topic($this->data);
							}
							//send email
							$this->data['Topic']['title_link'] = \GCore\Helpers\Html::url($this->data['Topic']['title'], r_('index.php?option=com_chronoforums&cont=posts&p='.$this->Post->id.'&t='.$this->data['Post']['topic_id'].'#p'.$this->Post->id, false, true));
							
							if(((int)$this->fparams->get('send_email_on_topic', 0) === 1 OR ((int)$this->fparams->get('send_email_on_topic', 0) === 2 AND empty($this->data['Topic']['published']))) AND $this->fparams->get('topics_notify_groups', array())){
								$emails_list = $this->Post->PostAuthor->find('list', array('fields' => array('email', 'name', 'id'), 'conditions' => array('GroupUser.group_id' => $this->fparams->get('topics_notify_groups', array()))));
								$mods = !empty($emails_list) ? array_keys($emails_list) : array();
								foreach($mods as $mod){
									$this->_sendEmail('new_topic', array($mod => $mod));
								}
							}
							
							//check auto reply
							if($this->fparams->get('enable_auto_reply', 0)){
								$url = r_('index.php?option=com_chronoforums&cont=posts&act=auto_reply&t='.$this->Topic->id, false, true);
								\GCore\Libs\Env::send_async($url, array('auto_reply_sec_token' => $this->fparams->get('auto_reply_sec_token', ''), 'title' => $this->data['Post']['subject'], 'text' => $this->data['Post']['text'], 'username' => $user['username']));
							}
							
							if(!empty($this->data['Topic']['published'])){
								$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&p='.$this->Post->id.'&t='.$this->Topic->id.'#p'.$this->Post->id));
							}else{
								$session->setFlash('success', l_('CHRONOFORUMS_TOPIC_POSTED_NOT_PUBLISHED'));
								$this->redirect(r_('index.php?option=com_chronoforums'));
							}
						}else{							
							$session->setFlash('error', l_('CHRONOFORUMS_SAVE_ERROR'));
						}
					}
				}else{
					//new topic
					
				}
			}
		}else{
			
		}
		add_view:
		//check if this is a discussion board
		if($this->fparams->get('board_display', 'default') == 'discussions'){
			$forums_list = array();
			$cats = $this->Forum->find('all', array('cache' => true, 'fields' => array('Category.id', 'Category.title', 'Category.published', 'Forum.id', 'Forum.title', 'Forum.published'), 'contain' => array('Category', 'Forum')));
			foreach($cats as $cat){
				if(!empty($cat['Category']['published']) AND !empty($cat['Forum']['published'])){
					$forums_list[$cat['Category']['title']][$cat['Forum']['id']] = $cat['Forum']['title'];
				}
			}
			$this->set('forums_list', array('' => '') + $forums_list);
		}
		if(!empty($this->data['Post']) AND empty($fid)){
			$session->setFlash('error', l_('CHRONOFORUMS_SAVE_ERROR'));
			$session->setFlash('error', l_('FORUMS_FORUM_REQUIRED'));
			return;
		}
	}
	
	function lock(){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic')));
		
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') !== true){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
		$tid = \GCore\Libs\Request::data('t', 0);
		if(!empty($tid)){			
			$this->Topic->id = $tid;
			$result = $this->Topic->saveField('locked', 1);
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_TOPIC_LOCK_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_TOPIC_LOCK_ERROR'));
			}
		}
		$tids = \GCore\Libs\Request::data('topics_ids', array());
		if(!empty($tids)){
			$tids = array_keys($tids);
			foreach($tids as $tid){
				$this->Topic->id = $tid;
				$result = $this->Topic->saveField('locked', 1);
			}
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_TOPIC_LOCK_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.\GCore\Libs\Request::data('f', 0)));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_TOPIC_LOCK_ERROR'));
			}
		}
	}
	
	function unlock(){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic')));
		
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') !== true){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
		$tid = \GCore\Libs\Request::data('t', 0);
		if(!empty($tid)){
			$this->Topic->id = $tid;
			$result = $this->Topic->saveField('locked', 0);
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_TOPIC_UNLOCK_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_TOPIC_UNLOCK_ERROR'));
			}
		}
		$tids = \GCore\Libs\Request::data('topics_ids', array());
		if(!empty($tids)){
			$tids = array_keys($tids);
			foreach($tids as $tid){
				$this->Topic->id = $tid;
				$result = $this->Topic->saveField('locked', 0);
			}
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_TOPIC_UNLOCK_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.\GCore\Libs\Request::data('f', 0)));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_TOPIC_UNLOCK_ERROR'));
			}
		}
	}
	
	function sticky($up = 1){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic')));
		
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') !== true){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
		$tid = \GCore\Libs\Request::data('t', 0);
		if(!empty($tid)){
			$this->Topic->id = $tid;
			$result = $this->Topic->saveField('sticky', $up);
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_UPDATE_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_UPDATE_ERROR'));
			}
		}
		$tids = \GCore\Libs\Request::data('topics_ids', array());
		if(!empty($tids)){
			$tids = array_keys($tids);
			foreach($tids as $tid){
				$this->Topic->id = $tid;
				$result = $this->Topic->saveField('sticky', $up);
			}
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_UPDATE_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.\GCore\Libs\Request::data('f', 0)));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_UPDATE_ERROR'));
			}
		}
	}
	
	function unsticky(){
		$this->sticky(0);
	}
	
	function announce($up = 1){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic')));
		
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') !== true){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
		$tid = \GCore\Libs\Request::data('t', 0);
		if(!empty($tid)){
			$this->Topic->id = $tid;
			$result = $this->Topic->saveField('announce', $up);
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_UPDATE_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_UPDATE_ERROR'));
			}
		}
		$tids = \GCore\Libs\Request::data('topics_ids', array());
		if(!empty($tids)){
			$tids = array_keys($tids);
			foreach($tids as $tid){
				$this->Topic->id = $tid;
				$result = $this->Topic->saveField('announce', $up);
			}
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_UPDATE_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.\GCore\Libs\Request::data('f', 0)));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_UPDATE_ERROR'));
			}
		}
	}
	
	function unannounce(){
		$this->announce(0);
	}
	
	function publish($up = 1){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic')));
		
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') !== true){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
		$tid = \GCore\Libs\Request::data('t', 0);
		if(!empty($tid)){
			$this->Topic->id = $tid;
			$result = $this->Topic->saveField('published', $up);
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_UPDATE_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_UPDATE_ERROR'));
			}
		}
		$tids = \GCore\Libs\Request::data('topics_ids', array());
		if(!empty($tids)){
			$tids = array_keys($tids);
			foreach($tids as $tid){
				$this->Topic->id = $tid;
				$result = $this->Topic->saveField('published', $up);
			}
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_UPDATE_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.\GCore\Libs\Request::data('f', 0)));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_UPDATE_ERROR'));
			}
		}
	}
	
	function unpublish(){
		$this->publish(0);
	}
	
	function move(){
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') !== true){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic')));
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post')));
		$this->Forum = \GCore\Admin\Extensions\Chronoforums\Models\Forum::getInstance(array('allowed_models' => array('Forum', 'Category')));
		$this->TopicTrack = \GCore\Admin\Extensions\Chronoforums\Models\TopicTrack::getInstance();
		
		
		$tid = \GCore\Libs\Request::data('t', 0);
		$fid = \GCore\Libs\Request::data('f', 0);
		$result = false;
		$tids = \GCore\Libs\Request::data('topics_ids', array());
		$tids = array_keys($tids);
		
		if(empty($tid) AND empty($tids)){
			$session->setFlash('error', l_('CHRONOFORUMS_ERROR_OCCURRED'));
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
		
		if(!empty($this->data['cancel_move_topic'])){
			if(!empty($tid)){
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
			}elseif(count($tids)){
				$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.$fid));
			}
		}elseif(!empty($this->data['confirm_move_topic']) AND !empty($fid)){
			if(empty($fid)){
				$session->setFlash('error', l_('CHRONOFORUMS_ERROR_OCCURRED'));
				$this->redirect(r_('index.php?option=com_chronoforums'));
			}
			
			if(empty($tids)){
				$tids = array($tid);	
			}
			$result = $this->Topic->updateAll(array('forum_id' => $fid), array('id' => $tids));
			$result = $this->Post->updateAll(array('forum_id' => $fid), array('topic_id' => $tids));
			$result = $this->TopicTrack->updateAll(array('forum_id' => $fid), array('topic_id' => $tids));
			
			if($result){
				$session->setFlash('success', l_('CHRONOFORUMS_UPDATE_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.$fid));
			}else{
				$session->setFlash('error', l_('CHRONOFORUMS_ERROR_OCCURRED'));
				$this->redirect(r_('index.php?option=com_chronoforums'));
			}
		}else{
			$this->set('fid', $fid);
			$this->set('tid', $tid);
			$this->set('tids', $tids);
			
			$forums_list = array();
			$cats = $this->Forum->find('all', array('cache' => true, 'fields' => array('Category.id', 'Category.title', 'Category.published', 'Forum.id', 'Forum.title', 'Forum.published'), 'contain' => array('Category', 'Forum')));
			foreach($cats as $cat){
				if(!empty($cat['Category']['published']) AND !empty($cat['Forum']['published'])){
					$forums_list[$cat['Category']['title']][$cat['Forum']['id']] = $cat['Forum']['title'];
				}
			}
			$this->set('forums_list', array('' => '') + $forums_list);
		}
	}
	
	function delete(){
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic')));
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post', 'Attachment', 'Report')));
		$this->Forum = \GCore\Admin\Extensions\Chronoforums\Models\Forum::getInstance(array('allowed_models' => array('Forum', 'LastForumPost')));
		
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') !== true){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
		$tid = \GCore\Libs\Request::data('t', 0);
		$fid = \GCore\Libs\Request::data('f', 0);
		@ini_set('memory_limit', -1);
		if(!empty($tid)){
			$result = $this->Topic->delete($tid, array('callbacks' => false));
			$result = $this->Post->deleteAll(array('Post.topic_id' => $tid), array('callbacks' => false));
			if($result !== false){
				//fix forum's last post
				$forum = $this->Forum->find('first', array('conditions' => array('id' => $fid), 'contain' => array('LastForumPost')));
				if(empty($forum['LastForumPost']['id'])){
					$last_post = $this->Post->find('first', array('conditions' => array('forum_id' => $fid), 'fields' => array('id'), 'order' => 'Post.created DESC', 'recursive' => -1));
					if(!empty($last_post)){
						$this->Forum->id = $fid;
						$this->Forum->saveField('last_post', $last_post['Post']['id']);
					}
				}
				$session->setFlash('success', l_('CHRONOFORUMS_DELETE_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.$fid));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_DELETE_ERROR'));
			}
		}
		$tids = \GCore\Libs\Request::data('topics_ids', array());
		if(!empty($tids)){
			$tids = array_keys($tids);
			//drop all topics
			$result = $this->Topic->delete($tids, array('callbacks' => false));
			$result = $this->Post->deleteAll(array('Post.topic_id' => $tids), array('callbacks' => false));
			//fix forum's last post
			$forum = $this->Forum->find('first', array('conditions' => array('id' => $fid), 'contain' => array('LastForumPost')));
			if(empty($forum['LastForumPost']['id'])){
				$last_post = $this->Post->find('first', array('conditions' => array('forum_id' => $fid), 'fields' => array('id'), 'order' => 'Post.created DESC', 'recursive' => -1));
				if(!empty($last_post)){
					$this->Forum->id = $fid;
					$this->Forum->saveField('last_post', $last_post['Post']['id']);
				}
			}
			
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_DELETE_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.\GCore\Libs\Request::data('f', 0)));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_DELETE_ERROR'));
			}
		}
	}
	
	function delete_author(){
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') !== true OR (bool)$this->fparams->get('allow_author_delete', 1) !== true){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic')));
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post', 'Attachment', 'Report')));
		$this->Forum = \GCore\Admin\Extensions\Chronoforums\Models\Forum::getInstance(array('allowed_models' => array('Forum')));
		
		
		$tid = \GCore\Libs\Request::data('t', 0);
		$fid = \GCore\Libs\Request::data('f', 0);
		$uid = \GCore\Libs\Request::data('u', 0);
		$result = false;
		$tids = \GCore\Libs\Request::data('topics_ids', array());
		$tids = array_keys($tids);
		
		if(!empty($this->data['cancel_delete_author'])){
			if(!empty($tid)){
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
			}elseif(count($tids)){
				$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.$fid));
			}
		}elseif(!empty($this->data['confirm_delete_author'])){
			@ini_set('memory_limit', -1);
		}else{
			$this->set('fid', $fid);
			$this->set('tid', $tid);
			$this->set('uid', $uid);
			$this->set('tids', $tids);
			$users = array();
			
			if(empty($uid) AND !empty($tid)){
				$topic = $this->Topic->find('first', array('conditions' => array('id' => $tid), 'contain' => array('Topic')));
				$uid = $topic['Topic']['user_id'];
			}elseif(empty($uid) AND !empty($tids)){
				$topics = $this->Topic->find('all', array('conditions' => array('id' => $tids), 'contain' => array('Topic')));
				$uid = \GCore\Libs\Arr::getVal($topics, array('[n]', 'Topic', 'user_id'));
			}
			if(!empty($uid)){
				$this->User = \GCore\Admin\Models\User::getInstance(array('allowed_models' => array('User')));
				\GCore\Libs\Model::generateModel('PostCounter', array(
					'tablename' => $this->Post->tablename,
				));
				$this->User->bindModels('hasMany', array(
					'PostCounter' => array(
						'className' => '\GCore\Models\PostCounter',
						'foreignKey' => 'user_id',
						'fields' => array('COUNT(*)' => 'count', 'user_id'),
						'group' => 'user_id',
					),
				));
				\GCore\Libs\Model::generateModel('TopicCounter', array(
					'tablename' => $this->Topic->tablename,
				));
				$this->User->bindModels('hasMany', array(
					'TopicCounter' => array(
						'className' => '\GCore\Models\TopicCounter',
						'foreignKey' => 'user_id',
						'fields' => array('COUNT(*)' => 'count', 'user_id'),
						'group' => 'user_id',
					),
				));
				$this->User->bindModels('hasOne', array(
					'Profile' => array(
						'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Profile',
						'foreignKey' => 'user_id',
					),
				));
				$users = $this->User->find('all', array('conditions' => array('User.id' => $uid), 'contain' => array('User', 'Profile', 'PostCounter', 'TopicCounter')));
				$this->set('users', $users);
			}
			//pr($users);
			return;
		}
		
		if(!empty($uid)){
			$author_id = $uid;
			goto get_author_data;
		}
		
		if(empty($tid)){
			$tids = \GCore\Libs\Request::data('topics_ids', array());
			if(!empty($tids)){
				$tids = array_keys($tids);
				get_new_tid:
				$tid = array_shift($tids);
			}
		}
		if(!empty($tid)){
			$topic = $this->Topic->find('first', array('conditions' => array('id' => $tid), 'contain' => array('Topic'), 'fields' => array('Topic.id', 'Topic.user_id', 'Topic.has_attachments', 'Topic.reported')));
			if(empty($topic['Topic'])){
				goto end_delete_author;
			}
			
			$author_id = $topic['Topic']['user_id'];
			get_author_data:
			//delete the user itself
			$delete_user = true;
			if(count($this->fparams->get('super_users_groups', array()))){
				$user_record = \GCore\Admin\Models\User::getInstance()->find('first', array('conditions' => array('id' => $author_id), 'fields' => array('User.id')));
				$user_groups = \GCore\Libs\Arr::getVal($user_record, array('GroupUser', '[n]', 'group_id'));
				if(!empty($user_groups) AND array_intersect($user_groups, $this->fparams->get('super_users_groups', array()))){
					$delete_user = false;
					goto end_delete_author;
				}
			}
			
			//code check
			if($this->fparams->get('author_delete_code_check')){
				$should_delete = eval('?>'.$this->fparams->get('author_delete_code_check'));
				if($should_delete === false){
					$delete_user = false;
					goto end_delete_author;
				}
			}
			
			$affected_topics_forums = $this->Post->find('list', array('fields' => array('Post.topic_id', 'Post.forum_id'), 'conditions' => array('Post.user_id' => $author_id), 'recursive' => -1, 'group' => array('Post.topic_id')));
			if($this->fparams->get('author_delete_affected_topics_limit', 5) AND count($affected_topics_forums) >= $this->fparams->get('author_delete_affected_topics_limit', 5)){
				$delete_user = false;
				goto end_delete_author;
			}
			$affected_topics = array_keys($affected_topics_forums);
			$affected_forums = array_unique(array_values($affected_topics_forums));
			$author_topics = $this->Topic->find('list', array('conditions' => array('user_id' => $author_id), 'fields' => array('id'), 'recursive' => -1));
			$undeleted_topics = array_diff($affected_topics, $author_topics);
			//delete the author topics posts
			$result = $this->Post->deleteAll(array('Post.topic_id' => $author_topics), array('callbacks' => false));
			//delete the author's posts
			$result = $this->Post->deleteAll(array('Post.user_id' => $author_id), array('callbacks' => false));
			//delete the author's topics
			$result = $this->Topic->delete($author_topics, array('callbacks' => false));
			\GCore\Libs\Model::generateModel('TopicPostCounter', array(
				'tablename' => $this->Post->tablename,
			));
			$this->Topic->bindModels('hasMany', array(
				'TopicPostCounter' => array(
					'className' => '\GCore\Models\TopicPostCounter',
					'foreignKey' => 'topic_id',
					'fields' => array('COUNT(*)' => 'count', 'topic_id'),
					'group' => 'topic_id',
				),
			));
			$this->Topic->bindModels('hasOne', array(
				'Attachment' => array(
					'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Attachment',
					'foreignKey' => 'topic_id',
					'fields' => array('Attachment.id', 'Attachment.topic_id')
				),
				'Report' => array(
					'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Report',
					'foreignKey' => 'topic_id',
					'fields' => array('Report.id', 'Report.topic_id')
				),
			));
			$this->Topic->bindModels('belongsTo', array(
				'LastPost' => array(
					'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Post',
					'foreignKey' => 'last_post',
					'fields' => array('LastPost.id', 'LastPost.topic_id')
				),
			));
			$this->Topic->contain[] = 'TopicPostCounter';
			$this->Topic->contain[] = 'Attachment';
			$this->Topic->contain[] = 'Report';
			$this->Topic->contain[] = 'LastPost';
			//find and fix undeleted topics data
			$undeleted_topics_data = $this->Topic->find('all', array('conditions' => array('Topic.id' => $undeleted_topics), 'fields' => array('Topic.id', 'Topic.has_attachments', 'Topic.reported')));
			if(!empty($undeleted_topics_data)){
				foreach($undeleted_topics_data as $topic){
					$this->Topic->id = $topic['Topic']['id'];
					/*if(!empty($topic['Topic']['has_attachments']) AND empty($topic['Attachment'])){
						$this->Topic->saveField('has_attachments', 0);
					}
					if(!empty($topic['Topic']['reported']) AND empty($topic['Report'])){
						$this->Topic->saveField('reported', 0);
					}*/
					
					$this->Topic->updateAll(array('post_count' => $topic['TopicPostCounter'][0]['count'], 'has_attachments' => (int)!empty($topic['Attachment']), 'reported' => (int)!empty($topic['Report'])), array('id' => $topic['Topic']['id']));
					if(empty($topic['LastPost'])){
						$last_post = $this->Post->find('first', array('conditions' => array('topic_id' => $topic['Topic']['id']), 'fields' => array('id'), 'order' => 'Post.created DESC', 'recursive' => -1));
						if(!empty($last_post)){
							$this->Topic->saveField('last_post', $last_post['Post']['id']);
						}else{
							$this->Topic->saveField('last_post', 0);
						}
					}
				}
			}
			//fix affected forums counts
			\GCore\Libs\Model::generateModel('PostCounter', array(
				'tablename' => $this->Post->tablename,
			));
			$this->Forum->bindModels('hasMany', array(
				'PostCounter' => array(
					'className' => '\GCore\Models\PostCounter',
					'foreignKey' => 'forum_id',
					'fields' => array('COUNT(*)' => 'count', 'forum_id'),
					'group' => 'forum_id',
				),
			));
			\GCore\Libs\Model::generateModel('TopicCounter', array(
				'tablename' => $this->Topic->tablename,
			));
			$this->Forum->bindModels('hasMany', array(
				'TopicCounter' => array(
					'className' => '\GCore\Models\TopicCounter',
					'foreignKey' => 'forum_id',
					'fields' => array('COUNT(*)' => 'count', 'forum_id'),
					'group' => 'forum_id',
				),
			));
			$this->Forum->bindModels('belongsTo', array(
				'LastPost' => array(
					'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Post',
					'foreignKey' => 'last_post',
					'fields' => array('id', 'forum_id'),
				),
			));
			$affected_forums_data = $this->Forum->find('all', array('conditions' => array('id' => $affected_forums), 'fields' => array('Forum.id', 'Forum.last_post', 'LastPost.id')));
			//pr($affected_forums_data);
			foreach($affected_forums_data as $forum){
				$this->Forum->id = $forum['Forum']['id'];
				$this->Forum->updateAll(array('topic_count' => $forum['TopicCounter'][0]['count'], 'post_count' => $forum['PostCounter'][0]['count']), array('id' => $forum['Forum']['id']));
				if(empty($forum['LastPost']['id'])){
					$last_post = $this->Post->find('first', array('conditions' => array('forum_id' => $forum['Forum']['id']), 'fields' => array('id'), 'order' => 'Post.created DESC', 'recursive' => -1));
					if(!empty($last_post)){
						$this->Forum->saveField('last_post', $last_post['Post']['id']);
					}else{
						$this->Forum->saveField('last_post', 0);
					}
				}
			}
			
			//delete subscriptions for topics
			\GCore\Admin\Extensions\Chronoforums\Models\Subscribed::getInstance()->deleteAll(array('user_id' => $author_id));
			//delete profile
			\GCore\Admin\Extensions\Chronoforums\Models\Profile::getInstance()->deleteAll(array('user_id' => $author_id));
			
			if($delete_user){
				$result = \GCore\Admin\Models\User::getInstance()->delete($author_id);
			}
			
			end_delete_author:
			if(!empty($tids)){
				goto get_new_tid;
			}
			
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_DELETE_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.$fid));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_AUTHOR_DELETE_ERROR'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.$fid));
			}
		}
	}
	
	function favorite(){
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		$tid = \GCore\Libs\Request::data('t', 0);
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'make_posts') !== true){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
		}
		if(!empty($tid) AND !empty($user['id']) AND $this->fparams->get('enable_topics_favorites', 0)){
			$result = \GCore\Admin\Extensions\Chronoforums\Models\Favorite::getInstance()->save(array(
				'topic_id' => $tid,
				'user_id' => $user['id'],
			), array('new' => true));
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_FAVORITED_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_UPDATE_ERROR'));
			}
		}
	}
	
	function unfavorite(){
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		$tid = \GCore\Libs\Request::data('t', 0);
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'make_posts') !== true){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
		}
		if(!empty($tid) AND !empty($user['id']) AND $this->fparams->get('enable_topics_favorites', 0)){
			$result = \GCore\Admin\Extensions\Chronoforums\Models\Favorite::getInstance()->deleteAll(array(
				'topic_id' => $tid,
				'user_id' => $user['id'],
			));
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_FAVORITED_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_UPDATE_ERROR'));
			}
		}
	}
	
	function feature(){
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		$tid = \GCore\Libs\Request::data('t', 0);
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'feature_topics') !== true){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
		}
		if(!empty($tid) AND !empty($user['id']) AND $this->fparams->get('enable_topics_featured', 0)){
			$result = \GCore\Admin\Extensions\Chronoforums\Models\Featured::getInstance()->save(array(
				'topic_id' => $tid,
				'user_id' => $user['id'],
			), array('new' => true));
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_FEATURED_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_UPDATE_ERROR'));
			}
		}
	}
	
	function unfeature(){
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		$tid = \GCore\Libs\Request::data('t', 0);
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'feature_topics') !== true){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
		}
		if(!empty($tid) AND !empty($user['id']) AND $this->fparams->get('enable_topics_featured', 0)){
			$result = \GCore\Admin\Extensions\Chronoforums\Models\Featured::getInstance()->deleteAll(array(
				'topic_id' => $tid,
			));
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_UNFEATURED_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_UPDATE_ERROR'));
			}
		}
	}
	
	function subscribe(){
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		$tid = \GCore\Libs\Request::data('t', 0);
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'make_posts') !== true){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
		}
		if(!empty($tid)){
			$result = \GCore\Admin\Extensions\Chronoforums\Models\Subscribed::getInstance()->save(array(
				'topic_id' => $tid,
				'user_id' => $user['id'],
				'sub_type' => 'topic',
				'notify_status' => 0,
			));
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_SUBSCRIBE_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_UPDATE_ERROR'));
			}
		}
	}
	
	function unsubscribe(){
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		$tid = \GCore\Libs\Request::data('t', 0);
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'make_posts') !== true){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
		}
		if(!empty($tid)){
			$result = \GCore\Admin\Extensions\Chronoforums\Models\Subscribed::getInstance()->deleteAll(array(
				'topic_id' => $tid,
				'user_id' => $user['id'],
				'sub_type' => 'topic',
			));
			if($result !== false){
				$session->setFlash('success', l_('CHRONOFORUMS_UNSUBSCRIBE_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
			}else{							
				$session->setFlash('error', l_('CHRONOFORUMS_UPDATE_ERROR'));
			}
		}
	}
	
	function tag_topic(){
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') !== true){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
		$tid = \GCore\Libs\Request::data('t', 0);
		if(!empty($tid)){
			$this->Tag = \GCore\Admin\Extensions\Chronoforums\Models\Tag::getInstance();
			if(!empty($this->data['topic_tags'])){// AND is_array($this->data['topic_tags'])){
				$this->Tag->Tagged->deleteAll(array('topic_id' => $tid));
				//pr($this->data['topic_tags']);die();
				$this->data['topic_tags'] = explode(',', $this->data['topic_tags']);
				foreach($this->data['topic_tags'] as $k => $tag_id){
					if(is_string($tag_id) AND !is_numeric($tag_id)){
						$this->Tag->save(array('title' => $tag_id, 'published' => 1), array('new' => true));
						$tag_id = $this->Tag->id;
					}
					$this->Tag->Tagged->save(array('tag_id' => $tag_id, 'topic_id' => $tid), array('new' => true));
				}
				$session->setFlash('success', l_('CHRONOFORUMS_UPDATE_SUCCESS'));
				$this->redirect(r_('index.php?option=com_chronoforums&cont=posts&t='.$tid));
			}
		}
		$session->setFlash('error', l_('CHRONOFORUMS_UPDATE_ERROR'));
	}
	
	function tags_lookup(){
		$json = array();
		if(!empty($this->data['tag_q'])){
			$add_new = true;
			$slug = \GCore\Libs\Str::slug($this->data['tag_q']);
			$this->Tag = \GCore\Admin\Extensions\Chronoforums\Models\Tag::getInstance();
			$tags = $this->Tag->find('list', array('conditions' => array('Tag.title LIKE' => $this->data['tag_q'].'%', 'Tag.published' => 1), 'fields' => array('id', 'title'), 'contain' => array('Tag')));
			if(!empty($tags)){
				foreach($tags as $id => $title){
					$json[] = array('id' => $id, 'text' => $title);
					if($title == $slug){
						$add_new = false;	
					}
				}
			}
			if($add_new){
				$json[] = array('id' => $slug, 'text' => $slug);
			}
		}
		echo json_encode($json);
	}
}
?>
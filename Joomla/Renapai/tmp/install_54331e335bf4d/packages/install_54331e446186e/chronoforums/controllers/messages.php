<?php
/**
* COMPONENT FILE HEADER
**/
namespace GCore\Extensions\Chronoforums\Controllers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Messages extends \GCore\Extensions\Chronoforums\Chronoforums {
	var $models = array('\GCore\Admin\Extensions\Chronoforums\Models\Message');
	var $helpers= array(
		'\GCore\Helpers\DataTable', 
		'\GCore\Helpers\Assets', 
		'\GCore\Helpers\Toolbar', 
		'\GCore\Helpers\Html', 
		'\GCore\Extensions\Chronoforums\Helpers\UserTasks',
		'\GCore\Extensions\Chronoforums\Helpers\Elements',
		'\GCore\Extensions\Chronoforums\Helpers\Output',
		'\GCore\Extensions\Chronoforums\Helpers\Bbeditor',
		'\GCore\Extensions\Chronoforums\Helpers\Bbcode',
	);
	
	function index(){
		$session = \GCore\Libs\Base::getSession();
		$box = $session->get('chronoforums_pm_box', 'inbox');
		$this->$box();
		$this->view = $box;
	}
	
	function outbox(){
		$user = \GCore\Libs\Base::getUser();
		$session = \GCore\Libs\Base::getSession();
		$session->set('chronoforums_pm_box', 'outbox');
		$this->_load();
		$this->Message->conditions = array('Message.sender_id' => $user['id']);
		$this->_sortable();
		$this->_paginate();
		
		$this->view = 'outbox';
		$messages_s = $this->Message->find('all');
		$this->set('messages_s', $messages_s);
	}
	
	function inbox(){
		$user = \GCore\Libs\Base::getUser();
		$session = \GCore\Libs\Base::getSession();
		$session->set('chronoforums_pm_box', 'inbox');
		$this->_load();
		$this->Message->conditions = array('MessageRecipient.recipient_id' => $user['id'], 'MessageRecipient.hidden' => 0);
		$this->_sortable();
		$this->_paginate();
		
		$this->view = 'inbox';
		$messages_r = $this->Message->find('all');
		$this->set('messages_r', $messages_r);
	}
	
	function delete(){
		$user = \GCore\Libs\Base::getUser();
		$session = \GCore\Libs\Base::getSession();
		
		$result = \GCore\Admin\Extensions\Chronoforums\Models\MessageRecipient::getInstance()->updateAll(array('hidden' => 1), array('MessageRecipient.message_id' => \GCore\Libs\Request::data('gcb', array()), 'MessageRecipient.recipient_id' => $user['id']));
		if($result === true){
			$session->setFlash('success', l_('DELETE_SUCCESS'));
		}elseif($result === false){
			$session->setFlash('error', (string)$result.l_('DELETE_ERROR'));
		}elseif(is_numeric($result)){
			$session->setFlash('success', (string)$result.' '.l_('ITEMS_DELETED'));
		}
		$this->redirect(r_('index.php?option=com_chronoforums&cont=messages'));
	}
	
	function _load(){
		$user = \GCore\Libs\Base::getUser();
		if(empty($user['id'])){
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
		
		$this->Message->order_by = 'Message.created DESC';
		$this->Message->bindModels('hasOne', array(
			'MessageRecipient' => array(
				'className' => '\GCore\Admin\Extensions\Chronoforums\Models\MessageRecipient',
				'foreignKey' => 'message_id',
			),
		));
		$this->Message->bindModels('belongsTo', array(
			'MessageUser' => array(
				'className' => '\GCore\Admin\Models\User',
				'foreignKey' => 'sender_id',
				'fields' => array('id', 'username'),
			),
		));
		$this->Message->MessageUser->bindModels('hasOne', array(
			'MessageUserProfile' => array(
				'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Profile',
				'foreignKey' => 'user_id',
			),
		));
		$this->Message->MessageRecipient->bindModels('belongsTo', array(
			'MessageRecipientUser' => array(
				'className' => '\GCore\Admin\Models\User',
				'foreignKey' => 'recipient_id',
				'fields' => array('id', 'username'),
			),
		));
		$this->Message->MessageRecipient->MessageRecipientUser->bindModels('hasOne', array(
			'MessageRecipientUserProfile' => array(
				'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Profile',
				'foreignKey' => 'user_id',
			),
		));
	}
	
	function username_lookup(){
		$json = array();
		if(!empty($this->data['username_q'])){
			if($this->fparams->get('enable_pm_groups_filter', 0) AND $this->fparams->get('pm_allowed_groups', array())){
				$user = \GCore\Admin\Models\User::getInstance();
				$user->bindModels('hasOne', array(
					'Group' => array(
						'className' => '\GCore\Admin\Models\GroupUser',
						'foreignKey' => 'user_id',
					),
				));
				$users = $user->find('list', array('conditions' => array('User.username LIKE' => $this->data['username_q'].'%', 'Group.group_id' => $this->fparams->get('pm_allowed_groups', array())), 'fields' => array('User.id', 'User.username'), 'contain' => array('Group', 'User')));
			}else{
				$users = \GCore\Admin\Models\User::getInstance()->find('list', array('conditions' => array('User.username LIKE' => $this->data['username_q'].'%'), 'fields' => array('id', 'username'), 'contain' => array('User')));
			}
			if(!empty($users)){
				foreach($users as $id => $username){
					$json[] = array('id' => $id, 'text' => $username);
				}
			}
		}
		echo json_encode($json);
	}
	
	function compose(){
		$user = \GCore\Libs\Base::getUser();
		$session = \GCore\Libs\Base::getSession();
		if(empty($user['id'])){
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
		
		if(!empty($this->data['u']) AND empty($this->data['submit'])){
			if($this->fparams->get('enable_pm_groups_filter', 0) AND $this->fparams->get('pm_allowed_groups', array())){
				$valid_group = \GCore\Admin\Models\GroupUser::getInstance()->find('first', array('conditions' => array('user_id' => $this->data['u'], 'group_id' => $this->fparams->get('pm_allowed_groups', array()))));
				if(empty($valid_group)){
					$this->data['u'] = null;
				}
			}
			
			$username = \GCore\Admin\Models\User::getInstance()->field('username', array('User.id' => $this->data['u']));
			$this->set('username', $username);
		}
		
		$reply_subject = '';
		if(!empty($this->data['subject'])){
			$reply_subject = urldecode($this->data['subject']);
		}
		
		if(!empty($this->data['Message'])){
			if(!empty($this->data['cancel_post'])){
				$this->redirect(r_('index.php?option=com_chronoforums&cont=messages'.(!empty($this->data['m']) ? '&act=read&m='.$this->data['m'] : '')));
			}else if(!empty($this->data['preview'])){
				$this->_preview();
			}else{
				//check spoofing
				if((int)$this->fparams->get('spoofing_limit', 30) > 0){
					$current_spoofing = $session->get('cfu_last_post', 0);
					if(!empty($current_spoofing) AND (int)$this->fparams->get('spoofing_limit', 30) + $current_spoofing > time()){
						$session->setFlash('error', l_('CHRONOFORUMS_SPOOFING_ERROR'));
						return;
						//$this->redirect(r_('index.php?option=com_chronoforums&cont=messages'));
					}else{
						$session->set('cfu_last_post', time());
					}
				}
				//check recipient id
				if(empty($this->data['u'])){
					$session->setFlash('error', l_('CHRONOFORUMS_MESSAGES_INVALID_RECIPIENT'));
					//$this->redirect(r_('index.php?option=com_chronoforums&cont=messages'));
				}else{
					//check the id is valid ?	
				}
				//save new message
				$this->data['Message']['sender_id'] = $user['id'];
				$this->data['Message']['params']['author_address'] = $_SERVER['REMOTE_ADDR'];
				
				$result = $this->Message->save($this->data, array('validate' => true));
				if($result !== false){
					//save recipients
					$did = !empty($this->data['d']) ? $this->data['d'] : mt_rand();
					\GCore\Admin\Extensions\Chronoforums\Models\MessageRecipient::getInstance()->save(array(
						'message_id' => $this->Message->id,
						'recipient_id' => $this->data['u'],
						'discussion_id' => $did,
					), array('new' => true));
					
					//send emails
					if((bool)$this->fparams->get('pm_email_notify', 1) === true){
						$this->data['Message']['link'] = \GCore\Helpers\Html::url($this->data['Message']['subject'], r_(\GCore\Libs\Url::root(true).'index.php?option=com_chronoforums&cont=messages&act=read&m='.$this->Message->id.'&d='.$did));
						$this->data['Message']['sender'] = $user['username'];
						
						$tos = \GCore\Admin\Models\User::getInstance()->find('list', array('conditions' => array('id' => $this->data['u']), 'fields' => array('email', 'username'), 'contain' => array('User')));
						foreach($tos as $email => $username){
							$this->_sendEmail('new_pm', array($email => $username));
						}
					}
					$session->setFlash('success', l_('CHRONOFORUMS_MESSAGES_SEND_SUCCESS'));
					$this->redirect(r_('index.php?option=com_chronoforums&cont=messages&act=read&m='.$this->Message->id.'&d='.$did));	
				}else{
					$session->setFlash('error', l_('CHRONOFORUMS_MESSAGES_SEND_FAILED'));
					//$this->redirect(r_('index.php?option=com_chronoforums&cont=messages'));
				}
			}
		}
		if(!empty($reply_subject)){
			$this->data['Message']['subject'] = $reply_subject;
		}
		//load discussion messages
		if(!empty($this->data['d'])){
			$this->_load();
			$d_messages = $this->Message->MessageRecipient->find('list', array('fields' => array('message_id'), 'contain' => array('MessageRecipient'), 'conditions' => array('MessageRecipient.discussion_id' => $this->data['d'])));
			if(!empty($d_messages)){
				$d_messages = $this->Message->find('all', array('contain' => array('Message', 'MessageUser', 'MessageUserProfile'), 'order' => array('Message.created DESC'), 'conditions' => array('Message.id' => $d_messages)));
				if(!empty($d_messages)){
					$this->set(array('d_messages' => $d_messages));
				}
			}
		}
	}
	
	function read(){
		$user = \GCore\Libs\Base::getUser();
		$session = \GCore\Libs\Base::getSession();
		if(empty($user['id'])){
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
		if(empty($this->data['m'])){
			$session->setFlash('error', l_('CHRONOFORUMS_MESSAGES_LOAD_FAILED'));
			$this->redirect(r_('index.php?option=com_chronoforums&cont=messages'));
		}
		
		//$this->Message->id = $this->data['m'];
		$this->_load();
		$message = $this->Message->find('first', array('conditions' => array('Message.id' => $this->data['m'])));
		if(empty($message)){
			$session->setFlash('error', l_('CHRONOFORUMS_MESSAGES_LOAD_FAILED'));
			$this->redirect(r_('index.php?option=com_chronoforums&cont=messages'));
		}
		$this->Message->MessageRecipient->updateAll(array('opened' => 1), array('message_id' => $this->data['m'], 'recipient_id' => $user['id']));
		$this->set(array('message' => $message));
		//load discussion messages
		if(!empty($this->data['d'])){
			$d_messages = $this->Message->MessageRecipient->find('list', array('fields' => array('message_id'), 'contain' => array('MessageRecipient'), 'conditions' => array('MessageRecipient.discussion_id' => $this->data['d'], 'MessageRecipient.message_id <>' => $this->data['m'])));
			if(!empty($d_messages)){
				$d_messages = $this->Message->find('all', array('contain' => array('Message', 'MessageUser', 'MessageUserProfile'), 'order' => array('Message.created DESC'), 'conditions' => array('Message.id' => $d_messages, 'Message.created <' => $message['Message']['created'])));
				if(!empty($d_messages)){
					$this->set(array('d_messages' => $d_messages));
				}
			}
		}
	}
}
?>
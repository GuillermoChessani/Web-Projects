<?php
/**
* COMPONENT FILE HEADER
**/
namespace GCore\Extensions\Chronoforums\Controllers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Profiles extends \GCore\Extensions\Chronoforums\Chronoforums {
	//var $models = array('\GCore\Admin\Extensions\Chronoforums\Models\Profile');
	//var $libs = array('\GCore\Libs\Request');
	var $helpers= array(
		'\GCore\Helpers\DataTable', 
		'\GCore\Helpers\Assets', 
		'\GCore\Helpers\Html', 
		'\GCore\Extensions\Chronoforums\Helpers\UserTasks',
		'\GCore\Extensions\Chronoforums\Helpers\Output',
		'\GCore\Extensions\Chronoforums\Helpers\Elements',
	);
	
	function mini(){
		$this->index();
	}
	
	function index(){
		$uid = \GCore\Libs\Request::data('u', 0);
		$logged = \GCore\Libs\Base::getUser();
		if(empty($uid) AND empty($logged['id'])){
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
		if(empty($uid)){
			$uid = $logged['id'];
		}
		
		//if there is a custom profile link then redirect to it
		if($this->fparams->get('username_link_path', '') AND $this->fparams->get('username_link_path', '') != 'index.php?option=com_chronoforums&cont=profiles&u={id}'){
			$this->redirect(r_(\GCore\Libs\Str::replacer($this->fparams->get('username_link_path', ''), array('id' => $uid))));
		}
		//build statistics
		$this->User = \GCore\Admin\Models\User::getInstance(array('allowed_models' => array('User')));
		/*
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
		*/
		$this->User->bindModels('hasOne', array(
			'Profile' => array(
				'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Profile',
				'foreignKey' => 'user_id',
			),
		));
		$user = $this->User->find('first', array('conditions' => array('User.id' => $uid), 'contain' => array('User', 'Profile', 'PostCounter', 'TopicCounter')));
		if(empty($user['User'])){
			\GCore\Libs\Env::e404();
			echo l_('CHRONOFORUMS_PAGE_DOESNT_EXIST');
			$this->view = false;
			return;
		}
		if(empty($user['Profile']['post_count']) OR empty($user['Profile']['topic_count'])){
			$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic')));
			$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post')));
			$user['Profile']['topic_count'] = $this->Topic->find('count', array('recursive' => -1, 'conditions' => array('user_id' => $uid)));
			$user['Profile']['post_count'] = $this->Post->find('count', array('recursive' => -1, 'conditions' => array('user_id' => $uid)));
			
			$save_params = array();
			if(empty($user['Profile']['user_id'])){
				$save_params['new'] = true;
				unset($user['Profile']['params']);
				unset($user['Profile']['ranks']);
			}
			$user['Profile']['user_id'] = $uid;
			\GCore\Admin\Extensions\Chronoforums\Models\Profile::getInstance()->save($user['Profile'], $save_params);
		}
		//pr($user);
		$this->set('user', $user);
		if($logged['id'] == $uid){
			$this->set('editable', true);
		}
	}
	
	function edit(){
		$session = \GCore\Libs\Base::getSession();
		$uid = \GCore\Libs\Request::data('u', 0);
		if(empty($uid)){
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
		//build statistics
		$this->User = \GCore\Admin\Models\User::getInstance(array('allowed_models' => array('User')));
		$this->User->bindModels('hasOne', array(
			'Profile' => array(
				'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Profile',
				'foreignKey' => 'user_id',
			),
		));
		$user = $this->User->find('first', array('conditions' => array('User.id' => $uid), 'contain' => array('User', 'Profile', 'PostCounter', 'TopicCounter')));
		//$this->set('user', $user);
		//$this->data = $user;
		
		$logged = \GCore\Libs\Base::getUser();
		if($logged['id'] != $uid){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums&cont=profiles&u='.$uid));
		}
		
		if(!empty($this->data['cancel_edit'])){
			$this->redirect(r_('index.php?option=com_chronoforums&cont=profiles&u='.$uid));
		}elseif(!empty($this->data['update_profile'])){
			//update the profile data
			$this->data['Profile']['params'] = array_merge($user['Profile']['params'], $this->data['Profile']['params']);
			if($this->fparams->get('allow_users_avatars', 1) AND !empty($_FILES['avatar']) AND \GCore\Libs\Upload::valid($_FILES['avatar']) AND \GCore\Libs\Upload::not_empty($_FILES['avatar'])){
				$file = $_FILES['avatar'];
				$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
				
				$avatars_path = \GCore\C::ext_path('chronoforums', 'front').'avatars'.DS;
				$target = $avatars_path.$uid.'.'.$ext;
				if(\GCore\Libs\Upload::check_type($file, array('jpg', 'png', 'gif'))){
					if($file['size']/1024 > $this->fparams->get('avatar_size', 100)){
						$session->setFlash('error', sprintf(l_('CHRONOFORUMS_AVATAR_SIZE_ERROR'), $this->fparams->get('avatar_size', 100)));
						//$this->redirect(r_('index.php?option=com_chronoforums&cont=profiles&act=edit&u='.$uid));
						goto normal_edit;
					}
					list($w, $h) = getimagesize($file['tmp_name']);
					if($w > $this->fparams->get('avatar_width', 100) OR $h > $this->fparams->get('avatar_height', 100)){
						$session->setFlash('error', sprintf(l_('CHRONOFORUMS_AVATAR_DIMENSIONS_ERROR'), $this->fparams->get('avatar_width', 100), $this->fparams->get('avatar_height', 100)));
						//$this->redirect(r_('index.php?option=com_chronoforums&cont=profiles&act=edit&u='.$uid));
						goto normal_edit;
					}
					$saved = \GCore\Libs\Upload::save($file['tmp_name'], $target);
				}
				if(empty($saved)){
					$session->setFlash('error', l_('CHRONOFORUMS_AVATAR_SAVE_ERROR'));
				}else{
					$this->data['Profile']['params']['avatar'] = $uid.'.'.$ext;
				}
			}
			$save_params = array();
			if(empty($user['Profile']['user_id'])){
				$save_params['new'] = true;
				$this->data['Profile']['params'] = '';
			}
			$this->data['Profile']['user_id'] = $uid;
			$saved = \GCore\Admin\Extensions\Chronoforums\Models\Profile::getInstance()->save($this->data['Profile'], $save_params);
			if(!$saved){
				$session->setFlash('error', l_('CHRONOFORUMS_PROFILE_UPDATE_ERROR'));
			}
			
			$this->redirect(r_('index.php?option=com_chronoforums&cont=profiles&u='.$uid));
		}else{
			normal_edit:
			//normal edit page
			$this->set('user', $user);
			$this->data = array_merge($user, $this->data);
		}
	}
	
	function avatar(){
		if(!empty($this->data['img'])){
			$avatars_path = \GCore\C::ext_path('chronoforums', 'front').'avatars'.DS;
			$target = $avatars_path.$this->data['img'];
			\GCore\Libs\Download::send($target, 'I', $this->data['img']);
		}else{
			\GCore\Libs\Env::e404();
		}
		$this->view = false;
	}
	
	function preferences(){
		$session = \GCore\Libs\Base::getSession();
		$uid = \GCore\Libs\Request::data('u', 0);
		if(empty($uid)){
			$this->redirect(r_('index.php?option=com_chronoforums'));
		}
		//build statistics
		$this->User = \GCore\Admin\Models\User::getInstance(array('allowed_models' => array('User')));
		$this->User->bindModels('hasOne', array(
			'Profile' => array(
				'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Profile',
				'foreignKey' => 'user_id',
			),
		));
		$user = $this->User->find('first', array('conditions' => array('User.id' => $uid), 'contain' => array('User', 'Profile', 'PostCounter', 'TopicCounter')));
		
		$logged = \GCore\Libs\Base::getUser();
		if($logged['id'] != $uid){
			$session->setFlash('error', l_('CHRONOFORUMS_PERMISSIONS_ERROR'));
			$this->redirect(r_('index.php?option=com_chronoforums&cont=profiles&u='.$uid));
		}
		
		if(!empty($this->data['cancel_edit'])){
			$this->redirect(r_('index.php?option=com_chronoforums&cont=profiles&u='.$uid));
		}elseif(!empty($this->data['update_profile'])){
			//update the profile data
			$this->data['Profile']['params'] = array_merge($user['Profile']['params'], $this->data['Profile']['params']);
			$save_params = array();
			if(empty($user['Profile']['user_id'])){
				$save_params['new'] = true;
				$this->data['Profile']['params'] = '';
			}
			$this->data['Profile']['user_id'] = $uid;
			$saved = \GCore\Admin\Extensions\Chronoforums\Models\Profile::getInstance()->save($this->data['Profile'], $save_params);
			if(!$saved){
				$session->setFlash('error', l_('CHRONOFORUMS_PROFILE_UPDATE_ERROR'));
			}
			
			$this->redirect(r_('index.php?option=com_chronoforums&cont=profiles&u='.$uid));
		}else{
			//normal edit page
			$this->set('user', $user);
			$this->data = array_merge($user, $this->data);
		}
	}
}
?>
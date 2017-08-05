<?php
/**
* COMPONENT FILE HEADER
**/
namespace GCore\Admin\Extensions\Chronoforums;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Chronoforums extends \GCore\Libs\GController {
	var $models = array('\GCore\Admin\Extensions\Chronoforums\Models\Forum', '\GCore\Admin\Models\Group', '\GCore\Admin\Models\Acl');
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
	
	function sync(){
		$session = \GCore\Libs\Base::getSession();
		if(!empty($this->data['sync_forum'])){
			if(empty($this->data['sync']['forum_id'])){
				$session->setFlash('error', l_('FORUM_ID_DOESNOT_EXIST'));
				$this->redirect(r_('index.php?ext=chronoforums'));
			}else{
				$topic_count = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance()->find('count', array('conditions' => array('forum_id' => $this->data['sync']['forum_id']), 'recursive' => -1));
				$post_count = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance()->find('count', array('conditions' => array('forum_id' => $this->data['sync']['forum_id']), 'recursive' => -1));
				$last_post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance()->find('first', array('conditions' => array('forum_id' => $this->data['sync']['forum_id']), 'order' => array('Post.created DESC'),'recursive' => -1));
				$result = \GCore\Admin\Extensions\Chronoforums\Models\Forum::getInstance()->updateAll(array('topic_count' => $topic_count, 'post_count' => $post_count, 'last_post' => $last_post['Post']['id']), array('id' => $this->data['sync']['forum_id']));
				if($result){
					$session->setFlash('success', l_('UPDATE_SUCCESS'));
				}else{
					$session->setFlash('error', l_('UPDATE_ERROR'));
				}
				$this->redirect(r_('index.php?ext=chronoforums'));
			}
		}else if(!empty($this->data['sync_forum_topics'])){
			if(empty($this->data['sync']['forum_id'])){
				$session->setFlash('error', l_('FORUM_ID_DOESNOT_EXIST'));
				$this->redirect(r_('index.php?ext=chronoforums'));
			}else{
				$topics = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance()->find('all', array('conditions' => array('forum_id' => $this->data['sync']['forum_id']), 'fields' => array('id'), 'recursive' => -1));
				$topics_ids = \GCore\Libs\Arr::getVal($topics, array('[n]', 'Topic', 'id'));
				
				foreach($topics_ids as $topic_id){
					$post_count = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance()->find('count', array('conditions' => array('topic_id' => $topic_id), 'recursive' => -1));
					$last_post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance()->find('first', array('conditions' => array('topic_id' => $topic_id), 'order' => array('Post.created DESC'),'recursive' => -1));
					$result = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance()->updateAll(array('post_count' => $post_count, 'last_post' => $last_post['Post']['id']), array('id' => $topic_id));
				}
				if($result){
					$session->setFlash('success', l_('UPDATE_SUCCESS'));
				}else{
					$session->setFlash('error', l_('UPDATE_ERROR'));
				}
				$this->redirect(r_('index.php?ext=chronoforums'));
			}
		}else if(!empty($this->data['sync_topic'])){
			if(empty($this->data['sync']['topic_id'])){
				$session->setFlash('error', l_('TOPIC_ID_DOESNOT_EXIST'));
				$this->redirect(r_('index.php?ext=chronoforums'));
			}else{
				$topic_id = $this->data['sync']['topic_id'];
				$post_count = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance()->find('count', array('conditions' => array('topic_id' => $topic_id), 'recursive' => -1));
				$last_post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance()->find('first', array('conditions' => array('topic_id' => $topic_id), 'order' => array('Post.created DESC'),'recursive' => -1));
				$result = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance()->updateAll(array('post_count' => $post_count, 'last_post' => $last_post['Post']['id']), array('id' => $topic_id));
				if($result){
					$session->setFlash('success', l_('UPDATE_SUCCESS'));
				}else{
					$session->setFlash('error', l_('UPDATE_ERROR'));
				}
				$this->redirect(r_('index.php?ext=chronoforums'));
			}
		}
	}
	
	function index(){
		$statics = array();
		$statics[l_('MEMBERS_COUNT')] = \GCore\Admin\Models\User::getInstance()->find('count', array('recursive' => -1));
		$statics[l_('TOPICS_COUNT')] = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance()->find('count', array('recursive' => -1));
		$statics[l_('POSTS_COUNT')] = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance()->find('count', array('recursive' => -1));
		$statics[l_('ATTACHMENTS_COUNT')] = \GCore\Admin\Extensions\Chronoforums\Models\Attachment::getInstance()->find('count', array('recursive' => -1));
		$this->set('statics', $statics);
		if($this->_validated() === false){
			$session = \GCore\Libs\Base::getSession();
			$domain = str_replace(array('http://', 'https://'), '', \GCore\Libs\Url::domain());
			$session->setFlash('error', "Your ChronoForums installation on <strong>".$domain."</strong> is NOT validated, all the features are enabled but validating the install would remove the credits link below the forums pages and would help us continue the development process.");
		}
		
		//apply updates
		//$sql = file_get_contents(\GCore\C::ext_path('GCORE_FRONT_PATH').'sql'.DS.'update.chronoforums.sql');
		//$this->Forum->dbo->exec($this->Forum->dbo->_prefixTable($sql));
	}
	
	function _validated(){
		parent::_settings('chronoforums');
		if(isset($this->data['Chronoforums']['validated']) AND (int)$this->data['Chronoforums']['validated'] == 1){
			return true;
		}
		return false;
	}
	
	function settings(){
		parent::_settings('editors');
		parent::_settings('chronoforums');
		$groups = $this->Group->find('list', array('fields' => array('id', 'title')));
		$this->set('groups', $groups);
	}
	
	function save_settings(){
		$result = parent::_save_settings('editors');
		$result = parent::_save_settings('chronoforums');
		$session = \GCore\Libs\Base::getSession();
		if($result){
			$session->setFlash('success', l_('SAVE_SUCCESS'));
		}else{
			$session->setFlash('error', l_('SAVE_ERROR'));
		}
		$this->redirect(r_('index.php?ext=chronoforums&act=settings'));
	}
	
	function permissions(){
		$perms = array(
			'make_topics' => 'Create New Topics',
			'read_topics' => 'Read/View Topics',
			'make_posts' => 'Post Replies',
			'modify_topics' => 'Modify/Moderate Topics',
			'list_attachments' => 'See posts attachments',
			'download_attachments' => 'Download and see inline attachments',
			'attach_files' => 'Attach Files',
			'edit_posts' => 'Edit Posts',
			'delete_posts' => 'Delete Posts',
			'report_posts' => 'Report Posts',
			'view_reports' => 'View Reports',
			'select_answers' => 'Select Answers',
			'feature_topics' => 'Feature Topics',
			'make_votes' => 'Vote',
			//'check_posts' => 'Check Posts',
		);
		$this->set('perms', $perms);
		
		$rules = $this->Group->find('list', array('fields' => array('id', 'title')));
		$rules['owner'] = 'Owner';
		$this->set('rules', $rules);
		$acl = $this->Acl->find('first', array('conditions' => array('aco' => '\GCore\Extensions\Chronoforums\Chronoforums')));
		if(!empty($acl)){
			$this->data = $acl;
		}
	}
	
	function save_permissions(){
		if(empty($this->data['Acl'])){
			$this->redirect(r_('index.php?ext=chronoforums&act=permissions'));
		}
		$this->data['Acl']['title'] = 'Chronoforums Front Permissions';
		$this->data['Acl']['aco'] = '\GCore\Extensions\Chronoforums\Chronoforums';
		$this->data['Acl']['enabled'] = 1;
		$result = $this->Acl->save($this->data);
		$session = \GCore\Libs\Base::getSession();
		if($result){
			$session->setFlash('success', l_('SAVE_SUCCESS'));
		}else{
			$session->setFlash('error', l_('SAVE_ERROR'));
		}
		$this->redirect(r_('index.php?ext=chronoforums&act=permissions'));
	}
	
	function delete_cache(){
		$path = \GCore\C::get('GCORE_FRONT_PATH').'cache'.DS;
		$files = \GCore\Libs\Folder::getFiles($path);
		$count = 0;
		foreach($files as $k => $file){
			if(basename($file) != 'index.html'){
				$result = \GCore\Libs\File::delete($file);
				if($result){
					$count++;
				}
			}
		}
		if(function_exists('apc_delete')){
			//apc_delete('db_tables_info');
			//$queries_cache = new \APCIterator('user', '/*\.queries/', APC_ITER_VALUE);
			//apc_delete($queries_cache);
			apc_clear_cache('user');
		}
		$session = \GCore\Libs\Base::getSession();
		$session->setFlash('info', $count.' '.l_('CACHE_FILES_DELETED'));
		$this->redirect(r_('index.php?ext=chronoforums'));
	}
	
	function validateinstall(){
		$domain = str_replace(array('http://', 'https://'), '', \GCore\Libs\Url::domain());
		$this->set('domain', $domain);
		if(!empty($this->data['license_key'])){
			$session = \GCore\Libs\Base::getSession();
			$fields = '';
			//$postfields = array();
			unset($this->data['option']);
			unset($this->data['act']);
			foreach($this->data as $key => $value){
				$fields .= "$key=".urlencode($value)."&";
			}
			
			$target_url = 'http://www.chronoengine.com/index.php?option=com_chronocontact&task=extra&chronoformname=validateLicense';
			if(ini_get('allow_url_open')){
				$output = file_get_contents($target_url.'&'.rtrim($fields, "& "));
			}else if(function_exists('curl_init')){
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $target_url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim($fields, "& "));
				$output = curl_exec($ch);
				curl_close($ch);
			}
			$validstatus = $output;
			
			if($validstatus == 'valid'){
				parent::_settings('chronoforums');
				$this->data['Chronoforums']['validated'] = 1;
				$result = parent::_save_settings('chronoforums');
				if($result){
					$session->setFlash('success', 'Validated successflly.');
					$this->redirect(r_('index.php?ext=chronoforums'));
				}else{
					$session->setFlash('error', 'Validation error.');
				}
			}else if($validstatus == 'invalid'){
				parent::_settings('chronoforums');
				$this->data['Chronoforums']['validated'] = 0;
				$result = parent::_save_settings('chronoforums');
				$session->setFlash('error', 'Validation error, you have provided incorrect data.');
				$this->redirect(r_('index.php?ext=chronoforums'));
			}else{
				if(!empty($this->data['instantcode'])){
					$step1 = base64_decode(trim($this->data['instantcode']));
					$step2 = str_replace(substr(md5(str_replace('www.', '', strtolower($matches[2]))), 0, 7), '', $step1);
					$step3 = str_replace(substr(md5(str_replace('www.', '', strtolower($matches[2]))), - strlen(md5(str_replace('www.', '', strtolower($matches[2])))) + 7), '', $step2);
					$step4 = str_replace(substr($this->data['license_key'], 0, 10), '', $step3);
					$step5 = str_replace(substr($this->data['license_key'], - strlen($this->data['license_key']) + 10), '', $step4);
					//echo (int)$step5;return;
					//if((((int)$step5 + (24 * 60 * 60)) > strtotime(date('d-m-Y H:i:s')))||(((int)$step5 - (24 * 60 * 60)) < strtotime(date('d-m-Y H:i:s')))){
					if(((int)$step5 < (strtotime("now") + (24 * 60 * 60))) AND ((int)$step5 > (strtotime("now") - (24 * 60 * 60)))){
						parent::_settings('chronoforums');
						$this->data['Chronoforums']['validated'] = 1;
						$result = parent::_save_settings('chronoforums');
						if($result){
							$session->setFlash('success', 'Validated successflly.');
							$this->redirect(r_('index.php?ext=chronoforums'));
						}else{
							$session->setFlash('error', 'Validation error.');
						}
					}else{
						$session->setFlash('error', 'Validation error, Invalid instant code provided.');
						$this->redirect(r_('index.php?ext=chronoforums'));
					}
				}else{
					if(!empty($this->data['serial_number'])){
						$blocks = explode("-", trim($this->data['serial_number']));
						$hash = md5($this->data['pid'].$this->data['license_key'].str_replace('www.', '', $domain).$blocks[3]);
						if(substr($hash, 0, 7) == $blocks[4]){
							parent::_settings('chronoforums');
							$this->data['Chronoforums']['validated'] = 1;
							$result = parent::_save_settings('chronoforums');
							if($result){
								$session->setFlash('success', 'Validated successfully.');
								$this->redirect(r_('index.php?ext=chronoforums'));
							}else{
								$session->setFlash('error', 'Validation error.');
							}
						}else{
							$session->setFlash('error', 'Serial number invalid!');
						}
					}
					$session->setFlash('error', 'Validation error, your server does NOT have the CURL function enabled, please ask your host admin to enable the CURL, or please try again using the Instant Code, or please contact us on www.chronoengine.com');
					$this->redirect(r_('index.php?ext=chronoforums'));
				}
			}
		}
	}
}
?>
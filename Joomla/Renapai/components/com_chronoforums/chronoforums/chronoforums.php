<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace GCore\Extensions\Chronoforums;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Chronoforums extends \GCore\Libs\GController {
	//var $models = array('\GCore\Admin\Extensions\Chronoforums\Models\Category');
	//var $libs = array('\GCore\Libs\Request');
	var $helpers= array(
		'\GCore\Helpers\Assets',
		'\GCore\Helpers\Html',
		'\GCore\Helpers\Paginator',
		'\GCore\Extensions\Chronoforums\Helpers\UserTasks',
		'\GCore\Extensions\Chronoforums\Helpers\Elements',
		'\GCore\Extensions\Chronoforums\Helpers\Output',
		//'\GCore\Helpers\Sorter'
	);

	function _initialize(){
		if(empty($this->data['Extension']['chronoforums']['settings'])){
			$settings = \GCore\Admin\Models\Extension::getInstance()->find('first', array('conditions' => array('name' => 'chronoforums'), 'fields' => array('settings')));
			$settings = !empty($settings['Extension']['settings']) ? $settings['Extension']['settings'] : array();
		}else{
			$settings = $this->data['Extension']['chronoforums']['settings'];
		}
		$this->fparams = new \GCore\Libs\Parameter($settings);
		$this->set('fparams', $this->fparams);
		//check if board offline
		if((bool)$this->fparams->get('offline', 0) === true){
			echo $this->fparams->get('offline_message', "Our board is currently offline, please check back again in the next few hours.");
			return false;
		}

		//check user session
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		//load profile settings
		$uprofile = array();
		if(!empty($user['id'])){
			$uprofile = \GCore\Admin\Extensions\Chronoforums\Models\Profile::getInstance()->find('first', array('conditions' => array('user_id' => $user['id'])));
		}
		$this->uprofile = new \GCore\Libs\Parameter($uprofile);
		$this->set('uprofile', $this->uprofile);
		//find ranks data if needed
		if((bool)$this->fparams->get('load_ranks', 0) === true){
			$ranks = \GCore\Admin\Extensions\Chronoforums\Models\Rank::getInstance()->find('all', array('cache' => true, 'conditions' => array('published' => 1), 'order' => array('Rank.group_id ASC', 'Rank.weight ASC')));
			$this->set('ranks', $ranks);
		}
		if(!empty($user['id']) AND $session->get('forums_visited', false) === false){
			//first login actions
			if((bool)$this->fparams->get('load_ranks', 0) === true){
				$this->_update_ranks($ranks);
			}
			$session->set('forums_visited', true);
		}
		//$session->set('forums_visited', true);
		//add the main css
		$document = \GCore\Libs\Document::getInstance();
		$document->_('jquery');
		$document->_('bootstrap');
		$document->addCssFile('extensions/chronoforums/assets/css/default.css');
		$document->addJsFile('extensions/chronoforums/assets/js/default.js');
		$document->addCssFile('extensions/chronoforums/styles/'.$this->fparams->get('theme', 'prosilver').'/theme/forums.css');

		$document->addJsCode('
		jQuery(document).ready(function(chronoQ){
			chronoQ(".gcoreTooltip").tooltip({"html": true,"container": "body"});
			chronoQ(".gcoreTooltip").on("hidden.bs.tooltip", function(){
				chronoQ(this).show();
			});
			chronoQ(".gcorePopover").popover({"html": true,"container": "body"});
			chronoQ(".gcorePopover").on("hidden.bs.popover", function(){
				chronoQ(this).show();
			});
			
			jQuery("#show_search_config").on("click", function(){
				if(jQuery("#cfu-search-config-content").css("display") == "none"){
					jQuery("#cfu-search-config-content").css("display", "block");
				}else{
					jQuery("#cfu-search-config-content").css("display", "none");
				}
			});
			jQuery(".reset").click(function() {
				jQuery(this).closest("form").find("input[type=text], textarea").val("");
			});
		});');
		if($this->fparams->get('usernames_mini_profile', 0)){
			$document->_('gtooltip');
			$document->addJsCode('jQuery(document).ready(function($){
				$(".cfu-username-box").gtooltip({"append":"body", "tipclass":"gtooltip cfu-profile-preview", "awaytime":400, "ontime":400, "ajaxloading":"<img src=\''.\GCore\Helpers\Assets::image('loading-small.gif').'\' />"});
				$(".cfu-username-box").gtooltip("hover");
			});');	
		}

		$this->helpers['\GCore\Extensions\Chronoforums\Helpers\Bbcode'] = array('emodir' => \GCore\C::get('GCORE_FRONT_URL').'extensions/chronoforums/styles/'.$this->fparams->get('theme', 'prosilver').'/imageset/smilies/');
		//check new email replies!
		if((bool)$this->fparams->get('enable_emails_posting') === true){
			$check_interval = (int)trim($this->fparams->get('emails_posting_period', 0));
			if(!empty($check_interval) AND (date('i') %$check_interval == 0) AND $this->action != 'email_reply'){
				//do it, we use App:: because we can't use AppJ inside the extension files, it would not be independent!
				$buffered = \GCore\Libs\App::call('front', 'chronoforums', 'posts', 'email_reply', array());
			}
		}
		//set default profile path
		if(strlen(trim($this->fparams->get('username_link_path', ''))) == 0){
			$this->fparams->set('username_link_path', 'index.php?option=com_chronoforums&cont=profiles&u={id}');
		}
		//check new pms
		if(!empty($user['id']) AND $this->fparams->get('enable_pm', 1)){
			$new_pms = \GCore\Admin\Extensions\Chronoforums\Models\MessageRecipient::getInstance()->find('count', array('conditions' => array('recipient_id' => $user['id'], 'opened' => 0)));
			$this->set('new_pms', $new_pms);
		}
		//check views dir
		//$this->views_dir = 'views_rt';
		if((bool)$this->fparams->get('forums_views_cache', 0) === true){
			$user = \GCore\Libs\Base::getUser();
			$user_print = array_merge($user['groups'], $user['inheritance']);
			sort($user_print);
			$cache_slices = array('chronoforums');
			$cache_slices[] = strtolower(\GCore\Libs\Base::getClassName($this->name));
			$cache_slices[] = strtolower($this->action);
			$cache_slices[] = 'c'.\GCore\Libs\Request::data('c');
			$cache_slices[] = 'f'.\GCore\Libs\Request::data('f');
			$cache_slices[] = 't'.\GCore\Libs\Request::data('t');
			$cache_slices[] = !(\GCore\Libs\Request::data('t')) ? 'p'.\GCore\Libs\Request::data('p') : '';
			$cache_slices[] = 'page'.\GCore\Libs\Request::data('page');
			//$cache_slices[] = 'u'.md5(json_encode($user_print));
			$cache_slices = array_unique($cache_slices);
			$this->cache = array('title' => implode('_', $cache_slices), 'time' => $this->fparams->get('forums_views_cache_time', 900), 'key' => md5(json_encode($user_print)));
		}
	}

	function _finalize(){
		if((bool)$this->fparams->get('forums_debug', 0) === true AND \GCore\Libs\Request::data('tvout') != 'ajax'){
			$debug = array();
			$debug['time'] = microtime(true) - \GCore\Loader::$start_time;
			$debug['memory_usage'] = memory_get_usage() - \GCore\Loader::$memory_usage;
			$debug['database_log'] = \GCore\Libs\Database::getInstance()->log;
			pr($debug);
		}
		if($this->_validated($this->fparams) === false AND \GCore\Libs\Request::data('tvout') != 'ajax'){
			echo '<p class="chrono_credits"><a href="http://www.chronoengine.com" target="_blank">Powered by ChronoForums - ChronoEngine.com</a></p>';
		}
	}

	function index(){
		//$this->Category = \GCore\Admin\Extensions\Chronoforums\Models\Category::getInstance(array('allowed_models' => array('Category', 'Forum', 'LastForumPost', 'PostAuthor')));
		$conditions = array('Category.published' => 1);
		if(\GCore\Libs\Request::data('c') != null){
			$conditions['Category.id'] = \GCore\Libs\Request::data('c');
		}
		
		if((bool)$this->fparams->get('load_forums_list', 1) === true OR isset($conditions['Category.id'])){
			$this->Category = \GCore\Admin\Extensions\Chronoforums\Models\Category::getInstance(array('allowed_models' => array('Category', 'Forum', 'LastForumPost', 'PostAuthor')));
			$this->Category->Forum->belongsTo['LastForumPost']['fields'] = array('LastForumPost.id', 'LastForumPost.user_id', 'LastForumPost.topic_id', 'LastForumPost.created');
			$this->Category->Forum->LastForumPost->belongsTo['PostAuthor']['fields'] = array('PostAuthor.id', 'PostAuthor.username', 'PostAuthor.name');
			$this->Category->Forum->LastForumPost->PostAuthor->bindModels('hasOne', array(
				'Profile' => array(
					'className' => '\GCore\Admin\Extensions\Chronoforums\Models\Profile',
					'foreignKey' => 'user_id',
				),
			));
			$this->Category->Forum->order_by = array('Forum.ordering');
			$contain = array('Category', 'Forum', 'LastForumPost', 'PostAuthor', 'Profile');
		}else{
			$this->Category = \GCore\Admin\Extensions\Chronoforums\Models\Category::getInstance(array('allowed_models' => array('Category')));
			$contain = array('Category');
		}
		$categories = $this->Category->find('all', array(
			'conditions' => $conditions,
			'order' => array('Category.ordering'),
			'contain' => $contain,
			'cache' => true,
		));
		if(empty($categories)){
			\GCore\Libs\Env::e404();
			echo l_('CHRONOFORUMS_PAGE_DOESNT_EXIST');
			$this->view = false;
			return;
		}else{
			//auto heal any broken counters
			/*foreach($categories as $kc => $category){
				if(!empty($category['Forum'])){
					foreach($category['Forum'] as $kf => $forum){
						if(!empty($forum['last_post']) AND empty($category['LastForumPost'][$kf]['id'])){
							$last_post = $this->Category->Forum->LastForumPost->find('first', array('conditions' => array('forum_id' => $forum['id']), 'fields' => array('id'), 'order' => 'LastForumPost.created DESC', 'recursive' => -1));
							$this->Category->Forum->id = $forum['id'];
							if(!empty($last_post)){
								$this->Category->Forum->saveField('last_post', $last_post['LastForumPost']['id']);
							}else{
								$this->Category->Forum->saveField('last_post', 0);
							}
						}
					}
				}
			}*/
		}
		$this->set('categories', $categories);
	}
	
	function _update_ranks($ranks = array()){
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		$this->Topic = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance(array('allowed_models' => array('Topic')));
		$this->Post = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance(array('allowed_models' => array('Post')));
		$topic_count = $this->Topic->find('count', array('recursive' => -1, 'conditions' => array('user_id' => $user['id'])));
		$post_count = $this->Post->find('count', array('recursive' => -1, 'conditions' => array('user_id' => $user['id'])));
		//fix user's ranks
		$new_ranks = array();
		if((bool)$this->fparams->get('load_ranks', 0) === true AND !empty($ranks)){
			foreach($ranks as $rank){
				if(!empty($rank['Rank']['published'])){
					if(!empty($rank['Rank']['params']['user_groups']) AND count(array_intersect($rank['Rank']['params']['user_groups'], $user['groups']))){
						if(!empty($rank['Rank']['group_id'])){
							$new_ranks[$rank['Rank']['group_id']] = $rank['Rank']['id'];
						}else{
							$new_ranks[] = $rank['Rank']['id'];
						}
					}
					if(!empty($rank['Rank']['params']['user_posts']) AND (int)$rank['Rank']['params']['user_posts'] <= $post_count){
						if(!empty($rank['Rank']['group_id'])){
							$new_ranks[$rank['Rank']['group_id']] = $rank['Rank']['id'];
						}else{
							$new_ranks[] = $rank['Rank']['id'];
						}
					}
					if(!empty($rank['Rank']['code'])){
						$code_result = eval('?>'.$rank['Rank']['code']);
						if($code_result === true){
							if(!empty($rank['Rank']['group_id'])){
								$new_ranks[$rank['Rank']['group_id']] = $rank['Rank']['id'];
							}else{
								$new_ranks[] = $rank['Rank']['id'];
							}
						}
					}
				}
			}
		}
		
		$reputation = $this->uprofile->get('Profile.reputation');
		//update user reputation
		if($this->fparams->get('enable_reputation', 0)){
			$voter = \GCore\Admin\Extensions\Chronoforums\Models\Vote::getInstance();
			\GCore\Libs\Model::generateModel('PostInfo', array(
				'tablename' => \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance()->tablename,
			));
			$voter->bindModels('belongsTo', array(
				'PostInfo' => array(
					'className' => '\GCore\Models\PostInfo',
					'join_conditions' => array('Vote.post_id = PostInfo.id'),
					//'group' => array('PostInfo.user_id'),
				),
			));
			$votes_sum = $voter->find('first', array('fields' => array('SUM(vote)' => 'votes_sum'), 'conditions' => array('Vote.post_id <>' => 0, 'PostInfo.user_id' => $user['id'])));
			//pr($votes_sum);
			$answer = \GCore\Admin\Extensions\Chronoforums\Models\Answer::getInstance();
			$answer->bindModels('belongsTo', array(
				'PostInfo' => array(
					'className' => '\GCore\Models\PostInfo',
					'join_conditions' => array('Answer.post_id = PostInfo.id'),
				),
			));
			$answers_count = $answer->find('first', array('fields' => array('COUNT(post_id)' => 'answers_count'), 'conditions' => array('PostInfo.user_id' => $user['id'], 'Answer.post_id <>' => 0)));
			//pr($answers_count);
			$reputation = ((int)$votes_sum['Vote']['votes_sum'] * (int)$this->fparams->get('vote_reputation_weight', 1)) + 
				((int)$answers_count['Answer']['answers_count'] * (int)$this->fparams->get('answer_reputation_weight', 10)) + 
				((int)$topic_count * (int)$this->fparams->get('topic_reputation_weight', 0)) + 
				((int)$post_count * (int)$this->fparams->get('post_reputation_weight', 0));
				
		}

		$new_ranks = array_values($new_ranks);
		$profile_exists = $this->uprofile->get('Profile.user_id');//\GCore\Admin\Extensions\Chronoforums\Models\Profile::getInstance()->field('user_id', array('user_id' => $user['id']));
		$save_params = array();
		if(!$profile_exists){
			$save_params['new'] = true;
			$user['Profile']['params'] = '';
		}
		\GCore\Admin\Extensions\Chronoforums\Models\Profile::getInstance()->save(array('user_id' => $user['id'], 'topic_count' => $topic_count, 'post_count' => $post_count, 'ranks' => $new_ranks, 'reputation' => $reputation), $save_params);
	}
	
	function _update_user_posts($update_topics = false, $auto_user = false){
		$user = $auto_user ? $auto_user : \GCore\Libs\Base::getUser();
		if($auto_user){
			$uprofile = \GCore\Admin\Extensions\Chronoforums\Models\Profile::getInstance()->find('first', array('conditions' => array('user_id' => $user['id'])));
			$this->uprofile = new \GCore\Libs\Parameter($uprofile);
		}
		if(empty($user['id'])){
			return;	
		}
		
		$profile_exists = $this->uprofile->get('Profile.user_id');
		$save_params = array();
		if(!$profile_exists){
			$save_params['new'] = true;
			$user['Profile']['params'] = '';
		}
		$topic_count = $this->uprofile->get('Profile.topic_count', 0);
		if($update_topics){
			$topic_count = $this->uprofile->get('Profile.topic_count', 0) + 1;
		}
		$post_count = $this->uprofile->get('Profile.post_count', 0) + 1;
		\GCore\Admin\Extensions\Chronoforums\Models\Profile::getInstance()->save(array('user_id' => $user['id'], 'topic_count' => $topic_count, 'post_count' => $post_count), $save_params);
	}
	
	function _update_user_reputation($user_id, $val){
		$profiler = \GCore\Admin\Extensions\Chronoforums\Models\Profile::getInstance();
		$profiler->id = $user_id;
		$val = $val >= 0 ? '+ '.$val : ''.$val;
		\GCore\Admin\Extensions\Chronoforums\Models\Profile::getInstance()->updateField('reputation', $val);
	}

	function _upload_file(){
		$session = \GCore\Libs\Base::getSession();
		$user = \GCore\Libs\Base::getUser();
		if((bool)$this->fparams->get('attach_files', 1) === true AND \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'attach_files') === true){
			$file = $_FILES['attach'];
			if(empty($file['name'])){
				return;	
			}
			$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
			$allowed_extensions = explode('-', $this->fparams->get('allowed_extensions', 'jpg-png-gif-zip-pdf-doc-docx-txt'));
			if(!in_array($ext, $allowed_extensions)){
				$session->setFlash('error', l_('CHRONOFORUMS_EXTENSION_NOT_ALLOWED'));
				return false;
			}
			$fname = $this->fparams->get('user_directory_files', 0) ? date('YmdHis').'_'.\GCore\Libs\Str::slug($file['name']) : $user['id'].'_'.date('YmdHis').'_'.\GCore\Libs\Str::slug($file['name']);
			$target = $this->fparams->get('user_directory_files', 0) ? \GCore\C::ext_path('chronoforums', 'front').'attachments'.DS.$user['id'].DS.$fname.'.'.$ext : \GCore\C::ext_path('chronoforums', 'front').'attachments'.DS.$fname.'.'.$ext;
			
			if($this->fparams->get('user_directory_files', 0) AND !is_dir(\GCore\C::ext_path('chronoforums', 'front').'attachments'.DS.$user['id'].DS)){
				\GCore\Libs\Folder::create(\GCore\C::ext_path('chronoforums', 'front').'attachments'.DS.$user['id'].DS);
			}
			
			$saved = \GCore\Libs\Upload::save($file['tmp_name'], $target);
			if(!$saved){
				$session->setFlash('error', l_('CHRONOFORUMS_FILE_SAVE_ERROR'));
				return false;
			}else{
				if(isset($this->data['Attachment'])){
					$count = count($this->data['Attachment']);
				}else{
					$count = 0;
				}
				$this->data['Attachment'][$count]['vfilename'] = $fname.'.'.$ext;
				$this->data['Attachment'][$count]['filename'] = $file['name'];
				$this->data['Attachment'][$count]['comment'] = '';
				$this->data['Attachment'][$count]['size'] = filesize($target);
			}
		}
	}

	function _delete_file(){
		//fix the files list
		$files_indexes = array_keys($this->data['delete_file']);
		$file_index = $files_indexes[0];
		$file_name = '';
		if(isset($this->data['Attachment'][$file_index])){
			$file_name = $this->data['Attachment'][$file_index]['vfilename'];
			unset($this->data['Attachment'][$file_index]);
			$this->data['Attachment'] = array_values($this->data['Attachment']);
		}
	}

	function _get_ranks(&$posts = array()){
		if(!empty($posts)){
			$ranks = $this->fparams->get('ranks', array());
			usort($ranks, function($a, $b){
				if($a['group_id'] == $b['group_id']){
					return (int)$a['weight'] - (int)$b['weight'];
				}else{
					return (int)$a['group_id'] - (int)$b['group_id'];
				}
			});
			//pr($ranks);
			foreach($posts as $k => $post){
				if(!empty($post['GroupUser'])){
					$user_groups = \GCore\Libs\Arr::getVal($post['GroupUser'], array('[n]', 'group_id'));
					foreach($ranks as $rank){
						if(!empty($rank['enabled']) AND !empty($rank['user_groups']) AND count(array_intersect($rank['user_groups'], $user_groups))){
							if(!empty($rank['group_id'])){
								$posts[$k]['PostAuthor']['ranks'][$rank['group_id']] = !empty($rank['code']) ? $rank['code'] : $rank['title'];
							}else{
								$posts[$k]['PostAuthor']['ranks'][] = !empty($rank['code']) ? $rank['code'] : $rank['title'];
							}
						}
					}
				}
				if(!empty($post['PostCounter'])){
					$user_post_count = $post['PostCounter'][0]['count'];
					foreach($ranks as $rank){
						if(!empty($rank['enabled']) AND !empty($rank['user_posts']) AND (int)$rank['user_posts'] <= $user_post_count){
							if(!empty($rank['group_id'])){
								$posts[$k]['PostAuthor']['ranks'][$rank['group_id']] = !empty($rank['code']) ? $rank['code'] : $rank['title'];
							}else{
								$posts[$k]['PostAuthor']['ranks'][] = !empty($rank['code']) ? $rank['code'] : $rank['title'];
							}
						}
					}
				}
			}
		}
	}

	function _preview(){
		$this->set('preview', true);
	}

	function _sendEmail($email_type = null, $tos = array()){
		$tos = array_keys($tos);
		switch($email_type){
			case 'report':
				$subject = l_('CHRONOFORUMS_POST_REPORTED_SUBJECT');
				$body = l_('CHRONOFORUMS_POST_REPORTED_BODY');
				$to = $tos;
				break;
			case 'new_reply':
				$subject = l_('CHRONOFORUMS_NEW_REPLY_SUBJECT');
				if((bool)$this->fparams->get('enable_emails_posting') === true){
					$subject .= l_('CHRONOFORUMS_NEW_REPLY_SUBJECT_EXT1');
				}
				$body = l_('CHRONOFORUMS_NEW_REPLY_BODY');
				if((bool)$this->fparams->get('send_reply_content') === true){
					$body .= l_('CHRONOFORUMS_NEW_REPLY_BODY_EXT1');
				}
				$to = $tos;
				break;
			case 'new_topic':
				$subject = l_('CHRONOFORUMS_NEW_TOPIC_SUBJECT');
				$body = l_('CHRONOFORUMS_NEW_TOPIC_BODY');
				$to = $tos;
				break;
			case 'new_post':
				$subject = l_('CHRONOFORUMS_NEW_POST_SUBJECT');
				$body = l_('CHRONOFORUMS_NEW_POST_BODY');
				$to = $tos;
				break;
			case 'post_edit':
				$subject = l_('CHRONOFORUMS_POST_EDIT_SUBJECT');
				$body = l_('CHRONOFORUMS_POST_EDIT_BODY');
				$to = $tos;
				break;
			case 'new_pm':
				$subject = l_('CHRONOFORUMS_NEW_PM_SUBJECT');
				$body = l_('CHRONOFORUMS_NEW_PM_BODY');
				$to = $tos;
				break;
		}
		$this->data['domain'] =  \GCore\Libs\Base::getConfig('site_title');
		$this->data['url'] =  empty($this->data['url']) ? \GCore\C::get('GCORE_ROOT_URL') : $this->data['url'];


		$subject = \GCore\Libs\Str::replacer($subject, $this->data, array('escape' => false));
		$body = \GCore\Libs\Str::replacer($body, $this->data, array('escape' => false));
		$body = nl2br($body);
		
		//load global settings
		$settings = $this->fparams->toArray();
		if(!empty($settings['mail'])){
			foreach($settings['mail'] as $k => $v){
				\GCore\Libs\Base::setConfig($k, $v);
			}
		}
		//send user email
		if(!empty($to)){
			\GCore\Libs\Mailer::send($to, $subject, $body, array(), array('from_name' => $this->fparams->get('email_from_name'), 'from_email' => $this->fparams->get('email_from_email'), 'reply_email' => $this->fparams->get('email_reply_email') ? $this->fparams->get('email_reply_email') : $this->fparams->get('email_from_email')));
		}
	}

	function _validated($params){
		if((bool)$params->get('validated', 0) === true){
			return true;
		}
		return false;
	}
}
?>
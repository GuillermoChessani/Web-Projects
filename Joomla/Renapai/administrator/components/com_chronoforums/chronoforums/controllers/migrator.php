<?php
/**
* COMPONENT FILE HEADER
**/
namespace GCore\Admin\Extensions\Chronoforums\Controllers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Migrator extends \GCore\Libs\GController {
	var $models = array(
		'\GCore\Admin\Extensions\Chronoforums\Models\Category', 
		'\GCore\Admin\Extensions\Chronoforums\Models\Forum', 
		'\GCore\Admin\Extensions\Chronoforums\Models\Topic', 
		'\GCore\Admin\Extensions\Chronoforums\Models\TopicTrack', 
		'\GCore\Admin\Extensions\Chronoforums\Models\Subscribed', 
		'\GCore\Admin\Extensions\Chronoforums\Models\Post', 
		'\GCore\Admin\Models\Group',
		'\GCore\Admin\Models\User',
	);
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
	
	function replacer(){
		ini_set('memory_limit', -1);
		set_time_limit(0);
		$user = \GCore\Libs\Base::getUser();
		$session = \GCore\Libs\Base::getSession();
		$direction = !empty($this->data['direction']) ? ' '.$this->data['direction'] : ' ASC';
		
		if(!empty($this->data['fix_posts']) AND (!empty($this->data['strings']) OR !empty($this->data['regexes']))){
			
			$posts_count = !empty($this->data['posts_count']) ? (int)$this->data['posts_count'] : $this->Post->find('count');
			
			$iteration = !empty($this->data['limit']) ? (int)$this->data['limit'] : 50;
			$limit = $iteration;
			$offset = $session->get('posts_offset', 0);
			
			$strings = !empty($this->data['strings']) ? \GCore\Libs\Str::list_to_array($this->data['strings'], ':::::') : array();
			$regexes = !empty($this->data['regexes']) ? \GCore\Libs\Str::list_to_array($this->data['regexes'], ':::::') : array();
			
			if($offset <= $posts_count){
				$posts = $this->Post->find('all', array('order' => 'Post.id'.$direction, 'fields' => array('Post.text', 'Post.id'), 'limit' => $limit, 'offset' => $offset, 'contain' => array('Post')));
				$offset = $offset + $iteration;
				$session->set('posts_offset', $offset);
				
				foreach($posts as $k => $post){
					if(!empty($strings)){
						$str_replaced = str_replace(array_keys($strings), array_values($strings), $post['Post']['text']);
						if(!empty($str_replaced)){
							$post['Post']['text'] = $str_replaced;	
						}
					}
					if(!empty($regexes)){
						$regex_replaced = preg_replace(array_keys($regexes), array_values($regexes), $post['Post']['text']);
						if(!empty($regex_replaced)){
							$post['Post']['text'] = $regex_replaced;	
						}
					}
					$this->Post->save($post, array('callbacks' => false, 'recursive' => -1));
				}
				
				if(is_array($posts) AND !empty($posts)){
					echo (count($posts) + $offset - $iteration).' Posts processed.....';
				}else{
					echo 'STOP';
				}
			}else{
				echo 'STOP';
			}
			//$session = \GCore\Libs\Base::getSession();
			//$session->setFlash('success', l_('Posts imported!'));
			$this->view = false;
		}
		
		if(!empty($this->data['alias_topics'])){
			
			$topics_count = !empty($this->data['topics_count']) ? (int)$this->data['topics_count'] : $this->Topic->find('count');
			
			$iteration = !empty($this->data['limit']) ? (int)$this->data['limit'] : 50;
			$limit = $iteration;
			$offset = $session->get('topics_offset', 0);
						
			if($offset <= $topics_count){
				$topics = $this->Topic->find('all', array('order' => 'Topic.id'.$direction, 'fields' => array('Topic.title', 'Topic.alias', 'Topic.id'), 'limit' => $limit, 'offset' => $offset, 'contain' => array('Topic')));
				$offset = $offset + $iteration;
				$session->set('topics_offset', $offset);
				
				foreach($topics as $k => $topic){
					if(empty($topic['Topic']['alias']) AND !empty($topic['Topic']['title'])){
						$topic['Topic']['alias'] = \GCore\Libs\Str::slug($topic['Topic']['title']);
					}
					$this->Topic->save($topic, array('callbacks' => false, 'recursive' => -1));
				}
				
				if(is_array($topics) AND !empty($topics)){
					echo (count($topics) + $offset - $iteration).' topics processed.....';
				}else{
					echo 'STOP';
				}
			}else{
				echo 'STOP';
			}
			$this->view = false;
		}
	}
	
	function index(){
		ini_set('memory_limit', -1);
		set_time_limit(0);
		$user = \GCore\Libs\Base::getUser();
		$session = \GCore\Libs\Base::getSession();
		$direction = !empty($this->data['direction']) ? ' '.$this->data['direction'] : ' ASC';
		
		if(!empty($this->data['source']) AND $this->data['source'] == 'phpbb3'){
			if(!empty($this->data['import_forums'])){
				\GCore\Libs\Model::generateModel('Forum', array(
					'dbo_config' => array('type' => $this->data['dbtype'], 'host' => $this->data['dbhost'], 'name' => $this->data['dbname'], 'user' => $this->data['dbuser'], 'pass' => $this->data['dbpass'], 'prefix' => $this->data['dbprefix']),
					'name' => 'Forum',
					'tablename' => '#__forums',
				));
				
				//import categories
				$categories = \GCore\Models\Forum::getInstance()->find('all', array('conditions' => array('Forum.parent_id' => 0), 'order' => array('Forum.left_id')));
				//pr($categories);
				
				$ordering = 0;
				foreach($categories as $k => $category){
					$category2 = array();
					$category2['id'] = $category['Forum']['forum_id'];
					$category2['title'] = $category['Forum']['forum_name'];
					$category2['alias'] = '';
					$category2['description'] = $category['Forum']['forum_desc'];
					$category2['ordering'] = $ordering;
					$category2['published'] = 1;
					$category2['params'] = '';
					$category2['rules'] = '';
					$ordering++;
					$this->Category->save($category2, array('new' => true));
				}
				
				//import forums
				$forums = \GCore\Models\Forum::getInstance()->find('all', array('conditions' => array('Forum.parent_id <>' => 0), 'order' => array('Forum.left_id')));
				//pr($categories);
				
				$ordering = 0;
				foreach($forums as $k => $forum){
					$forum2 = array();
					$forum2['id'] = $forum['Forum']['forum_id'];
					$forum2['title'] = $forum['Forum']['forum_name'];
					$forum2['alias'] = '';
					$forum2['description'] = $forum['Forum']['forum_desc'];
					$forum2['cat_id'] = $forum['Forum']['parent_id'];
					$forum2['ordering'] = $ordering;
					$forum2['published'] = 1;
					$forum2['params'] = '';
					$forum2['rules'] = '';
					$forum2['topic_count'] = $forum['Forum']['forum_topics'];
					$forum2['post_count'] = $forum['Forum']['forum_posts'];
					$forum2['last_post'] = $forum['Forum']['forum_last_post_id'];
					$ordering++;
					$this->Forum->save($forum2, array('new' => true));
				}
				
				echo 'STOP';
				$this->view = false;
			}
			
			if(!empty($this->data['import_topics'])){
				\GCore\Libs\Model::generateModel('BBUser', array(
					'dbo_config' => array('type' => $this->data['dbtype'], 'host' => $this->data['dbhost'], 'name' => $this->data['dbname'], 'user' => $this->data['dbuser'], 'pass' => $this->data['dbpass'], 'prefix' => $this->data['dbprefix']),
					'name' => 'BBUser',
					'tablename' => '#__users',
				));
				//import topics
				\GCore\Libs\Model::generateModel('Topic', array(
					'dbo_config' => array('type' => $this->data['dbtype'], 'host' => $this->data['dbhost'], 'name' => $this->data['dbname'], 'user' => $this->data['dbuser'], 'pass' => $this->data['dbpass'], 'prefix' => $this->data['dbprefix']),
					'name' => 'Topic',
					'tablename' => '#__topics',
				));
				
				$topics_count = !empty($this->data['topics_count']) ? (int)$this->data['topics_count'] : \GCore\Models\Topic::getInstance()->find('count');
				
				$iteration = !empty($this->data['limit']) ? (int)$this->data['limit'] : 50;
				$limit = $iteration;
				$offset = $session->get('topics_offset', 0);
				
				if($offset <= $topics_count){
					$topics = \GCore\Models\Topic::getInstance()->find('all', array('order' => 'Topic.topic_id'.$direction, 'limit' => $limit, 'offset' => $offset));
					$offset = $offset + $iteration;
					$session->set('topics_offset', $offset);
					
					foreach($topics as $k => $topic){
						$topic2 = $topic['Topic'];
						$topic2['id'] = $topic['Topic']['topic_id'];
						$topic2['title'] = $topic['Topic']['topic_title'];
						$topic2['alias'] = '';
						$topic2['created'] = date('Y-m-d H:i:s', $topic['Topic']['topic_time']);
						$topic2['reported'] = $topic['Topic']['topic_reported'];
						$topic2['has_attachments'] = $topic['Topic']['topic_attachment'];
						$topic2['published'] = $topic['Topic']['topic_approved'];
						$topic2['user_id'] = $topic['Topic']['topic_poster'];
						$topic2['hits'] = $topic['Topic']['topic_views'];
						$topic2['post_count'] = (int)$topic['Topic']['topic_replies'] + 1;
						$topic2['last_post'] = $topic['Topic']['topic_last_post_id'];
						$topic2['params'] = '';
						$topic2['announce'] = ((int)$topic['Topic']['topic_type'] == 3 OR (int)$topic['Topic']['topic_type'] == 2) ? 1 : 0;
						$topic2['locked'] = $topic['Topic']['topic_status'];
						$topic2['sticky'] = ((int)$topic['Topic']['topic_type'] == 1) ? 1 : 0;
						
						if(!empty($topic['Topic']['topic_first_poster_name'])){
							$topic2['user_id'] = $this->User->field('id', array('User.username' => $topic['Topic']['topic_first_poster_name']));
						}else{
							$poster_username = \GCore\Models\BBUser::getInstance()->field('username_clean', array('BBUser.user_id' => $topic['Topic']['topic_poster']));
							$topic2['user_id'] = $this->User->field('id', array('User.username' => $poster_username));
						}
						
						$this->Topic->save($topic2, array('new' => true, 'callbacks' => false, 'recursive' => -1));
					}
				
					if(is_array($topics) AND !empty($topics)){
						echo (count($topics) + $offset - $iteration).' Topics processed.....';
					}else{
						echo 'STOP';
					}
				}else{
					echo 'STOP';
				}
				//$session = \GCore\Libs\Base::getSession();
				//$session->setFlash('success', l_('Topics imported!'));
				$this->view = false;
			}
			
			if(!empty($this->data['import_posts'])){
				\GCore\Libs\Model::generateModel('BBUser', array(
					'dbo_config' => array('type' => $this->data['dbtype'], 'host' => $this->data['dbhost'], 'name' => $this->data['dbname'], 'user' => $this->data['dbuser'], 'pass' => $this->data['dbpass'], 'prefix' => $this->data['dbprefix']),
					'name' => 'BBUser',
					'tablename' => '#__users',
				));
				//import posts
				\GCore\Libs\Model::generateModel('Post', array(
					'dbo_config' => array('type' => $this->data['dbtype'], 'host' => $this->data['dbhost'], 'name' => $this->data['dbname'], 'user' => $this->data['dbuser'], 'pass' => $this->data['dbpass'], 'prefix' => $this->data['dbprefix']),
					'name' => 'Post',
					'tablename' => '#__posts',
				));
				\GCore\Libs\Model::generateModel('Attachment', array(
					'dbo_config' => array('type' => $this->data['dbtype'], 'host' => $this->data['dbhost'], 'name' => $this->data['dbname'], 'user' => $this->data['dbuser'], 'pass' => $this->data['dbpass'], 'prefix' => $this->data['dbprefix']),
					'name' => 'Attachment',
					'tablename' => '#__attachments',
				));
				
				\GCore\Models\Post::getInstance()->bindModels('hasMany', array(
					'Attachment' => array(
						'className' => '\GCore\Models\Attachment',
						'foreignKey' => 'post_msg_id',
					),
				));
				
				$posts_count = !empty($this->data['posts_count']) ? (int)$this->data['posts_count'] : \GCore\Models\Post::getInstance()->find('count');
				
				$iteration = !empty($this->data['limit']) ? (int)$this->data['limit'] : 50;
				$limit = $iteration;
				$offset = $session->get('posts_offset', 0);
				
				if($offset <= $posts_count){
					$posts = \GCore\Models\Post::getInstance()->find('all', array('order' => 'Post.post_id'.$direction, 'limit' => $limit, 'offset' => $offset));
					$offset = $offset + $iteration;
					$session->set('posts_offset', $offset);
					
					foreach($posts as $k => $post){
						$post2['Post'] = $post['Post'];
						$post2['Post']['id'] = $post['Post']['post_id'];
						$post2['Post']['subject'] = $post['Post']['post_subject'];
						//fix post text
						$inline_codes = array('<!-- ia0 -->', '<!-- ia1 -->', '<!-- ia2 -->', '<!-- ia3 -->', '<!-- ia4-->', '<!-- ia5 -->', '<!-- ia6 -->', '<!-- ia7 -->', '<!-- ia8 -->', '<!-- ia9 -->', );
						preg_match_all('/<!-- s(.*?) --><img (.*?)><!-- s(.*?) -->/i', $post['Post']['post_text'], $matches);
						if(!empty($matches[0]) AND !empty($matches[1])){
							$post['Post']['post_text'] = str_replace($matches[0], $matches[1], $post['Post']['post_text']);
						}
						preg_match_all('/<!-- m --><a class="postlink" href="(.*?)">(.*?)<!-- m -->/i', $post['Post']['post_text'], $matches);
						if(!empty($matches[0]) AND !empty($matches[1])){
							foreach($matches[1] as $m => $match){
								$post['Post']['post_text'] = str_replace($matches[0][$m], '[url='.$matches[1][$m].']'.$matches[1][$m].'[/url]', $post['Post']['post_text']);
							}
						}
						preg_match_all('/<!-- e --><a href="mailto:(.*?)">(.*?)<!-- e -->/i', $post['Post']['post_text'], $matches);
						if(!empty($matches[0]) AND !empty($matches[1])){
							foreach($matches[1] as $m => $match){
								$post['Post']['post_text'] = str_replace($matches[0][$m], '[email='.$matches[1][$m].']'.$matches[1][$m].'[/email]', $post['Post']['post_text']);
							}
						}
						preg_match_all('/<!-- l --><a class="postlink-local" href="(.*?)">(.*?)<!-- l -->/i', $post['Post']['post_text'], $matches);
						if(!empty($matches[0]) AND !empty($matches[1])){
							foreach($matches[1] as $m => $match){
								$fixed_link = str_replace(array('viewtopic.php?', 'viewforum.php?'), array(r_('index.php?option=com_chronoforums&cont=posts&'), r_('index.php?option=com_chronoforums&cont=forums&')), $matches[1][$m]);
								$post['Post']['post_text'] = str_replace($matches[0][$m], '[url='.$fixed_link.']'.$fixed_link.'[/url]', $post['Post']['post_text']);
							}
						}
						$text_fixed = str_replace(array(':m:'.$post['Post']['bbcode_uid'], ':u:'.$post['Post']['bbcode_uid'], ':'.$post['Post']['bbcode_uid']), '', $post['Post']['post_text']);
						$post2['Post']['text'] = html_entity_decode(str_replace($inline_codes, '', $text_fixed));
						
						$post2['Post']['created'] = date('Y-m-d H:i:s', $post['Post']['post_time']);
						//$post2['Post']['user_id'] = $post['Post']['post_poster'];
						$post2['Post']['published'] = $post['Post']['post_approved'];
						
						$post2['Post']['params'] = json_encode(array('author_address' => $post['Post']['poster_ip']));
						
						
						if(!empty($post['Post']['post_username'])){
							$post2['Post']['user_id'] = $this->User->field('id', array('User.username' => $post['Post']['post_username']));
						}else{
							$poster_username = \GCore\Models\BBUser::getInstance()->field('username_clean', array('BBUser.user_id' => $post['Post']['poster_id']));
							$post2['Post']['user_id'] = $this->User->field('id', array('User.username' => $poster_username));
						}
						//attachments
						if(!empty($post['Attachment'])){
							$post2['Attachment'] = $post['Attachment'];
							foreach($post2['Attachment'] as $a => $attachment){
								$post2['Attachment'][$a]['id'] = $post['Attachment'][$a]['attach_id'];
								$post2['Attachment'][$a]['post_id'] = $post['Attachment'][$a]['post_msg_id'];
								$post2['Attachment'][$a]['user_id'] = $post2['Post']['user_id'];
								$post2['Attachment'][$a]['filename'] = $post['Attachment'][$a]['real_filename'];
								$post2['Attachment'][$a]['vfilename'] = $post['Attachment'][$a]['physical_filename'];
								$post2['Attachment'][$a]['comment'] = $post['Attachment'][$a]['attach_comment'];
								$post2['Attachment'][$a]['downloads'] = $post['Attachment'][$a]['download_count'];
								$post2['Attachment'][$a]['created'] = date('Y-m-d H:i:s', $post['Attachment'][$a]['filetime']);
								$post2['Attachment'][$a]['size'] = $post['Attachment'][$a]['filesize'];
								
								$this->Post->Attachment->save($post2['Attachment'][$a], array('new' => true));
							}
							unset($post2['Attachment']);
						}
						
						$this->Post->save($post2, array('new' => true, 'callbacks' => false, 'recursive' => -1));
					}
					
					if(is_array($posts) AND !empty($posts)){
						echo (count($posts) + $offset - $iteration).' Posts processed.....';
					}else{
						echo 'STOP';
					}
				}else{
					echo 'STOP';
				}
				//$session = \GCore\Libs\Base::getSession();
				//$session->setFlash('success', l_('Posts imported!'));
				$this->view = false;
			}
		}else if(!empty($this->data['source']) AND $this->data['source'] == 'kunena'){
			if(!empty($this->data['import_forums'])){
				\GCore\Libs\Model::generateModel('Forum', array(
					'name' => 'Forum',
					'tablename' => '#__kunena_categories',
				));
				
				//import categories
				$categories = \GCore\Models\Forum::getInstance()->find('all', array('conditions' => array('Forum.parent_id' => 0), 'order' => array('Forum.id')));
				//pr($categories);
				
				$ordering = 0;
				foreach($categories as $k => $category){
					$category2 = array();
					$category2['id'] = $category['Forum']['id'];
					$category2['title'] = $category['Forum']['name'];
					$category2['alias'] = '';
					$category2['description'] = $category['Forum']['description'];
					$category2['ordering'] = $ordering;
					$category2['published'] = 1;
					$category2['params'] = '';
					$category2['rules'] = '';
					$ordering++;
					$this->Category->save($category2, array('new' => true));
				}
				
				//import forums
				$forums = \GCore\Models\Forum::getInstance()->find('all', array('conditions' => array('Forum.parent_id <>' => 0), 'order' => array('Forum.id')));
				//pr($categories);
				
				$ordering = 0;
				foreach($forums as $k => $forum){
					$forum2 = array();
					$forum2['id'] = $forum['Forum']['id'];
					$forum2['title'] = $forum['Forum']['name'];
					$forum2['alias'] = '';
					$forum2['description'] = $forum['Forum']['description'];
					$forum2['cat_id'] = $forum['Forum']['parent_id'];
					$forum2['ordering'] = $forum['Forum']['ordering'];
					$forum2['published'] = 1;
					$forum2['params'] = '';
					$forum2['rules'] = '';
					$forum2['topic_count'] = $forum['Forum']['numTopics'];
					$forum2['post_count'] = $forum['Forum']['numPosts'];
					$forum2['last_post'] = $forum['Forum']['last_post_id'];
					$ordering++;
					$this->Forum->save($forum2, array('new' => true));
				}
				
				echo 'STOP';
				$this->view = false;
			}
			
			if(!empty($this->data['import_topics'])){
				//import topics
				\GCore\Libs\Model::generateModel('Topic', array(
					'name' => 'Topic',
					'tablename' => '#__kunena_topics',
				));
				
				$topics_count = !empty($this->data['topics_count']) ? (int)$this->data['topics_count'] : \GCore\Models\Topic::getInstance()->find('count');
				
				$iteration = !empty($this->data['limit']) ? (int)$this->data['limit'] : 50;
				$limit = $iteration;
				$offset = $session->get('topics_offset', 0);
				
				if($offset <= $topics_count){
					$topics = \GCore\Models\Topic::getInstance()->find('all', array('order' => 'Topic.id'.$direction, 'limit' => $limit, 'offset' => $offset));
					$offset = $offset + $iteration;
					$session->set('topics_offset', $offset);
					
					foreach($topics as $k => $topic){
						$topic2 = $topic['Topic'];
						$topic2['id'] = $topic['Topic']['id'];
						$topic2['forum_id'] = $topic['Topic']['category_id'];
						$topic2['title'] = $topic['Topic']['subject'];
						$topic2['alias'] = \GCore\Libs\Str::slug($topic['Topic']['subject']);
						$topic2['created'] = date('Y-m-d H:i:s', $topic['Topic']['first_post_time']);
						//$topic2['reported'] = $topic['Topic']['topic_reported'];
						$topic2['has_attachments'] = (int)!empty($topic['Topic']['attachments']);
						$topic2['published'] = (int)empty($topic['Topic']['hold']);
						$topic2['user_id'] = $topic['Topic']['first_post_userid'];
						$topic2['hits'] = $topic['Topic']['hits'];
						$topic2['post_count'] = (int)$topic['Topic']['posts'];
						$topic2['last_post'] = $topic['Topic']['last_post_id'];
						$topic2['params'] = '';
						//$topic2['announce'] = ((int)$topic['Topic']['topic_type'] == 3 OR (int)$topic['Topic']['topic_type'] == 2) ? 1 : 0;
						$topic2['locked'] = $topic['Topic']['locked'];
						//$topic2['sticky'] = ((int)$topic['Topic']['topic_type'] == 1) ? 1 : 0;
						
						$this->Topic->save($topic2, array('new' => true, 'callbacks' => false, 'recursive' => -1));
					}
				
					if(is_array($topics) AND !empty($topics)){
						echo (count($topics) + $offset - $iteration).' Topics processed.....';
					}else{
						echo 'STOP';
					}
				}else{
					echo 'STOP';
				}
				$this->view = false;
			}
			
			if(!empty($this->data['import_posts'])){
				//import posts
				\GCore\Libs\Model::generateModel('Post', array(
					'name' => 'Post',
					'tablename' => '#__kunena_messages',
				));
				\GCore\Libs\Model::generateModel('PostText', array(
					'name' => 'PostText',
					'tablename' => '#__kunena_messages_text',
				));
				\GCore\Libs\Model::generateModel('Attachment', array(
					'name' => 'Attachment',
					'tablename' => '#__kunena_attachments',
				));
				
				\GCore\Models\Post::getInstance()->bindModels('hasOne', array(
					'PostText' => array(
						'className' => '\GCore\Models\PostText',
						'foreignKey' => 'mesid',
					),
				));
				\GCore\Models\Post::getInstance()->bindModels('hasMany', array(
					'Attachment' => array(
						'className' => '\GCore\Models\Attachment',
						'foreignKey' => 'mesid',
					),
				));
				
				$posts_count = !empty($this->data['posts_count']) ? (int)$this->data['posts_count'] : \GCore\Models\Post::getInstance()->find('count');
				
				$iteration = !empty($this->data['limit']) ? (int)$this->data['limit'] : 50;
				$limit = $iteration;
				$offset = $session->get('posts_offset', 0);
				
				if(!empty($this->data['attachments_names'])){
					//rename the file on desk and move it
					$kunena_attachments_path = str_replace(array('/', '\\'), DS, $this->data['kunena_attachments_path']);
					$attachments_path = \GCore\C::ext_path('chronoforums', 'front').'attachments'.DS;
				}
				
				if($offset <= $posts_count){
					$posts = \GCore\Models\Post::getInstance()->find('all', array('order' => 'Post.id'.$direction, 'limit' => $limit, 'offset' => $offset));
					$offset = $offset + $iteration;
					$session->set('posts_offset', $offset);
					
					foreach($posts as $k => $post){
						$post2['Post'] = $post['Post'];
						$post2['Post']['id'] = $post['Post']['id'];
						$post2['Post']['forum_id'] = $post['Post']['catid'];
						$post2['Post']['topic_id'] = $post['Post']['thread'];
						$post2['Post']['subject'] = $post['Post']['subject'];
						
						$post2['Post']['text'] = $post['PostText']['message'];
						$post2['Post']['created'] = date('Y-m-d H:i:s', $post['Post']['time']);
						
						$post2['Post']['user_id'] = $post['Post']['userid'];
						$post2['Post']['published'] = (int)empty($post['Post']['hold']);
						
						$post2['Post']['params'] = json_encode(array('author_address' => $post['Post']['ip']));
						
						if(!empty($post['Post']['modified_time'])){
							$post2['Post']['modified'] = !empty($post['Post']['modified_time']) ? date('Y-m-d H:i:s', $post['Post']['modified_time']) : NULL;
						}
						//attachments
						if(!empty($post['Attachment'])){
							$post2['Attachment'] = $post['Attachment'];
							foreach($post2['Attachment'] as $a => $attachment){
								$post2['Attachment'][$a]['id'] = $post['Attachment'][$a]['id'];
								$post2['Attachment'][$a]['post_id'] = $post['Attachment'][$a]['mesid'];
								$post2['Attachment'][$a]['topic_id'] = $post2['Post']['topic_id'];
								$post2['Attachment'][$a]['user_id'] = $post['Attachment'][$a]['userid'];
								$post2['Attachment'][$a]['filename'] = $post['Attachment'][$a]['filename'];
								$post2['Attachment'][$a]['vfilename'] = empty($this->data['attachments_names']) ? $post['Attachment'][$a]['filename'] : $post['Attachment'][$a]['userid'].'_'.$post['Post']['time'].'_'.$post['Attachment'][$a]['filename'];
								if(!empty($this->data['attachments_names'])){
									//rename the file on desk and move it
									\GCore\Libs\File::move($kunena_attachments_path.$post['Attachment'][$a]['userid'].DS.$post['Attachment'][$a]['filename'], $attachments_path.$post2['Attachment'][$a]['vfilename']);
								}
								//$post2['Attachment'][$a]['comment'] = $post['Attachment'][$a]['attach_comment'];
								//$post2['Attachment'][$a]['downloads'] = $post['Attachment'][$a]['download_count'];
								$post2['Attachment'][$a]['created'] = $post2['Post']['created'];
								$post2['Attachment'][$a]['size'] = $post['Attachment'][$a]['size'];
								
								$this->Post->Attachment->save($post2['Attachment'][$a], array('new' => true));
							}
							unset($post2['Attachment']);
							
							$this->Topic->id = $post2['Post']['topic_id'];
							$this->Topic->saveField('has_attachments', 1);
						}
						
						$this->Post->save($post2, array('new' => true, 'callbacks' => false, 'recursive' => -1));
					}
					
					if(is_array($posts) AND !empty($posts)){
						echo (count($posts) + $offset - $iteration).' Posts processed.....';
					}else{
						echo 'STOP';
					}
				}else{
					echo 'STOP';
				}
				$this->view = false;
			}
		
			if(!empty($this->data['import_topics_track'])){
				//import topics
				\GCore\Libs\Model::generateModel('Track', array(
					'name' => 'Track',
					'tablename' => '#__kunena_user_read',
				));
				
				$topics_count = !empty($this->data['topics_count']) ? (int)$this->data['topics_count'] : \GCore\Models\Track::getInstance()->find('count');
				
				$iteration = !empty($this->data['limit']) ? (int)$this->data['limit'] : 50;
				$limit = $iteration;
				$offset = $session->get('topics_offset', 0);
				
				if($offset <= $topics_count){
					$tracks = \GCore\Models\Track::getInstance()->find('all', array('order' => 'Track.topic_id'.$direction, 'limit' => $limit, 'offset' => $offset));
					$offset = $offset + $iteration;
					$session->set('topics_offset', $offset);
					
					foreach($tracks as $k => $track){
						$track2 = $track['Track'];
						$track2['forum_id'] = $track['Track']['category_id'];
						$track2['last_visit'] = date('Y-m-d H:i:s', $track['Track']['time']);
						
						$this->TopicTrack->save($track2, array('new' => true, 'callbacks' => false, 'recursive' => -1));
					}
				
					if(is_array($tracks) AND !empty($tracks)){
						echo (count($tracks) + $offset - $iteration).' Topics processed.....';
					}else{
						echo 'STOP';
					}
				}else{
					echo 'STOP';
				}
				$this->view = false;
			}
			
			if(!empty($this->data['import_topics_subscribe'])){
				//import topics
				\GCore\Libs\Model::generateModel('Subscribe', array(
					'name' => 'Subscribe',
					'tablename' => '#__kunena_user_topics',
				));
				
				$topics_count = !empty($this->data['topics_count']) ? (int)$this->data['topics_count'] : \GCore\Models\Subscribe::getInstance()->find('count');
				
				$iteration = !empty($this->data['limit']) ? (int)$this->data['limit'] : 50;
				$limit = $iteration;
				$offset = $session->get('topics_offset', 0);
				
				if($offset <= $topics_count){
					$tracks = \GCore\Models\Subscribe::getInstance()->find('all', array('order' => 'Subscribe.topic_id'.$direction, 'limit' => $limit, 'offset' => $offset));
					$offset = $offset + $iteration;
					$session->set('topics_offset', $offset);
					
					foreach($tracks as $k => $track){
						$track2 = $track['Subscribe'];
						$track2['sub_type'] = 'topic';
						$track2['notify_status'] = 1;
						
						$this->Subscribed->save($track2, array('new' => true, 'callbacks' => false, 'recursive' => -1));
					}
				
					if(is_array($tracks) AND !empty($tracks)){
						echo (count($tracks) + $offset - $iteration).' Topics processed.....';
					}else{
						echo 'STOP';
					}
				}else{
					echo 'STOP';
				}
				$this->view = false;
			}
		}
	}
}
?>
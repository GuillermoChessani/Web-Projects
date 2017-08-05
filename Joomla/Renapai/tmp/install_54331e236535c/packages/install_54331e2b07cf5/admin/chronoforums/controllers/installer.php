<?php
/**
* COMPONENT FILE HEADER
**/
namespace GCore\Admin\Extensions\Chronoforums\Controllers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Installer extends \GCore\Libs\GController {
	function index(){
		//apply updates
		$sql = file_get_contents(\GCore\C::ext_path('chronoforums', 'admin').'sql'.DS.'install.chronoforums.sql');
		
		$queries = \GCore\Libs\Database::getInstance()->split_sql($sql);
		foreach($queries as $query){
			\GCore\Libs\Database::getInstance()->exec(\GCore\Libs\Database::getInstance()->_prefixTable($query));
		}
		
		//updates
		$tableinfo = \GCore\Libs\Database::getInstance()->getTableInfo('#__chronoengine_forums_messages_recipients');
		$fields = \GCore\Libs\Arr::getVal($tableinfo, array('[n]', 'Field'));
		if(!in_array('discussion_id', $fields)){
			$query = "ALTER TABLE `#__chronoengine_forums_messages_recipients` ADD `discussion_id` VARCHAR( 55 ) NOT NULL DEFAULT '', ADD INDEX ( `discussion_id` ) ;";
			\GCore\Libs\Database::getInstance()->exec(\GCore\Libs\Database::getInstance()->_prefixTable($query));
		}
		if(!in_array('hidden', $fields)){
			$query = "ALTER TABLE `#__chronoengine_forums_messages_recipients` ADD `hidden` TINYINT( 1 ) NOT NULL DEFAULT '0';";
			\GCore\Libs\Database::getInstance()->exec(\GCore\Libs\Database::getInstance()->_prefixTable($query));
		}
		
		$tableinfo = \GCore\Libs\Database::getInstance()->getTableInfo('#__chronoengine_forums_users_profiles');
		$fields = \GCore\Libs\Arr::getVal($tableinfo, array('[n]', 'Field'));
		if(!in_array('reputation', $fields)){
			$query = "ALTER TABLE `#__chronoengine_forums_users_profiles` ADD `reputation` INT(7) NOT NULL DEFAULT '0';";
			\GCore\Libs\Database::getInstance()->exec(\GCore\Libs\Database::getInstance()->_prefixTable($query));
		}
		
		$session = \GCore\Libs\Base::getSession();
		$session->setFlash('success', l_('CF_DB_TABLES_INSTALLED'));
		$this->redirect(r_('index.php?ext=chronoforums&act=delete_cache'));
	}
	
	function fix_charset(){
		$posts = \GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance()->find('all', array('recursive' => -1));
		foreach($posts as $post){
			$data = array(
				'id' => $post['Post']['id'], 
				'subject' => mb_convert_encoding($post['Post']['subject'], 'ISO-8859-1', 'UTF-8'), 
				'text' => mb_convert_encoding($post['Post']['text'], 'ISO-8859-1', 'UTF-8'), 
			);
			\GCore\Admin\Extensions\Chronoforums\Models\Post::getInstance()->save($data);
		}
		
		$topics = \GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance()->find('all', array('recursive' => -1));
		foreach($topics as $topic){
			$data = array(
				'id' => $topic['Topic']['id'], 
				'title' => mb_convert_encoding($topic['Topic']['title'], 'ISO-8859-1', 'UTF-8'), 
				'alias' => '', 
			);
			\GCore\Admin\Extensions\Chronoforums\Models\Topic::getInstance()->save($data);
		}
		echo "Done!";
	}
}
?>
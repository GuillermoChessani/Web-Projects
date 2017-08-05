<?php
/**
* COMPONENT FILE HEADER
**/
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or define("GCORE_SITE", "front");
jimport('cegcore.joomla_gcloader');
if(!class_exists('JoomlaGCLoader')){
	JError::raiseWarning(100, "Please download the CEGCore framework from www.chronoengine.com then install it using the 'Extensions Manager'");
	return;
}

$chronoforums_setup = function(){
	//load forums settings early
	$settings = \GCore\Admin\Models\Extension::getInstance()->find('first', array('conditions' => array('name' => 'chronoforums'), 'fields' => array('settings')));
	$_POST['Extension']['chronoforums']['settings'] = !empty($settings['Extension']['settings']) ? $settings['Extension']['settings'] : array();
	$chronoforums_params = new \GCore\Libs\Parameter($_POST['Extension']['chronoforums']['settings']);
	if((bool)$chronoforums_params->get('forums_query_cache', 0) === true){
		\GCore\Libs\Base::setConfig('cache_query', 1);
	}
	if(strlen($chronoforums_params->get('forums_cache_engine', 'file')) > 0){
		\GCore\Libs\Base::setConfig('cache_engine', $chronoforums_params->get('forums_cache_engine', 'file'));
	}
	//end loading settings
};

$output = new JoomlaGCLoader('front', 'chronoforums', 'chronoforums', $chronoforums_setup);
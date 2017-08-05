<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
if(!defined('DS')){
	define('DS', DIRECTORY_SEPARATOR);
}
function ChronoforumsBuildRoute(&$query){
	$segments = array();
	if(!empty($query['cont'])){
		$segments[] = $query['cont'];
	}
	if(!empty($query['act'])){
		$segments[] = $query['act'];
	}
	$vps = array('u', 'm', 'f', 't', 'p');
	foreach($vps as $vp){
		if(!empty($query[$vp])){
			$segments[] = $vp.$query[$vp];
		}
	}
	
	if(!empty($query['alias'])){
		$segments[] = $query['alias'];
	}
	
	if(!empty($query['cont'])){
		unset($query['cont']);
	}
	if(!empty($query['act'])){
		unset($query['act']);
	}
	if(!empty($query['u'])){
		unset($query['u']);
	}
	if(!empty($query['m'])){
		unset($query['m']);
	}
	if(!empty($query['f'])){
		unset($query['f']);
	}
	if(!empty($query['t'])){
		unset($query['t']);
	}
	if(!empty($query['p'])){
		unset($query['p']);
	}
	if(!empty($query['alias'])){
		unset($query['alias']);
	}
	return $segments;
}

function ChronoforumsParseRoute($segments){
	$query = array();
	
	$check_param = function($param, $main = ''){
		if(preg_match('/[0-9]/', $param)){
			$vps = array('u', 'm', 'f', 't', 'p');
			foreach($vps as $vp){
				if(strpos($param, $vp) === 0 AND is_numeric(substr($param, 1))){
					return array($vp => substr($param, 1));
				}
			}
		}else{
			return array($main => $param);
		}
		return array();
	};
	
	$main = array('cont', 'act');
	while(!empty($segments)){
		$param = array_shift($segments);
		if(!empty($main)){
			$query = array_merge($query, $check_param($param, array_shift($main)));
		}else{
			$query = array_merge($query, $check_param($param));
		}
	}
	
	//fix for legacy boards
	if(!empty($query['cont']) AND $query['cont'] == 'viewtopic'){
		//$_GET['f'] = empty($_GET['f']) ? 0 : $_GET['f'];
		JRequest::setVar('f', !JRequest::getVar('f') ? 0 : JRequest::getVar('f'));
		//$_GET['t'] = empty($_GET['t']) ? 0 : $_GET['t'];
		JRequest::setVar('t', !JRequest::getVar('t') ? 0 : JRequest::getVar('t'));
		//header('Location: '.'posts/f'.$_GET['f'].'/t'.$_GET['t']);
		header('Location: '.'posts/f'.JRequest::getVar('f').'/t'.JRequest::getVar('t'));
		ob_end_flush();
		exit();
	}

	foreach($query as $k => $v){
		//$_GET[$k] = $v;
		JRequest::setVar($k, $v);
	}
	//print_r($query);//die();
	return $query;
}

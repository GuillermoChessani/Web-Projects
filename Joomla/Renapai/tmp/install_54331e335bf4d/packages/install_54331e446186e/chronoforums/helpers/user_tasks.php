<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace GCore\Extensions\Chronoforums\Helpers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class UserTasks {
	var $view;
	static $ranks_colors = array();
	static $ranks_outputs = array();
	
	protected function _get_ranks_colors($ranks = array()){
		if(!empty(self::$ranks_colors)){
			return self::$ranks_colors;
		}else{
			$colors = \GCore\Libs\Arr::getVal($ranks, array('[n]', 'Rank', 'params', 'username_color'));
			$ids = \GCore\Libs\Arr::getVal($ranks, array('[n]', 'Rank', 'id'));
			return self::$ranks_colors = array_combine($ids, $colors);
		}
	}
	
	protected function _get_ranks_outputs($ranks = array()){
		if(!empty(self::$ranks_outputs)){
			return self::$ranks_outputs;
		}else{
			$outputs = \GCore\Libs\Arr::getVal($ranks, array('[n]', 'Rank', 'output'));
			foreach($outputs as $k => $output){
				if(empty($output)){
					$outputs[$k] = $ranks[$k]['Rank']['title'];
				}else{
					ob_start();
					eval('?>'.$ranks[$k]['Rank']['output']);
					$output = ob_get_clean();
					$outputs[$k] = $output;
				}
			}
			$ids = \GCore\Libs\Arr::getVal($ranks, array('[n]', 'Rank', 'id'));
			return self::$ranks_outputs = array_combine($ids, $outputs);
		}
	}
	
	function display_ranks($user = array()){
		$fparams = $this->view->vars['fparams'];
		$ranks = !empty($this->view->vars['ranks']) ? $this->_get_ranks_outputs($this->view->vars['ranks']) : array();
		if(!empty($ranks) AND !empty($user['Profile']['ranks'])){
			$user_ranks = array_flip($user['Profile']['ranks']);
			$outputs = array_intersect_key($ranks, $user_ranks);
			return implode($fparams->get('ranks_separator', '<br />'), $outputs);
		}
		return '';
	}
	
	function username($user = array(), $avatar = true){
		$fparams = $this->view->vars['fparams'];
		$ranks = !empty($this->view->vars['ranks']) ? $this->_get_ranks_colors($this->view->vars['ranks']) : array();
		ob_start();
		?>
		<?php if(!empty($user['User']['id'])): ?>
			<?php
			$style = '';
			if(!empty($ranks) AND !empty($user['Profile']['ranks'])){
				$user_ranks = array_flip($user['Profile']['ranks']);
				$colors = array_intersect_key($ranks, $user_ranks);
				$style = ' style="color:'.array_pop($colors).'"';
			}
			?>
			<span class="cfu-username-box" data-ajax="<?php echo r_('index.php?option=com_chronoforums&cont=profiles&act=mini&u='.$user['User']['id'].'&tvout=ajax'); ?>">
			<?php if((bool)$fparams->get('link_usernames', 1)): ?>
				<a <?php echo $style; ?> href="<?php echo r_(\GCore\Libs\Str::replacer($fparams->get('username_link_path', ''), array('id' => $user['User']['id']))); ?>" class="cfu-username" title="<?php echo l_('CHRONOFORUMS_VIEW_PROFILE'); ?>">
			<?php endif; ?>
			<?php echo $user['User'][$fparams->get('display_name', 'username')]; ?>
			<?php if((bool)$fparams->get('link_usernames', 1)): ?>
				</a>
			<?php endif; ?>
			<?php if((bool)$fparams->get('usernames_avatars', 1) AND $avatar): ?>
				<?php echo $this->avatar($user, array('height' => 25, 'width' => 25, 'class' => '')); ?>
			<?php endif; ?>
			</span>
		<?php else: ?>
			<?php echo l_('CHRONOFORUMS_GUEST'); ?>
		<?php endif; ?>
		<?php
		$return = ob_get_clean();
		return $return;
	}
	
	function avatar($user = array(), $params = array()){
		$fparams = $this->view->vars['fparams'];
		$img_params = array_merge(array('class' => 'img-rounded center-block'), $params);
		if(empty($user['Profile']['params']['avatar'])){
			return '';	
		}
		$img_params['class'] = $img_params['class'].' cfu-avatar';
		//$img_params[':data-ajax'] = r_('index.php?option=com_chronoforums&cont=profiles&act=mini&tvout=ajax&img='.$user['Profile']['params']['avatar']);
		return \GCore\Helpers\Html::url(\GCore\Helpers\Html::image(r_('index.php?option=com_chronoforums&cont=profiles&act=avatar&img='.$user['Profile']['params']['avatar']), $img_params), r_(\GCore\Libs\Str::replacer($fparams->get('username_link_path', ''), array('id' => $user['User']['id']))));
	}
	
	function signature($user = array()){
		$fparams = $this->view->vars['fparams'];
		return $this->view->Bbcode->parse(htmlentities($user['Profile']['params']['signature']));
	}
	
	function post_count($user = array()){
		return is_null($user['Profile']['post_count']) ? l_('NA') : $user['Profile']['post_count'];
	}
	
	function join_date($user = array()){
		return $this->view->Output->date_time($user['User']['registerDate']);
	}
	
	function is_online($id = 0){
		$online_ids = !empty($this->view->vars['online_ids']) ? $this->view->vars['online_ids'] : false;
		if(is_array($online_ids) AND in_array($id, $online_ids)){
			return true;
		}
		return false;
	}
}
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
class PostTasks {
	var $view;

	function selected_answer_label($post = array(), $topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($post['Post'])):
			?>
			<?php if(!empty($topic['Answer']['post_id']) AND $topic['Answer']['post_id'] == $post['Post']['id']): ?>
			<span class="label label-success"><?php echo l_('CHRONOFORUMS_BEST_ANSWER'); ?></span>
			<?php endif; ?>
			<?php
		endif;
	}

	function reported_label($post = array(), $topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($post['Post'])):
			?>
			<?php if(!empty($post['Report'])): ?>
			<span class="label label-warning"><?php echo l_('CHRONOFORUMS_REPORTED'); ?></span>
			<?php endif; ?>
			<?php
		endif;
	}
	
	function votes_label($post = array(), $topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($post['Post'])):
			?>
			<?php if($fparams->get('enable_votes', 0) == 'post' AND !empty($post['Vote'][0]['votes_sum'])): ?>
			<?php
			$class = (int)$post['Vote'][0]['votes_sum'] > 0 ? 'label-success' : 'label-danger';
			$icon_class = (int)$post['Vote'][0]['votes_sum'] > 0 ? 'fa-thumbs-up' : 'fa-thumbs-down';
			?>
			<span class="label <?php echo $class; ?>"><i class="fa <?php echo $icon_class; ?> fa-lg"></i>&nbsp;<?php echo $post['Vote'][0]['votes_sum']; ?></span>
			<?php endif; ?>
			<?php
		endif;
	}
	
	function vote_link($post = array(), $topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($post['Post'])):
			?>
			<?php if($fparams->get('enable_votes', 0) == 'post' AND empty($post['VoteOwner']['post_id']) AND \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'make_votes', $post['Post']['user_id'])): ?>
			<span class="btn-group btn-group-xs">
			<?php if($fparams->get('enable_down_votes', 1)): ?>
			<a title="<?php echo l_('CHRONOFORUMS_VOTE_DOWN'); ?>" class="btn btn-default gcoreTooltip" href="<?php echo r_("index.php?option=com_chronoforums&cont=posts&act=vote&p=".$post['Post']['id']."&t=".$post['Post']['topic_id']."&f=".$post['Post']['forum_id']."&val=-1"); ?>"><i class="fa fa-thumbs-down fa-lg text-danger"></i></a>
			<?php endif; ?>
			<a title="<?php echo l_('CHRONOFORUMS_VOTE_UP'); ?>" class="btn btn-default gcoreTooltip" href="<?php echo r_("index.php?option=com_chronoforums&cont=posts&act=vote&p=".$post['Post']['id']."&t=".$post['Post']['topic_id']."&f=".$post['Post']['forum_id']."&val=1"); ?>"><i class="fa fa-thumbs-up fa-lg text-success"></i></a>
			</span>
			<?php endif; ?>
			<?php
		endif;
	}

	function select_answer_link($post = array(), $topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($post['Post'])):
			?>
			<?php if(empty($topic['Answer']['topic_id']) AND \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'select_answers', $topic['Topic']['user_id'])): ?>
			<a title="<?php echo l_('CHRONOFORUMS_SELECT_ANSWER'); ?>" class="btn btn-success gcoreTooltip" href="<?php echo r_("index.php?option=com_chronoforums&cont=posts&act=answer&p=".$post['Post']['id']."&t=".$post['Post']['topic_id']."&f=".$post['Post']['forum_id']); ?>"><i class="fa fa-check fa-lg"></i></a>
			<?php endif; ?>
			<?php
		endif;
	}

	function quote_link($post = array(), $topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($post['Post'])):
			?>
			<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'make_posts') AND (bool)$fparams->get('allow_quote_reply', 1) === true): ?>
			<a title="<?php echo l_('CHRONOFORUMS_REPLY_QUOTE'); ?>" class="btn btn-primary gcoreTooltip" href="<?php echo r_("index.php?option=com_chronoforums&cont=posts&act=reply_quote&p=".$post['Post']['id']."&t=".$post['Post']['topic_id']."&f=".$post['Post']['forum_id']); ?>"><i class="fa fa-quote-right fa-lg"></i><?php //echo l_('CHRONOFORUMS_QUOTE'); ?></a>
			<?php endif; ?>
			<?php
		endif;
	}

	function report_link($post = array(), $topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($post['Post'])):
			?>
			<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'report_posts')): ?>
			<a title="<?php echo l_('CHRONOFORUMS_REPORT'); ?>" class="btn btn-warning gcoreTooltip" href="<?php echo r_("index.php?option=com_chronoforums&cont=posts&act=report&p=".$post['Post']['id']."&t=".$post['Post']['topic_id']."&f=".$post['Post']['forum_id']); ?>"><i class="fa fa-warning fa-lg"></i><?php //echo l_('CHRONOFORUMS_REPORT'); ?></a>
			<?php endif; ?>
			<?php
		endif;
	}
	
	function publish_link($post = array(), $topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($post['Post'])):
			?>
			<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics')): ?>
			<a title="<?php echo l_('CHRONOFORUMS_PUBLISH'); ?>" class="btn btn-success gcoreTooltip" href="<?php echo r_("index.php?option=com_chronoforums&cont=posts&act=publish&p=".$post['Post']['id']."&t=".$post['Post']['topic_id']."&f=".$post['Post']['forum_id']); ?>"><i class="fa fa-plus-circle fa-lg"></i></a>
			<?php endif; ?>
			<?php
		endif;
	}
	
	function unpublish_link($post = array(), $topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($post['Post'])):
			?>
			<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics')): ?>
			<a title="<?php echo l_('CHRONOFORUMS_UNPUBLISH'); ?>" class="btn btn-danger gcoreTooltip" href="<?php echo r_("index.php?option=com_chronoforums&cont=posts&act=unpublish&p=".$post['Post']['id']."&t=".$post['Post']['topic_id']."&f=".$post['Post']['forum_id']); ?>"><i class="fa fa-minus-circle fa-lg"></i></a>
			<?php endif; ?>
			<?php
		endif;
	}

	function edit_link($post = array(), $topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($post['Post'])):
			?>
			<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'edit_posts', $post['PostAuthor']['id'])): ?>
			<a title="<?php echo l_('CHRONOFORUMS_EDIT'); ?>" class="btn btn-default gcoreTooltip" href="<?php echo r_("index.php?option=com_chronoforums&cont=posts&act=edit&p=".$post['Post']['id']."&t=".$post['Post']['topic_id']."&f=".$post['Post']['forum_id']); ?>"><i class="fa fa-pencil fa-lg"></i><?php //echo l_('CHRONOFORUMS_EDIT'); ?></a>
			<?php endif; ?>
			<?php
		endif;
	}

	function delete_link($post = array(), $topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($post['Post'])):
			?>
			<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'delete_posts', $post['PostAuthor']['id'])): ?>
			<a title="<?php echo l_('CHRONOFORUMS_DELETE'); ?>" class="btn btn-danger gcoreTooltip" href="<?php echo r_("index.php?option=com_chronoforums&cont=posts&act=delete&p=".$post['Post']['id']."&t=".$post['Post']['topic_id']."&f=".$post['Post']['forum_id']); ?>"><i class="fa fa-trash-o fa-lg"></i><?php //echo l_('CHRONOFORUMS_DELETE'); ?></a>
			<?php endif; ?>
			<?php
		endif;
	}

	function delete_author_link($post = array(), $topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($post['Post']) AND !empty($post['PostAuthor']['id'])):
			?>
			<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') AND (bool)$fparams->get('allow_author_delete', 1) === true): ?>
				<a title="<?php echo l_('CHRONOFORUMS_DELETE_AUTHOR'); ?>" class="btn btn-danger gcoreTooltip" href="<?php echo r_("index.php?option=com_chronoforums&cont=topics&act=delete_author&p=".$post['Post']['id']."&u=".$post['PostAuthor']['id']."&f=".$post['Post']['forum_id']."&t=".$post['Post']['topic_id']); ?>"><i class="fa fa fa-user fa-lg text-default"></i><?php //echo l_('CHRONOFORUMS_DELETE_AUTHOR'); ?></a>
			<?php endif; ?>
			<?php
		endif;
	}

	function content($post = array()){
		$fparams = $this->view->vars['fparams'];
		$inline_attachments_keys = array();
		//remove the inline files
		preg_match_all('/\[attachment=(.*?)](.*?)\[\/attachment\]/ms', $post['Post']['text'], $inline_files);
		if(isset($inline_files[1]) AND !empty($inline_files[1]) AND is_array($inline_files[1])){
			$inline_attachments_keys = $inline_files[1];
		}

		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'list_attachments')){
			$inline_img_class = $fparams->get('inline_images_display', 0) == 1 ? 'gcore_magnified' : '';
			$inline_img_fn = $fparams->get('inline_images_display', 0) == 1 ? '' : $fparams->get('inline_images_display', 0) == 0 ? 'viewableArea(this);' : 'viewableModal(this);';
			if(!empty($post['Attachment'])){
				$inline_extensions = $fparams->get('inline_extensions', 'jpg-png-gif');
				$inline_extensions = explode('-', $inline_extensions);
				foreach($post['Attachment'] as $k => $attach){
					$post['Attachment'][$k]['size'] = '('.round(((int)$post['Attachment'][$k]['size'])/1024, 2).' KiB)';
					$post['Attachment'][$k]['link'] = r_('index.php?option=com_chronoforums&cont=attachments&act=download&file_id='.$post['Attachment'][$k]['id']);

					$ext = pathinfo($post['Attachment'][$k]['filename'], PATHINFO_EXTENSION);
					if(in_array(strtolower($ext), $inline_extensions) AND \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'download_attachments')){
						$post['Attachment'][$k]['inline_output'] = '<div class="cfu-inline-attachment"><dl class="cfu-file"><dt class="cfu-attach-image"><img class="'.$inline_img_class.'" id="cfu-attachment-'.$post['Attachment'][$k]['id'].'" onclick="'.$inline_img_fn.'" alt="'.$post['Attachment'][$k]['filename'].'" src="'.$post['Attachment'][$k]['link'].'"></dt><dd><em>'.$post['Attachment'][$k]['comment'].'</em></dd><dd>'.$post['Attachment'][$k]['filename'].' '.$post['Attachment'][$k]['size'].' '.l_('CHRONOFORUMS_VIEWED').' '.$post['Attachment'][$k]['downloads'].' '.l_('CHRONOFORUMS_TIMES').'.</dd></dl></div>';
						$post['Attachment'][$k]['output'] = '<dl class="cfu-file"><dt class="cfu-attach-image"><img class="'.$inline_img_class.'" id="cfu-attachment-'.$post['Attachment'][$k]['id'].'" onclick="'.$inline_img_fn.'" alt="'.$post['Attachment'][$k]['filename'].'" src="'.$post['Attachment'][$k]['link'].'"></dt><dd><em>'.$post['Attachment'][$k]['comment'].'</em></dd><dd>'.$post['Attachment'][$k]['filename'].' '.$post['Attachment'][$k]['size'].' '.l_('CHRONOFORUMS_VIEWED').' '.$post['Attachment'][$k]['downloads'].' '.l_('CHRONOFORUMS_TIMES').'.</dd></dl>';
					}else{
						$post['Attachment'][$k]['inline_output'] = '<div class="cfu-inline-attachment"><dl class="cfu-file"><dt><i title="" class="gcoreTooltip fa fa-fw fa-paperclip" data-original-title="Attachment"></i><a class="cfu-link" href="'.$post['Attachment'][$k]['link'].'">'.$post['Attachment'][$k]['filename'].'</a></dt><dd><em>'.$post['Attachment'][$k]['comment'].'</em></dd><dd>'.$post['Attachment'][$k]['size'].' '.l_('CHRONOFORUMS_DOWNLOADED').' '.$post['Attachment'][$k]['downloads'].' '.l_('CHRONOFORUMS_TIMES').'.</dd></dl></div>';
						$post['Attachment'][$k]['output'] = '<dl class="cfu-file"><dt><i title="" class="gcoreTooltip fa fa-fw fa-paperclip" data-original-title="Attachment"></i><a class="cfu-link" href="'.$post['Attachment'][$k]['link'].'">'.$post['Attachment'][$k]['filename'].'</a></dt><dd><em>'.$post['Attachment'][$k]['comment'].'</em></dd><dd>'.$post['Attachment'][$k]['size'].' '.l_('CHRONOFORUMS_DOWNLOADED').' '.$post['Attachment'][$k]['downloads'].' '.l_('CHRONOFORUMS_TIMES').'.</dd></dl>';
					}
				}
			}
		}
		$content = $this->view->Bbcode->parse($post['Post']['text']);
		if(!empty($inline_attachments_keys)){
			foreach($inline_attachments_keys as $r_k => $at_k){
				if(!empty($post['Attachment'][$at_k]['inline_output'])){
					$content = str_replace($inline_files[0][$r_k], htmlspecialchars_decode($post['Attachment'][$at_k]['inline_output']), $content);
				}else{
					$content = str_replace($inline_files[0][$r_k], '', $content);
				}
			}
		}

		$attachments = array();
		if(!empty($post['Attachment']) AND \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'list_attachments')){
			foreach($post['Attachment'] as $k => $attach){
				if(!in_array($k, $inline_attachments_keys)){
					$attachments[] = $post['Attachment'][$k]['output'];
				}
			}
		}

		return array($content, $attachments);
	}

	function search_form($topic = array()){
		?>
		<form action="<?php echo r_('index.php?option=com_chronoforums&cont=posts&f='.$topic['Forum']['id'].'&t='.$topic['Topic']['id']); ?>" method="post" name="searchform">
			<div class="input-group input-group-sm">
				<input type="hidden" name="t" value="<?php echo $topic['Topic']['id']; ?>"/>
				<input type="text" class="form-control" value="" size="20" id="cfu-search_keywords" name="keywords" placeholder="<?php echo l_('CHRONOFORUMS_SEARCH_TOPIC'); ?>..." />
				<span class="input-group-btn">
					<button class="btn btn-default" name="search_posts" type="submit" value=""><i class="fa fa-search"></i></button>
					<button class="btn btn-default reset" name="reset" type="submit" value=""><i class="fa fa-times"></i></button>
				</span>
			</div>
		</form>
		<?php
	}

	function reports_list($post = array()){
		$fparams = $this->view->vars['fparams'];
		?>
		<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'view_reports')): ?>
			<?php if(!empty($post['Report'])): ?>
				<div class="alert alert-danger cfu-post-report">
					<?php foreach($post['Report'] as $k => $report): ?>
					<?php echo l_('CHRONOFORUMS_BY'); ?> <strong><?php echo $this->view->UserTasks->username(array('User' => $post['ReportAuthor'][$k], 'Profile' => $post['ReportAuthorProfile'][$k])); ?></strong><?php echo " &#187; "; ?><?php echo $this->view->Output->date_time($report['created']); ?>
					<br />
					<?php echo $report['reason']; ?>
					<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') === true): ?>
					<br />
					<a href="<?php echo r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Post']['topic_id'].'&act=unreport&report_id='.$report['id']); ?>" class="btn btn-danger btn-xs"><?php echo l_('CHRONOFORUMS_DELETE'); ?></a>
					<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php
	}

	function title($post = array(), $topic = array()){
		$fparams = $this->view->vars['fparams'];
		$alias = isset($topic['Topic']['alias']) ? $topic['Topic']['alias'] : $post['Topic']['alias'];
		?>
		<a class="cfu-post-title" href="<?php echo r_('index.php?option=com_chronoforums&cont=posts&p='.$post['Post']['id'].'&t='.$post['Post']['topic_id'].'&alias='.$alias.'#p'.$post['Post']['id']); ?>"><?php echo strip_tags($post['Post']['subject']); ?></a>
		<?php
	}
}
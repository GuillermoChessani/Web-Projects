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
class TopicTasks {
	var $view;

	function tasks_list($topic = array()){
		//echo '<form action="'.r_('index.php?option=com_chronoforums&cont=topics').'" method="post" name="searchform">';
		echo '<span class="input-group-addon">'.l_('CHRONOFORUMS_QUICK_TASKS').'</span>';
		$options = array(
			'' => ' - ',
			'move' => l_('CHRONOFORUMS_MOVE_TOPIC'),
			'delete' => l_('CHRONOFORUMS_DELETE_TOPIC'),
			//'delete_author' => l_('CHRONOFORUMS_DELETE_AUTHOR'),
		);

		if((bool)$this->view->vars['fparams']->get('allow_author_delete', 1) === true){
			$options['delete_author'] = l_('CHRONOFORUMS_DELETE_AUTHOR');
		}

		if(empty($topic['locked'])){
			$options['lock'] = l_('CHRONOFORUMS_LOCK_TOPIC');
		}
		if(!empty($topic['locked']) OR empty($topic)){
			$options['unlock'] = l_('CHRONOFORUMS_UNLOCK_TOPIC');
		}
		if(empty($topic['announce'])){
			$options['announce'] = l_('CHRONOFORUMS_SET_ANNOUNCEMENT');
		}
		if(!empty($topic['announce']) OR empty($topic)){
			$options['unannounce'] = l_('CHRONOFORUMS_UNSET_ANNOUNCEMENT');
		}
		if(empty($topic['sticky'])){
			$options['sticky'] = l_('CHRONOFORUMS_SET_STICKY');
		}
		if(!empty($topic['sticky']) OR empty($topic)){
			$options['unsticky'] = l_('CHRONOFORUMS_UNSET_STICKY');
		}

		if(empty($topic['published'])){
			$options['publish'] = l_('CHRONOFORUMS_PUBLISH_TOPIC');
		}
		if(!empty($topic['published']) OR empty($topic)){
			$options['unpublish'] = l_('CHRONOFORUMS_UNPUBLISH_TOPIC');
		}

		echo \GCore\Helpers\Html::input('act', array('type' => 'dropdown', 'label' => '', 'class' => 'form-control', 'options' => $options));
		echo \GCore\Helpers\Html::input('f', array('type' => 'hidden', 'value' => isset($topic['forum_id']) ? $topic['forum_id'] : ''));
		echo \GCore\Helpers\Html::input('t', array('type' => 'hidden', 'value' => isset($topic['id']) ? $topic['id'] : ''));
		echo '<span class="input-group-btn">';
		echo '<input type="submit" name="topic_tasks_process" class="btn btn-warning" value="'.l_('CHRONOFORUMS_GO').'">';
		echo '</span>';
		//echo '</form>';
	}

	function tasks_form($topic = array()){
		if(!is_null($topic) AND \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics')){
			echo '<form action="'.r_('index.php?option=com_chronoforums&cont=topics').'" method="post" name="topictasksform" class="form-inline">';
			echo '<div class="input-group input-group-sm">';
			$this->tasks_list(!empty($topic['Topic']) ? $topic['Topic'] : array());
			echo '</div>';
			echo '</form>';
		}
	}

	function tags_input($topic = array(), $tags = array()){
		if(!empty($tags)){
			//$options = array('' => '');
			foreach($tags as $tag){
				$options[$tag['Tag']['id']] = $tag['Tag']['title'];
			}
			//$values = \GCore\Libs\Arr::getVal($topic, array('Tag', '[n]', 'id'), array());
			$values = array();
			if(!empty($topic['Tag'])){
				foreach($topic['Tag'] as $k => $tag){
					$values[] = array('id' => $tag['id'], 'text' => $tag['title']);	
				}
			}
			$doc = \GCore\Libs\Document::getInstance();
			/*$doc->addJsFile(\GCore\C::get('GCORE_FRONT_URL').'extensions/chronoforums/assets/chosen/chosen.jquery.min.js');
			$doc->addCssFile(\GCore\C::get('GCORE_FRONT_URL').'extensions/chronoforums/assets/chosen/chosen.min.css');
			$doc->addJsCode('
				jQuery(document).ready(function($){
					$("#topic_tags").chosen({no_results_text:"'.l_('CHRONOFORUMS_TAGS_NO_RESULTS').'"});
				});
			');*/
			$doc->_('select2');
			$doc->addJsCode('jQuery(document).ready(function($){ $("#topic_tags").select2(
				{
					minimumInputLength: 1,
					containerCss:{"max-width":"200px"},
					//width: "resolve",
					multiple: true,
					tags: true,
					tokenSeparators: [","," "],
					ajax:{
						url: "'.r_('index.php?option=com_chronoforums&cont=topics&act=tags_lookup&tvout=ajax').'",
						dataType: "json",
						data: function (term, page){
							return {
								tag_q: term,
							};
						},
						results: function (data, page){
							return {results: data};
						}
					},
					initSelection: function(element, callback){
						var data = '.json_encode($values).';
						callback(data);
					}
				}
			);
			$("#topic_tags").select2("data", '.json_encode($values).');
			});');
			//echo \GCore\Helpers\Html::formStart('cfu-topic-tags');
			//echo \GCore\Helpers\Html::formSecStart();
			//echo \GCore\Helpers\Html::input('topic_tags[]', array('type' => 'dropdown', ':data-placeholder' => l_('CHRONOFORUMS_TOPIC_TAGS'), 'id' => 'topic_tags', 'multiple' => 'multiple', 'options' => $options, 'values' => $values, 'class' => 'form-control'));
			echo \GCore\Helpers\Html::input('topic_tags', array('type' => 'hidden', ':data-placeholder' => l_('CHRONOFORUMS_TOPIC_TAGS'), 'id' => 'topic_tags', 'multiple' => 'multiple', 'value' => ''));
			echo \GCore\Helpers\Html::input('act', array('type' => 'hidden', 'value' => 'tag_topic'));
			echo \GCore\Helpers\Html::input('f', array('type' => 'hidden', 'value' => isset($topic['Topic']['forum_id']) ? $topic['Topic']['forum_id'] : ''));
			echo \GCore\Helpers\Html::input('t', array('type' => 'hidden', 'value' => isset($topic['Topic']['id']) ? $topic['Topic']['id'] : ''));
			echo '<span class="input-group-btn">';
			echo '<input type="submit" name="topic_tasks_process" class="btn btn-warning btn-sm" value="'.l_('CHRONOFORUMS_UPDATE_TAGS').'">';
			echo '</span>';
			//echo \GCore\Helpers\Html::formSecEnd();
			//echo \GCore\Helpers\Html::formEnd();
		}
	}

	function tags_form($topic = array(), $tags = array()){
		$fparams = $this->view->vars['fparams'];
		if((((bool)$fparams->get('enable_topic_tags', 0) === true) OR ($fparams->get('search_method', 'deep') == 'tags')) AND \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics')):
		?>
		<form action="<?php echo r_('index.php?option=com_chronoforums&cont=topics'); ?>" method="post" name="topictagsform">
			<div class="input-group input-group-sm1 text-right">
				<?php $this->tags_input($topic, $tags); ?>
			</div>
		</form>
		<?php
		endif;
	}

	function tags_list($topic = array()){
		if(!empty($topic['Tag'])){
			$tags = \GCore\Libs\Arr::getVal($topic, array('Tag', '[n]', 'title'), array());
			foreach($tags as $tag){
				echo '<a class="cfu-tag cfu-tag-'.$tag.' btn btn-info btn-xs" href="'.r_('index.php?option=com_chronoforums&cont=forums&skeywords='.$tag).'"><span class=""><i class="fa fa-tag fa-lg fa-fw"></i>'.$tag.'</span></a>';
			}
		}
	}
	
	function quick_reply(){
		$fparams = $this->view->vars['fparams'];
		if($fparams->get('enable_quick_reply', 0) AND \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'make_posts') === true):
		$doc = \GCore\Libs\Document::getInstance();
		$doc->addJsCode("
			var bbcode_area_id = 'quick_reply';
			var bbcode = new Array();
			var bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[quote]','[/quote]','[code]','[/code]','[list]','[/list]','[list=]','[/list]','[img]','[/img]','[url]','[/url]','[flash=]', '[/flash]','[size=]','[/size]');
		");
		$doc->addJsFile(\GCore\C::get('GCORE_FRONT_URL').'extensions/chronoforums/assets/js/editor.js');
		
		$doc->_('jquery');
		$doc->addJsCode('
			function preview_quick_reply(){
				jQuery.ajax({
					"type" : "POST",
					"url" : "'.r_('index.php?option=com_chronoforums&cont=posts&tvout=ajax&act=bbcode_preview').'",
					"data" : jQuery("#quick_reply_form").serialize(),
					beforeSend: function(){
						jQuery("#quick_reply_preview").empty();
						jQuery("#quick_reply_preview").append("<img src=\"'.\GCore\Helpers\Assets::image('loading.gif').'\" border=\"0\" />");
						jQuery("#quick_reply_preview").css("display", "block");
					},
					"success" : function(res){
						jQuery("#quick_reply_preview").empty();
						jQuery("#quick_reply_preview").append(res);
					},
				});
			}
		');
		
		?>
		<form action="<?php echo r_('index.php?option=com_chronoforums&cont=posts&act=reply'); ?>" method="post" name="quick_reply_form" id="quick_reply_form">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title pull-left"><?php echo l_('CHRONOFORUMS_QUICK_REPLY'); ?></h3>
					<span class="pull-right">
						<a class="btn btn-xs btn-default" onclick="insert_text(':D', true); return false;" href="#"><img width="15" height="17" title="Very Happy" alt=":D" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_biggrin.gif"></a>
						<a class="btn btn-xs btn-default" onclick="insert_text(':)', true); return false;" href="#"><img width="15" height="17" title="Smile" alt=":)" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_smile.gif"></a>
						<a class="btn btn-xs btn-default" onclick="insert_text(';)', true); return false;" href="#"><img width="15" height="17" title="Wink" alt=";)" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_wink.gif"></a>
						<a class="btn btn-xs btn-default" onclick="insert_text(':(', true); return false;" href="#"><img width="15" height="17" title="Sad" alt=":(" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_sad.gif"></a>
						<a class="btn btn-xs btn-default" onclick="insert_text(':o', true); return false;" href="#"><img width="15" height="17" title="Surprised" alt=":o" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_surprised.gif"></a>
						<a class="btn btn-xs btn-default" onclick="insert_text(':shock:', true); return false;" href="#"><img width="15" height="17" title="Shocked" alt=":shock:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_eek.gif"></a>
						<a class="btn btn-xs btn-default" onclick="insert_text(':?', true); return false;" href="#"><img width="15" height="17" title="Confused" alt=":?" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_confused.gif"></a>
						<a class="btn btn-xs btn-default" onclick="insert_text('8-)', true); return false;" href="#"><img width="15" height="17" title="Cool" alt="8-)" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_cool.gif"></a>
						
						<a title="<?php echo l_('CHRONOFORUMS_BOLD_TEXT'); ?>: [b]text[/b]" onclick="bbstyle(0); return false;" name="addbbcode0" accesskey="b" class="btn btn-default btn-sm"><i class="fa fa-bold fa-fw fa-lg"></i></a>
						<a title="<?php echo l_('CHRONOFORUMS_ITALIC_TEXT'); ?>: [i]text[/i]" onclick="bbstyle(2); return false;" name="addbbcode2" accesskey="i" class="btn btn-default btn-sm"><i class="fa fa-italic fa-fw fa-lg"></i></a>
						<a title="<?php echo l_('CHRONOFORUMS_UNDERLINE_TEXT'); ?>: [u]text[/u]" onclick="bbstyle(4); return false;" name="addbbcode4" accesskey="u" class="btn btn-default btn-sm"><i class="fa fa-underline fa-fw fa-lg"></i></a>
						<a title="<?php echo l_('CHRONOFORUMS_QUOTE_TEXT'); ?>: [quote]text[/quote]" onclick="bbstyle(6); return false;" name="addbbcode6" accesskey="q" class="btn btn-default btn-sm"><i class="fa fa-quote-left fa-fw fa-lg"></i></a>
						<a title="<?php echo l_('CHRONOFORUMS_CODE_DISPLAY'); ?>: [code]code[/code]" onclick="bbstyle(8); return false;" name="addbbcode8" accesskey="c" class="btn btn-default btn-sm"><i class="fa fa-code fa-fw fa-lg"></i></a>
						<a title="<?php echo l_('CHRONOFORUMS_INSERT_URL'); ?>: [url]http://url[/url] or [url=http://url]URL text[/url]" onclick="bbstyle(16); return false;" name="addbbcode16" accesskey="w" class="btn btn-default btn-sm"><i class="fa fa-link fa-fw fa-lg"></i></a>
						
					</span>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<?php echo \GCore\Helpers\Html::input('Post[text]', array('type' => 'textarea', 'id' => 'quick_reply', 'class' => 'F', 'rows' => 5, 'cols' => 60, 'style' => 'width:100% !important;')); ?>
					<div id="quick_reply_preview" class="well" style="display:none;"></div>
				</div>
				<div class="panel-footer text-center">
					<?php echo \GCore\Helpers\Html::input('quick_reply_submit', array('type' => 'submit', 'value' => l_('CHRONOFORUMS_SUBMIT'), 'class' => 'btn btn-success btn-sm')); ?>
					<?php echo \GCore\Helpers\Html::input('quick_reply_preview', array('type' => 'button', 'value' => l_('CHRONOFORUMS_PREVIEW'), 'onclick' => 'preview_quick_reply();', 'class' => 'btn btn-info btn-sm')); ?>
				</div>
			</div>
			<?php echo \GCore\Helpers\Html::input('f', array('type' => 'hidden', 'value' => \GCore\Libs\Request::data('f'))); ?>
			<?php echo \GCore\Helpers\Html::input('t', array('type' => 'hidden', 'value' => \GCore\Libs\Request::data('t'))); ?>
		</form>
		<?php
		endif;
	}

	function no_posts(){
		?>
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo l_('CHRONOFORUMS_INFORMATION'); ?></h3>
			</div>
			<div class="panel-body">
				<?php if(isset($this->view->vars['offline_message'])): ?>
				<p><?php echo $this->view->vars['offline_message']; ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	function no_topics(){
		?>
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo l_('CHRONOFORUMS_INFORMATION'); ?></h3>
			</div>
			<div class="panel-body">
				<?php if(isset($this->view->vars['offline_message'])): ?>
				<p><?php echo $this->view->vars['offline_message']; ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	function reply_button($topic = array()){
		$fparams = $this->view->vars['fparams'];
		?>
		<?php if(empty($topic['Topic']['locked'])): ?>
			<?php if((bool)$fparams->get('hide_post_reply_button', 0) === false OR \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'make_posts') === true): ?>
				<a title="<?php echo l_('CHRONOFORUMS_POST_REPLY'); ?>" class="btn btn-primary btn-sm" href="<?php echo r_('index.php?option=com_chronoforums&cont=posts&act=reply&f='.$topic['Forum']['id'].'&t='.$topic['Topic']['id']); ?>"><i class="fa fa-fw fa-reply"></i> <?php echo l_('CHRONOFORUMS_REPLY'); ?></a>
			<?php endif; ?>
		<?php endif; ?>
		<?php
	}

	function new_topic_button($forum = array()){
		$fparams = $this->view->vars['fparams'];
		?>
		<?php if((bool)$fparams->get('hide_new_topic_button', 0) === false OR \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'make_topics') === true): ?>
			<a class="btn btn-primary btn-sm" href="<?php echo r_('index.php?option=com_chronoforums&cont=topics&act=add'.(!empty($forum['Forum']['id']) ? '&f='.$forum['Forum']['id'] : '')); ?>"><?php echo l_('CHRONOFORUMS_NEW_TOPIC'); ?></a>
		<?php endif; ?>
		<?php
	}
	
	function favorite_button($topic = array()){
		$user = \GCore\Libs\Base::getUser();
		$fparams = $this->view->vars['fparams'];
		if((bool)$fparams->get('enable_topics_favorites', 0) AND !empty($user['id'])):
		$class = ' fa-star-o';
		$title = l_('CHRONOFORUMS_ADD_TO_FAVORITES');
		$act = 'favorite';
		if(!empty($topic['Favorite']['topic_id'])){
			$class = ' fa-star cfu-favorited';
			$title = l_('CHRONOFORUMS_REMOVE_FROM_FAVORITES');
			$act = 'unfavorite';
		}
		?>
		<a title="<?php echo $title; ?>" class="btn btn-default btn-xs gcoreTooltip" href="<?php echo r_('index.php?option=com_chronoforums&cont=topics&act='.$act.'&f='.$topic['Forum']['id'].'&t='.$topic['Topic']['id']); ?>"><i class="fa fa-fw fa-2x<?php echo $class; ?>"></i></a>
		<?php
		endif;
	}
	
	function feature_button($topic = array()){
		$user = \GCore\Libs\Base::getUser();
		$fparams = $this->view->vars['fparams'];
		if((bool)$fparams->get('enable_topics_featured', 0) AND \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'feature_topics') === true):
		$class = ' fa-bookmark-o';
		$title = l_('CHRONOFORUMS_ADD_TO_FEATURED');
		$act = 'feature';
		if(!empty($topic['Featured']['topic_id'])){
			$class = ' fa-bookmark cfu-featured';
			$title = l_('CHRONOFORUMS_REMOVE_FROM_FEATURED');
			$act = 'unfeature';
		}
		?>
		<a title="<?php echo $title; ?>" class="btn btn-default btn-xs gcoreTooltip" href="<?php echo r_('index.php?option=com_chronoforums&cont=topics&act='.$act.'&f='.$topic['Forum']['id'].'&t='.$topic['Topic']['id']); ?>"><i class="fa fa-fw fa-2x<?php echo $class; ?>"></i></a>
		<?php
		endif;
	}

	function forum_title($forum = array()){
		?>
		<a class="cfu-title" href="<?php echo r_('index.php?option=com_chronoforums&cont=forums&f='.$forum['Forum']['id'].'&alias='.$forum['Forum']['alias']); ?>"><?php echo $forum['Forum']['title']; ?></a>
		<?php
	}

	function search_title(){
		$searched = !empty($this->view->vars['searched']) ? $this->view->vars['searched'] : '';
		$forum = !empty($this->view->vars['forum']) ? $this->view->vars['forum'] : array();
		$fparams = $this->view->vars['fparams'];
		$url = r_('index.php?option=com_chronoforums&cont=forums'.(!empty($forum) ? '&f='.$forum['Forum']['id'] : ''));
		if(\GCore\Libs\Request::data('search_age')){
			$search_age = \GCore\Libs\Request::data('search_age');
		}else{
			$search_age = $fparams->get('search_start_from_value', '1y');
		}
		if(!empty($forum)){
			$url = \GCore\Libs\Url::buildQuery($url, array('keywords' => $searched, 'page' => 1));
		}else{
			$url = \GCore\Libs\Url::buildQuery($url, array('skeywords' => $searched, 'search_age' => $search_age, 'page' => 1));
		}
		?>
		<?php echo sprintf(l_('CHRONOFORUMS_SEARCH_FOUND'), $this->view->Paginator->total); ?> <a class="cfu-title" href="<?php echo $url; ?>"><?php echo $searched; ?></a>
		<?php
	}

	function paginator($type = ''){
		$this->view->Paginator->bs();
		?>
		<?php if($type == 'info' OR empty($type)): ?>
		<div class="cfu-info pull-right">
			<?php echo $this->view->Paginator->getInfo(array('PAGINATOR_INFO' => l_('CHRONOFORUMS_PAGINATOR_INFO'))); ?>
		</div>
		<?php endif; ?>
		<?php if($type == 'data' OR empty($type)): ?>
			<?php echo $this->view->Paginator->getNav(array('PAGINATOR_PREV' => l_('CHRONOFORUMS_PAGINATOR_PREV'), 'PAGINATOR_FIRST' => l_('CHRONOFORUMS_PAGINATOR_FIRST'), 'PAGINATOR_LAST' => l_('CHRONOFORUMS_PAGINATOR_LAST'), 'PAGINATOR_NEXT' => l_('CHRONOFORUMS_PAGINATOR_NEXT'))); ?>
		<?php endif; ?>
		<?php
	}

	function search_form($forum = array()){
		?>
		<form action="<?php echo r_('index.php?option=com_chronoforums&cont=forums&f='.$forum['Forum']['id']); ?>" method="post" name="searchform">
			<div class="input-group input-group-sm">
				<input type="hidden" name="f" value="<?php echo $forum['Forum']['id']; ?>"/>
				<input type="text" class="form-control" value="" size="20" id="cfu-search_keywords" name="keywords" placeholder="<?php echo l_('CHRONOFORUMS_SEARCH_FORUM'); ?>..." />
				<span class="input-group-btn">
					<button class="btn btn-default" name="search_posts" type="submit" value=""><i class="fa fa-search"></i></button>
					<button class="btn btn-default reset" name="reset" type="submit" value=""><i class="fa fa-times"></i></button>
				</span>
			</div>
		</form>
		<?php
	}

	function attachments_icon($topic = array()){
		$fparams = $this->view->vars['fparams'];
		?>
		<?php if(!empty($topic['Topic']['has_attachments'])): ?>
		<i class="gcoreTooltip fa fa-paperclip" title="<?php echo l_('CHRONOFORUMS_HAS_ATTACHMENTS'); ?>"></i>
		<?php endif; ?>
		<?php
	}
	
	function datetime_icon($topic = array()){
		$fparams = $this->view->vars['fparams'];
		?>
		<i class="gcoreTooltip fa fa-calendar" title="<?php echo $this->view->Output->date_time($topic['Topic']['created']); ?>"></i>
		<?php
	}

	function row_title($topic = array()){
		$searched = !empty($this->view->vars['searched']) ? $this->view->vars['searched'] : '';
		$read = $this->is_topic_read($topic);
		echo $this->read_status($topic, $read);
		$class = ' cfu-unread';
		if($read === true){
			$class = ' cfu-read';
		}
		$url = r_('index.php?option=com_chronoforums&cont=posts&f='.$topic['Topic']['forum_id'].'&t='.$topic['Topic']['id'].'&alias='.$topic['Topic']['alias']);
		if(!empty($searched)){
			$url = \GCore\Libs\Url::buildQuery($url, array('hilit' => $searched));
		}
		?>
		<a href="<?php echo $url; ?>" class="cfu-title<?php echo $class; ?>"><?php echo strip_tags($topic['Topic']['title']); ?></a>
		<?php
	}
	
	function is_topic_read($topic = array()){
		$user = \GCore\Libs\Base::getUser();
		$fparams = $this->view->vars['fparams'];
		$uprofile = $this->view->vars['uprofile'];
		$read = null;
		//track topic read status
		if($uprofile->get('Profile.params.preferences.enable_topics_track', 0)){
			if(!empty($user['id']) AND (bool)$fparams->get('enable_topics_track', 0) === true){
				$read = false;
				if(!empty($topic['TopicTrack']['last_visit'])){
					$read = true;
					if(!empty($topic['LastPost']['created']) AND $topic['LastPost']['created'] > $topic['TopicTrack']['last_visit']){
						$read = false;
					}
				}else{
					if(!empty($topic['LastPost']['user_id']) AND $topic['LastPost']['user_id'] == $user['id']){
						$read = true;
					}
				}
			}
		}
		return $read;
	}
	
	function read_status($topic = array(), $read = null){
		if(is_null($read)){
			return '';//$read = $this->is_topic_read($topic);
		}
		if($read){
			return '<i class="fa fa-folder-open-o gcoreTooltip" title="'.l_('CHRONOFORUMS_NO_NEW_POSTS').'"></i>';
		}else{
			return '<i class="fa fa-folder-o gcoreTooltip" title="'.l_('CHRONOFORUMS_HAS_NEW_POSTS').'"></i>';
		}
	}

	function topic_title($topic = array()){
		?>
		<a class="cfu-title" href="<?php echo r_('index.php?option=com_chronoforums&cont=posts&f='.$topic['Forum']['id'].'&t='.$topic['Topic']['id'].'&alias='.$topic['Topic']['alias']); ?>"><?php echo strip_tags($topic['Topic']['title']); ?></a>
		<?php
	}

	function selector($topic = array()){
		echo $this->view->Html->input('topics_ids['.$topic['Topic']['id'].']', array('type' => 'checkbox', 'value' => 1));
	}

	function topic_category($topic = array()){
		?>
		<a class="cfu-category-title" href="<?php echo r_('index.php?option=com_chronoforums&c='.$topic['Category']['id']); ?>"><?php echo $topic['Category']['title']; ?></a>
		<?php
	}

	function topic_forum($topic = array()){
		?>
		<a class="cfu-forum-title" href="<?php echo r_('index.php?option=com_chronoforums&cont=forums&f='.$topic['Forum']['id'].'&alias='.$topic['Forum']['alias']); ?>"><?php echo $topic['Forum']['title']; ?></a>
		<?php
	}

	function status($topic = array()){
		$fparams = $this->view->vars['fparams'];
		$days = (time() - strtotime($topic['Topic']['created']))/(24*60*60);
		?>
		
		<?php if($fparams->get('enable_votes', 0) AND !empty($topic['Vote'][0]['votes_sum'])): ?>
		<?php
		$class = (int)$topic['Vote'][0]['votes_sum'] > 0 ? 'label-success' : 'label-danger';
		$icon_class = (int)$topic['Vote'][0]['votes_sum'] > 0 ? 'fa-thumbs-up' : 'fa-thumbs-down';
		?>
		<span class="label <?php echo $class; ?>"><i class="fa <?php echo $icon_class; ?> fa-lg"></i>&nbsp;<?php echo $topic['Vote'][0]['votes_sum']; ?></span>
		<?php endif; ?>

		<?php if(!empty($topic['Topic']['announce'])): ?>
		<span class="label label-primary"><i class="fa fa-bell-o fa-lg"></i>&nbsp;<?php echo l_('CHRONOFORUMS_ANNOUNCEMENT'); ?></span>
		<?php endif; ?>

		<?php if(!empty($topic['Topic']['locked'])): ?>
		<span class="label label-default" style="background-color:#024959;"><i class="fa fa-lock fa-lg"></i>&nbsp;<?php echo l_('CHRONOFORUMS_LOCKED'); ?></span>
		<?php endif; ?>

		<?php if(!empty($topic['Topic']['sticky'])): ?>
		<span class="label label-default" style="background-color:#A901DB;"><i class="fa fa-map-marker fa-lg"></i>&nbsp;<?php echo l_('CHRONOFORUMS_STICKY'); ?></span>
		<?php endif; ?>

		<?php if(empty($topic['Topic']['published'])): ?>
		<span class="label label-danger"><i class="fa fa-times fa-lg"></i>&nbsp;<?php echo l_('CHRONOFORUMS_UNPUBLISHED'); ?></span>
		<?php endif; ?>

		<?php if(!empty($topic['Answer']['topic_id'])): ?>
		<span class="label label-success"><i class="fa fa-check fa-lg"></i>&nbsp;<?php echo l_('CHRONOFORUMS_ANSWERED'); ?></span>
		<?php endif; ?>
		
		<?php if(!empty($topic['Topic']['hits']) AND $topic['Topic']['hits'] >= $fparams->get('topic_popular_limit', 30) AND $topic['Topic']['hits']/$days >= $fparams->get('topic_popular_limit', 30)): ?>
		<span class="label label-default" style="background-color:#F24C27;"><i class="fa fa-heart-o fa-lg"></i>&nbsp;<?php echo l_('CHRONOFORUMS_POPULAR'); ?></span>
		<?php endif; ?>

		<?php if(!empty($topic['Topic']['post_count']) AND $topic['Topic']['post_count']/$days >= $fparams->get('topic_hot_limit', 5)): ?>
		<span class="label label-default" style="background-color:#d70553;"><i class="fa fa-coffee fa-lg"></i>&nbsp;<?php echo l_('CHRONOFORUMS_HOT'); ?></span>
		<?php endif; ?>

		<?php if(!empty($topic['Topic']['reported'])): ?>
		<span class="label label-warning"><i class="fa fa-warning fa-lg"></i>&nbsp;<?php echo l_('CHRONOFORUMS_REPORTED'); ?></span>
		<?php endif; ?>

		<?php if(!empty($topic['Featured']['topic_id'])): ?>
		<span class="label label-default" style="background-color:#499989;"><i class="fa fa-bookmark-o fa-lg"></i>&nbsp;<?php echo l_('CHRONOFORUMS_FEATURED'); ?></span>
		<?php endif; ?>

		<?php if((bool)$fparams->get('enable_topic_replies', 1) === true AND $fparams->get('topic_replies_display', 'label') == 'label'): ?>
		<span class="label label-default" style="background-color:#3498DB;"><i class="fa fa-comments-o fa-lg gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_REPLIES'); ?>"></i>&nbsp;<?php echo (int)$topic['Topic']['post_count'] - 1; ?></span>
		<?php endif; ?>

		<?php if((bool)$fparams->get('enable_topic_views', 1) === true AND $fparams->get('topic_views_display', 'label') == 'label'): ?>
		<span class="label label-default"><i class="fa fa-desktop fa-lg gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_VIEWS'); ?>"></i>&nbsp;<?php echo $topic['Topic']['hits']; ?></span>
		<?php endif; ?>

		<?php if($fparams->get('enable_mini_pager', 1) AND (int)$topic['Topic']['post_count'] > $fparams->get('posts_limit', 10)): ?>
		<div class="btn-group btn-group-xs cfu-mini-pager">
			<?php
				$list_start = ceil((int)$topic['Topic']['post_count']/(int)$fparams->get('posts_limit', 10)) - 5;
				if($list_start < 1){
					$list_start = 1;	
				}
			?>
			<?php for($i = $list_start; $i <= ceil((int)$topic['Topic']['post_count']/(int)$fparams->get('posts_limit', 10)); $i++): ?>
				<a class="btn btn-default" href="<?php echo r_('index.php?option=com_chronoforums&cont=posts&f='.$topic['Topic']['forum_id'].'&t='.$topic['Topic']['id'].'&alias='.$topic['Topic']['alias'].'&page='.$i); ?>"><?php echo $i; ?></a>
			<?php endfor; ?>
		</div>
		<?php endif; ?>
		<?php
	}
	
	function move_link($topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($topic['Topic'])):
			?>
			<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics', $topic['Topic']['user_id'])): ?>
			<a title="<?php echo l_('CHRONOFORUMS_MOVE_TOPIC'); ?>" class="btn gcoreTooltip text-primary" href="<?php echo r_("index.php?option=com_chronoforums&cont=topics&act=move&t=".$topic['Topic']['id']."&f=".$topic['Topic']['forum_id']); ?>"><i class="fa fa-external-link-square fa-lg"></i></a>
			<?php endif; ?>
			<?php
		endif;
	}
	
	function lock_link($topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($topic['Topic'])):
			$act = !empty($topic['Topic']['locked']) ? 'unlock' : 'lock';
			$icon = !empty($topic['Topic']['locked']) ? 'unlock' : 'lock';
			$tip = !empty($topic['Topic']['locked']) ? l_('CHRONOFORUMS_UNLOCK_TOPIC') : l_('CHRONOFORUMS_LOCK_TOPIC');
			$class = !empty($topic['Topic']['locked']) ? 'text-success' : 'text-danger';
			?>
			<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics', $topic['Topic']['user_id'])): ?>
			<a title="<?php echo $tip; ?>" class="btn gcoreTooltip <?php echo $class; ?>" href="<?php echo r_("index.php?option=com_chronoforums&cont=topics&act=".$act."&t=".$topic['Topic']['id']."&f=".$topic['Topic']['forum_id']); ?>"><i class="fa fa-<?php echo $icon; ?> fa-lg"></i></a>
			<?php endif; ?>
			<?php
		endif;
	}
	
	function publish_link($topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($topic['Topic'])):
			$act = !empty($topic['Topic']['published']) ? 'unpublish' : 'publish';
			$icon = !empty($topic['Topic']['published']) ? 'minus-circle' : 'plus-circle';
			$tip = !empty($topic['Topic']['published']) ? l_('CHRONOFORUMS_UNPUBLISH_TOPIC') : l_('CHRONOFORUMS_PUBLISH_TOPIC');
			$class = !empty($topic['Topic']['published']) ? 'text-danger' : 'text-success';
			?>
			<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics', $topic['Topic']['user_id'])): ?>
			<a title="<?php echo $tip; ?>" class="btn gcoreTooltip <?php echo $class; ?>" href="<?php echo r_("index.php?option=com_chronoforums&cont=topics&act=".$act."&t=".$topic['Topic']['id']."&f=".$topic['Topic']['forum_id']); ?>"><i class="fa fa-<?php echo $icon; ?> fa-lg"></i></a>
			<?php endif; ?>
			<?php
		endif;
	}
	
	function announce_link($topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($topic['Topic'])):
			$act = !empty($topic['Topic']['announce']) ? 'unannounce' : 'announce';
			$icon = !empty($topic['Topic']['announce']) ? 'bell-o' : 'bell-o';
			$tip = !empty($topic['Topic']['announce']) ? l_('CHRONOFORUMS_UNSET_ANNOUNCEMENT') : l_('CHRONOFORUMS_SET_ANNOUNCEMENT');
			$class = !empty($topic['Topic']['announce']) ? 'text-danger' : 'text-success';
			?>
			<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics', $topic['Topic']['user_id'])): ?>
			<a title="<?php echo $tip; ?>" class="btn gcoreTooltip <?php echo $class; ?>" href="<?php echo r_("index.php?option=com_chronoforums&cont=topics&act=".$act."&t=".$topic['Topic']['id']."&f=".$topic['Topic']['forum_id']); ?>"><i class="fa fa-<?php echo $icon; ?> fa-lg"></i></a>
			<?php endif; ?>
			<?php
		endif;
	}
	
	function sticky_link($topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($topic['Topic'])):
			$act = !empty($topic['Topic']['sticky']) ? 'unsticky' : 'sticky';
			$icon = !empty($topic['Topic']['sticky']) ? 'map-marker' : 'map-marker';
			$tip = !empty($topic['Topic']['sticky']) ? l_('CHRONOFORUMS_UNSET_STICKY') : l_('CHRONOFORUMS_SET_STICKY');
			$class = !empty($topic['Topic']['sticky']) ? 'text-danger' : 'text-success';
			?>
			<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics', $topic['Topic']['user_id'])): ?>
			<a title="<?php echo $tip; ?>" class="btn gcoreTooltip <?php echo $class; ?>" href="<?php echo r_("index.php?option=com_chronoforums&cont=topics&act=".$act."&t=".$topic['Topic']['id']."&f=".$topic['Topic']['forum_id']); ?>"><i class="fa fa-<?php echo $icon; ?> fa-lg"></i></a>
			<?php endif; ?>
			<?php
		endif;
	}
	
	function delete_link($topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($topic['Topic'])):
			?>
			<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics', $topic['Topic']['user_id'])): ?>
			<a title="<?php echo l_('CHRONOFORUMS_DELETE_TOPIC'); ?>" class="btn gcoreTooltip text-danger" href="<?php echo r_("index.php?option=com_chronoforums&cont=topics&act=delete&t=".$topic['Topic']['id']."&f=".$topic['Topic']['forum_id']); ?>"><i class="fa fa-trash-o fa-lg"></i></a>
			<?php endif; ?>
			<?php
		endif;
	}
	
	function delete_author_link($topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!empty($topic['Topic']) AND !empty($topic['Topic']['user_id'])):
			?>
			<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics') AND (bool)$fparams->get('allow_author_delete', 1) === true): ?>
				<a title="<?php echo l_('CHRONOFORUMS_DELETE_AUTHOR'); ?>" class="btn gcoreTooltip text-danger" href="<?php echo r_("index.php?option=com_chronoforums&cont=topics&act=delete_author&u=".$topic['Topic']['user_id']."&f=".$topic['Topic']['forum_id']."&t=".$topic['Topic']['id']); ?>"><i class="fa fa fa-user fa-lg text-default"></i></a>
			<?php endif; ?>
			<?php
		endif;
	}
	
	function posts_loader($topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!$fparams->get('posts_loader_enabled', 0)){
			return;
		}
		echo '<span id="posts_loader_trigger"></span>';
		echo '<span id="posts_loader_loading" style="text-align:center; display:none;"><img src="'.\GCore\Helpers\Assets::image('loading.gif').'" border="0" /></span>';
		$doc = \GCore\Libs\Document::getInstance();
		$doc->_('jquery');
		$doc->addJsCode('
			var posts_end_reached = 0;
			var posts_loader_running = 0;
			function load_more_posts(topic_id){
				if(!posts_end_reached && !posts_loader_running){
					jQuery.ajax({
						"type" : "POST",
						"url" : "'.r_('index.php?option=com_chronoforums&cont=posts&tvout=ajax&posts_loader=1').'",
						"data" : {"t": topic_id, "p": jQuery(".posts.index .cfu-post").last().prop("id").replace("p", "")},
						beforeSend: function(){
							posts_loader_running = 1;
							jQuery("#posts_loader_loading").css("display", "block");
						},
						"success" : function(res){
							if(res == "_END_"){
								jQuery(".posts.index .cfu-post").last().after("<div class=\"row posts-loader-no-posts\"><div class=\"col-md-12\"><div class=\"alert alert-info\">'.l_('CHRONOFORUMS_NO_MORE_POSTS').'</div></div></div>");
								posts_end_reached = 1;
								jQuery(".posts-loader-load-more").prop("disabled", true);
							}else{
								jQuery(".posts.index .cfu-post").last().after(res);
							}
							posts_loader_running = 0;
							jQuery("#posts_loader_loading").css("display", "none");
						},
					});
				}
			}
		');
		if($fparams->get('posts_loader_method', 'scroll') == 'scroll'){
			$doc->addJsCode('
			jQuery(window).scroll(function(){
				var loader_trigger = jQuery("#posts_loader_trigger").offset().top;
				var view_end = jQuery(window).scrollTop() + jQuery(window).height();
				var distance = loader_trigger - view_end;
				if(distance < '.$fparams->get('posts_loader_scroll_distance', '200').'){
					load_more_posts('.$topic['Topic']['id'].');
				}
			});
			');
		}else{
			echo '
				<div class="row">
					<div class="col-md-12">
						<input type="button" class="btn btn-primary btn-block posts-loader-load-more" name="loader" value="'.l_('CHRONOFORUMS_LOAD_MORE_POSTS').'" onclick="load_more_posts('.$topic['Topic']['id'].');" />
					</div>
				</div>';
		}
	}
	
	function topic_preview($topic = array()){
		$fparams = $this->view->vars['fparams'];
		if(!$fparams->get('enable_topic_preview', 1)){
			return;
		}
		echo '<span id="topic_preview_loading" style="text-align:center; display:none;"><img src="'.\GCore\Helpers\Assets::image('loading.gif').'" border="0" /></span>';
		$doc = \GCore\Libs\Document::getInstance();
		$doc->_('jquery');
		$doc->addJsCode('
			var posts_end_reached = 0;
			var topic_preview_running = 0;
			function load_more_posts(topic_id){
				if(!posts_end_reached && !topic_preview_running){
					jQuery.ajax({
						"type" : "POST",
						"url" : "'.r_('index.php?option=com_chronoforums&cont=posts&tvout=ajax&act=topic_preview').'",
						"data" : {"t": topic_id, "p": jQuery(".cfu-post").length ? jQuery(".cfu-post").last().prop("id").replace("p", "") : 0},
						beforeSend: function(){
							topic_preview_running = 1;
							jQuery("#topic_preview_loading").css("display", "block");
						},
						"success" : function(res){
							if(res == "_END_"){
								jQuery(".cfu-post").last().after("<div class=\"row posts-loader-no-posts\"><div class=\"col-md-12\"><div class=\"alert alert-info\">'.l_('CHRONOFORUMS_NO_MORE_POSTS').'</div></div></div>");
								posts_end_reached = 1;
								jQuery(".posts-loader-load-more").prop("disabled", true);
							}else{
								jQuery("#reply-topic-preview").append(res);
							}
							topic_preview_running = 0;
							jQuery("#topic_preview_loading").css("display", "none");
						},
					});
				}
			}
			jQuery(document).ready(function(){
				load_more_posts('.$topic['Topic']['id'].');
			});
		');
		echo '
			<div class="row">
				<div class="col-md-12">
					<input type="button" class="btn btn-primary btn-block posts-loader-load-more" name="loader" value="'.l_('CHRONOFORUMS_LOAD_MORE_POSTS').'" onclick="load_more_posts('.$topic['Topic']['id'].');" />
				</div>
			</div>';
	}
}
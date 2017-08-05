<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	$doc->_('jquery');
	//$doc->_('jquery-ui');
	//$doc->_('forms');
	//$doc->__('tabs', '#details-panel');
	//$doc->__('tabs', '#ranks-panel');
	
	$this->Toolbar->addButton('save', r_('index.php?ext=chronoforums&act=save_settings'), l_('SAVE'), $this->Assets->image('save', 'toolbar/'));
	//$this->Toolbar->addButton('separator', r_('index.php?ext=chronoforums'), '&nbsp;', $this->Assets->image('separator', 'toolbar/'), 'false');
	$this->Toolbar->addButton('home', r_('index.php?ext=chronoforums'), l_('HOME'), \GCore\C::get('GCORE_ADMIN_URL').'extensions/chronoforums/assets/images/home.png', 'link');
	$styles_files = \GCore\Libs\Folder::getFiles(\GCore\C::ext_path('chronoforums', 'front').'styles'.DS);//array('prosilver' => 'prosilver');
	$styles = array();
	foreach($styles_files as $k => $style){
		if(strpos($style, '.html') !== false){
			continue;
		}
		$s = str_replace(\GCore\C::ext_path('chronoforums', 'front').'styles'.DS, '', $style);
		$styles[$s] = $s;
	}
?>
<div class="chrono-page-container">
<div class="container">
	<div class="row" style="margin-top:20px;">
		<div class="col-md-6">
			<h3><?php echo l_('BOARD_SETTINGS'); ?></h3>
		</div>
		<div class="col-md-6 pull-right text-right">
			<?php
				echo $this->Toolbar->renderBar();
			?>
		</div>
	</div>
	<div class="row">
	<div class="panel panel-default">
		<div class="panel-body">
			<form action="<?php echo r_('index.php?ext=chronoforums&act=save_settings'); ?>" method="post" name="admin_form" id="admin_form">	
				<div id="details-panel">
					<ul class="nav nav-pills">
						<li class="active"><a href="#general" data-g-toggle="tab"><?php echo l_('GENERAL'); ?></a></li>
						<li><a href="#display" data-g-toggle="tab"><?php echo l_('DISPLAY'); ?></a></li>
						<li><a href="#posts_loader" data-g-toggle="tab"><?php echo l_('POSTS_LOADER'); ?></a></li>
						<li><a href="#authors" data-g-toggle="tab"><?php echo l_('AUTHORS'); ?></a></li>
						<li><a href="#notifications" data-g-toggle="tab"><?php echo l_('NOTIFICATIONS'); ?></a></li>
						<li><a href="#email_config" data-g-toggle="tab"><?php echo l_('EMAIL_CONFIG'); ?></a></li>
						<li><a href="#editors" data-g-toggle="tab"><?php echo l_('TEXT_EDITORS'); ?></a></li>
						<li><a href="#extra_info" data-g-toggle="tab"><?php echo l_('EXTRA_INFO'); ?></a></li>
						<li><a href="#ranks" data-g-toggle="tab"><?php echo l_('USERS_RANKS'); ?></a></li>
						<li><a href="#emailsposting" data-g-toggle="tab"><?php echo l_('EMAILS_POSTING'); ?></a></li>
						<li><a href="#messages" data-g-toggle="tab"><?php echo l_('PRIVATE_MESSAGES'); ?></a></li>
						<li><a href="#auto_reply" data-g-toggle="tab"><?php echo l_('AUTO_REPLY'); ?></a></li>
						<li><a href="#search" data-g-toggle="tab"><?php echo l_('CFU_SEARCH'); ?></a></li>
						<li><a href="#style" data-g-toggle="tab"><?php echo l_('CFU_STYLE'); ?></a></li>
						<!--<li><a href="#permissions" data-g-toggle="tab"><?php echo l_('PERMISSIONS'); ?></a></li>-->
						<li><a href="#system" data-g-toggle="tab"><?php echo l_('CFU_SYSTEM'); ?></a></li>
					</ul>
					<div class="tab-content">
					<div id="general" class="tab-pane active">
						<?php echo $this->Html->formStart(); ?>
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('Chronoforums[offline]', array('type' => 'dropdown', 'label' => l_('BOARD_OFFLINE'), 'options' => array(0 => l_('NO'), 1 => l_('YES')))); ?>
						<?php echo $this->Html->formLine('Chronoforums[offline_message]', array('type' => 'textarea', 'label' => l_('OFFLINE_MESSAGE'), 'value' => 'Our board is currently offline, please check back again in the next few hours.', 'rows' => 3, 'cols' => 60)); ?>
						<?php echo $this->Html->formLine('Chronoforums[theme]', array('type' => 'dropdown', 'label' => l_('BOARD_THEME'), 'options' => $styles)); ?>
						<?php echo $this->Html->formLine('Chronoforums[forum_permissions]', array('type' => 'dropdown', 'label' => l_('FORUM_PERMISSIONS'), 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('FORUM_PERMISSIONS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[board_display]', array('type' => 'dropdown', 'label' => l_('BOARD_DISPLAY'), 'options' => array('default' => l_('CFU_DEFAULT'), 'discussions' => l_('DISCUSSIONS')), 'sublabel' => l_('BOARD_DISPLAY_DESC'))); ?>
						
						<?php echo $this->Html->formLine('Chronoforums[allowed_extensions]', array('type' => 'text', 'label' => l_('ALLOWED_EXTENSIONS'), 'value' => 'jpg-png-gif-zip-pdf-doc-docx-txt', 'class' => 'XL', 'sublabel' => l_('ALLOWED_EXTENSIONS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[inline_extensions]', array('type' => 'text', 'label' => l_('INLINE_EXTENSIONS'), 'value' => 'jpg-png-gif', 'class' => 'XL', 'sublabel' => l_('INLINE_EXTENSIONS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[user_directory_files]', array('type' => 'dropdown', 'label' => l_('USER_DIRECTORY_FILES'), 'values' => 0, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('USER_DIRECTORY_FILES_DESC'))); ?>
						<?php //echo $this->Html->formLine('Chronoforums[date_timezone]', array('type' => 'text', 'label' => l_('DATE_TIMEZONE'), 'value' => '', 'sublabel' => l_('DATE_TIMEZONE_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[spoofing_limit]', array('type' => 'text', 'label' => l_('SPOOFING_LIMIT'), 'value' => '30', 'sublabel' => l_('SPOOFING_LIMIT_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[auto_lock_topic_inactive_limit]', array('type' => 'text', 'label' => l_('AUTOLOCK_TOPIC_INACTIVE_LIMIT'), 'value' => '0', 'sublabel' => l_('AUTOLOCK_TOPIC_INACTIVE_LIMIT_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[new_topics_published]', array('type' => 'dropdown', 'label' => l_('NEW_TOPICS_AUTO_APPROVED'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('NEW_TOPICS_AUTO_APPROVED_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[new_posts_published]', array('type' => 'dropdown', 'label' => l_('NEW_POSTS_AUTO_APPROVED'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('NEW_POSTS_AUTO_APPROVED_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[auto_approval_threshold]', array('type' => 'text', 'label' => l_('AUTO_APPROVAL_THRESHOLD'), 'value' => '0', 'sublabel' => l_('AUTO_APPROVAL_THRESHOLD_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[non_approved_threshold]', array('type' => 'text', 'label' => l_('NON_APPROVED_THRESHOLD'), 'value' => '0', 'sublabel' => l_('NON_APPROVED_THRESHOLD_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[topic_hot_limit]', array('type' => 'text', 'label' => l_('TOPIC_HOT_LIMIT'), 'value' => '10', 'sublabel' => l_('TOPIC_HOT_LIMIT_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[topic_popular_limit]', array('type' => 'text', 'label' => l_('TOPIC_POPULAR_LIMIT'), 'value' => '2000', 'sublabel' => l_('TOPIC_POPULAR_LIMIT_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[active_topic_days]', array('type' => 'text', 'label' => l_('ACTIVE_TOPIC_DAYS'), 'value' => '7', 'sublabel' => l_('ACTIVE_TOPIC_DAYS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_quick_reply]', array('type' => 'dropdown', 'label' => l_('ENABLE_QUICK_REPLY'), 'values' => 0, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_QUICK_REPLY_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_topics_track]', array('type' => 'dropdown', 'label' => l_('ENABLE_TOPICS_TRACK'), 'values' => 0, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_TOPICS_TRACK_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_topics_favorites]', array('type' => 'dropdown', 'label' => l_('ENABLE_TOPICS_FAVORITES'), 'values' => 0, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_TOPICS_FAVORITES_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_topics_featured]', array('type' => 'dropdown', 'label' => l_('ENABLE_TOPICS_FEATURED'), 'values' => 0, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_TOPICS_FEATURED_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_topic_preview]', array('type' => 'dropdown', 'label' => l_('ENABLE_TOPIC_PREVIEW'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_TOPIC_PREVIEW_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_community_support]', array('type' => 'dropdown', 'label' => l_('ENABLE_COMMUNITY_SUPPORT'), 'values' => 0, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_COMMUNITY_SUPPORT_DESC'))); ?>
						
						<?php echo $this->Html->formSecEnd(); ?>
						<?php echo $this->Html->formEnd(); ?>
					</div>
					<div id="display" class="tab-pane">
						<?php echo $this->Html->formStart(); ?>
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('Chronoforums[posts_limit]', array('type' => 'text', 'label' => l_('POSTS_LIMIT'), 'value' => 10, 'sublabel' => l_('POSTS_LIMIT_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[topics_limit]', array('type' => 'text', 'label' => l_('TOPICS_LIMIT'), 'value' => 15, 'sublabel' => l_('TOPICS_LIMIT_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[topics_ordering]', array('type' => 'dropdown', 'label' => l_('TOPICS_ORDERING'), 
							'options' => array(
								'LastPost.created DESC' => 'Latest post date - latest first', 
								'LastPost.created ASC' => 'Latest post date - earliest first',
								'Topic.created DESC' => 'Topic creation date - latest first',
								'Topic.created ASC' => 'Topic creation date - earliest first',
							)
						)); ?>
						<?php echo $this->Html->formLine('Chronoforums[posts_ordering]', array('type' => 'dropdown', 'label' => l_('POSTS_ORDERING'), 
							'options' => array(
								'Post.created ASC' => l_('POSTS_ORDERING_EARLIEST_FIRST'), 
								'Post.created DESC' => l_('POSTS_ORDERING_LATEST_FIRST'),
							)
						)); ?>
						<?php echo $this->Html->formLine('Chronoforums[show_datetime]', array('type' => 'dropdown', 'label' => l_('SHOW_DATETIME'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')))); ?>
						<?php echo $this->Html->formLine('Chronoforums[hide_new_topic_button]', array('type' => 'dropdown', 'label' => l_('HIDE_NEW_TOPICS_BUTTON'), 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('HIDE_NEW_TOPICS_BUTTON_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[hide_post_reply_button]', array('type' => 'dropdown', 'label' => l_('HIDE_POST_REPLY_BUTTON'), 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('HIDE_POST_REPLY_BUTTON_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[allow_quote_reply]', array('type' => 'dropdown', 'label' => l_('ALLOW_QUOTE_REPLY'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ALLOW_QUOTE_REPLY_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_topic_replies]', array('type' => 'dropdown', 'label' => l_('ENABLE_TOPIC_REPLIES'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_TOPIC_REPLIES_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[topic_replies_display]', array('type' => 'dropdown', 'label' => l_('TOPIC_REPLIES_DISPLAY'), 'values' => 'label', 'options' => array('label' => l_('LABEL'), 'text' => l_('TEXT')), 'sublabel' => l_('TOPIC_REPLIES_DISPLAY_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_topic_views]', array('type' => 'dropdown', 'label' => l_('ENABLE_TOPIC_VIEWS'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_TOPIC_VIEWS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[topic_views_display]', array('type' => 'dropdown', 'label' => l_('TOPIC_VIEWS_DISPLAY'), 'values' => 'label', 'options' => array('label' => l_('LABEL'), 'text' => l_('TEXT')), 'sublabel' => l_('TOPIC_VIEWS_DISPLAY_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_mini_pager]', array('type' => 'dropdown', 'label' => l_('ENABLE_MINI_PAGER'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_MINI_PAGER_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[inline_images_display]', array('type' => 'dropdown', 'label' => l_('INLINE_IMAGES_DISPLAY'), 'values' => 0, 'options' => array(0 => l_('ENLARGABLE'), 1 => l_('MAGNIFIED'), 2 => l_('MODAL')), 'sublabel' => l_('INLINE_IMAGES_DISPLAY_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[auto_collapse_code]', array('type' => 'dropdown', 'label' => l_('AUTO_COLLAPSE_CODE'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('AUTO_COLLAPSE_CODE_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[load_forums_list]', array('type' => 'dropdown', 'label' => l_('LOAD_FORUMS_LIST'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('LOAD_FORUMS_LIST_DESC'))); ?>
						
						<?php echo $this->Html->formSecEnd(); ?>
						<?php echo $this->Html->formEnd(); ?>
					</div>
					<div id="posts_loader" class="tab-pane">
						<?php echo $this->Html->formStart(); ?>
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('Chronoforums[posts_loader_enabled]', array('type' => 'dropdown', 'label' => l_('POSTS_LOADER_ENABLED'), 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('POSTS_LOADER_ENABLED_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[posts_loader_method]', array('type' => 'dropdown', 'label' => l_('POSTS_LOADER_METHOD'), 'options' => array('scroll' => l_('SCROLL'), 'button' => l_('BUTTON')), 'sublabel' => l_('POSTS_LOADER_METHOD_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[posts_loader_scroll_distance]', array('type' => 'text', 'label' => l_('POSTS_LOADER_SCROLL_DISTANCE'), 'value' => '200', 'class' => 'M', 'sublabel' => l_('POSTS_LOADER_SCROLL_DISTANCE_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[posts_loader_limit]', array('type' => 'text', 'label' => l_('POSTS_LOADER_LIMIT'), 'value' => '3', 'class' => 'M', 'sublabel' => l_('POSTS_LOADER_LIMIT_DESC'))); ?>
						
						<?php echo $this->Html->formSecEnd(); ?>
						<?php echo $this->Html->formEnd(); ?>
					</div>
					<div id="authors" class="tab-pane">
						<?php echo $this->Html->formStart(); ?>
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('Chronoforums[link_usernames]', array('type' => 'dropdown', 'label' => l_('LINK_USERNAMES'), 'options' => array(1 => l_('YES'), 0 => l_('NO')))); ?>
						<?php echo $this->Html->formLine('Chronoforums[display_name]', array('type' => 'dropdown', 'label' => l_('DISPLAY_NAME'), 'options' => array('username' => l_('USERNAME'), 'name' => l_('NAME')))); ?>
						<?php echo $this->Html->formLine('Chronoforums[username_link_path]', array('type' => 'text', 'label' => l_('USERNAME_LINK_PATH'), 'class' => 'XL', 'sublabel' => l_('USERNAME_LINK_PATH_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[show_author_posts_count]', array('type' => 'dropdown', 'label' => l_('SHOW_AUTHOR_POSTS_COUNT'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('SHOW_AUTHOR_POSTS_COUNT_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[show_author_join_date]', array('type' => 'dropdown', 'label' => l_('SHOW_AUTHOR_JOIN_DATE'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('SHOW_AUTHOR_JOIN_DATE_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[allow_author_delete]', array('type' => 'dropdown', 'label' => l_('ALLOW_AUTHOR_DELETE'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ALLOW_AUTHOR_DELETE_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[super_users_groups]', array('type' => 'checkbox_group', 'label' => l_('SUPER_USERS_GROUPS'), 'multiple' => 'multiple', 'options' => $groups, 'ghost' => true, 'sublabel' => l_('SUPER_USERS_GROUPS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[author_delete_affected_topics_limit]', array('type' => 'text', 'label' => l_('AUTHOR_DELETE_AFFECTED_TOPICS_LIMIT'), 'value' => 5, 'class' => 'S', 'sublabel' => l_('AUTHOR_DELETE_AFFECTED_TOPICS_LIMIT_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[author_delete_code_check]', array('type' => 'textarea', 'label' => l_('AUTHOR_DELETE_CODE_CHECK'), 'rows' => 8, 'cols' => 100, 'sublabel' => l_('AUTHOR_DELETE_CODE_CHECK_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[allow_users_avatars]', array('type' => 'dropdown', 'label' => l_('ALLOW_USERS_AVATARS'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ALLOW_USERS_AVATARS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[show_post_author_avatar]', array('type' => 'dropdown', 'label' => l_('SHOW_POST_AUTHOR_AVATAR'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('SHOW_POST_AUTHOR_AVATAR_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[avatar_size]', array('type' => 'text', 'label' => l_('AVATAR_SIZE'), 'value' => '100', 'class' => 'M', 'sublabel' => l_('AVATAR_SIZE_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[avatar_width]', array('type' => 'text', 'label' => l_('AVATAR_WIDTH'), 'value' => '100', 'class' => 'M', 'sublabel' => l_('AVATAR_WIDTH_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[avatar_height]', array('type' => 'text', 'label' => l_('AVATAR_HEIGHT'), 'value' => '100', 'class' => 'M', 'sublabel' => l_('AVATAR_HEIGHT_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[usernames_avatars]', array('type' => 'dropdown', 'label' => l_('USERNAMES_AVATARS'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('USERNAMES_AVATARS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[posts_mini_profile]', array('type' => 'dropdown', 'label' => l_('POSTS_MINI_PROFILE'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('POSTS_MINI_PROFILE_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[usernames_mini_profile]', array('type' => 'dropdown', 'label' => l_('USERNAMES_MINI_PROFILE'), 'values' => 0, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('USERNAMES_MINI_PROFILE_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[post_title_author]', array('type' => 'dropdown', 'label' => l_('POST_TITLE_AUTHOR'), 'values' => 0, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('POST_TITLE_AUTHOR_DESC'))); ?>
						
						<?php echo $this->Html->formSecEnd(); ?>
						<?php echo $this->Html->formEnd(); ?>
					</div>
					<div id="notifications" class="tab-pane">
						<?php echo $this->Html->formStart(); ?>
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('Chronoforums[send_email_on_report]', array('type' => 'dropdown', 'label' => l_('SEND_REPORT_EMAIL'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('SEND_REPORT_EMAIL_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[reports_notify_groups]', array('type' => 'checkbox_group', 'label' => l_('REPORTS_NOTIFY_GROUPS'), 'multiple' => 'multiple', 'options' => $groups, 'ghost' => true, 'sublabel' => l_('REPORTS_NOTIFY_GROUPS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[topic_subscribe_enabled]', array('type' => 'dropdown', 'label' => l_('TOPIC_SUBSCRIBE_ENABLED'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('TOPIC_SUBSCRIBE_ENABLED_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[send_email_on_reply]', array('type' => 'dropdown', 'label' => l_('SEND_REPLY_EMAIL'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('SEND_REPLY_EMAIL_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[send_reply_content]', array('type' => 'dropdown', 'label' => l_('SEND_REPLY_CONTENT'), 'values' => 0, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('SEND_REPLY_CONTENT_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[send_email_on_topic]', array('type' => 'dropdown', 'label' => l_('SEND_TOPIC_EMAIL'), 'values' => 1, 'options' => array(0 => l_('NEVER'), 1 => l_('ALL_TIME'), 2 => l_('ONLY_NOT_APPROVED')), 'sublabel' => l_('SEND_TOPIC_EMAIL_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[topics_notify_groups]', array('type' => 'checkbox_group', 'label' => l_('TOPICS_NOTIFY_GROUPS'), 'multiple' => 'multiple', 'options' => $groups, 'ghost' => true, 'sublabel' => l_('TOPICS_NOTIFY_GROUPS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[send_email_on_post]', array('type' => 'dropdown', 'label' => l_('SEND_POST_EMAIL'), 'values' => 0, 'options' => array(0 => l_('NEVER'), 1 => l_('ALL_TIME'), 2 => l_('ONLY_NOT_APPROVED')), 'sublabel' => l_('SEND_POST_EMAIL_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[posts_notify_groups]', array('type' => 'checkbox_group', 'label' => l_('POSTS_NOTIFY_GROUPS'), 'multiple' => 'multiple', 'options' => $groups, 'ghost' => true, 'sublabel' => l_('POSTS_NOTIFY_GROUPS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[send_email_on_post_edit]', array('type' => 'dropdown', 'label' => l_('SEND_POST_EDIT_EMAIL'), 'values' => 0, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('SEND_POST_EDIT_EMAIL_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[posts_edit_notify_groups]', array('type' => 'checkbox_group', 'label' => l_('POSTS_EDIT_NOTIFY_GROUPS'), 'multiple' => 'multiple', 'options' => $groups, 'ghost' => true, 'sublabel' => l_('POSTS_EDIT_NOTIFY_GROUPS_DESC'))); ?>
						<?php echo $this->Html->formSecEnd(); ?>
						<?php echo $this->Html->formEnd(); ?>
					</div>
					<div id="email_config" class="tab-pane">
						<?php echo $this->Html->formStart(); ?>
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('Chronoforums[email_from_name]', array('type' => 'text', 'label' => l_('EMAIL_FROM_NAME'), 'value' => '', 'class' => 'XL', 'sublabel' => l_('EMAIL_FROM_NAME_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[email_from_email]', array('type' => 'text', 'label' => l_('EMAIL_FROM_EMAIL'), 'value' => '', 'class' => 'XL', 'sublabel' => l_('EMAIL_FROM_EMAIL_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[mail][smtp]', array('type' => 'dropdown', 'label' => l_('ENABLE_SMTP'), 'options' => array(0 => l_('NO'), 1 => l_('YES')))); ?>
						<?php echo $this->Html->formLine('Chronoforums[mail][smtp_secure]', array('type' => 'text', 'label' => l_('SMTP_SECURE'), 'placeholder' => 'tls or ssl', 'sublabel' => l_('SMTP_SECURE_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[mail][smtp_host]', array('type' => 'text', 'class' => 'L', 'label' => l_('SMTP_HOST'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[mail][smtp_port]', array('type' => 'text', 'label' => l_('SMTP_PORT'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[mail][smtp_username]', array('type' => 'text', 'class' => 'L', 'label' => l_('SMTP_USERNAME'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[mail][smtp_password]', array('type' => 'text', 'class' => 'L', 'label' => l_('SMTP_PASSWORD'))); ?>
						<?php echo $this->Html->formSecEnd(); ?>
						<?php echo $this->Html->formEnd(); ?>
					</div>
					<div id="editors" class="tab-pane">
						<?php echo $this->Html->formStart(); ?>
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('Editors[active_editor]', array('type' => 'dropdown', 'label' => l_('EDITORS_ADMIN_EDITOR'), 'values' => array('tinymce'), 
							'options' => array(
								//'' => 'GCore Editor - Default', 
								'tinymce' => 'TinyMCE',
								//'ckeditor' => 'CKEditor',
								//'sceditor' => 'SCEditor',
							)
						)); ?>
						<?php echo $this->Html->formLine('Chronoforums[board_editor]', array('type' => 'dropdown', 'label' => l_('EDITORS_FRONT_EDITOR'), 'values' => array('default'), 
							'options' => array(
								'default' => 'Basic - Default', 
								'active' => 'Active Editor',
							)
						)); ?>
						<?php echo $this->Html->formSecEnd(); ?>
						<?php echo $this->Html->formEnd(); ?>
					</div>
					<div id="extra_info" class="tab-pane">
						<?php echo $this->Html->formStart(); ?>
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_extra_topic_info]', array('type' => 'dropdown', 'label' => l_('ENABLE_EXTRA_TOPIC_INFO'), 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_EXTRA_TOPIC_INFO_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[extra_topic_info_code]', array('type' => 'textarea', 'label' => l_('EXTRA_TOPIC_INFO_CODE'), 'rows' => 10, 'cols' => 80, 'sublabel' => l_('EXTRA_TOPIC_INFO_CODE_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[extra_topic_info_output]', array('type' => 'textarea', 'label' => l_('EXTRA_TOPIC_INFO_OUTPUT'), 'rows' => 10, 'cols' => 80, 'sublabel' => l_('EXTRA_TOPIC_INFO_OUTPUT_DESC'))); ?>
						<?php echo $this->Html->formSecEnd(); ?>
						<?php echo $this->Html->formEnd(); ?>
					</div>
					<div id="ranks" class="tab-pane">
						<?php echo $this->Html->formStart(); ?>
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('Chronoforums[load_ranks]', array('type' => 'dropdown', 'label' => l_('LOAD_RANKS'), 'values' => 0, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('LOAD_RANKS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[ranks_separator]', array('type' => 'text', 'label' => l_('RANKS_SEPARATOR'), 'value' => '<br />', 'class' => '', 'sublabel' => l_('RANKS_SEPARATOR_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_votes]', array('type' => 'dropdown', 'label' => l_('ENABLE_VOTES'), 'values' => 0, 'options' => array(0 => l_('NO'), 'post' => l_('POSTS'), 'topic' => l_('TOPICS')), 'sublabel' => l_('ENABLE_VOTES_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_down_votes]', array('type' => 'dropdown', 'label' => l_('ENABLE_DOWN_VOTES'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_DOWN_VOTES_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_reputation]', array('type' => 'dropdown', 'label' => l_('ENABLE_REPUTATION'), 'values' => 0, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_REPUTATION_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[vote_reputation_weight]', array('type' => 'text', 'label' => l_('VOTE_REPUTATION_WEIGTH'), 'value' => '1', 'class' => '', 'sublabel' => l_('VOTE_REPUTATION_WEIGTH_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[post_reputation_weight]', array('type' => 'text', 'label' => l_('POST_REPUTATION_WEIGTH'), 'value' => '0', 'class' => '', 'sublabel' => l_('POST_REPUTATION_WEIGTH_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[topic_reputation_weight]', array('type' => 'text', 'label' => l_('TOPIC_REPUTATION_WEIGTH'), 'value' => '0', 'class' => '', 'sublabel' => l_('TOPIC_REPUTATION_WEIGTH_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[answer_reputation_weight]', array('type' => 'text', 'label' => l_('ANSWER_REPUTATION_WEIGTH'), 'value' => '10', 'class' => '', 'sublabel' => l_('ANSWER_REPUTATION_WEIGTH_DESC'))); ?>
						
						<?php echo $this->Html->formSecEnd(); ?>
						<?php echo $this->Html->formEnd(); ?>
					</div>
					<div id="emailsposting" class="tab-pane">
						<?php echo $this->Html->formStart(); ?>
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_emails_posting]', array('type' => 'dropdown', 'label' => l_('ENABLE_EMAILS_POSTING'), 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_EMAILS_POSTING_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[email_reply_email]', array('type' => 'text', 'label' => l_('EMAIL_REPLY_EMAIL'), 'value' => '', 'class' => 'XL', 'sublabel' => l_('EMAIL_REPLY_EMAIL_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[email_reply_password]', array('type' => 'password', 'label' => l_('EMAIL_REPLY_PASSWORD'), 'value' => '', 'class' => 'M', 'sublabel' => l_('EMAIL_REPLY_PASSWORD_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[email_reply_path]', array('type' => 'text', 'label' => l_('EMAIL_REPLY_PATH'), 'value' => '', 'class' => 'XL', 'sublabel' => l_('EMAIL_REPLY_PATH_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[emails_posting_period]', array('type' => 'text', 'label' => l_('EMAILS_POSTING_PERIOD'), 'value' => '0', 'class' => 'SS', 'sublabel' => l_('EMAILS_POSTING_PERIOD_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[emails_posting_secret]', array('type' => 'text', 'label' => l_('EMAILS_POSTING_SECRET'), 'value' => \GCore\Libs\Str::rand(), 'class' => 'L', 'sublabel' => l_('EMAILS_POSTING_SECRET_DESC'))); ?>
						<?php echo $this->Html->formSecEnd(); ?>
						<?php echo $this->Html->formEnd(); ?>
					</div>
					<div id="messages" class="tab-pane">
						<?php echo $this->Html->formStart(); ?>
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_pm]', array('type' => 'dropdown', 'label' => l_('ENABLE_PRIVATE_MESSAGES'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_PRIVATE_MESSAGES_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[pm_email_notify]', array('type' => 'dropdown', 'label' => l_('ENABLE_MESSAGE_NOTIFY'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_MESSAGE_NOTIFY_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_pm_groups_filter]', array('type' => 'dropdown', 'label' => l_('ENABLE_MESSAGES_GROUPS_FILTER'), 'values' => 0, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_MESSAGES_GROUPS_FILTER_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[pm_allowed_groups]', array('type' => 'checkbox_group', 'label' => l_('MESSAGES_ALLOWED_GROUPS'), 'multiple' => 'multiple', 'options' => $groups, 'ghost' => true, 'sublabel' => l_('MESSAGES_ALLOWED_GROUPS_DESC'))); ?>
						<?php echo $this->Html->formSecEnd(); ?>
						<?php echo $this->Html->formEnd(); ?>
					</div>
					<div id="auto_reply" class="tab-pane">
						<?php echo $this->Html->formStart(); ?>
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_auto_reply]', array('type' => 'dropdown', 'label' => l_('ENABLE_AUTO_REPLY'), 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_AUTO_REPLY_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[auto_reply_user_id]', array('type' => 'text', 'label' => l_('AUTO_REPLY_USER_ID'), 'value' => '', 'class' => 'S', 'sublabel' => l_('AUTO_REPLY_USER_ID_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[auto_reply_sec_token]', array('type' => 'text', 'label' => l_('AUTO_REPLY_SECURITY_TOKEN'), 'value' => \GCore\Libs\Str::rand(), 'class' => 'L', 'sublabel' => l_('AUTO_REPLY_SECURITY_TOKEN_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[auto_reply_content]', array('type' => 'textarea', 'label' => l_('AUTO_REPLY_CONTENT'), 'rows' => 15, 'cols' => 100, 'sublabel' => l_('AUTO_REPLY_CONTENT_DESC'))); ?>
						<?php echo $this->Html->formSecEnd(); ?>
						<?php echo $this->Html->formEnd(); ?>
					</div>
					<div id="search" class="tab-pane">
						<?php echo $this->Html->formStart(); ?>
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('Chronoforums[search_method]', array('type' => 'dropdown', 'label' => l_('SEARCH_METHOD'), 'options' => array('deep' => l_('DEEP'), 'tags' => l_('TAGS')), 'sublabel' => l_('SEARCH_METHOD_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[deep_search_type]', array('type' => 'dropdown', 'label' => l_('DEEP_SEARCH_TYPE'), 'values' => 'match', 'options' => array('match' => l_('MATCH AGAINST'), 'like' => l_('LIKE')), 'sublabel' => l_('DEEP_SEARCH_TYPE_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[search_order]', array('type' => 'dropdown', 'label' => l_('SEARCH_ORDER'), 'values' => 'relevance', 'options' => array('relevance' => l_('RELEVANCE'), 'default' => l_('DEFAULT')), 'sublabel' => l_('SEARCH_ORDER_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[search_words_limit]', array('type' => 'text', 'label' => l_('SEARCH_WORDS_LIMIT'), 'value' => '4', 'class' => 'S', 'sublabel' => l_('SEARCH_WORDS_LIMIT_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[search_start_from]', array('type' => 'text', 'label' => l_('SEARCH_START_FROM'), 'value' => '3m,6m,1y,2y', 'class' => 'L', 'sublabel' => l_('SEARCH_START_FROM_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[search_start_from_value]', array('type' => 'text', 'label' => l_('SEARCH_START_FROM_VALUE'), 'value' => '1y', 'class' => 'S', 'sublabel' => l_('SEARCH_START_FROM_VALUE_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[search_flooding_limit]', array('type' => 'text', 'label' => l_('SEARCH_FLOODING_LIMIT'), 'value' => '20', 'class' => 'S', 'sublabel' => l_('SEARCH_FLOODING_LIMIT_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[enable_topic_tags]', array('type' => 'dropdown', 'label' => l_('ENABLE_TOPIC_TAGS'), 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_TOPIC_TAGS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[save_search_tags]', array('type' => 'dropdown', 'label' => l_('SAVE_SEARCH_TAGS'), 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('SAVE_SEARCH_TAGS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[update_tags_hits]', array('type' => 'dropdown', 'label' => l_('UPDATE_TAGS_HITS'), 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('UPDATE_TAGS_HITS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[auto_tag_topics]', array('type' => 'dropdown', 'label' => l_('AUTO_TAG_TOPICS'), 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('AUTO_TAG_TOPICS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[list_topic_tags]', array('type' => 'dropdown', 'label' => l_('LIST_TOPIC_TAGS'), 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('LIST_TOPIC_TAGS_DESC'))); ?>
						<?php echo $this->Html->formSecEnd(); ?>
						<?php echo $this->Html->formEnd(); ?>
					</div>
					<div id="style" class="tab-pane">
						<?php echo $this->Html->formStart(); ?>
						<?php echo $this->Html->formSecStart(); ?>
						<?php //echo $this->Html->formLine('Chronoforums[posts_font_size]', array('type' => 'text', 'label' => l_('POSTS_FONT_SIZE'), 'value' => '11px', 'class' => 'M', 'sublabel' => l_('POSTS_FONT_SIZE_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[global_css]', array('type' => 'textarea', 'label' => l_('GLOBAL_CSS'), 'rows' => 10, 'cols' => 80, 'style' => 'width:auto;', 'sublabel' => l_('GLOBAL_CSS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[display_forum_icon]', array('type' => 'dropdown', 'label' => l_('DISPLAY_FORUM_ICON'), 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('DISPLAY_FORUM_ICON_DESC'))); ?>
						<?php //echo $this->Html->formLine('Chronoforums[rt_support]', array('type' => 'dropdown', 'label' => l_('RT_SUPPORT'), 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('RT_SUPPORT_DESC'))); ?>
						<?php echo $this->Html->formSecEnd(); ?>
						<?php echo $this->Html->formEnd(); ?>
					</div>
					<div id="permissions" class="tab-pane">
						<?php /*echo $this->Html->formStart(); ?>
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('Chronoforums[permissions][active]', array('type' => 'dropdown', 'label' => l_('PERMISSIONS_ACTIVE_SYSTEM'), 'options' => array(0 => l_('CUSTOM_PERMISSIONS'), 1 => l_('MEMBERS_POST_GUESTS_READ'), 1 => l_('MEMBERS_POST_GUESTS_NOREAD')), 'sublabel' => l_('PERMISSIONS_ACTIVE_SYSTEM_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[permissions][moderators]', array('type' => 'dropdown', 'label' => l_('PERMISSIONS_MODERATORS'), 'options' => $groups, 'sublabel' => l_('PERMISSIONS_MODERATORS_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[permissions][members]', array('type' => 'dropdown', 'label' => l_('PERMISSIONS_MEMBERS'), 'options' => $groups, 'sublabel' => l_('PERMISSIONS_MEMBERS_DESC'))); ?>
						<?php echo $this->Html->formSecEnd(); ?>
						<?php echo $this->Html->formEnd();*/ ?>
					</div>
					<div id="system" class="tab-pane">
						<?php echo $this->Html->formStart(); ?>
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('Chronoforums[forums_debug]', array('type' => 'dropdown', 'label' => l_('ENABLE_FORUMS_DEBUG'), 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_FORUMS_DEBUG_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[forums_query_cache]', array('type' => 'dropdown', 'label' => l_('ENABLE_FORUMS_QUERY_CACHE'), 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_FORUMS_QUERY_CACHE_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[forums_query_cache_time]', array('type' => 'text', 'label' => l_('FORUMS_QUERY_CACHE_TIME'), 'value' => '3600', 'class' => '', 'sublabel' => l_('FORUMS_QUERY_CACHE_TIME_DESC'))); ?>
						<?php echo $this->Html->formLine('Chronoforums[forums_cache_engine]', array('type' => 'dropdown', 'label' => l_('FORUMS_CACHE_ENGINE'), 'options' => array('file' => l_('FILE'), 'apc' => l_('APC')), 'sublabel' => l_('FORUMS_CACHE_ENGINE_DESC'))); ?>
						<?php //echo $this->Html->formLine('Chronoforums[forums_views_cache]', array('type' => 'dropdown', 'label' => l_('ENABLE_FORUMS_VIEWS_CACHE'), 'options' => array(0 => l_('NO'), /*1 => l_('YES')*/), 'sublabel' => l_('ENABLE_FORUMS_VIEWS_CACHE_DESC'))); ?>
						<?php //echo $this->Html->formLine('Chronoforums[forums_views_cache_time]', array('type' => 'text', 'label' => l_('FORUMS_VIEWS_CACHE_TIME'), 'value' => '900', 'class' => '', 'sublabel' => l_('FORUMS_VIEWS_CACHE_TIME_DESC'))); ?>
						<?php echo $this->Html->formSecEnd(); ?>
						<?php echo $this->Html->formEnd(); ?>
					</div>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>
</div>
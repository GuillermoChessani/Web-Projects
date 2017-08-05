<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	//$doc->_('datatable');
	$doc->_('jquery');
	//$doc->_('jquery-ui');
	//$doc->__('tabs', '#details-panel');
	//$doc->_('forms');
	$this->Toolbar->addButton('categories', r_('index.php?ext=chronoforums&cont=categories'), l_('CATEGORIES_MANAGER'), \GCore\C::get('GCORE_ADMIN_URL').'extensions/chronoforums/assets/images/category.png', 'link');
	$this->Toolbar->addButton('forums', r_('index.php?ext=chronoforums&cont=forums'), l_('FORUMS_MANAGER'), \GCore\C::get('GCORE_ADMIN_URL').'extensions/chronoforums/assets/images/forums.png', 'link');
	$this->Toolbar->addButton('tags', r_('index.php?ext=chronoforums&cont=tags'), l_('TAGS_MANAGER'), \GCore\C::get('GCORE_ADMIN_URL').'extensions/chronoforums/assets/images/tags.png', 'link');
	$this->Toolbar->addButton('ranks', r_('index.php?ext=chronoforums&cont=ranks'), l_('RANKS_MANAGER'), \GCore\C::get('GCORE_ADMIN_URL').'extensions/chronoforums/assets/images/ranks.png', 'link');
	$this->Toolbar->setGroup(2);
	$this->Toolbar->addButton('settings', r_('index.php?ext=chronoforums&act=settings'), l_('SETTINGS'), \GCore\C::get('GCORE_ADMIN_URL').'extensions/chronoforums/assets/images/settings.png', 'link');
	$this->Toolbar->addButton('permissions', r_('index.php?ext=chronoforums&act=permissions'), l_('PERMISSIONS'), \GCore\C::get('GCORE_ADMIN_URL').'extensions/chronoforums/assets/images/permissions.png', 'link');
	$this->Toolbar->addButton('validate', r_('index.php?ext=chronoforums&act=validateinstall'), l_('VALIDATE_INSTALL'), \GCore\C::get('GCORE_ADMIN_URL').'extensions/chronoforums/assets/images/validate.png', 'link');
	$this->Toolbar->addButton('migrator', r_('index.php?ext=chronoforums&cont=migrator'), l_('MIGRATE'), \GCore\C::get('GCORE_ADMIN_URL').'extensions/chronoforums/assets/images/import.png', 'link');
	//$this->Toolbar->addButton('replacer', r_('index.php?ext=chronoforums&cont=migrator&act=replacer'), l_('REPLACER'), \GCore\C::get('GCORE_ADMIN_URL').'extensions/chronoforums/assets/images/text_replace.png', 'link');
	$this->Toolbar->addButton('delete_cache', r_('index.php?ext=chronoforums&act=delete_cache'), l_('DELETE_CACHE'), \GCore\C::get('GCORE_ADMIN_URL').'extensions/chronoforums/assets/images/delete_cache.png', 'link');
	
?>
<div class="chrono-page-container">
<div class="container" style="width:100%;">
	<div class="row" style="margin-top:20px;">
		<div class="col-md-6">
			<h3>ChronoForums Admin Home</h3>
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
			<div id="details-panel">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#statistics" data-g-toggle="tab"><?php echo l_('STATISTICS'); ?></a></li>
					<li><a href="#permissions" data-g-toggle="tab"><?php echo l_('FOLDERS_PERMISSIONS'); ?></a></li>
					<li><a href="#sync" data-g-toggle="tab"><?php echo l_('SYNC'); ?></a></li>
				</ul>
				<div class="tab-content">
					<div id="statistics" class="tab-pane active">
						<table cellpadding="5" cellspacing="5" border="0">
							<tbody>
							<?php foreach($statics as $title => $value): ?>
								<tr>
									<td><?php echo $title; ?></td>
									<td><?php echo $value; ?></td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<div id="permissions" class="tab-pane">
						<table cellpadding="5" cellspacing="5" border="0" style="width:100%;">
							<thead>
								<th style="width:70%;"><strong><?php echo l_('CPANEL_SYSINFO_DIR_NAME'); ?></strong></th>
								<th style="padding:15px;"><strong><?php //echo l_('CPANEL_SYSINFO_DIR_STATUS'); ?></strong></th>
							</thead>
							<tbody>
							<?php
								$folders = array(
									\GCore\C::ext_path('chronoforums', 'front').'attachments'.DS,
									\GCore\C::get('GCORE_FRONT_PATH').'cache'.DS,
								);
								foreach($folders as $folder){
									if(is_dir($folder) OR in_array(basename($folder), array('bootstrap.php', 'gcloader.php', 'index.php', 'config.php'))){
										if(is_writable($folder)){
											$status = '<span style="font-weight:bold;padding:5px;color:#088A29;background-color:#D0FA58;">'.l_('CPANEL_SYSINFO_WRITABLE').'</span>';
										}else{
											$status = '<span style="font-weight:bold;padding:5px;color:#B40404;background-color:#F5A9A9;">'.l_('CPANEL_SYSINFO_NOT_WRITABLE').'</span>';
										}
										echo '<tr><td><strong style="color:#5882FA;">'.$folder.'</strong></td><td style="padding:15px;">'.$status.'</td></tr>';
									}
								}
							?>
							</tbody>
						</table>
					</div>
					<div id="sync" class="tab-pane">
						<form action="<?php echo r_('index.php?ext=chronoforums&act=sync'); ?>" method="post" name="admin_form" id="admin_form">
							<?php echo $this->Html->formStart(); ?>
							<?php echo $this->Html->formSecStart(); ?>
							<?php echo $this->Html->formLine('forum_id', array('type' => 'multi', 'label' => 'Forum ID', 'layout' => 'wide',
								'inputs' => array(
									array('type' => 'text', 'class' => 'S', 'name' => 'sync[forum_id]'),
									array('type' => 'submit', 'name' => 'sync_forum', 'value' => l_('SYNC_FORUM'), 'style' => 'margin-left:50px;'),
									array('type' => 'submit', 'name' => 'sync_forum_topics', 'value' => l_('SYNC_FORUM_TOPICS'), 'style' => 'margin-left:50px;'),
								)
							)); ?>
							<?php echo $this->Html->formLine('topic_id', array('type' => 'multi', 'label' => 'Topic ID', 'layout' => 'wide',
								'inputs' => array(
									array('type' => 'text', 'class' => 'S', 'name' => 'sync[topic_id]'),
									array('type' => 'submit', 'name' => 'sync_topic', 'value' => l_('SYNC_TOPIC'), 'style' => 'margin-left:50px;'),
								)
							)); ?>
							<?php echo $this->Html->formSecEnd(); ?>
							<?php echo $this->Html->formEnd(); ?>
						</form>
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>
</div>
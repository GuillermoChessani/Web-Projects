<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
?>
<div class="chronoforums profiles edit">
	<div class="container">
		<div class="row cfu-header">
			<?php echo $this->Elements->header(); ?>
		</div>
		<div class="row cfu-data">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="cfu-title"><?php echo sprintf(l_('CHRONOFORUMS_PROFILE_TITLE'), $user['User'][$fparams->get('display_name', 'username')]); ?></h3>	
				</div>
				<div class="panel-body">
					<form action="<?php echo r_('index.php?option=com_chronoforums&cont=profiles&act=edit&u='.$user['User']['id']); ?>" method="post" name="postform" enctype="multipart/form-data" id="postform" class="panel">
					<?php echo $this->Html->formSecStart(); ?>
					<?php echo $this->Html->formLine('Profile[params][location]', array('type' => 'text', 'class' => 'M', 'label' => l_('CHRONOFORUMS_LOCATION'))); ?>
					<?php echo $this->Html->formLine('Profile[params][about]', array('type' => 'textarea', 'rows' => 3, 'cols' => 50, 'label' => l_('CHRONOFORUMS_ABOUT'))); ?>
					<?php echo $this->Html->formLine('Profile[params][signature]', array('type' => 'textarea', 'rows' => 3, 'cols' => 50, 'label' => l_('CHRONOFORUMS_SIGNATURE'))); ?>
					<?php if(empty($this->data['Profile']['params']['avatar'])): ?>
						<?php echo $this->Html->formLine('avatar', array('type' => 'file', 'class' => 'M', 'label' => l_('CHRONOFORUMS_AVATAR'))); ?>
					<?php else: ?>
						<?php echo $this->Html->formLine('avatar', array('type' => 'multi', 'label' => l_('CHRONOFORUMS_AVATAR'), 'layout' => 'wide',
							'inputs' => array(
								array('type' => 'file', 'class' => 'M', 'name' => 'avatar'),
								array('type' => 'hidden', 'name' => 'Profile[params][avatar]'),
								array('type' => 'custom', 'name' => 'preview', 'code' => $this->Html->image(r_('index.php?option=com_chronoforums&cont=profiles&act=avatar&img='.$user['Profile']['params']['avatar']), array('class' => 'img-rounded'))),
							)
						)); ?>
					<?php endif; ?>
					<?php echo $this->Html->formLine('Profile[params][website]', array('type' => 'text', 'class' => 'M', 'label' => l_('CHRONOFORUMS_WEBSITE'))); ?>
					<?php //echo $this->Html->formLine('Profile[params][subscribed]', array('type' => 'checkbox', 'value' => 1, 'label' => l_('CHRONOFORUMS_SUBSCRIBED'))); ?>
					<?php echo $this->Html->formLine('buttons', array('type' => 'multi', 'layout' => 'wide',
						'inputs' => array(
							array('type' => 'submit', 'name' => 'cancel_edit', 'value' => l_('CHRONOFORUMS_CANCEL'), 'class' => 'btn btn-danger'),
							array('type' => 'submit', 'name' => 'update_profile', 'value' => l_('CHRONOFORUMS_SUBMIT'), 'class' => 'btn btn-success'),
						)
					)); ?>
					<?php echo $this->Html->formSecEnd(); ?>
					</form>
				</div>
			</div>
		</div>
		<div class="row cfu-footer">
			<?php echo $this->Elements->footer(); ?>
		</div>
	</div>
</div>
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
					<form action="<?php echo r_('index.php?option=com_chronoforums&cont=profiles&act=preferences&u='.$user['User']['id']); ?>" method="post" name="postform" id="postform" class="panel">
					<?php echo $this->Html->formSecStart(); ?>
					<?php echo $this->Html->formLine('Profile[params][preferences][posts_ordering]', array('type' => 'dropdown', 'label' => l_('POSTS_ORDERING'), 
						'options' => array(
							'Post.created ASC' => l_('POSTS_ORDERING_EARLIEST_FIRST'), 
							'Post.created DESC' => l_('POSTS_ORDERING_LATEST_FIRST'),
						)
					)); ?>
					<?php if((bool)$fparams->get('enable_topics_track', 0) === true): ?>
					<?php echo $this->Html->formLine('Profile[params][preferences][enable_topics_track]', array('type' => 'dropdown', 'label' => l_('ENABLE_TOPICS_TRACK'), 'values' => 0, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('ENABLE_TOPICS_TRACK_FRONT_DESC'))); ?>
					<?php endif; ?>
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
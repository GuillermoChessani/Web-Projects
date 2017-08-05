<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	$doc->_('forms');
?>
<div class="chronoforums topics delete_author">
	<div class="container">
		<div class="row cfu-header">
			<?php echo $this->Elements->header(); ?>
		</div>
		<div class="row cfu-body">
			<form action="<?php echo r_('index.php?option=com_chronoforums&cont=topics&act=delete_author&f='.$fid.'&t='.$tid); ?>" method="post" name="postform" enctype="multipart/form-data" id="postform" class="cfu-panel">
				<div class="container">
					<div class="row">
						<p class="alert alert-danger"><?php echo l_('CHRONOFORUMS_DELETE_AUTHOR_CONFIRMATION'); ?></p>
					</div>
		
					<div class="row">
						<?php
							if(!empty($users)){
								foreach($users as $user):
								?>
									<div class="well well-sm">
										<?php echo $this->UserTasks->username(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?>
										<?php if(isset($user['TopicCounter'][0]['count'])): ?>
											<?php echo ' - '.$user['TopicCounter'][0]['count'].' '.l_('CHRONOFORUMS_TOPICS'); ?>
										<?php endif; ?>
										<?php if(isset($user['PostCounter'][0]['count'])): ?>
											<?php echo ' - '.$user['PostCounter'][0]['count'].' '.l_('CHRONOFORUMS_POSTS'); ?>
										<?php endif; ?>
									</div>
								<?php
									//echo $this->Html->formLine('user', array('type' => 'custom', 'code' => $code));
								endforeach;
							}
						?>
		
						<?php echo $this->Html->input('f', array('type' => 'hidden', 'value' => $fid)); ?>
						<?php echo $this->Html->input('t', array('type' => 'hidden', 'value' => $tid)); ?>
						<?php echo $this->Html->input('u', array('type' => 'hidden', 'value' => $uid)); ?>
						<?php
							foreach($tids as $t){
								echo $this->Html->input('topics_ids['.$t.']', array('type' => 'hidden', 'value' => 1));
							}
						?>
					</div>
					<div class="row">
						<?php echo $this->Html->input('buttons', array('type' => 'multi', 'layout' => 'wide',
							'inputs' => array(
								array('type' => 'submit', 'name' => 'cancel_delete_author', 'value' => l_('CHRONOFORUMS_CANCEL'), 'class' => 'btn btn-primary'),
								array('type' => 'submit', 'name' => 'confirm_delete_author', 'value' => l_('CHRONOFORUMS_DELETE'), 'class' => 'btn btn-danger delete_button')
							)
						)); ?>
					</div>
		
				</div>
			</form>
		</div>
	</div>
</div>
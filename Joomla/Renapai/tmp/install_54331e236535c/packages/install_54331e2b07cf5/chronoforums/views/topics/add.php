<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	$extra_info = '';
?>
<div class="chronoforums topics add">
	<div class="container">
		<div class="row cfu-header">
			<?php echo $this->Elements->header(); ?>
		</div>
		<div class="row cfu-body">
			<form action="<?php echo r_('index.php?option=com_chronoforums&cont=topics&act=add&f='.\GCore\Libs\Request::data('f')); ?>" method="post" name="postform" enctype="multipart/form-data" id="postform" class="panel">
				<?php if($fparams->get('enable_extra_topic_info', 0)): ?>
					<?php ob_start(); ?>
					<div class="row cfu-extra-info">
						<?php
						ob_start();
						eval('?>'.$fparams->get('extra_topic_info_code', ''));
						$output = ob_get_clean();
						echo $output;
						?>
					</div>
					<?php $extra_info .= ob_get_clean(); ?>
				<?php endif; ?>
				<?php if($fparams->get('board_display', 'default') == 'discussions'): ?>
					<?php ob_start(); ?>
					<div class="row cfu-forum-select">
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('f',array('type' => 'dropdown', 'label' => l_('CHRONOFORUMS_FORUM'), 'options' => $forums_list)); ?>
						<?php echo $this->Html->formSecEnd(); ?>
					</div>
					<?php $extra_info .= ob_get_clean(); ?>
				<?php endif; ?>
				<?php //require_once(dirname(dirname(__FILE__)).DS.'editor_body.php'); ?>
				<?php $this->PostEdit->display($extra_info); ?>
				<div class="well well-sm cfu-fields">
					<div class="container">
						<div class="row cfu-subscribe">
							<?php echo $this->Html->formSecStart(); ?>
							<?php echo $this->Html->formLine('subscribe', array('type' => 'checkbox', 'checked' => (bool)$fparams->get('topic_subscribe_enabled', 1), 'value' => 1, 'label' => l_('CHRONOFORUMS_SUBSCRIBE_TOPIC'), 'sublabel' => l_('CHRONOFORUMS_SUBSCRIBE_TOPIC_DESC'))); ?>
							<?php echo $this->Html->formSecEnd(); ?>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
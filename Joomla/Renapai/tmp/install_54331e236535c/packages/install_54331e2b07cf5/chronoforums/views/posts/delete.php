<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	$doc->_('forms');
?>
<div class="chronoforums posts delete">
	<form action="<?php echo r_('index.php?option=com_chronoforums&cont=posts&act=delete&p='.$post['Post']['id'].'&t='.$post['Post']['topic_id']); ?>" method="post" name="postform" enctype="multipart/form-data" id="postform" class="cfu-panel">
		<div class="container">
			<div class="row">
				<p class="alert alert-warning"><strong><?php echo l_('CHRONOFORUMS_DELETE_CONFIRMATION'); ?></strong></p>
			</div>
			<div class="row">
				<?php echo $this->Html->input('buttons', array('type' => 'multi', 'layout' => 'wide',
					'inputs' => array(
						array('type' => 'submit', 'name' => 'cancel_delete', 'value' => l_('CHRONOFORUMS_CANCEL'), 'class' => 'btn btn-primary'),
						array('type' => 'submit', 'name' => 'confirm_delete', 'value' => l_('CHRONOFORUMS_DELETE'), 'class' => 'btn btn-danger')
					)
				)); ?>
			</div>

			<div class="row">
				<?php require_once(dirname(__FILE__).DS.'post_body.php'); ?>
			</div>
		</div>
	</form>
</div>
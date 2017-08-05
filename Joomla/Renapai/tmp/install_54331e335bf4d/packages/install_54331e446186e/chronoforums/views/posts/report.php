<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	$doc->_('forms');
?>
<div class="chronoforums posts report">
	<form action="<?php echo r_('index.php?option=com_chronoforums&cont=posts&act=report&p='.$post['Post']['id'].'&t='.$post['Post']['topic_id']); ?>" method="post" name="postform" enctype="multipart/form-data" id="postform" class="cfu-panel">
		<div class="container">
			<div class="row">
				<p class="alert alert-warning"><strong><?php echo l_('CHRONOFORUMS_REPORT_CONFIRMATION'); ?></strong></p>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label"><?php echo l_('CHRONOFORUMS_REPORT_REASON'); ?></label>
				</div>
				<div class="col-md-8">
					<?php echo $this->Html->input('Report[reason]', array('type' => 'textarea', 'label' => l_('CHRONOFORUMS_REPORT_REASON'), 'rows' => '5', 'cols' => '80', 'class' => 'form-control')); ?>
				</div>
			</div>
			<div class="row">
				<?php echo $this->Html->input('buttons', array('type' => 'multi', 'layout' => 'wide',
					'inputs' => array(
						array('type' => 'submit', 'name' => 'cancel_report', 'value' => l_('CHRONOFORUMS_CANCEL'), 'class' => 'btn btn-default'),
						array('type' => 'submit', 'name' => 'confirm_report', 'value' => l_('CHRONOFORUMS_REPORT'), 'class' => 'btn btn-danger')
					)
				)); ?>
			</div>

			<div class="row">
				<?php require_once(dirname(__FILE__).DS.'post_body.php'); ?>
			</div>
		</div>
	</form>
</div>
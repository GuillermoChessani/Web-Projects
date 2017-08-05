<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="cfu-editor">
	<div class="container">
		<?php
			if(isset($preview) AND $preview === true){
				echo '
					<div class="row cfu-preview">
						<div class="well">
						'.$this->Bbcode->parse($this->data['Post']['text']).'
						</div>
					</div>
				';
			}
		?>
		<div class="row">
			<div class="container">
				<div class="row cfu-subject">
					<?php echo $this->Html->formSecStart(); ?>
					<?php echo $this->Html->formLine('Post[subject]', array('type' => 'text', 'label' => l_('CHRONOFORUMS_SUBJECT'), 'class' => 'XL form-control')); ?>
					<?php echo $this->Html->formSecEnd(); ?>
				</div>
				<div class="row cfu-message">
					<?php $this->Bbeditor->editor(); ?>
				</div>
				<?php echo $this->Html->input('f', array('type' => 'hidden', 'value' => \GCore\Libs\Request::data('f'))); ?>
				<?php echo $this->Html->input('t', array('type' => 'hidden', 'value' => \GCore\Libs\Request::data('t'))); ?>
				<?php echo $this->Html->input('p', array('type' => 'hidden', 'value' => \GCore\Libs\Request::data('p'))); ?>
				<?php if(!isset($editor_attachments) OR $editor_attachments === true): ?>
				<div class="row cfu-upload">
					<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'attach_files') === true): ?>
						<?php echo $this->Html->input('photo', array('type' => 'multi', 'label' => l_('CHRONOFORUMS_ATTACH_FILE'), 'layout' => 'wide',
							'inputs' => array(
								array('type' => 'file', 'class' => 'M', 'name' => 'attach'),
								array('type' => 'submit', 'name' => 'upload', 'value' => l_('CHRONOFORUMS_UPLOAD'), 'style' => 'margin-left:50px;', 'class' => 'btn btn-default')
							)
						)); ?>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				<div class="row cfu-submit">
					<?php echo $this->Html->input('buttons', array('type' => 'multi', 'layout' => 'wide',
						'inputs' => array(
							array('type' => 'submit', 'name' => 'cancel_post', 'value' => l_('CHRONOFORUMS_CANCEL'), 'class' => 'btn btn-danger'),
							array('type' => 'submit', 'name' => 'preview', 'value' => l_('CHRONOFORUMS_PREVIEW'), 'class' => 'btn btn-primary'),
							array('type' => 'submit', 'name' => 'submit', 'value' => l_('CHRONOFORUMS_SUBMIT'), 'class' => 'btn btn-success'),
						)
					)); ?>
				</div>
			</div>
		</div>
	</div>
</div>
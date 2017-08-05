<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	$doc->_('select2');
	$doc->addJsCode('jQuery(document).ready(function($){ $("#recipients").select2(
		{
			placeholder: "Search for a user",
			minimumInputLength: 3,
			width: "element",
			//multiple: true,
			//tags: true,
			//tokenSeparators: [","," "],
			ajax:{
				url: "'.r_('index.php?option=com_chronoforums&cont=messages&act=username_lookup&tvout=ajax').'",
				dataType: "json",
				data: function (term, page){
					return {
						username_q: term,
					};
				},
				results: function (data, page){
					return {results: data};
				}
			}'.(!empty($username) ? ',
			initSelection: function(element, callback){
				var uid = $(element).val();
				var data = {"id": $(element).val(), "text": "'.$username.'"};
				callback(data);
			},' : '').'
		}
	); });');
?>
<div class="chronoforums messages compose">
	<div class="container">
		<div class="row cfu-header">
			<?php echo $this->Elements->header(); ?>
		</div>
		<div class="row">
			<h3><?php echo l_('CHRONOFORUMS_PRIVATE_MESSAGING'); ?> - <?php echo l_('CHRONOFORUMS_COMPOSE'); ?></h3>
		</div>
		<div class="row cfu-editor">
			<form action="<?php echo r_('index.php?option=com_chronoforums&cont=messages&act=compose'); ?>" method="post" name="postform" enctype="multipart/form-data" id="postform" class="panel">
				<div class="container">
					<?php
						if(isset($preview) AND $preview === true){
							echo '
								<div class="row">
									<div class="well">
									'.$this->Bbcode->parse($this->data['Message']['text']).'
									</div>
								</div>
							';
						}
					?>
					<?php echo $this->Html->input('d', array('type' => 'hidden', 'value' => \GCore\Libs\Request::data('d'))); ?>
					<?php echo $this->Html->input('m', array('type' => 'hidden', 'value' => \GCore\Libs\Request::data('m'))); ?>
					<div class="row cfu-recipient">
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('u', array('type' => 'hidden', 'label' => l_('CHRONOFORUMS_RECIPIENTS'), 'id' => 'recipients', 'class' => 'M')); ?>
						<?php echo $this->Html->formSecEnd(); ?>
					</div>
					<div class="row cfu-subject">
						<?php echo $this->Html->formSecStart(); ?>
						<?php echo $this->Html->formLine('Message[subject]', array('type' => 'text', 'label' => l_('CHRONOFORUMS_SUBJECT'), 'class' => 'XL form-control')); ?>
						<?php echo $this->Html->formSecEnd(); ?>
					</div>
					<div class="row cfu-message">
						<?php $this->Bbeditor->editor('Message[text]'); ?>
					</div>
					<div class="row cfu-submit">
						<?php echo $this->Html->input('buttons', array('type' => 'multi', 'layout' => 'wide',
							'inputs' => array(
								array('type' => 'submit', 'name' => 'cancel_post', 'value' => l_('CHRONOFORUMS_CANCEL'), 'class' => 'btn btn-danger'),
								array('type' => 'submit', 'name' => 'submit', 'value' => l_('CHRONOFORUMS_SUBMIT'), 'class' => 'btn btn-success'),
								array('type' => 'submit', 'name' => 'preview', 'value' => l_('CHRONOFORUMS_PREVIEW'), 'class' => 'btn btn-primary'),
							)
						)); ?>
					</div>
				</div>
			</form>
		</div>
		<div class="row cfu-preview">
			<?php if(!empty($d_messages)): ?>
				<?php foreach($d_messages as $d_message): ?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="col-lg-7 pull-left">
								<strong><?php echo $d_message['Message']['subject']; ?></strong>
							</div>
							<div class="col-lg-5 pull-right">
								<span class="pull-right">
									<i class="fa fa-fw fa-calendar"></i>
									<small class="cfu-time"><?php echo $this->Output->date_time($d_message['Message']['created']); ?></small>
								</span>
								<small class="cfu-user-info pull-right">
									<i class="fa fa-lg- fa-user"></i><?php echo $this->UserTasks->username(array('User' => $d_message['MessageUser'], 'Profile' => $d_message['MessageUserProfile']), false); ?>
								</small>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-body">
							<?php echo $this->Bbcode->parse($d_message['Message']['text']); ?>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<div class="row cfu-footer">
			<?php echo $this->Elements->footer(); ?>
		</div>
	</div>
</div>
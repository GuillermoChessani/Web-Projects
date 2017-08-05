<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace GCore\Extensions\Chronoforums\Helpers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class PostEdit {
	var $view;
	
	function display($extra = ''){
		$fparams = $this->view->vars['fparams'];
		//$preview = isset($this->view->vars['preview']) ? $this->view->vars['preview'] : false;
		$editor_attachments = isset($this->view->vars['editor_attachments']) ? $this->view->vars['editor_attachments'] : true;
		
		$doc = \GCore\Libs\Document::getInstance();
		$doc->_('jquery');
		$doc->addJsCode('
			function preview_quick_reply(){
				jQuery.ajax({
					"type" : "POST",
					"url" : "'.r_('index.php?option=com_chronoforums&cont=posts&tvout=ajax&act=bbcode_preview').'",
					"data" : jQuery("#postform").serialize(),
					beforeSend: function(){
						jQuery("#quick_reply_preview").empty();
						jQuery("#quick_reply_preview").append("<img src=\"'.\GCore\Helpers\Assets::image('loading.gif').'\" border=\"0\" />");
						jQuery("#quick_reply_preview").css("display", "block");
					},
					"success" : function(res){
						jQuery("#quick_reply_preview").empty();
						jQuery("#quick_reply_preview").append(res);
					},
				});
			}
		');
		?>
			<div class="cfu-editor">
				<div class="container">
					<div class="row cfu-preview">
						<div id="quick_reply_preview" class="well" style="display:none;"></div>
					</div>
					<div class="row">
						<div class="container">
							<?php echo $this->view->Html->input('f', array('type' => 'hidden', 'value' => \GCore\Libs\Request::data('f'))); ?>
							<?php echo $this->view->Html->input('t', array('type' => 'hidden', 'value' => \GCore\Libs\Request::data('t'))); ?>
							<?php echo $this->view->Html->input('p', array('type' => 'hidden', 'value' => \GCore\Libs\Request::data('p'))); ?>
							<div class="row cfu-subject">
								<?php echo $this->view->Html->formSecStart(); ?>
								<?php echo $this->view->Html->formLine('Post[subject]', array('type' => 'text', 'label' => l_('CHRONOFORUMS_SUBJECT'), 'class' => 'XL form-control')); ?>
								<?php echo $this->view->Html->formSecEnd(); ?>
							</div>
							<?php if($extra): ?>
							<?php echo $extra; ?>
							<?php endif; ?>
							<div class="row cfu-message">
								<?php $this->view->Bbeditor->editor(); ?>
							</div>
							
							<?php if(!isset($editor_attachments) OR $editor_attachments === true): ?>
							<div class="row cfu-upload">
								<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'attach_files') === true): ?>
									<?php echo $this->view->Html->input('photo', array('type' => 'multi', 'label' => l_('CHRONOFORUMS_ATTACH_FILE'), 'layout' => 'wide',
										'inputs' => array(
											array('type' => 'file', 'class' => 'M', 'name' => 'attach'),
											array('type' => 'submit', 'name' => 'upload', 'value' => l_('CHRONOFORUMS_UPLOAD'), 'style' => 'margin-left:50px;', 'class' => 'btn btn-default')
										)
									)); ?>
								<?php endif; ?>
							</div>
							<?php endif; ?>
							<div class="row cfu-submit">
								<?php echo $this->view->Html->input('buttons', array('type' => 'multi', 'layout' => 'wide',
									'inputs' => array(
										array('type' => 'submit', 'name' => 'cancel_post', 'value' => l_('CHRONOFORUMS_CANCEL'), 'class' => 'btn btn-danger'),
										array('type' => 'button', 'name' => 'preview', 'value' => l_('CHRONOFORUMS_PREVIEW'), 'class' => 'btn btn-info', 'onclick' => 'preview_quick_reply();'),
										array('type' => 'submit', 'name' => 'submit', 'value' => l_('CHRONOFORUMS_SUBMIT'), 'class' => 'btn btn-success'),
									)
								)); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
	}
}
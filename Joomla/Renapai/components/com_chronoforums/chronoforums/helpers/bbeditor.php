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
class Bbeditor {
	var $view;
	function editor($message_name = 'Post[text]'){
		$fparams = $this->view->vars['fparams'];
		?>
		<?php if($fparams->get('board_editor', 'default') != 'default'): ?>
			<?php
				$doc = \GCore\Libs\Document::getInstance();
				//$doc->_('jquery');
				$doc->_('editor');
				$doc->__('editor', '#post-text', array('plugins' => 'bbcode'));
				echo $this->view->Html->input($message_name, array('type' => 'textarea', 'id' => 'post-text', 'rows' => '10', 'cols' => '80', 'style' => 'height:300px; width:600px;'));
				$external_editor = true;
			?>
		<?php else: ?>
		
		<div class="container">
			<div class="row">

				<script type="text/javascript">
				// <![CDATA[
					//var form_name = 'postform';
					//var text_name = 'message';
					var bbcode_form_id = 'postform';
					var bbcode_area_id = 'post-text';
					var load_draft = false;
					var upload = false;

					// Define the bbCode tags
					var bbcode = new Array();
					var bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[quote]','[/quote]','[code]','[/code]','[list]','[/list]','[list=]','[/list]','[img]','[/img]','[url]','[/url]','[flash=]', '[/flash]','[size=]','[/size]');
					var imageTag = false;

				// ]]>
				</script>
				<script src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/js/editor.js" type="text/javascript"></script>
				<div id="colour_palette" style="display: none;">
					<dl style="clear: left;">
						<dt><label>Font colour:</label></dt>
						<dd>
						<script type="text/javascript">
						// <![CDATA[
							function change_palette(){
								if(jQuery('#colour_palette').css('display') == 'block'){
									jQuery('#colour_palette').css('display', 'none');
								}else{
									jQuery('#colour_palette').css('display', 'block');
								}
							}
							colorPalette('h', 15, 10, '<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/assets/images/');
						// ]]>
						</script>
						</dd>
					</dl>
				</div>
				
				<div id="cfu-buttons" class="well well-sm cfu-buttons">
					<a title="<?php echo l_('CHRONOFORUMS_BOLD_TEXT'); ?>: [b]text[/b]" onclick="bbstyle(0); return false;" name="addbbcode0" accesskey="b" class="btn btn-default btn-sm"><i class="fa fa-bold fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_ITALIC_TEXT'); ?>: [i]text[/i]" onclick="bbstyle(2); return false;" name="addbbcode2" accesskey="i" class="btn btn-default btn-sm"><i class="fa fa-italic fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_UNDERLINE_TEXT'); ?>: [u]text[/u]" onclick="bbstyle(4); return false;" name="addbbcode4" accesskey="u" class="btn btn-default btn-sm"><i class="fa fa-underline fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_QUOTE_TEXT'); ?>: [quote]text[/quote]" onclick="bbstyle(6); return false;" name="addbbcode6" accesskey="q" class="btn btn-default btn-sm"><i class="fa fa-quote-left fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_CODE_DISPLAY'); ?>: [code]code[/code]" onclick="bbstyle(8); return false;" name="addbbcode8" accesskey="c" class="btn btn-default btn-sm"><i class="fa fa-code fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_LIST'); ?>: [list]text[/list]" onclick="bbstyle(10); return false;" name="addbbcode10" accesskey="l" class="btn btn-default btn-sm"><i class="fa fa-list-ul fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_ORDERED_LIST'); ?>: [list=]text[/list]" onclick="bbstyle(12); return false;" name="addbbcode12" accesskey="o" class="btn btn-default btn-sm"><i class="fa fa-list-ol fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_LIST_ELEMENT'); ?>: [*]text[/*]" onclick="bbstyle(-1); return false;" name="addlistitem" accesskey="y" class="btn btn-default btn-sm"><i class="fa fa-circle-o fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_INSERT_IMAGE'); ?>: [img]http://image_url[/img]" onclick="bbstyle(14); return false;" name="addbbcode14" accesskey="p" class="btn btn-default btn-sm"><i class="fa fa-picture-o fa-fw fa-lg"></i></a>
					<a title="<?php echo l_('CHRONOFORUMS_INSERT_URL'); ?>: [url]http://url[/url] or [url=http://url]URL text[/url]" onclick="bbstyle(16); return false;" name="addbbcode16" accesskey="w" class="btn btn-default btn-sm"><i class="fa fa-link fa-fw fa-lg"></i></a>
					<!--<a title="<?php echo l_('CHRONOFORUMS_FLASH'); ?>: [flash=width,height]http://url[/flash]" onclick="bbstyle(18); return false;" name="addbbcode18" accesskey="d" class="btn btn-default btn-sm"><i class="fa fa-bold fa-fw fa-lg"></i></a>-->
					<select title="<?php echo l_('CHRONOFORUMS_FONT_SIZE'); ?>: [size=85]small text[/size]" alt="ghost" onchange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]');this.form.addbbcode20.selectedIndex = 2;" name="addbbcode20" class="input-sm S">
						<option value="50"><?php echo l_('CHRONOFORUMS_TINY'); ?></option>
						<option value="85"><?php echo l_('CHRONOFORUMS_SMALL'); ?></option>
						<option selected="selected" value="100"><?php echo l_('CHRONOFORUMS_NORMAL'); ?></option>
						<option value="150"><?php echo l_('CHRONOFORUMS_LARGE'); ?></option>
						<option value="200"><?php echo l_('CHRONOFORUMS_HUGE'); ?></option>
					</select>
					<a title="<?php echo l_('CHRONOFORUMS_FONT_COLOR'); ?>: [color=red]text[/color]  Tip: you can also use color=#FF0000" onclick="change_palette(); return false;" name="bbpalette" id="bbpalette" class="btn btn-warning btn-sm"><i class="fa fa-th fa-fw fa-lg"></i></a>
				</div>

				<div id="cfu-smilies" class="well well-sm cfu-smilies">
					<a class="btn btn-xs btn-default" onclick="insert_text(':D', true); return false;" href="#"><img width="15" height="17" title="Very Happy" alt=":D" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_biggrin.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':)', true); return false;" href="#"><img width="15" height="17" title="Smile" alt=":)" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_smile.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(';)', true); return false;" href="#"><img width="15" height="17" title="Wink" alt=";)" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_wink.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':(', true); return false;" href="#"><img width="15" height="17" title="Sad" alt=":(" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_sad.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':o', true); return false;" href="#"><img width="15" height="17" title="Surprised" alt=":o" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_surprised.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':shock:', true); return false;" href="#"><img width="15" height="17" title="Shocked" alt=":shock:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_eek.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':?', true); return false;" href="#"><img width="15" height="17" title="Confused" alt=":?" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_confused.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text('8-)', true); return false;" href="#"><img width="15" height="17" title="Cool" alt="8-)" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_cool.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':lol:', true); return false;" href="#"><img width="15" height="17" title="Laughing" alt=":lol:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_lol.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':x', true); return false;" href="#"><img width="15" height="17" title="Mad" alt=":x" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_mad.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':P', true); return false;" href="#"><img width="15" height="17" title="Razz" alt=":P" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_razz.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':oops:', true); return false;" href="#"><img width="15" height="17" title="Embarrassed" alt=":oops:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_redface.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':cry:', true); return false;" href="#"><img width="15" height="17" title="Crying or Very Sad" alt=":cry:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_cry.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':evil:', true); return false;" href="#"><img width="15" height="17" title="Evil or Very Mad" alt=":evil:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_evil.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':twisted:', true); return false;" href="#"><img width="15" height="17" title="Twisted Evil" alt=":twisted:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_twisted.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':roll:', true); return false;" href="#"><img width="15" height="17" title="Rolling Eyes" alt=":roll:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_rolleyes.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':!:', true); return false;" href="#"><img width="15" height="17" title="Exclamation" alt=":!:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_exclaim.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':?:', true); return false;" href="#"><img width="15" height="17" title="Question" alt=":?:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_question.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':idea:', true); return false;" href="#"><img width="15" height="17" title="Idea" alt=":idea:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_idea.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':arrow:', true); return false;" href="#"><img width="15" height="17" title="Arrow" alt=":arrow:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_arrow.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':|', true); return false;" href="#"><img width="15" height="17" title="Neutral" alt=":|" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_neutral.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':mrgreen:', true); return false;" href="#"><img width="15" height="17" title="Mr. Green" alt=":mrgreen:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_mrgreen.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':geek:', true); return false;" href="#"><img width="17" height="17" title="Geek" alt=":geek:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_e_geek.gif"></a>
					<a class="btn btn-xs btn-default" onclick="insert_text(':ugeek:', true); return false;" href="#"><img width="17" height="18" title="Uber Geek" alt=":ugeek:" src="<?php echo \GCore\C::get('GCORE_FRONT_URL'); ?>extensions/chronoforums/styles/<?php echo $fparams->get('theme', 'prosilver'); ?>/imageset/smilies/icon_e_ugeek.gif"></a>
					
				</div>
				<div id="cfu-message">
					<textarea class="form-control" onfocus="initInsertions();" onkeyup="storeCaret(this);" onclick="storeCaret(this);" onselect="storeCaret(this);" tabindex="4" cols="76" rows="10" id="post-text" name="<?php echo $message_name; ?>"></textarea>
				</div>
			</div>
		</div>
		
		<?php endif; ?>
		<?php
			if((bool)$fparams->get('attach_files', 1) === true){
				if(!empty($this->view->data['Attachment'])){
					foreach($this->view->data['Attachment'] as $k => $attachment){
					?>
					<div class="cfu-attachment">
						<div class="cfu-comment">
							<?php echo $this->view->Html->formSecStart(); ?>
							<?php echo $this->view->Html->formLine('Attachment['.$k.'][comment]', array('type' => 'textarea', 'label' => l_('CHRONOFORUMS_FILE_COMMENT'), 'rows' => 2, 'cols' => 45)); ?>
							<?php echo $this->view->Html->formSecEnd(); ?>
						</div>
						<div class="clearfix"></div>
						<div class="cfu-info">
							<?php echo $this->view->Html->formSecStart(); ?>
							<?php echo $this->view->Html->formLine('Attachment['.$k.'][info]', array('type' => 'custom', 'label' => l_('CHRONOFORUMS_FILE_INFO'), 'code' => $attachment['filename'])); ?>
							<?php echo $this->view->Html->formSecEnd(); ?>
						</div>
						<div class="clearfix"></div>
						<div class="cfu-tasks">
							<div class="col-md-2">
								<label class="control-label"></label>
							</div>
							<div class="col-md-8">
								<?php if(!isset($external_editor)): ?>
								<input type="button" class="btn btn-default" onclick="attach_inline(<?php echo $k; ?>, '<?php echo $attachment['filename']; ?>');" value="<?php echo l_('CHRONOFORUMS_PLACE_INLINE'); ?>">&nbsp;
								<?php endif; ?>
								<input type="submit" class="btn btn-default" value="<?php echo l_('CHRONOFORUMS_DELETE_FILE'); ?>" name="delete_file[<?php echo $k; ?>]">
								<input type="hidden" name="Attachment[<?php echo $k; ?>][filename]" value="" />
								<input type="hidden" name="Attachment[<?php echo $k; ?>][vfilename]" value="" />
								<input type="hidden" name="Attachment[<?php echo $k; ?>][size]" value="" />
								<input type="hidden" name="Attachment[<?php echo $k; ?>][id]" value="" />
							</div>
						</div>
					</div>
					<?php
					}
				}
			}
		?>
	<?php
	}
}
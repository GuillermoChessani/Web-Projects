<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	//$doc->_('datatable');
	$doc->_('jquery');
	//$doc->_('jquery-ui');
	//$doc->__('tabs', '#details-panel');
	//$doc->_('forms');
	$doc->addCssFile('system_messages');
?>
<script>	
	jQuery(document).ready(function($){
		$('#migrator-status').css('display', 'none');
		$('#alias_topics').on('click', function(){
			var obj = $('#admin_form').serialize();
			if($('#migrator-warning').css('display') == 'none'){
				$('#migrator-status').html('Started topics aliasing, please wait.....');
			}
			$('#migrator-warning').css('display', 'block');
			$('#migrator-status').css('display', 'block');
			$.ajax({
				url: '<?php echo r_('index.php?ext=chronoforums&cont=migrator&tvout=ajax&act=replacer&alias_topics=1&limit=100'); ?>',
				data: obj
			}).done(function(msg){
				//console.log(msg);
				if(msg == 'STOP'){
					$('#migrator-status').html($('#migrator-status').html() + ' - Finished successfully!');
					$('#migrator-warning').css('display', 'none');
				}else{
					$('#migrator-status').html(msg);
					$('#alias_topics').trigger('click');
				}
			});
		});
	});
	jQuery(document).ready(function($){
		$('#migrator-status').css('display', 'none');
		$('#fix_posts').on('click', function(){
			var obj = $('#admin_form').serialize();
			if($('#migrator-warning').css('display') == 'none'){
				$('#migrator-status').html('Started posts importing, please wait.....');
			}
			$('#migrator-warning').css('display', 'block');
			$('#migrator-status').css('display', 'block');
			$.ajax({
				url: '<?php echo r_('index.php?ext=chronoforums&cont=migrator&tvout=ajax&act=replacer&fix_posts=1&limit=100'); ?>',
				data: obj
			}).done(function(msg){
				//console.log(msg);
				if(msg == 'STOP'){
					$('#migrator-status').html($('#migrator-status').html() + ' - Finished successfully!');
					$('#migrator-warning').css('display', 'none');
				}else{
					$('#migrator-status').html(msg);
					$('#fix_posts').trigger('click');
				}
			});
		});
	});
</script>
<div class="system-message">
	<div class="warning message" id="migrator-warning" style="display:none;">Please don't interrupt the replacing process until it successfully finishes.</div>
	<div class="info message" id="migrator-status"></div>
</div>
<div class="chrono-page-container">
<div class="container" style="width:100%;">
	<div class="row" style="margin-top:20px;">
		<div class="col-md-6">
			<h3>Posts text replacer</h3>
		</div>
		<div class="col-md-6 pull-right text-right">
			<?php
				$this->Toolbar->addButton('home', r_('index.php?ext=chronoforums'), l_('HOME'), \GCore\C::get('GCORE_ADMIN_URL').'extensions/chronoforums/assets/images/home.png', 'link');
				echo $this->Toolbar->renderBar();
			?>
		</div>
	</div>
	<div class="row">
	<div class="panel panel-default">
		<div class="panel-body">
			<form action="<?php echo r_('index.php?ext=chronoforums&cont=migrator&act=replacer'); ?>" method="post" name="admin_form" id="admin_form">
				<div id="details-panel">
					<ul class="nav nav-pills">
						<li class="active"><a href="#backup" data-g-toggle="tab"><?php echo l_('Replace'); ?></a></li>
					</ul>
					<div class="tab-content">
						<div id="backup" class="tab-pane active">
							<?php echo $this->Html->formStart(); ?>
								<?php echo $this->Html->formSecStart(); ?>
								<?php echo $this->Html->formLine('alias_topics', array('value' => 'Alias topics', 'type' => 'button', 'id' => 'alias_topics', 'sublabel' => 'Will set aliases for any topics without alias in the forums database')); ?>
								<?php echo $this->Html->formLine('fix_posts', array('value' => 'Fix Posts', 'type' => 'button', 'id' => 'fix_posts', 'sublabel' => 'Will fix all posts in the forums database')); ?>
								<?php echo $this->Html->formLine('strings', array('label' => 'Replace strings', 'type' => 'textarea', 'cols' => 80, 'rows' => 5, 'sublabel' => 'The strings to be replaced and the alternatives in multi line format, e.g:old_string:::::new_string')); ?>
								<?php echo $this->Html->formLine('regexes', array('label' => 'Replace regex', 'type' => 'textarea', 'cols' => 80, 'rows' => 5, 'sublabel' => 'The regexes to be replaced and the alternatives in multi line format, WARNING, 1 mistake here and you may lose your forums posts, use wisely and take a backup first, e.g:/old_string/:::::new_string')); ?>
								<?php echo $this->Html->formSecEnd(); ?>
								<?php echo $this->Html->formSecStart(); ?>
								<?php echo $this->Html->formLine('posts_count', array('label' => 'Posts count', 'type' => 'text', 'sublabel' => 'Enter an integer to limit the number of fixed posts')); ?>
								<?php echo $this->Html->formLine('limit', array('label' => 'Limit', 'type' => 'text', 'value' => 50, 'sublabel' => 'The number of processed posts per iteration')); ?>
								<?php echo $this->Html->formLine('direction', array('label' => 'Direction', 'type' => 'dropdown', 'options' => array('ASC' => 'ASC', 'DESC' => 'DESC'), 'sublabel' => 'DESC will fix more recent posts first.')); ?>
								<?php echo $this->Html->formSecEnd(); ?>
							<?php echo $this->Html->formEnd(); ?>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	</div>
</div>
</div>
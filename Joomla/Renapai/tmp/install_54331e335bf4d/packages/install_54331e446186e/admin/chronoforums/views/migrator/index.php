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
		$('#import_forums').on('click', function(){
			var obj = $('#admin_form').serialize();
			//obj['import_forums'] = 1;
			//obj['limit'] = 100;
			if($('#migrator-warning').css('display') == 'none'){
				$('#migrator-status').html('Started forums importing, please wait.....');
			}
			$('#migrator-warning').css('display', 'block');
			$('#migrator-status').css('display', 'block');
			$.ajax({
				url: '<?php echo r_('index.php?ext=chronoforums&cont=migrator&tvout=ajax&import_forums=1&limit=100'); ?>',
				data: obj
			}).done(function(msg){
				//console.log(msg);
				if(msg == 'STOP'){
					$('#migrator-status').html($('#migrator-status').html() + ' - Finished successfully!');
					$('#migrator-warning').css('display', 'none');
				}else{
					$('#migrator-status').html(msg);
					$('#import_forums').trigger('click');
				}
			});
		});
	});
	
	jQuery(document).ready(function($){
		$('#migrator-status').css('display', 'none');
		$('#import_topics').on('click', function(){
			var obj = $('#admin_form').serialize();
			//obj['import_topics'] = 1;
			//obj['limit'] = 100;
			if($('#migrator-warning').css('display') == 'none'){
				$('#migrator-status').html('Started topics importing, please wait.....');
			}
			$('#migrator-warning').css('display', 'block');
			$('#migrator-status').css('display', 'block');
			$.ajax({
				url: '<?php echo r_('index.php?ext=chronoforums&cont=migrator&tvout=ajax&import_topics=1&limit=100'); ?>',
				data: obj
			}).done(function(msg){
				//console.log(msg);
				if(msg == 'STOP'){
					$('#migrator-status').html($('#migrator-status').html() + ' - Finished successfully!');
					$('#migrator-warning').css('display', 'none');
				}else{
					$('#migrator-status').html(msg);
					$('#import_topics').trigger('click');
				}
			});
		});
	});
	
	jQuery(document).ready(function($){
		$('#migrator-status').css('display', 'none');
		$('#import_posts').on('click', function(){
			var obj = $('#admin_form').serialize();
			//obj['import_posts'] = 1;
			//obj['limit'] = 100;
			if($('#migrator-warning').css('display') == 'none'){
				$('#migrator-status').html('Started posts importing, please wait.....');
			}
			$('#migrator-warning').css('display', 'block');
			$('#migrator-status').css('display', 'block');
			$.ajax({
				url: '<?php echo r_('index.php?ext=chronoforums&cont=migrator&tvout=ajax&import_posts=1&limit=100'); ?>',
				data: obj
			}).done(function(msg){
				//console.log(msg);
				if(msg == 'STOP'){
					$('#migrator-status').html($('#migrator-status').html() + ' - Finished successfully!');
					$('#migrator-warning').css('display', 'none');
				}else{
					$('#migrator-status').html(msg);
					$('#import_posts').trigger('click');
				}
			});
		});
	});
	
	jQuery(document).ready(function($){
		$('#migrator-status').css('display', 'none');
		$('#import_topics_track').on('click', function(){
			var obj = $('#admin_form').serialize();
			//obj['import_topics'] = 1;
			//obj['limit'] = 100;
			if($('#migrator-warning').css('display') == 'none'){
				$('#migrator-status').html('Started topics tracking info importing, please wait.....');
			}
			$('#migrator-warning').css('display', 'block');
			$('#migrator-status').css('display', 'block');
			$.ajax({
				url: '<?php echo r_('index.php?ext=chronoforums&cont=migrator&tvout=ajax&import_topics_track=1&limit=100'); ?>',
				data: obj
			}).done(function(msg){
				//console.log(msg);
				if(msg == 'STOP'){
					$('#migrator-status').html($('#migrator-status').html() + ' - Finished successfully!');
					$('#migrator-warning').css('display', 'none');
				}else{
					$('#migrator-status').html(msg);
					$('#import_topics_track').trigger('click');
				}
			});
		});
	});
	
	jQuery(document).ready(function($){
		$('#migrator-status').css('display', 'none');
		$('#import_topics_subscribe').on('click', function(){
			var obj = $('#admin_form').serialize();
			//obj['import_topics'] = 1;
			//obj['limit'] = 100;
			if($('#migrator-warning').css('display') == 'none'){
				$('#migrator-status').html('Started topics subscriptions info importing, please wait.....');
			}
			$('#migrator-warning').css('display', 'block');
			$('#migrator-status').css('display', 'block');
			$.ajax({
				url: '<?php echo r_('index.php?ext=chronoforums&cont=migrator&tvout=ajax&import_topics_subscribe=1&limit=100'); ?>',
				data: obj
			}).done(function(msg){
				//console.log(msg);
				if(msg == 'STOP'){
					$('#migrator-status').html($('#migrator-status').html() + ' - Finished successfully!');
					$('#migrator-warning').css('display', 'none');
				}else{
					$('#migrator-status').html(msg);
					$('#import_topics_subscribe').trigger('click');
				}
			});
		});
	});
	
	jQuery(document).ready(function($){
		$('#source').on('click', function(){
			$('.board_settings').css('display', 'none');
			$('#'+$('#source').val()+'_settings').css('display', 'block');
			/*if($('#source').val() == 'phpbb3'){
				$('#phpbb3_settings').css('display', 'block');
			}else{
				$('#phpbb3_settings').css('display', 'none');
			}*/
		});
	});
</script>
<div class="system-message">
	<div class="warning message" id="migrator-warning" style="display:none;">Please don't interrupt the importing process until it successfully finishes.</div>
	<div class="info message" id="migrator-status"></div>
</div>
<div class="chrono-page-container">
<div class="container" style="width:100%;">
	<div class="row" style="margin-top:20px;">
		<div class="col-md-6">
			<h3>phpBB3 Importer</h3>
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
			<form action="<?php echo r_('index.php?ext=chronoforums&cont=migrator'); ?>" method="post" name="admin_form" id="admin_form">
				<div id="details-panel">
					<ul class="nav nav-pills">
						<li class="active"><a href="#backup" data-g-toggle="tab"><?php echo l_('Import'); ?></a></li>
						<li><a href="#settings" data-g-toggle="tab"><?php echo l_('Settings'); ?></a></li>
					</ul>
					<div class="tab-content">
						<div id="backup" class="tab-pane active">
							<?php echo $this->Html->formStart(); ?>
								<?php echo $this->Html->formSecStart(); ?>
								<?php echo $this->Html->formLine('source', array('label' => 'Source', 'id' => 'source', 'type' => 'dropdown', 'options' => array('phpbb3' => 'phpBB3', 'kunena' => 'Kunena'), 'sublabel' => 'Choose the source to import the data from.')); ?>
								<div id="phpbb3_settings" class="board_settings" style="display:block;">
								<?php echo $this->Html->formLine('dbtype', array('label' => 'phpBB3 DB Type', 'type' => 'text', 'value' => 'mysql')); ?>
								<?php echo $this->Html->formLine('dbhost', array('label' => 'phpBB3 DB Host', 'type' => 'text', 'value' => 'localhost', 'sublabel' => 'You may also enter the IP address of a remote server')); ?>
								<?php echo $this->Html->formLine('dbname', array('label' => 'phpBB3 DB Name', 'type' => 'text', 'class' => 'L')); ?>
								<?php echo $this->Html->formLine('dbuser', array('label' => 'phpBB3 DB User', 'type' => 'text', 'class' => 'L')); ?>
								<?php echo $this->Html->formLine('dbpass', array('label' => 'phpBB3 DB Pass', 'type' => 'text', 'class' => 'L')); ?>
								<?php echo $this->Html->formLine('dbprefix', array('label' => 'phpBB3 DB tables prefix', 'type' => 'text', 'value' => 'phpbb_')); ?>
								</div>
								<div id="kunena_settings" class="board_settings" style="display:none;">
								<?php echo $this->Html->formLine('attachments_names', array('label' => 'Attachments names', 'type' => 'dropdown', 'options' => array(0 => 'Do NOT change', 1 => 'Update to use ChronoForums format'), 'sublabel' => 'If you do not change the names then just copy the attachments folder contents of kunena to Chronoforums attachments path, then enable the "User directory files" setting in Chronoforums settings.')); ?>
								<?php echo $this->Html->formLine('kunena_attachments_path', array('label' => 'Kunena attachments path', 'type' => 'text', 'class' => 'XXL', 'sublabel' => 'The absolute path on server to the Kunena attachments folder, this is only needed if you choose to "update the files names" in the setting above.')); ?>
								</div>
								<?php echo $this->Html->formLine('import_forums', array('value' => 'Import Forums', 'type' => 'button', 'id' => 'import_forums', 'sublabel' => 'Will import all categories and forums from your old board')); ?>
								<?php echo $this->Html->formLine('import_topics', array('value' => 'Import Topics', 'type' => 'button', 'id' => 'import_topics', 'sublabel' => 'Will import all topics from your old board')); ?>
								<?php echo $this->Html->formLine('import_topics_track', array('value' => 'Import Topics Track info', 'type' => 'button', 'id' => 'import_topics_track', 'sublabel' => 'Will import all topics track from your old board')); ?>
								<?php echo $this->Html->formLine('import_topics_subscribe', array('value' => 'Import Topics Subscriptions', 'type' => 'button', 'id' => 'import_topics_subscribe', 'sublabel' => 'Will import all topics subscriptions from your old board')); ?>
								<?php echo $this->Html->formLine('import_posts', array('value' => 'Import Posts', 'type' => 'button', 'id' => 'import_posts', 'sublabel' => 'Will import all posts from your old board')); ?>
								<?php echo $this->Html->formSecEnd(); ?>
							<?php echo $this->Html->formEnd(); ?>
						</div>
						
						<div id="settings" class="tab-pane">
							<?php echo $this->Html->formStart(); ?>
								<?php echo $this->Html->formSecStart(); ?>
								<?php echo $this->Html->formLine('topics_count', array('label' => 'Topics count', 'type' => 'text', 'sublabel' => 'Enter an integer to limit the number of imported topics')); ?>
								<?php echo $this->Html->formLine('posts_count', array('label' => 'Posts count', 'type' => 'text', 'sublabel' => 'Enter an integer to limit the number of imported posts')); ?>
								<?php echo $this->Html->formLine('limit', array('label' => 'Limit', 'type' => 'text', 'value' => 50, 'sublabel' => 'The number of processed topics/posts per iteration')); ?>
								<?php echo $this->Html->formLine('direction', array('label' => 'Direction', 'type' => 'dropdown', 'options' => array('ASC' => 'ASC', 'DESC' => 'DESC'), 'sublabel' => 'DESC will import more recent topics/posts first.')); ?>
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
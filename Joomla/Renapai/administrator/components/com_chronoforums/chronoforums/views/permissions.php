<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	$doc->_('jquery');
	//$doc->_('jquery-ui');
	//$doc->_('forms');
	//$doc->__('tabs', '#details-panel');
	//$doc->__('accordion', '#permissions');
	//$doc->addCssCode('.ui-accordion-content-active{height:auto !important;}');
	
	$this->Toolbar->addButton('save', r_('index.php?ext=chronoforums&act=save_permissions'), l_('SAVE'), $this->Assets->image('save', 'toolbar/'));
	//$this->Toolbar->addButton('separator', r_('index.php?ext=chronoforums'), '&nbsp;', $this->Assets->image('separator', 'toolbar/'), 'false');
	$this->Toolbar->addButton('home', r_('index.php?ext=chronoforums'), l_('HOME'), \GCore\C::get('GCORE_ADMIN_URL').'extensions/chronoforums/assets/images/home.png', 'link');
	
?>
<div class="chrono-page-container">
<div class="container" style="width:100%;">
	<div class="row" style="margin-top:20px;">
		<div class="col-md-6">
			<h3><?php echo l_('PERMISSIONS'); ?></h3>
		</div>
		<div class="col-md-6 pull-right text-right">
			<?php
				echo $this->Toolbar->renderBar();
			?>
		</div>
	</div>
	<div class="row">
	<div class="panel panel-default">
		<div class="panel-body">
			<form action="<?php echo r_('index.php?ext=chronoforums&act=save_permissions'); ?>" method="post" name="admin_form" id="admin_form">
				<div class="container" style="width:100%;">
					<div class="row">
						<div class="col-md-8 pull-right text-right">
							<a id="help_link" href="http://www.chronoengine.com/faqs/68-chronoforums.html" target="_blank" class="btn btn-success pull-left">Find help online on ChronoEngine.com</a>
						</div>
					</div>
					<div class="row">
						<div class="panel panel-warning">
							<div class="panel-heading"><strong><?php echo l_('PERMISSIONS_LEGEND'); ?></strong></div>
							<div class="panel-body">
								<ul>
									<li><strong><?php echo l_('ALLOWED'); ?>:</strong> <?php echo l_('ALLOWED_DESC'); ?></li>
									<li><strong><?php echo l_('INHERITED'); ?>:</strong> <?php echo l_('INHERITED_DESC'); ?></li>
									<li><strong><?php echo l_('NOT_SET'); ?>:</strong> <?php echo l_('NOT_SET_DESC'); ?></li>
									<li><strong><?php echo l_('DENIED'); ?>:</strong> <?php echo l_('DENIED_DESC'); ?></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<ul class="nav nav-pills nav-stacked" id="">
							<?php $counter = 0; ?>
							<?php foreach($perms as $action => $label): ?>
								<li class="<?php echo ($counter == 0) ? 'active':''; ?>"><a href="#permissions-<?php echo $action; ?>" data-g-toggle="tab"><strong><?php echo $label; ?></strong></a></li>
							<?php $counter++; ?>
							<?php endforeach; ?>
							</ul>
						</div>
						<div class="col-md-9">
							<div class="tab-content" id="">
							<?php $counter = 0; ?>
							<?php foreach($perms as $action => $label): ?>
								<div id="permissions-<?php echo $action; ?>" class="tab-pane <?php echo ($counter == 0) ? 'active':''; ?>">
									<div class="panel panel-info">
										<div class="panel-heading"><strong><?php echo $label; ?></strong></div>
										<div class="panel-body">
											<?php foreach($rules as $g_id => $g_name): ?>
												<?php echo $this->Html->formSecStart(); ?>
													<?php echo $this->Html->formLine('Acl[rules]['.$action.']['.$g_id.']', array('type' => 'dropdown', 'label' => $g_name, 'class' => 'M', 'options' => array(0 => l_('INHERITED'), '' => l_('NOT_SET'), 1 => l_('ALLOWED'), -1 => l_('DENIED')))); ?>
												<?php echo $this->Html->formSecEnd(); ?>
											<?php endforeach; ?>
										</div>
									</div>
								</div>
							<?php $counter++; ?>
							<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
				<?php /* ?>
				<div id="details-panel">
					<ul>
						<li><a href="#permissions"><?php echo l_('PERMISSIONS'); ?></a></li>
					</ul>
					<div id="permissions">
						<?php foreach($perms as $action => $label): ?>
							<h3><a href="#"><?php echo $label; ?></a></h3>
							<div>
							<?php foreach($rules as $g_id => $g_name): ?>
								<?php echo $this->Html->formSecStart(); ?>
									<?php echo $this->Html->formLine('Acl[rules]['.$action.']['.$g_id.']', array('type' => 'dropdown', 'label' => $g_name, 'class' => 'M', 'options' => array(0 => l_('INHERITED'), '' => l_('NOT_SET'), 1 => l_('ALLOWED'), -1 => l_('DENIED')))); ?>
								<?php echo $this->Html->formSecEnd(); ?>
							<?php endforeach; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<?php */ ?>
				<?php echo $this->Html->input('Acl[id]', array('type' => 'hidden')); ?>
			</form>
		</div>
	</div>
	</div>
</div>
</div>
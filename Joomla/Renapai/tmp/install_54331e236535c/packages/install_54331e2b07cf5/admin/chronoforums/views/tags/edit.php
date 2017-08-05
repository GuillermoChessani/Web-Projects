<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	$doc->_('jquery');	
	
	$this->Toolbar->addButton('apply', r_('index.php?ext=chronoforums&cont=tags&act=save&save_act=apply'), l_('APPLY'), $this->Assets->image('apply', 'toolbar/'));
	$this->Toolbar->addButton('save', r_('index.php?ext=chronoforums&cont=tags&act=save'), l_('SAVE'), $this->Assets->image('save', 'toolbar/'));
	$this->Toolbar->addButton('cancel', r_('index.php?ext=chronoforums&cont=tags'), l_('CANCEL'), $this->Assets->image('cancel', 'toolbar/'), 'link');
?>
<div class="chrono-page-container">
<div class="container" style="width:100%;">
	<div class="row" style="margin-top:20px;">
		<div class="col-md-6">
			<h3><?php echo l_('TAGS_MANAGER'); ?></h3>
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
			<form action="<?php echo r_('index.php?ext=chronoforums&cont=tags&act=save'); ?>" method="post" name="admin_form" id="admin_form">
				<div id="details-panel">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#general" data-g-toggle="tab"><?php echo l_('GENERAL'); ?></a></li>
					</ul>
					<div class="tab-content">
						<div id="general" class="tab-pane active">
							<?php echo $this->Html->formStart(); ?>
							<?php echo $this->Html->formSecStart(); ?>
							<?php echo $this->Html->formLine('Tag[title]', array('type' => 'text', 'label' => l_('TITLE'), 'class' => 'L')); ?>
							<?php echo $this->Html->formLine('Tag[occurrences]', array('type' => 'text', 'label' => l_('OCCURRENCES'), 'value' => 1, 'sublabel' => l_('OCCURRENCES_DESC'), 'class' => 'S')); ?>
							<?php echo $this->Html->formLine('Tag[published]', array('type' => 'dropdown', 'label' => l_('PUBLISHED'), 'values' => 1, 'options' => array(0 => l_('NO'), 1 => l_('YES')))); ?>
							<?php echo $this->Html->formSecEnd(); ?>
							<?php echo $this->Html->formEnd(); ?>
						</div>
					</div>
				</div>
				<?php echo $this->Html->input('Tag[id]', array('type' => 'hidden')); ?>
			</form>
		</div>
	</div>
	</div>
</div>
</div>
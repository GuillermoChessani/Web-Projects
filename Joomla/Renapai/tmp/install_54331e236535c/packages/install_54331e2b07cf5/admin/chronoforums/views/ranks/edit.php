<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	$doc->_('jquery');
	//$doc->_('jquery-ui');
	$this->Toolbar->addButton('apply', r_('index.php?ext=chronoforums&cont=ranks&act=save&save_act=apply'), l_('APPLY'), $this->Assets->image('apply', 'toolbar/'));
	$this->Toolbar->addButton('save', r_('index.php?ext=chronoforums&cont=ranks&act=save'), l_('SAVE'), $this->Assets->image('save', 'toolbar/'));
	$this->Toolbar->addButton('cancel', r_('index.php?ext=chronoforums&cont=ranks'), l_('CANCEL'), $this->Assets->image('cancel', 'toolbar/'), 'link');
?>
<div class="chrono-page-container">
<div class="container" style="width:100%;">
	<div class="row" style="margin-top:20px;">
		<div class="col-md-6">
			<h3><?php echo l_('RANKS_MANAGER'); ?></h3>
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
			<form action="<?php echo r_('index.php?ext=chronoforums&cont=ranks&act=save'); ?>" method="post" name="admin_form" id="admin_form">
				<div id="details-panel">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#general" data-g-toggle="tab"><?php echo l_('GENERAL'); ?></a></li>
					</ul>
					<div class="tab-content">
						<div id="general" class="tab-pane active">
							<?php echo $this->Html->formStart(); ?>
							<?php echo $this->Html->formSecStart(); ?>
							<?php echo $this->Html->formLine('Rank[title]', array('type' => 'text', 'label' => l_('RANK_TITLE'), 'value' => '', 'class' => '', 'sublabel' => l_('RANK_TITLE_DESC'))); ?>
							<?php echo $this->Html->formLine('Rank[published]', array('type' => 'dropdown', 'label' => l_('RANK_ENABLED'), 'values' => 0, 'options' => array(0 => l_('NO'), 1 => l_('YES')), 'sublabel' => l_('RANK_ENABLED_DESC'))); ?>
							<?php echo $this->Html->formLine('Rank[params][user_posts]', array('type' => 'text', 'label' => l_('RANK_POSTS'), 'value' => '', 'class' => 'S', 'sublabel' => l_('RANK_POSTS_DESC'))); ?>
							<?php echo $this->Html->formLine('Rank[params][user_groups]', array('type' => 'checkbox_group', 'label' => l_('RANK_GROUPS'), 'multiple' => 'multiple', 'options' => $groups, 'sublabel' => l_('RANK_GROUPS_DESC'))); ?>
							<?php echo $this->Html->formLine('Rank[group_id]', array('type' => 'text', 'label' => l_('RANK_GROUP'), 'value' => 0, 'class' => 'S', 'sublabel' => l_('RANK_GROUP_DESC'))); ?>
							<?php echo $this->Html->formLine('Rank[weight]', array('type' => 'text', 'label' => l_('RANK_WEIGHT'), 'value' => 0, 'class' => 'S', 'sublabel' => l_('RANK_WEIGHT_DESC'))); ?>
							<?php echo $this->Html->formLine('Rank[code]', array('type' => 'textarea', 'label' => l_('RANK_CODE'), 'rows' => 10, 'cols' => 80, 'style' => 'width:auto;', 'class' => '', 'sublabel' => l_('RANK_CODE_DESC'))); ?>
							<?php echo $this->Html->formLine('Rank[output]', array('type' => 'textarea', 'label' => l_('RANK_OUTPUT'), 'rows' => 10, 'cols' => 80, 'style' => 'width:auto;', 'class' => '', 'sublabel' => l_('RANK_OUTPUT_DESC'))); ?>
							<?php echo $this->Html->formLine('Rank[params][username_color]', array('type' => 'text', 'label' => l_('RANK_NAME_COLOR'), 'value' => '#000000', 'class' => 'M', 'sublabel' => l_('RANK_NAME_COLOR_DESC'))); ?>
							<?php echo $this->Html->formSecEnd(); ?>
							<?php echo $this->Html->formEnd(); ?>
						</div>
					</div>
				</div>
				<?php echo $this->Html->input('Rank[id]', array('type' => 'hidden')); ?>
			</form>
		</div>
	</div>
	</div>
</div>
</div>
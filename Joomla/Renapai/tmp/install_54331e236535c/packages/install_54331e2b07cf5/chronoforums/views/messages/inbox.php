<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="chronoforums messages inbox">
<div class="container">
	<div class="row cfu-header">
		<?php echo $this->Elements->header(); ?>
	</div>
	<div class="row">
		<h3><?php echo l_('CHRONOFORUMS_PRIVATE_MESSAGING'); ?> - <?php echo l_('CHRONOFORUMS_INBOX'); ?></h3>
	</div>
	<div class="row cfu-nav">
		<div class="col-md-8">
			<ul class="nav nav-pills">
				<li class="active"><a href="<?php echo r_('index.php?ext=chronoforums&cont=messages&act=inbox'); ?>"><?php echo l_('CHRONOFORUMS_INBOX'); ?></a></li>
				<li><a href="<?php echo r_('index.php?ext=chronoforums&cont=messages&act=outbox'); ?>"><?php echo l_('CHRONOFORUMS_OUTBOX'); ?></a></li>
			</ul>
		</div>
		<div class="col-md-4">
			<a class="btn btn-default btn-sm gcoreTooltip pull-right" title="<?php echo l_('CHRONOFORUMS_COMPOSE_DESC'); ?>" href="<?php echo r_("index.php?option=com_chronoforums&cont=messages&act=compose"); ?>"><?php echo l_('CHRONOFORUMS_COMPOSE'); ?></a>
			<?php
				//$this->Toolbar->addButton('remove', r_('index.php?ext=chronoforums&cont=messages&act=delete'), l_('DELETE'), $this->Assets->image('remove', 'toolbar/'), 'submit_selectors');
				$this->Toolbar->addButton('remove', r_('index.php?ext=chronoforums&cont=messages&act=delete'), '<button value="" id="toolbar-button-remove" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i>&nbsp;'.l_('DELETE').'</button>', '', 'submit_selectors');
			?>
		</div>
	</div>
	<div class="row cfu-body">
	<div class="panel panel-default">
		<div class="panel-body">
			<form action="<?php echo r_('index.php?ext=chronoforums&cont=messages'); ?>" method="post" name="admin_form" id="admin_form">
				<?php
					echo $this->DataTable->headerPanel($this->DataTable->_l($this->Paginator->getList()).$this->DataTable->_r($this->Toolbar->renderBar()));
					$this->DataTable->create();
					$this->DataTable->header(
						array(
							'Message.subject' => l_('CHRONOFORUMS_SUBJECT'),
							'MessageUser.username' => l_('CHRONOFORUMS_SENDER'),
							'Message.created' => l_('CHRONOFORUMS_SENT'),
							'CHECK' => $this->Toolbar->selectAll(),
						)
					);
					$new_label = function($cell, $row){
						if(empty($row['MessageRecipient']['opened'])){
							return $cell.' <span class="label label-primary">New</span>';	
						}
						return $cell;
					};
					$view = $this;
					$format_username = function($cell, $row) use ($view) {
						return $view->UserTasks->username(array('User' => $row['MessageUser'], 'Profile' => $row['MessageUserProfile']), false);
					};
					$format_date = function($cell, $row) use ($view) {
						return $view->Output->date_time($cell);
					};
					$this->DataTable->cells($messages_r, array(
						'Message.subject' => array(
							'function' => $new_label,
							'link' => r_('index.php?ext=chronoforums&cont=messages&act=read&m={Message.id}&d={MessageRecipient.discussion_id}'),
							'style' => array('text-align' => 'left')
						),
						'MessageUser.username' => array(
							'function' => $format_username,
							'style' => array('width' => '25%'),
						),
						'Message.created' => array(
							'function' => $format_date,
							'style' => array('width' => '25%'),
						),
						'CHECK' => array(
							'style' => array('width' => '3%'),
							'html' => $this->Toolbar->selector('{Message.id}')
						),
					));
					echo $this->DataTable->build();
					echo $this->DataTable->footerPanel($this->DataTable->_l($this->Paginator->getInfo()).$this->DataTable->_r($this->Paginator->getNav()));
				?>
			</form>
		</div>
	</div>
	</div>
	<div class="row cfu-footer">
		<?php echo $this->Elements->footer(); ?>
	</div>
</div>
</div>
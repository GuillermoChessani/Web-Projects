<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	$doc->_('jquery');
	$this->Toolbar->addButton('add', r_('index.php?ext=chronoforums&cont=forums&act=edit'), 'New', $this->Assets->image('add', 'toolbar/'));
	$this->Toolbar->addButton('save_list', r_('index.php?ext=chronoforums&cont=forums&act=save_list'), 'Update List', $this->Assets->image('save_list', 'toolbar/'), 'submit_selectors');
	$this->Toolbar->addButton('remove', r_('index.php?ext=chronoforums&cont=forums&act=delete'), 'Delete', $this->Assets->image('remove', 'toolbar/'), 'submit_selectors');
	//$this->Toolbar->addButton('separator', r_('index.php?ext=chronoforums'), '&nbsp;', $this->Assets->image('separator', 'toolbar/'), 'false');
	$this->Toolbar->addButton('home', r_('index.php?ext=chronoforums'), l_('HOME'), \GCore\C::get('GCORE_ADMIN_URL').'extensions/chronoforums/assets/images/home.png', 'link');
	
?>
<div class="chrono-page-container">
<div class="container" style="width:100%;">
	<div class="row" style="margin-top:20px;">
		<div class="col-md-6">
			<h3><?php echo l_('FORUMS_MANAGER'); ?></h3>
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
			<form action="<?php echo r_('index.php?ext=chronoforums&cont=forums'); ?>" method="post" name="admin_form" id="admin_form">
				<?php
					echo $this->DataTable->headerPanel($this->DataTable->_l($this->Paginator->getList()));
					$this->DataTable->create();
					$this->DataTable->header(
						array(
							'CHECK' => $this->Toolbar->selectAll(),
							'Forum.title' => $this->Sorter->link('Title', 'Forum.title'),
							'Category.title' => 'Category',
							'Forum.ordering' => 'Ordering',
							'Forum.published' => l_('PUBLISHED'),
							'Forum.id' => $this->Sorter->link('Forum ID', 'Forum.id')
						)
					);
					$this->DataTable->cells($forums, array(
						'CHECK' => array(
							'style' => array('width' => '5%'),
							'html' => $this->Toolbar->selector('{Forum.id}')
						),
						'Forum.title' => array(
							'link' => r_('index.php?ext=chronoforums&cont=forums&act=edit&id={Forum.id}'),
							'style' => array('text-align' => 'left')
						),
						'Category.title' => array(
							'style' => array('width' => '25%'),
						),
						'Forum.ordering' => array(
							'style' => array('width' => '10%'),
							'field' => $this->Html->input('Forum[{Forum.id}][ordering]', array('type' => 'text', 'value' => '{Forum.ordering}', 'class' => 'SS', 'size' => 3, 'maxlength' => 3, 'onclick' => 'toggleRowActive(this);')),
						),
						'Forum.published' => array(
							'link' => array(r_('index.php?ext=chronoforums&cont=forums&act=toggle&gcb={Forum.id}&val=1&fld=published'), r_('index.php?ext=chronoforums&cont=forums&act=toggle&gcb={Forum.id}&val=0&fld=published')),
							'image' => array($this->Assets->image('disabled.png'), $this->Assets->image('enabled.png')),
							'style' => array('width' => '15%'),
						),
						'Forum.id' => array(
							'style' => array('width' => '15%'),
						)
					));
					echo $this->DataTable->build();
					echo $this->DataTable->footerPanel($this->DataTable->_l($this->Paginator->getInfo()).$this->DataTable->_r($this->Paginator->getNav()));
				?>
			</form>
		</div>
	</div>
	</div>
</div>
</div>
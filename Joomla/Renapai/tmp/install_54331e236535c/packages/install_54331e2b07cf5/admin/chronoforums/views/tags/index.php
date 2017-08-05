<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	//$doc->_('datatable');
	$doc->_('jquery');
	//$doc->_('jquery-ui');
	//$this->Toolbar->setTitle(l_('TAGS_MANAGER'));
	$this->Toolbar->addButton('tag_topics', r_('index.php?ext=chronoforums&cont=tags&act=tag_topics'), 'Tag Topics', \GCore\C::get('GCORE_ADMIN_URL').'extensions/chronoforums/assets/images/tag_topics.png', 'submit_selectors');
	$this->Toolbar->addButton('add', r_('index.php?ext=chronoforums&cont=tags&act=edit'), 'New', $this->Assets->image('add', 'toolbar/'));
	//$this->Toolbar->addButton('save_list', r_('index.php?ext=chronoforums&cont=tags&act=save_list'), 'Update List', $this->Assets->image('save_list', 'toolbar/'), 'submit_selectors');
	$this->Toolbar->addButton('remove', r_('index.php?ext=chronoforums&cont=tags&act=delete'), 'Delete', $this->Assets->image('remove', 'toolbar/'), 'submit_selectors');
	//$this->Toolbar->addButton('separator', r_('index.php?ext=chronoforums'), '&nbsp;', $this->Assets->image('separator', 'toolbar/'), 'false');
	$this->Toolbar->addButton('home', r_('index.php?ext=chronoforums'), l_('HOME'), \GCore\C::get('GCORE_ADMIN_URL').'extensions/chronoforums/assets/images/home.png', 'link');
	
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
			<form action="<?php echo r_('index.php?ext=chronoforums&cont=tags'); ?>" method="post" name="admin_form" id="admin_form">
				<?php
					echo $this->DataTable->headerPanel($this->DataTable->_l($this->Paginator->getList()));
					$this->DataTable->create();
					$this->DataTable->header(
						array(
							'CHECK' => $this->Toolbar->selectAll(),
							'Tag.title' => $this->Sorter->link('Title', 'Tag.title'),
							'Tag.topic_count' => l_('TOPICS_COUNT'),
							'Tag.occurrences' => l_('OCCURRENCES'),
							'Tag.hits' => l_('HITS'),
							'Tag.published' => l_('PUBLISHED'),
							'Tag.id' => $this->Sorter->link('Tag ID', 'Tag.id')
						)
					);
					$this->DataTable->cells($tags, array(
						'CHECK' => array(
							'style' => array('width' => '5%'),
							'html' => $this->Toolbar->selector('{Tag.id}')
						),
						'Tag.title' => array(
							'link' => r_('index.php?ext=chronoforums&cont=tags&act=edit&id={Tag.id}'),
							'style' => array('text-align' => 'left')
						),
						'Tag.topic_count' => array(
							'function' => create_function('$cell, $row', 'return !empty($row["TagCounter"][0]["count"]) ? $row["TagCounter"][0]["count"] : "-";'),
							'style' => array('width' => '10%'),
						),
						'Tag.occurrences' => array(
							'style' => array('width' => '10%'),
						),
						'Tag.hits' => array(
							'style' => array('width' => '10%'),
						),
						'Tag.published' => array(
							'link' => array(r_('index.php?ext=chronoforums&cont=tags&act=toggle&gcb={Tag.id}&val=1&fld=published'), r_('index.php?ext=chronoforums&cont=tags&act=toggle&gcb={Tag.id}&val=0&fld=published')),
							'image' => array($this->Assets->image('disabled.png'), $this->Assets->image('enabled.png')),
							'style' => array('width' => '15%'),
						),
						'Tag.id' => array(
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
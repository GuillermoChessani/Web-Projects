<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="chronoforums forums index">
<?php $r_k = 1; ?>
<a name="start_here"></a>
<div class="container">
<?php
if(empty($forum) AND empty($searched) AND empty($global_listing)){
	goto no_topics;
	return;
}
?>
	<div class="row cfu-header">
		<?php echo $this->Elements->header(); ?>
	</div>
	<?php
		if(empty($topics) AND empty($searched) AND !isset($forum)){
			goto no_topics;
		}
	?>
	<?php if(!empty($searched)): ?>
	<div class="row cfu-search-title">
		<h3><?php $this->TopicTasks->search_title(); ?></h3>
	</div>
	<?php endif; ?>

	<?php if(empty($global_listing)): ?>
	<div class="row cfu-title">
		<h2><?php $this->TopicTasks->forum_title($forum); ?></h2>
	</div>
	<?php endif; ?>
	<div class="row" style="display: none;">
		<span>
		<?php echo $forum['Forum']['description']; ?>
		</span>
	</div>
	<div class="row cfu-pagination">
		<div class="pull-right text-right">
			<?php $this->TopicTasks->paginator('data'); ?>
		</div>
	</div>
	<div class="row cfu-head">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="col-md-2 cfu-new">
					<?php if(empty($searched) AND empty($custom_listing)): ?>
					<?php $this->TopicTasks->new_topic_button($forum); ?>
					<?php endif; ?>
				</div>
				<?php if(empty($global_listing)): ?>
				<div class="col-md-4 cfu-search">
					<?php $this->TopicTasks->search_form($forum); ?>
				</div>
				<?php endif; ?>
				<div class="col-md-4 pull-right cfu-pagination">
					<?php if(!empty($topics)): ?>
						<?php $this->TopicTasks->paginator('info'); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php if(!empty($topics)): ?>
	<div class="row cfu-topics">
		<form action="<?php echo r_('index.php?option=com_chronoforums&cont=topics'); ?>" method="post" name="topictasksform">
			<div class="panel panel-default">
				<div class="panel-body">
				<table class="table table-hover table-censored cfu-table">
					<thead class="cfu-head">
						<tr>
							<th class="cfu-topic"><?php echo l_('CHRONOFORUMS_TOPICS'); ?></th>
							<th class="cfu-author"><?php echo l_('CHRONOFORUMS_AUTHOR'); ?></th>
							<?php if((bool)$fparams->get('enable_topic_replies', 1) === true AND $fparams->get('topic_replies_display', 'label') == 'text'): ?>
							<th class="cfu-replies"><?php echo l_('CHRONOFORUMS_REPLIES'); ?></th>
							<?php endif; ?>
							<?php if((bool)$fparams->get('enable_topic_views', 1) === true AND $fparams->get('topic_views_display', 'label') == 'text'): ?>
							<th class="cfu-views"><?php echo l_('CHRONOFORUMS_VIEWS'); ?></th>
							<?php endif; ?>
							<th class="cfu-lastpost"><?php echo l_('CHRONOFORUMS_LASTPOST'); ?></th>
							<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics')): ?>
							<th class="cfu-check">#</th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
					<?php foreach($topics as $topic): ?>
						<?php $r_k = 1 - $r_k; ?>
						<tr class="cfu-topic<?php if(empty($topic['Topic']['published'])): ?> danger<?php endif; ?><?php if(!empty($topic['Topic']['reported'])): ?><?php endif; ?>">
							<td>
								<?php //echo $this->TopicTasks->read_status($topic); ?>
								<?php $this->TopicTasks->row_title($topic); ?>
								<?php if(!empty($global_listing)): ?>
								<br />
								<i class="fa fa-folder-open"></i> <?php $this->TopicTasks->topic_category($topic); ?> <i class="fa fa-angle-right"></i> <?php $this->TopicTasks->topic_forum($topic); ?>
								<?php endif; ?>
								<br />
								<?php $this->TopicTasks->datetime_icon($topic); ?>
								<?php //$this->TopicTasks->attachments_icon($topic); ?>
								<?php $this->TopicTasks->status($topic); ?>
								<?php $this->TopicTasks->attachments_icon($topic); ?>
							</td>
							<td><?php echo $this->UserTasks->username(array('User' => $topic['TopicAuthor'], 'Profile' => $topic['TopicAuthorProfile'])); ?></td>
							<?php if((bool)$fparams->get('enable_topic_replies', 1) === true AND $fparams->get('topic_replies_display', 'label') == 'text'): ?>
							<td><?php echo ($topic['Topic']['post_count'] > 0 ? $topic['Topic']['post_count'] - 1 : 0); ?></td>
							<?php endif; ?>
							<?php if((bool)$fparams->get('enable_topic_views', 1) === true AND $fparams->get('topic_views_display', 'label') == 'text'): ?>
							<td><?php echo $topic['Topic']['hits']; ?></td>
							<?php endif; ?>
							<td class="cfu-lastpost">
								<?php if(!empty($topic['Topic']['last_post'])): ?>
									<i class="fa fa-lg- fa-user"></i><?php echo $this->UserTasks->username(array('User' => $topic['PostAuthor'], 'Profile' => $topic['PostAuthorProfile'])); ?>
									<a href="<?php echo r_("index.php?option=com_chronoforums&cont=posts&f=".$topic['Topic']['forum_id']."&t=".$topic['Topic']['id']."&p=".$topic['LastPost']['id']."#p".$topic['LastPost']['id']); ?>" class="gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_VIEW_LATEST_POST'); ?>" alt="<?php echo l_('CHRONOFORUMS_VIEW_LATEST_POST'); ?>"><span class="fa fa-arrow-circle-right"></span></a>
									<span class="cfu-time">
										<i class="fa fa-calendar"></i>
										<small><?php echo $this->Output->date_time($topic['LastPost']['created']); ?></small>
									</span>
								<?php endif; ?>
							</td>
							<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics')): ?>
							<td><?php $this->TopicTasks->selector($topic); ?></td>
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="panel panel-default cfu-foot">
				<div class="panel-body">
					<div class="col-md-2 cfu-search">
						<?php if(empty($searched) AND empty($custom_listing)): ?>
							<?php $this->TopicTasks->new_topic_button($forum); ?>
						<?php endif; ?>
					</div>
					<div class="col-md-4 pull-right cfu-pagination">
						<?php $this->TopicTasks->paginator('info'); ?>
					</div>
				</div>
				<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics')): ?>
				<div class="panel-footer cfu-tasks">
					<div class="container">
						<div class="row">
							<div class="col-md-8 pull-right">
							<?php if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'modify_topics')): ?>
								<?php $this->TopicTasks->tasks_form(); ?>
							<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</form>
	</div>
	<?php endif; ?>
	<div class="row cfu-pagination">
		<div class="pull-right text-right">
			<?php $this->TopicTasks->paginator('data'); ?>
		</div>
	</div>
	<?php no_topics: ?>
	<?php if(empty($topics) AND empty($searched) AND !isset($forum)): ?>
		<div class="row cfu-empty">
			<?php $this->TopicTasks->no_topics(); ?>
		</div>
	<?php endif; ?>
	<div class="row cfu-footer">
		<?php echo $this->Elements->footer(); ?>
	</div>
</div>
</div>
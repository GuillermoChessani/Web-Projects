<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="chronoforums categories index">
<div class="container">
	<div class="row cfu-header">
		<?php echo $this->Elements->header(); ?>
	</div>
	<div class="row cfu-body">
		<?php if(!empty($categories)): ?>
		<?php foreach($categories as $category): ?>
		<?php
			if((bool)$fparams->get('forum_permissions', 0) === true AND (empty($category['Category']['rules']['display']) OR !\GCore\Libs\Authorize::check_rules($category['Category']['rules']['display']))){
				continue;
			}
			if(!empty($category['Category']['params']['languages']) AND (!in_array(\GCore\Libs\Base::getConfig('site_language'), explode(',', trim($category['Category']['params']['languages']))))){
				continue;
			}
		?>
		<div class="panel panel-default cfu-category">
			<div class="panel-heading cfu-head">
				<h4>
					<i class="fa fa-lg fa-fw fa-folder<?php if($fparams->get('load_forums_list', 1)): ?>-open<?php endif; ?>-o"></i>
					<a href="<?php echo r_("index.php?option=com_chronoforums&c=".$category['Category']['id']); ?>"><?php echo $category['Category']['title']; ?></a>
					<?php if(!empty($category['Category']['description'])): ?>
						<small class="cfu-description"><?php echo $category['Category']['description']; ?></small>
					<?php endif; ?>
				</h4>
			</div>
			<?php if(!empty($category['Forum'])): ?>
				<div class="panel-body">
				<table class="table table-censored table-hover cfu-table">
					<thead class="cfu-head">
						<tr>
							<th class="cfu-forum"><?php echo l_('CHRONOFORUMS_FORUM'); ?></th>
							<th><?php echo l_('CHRONOFORUMS_TOPICS'); ?></th>
							<th><?php echo l_('CHRONOFORUMS_POSTS'); ?></th>
							<th><?php echo l_('CHRONOFORUMS_LASTPOST'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($category['Forum'] as $k => $forum): ?>
						<?php
							if((bool)$fparams->get('forum_permissions', 0) === true AND (empty($forum['rules']['display']) OR !\GCore\Libs\Authorize::check_rules($forum['rules']['display']))){
								continue;
							}
						?>
						<tr class="cfu-row"<?php if((bool)$fparams->get('display_forum_icon', 0) === true): ?> style="background-image: url('<?php echo $this->Output->forum_icon($forum); ?>'); background-repeat: no-repeat; background-position:center left;"<?php endif; ?>>
							<td class="cfu-forum"<?php if((bool)$fparams->get('display_forum_icon', 0) === true): ?> style="padding-left:38px !important;"<?php endif; ?>>
								<?php if((bool)$fparams->get('display_forum_icon', 0) === false): ?>
								<i class="fa fa-lg fa-fw fa-folder-o"></i>
								<?php endif; ?>
								<a href="<?php echo r_("index.php?option=com_chronoforums&cont=forums&f=".$forum['id']."&alias=".$forum['alias']); ?>" class="cfu-title gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_READ_POSTS'); ?>"><?php echo $forum['title']; ?></a>
								<?php if($forum['description']): ?>
									<small class="cfu-description">
										<?php echo $forum['description']; ?>
									</small>
								<?php endif; ?>
							</td>
							<td>
								<?php if(!empty($forum['topic_count'])): ?>
									<?php echo (int)$forum['topic_count']; ?>
								<?php else: ?>
									<span class="label label-danger"><?php echo l_('CHRONOFORUMS_EMPTY'); ?></span>
								<?php endif; ?>
							</td>

							<td>
								<?php if(!empty($forum['post_count'])): ?>
									<?php echo (int)$forum['post_count']; ?>
								<?php else: ?>
									<span class="label label-danger"><?php echo l_('CHRONOFORUMS_EMPTY'); ?></span>
								<?php endif; ?>
							</td>

							<td class="cfu-lastpost">
								<span>
									<?php if(!empty($category['LastForumPost'][$k]['id'])): ?>
										<i class="fa fa-lg- fa-user"></i><?php echo $this->UserTasks->username(array('User' => $category['PostAuthor'][$k], 'Profile' => $category['Profile'][$k])); ?>
										<a href="<?php echo r_("index.php?option=com_chronoforums&cont=posts&t=".$category['LastForumPost'][$k]['topic_id']."&p=".$category['LastForumPost'][$k]['id']."#p".$category['LastForumPost'][$k]['id']); ?>" title="<?php echo l_('CHRONOFORUMS_VIEW_LATEST_POST'); ?>" alt="<?php echo l_('CHRONOFORUMS_VIEW_LATEST_POST'); ?>" class="gcoreTooltip"><span class="fa fa-arrow-circle-o-right"></span></a>
										<span class="cfu-time">
											<i class="fa fa-calendar"></i>
											<small><?php echo $this->Output->date_time($category['LastForumPost'][$k]['created']); ?></small>
										</span>
									<?php else: ?>
										<span class="label label-danger"><?php echo l_('CHRONOFORUMS_EMPTY'); ?></span>
									<?php endif; ?>
								</span>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				</div>
			<?php endif; ?>
		</div>
		<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<div class="row cfu-footer">
		<?php echo $this->Elements->footer(); ?>
	</div>
</div>
</div>
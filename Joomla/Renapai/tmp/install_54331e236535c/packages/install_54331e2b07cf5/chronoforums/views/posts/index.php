<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($this->data['posts_loader'])){
		goto posts_output;
	}
	$doc = \GCore\Libs\Document::getInstance();
	$doc->_('gmagnify');
?>
<div class="chronoforums posts index">
<a name="start_here"></a>
<div class="container">
	<div class="row cfu-header">
		<?php echo $this->Elements->header(); ?>
	</div>
	<?php if(!empty($posts) OR !empty($keywords)): ?>
		<?php $this->Paginator->url = 'index.php?option=com_chronoforums&cont=posts&f='.$topic['Forum']['id'].'&t='.$topic['Topic']['id'].(!empty($searched) ? "&hilit=".$searched : ''); ?>
		<div class="row cfu-forum-description" style="display: none;">
			<span>
			<?php echo $topic['Forum']['description']; ?>
			</span>
		</div>
		<div class="row cfu-topic">
			<div class="col-md-12 cfu-title">
				<h2><?php $this->TopicTasks->topic_title($topic); ?></h2>
			</div>
		</div>
		<div class="row cfu-tags">
			<?php if(!empty($tags)): ?>
			<div class="col-md-6 pull-right">
				<?php $this->TopicTasks->tags_form($topic, $tags); ?>
			</div>
			<?php endif; ?>
			<?php if((bool)$fparams->get('list_topic_tags', 0) === true): ?>
			<div class="col-md-6 pull-right text-right">
				<?php $this->TopicTasks->tags_list($topic); ?>
			</div>
			<?php endif; ?>
		</div>
		<div class="row cfu-pagination">
			<div class="col-md-6 pull-right text-right cfu-tags">
				<?php $this->TopicTasks->paginator('data'); ?>
			</div>
		</div>
		<div class="row cfu-topic">
			<div class="panel panel-default cfu-head">
				<div class="panel-heading cfu-topic-status">
					<div class="pull-left">
						<?php $this->TopicTasks->status($topic); ?>
					</div>
					<div class="pull-right btn-group-xs">
						<?php $this->TopicTasks->move_link($topic); ?>
						<?php $this->TopicTasks->lock_link($topic); ?>
						<?php $this->TopicTasks->publish_link($topic); ?>
						<?php $this->TopicTasks->announce_link($topic); ?>
						<?php $this->TopicTasks->sticky_link($topic); ?>
						<?php $this->TopicTasks->delete_link($topic); ?>
						<?php $this->TopicTasks->delete_author_link($topic); ?>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<div class="col-md-2 cfu-reply">
						<?php $this->TopicTasks->reply_button($topic); ?>
					</div>
					<div class="col-md-3 cfu-search">
						<?php $this->PostTasks->search_form($topic); ?>
					</div>
					<div class="col-md-2">
						<div class="btn-group btn-group-xs">
							<?php $this->TopicTasks->favorite_button($topic); ?>
							<?php $this->TopicTasks->feature_button($topic); ?>
						</div>
					</div>
					<div class="col-md-4 pull-right cfu-paginator">
						<?php $this->TopicTasks->paginator('info'); ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php posts_output: ?>
	<?php
		//check posts profiles
		if($fparams->get('posts_mini_profile', 1)){
			$post_width = 9;
			$profile_width = 3;
		}else{
			$post_width = 12;
			$profile_width = 0;
		}
	?>
	<?php $r_k = 1; ?>
	<?php if(!empty($posts)): ?>
		<?php foreach($posts as $post): ?>
		<?php $r_k = 1 - $r_k; ?>
		<div class="row cfu-post cfu-bg<?php echo $r_k + 1; ?>" id="p<?php echo $post['Post']['id']; ?>">
			<?php
				$post_class = 'panel-default';
				if(!empty($post['Report'])){
					$post_class = 'panel-warning';
				}else if(empty($post['Post']['published'])){
					$post_class = 'panel-danger';
				}else if($post['Post']['id'] == $posts[0]['Post']['id'] AND empty($this->data['posts_loader']) AND $this->Paginator->page == 1){
					$post_class = 'panel-info';
				}else if(!empty($topic['Answer']['post_id']) AND $topic['Answer']['post_id'] == $post['Post']['id']){
					$post_class = 'panel-success';
				}
				$post_title_width = 9;
				if((bool)$fparams->get('post_title_author', 0)){
					$post_title_width = 7;
				}
			?>
			<div class="panel <?php echo $post_class; ?>">
				<div class="panel-heading cfu-head">
					<div class="container">
						<div class="row">
							<div class="col-lg-<?php echo $post_title_width; ?>">
								<h3 class="panel-title cfu-title"><?php $this->PostTasks->title($post, $topic); ?></h3>
							</div>
							<div class="col-lg-<?php echo 12 - $post_title_width; ?> pull-right">
								<span class="pull-right">
									<i class="fa fa-fw fa-calendar"></i>
									<small class="cfu-time"><?php echo $this->Output->date_time($post['Post']['created']); ?></small>
								</span>
								<?php if((bool)$fparams->get('post_title_author', 0)): ?>
								<small class="cfu-user-info pull-right">
									<i class="fa fa-lg- fa-user"></i><?php echo $this->UserTasks->username(array('User' => $post['PostAuthor'], 'Profile' => $post['Profile'])); ?>
								</small>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body cfu-body">
					<div class="container">
						<div class="row">
							<div class="col-lg-<?php echo $post_width; ?> cfu-data">
								<?php
									list($content, $attachments) = $this->PostTasks->content($post);
								?>
								<?php $this->PostTasks->selected_answer_label($post, $topic); ?>
								<?php $this->PostTasks->reported_label($post, $topic); ?>
								<?php $this->PostTasks->votes_label($post, $topic); ?>
								<div class="btn-group_x btn-group-xs pull-right">
									<?php if(0)://(bool)$fparams->get('quick_post_tools', 1) === true): ?>
										<?php $this->PostTasks->tools_list($post, $topic); ?>
									<?php else: ?>
										<?php $this->PostTasks->vote_link($post, $topic); ?>
										<?php $this->PostTasks->select_answer_link($post, $topic); ?>
										<?php $this->PostTasks->quote_link($post, $topic); ?>
										<?php $this->PostTasks->report_link($post, $topic); ?>
										<?php
											if(empty($post['Post']['published'])){
												$this->PostTasks->publish_link($post, $topic);
											}else{
												$this->PostTasks->unpublish_link($post, $topic);
											}
										?>
										<?php $this->PostTasks->edit_link($post, $topic); ?>
										<?php $this->PostTasks->delete_link($post, $topic); ?>
										<?php $this->PostTasks->delete_author_link($post, $topic); ?>
										<?php //$this->PostTasks->mod_link($post, $topic); ?>
									<?php endif; ?>
								</div>
								<div class="clearfix"></div>
								<div class="cfu-content"><?php echo $content; ?></div>
								<?php if(!empty($attachments) AND \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'list_attachments')): ?>
									<ul class="list-group cfu-attachments">
										<?php foreach($attachments as $k => $attachment_output): ?>
										<li href="#" class="list-group-item cfu-attachment">
											<h4 class="list-group-item-heading"></h4>
											<?php echo $attachment_output; ?>
										</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
								<?php if(!empty($post['Profile']['params']['signature'])): ?>
									<hr />
									<span class="cfu-signature" id="sig<?php echo $post['Post']['id']; ?>">
										<?php echo $this->UserTasks->signature(array('User' => $post['PostAuthor'], 'Profile' => $post['Profile'])); ?>
									</span>
								<?php endif; ?>
							</div>
							<?php if(!empty($profile_width)): ?>
							<div class="col-lg-<?php echo $profile_width; ?> cfu-profile">
								<?php if(!empty($post['PostAuthor']['id'])): ?>
								<div class="panel panel-default<?php if($this->UserTasks->is_online($post['PostAuthor']['id'])): ?> panel-success<?php endif; ?>">
									<div class="panel-heading">
										<h5 class="text-center"><?php echo $this->UserTasks->username(array('User' => $post['PostAuthor'], 'Profile' => $post['Profile']), false); ?></h5>
									</div>
									<div class="panel-body">
										<div class="text-center">
										<?php if((bool)$fparams->get('show_post_author_avatar', 1) AND !empty($post['Profile']['params']['avatar'])): ?>
											<div class="center-block"><?php echo $this->UserTasks->avatar(array('User' => $post['PostAuthor'], 'Profile' => $post['Profile'])); ?></div>
										<?php endif; ?>
										<?php if($fparams->get('load_ranks', 0)): ?>
										<div class="cfu-ranks">
											<?php echo $this->UserTasks->display_ranks(array('User' => $post['PostAuthor'], 'Profile' => $post['Profile'])); ?>
										</div>
										<?php endif; ?>
										</div>
										<?php if((bool)$fparams->get('show_author_posts_count', 1)): ?>
										<small><span class="btn btn-xs gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_POSTS'); ?>"><i class="fa fa-fw fa-lg fa-comments"></i></span> <?php echo $this->UserTasks->post_count(array('User' => $post['PostAuthor'], 'Profile' => $post['Profile'])); ?></small>
										<?php endif; ?>
										<?php if((bool)$fparams->get('enable_reputation', 0)): ?>
										<small><span class="btn btn-xs gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_REPUTATION'); ?>"><i class="fa fa-fw fa-lg fa-thumbs-o-up"></i></span> <?php echo $post['Profile']['reputation']; ?></small>
										<?php endif; ?>
										<?php if((bool)$fparams->get('show_author_join_date', 1)): ?>
										<br><small><span class="btn btn-xs gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_JOINED'); ?>"><i class="fa fa-fw fa-lg fa-credit-card"></i></span> <?php echo $this->UserTasks->join_date(array('User' => $post['PostAuthor'], 'Profile' => $post['Profile'])); ?></small>
										<?php endif; ?>
									</div>
									<div class="panel-footer">
										<span class="text-right">
											<?php if($fparams->get('enable_pm', 1)): ?>
												<a class="btn btn-default btn-xs gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_SEND_PRIVATE_MESSAGING'); ?>" href="<?php echo r_("index.php?option=com_chronoforums&cont=messages&act=compose&u=".$post['PostAuthor']['id']); ?>"><i class="fa fa-envelope fa-lg fa-fw"></i><?php echo l_('CHRONOFORUMS_PM'); ?></a>
											<?php endif; ?>
										</span>
										<?php if($this->UserTasks->is_online($post['PostAuthor']['id'])): ?>
											<span class="label label-success"><i class="fa fa-laptop fa-lg"></i>&nbsp;<?php echo l_('CHRONOFORUMS_ONLINE'); ?></span>
										<?php endif; ?>
									</div>
								</div>
								<?php else: ?>
									<p><?php echo l_('CHRONOFORUMS_GUEST'); ?></p>
								<?php endif; ?>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php if(!empty($post['Report'])): ?>
				<div class="panel-footer">
					<?php $this->PostTasks->reports_list($post); ?>
				</div>
				<?php endif; ?>
				<?php if(!empty($this->data['topic_info']) AND ($post['Post']['id'] == $posts[0]['Post']['id'])): ?>
				<div class="panel-footer">
					<?php echo $fparams->get('extra_topic_info_output', ''); ?>
				</div>
				<?php endif; ?>
			</div>
		</div>

		<?php endforeach; ?>
	<?php endif; ?>
	<?php
		if(!empty($this->data['posts_loader'])){
			return;
		}
	?>
	<?php $this->TopicTasks->posts_loader($topic); ?>
	<?php if(!empty($posts)): ?>
		<div class="row cfu-topic">
			<div class="panel panel-default cfu-foot">
				<div class="panel-body">
					<div class="col-md-2">
						<?php $this->TopicTasks->reply_button($topic); ?>
					</div>
					<div class="col-md-4 pull-right">
						<?php $this->TopicTasks->paginator('info'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row cfu-pagination">
			<div class="pull-right text-right">
				<?php $this->TopicTasks->paginator('data'); ?>
			</div>
		</div>
		<div class="row cfu-quickreply">
			<?php $this->TopicTasks->quick_reply(); ?>
		</div>
	<?php else: ?>
		<div class="row cfu-empty">
			<?php $this->TopicTasks->no_posts(); ?>
		</div>
	<?php endif; ?>
	<div class="row cfu-footer">
		<?php echo $this->Elements->footer((!empty($topic) ? array('topic' => $topic, 'subscribed' => isset($subscribed) ? $subscribed : array()) : array())); ?>
	</div>
</div>
</div>
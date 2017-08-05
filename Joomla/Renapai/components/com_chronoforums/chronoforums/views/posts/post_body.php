<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $topic = $post['Topic']; ?>
<div class="cfu-post">
	<div class="panel panel-default<?php if(!empty($post['Report'])){echo ' panel-warning'; $reported = true;} ?><?php if(empty($reported) AND !empty($topic['Answer']['post_id']) AND $topic['Answer']['post_id'] == $post['Post']['id'])echo ' panel-success'; ?>">
		<div class="panel-heading cfu-head">
			<div class="container">
				<div class="row">
					<div class="col-lg-7">
						<h3 class="panel-title cfu-title"><?php $this->PostTasks->title($post); ?></h3>
					</div>
					<div class="col-lg-5 pull-right">
						<span class="pull-right">
							<i class="fa fa-fw fa-calendar"></i>
							<small class="cfu-time"><?php echo $this->Output->date_time($post['Post']['created']); ?></small>
						</span>
						<small class="cfu-user-info pull-right">
							<i class="fa fa-lg- fa-user"></i><?php echo $this->UserTasks->username(array('User' => $post['PostAuthor'], 'Profile' => $post['Profile'])); ?>
						</small>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-body">
			<div class="container">
				<div class="row">
					<div class="col-lg-9">
						<?php
							list($content, $attachments) = $this->PostTasks->content($post);
						?>
						<?php $this->PostTasks->selected_answer_label($post, $topic); ?>
						<?php $this->PostTasks->reported_label($post, $topic); ?>
						<br>
						<div class="cfu-content"><?php echo $content; ?></div>
						<?php if(!empty($attachments) AND \GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'list_attachments')): ?>
							<ul class="list-group cfu-attachments">
								<?php foreach($attachments as $k => $attachment_output): ?>
								<li href="#" class="list-group-item">
									<h4 class="list-group-item-heading"></h4>
									<?php echo $attachment_output; ?>
									<?php endforeach; ?>
								</li>
							</ul>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
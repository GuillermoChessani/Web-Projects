<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="gbs3">
<div class="chronoforums profiles mini">
	<div class="cfu-profile">
		<table>
			<tr>
				<td class="cfu-avatar">
					<?php if((bool)$fparams->get('show_post_author_avatar', 1) AND !empty($user['Profile']['params']['avatar'])): ?>
						<?php echo $this->UserTasks->avatar(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?>
					<?php endif; ?>
					<h5 class="text-center"><?php echo $this->UserTasks->username(array('User' => $user['User'], 'Profile' => $user['Profile']), false); ?></h5>
				</td>
				<td class="cfu-info">
					<div class="text-center">
					<?php if($fparams->get('load_ranks', 0)): ?>
					<div class="cfu-ranks">
						<?php echo $this->UserTasks->display_ranks(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?>
					</div>
					<?php endif; ?>
					</div>
					<?php if((bool)$fparams->get('show_author_posts_count', 1)): ?>
					<small class="cfu-posts"><span class="btn btn-xs gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_POSTS'); ?>"><i class="fa fa-fw fa-lg fa-comments"></i></span> <?php echo $this->UserTasks->post_count(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?></small>
					<br>
					<?php endif; ?>
					<?php if((bool)$fparams->get('show_author_join_date', 1)): ?>
					<small class="cfu-join"><span class="btn btn-xs gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_JOINED'); ?>"><i class="fa fa-fw fa-lg fa-credit-card"></i></span> <?php echo $this->UserTasks->join_date(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?></small>
					<?php endif; ?>
				</td>
			</tr>
		</table>
		<?php /*
		<div class="thumbnail">
			<div class="caption<?php if($this->UserTasks->is_online($user['User']['id'])){echo ' alert-success';} ?>">
			<?php if(!empty($user['User']['id'])): ?>
				<?php if((bool)$fparams->get('show_post_author_avatar', 1) AND !empty($user['Profile']['params']['avatar'])): ?>
					<div class="center-block"><?php echo $this->UserTasks->avatar(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?></div>
				<?php endif; ?>
				<div>
					<div class="text-center">
					<h5 class="text-center"><?php echo $this->UserTasks->username(array('User' => $user['User'], 'Profile' => $user['Profile']), false); ?></h5>
					<?php if($fparams->get('load_ranks', 0)): ?>
					<div class="cfu-ranks">
						<?php echo $this->UserTasks->display_ranks(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?>
					</div>
					<?php endif; ?>
					</div>
					<?php if((bool)$fparams->get('show_author_posts_count', 1)): ?>
					<small class="cfu-posts"><span class="btn btn-xs gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_POSTS'); ?>"><i class="fa fa-fw fa-lg fa-comments"></i></span> <?php echo $this->UserTasks->post_count(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?></small>
					<br>
					<?php endif; ?>
					<?php if((bool)$fparams->get('show_author_join_date', 1)): ?>
					<small class="cfu-join"><span class="btn btn-xs gcoreTooltip" title="<?php echo l_('CHRONOFORUMS_JOINED'); ?>"><i class="fa fa-fw fa-lg fa-credit-card"></i></span> <?php echo $this->UserTasks->join_date(array('User' => $user['User'], 'Profile' => $user['Profile'])); ?></small>
					<?php endif; ?>
				</div>
			<?php else: ?>
				<p><?php echo l_('CHRONOFORUMS_GUEST'); ?></p>
			<?php endif; ?>
			</div>
		</div>
		*/ ?>
	</div>
</div>
</div>
<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$doc = \GCore\Libs\Document::getInstance();
	$user = \GCore\Libs\Base::getUser();
	$u = ($message['MessageUser']['id'] == $user['id']) ? $message['MessageRecipientUser']['id'] : $message['MessageUser']['id'];
	$d = $message['MessageRecipient']['discussion_id'];
?>
<div class="chronoforums messages read">
<div class="cfu-body">
	<div class="container">
		<div class="row cfu-header">
			<?php echo $this->Elements->header(); ?>
		</div>
		<div class="row">
			<!--<h3><?php echo l_('CHRONOFORUMS_PRIVATE_MESSAGING'); ?> - <?php echo l_('CHRONOFORUMS_MESSAGE'); ?></h3>-->
			<h3 class="cfu-subject"><?php echo $message['Message']['subject']; ?></h3>
		</div>
		<div class="row cfu-details">
			<div class="panel panel-info">
				<div class="panel-heading">
					<a title="<?php echo l_('CHRONOFORUMS_POST_REPLY'); ?>" class="btn btn-primary btn-sm" href="<?php echo r_('index.php?option=com_chronoforums&cont=messages&act=compose&m='.$message['Message']['id'].'&u='.$u.'&d='.$d.'&subject='.urlencode($message['Message']['subject'])); ?>"><i class="fa fa-fw fa-reply"></i> <?php echo l_('CHRONOFORUMS_REPLY'); ?></a>
					<div class="col-lg-5 pull-right">
						<span class="pull-right">
							<i class="fa fa-fw fa-calendar"></i>
							<small class="cfu-time"><?php echo $this->Output->date_time($message['Message']['created']); ?></small>
						</span>
						<small class="cfu-user-info pull-right">
							<i class="fa fa-lg- fa-user"></i><?php echo $this->UserTasks->username(array('User' => $message['MessageUser'], 'Profile' => $message['MessageUserProfile']), false); ?>
						</small>
					</div>
				</div>
				<div class="panel-body">
					<?php echo $this->Bbcode->parse($message['Message']['text']); ?>
				</div>
			</div>
			<?php if(!empty($d_messages)): ?>
				<?php foreach($d_messages as $d_message): ?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="col-lg-5 pull-right">
								<span class="pull-right">
									<i class="fa fa-fw fa-calendar"></i>
									<small class="cfu-time"><?php echo $this->Output->date_time($d_message['Message']['created']); ?></small>
								</span>
								<small class="cfu-user-info pull-right">
									<i class="fa fa-lg- fa-user"></i><?php echo $this->UserTasks->username(array('User' => $d_message['MessageUser'], 'Profile' => $d_message['MessageUserProfile']), false); ?>
								</small>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-body">
							<?php echo $this->Bbcode->parse($d_message['Message']['text']); ?>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<div class="row cfu-footer">
			<?php echo $this->Elements->footer(); ?>
		</div>
	</div>
</div>
</div>
<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php if(!empty($topics)): ?>
	<ol>
		<?php foreach($topics as $topic): ?>
			<li>
			<?php
			$url = r_('index.php?option=com_chronoforums&cont=posts&f='.$topic['Topic']['forum_id'].'&t='.$topic['Topic']['id'].'&alias='.$topic['Topic']['alias'].(!empty($forums_menu_id) ? '&Itemid='.$forums_menu_id : '').'#p'.$topic['Topic']['last_post']);
			?>
			<a href="<?php echo $url; ?>" class="cfu-title"><?php echo strip_tags($topic['Topic']['title']); ?></a>
			</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>
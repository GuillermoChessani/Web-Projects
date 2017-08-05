<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($this->data['Post']['text'])){
		echo $this->Bbcode->parse($this->data['Post']['text']);
	}
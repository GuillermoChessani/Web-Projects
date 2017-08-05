<?php
/**
 * @package		DZIResponsiveBannerSlider
 * @subpackage	mod_dziresponsivebannerslider
 * @copyright	Copyright (C) 2005 - 2013 Devzoneindian. All rights reserved.
 * @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$catid	= trim($params->get('catid'));
$slider_type = trim($params->get('type'));
$onclick = trim($params->get('onclickredirect'));
$target = trim($params->get('target'));
$navigation = trim($params->get('navigation'));
$banners = &modDziresponsivebannersliderHelper::getBanners($catid);
$cat_title = &modDziresponsivebannersliderHelper::getCatTitle($catid);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_dziresponsivebannerslider', $params->get('layout', 'default'));
<?php
/**
 * @package		DZIResponsiveBannerSlider
 * @subpackage	mod_dziresponsivebannerslider
 * @copyright	Copyright (C) 2005 - 2013 Devzoneindian. All rights reserved.
 * @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die;

class modDziresponsivebannersliderHelper {

    static function &getBanners($catid) {
        $db = JFactory::getDBO();
        $qry = "SELECT a.name,a.clickurl,a.state,a.catid,a.description,a.params
                FROM `#__banners` as a 
                WHERE a.catid = " . $catid . " AND a.state = 1 ";
        $db->setQuery($qry);
        $banners = $db->loadObjectList();
        return $banners;
    }
    static function &getCatTitle($catid){
        $db = JFactory::getDBO();
        $qry = "SELECT b.title	 
                FROM `#__categories` as b 	
                where b.id = " . $catid ;
        $db->setQuery($qry);
        $title = $db->loadResult();
        return $title;
    }

}

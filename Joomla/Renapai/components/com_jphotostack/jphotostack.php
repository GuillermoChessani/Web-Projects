<?php

/*------------------------------------------------------------------------
# J Photostack
# ------------------------------------------------------------------------
# author                Md. Shaon Bahadur
# copyright             Copyright (C) 2012 j-download.com. All Rights Reserved.
# @license -            http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites:             http://www.j-download.com
# Technical Support:    http://www.j-download.com/request-for-quotation.html
-------------------------------------------------------------------------*/


defined('_JEXEC') or die;


$location 	= 'modules/mod_jphotostack/tmpl/albums';
$album_name	= $_GET['album_name'];

if(!$album_name){
    $jApp = JFactory::getApplication();
    $jApp->redirect('index.php', 'You are not authorize to get access to this page. This component is only to load data for ajax J Photostack.');
}

$files 		= glob($location . '/' . $album_name . '/*.{jpg,gif,png}', GLOB_BRACE);
$encoded 	= json_encode($files);
echo $encoded;
unset($encoded);

?>
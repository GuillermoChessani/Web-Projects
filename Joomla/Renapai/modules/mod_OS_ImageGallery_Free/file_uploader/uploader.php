<?php
/**
 * @package OS_ImageGallery_Free
 * @subpackage  OS_ImageGallery_Free
 * @copyright Andrey Kvasnevskiy-OrdaSoft(akbet@mail.ru); Anton Panchenko(nix-legend@mail.ru); 
 * @Homepage: http://www.ordasoft.com
 * @version: 1.0 
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * */
define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);

function toBytes($str) {
	$val = trim($str);
	$last = strtolower($str[strlen($str) - 1]);
	switch ($last) {
		case 'g': $val *= 1024;
		case 'm': $val *= 1024;
		case 'k': $val *= 1024;
	}
	return $val;
}

if (!defined('_JDEFINES')) {
	define('JPATH_BASE', dirname(__FILE__)."/../../../");
	require_once JPATH_BASE.'/includes/defines.php';
}

require_once JPATH_BASE.'/includes/framework.php';
jimport('joomla.filesystem.folder');
// Mark afterLoad in the profiler.
JDEBUG ? $_PROFILER->mark('afterLoad') : null;

// Instantiate the application.
$app = JFactory::getApplication('administrator');
$jlang = JFactory::getLanguage();
$jlang->load('mod_OS_ImageGallery_Free', JPATH_SITE, null, true);

// Upload process
require_once dirname(__FILE__)."/qqUploadedFileXhr.class.php";

if (isset($_GET['qqfile'])) {
	$file = new qqUploadedFileXhr();
} elseif (isset($_FILES['qqfile'])) {
	$file = new qqUploadedFileForm();
} else {
	$file = false; 
}

$pathinfo = pathinfo(mb_strtolower($file->getName()));
$filename = JApplication::stringURLSafe($pathinfo['filename']);
$ext = $pathinfo['extension'];

// Max size to upload (10MB)
$sizeLimit = 10 * 1024 * 1024;
$postSize = toBytes(ini_get('post_max_size'));
$uploadSize = toBytes(ini_get('upload_max_filesize'));        

// allowed extensions to upload
$allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
$response = array('success' => false, 'message' => '');
$moduleID = JRequest::getInt('id', 0);
$dir = JPATH_BASE . '/images';

$user = JFactory::getUser();
if ($user->guest) {
	$response['message'] = "This function only for logged users!";
} else if (!$file) {
	$response['message'] = "No files are found!";
}
else if ($file->getSize() == 0) {
	$response['message'] = "File is empty, check your file and try again";
}
else if ($file->getSize() > $sizeLimit) {
	$response['message'] = "File is too largest";
}
else if (!is_writable($dir)) {
	$response['message'] = "Directory {$dir} is not writable";
}
else if (!in_array(strtolower($ext), $allowedExtensions)) {
	$response['message'] = "Invalid extension, allowed: ".implode(", ",$allowedExtensions);
}
else {

	require_once dirname(__FILE__) . '/../helpers/images.php';

	$dir = $dir . '/os_imagegallery_' . $moduleID;
    if (!file_exists($dir) || !is_dir($dir)) JFolder::create($dir);
    if (!file_exists($dir . '/manager') || !is_dir($dir)) mkdir($dir . '/manager');
    if (!file_exists($dir . '/original') || !is_dir($dir)) mkdir($dir . '/original');
    if (!file_exists($dir . '/thumbnail') || !is_dir($dir)) mkdir($dir . '/thumbnail');
    
	// for not replace files
	$i = '';
	while (file_exists($dir . "/original/{$filename}{$i}.{$ext}")) {
		$i++;
	}
	$filename = "{$filename}{$i}.{$ext}";


	if (!$file->save("{$dir}/original/{$filename}")) {
		$response['message'] = "Can't save file here: {$dir}/original/{$filename}";
	}
	else {
		$imagesize = getimagesize("{$dir}/original/{$filename}", $imageinfo);
		$mime = $imagesize['mime'];

			resize_img($dir . "/original/{$filename}", $dir . "/manager/{$filename}", 128, 96);
			$response['success'] = true;
			$response['file'] = strtolower($filename)
            ;
	}
}
echo json_encode($response);
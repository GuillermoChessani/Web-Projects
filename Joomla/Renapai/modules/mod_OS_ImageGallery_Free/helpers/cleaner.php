<?php
/**
 * @package OS_ImageGallery_Free
 * @subpackage  OS_ImageGallery_Free
 * @copyright Andrey Kvasnevskiy-OrdaSoft(akbet@mail.ru); Anton Panchenko(nix-legend@mail.ru); 
 * @Homepage: http://www.ordasoft.com
 * @version: 1.0 
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * */
defined('_JEXEC') or die;
if(!function_exists('checkFiles')){
    function checkFiles($items, $moduleId) {
        $files = array();
        if (is_array($items)) {
            foreach ($items as $item) {
                $files[$item->file] = true;
            }
        }

        $dir = JPATH_ROOT . '/images/os_imagegallery_' . $moduleId;
        delete_old($files, $dir . '/manager');
        delete_old($files, $dir . '/original');
        delete_old($files, $dir . '/thumbnail');
    }
}

jimport('joomla.filesystem.folder');
if(!function_exists('delete_old')){
    function delete_old($files, $dir) {
        if (!JFolder::exists($dir)) return;
        foreach (JFolder::files($dir) as $file) {
            if (!array_key_exists($file, $files)) {
                JFile::delete($dir . '/' . $file);
            }
        }
    }
}
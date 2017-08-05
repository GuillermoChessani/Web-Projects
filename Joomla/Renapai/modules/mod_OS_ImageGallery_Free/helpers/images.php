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

jimport( 'joomla.filesystem.file' );
if(!function_exists('createImage')){
    function createImage($imgSrc, $imgDest, $width, $height, $crop = true, $quality = 100) {
        if (JFile::exists($imgDest)) {
            $info = getimagesize($imgDest, $imageinfo);
            if (($info[0] == $width) && ($info[1] == $height)) {
                return;
            }
        }
        if (JFile::exists($imgSrc)) {
            $info = getimagesize($imgSrc, $imageinfo);
            $sWidth = $info[0];
            $sHeight = $info[1];
            resize_img($imgSrc, $imgDest, $width, $height, $crop, $quality);
        }
    }
}
if(!function_exists('resize_img')){
    function resize_img($imgSrc, $imgDest, $tmp_width, $tmp_height, $crop = true, $quality = 100) {
        $info = getimagesize($imgSrc, $imageinfo);
        $sWidth = $info[0];
        $sHeight = $info[1];
        $quality = 100;

        if ($sHeight / $sWidth > $tmp_height / $tmp_width) {
            $width = $sWidth;
            $height = round(($tmp_height * $sWidth) / $tmp_width);
            $sx = 0;
            $sy = round(($sHeight - $height) / 3);
        }
        else {
            $height = $sHeight;
            $width = round(($sHeight * $tmp_width) / $tmp_height);
            $sx = round(($sWidth - $width) / 2);
            $sy = 0;
        }

        if (!$crop) {
            $sx = 0;
            $sy = 0;
            $width = $sWidth;
            $height = $sHeight;
        }

        $ext = str_replace('image/', '', $info['mime']);
        $imageCreateFunc = getImageCreateFunction($ext);
        $imageSaveFunc = getImageSaveFunction($ext);

        $sImage = $imageCreateFunc($imgSrc);
        $dImage = imagecreatetruecolor($tmp_width, $tmp_height);

        // Make transparent
        if ($ext == 'png') {
            imagealphablending($dImage, false);
            imagesavealpha($dImage,true);
            $transparent = imagecolorallocatealpha($dImage, 255, 255, 255, 127);
            imagefilledrectangle($dImage, 0, 0, $tmp_width, $tmp_height, $transparent);
        }

        imagecopyresampled($dImage, $sImage, 0, 0, $sx, $sy, $tmp_width, $tmp_height, $width, $height);

        if ($ext == 'png') {
            $imageSaveFunc($dImage, $imgDest, 9);
        }
        else if ($ext == 'gif') {
            $imageSaveFunc($dImage, $imgDest);
        }
        else {
            $imageSaveFunc($dImage, $imgDest, $quality);
        }
    }
}
if(!function_exists('getImageCreateFunction')){
    function getImageCreateFunction($type) {
        switch ($type) {
            case 'jpeg':
            case 'jpg':
                $imageCreateFunc = 'imagecreatefromjpeg';
                break;

            case 'png':
                $imageCreateFunc = 'imagecreatefrompng';
                break;

            case 'bmp':
                $imageCreateFunc = 'imagecreatefrombmp';
                break;

            case 'gif':
                $imageCreateFunc = 'imagecreatefromgif';
                break;

            case 'vnd.wap.wbmp':
                $imageCreateFunc = 'imagecreatefromwbmp';
                break;

            case 'xbm':
                $imageCreateFunc = 'imagecreatefromxbm';
                break;

            default:
                $imageCreateFunc = 'imagecreatefromjpeg';
        }

        return $imageCreateFunc;
    }
}
if(!function_exists('getImageSaveFunction')){
    function getImageSaveFunction($type) {
        switch ($type) {
            case 'jpeg':
                $imageSaveFunc = 'imagejpeg';
                break;

            case 'png':
                $imageSaveFunc = 'imagepng';
                break;

            case 'bmp':
                $imageSaveFunc = 'imagebmp';
                break;

            case 'gif':
                $imageSaveFunc = 'imagegif';
                break;

            case 'vnd.wap.wbmp':
                $imageSaveFunc = 'imagewbmp';
                break;

            case 'xbm':
                $imageSaveFunc = 'imagexbm';
                break;

            default:
                $imageSaveFunc = 'imagejpeg';
        }

        return $imageSaveFunc;
    }
}
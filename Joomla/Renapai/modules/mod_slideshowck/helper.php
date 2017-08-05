<?php

/**
 * @copyright	Copyright (C) 2011 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * Module Slideshow CK
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die;
$com_path = JPATH_SITE . '/components/com_content/';
require_once $com_path . 'router.php';
require_once $com_path . 'helpers/route.php';
JModelLegacy::addIncludePath($com_path . '/models', 'ContentModel');
jimport('joomla.filesystem.folder');

class modSlideshowckHelper {

	/**
	 * Get a list of the items.
	 *
	 * @param	JRegistry	$params	The module options.
	 *
	 * @return	array
	 */
	static function getItems(&$params) {
		// Initialise variables.
		$db = JFactory::getDbo();
		$document = JFactory::getDocument();

		// load the libraries
		//jimport('joomla.application.module.helper');
		$items = json_decode(str_replace("|qq|", "\"", $params->get('slides')));
		foreach ($items as $i => $item) {
			if (!$item->imgname) {
				unset($items[$i]);
				continue;
			}

			if (isset($item->slidearticleid) && $item->slidearticleid) {
				$item = self::getArticle($item, $params);
			} else {
				$item->article = null;
			}
			// create new images for mobile
			if ($params->get('usemobileimage', '0')) { 
				$resolutions = explode(',', $params->get('mobileimageresolution', '640'));
				foreach ($resolutions as $resolution) {
					self::resizeImage($item->imgname, (int)$resolution, '', (int)$resolution, '');
				}
			}

			if (stristr($item->imgname, "http")) {
				$item->imgthumb = $item->imgname;
			} else {
				// renomme le fichier
				$thumbext = explode(".", $item->imgname);
				$thumbext = end($thumbext);
				// crée la miniature
				if ($params->get('thumbnails', '1') == '1') {
					$item->imgthumb = JURI::base(true) . '/' . self::resizeImage($item->imgname, $params->get('thumbnailwidth', '100'), $params->get('thumbnailheight', '75'));
				} else {
					$item->imgthumb = JURI::base(true) . '/' . str_replace("." . $thumbext, "_th." . $thumbext, $item->imgname);
				}
				$item->imgname = JURI::base(true) . '/' . $item->imgname;
			}

			// set the videolink
			if ($item->imgvideo)
				$item->imgvideo = self::setVideolink($item->imgvideo);

			// manage the title and description
			if (stristr($item->imgcaption, "||")) {
				$splitcaption = explode("||", $item->imgcaption);
				$item->imgcaption = '<div class="slideshowck_title">' . $splitcaption[0] . '</div><div class="slideshowck_description">' . $splitcaption[1] . '</div>';
			}
		}
		//shuffle($items);
		return $items;
	}

	static function getArticle(&$item, $params) {
		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		// Get an instance of the generic articles model
		$articles = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
		// Set application parameters in model
		$app = JFactory::getApplication();
		$appParams = $app->getParams();
		$articles->setState('params', $appParams);
		$articles->setState('filter.published', 1);
		$articles->setState('filter.article_id', $item->slidearticleid);
		$items2 = $articles->getItems();
		$item->article = $items2[0];
		$item->article->text = JHTML::_('content.prepare', $item->article->introtext);
		$item->article->text = self::truncate($item->article->text, $params->get('articlelength', '150'));
		// $item->article->text = JHTML::_('string.truncate',$item->article->introtext,'150');
		// set the item link to the article depending on the user rights
		if ($access || in_array($item->article->access, $authorised)) {
			// We know that user has the privilege to view the article
			$item->slug = $item->article->id . ':' . $item->article->alias;
			$item->catslug = $item->article->catid ? $item->article->catid . ':' . $item->article->category_alias : $item->article->catid;
			$item->article->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
		} else {
			$app = JFactory::getApplication();
			$menu = $app->getMenu();
			$menuitems = $menu->getItems('link', 'index.php?option=com_users&view=login');
			if (isset($menuitems[0])) {
				$Itemid = $menuitems[0]->id;
			} elseif (JRequest::getInt('Itemid') > 0) {
				$Itemid = JRequest::getInt('Itemid');
			}
			$item->article->link = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $Itemid);
		}
		return $item;
	}

	/**
	 * Get a list of the items.
	 *
	 * @param	JRegistry	$params	The module options.
	 *
	 * @return	array
	 */
	static function getItemsFromfolder(&$params) {
		$authorisedExt = array('png', 'jpg', 'JPG', 'JPEG', 'jpeg', 'bmp', 'tiff', 'gif');
		$items = json_decode(str_replace("|qq|", "\"", $params->get('slidesfromfolder')));
		foreach ($items as & $item) {
//			$item->imgname = str_replace(JUri::base(), '', $item->imgname);
			$item->imgthumb = '';
			$item->imgname = trim($item->imgname, '/');
			$item->imgname = trim($item->imgname, '\\');
			// create new images for mobile
			if ($params->get('usemobileimage', '0')) { 
				self::resizeImage($item->imgname, $params->get('mobileimageresolution', '640'), '', $params->get('mobileimageresolution', '640'), '');
			}
			if ($params->get('thumbnails', '1') == '1')
				$item->imgthumb = JURI::base(true) . '/' . self::resizeImage($item->imgname, $params->get('thumbnailwidth', '100'), $params->get('thumbnailheight', '75'));
			$thumbext = explode(".", $item->imgname);
			$thumbext = end($thumbext);
			// set the variables
			$item->imgvideo = null;
			$item->slideselect = null;
			$item->slideselect = null;
			$item->imgcaption = null;
			$item->article = null;
			$item->slidearticleid = null;
			$item->imgalignment = null;
			$item->imgtarget = null;
			$item->imgtime = null;
			$item->imglink = null;

			if (!in_array(strToLower(JFile::getExt($item->imgname)), $authorisedExt))
				continue;

			// load the image data from txt
			$item = self::getImageDataFromfolder($item, $params);
			$item->imgname = JURI::base(true) . '/' . $item->imgname;
		}

		return $items;
	}
	
	static function getItemsAutoloadfolder(&$params) {
		$authorisedExt = array('png', 'jpg', 'JPG', 'JPEG', 'jpeg', 'bmp', 'tiff', 'gif');
		$items = JFolder::files($params->get('autoloadfoldername'), '.jpg|.png|.jpeg|.gif|.JPG|.JPEG|.jpeg', false, true);
		foreach ($items as $i => $name) {
			$item = new stdClass();
			// $item->imgname = str_replace(JUri::base(),'', $item->imgname);
			$item->imgthumb = '';
			$item->imgname = trim(str_replace('\\','/',$name), '/');
			$item->imgname = trim($item->imgname, '\\');
			// create new images for mobile
			if ($params->get('usemobileimage', '0')) { 
				self::resizeImage($item->imgname, $params->get('mobileimageresolution', '640'), '', $params->get('mobileimageresolution', '640'), '');
			}
			if ($params->get('thumbnails', '1') == '1')
				$item->imgthumb = JURI::base(true) . '/' . self::resizeImage($item->imgname, $params->get('thumbnailwidth', '100'), $params->get('thumbnailheight', '75'));
			$thumbext = explode(".", $item->imgname);
			$thumbext = end($thumbext);
			// set the variables
			$item->imgvideo = null;
			$item->slideselect = null;
			$item->slideselect = null;
			$item->imgcaption = null;
			$item->article = null;
			$item->slidearticleid = null;
			$item->imgalignment = null;
			$item->imgtarget = null;
			$item->imgtime = null;
			$item->imglink = null;

			if (!in_array(strToLower(JFile::getExt($item->imgname)), $authorisedExt))
				continue;

			// load the image data from txt
			$item = self::getImageDataFromfolder($item, $params);
			$item->imgname = JURI::base(true) . '/' . $item->imgname;
			$items[$i] = $item;
		}

		return $items;
	}

	static function getImageDataFromfolder(&$item, $params) {
		$item->imgvideo = null;
		$item->slideselect = null;
		$item->imgcaption = null;
		$item->article = null;
		$item->imgalignment = null;
		$item->imgtarget = null;
		$item->imgtime = null;
		$item->imglink = null;
		// load the image data from txt
		$datafile = JPATH_ROOT . '/' . str_replace(JFile::getExt($item->imgname), 'txt', $item->imgname);
		$data = JFile::exists($datafile) ? JFile::read($datafile) : '';
		$imgdatatmp = explode("\n", $data);

		$parmsnumb = count($imgdatatmp);
		for ($i = 0; $i < $parmsnumb; $i++) {
			$imgdatatmp[$i] = trim($imgdatatmp[$i]);
			$item->imgcaption = stristr($imgdatatmp[$i], "caption=") ? str_replace('caption=', '', $imgdatatmp[$i]) : $item->imgcaption;
			$item->slidearticleid = stristr($imgdatatmp[$i], "articleid=") ? str_replace('articleid=', '', $imgdatatmp[$i]) : $item->slidearticleid;
			$item->imgvideo = stristr($imgdatatmp[$i], "video=") ? str_replace('video=', '', $imgdatatmp[$i]) : $item->imgvideo;
			$item->imglink = stristr($imgdatatmp[$i], "link=") ? str_replace('link=', '', $imgdatatmp[$i]) : $item->imglink;
			$item->imgtime = stristr($imgdatatmp[$i], "time=") ? str_replace('time=', '', $imgdatatmp[$i]) : $item->imgtime;
			$item->imgtarget = stristr($imgdatatmp[$i], "target=") ? str_replace('target=', '', $imgdatatmp[$i]) : $item->imgtarget;
		}

		if ($item->imgvideo)
			$item->slideselect = 'video';

		if (isset($item->slidearticleid) && $item->slidearticleid) {
			$item = self::getArticle($item, $params);
		}

		return $item;
	}

	/**
	 * Set the correct video link
	 *
	 * $videolink string the video path
	 *
	 * @return string the new video path
	 */
	static function setVideolink($videolink) {
		// youtube
		if (stristr($videolink, 'youtu.be')) {
			$videolink = str_replace('youtu.be', 'www.youtube.com/embed', $videolink);
		} else if (stristr($videolink, 'www.youtube.com') AND !stristr($videolink, 'embed')) {
			$videolink = str_replace('youtube.com', 'youtube.com/embed', $videolink);
		}

		$videolink .= ( stristr($videolink, '?')) ? '&wmode=transparent' : '?wmode=transparent';

		return $videolink;
	}

	/**
	 * Create the list of all modules published as Object
	 *
	 * $file string the image path
	 * $x integer the new image width
	 * $y integer the new image height
	 *
	 * @return Boolean True on Success
	 */
	static function resizeImage($file, $x, $y = '', $thumbpath = 'th', $thumbsuffix = '_th') {

		if (!$file)
			return;

		$filetmp = JPATH_ROOT . '/' . $file;
		$filetmp = str_replace("%20", " ", $filetmp);
		$size = getimagesize($filetmp);
		if ($y == '') $y = $x * $size[1] / $size[0];
		$thumbext = explode(".", $file);
		$thumbext = end($thumbext);
		$thumbfile = str_replace(JFile::getName($file), $thumbpath . "/" . JFile::getName($file), $file);
		$thumbfile = str_replace("." . $thumbext, $thumbsuffix . "." . $thumbext, $thumbfile);

		if ($size) {
			$thumbfolder = str_replace(JFile::getName($file), $thumbpath . "/", $filetmp);
			if (!JFolder::exists($thumbfolder)) { 
				JFolder::create($thumbfolder);
				JFile::copy(JPATH_ROOT . '/modules/mod_slideshowck/index.html', $thumbfolder . 'index.html' );
			}

			if (JFile::exists($thumbfile)) {
				$thumbsize = getimagesize(JPATH_ROOT . '/' . $thumbfile);
				if ($thumbsize[0] == $x || $thumbsuffix == '') {
					//echo 'miniature existante';
					return $thumbfile;
				}
			}

			if ($size['mime'] == 'image/jpeg') {
				$img_big = imagecreatefromjpeg($filetmp); # On ouvre l'image d'origine
				$img_new = imagecreate($x, $y);
				# création de la miniature
				$img_mini = imagecreatetruecolor($x, $y) or $img_mini = imagecreate($x, $y);
				// copie de l'image, avec le redimensionnement.
				imagecopyresized($img_mini, $img_big, 0, 0, 0, 0, $x, $y, $size[0], $size[1]);

				imagejpeg($img_mini, JPATH_ROOT . '/' . $thumbfile);
			} elseif ($size['mime'] == 'image/png') {
				$img_big = imagecreatefrompng($filetmp); # On ouvre l'image d'origine
				$img_new = imagecreate($x, $y);
				# création de la miniature
				$img_mini = imagecreatetruecolor($x, $y) or $img_mini = imagecreate($x, $y);
				// copie de l'image, avec le redimensionnement.
				imagecopyresized($img_mini, $img_big, 0, 0, 0, 0, $x, $y, $size[0], $size[1]);

				imagepng($img_mini, JPATH_ROOT . '/' . $thumbfile);
			} elseif ($size['mime'] == 'image/gif') {
				$img_big = imagecreatefromgif($filetmp); # On ouvre l'image d'origine
				$img_new = imagecreate($x, $y);
				# création de la miniature
				$img_mini = imagecreatetruecolor($x, $y) or $img_mini = imagecreate($x, $y);
				// copie de l'image, avec le redimensionnement.
				imagecopyresized($img_mini, $img_big, 0, 0, 0, 0, $x, $y, $size[0], $size[1]);

				imagegif($img_mini, JPATH_ROOT . '/' . $thumbfile);
			}
			//echo 'Image redimensionnée !';
		}

		return $thumbfile;
	}

	/**
	 * Create the css
	 *
	 * $params JRegistry the module params
	 * $prefix integer the prefix of the params
	 *
	 * @return Array of css
	 */
	static function createCss($params, $prefix = 'menu') {
		$css = Array();
		$csspaddingtop = ($params->get($prefix . 'paddingtop') AND $params->get($prefix . 'usemargin')) ? 'padding-top: ' . $params->get($prefix . 'paddingtop', '0') . 'px;' : '';
		$csspaddingright = ($params->get($prefix . 'paddingright') AND $params->get($prefix . 'usemargin')) ? 'padding-right: ' . $params->get($prefix . 'paddingright', '0') . 'px;' : '';
		$csspaddingbottom = ($params->get($prefix . 'paddingbottom') AND $params->get($prefix . 'usemargin') ) ? 'padding-bottom: ' . $params->get($prefix . 'paddingbottom', '0') . 'px;' : '';
		$csspaddingleft = ($params->get($prefix . 'paddingleft') AND $params->get($prefix . 'usemargin')) ? 'padding-left: ' . $params->get($prefix . 'paddingleft', '0') . 'px;' : '';
		$css['padding'] = $csspaddingtop . $csspaddingright . $csspaddingbottom . $csspaddingleft;
		$cssmargintop = ($params->get($prefix . 'margintop') AND $params->get($prefix . 'usemargin')) ? 'margin-top: ' . $params->get($prefix . 'margintop', '0') . 'px;' : '';
		$cssmarginright = ($params->get($prefix . 'marginright') AND $params->get($prefix . 'usemargin')) ? 'margin-right: ' . $params->get($prefix . 'marginright', '0') . 'px;' : '';
		$cssmarginbottom = ($params->get($prefix . 'marginbottom') AND $params->get($prefix . 'usemargin')) ? 'margin-bottom: ' . $params->get($prefix . 'marginbottom', '0') . 'px;' : '';
		$cssmarginleft = ($params->get($prefix . 'marginleft') AND $params->get($prefix . 'usemargin')) ? 'margin-left: ' . $params->get($prefix . 'marginleft', '0') . 'px;' : '';
		$css['margin'] = $cssmargintop . $cssmarginright . $cssmarginbottom . $cssmarginleft;
		$css['background'] = ($params->get($prefix . 'bgcolor1') AND $params->get($prefix . 'usebackground')) ? 'background: ' . $params->get($prefix . 'bgcolor1') . ';' : '';
		$css['background'] .= ( $params->get($prefix . 'bgimage') AND $params->get($prefix . 'usebackground')) ? 'background-image: url("' . JURI::ROOT() . $params->get($prefix . 'bgimage') . '");' : '';
		$css['background'] .= ( $params->get($prefix . 'bgimage') AND $params->get($prefix . 'usebackground')) ? 'background-repeat: ' . $params->get($prefix . 'bgimagerepeat') . ';' : '';
		$css['background'] .= ( $params->get($prefix . 'bgimage') AND $params->get($prefix . 'usebackground')) ? 'background-position: ' . $params->get($prefix . 'bgpositionx') . ' ' . $params->get($prefix . 'bgpositiony') . ';' : '';
		$css['gradient'] = ($css['background'] AND $params->get($prefix . 'bgcolor2') AND $params->get($prefix . 'usegradient')) ?
				"background: -moz-linear-gradient(top,  " . $params->get($prefix . 'bgcolor1', '#f0f0f0') . " 0%, " . $params->get($prefix . 'bgcolor2', '#e3e3e3') . " 100%);"
				. "background: -webkit-gradient(linear, left top, left bottom, color-stop(0%," . $params->get($prefix . 'bgcolor1', '#f0f0f0') . "), color-stop(100%," . $params->get($prefix . 'bgcolor2', '#e3e3e3') . ")); "
				. "background: -webkit-linear-gradient(top,  " . $params->get($prefix . 'bgcolor1', '#f0f0f0') . " 0%," . $params->get($prefix . 'bgcolor2', '#e3e3e3') . " 100%);"
				. "background: -o-linear-gradient(top,  " . $params->get($prefix . 'bgcolor1', '#f0f0f0') . " 0%," . $params->get($prefix . 'bgcolor2', '#e3e3e3') . " 100%);"
				. "background: -ms-linear-gradient(top,  " . $params->get($prefix . 'bgcolor1', '#f0f0f0') . " 0%," . $params->get($prefix . 'bgcolor2', '#e3e3e3') . " 100%);"
				. "background: linear-gradient(top,  " . $params->get($prefix . 'bgcolor1', '#f0f0f0') . " 0%," . $params->get($prefix . 'bgcolor2', '#e3e3e3') . " 100%); "
				. "filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='" . $params->get($prefix . 'bgcolor1', '#f0f0f0') . "', endColorstr='" . $params->get($prefix . 'bgcolor2', '#e3e3e3') . "',GradientType=0 );" : '';
		$css['borderradius'] = ($params->get($prefix . 'useroundedcorners')) ?
				'-moz-border-radius: ' . $params->get($prefix . 'roundedcornerstl', '0') . 'px ' . $params->get($prefix . 'roundedcornerstr', '0') . 'px ' . $params->get($prefix . 'roundedcornersbr', '0') . 'px ' . $params->get($prefix . 'roundedcornersbl', '0') . 'px;'
				. '-webkit-border-radius: ' . $params->get($prefix . 'roundedcornerstl', '0') . 'px ' . $params->get($prefix . 'roundedcornerstr', '0') . 'px ' . $params->get($prefix . 'roundedcornersbr', '0') . 'px ' . $params->get($prefix . 'roundedcornersbl', '0') . 'px;'
				. 'border-radius: ' . $params->get($prefix . 'roundedcornerstl', '0') . 'px ' . $params->get($prefix . 'roundedcornerstr', '0') . 'px ' . $params->get($prefix . 'roundedcornersbr', '0') . 'px ' . $params->get($prefix . 'roundedcornersbl', '0') . 'px;' : '';
		$shadowinset = $params->get($prefix . 'shadowinset', 0) ? 'inset ' : '';
		$css['shadow'] = ($params->get($prefix . 'shadowcolor') AND $params->get($prefix . 'shadowblur') AND $params->get($prefix . 'useshadow')) ?
				'-moz-box-shadow: ' . $shadowinset . $params->get($prefix . 'shadowoffsetx', '0') . 'px ' . $params->get($prefix . 'shadowoffsety', '0') . 'px ' . $params->get($prefix . 'shadowblur', '') . 'px ' . $params->get($prefix . 'shadowspread', '0') . 'px ' . $params->get($prefix . 'shadowcolor', '') . ';'
				. '-webkit-box-shadow: ' . $shadowinset . $params->get($prefix . 'shadowoffsetx', '0') . 'px ' . $params->get($prefix . 'shadowoffsety', '0') . 'px ' . $params->get($prefix . 'shadowblur', '') . 'px ' . $params->get($prefix . 'shadowspread', '0') . 'px ' . $params->get($prefix . 'shadowcolor', '') . ';'
				. 'box-shadow: ' . $shadowinset . $params->get($prefix . 'shadowoffsetx', '0') . 'px ' . $params->get($prefix . 'shadowoffsety', '0') . 'px ' . $params->get($prefix . 'shadowblur', '') . 'px ' . $params->get($prefix . 'shadowspread', '0') . 'px ' . $params->get($prefix . 'shadowcolor', '') . ';' : '';
		$css['border'] = ($params->get($prefix . 'bordercolor') AND $params->get($prefix . 'borderwidth') AND $params->get($prefix . 'useborders')) ?
				'border: ' . $params->get($prefix . 'bordercolor', '#efefef') . ' ' . $params->get($prefix . 'borderwidth', '1') . 'px solid;' : '';
		$css['fontsize'] = ($params->get($prefix . 'usefont') AND $params->get($prefix . 'fontsize')) ?
				'font-size: ' . $params->get($prefix . 'fontsize') . ';' : '';
		$css['fontcolor'] = ($params->get($prefix . 'usefont') AND $params->get($prefix . 'fontcolor')) ?
				'color: ' . $params->get($prefix . 'fontcolor') . ';' : '';
		$css['fontweight'] = ($params->get($prefix . 'usefont') AND $params->get($prefix . 'fontweight')) ?
				'font-weight: ' . $params->get($prefix . 'fontweight') . ';' : '';
		/* $css['fontcolorhover'] = ($params->get($prefix . 'usefont') AND $params->get($prefix . 'fontcolorhover')) ?
		  'color: ' . $params->get($prefix . 'fontcolorhover') . ';' : ''; */
		$css['descfontsize'] = ($params->get($prefix . 'usefont') AND $params->get($prefix . 'descfontsize')) ?
				'font-size: ' . $params->get($prefix . 'descfontsize') . ';' : '';
		$css['descfontcolor'] = ($params->get($prefix . 'usefont') AND $params->get($prefix . 'descfontcolor')) ?
				'color: ' . $params->get($prefix . 'descfontcolor') . ';' : '';
		return $css;
	}

	/**
	 * Truncates text blocks over the specified character limit and closes
	 * all open HTML tags. The method will optionally not truncate an individual
	 * word, it will find the first space that is within the limit and
	 * truncate at that point. This method is UTF-8 safe.
	 *
	 * @param   string   $text       The text to truncate.
	 * @param   integer  $length     The maximum length of the text.
	 * @param   boolean  $noSplit    Don't split a word if that is where the cutoff occurs (default: true).
	 * @param   boolean  $allowHtml  Allow HTML tags in the output, and close any open tags (default: true).
	 *
	 * @return  string   The truncated text.
	 *
	 * @since   11.1
	 */
	public static function truncate($text, $length = 0, $noSplit = true, $allowHtml = true) {
		// Check if HTML tags are allowed.
		if (!$allowHtml) {
			// Deal with spacing issues in the input.
			$text = str_replace('>', '> ', $text);
			$text = str_replace(array('&nbsp;', '&#160;'), ' ', $text);
			$text = JString::trim(preg_replace('#\s+#mui', ' ', $text));

			// Strip the tags from the input and decode entities.
			$text = strip_tags($text);
			$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

			// Remove remaining extra spaces.
			$text = str_replace('&nbsp;', ' ', $text);
			$text = JString::trim(preg_replace('#\s+#mui', ' ', $text));
		}

		// Truncate the item text if it is too long.
		if ($length > 0 && JString::strlen($text) > $length) {
			// Find the first space within the allowed length.
			$tmp = JString::substr($text, 0, $length);

			if ($noSplit) {
				$offset = JString::strrpos($tmp, ' ');
				if (JString::strrpos($tmp, '<') > JString::strrpos($tmp, '>')) {
					$offset = JString::strrpos($tmp, '<');
				}
				$tmp = JString::substr($tmp, 0, $offset);

				// If we don't have 3 characters of room, go to the second space within the limit.
				if (JString::strlen($tmp) > $length - 3) {
					$tmp = JString::substr($tmp, 0, JString::strrpos($tmp, ' '));
				}
			}

			if ($allowHtml) {
				// Put all opened tags into an array
				preg_match_all("#<([a-z][a-z0-9]*)\b.*?(?!/)>#i", $tmp, $result);
				$openedTags = $result[1];
				$openedTags = array_diff($openedTags, array("img", "hr", "br"));
				$openedTags = array_values($openedTags);

				// Put all closed tags into an array
				preg_match_all("#</([a-z]+)>#iU", $tmp, $result);
				$closedTags = $result[1];

				$numOpened = count($openedTags);

				// All tags are closed
				if (count($closedTags) == $numOpened) {
					return $tmp . '...';
				}
				$tmp .= '...';
				$openedTags = array_reverse($openedTags);

				// Close tags
				for ($i = 0; $i < $numOpened; $i++) {
					if (!in_array($openedTags[$i], $closedTags)) {
						$tmp .= "</" . $openedTags[$i] . ">";
					} else {
						unset($closedTags[array_search($openedTags[$i], $closedTags)]);
					}
				}
			}

			$text = $tmp;
		}

		return $text;
	}

}

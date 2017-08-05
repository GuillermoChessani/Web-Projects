<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace GCore\Extensions\Chronoforums\Helpers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Bbcode {
	var $view;
	
	static $emotions = array(
		' :oops:',
		' :D',
		' :)',
		' ;)',
		' :(',
		' :o',
		' :shock:',
		' :?',
		' 8-)',
		' :lol:',
		' :x',
		' :P',
		' :cry:',
		' :evil:',
		' :twisted:',
		' :roll:',
		' :!:',
		' :?:',
		' :idea:',
		' :arrow:',
		' :|',
		' :mrgreen:',
		' :geek:',
		' :ugeek:'
	);

	static $emotions_rand = array(
		'__EMOTION0__1',
		'__EMOTION0__2',
		'__EMOTION0__3',
		'__EMOTION0__4',
		'__EMOTION0__5',
		'__EMOTION0__6',
		'__EMOTION0__7',
		'__EMOTION0__8',
		'__EMOTION0__9',
		'__EMOTION1__1',
		'__EMOTION1__2',
		'__EMOTION1__3',
		'__EMOTION1__4',
		'__EMOTION1__5',
		'__EMOTION1__6',
		'__EMOTION1__7',
		'__EMOTION1__8',
		'__EMOTION1__9',
		'__EMOTION2__1',
		'__EMOTION2__2',
		'__EMOTION2__3',
		'__EMOTION2__4',
		'__EMOTION2__5',
	);

	function escape($s){
		$fparams = $this->view->vars['fparams'];
		//$text = strip_tags($text);
		$code = $s;//[1];
		$code = trim($code, "\n\r");
		$code = str_replace("[", "&#91;", $code);
		$code = str_replace("]", "&#93;", $code);
		//$code = str_replace(self::$emotions, self::$emotions_rand, $code);
		$code = str_replace(array("\t", " "), '&nbsp;', $code);
		$code = nl2br($code);
		//return '<pre class="pre-scrollable">'.$code.'</pre>';
		if(strpos($code, "\n") !== false){
			return '<dl class="cfu-code'.($fparams->get('auto_collapse_code', 1) ? ' cfu-collapsed' : '').'"><dt><span>'.l_('CHRONOFORUMS_CODE').'</span>: <a href="#" onclick="selectCode(this); return false;">'.l_('CHRONOFORUMS_SELECT_ALL').'</a>&nbsp;'.($fparams->get('auto_collapse_code', 1) ? '<a href="#" class="collapsed" data-expand="'.l_('CHRONOFORUMS_EXPAND').'" data-collapse="'.l_('CHRONOFORUMS_COLLAPSE').'" onclick="expand_collapse_code(this); return false;">'.l_('CHRONOFORUMS_EXPAND').'</a>' : '').'</dt><dd><code class="cfu-multiline'.($fparams->get('auto_collapse_code', 1) ? ' cfu-collapsed' : '').'">'.$code.'</code></dd></dl>';
		}else{
			return '<dl class="cfu-code"><dd><code class="cfu-oneline">'.$code.'</code></dd></dl>';
		}
	}

	function parse($text) {
		$fparams = $this->view->vars['fparams'];
		$text = htmlspecialchars($text);
		//fix emails
		$EmailRegex = '/[A-Za-z0-9_-]+@[A-Za-z0-9_-]+\.([A-Za-z0-9_-][A-Za-z0-9_]+)/';
		preg_match_all($EmailRegex, $text, $email_matches);
		if(!empty($email_matches[0])){
			foreach($email_matches[0] as $email_match){
				$email_new = str_replace(array('@', '.'), array(' @[at] ', ' [dot] '), $email_match);
				$text = str_replace($email_match, $email_new, $text);
			}
		}
		
		preg_match_all('/\[code\](.*?)\[\/code\]/ms', $text, $code_matches);
		$code_chunks = array();
		$code_count = 0;
		if(!empty($code_matches[1])){
			foreach($code_matches[1] as $c => $code){
				$new_code = $this->escape($code);
				$code_chunks['__CODE__'.$code_count] = $new_code;
				$text = str_replace($code_matches[0][$c], '__CODE__'.$code_count, $text);
				$code_count++;
			}
		}
		//$text = preg_replace_callback('/\[code\](.*?)\[\/code\]/ms', array($this, 'escape'), $text);

		$hilit = \GCore\Libs\Request::data('hilit');
		if(!empty($hilit)){
			$hilits = str_replace(array('"', "'"), '', $hilit);
			$hilits = array_filter(explode(' ', $hilits));
			$text = preg_replace('/( '.implode(' | ', $hilits).' )/ms', '<span class="badge cfu-hilit">${1}</span>', $text);
		}
		
		//fix plain urls
		$URLRegex = '/(?:(?<!(\[\/url\]|\[\/url=))(\s|^))'; // No [url]-tag in front and is start of string, or has whitespace in front
		$URLRegex.= '(';                                    // Start capturing URL
		$URLRegex.= '(http?|https?|ftps?|ircs?):\/\/';            // Protocol
		$URLRegex.= '\S+';                                  // Any non-space character
		$URLRegex.= ')';                                    // Stop capturing URL
		$URLRegex.= '(?:(?<![[:punct:]])(\s|\.?$))/i';      // Doesn't end with punctuation and is end of string, or has whitespace after
		$text = preg_replace($URLRegex, "$2[url]$3[/url]$5", $text);
		
		//images enlarging
		$inline_img_class = $fparams->get('inline_images_display', 0) == 1 ? 'gcore_magnified' : '';
		$inline_img_fn = $fparams->get('inline_images_display', 0) == 1 ? '' : $fparams->get('inline_images_display', 0) == 0 ? 'viewableArea(this);' : 'viewableModal(this);';

		$in = array(
			'/\[b\](.*?)\[\/b\]/msi',
			'/\[i\](.*?)\[\/i\]/msi',
			'/\[u\](.*?)\[\/u\]/msi',
			'/\[img\](.*?)\[\/img\]/msi',
			'/\[email\](.*?)\[\/email\]/msi',
			'/\[url\="?(.*?)"?\](.*?)\[\/url\]/msi',
			'/\[url\]( *)(.*?)\[\/url\]/msi',
			'/\[size\="?(.*?)"?\](.*?)\[\/size\]/msi',
			'/\[color\="?(.*?)"?\](.*?)\[\/color\]/msi',
			'/\[quote\](.*?)\[\/quote\]/msi',
			'/\[quote="(.*?)"](.*?)\[\/quote\]/msi',
			'/\[quote=&quot;(.*?)&quot;](.*?)\[\/quote\]/msi',
			//'/\[attachment=(.*?)](.*?)\[\/attachment\]/ms',
			'/\[list\=(.*?)\](.*?)\[\/list\]/msi',
			'/\[list\](.*?)\[\/list\]/msi',
			'/\[\*\](.*?)\[\/\*\]/msi',
			'/\[\*\]\s?(.*?)\n/msi'
		);

		$out = array(
			'<strong>\1</strong>',
			'<em>\1</em>',
			'<u>\1</u>',
			'<img src="\1" alt="\1" onclick="'.$inline_img_fn.'" class="'.$inline_img_class.'" />',
			'<a href="mailto:\1">\1</a>',
			'<a class="cfu-postlink" target="_blank" rel="nofollow" href="\1">\2</a>',
			'<a class="cfu-postlink" target="_blank" rel="nofollow" href="\2">\2</a>',
			'<span style="font-size:\1%">\2</span>',
			'<span style="color:\1">\2</span>',
			'<blockquote><p>\1</p></blockquote>',
			'<blockquote><p>\2<small>'.l_('CHRONOFORUMS_WROTE').':\1</small></p></blockquote>',
			'<blockquote><p>\2<small>'.l_('CHRONOFORUMS_WROTE').':\1</small></p></blockquote>',
			//'{Post.Attachment.\1.inline_output}',
			'<ol start="\1">\2</ol>',
			'<ul>\1</ul>',
			'<li>\1</li>',
			'<li>\1</li>'
		);
		$text = preg_replace($in, $out, $text);

		$text = str_replace("\r", '', $text);
		$text = '<p>'.preg_replace("/(\n){2,}/", '</p><p>', $text).'</p>';
		$text = nl2br($text);

		$text = preg_replace_callback('/<pre>(.*?)<\/pre>/ms', array($this, 'cleanCode'), $text);
		$text = preg_replace('/<p><pre>(.*?)<\/pre><\/p>/ms', "<pre>\\1</pre>", $text);

		$text = preg_replace_callback('/<ul>(.*?)<\/ul>/ms', array($this, 'cleanCode'), $text);
		$text = preg_replace('/<p><ul>(.*?)<\/ul><\/p>/ms', "<ul>\\1</ul>", $text);


		// And replace them by...
		$out = array(
			' <img width="15" height="15" title="Embarrassed" alt="oops" src="'.$this->emodir.'icon_redface.gif">',
			' <img width="15" height="15" title="Very Happy" alt=":D" src="'.$this->emodir.'icon_biggrin.gif">',
			' <img width="15" height="15" title="Smile" alt=":)" src="'.$this->emodir.'icon_smile.gif">',
			' <img width="15" height="15" title="Wink" alt=";)" src="'.$this->emodir.'icon_wink.gif">',
			' <img width="15" height="15" title="Sad" alt=":(" src="'.$this->emodir.'icon_sad.gif">',
			' <img width="15" height="15" title="Surprised" alt=":o" src="'.$this->emodir.'icon_surprised.gif">',
			' <img width="15" height="15" title="Shocked" alt=":shock:" src="'.$this->emodir.'icon_eek.gif">',
			' <img width="15" height="15" title="Confused" alt=":?" src="'.$this->emodir.'icon_confused.gif">',
			' <img width="15" height="15" title="Cool" alt="8-)" src="'.$this->emodir.'icon_cool.gif">',
			' <img width="15" height="15" title="Laughing" alt=":lol:" src="'.$this->emodir.'icon_lol.gif">',
			' <img width="15" height="15" title="Mad" alt=":x" src="'.$this->emodir.'icon_mad.gif">',
			' <img width="15" height="15" title="Razz" alt=":P" src="'.$this->emodir.'icon_razz.gif">',
			' <img width="15" height="15" title="Crying or Very Sad" alt=":cry:" src="'.$this->emodir.'icon_cry.gif">',
			' <img width="15" height="15" title="Evil or Very Mad" alt=":evil:" src="'.$this->emodir.'icon_evil.gif">',
			' <img width="15" height="15" title="Twisted Evil" alt=":twisted:" src="'.$this->emodir.'icon_twisted.gif">',
			' <img width="15" height="15" title="Rolling Eyes" alt=":roll:" src="'.$this->emodir.'icon_rolleyes.gif">',
			' <img width="15" height="15" title="Exclamation" alt=":!:" src="'.$this->emodir.'icon_exclaim.gif">',
			' <img width="15" height="15" title="Question" alt=":?:" src="'.$this->emodir.'icon_question.gif">',
			' <img width="15" height="15" title="Idea" alt=":idea:" src="'.$this->emodir.'icon_idea.gif">',
			' <img width="15" height="15" title="Arrow" alt=":arrow:" src="'.$this->emodir.'icon_arrow.gif">',
			' <img width="15" height="15" title="Neutral" alt=":|" src="'.$this->emodir.'icon_neutral.gif">',
			' <img width="15" height="15" title="Mr. Green" alt=":mrgreen:" src="'.$this->emodir.'icon_mrgreen.gif">',
			' <img width="17" height="17" title="Geek" alt=":geek:" src="'.$this->emodir.'icon_e_geek.gif">',
			' <img width="17" height="18" title="Uber Geek" alt=":ugeek:" src="'.$this->emodir.'icon_e_ugeek.gif">',

		);
		$text = str_replace(self::$emotions, $out, $text);
		
		//fix plain urls
		/*if(1){
			$text = preg_replace('/(?!\[url(=.*?)?\])(http|ftp)(s)?:\/\/[a-zA-Z0-9.?&_\-\/]+/', "<a href=\"\\0\">\\0</a>", $text);	
		}
		*/
		//fix emotions again
		//$text = str_replace(self::$emotions_rand, self::$emotions, $text);
		//fix code
		if(!empty($code_chunks)){
			$text = str_replace(array_keys($code_chunks), array_values($code_chunks), $text);
		}

		return $text;
	}

	function cleanCode($s){
		return str_replace('<br />', '', $s[0]);
	}
}
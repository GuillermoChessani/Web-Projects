<?php
/**
* COMPONENT FILE HEADER
**/
namespace GCore\Extensions\Chronoforums\Controllers;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Attachments extends \GCore\Extensions\Chronoforums\Chronoforums {
	var $models = array('\GCore\Admin\Extensions\Chronoforums\Models\Attachment');
	var $libs = array('\GCore\Libs\Request');
	var $helpers= array(
		'\GCore\Helpers\DataTable', 
		'\GCore\Helpers\Assets', 
		'\GCore\Helpers\Html', 
		'\GCore\Helpers\Toolbar', 
		'\GCore\Helpers\Tasks', 
		'\GCore\Helpers\Paginator',
		'\GCore\Helpers\Sorter'
	);
	
	function index(){
		$this->redirect(r_('index.php?option=com_chronoforums&cont=forums&f='.\GCore\Libs\Request::data('f', 0)));
	}
	
	function download(){
		if(\GCore\Libs\Authorize::authorized('\GCore\Extensions\Chronoforums\Chronoforums', 'download_attachments') === false){
			echo l_('CHRONOFORUMS_PERMISSIONS_ERROR');
			\GCore\Libs\Env::e404();
			return;
		}
		$file_id = $this->Request->data('file_id');
		$file = $this->Attachment->find('first', array('conditions' => array('id' => $file_id)));
		if(!empty($file)){
			$this->Attachment->id = $file_id;
			$this->Attachment->updateField('downloads', '+ 1');
			//get physical file name
			$filename = $file['Attachment']['vfilename'];
			$real_filename = $file['Attachment']['filename'];
			$attachments_path = $this->fparams->get('attachments_path', \GCore\C::ext_path('chronoforums', 'front').'attachments'.DS);
			$attachments_path = str_replace('/', DS, $attachments_path);
			$attachments_path = $this->fparams->get('user_directory_files', 0) ? $attachments_path.$file['Attachment']['user_id'].DS : $attachments_path;
			
			if(file_exists($attachments_path.$filename)){
				$ext = pathinfo($attachments_path.$filename, PATHINFO_EXTENSION);
				$inline_extensions = $this->fparams->get('inline_extensions', 'jpg-png-gif');
				$inline_extensions = explode('-', $inline_extensions);
				$view = 'D';
				if(in_array(strtolower($ext), $inline_extensions)){
					$view = 'I';
				}
				\GCore\Libs\Download::send($attachments_path.$filename, $view, $real_filename);
			}else{
				
			}
		}
	}
}
?>
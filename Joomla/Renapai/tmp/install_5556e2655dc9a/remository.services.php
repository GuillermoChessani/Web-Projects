<?php

/**************************************************************
* This file is part of Remository
* Copyright (c) 2006 Martin Brampton
* Issued as open source under GNU/GPL
* For support and other information, visit http://remository.com
* To contact Martin Brampton, write to martin@remository.com
*
* Remository started life as the psx-dude script by psx-dude@psx-dude.net
* It was enhanced by Matt Smith up to version 2.10
* Since then development has been primarily by Martin Brampton,
* with contributions from other people gratefully accepted
*/

DEFINE ('_ALIRO_INSTALL_CATEGORIES', '2,3,4,5');

class remositoryServices {
	private $files = array();
	private $cfiles = array();
	
	public function getInfo () {
		$uri = $_SERVER['REQUEST_URI'];
		$this->files = aliroDatabase::getInstance()->doSQLget("SELECT id, containerid, filetitle, realname FROM #__downloads_files ORDER BY filetitle");
		foreach ($this->files as $key=>$file) $this->cfiles[$file->containerid][] = $key;
		
		$elements = explode('/', $uri);
		if ('/' == substr($uri,-1)) array_pop($elements);
		$locator = array_search('repositorydata', $elements);
		if ($locator+1 == count($elements)) echo $this->showContainerStructure();
		else {
			$id = $elements[$locator+1];
			$file = new remositoryFile ($id);
			$user = aliroUser::getInstance();
			$file->getValues($user);
			$interface = remositoryInterface::getInstance();
			$repository = remositoryRepository::getInstance();
			$downloader = new remository_download_Controller(null);
			$downloader->deliverFile ($file, $repository, $interface, $user);
		}
	}
	
	private function showContainerStructure ($level=0, $containerid=0) {
		$manager = remositoryContainerManager::getInstance();
		$children = $manager->getChildren($containerid);
		$html = '';
		$categories = array_map('trim', explode(',', _ALIRO_INSTALL_CATEGORIES));
		foreach ($children as $child) if ($containerid OR in_array($child->id, $categories)) $html .= <<<ONE_CHILD
		
				<div class="remositorylevel$level" style="padding-left: 20px">
					$child->name
					{$this->showFiles($child)}
					{$this->showContainerStructure($level+1, $child->id)}
				</div>
		
ONE_CHILD;

		return <<<SHOW_ALL
		
			<div id="repositorydata">
				$html
			</div>
		
SHOW_ALL;

	}
	
	private function makeContainerLink ($container) {
		return 'index.php?option=com_remository&func=select&id='.$container->id;
	}
	
	private function showFiles ($container) {
		$html = '';
		if (!isset($this->cfiles[$container->id])) return $html;
		foreach ($this->cfiles[$container->id] as $key) {
			$file = $this->files[$key];
			$link = $this->makeFileLink($file);
			$html .= <<<ONE_FILE
			
					<div class="remositoryfile" style="padding-left: 20px">
						<a href="$link">$file->filetitle</a>
					</div>
					
ONE_FILE;

		}
		return $html;
	}
	
	private function makeFileLink ($file) {
		return aliroCore::getInstance()->getCfg('live_site')."/repositorydata/$file->id/$file->realname";
	}
}

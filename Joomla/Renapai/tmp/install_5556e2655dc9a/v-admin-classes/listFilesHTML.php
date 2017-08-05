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

class listFilesHTML extends remositoryAdminHTML {
	protected $default_view = 'listFiles';
	
	protected $files = array();
	protected $descendants = array();
	protected $search = '';

	protected function containerLink ($file) {
		$parent = $file->getContainer();
		if ($parent) {
			$grandparent = $parent->getParent();
			if ($grandparent) $linkid = $grandparent->id;
			else $linkid = $parent->id;
		}
		else $linkid = 0;
		$link = '';
		// Change for multiple repositories
		// if ($linkid) $link .= "<a href='index2.php?option=com_remository&amp;repnum=$this->repnum&amp;act=containers&amp;task=list&amp;parentid=$linkid'>";
		if ($linkid) $link .= "<a href=\"{$this->interface->indexFileName()}?option=com_remository&amp;act=containers&amp;task=list&amp;parentid=$linkid\">";
		$link .= $file->getFamilyNames();
		if ($linkid) $link .= '</a>';
		return $link;
	}

	protected function fileLocation ($file) {
		return $file->islocal ? _DOWN_IS_LOCAL : _DOWN_IS_REMOTE;
	}

	public function view ($files, $descendants, $search='')  {
		$this->descendants = $descendants;
		$this->files = $files;
		$this->search = $search;
		$this->display();
	}
	
}
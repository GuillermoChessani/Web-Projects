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

class listUnlinkedHTML extends remositoryAdminHTML {
	protected $default_view = 'listUnlinked';
	
	protected $OrphanDownloads = array();
	protected $OrphanUploads = array();
	protected $baselink = '';

	function view ($OrphanDownloads, $OrphanUploads, $baselink) {
		$this->OrphanDownloads = $OrphanDownloads;
		$this->OrphanUploads = $OrphanUploads;
		$this->baselink = $baselink;
		$this->display();
	}
}
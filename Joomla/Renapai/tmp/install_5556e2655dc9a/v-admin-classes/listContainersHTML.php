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

class listContainersHTML extends remositoryAdminHTML {
	protected $default_view = 'listContainers';
	
	protected $container = null;
	protected $containers = array();
	protected $descendants = array();
	protected $search = '';
	protected $authoriser = null;

	//private function
	protected function checkOtherPermission ($actions, $id) {
		$authAdmin = aliroAuthorisationAdmin::getInstance();
		$allowed = $authAdmin->permittedRoles ($actions, 'remosFolder', $id, array('Registered', 'Nobody'));
		return count($allowed);
	}

	// was showContainersHTML
	public function view ($container, $containers, $descendants, $search='')  {
		$this->container = $container;
		$this->containers = $containers;
		$this->descendants = $descendants;
		$this->search = $search;
		$this->authoriser = aliroAuthoriser::getInstance();
		$this->display();
	}
}
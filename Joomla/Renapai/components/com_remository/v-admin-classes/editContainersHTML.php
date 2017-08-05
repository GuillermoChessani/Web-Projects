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

class editContainersHTML extends remositoryAdminHTML {
	protected $default_view = 'listContainers';	
	
	protected $container = null;
	protected $roleselect = array();
	protected $subsinfo = null;

	function oneAccessSelector ($roleselect, $type, $title) {
		$select = $roleselect[$type];
		return <<<ACCESS_SELECTOR

		<div class="remositoryaccessselector">
		<fieldset>
			<legend>$title</legend>
			<div>
				$select
			</div>
			{$this->newRole($type)}
		</fieldset>
		</div>

ACCESS_SELECTOR;

	}

	private function newRole ($type) {
		$newrole = _DOWN_ADD_NEW_ROLE;
		if (!remositoryRepository::getInstance()->Use_CMS_Groups) return <<<NEW_ROLE

			<div>
				<label for="new_role_$type">$newrole</label>
				<input class="inputbox" type="text" name="new_role_$type" id="new_role_$type" />
			</div>

NEW_ROLE;

	}

	function view ($container, $roleselect, $subsinfo)	{
		$this->container = $container;
		$this->roleselect = $roleselect;
		$this->subsinfo = $subsinfo;
		$this->display();
	}
}

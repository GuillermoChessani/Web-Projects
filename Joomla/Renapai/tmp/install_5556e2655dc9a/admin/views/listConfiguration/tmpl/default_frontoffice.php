<?php

/**************************************************************
* This file is part of Remository
* Copyright (c) 2013 Martin Brampton
* Issued as open source under GNU/GPL
* For support and other information, visit http://remository.com
* To contact Martin Brampton, write to martin@remository.com
*
* Remository started life as the psx-dude script by psx-dude@psx-dude.net
* It was enhanced by Matt Smith up to version 2.10
* Since then development has been primarily by Martin Brampton,
* with contributions from other people gratefully accepted
*
* Template for Remository Configuration - Front Office
*/
    echo '<div class="row-fluid">';
	include ('default.php');
	
	echo <<<CONFIG_FRONTOFFICE
    <div class="span10">
	<form action="{$this->interface->indexFileName()}" method="post" name="adminForm" id="adminForm">
	<table cellpadding="2" cellspacing="4" border="0" width="100%" class="adminForm" id="adminForm">
	    {$this->configYesNoBox('Allow_Container_Add', _DOWN_CONFIG106, $this->yesno)}
	    {$this->configYesNoBox('Allow_Container_Edit', _DOWN_CONFIG108, $this->yesno)}
	    {$this->configYesNoBox('Allow_Container_Delete', _DOWN_CONFIG107, $this->yesno)}
	    {$this->configYesNoBox('User_Remote_Files', _DOWN_CONFIG29, $this->yesno)}
	    {$this->configYesNoBox('Allow_User_Sub', _DOWN_CONFIG12, $this->yesno)}
	    {$this->configYesNoBox('Allow_User_Edit', _DOWN_CONFIG13, $this->yesno)}
	    {$this->configYesNoBox('Allow_User_Delete', _DOWN_CONFIG42, $this->yesno)}
	    {$this->configTextBox(_DOWN_CONFIG7, 'Max_Up_Per_Day')}
	    {$this->configTextBox(_DOWN_CONFIG9, 'ExtsOk')}
	    {$this->configYesNoBox('Enable_Admin_Autoapp', _DOWN_CONFIG26, $this->yesno)}
	    {$this->configYesNoBox('Make_Auto_Thumbnail', _DOWN_CONFIG43, $this->yesno)}
	    {$this->configTextBox(_DOWN_CONFIG32, 'Default_Version')}
	    {$this->configYesNoBox('Send_Sub_Mail', _DOWN_CONFIG16, $this->yesno)}
	    {$this->configTextBox(_DOWN_CONFIG17, 'Sub_Mail_Alt_Addr')}
	    {$this->configTextBox(_DOWN_CONFIG18, 'Sub_Mail_Alt_Name')}
	</table>
	<div>
		<input type="hidden" name="option" value="com_remository" />
		<input type="hidden" name="repnum" value="$this->repnum" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="act" value="$this->act" />
		<input type="hidden" name="configpage" value="frontoffice" />
	</div>
	</form></div></div>

CONFIG_FRONTOFFICE;

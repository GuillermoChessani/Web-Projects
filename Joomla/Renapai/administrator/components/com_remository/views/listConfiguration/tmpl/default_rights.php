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
* Template for Remository Configuration - Rights
*/
    echo '<div class="row-fluid">';
	include ('default.php');
	
	echo <<<CONFIG_RIGHTS
    <div class="span10">
	<form action="{$this->interface->indexFileName()}" method="post" name="adminForm" id="adminForm">
	<table cellpadding="2" cellspacing="4" border="0" width="100%" class="adminForm" id="adminForm">
	    {$this->configYesNoBox('Use_CMS_Groups', _DOWN_CONFIG104, $this->yesno)}
	    {$this->configYesNoBox('Activate_AEC', _DOWN_CONFIG66, $this->yesno)}
	    {$this->configTextBox(_DOWN_CONFIG46, 'ExtsDisplay')}
	    {$this->configYesNoBox('Audio_Download', _DOWN_CONFIG60, $this->yesno)}
	    {$this->configTextBox(_DOWN_CONFIG56, 'ExtsAudio')}
	    {$this->configYesNoBox('Video_Download', _DOWN_CONFIG61, $this->yesno)}
	    {$this->configTextBox(_DOWN_CONFIG57, 'ExtsVideo')}
	    {$this->configYesNoBox('Enable_List_Download', _DOWN_CONFIG28, $this->yesno)}
	    {$this->configYesNoBox('Allow_Comments', _DOWN_CONFIG15, $this->yesno)}
	    {$this->configYesNoBox('Allow_Votes', _DOWN_CONFIG25, $this->yesno)}
	    {$this->configTextBox(_DOWN_CONFIG40, 'Max_Down_Per_Day')}
	    {$this->configTextBox(_DOWN_CONFIG44, 'Max_Down_Reg_Day')}
	    {$this->configTextBox(_DOWN_CONFIG41, 'Max_Down_File_Day')}
	</table>
	<div>
		<input type="hidden" name="option" value="com_remository" />
		<input type="hidden" name="repnum" value="$this->repnum" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="act" value="$this->act" />
		<input type="hidden" name="configpage" value="rights" />
	</div>
	</form></div></div>

CONFIG_RIGHTS;

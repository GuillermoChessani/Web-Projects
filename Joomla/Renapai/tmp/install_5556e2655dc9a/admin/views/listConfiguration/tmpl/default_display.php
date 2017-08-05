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
* Template for Remository Configuration - Display Management
*/
    echo '<div class="row-fluid">';
	include ('default.php');
	
	echo <<<CONFIG_DISPLAY
    <div class="span10">
	<form action="{$this->interface->indexFileName()}" method="post" name="adminForm" id="adminForm">
	<table cellpadding="2" cellspacing="0" border="0" width="100%" class="adminForm">
	    {$this->configTextBox(_DOWN_CONFIG65, 'Main_Page_Title')}
	    {$this->configTextBox(_DOWN_CONFIG19, 'headerpic')}
	    {$this->configYesNoBox('Remository_Pathway', _DOWN_CONFIG50, $this->yesnoboth)}
	    {$this->configYesNoBox('Show_RSS_feeds', _DOWN_CONFIG48, $this->yesno)}
	    {$this->configYesNoBox('See_Containers_no_download', _DOWN_CONFIG33, $this->yesno)}
	    {$this->configYesNoBox('Show_SubCategories', _DOWN_CONFIG71, $this->yesno)}
	    {$this->configTextBox(_DOWN_CONFIG55, 'Featured_Number')}
	    {$this->configYesNoBox('Show_File_Folder_Counts', _DOWN_CONFIG53, $this->yesno)}
	    {$this->configTextBox(_DOWN_CONFIG47, 'Scribd')}
	    {$this->configYesNoBox('See_Files_no_download', _DOWN_CONFIG34, $this->yesno)}
	    {$this->configYesNoBox('Immediate_Download', _DOWN_CONFIG103, $this->yesno)}
	    {$this->configYesNoBox('Allow_File_Info', _DOWN_CONFIG51, $this->yesno)}
	    {$this->configYesNoBox('Count_Down', _DOWN_CONFIG54, $this->yesno)}
	    {$this->configYesNoBox('Allow_Large_Images', _DOWN_CONFIG38, $this->yesno)}
	    {$this->configTextBox(_DOWN_CONFIG36, 'Large_Image_Width')}
	    {$this->configTextBox(_DOWN_CONFIG37, 'Large_Image_Height')}
	    {$this->configYesNoBox('Show_Footer', _DOWN_CONFIG52, $this->yesno)}
	    {$this->configYesNoBox('Show_all_containers', _DOWN_CONFIG70, $this->yesno)}
	    {$this->configTextBox(_DOWN_CONFIG1, 'tabclass')}
	    {$this->configTextBox(_DOWN_CONFIG2, 'tabheader')}
	</table>
	<div>
		<input type="hidden" name="option" value="com_remository" />
		<input type="hidden" name="repnum" value="$this->repnum" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="act" value="$this->act" />
		<input type="hidden" name="configpage" value="display" />
	</div>
	</form></div></div>

CONFIG_DISPLAY;
		
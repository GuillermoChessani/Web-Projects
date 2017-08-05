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
* Template for Remository Configuration - Paths/Misc
*/
    echo '<div class="row-fluid">';
    include ('default.php');

	echo <<<CONFIG_PATHS
    <div class="span10">
	<form action="{$this->interface->indexFileName()}" method="post" name="adminForm" id="adminForm">
	<table cellpadding="2" cellspacing="4" border="0" width="100%" class="adminForm" id="">
	    {$this->configTextBox(_DOWN_CONFIG67, 'Profile_URI')}
	    {$this->configTextBox(_DOWN_CONFIG49, 'Classification_Types')}
	    {$this->configTextBox(_DOWN_CONFIG4, 'Down_Path')}
	    {$this->configTextBox(_DOWN_CONFIG5, 'Up_Path')}
	    {$this->configYesNoBox('Use_Database', _DOWN_CONFIG39, $this->yesno)}
	    {$this->configTextBox(_DOWN_CONFIG8, 'Max_Up_Dir_Space')}
	    {$this->configYesNoBox('Allow_Up_Overwrite', _DOWN_CONFIG11, $this->yesno)}
	    {$this->configYesNoBox('Real_With_ID', _DOWN_CONFIG72, $this->yesno)}
	    {$this->configTextBox(_DOWN_CONFIG6, 'MaxSize')}
	    {$this->configTextBox(_DOWN_CONFIG21, 'Large_Text_Len')}
	    {$this->configTextBox(_DOWN_CONFIG22, 'Small_Text_Len')}
	    {$this->configTextBox(_DOWN_CONFIG35, 'Max_Thumbnails')}
	    {$this->configTextBox(_DOWN_CONFIG23, 'Small_Image_Width')}
	    {$this->configTextBox(_DOWN_CONFIG24, 'Small_Image_Height')}
	    {$this->configTextBox(_DOWN_CONFIG30, 'Favourites_Max')}
	    {$this->configTextBox(_DOWN_CONFIG63, 'Main_Authors')}
	    {$this->configTextBox(_DOWN_CONFIG64, 'Author_Threshold')}
	    {$this->configTextBox(_DOWN_CONFIG31, 'Date_Format')}
	    {$this->configTextBox(_DOWN_CONFIG69, 'Set_date_locale')}
	    {$this->configTextBox(_DOWN_CONFIG68, 'Force_Language')}
	</table>
	<div>
		<input type="hidden" name="option" value="com_remository" />
		<input type="hidden" name="repnum" value="$this->repnum" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="act" value="$this->act" />
		<input type="hidden" name="configpage" value="paths" />
	</div>
	</form></div></div>

CONFIG_PATHS;

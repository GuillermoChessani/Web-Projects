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
* Template for Remository Configuration - Download Text
*/
    echo '<div class="row-fluid">';
	include ('default.php');
	
	echo <<<CONFIG_DLTEXT
    <div class="span10">
	<form action="{$this->interface->indexFileName()}" method="post" name="adminForm" id="adminForm">
	<table cellpadding="2" cellspacing="4" border="0" width="100%" class="adminForm" id="adminForm">
		{$this->fileInputAreaconfig(_DOWN_DOWNLOAD_TEXT_BOX, '', 'download_text', $this->repository->download_text, 50, 100)}
	</table>
	<div>
		<input type="hidden" name="option" value="com_remository" />
		<input type="hidden" name="repnum" value="$this->repnum" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="act" value="$this->act" />
		<input type="hidden" name="configpage" value="downloadtext" />
	</div>
	</form>
    </div></div>
CONFIG_DLTEXT;

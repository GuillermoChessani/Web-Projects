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
* Template for Remository Edit Container
*/

	$iconList = remositoryContainer::getIcons ();
	$this->commonScripts('description');

	if (!defined('_ALIRO_IS_PRESENT')) $formstart = <<<FORM_START

		<form method="post" name="adminForm" id="adminForm" action="{$this->interface->indexFileName()}" enctype="multipart/form-data">

FORM_START;

	else $formstart = '';

	$heading = _DOWN_REMOSITORY.' '._DOWN_EDIT_CONTAINER.' <span class="small">(ID='.$this->container->id.')</span>';
	$loctext = _DOWN_SUGGEST_LOC;
	$leftcontents = $this->narrowInputBox(_DOWN_FOLDER_NAME, 'name', $this->container->name, 50).
		$this->narrowInputBox(_DOWN_ALIAS.':', 'alias', $this->container->alias, 50).
		$this->simpleInputArea(_DOWN_DESC, _DOWN_DESC_MAX, 'description', $this->container->description, 50, 100, true);
	if ($this->repository->Display_FolderIcons) $leftcontents .= $this->simpleIcons($this->container, $iconList);
	// $site = remositoryInterface::getInstance()->getCfg('live_site');

	echo <<<MAIN_DIV

		<div id="remositoryedit">
		$formstart
			<table class="adminheading">
	        {$this->interface->adminPageHeading($heading, 'generic')}
            </table>


		<div id="remositorycontainermain" class="span8">
		<label for="$loctext"><strong>$loctext</strong></label>
		<div>
			$this->clist
		</div>
			$leftcontents
		</div>

MAIN_DIV;

    echo '<div class="span4 remositorycontainerparams">';
	echo $this->fieldset(_DOWN_PUBLISHING, $this->simpleCheckBox ($this->container, 'published', _DOWN_PUB));
	
	echo $this->fieldset(_DOWN_METADATA,
			$this->simpleInputBox(_DOWN_KEYWORDS,'keywords',$this->container->keywords,50).
			$this->simpleInputBox(_DOWN_WINDOW_TITLE,'windowtitle',$this->container->windowtitle,50)
		);

	echo $this->fieldset(_DOWN_STORAGE,
			$this->simpleInputBox(_DOWN_UP_ABSOLUTE_PATH,'filepath',$this->container->filepath,50).
			$this->yesNoRadio (null, 'inheritpath', _DOWN_INHERIT).
			$this->simpleCheckBox($this->container, 'plaintext', _DOWN_UP_PLAIN_TEXT)
		);
	
	echo $this->fieldset(_DOWN_ACCESS_CONTROL,
			($this->subsinfo ?  $this->yesNoRadio ($this->container, 'countdown', _DOWN_COUNT_DOWN).
				$this->yesNoRadio ($this->container, 'childcountdown', _DOWN_COUNT_DOWN_CHILD).
				$this->yesNoRadio ($this->container, 'countup', _DOWN_COUNT_UP).
				$this->yesNoRadio ($this->container, 'childcountup', _DOWN_COUNT_UP_CHILD) : '').
			$this->oneAccessSelector ($this->roleselect, 'download', _DOWN_DOWNLOAD_ROLES).
			$this->oneAccessSelector ($this->roleselect, 'upload', _DOWN_UPLOAD_ROLES).
			$this->oneAccessSelector ($this->roleselect, 'edit', _DOWN_EDIT_ROLES).
			$this->oneAccessSelector ($this->roleselect, 'selfApprove', _DOWN_APPROVE_ROLES).
			$this->yesNoRadio (null, 'inherit', _DOWN_INHERIT),'access_control'
		);
    echo '</div>';
	echo <<<END_PAGE

		<input type="hidden" name="cfid" value="{$this->container->id}" />
		<input type="hidden" name="limit" value="$this->limit" />
		<input type="hidden" name="oldpath" value="{$this->container->filepath}" />
		<input type="hidden" name="option" value="com_remository" />
		<input type="hidden" name="repnum" value="$this->repnum" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="act" value="$this->act" />

END_PAGE;

	if (!defined('_ALIRO_IS_PRESENT')) echo '</form>';
	echo "\n\t</div>";

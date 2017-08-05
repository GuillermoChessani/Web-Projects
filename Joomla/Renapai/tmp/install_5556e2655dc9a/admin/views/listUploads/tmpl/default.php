<?php

/**************************************************************
* This file is part of Remository
* Copyright (c) 2013 Remository Software Ltd
* Issued as open source under GNU/GPL
* For support and other information, visit http://remository.com
* To contact Martin Brampton, write to martin@remository.com
*
* Remository started life as the psx-dude script by psx-dude@psx-dude.net
* It was enhanced by Matt Smith up to version 2.10
* Since then development has been primarily by Martin Brampton,
* with contributions from other people gratefully accepted
*
* Template for Remository New Uploads
*/

	$this->formStart(_DOWN_APPROVE_TITLE);
	echo "\n\t</table>";
	$this->listHeadingStart(count($this->files));
	$this->headingItem('15%', _DOWN_NAME_TITLE);
	$this->headingItem('20%', _DOWN_PARENT_CAT);
	$this->headingItem('20%', _DOWN_PARENT_FOLDER);
	$this->headingItem('20%', _DOWN_DATE);
	$this->headingItem('15%', _DOWNLOAD);
	echo "\n</tr></thead>";
	$k = 0;
	echo "\n\t\t<tbody>";
	
	foreach ($this->files as $i=>$file) {
		$indexfile = $this->interface->indexFileName(3);
		$downlink = $this->interface->getCfg('admin_site')."/$indexfile?option=com_remository&amp;act=download&amp;id=".$file->id;
		echo <<<LIST_LINE

		<tr class="row$k">
			<td width="5">
				<input type="checkbox" id="cb$i" name="cfid[]" value="$file->id" onclick="isChecked(this.checked);" />
			</td>
			<td align="left">
				<a href="{$this->interface->indexFileName()}?option=com_remository&amp;act={$_REQUEST['act']}&amp;task=edit&cfid=$file->id">
					$file->filetitle
				</a>
			</td>
			<td align="left">{$file->getCategoryName()}</td>
			<td align="left">{$file->getFamilyNames()}</td>
			<td align="left">$file->filedate</td>
			<td align="left"><a href="$downlink">{$this->show(_DOWNLOAD)}</a></td>
		</tr>

LIST_LINE;

		$k = 1 - $k;
	}
	
	if (count($this->files) == 0) {
		$text = '0 '._DOWN_RECORDS;
		echo <<<NO_RECORDS

		<tr>
			<td colspan="13" align="center"><span class="message">$text</span></td>
		</tr>

NO_RECORDS;

		
	}
	$this->pageNav->listFormEnd();
	echo "\n\t\t</tbody></table></form>";

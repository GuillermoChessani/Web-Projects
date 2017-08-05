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
* Template for Remository Missing Files
* 
*/

	$this->formStart(_DOWN_MISSING_TITLE);
	echo "\n\t</table>";
	$this->listHeadingStart($this->filecount);
	$this->headingItem('5%', 'ID');
	$this->headingItem('15%', _DOWN_NAME_TITLE);
	$this->headingItem('25%', _DOWN_PARENT_CAT);
	$this->headingItem('25%', _DOWN_PARENT_FOLDER);
	$this->headingItem('20%', _DOWN_DATE);
	$this->headingItem('20%', '');
	echo "\n</tr></thead>";
	$this->pageNav->listFormEnd(false);
	$k = 0;
	echo "\n\t\t<tbody>";
	foreach ($this->files as $i=>$file) {
		echo <<<LIST_LINE

		<tr class="row$k">
			<td width="5">
				<input type="checkbox" id="cb$i" name="cfid[]" value="$file->id" onclick="Joomla.isChecked(this.checked);" />
			</td>
			<td>
				$file->id
			</td>
			<td align="left">
				<a href="{$this->interface->indexFileName()}?option=com_remository&amp;act={$_REQUEST['act']}&amp;task=edit&cfid=$file->id">
					$file->filetitle
				</a>
			</td>
			<td align="left">{$file->getCategoryName()}</td>
			<td align="left">{$file->getFamilyNames()}</td>
			<td align="left">$file->filedate</td>
			<td align="left">$file->location</td>
		</tr>

LIST_LINE;

		$k = 1 - $k;
	}
	if (0 == $this->filecount) {
		echo '<tr><td colspan="6" align="center"><span class="message">'._DOWN_NONE_MISSING.'</span></td></tr>';
	}
	echo "\n\t\t</tbody></table></form>";

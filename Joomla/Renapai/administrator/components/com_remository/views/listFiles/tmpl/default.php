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
* Template for Remository List Files
*/

	$this->formStart(_DOWN_FILES);
	$this->listHeader($this->descendants, $this->search);
	echo '</table>';
	$this->listHeadingStart(count($this->files));
	$this->headingItem('5', _DOWN_ID);
	$this->headingItem('15%', _DOWN_NAME_TITLE);
	$this->headingItem('15%', _DOWN_PARENT_CAT);
	$this->headingItem('15%', _DOWN_PARENT_FOLDER);
	$this->headingItem('10%', _DOWN_LOCAL_OR_REMOTE);
	$this->headingItem('10%', _DOWN_PUB1);
	$this->headingItem('10%', _DOWN_DOWNLOADS_SORT);
	$this->headingItem('10%', '');
	echo "\n</tr></thead>";
	$this->pageNav->listFormEnd();
	$k = 0;
	echo "\n\t\t<tbody>";
	$indexfile = $this->interface->indexFileName(3);
	foreach ($this->files as $i=>$file) {
		$downlink = $this->interface->getCfg('admin_site')."/$indexfile?option=com_remository&amp;act=download&amp;id=".$file->id;
		$checkbox = JHtml::_('grid.id', $i, $file->id);
		/*if ($file->published) {
			$publishimage = 'publish_g';
			$publishalt = 'Published';
		}
		else {
			$publishimage = 'publish_x';
			$publishalt = 'Not Published';
		}*/
        $publish_unpublish = JHtml::_('jgrid.published', $file->published, $i, '', true, 'cb');


        $downtext = _DOWNLOAD;
		echo <<<FILE_LINE
			
				<tr class="row$k">
					<td width="5">
						$checkbox
					</td>
					<td>
						$file->id
					</td>
					<td width="15%" align="left">
						{$this->editLink($file->id, $file->filetitle, $file->containerid)}
					</td>
					<td width="15%" align="left">{$file->getCategoryName()}</td>
					<td width="15%" align="left">{$this->containerLink($file)}</td>
					<td width="10%" align="left">{$this->fileLocation($file)}</td>
					<td width="10%" align="center">{$publish_unpublish}</td>
					<td width="10%" align="left">$file->downloads</td>
					<td width="10%" align="left"><a href="$downlink">$downtext</a></td>
				</tr>
			
FILE_LINE;
			
		$k = 1 - $k;
	}
	echo "\n\t\t</tbody></table></form>";

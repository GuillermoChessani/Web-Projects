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
* Template for Remository List Containers
*/

	$title = $this->container->id ? _DOWN_CONTAINERS.' - '.$this->container->name : _DOWN_CONTAINERS;
	$this->formStart($title);
	$this->listHeader($this->descendants, $this->search);
	echo '</table>';
		
	$this->listHeadingStart(count($this->containers));
	$this->headingItem('10%', _DOWN_NAME_TITLE);
	$this->headingItem('3%', _DOWN_VISIT);
	//$this->headingItem('3%', _DOWN_EDIT);
	if ($this->clist) {

		$this->headingItem('10%', _DOWN_PARENT_CAT);
		$this->headingItem('10%', _DOWN_PARENT_FOLDER);
	}
	$this->headingItem('6%', _DOWN_PUB1);
	$this->headingItem('6%', _DOWN_RECORDS);
	$this->headingItem('8%', _DOWN_VISITORS);
	$this->headingItem('8%', _DOWN_REG_USERS);
	$this->headingItem('8%', _DOWN_OTHER_USERS);
	$this->headingItem('10%', _DOWN_STORAGE_STATUS);
if ($this->clist) {
    $this->headingItem('3%', 'ID');
}
	echo "\n</tr></thead>";
		
	$this->pageNav->listFormEnd();
	$k = $parentid = 0;
	echo "\n\t\t<tbody>";
		
	foreach ($this->containers as $i=>$container) {
	    $parentid = $container->parentid;
		$categoryname = $this->visitLink(0, $container->getCategoryName());
		$family = $container->getFamilyNames();
		if ($container->parentid) {
		    $parent = $container->getParent();
		    if ($parent->parentid) $family = $this->visitLink($parent->parentid, $family);
		}
		if ($container->filecount) {
			$counthtml = <<<COUNT
				<a href='{$this->interface->indexFileName()}?option=com_remository&amp;act=files&amp;task=list&amp;containerid=$container->id'>
					$container->filecount
				</a>
COUNT;
			
		}
		else $counthtml = '0';
		/*if ($container->published) {
			$publishimage = 'publish_g';
			$publishalt = 'Published';
		}
		else {
			$publishimage = 'publish_x';
			$publishalt = 'Not Published';
		}*/
		$otherimagedown = $this->checkOtherPermission(array('download','edit'), $container->id) ? $this->repository->RemositoryImageURL('download_trans.gif').'/' : '-/';
		$otherimageup = $this->checkOtherPermission(array('upload','edit'), $container->id) ? $this->repository->RemositoryImageURL('add_file.gif') : '-';
		$publicdown = $this->authoriser->checkRolePermission('Public', array('download','edit'), 'remosFolder', $container->id) ? $this->repository->RemositoryImageURL('download_trans.gif').'/' : '-/';
		$publicup = $this->authoriser->checkRolePermission('Public', array('upload','edit'), 'remosFolder', $container->id) ? $this->repository->RemositoryImageURL('add_file.gif') : '-';
		$regdown = $this->authoriser->checkRolePermission(array('Public','Registered'), array('download','edit'), 'remosFolder', $container->id) ? $this->repository->RemositoryImageURL('download_trans.gif').'/' : '-/';
		$regup = $this->authoriser->checkRolePermission(array('Public','Registered'), array('upload','edit'), 'remosFolder', $container->id) ? $this->repository->RemositoryImageURL('add_file.gif') : '-';
		
		$checkbox = JHtml::_('grid.id', $i, $container->id);
        $publish_unpublish = JHtml::_('jgrid.published', $container->published, $i, '', true, 'cb');

		echo <<<CONTAINER_LINE
				
		<tr class="row$k">
			<td>
				$checkbox
			</td>
			<td align="left">{$this->editLink($container->id, $container->name)}</td>
			<td align="left">
				{$this->visitLink($container->id, _DOWN_VISIT)}
			</td>


			<td align="left">$categoryname</td>
			<td align="left">$family</td>
			<td align="left">
			{$publish_unpublish}</td>
			<td align="left">$counthtml</td>
			<td align="left">
				$publicdown
				$publicup
			</td>
			<td align="left">
				$regdown
				$regup
			</td>
			<td align="left">
				$otherimagedown
				$otherimageup
			</td>
			<td align="left">
				$container->pathstatus
			</td>
			<td align="left">$container->id</td>
		</tr>
				
CONTAINER_LINE;
		
		$k = 1 - $k;
	}
		
	echo <<<SAVE_PARENT
		</tbody>
		</table>
		<div>
			<input type="hidden" name="currparent" value="$parentid" />
		</div>
		</form>
		
SAVE_PARENT;


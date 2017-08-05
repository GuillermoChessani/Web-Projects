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
* Template for Remository File Classifications List
* 
*/

	$this->formStart(_DOWN_CLASSIFICATIONS);
	//$displaytext = $this->pageNav->getLimitBox();
	$searchtext = _DOWN_SEARCH_COLON;
	$typoptions = <<<NULL_OPTION

			<option value="">Display all</option>

NULL_OPTION;

	foreach ($this->types as $one) {
		if ($one == $this->type) $selected = ' selected="selected"';
		else $selected = '';
		$typoptions .= <<<OPTION

			<option$selected value="$one">$one</option>

OPTION;

	}
	$typeselect = <<<SELECTION

			<td align="" class="classification_search">
				<select name="type" onchange="document.adminForm.submit();">
					$typoptions
				</select>
			</td>

SELECTION;

	echo <<<FILTER_HTML

		<tr>

			<td align="left">

			<div class="js-stools-container-bar">
                <label class="element-invisible" for="filter_search" aria-invalid="false">
                {$searchtext}</label>
                <div class="btn-wrapper input-append">
                    <input type="text" placeholder="{$searchtext}" value="{$this->search}" id="filter_search" name="search">
                        <button title="" class="btn hasTooltip" type="submit"  data-original-title="Search"><i class="icon-search"></i></button>
                </div>

                <div class="btn-wrapper">
                <button title="" class="btn hasTooltip js-stools-btn-clear" onclick="document.id('filter_search').value='';this.form.submit();" type="button" data-original-title="Clear">Clear</button>
                </div>
			</div>

    		</td>
    		$typeselect
		</tr>

FILTER_HTML;

	echo '</table>';
	$this->listHeadingStart(count($this->classifications));
	$this->headingItem('15%', _DOWN_NAME_TITLE);
	$this->headingItem('5%', _DOWN_PUB1);
	$this->headingItem('5%', _DOWN_IS_VISIBLE);
	$this->headingItem('10%', _DOWN_FREQUENCY);
	$this->headingItem('10%', _DOWN_TYPE);
	$this->headingItem('45%', _DOWN_DESCRIPTION);
    $this->headingItem('3%', _DOWN_ID);
	echo '</tr></thead><tbody>';
	$k = $parentid = 0;
	if ($this->classifications) foreach ($this->classifications as $i=>$classification) {
		//$pimage = $classification->published ? 'publish_g.png' : 'publish_x.png';
		//$palt = $classification->published ? _DOWN_PUB1 : _DOWN_NOT_PUBLISHED;
		$himage = $classification->hidden ? 'publish_x.png' : 'tick.png';
		$halt = $classification->hidden ? 'Hidden' : 'Not hidden';
		$admin_images = $this->interface->getAdminImagePath();

        $publish_unpublish = JHtml::_('jgrid.published', $classification->published, $i, '', true, 'cb');


        echo <<<CLASSN_LINE

				<tr class="row$k">
					<td>
						<input type="checkbox" id="cb$i" name="cfid[]" value="$classification->id" onclick="Joomla.isChecked(this.checked);" />
					</td>
					<td align="left"><a href="{$this->interface->indexFileName()}?option=com_remository&amp;act=$this->act&amp;task=edit&amp;cfid=$classification->id">$classification->name</a></td>
					<td align="left">$publish_unpublish</td>
					<td align="left"><img src="$admin_images/$himage" border="0" alt="$halt" /></td>
					<td align="left">$classification->frequency</td>
					<td align="left">$classification->type</td>
					<td align="left">$classification->description</td>
					<td align="left">$classification->id</td>

				</tr>

CLASSN_LINE;

		$k = 1 - $k;
	}

echo '</tbody>';
$this->pageNav->listFormEnd();
echo '</table></form>';



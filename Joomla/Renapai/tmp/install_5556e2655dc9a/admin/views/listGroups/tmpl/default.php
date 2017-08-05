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
* Template for Remository List Groups
*/

        $k = 0;
        $role_list = '';
        $i=0;
        foreach ($this->roles as $role=>$translated) {
            $editlink = "index.php?option=com_remository&act=groups&task=edit&role=".$translated;
        	$idrole = str_replace(' ', '0', $role);
			//$checkbox = JHtml::_('grid.id', $k, $idrole);
            $checkbox = '<input type="checkbox" id="cb'.$i.'" name="cfid[]" value="'.$translated.'" onclick="Joomla.isChecked(this.checked);" />';

        	$role_list .= <<<ROLE_LINE
            <tr class="row$k">
            	<td width='20'>
					$checkbox
				</td>
				<td align="left">
					<a href="$editlink">
						$translated
					</a>
				</td>
				<td align="left">
					$translated
        		</td>
        		<td></td>
			</tr>

ROLE_LINE;

            $k = 1 - $k;
            $i++;
        }

$this->formStart(_MBT_GROUP_MANAGER);
//echo $this->show(_MBT_GROUP_FILTER);
echo <<<LIST_HEADER

<div class="js-stools-container-bar">
                <label class="element-invisible" for="filter_search" aria-invalid="false">
                {_DOWN_SEARCH_COLON}</label>
                <div class="btn-wrapper input-append">
                    <input type="text" placeholder="{$this->show(_DOWN_SEARCH_COLON)}" value="{$this->rsearch}" id="filter_search" name="rsearch">
                        <button title="" class="btn hasTooltip" type="submit"  data-original-title="Search"><i class="icon-search"></i></button>
                </div>

                <div class="btn-wrapper">
                <button title="" class="btn hasTooltip js-stools-btn-clear" onclick="document.id('filter_search').value='';this.form.submit();" type="button" data-original-title="Clear">Clear</button>
                </div>
			</div>
			<input type="hidden" name="listype" value="roles" />
LIST_HEADER;



 		$checkall = JHtml::_('grid.checkall');
		echo <<<ROLE_LIST1
            </table>
			<table class="table table-striped" cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
				<thead>
				<tr>
					<th width="5%" align="left">$checkall</th>
					<th class="title" width="30%"><div align="left">{$this->show(_MBT_GROUP_GROUP)}</div></th>
					<th class="title" width="55%"><div align="left">{$this->show(_MBT_GROUP_DESCRIPTION)}</div></th>
					<th class="title" width="15%"><div align="left">{$this->show(_MBT_GROUP_EMAIL)}</div></th>
				</tr>
				</thead>
					
ROLE_LIST1;
					
		echo <<<ROLE_LIST
		
				<tbody>
					$role_list
       			</tbody>
       			<tfoot>
       			{$this->pageNav->listFormEnd()}
       			</tfoot>
       		</table>
       	</form>	

ROLE_LIST;


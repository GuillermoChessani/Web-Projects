<?php

/**************************************************************
* This file is part of Remository
* Copyright (c) 2006 Martin Brampton
* Issued as open source under GNU/GPL
* For support and other information, visit http://remository.com
* To contact Martin Brampton, write to martin@remository.com
*
* Remository started life as the psx-dude script by psx-dude@psx-dude.net
* It was enhanced by Matt Smith up to version 2.10
* Since then development has been primarily by Martin Brampton,
* with contributions from other people gratefully accepted
*/

class listConfigurationHTML extends remositoryAdminHTML {
	protected $customnames = array();
	protected $page = '';
	protected $pagenames = array(
		'paths' => _DOWN_CONFIG_TITLE1,
		'display' => _DOWN_CONFIG_TITLE_DISPLAY,
		'rights' => _DOWN_CONFIG_TITLE_RIGHTS,
		'frontoffice' => _DOWN_CONFIG_TITLE_FRONT_OFFICE_MGT,
		'downloadtext'=> _DOWN_CONFIG_TITLE3,
		'intro' => _DOWN_CONFIG_TITLE_PREAMBLE,
		'licence' => _DOWN_CONFIG_TITLE_LICENCE,
		'customize' => _DOWN_CONFIG_TITLE4
	);
	
	protected function menulink ($name) {
		return 'index.php?option=com_remository&act=config'.(isset($this->pagenames[$name]) ? '&page='.$name : '');
	}
	
    protected function configTextBox ($title, $name) {
        return '<tr>
		<td width="50%">'.$title.'</td>
		<td  width="50%"> <input class="inputbox" type="text" name="'.$name.'" size="50" value="'.$this->repository->$name.'" /></td>
	    </tr>';
    }

    protected function configYesNoBox ($variablename, $description, &$optionlist) {

        return '<tr><td width="">'.$description.'</td><td>'.$this->repository->selectList($optionlist, $variablename, 'class="inputbox" size="1"', $this->repository->$variablename).'
		</td></tr>';

    }

    public function view ($customnames, $page='paths') {
		$this->customnames = $customnames;
		$this->page = $page;
		if (isset($this->pagenames[$page])) $this->display($page);
		else $this->display();
    }
}
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
* Template for Remository Configuration - common part
*/


foreach ($this->pagenames as $name=>$title){
    JHtmlSidebar::addEntry($title, $this->menulink($name),$name==$this->page);
}
$sidebar = JHtmlSidebar::render();

$title = _DOWN_CONFIG_TITLE;
$this->interface->adminPageHeading('Remository '.$title, 'generic');

echo <<<CONFIG_MENU
<div class="span2">{$sidebar}</div>
CONFIG_MENU;

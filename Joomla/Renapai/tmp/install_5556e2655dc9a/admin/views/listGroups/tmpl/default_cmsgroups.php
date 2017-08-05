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

	$this->formStart(_MBT_GROUP_MANAGER);
	//echo '</table><table cellpadding="4" cellspacing="0" border="0" width="100%" class=""></table>';
	echo <<<UNDER_HEADING


		<div>
			<input type="hidden" name="task" value=""/>
			<input type="hidden" name="option" value="com_remository"/>
			<input type="hidden" name="repnum" value="$this->repnum" />
		</div>
		</form>

UNDER_HEADING;

	echo <<<NO_GROUPS

		<div class="alert alert-info">{$this->show(_DOWN_NO_REMOSITORY_GROUPS)}</div>

NO_GROUPS;


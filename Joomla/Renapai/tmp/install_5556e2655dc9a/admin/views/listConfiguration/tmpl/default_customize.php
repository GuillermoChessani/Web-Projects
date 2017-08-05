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
* Template for Remository Configuration - Customize
*/
    echo '<div class="row-fluid">';
	include ('default.php');

	$customobj = new remositoryCustomizer();
    $fieldnames = $customobj->getFileListFields();
    $values = $customobj->getCustomSpec();
	$lines = '';

    foreach ($values['S'] as $key=>$sequence) $reseq[$sequence][] = $key;
    if (isset($reseq)) {
	    ksort($reseq);
	    $sequence = 0;
	    foreach ($reseq as $kset) foreach ($kset as $key) {
		    $legend = $fieldnames[$key][1];
		    $achecked = empty($values['A'][$key]) ? '' : 'checked="checked"';
		    $bchecked = empty($values['B'][$key]) ? '' : 'checked="checked"';
		    $cchecked = empty($values['C'][$key]) ? '' : 'checked="checked"';
		    $dchecked = empty($values['D'][$key]) ? '' : 'checked="checked"';
		    $echecked = empty($values['E'][$key]) ? '' : 'checked="checked"';
		    $sequence += 10;

		    $lines .= <<<FIELD_SELECT

	    <tr>
		    <td class="config_customize_legend">$legend</td>
		    <td class="config_customize_legend sequence"><input type="text" name="sequence[$key]" value="$sequence" size="5" /></td>
		    <td><input type="checkbox" name="afield[$key]" value="1" $achecked /></td>
		    <td><input type="checkbox" name="bfield[$key]" value="1" $bchecked /></td>
		    <td><input type="checkbox" name="cfield[$key]" value="1" $cchecked /></td>
		    <td><input type="checkbox" name="dfield[$key]" value="1" $dchecked /></td>
		    <td><input type="checkbox" name="efield[$key]" value="1" $echecked /></td>
	    </tr>

FIELD_SELECT;

	    }
    }

	echo <<<CONFIG_CUSTOMIZE
    <div class="span10">
	<form action="{$this->interface->indexFileName()}" method="post" name="adminForm" id="adminForm">
	<table cellpadding="2" cellspacing="4" border="0" width="100%" class="adminForm configuration_customize" id="adminForm">
	    <tr>
		    <th class="config_customize_legend">{$this->show(_DOWN_FIELD)}</th>
		    <th class="config_customize_legend">{$this->show(_DOWN_SEQUENCE)}</th>
		    <th>A</th>
		    <th>B</th>
		    <th>C</th>
		    <th>D</th>
		    <th>E</th>
	    </tr>
		$lines
	    <tr>
		    <td></td><td></td>
		    <td colspan="5" class="remositoryexplain">{$this->show(_DOWN_CONFIG_EXPLAIN_1)}</td>
	    </tr>
	    <tr>
		    <td></td><td></td>
		    <td colspan="5" class="remositoryexplain">{$this->show(_DOWN_CONFIG_EXPLAIN_2)}</td>
	    </tr>
	    <tr>
		    <td></td><td></td>
		    <td colspan="5" class="remositoryexplain">{$this->show(_DOWN_CONFIG_EXPLAIN_3)}</td>
	    </tr>
	    <tr>
		    <td></td><td></td>
		    <td colspan="5" class="remositoryexplain">{$this->show(_DOWN_CONFIG_EXPLAIN_4)}</td>
	    </tr>
	    <tr>
		    <td></td><td></td>
		    <td colspan="5" class="remositoryexplain">{$this->show(_DOWN_CONFIG_EXPLAIN_5)}</td>
	    </tr>
	</table>
	<div>
		<input type="hidden" name="option" value="com_remository" />
		<input type="hidden" name="repnum" value="$this->repnum" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="act" value="$this->act" />
		<input type="hidden" name="configpage" value="customize" />
	</div>
	</form>
</div></div>
CONFIG_CUSTOMIZE;

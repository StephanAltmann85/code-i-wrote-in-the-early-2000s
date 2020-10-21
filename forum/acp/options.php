<?php
// ************************************************************************************//
// * WoltLab Burning Board 2
// ************************************************************************************//
// * Copyright (c) 2001-2004 WoltLab GmbH
// * Web           http://www.woltlab.de/
// * License       http://www.woltlab.de/products/burning_board/license_en.php
// *               http://www.woltlab.de/products/burning_board/license.php
// ************************************************************************************//
// * WoltLab Burning Board 2 is NOT free software.
// * You may not redistribute this package or any of it's files.
// ************************************************************************************//
// * $Date: 2004-10-20 13:24:57 +0200 (Wed, 20 Oct 2004) $
// * $Author: Burntime $
// * $Rev: 1453 $
// ************************************************************************************//


require('./global.php');
$lang->load('ACP_OPTIONS');

// check if the user has the permission to edit the options
checkAdminPermissions('a_can_options_edit', 1);

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = '';




/** overview of optiongroups */
if (!$action) {
	$result = $db->query("SELECT og.*, COUNT(o.optionid) AS options FROM bb".$n."_optiongroups og LEFT JOIN bb".$n."_options o ON o.optiongroupid=og.optiongroupid AND o.acpmode<='".$wbbuserdata['acpmode']."' WHERE og.acpmode<='".$wbbuserdata['acpmode']."' GROUP BY og.optiongroupid HAVING COUNT(o.optionid)>0 ORDER BY og.showorder ASC");
	$groupbit = '';
	$count = 0;
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count, "firstrow", "secondrow");
		$row['title'] = $lang->get("LANG_ACP_OPTIONS_GROUP_".wbb_strtoupper($row['title']));
		eval("\$groupbit .= \"".$tpl->get("options_groupbit", 1)."\";");
		$count++;
	}
	eval("\$tpl->output(\"".$tpl->get("options_group", 1)."\",1);"); 	
}





/** edit optiongroup */
if ($action == "edit") {
	if (isset($_REQUEST['optiongroupid'])) $optiongroupid = intval($_REQUEST['optiongroupid']);
	else $optiongroupid = 0;
	
	if (isset($_POST['send'])) {
		if (is_array($_POST['option'])) {
			reset($_POST['option']);
			while (list($optionid, $value) = each($_POST['option'])) $db->query("UPDATE bb".$n."_options SET value='".addslashes($value)."' WHERE optionid='$optionid'");
		}
		require("./lib/class_options.php");
		$option = new options("lib");
		$option->write();
		header("Location: options.php?sid=$session[hash]");
		exit();	
	}
	
	$optiongroup = $db->query_first("SELECT title FROM bb".$n."_optiongroups WHERE optiongroupid='$optiongroupid'");
	$optiongroup['title'] = $lang->get("LANG_ACP_OPTIONS_GROUP_".wbb_strtoupper($optiongroup['title']));
	
	$result = $db->query("SELECT * FROM bb".$n."_options WHERE optiongroupid='$optiongroupid' AND acpmode<='".$wbbuserdata['acpmode']."' ORDER BY showorder ASC");
	$optionbit = '';
	$count = 0;
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count, "firstrow", "secondrow");
		if ($row['optioncode'] == "text") $optioncode = "<input type=\"text\" name=\"option[$row[optionid]]\" value=\"".htmlconverter($row['value'])."\" size=\"35\" />";
		elseif ($row['optioncode'] == "truefalse") $optioncode = "<input type=\"radio\" name=\"option[".$row['optionid']."]\" id=\"radio_".$row['optionid']."_1\" value=\"1\"".(($row['value'] == 1) ? ("checked=\"checked\"") : (""))." /><label for=\"radio_".$row['optionid']."_1\"> ".$lang->items['LANG_ACP_GLOBAL_YES']."</label> <input type=\"radio\" name=\"option[".$row['optionid']."]\" id=\"radio_".$row['optionid']."_2\" value=\"0\"".(($row['value'] == 0) ? ("checked=\"checked\"") : (""))." /><label for=\"radio_".$row['optionid']."_2\"> ".$lang->items['LANG_ACP_GLOBAL_NO']."</label>";
		elseif ($row['optioncode'] == "textarea") $optioncode = "<textarea name=\"option[$row[optionid]]\" rows=\"8\" cols=\"50\">".htmlconverter($row['value'])."</textarea>";
		else eval("\$optioncode = \"$row[optioncode]\";");
		
		$varname = wbb_strtoupper($row['varname']);
		
		$row['title'] = $lang->get("LANG_ACP_OPTIONS_OPTION_".$varname);
		$row['description'] = $lang->get("LANG_ACP_OPTIONS_OPTION_".$varname."_DESC");
		
		eval("\$optionbit .= \"".$tpl->get("options_optionbit", 1)."\";");
		$count++;
	}
	eval("\$tpl->output(\"".$tpl->get("options_option", 1)."\",1);"); 	
}
?>
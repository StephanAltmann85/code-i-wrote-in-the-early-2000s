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

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = 'view';

$lang->load("ACP_PROFILEFIELD");

if ($action == 'view') {
	if (!checkAdminPermissions("a_can_profilefield_edit") && !checkAdminPermissions("a_can_profilefield_del")) access_error(1);
	$count = 0;
	$profilefield_viewbit = '';
	$result = $db->query("SELECT profilefieldid, title, fieldorder FROM bb".$n."_profilefields ORDER BY fieldorder");
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count++, "firstrow", "secondrow");
		
		$row['title'] = getlangvar($row['title'], $lang);
		
		eval("\$profilefield_viewbit .= \"".$tpl->get("profilefield_viewbit", 1)."\";");
	}
	eval("\$tpl->output(\"".$tpl->get("profilefield_view", 1)."\",1);");
}


if ($action == "add") {
	checkAdminPermissions("a_can_profilefield_add", 1);
	if (isset($_POST['send'])) {
		$db->query("INSERT INTO bb".$n."_profilefields (profilefieldid,title,description,required,showinthread,hidden,fieldtype,fieldoptions,maxlength,fieldsize,choicecount,fieldorder) VALUES (NULL,'".addslashes($_POST['title'])."', '".addslashes($_POST['description'])."','".intval($_POST['required'])."','".intval($_POST['showinthread'])."','".intval($_POST['hidden'])."','".addslashes($_POST['fieldtype'])."','".addslashes($_POST['fieldoptions'])."','".intval($_POST['maxlength'])."','".intval($_POST['fieldsize'])."','".intval($_POST['choicecount'])."','".intval($_POST['fieldorder'])."')");
		$id = $db->insert_id();
		$fieldtype = "varchar(250)";
		switch ($_POST['fieldtype']) {
			case "text": $fieldtype = "VARCHAR(250)"; break;
			case "select": 
				$temp = str_replace("\n", "','", addslashes(preg_replace("(\n|\r\n|\r)", "\n", trim($_POST['fieldoptions']))));
				if ($temp != '') $temp = "','" . $temp;
				$fieldtype = "ENUM('".$temp."')";
			break;
			case "multiselect": $fieldtype = "TEXT"; break;
			case "checkbox": $fieldtype = "ENUM('','".addslashes(trim($_POST['fieldoptions']))."')"; break;
			case "date": $fieldtype = "DATE"; break;
		}
		$db->query("ALTER TABLE bb".$n."_userfields ADD field$id $fieldtype NOT NULL");
		header("Location: profilefield.php?action=view&sid=$session[hash]");
		exit();
	}
	eval("\$tpl->output(\"".$tpl->get("profilefield_add", 1)."\",1);");
}


if ($action == "edit") {
	checkAdminPermissions("a_can_profilefield_edit", 1);
	if (isset($_POST['send'])) {
		$db->query("UPDATE bb".$n."_profilefields SET title = '".addslashes($_POST['title'])."', description = '".addslashes($_POST['description'])."', required = '".$_POST['required']."', showinthread = '".$_POST['showinthread']."', maxlength = '".intval($_POST['maxlength'])."', fieldsize = '".intval($_POST['fieldsize'])."', fieldorder = '".intval($_POST['fieldorder'])."', hidden = '".intval($_POST['hidden'])."',fieldtype='".addslashes($_POST['fieldtype'])."',fieldoptions='".addslashes($_POST['fieldoptions'])."', choicecount='".intval($_POST['choicecount'])."' WHERE profilefieldid = '".intval($_POST['profilefieldid'])."'");
		switch ($_POST['fieldtype']) {
			case "text": $fieldtype = "VARCHAR(250)"; break;
			case "select": $fieldtype = "ENUM('".str_replace("\n", "','", addslashes(preg_replace("(\n|\r\n|\r)", "\n", trim($_POST['fieldoptions']))))."')"; break;
			case "multiselect": $fieldtype = "TEXT"; break;
			case "checkbox": $fieldtype = "ENUM('','".addslashes(trim($_POST['fieldoptions']))."')"; break;
			case "date": $fieldtype = "DATE"; break;
		}
		$db->query("ALTER TABLE bb".$n."_userfields CHANGE field".$_POST['profilefieldid']." field".$_POST['profilefieldid']." $fieldtype NOT NULL");
		header("Location: profilefield.php?action=view&sid=$session[hash]");
		exit();
	}
	
	$profile = $db->query_first("SELECT * FROM bb".$n."_profilefields WHERE profilefieldid = '".intval($_REQUEST['profilefieldid'])."'");
	$profilesel = array("", "", "", "", "", "", "", "", "", "");
	if ($profile['required'] == "1")$profilesel[0] = " selected=\"selected\"";
	else $profilesel[1] = " selected=\"selected\"";
	if ($profile['showinthread'] == "1") $profilesel[2] = " selected=\"selected\"";
	else $profilesel[3] = " selected=\"selected\"";
	if ($profile['hidden'] == "1") $profilesel[4] = " selected=\"selected\"";
	else $profilesel[5] = " selected=\"selected\"";
	switch ($profile['fieldtype']) {
		case "text": $profilesel[6] = " selected=\"selected\""; break;
		case "select": $profilesel[7] = " selected=\"selected\""; break;
		case "multiselect": $profilesel[10] = " selected=\"selected\""; break;
		case "checkbox": $profilesel[8] = " selected=\"selected\""; break;
		case "date": $profilesel[9] = " selected=\"selected\""; break;
	}
	$profile['title'] = htmlconverter($profile['title']);
	$profile['description'] = htmlconverter($profile['description']);
	$profile['fieldoptions'] = htmlconverter($profile['fieldoptions']);
	eval("\$tpl->output(\"".$tpl->get("profilefield_edit", 1)."\",1);");
}

if ($action == "del") {
	checkAdminPermissions("a_can_profilefield_del", 1);
	if (isset($_POST['send'])) {
		$profilefieldid = intval($_POST['profilefieldid']);
  
		$options = explode('|', $memberslistoptions_show);
		while (list($key, $val) = each($options)) {
		 	if ($val == "profilefield" . $profilefieldid) {
		  		unset($options[$key]);
		  		$db->query("UPDATE bb".$n."_options SET value='".addslashes(implode('|', $options))."' WHERE varname='memberslistoptions_show'");
		  		require("./lib/class_options.php");
		 		$option = new options("lib");
		 		$option->write();
		  		break;
		 	}
		}
		  
		$db->query("DELETE FROM bb".$n."_profilefields WHERE profilefieldid = '".$profilefieldid."'");
		$db->query("ALTER TABLE bb".$n."_userfields DROP field".$profilefieldid."");
		header("Location: profilefield.php?action=view&sid=$session[hash]");
		exit();
	}
	$profile = $db->query_first("SELECT title FROM bb".$n."_profilefields WHERE profilefieldid = '".intval($_REQUEST['profilefieldid'])."'");
	$profile['title'] = getlangvar($profile['title'], $lang);
	
	$lang->items['LANG_ACP_PROFILEFIELD_DELETE'] = $lang->get("LANG_ACP_PROFILEFIELD_DELETE", array('$title' => $profile['title']));
	eval("\$tpl->output(\"".$tpl->get("profilefield_del_confirm", 1)."\",1);");
}
?>
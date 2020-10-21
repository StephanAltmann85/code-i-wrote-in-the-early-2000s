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
$lang->load('ACP_DESIGNPACK');

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = 'view';


/** add designpack **/
if ($action == 'add') {
	checkAdminPermissions('a_can_designpack_add', 1);
	if (isset($_POST['send'])) {
		reset($_POST);
		
		$db->query("INSERT INTO bb".$n."_designpacks (designpackname) VALUES ('".addslashes($_POST['designpackname'])."')");
		$designpackid = $db->insert_id();
		
		while (list($key, $val) = each($_POST)) {
			if ($key == "send" || $key == "action" || $key == "sid" || $key == "designpackname" || $key == "designpackid") continue;
			
			$db->unbuffered_query("INSERT INTO bb".$n."_designelements (designpackid,element,value) VALUES ('".$designpackid."','".addslashes(trim($key))."','".addslashes(trim($val))."')", 1);	
		}
		
		header("Location: designpack.php?action=view&sid=$session[hash]");
		exit();	
	}
	
	$pagetitle = $lang->get("LANG_ACP_GLOBAL_MENU_DESIGNPACK_ADD");
	
	eval("\$tpl->output(\"".$tpl->get("designpack_form", 1)."\",1);");
}


/** view designpacks **/
if ($action == 'view') {
	if (!checkAdminPermissions('a_can_designpack_edit') && !checkAdminPermissions('a_can_designpack_copy') && !checkAdminPermissions('a_can_designpack_del')) access_error(1); 
	$count = 0;
	$designpack_viewbit = '';
	$result = $db->query("SELECT * FROM bb".$n."_designpacks ORDER BY designpackname");	
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count++, "firstrow", "secondrow");
		$row['designpackname'] = htmlconverter($row['designpackname']);
		eval("\$designpack_viewbit .= \"".$tpl->get("designpack_viewbit", 1)."\";");	
	}
	
	eval("\$tpl->output(\"".$tpl->get("designpack_view", 1)."\",1);");
}


/** edit designpack **/
if ($action == 'edit') {
	checkAdminPermissions('a_can_designpack_edit', 1);
	if (isset($_REQUEST['designpackid'])) $designpackid = intval($_REQUEST['designpackid']);
	else $designpackid = 0;
	
	if (isset($_POST['send'])) {
		reset($_POST);
		while (list($key, $val) = each($_POST)) {
			if ($key == "send" || $key == "action" || $key == "sid" || $key == "designpackname" || $key == "designpackid") continue;
			
			$db->unbuffered_query("REPLACE INTO bb".$n."_designelements (designpackid,element,value) VALUES ('".$designpackid."','".addslashes(trim($key))."','".addslashes(trim($val))."')", 1);	
		}
		
		$db->unbuffered_query("UPDATE bb".$n."_designpacks SET designpackname='".addslashes($_POST['designpackname'])."' WHERE designpackid='".$designpackid."'", 1);
		
		header("Location: designpack.php?action=view&sid=$session[hash]");
		exit();	
	}
	
	$design = array();
	$result = $db->unbuffered_query("SELECT element, value FROM bb".$n."_designelements WHERE designpackid = '".$designpackid."'");
	while ($row = $db->fetch_array($result)) $design[$row['element']] = htmlconverter($row['value']);
	
	list($designpackname) = $db->query_first("SELECT designpackname FROM bb".$n."_designpacks WHERE designpackid = '".$designpackid."'");
	$designpackname = htmlconverter($designpackname);
	
	$pagetitle = $lang->get("LANG_ACP_GLOBAL_MENU_DESIGNPACK_EDIT");
	
	eval("\$tpl->output(\"".$tpl->get("designpack_form", 1)."\",1);");
}


/** copy designpack **/
if ($action == 'copy') {
	checkAdminPermissions('a_can_designpack_copy', 1);
	if (isset($_POST['send'])) {
		reset($_POST);
		
		$db->query("INSERT INTO bb".$n."_designpacks (designpackname) VALUES ('".addslashes($_POST['designpackname'])."')");
		$designpackid = $db->insert_id();
		
		while (list($key, $val) = each($_POST)) {
			if ($key == "send" || $key == "action" || $key == "sid" || $key == "designpackname" || $key == "designpackid") continue;
			
			$db->unbuffered_query("INSERT INTO bb".$n."_designelements (designpackid,element,value) VALUES ('".$designpackid."','".addslashes(trim($key))."','".addslashes(trim($val))."')", 1);	
		}
		
		header("Location: designpack.php?action=view&sid=$session[hash]");
		exit();	
	}
	
	if (isset($_REQUEST['designpackid'])) $designpackid = intval($_REQUEST['designpackid']);
	else $designpackid = 0;
	
	$design = array();
	$result = $db->unbuffered_query("SELECT element, value FROM bb".$n."_designelements WHERE designpackid = '".$designpackid."'");
	while ($row = $db->fetch_array($result)) $design[$row['element']] = htmlconverter($row['value']);
	
	list($designpackname) = $db->query_first("SELECT designpackname FROM bb".$n."_designpacks WHERE designpackid = '".$designpackid."'");
	$designpackname = htmlconverter($designpackname);
	
	$pagetitle = $lang->get("LANG_ACP_DESIGNPACK_COPY");
	
	eval("\$tpl->output(\"".$tpl->get("designpack_form", 1)."\",1);");
}


/** delete designpack **/
if ($action == 'del') {
	checkAdminPermissions('a_can_designpack_del', 1);
	if (isset($_REQUEST['designpackid'])) $designpackid = intval($_REQUEST['designpackid']);
	else $designpackid = 0;
	
	if (isset($_POST['send'])) {
		$db->unbuffered_query("DELETE FROM bb".$n."_designpacks WHERE designpackid='$designpackid'", 1);	
		$db->unbuffered_query("DELETE FROM bb".$n."_designelements WHERE designpackid='$designpackid'", 1);	
		$db->unbuffered_query("UPDATE bb".$n."_styles SET designpackid=0 WHERE designpackid='$designpackid'", 1);	
		header("Location: designpack.php?action=view&sid=$session[hash]");
		exit;
	}	
	
	list($count) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_designpacks");
	if ($count == 1) acp_error($lang->get("LANG_ACP_DESIGNPACK_DELETE_ONLYONE"));
	$dp = $db->query_first("SELECT designpackname FROM bb".$n."_designpacks WHERE designpackid='$designpackid'");
	$lang->items['LANG_ACP_DESIGNPACK_DELETE_SURE'] = $lang->get("LANG_ACP_DESIGNPACK_DELETE_SURE", array('$designpackname' => $dp['designpackname']));
	eval("\$tpl->output(\"".$tpl->get("designpack_del", 1)."\",1);");
}


/** colorchooser **/
if ($action == 'colorchooser') {
	if (!checkAdminPermissions("a_can_designpack_edit") && !checkAdminPermissions("a_can_designpack_copy") && !checkAdminPermissions("a_can_designpack_add")) access_error(1); 
	
	eval("\$tpl->output(\"".$tpl->get("designpack_colorchooser", 1)."\",1);");
}
?>
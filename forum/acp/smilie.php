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
$lang->load('ACP_SMILIE');

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = 'view';


/** view smilies **/
if ($action == 'view') {
	if (!checkAdminPermissions("a_can_smilie_edit") && !checkAdminPermissions("a_can_smilie_del")) access_error(1);
	$count = '';
	$smilie_viewbit = '';
	
	$design = $db->query_first("SELECT value FROM bb".$n."_designelements WHERE element = 'imagefolder'");
	
	$result = $db->unbuffered_query("SELECT smilieid, smiliepath, smilietitle, smiliecode, smilieorder FROM bb".$n."_smilies ORDER BY smilieorder ASC");
	while ($row = $db->fetch_array($result)) {
		$row['smilietitle'] = getlangvar($row['smilietitle'], $lang);
		
		if (stristr($row['smiliepath'], "http://")) $smiliepathimage = makeimgtag($row['smiliepath'], $row['smilietitle']);
		else {
			$row['smiliepath'] = ((!stristr($design['value'], "http://")) ? ("../") : ("")).str_replace("{imagefolder}", $lang->get("LANG_GLOBAL_IMAGEFOLDER_PREFIX").$design['value'], $row['smiliepath']);
			if (is_file($row['smiliepath'])) $smiliepathimage = makeimgtag($row['smiliepath'], $row['smilietitle']);
			else $smiliepathimage = "n/a";
		}
		
		$row['smiliecode'] = htmlconverter($row['smiliecode']);
		$rowclass = getone($count++, "firstrow", "secondrow");
		
		eval("\$smilie_viewbit .= \"".$tpl->get("smilie_viewbit", 1)."\";");
	}
	
	eval("\$tpl->output(\"".$tpl->get("smilie_view", 1)."\",1);"); 
}


/** add smilie **/
if ($action == "add") {
	checkAdminPermissions("a_can_smilie_add", 1);
	if (isset($_POST['send'])) {
		$db->query("INSERT INTO bb".$n."_smilies (smiliepath,smilietitle,smiliecode,smilieorder) VALUES ('".addslashes($_POST['smiliepath'])."', '".addslashes($_POST['smilietitle'])."', '".addslashes($_POST['smiliecode'])."', '".intval($_POST['smilieorder'])."')");
		header("Location: smilie.php?action=view&sid=$session[hash]");
		exit();
	}
	
	eval("\$tpl->output(\"".$tpl->get("smilie_add", 1)."\",1);"); 
}


/** edit smilie **/
if ($action == "edit") {
	checkAdminPermissions("a_can_smilie_edit", 1);
	
	if (isset($_REQUEST['smilieid'])) $smilieid = intval($_REQUEST['smilieid']);
	else $smilieid = 0;
	
	if (isset($_POST['send'])) {
		$db->query("UPDATE bb".$n."_smilies SET smiliepath = '".addslashes($_POST['smiliepath'])."', smilietitle = '".addslashes($_POST['smilietitle'])."', smiliecode = '".addslashes($_POST['smiliecode'])."', smilieorder = '".intval($_POST['smilieorder'])."' WHERE smilieid = '".$smilieid."'");
		header("Location: smilie.php?action=view&sid=$session[hash]");
		exit();
	}
	$smilie = $db->query_first("SELECT * FROM bb".$n."_smilies WHERE smilieid = '".$smilieid."'");
	
	$smilie['smilietitle'] = htmlconverter($smilie['smilietitle']);
	$smilie['smiliecode'] = htmlconverter($smilie['smiliecode']);
	
	eval("\$tpl->output(\"".$tpl->get("smilie_edit", 1)."\",1);");
}


/** delete smilie **/
if ($action == "del") {
	checkAdminPermissions("a_can_smilie_del", 1);
	
	if (isset($_REQUEST['smilieid'])) $smilieid = intval($_REQUEST['smilieid']);
	else $smilieid = 0;
	
	if (isset($_POST['send'])) {
		$db->query("DELETE FROM bb".$n."_smilies WHERE smilieid = '".$smilieid."'");
		header("Location: smilie.php?action=view&sid=$session[hash]");
		exit();
	}
	$smilie = $db->query_first("SELECT smilieid, smilietitle FROM bb".$n."_smilies WHERE smilieid = '".$smilieid."'");
	$smilie['smilietitle'] = getlangvar($smilie['smilietitle'], $lang);
	
	$lang->items['LANG_ACP_SMILIE_DELETE'] = $lang->get("LANG_ACP_SMILIE_DELETE", array('$smilietitle' => $smilie['smilietitle']));
	eval("\$tpl->output(\"".$tpl->get("smilie_del", 1)."\",1);");
}
?>
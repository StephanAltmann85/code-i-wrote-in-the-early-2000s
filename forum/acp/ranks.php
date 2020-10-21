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
$lang->load('ACP_RANKS');

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = 'view';


/** view ranks **/
if ($action == 'view') {
	if (!checkAdminPermissions("a_can_ranks_edit") && !checkAdminPermissions("a_can_ranks_del")) access_error(1);
	
	$count = 0;
	$ranks_viewbit = '';
	
	$result = $db->query("SELECT rankid, ranktitle FROM bb".$n."_ranks ORDER BY rankid ASC");
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count++, "firstrow", "secondrow");
		$row['ranktitle'] = getlangvar($row['ranktitle'], $lang);
		
		eval("\$ranks_viewbit .= \"".$tpl->get("ranks_viewbit", 1)."\";");
	}
	
	eval("\$tpl->output(\"".$tpl->get("ranks_view", 1)."\",1);"); 
}


/** add rank **/
if ($action == "add") {
	checkAdminPermissions("a_can_ranks_add", 1);
	if (isset($_POST['send'])) {
		$images = preg_replace("/\s*\n\s*/", "\n", trim($_POST['images']));
		
		$db->query("INSERT INTO bb".$n."_ranks (groupid,gender,needposts,ranktitle,rankimages) VALUES ('".intval($_POST['group'])."','".intval($_POST['gender'])."','".intval($_POST['quantity'])."','".addslashes($_POST['title'])."','".addslashes(implode(";", explode("\n", $images)))."')");
		header("Location: ranks.php?action=view&sid=$session[hash]");
		exit();
	}
	
	$ranks_groupsbit = '';
	$result = $db->query("SELECT groupid, title FROM bb".$n."_groups WHERE grouptype>=2 ORDER BY title ASC");
	while ($row = $db->fetch_array($result)) $ranks_groupsbit .= makeoption($row['groupid'], getlangvar($row['title'], $lang), "", 0);
	
	eval("\$tpl->output(\"".$tpl->get("ranks_add", 1)."\",1);"); 
}


/** edit rank **/
if ($action == "edit") {
	checkAdminPermissions("a_can_ranks_edit", 1);
	
	if (isset($_REQUEST['rankid'])) $rankid = intval($_REQUEST['rankid']);
	else $rankid = 0;
	
	if (isset($_POST['send'])) {
		$images = preg_replace("/\s*\n\s*/", "\n", trim($_POST['images']));
		$db->query("UPDATE bb".$n."_ranks SET groupid = '".intval($_POST['group'])."', gender = '".intval($_POST['gender'])."', needposts = '".intval($_POST['quantity'])."', ranktitle = '".addslashes($_POST['title'])."', rankimages = '".addslashes(implode(";", explode("\n", $images)))."' WHERE rankid = '".$rankid."'");
		header("Location: ranks.php?action=view&sid=$session[hash]");
		exit();
	}
	
	$ranks = $db->query_first("SELECT rankid, groupid, gender, needposts, ranktitle, rankimages FROM bb".$n."_ranks WHERE rankid = '".$rankid."'");
	
	if ($ranks['gender'] == "2") $rankgendersel[2] = " selected=\"selected\"";
	elseif ($ranks['gender'] == "1") $rankgendersel[1] = " selected=\"selected\"";
	else $rankgendersel[0] = " selected=\"selected\"";
	
	$ranks_groupsbit = '';
	$result = $db->query("SELECT groupid, title FROM bb".$n."_groups WHERE grouptype>=2 ORDER BY title ASC");
	while ($row = $db->fetch_array($result)) $ranks_groupsbit .= makeoption($row['groupid'], getlangvar($row['title'], $lang), $ranks['groupid']);
	 
	$ranks['rankimages'] = htmlconverter(implode("\n", explode(";", $ranks['rankimages']))); 
	$ranks['ranktitle'] = htmlconverter($ranks['ranktitle']);
	
	eval("\$tpl->output(\"".$tpl->get("ranks_edit", 1)."\",1);"); 
}


/** delete rank **/
if ($action == "del") {
	checkAdminPermissions("a_can_ranks_del", 1);
	
	if (isset($_REQUEST['rankid'])) $rankid = intval($_REQUEST['rankid']);
	else $rankid = 0;
	
	if (isset($_POST['send'])) {
		$db->query("DELETE FROM bb".$n."_ranks WHERE rankid = '".$rankid."'");
		$db->query("UPDATE bb".$n."_users SET rankid = '0' WHERE rankid = '".$rankid."'");
		header("Location: ranks.php?action=view&sid=$session[hash]");
		exit();
	}
	
	$rank = $db->query_first("SELECT ranktitle FROM bb".$n."_ranks WHERE rankid = '".$rankid."'");
	$rank['ranktitle'] = getlangvar($rank['ranktitle'], $lang);
	
	$lang->items['LANG_ACP_RANKS_DELETE'] = $lang->get("LANG_ACP_RANKS_DELETE", array('$ranktitle' => $rank['ranktitle']));
	eval("\$tpl->output(\"".$tpl->get("ranks_del", 1)."\",1);");
}
?>
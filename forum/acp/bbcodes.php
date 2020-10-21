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
$lang->load('ACP_BBCODES');

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = 'view';

/** view bbcodes **/
if ($action == 'view') {
	if (!checkAdminPermissions('a_can_bbcodes_edit') && !checkAdminPermissions('a_can_bbcodes_del')) access_error(1);
	
	$bbcodes_viewbit = '';
	$count = '';
	$result = $db->unbuffered_query("SELECT bbcodeid, bbcodetag FROM bb".$n."_bbcodes");
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count++, 'firstrow', 'secondrow');
		$row['bbcodetag'] = htmlconverter($row['bbcodetag']);
		
		eval("\$bbcodes_viewbit .= \"".$tpl->get("bbcodes_viewbit", 1)."\";");
	}
	
	eval("\$tpl->output(\"".$tpl->get("bbcodes_view", 1)."\",1);"); 
}

/** edit bbcodes **/
if ($action == 'edit') {
	checkAdminPermissions('a_can_bbcodes_edit', 1);
	$bbcodeid = intval($_REQUEST['bbcodeid']);
	
	if (isset($_POST['send'])) {
		$bbcodereplacement = $_POST['bbcodereplacement'];
		$params = intval($_POST['params']);
		
		if ($params > 1) {
			$bbcodereplacement = str_replace("{param1}", "\\2", $bbcodereplacement);
			$bbcodereplacement = str_replace("{param2}", "\\3", $bbcodereplacement);
			$bbcodereplacement = str_replace("{param3}", "\\4", $bbcodereplacement);
		}
		else $bbcodereplacement = str_replace("{param1}", "\\1", $bbcodereplacement);
		
		$db->unbuffered_query("UPDATE bb".$n."_bbcodes SET bbcodetag='".addslashes(trim($_POST['bbcodetag']))."', bbcodereplacement='".addslashes($bbcodereplacement)."', bbcodeexample='".addslashes(trim($_POST['bbcodeexample']))."', bbcodeexplanation='".addslashes(trim($_POST['bbcodeexplanation']))."', params='".$params."', multiuse='".intval($_POST['multiuse'])."', pattern1='".addslashes($_POST['pattern1'])."', pattern2='".addslashes($_POST['pattern2'])."', pattern3='".addslashes($_POST['pattern3'])."', eval_replacement='".intval($_POST['eval_replacement'])."' WHERE bbcodeid='$bbcodeid'", 1);	
		header("Location: bbcodes.php?action=view&sid=$session[hash]");
		exit();
	}
	
	$bbcode = $db->query_first("SELECT * FROM bb".$n."_bbcodes WHERE bbcodeid='$bbcodeid'");	
	
	$bbcode['bbcodereplacement'] = str_replace("\\1", "{param1}", $bbcode['bbcodereplacement']);
	$bbcode['bbcodereplacement'] = str_replace("\\2", "{param1}", $bbcode['bbcodereplacement']);
	$bbcode['bbcodereplacement'] = str_replace("\\3", "{param2}", $bbcode['bbcodereplacement']);
	$bbcode['bbcodereplacement'] = str_replace("\\4", "{param3}", $bbcode['bbcodereplacement']);
	
	$bbcode['bbcodereplacement'] = htmlconverter($bbcode['bbcodereplacement']);
	$bbcode['bbcodetag'] = htmlconverter($bbcode['bbcodetag']);
	$bbcode['bbcodeexample'] = htmlconverter($bbcode['bbcodeexample']);
	$bbcode['bbcodeexplanation'] = htmlconverter($bbcode['bbcodeexplanation']);
	
	$bbcode['pattern1'] = htmlconverter($bbcode['pattern1']);
	$bbcode['pattern2'] = htmlconverter($bbcode['pattern2']);
	$bbcode['pattern3'] = htmlconverter($bbcode['pattern3']);
	
	$sel_params[$bbcode['params']] = ' selected="selected"';
	$sel_eval_replacement[$bbcode['eval_replacement']] = ' selected="selected"';
	
	eval("\$tpl->output(\"".$tpl->get("bbcodes_edit", 1)."\",1);"); 	
}


/** add bbcodes **/
if ($action == 'add') {
	checkAdminPermissions('a_can_bbcodes_add', 1);
	
	if (isset($_POST['send'])) {
		$bbcodereplacement = $_POST['bbcodereplacement'];
		$params = intval($_POST['params']);
		
		if ($params > 1) {
			$bbcodereplacement = str_replace("{param1}", "\\2", $bbcodereplacement);
			$bbcodereplacement = str_replace("{param2}", "\\3", $bbcodereplacement);
			$bbcodereplacement = str_replace("{param3}", "\\4", $bbcodereplacement);
		}
		else $bbcodereplacement = str_replace("{param1}", "\\1", $bbcodereplacement);
		
		$db->unbuffered_query("INSERT INTO bb".$n."_bbcodes (bbcodetag,bbcodereplacement,bbcodeexample,bbcodeexplanation,params,multiuse,pattern1,pattern2,pattern3,eval_replacement) VALUES ('".addslashes(trim($_POST['bbcodetag']))."','".addslashes($bbcodereplacement)."','".addslashes(trim($_POST['bbcodeexample']))."','".addslashes(trim($_POST['bbcodeexplanation']))."','".$params."','".intval($_POST['multiuse'])."','".addslashes($_POST['pattern1'])."','".addslashes($_POST['pattern2'])."','".addslashes($_POST['pattern3'])."','".intval($_POST['eval_replacement'])."')", 1);	
		header("Location: bbcodes.php?action=view&sid=$session[hash]");
		exit();
	}
	
	eval("\$tpl->output(\"".$tpl->get("bbcodes_add", 1)."\",1);"); 
}


/** delete bbcodes **/
if ($action == 'del') {
	checkAdminPermissions('a_can_bbcodes_del', 1);
	$bbcodeid = intval($_REQUEST['bbcodeid']);
	
	if (isset($_POST['send'])) {
		$db->unbuffered_query("DELETE FROM bb".$n."_bbcodes WHERE bbcodeid='$bbcodeid'", 1);	
		header("Location: bbcodes.php?action=view&sid=$session[hash]");
		exit();
	}
	
	$bbcode = $db->query_first("SELECT bbcodetag FROM bb".$n."_bbcodes WHERE bbcodeid='$bbcodeid'");
	$bbcode['bbcodetag'] = htmlconverter($bbcode['bbcodetag']);
	
	$lang->items['LANG_ACP_BBCODES_DELETE'] = $lang->get("LANG_ACP_BBCODES_DELETE", array('$bbcodetag' => $bbcode['bbcodetag']));
	eval("\$tpl->output(\"".$tpl->get("bbcodes_del", 1)."\",1);"); 
}
?>
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

$lang->load('ACP_ICON');


/** edit icons **/
if ($action == 'view') {
	if (!checkAdminPermissions('a_can_icon_edit') && !checkAdminPermissions('a_can_icon_del')) access_error(1);
	$count = '';
	$icon_viewbit = '';
	
	$result2 = $db->query_first("SELECT value FROM bb".$n."_designelements WHERE element = 'imagefolder'");
	$result = $db->query("SELECT iconid, iconpath, icontitle, iconorder FROM bb".$n."_icons ORDER BY iconorder ASC");
	while ($row = $db->fetch_array($result)) {
		if (stristr($row['iconpath'], "http://")) $iconpathimage = makeimgtag($row['iconpath'], $row['icontitle']);
		else {
			$row['iconpath'] = "../".str_replace("{imagefolder}", $lang->get("LANG_GLOBAL_IMAGEFOLDER_PREFIX").$result2['value'], $row['iconpath']);
			if (is_file($row['iconpath'])) $iconpathimage = makeimgtag($row['iconpath'], $row['icontitle']);
			else $iconpathimage = "n/a";
		}
		$row['icontitle'] = getlangvar($row['icontitle'], $lang);
		$rowclass = getone($count++, "firstrow", "secondrow");
		eval("\$icon_viewbit .= \"".$tpl->get("icon_viewbit", 1)."\";");
	}
	eval("\$tpl->output(\"".$tpl->get("icon_view", 1)."\",1);");
}








/** add icons **/
if ($action == 'add') {
	checkAdminPermissions('a_can_icon_add', 1);
	if (isset($_POST['send'])) {
		$db->query("INSERT INTO bb".$n."_icons (iconid,iconpath,icontitle,iconorder) VALUES (NULL, '".addslashes($_POST['iconpath'])."', '".addslashes($_POST['icontitle'])."', '".intval($_POST['iconorder'])."')");
		header("Location: icon.php?action=view&sid=$session[hash]");
		exit();
	}
	eval("\$tpl->output(\"".$tpl->get("icon_add", 1)."\",1);");
}




/** edit icon **/
if ($action == 'edit') {
	checkAdminPermissions('a_can_icon_edit', 1);
	if ($_POST['send'] == 'send') {
		$db->query("UPDATE bb".$n."_icons SET iconpath = '".addslashes($_POST['iconpath'])."', icontitle = '".addslashes($_POST['icontitle'])."', iconorder = '".intval($_POST['iconorder'])."' WHERE iconid = '".$_POST['iconid']."'");
		header("Location: icon.php?action=view&sid=$session[hash]");
		exit();
	}
	$icon = $db->query_first("SELECT iconid, iconpath, icontitle, iconorder FROM bb".$n."_icons WHERE iconid = '".$_REQUEST['iconid']."'");
	$icon['icontitle'] = htmlconverter($icon['icontitle']);
	$icon['iconpath'] = htmlconverter($icon['iconpath']);
	eval("\$tpl->output(\"".$tpl->get("icon_edit", 1)."\",1);");
}




/** delete icon **/
if ($action == 'del') {
	checkAdminPermissions('a_can_icon_del', 1);
	if (isset($_POST['send'])) {
		$db->query("DELETE FROM bb".$n."_icons WHERE iconid = '".intval($_POST['iconid'])."'");
		$db->query("UPDATE bb".$n."_threads SET iconid = '0' WHERE iconid = '".intval($_POST['iconid'])."'");
		$db->query("UPDATE bb".$n."_posts SET iconid = '0' WHERE iconid = '".intval($_POST['iconid'])."'");
		$db->query("UPDATE bb".$n."_privatemessage SET iconid = '0' WHERE iconid = '".intval($_POST['iconid'])."'");
		header("Location: icon.php?action=view&sid=$session[hash]");
		exit();
	}
	$icon = $db->query_first("SELECT iconid, icontitle FROM bb".$n."_icons WHERE iconid = '".intval($_REQUEST['iconid'])."'");
	$icon['icontitle'] = getlangvar($icon['icontitle'], $lang);
	
	$lang->items['LANG_ACP_ICON_DELETE'] = $lang->get("LANG_ACP_ICON_DELETE", array('$icontitle' => $icon['icontitle']));
	eval("\$tpl->output(\"".$tpl->get("icon_del_confirm", 1)."\",1);");
}
?>
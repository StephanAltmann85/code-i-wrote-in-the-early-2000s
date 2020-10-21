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
$lang->load('ACP_MEMBERSLIST,MEMBERS');

checkAdminPermissions('a_can_memberslist', 1);

if (isset($_POST['send'])) {
	$db->query("UPDATE bb".$n."_options SET value='".addslashes($_POST['hidden_show'])."' WHERE varname='memberslistoptions_show'");
	$db->query("UPDATE bb".$n."_options SET value='".addslashes($_POST['sortorder'])."' WHERE varname='default_memberslist_sortorder'");
	$db->query("UPDATE bb".$n."_options SET value='".addslashes($_POST['sortfield'])."' WHERE varname='default_memberslist_sortfield'");
	
	require("./lib/class_options.php");
	$option = new options("lib");
	$option->write();
	header("Location: memberslist.php?sid=$session[hash]");
	exit();
}

$a_all = explode("|", $memberslistoptions_all);
$a_show = explode("|", $memberslistoptions_show);

$profilefieldcache = array();
$result = $db->query("SELECT profilefieldid, title FROM bb".$n."_profilefields");
while ($row = $db->fetch_array($result)) $profilefieldcache[$row['profilefieldid']] = getlangvar($row['title'], $lang);

$options_show = '';
for ($i = 0; $i < count($a_show); $i++) {
	if ($a_show[$i] == '') continue;
	if (strstr($a_show[$i], "profilefield")) $options_show .= makeoption($a_show[$i], $profilefieldcache[wbb_substr($a_show[$i], 12)], "", 0);
	else $options_show .= makeoption($a_show[$i], $lang->get("LANG_MEMBERS_MBL_".wbb_strtoupper($a_show[$i])), "", 0);
}

$options_all = '';
for ($i = 0; $i < count($a_all); $i++) {
	if ($a_all[$i] == '') continue;
	if (!in_array($a_all[$i], $a_show)) $options_all .= makeoption($a_all[$i], $lang->get("LANG_MEMBERS_MBL_".wbb_strtoupper($a_all[$i])), "", 0);
}

while (list($key, $val) = each($profilefieldcache)) if (!in_array("profilefield".$key, $a_show)) $options_all .= makeoption("profilefield".$key, $val, "", 0);

$sortfield_options = '';
reset($a_show);
while (list($key, $val) = each($a_show)) {
	$fieldname = $lang->get("LANG_MEMBERS_MBL_".wbb_strtoupper($val));
	
	if (strstr($val, "profilefield")) $fieldname = $profilefieldcache[wbb_substr($val, 12)];
	
	$searchname = getSearchFieldname($val);
	if ($searchname != '') $sortfield_options .= makeoption($searchname, $fieldname, $default_memberslist_sortfield);
}

$s_sortorder[$default_memberslist_sortorder] = " selected=\"selected\"";

eval("\$tpl->output(\"".$tpl->get("memberslist", 1)."\",1);"); 
?>
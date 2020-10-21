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


$filename = 'wiw.php';
require('./global.php');
if (!$wbbuserdata['can_view_wiw']) access_error();

require('./acp/lib/class_useronline.php');
require('./acp/lib/class_wiw.php');
$lang->load('WIW');

// Define
if (!isset($_GET['sortby'])) $_GET['sortby'] = '';
if (!isset($_GET['order'])) $_GET['order'] = '';
$sel_sortby['username'] = '';
$sel_sortby['ipaddress'] = '';
$sel_sortby['useragent'] = '';
$sel_sortby['lastactivity'] = '';
$sel_sortby['request_uri'] = '';
$sel_order['ASC'] = '';
$sel_order['DESC'] = '';
$useronline = '';

switch ($_GET['sortby']) {
	case "username": break;
	case "ipaddress": break;
	case "useragent": break;
	case "lastactivity": break;
	case "request_uri": break;
	default: $_GET['sortby'] = "lastactivity"; break;
}

switch ($_GET['order']) {
	case "ASC": break;
	case "DESC": break;
	default: $_GET['order'] = "DESC"; break;
}

$sel_sortby[$_GET['sortby']] = " selected=\"selected\"";
$sel_order[$_GET['order']] = " selected=\"selected\"";

$wiw = &new WIW($wbbuserdata['a_can_view_ghosts'], $wbbuserdata['buddylist']);

$boardids = '';
$threadids = '';
$result = $db->query("SELECT s.*, u.username, u.invisible, u.useronlinegroupid,g.useronlinemarking, 0 AS script FROM bb".$n."_sessions s LEFT JOIN bb".$n."_users u USING (userid) LEFT JOIN bb".$n."_groups g ON g.groupid=u.useronlinegroupid WHERE s.lastactivity >= '".(time() - 60 * $useronlinetimeout)."'".(($wiw_showonlyusers == 1) ? (" AND s.userid<>0") : ("")).(($wbbuserdata['ignorelist']) ? (" AND s.userid NOT IN (".str_replace(" ", ",", $wbbuserdata['ignorelist']).")") : (""))." ORDER BY ".$_GET['sortby']." ".$_GET['order']."");
while ($row = $db->fetch_array($result)) $wiw->insert($row);

$wiw->cache();

$guestcount = 1;
while ($row = $wiw->get()) {
	
	if (!$row['userid']) {
		$username = $lang->get("LANG_WIW_GUEST", array('$guestcount' => $guestcount));
		$guestcount++;
	}
	else $username = $wiw->parse($row['userid'], htmlconverter($row['username']), $row['useronlinemarking'], $row['invisible']);
	
	$time = formatdate($wbbuserdata['timeformat'], $row['lastactivity']);
	
	if ($wbbuserdata['a_can_view_ipaddress'] == 1) {
		$ipadress = htmlconverter($row['ipaddress']);
		$browser = $row['useragent'];
		if (wbb_strlen($browser) > 50) $browser = wbb_substr($browser, 0, 50)."...";
		$browser = htmlconverter($browser);
		$row['useragent'] = htmlconverter($row['useragent']);
	}
	
	$location = $row['location'];
	eval("\$useronline .= \"".$tpl->get("wiw_userbit")."\";");
}

eval("\$wiw_sortby = \"".$tpl->get("wiw_sortby")."\";");
eval("\$wiw_order = \"".$tpl->get("wiw_order")."\";");
$lang->items['LANG_WIW_SORTOPTIONS'] = $lang->get("LANG_WIW_SORTOPTIONS", array('$wiw_sortby' => $wiw_sortby, '$wiw_order' => $wiw_order));

eval("\$tpl->output(\"".$tpl->get("wiw")."\");");
?>
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
// * $Date: 2005-03-18 16:39:04 +0100 (Fri, 18 Mar 2005) $
// * $Author: Burntime $
// * $Rev: 1576 $
// ************************************************************************************//


$filename = 'team.php';

require('./global.php');
$lang->load('MEMBERS,MISC');

$users = $db->unbuffered_query("SELECT g.groupid, g.title, uf.*, ".
 "u.userid, u.username, u.invisible, u.receivepm, u.lastactivity, u.email, u.showemail, u.usercanemail,".
 "gl.userid AS groupleader ".
 "FROM bb".$n."_groups g ".
 "LEFT JOIN bb".$n."_user2groups USING (groupid) ".
 "LEFT JOIN bb".$n."_users u USING (userid) ".
 "LEFT JOIN bb".$n."_userfields uf USING (userid) ".
 "LEFT JOIN bb".$n."_groupleaders gl ON (gl.userid=u.userid AND gl.groupid=g.groupid) ".
 "WHERE g.showonteam = 1 ORDER BY g.showorder, g.groupid, u.username");

$grouptitles = array();
$userbits = array();
$groupleaderbits = array();
$team = '';
while ($user = $db->fetch_array($users)) {
	if (!$user['userid']) continue;
	
	$user['username'] = htmlconverter($user['username']);
	$user['field1'] = htmlconverter($user['field1']);
	$username = $user['username'];
	
	if (!isset($grouptitles[$user['groupid']])) $grouptitles[$user['groupid']] = getlangvar($user['title'], $lang);
	if (($user['invisible'] == 0 || $wbbuserdata['a_can_view_ghosts'] == 1) && $user['lastactivity'] >= time() - $useronlinetimeout * 60) {
		$user_online = 1;
		$LANG_MEMBERS_USERONLINE = $lang->get("LANG_MEMBERS_USERONLINE", array('$username' => $username));
	}
	else {
		$user_online = 0;
		$LANG_MEMBERS_USERONLINE = $lang->get("LANG_MEMBERS_USEROFFLINE", array('$username' => $username));
	}
	
	if ($wbbuserdata['can_use_pms'] == 1 && $user['receivepm'] == 1) $LANG_MEMBERS_PM = $lang->get("LANG_MEMBERS_PM", array('$username' => $username));
	if ($user['showemail'] == 1 || $user['usercanemail'] == 1) $LANG_MEMBERS_SENDEMAIL = $lang->get("LANG_MEMBERS_SENDEMAIL", array('$username' => $username));
		
	eval("\$userbit = \"".$tpl->get("team_userbit")."\";");
	if (!$user['groupleader']) $userbits[$user['groupid']] .= $userbit;
	else $groupleaderbits[$user['groupid']] .= $userbit;
}

if (count($grouptitles)) {
	while (list($groupid, $grouptitle) = each($grouptitles)) eval("\$team .= \"".$tpl->get("team_groupbit")."\";");
}

if ($showboardjump == 1) $boardjump = makeboardjump(0);
eval("\$tpl->output(\"".$tpl->get("team")."\");");
?>
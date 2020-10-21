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
// * $Date: 2004-10-26 14:41:23 +0200 (Tue, 26 Oct 2004) $
// * $Author: Burntime $
// * $Rev: 1459 $
// ************************************************************************************//


$filename = 'index.php';

require('./global.php');
$lang->load('START');

require('./acp/lib/class_useronline.php');

if (isset($_COOKIE[$cookieprefix.'hidecats'])) $hidecats = decode_cookie($_COOKIE[$cookieprefix.'hidecats']);
else $hidecats = array();

if (isset($_GET['hidecat'])) {
	$hidecats[$_GET['hidecat']] = 1;
	if ($wbbuserdata['usecookies'] == 1) encode_cookie("hidecats", time() + 3600 * 24 * 365);
	else encode_cookie("hidecats");
}
if (isset($_GET['showcat'])) {
	$hidecats[$_GET['showcat']] = 0;
	if ($wbbuserdata['usecookies'] == 1) encode_cookie("hidecats", time() + 3600 * 24 * 365);
	else encode_cookie("hidecats");
}

$boardcache = array();
$permissioncache = array();
$modcache = array();

switch ($boardordermode) {
	case 1: $boardorder = 'b.title ASC'; break;
	case 2: $boardorder = 'b.title DESC'; break;
	case 3: $boardorder = 'b.lastposttime DESC'; break;
	default: $boardorder = 'b.boardorder ASC'; break;
}
$activtime = time() - 60 * $useronlinetimeout;

$boardvisit = array();
$result = $db->unbuffered_query("
 SELECT
 b.*".(($showlastposttitle == 1) ? (", t.topic, t.prefix AS threadprefix, i.*") : (""))."
 ".(($showuseronlineinboard == 1) ? (", COUNT(s.sessionhash) AS useronline") : (""))."
 ".(($wbbuserdata['userid']) ? (", bv.lastvisit") : (""))."
 FROM bb".$n."_boards b
 ".(($showlastposttitle == 1) ? ("LEFT JOIN bb".$n."_threads t ON (t.threadid=b.lastthreadid)
 LEFT JOIN bb".$n."_icons i USING (iconid)") : (""))."
 ".(($showuseronlineinboard == 1) ? ("LEFT JOIN bb".$n."_sessions s ON (s.boardid=b.boardid AND s.lastactivity>='$activtime')") : (""))."
 ".(($wbbuserdata['userid']) ? (" LEFT JOIN bb".$n."_boardvisit bv ON (bv.boardid=b.boardid AND bv.userid='".$wbbuserdata['userid']."')") : (""))."
 ".(($showuseronlineinboard == 1) ? ("GROUP BY b.boardid") : (""))."
 ORDER by b.parentid ASC, $boardorder");
while ($row = $db->fetch_array($result)) {
	$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
	$boardvisit[$row['boardid']] = $row['lastvisit'];
}

if ($showuseronlineinboard == 2) {
	$userinboard = array();
	$online = &new useronline($wbbuserdata['a_can_view_ghosts'], $wbbuserdata['buddylist']);
	$result = $db->unbuffered_query("SELECT s.userid, s.boardid, u.username, u.useronlinegroupid,g.useronlinemarking, u.invisible FROM bb".$n."_sessions s LEFT JOIN bb".$n."_users u USING (userid) LEFT JOIN bb".$n."_groups g ON g.groupid=u.useronlinegroupid WHERE s.lastactivity>='$activtime'".(($wbbuserdata['ignorelist']) ? (" AND s.userid NOT IN (".str_replace(" ", ",", $wbbuserdata['ignorelist']).")") : (""))." ORDER BY u.username ASC");	
	while ($row = $db->fetch_array($result)) $userinboard[$row['boardid']][] = $row;	
}

$result = $db->unbuffered_query("SELECT t.boardid, t.threadid, t.lastposttime".(($wbbuserdata['userid']) ? (", tv.lastvisit") : (""))." FROM bb".$n."_threads t".(($wbbuserdata['userid']) ? (" LEFT JOIN bb".$n."_threadvisit tv ON (tv.threadid=t.threadid AND tv.userid='".$wbbuserdata['userid']."')") : (""))." WHERE t.visible = 1 AND t.lastposttime > '$wbbuserdata[lastvisit]' AND t.closed <> 3");
while ($row = $db->fetch_array($result)) {
	if ($row['lastposttime'] > $row['lastvisit']) $visitcache[$row['boardid']][$row['threadid']] = $row['lastposttime'];
}

// read permissions
$permissioncache = getPermissions();

if ($hide_modcell == 0) {
	$result = $db->unbuffered_query("SELECT bb".$n."_moderators.*, username FROM bb".$n."_moderators LEFT JOIN bb".$n."_users USING (userid) ORDER BY username ASC");
	while ($row = $db->fetch_array($result)) $modcache[$row['boardid']][] = $row;
}

$boardbit = makeboardbit(0);

$index_pms = '';
$quicklogin = '';
$index_showevents = '';
$index_useronline = '';
$index_stats = '';

/* ############## STATS ############## */
if ($showstats == 1) {
	$stats = $db->query_first("SELECT s.*, u.username FROM bb".$n."_stats s LEFT JOIN bb".$n."_users u ON(u.userid=s.lastuserid)");
	$stats['username'] = htmlconverter($stats['username']);
	
	$installdays = (time() - $installdate) / 86400;
	if ($installdays < 1) $postperday = $stats['postcount'];
	else $postperday = $stats['postcount'] / $installdays; 
	
	$postperday = number_format($postperday, 2, $lang->get("LANG_GLOBAL_DEC_POINT"), $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	
	if ($stats['usercount'] >= 1000) $stats['usercount'] = number_format($stats['usercount'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	if ($stats['threadcount'] >= 1000) $stats['threadcount'] = number_format($stats['threadcount'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	if ($stats['postcount'] >= 1000) $stats['postcount'] = number_format($stats['postcount'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
}
/* ############## USERONLINE ############## */
if ($showuseronline == 1) {
	$guestcount = 0;
	$membercount = 0;
	$invisiblecount = 0;
	$online = &new useronline($wbbuserdata['a_can_view_ghosts'], $wbbuserdata['buddylist']);
	$result = $db->unbuffered_query("SELECT s.userid, username, useronlinegroupid, useronlinemarking, invisible FROM bb".$n."_sessions s LEFT JOIN bb".$n."_users u USING (userid) LEFT JOIN bb".$n."_groups g ON g.groupid=u.useronlinegroupid WHERE s.lastactivity >= '".(time() - 60 * $useronlinetimeout)."'".(($wbbuserdata['ignorelist']) ? (" AND s.userid NOT IN (".str_replace(" ", ",", $wbbuserdata['ignorelist']).")") : (""))." ORDER BY u.username ASC"); 
	while ($row = $db->fetch_array($result)) {
		if ($row['userid'] == 0) {
			$guestcount++;
			continue;	
		}
		$membercount++;
		if ($row['invisible'] == 1) $invisiblecount++;
		$online->user($row['userid'], htmlconverter($row['username']), $row['useronlinemarking'], $row['invisible']);
	}
	$useronline = $online->useronlinebit;
	$totaluseronline = $membercount + $guestcount;
	if ($totaluseronline > $rekord) {
		$rekord = $totaluseronline;
		$rekordtime = time();
		$db->unbuffered_query("UPDATE bb".$n."_options SET value='$rekord' WHERE varname='rekord'", 1);
		$db->unbuffered_query("UPDATE bb".$n."_options SET value='$rekordtime' WHERE varname='rekordtime'", 1);
		require("./acp/lib/class_options.php");
		$option = &new options("acp/lib");
		$option->write();
	}
	$rekorddate = formatdate($wbbuserdata['dateformat'], $rekordtime);
	$rekordtime = formatdate($wbbuserdata['timeformat'], $rekordtime);
	
	// format figures
	if ($guestcount >= 1000) $guestcount = number_format($guestcount, 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	if ($membercount >= 1000) $membercount = number_format($membercount, 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	if ($invisiblecount >= 1000) $invisiblecount = number_format($invisiblecount, 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	if ($totaluseronline >= 1000) $totaluseronline = number_format($totaluseronline, 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	if ($rekord >= 1000) $rekord = number_format($rekord, 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	
	if ($totaluseronline == 1) {
		$useronline_BE = $lang->items['LANG_START_USERONLINE_BE_ONE'];
		$useronline_USER = $lang->items['LANG_START_USERONLINE_USER_ONE'];
	}
	else {
		$useronline_BE = $lang->items['LANG_START_USERONLINE_BE'];
		$useronline_USER = $lang->items['LANG_START_USERONLINE_USER'];
	}
	
	if ($guestcount == 1) $useronline_GUEST = $lang->items['LANG_START_USERONLINE_GUEST_ONE'];
	elseif ($guestcount > 1) $useronline_GUEST = $lang->items['LANG_START_USERONLINE_GUEST'];
	else {
		$useronline_GUEST = '';
		$guestcount = '';
	}
	
	if ($membercount == 1) $useronline_MEMBERS = $lang->items['LANG_START_USERONLINE_MEMBERS_ONE'];
	elseif ($membercount > 1) $useronline_MEMBERS = $lang->items['LANG_START_USERONLINE_MEMBERS'];
	else {
		$useronline_MEMBERS = '';
		$membercount = '';
	}
	
	if ($invisiblecount == 1) $useronline_GHOSTS = $lang->items['LANG_START_USERONLINE_GHOSTS_ONE'];
	elseif ($invisiblecount > 1) $useronline_GHOSTS = $lang->get("LANG_START_USERONLINE_GHOSTS", array('$invisiblecount' => $invisiblecount));
	else $useronline_GHOSTS = '';
	
	if ($guestcount > 0 && $membercount > 0) $useronline_AND = $lang->items['LANG_START_USERONLINE_AND'];
	else $useronline_AND = '';
	
	$lang->items['LANG_START_USERONLINE'] = $lang->get("LANG_START_USERONLINE", array('$useronline_BE' => $useronline_BE, '$membercount' => $membercount, '$useronline_MEMBERS' => $useronline_MEMBERS, '$useronline_GHOSTS' => $useronline_GHOSTS, '$useronline_AND' => $useronline_AND, '$guestcount' => $guestcount, '$useronline_GUEST' => $useronline_GUEST, '$rekord' => $rekord, '$useronline_USER' => $useronline_USER, '$rekorddate' => $rekorddate, '$rekordtime' => $rekordtime));
	$lang->items['LANG_START_SHOWUSERONLINE'] = $lang->get("LANG_START_SHOWUSERONLINE", array('$useronline_BE' => $useronline_BE, '$totaluseronline' => $totaluseronline, '$useronline_USER' => $useronline_USER));
}
/* ############## BIRTHDAYS ############## */
unset($birthdaybit);
if ($showbirthdays == 1  && $wbbuserdata['can_view_calendar'] != 0) {
	$currentdate = formatdate("m-d", time());
	$currentyear = intval(formatdate("Y", time()));
	$result = $db->unbuffered_query("SELECT userid, username, birthday FROM bb".$n."_users WHERE birthday LIKE '%-$currentdate' ORDER BY username ASC");
	while ($row = $db->fetch_array($result)) {
		$row['username'] = htmlconverter($row['username']);
		$birthyear = intval(wbb_substr($row['birthday'], 0, 4));
		$age = $currentyear - $birthyear;
		if ($age < 1 || $age > 200) $age = '';
		else $age = "&nbsp;($age)";
		if (isset($birthdaybit)) eval("\$birthdaybit .= \"".$tpl->get("index_birthdaybit")."\";");
		else eval("\$birthdaybit = \"".$tpl->get("index_birthdaybit")."\";");
	}
}

/* ############## EVENTS ############## */
unset($eventbit);
if ($showevents == 1 && $wbbuserdata['can_view_calendar'] != 0) {
	$currentdate = date("Y-m-d"); 
	$result = $db->unbuffered_query("SELECT eventid, subject, public FROM bb".$n."_events WHERE eventdate = '$currentdate' AND (public=2 OR (public=1 AND groupid = '$wbbuserdata[groupid]') OR (public=0 AND userid = '$wbbuserdata[userid]')) ORDER BY public ASC, subject ASC");
	while ($row = $db->fetch_array($result)) {
		$row['subject'] = htmlconverter($row['subject']);
		if (isset($eventbit)) eval("\$eventbit .= \"".$tpl->get("index_eventbit")."\";");
		else eval("\$eventbit = \"".$tpl->get("index_eventbit")."\";");
	}
}

if (!$wbbuserdata['userid']) {
	$lang->items['LANG_START_WELCOME_TITLE'] = $lang->get("LANG_START_WELCOME_TITLE", array('$master_board_name' => $master_board_name));
	$lang->items['LANG_START_WELCOME'] = $lang->get("LANG_START_WELCOME", array('$SID_ARG_2ND' => $SID_ARG_2ND, '$SID_ARG_1ST' => $SID_ARG_1ST));
}
else {
	$currenttime = formatdate($wbbuserdata['timeformat'], time());
	$toffset = (($wbbuserdata['timezoneoffset'] >= 0) ? ("+") : ("")).$wbbuserdata['timezoneoffset'];
	$lang->items['LANG_START_TIMEZONE'] = $lang->get("LANG_START_TIMEZONE", array('$toffset' => $toffset));
	$lastvisitdate = formatdate($wbbuserdata['dateformat'], $wbbuserdata['lastvisit'], 1);
	$lastvisittime = formatdate($wbbuserdata['timeformat'], $wbbuserdata['lastvisit']);
	if ($showpmonindex == 1 && $wbbuserdata['can_use_pms'] == 1 && $wbbuserdata['receivepm'] == 1) {
		$counttotal = $wbbuserdata['pminboxcount'];
		$countunread = $wbbuserdata['pmunreadcount'];
		$countnew = $wbbuserdata['pmnewcount'];
		if ($countnew == 1) $pms_NEWMESSAGE = $lang->items['LANG_START_PMS_MESSAGE'];
		else $pms_NEWMESSAGE = $lang->items['LANG_START_PMS_MESSAGES'];
		
		if ($counttotal == 1) $pms_TOTALMESSAGE = $lang->items['LANG_START_PMS_MESSAGE'];
		else $pms_TOTALMESSAGE = $lang->items['LANG_START_PMS_MESSAGES'];
		
		$lang->items['LANG_START_PMS'] = $lang->get("LANG_START_PMS", array('$countnew' => $countnew, '$pms_NEWMESSAGE' => $pms_NEWMESSAGE, '$countunread' => $countunread, '$counttotal' => $counttotal, '$pms_TOTALMESSAGE' => $pms_TOTALMESSAGE));
	}
}

/* Überprüfung PMS-Box-Status*/
$user_check = getwbbuserdatas(wbb_trim($wbbuserdata['username']));
$result = $user_check[wbb_strtolower($wbbuserdata['username'])];
if($wbbuserdata['a_can_ignore_maxpms'] != 1 && $wbbuserdata['userid'])
{
	if($result['pmtotalcount'] >= $result['max_pms']) $pms_error = 1;
	else $pms_error = 0;
}

eval("\$tpl->output(\"".$tpl->get("index")."\");"); 

?>

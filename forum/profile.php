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


$filename = 'profile.php';

require('./global.php');
if ($wbbuserdata['can_view_profile'] == 0) access_error();
require('./acp/lib/class_parse.php');
$lang->load('MEMBERS,THREAD');

$userid = intval($_GET['userid']);
if (!$userid) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));

$user_info = $db->query_first("SELECT ".
"u.*, ".
"uf.*, ".
"r.rankimages, r.ranktitle, ".
"a.avatarextension, a.width, a.height, ".
"s.lastactivity AS s_lastactivity, s.boardid, s.threadid, s.request_uri ".
($showlanguageinprofile == 1 ? ", l.languagepackname " : "").
"FROM bb".$n."_users u ".
"LEFT JOIN bb".$n."_userfields uf USING (userid) ".
"LEFT JOIN bb".$n."_avatars a ON (a.avatarid=u.avatarid) ".
"LEFT JOIN bb".$n."_ranks r ON (r.rankid=u.rankid) ".
"LEFT JOIN bb".$n."_sessions s ON (s.userid=u.userid) ".
($showlanguageinprofile == 1 ? "LEFT JOIN bb".$n."_languagepacks l ON (l.languagepackid=u.langid) " : "").
"WHERE u.userid='$userid'");

if (!$user_info['userid']) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
$user_info['username'] = htmlconverter($user_info['username']);
$lang->items['LANG_MEMBERS_PROFILE_TITLE'] = $lang->get("LANG_MEMBERS_PROFILE_TITLE", array('$username' => $user_info['username']));

/* regdate */
$regdate = formatdate($wbbuserdata['dateformat'], $user_info['regdate']);

/* last activity */
if ($user_info['invisible'] == 0 || $wbbuserdata['a_can_view_ghosts'] == 1) {
	$la_date = formatdate($wbbuserdata['dateformat'], $user_info['lastactivity'], 1);
	$la_time = formatdate($wbbuserdata['timeformat'], $user_info['lastactivity']);
}
else {
	$la_date = $lang->items['LANG_MEMBERS_PROFILE_NODECLARATION'];
	$la_time = '';
}

/* posts per day */
$regdays = (time() - $user_info['regdate']) / 86400;
if ($regdays < 1) $postperday = $user_info['userposts'];
else $postperday = $user_info['userposts'] / $regdays;

$postperday = number_format($postperday, 2, $lang->get("LANG_GLOBAL_DEC_POINT"), $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
$lang->items['LANG_MEMBERS_PROFILE_POSTSPERDAY'] = $lang->get("LANG_MEMBERS_PROFILE_POSTSPERDAY", array('$postperday' => $postperday));

/* usertext */
if ($user_info['usertext']) $user_text = nl2br(htmlconverter(textwrap($user_info['usertext'], 40)));
else $user_text = '';

/* gender */
if ($user_info['gender']) {
	if ($user_info['gender'] == 1) $gender = $lang->items['LANG_MEMBERS_PROFILE_MALE'];
	else $gender = $lang->items['LANG_MEMBERS_PROFILE_FEMALE'];
}
else $gender = $lang->items['LANG_MEMBERS_PROFILE_NODECLARATION'];

/* usertitle */
if ($user_info['title']) $user_info['ranktitle'] = htmlconverter($user_info['title']);
else $user_info['ranktitle'] = getlangvar($user_info['ranktitle'], $lang);
$rankimages = formatRI($user_info['rankimages']);

/* avatar */
if ($user_info['avatarid'] && $showavatar == 1 && $wbbuserdata['showavatars'] == 1) {
	$avatarname = "images/avatars/avatar-$user_info[avatarid].".htmlconverter($user_info['avatarextension']);
	$avatarwidth = $user_info['width'];
	$avatarheight = $user_info['height'];
	if ($user_info['avatarextension'] == "swf" && $allowflashavatar == 1) {
		eval("\$useravatar = \"".$tpl->get("avatar_flash")."\";");
	}
	elseif ($user_info['avatarextension'] != "swf") eval("\$useravatar = \"".$tpl->get("avatar_image")."\";");
}

/* useremail */
if ($user_info['showemail'] == 1) {
	$user_info['email'] = getASCIICodeString($user_info['email']);
	$useremail = makehreftag("mailto:".$user_info['email'], $user_info['email']);
}
else $useremail = $lang->items['LANG_MEMBERS_PROFILE_NODECLARATION'];

/* homepage */
if ($user_info['homepage']) {
	$user_info['homepage'] = htmlconverter($user_info['homepage']);
	$userhomepage = makehreftag($user_info['homepage'], $user_info['homepage'], "_blank");
}
else $userhomepage = $lang->items['LANG_MEMBERS_PROFILE_NODECLARATION'];

/* icq, aim, yim, msn */
if (!$user_info['icq']) $user_info['icq'] = $lang->items['LANG_MEMBERS_PROFILE_NODECLARATION'];
if (!$user_info['aim']) $user_info['aim'] = $lang->items['LANG_MEMBERS_PROFILE_NODECLARATION'];
else $user_info['aim'] = htmlconverter($user_info['aim']);
if (!$user_info['yim']) $user_info['yim'] = $lang->items['LANG_MEMBERS_PROFILE_NODECLARATION'];
else $user_info['yim'] = htmlconverter($user_info['yim']);
if (!$user_info['msn']) $user_info['msn'] = $lang->items['LANG_MEMBERS_PROFILE_NODECLARATION'];
else $user_info['msn'] = htmlconverter($user_info['msn']);

/* birthday */
if ($user_info['birthday'] && $user_info['birthday'] != '0000-00-00') {
	$birthday_array = explode('-', $user_info['birthday']);
	if ($birthday_array[0] == '0000') $birthday =  $birthday_array[2].".".$birthday_array[1].".";
	else $birthday =  $birthday_array[2].".".$birthday_array[1].".".$birthday_array[0];
}
else $birthday = $lang->items['LANG_MEMBERS_PROFILE_NODECLARATION'];


/* profilefields */
$profilefields = '';
$result = $db->unbuffered_query("SELECT profilefieldid, title, fieldtype FROM bb".$n."_profilefields".(($wbbuserdata['a_can_view_hidden'] == 0) ? (" WHERE hidden=0") : (""))." ORDER BY fieldorder ASC");
while ($row = $db->fetch_array($result)) {
	$fieldid = "field".$row['profilefieldid'];
	if (!$user_info[$fieldid] || $user_info[$fieldid] == "0000-00-00") $user_info[$fieldid] = $lang->items['LANG_MEMBERS_PROFILE_NODECLARATION'];
	else {
		if ($row['fieldtype'] == "multiselect") $user_info[$fieldid] = htmlconverter(textwrap(str_replace("\n", "; ", $user_info[$fieldid]), 50));
		elseif ($row['fieldtype'] == "date") {
			$row_datearray = explode("-", $user_info[$fieldid]);
			if ($row_datearray[0] == "0000") $user_info[$fieldid] = $row_datearray[2].".".$row_datearray[1].".";
			else $user_info[$fieldid] = $row_datearray[2].".".$row_datearray[1].".".$row_datearray[0];
		}
		else $user_info[$fieldid] = htmlconverter(textwrap($user_info[$fieldid], 50));
	}

	$row['title'] = getlangvar($row['title'], $lang);

	eval("\$profilefields .= \"".$tpl->get("profile_userfield")."\";");
}


/* users lastpost */
$showlastpost = 0;
if ($showlastpostinprofile == 1 && $wbbuserdata['can_enter_board'] == 1) {
	$boardids = '';

	$permissioncache = getPermissions();

	$result = $db->unbuffered_query("SELECT boardid, password, invisible FROM bb".$n."_boards");
	while ($row = $db->fetch_array($result)) {
		if ($row['password'] != '' || $row['invisible'] == 2) continue;
		if (!isset($permissioncache[$row['boardid']]['can_enter_board']) || $permissioncache[$row['boardid']]['can_enter_board'] != 0) $boardids .= ",".$row['boardid'];
	}

	if ($boardids != '') {
		$lastpost = $db->query_first("SELECT p.postid, p.posttime, t.topic, t.boardid, b.title FROM bb".$n."_posts p, bb".$n."_threads t
		LEFT JOIN bb".$n."_boards b ON (t.boardid=b.boardid)
		WHERE p.threadid=t.threadid AND t.boardid IN (0$boardids) AND p.userid = '$userid' AND p.visible=1
		ORDER BY p.posttime DESC", 1);
		if ($lastpost['postid']) {
			$lastpostdate = formatdate($wbbuserdata['dateformat'], $lastpost['posttime'], 1);
			$lastposttime = formatdate($wbbuserdata['timeformat'], $lastpost['posttime']);

			$lastpost['topic'] = htmlconverter(textwrap($lastpost['topic']));
			$lastpost['title'] = getlangvar($lastpost['title'], $lang);
			$showlastpost = 1;
		}
	}
}

/* buttons for search, buddy, pm, email */
$username = $user_info['username'];
$lang->items['LANG_MEMBERS_SEARCH'] = $lang->get("LANG_MEMBERS_SEARCH", array('$username' => $username));
$lang->items['LANG_MEMBERS_BUDDY'] = $lang->get("LANG_MEMBERS_BUDDY", array('$username' => $username));
if ($user_info['receivepm'] == 1 && $wbbuserdata['can_use_pms'] == 1) $lang->items['LANG_MEMBERS_PM'] = $lang->get("LANG_MEMBERS_PM", array('$username' => $username));
if ($user_info['showemail'] == 0 && $user_info['usercanemail'] == 1) $lang->items['LANG_MEMBERS_SENDEMAIL'] = $lang->get("LANG_MEMBERS_SENDEMAIL", array('$username' => $username));

/* user online */
if (($user_info['invisible'] == 0 || $wbbuserdata['a_can_view_ghosts'] == 1) && $user_info['lastactivity'] >= time() - $useronlinetimeout * 60) {
	$user_online = 1;
	$lang->items['LANG_MEMBERS_USERONLINE'] = $lang->get("LANG_MEMBERS_USERONLINE", array('$username' => $username));
}
else {
	$user_online = 0;
	$lang->items['LANG_MEMBERS_USEROFFLINE'] = $lang->get("LANG_MEMBERS_USEROFFLINE", array('$username' => $username));
}

/* wiw */
$userlocation = '';
if ($showuserlocation == 1 && $user_info['s_lastactivity'] >= (time() - 60 * $useronlinetimeout)) {
	include('./acp/lib/class_useronline.php');
	include('./acp/lib/class_wiw.php');
	$lang->load('WIW');

	$wiw = &new WIW($wbbuserdata['a_can_view_ghosts']);
	$wiw->insert($user_info);
	$wiw->cache();

	if ($row = $wiw->get()) $userlocation = $row['location'];
}

/* userrating */
if ($userratings == 1) $userrating = userrating($user_info['ratingcount'], $user_info['ratingpoints'], $user_info['userid']);
else $userrating = '';

/* userlevel */
if ($userlevels == 1) $userlevel = userlevel($user_info['userposts'], $user_info['regdate']);
else $userlevel = '';

if ($user_info['userposts'] >= 1000) $user_info['userposts'] = number_format($user_info['userposts'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));

/* languagepack */
if ($showlanguageinprofile == 1) {
	$languagepackname = getlangvar($user_info['languagepackname'], $lang);
}
else $languagepackname = '';


eval("\$tpl->output(\"".$tpl->get("profile")."\");");
?>
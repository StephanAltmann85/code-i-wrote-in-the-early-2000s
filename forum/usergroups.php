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


$filename = 'usergroups.php';

require('./global.php');
require('./acp/lib/class_parse.php');
require('./acp/lib/class_parsecode.php');
if (!$wbbuserdata['userid']) access_error();
$lang->load('USERGROUPS,USERCP,MAIL');

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = 'groups';
if (isset($_REQUEST['groupid'])) $groupid = intval($_REQUEST['groupid']);
else $groupid = 0;
if (isset($_REQUEST['userid'])) $userid = intval($_REQUEST['userid']);
else $userid = 0;
if (isset($_REQUEST['applicationid'])) $applicationid = intval($_REQUEST['applicationid']);
else $applicationid = 0;

$username = htmlconverter($wbbuserdata['username']);
$lang->items['LANG_USERCP_TITLE'] = $lang->get("LANG_USERCP_TITLE", array('$username' => $username));

/** groups overview **/
if ($action == 'groups') {
	$lang->load('POSTINGS');


	// cache groupleaders
	$groupleadercache = array();
	$result = $db->unbuffered_query("SELECT l.*, u.username FROM bb".$n."_groupleaders l LEFT JOIN bb".$n."_users u USING(userid) ORDER BY u.username ASC");
	while ($row = $db->fetch_array($result)) $groupleadercache[$row['groupid']][$row['userid']] = htmlconverter($row['username']);



	// applications
	$appliedgroups = '';
	$result = $db->query("SELECT g.*,a.* FROM bb".$n."_applications a LEFT JOIN bb".$n."_groups g ON g.groupid=a.groupid WHERE userid='$wbbuserdata[userid]' AND a.groupid NOT IN(".implode(",", $wbbuserdata['groupids']).") ORDER BY g.showorder ASC");
	if ($db->num_rows($result) > 0) {
		$i = 0;
		while ($group = $db->fetch_array($result)) {
			$group['title'] = getlangvar($group['title'], $lang);
			$group['description'] = getlangvar($group['description'], $lang);

			$groupleaderbit = '';
			$tdclass = getone($i, "tablea", "tableb");
			$senddate = formatdate($wbbuserdata['dateformat'], $group['sendtime'], 1);
			$sendtime = formatdate($wbbuserdata['timeformat'], $group['sendtime']);

			if (isset($groupleadercache[$group['groupid']]) && count($groupleadercache[$group['groupid']])) {
				reset($groupleadercache[$group['groupid']]);
				while (list($userid, $username) = each($groupleadercache[$group['groupid']])) eval("\$groupleaderbit .= \"".$tpl->get("usergroups_groups_groupleaderbit")."\";");
			}

			eval("\$appliedgroups .= \"".$tpl->get("usergroups_groups_appliedgroupbit")."\";");
			$i++;
		}
	}


	// open groups
	$avaiblegroups = '';
	$result = $db->query("SELECT g.*,a.userid FROM bb".$n."_groups g LEFT OUTER JOIN bb".$n."_applications a ON (a.groupid=g.groupid AND a.userid='$wbbuserdata[userid]')WHERE grouptype BETWEEN 5 AND 6 AND g.groupid NOT IN(".implode(",", $wbbuserdata['groupids']).") AND a.groupid IS NULL ORDER BY g.showorder ASC");
	if ($db->num_rows($result) > 0) {
		$i = 0;
		while ($group = $db->fetch_array($result)) {
			$group['title'] = getlangvar($group['title'], $lang);
			$group['description'] = getlangvar($group['description'], $lang);
			$groupleaderbit = '';

			$tdclass = getone($i, "tablea", "tableb");
			$grouptype = $lang->get("LANG_USERGROUPS_GROUPS_GROUPTYPE_".$group['grouptype']);

			if (isset($groupleadercache[$group['groupid']]) && count($groupleadercache[$group['groupid']])) {
				reset($groupleadercache[$group['groupid']]);
				while (list($userid, $username) = each($groupleadercache[$group['groupid']])) eval("\$groupleaderbit .= \"".$tpl->get("usergroups_groups_groupleaderbit")."\";");
			}

			eval("\$avaiblegroups .= \"".$tpl->get("usergroups_groups_avaiblegroupbit")."\";");
			$i++;
		}
	}


	// memberships
	$i = 0;
	$groups_memberships = '';
	$result = $db->query("SELECT * FROM bb".$n."_groups WHERE groupid IN(".implode(",", $wbbuserdata['groupids']).") ORDER BY showorder ASC");
	while ($group = $db->fetch_array($result)) {
		$group['title'] = getlangvar($group['title'], $lang);
		$group['description'] = getlangvar($group['description'], $lang);

		$groupleaderbit = '';
		$tdclass = getone($i, "tablea", "tableb");
		$grouptype = $lang->get("LANG_USERGROUPS_GROUPS_GROUPTYPE_".$group['grouptype']);

		if (isset($groupleadercache[$group['groupid']]) && count($groupleadercache[$group['groupid']])) {
			reset($groupleadercache[$group['groupid']]);
			while (list($userid, $username) = each($groupleadercache[$group['groupid']])) eval("\$groupleaderbit .= \"".$tpl->get("usergroups_groups_groupleaderbit")."\";");
		}

		eval("\$groups_memberships .= \"".$tpl->get("usergroups_groups_memberships")."\";");
		$i++;
	}

	// userranks
	$ranks = '';
	if (count($wbbuserdata['groupids']) > 1 && $wbbuserdata['can_select_rankgroup'] == 1) {
		reset($wbbuserdata['groupids']);
		$checked = array();
		$checked[$wbbuserdata['rankgroupid']] = ' checked="checked"';
		$i = 0;

		$db->data_seek($result, 0);
		while ($group = $db->fetch_array($result)) {
			$group['title'] = getlangvar($group['title'], $lang);
			$groupid = $group['groupid'];

			$tdclass = getone($i, "tablea", "tableb");
			$rankresult = $db->query_first("SELECT * FROM bb".$n."_ranks WHERE groupid IN ('0','$groupid') AND needposts<='$wbbuserdata[userposts]' AND gender IN ('0','$wbbuserdata[gender]') ORDER BY needposts DESC, gender DESC", 1);

			if (!$rankresult['rankid']) $rankresult['ranktitle'] = $lang->get("LANG_USERGROUPS_GROUPS_NORANK");
			else $rankresult['ranktitle'] = getlangvar($rankresult['ranktitle'], $lang);

			$rankimages = formatRI($rankresult['rankimages']);

			eval("\$ranks .= \"".$tpl->get("usergroups_groups_rankbit")."\";");
			$i++;
		}
	}
	else $selectrankgroup = '';

	// useronlinegroups
	$useronlinegroups = '';
	if (count($wbbuserdata['groupids']) > 1 && $wbbuserdata['can_select_useronlinegroup'] == 1) {
		$wbbuserdata['username'] = htmlconverter($wbbuserdata['username']);

		$checked = array();
		$checked[$wbbuserdata['useronlinegroupid']] = ' checked="checked"';
		$i = 0;

		$db->data_seek($result, 0);
		while ($group = $db->fetch_array($result)) {
			$group['title'] = getlangvar($group['title'], $lang);

			$tdclass = getone($i, "tablea", "tableb");
			$groupid = $group['groupid'];
			$useronlinemarking = sprintf($group['useronlinemarking'], $wbbuserdata['username']);
			eval("\$useronlinegroups .= \"".$tpl->get("usergroups_groups_useronlinegroupbit")."\";");
			$i++;
		}
	}
	else $selectuseronlinegroup = '';


	eval("\$tpl->output(\"".$tpl->get("usergroups_groups")."\");");
}




/** join group **/
if ($action == 'join') {
	if ($groupid && !in_array($groupid, $wbbuserdata['groupids'])) {
		$result = $db->query_first("SELECT * FROM bb".$n."_groups WHERE groupid='".$groupid."'");
		if ($result['grouptype'] == 5) {
			$wbbuserdata['groupids'][] = $groupid;
     			sort($wbbuserdata['groupids']);

     			updateMemberships($wbbuserdata['userid'], $wbbuserdata['userposts'], $wbbuserdata['gender'], implode(",", $wbbuserdata['groupids']));
    			$db->unbuffered_query("INSERT IGNORE INTO bb".$n."_user2groups (userid,groupid) VALUES('".$wbbuserdata['userid']."','".$groupid."')", 1);

			header("Location: usergroups.php?action=groups" . $SID_ARG_2ND_UN);
			exit;
		}
		elseif ($result['grouptype'] == 6) {
			$lang->load("POSTINGS");
			
			$result['title'] = getlangvar($result['title'], $lang);			
			$lang->items['LANG_USERGROUPS_GROUPS_APPLICATION'] = $lang->get("LANG_USERGROUPS_GROUPS_APPLICATION", array('$title' => $result['title']));
			eval("\$tpl->output(\"".$tpl->get("usergroups_applyforgroup")."\");");
			exit;
		}
		else {
			header("Location: usergroups.php?action=groups" . $SID_ARG_2ND_UN);
			exit;
		}
	}
	else {
	 	header("Location: usergroups.php?action=groups" . $SID_ARG_2ND_UN);
	 	exit;
	}
}




/** leave group **/
if ($action == 'leave') {
	if ($groupid) {
		$result = $db->query_first("SELECT groupid,grouptype FROM bb".$n."_groups WHERE groupid='".$groupid."'");
		if ($result['grouptype'] > 4 && $result['grouptype'] < 7) {
			$result2 = $db->query_first("SELECT groupid FROM bb".$n."_groups WHERE grouptype='4'");
			
			while (list($key, $val) = each($wbbuserdata['groupids'])) {
				if ($val == $groupid) {
					unset($wbbuserdata['groupids'][$key]);
					break;
				}
			}
			
			if (!count($wbbuserdata['groupids'])) {
				$wbbuserdata['groupids'][] = $result2['groupid'];
				$db->query("INSERT IGNORE INTO bb".$n."_user2groups (userid, groupid) VALUES ('".$wbbuserdata['userid']."', '".$groupid."')");
			}

  			updateMemberships($wbbuserdata['userid'], $wbbuserdata['userposts'], $wbbuserdata['gender'], implode(",", $wbbuserdata['groupids']));
    			$db->unbuffered_query("DELETE FROM bb".$n."_user2groups WHERE userid='".$wbbuserdata['userid']."' AND groupid='".$groupid."'", 1);

			$db->unbuffered_query("DELETE FROM bb".$n."_applications WHERE userid='$wbbuserdata[userid]' AND groupid='$groupid'");
		}
	}
	header("Location: usergroups.php?action=groups" . $SID_ARG_2ND_UN);
	exit;
}





/** applications **/
if ($action == 'apply') {
	$result = $db->query_first("SELECT title,grouptype FROM bb".$n."_groups WHERE groupid='".$groupid."'");
	if ($result['grouptype'] != 6 || in_array($groupid, $wbbuserdata['groupids'])) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
	if (isset($_POST['send']) && $_POST['send'] == "send") {
		$check = $db->query_first("SELECT applicationid FROM bb".$n."_applications WHERE userid='$wbbuserdata[userid]' AND groupid='$groupid' AND status <> 3");
		if (!$check['applicationid']) {
			$db->unbuffered_query("INSERT INTO bb".$n."_applications (userid,groupid,sendtime,reason,notifyperemail) VALUES ('$wbbuserdata[userid]','".$groupid."','".time()."','".addslashes($_POST['reason'])."', '".intval($_POST['notifyperemail'])."')", 1);
			$applicationid = $db->insert_id();

			$langpacks = array();
    			$langpacks[$lang->languagepackid] = $lang;
    			$result['o_title'] = $result['title'];

			$result2 = $db->unbuffered_query("SELECT u.userid, u.username, u.email, u.notificationperpm, l.languagepackid FROM bb".$n."_users u LEFT JOIN bb".$n."_groupleaders gl ON gl.userid=u.userid LEFT JOIN bb".$n."_languagepacks l ON (l.languagepackid=u.langid) WHERE gl.groupid='$groupid' AND u.emailonapplication='1'");
			while ($row = $db->fetch_array($result2)) {
				if (!isset($langpacks[$row['languagepackid']])) {
      					$langpacks[$row['languagepackid']] = &new language(intval($row['languagepackid']));
      					$langpacks[$row['languagepackid']]->load("OWN,MAIL");
     				}

				$master_board_name_email = getlangvar($o_master_board_name, $langpacks[$row['languagepackid']], 0);
     				$result['title'] = getlangvar($result['o_title'], $langpacks[$row['languagepackid']], 0);

     				$subject = $langpacks[$row['languagepackid']]->get("LANG_MAIL_APPLICATION_SUBJECT", array('$username' => $wbbuserdata['username'], '$title' => $result['title']));
				$text = $langpacks[$row['languagepackid']]->get("LANG_MAIL_APPLICATION_TEXT", array('$groupleader' => $row['username'], '$username' => $wbbuserdata['username'], '$title' => $result['title'], '$url2board' => $url2board, '$applicationid' => $applicationid, '$reason' => $_POST['reason'], '$master_board_name_email' => $master_board_name_email));
				if ($row['notificationperpm'] == 0) mailer($row['email'], $subject, $text, $wbbuserdata['email']);
				else sendPrivateMessage(array($row['userid'] => $row['username']), array(), $subject, parseURL($text));
			}
		}
	}
	header("Location: usergroups.php?action=groups" . $SID_ARG_2ND_UN);
	exit;
}


/** save rankgroup **/
if ($action == 'rankgroup') {
	if ($groupid && count($wbbuserdata['groupids']) > 1 && $wbbuserdata['can_select_rankgroup'] == 1) {
		if (in_array($groupid, $wbbuserdata['groupids'])) {
			list($rankid) = $db->query_first("SELECT rankid FROM bb".$n."_ranks WHERE groupid IN ('0','".$groupid."') AND needposts<='$wbbuserdata[userposts]' AND gender IN ('0','$wbbuserdata[gender]') ORDER BY needposts DESC, gender DESC LIMIT 1");
			$db->unbuffered_query("UPDATE bb".$n."_users SET rankgroupid='".$groupid."',rankid='".$rankid."' WHERE userid='".$wbbuserdata['userid']."'", 1);
		}
	}
	header("Location: usergroups.php?action=groups" . $SID_ARG_2ND_UN);
	exit;
}


/** save useronlinegroup **/
if ($action == 'useronlinegroup') {
	if ($groupid && count($wbbuserdata['groupids']) > 1 && $wbbuserdata['can_select_useronlinegroup'] == 1) {
		if (in_array($groupid, $wbbuserdata['groupids'])) $db->unbuffered_query("UPDATE bb".$n."_users SET useronlinegroupid='".$groupid."' WHERE userid='".$wbbuserdata['userid']."'", 1);
	}
	header("Location: usergroups.php?action=groups" . $SID_ARG_2ND_UN);
	exit;
}





/** edit application **/
if ($action == 'editapplication') {
	$application = $db->query_first("SELECT a.*, g.* FROM bb".$n."_applications a LEFT JOIN bb".$n."_groups g ON g.groupid=a.groupid WHERE a.applicationid='$applicationid' AND a.userid='$wbbuserdata[userid]'");

	if (!$application['applicationid']) {
		header("Location: usergroups.php?action=groups" . $SID_ARG_2ND_UN);
		exit;
	}

	if (isset($_POST['send']) && $_POST['send'] == "send") {
		if (isset($_POST['retireapplication']) && $application['status'] == 0) {
			$db->unbuffered_query("DELETE FROM bb".$n."_applications WHERE applicationid='$applicationid'", 1);
			header("Location: usergroups.php?action=groups" . $SID_ARG_2ND_UN);
			exit;
		}
		else {
			$db->unbuffered_query("UPDATE bb".$n."_applications SET notifyperemail='".intval($_POST['notifyperemail'])."'".(($application['status'] == 0) ? (",reason='".addslashes($_POST['reason'])."'") : (""))." WHERE applicationid='$applicationid'", 1);

			header("Location: usergroups.php?action=editapplication&applicationid=$applicationid". $SID_ARG_2ND_UN);
			exit;
		}
	}


	$groupleaderbit = '';
	$result = $db->unbuffered_query("SELECT bb".$n."_groupleaders.userid, username FROM bb".$n."_groupleaders LEFT JOIN bb".$n."_users USING (userid) WHERE groupid = '".$application['groupid']."'");
	while (list($userid, $username) = $db->fetch_array($result)) {
		$username = htmlconverter($username);
		eval("\$groupleaderbit .= \"".$tpl->get("usergroups_groups_groupleaderbit")."\";");
	}

	$application['reply'] = nl2br(htmlconverter($application['reply']));
	$senddate = formatdate($wbbuserdata['dateformat'], $application['sendtime'], 1);
	$sendtime = formatdate($wbbuserdata['timeformat'], $application['sendtime']);
	$status_selected = array("", "", "", "");
	$status_selected[$application['status']] = " selected=\"selected\"";

	$application['reason'] = htmlconverter($application['reason']);
	$application['title'] = getlangvar($application['title'], $lang);
	$application['username'] = htmlconverter($application['username']);

	$lang->items['LANG_USERGROUPS_EDITAPPLICATION_TITLE'] = $lang->get("LANG_USERGROUPS_EDITAPPLICATION_TITLE", array('$title' => $application['title']));
	eval("\$tpl->output(\"".$tpl->get("usergroups_editapplication")."\");");
}





/** groupleaders panel **/
if ($action == 'groupleaders') {
	$check = $db->query("SELECT gl.userid,g.groupid,g.title,g.grouptype,count(u2g.userid) as membercount FROM bb".$n."_groupleaders gl LEFT JOIN bb".$n."_groups g USING(groupid) LEFT JOIN bb".$n."_user2groups u2g ON u2g.groupid=g.groupid WHERE gl.userid='$wbbuserdata[userid]' GROUP BY g.groupid ORDER BY g.showorder ASC");
	if ($db->num_rows($check) < 1) access_error();
	$groupids = '';

	// grouplist
	$groupbits = '';
	$i = 0;
	while ($group = $db->fetch_array($check)) {
		$group['title'] = getlangvar($group['title'], $lang);

		$groupids .= ",".$group['groupid'];
		$tdclass = getone($i, "tablea", "tableb");
		$grouptype = $lang->get("LANG_USERGROUPS_GROUPS_GROUPTYPE_".$group['grouptype']);

		eval("\$groupbits .= \"".$tpl->get("usergroups_groupleaders_groupbit")."\";");
		$i++;
	}

	// applications
	$applicationbits = '';
	$i = 0;
	$result = $db->unbuffered_query("SELECT a.*,u.*,g.* FROM bb".$n."_applications a LEFT JOIN bb".$n."_users u ON u.userid=a.userid LEFT JOIN bb".$n."_groups g ON g.groupid=a.groupid WHERE a.groupid IN(0$groupids) AND status<=1 ORDER BY sendtime DESC,username ASC");
	while ($application = $db->fetch_array($result)) {
		$application['username'] = htmlconverter($application['username']);
		$application['title'] = getlangvar($application['title'], $lang);

		$tdclass = getone($i, "tablea", "tableb");
		$senddate = formatdate($wbbuserdata['dateformat'], $application['sendtime'], 1);
		$sendtime = formatdate($wbbuserdata['timeformat'], $application['sendtime']);
		if ($application['status'] == 0 || $application['sendtime'] >= $wbbuserdata['lastvisit']) $new = makeimgtag("{$style[imagefolder]}/pm_new.gif");
		eval("\$applicationbits .= \"".$tpl->get("usergroups_groupleaders_applicationbit")."\";");
		$i++;
	}

	// old applications
	$i = 0;
	$oldapplicationbits = '';
	$result = $db->unbuffered_query("SELECT a.*,u.*,g.* FROM bb".$n."_applications a LEFT JOIN bb".$n."_users u ON u.userid=a.userid LEFT JOIN bb".$n."_groups g ON g.groupid=a.groupid WHERE a.groupid IN(0$groupids) AND status>=2 ORDER BY sendtime DESC,username ASC");
	while ($application = $db->fetch_array($result)) {
		$application['username'] = htmlconverter($application['username']);
		$application['title'] = getlangvar($application['title'], $lang);

		$tdclass = getone($i, "tablea", "tableb");
		$senddate = formatdate($wbbuserdata['dateformat'], $application['sendtime'], 1);
		$sendtime = formatdate($wbbuserdata['timeformat'], $application['sendtime']);
		eval("\$oldapplicationbits .= \"".$tpl->get("usergroups_groupleaders_oldapplicationbit")."\";");
		$i++;
	}
	eval("\$tpl->output(\"".$tpl->get("usergroups_groupleaders")."\");");
}



/** edit application (groupleader) **/
if ($action == 'groupleaders_editapplication') {
	$lang->load('POSTINGS');

	$application = $db->query_first("SELECT a.*,g.*,u.userid,u.username,u.email,u.notificationperpm,l.languagepackid FROM bb".$n."_applications a LEFT JOIN bb".$n."_groups g ON g.groupid=a.groupid LEFT JOIN bb".$n."_users u ON u.userid=a.userid LEFT JOIN bb".$n."_languagepacks l ON (l.languagepackid=u.langid) WHERE applicationid='$applicationid'");
	if (!$application['applicationid']) {
		header("Location: usergroups.php?action=groupleaders".$SID_ARG_2ND_UN);
		exit;
	}

	$check = $db->query_first("SELECT gl.userid FROM bb".$n."_groupleaders gl WHERE gl.userid='$wbbuserdata[userid]' AND gl.groupid='$application[groupid]'");
	if (!$check['userid']) access_error();

	if (isset($_POST['send']) && $_POST['send'] == "send") {
		if ($application['applicationid']) {
			$db->unbuffered_query("UPDATE bb".$n."_applications SET reply='".addslashes($_POST['reply'])."', status='".intval($_POST['status'])."', groupleaderid='$wbbuserdata[userid]' WHERE applicationid='$applicationid'", 1);
			// accepted
			if ($_POST['status'] == 3 && $application['status'] != 3) {
				if ($application['notifyperemail'] == 1) {
					if ($application['languagepackid'] == $lang->languagepackid) $userlang = $lang;
 					else {
  						$userlang = &new language(intval($application['languagepackid']));
  						$userlang->load("OWN,MAIL");
 					}

					$application['title'] = getlangvar($application['title'], $userlang, 0);
					$master_board_name_email = getlangvar($o_master_board_name, $userlang, 0);

					$subject = $userlang->get("LANG_MAIL_APPLICATION_ACCEPTED_SUBJECT", array('$title' => $application['title']));
					$text = $userlang->get("LANG_MAIL_APPLICATION_ACCEPTED_TEXT", array('$username' => $application['username'], '$title' => $application['title'], '$reply' => $_POST['reply'], '$master_board_name_email' => $master_board_name_email));
					if ($application['notificationperpm'] == 0) mailer($application['email'], $subject, $text, $wbbuserdata['email']);
					else sendPrivateMessage(array($application['userid'] => $application['username']), array(), $subject, parseURL($text));
				}

				$result = getwbbuserdata($application['userid']);
				if (!in_array($application['groupid'], $result['groupids'])) {
					$result['groupids'][] = $application['groupid'];
					sort($result['groupids']);

					updateMemberships($result['userid'], $result['userposts'], $result['gender'], implode(",", $result['groupids']));
    				}

				$db->unbuffered_query("INSERT IGNORE INTO bb".$n."_user2groups (userid,groupid) VALUES ('".$application['userid']."','".$application['groupid']."')", 1);
			}

			// refused
			if ($_POST['status'] == 2) {
				if ($application['notifyperemail'] == 1) {
					if ($application['languagepackid'] == $lang->languagepackid) $userlang = $lang;
 					else {
  						$userlang = &new language(intval($application['languagepackid']));
  						$userlang->load("OWN,MAIL");
 					}

					$application['title'] = getlangvar($application['title'], $userlang, 0);
					$master_board_name_email = getlangvar($o_master_board_name, $userlang, 0);

					$subject = $userlang->get("LANG_MAIL_APPLICATION_REFUSED_SUBJECT", array('$title' => $application['title']));
					$text = $userlang->get("LANG_MAIL_APPLICATION_REFUSED_TEXT", array('$username' => $application['username'], '$title' => $application['title'], '$reply' => $_POST['reply'], '$master_board_name_email' => $master_board_name_email));
					if ($application['notificationperpm'] == 0) mailer($application['email'], $subject, $text, $wbbuserdata['email']);
					else sendPrivateMessage(array($application['userid'] => $application['username']), array(), $subject, parseURL($text));
				}

				$result = getwbbuserdata($application['userid']);

				while (list($key, $val) = each($result['groupids'])) {
					if ($val == $application['groupid']) {
						unset($result['groupids'][$key]);
						break;
					}
   				}


   				updateMemberships($result['userid'], $result['userposts'], $result['gender'], implode(",", $result['groupids']));
   				$db->unbuffered_query("DELETE FROM bb".$n."_user2groups WHERE userid='$application[userid]' AND groupid='$application[groupid]'", 1);
			}
		}
		header("Location: usergroups.php?action=groupleaders" . $SID_ARG_2ND_UN);
		exit;
	}

	if ($application['status'] == 0) {
		$db->unbuffered_query("UPDATE bb".$n."_applications SET status='1',groupleaderid='$wbbuserdata[userid]' WHERE applicationid='$applicationid' AND status='0'", 1);
		$application['status'] = 1;
	}

	$application['reason'] = nl2br(htmlconverter($application['reason']));
	$application['reply'] = htmlconverter($application['reply']);

	$senddate = formatdate($wbbuserdata['dateformat'], $application['sendtime'], 1);
	$sendtime = formatdate($wbbuserdata['timeformat'], $application['sendtime']);
	$status_selected = array("", "", "", "");
	$status_selected[$application['status']] = " selected=\"selected\"";

	$application['title'] = getlangvar($application['title'], $lang);

	$lang->items['LANG_USERGROUPS_EDITAPPLICATION_TITLE'] = $lang->get("LANG_USERGROUPS_EDITAPPLICATION_TITLE", array('$title' => $application['title']));
	eval("\$tpl->output(\"".$tpl->get("usergroups_groupleaders_editapplication")."\");");
}


/** delete applications (groupleader) **/
if ($action == 'groupleaders_deleteapplications') {
	$deleteids = array();
	if (is_array($_POST['applicationids'])) while (list($applicationid, $val) = each($_POST['applicationids'])) if ($val == 1) $deleteids[] = $applicationid;
	if ($deleteids) {
		$result = $db->query("SELECT a.applicationid,gl.userid FROM bb".$n."_applications a LEFT JOIN bb".$n."_groupleaders gl ON (gl.groupid=a.groupid) WHERE applicationid IN(".implode(",", $deleteids).") AND gl.userid='$wbbuserdata[userid]'");
		while ($row = $db->fetch_array($result)) if ($row['userid'] == $wbbuserdata['userid']) $db->unbuffered_query("DELETE FROM bb".$n."_applications WHERE applicationid='$row[applicationid]'", 1);
	}
	header("Location: usergroups.php?action=groupleaders" . $SID_ARG_2ND_UN);
	exit;
}


/** memberslist (groupleader) **/
if ($action == 'memberlist') {
	$check = $db->query_first("SELECT gl.userid FROM bb".$n."_groupleaders gl WHERE gl.userid='$wbbuserdata[userid]' AND gl.groupid='$groupid'");
	if (!$check['userid']) access_error();

	$group = $db->query_first("SELECT * FROM bb".$n."_groups WHERE groupid='$groupid'");
	list($memberscount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_user2groups WHERE groupid='$groupid'");
	if (isset($_REQUEST['page'])) {
		$page = intval($_REQUEST['page']);
		if ($page == 0) $page = 1;
	}
	else $page = 1;
	$pages = ceil($memberscount / $membersperpage);

	$userbits = '';
	if ($pages > 1) $pagelink = makepagelink("usergroups.php?action=memberlist&amp;groupid=$groupid".$SID_ARG_2ND, $page, $pages, $showpagelinks - 1);


	$result = $db->query("SELECT u.userid,u.username FROM bb".$n."_user2groups u2g LEFT JOIN bb".$n."_users u ON u.userid=u2g.userid WHERE u2g.groupid='$groupid' ORDER BY u.username ASC LIMIT ".(($page - 1) * $membersperpage).",$membersperpage");
	$i = 0;
	while ($user = $db->fetch_array($result)) {
		$user['username'] = htmlconverter($user['username']);
		$tdclass = getone($i, "tablea", "tableb");
		eval("\$userbits .= \"".$tpl->get("usergroups_memberslist_userbit")."\";");
		$i++;
	}


	$group['title'] = getlangvar($group['title'], $lang);
	
	$lang->items['LANG_USERGROUPS_GROUPLEADERS_USERSINGROUP'] = $lang->get("LANG_USERGROUPS_GROUPLEADERS_USERSINGROUP", array('$title' => $group['title']));
	eval("\$tpl->output(\"".$tpl->get("usergroups_memberslist")."\");");
}


/** remove user (groupleader) **/
if ($action == 'groupleaders_removeusers') {
	$check = $db->query_first("SELECT gl.userid FROM bb".$n."_groupleaders gl WHERE gl.userid='$wbbuserdata[userid]' AND gl.groupid='$groupid'");
	if (!$check['userid']) access_error();

	$check2 = $db->query_first("SELECT * FROM bb".$n."_groups g WHERE groupid='$groupid'");
	if ($check2['grouptype'] <= 4) {
		header("Location: usergroups.php?action=groupleaders" . $SID_ARG_2ND_UN);
		exit;
	}
	
	$result2 = $db->query_first("SELECT groupid FROM bb".$n."_groups WHERE grouptype='4'");

	if (is_array($_POST['userids'])) {
		while (list($userid, ) = each($_POST['userids'])) {
			$result = getwbbuserdata($userid);

			while (list($key, $val) = each($result['groupids'])) {
				if ($val == $groupid) {
					unset($result['groupids'][$key]);
					break;
				}
			}

			if (!count($result['groupids'])) {
				$result['groupids'][] = $result2['groupid'];
				$db->query("INSERT IGNORE INTO bb".$n."_user2groups (userid, groupid) VALUES ('".$userid."', '".$groupid."')");
			}
			
			updateMemberships($result['userid'], $result['userposts'], $result['gender'], implode(",", $result['groupids']));
			$db->unbuffered_query("DELETE FROM bb".$n."_user2groups WHERE userid='".$result['userid']."' AND groupid='$groupid'", 1);
		}
	}

	header("Location: usergroups.php?action=groupleaders" . $SID_ARG_2ND_UN);
	exit;
}
?>
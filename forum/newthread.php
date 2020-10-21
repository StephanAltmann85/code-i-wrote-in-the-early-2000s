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
// * $Date: 2005-03-23 15:02:18 +0100 (Wed, 23 Mar 2005) $
// * $Author: Burntime $
// * $Rev: 1581 $
// ************************************************************************************//


$filename = 'newthread.php';

require('./global.php');
require('./acp/lib/class_parse.php');
require('./acp/lib/class_parsecode.php');

$lang->load('POST,POSTINGS,MAIL');



/** announce thread **/
if ($_REQUEST['action'] == 'announce') {
	if (!isset($threadid) || $thread['important'] != 2) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
	if (!checkmodpermissions("m_can_announce")) access_error();
	
	$action = 'announce';
	
	if (isset($_POST['send'])) {
		$boardids = $_POST['boardids'];
		if (count($boardids)) {
			$boardids = implode("','$threadid'),('", $boardids);
			$db->unbuffered_query("INSERT IGNORE INTO bb".$n."_announcements (boardid,threadid) VALUES ('$boardids','$threadid')", 1);
		}
		
		header("Location: thread.php?threadid=$threadid" . $SID_ARG_2ND_UN);
		exit();	
	}	
	
	$result = $db->unbuffered_query("SELECT boardid, parentid, boardorder, title, invisible FROM bb".$n."_boards ORDER by parentid ASC, boardorder ASC");
	while ($row = $db->fetch_array($result)) $boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
	
	$permissioncache = getPermissions();
	$board_options = makeboardselect(0, 1, $boardid);
	
	$navbar = getNavbar($board['parentlist']);
	eval("\$navbar .= \"".$tpl->get("navbar_board")."\";");
	
	eval("\$tpl->output(\"".$tpl->get("newthread_announce")."\");");	
	exit();	
}

unset($message);
unset($topic);
unset($guestname);

if (!isset($boardid)) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
if ($board['isboard'] != 1 || $board['closed'] == 1 || $board['externalurl'] != '' || !checkpermissions("can_start_topic")) access_error();

/* checkbox preselect */
if ($newthread_default_checked_0 == 1) $checked[0] = 'checked="checked"';
if ($wbbuserdata['emailnotify'] == 1) $checked[1] = 'checked="checked"';

if ($newthread_default_checked_2 == 1) $checked[2] = 'checked="checked"';
if ($newthread_default_checked_3 == 1) $checked[3] = 'checked="checked"';
if ($newthread_default_checked_4 == 1) $checked[4] = 'checked="checked"';
if ($newthread_default_checked_5 == 1) $checked[5] = 'checked="checked"';

if ($newthread_default_checked_6 == 1) $checked[6] = 'checked="checked"';
$imp_checked[0] = 'checked="checked"';


if (isset($_POST['send'])) {
	/* get topic & stop shooting */
	$topic = wbb_trim($_POST['topic']);
	if ($dostopshooting == 1) $topic = stopShooting($topic);
	if (isset($_POST['prefix'])) $prefix = $_POST['prefix'];
	else $prefix = '';
	
	/* get message & strip crap */
	$message = stripcrap(wbb_trim($_POST['message']));
	if (wbb_strlen($message) > $postmaxchars) $message = wbb_substr($message, 0, $postmaxchars);
	
	/* get guestname */
	if (!$wbbuserdata['userid']) $guestname = wbb_trim($_POST['guestname']);

	// get idhash (for attachments)
	if (isset($_POST['idhash'])) $idhash = wbb_trim($_POST['idhash']);
	else $idhash = '';
	
	if ($idhash == '') $idhash = md5($wbbuserdata['userid'].'|'.$boardid.'|'.time());
	
	if (isset($_POST['poll_id'])) $poll_id = intval($_POST['poll_id']);
	else $poll_id = 0;
	
	/* check attachmentids:start */
	if (checkpermissions('can_upload_attachments') == 1) {
		if (isset($_POST['attachmentids']) && $_POST['attachmentids'] != '') {
			$attachmentids = intval_array(explode(',', $_POST['attachmentids']));
			$attachment_verify = $db->query("SELECT * FROM bb".$n."_attachments WHERE attachmentid IN (".implode(',', $attachmentids).") AND idhash='".addslashes($idhash)."'");
			$attachmentids = array();
			while ($row = $db->fetch_array($attachment_verify)) {
				$attachmentids[] = $row['attachmentid'];
			}		
		}
		else {
			// read attachments from database (for users without javascript)
			$attachment_verify = $db->query("SELECT * FROM bb".$n."_attachments WHERE idhash='".addslashes($idhash)."'");
			$attachmentids = array();
			while ($row = $db->fetch_array($attachment_verify)) {
				$attachmentids[] = $row['attachmentid'];
			}
		}	
	}
	else {
		$attachmentids = array();	
	}
	/* check attachmentids:end */
	
	/* posting feature rights:start */
	if (isset($_POST['iconid']) && checkpermissions("can_use_post_icons") == 1) $iconid = intval($_POST['iconid']);
	else $iconid = 0;
	
	if (!checkpermissions("can_use_post_smilies") || (isset($_POST['disablesmilies']) && $_POST['disablesmilies'] == 1)) $allowsmilies = 0;
	else $allowsmilies = 1;	
	
	if (!checkpermissions("can_use_post_html") || (isset($_POST['disablehtml']) && $_POST['disablehtml'] == 1)) $allowhtml = 0;
	else $allowhtml = 1;	
	
	if (!checkpermissions("can_use_post_bbcode") || (isset($_POST['disablebbcode']) && $_POST['disablebbcode'] == 1)) $allowbbcode = 0;
	else $allowbbcode = 1;	
	
	if (!checkpermissions("can_use_post_images") || (isset($_POST['disableimages']) && $_POST['disableimages'] == 1)) $allowimages = 0;
	else $allowimages = 1;	
	/* posting feature rights:end */
	
	
	if (!isset($_POST['preview']) && !$_POST['change_editor']) {
		$error = '';
		
		/* verify guestname */
		if (!$wbbuserdata['userid']) {
			$wbbuserdata['username'] = $guestname;
			if (!$wbbuserdata['username'] || !verify_username($wbbuserdata['username'])) $error .= $lang->items['LANG_POST_ERROR2'];
		}
		
		/* check message */
		if (!$topic || !$message || ($board['prefixuse'] > 0 && checkpermissions('can_use_prefix') && $board['prefixrequired'] == 1 && !$prefix)) $error .= $lang->items['LANG_POSTINGS_ERROR1'];
		if (flood_control($wbbuserdata['userid'], $REMOTE_ADDR, $wbbuserdata['avoid_fc'])) $error .= $lang->get("LANG_POST_ERROR3", array('$fctime' => $fctime));
		if ($wbbuserdata['max_post_image'] != -1 && wbb_substr_count(wbb_strtolower($message), "[img]") > $wbbuserdata['max_post_image']) $error .= $lang->items['LANG_POST_ERROR4'];
		
		if ($error) eval("\$newthread_error = \"".$tpl->get("newthread_error")."\";");
		else {
			/* parse url */
			if ($_POST['parseurl'] == 1 && $allowbbcode == 1) $message = parseURL($message);
			
			/* thread already exists? */
			$result = $db->query_first("SELECT threadid FROM bb".$n."_threads WHERE boardid = '".$boardid."' AND starterid='$wbbuserdata[userid]' AND starter='".addslashes($wbbuserdata['username'])."' AND topic='".addslashes($topic)."' AND prefix='".addslashes($prefix)."' AND starttime>='".(time() - $dpvtime)."'", 1);
			if ($result['threadid']) {
				header("Location: thread.php?threadid=".$result['threadid'].$SID_ARG_2ND_UN);
				exit();	
			}
			
			/* verify poll */
			if ($poll_id != 0) {
				$poll_verify = $db->query_first("SELECT threadid FROM bb".$n."_polls WHERE pollid = '$poll_id' AND idhash='".addslashes($idhash)."'");
				if ($poll_verify['threadid'] || $poll_verify['threadid'] != 0) $poll_id = 0;
			}
			
			/* avoid moderation */
			if (checkpermissions("can_post_without_moderation") == 1) $board['moderatenew'] = 0;
			$time = time();
			
			/* mod options */
			if (intval($_POST['important']) == 1 && checkmodpermissions("m_can_thread_top")) $important = 1;
			elseif (intval($_POST['important']) == 2 && checkmodpermissions("m_can_announce")) $important = 2;
			else $important = 0;
			
			/* verify prefix */
			if ($prefix && $board['prefixuse'] > 0 && checkpermissions('can_use_prefix')) {
				if ($board['prefixuse'] == 1) $ch_prefix = $default_prefix;
				if ($board['prefixuse'] == 2) $ch_prefix = $default_prefix."\n".$board['prefix'];
				if ($board['prefixuse'] == 3) $ch_prefix = $board['prefix'];
				$ch_prefix = preg_replace("/\s*\n\s*/", "\n", wbb_trim($ch_prefix));
				$ch_prefix = explode("\n", $ch_prefix);
				if (!in_array($prefix, $ch_prefix)) $prefix = '';
			}
			else $prefix = '';
			
			/* insert thread */
			$db->query("INSERT INTO bb".$n."_threads (boardid,prefix,topic,iconid,starttime,starterid,starter,lastposttime,lastposterid,lastposter,attachments,pollid,important,visible) VALUES ('$boardid','".addslashes($prefix)."','".addslashes($topic)."','$iconid','$time','$wbbuserdata[userid]','".addslashes($wbbuserdata['username'])."','$time','$wbbuserdata[userid]','".addslashes($wbbuserdata['username'])."','".count($attachmentids)."','$poll_id','$important','".(($board['moderatenew'] == 10 || $board['moderatenew'] == 11) ? (0) : (1))."')");
			$threadid = $db->insert_id();
			
			/* set poll threadid */
			if ($_POST['poll_id']) $db->unbuffered_query("UPDATE bb".$n."_polls SET threadid='$threadid', idhash='' WHERE pollid='$poll_id'", 1);
			
			/* insert post */
			$db->query("INSERT INTO bb".$n."_posts (threadid,userid,username,iconid,posttopic,posttime,message,attachments,allowsmilies,allowhtml,allowbbcode,allowimages,showsignature,ipaddress,visible) VALUES ".
			"('$threadid','$wbbuserdata[userid]','".addslashes($wbbuserdata['username'])."','$iconid','".addslashes($topic)."','$time','".addslashes($message)."','".count($attachmentids)."','$allowsmilies','$allowhtml','$allowbbcode','$allowimages','".intval($_POST['showsignature'])."','".addslashes($REMOTE_ADDR)."','".(($board['moderatenew'] == 10 || $board['moderatenew'] == 11) ? (0) : (1))."')");
			$postid = $db->insert_id();
			
			/* create postcache */
			$parse = &new parse($docensor, 75, 1, '', $usecode, 1, 1);
			$cache = $parse->doparse($message, $allowsmilies, $allowhtml, $allowbbcode, $allowimages);
			$db->query("REPLACE INTO bb".$n."_postcache (postid, threadid, cache) VALUES ('".$postid."', '".$threadid."', '".addslashes($cache)."')");

			
			/* set attachments postid */
			if (count($attachmentids)) {
				$db->unbuffered_query("UPDATE bb".$n."_attachments SET postid='$postid', idhash='' WHERE attachmentid IN (".implode(',', $attachmentids).")", 1);
			}
			
			/* insert subscription */
			if ($_POST['emailnotify'] == 1 && $wbbuserdata['userid']) $db->unbuffered_query("INSERT INTO bb".$n."_subscribethreads (userid,threadid,emailnotify,countemails) VALUES ($wbbuserdata[userid],$threadid,1,0)", 1);
			
			/* wordmatch */
			wordmatch($postid, $message, $topic);
			
			/* mod subscriptions */
			$subscriptions = '';
			$langpacks = array();
			$langpacks[$lang->languagepackid] = $lang;
			$result = $db->query("SELECT u.userid, u.email, u.username, u.notificationperpm, l.languagepackid FROM bb".$n."_moderators m LEFT JOIN bb".$n."_users u USING(userid) LEFT JOIN bb".$n."_languagepacks l ON(l.languagepackid=u.langid) WHERE m.userid<>'$wbbuserdata[userid]' AND m.boardid ='".$boardid."' AND m.notify_newthread=1");
			while ($row = $db->fetch_array($result)) {
				$subscriptions .= "," . $row['userid'];
				
				if (!isset($langpacks[$row['languagepackid']])) {
					$langpacks[$row['languagepackid']] = &new language(intval($row['languagepackid']));	
					$langpacks[$row['languagepackid']]->load("OWN,MAIL");
				}
				
				$master_board_name_email = getlangvar($o_master_board_name, $langpacks[$row['languagepackid']], 0);   
				$board['title'] = getlangvar($board['o_title'], $langpacks[$row['languagepackid']], 0);   
				
				$mail_subject = $langpacks[$row['languagepackid']]->get("LANG_MAIL_MOD_NEWTHREAD_SUBJECT", array('$title' => $board['title']));
				$mail_text = $langpacks[$row['languagepackid']]->get("LANG_MAIL_MOD_NEWTHREAD_TEXT", array('$username' => $row['username'], '$title' => $board['title'], '$topic' => $topic, '$author' => $wbbuserdata['username'], '$url2board' => $url2board, '$threadid' => $threadid, '$master_board_name_email' => $master_board_name_email));
				if ($row['notificationperpm'] == 0) mailer($row['email'], $mail_subject, $mail_text);
				else sendPrivateMessage(array($row['userid'] => $row['username']), array(), $mail_subject, parseURL($mail_text));
			}
			
			
			if ($board['moderatenew'] == 10 || $board['moderatenew'] == 11) redirect($lang->items['LANG_POST_REDIRECT'], "board.php?boardid=$boardid".$SID_ARG_2ND, 10);
			else {
				/* update board info */
				$db->unbuffered_query("UPDATE bb".$n."_boards SET threadcount=threadcount+1, postcount=postcount+1, lastthreadid='$threadid', lastposttime='$time', lastposterid='$wbbuserdata[userid]', lastposter='".addslashes($wbbuserdata['username'])."' WHERE boardid IN ($board[parentlist],$boardid)", 1);
				
				/* update global threadcount & postcount */
				$db->unbuffered_query("UPDATE bb".$n."_stats SET threadcount=threadcount+1, postcount=postcount+1", 1);
				
				/* update userposts & rank */
				if ($board['countuserposts'] == 1  && $wbbuserdata['userid']) {
					$wbbuserdata['userposts'] += 1;
					list($rankid) = $db->query_first("SELECT rankid FROM bb".$n."_ranks WHERE groupid IN ('0','$wbbuserdata[rankgroupid]') AND needposts<='$wbbuserdata[userposts]' AND gender IN ('0','$wbbuserdata[gender]') ORDER BY needposts DESC, gender DESC", 1);
					$db->unbuffered_query("UPDATE bb".$n."_users SET userposts=userposts+1".(($rankid != $wbbuserdata['rankid']) ? (", rankid='$rankid'") : (""))." WHERE userid = '$wbbuserdata[userid]'", 1);
					
					checkPosts4AI();
				}
				
				/* subscriptions */
				$result = $db->query("SELECT u.userid, u.email, u.username, u.notificationperpm, s.countemails, l.languagepackid FROM bb".$n."_subscribeboards s LEFT JOIN bb".$n."_users u USING(userid) LEFT JOIN bb".$n."_languagepacks l ON(l.languagepackid=u.langid) WHERE s.boardid='$boardid' AND s.userid NOT IN (" . $wbbuserdata['userid'] . $subscriptions . ") AND s.emailnotify=1 AND s.countemails<'$maxnotifymails' AND u.email is not null");
				while ($row = $db->fetch_array($result)) {
					
					if (!isset($langpacks[$row['languagepackid']])) {
						$langpacks[$row['languagepackid']] = &new language(intval($row['languagepackid']));	
						$langpacks[$row['languagepackid']]->load("OWN,MAIL");
					}
					
					$master_board_name_email = getlangvar($o_master_board_name, $langpacks[$row['languagepackid']], 0);   
					$board['title'] = getlangvar($board['o_title'], $langpacks[$row['languagepackid']], 0);   
					
					$mail_subject = $langpacks[$row['languagepackid']]->get("LANG_MAIL_NEWTHREAD_SUBJECT", array('$title' => $board['title']));
					$mail_text = $langpacks[$row['languagepackid']]->get("LANG_MAIL_NEWTHREAD_TEXT", array('$username' => $row['username'], '$title' => $board['title'], '$topic' => $topic, '$author' => $wbbuserdata['username'], '$url2board' => $url2board, '$threadid' => $threadid, '$master_board_name_email' => $master_board_name_email));
					
					if ($row['notificationperpm'] == 0) mailer($row['email'], $mail_subject, $mail_text);
					else sendPrivateMessage(array($row['userid'] => $row['username']), array(), $mail_subject, parseURL($mail_text));
				}
				$db->unbuffered_query("UPDATE bb".$n."_subscribeboards SET countemails=countemails+1 WHERE boardid='$boardid' AND userid<>'$wbbuserdata[userid]' AND emailnotify=1 AND countemails<'$maxnotifymails'", 1);
				
				if ($important == 2) {
					$db->unbuffered_query("INSERT INTO bb".$n."_announcements (boardid,threadid) VALUES ('$boardid','$threadid')", 1);
					header("Location: newthread.php?action=announce&threadid=$threadid".$SID_ARG_2ND_UN);
				}
				else header("Location: thread.php?threadid=$threadid" . $SID_ARG_2ND_UN);
				exit;
			}
			
		}
	}
	else if (!$_POST['change_editor']) {
		$parse = &new parse($docensor, 75, $wbbuserdata['showimages'], "", $usecode);
		$preview_topic = htmlconverter(textwrap($topic));
		$preview_message = $parse->doparse((($_POST['parseurl'] == 1 && $allowbbcode) ? (parseURL($message)) : ($message)), $allowsmilies, $allowhtml, $allowbbcode, $allowimages);
		if ($iconid != 0) {
			$result = $db->query_first("SELECT * FROM bb".$n."_icons WHERE iconid = '$iconid'");
			$preview_posticon = makeimgtag($result['iconpath'], getlangvar($result['icontitle'], $lang), 0);
		}
		eval("\$preview_window = \"".$tpl->get("newthread_preview")."\";");	
	}
	
	if ($_POST['parseurl'] == 1 && !$_POST['disablebbcode']) $checked[0] = 'checked="checked"';
	else $checked[0] = '';
	if ($_POST['emailnotify'] == 1) $checked[1] = 'checked="checked"';
	else $checked[1] = '';
	
	if ($_POST['disablesmilies'] == 1) $checked[2] = 'checked="checked"';
	else $checked[2] = '';
	if ($_POST['disablehtml'] == 1) $checked[3] = 'checked="checked"';
	else $checked[3] = '';
	if ($_POST['disablebbcode'] == 1) $checked[4] = 'checked="checked"';
	else $checked[4] = '';
	if ($_POST['disableimages'] == 1) $checked[5] = 'checked="checked"';
	else $checked[5] = '';
	
	if ($_POST['showsignature'] == 1) $checked[6] = 'checked="checked"';
	else $checked[6] = '';
	if (isset($_POST['important'])) {
		if ($_POST['important'] == 2) $imp_checked[2] = 'checked="checked"';	
		if ($_POST['important'] == 1) $imp_checked[1] = 'checked="checked"';	
		if ($_POST['important'] != 0) $imp_checked[0] = '';	
	}
	
	if (isset($_POST['attachmentname'])) $attachmentname = $_POST['attachmentname'];
	else $attachmentname = '';
	if (isset($_POST['attachment_id'])) $attachment_id = $_POST['attachment_id'];
	else $attachment_id = 0;
	
}

$navbar = getNavbar($board['parentlist']);
eval("\$navbar .= \"".$tpl->get("navbar_board")."\";");

if (!isset($iconid)) $iconid = 0;
if (checkpermissions("can_use_post_icons") == 1) $newthread_icons = getIcons($iconid);
if (checkpermissions("can_use_post_bbcode") == 1 && $wbbuserdata['usewysiwyg'] != 1) $bbcode_buttons = getcodebuttons();
if (checkpermissions("can_use_post_smilies") == 1) {
	if ($wbbuserdata['usewysiwyg'] == 1) $smilies = getAppletSmilies();
	$bbcode_smilies = getclickysmilies($smilie_table_cols, $smilie_table_rows);
}

$note = '';
if (checkpermissions("can_use_post_html") == 0) $note .= $lang->items['LANG_POSTINGS_HTML_NOT_ALLOW'];
else $note .= $lang->items['LANG_POSTINGS_HTML_ALLOW'];
if (checkpermissions("can_use_post_bbcode") == 0) $note .= $lang->items['LANG_POSTINGS_BBCODE_NOT_ALLOW'];
else $note .= $lang->items['LANG_POSTINGS_BBCODE_ALLOW'];
if (checkpermissions("can_use_post_smilies") == 0) $note .= $lang->items['LANG_POSTINGS_SMILIES_NOT_ALLOW'];
else $note .= $lang->items['LANG_POSTINGS_SMILIES_ALLOW'];
if (checkpermissions("can_use_post_images") == 0) $note .= $lang->items['LANG_POSTINGS_HTML_IMAGES_ALLOW'];
else $note .= $lang->items['LANG_POSTINGS_IMAGES_ALLOW'];


if (!isset($idhash)) $idhash = md5($wbbuserdata['userid'].'|'.$boardid.'|'.time());
else $idhash = htmlconverter($idhash);
if (checkpermissions("can_upload_attachments") == 1) {
	if (isset($attachmentids) && is_array($attachmentids)) $attachmentids = implode(',', $attachmentids);
	else $attachmentids = '';
	
	eval("\$attachment = \"".$tpl->get("newthread_attachment")."\";");
}
else $attachment = '';

if (isset($message)) $message = htmlconverter($message);
elseif ($board['threadtemplateuse'] > 0) {
	if ($board['threadtemplateuse'] == 1) $threadtemplate = $default_threadtemplate;
	if ($board['threadtemplateuse'] == 2) $threadtemplate = $board['threadtemplate'];
	$message = getlangvar($threadtemplate, $lang);
}
if (isset($topic)) $topic = htmlconverter($topic);
if (isset($guestname)) $guestname = htmlconverter($guestname);
eval("\$newthread_username = \"".$tpl->get("newthread_username")."\";");

if ($board['prefixuse'] > 0 && checkpermissions("can_use_prefix")) {
	if ($board['prefixuse'] == 1) $ch_prefix = $default_prefix;
	if ($board['prefixuse'] == 2) $ch_prefix = $default_prefix."\n".$board['prefix'];
	if ($board['prefixuse'] == 3) $ch_prefix = $board['prefix'];
	
	$ch_prefix = preg_replace("/\s*\n\s*/", "\n", wbb_trim($ch_prefix));
	$ch_prefix = explode("\n", $ch_prefix);	
	sort($ch_prefix);
	
	$prefix_options = '';
	$_POST['prefix'] = htmlconverter($_POST['prefix']);
	for ($i = 0; $i < count($ch_prefix); $i++) {
		$ch_prefix[$i] = htmlconverter($ch_prefix[$i]);
		$prefix_options .= makeoption($ch_prefix[$i], $ch_prefix[$i], $_POST['prefix'], 1);	
	}	
	if ($prefix_options != '') eval("\$select_prefix = \"".$tpl->get("newthread_prefix")."\";");
}

eval("\$headinclude .= \"".$tpl->get("bbcode_script")."\";");
eval("\$editor = \"".$tpl->get("editor")."\";");
eval("\$editor_switch = \"".$tpl->get("editor_switch")."\";");
eval("\$tpl->output(\"".$tpl->get("newthread")."\");");
?>
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
// * $Date: 2005-03-10 16:32:55 +0100 (Thu, 10 Mar 2005) $
// * $Author: Burntime $
// * $Rev: 1570 $
// ************************************************************************************//


$filename = 'addreply.php';

require('./global.php');
require('./acp/lib/class_parse.php');
require('./acp/lib/class_parsecode.php');
$lang->load('POST,POSTINGS,MAIL,THREAD');

if (!isset($threadid) || $thread['closed'] == 3) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
if ($thread['visible'] == 0 || ($thread['closed'] != 0 && !checkmodpermissions('m_can_close_reply')) || $board['isboard'] != 1 || $board['closed'] == 1 || (!checkpermissions('can_reply_topic') && (!checkpermissions('can_reply_own_topic') || $thread['starterid'] != $wbbuserdata['userid']))) access_error();

// check for double post
if ($wbbuserdata['doublepost_timegap'] != 0 && $thread['lastposterid'] == $wbbuserdata['userid']) {
	
	if ($wbbuserdata['doublepost_timegap'] == -1) error($lang->get("LANG_POST_REPLY_ERROR1"));
	else if ($thread['lastposttime'] >= time() - $wbbuserdata['doublepost_timegap'] * 60 ) error($lang->get("LANG_POST_REPLY_ERROR2", array('$doublepost_timegap' => $wbbuserdata['doublepost_timegap'])));

}

unset($message);
unset($topic);
unset($guestname);
unset($result);

$preview_window = '';
$addreply_error = '';
$checked = array('', '', '', '', '', '', '', '');

/* checkbox preselect */
if ($addreply_default_checked_0 == 1) $checked[0] = 'checked="checked"';
if ($wbbuserdata['emailnotify'] == 1) $checked[1] = 'checked="checked"';

if ($addreply_default_checked_2 == 1) $checked[2] = 'checked="checked"';
if ($addreply_default_checked_3 == 1) $checked[3] = 'checked="checked"';
if ($addreply_default_checked_4 == 1) $checked[4] = 'checked="checked"';
if ($addreply_default_checked_5 == 1) $checked[5] = 'checked="checked"';

if ($addreply_default_checked_6 == 1) $checked[6] = 'checked="checked"';

if (isset($_POST['send'])) {
	// post options
	if (isset($_POST['parseurl'])) $parseurl = intval($_POST['parseurl']);
	else $parseurl = 0;
	if (isset($_POST['emailnotify'])) $emailnotify = intval($_POST['emailnotify']);
	else $emailnotify = 0;
	if (isset($_POST['disablesmilies'])) $disablesmilies = intval($_POST['disablesmilies']);
	else $disablesmilies = 0;
	if (isset($_POST['disablehtml'])) $disablehtml = intval($_POST['disablehtml']);
	else $disablehtml = 0;
	if (isset($_POST['disablebbcode'])) $disablebbcode = intval($_POST['disablebbcode']);
	else $disablebbcode = 0;
	if (isset($_POST['disableimages'])) $disableimages = intval($_POST['disableimages']);
	else $disableimages = 0;
	if (isset($_POST['showsignature'])) $showsignature = intval($_POST['showsignature']);
	else $showsignature = 0;
	if (isset($_POST['threadclose'])) $threadclose = intval($_POST['threadclose']);
	else $threadclose = 0;
	if (isset($_POST['idhash'])) $idhash = wbb_trim($_POST['idhash']);
	else $idhash = '';
	
	if ($idhash == '') $idhash = md5($wbbuserdata['userid'].'|'.$threadid.'|'.time());
	
	/* get topic & stop shooting */
	$topic = wbb_trim($_POST['topic']);
	if ($dostopshooting == 1) $topic = stopShooting($topic);

	/* get message & strip crap */
	$message = stripcrap(wbb_trim($_POST['message']));
	if (wbb_strlen($message) > $postmaxchars) $message = wbb_substr($message, 0, $postmaxchars);
	
	/* get guestname */
	if (!$wbbuserdata['userid']) $guestname = wbb_trim($_POST['guestname']);

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
	if (isset($_POST['iconid']) && checkpermissions('can_use_post_icons') == 1) $iconid = intval($_POST['iconid']);
	else $iconid = 0;

	if (!checkpermissions('can_use_post_smilies') || $disablesmilies == 1) $allowsmilies = 0;
	else $allowsmilies = 1;

	if (!checkpermissions('can_use_post_html') || $disablehtml == 1) $allowhtml = 0;
	else $allowhtml = 1;

	if (!checkpermissions('can_use_post_bbcode') || $disablebbcode == 1) $allowbbcode = 0;
	else $allowbbcode = 1;

	if (!checkpermissions('can_use_post_images') || $disableimages == 1) $allowimages = 0;
	else $allowimages = 1;
	/* posting feature rights:end */

	/* get parent postid */
	if (isset($_POST['postid'])) $postid = intval($_POST['postid']);
	else $postid = 0;

	if (!isset($_POST['preview']) && !$_POST['change_editor']) {
		$error = '';

		/* verify guestname */
		if (!$wbbuserdata['userid']) {
			$wbbuserdata['username'] = $guestname;
			if (!$wbbuserdata['username'] || !verify_username($wbbuserdata['username'])) $error .= $lang->items['LANG_POST_ERROR2'];
		}

		/* check message */
		if (!$message) $error .= $lang->items['LANG_POSTINGS_ERROR1'];
		if (flood_control($wbbuserdata['userid'], $REMOTE_ADDR, $wbbuserdata['avoid_fc'])) error($lang->get("LANG_POST_ERROR3", array('$fctime' => $fctime)));
		if ($wbbuserdata['max_post_image'] != -1 && wbb_substr_count(wbb_strtolower($message), '[img]') > $wbbuserdata['max_post_image']) $error .= $lang->items['LANG_POST_ERROR4'];

		if ($error) eval("\$addreply_error = \"".$tpl->get("newthread_error")."\";");
		else {
			/* parse url */
			if ($parseurl == 1 && $allowbbcode == 1) $message = parseURL($message);

			/* post already exists? */
			$result = $db->query_first("SELECT postid FROM bb".$n."_posts WHERE threadid='$threadid' AND userid='$wbbuserdata[userid]' AND username='".addslashes($wbbuserdata['username'])."' AND posttopic='".addslashes($topic)."' AND posttime>='".(time() - $dpvtime)."' AND message='".addslashes($message)."'", 1);
			if ($result['postid']) {
				header("Location: thread.php?postid=".$result['postid'].$SID_ARG_2ND_UN."#post".$result['postid']);
				exit();
			}

			/* avoid moderation */
			if (checkpermissions('can_post_without_moderation') == 1) $board['moderatenew'] = 0;
			$time = time();

			/* insert post */
			$db->query("INSERT INTO bb".$n."_posts (parentpostid,threadid,userid,username,iconid,posttopic,posttime,message,attachments,allowsmilies,allowhtml,allowbbcode,allowimages,showsignature,ipaddress,visible) VALUES ".
			"('$postid','$threadid','$wbbuserdata[userid]','".addslashes($wbbuserdata['username'])."','$iconid','".addslashes($topic)."','$time','".addslashes($message)."','".count($attachmentids)."','$allowsmilies','$allowhtml','$allowbbcode','$allowimages','".$showsignature."','".addslashes($REMOTE_ADDR)."','".(($board['moderatenew'] == 1 || $board['moderatenew'] == 11) ? (0) : (1))."')");
			$postid = $db->insert_id();
			
			/* create postcache */
			$parse = &new parse($docensor, 75, 1, '', $usecode, 1, 1);
			$cache = $parse->doparse($message, $allowsmilies, $allowhtml, $allowbbcode, $allowimages);
			$db->query("REPLACE INTO bb".$n."_postcache (postid, threadid, cache) VALUES ('".$postid."', '".$threadid."', '".addslashes($cache)."')");

			/* set attachment postid */
			if (count($attachmentids)) {
				$db->unbuffered_query("UPDATE bb".$n."_attachments SET postid='$postid', idhash='' WHERE attachmentid IN (".implode(',', $attachmentids).")", 1);
				$attachmentcount = ', attachments=attachments+'.count($attachmentids);
			}
			else $attachmentcount = '';

			/* insert subscription */
			if ($emailnotify == 1 && $wbbuserdata['userid']) $db->unbuffered_query("REPLACE INTO bb".$n."_subscribethreads (userid,threadid,emailnotify,countemails) VALUES ($wbbuserdata[userid],$threadid,1,0)");

			/* wordmatch */
			wordmatch($postid, $message, $topic);

			/* mod subscriptions */
			$subscriptions = '';
			$langpacks = array();
			$langpacks[$lang->languagepackid] = $lang;
			$result = $db->query("SELECT u.userid, u.email, u.username, u.notificationperpm, l.languagepackid FROM bb".$n."_moderators m LEFT JOIN bb".$n."_users u USING(userid) LEFT JOIN bb".$n."_languagepacks l ON(l.languagepackid=u.langid) WHERE m.userid<>'$wbbuserdata[userid]' AND m.boardid ='".$boardid."' AND m.notify_newpost=1");
			while ($row = $db->fetch_array($result)) {
				$subscriptions .= ','.$row['userid'];

				if (!isset($langpacks[$row['languagepackid']])) {
					$langpacks[$row['languagepackid']] = &new language(intval($row['languagepackid']));
					$langpacks[$row['languagepackid']]->load('OWN,MAIL');
				}

				$master_board_name_email = getlangvar($o_master_board_name, $langpacks[$row['languagepackid']], 0);
				
				$mail_subject = $langpacks[$row['languagepackid']]->get("LANG_MAIL_MOD_NEWPOST_SUBJECT", array('$topic' => $thread['topic']));
				$mail_text = $langpacks[$row['languagepackid']]->get("LANG_MAIL_MOD_NEWPOST_TEXT", array('$username' => $row['username'], '$topic' => $thread['topic'], '$author' => $wbbuserdata['username'], '$url2board' => $url2board, '$postid' => $postid, '$master_board_name_email' => $master_board_name_email));
				
				// send notification (per email or pn)
				if ($row['notificationperpm'] == 0) mailer($row['email'], $mail_subject, $mail_text);
				else sendPrivateMessage(array($row['userid'] => $row['username']), array(), $mail_subject, parseURL($mail_text));
			}


			if ($board['moderatenew'] == 1 || $board['moderatenew'] == 11) redirect($lang->items['LANG_POST_REDIRECT'], "board.php?boardid=$boardid".$SID_ARG_2ND, 10);
			else {
				/* close thread option */
				if ($threadclose == 1 && (checkmodpermissions('m_can_thread_close') || ($wbbuserdata['userid'] && $wbbuserdata['userid'] == $thread['starterid'] && checkpermissions('can_close_own_topic') == 1))) $threadclose = ', closed=1';
				else $threadclose = '';

				/* update thread info */
				$db->unbuffered_query("UPDATE bb".$n."_threads SET lastposttime = '$time', lastposterid = '$wbbuserdata[userid]', lastposter = '".addslashes($wbbuserdata['username'])."', replycount = replycount+1$attachmentcount$threadclose WHERE threadid = '$threadid'", 1);
				
				/* update board info */
				$db->unbuffered_query("UPDATE bb".$n."_boards SET postcount=postcount+1, lastthreadid='$threadid', lastposttime='$time', lastposterid='$wbbuserdata[userid]', lastposter='".addslashes($wbbuserdata['username'])."' WHERE boardid IN ($board[parentlist],$boardid)", 1);

				/* update global postcount */
				$db->unbuffered_query("UPDATE bb".$n."_stats SET postcount=postcount+1", 1);

				/* update userposts & rank */
				if ($board['countuserposts'] == 1 && $wbbuserdata['userid']) {
					$wbbuserdata['userposts'] += 1;
					list($rankid) = $db->query_first("SELECT rankid FROM bb".$n."_ranks WHERE groupid IN ('0','$wbbuserdata[rankgroupid]') AND needposts<='$wbbuserdata[userposts]' AND gender IN ('0','$wbbuserdata[gender]') ORDER BY needposts DESC, gender DESC", 1);
					$db->unbuffered_query("UPDATE bb".$n."_users SET userposts=userposts+1".(($rankid != $wbbuserdata['rankid']) ? (", rankid='$rankid'") : (""))." WHERE userid = '$wbbuserdata[userid]'", 1);

					checkPosts4AI();
				}

				/* subscriptions */
				$result = $db->query("SELECT u.userid, u.email, u.username, u.notificationperpm, s.countemails, l.languagepackid FROM bb".$n."_subscribethreads s LEFT JOIN bb".$n."_users u USING(userid) LEFT JOIN bb".$n."_languagepacks l ON(l.languagepackid=u.langid) WHERE s.threadid='$threadid' AND s.userid NOT IN (".$wbbuserdata['userid'].$subscriptions.") AND s.emailnotify=1 AND s.countemails<'$maxnotifymails' AND u.email is not null");
				while ($row = $db->fetch_array($result)) {

					if (!isset($langpacks[$row['languagepackid']])) {
						$langpacks[$row['languagepackid']] = &new language(intval($row['languagepackid']));
						$langpacks[$row['languagepackid']]->load('OWN,MAIL');
					}

					$master_board_name_email = getlangvar($o_master_board_name, $langpacks[$row['languagepackid']], 0);

					$mail_subject = $langpacks[$row['languagepackid']]->get("LANG_MAIL_NEWPOST_SUBJECT", array('$topic' => $thread['topic']));
					$mail_text = $langpacks[$row['languagepackid']]->get("LANG_MAIL_NEWPOST_TEXT", array('$username' => $row['username'], '$topic' => $thread['topic'], '$author' => $wbbuserdata['username'], '$url2board' => $url2board, '$postid' => $postid, '$master_board_name_email' => $master_board_name_email));
				
					if ($row['notificationperpm'] == 0) mailer($row['email'], $mail_subject, $mail_text);
					else sendPrivateMessage(array($row['userid'] => $row['username']), array(), $mail_subject, parseURL($mail_text));
				}
				$db->unbuffered_query("UPDATE bb".$n."_subscribethreads SET countemails=countemails+1 WHERE threadid='$threadid' AND emailnotify=1 AND countemails<'$maxnotifymails'", 1);

				header("Location: thread.php?postid=$postid".$SID_ARG_2ND_UN."#post$postid");
				exit();
			}
		}
	}
	else if (!$_POST['change_editor']) {
		$parse = &new parse($docensor, 75, $wbbuserdata['showimages'], '', $usecode);
		$preview_topic = htmlconverter(textwrap($topic));
		$preview_message = $parse->doparse((($parseurl == 1 && $allowbbcode == 1) ? (parseURL($message)) : ($message)), $allowsmilies, $allowhtml, $allowbbcode, $allowimages);
		if ($iconid) {
			$result = $db->query_first("SELECT * FROM bb".$n."_icons WHERE iconid = '$iconid'");
			$preview_posticon = makeimgtag($result['iconpath'], getlangvar($result['icontitle'], $lang), 0);
		}
		else $preview_posticon = '';
		eval("\$preview_window = \"".$tpl->get("newthread_preview")."\";");
	}


	if ($parseurl == 1 && !$disablebbcode) $checked[0] = 'checked="checked"';
	else $checked[0] = '';
	if ($emailnotify == 1) $checked[1] = 'checked="checked"';
	else $checked[1] = '';
	if ($disablesmilies == 1) $checked[2] = 'checked="checked"';
	else $checked[2] = '';
	if ($disablehtml == 1) $checked[3] = 'checked="checked"';
	else $checked[3] = '';
	if ($disablebbcode == 1) $checked[4] = 'checked="checked"';
	else $checked[4] = '';
	if ($disableimages == 1) $checked[5] = 'checked="checked"';
	else $checked[5] = '';
	if ($showsignature == 1) $checked[6] = 'checked="checked"';
	else $checked[6] = '';
	if ($threadclose == 1) $checked[7] = 'checked="checked"';
	else $checked[7] = '';
}
elseif (isset($postid)) {
	if ($post['posttopic'] != '') {
		$post['posttopic'] = preg_replace('/^RE: /i', '', $post['posttopic']);
		$topic = $lang->get("LANG_POST_QUOTE_TOPIC", array('$posttopic' => $post['posttopic']));
	}
	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'quote') {
		if ($docensor == 1) {
			$parse = &new parse(1);
			$post['message'] = $parse->censor($post['message']);
		}

		$message = $lang->get("LANG_POST_QUOTE_MESSAGE", array('$username' => $post['username'], '$message' => $post['message']));
	}
}

$navbar = getNavbar($board['parentlist']);
eval("\$navbar .= \"".$tpl->get("navbar_board")."\";");

$wbbuserdata['username'] = htmlconverter($wbbuserdata['username']);

if (!isset($iconid)) $iconid = 0;
if (checkpermissions('can_use_post_icons') == 1) $newthread_icons = getIcons($iconid);
if (checkpermissions('can_use_post_bbcode') == 1 && $wbbuserdata['usewysiwyg'] != 1) $bbcode_buttons = getcodebuttons();
if (checkpermissions('can_use_post_smilies') == 1) {
	if ($wbbuserdata['usewysiwyg'] == 1) $smilies = getAppletSmilies();
	$bbcode_smilies = getclickysmilies($smilie_table_cols, $smilie_table_rows);
}

$note = '';
if (checkpermissions('can_use_post_html') == 0) $note .= $lang->items['LANG_POSTINGS_HTML_NOT_ALLOW'];
else $note .= $lang->items['LANG_POSTINGS_HTML_ALLOW'];
if (checkpermissions('can_use_post_bbcode') == 0) $note .= $lang->items['LANG_POSTINGS_BBCODE_NOT_ALLOW'];
else $note .= $lang->items['LANG_POSTINGS_BBCODE_ALLOW'];
if (checkpermissions('can_use_post_smilies') == 0) $note .= $lang->items['LANG_POSTINGS_SMILIES_NOT_ALLOW'];
else $note .= $lang->items['LANG_POSTINGS_SMILIES_ALLOW'];
if (checkpermissions('can_use_post_images') == 0) $note .= $lang->items['LANG_POSTINGS_HTML_IMAGES_ALLOW'];
else $note .= $lang->items['LANG_POSTINGS_IMAGES_ALLOW'];


$readAttachments = false;
$postids = '';
$result = $db->unbuffered_query("SELECT postid, attachments FROM bb".$n."_posts WHERE threadid = '".$threadid."' AND visible = 1 ORDER BY posttime DESC", 0, $showpostsinreply);
while ($row = $db->fetch_array($result)) {
	$postids .= ",".$row['postid'];
	if ($row['attachments']) $readAttachments = true;
}

$attachmentArray = array();
if ($readAttachments) {
	$result = $db->unbuffered_query("SELECT postid, attachmentid, attachmentname, attachmentextension, attachmentsize, counter, thumbnailextension FROM bb".$n."_attachments WHERE postid IN (0".$postids.") ORDER BY uploadtime");
	while ($row = $db->fetch_array($result)) {
		$attachmentArray[$row['postid']][$row['attachmentid']] = $row;
	}
}

$result = $db->query("SELECT p.*, pc.cache, i.* 
	FROM bb".$n."_posts p
	LEFT JOIN bb".$n."_icons i USING (iconid)
	LEFT JOIN bb".$n."_postcache pc ON (p.postid=pc.postid)
	WHERE p.postid IN (0$postids) 
	ORDER BY posttime DESC", $showpostsinreply);


$postcount = $thread['replycount'] + 1;
if ($postcount > $showpostsinreply) {
	$postcount = $showpostsinreply;
	$complete_thread = 1;
	
	$lang->items['LANG_POST_MORE_POSTS'] = $lang->get("LANG_POST_MORE_POSTS", array('$threadid' => $threadid, '$SID_ARG_2ND' => $SID_ARG_2ND));
}
else $complete_thread = 0;
$lang->items['LANG_POST_LAST_X_POSTS'] = $lang->get("LANG_POST_LAST_X_POSTS", array('$postcount' => $postcount));

$count = 0;
$postbit = '';
$parse = &new parse($docensor, 75, $wbbuserdata['showimages'], '', $usecode);
while ($posts = $db->fetch_array($result)) {
	$tdclass = getone($count, 'tableb', 'tablea');
	
	// use postcache if possible
	if ($posts['cache']) $posts['message'] = $parse->parseCache($posts['cache']);
	else $posts['message'] = $parse->doparse($posts['message'], $posts['allowsmilies'], $posts['allowhtml'], $posts['allowbbcode'], $posts['allowimages']);
	
	$posts['posttopic'] = htmlconverter(textwrap($posts['posttopic']));
	$posts['username'] = htmlconverter($posts['username']);
	$username = $posts['username'];
	
	if ($posts['iconid']) $posticon = makeimgtag($posts['iconpath'], getlangvar($posts['icontitle'], $lang), 0);
	else $posticon = '';

	// show attachments
	$attachments = '';
	$attachment_thumbnailCount = 0;
	$attachmentbit = '';
	$attachmentbit_img = '';
	$attachmentbit_img_small = '';
	$attachmentbit_img_thumbnails = '';

	if (isset($attachmentArray[$posts['postid']]) && count($attachmentArray[$posts['postid']])) {
		unset($LANG_THREAD_ATTACHMENT_IMAGE_THUMBNAIL);
		unset($LANG_THREAD_ATTACHMENT_IMAGE_SMALL);
		unset($LANG_THREAD_ATTACHMENT_IMAGE);
		unset($LANG_THREAD_ATTACHMENT);

		foreach ($attachmentArray[$posts['postid']] as $attachment) {
			$attachment['attachmentextension'] = htmlconverter($attachment['attachmentextension']);
			$attachment['attachmentname'] = htmlconverter($attachment['attachmentname']);
			
			// attachment is an image, display it directly
			if (checkpermissions('can_download_attachments') == 1 && $wbbuserdata['showimages'] == 1 && $wbbuserdata['can_download_attachments'] == 1 && ($attachment['attachmentextension'] == 'gif' || $attachment['attachmentextension'] == 'jpg' || $attachment['attachmentextension'] == 'jpeg'  || $attachment['attachmentextension'] == 'png')) {
				if ($attachment['thumbnailextension'] != '') {
					$attachment_thumbnailCount++;
					if ($attachment_thumbnailCount && ($attachment_thumbnailCount % $thumbnailsperrow) == 0) $thumbnailNewline = true;
					else $thumbnailNewline = false;
					if (!isset($LANG_THREAD_ATTACHMENT_IMAGE_THUMBNAIL)) $LANG_THREAD_ATTACHMENT_IMAGE_THUMBNAIL = $lang->get("LANG_THREAD_ATTACHMENT_IMAGE_SMALL", array('$username' => $username));
					else $LANG_THREAD_ATTACHMENT_IMAGE_THUMBNAIL = $lang->get("LANG_THREAD_ATTACHMENTS_IMAGE_SMALL", array('$username' => $username));

					eval("\$attachmentbit_img_thumbnails .= \"".$tpl->get("thread_attachmentbit_show_thumbnail")."\";");
				}
				else {
					$imgsize = @getimagesize("./attachments/attachment-$attachment[attachmentid].$attachment[attachmentextension]");
					
					if (($picmaxwidth != 0 && $imgsize[0] > $picmaxwidth) || ($picmaxheight != 0 && $imgsize[1] > $picmaxheight)) {
						if ($picmaxwidth != 0) $div1 = $picmaxwidth / $imgsize[0];
						else $div1 = 1;
						if ($picmaxheight != 0) $div2 = $picmaxheight / $imgsize[1];
						else $div2 = 1;
						
						if ($div1 < $div2) {
							$attachment['imgwidth'] = $picmaxwidth;
							$attachment['imgheight'] = round($imgsize[1] * $div1);
						}
						else {
							$attachment['imgheight'] = $picmaxheight;
							$attachment['imgwidth'] = round($imgsize[0] * $div2);	
						}

						if (!isset($LANG_THREAD_ATTACHMENT_IMAGE_SMALL)) $LANG_THREAD_ATTACHMENT_IMAGE_SMALL = $lang->get("LANG_THREAD_ATTACHMENT_IMAGE_SMALL", array('$username' => $username));
						else $LANG_THREAD_ATTACHMENT_IMAGE_SMALL = $lang->get("LANG_THREAD_ATTACHMENTS_IMAGE_SMALL", array('$username' => $username));
						
						eval("\$attachmentbit_img_small .= \"".$tpl->get("thread_attachmentbit_show_small")."\";");
					}
					else {
						if (!isset($LANG_THREAD_ATTACHMENT_IMAGE)) $LANG_THREAD_ATTACHMENT_IMAGE = $lang->get("LANG_THREAD_ATTACHMENT_IMAGE", array('$username' => $username));
						else $LANG_THREAD_ATTACHMENT_IMAGE = $lang->get("LANG_THREAD_ATTACHMENTS_IMAGE", array('$username' => $username));

						eval("\$attachmentbit_img .= \"".$tpl->get("thread_attachmentbit_show")."\";");
					}
				}
			}
			else {
				if (!file_exists($style['imagefolder']."/filetypes/".$attachment['attachmentextension'].".gif")) $extensionimage = "unknown";
				else $extensionimage = $attachment['attachmentextension'];
				if ($attachment['counter'] >= 1000) $attachment['counter'] = number_format($attachment['counter'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP")); 
				$attachment['attachmentsize'] = formatFilesize($attachment['attachmentsize']);
				$LANG_THREAD_ATTACHMENT_INFO = $lang->get("LANG_THREAD_ATTACHMENT_INFO", array('$attachmentsize' => $attachment['attachmentsize'], '$counter' => $attachment['counter']));
				if (!isset($LANG_THREAD_ATTACHMENT)) $LANG_THREAD_ATTACHMENT = $lang->get('LANG_THREAD_ATTACHMENT');
				else  $LANG_THREAD_ATTACHMENT = $lang->get('LANG_THREAD_ATTACHMENTS');

				eval("\$attachmentbit .= \"".$tpl->get("thread_attachmentbit")."\";");
			}				
		}
		eval("\$attachments = \"".$tpl->get("thread_attachments")."\";");
	}


	eval("\$postbit .= \"".$tpl->get("addreply_postbit")."\";");
	$count++;
}

if (!isset($idhash)) $idhash = md5($wbbuserdata['userid'].'|'.$threadid.'|'.time());
else $idhash = htmlconverter($idhash);
if (checkpermissions('can_upload_attachments') == 1) {
	if (isset($attachmentids) && is_array($attachmentids)) $attachmentids = implode(',', $attachmentids);
	else $attachmentids = '';
	
	eval("\$attachment = \"".$tpl->get("newthread_attachment")."\";");
}
else $attachment = '';

if (isset($message)) $message = htmlconverter($message);
elseif ($board['posttemplateuse'] > 0) {
	if ($board['posttemplateuse'] == 1) $posttemplate = $default_posttemplate;
	if ($board['posttemplateuse'] == 2) $posttemplate = $board['posttemplate'];
	$message = getlangvar($posttemplate, $lang);
}
if (isset($topic)) $topic = htmlconverter($topic);
if (isset($guestname)) $guestname = htmlconverter($guestname);

eval("\$newthread_username = \"".$tpl->get("newthread_username")."\";");
$thread['topic'] = htmlconverter(textwrap($thread['topic']));

eval("\$headinclude .= \"".$tpl->get("bbcode_script")."\";");
eval("\$editor = \"".$tpl->get("editor")."\";");
eval("\$editor_switch = \"".$tpl->get("editor_switch")."\";");
eval("\$tpl->output(\"".$tpl->get("addreply")."\");");
?>
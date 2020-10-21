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
// * $Date: 2005-02-07 16:34:44 +0100 (Mon, 07 Feb 2005) $
// * $Author: Burntime $
// * $Rev: 1550 $
// ************************************************************************************//


$filename = 'editpost.php';

require('./global.php');
require('./acp/lib/class_parse.php');
require('./acp/lib/class_parsecode.php');
$lang->load('POST,POSTINGS');

if (!isset($postid)) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));

$isuser = 0;
$ismod = 0;
if ($wbbuserdata['userid'] && $wbbuserdata['userid'] == $post['userid']) $isuser = 1;
if (checkmodpermissions('m_can_post_del') == 1 || checkmodpermissions('m_can_post_edit') == 1) $ismod = 1;

if (($isuser == 0 || (!checkpermissions('can_edit_own_post') && !checkpermissions('can_del_own_post')) || $thread['closed'] != 0) && $ismod == 0) access_error();

if ($ismod == 0 && $wbbuserdata['edit_posttime_limit'] != -1 && (time() - $post['posttime']) > $wbbuserdata['edit_posttime_limit'] * 60) {
	error($lang->get("LANG_POST_EDITERROR1", array('$edit_posttime_limit' => $wbbuserdata['edit_posttime_limit'])));
	
}

$preview_window = '';
$editpost_error = '';

/* delete post */
if (isset($_POST['send']) && $_POST['send'] == 'send2') {
	if ($_POST['deletepost'] == 1) {
		if (($isuser == 1 && $wbbuserdata['can_del_own_post'] == 1) || checkmodpermissions("m_can_post_del")) {
			if ($post['postid']) {
				$db->query("DELETE FROM bb".$n."_posts WHERE postid = '$postid'");
				$db->query("DELETE FROM bb".$n."_postcache WHERE postid = '$postid'");
				if ($thread['replycount'] == 0) {
					/* delete post & thread */
					if ($thread['visible'] == 1 && $post['visible'] == 1) $db->unbuffered_query("UPDATE bb".$n."_boards SET threadcount=threadcount-1, postcount=postcount-1 WHERE boardid IN ($boardid,$board[parentlist])", 1);
					$db->unbuffered_query("DELETE FROM bb".$n."_subscribethreads WHERE threadid = '$threadid'", 1);
					if ($thread['pollid']) {
						$db->unbuffered_query("DELETE FROM bb".$n."_polls WHERE pollid = '$thread[pollid]'", 1);
						$pollvotes = " OR (id = '$thread[pollid]' AND votemode=1)";
						$db->unbuffered_query("DELETE FROM bb".$n."_polloptions WHERE pollid = '$thread[pollid]'", 1);
					}
					else $pollvotes = '';
					$db->unbuffered_query("DELETE FROM bb".$n."_votes WHERE (id = '$threadid' AND votemode=2)$pollvotes", 1);
					
					$db->unbuffered_query("DELETE FROM bb".$n."_threads WHERE threadid = '$threadid'", 1);
					$db->unbuffered_query("DELETE FROM bb".$n."_threads WHERE pollid = '$threadid' AND closed=3", 1);
					if ($thread['important'] == 2) $db->unbuffered_query("DELETE FROM bb".$n."_announcements WHERE threadid = '$threadid'", 1);
					
					/* update global threadcount & postcount */
					if ($thread['visible'] == 1 && $post['visible'] == 1) $db->unbuffered_query("UPDATE bb".$n."_stats SET threadcount=threadcount-1, postcount=postcount-1", 1);
				}
				else {
					/* delete only post */
					
					/* for threaded view -> */
					$db->unbuffered_query("UPDATE bb".$n."_posts SET parentpostid = '$post[parentpostid]' WHERE threadid = '".$threadid."' AND parentpostid = '$postid'", 1);
					
					if ($post['visible'] == 1) {
						$db->unbuffered_query("UPDATE bb".$n."_boards SET postcount=postcount-1 WHERE boardid IN ($boardid,$board[parentlist])", 1);
						if ($thread['lastposttime'] <= $post['posttime']) {
							$result = $db->query_first("SELECT userid, username, posttime FROM bb".$n."_posts WHERE threadid='$threadid' AND visible = '1' ORDER BY posttime DESC", 1);
							$db->unbuffered_query("UPDATE bb".$n."_threads SET replycount=replycount-1, lastposttime='$result[posttime]', lastposterid='$result[userid]', lastposter='".addslashes($result['username'])."'".(($post['attachments']) ? (", attachments=attachments-".$post['attachments']) : (""))." WHERE threadid='$threadid'", 1);
						}
						else {
							$db->unbuffered_query("UPDATE bb".$n."_threads SET replycount=replycount-1".(($post['attachments']) ? (", attachments=attachments-".$post['attachments']) : (""))." WHERE threadid='$threadid'", 1);
						}
						
						/* update global postcount */
						$db->unbuffered_query("UPDATE bb".$n."_stats SET postcount=postcount-1", 1);
					}
				}
				
				updateBoardInfo("$boardid,$board[parentlist]", $post['posttime']);
				
				if ($post['attachments']) {
					$attachments = $db->query("SELECT attachmentid, attachmentextension, thumbnailextension FROM bb".$n."_attachments WHERE postid = '".$post['postid']."'");
					while ($row = $db->fetch_array($attachments)) {
						@unlink("attachments/attachment-".$row['attachmentid'].".".$row['attachmentextension']);
						@unlink("attachments/thumbnail-".$row['attachmentid'].".".$row['thumbnailextension']);
					}
					$db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE postid = '".$post['postid']."'", 1);
				}
				if ($board['countuserposts'] && $post['userid'] && $post['visible'] == 1) $db->unbuffered_query("UPDATE bb".$n."_users SET userposts=userposts-1 WHERE userid = '$post[userid]'", 1);
				if ($thread['replycount'] == 0) header("Location: board.php?boardid=$boardid".$SID_ARG_2ND_UN);
				else header("Location: thread.php?threadid=$threadid".$SID_ARG_2ND_UN);
				exit();
			}
		}
		else access_error();
	}
	else {
		header("Location: thread.php?postid=$postid".$SID_ARG_2ND_UN."#post$postid");
		exit();	
	}
}

if ($editpost_default_checked_0 == 1) $checked[0] = 'checked="checked"';
else $checked[0] = '';
if ($wbbuserdata['emailnotify'] == 1) $checked[1] = 'checked="checked"';
else $checked[1] = '';

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
	if (isset($_POST['dont_append_editnote'])) $dont_append_editnote = intval($_POST['dont_append_editnote']);
	else $dont_append_editnote = 0;
	
	/* get topic & stop shooting */
	$topic = wbb_trim($_POST['topic']);
	if ($dostopshooting == 1) $topic = stopShooting($topic);
	
	/* get message & strip crap */
	$message = stripcrap(wbb_trim($_POST['message']));
	if (wbb_strlen($message) > $postmaxchars) $message = wbb_substr($message, 0, $postmaxchars);
 
	/* check attachmentids:start */
	if (checkpermissions('can_upload_attachments') == 1) {
		if (isset($_POST['attachmentids']) && $_POST['attachmentids'] != '') {
			$attachmentids = intval_array(explode(',', $_POST['attachmentids']));
			$attachment_verify = $db->query("SELECT * FROM bb".$n."_attachments WHERE attachmentid IN (".implode(',', $attachmentids).") AND postid='$postid'");
			$attachmentids = array();
			while ($row = $db->fetch_array($attachment_verify)) {
				$attachmentids[] = $row['attachmentid'];
			}
		}
		else {
			// read attachments from database (for users without javascript)
			$attachment_verify = $db->query("SELECT * FROM bb".$n."_attachments WHERE postid='$postid'");
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
	
	if (!checkpermissions("can_use_post_smilies") || $disablesmilies == 1) $allowsmilies = 0;
	else $allowsmilies = 1;	
	
	if (!checkpermissions("can_use_post_html") || $disablehtml == 1) $allowhtml = 0;
	else $allowhtml = 1;	
	
	if (!checkpermissions("can_use_post_bbcode") || $disablebbcode == 1) $allowbbcode = 0;
	else $allowbbcode = 1;	
	
	if (!checkpermissions("can_use_post_images") || $disableimages == 1) $allowimages = 0;
	else $allowimages = 1;	
	/* posting feature rights:end */
 
	if (!isset($_POST['preview']) && !$_POST['change_editor']) { 
		$error = '';
		
		/* check message */
		if (!$message) $error .= $lang->items['LANG_POSTINGS_ERROR1'];
		if ($wbbuserdata['max_post_image'] != -1 && wbb_substr_count(wbb_strtolower($message), "[img]") > $wbbuserdata['max_post_image']) $error .= $lang->items['LANG_POST_ERROR4'];
		
		if ($error) eval("\$editpost_error .= \"".$tpl->get("newthread_error")."\";");
		else {
			/* parse url */
			if ($parseurl == 1 && $allowbbcode == 1) $message = parseURL($message);
			
			/* update posts */
			$db->query("UPDATE bb".$n."_posts SET iconid='$iconid', posttopic='".addslashes($topic)."', message='".addslashes($message)."', ".(($dont_append_editnote == 0) ? ("edittime='".time()."', editorid='$wbbuserdata[userid]', editor='".addslashes($wbbuserdata['username'])."', editcount=editcount+1, ") : (""))."allowsmilies='$allowsmilies', allowhtml='$allowhtml', allowbbcode='$allowbbcode', allowimages='$allowimages', showsignature='".$showsignature."', attachments='".count($attachmentids)."', reindex='1' WHERE postid='$postid'");
			
			/* update search index */
			wordmatch($postid, $message, $topic);
			
			/* create postcache */
			$parse = &new parse($docensor, 75, 1, '', $usecode, 1, 1);
			$cache = $parse->doparse($message, $allowsmilies, $allowhtml, $allowbbcode, $allowimages);
			$db->query("REPLACE INTO bb".$n."_postcache (postid, threadid, cache) VALUES ('".$postid."', '".$threadid."', '".addslashes($cache)."')");

			
			/* update thread */
			if ($post['posttime'] == $thread['starttime']) $db->query("UPDATE bb".$n."_threads SET iconid='$iconid'".(($topic != '') ? (", topic='".addslashes($topic)."'") : (""))." WHERE threadid='$threadid'");
			
			/* update thread attachmentcount */
			if (count($attachmentids) > $post['attachments']) $db->query("UPDATE bb".$n."_threads SET attachments=attachments+".(count($attachmentids) - $post['attachments'])." WHERE threadid='$threadid'");
			elseif (count($attachmentids) < $post['attachments']) $db->query("UPDATE bb".$n."_threads SET attachments=attachments-".($post['attachments'] - count($attachmentids))." WHERE threadid='$threadid'");
			
			/* update subscription */
			if ($wbbuserdata['userid']) {   
				if ($emailnotify == 1) {
					$result = $db->query_first("SELECT userid, emailnotify FROM bb".$n."_subscribethreads WHERE userid='$wbbuserdata[userid]' AND threadid='$threadid'");
					if (!$result['userid']) $db->query("INSERT INTO bb".$n."_subscribethreads (userid,threadid,emailnotify,countemails) VALUES ($wbbuserdata[userid],$threadid,1,0)");
					elseif ($result['emailnotify'] == 0) $db->query("UPDATE bb".$n."_subscribethreads SET emailnotify=1 WHERE userid='$wbbuserdata[userid]' AND threadid='$threadid'");
				}
				else $db->query("DELETE FROM bb".$n."_subscribethreads WHERE userid='$wbbuserdata[userid]' AND threadid='$threadid'");
			}
			
			header("Location: thread.php?postid=$postid".$SID_ARG_2ND_UN."#post$postid");
			exit();
		}
	}
	else if (!$_POST['change_editor']) {
		$parse = &new parse($docensor, 75, $wbbuserdata['showimages'], "", $usecode);
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
	if ($dont_append_editnote == 1) $checked[7] = 'checked="checked"';
	else $checked[7] = '';
}
else {
	$message = $post['message'];
	$topic = $post['posttopic'];
	$iconid = $post['iconid'];
	
	$disablesmilies = 1 - $post['allowsmilies'];
	$disablehtml = 1 - $post['allowhtml'];
	$disablebbcode = 1 - $post['allowbbcode'];
	$disableimages = 1 - $post['allowimages'];
	$showsignature = $post['showsignature'];
	
	if ($wbbuserdata['userid']) list($emailnotify) = $db->query_first("SELECT emailnotify FROM bb".$n."_subscribethreads WHERE userid='".$wbbuserdata['userid']."' AND threadid='".$threadid."'");
	else $emailnotify = 0; 
	
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
	if ($wbbuserdata['dont_append_editnote'] == 1) $checked[7] = 'checked="checked"';
	else $checked[7] = '';
	
	if ($post['attachments']) {
		$attachmentids = array();
		$result = $db->query("SELECT attachmentid FROM bb".$n."_attachments WHERE postid='$postid'");
		while ($row = $db->fetch_array($result)) {
			$attachmentids[] = $row['attachmentid'];
		}
	}
}

$navbar = getNavbar($board['parentlist']);
eval("\$navbar .= \"".$tpl->get("navbar_board")."\";");

$wbbuserdata['username'] = htmlconverter($wbbuserdata['username']);
eval("\$newthread_username = \"".$tpl->get("newthread_username")."\";");

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

$idhash = '';
if (checkpermissions('can_upload_attachments') == 1) {
	if (isset($attachmentids) && is_array($attachmentids)) $attachmentids = implode(',', $attachmentids);
	else $attachmentids = '';
	
	eval("\$attachment = \"".$tpl->get("newthread_attachment")."\";");
}
else $attachment = '';

if (isset($message)) $message = htmlconverter($message);
if (isset($topic)) $topic = htmlconverter($topic);

$thread['topic'] = htmlconverter(textwrap($thread['topic']));

eval("\$headinclude .= \"".$tpl->get("bbcode_script")."\";");
eval("\$editor = \"".$tpl->get("editor")."\";");
eval("\$editor_switch = \"".$tpl->get("editor_switch")."\";");
eval("\$tpl->output(\"".$tpl->get("editpost")."\");");
?>
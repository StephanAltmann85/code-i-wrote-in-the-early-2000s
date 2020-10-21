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
// * $Date: 2005-02-24 14:25:32 +0100 (Thu, 24 Feb 2005) $
// * $Author: Burntime $
// * $Rev: 1557 $
// ************************************************************************************//


$filename = 'formmail.php';

require('./global.php');
$lang->load("MISC,POSTINGS");

if ($turnoff_formmail == 1 || !$wbbuserdata['userid'] || $wbbuserdata['activation'] != 1) access_error();

if (isset($_POST['send'])) {
	if (isset($_POST['userid'])) {
		$user = $db->query_first("SELECT email FROM bb".$n."_users WHERE userid='".intval($_POST['userid'])."' AND usercanemail = 1");
		if (!$user['email']) access_error();
		$recipient = $user['email'];
	}
	else $recipient = wbb_trim($_POST['recipient']);
	
	$message = wbb_trim($_POST['message']);
 	if (!$message) error($lang->items['LANG_POSTINGS_ERROR1']);
	if (!$recipient) error($lang->items['LANG_MISC_FORMMAIL_ERROR1']);
	mailer($recipient, wbb_trim($_POST['subject']), $message, $wbbuserdata['email']);
	redirect($lang->get("LANG_MISC_FORMMAIL_REDIRECT"), "index.php".$SID_ARG_1ST, 5);
}

if (isset($_GET['userid'])) {
	$userid = intval($_GET['userid']);
	
	$user = $db->query_first("SELECT username FROM bb".$n."_users WHERE userid='".$userid."' AND usercanemail = 1");
	if (!$user['username']) access_error();
	$recipientName = htmlconverter($user['username']);	
}
else $userid = 0;

if (isset($threadid)) {
	$subject = htmlconverter($thread['topic']);
	$wbbuserdata['username'] = htmlconverter($wbbuserdata['username']);
	$message = $lang->get("LANG_MISC_FORMMAIL_TOFRIEND", array('$url2board' => $url2board, '$threadid' => $threadid, '$username' => $wbbuserdata['username']));
}
eval("\$tpl->output(\"".$tpl->get("formmail")."\");");
?>
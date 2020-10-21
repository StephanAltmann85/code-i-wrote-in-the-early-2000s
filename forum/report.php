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


$filename = 'report.php';
require('./global.php');
require('./acp/lib/class_parse.php');
require('./acp/lib/class_parsecode.php');
$lang->load('MISC,POSTINGS');

if (!$wbbuserdata['userid']) access_error();
if (!isset($postid)) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));

if (isset($_POST['send'])) {
	$lang->load('MAIL');
	$reason = wbb_trim($_POST['reason']);
	$mod = $db->query_first("SELECT userid, email, username, notificationperpm, languagepackid FROM bb".$n."_users LEFT JOIN bb".$n."_languagepacks ON (languagepackid=langid) WHERE userid='".intval($_POST['modid'])."'");
	
	if ($mod['languagepackid'] == $lang->languagepackid) $userlang = $lang;
	else {     
		$userlang = &new language(intval($mod['languagepackid']));
		$userlang->load('OWN,MAIL');
	}
	
	$master_board_name_email = getlangvar($o_master_board_name, $userlang, 0);
	
	$mail_text = $userlang->get("LANG_MAIL_REPORT_TEXT", array('$mod' => $mod['username'], '$username' => $wbbuserdata['username'], '$author' => $post['username'], '$url2board' => $url2board, '$postid' => $post['postid'], '$reason' => $reason, '$master_board_name_email' => $master_board_name_email));
	$mail_subject = $userlang->get("LANG_MAIL_REPORT_SUBJECT", array('$author' => $post['username']));
	if ($mod['notificationperpm'] == 0) mailer($mod['email'], $mail_subject, $mail_text);
	else sendPrivateMessage(array($mod['userid'] => $mod['username']), array(), $mail_subject, parseURL($mail_text));
	
	header("Location: thread.php?postid=$postid".$SID_ARG_2ND_UN."#post$postid");
	exit();	
}

$mod_options = '';
$result = $db->unbuffered_query("SELECT m.userid, u.username FROM bb".$n."_moderators m LEFT JOIN bb".$n."_users u USING (userid) WHERE boardid='".$boardid."' ORDER BY username ASC");
while ($row = $db->fetch_array($result)) $mod_options .= makeoption($row['userid'], htmlconverter($row['username']), "", 0);

if ($mod_options == '') {
	$groupcombinations = getUserByGroupcombination(array("m_is_supermod" => 1));	
	$result = $db->unbuffered_query("SELECT userid, username FROM bb".$n."_users WHERE groupcombinationid IN (0".$groupcombinations.") ORDER BY username ASC");
	while ($row = $db->fetch_array($result)) $mod_options .= makeoption($row['userid'], htmlconverter($row['username']), "", 0);
}

eval("\$tpl->output(\"".$tpl->get("report")."\");");
?>
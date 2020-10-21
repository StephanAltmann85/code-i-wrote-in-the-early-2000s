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


$filename = 'forgotpw.php';

require('./global.php');
$lang->load('USERCP,MAIL');

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = '';




if (!$action) {
	if (isset($_POST['send'])) {
		$result = $db->query_first("SELECT userid, username, email, password FROM bb".$n."_users WHERE username='".addslashes(wbb_trim($_POST['username']))."'");
		if (!$result['userid']) error($lang->items['LANG_USERCP_ERROR1']);
		
		$pwhash = md5($result['password']);
		
		$master_board_name_email = getlangvar($o_master_board_name, $lang, 0);
		
		
		$message = $lang->get("LANG_MAIL_FORGOTPW_TEXT_1", array('$username' => $result['username'], '$url2board' => $url2board, '$userid' => $result['userid'], '$pwhash' => $pwhash, '$master_board_name_email' => $master_board_name_email));
		$subject = $lang->get("LANG_MAIL_FORGOTPW_SUBJECT_1", array('$master_board_name_email' => $master_board_name_email));
		mailer($result['email'], $subject, $message);
		redirect($lang->get("LANG_USERCP_FORGOTPW_REDIRECT_1"), "index.php".$SID_ARG_1ST, 10);
	}	
	
	eval("\$tpl->output(\"".$tpl->get("forgotpw")."\");");	
}





if ($action == 'pw') {
	$result = $db->query_first("SELECT userid, username, email, password FROM bb".$n."_users WHERE userid='".intval($_REQUEST['userid'])."'");
	if (!$result['userid']) error($lang->items['LANG_USERCP_ERROR8']);
	if ($_REQUEST['pwhash'] != md5($result['password'])) error($lang->items['LANG_USERCP_ERROR10']);
	
	$newpw = password_generate(2, 8);
	$db->unbuffered_query("UPDATE bb".$n."_users SET password='".md5($newpw)."', sha1_password='".sha1($newpw)."' WHERE userid='".intval($_REQUEST['userid'])."'", 1);
	
	$master_board_name_email = getlangvar($o_master_board_name, $lang, 0);
	
	$message = $lang->get("LANG_MAIL_FORGOTPW_TEXT_2", array('$username' => $result['username'],  '$newpw' => $newpw, '$master_board_name_email' => $master_board_name_email));
	$subject = $lang->get("LANG_MAIL_FORGOTPW_SUBJECT_2", array('$master_board_name_email' => $master_board_name_email));
	mailer($result['email'], $subject, $message);
	redirect($lang->get("LANG_USERCP_FORGOTPW_REDIRECT_2"), "index.php".$SID_ARG_1ST, 10);
}
?>
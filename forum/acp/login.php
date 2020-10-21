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


define("WBB_ACP_LOGIN", true);
require("./global.php");

$result = getwbbuserdata($_POST['l_username'], "username");
if ($allowloginencryption == 1 && $_POST['crypted'] == "true" && $result['sha1_password']) {
	$authentificationcode = sha1(sha1($adminsession->authentificationcode).$result['sha1_password']);
	if (!$result['userid'] || $authentificationcode != $_POST['authentificationcode']) {
		unset($result);
		unset($authentificationcode);
	}
	
	// delete authentificatincode
	$db->unbuffered_query("DELETE FROM bb".$n."_adminsessions WHERE sessionhash='$session[hash]'");
	unset($adminsession);
}
else {
	$wbb_userpassword = md5($_POST['l_password']);
	if (!$result['userid'] || $result['password'] != $wbb_userpassword) unset($result);
	else {
		if (!$result['sha1_password']) $db->unbuffered_query("UPDATE bb".$n."_users SET sha1_password='".sha1($_POST['l_password'])."' WHERE userid='$result[userid]'");
	}
}


if (isset($result) && $result['userid'] && $result['a_can_use_acp'] == 1) {
	$adminsession = new adminsession();
	$adminsession->create($result['userid'], $REMOTE_ADDR, $HTTP_USER_AGENT);
	header("Location: index.php?sid=".$adminsession->hash . ((isset($_REQUEST['url'])) ? ("&url=".urlencode($_REQUEST['url'])) : ("")));
	exit;
}
else acp_error($lang->get("LANG_ACP_GLOBAL_ERROR_LOGIN"));
?>
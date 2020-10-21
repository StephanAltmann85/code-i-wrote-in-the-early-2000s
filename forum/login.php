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


$filename = 'login.php';
require('./global.php');
$lang->load('USERCP');

if ($wbbuserdata['userid']) access_error();

if (isset($_POST['send'])) {
	$result = getwbbuserdata($_POST['l_username'], "username");
	if ($allowloginencryption == 1 && $_POST['crypted'] == "true" && $result['sha1_password']) {
		$authentificationcode = sha1(sha1($session['authentificationcode']).$result['sha1_password']);
		if (!$result['userid'] || $authentificationcode != $_POST['authentificationcode']) {
			unset($result);
			unset($authentificationcode);
		}
		else $wbb_userpassword = $result['password'];
	}
	else {
		$wbb_userpassword = md5($_POST['l_password']);
		if (!$result['userid'] || $result['password'] != $wbb_userpassword) unset($result);
		else {
			if (!$result['sha1_password']) $db->unbuffered_query("UPDATE bb".$n."_users SET sha1_password='".sha1($_POST['l_password'])."' WHERE userid='$result[userid]'");
		}
	}
	
	if (isSet($result['userid']) && $result['userid']) {
		$wbb_username = htmlconverter($result['username']);
		if ($result['usecookies'] == 1) {
			bbcookie("userid", "$result[userid]", time() + 3600 * 24 * 365);
			bbcookie("userpassword", "$wbb_userpassword", time() + 3600 * 24 * 365);
		}
		$db->unbuffered_query("DELETE FROM bb".$n."_sessions WHERE userid = '$result[userid]'", 1);
		$db->unbuffered_query("UPDATE bb".$n."_sessions SET userid = '$result[userid]', authentificationcode='', styleid='".$result['styleid']."' WHERE sessionhash = '$sid'", 1); 
		unset($session['authentificationcode']);
		
		/** convert url -> remove session hash **/
		function convert_url($url, $hash) {
 			return preg_replace("/[0-9a-z]{32}/", (($hash != '') ? ($hash) : ("")), $url);
		} 
				
		if (isset($_POST['url']) && $_POST['url'] && strstr($_POST['url'], "?")) $url = convert_url($_POST['url'], $session['hash']);
		else $url = "index.php" . $SID_ARG_1ST;
		
		redirect($lang->get("LANG_USERCP_LOGIN_REDIRECT", array('$wbb_username' => $wbb_username)), $url);
		exit;
	}
	else {
		$db->unbuffered_query("UPDATE bb".$n."_sessions SET authentificationcode='' WHERE sessionhash = '$sid'", 1);
		unset($session['authentificationcode']);
		error($lang->items['LANG_USERCP_LOGIN_ERROR']);
	}
}
else {
	eval("\$tpl->output(\"".$tpl->get("login")."\");"); 
}
?>
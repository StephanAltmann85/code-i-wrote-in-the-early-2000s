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


define('WBB_ACP_LOGIN', true);
require('./global.php');

if (isset($_REQUEST['url'])) $url = htmlconverter($_REQUEST['url']);
else $url = '';

if (!$wbbuserdata['a_can_use_acp']) {
	if (isset($_COOKIE[$cookieprefix.'userid'])) {
		list($l_username) = $db->query_first("SELECT username FROM bb".$n."_users WHERE userid='".intval($_COOKIE[$cookieprefix.'userid'])."'"); 
		$l_username = htmlconverter($l_username);
	}
	else $l_username = '';
	
	if ($allowloginencryption == 1) {
		$authentificationcode = makeAuthentificationcode(0);
		$adminsession = new adminsession();
		$adminsession->create($result['userid'], $REMOTE_ADDR, $HTTP_USER_AGENT, $authentificationcode);
		$session['hash'] = $adminsession->hash;
	}
	
	eval("\$tpl->output(\"".$tpl->get("login", 1)."\",1);");
	exit();
}

eval("\$tpl->output(\"".$tpl->get("frameset", 1)."\",1);");
?>
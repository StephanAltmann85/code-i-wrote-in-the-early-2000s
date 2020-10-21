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


$filename = 'logout.php';

require('./global.php');
if (!$wbbuserdata['userid']) access_error();

$lang->load('USERCP');

$db->unbuffered_query("UPDATE bb".$n."_users SET lastvisit=".$wbbuserdata['lastactivity'].", lastactivity = '".time()."' WHERE userid = '$wbbuserdata[userid]'", 1);

bbcookie('userid', '', 0);
bbcookie('userpassword', '', 0);
bbcookie('boardpasswords', '', 0);
bbcookie('hidecats', '', 0);

$db->query("UPDATE bb".$n."_sessions SET userid = '0', styleid='0' WHERE sessionhash = '$sid'"); 
redirect($lang->get("LANG_USERCP_LOGOUT_REDIRECT", array('$usercbar_username' => $usercbar_username)), "index.php".$SID_ARG_1ST);
?>
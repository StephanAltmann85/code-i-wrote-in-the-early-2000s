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


$filename = 'markread.php';

require('./global.php');

if (isset($boardid)) {
	if ($wbbuserdata['userid'] && $board['lastposttime'] > $wbbuserdata['lastvisit']) {
		$db->unbuffered_query("REPLACE INTO bb".$n."_boardvisit (boardid,userid,lastvisit) VALUES ('".$boardid."','".$wbbuserdata['userid']."','".time()."')");
	}
}
else {
	if ($wbbuserdata['userid']) {
		$db->query("UPDATE bb".$n."_users SET lastvisit='".time()."' WHERE userid = '$wbbuserdata[userid]'"); 
		sessionupdate();
	}
	else bbcookie('lastvisit', time(), 0);
}
if (isset($boardid)) header("Location: board.php?boardid=$boardid" . $SID_ARG_2ND_UN);
else header("Location: index.php".$SID_ARG_1ST);
?>
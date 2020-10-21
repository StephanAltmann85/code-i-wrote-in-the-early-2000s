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


$filename = 'threadrating.php';

require('./global.php');
$lang->load('MISC');

if (!isset($threadid)) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK"));
if (!checkpermissions("can_rate_thread") || $board['allowratings'] == 0) access_error();
$rating = intval($_POST['rating']);
if ($rating < 1 || $rating > 10) error($lang->get("LANG_MISC_THREADRATING_ERROR1"));

$dorate = 0;
if ($wbbuserdata['userid']) {
	$result = $db->query_first("SELECT id AS threadid FROM bb".$n."_votes WHERE id='$threadid' AND votemode=2 AND userid='$wbbuserdata[userid]'");
	if (!$result[0]) $dorate = 1;
}
else {
	$result = $db->query_first("SELECT id AS threadid FROM bb".$n."_votes WHERE id='$threadid' AND votemode=2 AND ipaddress='".addslashes($REMOTE_ADDR)."'");
	if (!$result[0]) $dorate = 1;
}

if ($dorate == 1) {
	$db->unbuffered_query("UPDATE bb".$n."_threads SET voted=voted+1, votepoints=votepoints+$rating WHERE threadid='$threadid'", 1);
	$db->unbuffered_query("INSERT INTO bb".$n."_votes (id,votemode,userid,ipaddress) VALUES ('$threadid','2','$wbbuserdata[userid]','".addslashes($REMOTE_ADDR)."')", 1);
	header("Location: thread.php?threadid=$threadid&page=".intval($_REQUEST['page']).$SID_ARG_2ND_UN);
}
else error($lang->get("LANG_MISC_THREADRATING_ERROR2"));
?>
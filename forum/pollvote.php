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


$filename = 'pollvote.php';
require('./global.php');
$lang->load('MISC');

if (!isset($pollid)) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
if (!checkpermissions("can_vote_poll")) access_error();
if (!count($_POST['polloptionid'])) error($lang->get("LANG_MISC_POLLVOTE_ERROR1"));
if ($poll['timeout'] && time() > $poll['starttime'] + $poll['timeout'] * 86400) error($lang->get("LANG_MISC_POLLVOTE_ERROR2"));
if (count($_POST['polloptionid']) > $poll['choicecount']) error($lang->get("LANG_MISC_POLLVOTE_ERROR3", array('$choicecount' => $poll['choicecount'])));
if ($wbbuserdata['userid']) $votecheck = $db->query_first("SELECT id AS pollid FROM bb".$n."_votes WHERE id='$pollid' AND votemode='1' AND userid='$wbbuserdata[userid]'");
else $votecheck = $db->query_first("SELECT id AS pollid FROM bb".$n."_votes WHERE id='$pollid' AND votemode='1' AND ipaddress='".addslashes($REMOTE_ADDR)."'");
if ($votecheck['pollid']) error($lang->get("LANG_MISC_POLLVOTE_ERROR4"));

$db->query("INSERT INTO bb".$n."_votes (id,votemode,userid,ipaddress) VALUES ('$pollid','1','$wbbuserdata[userid]','".addslashes($REMOTE_ADDR)."')");
$polloptionsids = implode(",", $_POST['polloptionid']);
$polloptionsids = preg_replace("/[^0-9,]/", "", $polloptionsids);
$db->query("UPDATE bb".$n."_polloptions SET votes=votes+1 WHERE polloptionid IN ($polloptionsids)");
header("Location: thread.php?threadid=".$poll['threadid'].$SID_ARG_2ND_UN);
exit();
?>
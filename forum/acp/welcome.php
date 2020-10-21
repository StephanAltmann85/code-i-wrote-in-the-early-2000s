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
// * $Date: 2004-10-20 20:57:36 +0200 (Wed, 20 Oct 2004) $
// * $Author: Burntime $
// * $Rev: 1455 $
// ************************************************************************************//


require('./global.php');
$lang->load('ACP_WELCOME');

// delete old sessions and searchrequests
$db->unbuffered_query("DELETE FROM bb".$n."_sessions WHERE lastactivity<".(time() - $sessiontimeout), 1);
$db->unbuffered_query("DELETE FROM bb".$n."_searchs WHERE searchtime<".(time() - 86400 * 7), 1);

// delete attachments without relation
$result = $db->query("SELECT attachmentid, attachmentextension, thumbnailextension FROM bb".$n."_attachments WHERE postid=0 AND privatemessageid=0 AND uploadtime>0 AND uploadtime<".(time() - 86400));
while ($row = $db->fetch_array($result)) {
	@unlink('./../attachments/attachment-'.$row['attachmentid'].'.'.$row['attachmentextension']);
	@unlink('./../attachments/thumbnail-'.$row['attachmentid'].'.'.$row['thumbnailextension']);
}
$db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE postid=0 AND privatemessageid=0 AND uploadtime>0 AND uploadtime<".(time() - 86400), 1);



/** prepare stats **/
$install_date = formatdate($wbbuserdata['dateformat']." ".$wbbuserdata['timeformat'], $installdate);

$stats = $db->query_first("SELECT * FROM bb".$n."_stats");
list($useronlinecount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_sessions WHERE lastactivity >= '".(time() - 60 * $useronlinetimeout)."'");
list($pncount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_privatemessage");

$attachmentinfo = $db->query_first("SELECT COUNT(*) AS attachmentcount, (SUM(attachmentsize) + SUM(thumbnailsize)) AS attachmentsize FROM bb".$n."_attachments");
$attachmentcount = $attachmentinfo['attachmentcount'];
$attachmentsize = formatFilesize($attachmentinfo['attachmentsize']);

$installdays = (time() - $installdate) / 86400;
if ($installdays < 1) {
	$perday = number_format($stats['postcount'], 2, $lang->get("LANG_GLOBAL_DEC_POINT"), $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	$postsperday = $lang->get("LANG_ACP_WELCOME_PERDAY", array('$perday' => $perday));
	
	$perday = number_format($stats['threadcount'], 2, $lang->get("LANG_GLOBAL_DEC_POINT"), $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	$threadsperday = $lang->get("LANG_ACP_WELCOME_PERDAY", array('$perday' => $perday));
}
else {
	$perday = number_format($stats['postcount'] / $installdays, 2, $lang->get("LANG_GLOBAL_DEC_POINT"), $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	$postsperday = $lang->get("LANG_ACP_WELCOME_PERDAY", array('$perday' => $perday));
	
	$perday = number_format($stats['threadcount'] / $installdays, 2, $lang->get("LANG_GLOBAL_DEC_POINT"), $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	$threadsperday = $lang->get("LANG_ACP_WELCOME_PERDAY", array('$perday' => $perday));
}

list($waiting4Activation) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_users WHERE activation<>1");
$lang->items['LANG_ACP_WELCOME_W4ACTIVATION'] = $lang->get("LANG_ACP_WELCOME_W4ACTIVATION", array('$waiting4Activation' => $waiting4Activation));

$serverinfo = 0;
if ($uptime = @exec("uptime")) {
	if (preg_match("/averages?: ([0-9\.]+),[\s]+([0-9\.]+),[\s]+([0-9\.]+)/", $uptime, $match)) {
		
		$match[1] *= 100;
		$match[2] *= 100;
		$match[3] *= 100;
		
		$serverinfo = 1;
	}
}

if ($stats['usercount'] >= 1000) $stats['usercount'] = number_format($stats['usercount'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
if ($stats['threadcount'] >= 1000) $stats['threadcount'] = number_format($stats['threadcount'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
if ($stats['postcount'] >= 1000) $stats['postcount'] = number_format($stats['postcount'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
if ($pncount >= 1000) $pncount = number_format($pncount, 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
if ($attachmentcount >= 1000) $attachmentcount = number_format($attachmentcount, 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));

eval("\$tpl->output(\"".$tpl->get("welcome", 1)."\",1);");
?>
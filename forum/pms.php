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
// * $Date: 2005-05-09 11:22:12 +0200 (Mon, 09 May 2005) $
// * $Author: Burntime $
// * $Rev: 1602 $
// ************************************************************************************//


$filename = 'pms.php';

require('./global.php');
require('./acp/lib/class_parse.php');
require('./acp/lib/class_parsecode.php');
$lang->load('PMS,USERCP');

// show max. 10 recipients in outbox, etc.
$pmmaxrecipientlistsize = 10;

if (!$wbbuserdata['userid'] || $wbbuserdata['can_use_pms'] == 0) access_error();

if (isset($_REQUEST['folderid'])) {
	$folderid = $_REQUEST['folderid'];
	if ($folderid != 'outbox') $folderid = intval($folderid);
}
else $folderid = '';
if ($folderid === 0) $folderid = '';

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = '';

$username = htmlconverter($wbbuserdata['username']);
$lang->items['LANG_USERCP_TITLE'] = $lang->get("LANG_USERCP_TITLE", array('$username' => $username));

if ($action == '' || $action == 'tracking') {
	$pmcount = 0;
	$inbox_count = 0;
	$tracking_count = 0;
	$outbox_count = 0;
	$pmnewcount = 0;
	$pmunreadcount = 0;
	$temp_folder_count = array();

	
	$result = $db->unbuffered_query("SELECT ".
	"pmr.folderid, pmr.recipientid, pmr.view, p.sendtime ".
	"FROM bb".$n."_privatemessagereceipts pmr ".
	"LEFT JOIN bb".$n."_privatemessage p USING(privatemessageid) ".
	"WHERE (pmr.recipientid='$wbbuserdata[userid]' AND pmr.deletepm=0)");
	while ($row = $db->fetch_array($result)) {
		$pmcount++;
		if ($row['folderid'] == 0) $inbox_count++;
		else {
			if (isset($temp_folder_count[$row['folderid']])) $temp_folder_count[$row['folderid']]++;
			else $temp_folder_count[$row['folderid']] = 1;
		}
		if ($row['view'] == 0) {
			$pmunreadcount++;	
			if ($row['sendtime'] > $wbbuserdata['lastvisit']) $pmnewcount++;
		}	
	}
	$result = $db->unbuffered_query("SELECT ".
	"privatemessageid, inoutbox, tracking, recipientcount ".
	"FROM bb".$n."_privatemessage p ".
	"WHERE p.senderid='$wbbuserdata[userid]' AND (inoutbox=1 OR tracking=1)");
	while ($row = $db->fetch_array($result)) {
		if ($row['inoutbox'] == 1) {
			$pmcount++;
			$outbox_count++;
		}
		if ($row['tracking'] == 1) {
			$tracking_count += $row['recipientcount'];
		}		
	}

	// update pm-counter if necessary
	if ($wbbuserdata['pmtotalcount'] != $pmcount || $wbbuserdata['pminboxcount'] != ($pmcount - $outbox_count) || $wbbuserdata['pmnewcount'] != $pmnewcount || $wbbuserdata['pmunreadcount'] != $pmunreadcount) {
		$wbbuserdata['pmtotalcount'] = $pmcount;
		$wbbuserdata['pminboxcount']  = $pmcount - $outbox_count;
		$wbbuserdata['pmnewcount'] = $pmnewcount;
		$wbbuserdata['pmunreadcount']  = $pmunreadcount;
		$db->unbuffered_query("UPDATE bb".$n."_users SET pmtotalcount='$wbbuserdata[pmtotalcount]', pminboxcount='$wbbuserdata[pminboxcount]', pmnewcount='$wbbuserdata[pmnewcount]', pmunreadcount='$wbbuserdata[pmunreadcount]' WHERE userid='$wbbuserdata[userid]'", 1);
	}
	
	if ($wbbuserdata['max_pms'] > 0) $temp = $pmcount / $wbbuserdata['max_pms'];
	else $temp = 0;
	if (($percent = round($temp * 100)) > 100) {
		$percent = 100;
		$temp = 1;
	}
	
	$lang->items['LANG_PMS_FOLDER_USAGE'] = $lang->get("LANG_PMS_FOLDER_USAGE", array('$percent' => $percent));
	$x = round($temp * 240);

	if (isset($_REQUEST['daysprune'])) $daysprune = intval($_REQUEST['daysprune']);
	elseif ($wbbuserdata['daysprune'] != 0) $daysprune = $wbbuserdata['daysprune'];
	else $daysprune = $default_daysprune;

	if ($daysprune == 1000) $datecute = 0;
	elseif ($daysprune == 1500) $datecute = $wbbuserdata['lastvisit'];
	else $datecute = time() - $daysprune * 86400;

	$d_select[1] = '';
	$d_select[2] = '';
	$d_select[5] = '';
	$d_select[10] = '';
	$d_select[20] = '';
	$d_select[30] = '';
	$d_select[45] = '';
	$d_select[60] = '';
	$d_select[75] = '';
	$d_select[100] = '';
	$d_select[365] = '';
	$d_select[$daysprune] = ' selected="selected"';

	$result = $db->query("SELECT folderid, title FROM bb".$n."_folders WHERE userid='$wbbuserdata[userid]' ORDER BY title ASC");
	$user_folder_count = $db->num_rows($result);
	$folder_bit = '';
	$moveto_options = '';
	$folder['title'] = '';
	while ($row = $db->fetch_array($result)) {
		if (isset($temp_folder_count[$row['folderid']])) $folder_count = $temp_folder_count[$row['folderid']];
		else $folder_count = 0;

		$row['title'] = htmlconverter($row['title']);
		eval("\$folder_bit .= \"".$tpl->get("pms_folderbit")."\";");
		if ($row['folderid'] == $folderid) $folder['title'] = $row['title'];
		else {
			eval("\$moveto_options .= \"".$tpl->get("pms_moveto_options")."\";");
		}
	}
}


/* view pms from folder x */
if ($action == '') {
	$lang->load('BOARD');
	
	if ($folderid != 'outbox' && $folderid != 0 && !$folder['title']) access_error();
	if (!$folder['title']) $folder['title'] = $lang->items['LANG_PMS_INBOX'];
	$pms_bit = '';
	
	if (isset($_REQUEST['sortfield'])) $sortfield = $_REQUEST['sortfield'];
	else $sortfield = '';
	if (isset($_REQUEST['sortorder'])) $sortorder = wbb_strtoupper($_REQUEST['sortorder']);
	else $sortorder = '';

	switch ($sortfield) {
		case 'sendtime': break;
		case 'subject': break;
		case 'username': if ($folderid == 'outbox') $sortfield = 'sendtime'; break;
		default: $sortfield = 'sendtime';	
	}
	switch ($sortorder) {
		case 'ASC': break;
		case 'DESC': break;
		default: $sortorder = 'DESC';	
	}

	if ($folderid == 'outbox') {
		$moveto_options = '';
		$result = $db->unbuffered_query("SELECT ".
		"p.privatemessageid, p.subject, p.sendtime, p.iconid, p.recipientlist, p.recipientcount, p.attachments, ".
		"i.iconpath, i.icontitle ".
		"FROM bb".$n."_privatemessage p ".
		"LEFT JOIN bb".$n."_icons i USING(iconid) ".
		"WHERE p.senderid='$wbbuserdata[userid]' AND p.inoutbox=1 AND p.sendtime>'$datecute' ".
		"ORDER BY $sortfield $sortorder");
		while ($row = $db->fetch_array($result)) {
			if ($row['iconid']) $icon = makeimgtag($row['iconpath'], getlangvar($row['icontitle'], $lang), 0);
			else $icon = "&nbsp;";

			$senddate = formatdate($wbbuserdata['dateformat'], $row['sendtime']);
			$sendtime = formatdate($wbbuserdata['timeformat'], $row['sendtime']);

			$row['subject'] = htmlconverter($row['subject']);
			$recipients = '';
			$row['recipientlist'] = unserialize($row['recipientlist']);
			foreach ($row['recipientlist'] as $recipientid=>$recipient) {
				$recipient = htmlconverter($recipient);
				eval("\$recipients .= \"".$tpl->get("pms_bit_recipientbit")."\";");
			}
			if ($row['recipientcount'] > $pmmaxrecipientlistsize) {
				$recipients .= '...<br />';	
			}
			//$recipients = wbb_substr($recipients, 0, -6);
			if ($row['attachments']) $LANG_PMS_ATTACHMENTS = $lang->get("LANG_BOARD_ATTACHMENTS", array('$attachments' => $row['attachments']));
			
			eval("\$pms_bit .= \"".$tpl->get("pms_bit")."\";");
		}

		eval("\$tpl->output(\"".$tpl->get("pms")."\");");
	}
	else {
		$result = $db->unbuffered_query("SELECT ".
		"p.privatemessageid, p.subject, p.sendtime, pmr.view, pmr.reply, pmr.forward, p.iconid, p.attachments, ".
		"i.iconpath, i.icontitle, ".
		"u.userid, u.username ".
		"FROM bb".$n."_privatemessagereceipts pmr ".
		"LEFT JOIN bb".$n."_privatemessage p ON (p.privatemessageid = pmr.privatemessageid) ".
		"LEFT JOIN bb".$n."_icons i USING(iconid) ".
		"LEFT JOIN bb".$n."_users u ON (p.senderid=u.userid) ".
		"WHERE pmr.recipientid='$wbbuserdata[userid]' AND pmr.deletepm=0 AND pmr.folderid='".addslashes($folderid)."' AND p.sendtime>'$datecute' ".
		"ORDER BY $sortfield $sortorder");		
		while ($row = $db->fetch_array($result)) {
			if ($row['iconid']) $icon = makeimgtag($row['iconpath'], getlangvar($row['icontitle'], $lang), 0);
			else $icon = "&nbsp;";

			$senddate = formatdate($wbbuserdata['dateformat'], $row['sendtime']);
			$sendtime = formatdate($wbbuserdata['timeformat'], $row['sendtime']);

			if ($row['sendtime'] >= $wbbuserdata['lastvisit'] && $row['view'] == 0) $pm_image = makeimgtag("{$style[imagefolder]}/pm_new.gif");
			elseif ($row['view'] == 0) $pm_image = makeimgtag("{$style[imagefolder]}/pm_unread.gif");
			else {
				if ($row['reply'] == 1 && $row['forward'] == 1) $pm_image = makeimgtag("{$style[imagefolder]}/pm_reward.gif");
				elseif ($row['reply'] == 1) $pm_image = makeimgtag("{$style[imagefolder]}/pm_reply.gif");
				elseif ($row['forward'] == 1) $pm_image = makeimgtag("{$style[imagefolder]}/pm_forward.gif");
				else $pm_image = makeimgtag("{$style[imagefolder]}/pm_normal.gif");
			}

			if ($row['userid'] > 0) $row['username'] = htmlconverter($row['username']);
			else $row['username'] = $lang->get('LANG_PMS_SENDER_SYSTEM', array('$master_board_name' => $master_board_name));
			$row['subject'] = htmlconverter($row['subject']);
			
			if ($row['attachments']) $LANG_PMS_ATTACHMENTS = $lang->get("LANG_BOARD_ATTACHMENTS", array('$attachments' => $row['attachments']));
			
			eval("\$pms_bit .= \"".$tpl->get("pms_bit")."\";");
		}

		eval("\$tpl->output(\"".$tpl->get("pms")."\");");
	}
	exit;
}

/** message tracking **/
if ($action == 'tracking') {
	$lang->load('MEMBERS');

	$readbit = '';
	$unreadbit = '';
	$read = '';
	$unread = '';
	$activtime = time() - 60 * $useronlinetimeout;
	$result = $db->unbuffered_query("SELECT ".
	"p.privatemessageid, pmr.recipientid, p.subject, pmr.view, p.sendtime, p.iconid, u.username, u.invisible, u.lastactivity, i.iconpath, i.icontitle ".
	"FROM bb".$n."_privatemessage p ".
	"LEFT JOIN bb".$n."_privatemessagereceipts pmr ON (pmr.privatemessageid=p.privatemessageid)".
	"LEFT JOIN bb".$n."_icons i ON (i.iconid=p.iconid) ".
	"LEFT JOIN bb".$n."_users u ON (u.userid=pmr.recipientid) ".
	"WHERE p.senderid='$wbbuserdata[userid]' AND p.tracking=1 AND p.sendtime>'$datecute' ".
	"ORDER BY sendtime DESC");
	while ($row = $db->fetch_array($result)) {
		$senddate = formatdate($wbbuserdata['dateformat'], $row['sendtime']);
		$sendtime = formatdate($wbbuserdata['timeformat'], $row['sendtime']);

		$row['subject'] = htmlconverter($row['subject']);
		$row['username'] = htmlconverter($row['username']);
		$username = $row['username'];
		if ($row['lastactivity'] >= $activtime && ($row['invisible'] == 0 || $wbbuserdata['a_can_view_ghosts'] == 1)) {
			$user_online = 1;
			$LANG_MEMBERS_USERONLINE = $lang->get("LANG_MEMBERS_USERONLINE", array('$username' => $username));
		}
		else {
			$user_online = 0;
			$LANG_MEMBERS_USEROFFLINE = $lang->get("LANG_MEMBERS_USEROFFLINE", array('$username' => $username));
		}

		if ($row['iconid']) $icon = makeimgtag($row['iconpath'], getlangvar($row['icontitle'], $lang), 0);
		else $icon = "&nbsp;";

		if ($row['view'] == 0) eval("\$unreadbit .= \"".$tpl->get("pms_tracking_unreadbit")."\";");
		else {
			$readdate = formatdate($wbbuserdata['dateformat'], $row['view']);
			$readtime = formatdate($wbbuserdata['timeformat'], $row['view']);
			eval("\$readbit .= \"".$tpl->get("pms_tracking_readbit")."\";");
		}
	}

	$folder['title'] = $lang->get('LANG_PMS_TRACKING');
	if ($readbit) eval("\$read = \"".$tpl->get("pms_tracking_read")."\";");
	if ($unreadbit) eval("\$unread = \"".$tpl->get("pms_tracking_unread")."\";");

	eval("\$tpl->output(\"".$tpl->get("pms")."\");");
	exit;
}

/** create a folder **/
if (isset($_POST['action']) && $_POST['action'] == 'createfolder') {
	$foldertitle = wbb_trim($_POST['foldertitle']);
	if (!$foldertitle) redirect($lang->items['LANG_PMS_REDIRECT_FALSEFOLDER'], "pms.php".$SID_ARG_1ST, 5);

	list($foldercount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_folders WHERE userid='$wbbuserdata[userid]'");
	if ($foldercount >= $wbbuserdata['max_pms_folders']) redirect($lang->items['LANG_PMS_TOOMANYFOLDERS'], "pms.php".$SID_ARG_1ST, 5);

	$db->query("INSERT INTO bb".$n."_folders (folderid,userid,title) VALUES (NULL,'$wbbuserdata[userid]','".addslashes($foldertitle)."')");
	$folderid = $db->insert_id();

	header("Location: pms.php?folderid=$folderid".$SID_ARG_2ND_UN);
	exit;
}

/** rename a folder **/
if (isset($_POST['action']) && $_POST['action'] == 'renamefolder') {
	$foldertitle = wbb_trim($_POST['foldertitle']);
	$folderid = intval($_POST['folderid']);

	list($controluser) = $db->query_first("SELECT userid FROM bb".$n."_folders WHERE folderid='$folderid'");
	if ($controluser != $wbbuserdata['userid']) access_error();

	$db->unbuffered_query("UPDATE bb".$n."_folders SET title = '".addslashes($foldertitle)."' WHERE folderid='$folderid'", 1);
	header("Location: pms.php?folderid=$folderid".$SID_ARG_2ND_UN);
	exit;
}

/** remove a folder **/
if (isset($_GET['action']) && $_GET['action'] == 'removefolder') {
	$folderid = intval($_GET['folderid']);

	list($controluser) = $db->query_first("SELECT userid FROM bb".$n."_folders WHERE folderid='$folderid'");
	if ($controluser != $wbbuserdata['userid']) access_error();

	$db->unbuffered_query("UPDATE bb".$n."_privatemessagereceipts SET folderid = '0' WHERE folderid='$folderid'", 1);
	$db->unbuffered_query("DELETE FROM bb".$n."_folders WHERE folderid='$folderid'", 1);

	header("Location: pms.php".$SID_ARG_1ST);
	exit;
}

/** delete marked msgs **/
if (isset($_POST['action']) && $_POST['action'] == 'delmark') {
	if ($_POST['pmid'] && count($_POST['pmid'])) $pmids = implode(',', intval_array($_POST['pmid']));
	else $pmids = '';
	if ($pmids) {
		if ($_POST['folderid'] == "outbox") {
			$db->query("UPDATE bb".$n."_privatemessage SET inoutbox=0 WHERE senderid='$wbbuserdata[userid]' AND privatemessageid IN (".addslashes($pmids).")");
			
			$deleteCount = 0;
			$deletepmids = '';
			$result = $db->query("SELECT ".
			"p.privatemessageid, p.inoutbox, COUNT(pmr.privatemessageid) as receipts ".
			"FROM bb".$n."_privatemessage p ".
			"LEFT OUTER JOIN bb".$n."_privatemessagereceipts pmr ON (pmr.privatemessageid=p.privatemessageid AND pmr.deletepm=0) ".
			"WHERE (p.senderid='$wbbuserdata[userid]' AND p.inoutbox=0 AND p.privatemessageid IN (".addslashes($pmids).")) ".
			"GROUP BY p.privatemessageid");
			while ($row = $db->fetch_array($result)) {
				if ($row['receipts'] == 0 && $row['inoutbox'] == 0) {
					$deletepmids .= ",$row[privatemessageid]";
				}
				$deleteCount++;
			}
			if ($deletepmids != '') {
				$deletepmids = wbb_substr($deletepmids, 1);
				$db->unbuffered_query("DELETE FROM bb".$n."_privatemessage WHERE privatemessageid IN (".$deletepmids.")", 1);
				$db->unbuffered_query("DELETE FROM bb".$n."_privatemessagereceipts WHERE privatemessageid IN (".$deletepmids.")", 1);
				// delete attachments as well
				$result = $db->query("SELECT attachmentid, attachmentextension, thumbnailextension FROM bb".$n."_attachments WHERE privatemessageid IN (".$deletepmids.") AND postid = 0");
				while ($row = $db->fetch_array($result)) {
					@unlink("attachments/attachment-".$row['attachmentid'].".".$row['attachmentextension']);
					@unlink("attachments/thumbnail-".$row['attachmentid'].".".$row['thumbnailextension']);
				}
				$db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE privatemessageid IN (".$deletepmids.") AND postid = 0", 1);
			}
			
			$db->query("UPDATE bb".$n."_users SET pmtotalcount=pmtotalcount-".$deleteCount." WHERE userid='$wbbuserdata[userid]'");
		}
		else {
			$deleteCount = 0;			
			$deletepmids = '';
			$db->unbuffered_query("UPDATE bb".$n."_privatemessagereceipts SET deletepm=1 WHERE recipientid='$wbbuserdata[userid]' AND privatemessageid IN (".addslashes($pmids).")", 1);
			$result = $db->query("SELECT ".
			"p.privatemessageid, p.inoutbox, COUNT(pmr.privatemessageid) as receipts ".
			"FROM bb".$n."_privatemessage p ".
			"LEFT OUTER JOIN bb".$n."_privatemessagereceipts pmr ON (pmr.privatemessageid=p.privatemessageid AND pmr.deletepm=0) ".
			"WHERE p.privatemessageid IN (".addslashes($pmids).") ".
			"GROUP BY p.privatemessageid");
			while ($row = $db->fetch_array($result)) {
				if ($row['receipts'] == 0 && $row['inoutbox'] == 0) {
					$deletepmids .= ",$row[privatemessageid]";
				}
				$deleteCount++;	
			}
			if ($deletepmids != '') {
				$deletepmids = wbb_substr($deletepmids, 1);
				$db->unbuffered_query("DELETE FROM bb".$n."_privatemessage WHERE privatemessageid IN (".$deletepmids.")", 1);
				$db->unbuffered_query("DELETE FROM bb".$n."_privatemessagereceipts WHERE privatemessageid IN (".$deletepmids.")", 1);
				// delete attachments as well
				$result = $db->query("SELECT attachmentid, attachmentextension, thumbnailextension FROM bb".$n."_attachments WHERE privatemessageid IN (".$deletepmids.") AND postid = 0");
				while ($row = $db->fetch_array($result)) {
					@unlink("attachments/attachment-".$row['attachmentid'].".".$row['attachmentextension']);
					@unlink("attachments/thumbnail-".$row['attachmentid'].".".$row['thumbnailextension']);
				}
				$db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE privatemessageid IN (".$deletepmids.") AND postid = 0", 1);
			}
			$db->query("UPDATE bb".$n."_users SET pmtotalcount=pmtotalcount-".$deleteCount.", pminboxcount=pminboxcount-".$deleteCount." WHERE userid='$wbbuserdata[userid]'");
		}
	}
	header("Location: pms.php?folderid=$folderid".$SID_ARG_2ND_UN);
	exit;
}

/** delete all msgs **/
if (isset($_POST['action']) && $_POST['action'] == 'delall') {
	if ($_POST['folderid'] == "outbox") {
		$db->query("UPDATE bb".$n."_privatemessage SET inoutbox=0 WHERE senderid='$wbbuserdata[userid]'");

		$deletepmids = '';
		$result = $db->query("SELECT ".
		"p.privatemessageid, p.inoutbox, COUNT(pmr.privatemessageid) as receipts ".
		"FROM bb".$n."_privatemessage p ".
		"LEFT OUTER JOIN bb".$n."_privatemessagereceipts pmr ON (pmr.privatemessageid=p.privatemessageid AND pmr.deletepm=0) ".
		"WHERE p.senderid='$wbbuserdata[userid]' AND p.inoutbox=0 ".
		"GROUP BY p.privatemessageid");
		while ($row = $db->fetch_array($result)) {
			if ($row['receipts'] == 0 && $row['inoutbox'] == 0) {
				$deletepmids .= ",$row[privatemessageid]";
			}	
		}
		if ($deletepmids != '') {
			$deletepmids = wbb_substr($deletepmids, 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_privatemessage WHERE privatemessageid IN (".$deletepmids.")", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_privatemessagereceipts WHERE privatemessageid IN (".$deletepmids.")", 1);
			// delete attachments as well
			$result = $db->query("SELECT attachmentid, attachmentextension, thumbnailextension FROM bb".$n."_attachments WHERE privatemessageid IN (".$deletepmids.") AND postid = 0");
			while ($row = $db->fetch_array($result)) {
				@unlink("attachments/attachment-".$row['attachmentid'].".".$row['attachmentextension']);
				@unlink("attachments/thumbnail-".$row['attachmentid'].".".$row['thumbnailextension']);
			}
			$db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE privatemessageid IN (".$deletepmids.") AND postid = 0", 1);
		}
		
		$db->query("UPDATE bb".$n."_users SET pmtotalcount=pminboxcount WHERE userid='$wbbuserdata[userid]'");
	}
	else {
		$db->unbuffered_query("UPDATE bb".$n."_privatemessagereceipts SET deletepm=1 WHERE recipientid='$wbbuserdata[userid]' AND folderid='".intval($_POST['folderid'])."'", 1);

		$pmids = '';
		$result = $db->query("SELECT privatemessageid FROM bb".$n."_privatemessagereceipts WHERE deletepm=1 AND recipientid='$wbbuserdata[userid]' AND folderid='".intval($_POST['folderid'])."'");
		while ($row = $db->fetch_array($result)) $pmids .= ",$row[privatemessageid]";
		
		$deleteCount = 0;
		$deletepmids = '';
		$result = $db->query("SELECT ".
		"p.privatemessageid, p.inoutbox, COUNT(pmr.privatemessageid) as receipts ".
		"FROM bb".$n."_privatemessage p ".
		"LEFT OUTER JOIN bb".$n."_privatemessagereceipts pmr ON (pmr.privatemessageid=p.privatemessageid AND pmr.deletepm=0) ".
		"WHERE p.privatemessageid IN (".wbb_substr($pmids, 1).") ".
		"GROUP BY p.privatemessageid");
		while ($row = $db->fetch_array($result)) {
			if ($row['receipts'] == 0 && $row['inoutbox'] == 0) {
				$deletepmids .= ",$row[privatemessageid]";
			}
			$deleteCount++;
		}
		if ($deletepmids != '') {
			$deletepmids = wbb_substr($deletepmids, 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_privatemessage WHERE privatemessageid IN (".$deletepmids.")", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_privatemessagereceipts WHERE privatemessageid IN (".$deletepmids.")", 1);
			// delete attachments as well
			$result = $db->query("SELECT attachmentid, attachmentextension, thumbnailextension FROM bb".$n."_attachments WHERE privatemessageid IN (".$deletepmids.") AND postid = 0");
			while ($row = $db->fetch_array($result)) {
				@unlink("attachments/attachment-".$row['attachmentid'].".".$row['attachmentextension']);
				@unlink("attachments/thumbnail-".$row['attachmentid'].".".$row['thumbnailextension']);
			}
			$db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE privatemessageid IN (".$deletepmids.") AND postid = 0", 1);
		}
		$db->query("UPDATE bb".$n."_users SET pmtotalcount=pmtotalcount-".$deleteCount.", pminboxcount=pminboxcount-".$deleteCount." WHERE userid='$wbbuserdata[userid]'");
	}
	header("Location: pms.php?folderid=$folderid".$SID_ARG_2ND_UN);
	exit;
}

/** view a pm **/
if (isset($_GET['action']) && $_GET['action'] == 'viewpm') {
	$lang->load('THREAD');
	
	if (isset($_GET['outbox'])) {
		$pmid = intval($_GET['pmid']);
		$pm = $db->query_first("SELECT ".
		"p.*, ".
		"i.iconpath, i.icontitle ".
		"FROM bb".$n."_privatemessage p ".
		"LEFT JOIN bb".$n."_icons i USING(iconid) ".
		"WHERE p.privatemessageid='$pmid' AND p.inoutbox=1");
		if ($pm['senderid'] != $wbbuserdata['userid']) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));

		$senddate = formatdate($wbbuserdata['dateformat'], $pm['sendtime']);
		$sendtime = formatdate($wbbuserdata['timeformat'], $pm['sendtime']);
		if ($pm['iconid']) $icon = makeimgtag($pm['iconpath'], getlangvar($pm['icontitle'], $lang), 0);
		else $icon = '';

		$parse = &new parse($docensor, 90, $wbbuserdata['showimages'], "", $usecode);
		$pm['message'] = $parse->doparse($pm['message'], $pm['allowsmilies'], $pm['allowhtml'], $pm['allowbbcode'], $pm['allowimages']);
		$pm['subject'] = htmlconverter(textwrap($pm['subject']));
		if ($pm['showsignature'] == 1 && !$wbbuserdata['disablesignature'] && $wbbuserdata['showsignatures'] == 1 && $wbbuserdata['signature']) {
			$posts['signature'] = $parse->doparse($wbbuserdata['signature'], $wbbuserdata['allowsigsmilies'], $wbbuserdata['allowsightml'], $wbbuserdata['allowsigbbcode'], $wbbuserdata['allowsigimages']);
			eval("\$signature = \"".$tpl->get("thread_signature")."\";");
		}

		$recipients = '';
		$pm['recipient'] = '';
		if ($pm['recipientcount'] > 1) {
			$result = $db->query("SELECT recipientid, recipient, blindcopy FROM bb".$n."_privatemessagereceipts WHERE privatemessageid='$pmid'", $pmmaxrecipientlistsize);
			while ($recipient = $db->fetch_array($result)) {
				$recipient['recipient'] = htmlconverter($recipient['recipient']);
				if ($pm['recipient'] == '') $pm['recipient'] = $recipient['recipient'];
				else eval("\$recipients .= \"".$tpl->get("pms_viewpm_recipientbit")."\";");
			}
			if ($pm['recipientcount'] > $pmmaxrecipientlistsize) {
				$recipients .= '..., ';	
			}
			$recipients = wbb_substr($recipients, 0, -2);
		}
		else {
			$pm['recipientlist'] = unserialize($pm['recipientlist']);
			$pm['recipient'] = htmlconverter(current($pm['recipientlist']));
		}
		$lang->items['LANG_PMS_MESSAGE_FURTHER_RECIPIENTS'] = $lang->get("LANG_PMS_MESSAGE_FURTHER_RECIPIENTS", array('$recipients' => $recipients));
		$lang->items['LANG_PMS_MESSAGE_TO_USER'] = $lang->get("LANG_PMS_MESSAGE_TO_USER", array('$username' => $pm['recipient'], '$senddate' => $senddate, '$sendtime' => $sendtime));


		// show attachments
		$attachments = '';
		$attachment_thumbnailCount = 0;
		$attachmentbit = '';
		$attachmentbit_img = '';
		$attachmentbit_img_small = '';
		$attachmentbit_img_thumbnails = '';
		
		if ($pm['attachments'] > 0) {
			unset($LANG_THREAD_ATTACHMENT_IMAGE_THUMBNAIL);
			unset($LANG_THREAD_ATTACHMENT_IMAGE_SMALL);
			unset($LANG_THREAD_ATTACHMENT_IMAGE);
			unset($LANG_THREAD_ATTACHMENT);
			
			$result = $db->query("SELECT * FROM bb".$n."_attachments WHERE privatemessageid='$pmid'");
			while ($attachment = $db->fetch_array($result)) {
				$attachment['attachmentextension'] = htmlconverter($attachment['attachmentextension']);
				$attachment['attachmentname'] = htmlconverter($attachment['attachmentname']);
				
				// attachment is an image, display it directly
				if ($wbbuserdata['showimages'] == 1 && ($attachment['attachmentextension'] == 'gif' || $attachment['attachmentextension'] == 'jpg' || $attachment['attachmentextension'] == 'jpeg'  || $attachment['attachmentextension'] == 'png')) {
					if ($attachment['thumbnailextension'] != '') {
						$attachment_thumbnailCount++;
						if ($attachment_thumbnailCount && ($attachment_thumbnailCount % $thumbnailsperrow) == 0) $thumbnailNewline = true;
						else $thumbnailNewline = false;
						if (!isset($LANG_THREAD_ATTACHMENT_IMAGE_THUMBNAIL)) $LANG_THREAD_ATTACHMENT_IMAGE_THUMBNAIL = $lang->get("LANG_THREAD_ATTACHMENT_IMAGE_SMALL", array('$username' => htmlconverter($wbbuserdata['username'])));
						else $LANG_THREAD_ATTACHMENT_IMAGE_THUMBNAIL = $lang->get("LANG_THREAD_ATTACHMENTS_IMAGE_SMALL", array('$username' => htmlconverter($wbbuserdata['username'])));

						eval("\$attachmentbit_img_thumbnails .= \"".$tpl->get("thread_attachmentbit_show_thumbnail")."\";");
					}
					else {
						$imgsize = @getimagesize("./attachments/attachment-$attachment[attachmentid].$attachment[attachmentextension]");
					
						if (($picmaxwidth != 0 && $imgsize[0] > $picmaxwidth) || ($picmaxheight != 0 && $imgsize[1] > $picmaxheight)) {
							if ($picmaxwidth != 0) $div1 = $picmaxwidth / $imgsize[0];
							else $div1 = 1;
							if ($picmaxheight != 0) $div2 = $picmaxheight / $imgsize[1];
							else $div2 = 1;
							
							if ($div1 < $div2) {
								$attachment['imgwidth'] = $picmaxwidth;
								$attachment['imgheight'] = round($imgsize[1] * $div1);
							}
							else {
								$attachment['imgheight'] = $picmaxheight;
								$attachment['imgwidth'] = round($imgsize[0] * $div2);	
							}
							
							if (!isset($LANG_THREAD_ATTACHMENT_IMAGE_SMALL)) $LANG_THREAD_ATTACHMENT_IMAGE_SMALL = $lang->get("LANG_THREAD_ATTACHMENT_IMAGE_SMALL", array('$username' => htmlconverter($wbbuserdata['username'])));
							else $LANG_THREAD_ATTACHMENT_IMAGE_SMALL = $lang->get("LANG_THREAD_ATTACHMENTS_IMAGE_SMALL", array('$username' => htmlconverter($wbbuserdata['username'])));
							
							eval("\$attachmentbit_img_small .= \"".$tpl->get("thread_attachmentbit_show_small")."\";");
						}
						else {
							if (!isset($LANG_THREAD_ATTACHMENT_IMAGE)) $LANG_THREAD_ATTACHMENT_IMAGE = $lang->get("LANG_THREAD_ATTACHMENT_IMAGE", array('$username' => htmlconverter($wbbuserdata['username'])));
							else $LANG_THREAD_ATTACHMENT_IMAGE = $lang->get("LANG_THREAD_ATTACHMENTS_IMAGE", array('$username' => htmlconverter($wbbuserdata['username'])));
							
							eval("\$attachmentbit_img .= \"".$tpl->get("thread_attachmentbit_show")."\";");
						}
					}
				}
				else {
					if (!file_exists($style['imagefolder']."/filetypes/".$attachment['attachmentextension'].".gif")) $extensionimage = "unknown";
					else $extensionimage = $attachment['attachmentextension'];
					$attachment['attachmentsize'] = formatFilesize($attachment['attachmentsize']);
					if (!isset($LANG_THREAD_ATTACHMENT)) $LANG_THREAD_ATTACHMENT = $lang->get('LANG_THREAD_ATTACHMENT');
					else  $LANG_THREAD_ATTACHMENT = $lang->get('LANG_THREAD_ATTACHMENTS');
					
					$LANG_THREAD_ATTACHMENT_INFO = $lang->get("LANG_THREAD_ATTACHMENT_INFO", array('$attachmentsize' => $attachment['attachmentsize'], '$counter' => $attachment['counter']));
					eval("\$attachmentbit .= \"".$tpl->get("thread_attachmentbit")."\";");
				}				
			}
			eval("\$attachments = \"".$tpl->get("thread_attachments")."\";");
		}
		
		
		eval("\$tpl->output(\"".$tpl->get("pms_viewpm_outbox")."\");");
	}
	else {
		$pmid = intval($_GET['pmid']);
		$pm = $db->query_first("SELECT ".
		"pmr.*, p.*, f.*, ".
		"i.iconpath, i.icontitle, ".
		"u.userid, u.username, u.signature, u.allowsigsmilies, u.allowsightml, u.allowsigbbcode, u.allowsigimages, u.disablesignature ".
		"FROM bb".$n."_privatemessagereceipts pmr ".
		"LEFT JOIN bb".$n."_privatemessage p ON (p.privatemessageid = pmr.privatemessageid) ".
		"LEFT JOIN bb".$n."_icons i USING(iconid) ".
		"LEFT JOIN bb".$n."_users u ON (p.senderid=u.userid) ".
		"LEFT JOIN bb".$n."_folders f ON (pmr.folderid=f.folderid) ".
		"WHERE pmr.privatemessageid='$pmid' AND pmr.recipientid='$wbbuserdata[userid]' AND pmr.deletepm=0");
		if ($pm['recipientid'] != $wbbuserdata['userid']) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
		if ($pm['view'] == 0) {
			$db->unbuffered_query("UPDATE bb".$n."_privatemessagereceipts SET view='".time()."' WHERE privatemessageid='$pmid' AND recipientid='$wbbuserdata[userid]'", 1);
			if ($pm['sendtime'] > $wbbuserdata['lastvisit']) $db->unbuffered_query("UPDATE bb".$n."_users SET pmunreadcount=pmunreadcount-1,pmnewcount=pmnewcount-1 WHERE userid='$wbbuserdata[userid]'", 1);
			else $db->unbuffered_query("UPDATE bb".$n."_users SET pmunreadcount=pmunreadcount-1 WHERE userid='$wbbuserdata[userid]'", 1);
		}

		$senddate = formatdate($wbbuserdata['dateformat'], $pm['sendtime']);
		$sendtime = formatdate($wbbuserdata['timeformat'], $pm['sendtime']);
		if ($pm['iconid']) $icon = makeimgtag($pm['iconpath'], getlangvar($pm['icontitle'], $lang), 0);
		else $icon = '';

		if ($pm['folderid'] == 0) $pm['title'] = $lang->items['LANG_PMS_INBOX'];
		else $pm['title'] = htmlconverter($pm['title']);
		$parse = &new parse($docensor, 90, $wbbuserdata['showimages'], "", $usecode);
		$pm['message'] = $parse->doparse($pm['message'], $pm['allowsmilies'], $pm['allowhtml'], $pm['allowbbcode'], $pm['allowimages']);
		$pm['subject'] = htmlconverter(textwrap($pm['subject']));
		if ($pm['showsignature'] == 1 && !$pm['disablesignature'] && $wbbuserdata['showsignatures'] == 1 && $pm['signature']) {
			$posts['signature'] = $parse->doparse($pm['signature'], $pm['allowsigsmilies'], $pm['allowsightml'], $pm['allowsigbbcode'], $pm['allowsigimages']);
			eval("\$signature = \"".$tpl->get("thread_signature")."\";");
		}
		
		
		$recipients = '';
		if ($pm['recipientcount'] > 1) {
			$result = $db->query("SELECT recipientid, recipient FROM bb".$n."_privatemessagereceipts WHERE privatemessageid='$pmid' AND blindcopy=0 AND recipientid<>'$wbbuserdata[userid]'", $pmmaxrecipientlistsize);
			while ($recipient = $db->fetch_array($result)) {
				$recipient['recipient'] = htmlconverter($recipient['recipient']);
				eval("\$recipients .= \"".$tpl->get("pms_viewpm_recipientbit")."\";");
			}
			if ($recipients != '' && $pm['recipientcount'] > $pmmaxrecipientlistsize) {
				$recipients .= '..., ';	
			}			
			
			$recipients = wbb_substr($recipients, 0, -2);
		}
		$lang->items['LANG_PMS_MESSAGE_FURTHER_RECIPIENTS'] = $lang->get("LANG_PMS_MESSAGE_FURTHER_RECIPIENTS", array('$recipients' => $recipients));
		
		if ($pm['userid'] > 0) $pm['username'] = htmlconverter($pm['username']);
		else $pm['username'] = $lang->get('LANG_PMS_SENDER_SYSTEM', array('$master_board_name' => $master_board_name));
		$lang->items['LANG_PMS_MESSAGE_FROM_USER'] = $lang->get("LANG_PMS_MESSAGE_FROM_USER", array('$username' => $pm['username'], '$senddate' => $senddate, '$sendtime' => $sendtime));

		// show attachments
		$attachments = '';
		$attachment_thumbnailCount = 0;
		$attachmentbit = '';
		$attachmentbit_img = '';
		$attachmentbit_img_small = '';
		$attachmentbit_img_thumbnails = '';
		
		if ($pm['attachments'] > 0) {
			unset($LANG_THREAD_ATTACHMENT_IMAGE_THUMBNAIL);
			unset($LANG_THREAD_ATTACHMENT_IMAGE_SMALL);
			unset($LANG_THREAD_ATTACHMENT_IMAGE);
			unset($LANG_THREAD_ATTACHMENT);
			
			$result = $db->query("SELECT * FROM bb".$n."_attachments WHERE privatemessageid='$pmid'");
			while ($attachment = $db->fetch_array($result)) {
				$attachment['attachmentextension'] = htmlconverter($attachment['attachmentextension']);
				$attachment['attachmentname'] = htmlconverter($attachment['attachmentname']);
				
				// attachment is an image, display it directly
				if ($wbbuserdata['showimages'] == 1 && ($attachment['attachmentextension'] == 'gif' || $attachment['attachmentextension'] == 'jpg' || $attachment['attachmentextension'] == 'jpeg'  || $attachment['attachmentextension'] == 'png')) {
					if ($attachment['thumbnailextension'] != '') {
						$attachment_thumbnailCount++;
						if ($attachment_thumbnailCount && ($attachment_thumbnailCount % $thumbnailsperrow) == 0) $thumbnailNewline = true;
						else $thumbnailNewline = false;
						if (!isset($LANG_THREAD_ATTACHMENT_IMAGE_THUMBNAIL)) $LANG_THREAD_ATTACHMENT_IMAGE_THUMBNAIL = $lang->get("LANG_THREAD_ATTACHMENT_IMAGE_SMALL", array('$username' => $pm['username']));
						else $LANG_THREAD_ATTACHMENT_IMAGE_THUMBNAIL = $lang->get("LANG_THREAD_ATTACHMENTS_IMAGE_SMALL", array('$username' => $pm['username']));
						
						eval("\$attachmentbit_img_thumbnails .= \"".$tpl->get("thread_attachmentbit_show_thumbnail")."\";");
					}
					else {
						$imgsize = @getimagesize("./attachments/attachment-$attachment[attachmentid].$attachment[attachmentextension]");
						
						if (($picmaxwidth != 0 && $imgsize[0] > $picmaxwidth) || ($picmaxheight != 0 && $imgsize[1] > $picmaxheight)) {
							if ($picmaxwidth != 0) $div1 = $picmaxwidth / $imgsize[0];
							else $div1 = 1;
							if ($picmaxheight != 0) $div2 = $picmaxheight / $imgsize[1];
							else $div2 = 1;
							
							if ($div1 < $div2) {
								$attachment['imgwidth'] = $picmaxwidth;
								$attachment['imgheight'] = round($imgsize[1] * $div1);
							}
							else {
								$attachment['imgheight'] = $picmaxheight;
								$attachment['imgwidth'] = round($imgsize[0] * $div2);	
							}
							
							if (!isset($LANG_THREAD_ATTACHMENT_IMAGE_SMALL)) $LANG_THREAD_ATTACHMENT_IMAGE_SMALL = $lang->get("LANG_THREAD_ATTACHMENT_IMAGE_SMALL", array('$username' => $pm['username']));
							else $LANG_THREAD_ATTACHMENT_IMAGE_SMALL = $lang->get("LANG_THREAD_ATTACHMENTS_IMAGE_SMALL", array('$username' => $pm['username']));
							
							eval("\$attachmentbit_img_small .= \"".$tpl->get("thread_attachmentbit_show_small")."\";");
						}
						else {
							if (!isset($LANG_THREAD_ATTACHMENT_IMAGE)) $LANG_THREAD_ATTACHMENT_IMAGE = $lang->get("LANG_THREAD_ATTACHMENT_IMAGE", array('$username' => $pm['username']));
							else $LANG_THREAD_ATTACHMENT_IMAGE = $lang->get("LANG_THREAD_ATTACHMENTS_IMAGE", array('$username' => $pm['username']));
							
							eval("\$attachmentbit_img .= \"".$tpl->get("thread_attachmentbit_show")."\";");
						}
					}
				}
				else {
					if (!file_exists($style['imagefolder']."/filetypes/".$attachment['attachmentextension'].".gif")) $extensionimage = "unknown";
					else $extensionimage = $attachment['attachmentextension'];
					$attachment['attachmentsize'] = formatFilesize($attachment['attachmentsize']);
					if (!isset($LANG_THREAD_ATTACHMENT)) $LANG_THREAD_ATTACHMENT = $lang->get('LANG_THREAD_ATTACHMENT');
					else  $LANG_THREAD_ATTACHMENT = $lang->get('LANG_THREAD_ATTACHMENTS');
					
					$LANG_THREAD_ATTACHMENT_INFO = $lang->get("LANG_THREAD_ATTACHMENT_INFO", array('$attachmentsize' => $attachment['attachmentsize'], '$counter' => $attachment['counter']));
					eval("\$attachmentbit .= \"".$tpl->get("thread_attachmentbit")."\";");
				}				
			}
			eval("\$attachments = \"".$tpl->get("thread_attachments")."\";");
		}

		eval("\$tpl->output(\"".$tpl->get("pms_viewpm")."\");");
	}
	exit;
}

/** create a new pm **/
if ($_REQUEST['action'] == 'newpm' || $_REQUEST['action'] == 'replypm' || $_REQUEST['action'] == 'forwardpm') {
	$lang->load('POST,POSTINGS,MAIL');

	/* checkbox preselect */
	if ($newpm_default_checked_0 == 1) $checked[0] = 'checked="checked"';
	if ($newpm_default_checked_1 == 1) $checked[1] = 'checked="checked"';

	if ($newpm_default_checked_5 == 1) $checked[5] = 'checked="checked"';
	if ($newpm_default_checked_6 == 1) $checked[6] = 'checked="checked"';
	if ($newpm_default_checked_7 == 1) $checked[7] = 'checked="checked"';


	if ($newpm_default_checked_2 == 1) $checked[2] = 'checked="checked"';
	if ($newpm_default_checked_3 == 1) $checked[3] = 'checked="checked"';
	if ($newpm_default_checked_4 == 1) $checked[4] = 'checked="checked"';
	
	if (isset($_REQUEST['pmid'])) $pmid = intval($_REQUEST['pmid']);

	if (isset($_POST['send'])) {
		/* get subject */
		$subject = wbb_trim($_POST['subject']);

		/* get recipients */
		$recipients = wbb_trim($_POST['recipients']);
		$recipients_bcc = wbb_trim($_POST['recipients_bcc']);
		
		/* get message & strip crap */
		$message = stripcrap(wbb_trim($_POST['message']));
		if (wbb_strlen($message) > $pmmaxchars) $message = wbb_substr($message, 0, $pmmaxchars);

		/* posting feature rights:start */
		if (isset($_POST['iconid']) && $wbbuserdata['can_use_pn_icons'] == 1) $iconid = intval($_POST['iconid']);
		else $iconid = 0;

		if (!$wbbuserdata['can_use_pn_smilies'] || (isset($_POST['disablesmilies']) && $_POST['disablesmilies'] == 1)) $allowsmilies = 0;
		else $allowsmilies = 1;

		if (!$wbbuserdata['can_use_pn_html'] || (isset($_POST['disablehtml']) && $_POST['disablehtml'] == 1)) $allowhtml = 0;
		else $allowhtml = 1;

		if (!$wbbuserdata['can_use_pn_bbcode'] || (isset($_POST['disablebbcode']) && $_POST['disablebbcode'] == 1)) $allowbbcode = 0;
		else $allowbbcode = 1;

		if (!$wbbuserdata['can_use_pn_images'] || (isset($_POST['disableimages']) && $_POST['disableimages'] == 1)) $allowimages = 0;
		else $allowimages = 1;
		/* posting feature rights:end */

		if (isset($_POST['idhash'])) $idhash = wbb_trim($_POST['idhash']);
		else $idhash = '';
		
		if ($idhash == '') $idhash = md5($wbbuserdata['userid'].'|newpm|'.time());

		/* check attachmentids:start */
		if ($wbbuserdata['can_upload_pm_attachments'] == 1) {
			if (isset($_POST['attachmentids']) && $_POST['attachmentids'] != '') {
				$attachmentids = intval_array(explode(',', $_POST['attachmentids']));
				$attachment_verify = $db->query("SELECT * FROM bb".$n."_attachments WHERE attachmentid IN (".implode(',', $attachmentids).") AND idhash='".addslashes($idhash)."'");
				$attachmentids = array();
				while ($row = $db->fetch_array($attachment_verify)) {
					$attachmentids[] = $row['attachmentid'];
				}
			}
			else {
				// read attachments from database (for users without javascript)
				$attachment_verify = $db->query("SELECT * FROM bb".$n."_attachments WHERE idhash='".addslashes($idhash)."'");
				$attachmentids = array();
				while ($row = $db->fetch_array($attachment_verify)) {
					$attachmentids[] = $row['attachmentid'];
				}
			}	
		}
		else {
			$attachmentids = array();	
		}
		/* check attachmentids:end */

		if (!isset($_POST['preview']) && !$_POST['change_editor']) {
			$error = '';
			if (!$subject || (!$recipients && !$recipients_bcc) || !$message) $error .= $lang->items['LANG_POSTINGS_ERROR1'];

			/* check recipients */
			if ($recipients != '' || $recipients_bcc != '') {
				$recipientlist = array();
				$recipientlist_bcc = array();
				$emaillist = array();
				
				$user_check = getwbbuserdatas(wbb_trim($recipients."\n".$recipients_bcc));
				if ($wbbuserdata['max_pms_recipients'] != -1 && count($user_check) > $wbbuserdata['max_pms_recipients']) $error .= $lang->get("LANG_PMS_ERROR6", array('$max_recipients' => $wbbuserdata['max_pms_recipients']));
				
				for ($i = 0; $i < 2; $i++) {
					if ($i == 0 && !$recipients) continue;
					elseif ($i == 1 && !$recipients_bcc) continue;
					foreach (explode("\n", ($i == 0 ? $recipients : $recipients_bcc)) as $recipient) {
						$recipient = wbb_trim($recipient);
						$result = $user_check[wbb_strtolower($recipient)];
						if (!$result['userid']) $error .= $lang->get("LANG_PMS_ERROR1", array('$recipient' => htmlconverter($recipient)));
						else {
							$recipient = htmlconverter($recipient);
							if (($result['receivepm'] == 0 || $result['can_use_pms'] == 0) && $wbbuserdata['a_can_ignore_maxpms'] != 1) $error .= $lang->get("LANG_PMS_ERROR2", array('$recipient' => $recipient));
							if (add2list($result['ignorelist'], $wbbuserdata['userid']) == -1) $error .= $lang->get("LANG_PMS_ERROR3", array('$recipient' => $recipient));
							if ($wbbuserdata['a_can_ignore_maxpms'] != 1 && $result['a_can_ignore_maxpms'] != 1) {
								if ($result['pmtotalcount'] >= $result['max_pms']) $error .= $lang->get("LANG_PMS_ERROR4", array('$recipient' => $recipient));
							}
							if ($i == 0) $recipientlist[$result['userid']] = $result['username'];
							else {
								if (!isset($recipientlist[$result['userid']])) $recipientlist_bcc[$result['userid']] = $result['username'];
							}
							// add to email notification list
							if ($result['emailonpm'] == 1) {
								$emaillist[$result['userid']] = $result;
							}
						}
					}					
				}

				
				$recipients = implode("\n", $recipientlist);
				$recipients_bcc = implode("\n", $recipientlist_bcc);
				
				if ($_POST['savecopy'] == 1) {
					if ($wbbuserdata['a_can_ignore_maxpms'] != 1) {
						if ($wbbuserdata['pmtotalcount'] >= $wbbuserdata['max_pms']) $error .= $lang->items['LANG_PMS_ERROR5'];
					}
				}
			}
			
			if ($error) eval("\$pm_error = \"".$tpl->get("newthread_error")."\";");

			else {
				// parse url
				if ($_POST['parseurl'] == 1) $message = parseURL($message);

				$newPmID = sendPrivateMessage($recipientlist, $recipientlist_bcc, $subject, $message, $wbbuserdata['userid'], $_POST['savecopy'], $allowsmilies, $allowhtml, $allowbbcode, $allowimages, $_POST['showsignature'], $iconid, $_POST['tracking'], count($attachmentids), 1);
				// pm already exists
				if (!$newPmID) {
					header("Location: pms.php".$SID_ARG_1ST);
					exit;	
				}
				
				// set attachment privatemessageid
				if (count($attachmentids)) {
					$db->unbuffered_query("UPDATE bb".$n."_attachments SET privatemessageid='$newPmID', idhash='' WHERE attachmentid IN (".implode(',', $attachmentids).")", 1);
				}

				// email notification for recipients
				if (count($emaillist) > 0) {
					$langpacks = array();
					$langpacks[$lang->languagepackid] = $lang;
					foreach ($emaillist as $result) {
						if (!isset($langpacks[$result['languagepackid']])) {
							$langpacks[$result['languagepackid']] = &new language(intval($result['languagepackid']));	
							$langpacks[$result['languagepackid']]->load("OWN,MAIL");
						}
	
						$master_board_name_email = getlangvar($o_master_board_name, $langpacks[$result['languagepackid']], 0);
	
						$mail_text = $langpacks[$result['languagepackid']]->get("LANG_MAIL_NEWPM_TEXT", array('$username' => $result['username'], '$sender' => $wbbuserdata['username'], '$url2board' => $url2board, '$master_board_name_email' => $master_board_name_email));
						$mail_subject = $langpacks[$result['languagepackid']]->get("LANG_MAIL_NEWPM_SUBJECT", array('$master_board_name_email' => $master_board_name_email));
						mailer($result['email'], $mail_subject, $mail_text);
					}	
					
				}


				if ($_REQUEST['action'] == "replypm") $db->unbuffered_query("UPDATE bb".$n."_privatemessagereceipts SET reply=1 WHERE privatemessageid='$pmid' AND recipientid='$wbbuserdata[userid]'", 1);
				if ($_REQUEST['action'] == "forwardpm") $db->unbuffered_query("UPDATE bb".$n."_privatemessagereceipts SET forward=1 WHERE privatemessageid='$pmid' AND recipientid='$wbbuserdata[userid]'", 1);
				header("Location: pms.php".$SID_ARG_1ST);
				exit;
			}
		}
		else if (!$_POST['change_editor']) {
			$parse = &new parse($docensor, 75, $wbbuserdata['showimages'], "", $usecode);
			$preview_subject = htmlconverter(textwrap($subject));
			$preview_message = $parse->doparse((($_POST['parseurl'] == 1) ? (parseURL($message)) : ($message)), $allowsmilies, $allowhtml, $allowbbcode, $allowimages);
			if ($iconid) {
				$result = $db->query_first("SELECT * FROM bb".$n."_icons WHERE iconid = '$iconid'");
				$preview_posticon = makeimgtag($result['iconpath'], getlangvar($result['icontitle'], $lang), 0);
			}
		}
		if ($_POST['parseurl'] == 1) $checked[0] = 'checked="checked"';
		else $checked[0] = '';
		if ($_POST['disablesmilies'] == 1) $checked[1] = 'checked="checked"';
		else $checked[1] = '';
		if ($_POST['showsignature'] == 1) $checked[5] = 'checked="checked"';
		else $checked[5] = '';
		if ($_POST['savecopy'] == 1) $checked[6] = 'checked="checked"';
		else $checked[6] = '';
		if ($_POST['tracking'] == 1) $checked[7] = 'checked="checked"';
		else $checked[7] = '';

		if ($_POST['disablehtml'] == 1) $checked[2] = 'checked="checked"';
		else $checked[2] = '';
		if ($_POST['disablebbcode'] == 1) $checked[3] = 'checked="checked"';
		else $checked[3] = '';
		if ($_POST['disableimages'] == 1) $checked[4] = 'checked="checked"';
		else $checked[4] = '';
	}
	else {
		if (isset($_GET['userid'])) {
			if (is_array($_GET['userid'])) {
				$recipients = '';
				$result = $db->query("SELECT username FROM bb".$n."_users WHERE userid IN(".implode(',', intval_array($_GET['userid'])).")");
				while ($row = $db->fetch_array($result)) {
					$recipients .= $row['username']."\n";	
				}
			}
			else list($recipients) = $db->query_first("SELECT username FROM bb".$n."_users WHERE userid='".intval($_GET['userid'])."'");
		}
		if ($_REQUEST['action'] == 'replypm' || $_REQUEST['action'] == 'forwardpm') {
			$pm = $db->query_first("SELECT ".
			"p.senderid, p.subject, p.message, p.sendtime, u.username ".
			"FROM bb".$n."_privatemessage p ".
			"LEFT JOIN bb".$n."_users u ON (u.userid=p.senderid) ".
			"LEFT JOIN bb".$n."_privatemessagereceipts pmr ON (p.privatemessageid=pmr.privatemessageid AND pmr.recipientid='$wbbuserdata[userid]') ".
			"WHERE p.privatemessageid='$pmid' AND pmr.recipientid='$wbbuserdata[userid]'");
			$sendtime = formatdate($wbbuserdata['dateformat']." ".$wbbuserdata['timeformat'], $pm['sendtime']);
			if ($docensor == 1) {
				if ($parse) $pm['message'] = $parse->censor($pm['message']);
				else {
					$parse = &new parse(1);
					$pm['message'] = $parse->censor($pm['message']);
				}
			}

			if ($_REQUEST['action'] == 'replypm') {
				$pm['subject'] = preg_replace("/^RE: /i", "", $pm['subject']);
				
				$subject = $lang->get("LANG_PMS_RE", array('$subject' => $pm['subject']));
				$message = $lang->get("LANG_PMS_ORIGINAL_MESSAGE", array('$subject' => $pm['subject'], '$username' => $pm['username'], '$sendtime' => $sendtime, '$sender' => $wbbuserdata['username'], '$message' => $pm['message']));
				$recipients = $pm['username'];
			}
			if ($_REQUEST['action'] == 'forwardpm') {
				$pm['subject'] = preg_replace("/^FW: /i", "", $pm['subject']);
				if ($pm['senderid'] == 0) $pm['username'] = $lang->get('LANG_PMS_SENDER_SYSTEM', array('$master_board_name' => $master_board_name));
				
				$subject = $lang->get("LANG_PMS_FW", array('$subject' => $pm['subject']));
				$message = $lang->get("LANG_PMS_ORIGINAL_MESSAGE", array('$subject' => $pm['subject'], '$username' => $pm['username'], '$sendtime' => $sendtime, '$sender' => $wbbuserdata['username'], '$message' => $pm['message']));
			}
		}
	}

	if (!isset($iconid)) $iconid = 0;
	if ($wbbuserdata['can_use_pn_icons'] == 1) $pm_icons = getIcons($iconid);
	if ($wbbuserdata['can_use_pn_bbcode'] == 1 && $wbbuserdata['usewysiwyg'] != 1) $bbcode_buttons = getcodebuttons();
	if ($wbbuserdata['can_use_pn_smilies'] == 1) {
		if ($wbbuserdata['usewysiwyg'] == 1) $smilies = getAppletSmilies();
		$bbcode_smilies = getclickysmilies($smilie_table_cols, $smilie_table_rows);
	}

	$note = '';
	if ($wbbuserdata['can_use_pn_html'] == 0) $note .= $lang->items['LANG_POSTINGS_HTML_NOT_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_HTML_ALLOW'];
	if ($wbbuserdata['can_use_pn_bbcode'] == 0) $note .= $lang->items['LANG_POSTINGS_BBCODE_NOT_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_BBCODE_ALLOW'];
	if ($wbbuserdata['can_use_pn_smilies'] == 0) $note .= $lang->items['LANG_POSTINGS_SMILIES_NOT_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_SMILIES_ALLOW'];
	if ($wbbuserdata['can_use_pn_images'] == 0) $note .= $lang->items['LANG_POSTINGS_HTML_IMAGES_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_IMAGES_ALLOW'];
	$LANG_PMS_MAX_RECIPIENTS = (($wbbuserdata['max_pms_recipients'] != -1) ? ($lang->get('LANG_PMS_MAX_RECIPIENTS', array('$max_recipients' => $wbbuserdata['max_pms_recipients']))) : (''));


	if (!isset($idhash)) $idhash = md5($wbbuserdata['userid'].'|newpm|'.time());
	else $idhash = htmlconverter($idhash);
	if ($wbbuserdata['can_upload_pm_attachments'] == 1) {
		if (isset($attachmentids) && is_array($attachmentids)) $attachmentids = implode(',', $attachmentids);
		else $attachmentids = '';
		
		eval("\$attachment = \"".$tpl->get("newthread_attachment")."\";");
	}
	else $attachment = '';
	
	$sendToBuddies = '';
	if ($wbbuserdata['buddylist'] != '') {
		$result = $db->query("SELECT username FROM bb".$n."_users WHERE userid IN (".str_replace(' ', ',', $wbbuserdata['buddylist']).")");
		while ($row = $db->fetch_array($result)) {
			$sendToBuddies .= str_replace("'", "\'", $row['username'])."\\n";
		}
	}

	if (isset($message)) $message = htmlconverter($message);
	if (isset($subject)) $subject = htmlconverter($subject);
	if (isset($recipients)) $recipients = htmlconverter($recipients);
	if (isset($recipients_bcc)) $recipients_bcc = htmlconverter($recipients_bcc);

	eval("\$headinclude .= \"".$tpl->get("bbcode_script")."\";");
	eval("\$editor = \"".$tpl->get("editor")."\";");
	eval("\$editor_switch = \"".$tpl->get("editor_switch")."\";");
	eval("\$tpl->output(\"".$tpl->get("pms_newpm")."\");");
	exit;
}

/** stop tracking **/
if (isset($_POST['action']) && $_POST['action'] == 'endtracking') {
	if ($_POST['pmid'] && count($_POST['pmid'])) {
		$pmids = preg_replace('%-[0-9]+%', '', implode(',', $_POST['pmid']));
		$pmids = implode(',', intval_array(explode(',', $pmids)));
	}
	else $pmids = '';

	if ($pmids) $db->unbuffered_query("UPDATE bb".$n."_privatemessage SET tracking=0 WHERE senderid='$wbbuserdata[userid]' AND privatemessageid IN (".addslashes($pmids).")", 1);

	header("Location: pms.php?action=tracking".$SID_ARG_2ND_UN);
	exit;
}

/** cancel message **/
if (isset($_POST['action']) && $_POST['action'] == 'cancel') {
	if ($_POST['pmid'] && count($_POST['pmid'])) {
		$pmidArray = array();
		foreach ($_POST['pmid'] as $row) {
			list($pmid, $recipientid) = explode('-', $row);
			$pmid = intval($pmid);
			$recipientid = intval($recipientid);
			if (!$pmid || !$recipientid) continue;
			
			if (!isset($pmidArray[$pmid])) $pmidArray[$pmid] = array();	
			$pmidArray[$pmid][$recipientid] = $recipientid;
		}
		
		if (count($pmidArray)) {
			$recipientLists = array();
			$recipientArray = array();
			$recipientCounters = array();
			$selectStr = '';
			$deleteStr = '';
			$result = $db->query("SELECT privatemessageid, recipientlist, recipientcount FROM bb".$n."_privatemessage WHERE senderid='$wbbuserdata[userid]' AND privatemessageid IN ('".implode("','", array_keys($pmidArray))."')");
			while ($row = $db->fetch_array($result)) {
				if ($selectStr != '') $selectStr .= ' OR ';
				$selectStr .= "(pmr.privatemessageid='$row[privatemessageid]' AND pmr.view=0 AND pmr.recipientid IN ('".implode("','", $pmidArray[$row['privatemessageid']])."'))";
				if ($deleteStr != '') $deleteStr .= ' OR ';
				$deleteStr .= "(privatemessageid='$row[privatemessageid]' AND view=0 AND recipientid IN ('".implode("','", $pmidArray[$row['privatemessageid']])."'))";
				$recipientLists[$row['privatemessageid']] = unserialize($row['recipientlist']);
				$recipientCounters[$row['privatemessageid']] = $row['recipientcount'];
			}
			if ($selectStr != '' && $deleteStr != '') {
				$result = $result = $db->query("SELECT pmr.privatemessageid, pmr.recipientid, pmr.recipient, p.sendtime, u.lastvisit FROM bb".$n."_privatemessagereceipts pmr LEFT JOIN bb".$n."_privatemessage p USING(privatemessageid) LEFT JOIN bb".$n."_users u ON (u.userid=pmr.recipientid) WHERE $selectStr");
				while ($row = $db->fetch_array($result)) {
					if ($row['sendtime'] > $row['lastvisit']) $db->query("UPDATE bb".$n."_users SET pmtotalcount=pmtotalcount-1, pminboxcount=pminboxcount-1, pmnewcount=pmnewcount-1, pmunreadcount=pmunreadcount-1 WHERE userid='$row[recipientid]'"); 
					else $db->query("UPDATE bb".$n."_users SET pmtotalcount=pmtotalcount-1, pminboxcount=pminboxcount-1, pmunreadcount=pmunreadcount-1 WHERE userid='$row[recipientid]'");
					$recipientArray[$row['recipientid']] = $row['recipientid'];
					unset($recipientLists[$row['privatemessageid']][$row['recipientid']]);
					$recipientCounters[$row['privatemessageid']]--;
				}
				// delete recipients from list
				$db->unbuffered_query("DELETE FROM bb".$n."_privatemessagereceipts WHERE $deleteStr", 1);
				// update pmpopups
				$db->unbuffered_query("UPDATE bb".$n."_users SET pmpopup=1 WHERE pmpopup=2 AND pmnewcount=0 AND userid IN ('".implode("','", $recipientArray)."')", 1);
				
				// update recipientlists
				$deletepmids = '';
				foreach ($recipientLists as $pmid => $recipientlist) {
					if (count($recipientlist)) list($receiptcount) = $db->query_first("SELECT COUNT(*) as receiptcount FROM bb".$n."_privatemessagereceipts WHERE privatemessageid='$pmid' AND deletepm=0");
					else $receiptcount = 0;
					if ($receiptcount == 0) {
						$deletepmids .= ",$pmid";
					}
					else {
						// its necessery to refill the recipientlist
						if ($recipientCounters[$pmid] > $pmmaxrecipientlistsize && count($recipientlist) < $pmmaxrecipientlistsize) {
							$recipientlist = array();
							$result = $db->query("SELECT recipientid, recipient FROM bb".$n."_privatemessagereceipts WHERE privatemessageid='$pmid'", $pmmaxrecipientlistsize);
							while ($row = $db->fetch_array($result)) {
								$recipientlist[$row['recipientid']] = $row['recipient'];
							}
						}
						$db->query("UPDATE bb".$n."_privatemessage SET recipientlist='".addslashes(serialize($recipientlist))."', recipientcount=recipientcount-1 WHERE privatemessageid='$pmid'");
					}
				}
				
				if ($deletepmids != '') {
					$deletepmids = wbb_substr($deletepmids, 1);
					$db->unbuffered_query("DELETE FROM bb".$n."_privatemessage WHERE privatemessageid IN (".$deletepmids.")", 1);
					$db->unbuffered_query("DELETE FROM bb".$n."_privatemessagereceipts WHERE privatemessageid IN (".$deletepmids.")", 1);
					// delete attachments as well
					$result = $db->query("SELECT attachmentid, attachmentextension, thumbnailextension FROM bb".$n."_attachments WHERE privatemessageid IN (".$deletepmids.") AND postid = 0");
					while ($row = $db->fetch_array($result)) {
						@unlink("attachments/attachment-".$row['attachmentid'].".".$row['attachmentextension']);
						@unlink("attachments/thumbnail-".$row['attachmentid'].".".$row['thumbnailextension']);
					}
					$db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE privatemessageid IN (".$deletepmids.") AND postid = 0", 1);
				}
			}
		}
		
	}
	header("Location: pms.php?action=tracking".$SID_ARG_2ND_UN);
	exit;
}

/** download a message -> txt file **/
if (isset($_GET['action']) && $_GET['action'] == 'downloadpm') {
	$pm = $db->query_first("SELECT ".
	"pmr.*, p.privatemessageid, p.subject, p.message, p.sendtime, ".
	"u.userid, u.username ".
	"FROM bb".$n."_privatemessagereceipts pmr ".
	"LEFT JOIN bb".$n."_privatemessage p USING(privatemessageid)".
	"LEFT JOIN bb".$n."_users u ON (p.senderid=u.userid) ".
	"WHERE pmr.privatemessageid='".intval($_GET['pmid'])."' AND pmr.recipientid='$wbbuserdata[userid]' AND pmr.deletepm=0");

	if (!$pm['privatemessageid']) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
	$sendtime = formatdate($wbbuserdata['dateformat']." ".$wbbuserdata['timeformat'], $pm['sendtime']);
	if ($pm['userid'] == 0) $pm['username'] = $lang->get('LANG_PMS_SENDER_SYSTEM', array('$master_board_name' => $master_board_name));

	$mime_type = (USR_BROWSER_AGENT == 'IE' || USR_BROWSER_AGENT == 'OPERA') ? 'application/octetstream' : 'application/octet-stream';
	$content_disp = (USR_BROWSER_AGENT == 'IE') ? 'inline; ' : 'attachment; ';
	header('Content-Type: '.$mime_type);
	header('Content-disposition: '.$content_disp.'filename="pm-'.$pm['privatemessageid'].'.txt"');
	header('Pragma: no-cache');
	header('Expires: 0');

	$printout = $lang->get("LANG_PMS_DOWNLOAD_MESSAGE", array('$subject' => $pm['subject'], '$username' => $pm['username'], '$sendtime' => $sendtime, '$sender' => $wbbuserdata['username'], '$message' => $pm['message']));
	$printout = str_replace("\r\n", "\n", $printout);
	$printout = str_replace("\n", "\r\n", $printout);
	
	print($printout);
	exit;
}

/** delete one message **/
if ($_REQUEST['action'] == 'deletepm') {
	$pmid = intval($_REQUEST['pmid']);
	if (isset($_REQUEST['outbox'])) $outbox = intval($_REQUEST['outbox']);
	else $outbox = 0;
	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		if ($outbox == 1) {
			$db->query("UPDATE bb".$n."_privatemessage SET inoutbox=0 WHERE privatemessageid='$pmid' AND senderid='$wbbuserdata[userid]'");
			if ($db->affected_rows() > 0) {			
				list($receiptcount) = $db->query_first("SELECT COUNT(*) as receiptcount FROM bb".$n."_privatemessagereceipts WHERE privatemessageid='$pmid' AND deletepm=0");
				if ($receiptcount == 0) {
					$db->query("DELETE FROM bb".$n."_privatemessage WHERE privatemessageid='$pmid' AND senderid='$wbbuserdata[userid]'");
					$db->query("DELETE FROM bb".$n."_privatemessagereceipts WHERE privatemessageid='$pmid'");
					$result = $db->query("SELECT attachmentid, attachmentextension, thumbnailextension FROM bb".$n."_attachments WHERE privatemessageid='$pmid' AND postid = 0");
					while ($row = $db->fetch_array($result)) {
						@unlink("./attachments/attachment-".$row['attachmentid'].".".$row['attachmentextension']);
						@unlink("./attachments/thumbnail-".$row['attachmentid'].".".$row['thumbnailextension']);
					}
					$db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE privatemessageid='$pmid' AND postid = 0", 1);
				}
				$db->query("UPDATE bb".$n."_users SET pmtotalcount=pmtotalcount-1 WHERE userid='$wbbuserdata[userid]'");
			}
			header("Location: pms.php?folderid=outbox".$SID_ARG_2ND_UN);
		}
		else {
			$pm = $db->query_first("SELECT p.privatemessageid, p.inoutbox, p.sendtime, pmr.view, pmr.recipientid FROM bb".$n."_privatemessage p LEFT JOIN bb".$n."_privatemessagereceipts pmr ON (pmr.privatemessageid=p.privatemessageid AND pmr.recipientid='$wbbuserdata[userid]') WHERE p.privatemessageid='$pmid'");
			if ($pm['privatemessageid'] && $pm['recipientid'] == $wbbuserdata['userid']) {
				$db->query("UPDATE bb".$n."_privatemessagereceipts SET deletepm=1 WHERE privatemessageid='$pmid' AND recipientid='$wbbuserdata[userid]'");
				if ($pm['inoutbox'] == 0 && $db->affected_rows() > 0) {
					list($receiptcount) = $db->query_first("SELECT COUNT(*) as receiptcount FROM bb".$n."_privatemessagereceipts WHERE privatemessageid='$pmid' AND deletepm=0");
					if ($receiptcount == 0) {
						$db->query("DELETE FROM bb".$n."_privatemessage WHERE privatemessageid='$pmid'");
						$db->query("DELETE FROM bb".$n."_privatemessagereceipts WHERE privatemessageid='$pmid'");
						$result = $db->query("SELECT attachmentid, attachmentextension, thumbnailextension FROM bb".$n."_attachments WHERE privatemessageid='$pmid' AND postid = 0");
						while ($row = $db->fetch_array($result)) {
							@unlink("./attachments/attachment-".$row['attachmentid'].".".$row['attachmentextension']);
							@unlink("./attachments/thumbnail-".$row['attachmentid'].".".$row['thumbnailextension']);
						}
						$db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE privatemessageid='$pmid' AND postid = 0", 1);
					}
				}
				// update users pm-counter
				if ($pm['view'] == 0 && $pm['sendtime'] > $wbbuserdata['lastvisit']) $db->query("UPDATE bb".$n."_users SET pmtotalcount=pmtotalcount-1, pminboxcount=pminboxcount-1, pmnewcount=pmnewcount-1, pmunreadcount=pmunreadcount-1 WHERE userid='$wbbuserdata[userid]'");
				elseif ($pm['view'] == 0 && $pm['sendtime'] <= $wbbuserdata['lastvisit']) $db->query("UPDATE bb".$n."_users SET pmtotalcount=pmtotalcount-1, pminboxcount=pminboxcount-1, pmunreadcount=pmunreadcount-1 WHERE userid='$wbbuserdata[userid]'");
				else $db->query("UPDATE bb".$n."_users SET pmtotalcount=pmtotalcount-1, pminboxcount=pminboxcount-1 WHERE userid='$wbbuserdata[userid]'");
			}
			header("Location: pms.php".$SID_ARG_1ST);
		}
		exit;
	}

	eval("\$tpl->output(\"".$tpl->get("pms_deletepm")."\");");
	exit;
}

/** print message **/
if ($_REQUEST['action'] == 'printpm') {
	$pmid = intval($_REQUEST['pmid']);
	$pm = $db->query_first("SELECT ".
	"pmr.*, p.*, i.iconpath, i.icontitle, ".
	"u.userid, u.username ".
	"FROM bb".$n."_privatemessagereceipts pmr ".
	"LEFT JOIN bb".$n."_privatemessage p USING(privatemessageid) ".
	"LEFT JOIN bb".$n."_icons i USING(iconid) ".
	"LEFT JOIN bb".$n."_users u ON (p.senderid=u.userid) ".
	"WHERE pmr.privatemessageid='$pmid' AND pmr.recipientid='$wbbuserdata[userid]' AND pmr.deletepm=0");
	if ($pm['recipientid'] != $wbbuserdata['userid']) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));

	$senddate = formatdate($wbbuserdata['dateformat'], $pm['sendtime']);
	$sendtime = formatdate($wbbuserdata['timeformat'], $pm['sendtime']);

	if ($pm['iconid']) $icon = makeimgtag($pm['iconpath'], getlangvar($pm['icontitle'], $lang), 0);
	else $icon = '';

	$parse = &new parse($docensor, 90, $wbbuserdata['showimages'], "", $usecode);
	$pm['message'] = $parse->doparse($pm['message'], $pm['allowsmilies'], $pm['allowhtml'], $pm['allowbbcode'], $pm['allowimages']);
	$pm['subject'] = htmlconverter(textwrap($pm['subject']));

	if ($pm['userid'] > 0) $pm['username'] = htmlconverter($pm['username']);
	else $pm['username'] = $lang->get('LANG_PMS_SENDER_SYSTEM', array('$master_board_name' => $master_board_name));
	
	$lang->items['LANG_PMS_PRINT_MESSAGE'] = $lang->get("LANG_PMS_PRINT_MESSAGE", array('$subject' => $pm['subject'], '$username' => $pm['username'], '$senddate' => $senddate, '$sendtime' => $sendtime, '$sender' => $wbbuserdata['username']));
	eval("\$tpl->output(\"".$tpl->get("pms_printpm")."\");");
	exit;
}

/** pm popup **/
if ($_REQUEST['action'] == 'popup') {
	$lang->load('BOARD');
	
	$result = $db->query("SELECT ".
	"p.privatemessageid, p.subject, p.sendtime, p.iconid, p.attachments, ".
	"i.iconpath, i.icontitle, ".
	"u.userid, u.username ".
	"FROM bb".$n."_privatemessagereceipts pmr ".
	"LEFT JOIN bb".$n."_privatemessage p USING(privatemessageid) ".
	"LEFT JOIN bb".$n."_icons i USING(iconid) ".
	"LEFT JOIN bb".$n."_users u ON (p.senderid=u.userid) ".
	"WHERE pmr.recipientid='$wbbuserdata[userid]' AND p.sendtime>'$wbbuserdata[lastvisit]' AND pmr.view=0 AND pmr.deletepm=0 ".
	"ORDER BY p.sendtime DESC");
	
	$pmscount = $db->num_rows($result);

	$pmbit = '';
	while ($row = $db->fetch_array($result)) {
		if ($row['iconid']) $icon = makeimgtag($row['iconpath'], getlangvar($row['icontitle'], $lang), 0);
		else $icon = "&nbsp;";

		$senddate = formatdate($wbbuserdata['dateformat'], $row['sendtime']);
		$sendtime = formatdate($wbbuserdata['timeformat'], $row['sendtime']);

		$row['subject'] = htmlconverter(textwrap($row['subject']));
		if ($row['userid'] > 0) $row['username'] = htmlconverter($row['username']);
		else $row['username'] = $lang->get('LANG_PMS_SENDER_SYSTEM', array('$master_board_name' => $master_board_name));
		
		if ($row['attachments']) $LANG_PMS_ATTACHMENTS = $lang->get("LANG_BOARD_ATTACHMENTS", array('$attachments' => $row['attachments']));
		
		eval("\$pmbit .= \"".$tpl->get("pmpopup_pmbit")."\";");
	}

	if ($pmscount == 1) $LANG_PMS_POPUP_MESSAGE = $lang->items['LANG_PMS_POPUP_MESSAGE'];
	else $LANG_PMS_POPUP_MESSAGE = $lang->items['LANG_PMS_POPUP_MESSAGES'];

	$lang->items['LANG_PMS_POPUP_NEWMESSAGE'] = $lang->get("LANG_PMS_POPUP_NEWMESSAGE", array('$pmscount' => $pmscount, '$LANG_PMS_POPUP_MESSAGE' => $LANG_PMS_POPUP_MESSAGE));
	eval("\$tpl->output(\"".$tpl->get("pmpopup")."\");");
	exit;
}

/** move marked msgs to x **/
if (isset($_POST['action']) && wbb_substr($_POST['action'], 0, 6) == 'moveto') {
	$tofolderid = intval(wbb_substr($_POST['action'], 7));
	if ($_POST['pmid'] && count($_POST['pmid'])) $pmids = implode(',', intval_array($_POST['pmid']));
	else $pmids = '';
	if ($pmids) {
		list($controluser) = $db->query_first("SELECT userid FROM bb".$n."_folders WHERE folderid='$tofolderid'");
		if ($controluser != $wbbuserdata['userid']) access_error();

		$db->query("UPDATE bb".$n."_privatemessagereceipts SET folderid='$tofolderid' WHERE recipientid='$wbbuserdata[userid]' AND privatemessageid IN (".addslashes($pmids).")");
	}
	header("Location: pms.php?folderid=$folderid".$SID_ARG_2ND_UN);
	exit;
}

/** download private messages as zip file **/
if (isset($_POST['action']) && $_POST['action'] == 'zipdownload') {
	if ($_POST['pmid'] && count($_POST['pmid'])) $pmids = implode(',', intval_array($_POST['pmid']));
	else $pmids = '';
	
	if ($pmids != '') {
		include('./acp/lib/class_zip.php');
		$zip = &new zipfile;
		
		function formatSubject($subject) {
			static $filenameTranslation = array('ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue', 'ß' => 'ss');
			
			$subject = strtr($subject, $filenameTranslation);
			$subject = preg_replace('/[^a-z0-9_\- .@]+/i', '', $subject);
			
			return $subject;
		}
		
		if ($_POST['folderid'] == 'outbox') {
			$result = $db->query("SELECT ".
			"privatemessageid, subject, message, sendtime, recipientcount, recipientlist ".
			"FROM bb".$n."_privatemessage ".
			"WHERE privatemessageid IN (".$pmids.") AND senderid='$wbbuserdata[userid]' AND inoutbox=1");
			
			while ($row = $db->fetch_array($result)) {
				$recipients = implode(', ', unserialize($row['recipientlist']));
				if ($row['recipientcount'] > $pmmaxrecipientlistsize) $recipients .= ', ...';
				$row['message'] = str_replace("\n", "\r\n", $row['message']);
				$pmContent = $lang->get("LANG_PMS_DOWNLOAD_MESSAGE", array('$subject' => $row['subject'], '$username' => $wbbuserdata['username'], '$sendtime' => formatdate($wbbuserdata['dateformat']." ".$wbbuserdata['timeformat'], $row['sendtime']), '$sender' => $recipients, '$message' => $row['message']));
				$pmContent = str_replace("\r\n", "\n", $pmContent);
				$pmContent = str_replace("\n", "\r\n", $pmContent);
				
				$zip->add_file($pmContent, formatSubject($row['subject']) . ' [ID'.$row['privatemessageid'].'].txt', $row['sendtime']);
			}
			
		}
		else {
			$result = $db->query("SELECT ".
			"pmr.*, p.privatemessageid, p.subject, p.message, p.sendtime, ".
			"u.userid, u.username ".
			"FROM bb".$n."_privatemessagereceipts pmr ".
			"LEFT JOIN bb".$n."_privatemessage p USING(privatemessageid) ".
			"LEFT JOIN bb".$n."_users u ON (u.userid=p.senderid) ".
			"WHERE pmr.privatemessageid IN (".$pmids.") AND pmr.recipientid='$wbbuserdata[userid]' AND pmr.deletepm=0 AND pmr.folderid='".intval($_POST['folderid'])."'");
			
			while ($row = $db->fetch_array($result)) {
				if ($row['userid'] == 0) $row['username'] = $lang->get('LANG_PMS_SENDER_SYSTEM', array('$master_board_name' => $master_board_name));
				$row['message'] = str_replace("\n", "\r\n", $row['message']);
				$pmContent = $lang->get("LANG_PMS_DOWNLOAD_MESSAGE", array('$subject' => $row['subject'], '$username' => $row['username'], '$sendtime' => formatdate($wbbuserdata['dateformat']." ".$wbbuserdata['timeformat'], $row['sendtime']), '$sender' => $wbbuserdata['username'], '$message' => $row['message']));
				$pmContent = str_replace("\r\n", "\n", $pmContent);
				$pmContent = str_replace("\n", "\r\n", $pmContent);
								
				$zip->add_file($pmContent, formatSubject($row['subject']) . ' [ID'.$row['privatemessageid'].'].txt', $row['sendtime']);
			}
		}
		// get mime type
		if (preg_match("/Opera\/[0-9]\.[0-9]{1,2}/", $_SERVER['HTTP_USER_AGENT']) || preg_match("/MSIE [0-9]\.[0-9]{1,2}/", $_SERVER['HTTP_USER_AGENT'])) $mime_type = "application/octetstream";
		else $mime_type = "application/octet-stream";
		
		header("Expires: ".date("D, d M Y H:i:s"));
		header("Content-Type: ".$mime_type);
		if (preg_match("/MSIE [0-9]\.[0-9]{1,2}/", $_SERVER['HTTP_USER_AGENT'])) {
			header("Content-Disposition: inline; filename=\"pms.zip\"");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Pragma: public");
		}
		else {
			header("Content-Disposition: attachment; filename=\"pms.zip\"");
			header("Pragma: no-cache");
		}		
		echo $zip->file();
		exit;		
	}
	else {
		header("Location: pms.php".$SID_ARG_1ST);
		exit;
	}
}

/** PMS-Box-Status **/
if($_REQUEST['action'] == 'pms_error') eval("\$tpl->output(\"".$tpl->get("pms_error_popup")."\");");
?>

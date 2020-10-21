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
// * $Date: 2005-01-12 15:18:25 +0100 (Wed, 12 Jan 2005) $
// * $Author: Burntime $
// * $Rev: 1542 $
// ************************************************************************************//


$filename = 'attachment.php';

require('./global.php');

if ($attachment['postid'] && !$attachment['privatemessageid']) {
	if (checkpermissions('can_download_attachments') == 0) access_error();
}
elseif (!$attachment['postid'] && $attachment['privatemessageid']) {
	if (!$wbbuserdata['userid'] || $wbbuserdata['can_use_pms'] == 0) access_error();
	if (!(($attachment['senderid'] == $wbbuserdata['userid'] && $attachment['inoutbox'] == 1) || ($attachment['recipientid'] == $wbbuserdata['userid'] && $attachment['deletepm'] == 0))) access_error();
}

if (isset($attachmentid)) {
	if (isset($_REQUEST['thumbnail'])) $thumbnail = intval($_REQUEST['thumbnail']);
	else $thumbnail = 0;
	if ($thumbnail && !$attachment['thumbnailextension']) $thumbnail = 0;
	
	$db->unbuffered_query("UPDATE bb".$n."_attachments SET counter=counter+1 WHERE attachmentid = '$attachmentid'", 1); 

	if (preg_match('/MSIE [0-9]\.[0-9]{1,2}/', $_SERVER['HTTP_USER_AGENT'])) $browser_type = 1; // IE 
	else if (preg_match('/Opera\/[0-9]\.[0-9]{1,2}/', $_SERVER['HTTP_USER_AGENT'])) $browser_type = 2; // Opera
	else $browser_type = 3; // other...
	
	$content_disp = '';
	$extension = (($thumbnail == 1) ? ($attachment['thumbnailextension']) : ($attachment['attachmentextension']));
	$size = (($thumbnail == 1) ? ($attachment['thumbnailsize']) : ($attachment['attachmentsize']));
	if ($extension == 'gif') $mime_type = 'image/gif';
	elseif ($extension == 'jpg' || $extension == 'jpeg') $mime_type = 'image/jpeg';
	elseif ($extension == 'png') $mime_type = 'image/png';
	elseif ($extension == 'pdf') $mime_type = 'application/pdf';
	elseif ($extension == 'txt') $mime_type = 'text/plain';
	else {
		if ($browser_type == 1 || $browser_type == 2) $mime_type = 'application/octetstream';
		else $mime_type = 'application/octet-stream';

		if ($browser_type == 1) $content_disp = 'inline; ';
		else $content_disp = 'attachment; ';
	}
	header('Content-Type: '.$mime_type);
	
	$filenameTranslation = array('ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue', 'ß' => 'ss');
	$attachment['attachmentname'] = strtr($attachment['attachmentname'], $filenameTranslation);
	$attachment['attachmentname'] = preg_replace("/[^a-z0-9_\- .@]{1}/i", "_", $attachment['attachmentname']);
	header('Content-disposition: '.$content_disp.'filename="'.$attachment['attachmentname'].'.'.$extension.'"');
	header('Content-Length: '.$size);
	
	if ($browser_type == 1) header('Pragma: public');
	else header('Pragma: no-cache');

	header('Expires: 0');
	if ($thumbnail == 1) {
		readfile("attachments/thumbnail-".$attachment['attachmentid'].".".$attachment['thumbnailextension']);
	}
	else {
		readfile("attachments/attachment-".$attachment['attachmentid'].".".$attachment['attachmentextension']);
	}
}
else error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
?>
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
// * $Date: 2004-11-03 13:22:00 +0100 (Wed, 03 Nov 2004) $
// * $Author: Burntime $
// * $Rev: 1477 $
// ************************************************************************************//


$filename = 'attachmentedit.php';

require('./global.php');
$lang->load('MISC');

if (isset($_REQUEST['idhash'])) $idhash = wbb_trim($_REQUEST['idhash']);	
else $idhash = '';
$pmAttachment = false;

// check permissions (attach file to post)
if (isset($boardid) && $boardid) {
	if (!checkpermissions('can_upload_attachments') || (isset($board) && is_array($board) && ($board['isboard'] != 1 || $board['closed'] == 1))) {
		eval("\$tpl->output(\"".$tpl->get("window_close")."\");");
		exit();
	}
	$pmAttachment = false;
}
// check permissions (attach file to post - edit)
if (isset($postid) && $postid) {
	if (!checkmodpermissions('m_can_post_edit') && $post['userid'] != 0 && ($wbbuserdata['userid'] == 0 || $post['userid'] != $wbbuserdata['userid'] || !checkpermissions('can_edit_own_post'))) {
		eval("\$tpl->output(\"".$tpl->get("window_close")."\");");
		exit();
	}
	$idhash = '';
	$pmAttachment = false;
}
// check permissions (attach file to private message)
if (!$boardid && !$postid) {
	if (!$wbbuserdata['userid'] || $wbbuserdata['can_use_pms'] == 0 || $wbbuserdata['can_upload_pm_attachments'] == 0) {
		eval("\$tpl->output(\"".$tpl->get("window_close")."\");");
		exit();
	}
	$pmAttachment = true;
}





// initialize attachmentids etc.
if (isset($_REQUEST['attachmentids'])) {
	$attachmentids = intval_array(explode(',', $_REQUEST['attachmentids']));
	foreach ($attachmentids as $key => $val) if ($val == 0) unset($attachmentids[$key]);
}
else unset($attachmentids);



// add new attachment
$error = '';
if (isset($_POST['action']) && $_POST['action'] == 'add') {
	// attachmentlimit reached
	$max_attachments = ((!$pmAttachment) ? ($wbbuserdata['max_attachments']) : ($wbbuserdata['max_pm_attachments']));
	if ($max_attachments != -1 && isset($attachmentids) && count($attachmentids) > $max_attachments) {
		$error .= $lang->get('LANG_MISC_ATTACHMENT_ERROR1', array('$max_attachments', $max_attachments));
	}
	elseif ($_FILES['attachment_file']['tmp_name'] && $_FILES['attachment_file']['tmp_name'] != 'none') {
		$attachment_file_extension = wbb_strtolower(wbb_substr(strrchr($_FILES['attachment_file']['name'], '.'), 1));
		$attachment_file_name2 = wbb_substr($_FILES['attachment_file']['name'], 0, (intval(wbb_strlen($attachment_file_extension)) + 1) * -1);
		
		$allowextensions = str_replace("\n", "|", str_replace('*', '[a-z0-9]*', dos2unix((!$pmAttachment) ? ($wbbuserdata['allowed_attachment_extensions']) : ($wbbuserdata['allowed_pm_attachment_extensions']))));
		$max_attachment_size = ((!$pmAttachment) ? ($wbbuserdata['max_attachment_size']) : ($wbbuserdata['max_pm_attachment_size']));
		
		// attachment extension is allowed
		if (preg_match("/^($allowextensions)$/i", $attachment_file_extension) && $_FILES['attachment_file']['size'] <= $wbbuserdata['max_attachment_size']) {
			
			// global attachment limit reached
			if ($total_attachment_filesize_limit > 0) list($total_attachment_filesize) = $db->query_first("SELECT (SUM(attachmentsize) + SUM(thumbnailsize)) as total_attachment_filesize FROM bb".$n."_attachments");
			if ($total_attachment_filesize_limit > 0 && ($_FILES['attachment_file']['size'] + $total_attachment_filesize) > $total_attachment_filesize_limit) {
				$error .= $lang->get('LANG_MISC_ATTACHMENT_ERROR4');
			}
			else {
				// personal attachment limit reached
				if ($wbbuserdata['userid'] > 0 && $wbbuserdata['total_attachment_filesize_limit'] > 0) list($total_attachment_filesize) = $db->query_first("SELECT (SUM(attachmentsize) + SUM(thumbnailsize)) as total_attachment_filesize FROM bb".$n."_attachments WHERE userid='$wbbuserdata[userid]'");
				if ($wbbuserdata['userid'] > 0 && $wbbuserdata['total_attachment_filesize_limit'] > 0 && ($_FILES['attachment_file']['size'] + $total_attachment_filesize) > $wbbuserdata['total_attachment_filesize_limit']) {
					$error .= $lang->get('LANG_MISC_ATTACHMENT_ERROR5', array('$total_attachment_filesize_limit' => formatFilesize($wbbuserdata['total_attachment_filesize_limit'])));
				}
				else {
					
					$db->query("INSERT INTO bb".$n."_attachments (postid,userid,attachmentname,attachmentextension,attachmentsize,idhash,uploadtime) VALUES ('".((isset($postid) && $postid) ? ($postid) : (0))."','".((isset($postid) && $postid) ? ($post['userid']) : ($wbbuserdata['userid']))."','".addslashes($attachment_file_name2)."','".addslashes($attachment_file_extension)."','".$_FILES['attachment_file']['size']."','".addslashes($idhash)."', '".time()."')");
					$attachmentid = $db->insert_id();
					
					if (@move_uploaded_file($_FILES['attachment_file']['tmp_name'], 'attachments/attachment-'.$attachmentid.'.'.$attachment_file_extension)) {
						@chmod('attachments/attachment-'.$attachmentid.'.'.$attachment_file_extension, 0777);
						
						// create a thumbnail image
						if ($makethumbnails > 0 && in_array($attachment_file_extension, array('gif', 'jpg', 'jpeg', 'png'))) {
							$thumbnail_type = '';
							$thumbnail = makeThumbnailImage('attachments/attachment-'.$attachmentid.'.'.$attachment_file_extension, $thumbnail_type, $thumbnailwidth, $thumbnailheight);
							
							// save thumbnail
							if ($thumbnail != '' && $thumbnail_type != '') {
								$fp = fopen('attachments/thumbnail-'.$attachmentid.'.'.$thumbnail_type, 'wb');
								fwrite($fp, $thumbnail);
								fclose($fp);
								@chmod('attachments/thumbnail-'.$attachmentid.'.'.$thumbnail_type, 0777);
								$db->unbuffered_query("UPDATE bb".$n."_attachments SET thumbnailextension='".addslashes($thumbnail_type)."', thumbnailsize='".wbb_strlen($thumbnail)."' WHERE attachmentid='$attachmentid'", 1);
							}
						}
						
						if (!isset($attachmentids)) $attachmentids = array();
						$attachmentids[] = $attachmentid;
					}
					else {
						// could not copy uploaded file, rollback insert statement
						$db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE attachmentid='$attachmentid'", 1);
						$error .= $lang->get('LANG_MISC_ATTACHMENT_ERROR2');
					}
				}
			}
		}
		else $error .= $lang->get('LANG_MISC_ATTACHMENT_ERROR3');
	}
	else $error .= $lang->get('LANG_MISC_ATTACHMENT_ERROR3');
}


// delete existing attachment
elseif (isset($_POST['action']) && $_POST['action'] == 'del') {
	$delAttachmentID = 0;
	foreach ($_POST as $key => $val) {
		if (wbb_substr($key, 0, 6) == 'delid_') {
			$delAttachmentID = intval(wbb_substr($key, 6));
			break;
		}
	}
	if ($delAttachmentID) {
		$verify_result = $db->query_first("SELECT * FROM bb".$n."_attachments WHERE attachmentid='$delAttachmentID'");
		if ((isset($idhash) && $idhash && $idhash == $verify_result['idhash']) || (isset($postid) && $postid && $verify_result['postid'] == $postid)) {
			@unlink("attachments/attachment-".$delAttachmentID.".".$verify_result['attachmentextension']);
			@unlink("attachments/thumbnail-".$delAttachmentID.".".$verify_result['thumbnailextension']);
			$db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE attachmentid = '$delAttachmentID'", 1);
			$attachmentids = array_diff($attachmentids, array($delAttachmentID));
		}
	}
}




// show existing attachments
$attachmentbit = '';
unset($result);
if (!isset($attachmentids) && isset($postid) && $postid) $result = $db->query("SELECT * FROM bb".$n."_attachments WHERE postid='$postid' ORDER BY uploadtime");	
elseif (isset($attachmentids) && $attachmentids) $result = $db->query("SELECT * FROM bb".$n."_attachments WHERE attachmentid IN (".implode(',', $attachmentids).")".(($idhash != '') ? (" AND idhash='".addslashes($idhash)."'") : ("")) . " ORDER BY uploadtime");	
elseif (!isset($attachmentids) && $idhash) $result = $db->query("SELECT * FROM bb".$n."_attachments WHERE idhash='".addslashes($idhash)."' ORDER BY uploadtime");	
if (isset($result)) {
	$attachmentids = array();
	while ($row = $db->fetch_array($result)) {
		$attachmentids[] = $row['attachmentid'];
		$row['attachmentname'] = htmlconverter($row['attachmentname']);
		$row['attachmentextension'] = htmlconverter($row['attachmentextension']);	
		if (!file_exists($style['imagefolder']."/filetypes/".$row['attachmentextension'].".gif")) $extensionimage = "unknown";
		else $extensionimage = $row['attachmentextension'];
		$LANG_MISC_ATTACHMENT_INFO = $lang->get('LANG_MISC_ATTACHMENT_INFO', array('$attachmentsize' => formatFilesize($row['attachmentsize'])));
		eval("\$attachmentbit .= \"".$tpl->get("attachmentedit_bit")."\";");
	}
}


if (isset($attachmentids)) {
	$attachmentCounter = count($attachmentids);
	$attachmentids = implode(',', $attachmentids);
}
else {
	$attachmentCounter = 0;
	$attachmentids = '';
}


if ($wbbuserdata['userid'] > 0 && $wbbuserdata['total_attachment_filesize_limit'] > 0) {
	list($total_attachment_filesize) = $db->query_first("SELECT (SUM(attachmentsize) + SUM(thumbnailsize)) as total_attachment_filesize FROM bb".$n."_attachments WHERE userid='$wbbuserdata[userid]'");
	$quota = formatFilesize($wbbuserdata['total_attachment_filesize_limit']);
	$quota_used = formatFilesize($total_attachment_filesize);
	$quota_free = formatFilesize(($wbbuserdata['total_attachment_filesize_limit'] > $total_attachment_filesize) ? ($wbbuserdata['total_attachment_filesize_limit'] - $total_attachment_filesize) : (0));
	$LANG_MISC_ATTACHMENT_QUOTA = $lang->get('LANG_MISC_ATTACHMENT_QUOTA', array('$quota' => $quota, '$quota_used' => $quota_used));
	$LANG_MISC_ATTACHMENT_QUOTA_FREE = $lang->get('LANG_MISC_ATTACHMENT_QUOTA_FREE', array('$quota' => $quota, '$quota_free' => $quota_free));
}
else {
	$LANG_MISC_ATTACHMENT_QUOTA = '';
	$LANG_MISC_ATTACHMENT_QUOTA_FREE = '';
}
$max_attachments = ((!$pmAttachment) ? ($wbbuserdata['max_attachments']) : ($wbbuserdata['max_pm_attachments']));
$max_attachment_size = ((!$pmAttachment) ? ($wbbuserdata['max_attachment_size']) : ($wbbuserdata['max_pm_attachment_size']));
$allowed_attachment_extensions	= getAllowedExtensions($wbbuserdata['allowed_attachment_extensions']);
$max_attachment_size_readable	= formatFilesize($max_attachment_size);
$idhash = htmlconverter($idhash);

eval("\$tpl->output(\"".$tpl->get("attachmentedit")."\");");
?>
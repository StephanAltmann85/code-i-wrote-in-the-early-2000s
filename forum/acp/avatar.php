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
// * $Date: 2005-03-09 14:17:40 +0100 (Wed, 09 Mar 2005) $
// * $Author: Burntime $
// * $Rev: 1564 $
// ************************************************************************************//


require('./global.php');
if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = 'view';

$lang->load('ACP_AVATAR');

// How much Avatars per page?
$avatarsperpage = 15;




/** view avatars **/
if ($action == 'view') {
	if (!checkAdminPermissions('a_can_avatars_edit') && !checkAdminPermissions('a_can_avatars_del')) access_error(1);
	$count = 0;
	$sel_sortby['0'] = '';
	$sel_sortby['1'] = '';
	$sel_orderby['ASC'] = '';
	$sel_orderby['DESC'] = '';
	if (isset($_REQUEST['sortby'])) $sortby = intval($_REQUEST['sortby']);
	else $sortby = 0;
	if (isset($_REQUEST['orderby'])) $orderby = wbb_strtoupper($_REQUEST['orderby']);
	else $orderby = '';
	
	switch ($sortby){
		case 1: break;
		case 0: break;
		default: $sortby = 0;
	}
	
	switch ($orderby){ 
		case 'ASC': break;
		case 'DESC': break;
		default: $orderby = 'DESC';
	}
	
	$sel_sortby[$sortby] = ' selected="selected"';
	$sel_orderby[$orderby] = ' selected="selected"';	
	
	if ($sortby == 1) list($avatarcount) = $db->query_first("SELECT count(avatarid) FROM bb".$n."_avatars WHERE userid <> 0");
	else list($avatarcount) = $db->query_first("SELECT count(avatarid) FROM bb".$n."_avatars WHERE userid = 0");
	if (isset($_REQUEST['page'])){
		$page = intval($_REQUEST['page']);
		if ($page == 0) $page = 1;
	}
	else $page = 1;
	
	$pages = ceil($avatarcount / $avatarsperpage);
	if ($sortby == 1){
		$result = $db->query("SELECT a.*, u.username FROM bb".$n."_avatars a LEFT JOIN bb".$n."_users u USING (userid) WHERE a.userid <> 0 ORDER BY a.avatarname $orderby", $avatarsperpage, $avatarsperpage * ($page - 1));
		while ($row = $db->fetch_array($result)) {
			$avatarname = "../images/avatars/avatar-$row[avatarid].$row[avatarextension]";
			$avatarwidth = $row['width'];
			$avatarheight = $row['height'];
			
			if ($row['avatarextension'] == 'swf') eval("\$avatarimage = \"".$tpl->get("avatar_flash")."\";"); 
			else eval("\$avatarimage = \"".$tpl->get("avatar_image")."\";"); 
			
			$rowclass = getone($count, 'firstrow', 'secondrow');
			
			$row['avatarname'] = htmlconverter($row['avatarname']);
			$row['avatarextension'] = htmlconverter($row['avatarextension']);
			$row['username'] = htmlconverter($row['username']);
			
			eval("\$avatar_viewbit .= \"".$tpl->get("avatar_viewbit2", 1)."\";"); 
			$count++;
		}
	}
	else {
		$result = $db->query("SELECT a.*, g.title FROM bb".$n."_avatars a LEFT JOIN bb".$n."_groups g USING(groupid) WHERE a.userid = 0 ORDER BY a.needposts $orderby, a.avatarname $orderby", $avatarsperpage, $avatarsperpage * ($page - 1));
		while ($row = $db->fetch_array($result)) {
			
			$avatarname = "../images/avatars/avatar-$row[avatarid].$row[avatarextension]";
			$avatarwidth = $row['width'];
			$avatarheight = $row['height'];
			
			if ($row['avatarextension'] == 'swf') eval("\$avatarimage = \"".$tpl->get("avatar_flash")."\";"); 
			else eval("\$avatarimage = \"".$tpl->get("avatar_image")."\";"); 
			
			$rowclass = getone($count, 'firstrow', 'secondrow');
			
			$row['avatarname'] = htmlconverter($row['avatarname']);
			$row['avatarextension'] = htmlconverter($row['avatarextension']);
			if ($row['title'] == '') $row['title'] = $lang->get("LANG_ACP_AVATAR_ALLGROUPS");
			else $row['title'] = getlangvar($row['title'], $lang);
			
			eval("\$avatar_viewbit .= \"".$tpl->get("avatar_viewbit", 1)."\";"); 
			$count++;
		}
	}
	
	if ($avatarcount) $countfrom = 1 + $avatarsperpage * ($page - 1);
	else $countfrom = 0;
	$countto = $avatarsperpage * $page;
	if ($countto > $avatarcount) $countto = $avatarcount;
	if ($pages > 1) $pagelink = makePageLink("avatar.php?action=view&sid=$session[hash]&sortby=$sortby&orderby=$orderby", $page, $pages, 2);
	
	$colspan = (($_REQUEST['sortby'] != "1") ? (4 + (int)checkAdminPermissions("a_can_avatars_edit")) : (3)) + (int)checkAdminPermissions("a_can_avatars_del");
	
	$lang->items['LANG_ACP_AVATAR_SHOW'] = $lang->get("LANG_ACP_AVATAR_SHOW", array('$countfrom' => $countfrom, '$countto' => $countto, '$avatarcount' => $avatarcount));
	eval("\$tpl->output(\"".$tpl->get("avatar_view", 1)."\",1);");
}



/** add an avatar **/
if ($action == 'add') {
	checkAdminPermissions('a_can_avatars_add', 1);
	if (isset($_POST['send'])) {
		if ($_FILES['avatar_file']['tmp_name'] == 'none') $avatar_error = acp_error_frame($lang->get("LANG_ACP_AVATAR_ERROR_1"));
		else {
			$avatar_extension = wbb_strtolower(wbb_substr(strrchr($_FILES['avatar_file']['name'], "."), 1));
			$avatar_name =  wbb_substr($_FILES['avatar_file']['name'], 0, (intval(wbb_strlen($avatar_extension)) + 1) * -1);
			
			$db->query("INSERT INTO bb".$n."_avatars (avatarname,avatarextension,groupid,needposts,userid) VALUES ('".addslashes($avatar_name)."', '".addslashes($avatar_extension)."','".$_POST['groupid']."', '".$_POST['needposts']."', '0')");
			$avatarid = $db->insert_id();
			if (move_uploaded_file($_FILES['avatar_file']['tmp_name'], "./../images/avatars/avatar-".$avatarid.".".$avatar_extension."")) {
				@chmod("./../images/avatars/avatar-".$avatarid.".".$avatar_extension, 0777);
				
				$imagesize = @getimagesize("./../images/avatars/avatar-".$avatarid.".".$avatar_extension);
				$width = $imagesize[0];
				$height = $imagesize[1];
				
				$db->unbuffered_query("UPDATE bb".$n."_avatars SET width='$width', height='$height' WHERE avatarid='$avatarid'", 1);
				
				header("Location: avatar.php?action=view&sid=$session[hash]");
				exit();
			}
			else {
				$db->query("DELETE FROM bb".$n."_avatars WHERE avatarid = '".$avatarid."'");
				$avatar_error = acp_error_frame($lang->get("LANG_ACP_AVATAR_ERROR_1"));
			}
		}
	}
	
	$avatar_groupsbit = '';
	$result = $db->query("SELECT groupid, title FROM bb".$n."_groups WHERE grouptype>=4");
	while ($row = $db->fetch_array($result)) $avatar_groupsbit .= makeoption($row['groupid'], getlangvar($row['title'], $lang), "", 0);
	
	eval("\$tpl->output(\"".$tpl->get("avatar_add", 1)."\",1);");
}



/** edit an avatar **/
if ($action == 'edit') {
	checkAdminPermissions('a_can_avatars_edit', 1);
	
	if (isset($_REQUEST['avatarid'])) $avatarid = intval($_REQUEST['avatarid']);
	else $avatarid = 0;
	
	if (isset($_POST['send'])) {
		$db->query("UPDATE bb".$n."_avatars SET groupid = '".intval($_POST['groupid'])."', needposts = '".intval($_POST['needposts'])."' WHERE avatarid = '".$avatarid."'");
		header("Location: avatar.php?action=view&sid=$session[hash]");
		exit();
	}
	
	$avatar = $db->query_first("SELECT avatarid, avatarname, avatarextension, width, height, groupid, needposts FROM bb".$n."_avatars WHERE avatarid = '".$avatarid."'");
	
	$avatar_groupsbit = '';
	$result = $db->query("SELECT groupid, title FROM bb".$n."_groups WHERE grouptype>=4");
	while ($row = $db->fetch_array($result)) $avatar_groupsbit .= makeoption($row['groupid'], getlangvar($row['title'], $lang), $avatar['groupid'], 1);
	
	$avatarname = "../images/avatars/avatar-$avatar[avatarid].$avatar[avatarextension]";
	$avatarwidth = $avatar['width'];
	$avatarheight = $avatar['height'];
	
	if ($row['avatarextension'] == "swf") eval("\$avatarimage = \"".$tpl->get("avatar_flash")."\";"); 
	else eval("\$avatarimage = \"".$tpl->get("avatar_image")."\";"); 
	
	$avatar['avatarname'] = htmlconverter($avatar['avatarname']);
	$avatar['avatarextension'] = htmlconverter($avatar['avatarextension']);
	
	eval("\$tpl->output(\"".$tpl->get("avatar_edit", 1)."\",1);");
}




/** delete an avatar **/
if ($action == 'del') {
	checkAdminPermissions('a_can_avatars_del', 1);
	
	if (isset($_REQUEST['avatarid'])) $avatarid = intval($_REQUEST['avatarid']);
	else $avatarid = 0;
	
	$avatar = $db->query_first("SELECT avatarid, avatarname, avatarextension, width, height, userid FROM bb".$n."_avatars WHERE avatarid = '".$avatarid."'");
	
	if (isset($_POST['send'])) {
		$db->query("DELETE FROM bb".$n."_avatars WHERE avatarid = '".$avatarid."'");
		$db->query("UPDATE bb".$n."_users SET avatarid = '0' WHERE avatarid = '".$avatarid."'");
		@unlink("./../images/avatars/avatar-$avatar[avatarid].$avatar[avatarextension]");
		header("Location: avatar.php?action=view&sortby=".(($avatar['userid'] <> 0) ? (1) : (0))."&sid=$session[hash]");
		exit();
	}
	
	$avatarname = "../images/avatars/avatar-$avatar[avatarid].$avatar[avatarextension]";
	$avatarwidth = $avatar['width'];
	$avatarheight = $avatar['height'];
	
	if ($row['avatarextension'] == "swf") eval("\$avatarimage = \"".$tpl->get("avatar_flash")."\";"); 
	else eval("\$avatarimage = \"".$tpl->get("avatar_image")."\";"); 
	
	$avatar['avatarname'] = htmlconverter($avatar['avatarname']);
	$avatar['avatarextension'] = htmlconverter($avatar['avatarextension']);
	
	$lang->items['LANG_ACP_AVATAR_DEL'] = $lang->get("LANG_ACP_AVATAR_DEL", array('$avatarname' => $avatar['avatarname'], '$avatarextension' => $avatar['avatarextension']));
	eval("\$tpl->output(\"".$tpl->get("avatar_del", 1)."\",1);");
}

/** read folder **/
if ($action == 'readfolder') {
	checkAdminPermissions('a_can_avatars_readfolder', 1);
	if (isset($_POST['send'])) {
		$avatarfolder = "../".$_POST['avatarfolder'];
		if (is_dir($avatarfolder) && $avatarfolder != "../images/avatars" && $avatarfolder != "../images/avatars/" && $avatarfolder != "..//images/avatars" && $avatarfolder != "..//images/avatars/") {
			
			$totalcount = 0;
			$goodcount = 0;
			$handle = @opendir($avatarfolder);
			while ($file = readdir($handle)) {	
				if ($file == ".." || $file == "." || !strstr($file, ".")) continue;
				
				$avatar_extension = wbb_strtolower(wbb_substr(strrchr($file, "."), 1));
				$avatar_name = wbb_substr($file, 0, (intval(wbb_strlen($avatar_extension)) + 1) * -1);
				$imagesize = @getimagesize("$avatarfolder/$file");
				$width = $imagesize[0];
				$height = $imagesize[1];
				
				$db->query("INSERT INTO bb".$n."_avatars (avatarname,avatarextension,width,height,groupid,needposts) VALUES ('".addslashes($avatar_name)."', '".addslashes($avatar_extension)."','$width','$height','".intval($_POST['groupid'])."', '".intval($_POST['needposts'])."')");
				$avatarid = $db->insert_id();
				
				if (@copy("$avatarfolder/$file", "../images/avatars/avatar-".$avatarid.".".$avatar_extension)) {
					@chmod("../images/avatars/avatar-".$avatarid.".".$avatar_extension, 0777);
					$goodcount++;
				}
				else $db->query("DELETE FROM bb".$n."_avatars WHERE avatarid = '".$avatarid."'");
				$totalcount++;
			}
			
			acp_message($lang->get("LANG_ACP_AVATAR_READ_OUTPUT", array('$goodcount' => $goodcount, '$totalcount' => $totalcount)));
		}
		else acp_error($lang->get("LANG_ACP_AVATAR_ERROR_2"));
	}
	
	$avatar_groupsbit = '';
	$result = $db->query("SELECT groupid, title FROM bb".$n."_groups WHERE grouptype>=4");
	while ($row = $db->fetch_array($result)) $avatar_groupsbit .= makeoption($row['groupid'], getlangvar($row['title'], $lang), "", 1);
	
	eval("\$tpl->output(\"".$tpl->get("avatar_readfolder", 1)."\",1);");
}




/** backup avatars **/
if ($action == 'backup') {
	checkAdminPermissions('a_can_avatars_readfolder', 1);
	if (isset($_GET['send'])) {
		include('./lib/class_zip.php');
		
		// get mime type
		if (preg_match("/Opera\/[0-9]\.[0-9]{1,2}/", $_SERVER['HTTP_USER_AGENT']) || preg_match("/MSIE [0-9]\.[0-9]{1,2}/", $_SERVER['HTTP_USER_AGENT'])) $mime_type = "application/octetstream";
		else $mime_type = "application/octet-stream";
		
		header("Expires: ".date("D, d M Y H:i:s"));
		header("Content-Type: ".$mime_type);
		if (preg_match("/MSIE [0-9]\.[0-9]{1,2}/", $_SERVER['HTTP_USER_AGENT'])) {
			header("Content-Disposition: inline; filename=\"avatars.zip\"");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Pragma: public");
		}
		else {
			header("Content-Disposition: attachment; filename=\"avatars.zip\"");
			header("Pragma: no-cache");
		}
		
		$z = &new zipfile;
		
		$result = $db->query("SELECT avatarid, avatarname, avatarextension FROM bb".$n."_avatars" );
		
		while ($row = $db->fetch_array($result)) {
			$filename = '../images/avatars/avatar-'.$row['avatarid'].'.'.$row['avatarextension'];
			$fp = fopen($filename, 'rb');
			$filecontent = fread($fp, filesize($filename));
			fclose($fp);
			$z->add_file($filecontent, 'avatar-'.$row['avatarid'].'.'.$row['avatarextension'], filectime($filename));
		}
		echo $z->file();
		exit();
	}
	else {
		eval("\$tpl->output(\"".$tpl->get("avatar_backup", 1)."\",1);");
	}
}
?>
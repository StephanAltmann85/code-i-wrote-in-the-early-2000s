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


require('./global.php');
@set_time_limit(0);
$lang->load('ACP_STYLE');

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = 'view';

/** view styles **/
if ($action == 'view') {
	if (!checkAdminPermissions('a_can_style_edit') && !checkAdminPermissions('a_can_style_del') && !checkAdminPermissions('a_can_style_export')) access_error(1);
	
	$result = $db->unbuffered_query("SELECT s.*, tp.templatepackname, dp.designpackname
	FROM bb".$n."_styles s
	LEFT JOIN bb".$n."_templatepacks tp USING (templatepackid)
	LEFT JOIN bb".$n."_designpacks dp ON (dp.designpackid=s.designpackid)
	ORDER BY s.stylename");
	
	$count = 0;
	$stylebit = '';
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count++, "firstrow", "secondrow");
		
		if (!$row['templatepackid']) $row['templatepackname'] = $lang->get("LANG_ACP_STYLE_DEFAULT_TEMPLATEPACK");
		else $row['templatepackname'] = htmlconverter($row['templatepackname']);
		
		$row['designpackname'] = htmlconverter($row['designpackname']);
		$row['stylename'] = getlangvar($row['stylename'], $lang);
		
		if ($row['styleid'] == 0) $star = "*";
		else $star = '';
		
		eval("\$stylebit .= \"".$tpl->get("style_viewbit", 1)."\";");
	}	
	
	eval("\$tpl->output(\"".$tpl->get("style_view", 1)."\",1);");
}


/** set default style **/
if ($action == 'default') {
	checkAdminPermissions('a_can_style_edit', 1);
	
	$styleid = intval($_REQUEST['styleid']);	
	
	list($newstyleid) = $db->query_first("SELECT MAX(styleid) FROM bb".$n."_styles"); 
	$newstyleid += 1;
	
	$db->unbuffered_query("UPDATE bb".$n."_styles SET styleid='".$newstyleid."' WHERE styleid=0", 1);	
	$db->unbuffered_query("UPDATE bb".$n."_styles SET styleid=0 WHERE styleid='".$styleid."'", 1);
	$db->unbuffered_query("UPDATE bb".$n."_users SET styleid=0 WHERE styleid='".$styleid."'", 1);
	$db->unbuffered_query("UPDATE bb".$n."_sessions SET styleid=0 WHERE styleid='".$styleid."'", 1);
	$db->unbuffered_query("UPDATE bb".$n."_boards SET styleid=0 WHERE styleid='".$styleid."'", 1);
	
	header("Location: style.php?action=view&sid=$session[hash]");
	exit();	
}


/** add style **/
if ($action == 'add') {
	checkAdminPermissions('a_can_style_add', 1);
	
	if (isset($_POST['send'])) {
		$designpackid = intval($_POST['designpackid']);	
		$templatepackid = intval($_POST['templatepackid']);	
		$stylename = trim($_POST['stylename']);
		
		list($styleid) = $db->query_first("SELECT MAX(styleid) FROM bb".$n."_styles");
		$styleid = intval($styleid) + 1;
		
		$db->unbuffered_query("INSERT INTO bb".$n."_styles (styleid,stylename,templatepackid,designpackid) VALUES ('".$styleid."','".addslashes($stylename)."','".$templatepackid."','".$designpackid."')", 1);
		header("Location: style.php?action=view&sid=$session[hash]");
		exit();	
	}
	
	$dp_options = '';
	$result = $db->query("SELECT * FROM bb".$n."_designpacks ORDER BY designpackname ASC");	
	while ($row = $db->fetch_array($result)) $dp_options .= makeoption($row['designpackid'], htmlconverter($row['designpackname']), "", 0);	
	
	$tplp_options = maketemplatepackoptions();
	
	eval("\$tpl->output(\"".$tpl->get("style_add", 1)."\",1);");
}


/** delete style **/
if ($action == 'del') {
	checkAdminPermissions('a_can_style_del', 1);
	
	$styleid = intval($_REQUEST['styleid']);
	list($count) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_styles");
	if ($count == 1) acp_error($lang->get("LANG_ACP_STYLE_DELETE_ONLYONE"));
	
	if (isset($_POST['send'])) {
		$db->unbuffered_query("UPDATE bb".$n."_users SET styleid = 0 WHERE styleid='$styleid'", 1);
		$db->unbuffered_query("UPDATE bb".$n."_boards SET styleid = 0 WHERE styleid='$styleid'", 1);
		$db->unbuffered_query("UPDATE bb".$n."_sessions SET styleid = 0 WHERE styleid='$styleid'", 1);
		$db->unbuffered_query("DELETE FROM bb".$n."_styles WHERE styleid='$styleid'", 1);
		
		// set new default style
		if ($styleid == 0) {
			list($styleid) = $db->query_first("SELECT styleid FROM bb".$n."_styles LIMIT 1");	
			
			$db->unbuffered_query("UPDATE bb".$n."_styles SET styleid=0 WHERE styleid='".$styleid."'", 1);
			$db->unbuffered_query("UPDATE bb".$n."_users SET styleid=0 WHERE styleid='".$styleid."'", 1);
			$db->unbuffered_query("UPDATE bb".$n."_sessions SET styleid=0 WHERE styleid='".$styleid."'", 1);
			$db->unbuffered_query("UPDATE bb".$n."_boards SET styleid=0 WHERE styleid='".$styleid."'", 1);
		}
		
		header("Location: style.php?action=view&sid=$session[hash]");
		exit();
	}
	
	$style = $db->query_first("SELECT stylename FROM bb".$n."_styles WHERE styleid='$styleid'");	
	$style['stylename'] = getlangvar($style['stylename'], $lang);
	
	$lang->items['LANG_ACP_STYLE_DELETE'] = $lang->get("LANG_ACP_STYLE_DELETE", array('$stylename' => $style['stylename']));
	eval("\$tpl->output(\"".$tpl->get("style_del", 1)."\",1);");	
}


/** edit style **/
if ($action == 'edit') {
	checkAdminPermissions('a_can_style_edit', 1);
	
	$styleid = intval($_REQUEST['styleid']);
	
	if (isset($_POST['send'])) {
		$designpackid = intval($_POST['designpackid']);	
		$templatepackid = intval($_POST['templatepackid']);	
		$stylename = trim($_POST['stylename']);
		
		$db->unbuffered_query("UPDATE bb".$n."_styles SET stylename='".addslashes($stylename)."', templatepackid='$templatepackid', designpackid='$designpackid' WHERE styleid='$styleid'", 1);
		header("Location: style.php?action=view&sid=$session[hash]");
		exit();	
	}
	
	$style = $db->query_first("SELECT * FROM bb".$n."_styles WHERE styleid='$styleid'");	
	
	$dp_options = '';
	$result = $db->query("SELECT * FROM bb".$n."_designpacks ORDER BY designpackname ASC");	
	while ($row = $db->fetch_array($result)) $dp_options .= makeoption($row['designpackid'], htmlconverter($row['designpackname']), $style['designpackid'], 1);	
	
	$tplp_options = maketemplatepackoptions( - 1, 0, $style['templatepackid']);
	
	$style['stylename'] = htmlconverter($style['stylename']);
	
	eval("\$tpl->output(\"".$tpl->get("style_edit", 1)."\",1);");	
}


/** export style **/
if ($action == 'export') {
	checkAdminPermissions('a_can_style_export', 1);
	
	if (isset($_REQUEST['styleid'])) $styleid = intval($_REQUEST['styleid']);
	else $styleid = 0;
	$style_info = $db->query_first("SELECT * FROM bb".$n."_styles WHERE styleid='".$styleid."'");
	
	if ($_POST['send']) {
		$data = array();
		$data['general'] = array();
		
		// general style export info
		$data['general']['stylename'] = $_POST['stylename'];
		$data['general']['wbbversion'] = $boardversion;
		$data['general']['exportdate'] = time();
		
		if (isset($_POST['exportdesignpack']) && intval($_POST['exportdesignpack']) == 1) {
			// designpack data
			$data['designpack'] = array();
			$data['designpack']['designpackname'] = $_POST['designpackname'];
			
			// designelements
			$data['designpack']['designelements'] = array();
			$result = $db->query("SELECT * FROM bb".$n."_designelements WHERE designpackid='".$style_info['designpackid']."'");
			while ($row = $db->fetch_array($result)) $data['designpack']['designelements'][$row['element']] = array("element" => $row['element'], "value" => $row['value']);
		}
		
		if (isset($_POST['templates']) && is_array($_POST['templates']) && count($_POST['templates'])) {
			// templates
			$templateids = implode(",", intval_array($_POST['templates']));
			$result = $db->query("SELECT templatename,template FROM bb".$n."_templates WHERE templatepackid='$style_info[templatepackid]' AND templateid IN ($templateids)");
			if ($db->num_rows($result)) $data['templates'] = array();
			while ($row = $db->fetch_array($result)) $data['templates'][$row['templatename']] = array("templatename" => $row['templatename'], "template" => $row['template']);
		}
		
		if (isset($_POST['images']) && is_array($_POST['images']) && count($_POST['images'])) {
			// images
			$data['images'] = array();
			list($imagefolder) = $db->query_first("SELECT value FROM bb".$n."_designelements WHERE designpackid='".$style_info['designpackid']."' AND element='imagefolder'");
			
			foreach ($_POST['images'] as $imagename) {
				if (is_file("../".$imagefolder."/".$imagename)) {
					$fh = fopen("../".$imagefolder."/".$imagename, "rb");
					$imagecontent = fread($fh, filesize("../".$imagefolder."/".$imagename));
					fclose($fh);
					$data['images'][$imagename] = array("imagename" => $imagename, "image" => $imagecontent);
				}
			}
		}
		
		$data = wordwrap(base64_encode(serialize($data)), 70, "\n", 1);
		
		if (preg_match("/MSIE [0-9]\.[0-9]{1,2}/", $_SERVER['HTTP_USER_AGENT'])) $browser_type = 1; // IE 
		else if (preg_match("/Opera\/[0-9]\.[0-9]{1,2}/", $_SERVER['HTTP_USER_AGENT'])) $browser_type = 2; // Opera
		else $browser_type = 3; // other...

		if ($browser_type == 1) $content_disp = "inline; ";
		else $content_disp = "attachment; ";
		$filename = "style-export-".$style_info['stylename'];
		
		// gzip style
		if (isset($_POST['gzip']) && $_POST['gzip'] && function_exists("gzencode")) {
			$data = gzencode($data);
			$extension = "gz";
			$mime_type = "application/x-gzip";
		}
		else {
			$extension = "style";
			if ($browser_type == 1 || $browser_type == 2) $mime_type = "application/octetstream";
			else $mime_type = "application/octet-stream";
		}
  

		// send file to browser
		header('Content-Type: '.$mime_type);
		header('Content-disposition: '.$content_disp.'filename="'.$filename.'.'.$extension.'"');
		if ($browser_type == 1) header('Pragma: public');
		else header('Pragma: no-cache');
		header('Expires: 0');
		echo $data;
	}
	else {
		$designpack_info = $db->query_first("SELECT * FROM bb".$n."_designpacks WHERE designpackid='$style_info[designpackid]'", 0, 0, MYSQL_ASSOC);
		$designelements = array();
		$result = $db->query("SELECT * FROM bb".$n."_designelements WHERE designpackid='$style_info[designpackid]'");
		while ($row = $db->fetch_array($result, MYSQL_ASSOC)) $designelements[$row['element']] = $row['value'];
		
		if ($style_info['templatepackid']) $templatepack_info = $db->query_first("SELECT * FROM bb".$n."_templatepacks WHERE templatepackid='$style_info[templatepackid]'", 0, 0, MYSQL_ASSOC);
		else $templatepack_info = array();
		
		$template_options = '';
		$result = $db->query("SELECT templateid,templatename FROM bb".$n."_templates WHERE templatepackid='$style_info[templatepackid]' ORDER BY templatename ASC");
		while ($row = $db->fetch_array($result, MYSQL_ASSOC)) $template_options .= makeoption($row['templateid'], htmlconverter($row['templatename']), 0, "");
		
		$image_options = makeimageoptions();
		
		$style_info['stylename'] = htmlconverter($style_info['stylename']);
		$designpack_info['designpackname'] = htmlconverter($designpack_info['designpackname']);
				
		eval("\$tpl->output(\"".$tpl->get("style_export", 1)."\",1);");
	}
}


/** style import / export **/
if ($action == 'import/export') {
	if (!checkAdminPermissions('a_can_style_export') && !checkAdminPermissions('a_can_style_import')) access_error(1);
	
	$style_options = '';	
	$result = $db->query("SELECT styleid, stylename FROM bb".$n."_styles ORDER BY stylename ASC");
	while ($row = $db->fetch_array($result)) $style_options .= makeoption($row['styleid'], getlangvar($row['stylename'], $lang), "", 0);
	
	eval("\$tpl->output(\"".$tpl->get("style_import_export", 1)."\",1);");
}


/** style import **/
if ($action == 'import_start') {
	checkAdminPermissions('a_can_style_import', 1);
	
	$mode = $_POST['mode'];
	if ($mode == "local") $stylefile = $_POST['stylefile'];
	else {
		if (isset($_FILES['uploadfile']['tmp_name']) && $_FILES['uploadfile']['tmp_name'] && is_uploaded_file($_FILES['uploadfile']['tmp_name'])) {
			$tempfile = "./temp/styleimport_".md5(uniqid(rand()));
			while (file_exists($tempfile)) $tempfile = "./temp/styleimport_".md5(uniqid(rand()));
			if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $tempfile)) {
				$stylefile = $tempfile;
				chmod($tempfile, 0777);
			}
		}
	}
	
	if (!$stylefile || !file_exists($stylefile)) {
		header("Location: style.php?action=import/export&sid=$session[hash]");
		exit;	
	}
	if (wbb_substr((($mode == "local") ? ($stylefile) : ($_FILES['uploadfile']['name'])), - 3) == ".gz" && function_exists("gzfile")) {
		$content = implode("", gzfile($stylefile));
		if ($mode == "local") {
			$stylefile = "./temp/styleimport_".md5(uniqid(rand()));
			while (file_exists($stylefile)) $stylefile = "./temp/styleimport_".md5(uniqid(rand()));
		}
		$fh = fopen($stylefile, "wb");
		fwrite($fh, $content);
		fclose($fh);
		chmod($stylefile, 0777);
		unset($content);
	}
	
	$fp = fopen($stylefile, "rb");
	$data = unserialize(base64_decode(str_replace("\n", "", fread($fp, filesize($stylefile)))));
	fclose($fp);
	
	$exportdate = formatdate($wbbuserdata['dateformat'] . " ". $wbbuserdata['timeformat'], $data['general']['exportdate']);
	
	$template_options = '';
	if (isset($data['templates']) && count($data['templates'])) {
		$templatepack_options = maketemplatepackoptions();
		
		while (list(, $template) = each($data['templates'])) {
			$template['templatename'] = htmlconverter($template['templatename']);
			$template_options .= makeoption($template['templatename'], $template['templatename'], 0, "");
		}
	}
	
	$image_options = '';
	if (isset($data['images']) && count($data['images'])) {
		
		$slashcount = 0;
		$slashcountprev = 0;
		$dirprev = '';
		$dir = '';
		
		while (list(, $image) = each($data['images'])) {
			
			if (strstr($image['imagename'], "/")) {
				$filename = basename($image['imagename']);
				$dir = wbb_substr($image['imagename'], 0, wbb_strrpos($image['imagename'], "/"));
				$slashcount = wbb_substr_count($image['imagename'], "/");
			}
			else {
				$filename = $image['imagename'];
				$dir = '';
				$slashcount = 0;
			}
			
			if ($dirprev != $dir && $slashcount > $slashcountprev) $image_options .= makeoption("", str_repeat("-", $slashcount)." /".htmlconverter($dir), 0, "");
			$image_options .= makeoption(htmlconverter($image['imagename']), (($slashcount) ? (str_repeat("&nbsp;", $slashcount)."&nbsp;&nbsp;") : ("")).htmlconverter($filename), 0, "");
			$dirprev = $dir;
			$slashcountprev = $slashcount;
		}
		
	}
	
	eval("\$tpl->output(\"".$tpl->get("style_import", 1)."\",1);");
}


/** preview an image **/
if ($action == 'imagepreview') {
	if (!checkAdminPermissions('a_can_style_import')) exit;
 	
	$stylefile = $_REQUEST['stylefile'];
	$image = $_REQUEST['image'];
	
	$fp = fopen($stylefile, "rb");
	$data = unserialize(base64_decode(str_replace("\n", "", fread($fp, filesize($stylefile)))));
	fclose($fp);
	
	if (isset($data['images'][$image]) && $data['images'][$image]) {
		$mime_type = '';
		if (wbb_strtolower(wbb_substr($image, - 4)) == ".gif") $mime_type = "image/gif";
		elseif (wbb_strtolower(wbb_substr($image, - 4)) == ".jpg") $mime_type = "image/jpeg";
		elseif (wbb_strtolower(wbb_substr($image, - 5)) == ".jpeg") $mime_type = "image/jpeg";
		elseif (wbb_strtolower(wbb_substr($image, - 4)) == ".png") $mime_type = "image/png";
		header ("Content-type: ".$mime_type);
		echo $data['images'][$image]['image'];
	}
}


/** import style **/
if ($action == 'import') {
	checkAdminPermissions('a_can_style_import', 1);
	
	$stylefile = $_REQUEST['stylefile'];
	if (isset($_REQUEST['doimport'])) $doimport = intval($_REQUEST['doimport']);
	else $doimport = 0;
	if (isset($_REQUEST['importstyle'])) $importstyle = intval($_REQUEST['importstyle']);
	else $importstyle = 0;
	if (isset($_REQUEST['importdesignpack'])) $importdesignpack = intval($_REQUEST['importdesignpack']);
	else $importdesignpack = 0;
	$templates_imported = 0;
	
	if ($doimport == 1) {
		$fp = fopen($stylefile, "rb");
		$data = unserialize(base64_decode(str_replace("\n", "", fread($fp, filesize($stylefile)))));
		fclose($fp);
		
		// does it make sense to import a style without a designpack?
		if ($importstyle == 1 && !$importdesignpack) $importstyle = $importdesignpack = 1;
		
		$designpackid = 0;
		// import designpack
		if ($importdesignpack == 1) {
			$db->query("INSERT INTO bb".$n."_designpacks (designpackname) VALUES ('".addslashes($_POST['designpackname'])."')");
			$designpackid = $db->insert_id();
			
			if (isset($data['designpack']['designelements']) && count($data['designpack']['designelements'])) {
				while (list(, $designelement) = each($data['designpack']['designelements'])) $db->unbuffered_query("INSERT INTO bb".$n."_designelements (designpackid, element, value) VALUES ('$designpackid', '".addslashes($designelement['element'])."', '".addslashes($designelement['value'])."')");
			} 
		}
		
		$templatepackid = 0;
		// import templates
		if (isset($_POST['templates']) && is_array($_POST['templates']) && count($_POST['templates'])) {
			if (isset($data['templates']) && count($data['templates'])) {
				if (isset($_POST['templatepackname']) && trim($_POST['templatepackname'])) {
					$db->query("INSERT INTO bb".$n."_templatepacks (templatepackname) VALUES ('".addslashes($_POST['templatepackname'])."')");
					$templatepackid = $db->insert_id();
				}
				else $templatepackid = intval($_POST['templatepackid']);
				
				foreach ($_POST['templates'] as $template) {
					if (!isset($data['templates'][$template]) || !$data['templates'][$template]) continue;
					$db->unbuffered_query("REPLACE INTO bb".$n."_templates (templatepackid, templatename, template) VALUES ('$templatepackid', '".addslashes($template)."', '".addslashes($data['templates'][$template]['template'])."')");
				}
				updateTemplateStructure();
				$templates_imported = 1;
			}
		}
		
		// import style
		if ($importstyle == 1) {
			if (!$designpackid) {
				list($designpackid) = $db->query_first("SELECT designpackid FROM bb".$n."_designpacks ORDER BY designpackid ASC LIMIT 1");
			}
			
			list($styleid) = $db->query_first("SELECT MAX(styleid) FROM bb".$n."_styles");
			$styleid = intval($styleid) + 1;
			
			$db->query("INSERT INTO bb".$n."_styles (styleid,stylename,templatepackid,designpackid) VALUES ('".$styleid."','".addslashes($_POST['stylename'])."', '".$templatepackid."', '".$designpackid."')");
		}
		
		// import images
		if (isset($_POST['images']) && is_array($_POST['images']) && count($_POST['images'])) {
			if (isset($_POST['imagefolder'])) $imagefolder = $_POST['imagefolder'];
			elseif (isset($data['designelements']['imagefolder'])) $imagefolder = $data['designpack']['designelements']['imagefolder'];
			if (isset($data['images']) && count($data['images'])) {
				foreach ($_POST['images'] as $image) {
					if (!isset($data['images'][$image]) || !$data['images'][$image]) continue;
					$filename = ((strstr($image, "/")) ? (basename($image)) : ($image));
					$dir = ((strstr($image, "/")) ? (dirname($image)) : (""));
					$destination = "../".$imagefolder.(($dir) ? ("/".$dir) : (""));
					
					if (!is_dir($destination)) @mkdir($destination, 0777);
					if (!is_writeable($destination)) continue;
					
					$fh2 = fopen($destination."/".$filename, "wb");
					fwrite($fh2, $data['images'][$image]['image']);
					fclose($fh2);
					chmod($destination."/".$filename, 0777);
				}
			}
		}
	}
	
	
	if (preg_match("/^\.\/temp\/styleimport_[^\/]+$/", $stylefile)) unlink($stylefile);
	
	if ($templates_imported) header("Location: template.php?action=cache&sid=$session[hash]");
	else header("Location: style.php?action=import/export&sid=$session[hash]");
	exit;
}





/** functions for style import / export **/
function makeimageoptions($dir = '', $level = 0) {
	global $designelements;
	$image_options = '';
	if ($dir) $image_options .= makeoption("", str_repeat("-", $level)." /".$dir, 0, "");
	
	$dirh = @opendir("../".$designelements['imagefolder'].(($dir) ? ("/".$dir) : ("")));
	while ($imagename = @readdir($dirh)) {
		if (is_file("../".$designelements['imagefolder'].(($dir) ? ("/".$dir) : (""))."/".$imagename)) $image_options .= makeoption(htmlconverter((($dir) ? ($dir."/") : ("")).$imagename), (($dir && $level) ? (str_repeat("&nbsp;", $level)."&nbsp;&nbsp;") : ("")).htmlconverter($imagename), 0, "");
		elseif (is_dir("../".$designelements['imagefolder'].(($dir) ? ("/".$dir) : (""))."/".$imagename) && $imagename != ".." && $imagename != "." && $imagename != "avatars") $image_options .= makeimageoptions((($dir) ? ($dir."/") : ("")).$imagename, $level + 1);
	}
	@closedir($dirh);
	
	return $image_options;
}
?>
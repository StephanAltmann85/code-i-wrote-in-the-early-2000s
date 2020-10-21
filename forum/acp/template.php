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
$lang->load('ACP_TEMPLATE');

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = 'view';

/** view templates **/
if ($action == 'view') {
	if (!checkAdminPermissions("a_can_template_add") && !checkAdminPermissions("a_can_template_edit") && !checkAdminPermissions("a_can_template_copy") && !checkAdminPermissions("a_can_template_del")) access_error(1); 
	if (isset($_REQUEST['templatepackid'])) $templatepackid = $_REQUEST['templatepackid'];
	else $templatepackid = 0;
	
	$count = 0;
	$template_options = "";
	$result = $db->unbuffered_query("SELECT templateid, templatename FROM bb".$n."_templates WHERE templatepackid = '$templatepackid' ORDER BY templatename ASC");
	while ($row = $db->fetch_array($result)) {
		$template_options .= makeoption($row['templateid'], htmlconverter($row['templatename']), "", 0)."\n";
		$count++;
	}
	
	$templatepack_options = maketemplatepackoptions( - 1, 0, $templatepackid);
	
	$lang->items['LANG_ACP_TEMPLATE_COUNT'] = $lang->get("LANG_ACP_TEMPLATE_COUNT", array('$count' => $count));
	eval("\$tpl->output(\"".$tpl->get("template_view", 1)."\",1);");
}


/** add new template **/
if ($action == "add") {
	checkAdminPermissions("a_can_template_add", 1);
	if (isset($_REQUEST['templatepackid'])) $templatepackid = intval($_REQUEST['templatepackid']);
	else $templatepackid = 0;
	$error = "";
	
	if (isset($_POST['send'])) {
		$template = $_POST['template'];
		$templatename = wbb_trim($_POST['templatename']);
		
		if (!$templatename) $error = acp_error_frame($lang->get("LANG_ACP_GLOBAL_ERROR_EMPTYFIELDS"));
		else {
			$result = $db->query_first("SELECT COUNT(*) FROM bb".$n."_templates WHERE templatepackid='$templatepackid' AND templatename='".addslashes($templatename)."'");	
			if ($result[0]) $error = acp_error_frame($lang->get("LANG_ACP_TEMPLATE_ERROR_1"));
			else {
				
				// parse template
				include_once("./lib/class_templateparser.php");
				$tplparser = new TemplateParser();
				$c_template = $tplparser->parse(dos2unix($template));
				
				if (@is_file("./../cache/templates/" . $templatepackid . "_" . $templatename . ".php") && !@is_writeable("./../cache/templates/" . $templatepackid . "_" . $templatename . ".php")) $error = acp_error_frame($lang->get("LANG_ACP_TEMPLATE_ERROR_3"));
				else {
					// cache template
					$fp = @fopen("./../cache/templates/" . $templatepackid . "_" . $templatename . ".php", "w+b");
					
					@fwrite($fp, "<?php
					/*
					templatepackid: ".$templatepackid."
					templatename: ".$templatename."
					*/
					
					\$this->templates['".$templatename."']=\"".addcslashes($c_template, "$\"\\")."\";
					?>");
					@fclose($fp);
					@chmod("./../cache/templates/" . $templatepackid . "_" . $templatename . ".php", 0777);
					unset($c_template);
					
					// save template in db
					$db->query("INSERT INTO bb".$n."_templates (templatepackid,templatename,template,recompile) VALUES ('$templatepackid','".addslashes($templatename)."','".addslashes($template)."', '0')");
					$templateid = $db->insert_id();
					updateTemplateStructure();
					header("Location: template.php?action=edit&templateid=$templateid&sid=$session[hash]");
					exit();
				}
				
			}
		}	
	}
	
	$templatepack_options = maketemplatepackoptions( - 1, 0, $templatepackid);
	
	$template = htmlconverter($template);
	$templatename = htmlconverter($templatename);
	
	eval("\$tpl->output(\"".$tpl->get("template_editor", 1)."\",1);");
}


/** edit template **/
if ($action == "edit") {
	checkAdminPermissions("a_can_template_edit", 1);
	if (isset($_REQUEST['templateid'])) $templateid = intval($_REQUEST['templateid']);
	else $templateid = 0;
	$error = "";
	$result = $db->query_first("SELECT * FROM bb".$n."_templates WHERE templateid='$templateid'");
	
	if (isset($_POST['send'])) {
		$template = $_POST['template'];
		$templatename = wbb_trim($_POST['templatename']);
		$templatepackid = intval($_POST['templatepackid']);
		
		if (!$templatename) $error = acp_error_frame($lang->get("LANG_ACP_GLOBAL_ERROR_EMPTYFIELDS"));
		else {
			if ($templatepackid != $result['templatepackid'] || $templatename != $result['templatename']) $doublecheck = $db->query_first("SELECT COUNT(*) FROM bb".$n."_templates WHERE templatepackid='$templatepackid' AND templatename='".addslashes($templatename)."'");	
			else $doublecheck[0] = 0;
			if ($doublecheck[0]) $error = acp_error_frame($lang->get("LANG_ACP_TEMPLATE_ERROR_1"));
			else {
				
				// parse template
				include_once("./lib/class_templateparser.php");
				$tplparser = new TemplateParser();
				$c_template = $tplparser->parse(dos2unix($template));
				
				
				if (@is_file("./../cache/templates/" . $templatepackid . "_" . $templatename . ".php") && !@is_writeable("./../cache/templates/" . $templatepackid . "_" . $templatename . ".php")) $error = acp_error_frame($lang->get("LANG_ACP_TEMPLATE_ERROR_3"));
				else {
					// cache template
					$fp = @fopen("./../cache/templates/" . $templatepackid . "_" . $templatename . ".php", "w+b");
					@fwrite($fp, "<?php
					/*
					templatepackid: ".$templatepackid."
					templatename: ".$templatename."
					*/
					
					\$this->templates['".$templatename."']=\"".addcslashes($c_template, "$\"\\")."\";
					?>");
					@fclose($fp);
					@chmod("./../cache/templates/" . $templatepackid . "_" . $templatename . ".php", 0777);
					unset($c_template);
					
					// save template in db
					$db->query("UPDATE bb".$n."_templates SET templatepackid='$templatepackid', templatename='".addslashes($templatename)."', template='".addslashes($template)."', recompile = '0' WHERE templateid='$templateid'");
					
					if ($templatepackid != $result['templatepackid'] || $templatename != $result['templatename']) {
						@unlink("./../cache/templates/".$result['templatepackid']."_".$result['templatename'].".php");
						updateTemplateStructure();
					}
				}
				
			}
		}	
	}
	else {
		$template = $result['template'];
		$templatename = $result['templatename'];
		$templatepackid = $result['templatepackid'];
	}
	
	$templatepack_options = maketemplatepackoptions(-1, 0, $templatepackid);
	
	$template = htmlconverter($template);  
	$templatename = htmlconverter($templatename);
	eval("\$tpl->output(\"".$tpl->get("template_editor", 1)."\",1);");
}


/** copy template **/
if ($action == "copy") {
	checkAdminPermissions("a_can_template_copy", 1);
	if (isset($_REQUEST['templateid'])) $templateid = intval($_REQUEST['templateid']);
	else $templateid = 0;
	
	if (isset($_POST['send'])) {
		$template = $_POST['template'];
		$templatename = wbb_trim($_POST['templatename']);
		$templatepackid = intval($_POST['templatepackid']);
		
		if (!$templatename) $error = acp_error_frame($lang->get("LANG_ACP_GLOBAL_ERROR_EMPTYFIELDS"));
		else {
			$result = $db->query_first("SELECT COUNT(*) FROM bb".$n."_templates WHERE templatepackid='$templatepackid' AND templatename='".addslashes($templatename)."'");	
			if ($result[0]) $error = acp_error_frame($lang->get("LANG_ACP_TEMPLATE_ERROR_1"));
			else {
				
				// parse template
				include_once("./lib/class_templateparser.php");
				$tplparser = new TemplateParser();
				$c_template = $tplparser->parse($template);
				
				
				if (@is_file("./../cache/templates/" . $templatepackid . "_" . $templatename . ".php") && !@is_writeable("./../cache/templates/" . $templatepackid . "_" . $templatename . ".php")) $error = acp_error_frame($lang->get("LANG_ACP_TEMPLATE_ERROR_3"));
				else {
					// cache template
					$fp = @fopen("./../cache/templates/" . $templatepackid . "_" . $templatename . ".php", "w+b");
					@fwrite($fp, "<?php
					/*
					templatepackid: ".$templatepackid."
					templatename: ".$templatename."
					*/
					
					\$this->templates['".$templatename."']=\"".addcslashes($c_template, "$\"\\")."\";
					?>");
					@fclose($fp);
					@chmod("./../cache/templates/" . $templatepackid . "_" . $templatename . ".php", 0777);
					unset($c_template);
					
					// save template in db
					$db->query("INSERT INTO bb".$n."_templates (templatepackid,templatename,template,recompile) VALUES ('$templatepackid','".addslashes($templatename)."','".addslashes($template)."', '0')");
					$templateid = $db->insert_id();
					updateTemplateStructure();
					header("Location: template.php?action=edit&templateid=$templateid&sid=$session[hash]");
					exit();
				}
				
			}
		}	
	}
	else {
		$result = $db->query_first("SELECT * FROM bb".$n."_templates WHERE templateid='$templateid'");
		$template = $result['template'];
		$templatename = $result['templatename'];
		$templatepackid = $result['templatepackid'];
	}
	
	$templatepack_options = maketemplatepackoptions(-1, 0, $templatepackid);
	
	$template = htmlconverter($template);
	$templatename = htmlconverter($templatename);
	eval("\$tpl->output(\"".$tpl->get("template_editor", 1)."\",1);");			
}


/** delete template **/
if ($action == "del") {
	checkAdminPermissions("a_can_template_del", 1);
	if (isset($_REQUEST['templateid'])) $templateid = intval($_REQUEST['templateid']);
	else $templateid = 0;
	
	$template = $db->query_first("SELECT templatename, templatepackid FROM bb".$n."_templates WHERE templateid='$templateid'");
	
	if (isset($_POST['send'])) {
		@unlink("./../cache/templates/" . $template['templatepackid'] . "_" . $template['templatename'] . ".php");
		
		$db->query("DELETE FROM bb".$n."_templates WHERE templateid='$templateid'");
		updateTemplateStructure();
		header("Location: template.php?action=view&templatepackid=$template[templatepackid]&sid=$session[hash]");
		exit();	
	}
	
	$lang->items['LANG_ACP_TEMPLATE_DEL_SURE'] = $lang->get("LANG_ACP_TEMPLATE_DEL_SURE", array('$templatename' => $template['templatename']));
	eval("\$tpl->output(\"".$tpl->get("template_del", 1)."\",1);");	
}


/** search / replace in templates **/
if ($action == "search") {
	checkAdminPermissions("a_can_template_search", 1);
	if (isset($_REQUEST['templatepackid'])) $templatepackid = $_REQUEST['templatepackid'];
	else $templatepackid = "*";
	
	if ($templatepackid != "*") $templateid = intval($templatepackid);
	
	if (isset($_POST['send'])) {
		if (!$_POST['search']) $error = acp_error($lang->get("LANG_ACP_GLOBAL_ERROR_NORESULT"));
		if (isset($_POST['dosearch'])) {
			$where_templateid = '';   
			if ($templatepackid != "*") {
				if (count($_POST['templateid'])) {
					$templateids = implode(",", $_POST['templateid']);
					$where_templateid = " t.templateid IN (".$templateids.") AND";
				}
				else $where_templateid = " t.templateid IN (0) AND"; 
			} 
			$result = $db->query("SELECT t.templateid, t.templatename, t.templatepackid, p.templatepackname FROM bb".$n."_templates t LEFT JOIN bb".$n."_templatepacks p USING(templatepackid) WHERE$where_templateid t.template LIKE '%".addslashes($_POST['search'])."%' ORDER BY p.templatepackname ASC, t.templatename ASC");
			if (!$db->num_rows($result)) $error = acp_error($lang->get("LANG_ACP_GLOBAL_ERROR_NORESULT"));
			$i = 0;
			$resultbit = '';
			while ($row = $db->fetch_array($result)) {
				$rowclass = getone($i++, "firstrow", "secondrow");
				if (!$row['templatepackid']) $defaultname = $lang->get("LANG_ACP_TEMPLATE_DEFAULTPACK");
				else $defaultname = '';
				eval("\$resultbit .= \"".$tpl->get("template_search_resultbit", 1)."\";");
			}
			eval("\$tpl->output(\"".$tpl->get("template_search_result", 1)."\",1);");
			exit();
		}
		elseif (isset($_POST['doreplace'])) {
			$where_templateid = '';   
			if ($templatepackid != "*") {
				if (count($_POST['templateid'])) {
					$templateids = implode(",", $_POST['templateid']);
					$where_templateid = " templateid IN (".$templateids.") AND";
				}
				else $where_templateid = " templateid IN (0) AND"; 
			} 
			
			$db->query("UPDATE bb".$n."_templates SET template=REPLACE(template,'".addslashes($_POST['search'])."','".addslashes($_POST['replace'])."'), recompile = 1 WHERE$where_templateid template LIKE '%".addslashes($_POST['search'])."%'");
			$count = $db->affected_rows();
			
			acp_message($lang->get("LANG_ACP_TEMPLATE_REPLACE_RESULT", array('$count' => $count, '$sessionhash' => $session['hash'])));
			exit;
		}
	}	
	
	$template_options = '';
	if ($templatepackid != "*") {
		$count = 0;
		$result = $db->query("SELECT templateid, templatename FROM bb".$n."_templates WHERE templatepackid = '$templatepackid' ORDER BY templatename ASC");
		while ($row = $db->fetch_array($result)) {
			$template_options .= makeoption($row['templateid'], $row['templatename'], "", 0)."\n";
			$count++;
		}
	}
	
	$templatepack_options = maketemplatepackoptions( - 1, 0, ($templatepackid != "*" ? $templatepackid : - 1));
	
	eval("\$tpl->output(\"".$tpl->get("template_search", 1)."\",1);");
}


/** import / export templates **/
if ($action == "import/export") {
	if (!checkAdminPermissions("a_can_template_import") && !checkAdminPermissions("a_can_template_export")) access_error(1);
	if (isset($_REQUEST['templatepackid'])) $templatepackid = $_REQUEST['templatepackid'];
	else $templatepackid = "*";
	
	$templatefolderValue = "templates";
	
	$template_options = '';
	if ($templatepackid != "*") {
		if ($templatepackid == 0) $selected = " selected=\"selected\"";
		$count = 0;
		$result = $db->query("SELECT templateid, templatename FROM bb".$n."_templates WHERE templatepackid = '$templatepackid' ORDER BY templatename ASC");
		while ($row = $db->fetch_array($result)) {
			$template_options .= makeoption($row['templateid'], $row['templatename'], $_POST['templatepackid'])."\n";
			$count++;
		}
	}
	
	$templatepack_options = maketemplatepackoptions( - 1, 0, ($templatepackid != "*" ? $templatepackid : - 1));
	
	$fileimportAction = "fileimport";
	
	$selectbit = '';
	if (isset($_REQUEST['templatefolder'])) {
		$templatefolderValue = $_REQUEST['templatefolder'];
		$templatefolder = "../".$_REQUEST['templatefolder'];
		if (is_dir($templatefolder)) {
			$handle = @opendir($templatefolder);
			while ($file = readdir($handle)) {
				if ($file == ".." || $file == "." || is_dir("$templatefolder/$file")) continue; 
				$filesize = formatFilesize(filesize("$templatefolder/$file"));
				$changedate = formatdate($wbbuserdata['dateformat']." ".$wbbuserdata['timeformat'], filemtime("$templatefolder/$file"));
				$perms = (wbb_substr(sprintf("%o", fileperms("$templatefolder/$file")), 3));
				eval("\$selectbit .= \"".$tpl->get("template_import_selectbit", 1)."\";");
			}
			
			$fileimportAction = "fileimport2";
			eval("\$importSelect = \"".$tpl->get("template_import_select", 1)."\";");
		}	
	}
	
	eval("\$tpl->output(\"".$tpl->get("template_import_export", 1)."\",1);");
}


/** export templates **/
if ($action == "export") {
	checkAdminPermissions("a_can_template_export", 1); 
	$errors = 0;
	
	if (isset($_POST['templateid'])) {
		if (count($_POST['templateid'])) {
			if ($_POST['templatepackid'] == 0) $templatefolder = "./../templates";
			else {
				list($templatefolder) = $db->query_first("SELECT templatefolder FROM bb".$n."_templatepacks WHERE templatepackid='$_POST[templatepackid]'");
				$templatefolder = "./../$templatefolder";
			}
			if (!is_dir($templatefolder)) @mkdir("$templatefolder", 0777);
			
			$result = $db->query("SELECT templatename, template FROM bb".$n."_templates WHERE templateid IN ('".implode("','", $_POST['templateid'])."')");
			while ($row = $db->fetch_array($result)) {
				if (!$row['templatename']) continue;
				
				if (!@is_writeable($templatefolder) || (@is_file($templatefolder."/".$row['templatename'].".tpl") && !@is_writeable($templatefolder."/".$row['templatename'].".tpl"))) {
					$errors++;
					continue;	
				}
				$fp = @fopen($templatefolder."/".$row['templatename'].".tpl", "w+b");
				@fwrite($fp, dos2unix($row['template']));
				@fclose($fp);
				@chmod($templatefolder."/".$row['templatename'].".tpl", 0777);
			}
		}	
	}
	else {
		if ($_POST['templatepackid'] == "*") {
			if (!is_dir("./../templates")) @mkdir("./../templates", 0777);
			$folder[0] = "./../templates";
			$result = $db->query("SELECT templatepackid, templatefolder FROM bb".$n."_templatepacks");	
			while ($row = $db->fetch_array($result)) {
				if (!@is_dir("./../$row[templatefolder]")) @mkdir("./../$row[templatefolder]", 0777);
				$folder[$row['templatepackid']] = "./../$row[templatefolder]";	
			}
			
			$result = $db->query("SELECT templatepackid, templatename, template FROM bb".$n."_templates");
			while ($row = $db->fetch_array($result)) {
				if (!$row['templatename']) continue;
				
				if (!@is_writeable($folder[$row['templatepackid']])  || (@is_file($folder[$row['templatepackid']]."/".$row['templatename'].".tpl") && !@is_writeable($folder[$row['templatepackid']]."/".$row['templatename'].".tpl"))) {
					$errors++;
					continue;	
				}
				$fp = @fopen($folder[$row['templatepackid']]."/$row[templatename].tpl", "w+b");
				@fwrite($fp, dos2unix($row['template']));
				@fclose($fp);
				@chmod($folder[$row['templatepackid']]."/$row[templatename].tpl", 0777);
			}
		}
		else {
			if ($_POST['templatepackid'] == 0) $templatefolder = "./../templates";
			else {
				list($templatefolder) = $db->query_first("SELECT templatefolder FROM bb".$n."_templatepacks WHERE templatepackid='$_POST[templatepackid]'");
				$templatefolder = "./../$templatefolder";
			}
			
			if (!@is_dir($templatefolder)) @mkdir("$templatefolder", 0777);
			
			$result = $db->query("SELECT templatename, template FROM bb".$n."_templates WHERE templatepackid='$_POST[templatepackid]'");
			while ($row = $db->fetch_array($result)) {
				
				if (!@is_writeable($templatefolder."/".$row['templatename'].".tpl")  || (@is_file($templatefolder."/".$row['templatename'].".tpl") && !@is_writeable($templatefolder."/".$row['templatename'].".tpl"))) {
					$errors++;
					continue;	
				}
				$fp = @fopen($templatefolder."/".$row['templatename'].".tpl", "w+b");
				@fwrite($fp, dos2unix($row['template']));
				@fclose($fp);
				@chmod($templatefolder."/".$row['templatename'].".tpl", 0777);
			}
		}
	}
	
	if ($errors != 0) acp_error($lang->get("LANG_ACP_TEMPLATE_ERROR_4"));
	else acp_message($lang->get("LANG_ACP_TEMPLATE_EXPORT_DONE"));
}

/** import templates (from pathnames) **/
if ($action == "fileimport2") {
	checkAdminPermissions("a_can_template_import", 1);
	$files = $_POST['files'];	
	$templatepackid = intval($_POST['templatepackid']);
	
	if (is_array($files) && count($files)) {
		while (list($key, $val) = each($files)) {
			if (!file_exists($val)) continue;
			$templatename = basename($val);
			$templatename = wbb_substr($templatename, 0, - 1 * wbb_strlen(strrchr($templatename, ".")));
			$fp = fopen($val, "rb");
			$template = dos2unix(@fread($fp, filesize($val)));
			fclose($fp);
			$db->unbuffered_query("REPLACE INTO bb".$n."_templates (templatepackid,templatename,template) VALUES ('$templatepackid','".addslashes($templatename)."','".addslashes($template)."')", 1);
		}
		updateTemplateStructure();  
	}
	
	acp_message($lang->get("LANG_ACP_TEMPLATE_IMPORT_DONE", array('$sessionhash' => $session['hash'])));
}


/** import templates (from templatefolder) **/
if ($action == "fileimport") {
	checkAdminPermissions("a_can_template_import", 1);
	$templatefolder = "./../".$_REQUEST['templatefolder'];	
	$templatepackid = intval($_REQUEST['templatepackid']);
	$templates = array();
	
	if ($handle = @opendir($templatefolder)) {
		while ($file = readdir($handle)) {
			if ($file == ".." || $file == ".") continue; 
			$templates[] = $file;
		}
	}
	else acp_error($lang->get("LANG_ACP_GLOBAL_ERROR_IMPORTERROR"));
	
	if (count($templates)) {
		for ($i = 0; $i < count($templates); $i++) {
			$templatename = wbb_substr($templates[$i], 0, - 1 * wbb_strlen(strrchr($templates[$i], ".")));
			$fp = fopen($templatefolder."/".$templates[$i], "rb");
			$template = dos2unix(@fread($fp, filesize($templatefolder."/".$templates[$i])));
			fclose($fp);
			$db->unbuffered_query("REPLACE INTO bb".$n."_templates (templatepackid,templatename,template) VALUES ('$templatepackid','".addslashes($templatename)."','".addslashes($template)."')", 1);
		}
		updateTemplateStructure();
	}
	
	acp_message($lang->get("LANG_ACP_TEMPLATE_IMPORT_DONE", array('$sessionhash' => $session['hash'])));
}





function maketemplatepacklist($parentid = -1, $x = 0) {
	global $templatepackcache, $session, $maxcolspan, $tpl, $lang;
	
	if (!isset($templatepackcache[$parentid])) return;
	
	foreach ($templatepackcache[$parentid] as $key => $row) {
		$colspan = $maxcolspan - $x;
		$temp = $maxcolspan - ($maxcolspan - $x);
		if ($temp) $tds = str_repeat("<td class=\"secondrow\">&nbsp;&nbsp;</td>", $temp);
		else $tds = '';
		eval("\$out .= \"".$tpl->get("templatepack_viewbit", 1)."\";");
		$out .= maketemplatepacklist($row['templatepackid'], $x + 1);
	} 
	unset($templatepackcache[$parentid]);
	return $out;
}
function getmaxcolspan($parentid = -1, $x = 0) {
	global $templatepackcache, $maxcolspan;
	
	if ($x > $maxcolspan) $maxcolspan = $x;
	if (!isset($templatepackcache[$parentid])) return;
	
	foreach ($templatepackcache[$parentid] as $key => $row) {
		getmaxcolspan($row['templatepackid'], $x + 1);
	}
}

/** view templatepacks **/
if ($action == "viewpack") {
	if (!checkAdminPermissions("a_can_templatepack_edit") && !checkAdminPermissions("a_can_templatepack_del")) access_error(1);
	
	
	$templatepackcache = array(
		-1 => array(
			array(
				"templatepackid" => 0, 
				"templatepackname" => $lang->get("LANG_ACP_TEMPLATE_DEFAULTPACK")
			)
		)
	);
	
	$result = $db->query("SELECT * FROM bb".$n."_templatepacks ORDER BY parentid ASC, templatepackname");
	while ($row = $db->fetch_array($result)) {
		$templatepackcache[$row['parentid']][] = $row;
	}
	
	
	$maxcolspan = 0;
	getmaxcolspan();
	$templatepackbit = maketemplatepacklist();
	
	eval("\$tpl->output(\"".$tpl->get("templatepack_view", 1)."\",1);");
}


/** add templatepack **/
if ($action == "addpack") {
	checkAdminPermissions("a_can_templatepack_add", 1);
	if (isset($_POST['send'])) {
		$db->unbuffered_query("INSERT INTO bb".$n."_templatepacks (templatepackname,templatefolder,parentid) VALUES ('".addslashes(wbb_trim($_POST['templatepackname']))."','".addslashes($_POST['templatefolder'])."','".intval($_POST['parentid'])."')", 1);
		
		updateTemplateStructure();
		
		header("Location: template.php?action=viewpack&sid=$session[hash]");
		exit();	
	}
	
	$parent_options = maketemplatepackoptions();
	
	eval("\$tpl->output(\"".$tpl->get("templatepack_add", 1)."\",1);");
}


/** delete templatepack **/
if ($action == "delpack") {
	checkAdminPermissions("a_can_templatepack_del", 1); 
	if (isset($_REQUEST['templatepackid'])) $templatepackid = intval($_REQUEST['templatepackid']);
	else $templatepackid = 0;
	
	if (isset($_POST['send'])) {
		$templatepack = $db->query_first("SELECT * FROM bb".$n."_templatepacks WHERE templatepackid='$templatepackid'");
		$db->unbuffered_query("DELETE FROM bb".$n."_templatepacks WHERE templatepackid='$templatepackid'", 1);
		$db->unbuffered_query("UPDATE bb".$n."_templatepacks SET parentid='$templatepack[parentid]' WHERE parentid='$templatepackid'", 1);
		
		$result = $db->unbuffered_query("SELECT templatename FROM bb".$n."_templates WHERE templatepackid='$templatepackid'");
		while ($row = $db->fetch_array($result)) {
			@unlink("./../cache/templates/".$templatepackid."_".$row['templatename'].".php");  	
		}
		
		$db->unbuffered_query("DELETE FROM bb".$n."_templates WHERE templatepackid='$templatepackid'", 1);
		$db->unbuffered_query("UPDATE bb".$n."_styles SET templatepackid=0 WHERE templatepackid='$templatepackid'", 1);
		
		updateTemplateStructure();
		
		header("Location: template.php?action=viewpack&sid=$session[hash]");
		exit();
	}
	
	$templatepack = $db->query_first("SELECT * FROM bb".$n."_templatepacks WHERE templatepackid='$templatepackid'");
	$lang->items['LANG_ACP_TEMPLATE_TEMPLATEPACK_DEL'] = $lang->get("LANG_ACP_TEMPLATE_TEMPLATEPACK_DEL", array('$templatepackname' => $templatepack['templatepackname']));
	eval("\$tpl->output(\"".$tpl->get("templatepack_del", 1)."\",1);");
}


/** edit templatepack **/
if ($action == "editpack") {
	checkAdminPermissions("a_can_templatepack_edit", 1);
	if (isset($_REQUEST['templatepackid'])) $templatepackid = intval($_REQUEST['templatepackid']);
	else $templatepackid = 0;
	
	if (isset($_POST['send'])) {
		$db->unbuffered_query("UPDATE bb".$n."_templatepacks SET templatepackname='".addslashes($_POST['templatepackname'])."', templatefolder='".addslashes($_POST['templatefolder'])."', parentid='".intval($_POST['parentid'])."' WHERE templatepackid='$templatepackid'", 1);
		
		updateTemplateStructure();
		
		header("Location: template.php?action=viewpack&sid=$session[hash]");
		exit();	
	}	
	
	
	$templatepack = $db->query_first("SELECT * FROM bb".$n."_templatepacks WHERE templatepackid='$templatepackid'");
	
	$parent_options = maketemplatepackoptions( - 1, 0, $templatepack['parentid'], $templatepack['templatepackid']);
	
	eval("\$tpl->output(\"".$tpl->get("templatepack_edit", 1)."\",1);");
}


/** cache templates **/
if ($action == "cache") {
	checkAdminPermissions("a_can_template_cache", 1);
	$lang->load("ACP_OTHERSTUFF");
	eval("\$tpl->output(\"".$tpl->get("template_cache", 1)."\",1);");
}
?>
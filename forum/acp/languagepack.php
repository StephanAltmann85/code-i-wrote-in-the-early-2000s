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
// * $Date: 2005-05-17 11:00:10 +0200 (Tue, 17 May 2005) $
// * $Author: Burntime $
// * $Rev: 1607 $
// ************************************************************************************//


require('./global.php');
$lang->load('ACP_LANGUAGEPACK');

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = 'view';
if (isset($_REQUEST['mode'])) $mode = $_REQUEST['mode'];
else $mode = 'mode';
if (isset($_REQUEST['languagepackid'])) $languagepackid = intval($_REQUEST['languagepackid']);
else $languagepackid = -1;


// view installed languagepacks
if ($action == 'view') {
	if (!checkAdminPermissions('a_can_languagepack_edit') && !checkAdminPermissions('a_can_languagepack_add') && !checkAdminPermissions('a_can_languagepack_del') && !checkAdminPermissions('a_can_languagepack_translate') && !checkAdminPermissions('a_can_languagepack_export')) access_error(1);
	
	$result = $db->query("SELECT lp.*, COUNT(l.languagepackid) as languages FROM bb".$n."_languagepacks lp LEFT JOIN bb".$n."_languages l ON l.languagepackid=lp.languagepackid GROUP BY lp.languagepackid ORDER BY languagepackname ASC");
	$count = 0;
	$languagepack_viewbit = '';
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count++, 'firstrow', 'secondrow');
		$row['languagepackname'] = getlangvar($row['languagepackname'], $lang);
		eval("\$languagepack_viewbit .= \"".$tpl->get("languagepack_viewbit", 1)."\";");
	}
	
	eval("\$tpl->output(\"".$tpl->get("languagepack_view", 1)."\",1);");
}




// create a languagepack
elseif ($action == 'add') {
	checkAdminPermissions('a_can_languagepack_add', 1);
	if ($mode == 'copy') {
		$lp = $db->query_first("SELECT * FROM bb".$n."_languagepacks WHERE languagepackid='$languagepackid'");
		$languagepackname = getlangvar($lp['languagepackname'], $lang);
		$languagecode = htmlconverter($lp['languagecode']);
		
		$lang->items['LANG_ACP_LANGUAGEPACK_NAME_COPY_OF'] = $lang->get("LANG_ACP_LANGUAGEPACK_NAME_COPY_OF", array('$languagepackname' => $languagepackname));
	}
	
	if (isset($_POST['send'])) {
		$languagepackname = $_POST['languagepackname'];
		
		list($newlanguagepackid) = $db->query_first("SELECT MAX(languagepackid) FROM bb".$n."_languagepacks");
		$newlanguagepackid = intval($newlanguagepackid) + 1;
		$db->query("INSERT INTO bb".$n."_languagepacks (languagepackid,languagepackname,languagecode) VALUES ('".$newlanguagepackid."','".addslashes($languagepackname)."','".addslashes($_POST['languagecode'])."')");
		
		// copy items from another languepack
		if ($mode == 'copy') {
			$insert_str = '';
			$items = $db->query("SELECT catid,itemname,item,showorder FROM bb".$n."_languages WHERE languagepackid='$languagepackid'");
			while ($row = $db->fetch_array($items)) $insert_str .= ",('$newlanguagepackid','$row[catid]','".addslashes($row['itemname'])."','".addslashes($row['item'])."', '".$row['showorder']."')";
			if ($insert_str) {
				$db->unbuffered_query("INSERT INTO bb".$n."_languages (languagepackid,catid,itemname,item,showorder) VALUES ".wbb_substr($insert_str, 1), 1);
				$result = $db->query("SELECT catid FROM bb".$n."_languagecats ORDER BY catname ASC");
				while ($row = $db->fetch_array($result)) updateCache($newlanguagepackid, $row['catid']);
			}
		}
		header("Location: languagepack.php?action=view&sid=$session[hash]");
		exit;
	}
	
	$lp_options = '';
	$result = $db->query("SELECT languagepackid,languagepackname FROM bb".$n."_languagepacks ORDER BY languagepackname ASC");
	while ($row = $db->fetch_array($result)) $lp_options .= makeoption($row['languagepackid'], getlangvar($row['languagepackname'], $lang), $languagepackid);
	
	eval("\$tpl->output(\"".$tpl->get("languagepack_add", 1)."\",1);");
}










// delete languagepack
elseif ($action == 'del') {
	checkAdminPermissions('a_can_languagepack_del', 1);
	if (isset($_POST['send'])) {
		$result = $db->query("SELECT catname FROM bb".$n."_languagecats ORDER BY catname ASC");
		while ($row = $db->fetch_array($result)) @unlink("./../cache/language/".$languagepackid."_".$row['catname'].".php");
		$db->unbuffered_query("DELETE FROM bb".$n."_languagepacks WHERE languagepackid='$languagepackid'", 1);
		$db->unbuffered_query("DELETE FROM bb".$n."_languages WHERE languagepackid='$languagepackid'", 1);
		$db->unbuffered_query("UPDATE bb".$n."_users SET langid=0 WHERE langid='$languagepackid'", 1);
		$db->unbuffered_query("UPDATE bb".$n."_sessions SET langid=0 WHERE langid='$languagepackid'", 1);
		
		// if languagepack was default, set a new default languagepack
		if ($languagepackid == 0) {
			list($newdefault) = $db->query_first("SELECT languagepackid FROM bb".$n."_languagepacks WHERE languagecode = '".addslashes($_SERVER["HTTP_ACCEPT_LANGUAGE"])."' ORDER BY languagepackid ASC");
			if (!$newdefault) list($newdefault) = $db->query_first("SELECT languagepackid FROM bb".$n."_languagepacks ORDER BY languagepackid ASC");
			header("Location: languagepack.php?action=default&languagepackid=$newdefault&sid=$session[hash]");
		}
		else header("Location: languagepack.php?action=view&sid=$session[hash]");
		exit;
	}
	list($count) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_languagepacks");
	if ($count == 1) acp_error($lang->get("LANG_ACP_LANGUAGEPACK_DELETE_ONLYONE"));
	$lp = $db->query_first("SELECT * FROM bb".$n."_languagepacks WHERE languagepackid='$languagepackid'");
	$lp['languagepackname'] = getlangvar($lp['languagepackname'], $lang);
	
	$lang->items['LANG_ACP_LANGUAGEPACK_DELETE'] = $lang->get("LANG_ACP_LANGUAGEPACK_DELETE", array('$languagepackname' => $lp['languagepackname']));
	eval("\$tpl->output(\"".$tpl->get("languagepack_del", 1)."\",1);");
}












// set default languagepack
elseif ($action == 'default') {
	checkAdminPermissions('a_can_languagepack_edit', 1);
	
	// only set default languagepack if necessary
	if ($languagepackid) {
		
		list($newlanguagepackid) = $db->query_first("SELECT MAX(languagepackid) FROM bb".$n."_languagepacks"); 
	 	$newlanguagepackid += 1;
		
		
		$db->unbuffered_query("UPDATE bb".$n."_languagepacks SET languagepackid='".$newlanguagepackid."' WHERE languagepackid=0", 1);
		$db->unbuffered_query("UPDATE bb".$n."_languages SET languagepackid='".$newlanguagepackid."' WHERE languagepackid=0", 1);
		
		$db->unbuffered_query("UPDATE bb".$n."_languagepacks SET languagepackid=0 WHERE languagepackid='".$languagepackid."'", 1);
		$db->unbuffered_query("UPDATE bb".$n."_languages SET languagepackid=0 WHERE languagepackid='".$languagepackid."'", 1);
		
		$result = $db->query("SELECT catid, catname FROM bb".$n."_languagecats ORDER BY catname ASC");
		while ($row = $db->fetch_array($result)) {
			@unlink("./../cache/language/".$languagepackid."_".$row['catname'].".php");
			updateCache(0, $row['catid']);
			updateCache($newlanguagepackid, $row['catid']);
		}	
		
		$db->unbuffered_query("UPDATE bb".$n."_users SET langid=0 WHERE langid='".$languagepackid."'", 1);
		$db->unbuffered_query("UPDATE bb".$n."_sessions SET langid=0 WHERE langid='".$languagepackid."'", 1);
	}
	header("Location: languagepack.php?action=view&sid=$session[hash]");
	exit;
}






// edit languagepack
elseif ($action == 'edit') {
	checkAdminPermissions('a_can_languagepack_edit', 1);
	if (isset($_POST['send'])) {
		$db->unbuffered_query("UPDATE bb".$n."_languagepacks SET languagepackname='".addslashes($_POST['languagepackname'])."', languagecode='".addslashes($_POST['languagecode'])."' WHERE languagepackid='$languagepackid'");
		header("Location: languagepack.php?action=view&sid=$session[hash]");
		exit;
	}
	
	$lp = $db->query_first("SELECT * FROM bb".$n."_languagepacks WHERE languagepackid='$languagepackid'");
	$languagepackname = htmlconverter($lp['languagepackname']);
	$languagecode = htmlconverter($lp['languagecode']);
	
	eval("\$tpl->output(\"".$tpl->get("languagepack_edit", 1)."\",1);");
}









// translate languagepack
elseif ($action == 'translate') {
	checkAdminPermissions('a_can_languagepack_translate', 1);
	if (isset($_REQUEST['catid'])) $catid = intval($_REQUEST['catid']);
	else $catid = 0;
	if (isset($_REQUEST['translation'])) $translation = intval($_REQUEST['translation']);
	else $translation = -1;
	
	if (isset($_POST['send'])) {
		if (isset($_POST['items']) && is_array($_POST['items'])) $items = $_POST['items'];
		else $items = array();
		foreach ($items as $itemid => $item) $db->unbuffered_query("UPDATE bb".$n."_languages SET item='".addslashes($item)."' WHERE itemid='".intval($itemid)."'", 1);
		updateCache($languagepackid, $catid);
		
		header("Location: languagepack.php?action=view&sid=$session[hash]");
		exit;
	}
	
	// read out languagepackname	
	$lp = $db->query_first("SELECT * FROM bb".$n."_languagepacks WHERE languagepackid='$languagepackid'");
	$lp['languagepackname'] = getlangvar($lp['languagepackname'], $lang);
	
	$lang->items['LANG_ACP_LANGUAGEPACK_TRANSLATEPACK'] = $lang->get("LANG_ACP_LANGUAGEPACK_TRANSLATEPACK", array('$languagepackname' => $lp['languagepackname']));
	
	// read out languagecats
	$result = $db->query("SELECT * FROM bb".$n."_languagecats ORDER BY catname ASC");
	$cat_options = '';
	while ($row = $db->fetch_array($result)) $cat_options .= makeoption($row['catid'], htmlconverter($row['catname']), $catid);
	
	// read out other languagepacks
	$result = $db->query("SELECT * FROM bb".$n."_languagepacks WHERE languagepackid<>'$languagepackid' ORDER BY languagepackname ASC");
	$translation_options = '';
	while ($row = $db->fetch_array($result)) {
		$translation_options .= makeoption($row['languagepackid'], getlangvar($row['languagepackname'], $lang), $translation);
		if ($translation == $row['languagepackid']) $translation_languagepackname = getlangvar($row['languagepackname'], $lang);
	}
	
	// read out items
	$result = $db->query("SELECT l.*".(($translation != -1) ? (",t.item as translation") : (""))." FROM bb".$n."_languages l".(($translation != -1) ? (" LEFT JOIN bb".$n."_languages t ON t.itemname=l.itemname AND t.languagepackid='$translation'") : (""))." WHERE l.languagepackid='$languagepackid' AND l.catid='$catid' ORDER BY l.showorder ASC");
	$count = 0;
	$itembit = '';
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count++, "firstrow", "secondrow");
		$row['itemname'] = htmlconverter($row['itemname']);
		$row['item'] = htmlconverter($row['item']);
		$row['translation'] = htmlconverter($row['translation']);
		eval("\$itembit .= \"".$tpl->get("languagepack_translate_itembit", 1)."\";");
	}
	
	eval("\$tpl->output(\"".$tpl->get("languagepack_translate", 1)."\",1);");
}






// add new language item
elseif ($action == 'additem') {
	checkAdminPermissions('a_can_languagepack_additem', 1);
	if (isset($_POST['send']) && isset($_POST['catid'])) {
		$catid = intval($_POST['catid']);
		
		list($verify) = $db->query_first("SELECT itemid FROM bb".$n."_languages WHERE languagepackid='".$languagepackid."' AND itemname='".addslashes($_POST['itemname'])."'");
		if ($verify) acp_error($lang->get("LANG_ACP_LANGUAGEPACK_ERROR1"));
				
		list($showorder) = $db->query_first("SELECT MAX(showorder) FROM bb".$n."_languages WHERE catid='$catid' AND languagepackid='$languagepackid'");
		$db->unbuffered_query("INSERT INTO bb".$n."_languages (languagepackid, catid, itemname, item, showorder) VALUES ('$languagepackid', '$catid', '".addslashes($_POST['itemname'])."', '".addslashes($_POST['item'])."', '".($showorder + 1)."')", 1);
		updateCache($languagepackid, $catid);
		
		header("Location: languagepack.php?action=view&sid=$session[hash]");
		exit;
	}
	
	$lp_options = '';
	$result = $db->query("SELECT * FROM bb".$n."_languagepacks ORDER BY languagepackname ASC");
	while ($row = $db->fetch_array($result)) $lp_options .= makeoption($row['languagepackid'], getlangvar($row['languagepackname'], $lang));
	
	$cat_options = '';
	$result = $db->query("SELECT * FROM bb".$n."_languagecats ORDER BY catname ASC");
	while ($row = $db->fetch_array($result)) $cat_options .= makeoption($row['catid'], htmlconverter($row['catname']));
	
	eval("\$tpl->output(\"".$tpl->get("languagepack_additem", 1)."\",1);");
}





// add new languagecategory
elseif ($action == 'addcategory')
{
	checkAdminPermissions('a_can_languagepack_addcategory', 1);
	if (isset($_POST['send']) && isset($_POST['catname'])) {
		$db->unbuffered_query("INSERT INTO bb".$n."_languagecats (catname) VALUES ('".addslashes($_POST['catname'])."')");
		
		header("Location: languagepack.php?action=view&sid=$session[hash]");
		exit;
	}
	
	eval("\$tpl->output(\"".$tpl->get("languagepack_addcategory", 1)."\",1);");
}



// delete category
elseif ($action == 'delcategory') {
	checkAdminPermissions('a_can_languagepack_delcategory', 1);
	
	if (isset($_POST['catid'])) $catid = intval($_POST['catid']);
	elseif (isset($_GET['catid'])) $catid = intval($_GET['catid']);
	else $catid = 0;
	$lngcategory = $db->query_first("SELECT * FROM bb".$n."_languagecats WHERE catid = '$catid'");
	
	
	if (!$lngcategory['catid']) {
		$cat_options = '';
		$result = $db->query("SELECT * FROM bb".$n."_languagecats ORDER BY catname ASC");
		while ($row = $db->fetch_array($result)) $cat_options .= makeoption($row['catid'], htmlconverter($row['catname']));
		eval("\$tpl->output(\"".$tpl->get("languagepack_delcategory", 1)."\",1);");
	}
	
	else {
		if (isset($_POST['send']) && $catid != 0) {
			$db->unbuffered_query("DELETE FROM bb".$n."_languages WHERE catid = '$catid'", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_languagecats WHERE catid = '$catid'", 1);
			$result = $db->query("SELECT languagepackid FROM bb".$n."_languagepacks");
			while ($row = $db->fetch_array($result)) {
				@unlink('../cache/language/'.$row['languagepackid'].'_'.$lngcategory['catname'].'.php');	
			}
			
			header("Location: languagepack.php?action=view&sid=$session[hash]");
			exit;
		}
		
		$lngcategory['catname'] = htmlconverter($lngcategory['catname']);
		
		$lang->items['LANG_ACP_LANGUAGEPACK_DELCATEGORY_SURE'] = $lang->get("LANG_ACP_LANGUAGEPACK_DELCATEGORY_SURE", array('$catname' => $lngcategory['catname']));
		eval("\$tpl->output(\"".$tpl->get("languagepack_delcategory_sure", 1)."\",1);");
	}
}




// delete language item
elseif ($action == 'delitem') {
	checkAdminPermissions('a_can_languagepack_delitem', 1);
	if (isset($_REQUEST['itemid'])) $itemid = intval($_REQUEST['itemid']);
	else $itemid = 0;
	$item = $db->query_first("SELECT * FROM bb".$n."_languages WHERE itemid='$itemid'");
	
	if (isset($_POST['send'])) {
		$db->unbuffered_query("DELETE FROM bb".$n."_languages WHERE itemid='$itemid'", 1);
		updateCache($item['languagepackid'], $item['catid']);
		header("Location: languagepack.php?action=translate&languagepackid=$item[languagepackid]&catid=$item[catid]&sid=$session[hash]");
		exit;
	}
	
	$item['itemname'] = htmlconverter($item['itemname']);
	$lang->items['LANG_ACP_LANGUAGEPACK_ITEM_DELETE'] = $lang->get("LANG_ACP_LANGUAGEPACK_ITEM_DELETE", array('$itemname' => $item['itemname']));
	eval("\$tpl->output(\"".$tpl->get("languagepack_delitem", 1)."\",1);");
}










// export languagepack
elseif ($action == 'export') { 
	checkAdminPermissions('a_can_languagepack_export', 1);
	
	// redirect to lp-overview if no languagepack is given.
	if ($languagepackid == -1) {
		header("Location: languagepack.php?action=view&sid=$session[hash]");
		exit;	
	}
	$lp = $db->query_first("SELECT * FROM bb".$n."_languagepacks WHERE languagepackid='$languagepackid'");
	
	
	
	// start export
	if (isset($_POST['send']) && $_POST['send'] == 'send') {
			
		$data = "# Languagepack-Export: ".$lp['languagepackname']." (export)\n";
		$data .= "# Languagecode: ".$lp['languagecode']."\n";
		$data .= "# Date: ".formatdate($wbbuserdata['dateformat']." ".$wbbuserdata['timeformat'], time())."\n";
		$data .= "# wBB Version: ".$boardversion."\n";
		
		// only export certain categories?
		if (isset($_POST['catids']) && is_array($_POST['catids'])) {
			$catids = intval_array($_POST['catids']);
			if ($catids[0] == '*' || in_array('*', $catids)) $catids = '';
			else $catids = implode(',', $catids);
		}
		else $catids = '';
		
		$cats = array();
		$exportedcats = array();
		$result = $db->query("SELECT * FROM bb".$n."_languagecats".(($catids != '') ? (" WHERE catid IN ($catids)") : (""))." ORDER BY catname ASC");
		while ($row = $db->fetch_array($result)) {
			$cats[$row['catid']] = $row['catname'];
		}
		
		// export language items
		$lastcat = 0;
		$result = $db->query("SELECT * FROM bb".$n."_languages WHERE languagepackid = '$languagepackid'".(($catids != '') ? (" AND catid IN ($catids)") : (""))." ORDER BY itemname ASC");
		while ($row = $db->fetch_array($result)) {
			if ($row['catid'] != $lastcat) {
				$data .= "\n\n\n[".$cats[$row['catid']]."]\n\n";
				$exportedcats[$row['catid']] = true;
			}
			$data .= "<text:".$row['itemname'].">".$row['item']."</".$row['itemname'].":text>\n";
			$lastcat = $row['catid'];
		}
		// export empty categories
		foreach ($cats as $catid => $catname) {
			if (!isset($exportedcats[$catid]) || !$exportedcats[$catid]) {
				$data .= "\n\n\n[".$cats[$catid]."]\n\n";
			}
		}
		
		$filename = $lp['languagepackname'].".lng";
		if (preg_match("/Opera\/[0-9]\.[0-9]{1,2}/", $_SERVER['HTTP_USER_AGENT']) || preg_match("/MSIE [0-9]\.[0-9]{1,2}/", $_SERVER['HTTP_USER_AGENT']))	$mime_type = "application/octetstream";
		else $mime_type = "application/octet-stream";
		// send file to browser
		header("Content-Type: ".$mime_type);
		header("Expires: ".date("D, d M Y H:i:s"));
		if (preg_match("/MSIE [0-9]\.[0-9]{1,2}/", $_SERVER['HTTP_USER_AGENT'])) {
			header("Content-Disposition: inline; filename=\"".$filename."\"");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Pragma: public");
		}
		else {
			header("Content-Disposition: attachment; filename=\"".$filename."\"");
			header("Pragma: no-cache");
		}
		echo $data;
	}
	
	
	else {
		$cat_options = '';
		$result = $db->query("SELECT * FROM bb".$n."_languagecats ORDER BY catname ASC");
		while ($row = $db->fetch_array($result)) $cat_options .= makeoption($row['catid'], htmlconverter($row['catname']));
		
		$lp['languagepackname'] = getlangvar($lp['languagepackname'], $lang);
		$lang->items['LANG_ACP_LANGUAGEPACK_EXPORT'] = $lang->get("LANG_ACP_LANGUAGEPACK_EXPORT", array('$languagepackname' => $lp['languagepackname']));
		eval("\$tpl->output(\"".$tpl->get("languagepack_export", 1)."\",1);");
	}
}









// start importing a languagepack
elseif ($action == 'import') {
	checkAdminPermissions('a_can_languagepack_import', 1);
	if (isset($_POST['send'])) {
		if ($_POST['start'] == 1) {
			$mode = $_POST['mode'];
			if ($mode == "local") $lngfile = $_POST['lngfile'];
			else {
				if (isset($_FILES['uploadfile']['tmp_name']) && $_FILES['uploadfile']['tmp_name'] && is_uploaded_file($_FILES['uploadfile']['tmp_name'])) {
					$tempfile = "./temp/lngimport_".md5(uniqid(rand()));
					while (file_exists($tempfile)) $tempfile = "./temp/lngimport_".md5(uniqid(rand()));
					if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $tempfile)) {
						$lngfile = $tempfile;
						chmod($tempfile, 0777);
					}
				}
			}
		}
		else $lngfile = $_POST['lngfile'];
		if (!$lngfile || !file_exists($lngfile)) acp_error($lang->items['LANG_ACP_LANGUAGEPACK_IMPORT_ERROR']);
		
		$lngdata = readlngfile($lngfile, intval($_POST['start'] != 1));
		$exportdate = $lngdata['exportdate'];
		$exportwbbversion = $lngdata['exportwbbversion'];
		$languagecode = $lngdata['languagecode'];
		$languagepackname = $_POST['languagepackname'];
		// show overview
		if ($_POST['start'] == 1) {
			$languagepackname = $lngdata['languagepackname'];
			$languagepack_options = '';
			$result = $db->query("SELECT languagepackid, languagepackname FROM bb".$n."_languagepacks ORDER BY languagepackname ASC");
			while ($row = $db->fetch_array($result)) $languagepack_options .= makeoption($row['languagepackid'], getlangvar($row['languagepackname'], $lang));
			
			$cat_options = '';
			if (count($lngdata['cats'])) {
				foreach ($lngdata['cats'] as $cat) {
					$cat_options .= makeoption(htmlconverter($cat), htmlconverter($cat));	
				}
			}
			
			eval("\$tpl->output(\"".$tpl->get("languagepack_import_start", 1)."\",1);");
		}
		// start import
		else {
			if (count($lngdata['cats'])) {
				if (isset($_POST['cats2import']) && is_array($_POST['cats2import'])) {
					$cats2import = $_POST['cats2import'];
					if ($cats2import[0] == '*' || in_array('*', $cats2import)) unset($cats2import);
				}

				$where = '';
				foreach ($lngdata['cats'] as $cat) {
					if (isset($cats2import) && !in_array($cat, $cats2import)) continue;
					$db->unbuffered_query("INSERT IGNORE INTO bb".$n."_languagecats (catname) VALUES ('".addslashes($cat)."')");
					$where .= ",'".addslashes($cat)."'";
				}
				$cats = array();
				$result = $db->query("SELECT catid,catname FROM bb".$n."_languagecats WHERE catname IN(".wbb_substr($where, 1).")");
				while ($row = $db->fetch_array($result)) $cats[$row['catname']] = $row['catid'];
			}
			
			if (count($lngdata['items'])) {
				if ($_POST['createnew'] == 1) {
					list($languagepackid) = $db->query_first("SELECT MAX(languagepackid) FROM bb".$n."_languagepacks");
					$languagepackid = intval($languagepackid) + 1;
					
					$db->query("INSERT INTO bb".$n."_languagepacks (languagepackid,languagepackname,languagecode) VALUES ('".$languagepackid."','".addslashes($languagepackname)."','".addslashes($languagecode)."')");
				}
				$insert_str = '';
				$rowCount = 0;
				foreach ($lngdata['items'] as $cat => $itemarray) {
					if (isset($cats2import) && !in_array($cat, $cats2import)) continue;
					$showorder = 1;
					foreach ($itemarray as $itemname => $item) {
						if ($rowCount > 150 && $insert_str != '') {
							$db->unbuffered_query("REPLACE INTO bb".$n."_languages (languagepackid,catid,itemname,item,showorder) VALUES ".wbb_substr($insert_str, 1), 1);
							$rowCount = 0;
							$insert_str = '';
						}
						$insert_str .= ",('$languagepackid','".$cats[$cat]."', '".addslashes($itemname)."', '".addslashes($item)."', '".$showorder."')";
						$showorder++;
						$rowCount++;
					}
				}
				if ($insert_str) $db->unbuffered_query("REPLACE INTO bb".$n."_languages (languagepackid,catid,itemname,item,showorder) VALUES ".wbb_substr($insert_str, 1), 1);
				foreach ($cats as $catname => $catid) updateCache($languagepackid, $catid);
			}
			if (preg_match("/^\.\/temp\/lngimport_[^\/]+$/", $lngfile)) unlink($lngfile);
			
			header("Location: languagepack.php?action=view&sid=$session[hash]");
			exit;
		}
	}
	else eval("\$tpl->output(\"".$tpl->get("languagepack_import", 1)."\",1);");
}













// search & replace languageitems
elseif ($action == 'search') {
	checkAdminPermissions('a_can_languagepack_search', 1);
	if (isset($_POST['send'])) {
		if (!$_POST['search']) acp_error($lang->get("LANG_ACP_GLOBAL_ERROR_NORESULT"));
		$where_itemid = '';
		if ($languagepackid != -1) {
			$where_itemid = " bb".$n."_languages.languagepackid = '".$languagepackid."' AND";
			if(isset($_POST['itemid']) && is_array($_POST['itemid']) && count($_POST['itemid'])) $where_itemid .= " bb".$n."_languages.itemid IN('".implode("','", intval_array($_POST['itemid']))."') AND";
		}
		
		// search
		if (isset($_POST['dosearch'])) {
			$result = $db->query("SELECT bb".$n."_languages.*, lp.languagepackid, lp.languagepackname FROM bb".$n."_languages LEFT JOIN bb".$n."_languagepacks lp USING(languagepackid) WHERE$where_itemid item LIKE '%".addslashes($_POST['search'])."%'");
			if (!$db->num_rows($result)) acp_error($lang->get("LANG_ACP_GLOBAL_ERROR_NORESULT"));
			
			$count = 1;
			$resultbit = '';
			while ($row = $db->fetch_array($result)) {
				$rowclass = getone($count++, "firstrow", "secondrow");
				$row['itemname'] = htmlconverter($row['itemname']);
				$row['languagepackname'] = getlangvar($row['languagepackname'], $lang);
				eval("\$resultbit .= \"".$tpl->get("languagepack_search_resultbit", 1)."\";");
			}
			
			eval("\$tpl->output(\"".$tpl->get("languagepack_search_result", 1)."\",1);");
		}
		
		// replace
		elseif (isset($_POST['doreplace'])) {
			$result = $db->query("SELECT catid,languagepackid FROM bb".$n."_languages WHERE$where_itemid item LIKE '%".addslashes($_POST['search'])."%' GROUP BY catid");
			$db->query("UPDATE bb".$n."_languages SET item=REPLACE(item,'".addslashes($_POST['search'])."','".addslashes($_POST['replace'])."') WHERE$where_itemid item LIKE '%".addslashes($_POST['search'])."%'");
			$count = $db->affected_rows();
			while ($row = $db->fetch_array($result)) updateCache($row['languagepackid'], $row['catid']);
			
			acp_message($lang->get("LANG_ACP_LANGUAGEPACK_REPLACE_RESULT", array('$count' => $count)));
		}
	}
	else {
		$languagepack_options = '';
		$result = $db->query("SELECT * FROM bb".$n."_languagepacks ORDER BY languagepackname ASC");
		while ($row = $db->fetch_array($result)) $languagepack_options .= makeoption($row['languagepackid'], getlangvar($row['languagepackname'], $lang), $languagepackid);
		
		if ($languagepackid != -1) {
			$result = $db->query("SELECT l.itemid,l.itemname,lc.catname FROM bb".$n."_languages l LEFT JOIN bb".$n."_languagecats lc USING(catid) WHERE l.languagepackid='$languagepackid' ORDER BY lc.catname ASC, l.showorder ASC");
			$prevcat = '';
			while ($row = $db->fetch_array($result)) {
				if ($prevcat != $row['catname']) $languageitems_options .= makeoption("", "&raquo; ".htmlconverter($row['catname']), 0, 0);
				$languageitems_options .= makeoption($row['itemid'], "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlconverter($row['itemname']), 0, 0);
				$prevcat = $row['catname'];
			}
			unset($prevcat);
		}
		
		eval("\$tpl->output(\"".$tpl->get("languagepack_search", 1)."\",1);");
	}
}














// sync languagepacks
elseif ($action == 'sync') {
	checkAdminPermissions('a_can_languagepack_sync', 1);
	
	if ($languagepackid != -1) {
		$cacheids = array();
		$languagepacks = array();
		$result = $db->query("SELECT languagepackid FROM bb".$n."_languagepacks WHERE languagepackid<>'$languagepackid'");
		while ($row = $db->fetch_array($result)) $languagepacks[] = $row['languagepackid'];
		
		$olditems = array();
		$result = $db->unbuffered_query("SELECT languagepackid,itemname FROM bb".$n."_languages WHERE languagepackid<>'$languagepackid'");
		while ($row = $db->fetch_array($result)) $olditems[$row['itemname']][] = $row['languagepackid'];
		
		$newitems = array();
		$result = $db->unbuffered_query("SELECT itemname,catid FROM bb".$n."_languages WHERE languagepackid='$languagepackid'");
		while ($row = $db->fetch_array($result)) $newitems[$row['itemname']] = $row;
		
		// insert new items into other languagepacks
		$insert_str = '';
		$result = $db->unbuffered_query("SELECT itemname, catid, item, showorder FROM bb".$n."_languages WHERE languagepackid='$languagepackid'");
		while ($row = $db->fetch_array($result)) {
			if (isset($olditems[$row['itemname']]) && is_array($olditems[$row['itemname']])) $diff = array_diff($languagepacks, $olditems[$row['itemname']]);
			else $diff = $languagepacks;
			foreach ($diff as $newlanguagepackid) {
				$insert_str .= ",('$newlanguagepackid', '".addslashes($row['itemname'])."', '$row[catid]', '".addslashes($row['item'])."', '$row[showorder]')";
				$cacheids[$newlanguagepackid][$row['catid']] = true;
			}
		}

		// delete old items in other languagepacks
		$delete_str = '';
		foreach ($olditems as $itemname => $val) {
			if (!isset($newitems[$itemname]) || !is_array($newitems[$itemname])) {
				$delete_str .= ",'".addslashes($itemname)."'";
				foreach ($val as $val2 => $newlanguagepackid) {
					$cacheids[$newlanguagepackid][$newitems[$itemname]['catid']] = true;
				}
			}	
		}

		if ($insert_str) $db->unbuffered_query("INSERT INTO bb".$n."_languages (languagepackid, itemname, catid, item, showorder) VALUES ".wbb_substr($insert_str, 1), 1);
		if ($delete_str) $db->unbuffered_query("DELETE FROM bb".$n."_languages WHERE languagepackid<>'$languagepackid' AND itemname IN (".wbb_substr($delete_str, 1).")", 1);
		foreach ($cacheids as $newlanguagepackid => $val) foreach ($val as $catid => $val2) updateCache($newlanguagepackid, $catid);
		
		header("Location: languagepack.php?action=view&sid=$session[hash]");
		exit;
	}
	
	$lp_options = '';
	$result = $db->query("SELECT lp.languagepackid, languagepackname, COUNT(itemid) as itemcount FROM bb".$n."_languagepacks lp LEFT JOIN bb".$n."_languages USING(languagepackid) GROUP BY lp.languagepackid ORDER BY itemcount DESC, languagepackname ASC");
	while ($row = $db->fetch_array($result)) $lp_options .= makeoption($row['languagepackid'], getlangvar($row['languagepackname'], $lang)." (".$row['itemcount'].")");
	
	eval("\$tpl->output(\"".$tpl->get("languagepack_sync", 1)."\",1);");
}
?>
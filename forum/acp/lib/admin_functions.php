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


/** check the security level **/
function checkSecurityLevel($level, $access_error = 0) {
	global $wbbuserdata;
	if ($access_error == 0) {
		if ($wbbuserdata['a_override_max_securitylevel'] != -1 && $level > $wbbuserdata['a_override_max_securitylevel']) return false;
		else return true;
	}
	elseif ($access_error != 0 && ($wbbuserdata['a_override_max_securitylevel'] != -1 && $level > $wbbuserdata['a_override_max_securitylevel'])) {
		global $lang;
		acp_error($lang->get("LANG_ACP_GLOBAL_ERROR_SECURITYLEVEL"));
	}
}


/** show an acp error page and die **/
function acp_error($error_msg) {
	global $lang, $tpl;
	eval("\$tpl->output(\"".$tpl->get("error", 1)."\",1);");
	exit();
}


/** show an acp message page and die **/
function acp_message($msg) {
	global $lang, $tpl;
	eval("\$tpl->output(\"".$tpl->get("message", 1)."\",1);");
	exit();
}


/** generate an acp error frame **/
function acp_error_frame($error_msg) {
	global $lang, $tpl;
	eval("\$temp = \"".$tpl->get("error_frame", 1)."\";");
	return $temp;
}


/** refresh an acp page **/
function refresh_die() {
	global $nophperror;
	if (!isset($nophperror) || !$nophperror) {
 		echo "</textarea>
		</form>
		<form name=\"bbform\" action=\"#\" method=\"post\">
		<input type=\"hidden\" name=\"working\" value=\"no\" />
		</form>
		</body></html>";
	}
}

/** refresh an acp page **/
function refresh_start() {
	global $lang, $tpl, $session;
	register_shutdown_function("refresh_die");
	eval("\$tpl->output(\"".$tpl->get("refresh_start", 1)."\",1);");
}

/** refresh an acp page **/
function refresh_error($errormsg) {
	global $tpl, $nophperror;
	$errorstring = str_replace('"', "'", strip_tags($errorstring));
	eval("\$tpl->output(\"".$tpl->get("refresh_error", 1)."\",1);");
	$nophperror = 1;
	exit();
}


/** refresh an acp page **/
function refresh($url, $taskname = '', $percent = 0, $time = 2) {
	global $lang, $tpl, $session, $nophperror;
	
	if ($taskname != '') $taskname = urlencode($taskname);
	eval("\$tpl->output(\"".$tpl->get("refresh", 1)."\",1);");
	$nophperror = 1;
}


/** generate a boardlist **/
function makeboardoptions($boardid, $depth = 1, $selected = 0, $selboardid = 0) {
	global $boardcache;
	
	if (!isset($boardcache[$boardid])) return;
	
	while (list($key1, $val1) = each($boardcache[$boardid])) {
		while (list($key2, $boards) = each($val1)) {
			$out .= "<option value=\"".$boards['boardid']."\"".(($selected == 1 && $boards[boardid] == $selboardid) ? (" selected=\"selected\"") : ("")).">";
			if ($depth > 1) $out .= str_repeat("--", $depth - 1)." ".$boards['title']."</option>";
			else $out .= $boards['title']."</option>";
			$out .= makeboardoptions($boards['boardid'], $depth + 1, $selected, $selboardid);
		} 
	} 
	unset($boardcache[$boardid]);
	return $out;
}


/** update parent or childlist of a board **/
function updateList($boardidlist, $update, $field = 'parentlist', $remove = false) {
	global $db, $n;
	
	$update = var2key(explode(',', $update));
	unset($update[0]);
	if (count($update)) {
		$result = $db->query("SELECT boardid, $field FROM bb".$n."_boards WHERE boardid IN ($boardidlist)");
		while ($row = $db->fetch_array($result)) {
			$temp = var2key(explode(',', $row[$field]));
			
			reset($update);
			while (list($key, $val) = each($update)) {
				if ($remove) unset($temp[$key]);
				else $temp[$key] = 1;
			}
			
			$temp = implode(',', key2var($temp));
			
			$db->query("UPDATE bb".$n."_boards SET $field = '$temp' WHERE boardid='$row[boardid]'");
		}
	}
}


/** array values to keys **/
function var2key($varArray, $value = 1) {
	$keyArray = array();
	
	reset($varArray);
	while (list($key, $val) = each($varArray)) $keyArray[$val] = $value;
	
	return $keyArray;
}


/** array keys to values **/
function key2var($keyArray) {
	$varArray = array();
	
	reset($keyArray);
	while (list($key, $val) = each($keyArray)) $varArray[] = $key;
	
	return $varArray;
}


/** updates the language cache **/
function updateCache($languagepackid, $catid) {
	global $db, $n;
	
	$lp = $db->query_first("SELECT * FROM bb".$n."_languagepacks WHERE languagepackid='$languagepackid'");
	$cat = $db->query_first("SELECT * FROM bb".$n."_languagecats WHERE catid='$catid'");
	
	$fp = fopen("../cache/language/".$languagepackid."_".$cat['catname'].".php", "w+b");
	fwrite($fp, "<?php
/*
language: ".$lp['languagepackname']."
category: ".$cat['catname']."
*/


");
	
	$result = $db->query("SELECT itemname, item FROM bb".$n."_languages WHERE catid='$catid' AND languagepackid='$languagepackid' ORDER BY itemname ASC");
	while ($row = $db->fetch_array($result)) {
		fwrite($fp, "\$this->items['".$row['itemname']."']=\"".addcslashes($row['item'], "$\"\\")."\";\n");
	}
	fwrite($fp, "?>");
	fclose($fp);
	@chmod("../cache/language/".$languagepackid."_".$cat['catname'].".php", 0777);
}



/** parse .lng file **/
function readlngfile($filename, $readall = 1) {
	if (!file_exists($filename)) return false;
	
	$fp = fopen($filename, 'rb');
	$content = fread($fp, filesize($filename));
	fclose($fp);
	$content = dos2unix($content);
	
	// fetch meta info
	preg_match('%# Languagepack-Export: (.*)%i', $content, $matches);
	$languagepackname = $matches[1];
	preg_match('%# Languagecode: (.*)%i', $content, $matches);
	$languagecode = $matches[1];
	preg_match('%# Date: (.*)%i', $content, $matches);
	$exportdate = $matches[1];
	preg_match('%# wBB Version: (.*)%i', $content, $matches);
	$exportwbbversion = $matches[1];
	$cats = array();
	$items = array();

	// fetch categories
	preg_match_all('%^\[([^\]]*)\]$%mi', $content, $matches);
	$cats = $matches[1];
	
	// read all content
	if ($readall == 1) {
		// split content
		$content = preg_split('%\n\[[a-z0-9_]+\]\n%i', $content);
		array_shift($content);
		
		for ($i = 0, $iMax = count($cats); $i < $iMax; $i++) {
			$cat = $cats[$i];
			// fetch language items
			preg_match_all('%<text:([^>]+)>(.*)</\\1:text>%isU', $content[$i], $matches);
			for ($j = 0, $jMax = count($matches[0]); $j < $jMax; $j++) {
				$items[$cat][$matches[1][$j]] = $matches[2][$j];
			}
		}
	}
	
	return array('languagepackname' => $languagepackname, 
		'languagecode' => $languagecode, 
		'exportdate' => $exportdate, 
		'exportwbbversion' => $exportwbbversion, 
		'cats' => $cats, 
		'items' => $items);
	
	
}



/** update template structure **/
function updateTemplateStructure() {
	global $db, $n;	
	
	
	global $templatepackcache, $templatecache;
	$templatepackcache = array();
	$templatecache = array();
	
	$result = $db->query("SELECT templatepackid,parentid FROM bb".$n."_templatepacks ORDER BY parentid ASC");
	while ($row = $db->fetch_array($result)) {
		$templatepackcache[$row['parentid']][] = $row['templatepackid'];	
	}
	$templatepackcache[-1][] = 0;
	
	$result = $db->query("SELECT templatepackid,templatename FROM bb".$n."_templates");
	while ($row = $db->fetch_array($result)) {
		$templatecache[$row['templatepackid']][$row['templatename']] = $row['templatepackid'];
	}
	
	inheritTemplates();
	
	// update option
	foreach ($templatepackcache as $parentid => $val) {
		foreach ($val as $key => $templatepackid) {
			if ($templatepackid != 0) {
				$db->unbuffered_query("UPDATE bb".$n."_templatepacks SET templatestructure='".addslashes(serialize($templatecache[$templatepackid]))."' WHERE templatepackid='$templatepackid'", 1);
			}
		}
	}
	
}

/** inherit template from parent templatepack **/
function inheritTemplates($parentid = -1) {
	global $templatepackcache, $templatecache;
	
	if (isset($templatepackcache[$parentid]) && is_array($templatepackcache[$parentid])) {
		foreach ($templatepackcache[$parentid] as $key => $templatepackid) {
			
			if (!isset($templatecache[$templatepackid]) || !is_array($templatecache[$templatepackid])) {
				$templatecache[$templatepackid] = array();
			}
			
			if ($parentid != -1) {
				$templatecache[$templatepackid] = array_merge($templatecache[$parentid], $templatecache[$templatepackid]);
			}
			
			inheritTemplates($templatepackid);
		}
	}
}

/** make templatepack options **/
function maketemplatepackoptions($parentid = -1, $level = 0, $selectedid = -1, $ignoreid = -1) {
	static $templatepackcache;
	
	if (!isset($templatepackcache) || !is_array($templatepackcache)) {
		global $db, $n, $lang;
		$lang->load("ACP_TEMPLATE");
		
		$templatepackcache = array(
		-1 => array(
			array("templatepackid" => 0, 
			"templatepackname" => $lang->get("LANG_ACP_TEMPLATE_DEFAULTPACK")
			)
		));
		$result = $db->query("SELECT * FROM bb".$n."_templatepacks ORDER BY parentid ASC, templatepackname ASC");
		while ($row = $db->fetch_array($result)) {
			$row['templatepackname'] = htmlconverter($row['templatepackname']);
			$templatepackcache[$row['parentid']][] = $row;
		}
	}
	
	if (!isset($templatepackcache[$parentid])) return;
	
	$options = '';
	foreach ($templatepackcache[$parentid] as $key => $row) {
		if ($ignoreid != -1 && $ignoreid == $row['templatepackid']) {
			continue;
		}
		$options .= makeoption($row['templatepackid'], ($level > 0 ? str_repeat("--", $level)." " : "").$row['templatepackname'], $selectedid, ($selectedid != -1 ? 1 : 0));
		$options .= maketemplatepackoptions($row['templatepackid'], ($level + 1), $selectedid, $ignoreid);
	}
	
	return $options; 
}




/**
* format field
* 
* @param string field
* @param string type
*
* @return string field
*/
function dumpSQLField($field, $type) {
	if ($type == 'integer') return $field;
	else {
		$field = addslashes($field);
		$field = str_replace("\t", "\\t", $field);
		$field = str_replace("\r", "\\r", $field);
		$field = str_replace("\n", "\\n", $field);
		//$field = str_replace("'", "\'", $field);
		
		return "'$field'";
	}
}


/** dump a sql table structure */
function dumpTableStructure($tableName, $dropTable = 0) {
	global $db;
	$dump = '';
	
	// add DROP TABLE IF EXISTS 
	if ($dropTable == 1) $dump .= "DROP TABLE IF EXISTS $tableName;\n";

	// begin table structure
	$dump .= "CREATE TABLE $tableName (\n";

	// get fields
	$fieldtypes = array();
	$result = $db->query("DESCRIBE $tableName");
	$fieldcount = $db->num_rows($result);
	
	$i = 0;
	while ($row = $db->fetch_array($result)) {
		$name = $row['Field'];
		$type = " ".$row['Type'];
		$fieldtypes[$name] = (!stristr($row['Type'], "ENUM") && ((stristr($row['Type'], "INT") || stristr($row['Type'], "FLOAT") || stristr($row['Type'], "DOUBLE") || stristr($row['Type'], "REAL") || stristr($row['Type'], "DECIMAL") || stristr($row['Type'], "NUMERIC") || stristr($row['Type'], "TIMESTAMP") || stristr($row['Type'], "YEAR"))) ? ("integer") : ("string"));
		
		if ($row['Null'] == "") $null = " NOT NULL";
		else $null = " NULL";
		
		if ($row['Default'] == "") $default = "";
		else $default = " DEFAULT '".$row['Default']."'";
		
		if ($row['Extra'] == "") $extra = "";
		else $extra = " ".$row['Extra'];
		
		// dump field data
		$dump .= "\t".$name.$type.$null.$default.$extra;
		$i++;
		if ($i < $fieldcount) $dump .= ", \n";
	}
	
	// get keys
	$index = array();
	$result = $db->query("SHOW KEYS FROM $tableName");
	while ($row = $db->fetch_array($result)) {
		$keyname = $row['Key_name'];
		$comment = (isset($row['Comment'])) ? $row['Comment'] : "";
		$sub_part = (isset($row['Sub_part'])) ? $row['Sub_part'] : "";
		
		if ($keyname != "PRIMARY" && $row['Non_unique'] == 0) $keyname = "UNIQUE|$keyname";
		if ($comment == "FULLTEXT") $keyname = "FULLTEXT|$keyname";
		if (!isset($index[$keyname])) $index[$keyname] = array();
		if ($sub_part > 1) $index[$keyname][] = $row['Column_name']."(".$sub_part.")";
		else $index[$keyname][] = $row['Column_name'];
	} 
	
	// write key data   
	foreach ($index as $keyname => $columns) {
		$dump .= ", \n";
		if ($keyname == "PRIMARY") $dump .= "\tPRIMARY KEY (";
		elseif (wbb_substr($keyname, 0, 6) == "UNIQUE") $dump .= "\tUNIQUE ".wbb_substr($keyname, 7)." (";
		elseif (wbb_substr($keyname, 0, 8) == "FULLTEXT") $dump .= "\tFULLTEXT ".wbb_substr($keyname, 9)." (";
		else $dump .= "\tKEY ".$keyname." (";
		$dump .= implode($columns, ", ").")";
	}
	
	// write table end
	$dump .= "\n);\n\n";
	
	return $dump;
}


/** dump table content to sql file */
function dumpTableData($tableName, &$fp, $limit = 0, $offset = 0) {
	global $db;
	
	// get table data
	$insert_tag = 0;
	$rowcount = 0;
	$result = $db->unbuffered_query("SELECT * FROM $tableName", 0, $limit, $offset);
	while ($row = $db->fetch_array($result, MYSQL_ASSOC)) {
		
		$values = '';
		foreach ($row as $key => $field) {
			if ($values != '') $values .= ",".dumpSQLField($field, $fieldtypes[$key]); 
			else $values = dumpSQLField($field, $fieldtypes[$key]);
		}
		
		if ($insert_tag == 0) {
			@wbbfwrite($fp, "INSERT INTO $tableName VALUES ($values)");
			$insert_tag = 1;	
		}
		else @wbbfwrite($fp, ",($values)");
		
		if ($insert_tag == 1 && $rowcount == 500) {
			@wbbfwrite($fp, ";\n");
			$insert_tag = 0;
			$rowcount = 0;
		}
		$rowcount++;
	}
	
	if ($insert_tag == 1) @wbbfwrite($fp, ";\n");
}

/**
* close file
*
* @param resource filepointer
*
* @return void
*/
function wbbfclose(&$fp) {
	global $use_gz;
	if ($use_gz) @gzclose($fp);
	else @fclose($fp);	
}

/**
* writes to file
*
* @param resource filepointer
* @param string data
*
* @return void
*/
function wbbfwrite(&$fp, $data) {
	global $use_gz;
	if ($use_gz) @gzwrite($fp, $data);
	else @fwrite($fp, $data);	
}
?>
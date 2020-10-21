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


require("./global.php");
$lang->load("ACP_MISC");
if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = '';





class menu {
	var $markfirst = 0;
	var $hidelast = 0;
	var $personalmenu = 1;
	var $acpmode = 1;
	
	var $itemgroupcache = array();
	var $itemcache = array();
	var $itemcount = 0;
	
	var $itemgroupbit1;
	var $itemgroupbit2;
	
	function menu(&$itemgroupbit1, &$itemgroupbit2, $personalmenu = 1, $markfirst = 0, $hidelast = 0) {
		global $wbbuserdata;

		$this->personalmenu = $personalmenu;
		$this->markfirst = $markfirst;
		$this->hidelast = $hidelast;
		
		$this->itemgroupbit1 =& $itemgroupbit1;
		$this->itemgroupbit2 =& $itemgroupbit2;

		$this->acpmode = $wbbuserdata['acpmode'];
		$this->loadmenu();
	}
	
	function parseItems() {
		global $session, $tpl, $lang;
		
		$i = 0;
		$hidden = false;
		$this->itemgroupbit1 = '';
		$this->itemgroupbit2 = '';
		
		foreach ($this->itemgroupcache as $itemgroup) {
			if (!$this->checkCondition($itemgroup['condition'], $itemgroup['conditiontype'])) continue;
			if (!isSet($this->itemcache[$itemgroup['itemgroupid']]) || count($this->itemcache[$itemgroup['itemgroupid']]) == 0) continue;
			$menu_itembit = '';
			
			foreach ($this->itemcache[$itemgroup['itemgroupid']] as $item) {
				// hide last items
				if ($i >= $this->itemcount - $this->hidelast) {
					$hidden = true;
					if (!isSet($hiddenstart)) $hiddenstart = $i;
				}
				if (!$this->checkCondition($item['condition'], $item['conditiontype'])) continue;
				
				$title = $lang->get("LANG_ACP_GLOBAL_MENU_" . $item['languageitem']);
				
				if (!$hidden) {
					if ($item['linkformat']) $title = sprintf($item['linkformat'], $title);
					elseif ($i < $this->markfirst) $title = sprintf("<b>%s</b>", $title);
				}
				if ($item['link']) {
					if (!strstr($item['link'], "?")) $item['link'] .= "?sid=".$session['hash']."&amp;countmenuitemid=".$item['itemid']."&amp;countmenuitemgroupid=".$item['itemgroupid'];
					elseif (wbb_substr($item['link'], - 1) == "?") $item['link'] .= "sid=".$session['hash']."&amp;countmenuitemid=".$item['itemid']."&amp;countmenuitemgroupid=".$item['itemgroupid'];
					else $item['link'] .= "&amp;sid=".$session['hash']."&amp;countmenuitemid=".$item['itemid']."&amp;countmenuitemgroupid=".$item['itemgroupid'];
				}
				
				// close current group
				if ($hidden == true && $menu_itembit && $hiddenstart == $i) {
					eval("\$this->itemgroupbit1 .= \"".$tpl->get("menu_itemgroupbit", 1)."\";");
					$menu_itembit = '';
				}
				
				eval("\$menu_itembit .= \"".$tpl->get("menu_itembit", 1)."\";");
				$i++;
			}
			
			if ($menu_itembit && $hidden) eval("\$this->itemgroupbit2 .= \"".$tpl->get("menu_itemgroupbit", 1)."\";");
			elseif ($menu_itembit && !$hidden) eval("\$this->itemgroupbit1 .= \"".$tpl->get("menu_itemgroupbit", 1)."\";");
		}
	}
	
	
	function loadmenu() {
		global $db, $n, $wbbuserdata;
		
		$this->itemgroupcache = array();
		$itemgroupids = '';
		if ($this->personalmenu) $result = $db->query("SELECT ig.*,igc.count FROM bb".$n."_acpmenuitemgroups ig LEFT OUTER JOIN bb".$n."_acpmenuitemgroupscount igc ON igc.itemgroupid=ig.itemgroupid AND igc.userid='$wbbuserdata[userid]' WHERE ig.acpmode<='".$this->acpmode."' ORDER BY igc.count DESC, igc.lastaccesstime DESC, ig.showorder ASC");
		else $result = $db->query("SELECT * FROM bb".$n."_acpmenuitemgroups WHERE acpmode<='".$this->acpmode."' ORDER BY showorder ASC");
		while ($row = $db->fetch_array($result)) {
			$this->itemgroupcache[] = $row;
			$itemgroupids .= ",".$row['itemgroupid'];
		}
		
		$this->itemcache = array();
		if ($this->personalmenu) $result = $db->query("SELECT i.*,ic.count FROM bb".$n."_acpmenuitems i LEFT OUTER JOIN bb".$n."_acpmenuitemscount ic ON ic.itemid=i.itemid AND ic.userid='$wbbuserdata[userid]' WHERE itemgroupid IN (0$itemgroupids) AND i.acpmode<='".$this->acpmode."' ORDER BY i.itemgroupid ASC, ic.count DESC, ic.lastaccesstime DESC, i.showorder ASC");
		else $result = $db->query("SELECT * FROM bb".$n."_acpmenuitems WHERE itemgroupid IN (0$itemgroupids) AND acpmode<='".$this->acpmode."' ORDER BY itemgroupid ASC, showorder ASC");
		$this->itemcount = $db->num_rows($result);
		while ($row = $db->fetch_array($result)) $this->itemcache[$row['itemgroupid']][] = $row;
		unset($itemgroupids);
	}


	function checkCondition($condition, $conditiontype) {
		if ($condition) {
			if (!strstr($condition, ";")) {
				if (!checkAdminPermissions($condition)) return false;
				else return true;
			}
			else {
				$conditions = explode(";", $condition);
				if ($conditiontype == "OR") {
					$condition_true = false;
					foreach ($conditions as $condition) if (checkAdminPermissions($condition)) $condition_true = true;
				}
				elseif ($conditiontype == "AND") {
					$condition_true = true;
					foreach ($conditions as $condition) if (!checkAdminPermissions($condition)) $condition_true = false;
				}
				return $condition_true;
			}
		}
		else return true;
	}
}







/** slicer for frameset **/
if ($action == "slice") eval("\$tpl->output(\"".$tpl->get("slice", 1)."\",1);");


/** acp menu **/
if ($action == "menu") {
	$lang->load("ACP_OPTIONS");
	
	$result = $db->query("SELECT og.optiongroupid,og.title FROM bb".$n."_optiongroups og LEFT JOIN bb".$n."_options o ON o.optiongroupid=og.optiongroupid AND o.acpmode<='".$wbbuserdata['acpmode']."' WHERE og.acpmode<='".$wbbuserdata['acpmode']."' GROUP BY og.optiongroupid HAVING COUNT(o.optionid)>0 ORDER BY og.showorder ASC");
	$optiongroupbit = '';
	while ($row = $db->fetch_array($result)) $optiongroupbit .= "<b>&raquo;</b> ".makehreftag("options.php?sid=$session[hash]&amp;action=edit&amp;optiongroupid=$row[optiongroupid]", $lang->get("LANG_ACP_OPTIONS_GROUP_".wbb_strtoupper($row['title'])), "main")."<br />";
	
	$menu = new menu($menu_itemgroupbit, $menu_itemgroupbit_hidden, $wbbuserdata['acppersonalmenu'], $wbbuserdata['acpmenumarkfirst'], ((isSet($_REQUEST['acpmenuhidelast'])) ? ($_REQUEST['acpmenuhidelast']) : ($wbbuserdata['acpmenuhidelast'])));
	$menu->parseItems();
	
	eval("\$tpl->output(\"".$tpl->get("menu", 1)."\",1);");
}


/** clipboard for users **/
if ($action == "storage") eval("\$tpl->output(\"".$tpl->get("storage", 1)."\",1);");


/** show acp logo **/
if ($action == "logo") eval("\$tpl->output(\"".$tpl->get("logo", 1)."\",1);");


/** clipboard header **/
if ($action == "storagetop") eval("\$tpl->output(\"".$tpl->get("storagetop", 1)."\",1);");


/** frameset top **/
if ($action == "top") {
	$lang->items['LANG_ACP_GLOBAL_BOARDVERSION'] = $lang->get("LANG_ACP_GLOBAL_BOARDVERSION", array('$boardversion' =>  $boardversion));
	
	eval("\$tpl->output(\"".$tpl->get("top", 1)."\",1);");
}


/** working frame **/
if ($action == "working") eval("\$tpl->output(\"".$tpl->get("working", 1)."\",1);");


/** sync **/
if ($action == "sync") {
	if (isset($_POST['send'])) {
		$userids = $_POST['userids'];
		if ($userids) {
			$lang->load("ACP_USERS");
			
			$result = $db->query("SELECT userid, username FROM bb".$n."_users WHERE userid IN ($userids)");	
			$count = $db->num_rows($result);
			if ($count < 20) $sboxsize = $count;
			else $sboxsize = 20;
			while ($row = $db->fetch_array($result)) $users .= makeoption($row['userid'], htmlconverter($row['username']), $row['userid'], 1);
			
			eval("\$tpl->output(\"".$tpl->get("sync_show", 1)."\",1);");
		}	
		exit();	
	}
	
	eval("\$tpl->output(\"".$tpl->get("sync", 1)."\",1);");
}


/** working top **/
if ($action == "workingtop") {
	$lang->load("ACP_OTHERSTUFF");
	
	if (isset($_REQUEST['taskname'])) $taskname = urldecode($_REQUEST['taskname']);
	else $taskname = "";
	
	if (isset($_REQUEST['percent'])) $percent = $_REQUEST['percent'];
	else $percent = 0;
	
	eval("\$tpl->output(\"".$tpl->get("workingtop", 1)."\",1);");
}
?>
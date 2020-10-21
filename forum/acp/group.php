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
// * $Date: 2005-03-09 13:40:45 +0100 (Wed, 09 Mar 2005) $
// * $Author: Burntime $
// * $Rev: 1563 $
// ************************************************************************************//


require('./global.php');

if (isset($_REQUEST['groupaction']) && $_REQUEST['groupaction'] != '') {
	header('Location: '.$_REQUEST['groupaction']);
	exit;
}

$lang->load('ACP_GROUP');

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = 'view';




/** show overview */
if ($action == 'view') {
	
	// check if the user has the permission to edit or delete groups
	if (!checkAdminPermissions('a_can_groups_edit') && !checkAdminPermissions('a_can_groups_edit_own') && !checkAdminPermissions('a_can_groups_del') && !checkAdminPermissions('a_can_boards_permissions'))	{
		access_error(1);
	}
	
	$variablegroupcache = array();
	$result = $db->query("SELECT g.variablegroupid, g.title ".
	"FROM bb".$n."_groupvariablegroups g ".
	"LEFT OUTER JOIN bb".$n."_groupvariables v ON (v.variablegroupid=g.variablegroupid AND v.acpmode<='".$wbbuserdata['acpmode']."') ".
	"LEFT OUTER JOIN bb".$n."_groupvariablegroups g2 ON (g2.parentvariablegroupid=g.variablegroupid AND g2.acpmode<='".$wbbuserdata['acpmode']."') ".
	"WHERE g.parentvariablegroupid=0".(($wbbuserdata['a_override_max_securitylevel'] != -1) ? (" AND g.securitylevel <= '".$wbbuserdata['a_override_max_securitylevel']."'") : (""))." AND g.acpmode<='".$wbbuserdata['acpmode']."' ".
	"GROUP BY g.variablegroupid HAVING(COUNT(v.variableid)>0 OR COUNT(g2.variablegroupid)>0) ".
	"ORDER BY g.showorder ASC");
	while ($row = $db->fetch_array($result)) {
		$variablegroupcache[$row['variablegroupid']] = $lang->get("LANG_ACP_GROUP_VARGROUP_".$row['title']);
	}
	
	$result = $db->query("SELECT g.groupid,g.title,count(u2g.userid) as count FROM bb".$n."_groups g LEFT JOIN bb".$n."_user2groups u2g USING(groupid) GROUP BY g.groupid ORDER BY grouptype ASC, title ASC");
	$count = 0;
	$group_viewbit = '';
	while ($row = $db->fetch_array($result)) {
		$group_options = '';
		if (count($variablegroupcache)) {
			reset($variablegroupcache);
			while (list($variablegroupid, $title) = each($variablegroupcache)) {
				$group_options .= makeoption("group.php?action=rights&amp;groupid=$row[groupid]&amp;parentvariablegroupid=$variablegroupid&amp;sid=$session[hash]", $title, "", 0);
			}
		}
		
		$row['title'] = getlangvar($row['title'], $lang);
		
		$rowclass = getone($count++, 'firstrow', 'secondrow');
		eval("\$group_viewbit .= \"".$tpl->get("group_viewbit", 1)."\";");
	}
	
	eval("\$tpl->output(\"".$tpl->get("group_view", 1)."\",1);");
}













/** delete usergroup */
if ($action == 'del') {
	
	// check if the user has the permission to delete groups
	checkAdminPermissions('a_can_groups_del', 1);
	
	$groupid = intval($_REQUEST['groupid']);
	
	$group = $db->query_first("SELECT * FROM bb".$n."_groups WHERE groupid='$groupid'");
	if (!$group['groupid']) {
		header("Location: group.php?action=view&sid=$session[hash]");
		exit();
	}
	
	if ($group['grouptype'] <= 4) acp_error($lang->get("LANG_ACP_GROUP_ERROR_ISDEFAULTGROUP"));
	
	$result = $db->query_first("SELECT COUNT(*) FROM bb".$n."_user2groups WHERE groupid = '".$groupid."'");
	if ($result[0]) {
		acp_error($lang->get("LANG_ACP_GROUP_ERROR_NOEMPTYGROUP"));
	}
	
	// check securitylevel
	checkSecurityLevel($group['securitylevel'], 1);
	
	if (isset($_POST['send'])) {
		$result = $db->query("SELECT groupcombinationid, groupids FROM bb".$n."_groupcombinations WHERE CONCAT(',', groupids, ',') LIKE '%,".$groupid.",%'");
		$deleteids = '';
		while ($row = $db->fetch_array($result)) {
			$newgroupids	= wbb_substr(str_replace(",".$groupid.",", ",", ",".$row['groupids'].","), 1, - 1);
			if ($newgroupids != '') {
				$newgroupcombinationid = cachegroupcombinationdata($newgroupids);
				
				$db->unbuffered_query("UPDATE bb".$n."_users SET groupcombinationid='".$newgroupcombinationid."' WHERE groupcombinationid='".$row['groupcombinationid']."'", 1);
			}
			
			$deleteids .= ",".$row['groupcombinationid'];
		}
		
		if ($deleteids != '') $db->unbuffered_query("DELETE FROM bb".$n."_groupcombinations WHERE groupcombinationid IN (0".$deleteids.")", 1);
		$db->unbuffered_query("DELETE FROM bb".$n."_user2groups WHERE groupid='$groupid'", 1);
		$db->unbuffered_query("DELETE FROM bb".$n."_groups WHERE groupid='$groupid'", 1);
		$db->unbuffered_query("UPDATE bb".$n."_avatars SET groupid=0 WHERE groupid='$groupid'", 1);
		$db->unbuffered_query("UPDATE bb".$n."_events SET groupid=0 WHERE groupid='$groupid'", 1);
		$db->unbuffered_query("DELETE FROM bb".$n."_permissions WHERE groupid='$groupid'", 1);
		$db->unbuffered_query("DELETE FROM bb".$n."_ranks WHERE groupid='$groupid'", 1);
		$db->unbuffered_query("DELETE FROM bb".$n."_groupvalues WHERE groupid='$groupid'", 1);
		$db->unbuffered_query("DELETE FROM bb".$n."_applications WHERE groupid='$groupid'", 1);
		list($defaultgroup) = $db->query_first("SELECT groupid FROM bb".$n."_groups WHERE grouptype=4");
		$db->unbuffered_query("UPDATE bb".$n."_users SET useronlinegroupid=$defaultgroup WHERE useronlinegroupid=$groupid", 1);
		$db->unbuffered_query("UPDATE bb".$n."_users SET rankgroupid=$defaultgroup,rankid=0 WHERE rankgroupid=$groupid", 1);
		
		// groupleaders
		$db->query("DELETE FROM bb".$n."_groupleaders WHERE groupid='$groupid'");
		$db->query("UPDATE bb".$n."_users SET isgroupleader='0'");
		
		$update_str = '';
		$result = $db->query("SELECT DISTINCT userid FROM bb".$n."_groupleaders");
		while ($row = $db->fetch_array($result)) $update_str .= ",$row[userid]";
		if ($update_str) $db->unbuffered_query("UPDATE bb".$n."_users SET isgroupleader='1' WHERE userid IN (0".$update_str.")");
		
		if ($group['ai_posts'] > -1 || $group['ai_days'] > -1) updateAI();
		
		header("Location: group.php?action=view&sid=$session[hash]");
		exit();
	}
	
	$group['title'] = getlangvar($group['title'], $lang);
	$lang->items['LANG_ACP_GROUP_DELETE'] = $lang->get("LANG_ACP_GROUP_DELETE", array('$title' => $group['title']));
	eval("\$tpl->output(\"".$tpl->get("group_del", 1)."\",1);");
}















/** add a new usergroup **/
if ($action == 'add') {
	// check if the user has the permission to add groups
	checkAdminPermissions('a_can_groups_add', 1);
	
	if (isset($_POST['send'])) {
		// posts & days for automatic insert
		if (isset($_POST['ai_posts'])) $ai_posts = intval($_POST['ai_posts']);
		else $ai_posts = -1;
		if (isset($_POST['ai_days'])) $ai_days = intval($_POST['ai_days']);
		else $ai_days = -1;
		
		$db->query("INSERT INTO bb".$n."_groups (title,grouptype,useronlinemarking,securitylevel,ai_posts,ai_days,showonteam,showorder,description) ".
		"VALUES ('".addslashes($_POST['title'])."','".intval($_POST['grouptype'])."', '".addslashes($_POST['useronlinemarking'])."', '".intval($_POST['securitylevel'])."','$ai_posts','$ai_days','".intval($_POST['showonteam'])."','".intval($_POST['showorder'])."','".addslashes($_POST['description'])."')");
		$groupid = $db->insert_id();
		
		$result = $db->query("SELECT variableid,defaultvalue FROM bb".$n."_groupvariables");
		while ($row = $db->fetch_array($result)) {
			$db->query("INSERT IGNORE INTO bb".$n."_groupvalues (variableid,value,groupid) SELECT '$row[variableid]' as variableid,'".addslashes($row['defaultvalue'])."' as value,groupid FROM bb".$n."_groups WHERE groupid='$groupid'");
		}
		cachegroupcombinationdata($groupid, 1, 1);
		
		// update automatic insert
		if ($ai_posts > -1 || $ai_days > -1) updateAI();
		
		if (is_array($_POST['groupleaders']) && count($_POST['groupleaders'])) {
			$insert_str = '';
			$update_str = '';
			while (list($key, $val) = each($_POST['groupleaders']))	{
				$val = intval($val);
				if ($val) {
					$insert_str .= ",('$val','$groupid')";
					$update_str .= ",'$val'";
				}
			}
			if ($insert_str && $update_str) {
				$db->query("INSERT INTO bb".$n."_groupleaders (userid,groupid) VALUES ".wbb_substr($insert_str, 1));
				$db->unbuffered_query("UPDATE bb".$n."_users SET isgroupleader='1' WHERE userid IN (".wbb_substr($update_str, 1).")");
			}
		}
		
		
		header("Location: group.php?action=view&sid=$session[hash]");
		exit();
	}
	
	eval("\$tpl->output(\"".$tpl->get("group_add", 1)."\",1);");
}














/** edit usergroup */
if ($action == 'edit') {
	$groupid = intval($_REQUEST['groupid']);
	$group = $db->query_first("SELECT * FROM bb".$n."_groups WHERE groupid='$groupid'");
	if (!$group['groupid']) {
		header("Location: group.php?action=view&sid=$session[hash]");
		exit();
	}
	
	// check if the user has the permission to edit this group
	if (in_array($groupid, $wbbuserdata['groupids'])) checkAdminPermissions('a_can_groups_edit_own', 1);
	else checkAdminPermissions('a_can_groups_edit', 1);
	
	// check securitylevel
	checkSecurityLevel($group['securitylevel'], 1);
	
	if (isset($_POST['send'])) {
		// posts & days for automatic insert
		if ($group['grouptype'] > 4 && isset($_POST['ai_posts'])) $ai_posts = intval($_POST['ai_posts']);
		else $ai_posts = -1;
		if ($group['grouptype'] > 4 && isset($_POST['ai_days'])) $ai_days = intval($_POST['ai_days']);
		else $ai_days = -1;
		
		// update group data
		$db->query("UPDATE bb".$n."_groups SET title='".addslashes($_POST['title'])."'".(($group['grouptype'] > 4) ? (",grouptype='".intval($_POST['grouptype'])."'") : ("")).", useronlinemarking='".addslashes($_POST['useronlinemarking'])."', securitylevel='".intval($_POST['securitylevel'])."', ai_posts='$ai_posts', ai_days='$ai_days', showonteam='".intval($_POST['showonteam'])."', showorder='".intval($_POST['showorder'])."', description='".addslashes($_POST['description'])."' WHERE groupid='$groupid'");
		cachegroupcombinationdata($groupid);
		
		// update automatic insert
		if ($ai_posts != $group['ai_posts'] || $ai_days != $group['ai_days']) updateAI();
		
		
		
		// delete groupleaders
		$db->query("DELETE FROM bb".$n."_groupleaders WHERE groupid='$groupid'");
		$db->query("UPDATE bb".$n."_users SET isgroupleader='0'");
		
		$update_str = '';
		$result = $db->query("SELECT DISTINCT userid FROM bb".$n."_groupleaders");
		while ($row = $db->fetch_array($result)) $update_str .= ",$row[userid]";
		if ($update_str) $db->unbuffered_query("UPDATE bb".$n."_users SET isgroupleader='1' WHERE userid IN (0".$update_str.")");
		
		// add groupleaders
		if (is_array($_POST['groupleaders'])) {
			$insert_str = '';
			$update_str = '';
			while (list($key, $val) = each($_POST['groupleaders'])) {
				$val = intval($val);
				if ($val) {
					$insert_str .= ",('$val','$groupid')";
					$update_str .= ",'$val'";
				}
			}
			if ($insert_str && $update_str) {
				$db->query("INSERT INTO bb".$n."_groupleaders (userid,groupid) VALUES ".wbb_substr($insert_str, 1));
				$db->unbuffered_query("UPDATE bb".$n."_users SET isgroupleader='1' WHERE userid IN (".wbb_substr($update_str, 1).")");
			}
		}
		header("Location: group.php?action=view&sid=$session[hash]");
		exit();
	}
	
	$selected = array("", "", "", "", "", "", "");
	$selected[$group['grouptype']] = " selected=\"selected\"";
	if ($group['grouptype'] < 5) $grouptypedisabled = " disabled=\"disabled\"";
	
	$sel_showonteam = array("", "");
	$sel_showonteam[$group['showonteam']] = " selected=\"selected\"";
	
	
	$groupleaders_options = '';
	$result = $db->query("SELECT g.userid, username FROM bb".$n."_groupleaders g LEFT JOIN bb".$n."_users USING(userid) WHERE g.groupid = '$groupid' ORDER BY username ASC");
	while ($row = $db->fetch_array($result)) $groupleaders_options .= makeoption($row['userid'], $row['username'], $row['userid']);
	
	$group['useronlinemarking'] = htmlconverter($group['useronlinemarking']);
	$group['title'] = htmlconverter($group['title']);
	
	eval("\$tpl->output(\"".$tpl->get("group_edit", 1)."\",1);");
}












/** edit rights */
if ($action == 'rights') {
	if (isset($_REQUEST['groupid'])) $groupid = intval($_REQUEST['groupid']);
	else $groupid = 0;
	if (isset($_REQUEST['parentvariablegroupid'])) $parentvariablegroupid = intval($_REQUEST['parentvariablegroupid']);
	else $parentvariablegroupid = 0;
	
	$group = $db->query_first("SELECT * FROM bb".$n."_groups WHERE groupid='$groupid'");
	$variablegrouptitle = '';
	$variablegroupcache = array();
	
	if (!$group['groupid']) {
		header("Location: group.php?action=view&sid=$session[hash]");
		exit();
	}
	
	// check if the user has the permission to edit this group
	if (in_array($groupid, $wbbuserdata['groupids'])) checkAdminPermissions('a_can_groups_edit_own', 1);
	else checkAdminPermissions('a_can_groups_edit', 1);
	
	// check groups' securitylevel
	checkSecurityLevel($group['securitylevel'], 1);
	
	
	
	if (isset($_POST['send'])) {
		reset($_POST);
		
		$result = $db->query("SELECT gv.*, gvg.* FROM bb".$n."_groupvariables gv LEFT JOIN bb".$n."_groupvariablegroups gvg ON gvg.variablegroupid=gv.variablegroupid");
		while ($row = $db->fetch_array($result)) {
			// check securitylevel of variablegroup
			if (!isset($_POST['groupvariable'][$row['variableid']]) || !checkSecurityLevel($row['securitylevel'])) continue;
			$value = $_POST['groupvariable'][$row['variableid']];
			if ($row['type'] == "truefalse") $value = intval($value);
			elseif ($row['type'] == "integer" || $row['type'] == "inverse_integer") $value = intval($value);
			elseif ($row['type'] == "string") $value = addslashes(preg_replace("/\s*\n\s*/", "\n", trim($value)));
			$db->query("REPLACE INTO bb".$n."_groupvalues (groupid,variableid,value) VALUES ('$groupid','$row[variableid]','$value')");
		}
		
		// update groupcombination data
		$result = $db->query("SELECT groupids, data FROM bb".$n."_groupcombinations WHERE CONCAT(',', groupids, ',') LIKE '%,".$groupid.",%'");
		while ($row = $db->fetch_array($result)) cachegroupcombinationdata($row['groupids'], 1, 1, unserialize($row['data']));
		
		header("Location: group.php?action=view&sid=$session[hash]");
		exit();
	}
	
	
	$result = $db->query("SELECT gvg.* FROM bb".$n."_groupvariablegroups gvg LEFT OUTER JOIN bb".$n."_groupvariables v ON v.variablegroupid=gvg.variablegroupid AND v.acpmode<='".$wbbuserdata['acpmode']."' LEFT OUTER JOIN bb".$n."_groupvariablegroups gvg2 ON gvg2.parentvariablegroupid=gvg.variablegroupid AND gvg2.acpmode<='".$wbbuserdata['acpmode']."' WHERE gvg.acpmode<='".$wbbuserdata['acpmode']."' GROUP BY gvg.variablegroupid HAVING (COUNT(v.variableid)>0 OR COUNT(gvg2.variablegroupid)>0) ORDER BY gvg.parentvariablegroupid ASC, gvg.showorder ASC");
	while ($row = $db->fetch_array($result)) {
		if (!checkSecurityLevel($row['securitylevel']))	{
			if ($row['variablegroupid'] == $parentvariablegroupid) acp_error($lang->get("LANG_ACP_GLOBAL_ERROR_SECURITYLEVEL"));
			else continue;
		}
		
		$row['title'] = $lang->get("LANG_ACP_GROUP_VARGROUP_".$row['title']);
		
		if ($parentvariablegroupid == $row['variablegroupid']) $variablegrouptitle = $row['title'];
		$variablegroupcache[$row['parentvariablegroupid']][] = $row;
	}
	$result = $db->query("SELECT var.*,vl.* FROM bb".$n."_groupvariables var LEFT JOIN bb".$n."_groupvalues vl USING(variableid) WHERE vl.groupid='$groupid' AND var.acpmode<='".$wbbuserdata['acpmode']."' ORDER BY showorder ASC");
	while ($row = $db->fetch_array($result)) {
		$row['title'] = $lang->get("LANG_ACP_GROUP_VAR_".wbb_strtoupper($row['variablename']));
		$row['description'] = $lang->get("LANG_ACP_GROUP_VAR_".wbb_strtoupper($row['variablename'])."_DESC");
		if ($row['type'] == 'inverse_integer') $row['type'] = 'integer';
		
		$valuecache[$row['variablegroupid']][] = $row;
	}
	$maxcolspan = getmaxcolspan($parentvariablegroupid) + 2;
	$variablelist = makevariablelist($parentvariablegroupid);
	
	$group['title'] = getlangvar($group['title'], $lang);
	$lang->items['LANG_ACP_GROUP_RIGHTS'] = $lang->get("LANG_ACP_GROUP_RIGHTS", array('$variablegrouptitle' => $variablegrouptitle, '$title' => $group['title']));
	eval("\$tpl->output(\"".$tpl->get("group_rights", 1)."\",1);");
}


function makevariablelist($variablegroupid, $level = 0) {
	global $variablegroupcache, $valuecache, $maxcolspan, $lang, $tpl;

	if (is_array($variablegroupcache[$variablegroupid])) {
		reset($variablegroupcache[$variablegroupid]);
		while (list($key, $val) = each($variablegroupcache[$variablegroupid])) {
			$colspan = $maxcolspan - $level;
			$tds = str_repeat("<td class=\"secondrow\">&nbsp;&nbsp;</td>", $level);
			eval("\$variablelist .= \"".$tpl->get("group_variablegroup", 1)."\";");

			$variablelist .= makevariablelist($val['variablegroupid'], $level + 1);

			if (is_array($valuecache[$val['variablegroupid']])) {
				$count = 0;
				reset($valuecache[$val['variablegroupid']]);
				while (list($key2, $val2) = each($valuecache[$val['variablegroupid']]))
				{
					$trclass = getone($count, "secondrow", "firstrow");
					$colspan = $maxcolspan - $level - 2;
					$tds = str_repeat("<td class=\"secondrow\">&nbsp;&nbsp;</td>", $level + 1);
					$variablefield = '';
					$selected = array('', '');
					if ($val2['type'] == "truefalse") $selected[$val2['value']] = " selected=\"selected\"";
					if ($val2['type'] == "string") $val2['value'] = htmlconverter($val2['value']);
					eval("\$variablefield = \"".$tpl->get("group_variablefield_".$val2['type'], 1)."\";");
					eval("\$variablelist .= \"".$tpl->get("group_variablerow", 1)."\";");
					$count++;
				}
			}
		}
	}


	if ($level == 0 && is_array($valuecache[$variablegroupid])) {
		$tds = '';
		$count = 0;
		reset($valuecache[$variablegroupid]);
		while (list($key2, $val2) = each($valuecache[$variablegroupid])) {
			$trclass = getone($count, "secondrow", "firstrow");
			$colspan = $maxcolspan - $level - 2;
			if ($colspan < 1) $colspan = 1;
			$variablefield = '';
			$selected = array("", "");
			if ($val2['type'] == "truefalse") $selected[$val2['value']] = " selected=\"selected\"";
			if ($val2['type'] == "string") $val2['value'] = htmlconverter($val2['value']);
			eval("\$variablefield = \"".$tpl->get("group_variablefield_".$val2['type'], 1)."\";");
			eval("\$variablelist .= \"".$tpl->get("group_variablerow", 1)."\";");
			$count++;
		}
	}


	return $variablelist;
}

function getmaxcolspan($variablegroupid = 0) {
	global $variablegroupcache;
	
	if (!isset($variablegroupcache[$variablegroupid])) return 0;
	
	$maxcolspan = 0;
	while (list($key, $val) = each($variablegroupcache[$variablegroupid])) {
		$newcolspan = getmaxcolspan($val['variablegroupid']);
		if ($newcolspan > $maxcolspan) $maxcolspan = $newcolspan;
	}
	
	return $maxcolspan + 1;
}










/** copy entire usergroup - with our without users */
if ($action == 'copy') {
	$groupid = intval($_REQUEST['groupid']);
	$group = $db->query_first("SELECT * FROM bb".$n."_groups WHERE groupid='$groupid'");
	if (!$group['groupid']) {
		header("Location: group.php?action=view&sid=$session[hash]");
		exit();
	}

	// check if the user has the permission to copy a group
	checkAdminPermissions('a_can_groups_add', 1);

	if (isset($_POST['send']) && $_POST['send'] == "send" && $group['groupid']) {
		// copy group
		$db->query("INSERT INTO bb".$n."_groups (title,useronlinemarking,grouptype,securitylevel,ai_posts,ai_days) VALUES('".addslashes($_POST['title'])."','".addslashes($group['useronlinemarking'])."','".(($group['grouptype'] > 4) ? ($group['grouptype']) : (5))."', '".intval($group['securitylevel'])."','".$group['ai_posts']."','".$group['ai_days']."')");
		$newgroupid = $db->insert_id();

		if ($group['ai_posts'] > -1 || $group['ai_days'] > -1) updateAI();

		// copy group settings
		$insert_str = '';
		$result = $db->query("SELECT variableid,value FROM bb".$n."_groupvalues WHERE groupid='$groupid'");
		while ($row = $db->fetch_array($result)) $insert_str .= ",('$newgroupid','".$row['variableid']."','".addslashes($row['value'])."')";
		if ($insert_str) $db->unbuffered_query("INSERT INTO bb".$n."_groupvalues (groupid,variableid,value) VALUES ".wbb_substr($insert_str, 1));

		// copy permissions
		$result = $db->query("SHOW FIELDS FROM bb".$n."_permissions");
		$fields = array();
		while ($row = $db->fetch_array($result)) {
			if ($row['Field'] != "boardid" && $row['Field'] != "groupid") {
				$fields[] = $row['Field'];
			}
		}

		$insert_str = '';
		$result = $db->query("SELECT * FROM bb".$n."_permissions WHERE groupid='$groupid'");
		while ($row = $db->fetch_array($result)) {
			$insert_str .= ",('".$row['boardid']."', '$newgroupid'";
			for ($i = 0; $i < count($fields); $i++) $insert_str .= ",'".(($row[$fields[$i]]) ? ($row[$fields[$i]]) : (" - 1"))."'";
			$insert_str .= ")";
		}
		if ($insert_str) $db->query("INSERT INTO bb".$n."_permissions (boardid,groupid,".implode(",", $fields).") VALUES ".wbb_substr($insert_str, 1));

		cachegroupcombinationdata($newgroupid);

		// copy user and groupleaders
		if (isset($_POST['copyuser']) && $_POST['copyuser'] == 1) {
			$insert_str = '';
			$newgroupcombinations = array();
			$result = $db->query("SELECT u2g.userid, g.groupids FROM bb".$n."_user2groups u2g LEFT JOIN bb".$n."_users USING(userid) LEFT JOIN bb".$n."_groupcombinations g USING(groupcombinationid) WHERE u2g.groupid='$groupid'");
			while ($row = $db->fetch_array($result)) {
				$groupids = explode(",", $row['groupids']);
				$groupids[] = $newgroupid;
				sort($groupids);
				$groupids = implode(",", $groupids);
				
				$newgroupcombinations[$groupids] .= ",".$row['userid'];
				$insert_str .= ",('".$row['userid']."','".$newgroupid."')";
			}
			if ($insert_str) $db->unbuffered_query("INSERT INTO bb".$n."_user2groups (userid,groupid) VALUES ".wbb_substr($insert_str, 1));

			if (count($newgroupcombinations)) {
				while (list($groupids, $userids) = each($newgroupcombinations)) $db->unbuffered_query("UPDATE bb".$n."_users SET groupcombinationid = '".cachegroupcombinationdata($groupids)."' WHERE userid IN (0".$userids.")");
			}

			$insert_str = '';
			$result = $db->query("SELECT userid FROM bb".$n."_groupleaders WHERE groupid='$groupid'");
			while ($row = $db->fetch_array($result)) $insert_str .= ",('".$row['userid']."','".$newgroupid."')";
			if ($insert_str) $db->unbuffered_query("INSERT INTO bb".$n."_groupleaders (userid,groupid) VALUES ".wbb_substr($insert_str, 1));
		}

		header("Location: group.php?action=view&sid=$session[hash]");
		exit;
	}

	eval("\$tpl->output(\"".$tpl->get("group_copy", 1)."\",1);");
}







/** update - undocumented: adds rows for new groupvariables (with the default values) */
if ($action == 'update') {
	$result = $db->query("SELECT variableid,defaultvalue FROM bb".$n."_groupvariables");
	$not_str = '';
	while ($row = $db->fetch_array($result)) {
		$not_str .= ",'$row[variableid]'";
		$db->unbuffered_query("INSERT IGNORE INTO bb".$n."_groupvalues (variableid,value,groupid) SELECT '$row[variableid]' as variableid,'".addslashes($row['defaultvalue'])."' as value,groupid FROM bb".$n."_groups");
	}

	if ($not_str) $db->unbuffered_query("DELETE FROM bb".$n."_groupvalues WHERE variableid NOT IN (".wbb_substr($not_str, 1).")");

	$result = $db->query("SELECT groupids FROM bb".$n."_groupcombinations");
	while ($row = $db->fetch_array($result)) cachegroupcombinationdata($row['groupids']);

	header("Location: group.php?action=view&sid=$session[hash]");
	exit;
}




/** find user for groupleader */
if ($action == 'group_finduser') {
	
	// check if the user has the permission to perform this action
	if (!checkAdminPermissions('a_can_groups_add') && !checkAdminPermissions('a_can_groups_edit') && !checkAdminPermissions('a_can_groups_edit_own')) {
		access_error(1);
	}
	
	$options = '';
	$username = wbb_trim($_POST['username']);
	
	if (isset($_POST['send']) && $username != '') {
		$result = $db->unbuffered_query("SELECT userid,username FROM bb".$n."_users WHERE username LIKE '%".addslashes($username)."%'");
		while ($row = $db->fetch_array($result)) {
			$row['username'] = htmlconverter($row['username']);
			$options .= makeoption($row['userid'], $row['username']);
		}
	}
	
	eval("\$tpl->output(\"".$tpl->get("group_finduser", 1)."\",1);");
}














/** set securitylevels for variablegroups */
if ($action == 'variablegroups_set_securitylevel') {
	// check if the user has the permission to perform this action
	checkAdminPermissions('a_can_groups_variablegroups_set_securitylevel', 1);

	// save securitylevels
	if (isSet($_POST['send'])) {
		if (is_array($_POST['securitylevels']) && count($_POST['securitylevels'])) {
			reset($_POST['securitylevels']);
			while (list($variablegroupid, $securitylevel) = each($_POST['securitylevels'])) {
				$db->unbuffered_query("UPDATE bb".$n."_groupvariablegroups SET securitylevel='".intval($securitylevel)."' WHERE variablegroupid='".intval($variablegroupid)."'");
			}
		}
		header("Location: group.php?action=view&sid=$session[hash]");
		exit;
	}

	// show form
	$variablegroupcache = array();
	$result = $db->query("SELECT * FROM bb".$n."_groupvariablegroups ORDER BY parentvariablegroupid ASC, showorder ASC");
	while ($row = $db->fetch_array($result)) {
		$row['title'] = $lang->get("LANG_ACP_GROUP_VARGROUP_".$row['title']);
		$variablegroupcache[$row['parentvariablegroupid']][] = $row;
	}

	$maxcolspan = getmaxcolspan(0) + 2;
	$variablegrouplist = makevariablegrouplist(0);

	eval("\$tpl->output(\"".$tpl->get("group_variablegroups_set_securitylevel", 1)."\",1);");
}

function makevariablegrouplist($variablegroupid, $level = 0) {
	global $variablegroupcache, $maxcolspan, $tpl;

	$variablelist = '';
	if (is_array($variablegroupcache[$variablegroupid])) {
		reset($variablegroupcache[$variablegroupid]);
		while (list($key, $val) = each($variablegroupcache[$variablegroupid])) {
			$colspan = $maxcolspan - $level;
			$tds = str_repeat("<td class=\"secondrow\">&nbsp;&nbsp;</td>", $level);
			eval("\$variablelist .= \"".$tpl->get("group_variablegroups_set_securitylevel_variablegroup", 1)."\";");
			$variablelist .= makevariablegrouplist($val['variablegroupid'], $level + 1);
		}
	}


	return $variablelist;
}

// update the automatic insert function
function updateAI() {
	global $db, $n;
	
	$posts4AI = array();
	$days4AI = array();
	
	$result = $db->query("SELECT groupid, ai_posts, ai_days FROM bb".$n."_groups WHERE grouptype > 4 AND (ai_posts>-1 OR ai_days>-1)");
	while ($row = $db->fetch_array($result)) {
		if ($row['ai_posts'] > -1) $posts4AI[$row['groupid']] = $row['ai_posts'];
		if ($row['ai_days'] > -1) $days4AI[$row['groupid']] = $row['ai_days'];
	}
	
	$db->query("UPDATE bb".$n."_options SET value='".serialize($posts4AI)."' WHERE varname='posts4AI'");
	$db->query("UPDATE bb".$n."_options SET value='".serialize($days4AI)."' WHERE varname='days4AI'");
	
	require("./lib/class_options.php");
	$option = new options("lib");
	$option->write();
}











function makeboardlist($boardid, $x = 0) {
	global $boardcache, $session, $maxcolspan, $permissioncache, $tpl, $lang, $style;
	
	if (!isset($boardcache[$boardid])) return;
	
	while (list($key1, $val1) = each($boardcache[$boardid])) {
		while (list($key2, $boards) = each($val1)) {
			$colspan = $maxcolspan - $x;
			$temp = $maxcolspan - ($maxcolspan - $x);
			if ($temp) $tds = str_repeat("<td class=\"secondrow\">&nbsp;&nbsp;</td>", $temp);
			else $tds = '';
			
			$sel_boardpermission = array("", "", ""); $sel_startpermission = array("", "", ""); $sel_replypermission = array("", "", "");
			
			if (!isset($permissioncache[$boards['boardid']]['boardpermission']) || $permissioncache[$boards['boardid']]['boardpermission'] == -1) $permissioncache[$boards['boardid']]['boardpermission'] = 2;
			if (!isset($permissioncache[$boards['boardid']]['startpermission']) || $permissioncache[$boards['boardid']]['startpermission'] == -1) $permissioncache[$boards['boardid']]['startpermission'] = 2;
			if (!isset($permissioncache[$boards['boardid']]['replypermission']) || $permissioncache[$boards['boardid']]['replypermission'] == -1) $permissioncache[$boards['boardid']]['replypermission'] = 2;
			
			
			$sel_boardpermission[$permissioncache[$boards['boardid']]['boardpermission']] = " selected=\"selected\"";
			$sel_startpermission[$permissioncache[$boards['boardid']]['startpermission']] = " selected=\"selected\"";
			$sel_replypermission[$permissioncache[$boards['boardid']]['replypermission']] = " selected=\"selected\"";
			
			switch ($permissioncache[$boards['boardid']]['boardpermission']) {
				case 1: $boardpermission_bgClass = 'greenBG'; break;
				case 0: $boardpermission_bgClass = 'redBG'; break;
				default: $boardpermission_bgClass = 'whiteBG';
			}
			switch ($permissioncache[$boards['boardid']]['startpermission']) {
				case 1: $startpermission_bgClass = 'greenBG'; break;
				case 0: $startpermission_bgClass = 'redBG'; break;
				default: $startpermission_bgClass = 'whiteBG';
			}
			switch ($permissioncache[$boards['boardid']]['replypermission']) {
				case 1: $replypermission_bgClass = 'greenBG'; break;
				case 0: $replypermission_bgClass = 'redBG'; break;
				default: $replypermission_bgClass = 'whiteBG';
			}
						
			$boardpermissionIncomplete = $permissioncache[$boards['boardid']]['boardpermissionIncomplete'];	
			
			eval("\$out .= \"".$tpl->get("group_permissionsbit", 1)."\";");
			$out .= makeboardlist($boards['boardid'], $x + 1);
		}
	}
	
	unset($boardcache[$boardid]);
	return $out;
}














/** set forum permissions (simplified) **/
if ($action == 'permissions') {
	checkAdminPermissions('a_can_boards_permissions', 1);
	$groupid = intval($_REQUEST['groupid']);
	$group = $db->query_first("SELECT groupid, title, securitylevel FROM bb".$n."_groups WHERE groupid='$groupid'");
	if (!$group['groupid']) {
		header("Location: group.php?action=view&sid=$session[hash]");
		exit();
	}
	
	// check securitylevel
	checkSecurityLevel($group['securitylevel'], 1);
	
	$boardids = '';
	if (!checkAdminPermissions('a_can_boards_global')) {
		$result = $db->query("SELECT boardid FROM bb".$n."_moderators WHERE userid='".$wbbuserdata['userid']."'");
		while ($row = $db->fetch_array($result)) $boardids .= "," . $row['boardid'];
		
		if ($boardids == '') access_error(1);
	}
	
	
	if (isset($_POST['send'])) {
		$permcache = array();
		$result = $db->query("SELECT * FROM bb".$n."_permissions WHERE groupid = '".$groupid."'");
		while ($row = $db->fetch_array($result, MYSQL_ASSOC)) $permcache[$row['boardid']] = $row;
		
		$db->query("DELETE FROM bb".$n."_permissions WHERE groupid = '".$groupid."'" . (($boardids != '') ? (" AND boardid IN (0$boardids)") : ("")));
		
		$result = $db->query("SELECT boardid FROM bb".$n."_boards" . (($boardids != '') ? (" WHERE boardid IN (0$boardids)") : ("")));
		while ($row = $db->fetch_array($result)) {
			if (!isset($_POST['ignoreBoardpermission'][$row['boardid']]) || !$_POST['ignoreBoardpermission'][$row['boardid']]) {
				$permcache[$row['boardid']]['can_view_board'] = intval($_POST['boardpermission'][$row['boardid']]);
				$permcache[$row['boardid']]['can_enter_board'] = intval($_POST['boardpermission'][$row['boardid']]);
				$permcache[$row['boardid']]['can_read_thread'] = intval($_POST['boardpermission'][$row['boardid']]);
				$permcache[$row['boardid']]['can_use_search'] = intval($_POST['boardpermission'][$row['boardid']]);
			}
			$permcache[$row['boardid']]['can_start_topic'] = intval($_POST['startpermission'][$row['boardid']]);
			$permcache[$row['boardid']]['can_reply_topic'] = intval($_POST['replypermission'][$row['boardid']]);
			
			$varlist = '';
			$valuelist = '';
			$insert_perm = false;
			
			reset($permcache[$row['boardid']]);
			while (list($key, $val) = each($permcache[$row['boardid']])) {
				if ($key == "boardid" || $key == "groupid") continue;
				
				if ($val != -1) $insert_perm = true;
				
				$varlist .= "," . $key;
				$valuelist .= ",'" . $val . "'";
			}
			
			if ($insert_perm) $db->query("INSERT INTO bb".$n."_permissions (boardid,groupid".$varlist.") VALUES ('$row[boardid]','$groupid'".$valuelist.")");
		}
		
		$result = $db->query("SELECT groupids, data FROM bb".$n."_groupcombinations WHERE CONCAT(',', groupids, ',') LIKE '%,".$groupid.",%'");
		while ($row = $db->fetch_array($result)) cachegroupcombinationdata($row['groupids'], 1, 2, unserialize($row['data']));
		
		header("Location: group.php?action=view&sid=$session[hash]");
		exit();
	}
	
	
	$permissioncache = array();
	$result = $db->query("SELECT * FROM bb".$n."_permissions WHERE groupid = '$groupid'");
	while ($row = $db->fetch_array($result)) {
		$boardpermission = $row['can_view_board'] + $row['can_enter_board'] + $row['can_read_thread'] + $row['can_use_search'];
		if (abs($boardpermission) != 4 && $boardpermission != 0) $boardpermissionIncomplete = 1;
		else $boardpermissionIncomplete = 0;
		$boardpermission = intval($boardpermission / 4);
		
		$startpermission = $row['can_start_topic'];
		$replypermission = $row['can_reply_topic'];
		
		$permissioncache[$row['boardid']] = array("boardpermission" => $boardpermission, "startpermission" => $startpermission, "replypermission" => $replypermission, "boardpermissionIncomplete" => $boardpermissionIncomplete);
	}
	
	$maxcolspan = 0;
	$result = $db->query("SELECT boardid, parentid, boardorder, title, parentlist FROM bb".$n."_boards ORDER by parentid ASC, boardorder ASC");
	while ($row = $db->fetch_array($result)) {
		$temp = count(explode(",", $row['parentlist']));
		if ($temp > $maxcolspan) $maxcolspan = $temp;
		$row['title'] = getlangvar($row['title'], $lang);
		$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
	}
	$boardlist = makeboardlist(0);
	
	if ($maxcolspan < 1) $maxcolspan = 1;
	$maxcolspan2 = $maxcolspan + 3;
	
	$group['title'] = getlangvar($group['title'], $lang);
	$lang->items['LANG_ACP_GROUP_PERMISSIONS'] = $lang->get("LANG_ACP_GROUP_PERMISSIONS", array('$title' => $group['title']));
	eval("\$tpl->output(\"".$tpl->get("group_permissions", 1)."\", 1); ");
}



/** send email */
if ($action == 'email') {
	// check permissions
 	checkAdminPermissions('a_can_users_email', 1);
 	$lang->load("ACP_OTHERSTUFF,ACP_USERS");

 	if (isset($_GET['groupid'])) $groupid = intval($_GET['groupid']);
 	else $groupid = 0;
 	
 	list($members) = $db->query_first("SELECT COUNT(*) AS members FROM bb".$n."_user2groups u2g LEFT JOIN bb".$n."_users u USING (userid) WHERE u2g.groupid = '".$groupid."' AND admincanemail = 1");
 	if (!$members) acp_error($lang->items['LANG_ACP_GROUP_EMAIL_ERROR']);
 		
 	$group = $db->query_first("SELECT groupid, title FROM bb".$n."_groups WHERE groupid='".$groupid."'");
 	if (!$group['groupid']) {
  		header("Location: group.php?action=view&sid=$session[hash]");
  		exit();
 	}

	$grouptitle = getlangvar($group['title'], $lang);
	$lang->items['LANG_ACP_GROUP_EMAIL_TITLE'] = $lang->get("LANG_ACP_GROUP_EMAIL_TITLE", array('$grouptitle' => $grouptitle));
	eval("\$tpl->output(\"".$tpl->get("group_email", 1)."\",1);");
}


/** send private message **/
if ($action == 'pmsend') {
	// check permissions
	if (!checkAdminPermissions('a_can_groups_pmsend') && !checkAdminPermissions('a_can_ignore_maxpms') && !checkAdminPermissions('a_can_users_email')) access_error(1);
	$lang->load("ACP_USERS,PMS,POSTINGS");
	include_once('./lib/class_parse.php');
	include_once('./lib/class_parsecode.php');

	if (isset($_REQUEST['groupids'])) $groupids = intval_array($_REQUEST['groupids']);
	else $groupids = array();
	
	$group_options = '';
	$result = $db->query("SELECT groupid, title FROM bb".$n."_groups WHERE grouptype > 1 ORDER BY showorder ASC");
	while ($row = $db->fetch_array($result)) {
		$row['title'] = getlangvar($row['title'], $lang);
		$group_options .= makeoption($row['groupid'], $row['title'], $groupids);
	}
 	
	// checkbox preselect
	$checked = array();
	if ($newpm_default_checked_0 == 1) $checked[0] = 'checked="checked"';
	if ($newpm_default_checked_1 == 1) $checked[1] = 'checked="checked"';
	if ($newpm_default_checked_5 == 1) $checked[5] = 'checked="checked"';
	if ($newpm_default_checked_6 == 1) $checked[6] = 'checked="checked"';
	if ($newpm_default_checked_2 == 1) $checked[2] = 'checked="checked"';
	if ($newpm_default_checked_3 == 1) $checked[3] = 'checked="checked"';
	if ($newpm_default_checked_4 == 1) $checked[4] = 'checked="checked"'; 	
	$checked[7] = 'checked="checked"';
 	
 	if (isset($_POST['send'])) {
		if (isset($_POST['subject'])) $subject = wbb_trim($_POST['subject']);
 		else $subject = '';
 		if ($subject == '') $subject = '---';
 		if (isset($_POST['message'])) $message = wbb_trim($_POST['message']);
 		else $message = '';
 		if (isset($_POST['blindcopy'])) $blindcopy = intval($_POST['blindcopy']);
 		else $blindcopy = 0;
 		if (isset($_POST['savecopy'])) $savecopy = intval($_POST['savecopy']);
 		else $savecopy = 0;
 		if (isset($_POST['showsignature'])) $showsignature = intval($_POST['showsignature']);
 		else $showsignature = 0;

		/* parse url */
		if ($_POST['parseurl'] == 1) $message = parseURL($message);

		/* posting feature rights:start */
		if (!$wbbuserdata['can_use_pn_smilies'] || (isset($_POST['disablesmilies']) && $_POST['disablesmilies'] == 1)) $allowsmilies = 0;
		else $allowsmilies = 1;
		if (!$wbbuserdata['can_use_pn_html'] || (isset($_POST['disablehtml']) && $_POST['disablehtml'] == 1)) $allowhtml = 0;
		else $allowhtml = 1;
		if (!$wbbuserdata['can_use_pn_bbcode'] || (isset($_POST['disablebbcode']) && $_POST['disablebbcode'] == 1)) $allowbbcode = 0;
		else $allowbbcode = 1;
		if (!$wbbuserdata['can_use_pn_images'] || (isset($_POST['disableimages']) && $_POST['disableimages'] == 1)) $allowimages = 0;
		else $allowimages = 1;
		/* posting feature rights:end */

	
		// show max. 10 recipients in outbox, etc.
		$pmmaxrecipientlistsize = 10; 		
		
 		if (count($groupids)) {
	 		foreach ($groupids as $groupid) 
	 		$groupcombinationids = '';
	 		$result = $db->query("SELECT groupcombinationid, groupids FROM bb".$n."_groupcombinations WHERE (CONCAT(',',groupids,',') LIKE '%,".implode(",%') OR (CONCAT(',',groupids,',') LIKE '%,", $groupids).",%')");
			while ($row = $db->fetch_array($result)) {
				$groupcombinationids .= ",$row[groupcombinationid]";
			}
			
	 		$userids = '';
			if ($groupcombinationids != '') {
				$groupcombinationids = wbb_substr($groupcombinationids, 1);
				
				list($recipientcount) = $db->query_first("SELECT COUNT(*) as recipientcount FROM bb".$n."_users WHERE groupcombinationid IN ($groupcombinationids)");
				$recipientlist = array();
				$result = $db->query("SELECT userid, username FROM bb".$n."_users WHERE groupcombinationid IN ($groupcombinationids) ORDER BY username ASC", $pmmaxrecipientlistsize);
				while ($row = $db->fetch_array($result)) $recipientlist[$row['userid']] = $row['username'];
				
				// insert private message
				$sendtime = time();
				$db->query("INSERT INTO bb".$n."_privatemessage ".
				"(senderid, recipientlist, recipientcount, subject, message, sendtime, ".
				"allowsmilies, allowhtml, allowbbcode, allowimages, showsignature, ".
				"inoutbox, tracking) VALUES ".
				"('$wbbuserdata[userid]', '".addslashes(serialize($recipientlist))."', '$recipientcount', ".
				"'".addslashes($subject)."', '".addslashes($message)."', '$sendtime', '$allowsmilies', '$allowhtml', '$allowbbcode', '$allowimages', '$showsignature', '$savecopy', '0')");
				$pmid = $db->insert_id();
				
				// insert recipients
				$db->query("INSERT INTO bb".$n."_privatemessagereceipts (privatemessageid, recipientid, recipient, blindcopy) SELECT '$pmid' as privatemessageid, userid as recipientid, username as recipient, '$blindcopy' as blindcopy FROM bb".$n."_users WHERE groupcombinationid IN ($groupcombinationids)");
				
				// update pm-counters
				$db->query("UPDATE bb".$n."_users SET pmtotalcount=pmtotalcount+1, pminboxcount=pminboxcount+1, pmnewcount=pmnewcount+1, pmunreadcount=pmunreadcount+1 WHERE groupcombinationid IN ($groupcombinationids)");

				// update pm-popups
				$db->query("UPDATE bb".$n."_users SET pmpopup=2 WHERE groupcombinationid IN ($groupcombinationids) AND pmpopup=1");

				// insert notificationmails into mailqueue
				$mailids = '';
				$caseStr = '';
				$result = $db->query("SELECT languagepackid FROM bb".$n."_languagepacks");
				while ($row = $db->fetch_array($result)) {
					if ($row['languagepackid']) $langpack = &new language(intval($row['languagepackid']));
					else $langpack = $lang;
					$langpack->load('OWN,MAIL');
							
					$master_board_name_email = getlangvar($o_master_board_name, $langpack, 0);
					$mail_subject = $langpack->get("LANG_MAIL_NEWPM_SUBJECT", array('$master_board_name_email' => $master_board_name_email));
					$mail_text = $langpack->get("LANG_MAIL_NEWPM_TEXT", array('$sender' => $wbbuserdata['username'], '$url2board' => $url2board, '$master_board_name_email' => $master_board_name_email));
					
					$db->query("INSERT INTO bb".$n."_mails (subject, message, userid, sendtime) VALUES ('".addslashes($mail_subject)."', '".addslashes($mail_text)."', '$wbbuserdata[userid]', '".time()."')");
					$mailid = $db->insert_id();
					$mailids .= ",$mailid";
					
					$caseStr .= "WHEN $row[languagepackid] THEN $mailid\n";
				}
				
				if ($mailids != '') {
					$db->query("INSERT INTO bb".$n."_mailqueue (mailid, userid, email, username) ".
					"SELECT (CASE langid ".
					wbb_trim($caseStr)." END) as mailid, userid, email, username ".
					"FROM bb".$n."_users WHERE groupcombinationid IN ($groupcombinationids) AND emailonpm=1");
					
					$sendMails = false;
					$result = $db->query("SELECT m.mailid, COUNT(q.userid) as recipients FROM bb".$n."_mails m LEFT JOIN bb".$n."_mailqueue q USING(mailid) WHERE m.mailid IN (0$mailids) GROUP BY m.mailid");
					while ($row = $db->fetch_array($result)) {
						if ($row['recipients'] > 0) {
							$db->unbuffered_query("UPDATE bb".$n."_mails SET recipients='$row[recipients]' WHERE mailid='$row[mailid]'", 1);
							$sendMails = true;
						}
						else $db->unbuffered_query("DELETE FROM bb".$n."_mails WHERE mailid='$row[mailid]'", 1);
					}
					
					if ($sendMails) {
						header("Location: otherstuff.php?action=mailqueue&sid=$session[hash]");
						exit();	
					}
				}

				
				header("Location: group.php?action=view&sid=$session[hash]");
				exit();
			}
	 	}
 	}
 	
	eval("\$tpl->output(\"".$tpl->get("group_pmsend", 1)."\",1);");
}
?>
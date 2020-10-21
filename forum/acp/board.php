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
// * $Date: 2005-01-12 14:55:02 +0100 (Wed, 12 Jan 2005) $
// * $Author: Burntime $
// * $Rev: 1541 $
// ************************************************************************************//


require('./global.php');

if (isset($_REQUEST['submit_boardaction']) && isset($_REQUEST['boardaction']) && $j = count($_REQUEST['boardaction'])) {
	for ($i = 0; $i < $j; $i++) {
		if ($_REQUEST['boardaction'][$i] != '') {
			header("Location: ".$_REQUEST['boardaction'][$i]);
			exit;	
		}	
	}
}

$lang->load('ACP_BOARD,BOARD');

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = 'view';


// read in modpermissions
$modpermissions = array();
$result = $db->query("SELECT boardid,userid FROM bb".$n."_moderators WHERE userid='".$wbbuserdata['userid']."'");
while ($row = $db->fetch_array($result)) $modpermissions[$row['boardid']] = 1;




/**
* generates a boardlist
*
* @param integer boardid
* @param integer x
*
* @return string boardlist
*/
function makeboardlist($boardid, $x = 0) {
	global $boardcache, $session, $maxcolspan, $tpl, $lang;
	
	if (!isset($boardcache[$boardid])) return;
	
	while (list($key1, $val1) = each($boardcache[$boardid])) {
		while (list($key2, $boards) = each($val1)) {
			$count = countboards($boardcache[$boardid]);
			unset($options);
			for ($i = 1; $i <= $count; $i++) $options .= makeoption($i, $i, $boards['boardorder'], 1);
			$colspan = $maxcolspan - $x;
			$temp = $maxcolspan - ($maxcolspan - $x);
			if ($temp) $tds = str_repeat("<td class=\"secondrow\">&nbsp;&nbsp;</td>", $temp);
			else $tds = '';
			eval("\$out .= \"".$tpl->get("board_viewbit", 1)."\";");
			$out .= makeboardlist($boards['boardid'], $x + 1);
		} 
	} 
	unset($boardcache[$boardid]);
	return $out;
}


/**
* create data for tree view
*
* @param integer boardid
* @param integer x
* @param array parentperm
* @param array parentaccess
*
* @return string tree data
*/
function makeboardtree($boardid, $x = 0, $parentperm = array(), $parentaccess = array()) {
	global $boardcache, $modcache, $permissioncache, $groupcache, $accesscache, $session, $tpl, $lang;
	
	if (!isset($boardcache[$boardid])) return;
	
	$tree = "";
	
	while (list($key1, $val1) = each($boardcache[$boardid])) {
		while (list($key2, $boards) = each($val1)) {
			
			$count = countboards($boardcache[$boardid]);
			
			$tree .= ",\n";
			
			$tree .= "['".addcslashes($boards['title'], "'")."','1','".$boards['boardid']."|".$count."|".$boards['boardorder']."|".(($boards['parentid'] == 0 && $boards['childlist'] != "0") ? (1) : (0))."'";
			
			// moderators
			if (isset($modcache[$boards['boardid']]) && is_array($modcache[$boards['boardid']])) {
				$tree .= ",\n['".$lang->get("LANG_ACP_BOARD_MODERATORS")."','2',''";
				
				reset($modcache[$boards['boardid']]);
				while (list(, $moderator) = each($modcache[$boards['boardid']])) {
					$tree .= ",\n['".addcslashes($moderator['username'], "'")."','3','".$boards['boardid']."|".$moderator['userid']."']";
				}
				
				$tree .= "]";	
			}
			
			// permissions
			$tree .= ",['".$lang->get("LANG_ACP_BOARD_GROUPPERMISSIONS")."','4',''";
			
			reset($groupcache);
			while (list($groupid, $grouptitle) = each($groupcache)) {
				if (isset($permissioncache[$boards['boardid']][$groupid])) $color = 0;
				else if (isset($parentperm[$groupid])) {
					$permissioncache[$boards['boardid']][$groupid] = 1;
					$color = 1;	
				}
				else $color = 2;
				
				$tree .= ",\n['".addcslashes($grouptitle, "'")."','5','".$boards['boardid']."|".$groupid."|".$color."']";	
			}
			
			$tree .= "]";
			
			// user access
			if (count($parentaccess)) {
				reset($parentaccess);
				while (list(, $user) = each($parentaccess)) {
					if (!isset($accesscache[$boards['boardid']][$user['userid']])) {
						$user['color'] = 1;
						$accesscache[$boards['boardid']][$user['userid']] = $user;	
					}	
				}	
			}
			
			if (isset($accesscache[$boards['boardid']]) && is_array($accesscache[$boards['boardid']])) {
				$tree .= ",\n['".$lang->get("LANG_ACP_BOARD_USERACCESS")."','6',''";
				
				reset($accesscache[$boards['boardid']]);
				while (list(, $user) = each($accesscache[$boards['boardid']])) {
					$tree .= ",\n['".addcslashes($user['username'], "'")."','7','".$boards['boardid']."|".$user['userid']."|".intval($user['color'])."']";
				}
				
				$tree .= "]";
			}
			
			$tree .= makeboardtree($boards['boardid'], $x + 1, $permissioncache[$boards['boardid']], $accesscache[$boards['boardid']]);
			
			
			$tree .= "]";
			
			
		} 
	} 
	unset($boardcache[$boardid]);
	return $tree;
}


/**
* count boards
* 
* @param array array
*
* @return integer count
*/
function countboards($array) {
	$count = 0;
	reset($array);
	while (list($key, $val) = each($array)) $count += count($val);
	return $count;
}








/** view boards */
if ($action == 'view') {
	
	// check permissions
	if ((!checkAdminPermissions('a_can_boards_global') && !count($modpermissions)) || (!checkAdminPermissions('a_can_boards_edit') && !checkAdminPermissions('a_can_boards_del') && !checkAdminPermissions('a_can_boards_empty') && !checkAdminPermissions('a_can_boards_rights') && !checkAdminPermissions('a_can_boards_permissions') && !checkAdminPermissions('a_can_moderator_add') && !checkAdminPermissions('a_can_moderator_edit') && !checkAdminPermissions('a_can_moderator_del'))) {
		access_error(1);
	}
	
	
	if (isset($_POST['send'])) {
		if (isset($_POST['boardorder']) && is_array($_POST['boardorder'])) {
			reset($_POST['boardorder']);
			while (list($key, $val) = each($_POST['boardorder'])) $db->query("UPDATE bb".$n."_boards SET boardorder='$val' WHERE boardid = '$key'");
		}
	}
	
	if (isset($_GET['boardview_tree'])) {
		$boardview_tree = intval($_GET['boardview_tree']);
		bbcookie('boardview_tree', $boardview_tree, time() + 3600 * 24 * 365);
	}
	else {
		if (isset($_COOKIE[$cookieprefix.'boardview_tree'])) $boardview_tree = intval($_COOKIE[$cookieprefix.'boardview_tree']);
		else $boardview_tree = 1;
	}
	
	if ($boardview_tree == 1) {
		// tree view
		$result = $db->query("SELECT boardid, parentid, boardorder, title, childlist FROM bb".$n."_boards ORDER by parentid ASC, boardorder ASC");
		while ($row = $db->fetch_array($result)) {
			$row['title'] = getlangvar($row['title'], $lang);
			if (!$row['title']) $row['title'] = "---";
			$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
		}
		
		$result = $db->query("SELECT m.boardid, m.userid, u.username FROM bb".$n."_moderators m LEFT JOIN bb".$n."_users u USING (userid)");
		while ($row = $db->fetch_array($result)) $modcache[$row['boardid']][] = $row;
		
		$result = $db->query("SELECT boardid, groupid FROM bb".$n."_permissions");
		while ($row = $db->fetch_array($result)) $permissioncache[$row['boardid']][$row['groupid']] = 1;
		
		$result = $db->query("SELECT groupid, title FROM bb".$n."_groups");
		while ($row = $db->fetch_array($result)) $groupcache[$row['groupid']] = getlangvar($row['title'], $lang);
		
		$result = $db->query("SELECT a.boardid, a.userid, u.username FROM bb".$n."_access a LEFT JOIN bb".$n."_users u USING (userid)");
		while ($row = $db->fetch_array($result)) $accesscache[$row['boardid']][$row['userid']] = $row;
		
		$tree = makeboardtree(0);
		
		eval("\$tpl->output(\"".$tpl->get("board_view_tree", 1)."\",1);");
	}
	else {
		// simple view	
		$maxcolspan = 0;
		$result = $db->query("SELECT boardid, parentid, boardorder, title, parentlist FROM bb".$n."_boards ORDER by parentid ASC, boardorder ASC");
		while ($row = $db->fetch_array($result)) {
			$temp = count(explode(",", $row['parentlist']));
			if ($temp > $maxcolspan) $maxcolspan = $temp;
			$row['title'] = getlangvar($row['title'], $lang);
			$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;	
		}
		$boardlist = makeboardlist(0);
		$maxcolspan += 1;
		
		eval("\$tpl->output(\"".$tpl->get("board_view", 1)."\",1);");	
	}
}












/** 
* generate a boardlist
*
* @param integer boardid
* @param integer depth
* @param integer selected
* @param integer selboardid
*
* @return string boardlist
*/
function makeparentboardoptions($boardid, $depth = 1, $selected = 0, $selboardid = 0) {
	global $boardcache, $modpermissions;
	
	if (!isset($boardcache[$boardid])) return;
	
	while (list($key1, $val1) = each($boardcache[$boardid])) {
		while (list($key2, $boards) = each($val1)) {
			$out .= "<option value=\"".$boards['boardid']."\"".(($selected == 1 && $boards['boardid'] == $selboardid) ? (" selected=\"selected\"") : ("")).((($selected == 0 || $boards['boardid'] != $selboardid) && !checkAdminPermissions("a_can_boards_global") && !$modpermissions[$boards['boardid']]) ? (" class=\"disabled\"") : ("")).">";
			if ($depth > 1) $out .= str_repeat("--", $depth - 1)." ".$boards['title']."</option>";
			else $out .= $boards['title']."</option>";
			$out .= makeparentboardoptions($boards['boardid'], $depth + 1, $selected, $selboardid);
		} 
	} 
	unset($boardcache[$boardid]);
	return $out;
} 


/** add a new board */
if ($action == 'add') {
	// check permissions
	checkAdminPermissions('a_can_boards_add', 1);
	if (!checkAdminPermissions('a_can_boards_global') && !count($modpermissions)) access_error(1);
	
	if (isset($_POST['send'])) {
		reset($_POST);
		while (list($key, $val) = each($_POST)) $$key = $val;
		$parentid = intval($parentid);
		
		// check parentid
		if (!checkAdminPermissions('a_can_boards_global') && !$modpermissions[$parentid]) acp_error($lang->get('LANG_ACP_BOARD_PARENT_INVALID'));
		
		if ($parentid == 0) $parentlist = "0";
		else {
			$result = $db->query_first("SELECT parentlist FROM bb".$n."_boards WHERE boardid = '$parentid'");
			$parentlist = $result['parentlist'].",".$parentid;
		}
		
		$prefix = preg_replace("/\s*\n\s*/", "\n", wbb_trim($prefix));
		switch ($sortfield) {
			case "prefix": break;
			case "topic": break;
			case "starttime": break;
			case "replycount": break;
			case "starter": break;
			case "views": break;
			case "vote": break;
			case "lastposttime": break;
			case "lastposter": break;
			default: $sortfield = '';	
		}
		switch ($sortorder) {
			case "ASC": break;
			case "DESC": break;
			default: $sortorder = '';
		}
		$threadtemplate = wbb_trim($threadtemplate);
		$posttemplate = wbb_trim($posttemplate);
		if (wbb_substr($externalurl, 0, 7) != 'http://' && wbb_substr($externalurl, 0, 8) != 'https://' && wbb_substr($externalurl, 0, 6) != 'ftp://') $externalurl = 'http://'.$externalurl;
		if ($externalurl == 'http://') $externalurl = '';
		
		list($boardCount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_boards");
		list($boardorder) = $db->query_first("SELECT MAX(boardorder) FROM bb".$n."_boards WHERE parentid = '$parentid'");
		$boardorder += 1;
		
		$db->query("INSERT INTO bb".$n."_boards (styleid,parentid,parentlist,childlist,boardorder,title,password,description,prefixuse,prefixrequired,prefix,threadtemplateuse,threadtemplate,posttemplateuse,posttemplate,allowratings,daysprune,sortfield,sortorder,threadsperpage,postsperpage,postorder,countuserposts,hotthread_reply,hotthread_view,moderatenew,enforcestyle,closed,isboard,invisible,showinarchive,externalurl,done_field) ".
        "VALUES ('".intval($style_set)."','$parentid','$parentlist','0','".intval($boardorder)."','".addslashes($title)."','".addslashes($password)."','".addslashes($description)."','".intval($prefixuse)."','".intval($prefixrequired)."','".addslashes($prefix)."','".intval($threadtemplateuse)."','".addslashes($threadtemplate)."','".intval($posttemplateuse)."','".addslashes($posttemplate)."','".intval($allowratings)."','".intval($daysprune)."','".addslashes($sortfield)."','".addslashes($sortorder)."','".intval($threadsperpage)."','".intval($postsperpage)."','".intval($postorder)."','".intval($countuserposts)."','".intval($hotthread_reply)."','".intval($hotthread_view)."','".(($moderatenewthreads == 1) ? ("1") : ("0")).(($moderatenewposts == 1) ? ("1") : ("0"))."','".intval($enforcestyle)."','".intval($closed)."','".intval($isboard)."','".intval($invisible)."','".intval($showinarchive)."','".addslashes($externalurl)."','".intval($define_threads_done)."')");
		$insertid = $db->insert_id();
		
		// "all boards" announcements
		$insertSQL = '';
		$result = $db->query("SELECT threadid, COUNT(boardid) AS boards FROM bb".$n."_announcements GROUP BY threadid HAVING boards = '".$boardCount."'");
		while ($row = $db->fetch_array($result)) {
			if ($insertSQL != '') $insertSQL .= ',';
			$insertSQL .= "('".$insertid."', '".$row['threadid']."')";
		}
		
		if ($insertSQL != '') $db->query("INSERT INTO bb".$n."_announcements (boardid, threadid) VALUES ".$insertSQL);
		
		if ($parentlist != '0') {
			$db->query("UPDATE bb".$n."_boards SET childlist=CONCAT(childlist,',$insertid') WHERE boardid IN ($parentlist)");
			// check if this forum inherits permissions
			$cachegroupids = (array)checkforinheritance($insertid, $parentlist);
		}
		else $cachegroupids = array();
		
		// insert the same moderators & permissions of the parent board if the creator is only mod
		if (!checkAdminPermissions('a_can_boards_global') && $parentid != 0) {
			$result = $db->query("SELECT * FROM bb".$n."_moderators WHERE boardid='$parentid'");
			$value_str = '';
			$fieldlist = '';
			while ($row = $db->fetch_array($result)) {
				$fieldlist = '';
				$valuelist = '';
				reset($row);
				while (list($key, $val) = each($row)) {
					if (strval(intval($key)) != $key && $key != "boardid") {
						$fieldlist .= ",".$key;
						$valuelist .= ",'".addslashes($val)."'";
					}
				}
				
				if ($value_str) $value_str .= ",('".$insertid."'".$valuelist.")";
				else $value_str = "('".$insertid."'".$valuelist.")";
			}
			if ($fieldlist && $value_str) $db->unbuffered_query("INSERT INTO bb".$n."_moderators (boardid$fieldlist) VALUES $value_str");
			
			
			
			$result = $db->query("SELECT * FROM bb".$n."_permissions WHERE boardid='$parentid'");
			$fieldlist = '';
			$value_str = '';
			while ($row = $db->fetch_array($result)) {
				$cachegroupids[] = $row['groupid'];
				$fieldlist = '';
				$valuelist = '';
				reset($row);
				while (list($key, $val) = each($row)) {
					if (strval(intval($key)) != $key && $key != "boardid") {
						$fieldlist .= ",".$key;
						$valuelist .= ",'".addslashes($val)."'";
					}
				}
				
				if ($value_str) $value_str .= ",('".$insertid."'".$valuelist.")";
				else $value_str = "('".$insertid."'".$valuelist.")";
			}
			if ($fieldlist && $value_str) $db->unbuffered_query("INSERT INTO bb".$n."_permissions (boardid$fieldlist) VALUES $value_str");
		}
		
		if (count($cachegroupids)) {
			unset($boardcache);
			$where = '';
			foreach ($cachegroupids as $cachegroupid) $where .= (($where != '') ? (" OR ") : (""))."CONCAT(',',groupids,',') LIKE '%,$cachegroupid,%'";
			$result = $db->query("SELECT groupids, data FROM bb".$n."_groupcombinations WHERE $where GROUP BY groupids");
			while ($row = $db->fetch_array($result)) cachegroupcombinationdata($row['groupids'], 1, 2, unserialize($row['data']));
		}
		
		header("Location: board.php?action=view&sid=$session[hash]");
		exit();
	}
	
	$result = $db->query("SELECT boardid, parentid, boardorder, title FROM bb".$n."_boards ORDER by parentid ASC, boardorder ASC");
	while ($row = $db->fetch_array($result)) {
		$row['title'] = getlangvar($row['title'], $lang);
		$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
	}
	if (count($boardcache)) {
		reset($boardcache);
		$parentid_options = makeparentboardoptions(0);
	}
	else $parentid_options = '';
	
	$style_options = "";
	$result = $db->query("SELECT styleid, stylename FROM bb".$n."_styles ORDER BY stylename ASC");
	while ($row = $db->fetch_array($result)) $style_options .= makeoption($row['styleid'], getlangvar($row['stylename'], $lang), 0);
	
	eval("\$tpl->output(\"".$tpl->get("board_add", 1)."\",1);");	
}























/** edit an existing board */
if ($action == 'edit') {
	
	// check permissions
	checkAdminPermissions('a_can_boards_edit', 1);
	
	$boardid = intval($_REQUEST['boardid']);
	if (!checkAdminPermissions('a_can_boards_global') && !$modpermissions[$boardid]) access_error(1);
	
	$board = $db->query_first("SELECT * FROM bb".$n."_boards WHERE boardid = '$boardid'");
	if (isset($_POST['send'])) {
		reset($_POST);
		while (list($key, $val) = each($_POST)) $$key = $val;
		
		// parentid has changed
		if ($board['parentid'] != $parentid) {
			// check parentid
			if (!checkAdminPermissions('a_can_boards_global') && !$modpermissions[$parentid]) acp_error($lang->get('LANG_ACP_BOARD_PARENT_INVALID'));
			$threadcount = $board['threadcount'];
			$postcount = $board['postcount'];
			
			// check if this forum inherits permissions "at his old position"
			$inheritedgroups = (array)checkforinheritance($boardid, $board['parentlist']);
			
			if ($parentid != 0) {
				list($parentlist) = $db->query_first("SELECT parentlist FROM bb".$n."_boards WHERE boardid='$parentid'");
				$parentlist .= ",$parentid";
				$db->query("UPDATE bb".$n."_boards SET threadcount=threadcount+$threadcount, postcount=postcount+$postcount WHERE boardid IN ($parentlist)");
				updateList($parentlist, "$boardid,$board[childlist]", "childlist");
				
				// check if this forum inherits permissions "at his new position"
				unset($boardcache);
				$newinheritedgroups = (array)checkforinheritance($boardid, $parentlist, $parentid);
				$inheritedgroups = array_unique(array_merge($inheritedgroups, $newinheritedgroups));
			}
			else $parentlist = 0;
			$parentchange = " parentid='$parentid', parentlist='$parentlist',";
			
			// update groupcombinations for those groups which inherited permissions from the old or new parent board
			if (count($inheritedgroups)) {
				unset($boardcache);
				$where = '';
				foreach ($inheritedgroups as $groupid) $where .= (($where != '') ? (" OR ") : (""))."CONCAT(',',groupids,',') LIKE ',$groupid,'";
				$result = $db->query("SELECT groupids, data FROM bb".$n."_groupcombinations WHERE $where");
				while ($row = $db->fetch_array($result)) {
					cachegroupcombinationdata($row['groupids'], 1, 2, unserialize($row['data']));
				}
			}
			
			
			if ($board['parentlist'] != "0") {  
				$db->query("UPDATE bb".$n."_boards SET threadcount=threadcount-$threadcount, postcount=postcount-$postcount WHERE boardid IN ($board[parentlist])");
				updateList($board['parentlist'], "$boardid,$board[childlist]", "childlist", true);
				
				updateBoardInfo("$board[parentlist]", $board['lastposttime']);
			}
			
			if ($parentlist != "0") updateBoardInfo("$parentlist", $board['lastposttime']);
		}
		if ($board['countuserposts'] != $countuserposts) {
			$result = $db->query("SELECT COUNT(p.postid) AS posts, p.userid FROM bb".$n."_posts p, bb".$n."_threads t WHERE t.threadid=p.threadid AND t.boardid='$boardid' AND p.visible=1 AND p.userid>0 GROUP BY p.userid");
			if ($countuserposts == 1) while ($row = $db->fetch_array($result)) $db->query("UPDATE bb".$n."_users SET userposts=userposts+'$row[posts]' WHERE userid='$row[userid]'");
			else while ($row = $db->fetch_array($result)) $db->query("UPDATE bb".$n."_users SET userposts=userposts-'$row[posts]' WHERE userid='$row[userid]'");
		}
		
		if ($board['parentid'] != $parentid && $board['childlist'] != "0" && $board['childlist'] != '') {
			updateList($board['childlist'], "$board[parentlist],$boardid", "parentlist", true);
			updateList($board['childlist'], "$parentlist,$boardid", "parentlist");
		}
		
		$prefix = preg_replace("/\s*\n\s*/", "\n", wbb_trim($prefix));
		switch ($sortfield) {
			case "prefix": break;
			case "topic": break;
			case "starttime": break;
			case "replycount": break;
			case "starter": break;
			case "views": break;
			case "vote": break;
			case "lastposttime": break;
			case "lastposter": break;
			default: $sortfield = '';	
		}
		switch ($sortorder) {
			case "ASC": break;
			case "DESC": break;
			default: $sortorder = '';
		}
		if (wbb_substr($externalurl, 0, 7) != 'http://' && wbb_substr($externalurl, 0, 8) != 'https://' && wbb_substr($externalurl, 0, 6) != 'ftp://') $externalurl = 'http://'.$externalurl;
		if ($externalurl == 'http://') $externalurl = '';
		$threadtemplate = wbb_trim($threadtemplate);
		$posttemplate = wbb_trim($posttemplate);
		
		$db->query("UPDATE bb".$n."_boards SET ".
        "styleid='$style_set',$parentchange title='".addslashes($title)."', password='".addslashes($password)."', description='".addslashes($description)."', allowratings='".intval($allowratings)."', daysprune='".intval($daysprune)."', sortfield='".addslashes($sortfield)."', sortorder='".addslashes($sortorder)."', prefixuse='".intval($prefixuse)."', prefixrequired='".intval($prefixrequired)."', prefix='".addslashes($prefix)."', threadtemplateuse='".intval($threadtemplateuse)."', threadtemplate='".addslashes($threadtemplate)."', posttemplateuse='".intval($posttemplateuse)."', posttemplate='".addslashes($posttemplate)."', ".
        "threadsperpage='".intval($threadsperpage)."', postsperpage='".intval($postsperpage)."', postorder='".intval($postorder)."', countuserposts='".intval($countuserposts)."', hotthread_reply='".intval($hotthread_reply)."', hotthread_view='".intval($hotthread_view)."', moderatenew='".(($moderatenewthreads == 1) ? ("1") : ("0")).(($moderatenewposts == 1) ? ("1") : ("0"))."', enforcestyle='".intval($enforcestyle)."', closed='".intval($closed)."', isboard='".intval($isboard)."', invisible='".intval($invisible)."', showinarchive='".intval($showinarchive)."', externalurl='".addslashes($externalurl)."', done_field='".intval($define_threads_done)."' ".
        "WHERE boardid='$boardid'");
		
		header("Location: board.php?action=view&sid=$session[hash]");
		exit(); 
	} 
	
	$sel_isboard[$board['isboard']] = " selected=\"selected\"";
	$sel_closed[$board['closed']] = " selected=\"selected\"";
	$sel_invisible[$board['invisible']] = " selected=\"selected\"";
	$sel_showinarchive[$board['showinarchive']] = " selected=\"selected\"";
	$sel_allowbbcode[$board['allowbbcode']] = " selected=\"selected\"";
	$sel_allowimages[$board['allowimages']] = " selected=\"selected\"";
	$sel_allowhtml[$board['allowhtml']] = " selected=\"selected\"";
	$sel_allowsmilies[$board['allowsmilies']] = " selected=\"selected\"";
	$sel_allowicons[$board['allowicons']] = " selected=\"selected\"";
	$sel_daysprune[$board['daysprune']] = " selected=\"selected\"";
	$sel_postorder[$board['postorder']] = " selected=\"selected\"";
	$sel_countuserposts[$board['countuserposts']] = " selected=\"selected\"";
	$sel_moderatenewthreads[(($board['moderatenew'] == 10 || $board['moderatenew'] == 11) ? (1) : (0))] = " selected=\"selected\"";
	$sel_moderatenewposts[(($board['moderatenew'] == 11 || $board['moderatenew'] == 1) ? (1) : (0))] = " selected=\"selected\"";
	$sel_enforcestyle[$board['enforcestyle']] = " selected=\"selected\"";
	$sel_allowratings[$board['allowratings']] = " selected=\"selected\"";
	$sel_prefixuse[$board['prefixuse']] = " selected=\"selected\"";
	$sel_prefixrequired[$board['prefixrequired']] = " selected=\"selected\"";
	$sel_threadtemplateuse[$board['threadtemplateuse']] = " selected=\"selected\"";
	$sel_posttemplateuse[$board['posttemplateuse']] = " selected=\"selected\"";
	$sel_define_threads_done[(($board['done_field'] == 11 || $board['done_field'] == 1) ? (1) : (0))] = " selected=\"selected\"";
	
	$sel_sortfield[$board['sortfield']] = " selected=\"selected\"";
	$sel_sortorder[$board['sortorder']] = " selected=\"selected\"";
	
	
	$boardcache = array();
	$result = $db->query("SELECT boardid, parentid, boardorder, title FROM bb".$n."_boards WHERE boardid <> '$boardid' ORDER by parentid ASC, boardorder ASC");
	while ($row = $db->fetch_array($result)) {
		$row['title'] = getlangvar($row['title'], $lang);
		$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;	
	}
	
	if (count($boardcache)) {
		reset($boardcache);
		$parentid_options = makeparentboardoptions(0, 1, 1, $board['parentid']);
	}
	else $parentid_options = '';
	
	$style_options = "";
	$result = $db->query("SELECT styleid, stylename FROM bb".$n."_styles ORDER BY stylename ASC");
	while ($row = $db->fetch_array($result)) $style_options .= makeoption($row['styleid'], getlangvar($row['stylename'], $lang), $board['styleid'], 1);
	
	$board['title'] = htmlconverter($board['title']);
	$board['description'] = htmlconverter($board['description']); 
	$board['prefix'] = htmlconverter($board['prefix']);
	$board['threadtemplate'] = htmlconverter($board['threadtemplate']);
	$board['posttemplate'] = htmlconverter($board['posttemplate']);
	$board['password'] = htmlconverter($board['password']); 
	$board['externalurl'] = htmlconverter($board['externalurl']);
	
	eval("\$tpl->output(\"".$tpl->get("board_edit", 1)."\",1);");
}






















/** 
* empty an existing board
*
* @param integer boardid
*
* @return void
*/
function emptyboard($boardid) {
	global $board, $db, $n, $wbbuserdata;	
	
	/* countuserposts */
	if ($board['countuserposts'] == 1) {
		$result = $db->query("SELECT COUNT(p.postid) AS posts, p.userid FROM bb".$n."_posts p, bb".$n."_threads t WHERE p.threadid=t.threadid AND t.boardid='$boardid' AND p.visible = 1 AND p.userid>0 GROUP BY p.userid");
		while ($row = $db->fetch_array($result)) $db->unbuffered_query("UPDATE bb".$n."_users SET userposts=userposts-'$row[posts]' WHERE userid='$row[userid]'", 1);	
	}
	
	/* get threadids */
	$threadids = '';
	$result = $db->query("SELECT threadid FROM bb".$n."_threads WHERE boardid='$boardid'");
	while ($row = $db->fetch_array($result)) $threadids .= ",".$row['threadid'];
	
	/* delete attachments */
	$postids = '';
	$result = $db->query("SELECT postid FROM bb".$n."_posts WHERE threadid IN (0$threadids) AND attachments>0");
	while ($row = $db->fetch_array($result)) $postids .= (($postids != '') ? (',') : ('')) . $row['postid'];
	if ($postids != '') {
		$result = $db->query("SELECT attachmentid, attachmentextension, thumbnailextension FROM bb".$n."_attachments WHERE postid IN ($postids)");
		while ($row = $db->fetch_array($result)) {
			@unlink("./../attachments/attachment-".$row['attachmentid'].".".$row['attachmentextension']);
			@unlink("./../attachments/thumbnail-".$row['attachmentid'].".".$row['thumbnailextension']);
		}
		$db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE postid IN ($postids)", 1);
	}
	
	/* delete posts & threads */	
	$db->unbuffered_query("DELETE FROM bb".$n."_posts WHERE threadid IN (0$threadids)", 1);	
	$db->unbuffered_query("DELETE FROM bb".$n."_postcache WHERE threadid IN (0$threadids)", 1);
	$db->unbuffered_query("DELETE FROM bb".$n."_threads WHERE pollid IN (0$threadids) AND closed=3", 1);	
	$db->unbuffered_query("DELETE FROM bb".$n."_announcements WHERE threadid IN (0$threadids) OR boardid='$boardid'", 1);
	$db->unbuffered_query("DELETE FROM bb".$n."_threads WHERE boardid='$boardid'", 1);	
	
	/* delete poll(options|votes) */
	$pollids = '';
	$result = $db->query("SELECT pollid FROM bb".$n."_polls WHERE threadid IN (0$threadids)");
	while ($row = $db->fetch_array($result)) $pollids .= ",".$row['pollid'];
	$db->unbuffered_query("DELETE FROM bb".$n."_polloptions WHERE pollid IN (0$pollids)", 1);	
	$db->unbuffered_query("DELETE FROM bb".$n."_votes WHERE id IN (0$pollids) AND votemode=1", 1);
	$db->unbuffered_query("DELETE FROM bb".$n."_polls WHERE pollid IN (0$pollids)", 1);
	
	/* update parent boards */ 
	if ($board['parentid'] != 0) {
		$db->unbuffered_query("UPDATE bb".$n."_boards SET threadcount=threadcount-'$board[threadcount]', postcount=postcount-'$board[postcount]' WHERE boardid IN ($board[parentlist])", 1);
		updateBoardInfo("$board[parentlist]", 0, $board['lastthreadid']);
	}
	
	/* update globals stats */
	$db->unbuffered_query("UPDATE bb".$n."_stats SET threadcount=threadcount-'".$board['threadcount']."', postcount=postcount-'".$board['postcount']."'", 1);
}



/** empty a board **/
if ($action == 'empty') {
	
	// check permissions
	checkAdminPermissions('a_can_boards_empty', 1);
	
	$boardid = intval($_REQUEST['boardid']);
	if (!checkAdminPermissions('a_can_boards_global') && !$modpermissions[$boardid]) access_error(1);
	
	$board = $db->query_first("SELECT * FROM bb".$n."_boards WHERE boardid = '$boardid'");
	
	if (isset($_POST['send'])) {
		emptyboard($boardid);	
		$db->unbuffered_query("UPDATE bb".$n."_boards SET threadcount=0, postcount=0, lastthreadid=0, lastposttime=0, lastposterid=0, lastposter='' WHERE boardid = '$boardid'", 1);	
		
		header("Location: board.php?action=view&sid=$session[hash]");
		exit(); 	
	}	
	
	$board['title'] = getlangvar($board['title'], $lang);
	$lang->items['LANG_ACP_BOARD_EMPTY'] = $lang->get("LANG_ACP_BOARD_EMPTY", array('$title' => $board['title']));
	eval("\$tpl->output(\"".$tpl->get("board_empty", 1)."\",1);");
}

































/** delete an existing board */
if ($action == 'del') {
	
	// check permissions
	checkAdminPermissions('a_can_boards_del', 1);
	
	$boardid = intval($_REQUEST['boardid']);
	if (!checkAdminPermissions('a_can_boards_global') && !$modpermissions[$boardid]) access_error(1);
	
	$board = $db->query_first("SELECT * FROM bb".$n."_boards WHERE boardid = '$boardid'");
	
	if (isset($_POST['send'])) {
		emptyboard($boardid);	
		
		$cachegroupids = (array)checkforinheritance($boardid, $board['parentlist']);
		
		$db->unbuffered_query("DELETE FROM bb".$n."_boards WHERE boardid = '$boardid'", 1);
		$db->unbuffered_query("DELETE FROM bb".$n."_access WHERE boardid = '$boardid'", 1);
		$db->unbuffered_query("DELETE FROM bb".$n."_moderators WHERE boardid = '$boardid'", 1);
		$db->unbuffered_query("DELETE FROM bb".$n."_permissions WHERE boardid = '$boardid'", 1);
		$db->unbuffered_query("DELETE FROM bb".$n."_subscribeboards WHERE boardid = '$boardid'", 1);
		
		if ($board['parentid'] != 0) $db->unbuffered_query("UPDATE bb".$n."_boards SET childlist = SUBSTRING(REPLACE(CONCAT(',',childlist,','),',$boardid,',','),2,LENGTH(REPLACE(CONCAT(',',childlist,','),',$boardid,',','))-2) WHERE boardid IN ($board[parentlist])", 1);
		if ($board['childlist'] != "0") {
			$db->unbuffered_query("UPDATE bb".$n."_boards SET parentlist = SUBSTRING(REPLACE(CONCAT(',',parentlist,','),',$boardid,',','),2,LENGTH(REPLACE(CONCAT(',',parentlist,','),',$boardid,',','))-2) WHERE boardid IN ($board[childlist])", 1);
			$db->unbuffered_query("UPDATE bb".$n."_boards SET parentid='$board[parentid]' WHERE parentid = '$boardid'", 1);
			
			$result = $db->query("SELECT DISTINCT groupid FROM bb".$n."_permissions WHERE boardid IN($board[childlist])");
			while ($row = $db->fetch_array($result)) $cachegroupids[] = $row['groupid'];
			$cachegroupids = array_unique($cachegroupids);
		}
		
		if (count($cachegroupids)) {
			unset($boardcache);
			$where = '';
			foreach ($cachegroupids as $cachegroupid) $where .= (($where != '') ? (" OR ") : (""))."CONCAT(',',groupids,',') LIKE '%,$cachegroupid,%'";
			$result = $db->query("SELECT groupids, data FROM bb".$n."_groupcombinations WHERE $where GROUP BY groupids");
			while ($row = $db->fetch_array($result)) cachegroupcombinationdata($row['groupids'], 1, 2, unserialize($row['data']));
		}
		
		
		header("Location: board.php?action=view&sid=$session[hash]");
		exit(); 	
	}
	
	$board['title'] = getlangvar($board['title'], $lang);
	$lang->items['LANG_ACP_BOARD_DEL'] = $lang->get("LANG_ACP_BOARD_DEL", array('$title' => $board['title']));
	eval("\$tpl->output(\"".$tpl->get("board_del", 1)."\",1);");
}










































/* view user access */
if ($action == 'rights') {
	$boardid = intval($_REQUEST['boardid']);
	$board = $db->query_first("SELECT title FROM bb".$n."_boards WHERE boardid = '$boardid'");
	
	checkAdminPermissions("a_can_boards_rights", 1);
	if (!checkAdminPermissions("a_can_boards_global") && !$modpermissions[$boardid]) access_error(1);
	
	$userbit = '';
	$result = $db->query("SELECT a.*, u.username FROM bb".$n."_access a LEFT JOIN bb".$n."_users u USING (userid) WHERE boardid = '$boardid' ORDER BY u.username ASC");
	while ($row = $db->fetch_array($result)) {
		$row['username'] = htmlconverter($row['username']);
		eval("\$userbit .= \"".$tpl->get("board_rights_userbit", 1)."\";");	
	}
	
	$board['title'] = getlangvar($board['title'], $lang);
	
	$lang->items['LANG_ACP_BOARD_RIGHTS_TITLE'] = $lang->get("LANG_ACP_BOARD_RIGHTS_TITLE", array('$title' => $board['title']));
	$lang->items['LANG_ACP_BOARD_RIGHTS_DESC'] = $lang->get("LANG_ACP_BOARD_RIGHTS_DESC", array('$title' => $board['title']));
	eval("\$tpl->output(\"".$tpl->get("board_rights", 1)."\",1);");
}













/* set permissions */
if ($action == 'permissions') {
	// check permissions
	checkAdminPermissions('a_can_boards_permissions', 1);
	
	$boardid = intval($_REQUEST['boardid']);
	if (!checkAdminPermissions('a_can_boards_global') && !$modpermissions[$boardid]) access_error(1);
	$board = $db->query_first("SELECT title FROM bb".$n."_boards WHERE boardid = '$boardid'");

	if (isset($_REQUEST['groupid'])) $groupid = intval($_REQUEST['groupid']);
	else $groupid = 0;

	if ($groupid != 0) {
		$group = $db->query_first("SELECT securitylevel FROM bb".$n."_groups WHERE groupid='$groupid'");	
		checkSecurityLevel($group['securitylevel'], 1);
	}

	if (isset($_POST['send']) && $groupid != 0) {
		$db->unbuffered_query("DELETE FROM bb".$n."_permissions WHERE boardid=$boardid AND groupid=$groupid", 1);
		
		$fields = '';
		$values = '';
		$default_count = 0;
		$count = 0;
			
		reset($_POST['permission']);
		while (list($key, $val) = each($_POST['permission'])) {
	 		$fields .= ",$key";
	 		$values .= ",'$val'";
	 			
	 		if ($val == -1) $default_count++;
	 		$count++;
	 	}
		if ($default_count != $count) $db->unbuffered_query("REPLACE INTO bb".$n."_permissions (boardid,groupid".$fields.") VALUES ('$boardid','$groupid'".$values.")", 1);
		
		$result = $db->query("SELECT groupids, data FROM bb".$n."_groupcombinations WHERE CONCAT(',',groupids,',') LIKE '%,$groupid,%'");
		while ($row = $db->fetch_array($result)) {
			cachegroupcombinationdata($row['groupids'], 1, 2, unserialize($row['data']));
		}
	}
	
	$groups_options = '';
	$result = $db->query("SELECT g.groupid, g.title".($boardid ? ", p.boardid" : "")." FROM bb".$n."_groups g".($boardid ? " LEFT JOIN bb".$n."_permissions p ON (p.groupid=g.groupid AND p.boardid=$boardid)" : "")." ORDER BY g.title ASC");
	while ($row = $db->fetch_array($result)) $group_options .= makeoption($row['groupid'], getlangvar($row['title'], $lang), $groupid, 1, ($row['boardid'] ? 'red' : ''));

	
	$permissionbit = '';
	$default_count = 0;
	$count = 0;
	if ($groupid != 0) {
		$lang->load("ACP_GROUP");
		
		$permissions = $db->query_first("SELECT * FROM bb".$n."_permissions WHERE boardid='$boardid' AND groupid='$groupid'");
		
		$result = $db->query("SHOW FIELDS FROM bb".$n."_permissions");
		while ($row = $db->fetch_array($result)) {
			$selected = array();
			if ($row['Field'] == "groupid" || $row['Field'] == "boardid") continue;
			if (!isset($permissions[$row['Field']]) || $permissions[$row['Field']] == -1) {
				$permissions[$row['Field']] = 2;
				$default_count++;
			}
			$selected[$permissions[$row['Field']]] = "selected=\"selected\"";
			$rowclass = getone($count, "firstrow", "secondrow");
			
			$row['title'] = $lang->get("LANG_ACP_GROUP_VAR_" . wbb_strtoupper($row['Field']));
			
			eval("\$permissionbit .= \"".$tpl->get("board_permissions_permissionbit", 1)."\";");
			$count++;
		}
	}

 	$board['title'] = getlangvar($board['title'], $lang);
 	$lang->items['LANG_ACP_BOARD_PERMISSIONS_TITLE'] = $lang->get("LANG_ACP_BOARD_PERMISSIONS_TITLE", array('$title' => $board['title']));
	eval("\$tpl->output(\"".$tpl->get("board_permissions", 1)."\",1);");
}






/** sync boards */
if ($action == 'sync') {
	checkAdminPermissions('a_can_boards_edit', 1);
	
	$result = $db->query("SELECT boardid, parentid FROM bb".$n."_boards ORDER by parentid ASC");
	while ($row = $db->fetch_array($result)) $boardcache[$row['parentid']][$row['boardid']] = $row;	
	
	/**
	* sync boards
	*
	* @param integer parentid
	* @param integer parentlist
	*
	* @return string childlist
	*/
	function syncBoards($parentid, $parentlist = '0') {
		global $boardcache, $db, $n;
		
		if (!isset($boardcache[$parentid])) {
			if ($parentid != 0) $db->query("UPDATE bb".$n."_boards SET childlist='0' WHERE boardid='$parentid'");
			return;
		}
		
		$childlist = '';
		$updatelist = '';
		while (list($boardid, $board) = each($boardcache[$parentid])) {
			$childlist .= ",$boardid";
			$childlist .= syncBoards($boardid, $parentlist.",$boardid");
			
			$updatelist .= ",$boardid";
		}	
		
		$db->query("UPDATE bb".$n."_boards SET parentlist='$parentlist' WHERE boardid IN (0$updatelist)");		
		if ($parentid != 0) $db->query("UPDATE bb".$n."_boards SET childlist='0$childlist' WHERE boardid='$parentid'");	
		
		return $childlist;	
	}	
	
	syncBoards(0);	
	
	header("Location: board.php?action=view&sid=$session[hash]");
	exit(); 	
}






/** add moderator **/
if ($action == 'addmoderator') {
	checkAdminPermissions('a_can_moderator_add', 1);
	
	$lang->load('ACP_GROUP');
	
	if (isset($_REQUEST['boardid'])) $boardid = intval($_REQUEST['boardid']);
	else $boardid = 0;
	
	if (!checkAdminPermissions('a_can_boards_global') && !$modpermissions[$boardid]) access_error(1);
	$board = $db->query_first("SELECT title FROM bb".$n."_boards WHERE boardid = '$boardid'");
	
	if (isset($_POST['send'])) {
		list($moderatorid) = $db->query_first("SELECT userid FROM bb".$n."_users WHERE username = '".addslashes(wbb_trim($_REQUEST['moderatorname']))."'");
		if (!$moderatorid) acp_error($lang->get("LANG_ACP_BOARD_MODERATOR_ADD_ERROR"));
		else {
			$fields = ''; $values = '';
			reset($_POST['rights']);
			while (list($key, $val) = each($_POST['rights'])) {
				$fields .= ",$key";
				$values .= ",'".intval($val)."'";
			}
			$db->query("REPLACE INTO bb".$n."_moderators (userid,boardid,notify_newpost,notify_newthread".$fields.") VALUES ('".$moderatorid."','".$boardid."','".intval($_REQUEST['notify_newpost'])."','".intval($_REQUEST['notify_newthread'])."'".$values.")");
		}
		
		header("Location: board.php?action=viewmoderator&boardid=$boardid&sid=$session[hash]");
		exit;
	}
	
	$count = 0;
	$rightbit = '';
	$result = $db->query("SHOW FIELDS FROM bb".$n."_moderators");
	while ($row = $db->fetch_array($result)) {
		if ($row['Field'] == "userid" || $row['Field'] == "boardid" || $row['Field'] == "notify_newpost" || $row['Field'] == "notify_newthread") continue;
		
		$rowclass = getone($count, "firstrow", "secondrow");
		
		$title = $lang->get("LANG_ACP_GROUP_VAR_" . wbb_strtoupper($row['Field']));
		
		eval("\$rightbit .= \"".$tpl->get("board_moderator_rightbit", 1)."\";");
		$count++;
	}	
	
	$board['title'] = getlangvar($board['title'], $lang);
	$lang->items['LANG_ACP_BOARD_MODERATOR_ADD_TITLE'] = $lang->get("LANG_ACP_BOARD_MODERATOR_ADD_TITLE", array('$title' => $board['title']));
	eval("\$tpl->output(\"".$tpl->get("board_moderator_add", 1)."\",1);");
}





/** view moderators **/
if ($action == 'viewmoderator') {
	if (!checkAdminPermissions('a_can_moderator_edit') || !checkAdminPermissions('a_can_moderator_del')) access_error(1);
	
	if (isset($_REQUEST['boardid'])) $boardid = intval($_REQUEST['boardid']);
	else $boardid = 0;
	
	if (!checkAdminPermissions('a_can_boards_global') && !$modpermissions[$boardid]) access_error(1);
	$board = $db->query_first("SELECT title FROM bb".$n."_boards WHERE boardid = '$boardid'");
	
	$count = 0;
	$moderatorbit = '';
	$result = $db->unbuffered_query("SELECT u.username, m.userid FROM bb".$n."_moderators m LEFT JOIN bb".$n."_users u USING(userid) WHERE boardid = '".$boardid."'");
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count, "firstrow", "secondrow");
		$row['username'] = htmlconverter($row['username']);	
		eval("\$moderatorbit .= \"".$tpl->get("board_moderator_view_moderatorbit", 1)."\";");	
		$count++;
	}
	
	$board['title'] = getlangvar($board['title'], $lang);
	$lang->items['LANG_ACP_BOARD_MODERATOR_EDIT_TITLE'] = $lang->get("LANG_ACP_BOARD_MODERATOR_EDIT_TITLE", array('$title' => $board['title']));
	eval("\$tpl->output(\"".$tpl->get("board_moderator_view", 1)."\",1);");	
}




/** edit moderator **/
if ($action == 'editmoderator') {
	checkAdminPermissions('a_can_moderator_edit', 1);
	
	$lang->load("ACP_GROUP");
	
	if (isset($_REQUEST['boardid'])) $boardid = intval($_REQUEST['boardid']);
	else $boardid = 0;
	
	if (isset($_GET['userid'])) $userid = intval($_GET['userid']);
	elseif (isset($_POST['userid'])) $userid = intval($_POST['userid']);
	else $userid = 0;
	
	if (!checkAdminPermissions('a_can_boards_global') && !$modpermissions[$boardid]) access_error(1);
	
	if (isset($_POST['send'])) {
		$fields = ''; $values = '';
		reset($_POST['rights']);
		while (list($key, $val) = each($_POST['rights'])) {
			$fields .= ",$key";
			$values .= ",'".intval($val)."'";
		}
		$db->query("REPLACE INTO bb".$n."_moderators (userid,boardid,notify_newpost,notify_newthread".$fields.") VALUES ('".$userid."','".$boardid."','".intval($_REQUEST['notify_newpost'])."','".intval($_REQUEST['notify_newthread'])."'".$values.")");
		
		header("Location: board.php?action=viewmoderator&boardid=$boardid&sid=$session[hash]");
		exit;
	}
	$board = $db->query_first("SELECT title FROM bb".$n."_boards WHERE boardid = '$boardid'");
	
	$moderator = $db->query_first("SELECT m.*, u.username FROM bb".$n."_moderators m LEFT JOIN bb".$n."_users u USING(userid) WHERE m.boardid = '".$boardid."' AND m.userid='".$userid."'");	
	$s_notify_newpost = array("", "");
	$s_notify_newthread = array("", "");
	
	$s_notify_newpost[$moderator['notify_newpost']] = " selected=\"selected\"";
	$s_notify_newthread[$moderator['notify_newthread']] = " selected=\"selected\"";
	
	$count = 0;
	$rightbit = '';
	$result = $db->query("SHOW FIELDS FROM bb".$n."_moderators");
	while ($row = $db->fetch_array($result)) {
		if ($row['Field'] == "userid" || $row['Field'] == "boardid" || $row['Field'] == "notify_newpost" || $row['Field'] == "notify_newthread") continue;
		
		$selected = array();
		if (!isset($moderator[$row['Field']]) || $moderator[$row['Field']] == -1) $moderator[$row['Field']] = 2;
		$selected[$moderator[$row['Field']]] = "selected=\"selected\"";
		
		$rowclass = getone($count, "firstrow", "secondrow");
		$title = $lang->get("LANG_ACP_GROUP_VAR_" . wbb_strtoupper($row['Field']));
		eval("\$rightbit .= \"".$tpl->get("board_moderator_rightbit", 1)."\";");
		$count++;
	}
	
	
	$board['title'] = getlangvar($board['title'], $lang);
	$lang->items['LANG_ACP_BOARD_MODERATOR_EDIT_TITLE'] = $lang->get("LANG_ACP_BOARD_MODERATOR_EDIT_TITLE", array('$title' => $board['title']));
	eval("\$tpl->output(\"".$tpl->get("board_moderator_edit", 1)."\",1);");		
}



/** delete moderator **/
if ($action == 'delmoderator') {
	checkAdminPermissions('a_can_moderator_del', 1);
	
	if (isset($_REQUEST['boardid'])) $boardid = intval($_REQUEST['boardid']);
	else $boardid = 0;
	
	if (isset($_GET['userid'])) $userid = intval($_GET['userid']);
	elseif (isset($_POST['userid'])) $userid = intval($_POST['userid']);
	else $userid = 0;
	
	if (!checkAdminPermissions('a_can_boards_global') && !$modpermissions[$boardid]) access_error(1);
	
	if (isset($_POST['send'])) {
		$db->unbuffered_query("DELETE FROM bb".$n."_moderators WHERE userid='".$userid."' AND boardid = '".$boardid."'", 1);	
		
		header("Location: board.php?action=viewmoderator&boardid=$boardid&sid=$session[hash]");
		exit;	
	}
	
	$moderator = $db->query_first("SELECT m.*, u.username, b.title FROM bb".$n."_moderators m LEFT JOIN bb".$n."_users u USING(userid) LEFT JOIN bb".$n."_boards b ON(m.boardid=b.boardid) WHERE m.boardid = '".$boardid."' AND m.userid='".$userid."'");	
	
	$moderator['title'] = getlangvar($moderator['title'], $lang);
	$moderator['username'] = htmlconverter($moderator['username']);
	$lang->items['LANG_ACP_BOARD_MODERATOR_DEL_TITLE'] = $lang->get("LANG_ACP_BOARD_MODERATOR_DEL_TITLE", array('$username' => $moderator['username'], '$title' => $moderator['title']));
	eval("\$tpl->output(\"".$tpl->get("board_moderator_del", 1)."\",1);");		
}


/** find moderator **/
if ($action == 'findmoderator') {
	checkAdminPermissions('a_can_moderator_add', 1);
	$lang->load('ACP_GROUP');
	
	$options = '';
	if (isset($_POST['send'])) {
		$result = $db->unbuffered_query("SELECT userid,username FROM bb".$n."_users WHERE username LIKE '%".addslashes(wbb_trim($_POST['username']))."%'");
		while ($row = $db->fetch_array($result)) {
			$row['username'] = htmlconverter($row['username']);
			$options .= makeoption($row['userid'], $row['username']);	
		}
	}
	eval("\$tpl->output(\"".$tpl->get("board_moderator_find", 1)."\",1);");	
}
?>

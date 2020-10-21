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
// * $Date: 2004-10-20 20:57:36 +0200 (Wed, 20 Oct 2004) $
// * $Author: Burntime $
// * $Rev: 1455 $
// ************************************************************************************//


require('./global.php');
require('./lib/mod_functions.php');
@set_time_limit(0);
$lang->load('ACP_THREADS');

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = 'spinning';


/** threads: mass prune / move / unsubscribe **/
if ($action == 'threads_mass_edit') {
	checkAdminPermissions('a_can_threads_mass_edit', 1);
	
	if (isset($_POST['send'])) {
		$where = '';
		
		// prefix is
		if (isset($_POST['prefix']) && $_POST['prefix']!="") add2where("prefix = '".addslashes($_POST['prefix'])."'");
		
		// first post older than x days
		if (isset($_POST['starttime']) && $_POST['starttime'] != '') add2where("starttime < '".(time() - intval($_POST['starttime']) * 86400)."'");
		
		// last post older than x days
		if (isset($_POST['lastposttime']) && $_POST['lastposttime'] != '') add2where("lastposttime < '".(time() - intval($_POST['lastposttime']) * 86400)."'");
		
		// replies more than x
		if (isset($_POST['replies_morethan']) && $_POST['replies_morethan'] != '') add2where("replycount > '".intval($_POST['replies_morethan'])."'");
		
		// replies less than x
		if (isset($_POST['replies_lessthan']) && $_POST['replies_lessthan'] != '') add2where("replycount < '".intval($_POST['replies_morethan'])."'");
		
		// starter is
		if (isset($_POST['starter']) && $_POST['starter'] != '') add2where("starter = '".addslashes(wbb_trim($_POST['starter']))."'");	
		
		// poster is
		if (isset($_POST['username']) && $_POST['username'] != '') {
			$threadids = "";
			$result = $db->unbuffered_query("SELECT DISTINCT threadid FROM bb".$n."_posts WHERE username='".addslashes(wbb_trim($_POST['username']))."'");
			while ($row = $db->fetch_array($result)) $threadids .= ",".$row['threadid'];
			
			if ($threadids != '') add2where("threadid IN (0".$threadids.")");	
		}
		
		// is closed?
		if (isset($_POST['closed']) && $_POST['closed'] != '') add2where("closed = '".intval($_POST['closed'])."'");
		
		// in boards
		if (isset($_POST['boardids']) && count($_POST['boardids'])) add2where("boardid IN (".implode(",", intval_array($_POST['boardids'])).")");
		
		
		if (isset($_POST['threadaction'])) $threadaction = $_POST['threadaction'];
		else $threadaction = '';
		
		$done = 0;
		if ($where != '') {
			$threadids = '';
			$result = $db->unbuffered_query("SELECT threadid FROM bb".$n."_threads WHERE ".$where." AND closed<>3");
			while ($row = $db->fetch_array($result)) $threadids .= ",".$row['threadid'];
			
			if ($threadids != '') {
				// unsubscribe users from threads
				if ($threadaction == "unsubscribe") {
					$db->unbuffered_query("DELETE FROM bb".$n."_subscribethreads WHERE threadid IN (0".$threadids.")", 1);
					$done = 1;
				}
				
				// open threads
				if ($threadaction == "open") {
					$db->unbuffered_query("UPDATE bb".$n."_threads SET closed=0 WHERE threadid IN (0".$threadids.") AND closed<>3", 1);	
					$done = 1;	
				}
				
				// close threads
				if ($threadaction == "close") {
					$db->unbuffered_query("UPDATE bb".$n."_threads SET closed=1 WHERE threadid IN (0".$threadids.") AND closed<>3", 1);	
					$done = 1;	
				}
				
				// delete threads
				if ($threadaction == "delete") {
					// update global stats
					list($threadcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_threads WHERE threadid IN (0".$threadids.")");
					list($postcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_posts WHERE threadid IN (0".$threadids.")");
					$db->unbuffered_query("UPDATE bb".$n."_stats SET threadcount=threadcount-".intval($threadcount).", postcount=postcount-".intval($postcount), 1);
					
					// delete polls
					$pollids = '';
					$result = $db->unbuffered_query("SELECT pollid FROM bb".$n."_threads WHERE threadid IN (0".$threadids.") AND pollid<>0 AND closed<>3");
					while ($row = $db->fetch_array($result)) $pollids = ",".$row['pollid'];
					
					if ($pollids != '') {
						$db->unbuffered_query("DELETE FROM bb".$n."_polls WHERE pollid IN (0".$pollids.")", 1);
						$db->unbuffered_query("DELETE FROM bb".$n."_votes WHERE id IN (0".$pollids.") AND votemode=1", 1);
						$db->unbuffered_query("DELETE FROM bb".$n."_polloptions WHERE pollid IN (0".$pollids.")", 1);	 
					}
					
					// delete attachments
					$postids = '';
					$result = $db->unbuffered_query("SELECT postid FROM bb".$n."_posts WHERE threadid IN (0".$threadids.") AND attachments>0");
					while ($row = $db->fetch_array($result)) $postids .= (($postids != '') ? (',') : ('')) . $row['postid'];
					if ($postids != '') {
						$result = $db->query("SELECT attachmentid, attachmentextension, thumbnailextension FROM bb".$n."_attachments WHERE postid IN (".$postids.")");
						while ($row = $db->fetch_array($result)) {
							@unlink("./../attachments/attachment-".$row['attachmentid'].".".$row['attachmentextension']);
							@unlink("./../attachments/thumbnail-".$row['attachmentid'].".".$row['thumbnailextension']);
						}
						$db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE postid IN (".$postids.")", 1);	
					}
					
					// delete threads
					$db->unbuffered_query("DELETE FROM bb".$n."_threads WHERE threadid IN (0".$threadids.")", 1);
					$db->unbuffered_query("DELETE FROM bb".$n."_threads WHERE pollid IN (0".$threadids.") AND closed=3", 1);
					$db->unbuffered_query("DELETE FROM bb".$n."_subscribethreads WHERE threadid IN (0".$threadids.")", 1);
					$db->unbuffered_query("DELETE FROM bb".$n."_announcements WHERE threadid IN (0".$threadids.")", 1);
					$db->unbuffered_query("DELETE FROM bb".$n."_votes WHERE id IN (0".$threadids.") AND votemode=2", 1);
					
					// delete posts
					$db->unbuffered_query("DELETE FROM bb".$n."_posts WHERE threadid IN (0".$threadids.")", 1);
					
					$done = 1;	
				}
				
				// move thread
				if ($threadaction == "move") {
					if (isset($_POST['movethread'])) $movethread = $_POST['movethread'];
					else $movethread = "";
					
					if (isset($_POST['newboardid'])) $newboardid = intval($_POST['newboardid']);
					else $newboardid = 0;
					
					if ($movethread == "onlymove" || $movethread == "movewithredirect") {
						// update announcements
						$result = $db->query("SELECT COUNT(a.threadid) AS acount, t.threadid, t.boardid FROM bb".$n."_threads t LEFT JOIN bb".$n."_announcements a USING(threadid) WHERE t.threadid IN (0".$threadids.") AND t.important=2 GROUP BY t.threadid");	
						while ($row = $db->fetch_array($result)) {
							if ($row['acount'] > 1) $db->unbuffered_query("INSERT IGNORE INTO bb".$n."_announcements (boardid,threadid) VALUES ('".$newboardid."','".$row['threadid']."')", 1);
							else $db->unbuffered_query("UPDATE bb".$n."_announcements SET boardid='".$newboardid."' WHERE threadid='".$row['threadid']."' AND boardid='".$row['boardid']."'", 1);
						}
						
						// add redirect	
						if ($movethread == "movewithredirect") {
							$result = $db->query("SELECT * FROM bb".$n."_threads WHERE threadid IN (0".$threadids.")");
							while ($row = $db->fetch_array($result)) {
								$db->unbuffered_query("INSERT INTO bb".$n."_threads (boardid,prefix,topic,iconid,starttime,starterid,starter,lastposttime,lastposterid,lastposter,replycount,views,closed,voted,votepoints,pollid,visible) VALUES "
								. "('".$row['boardid']."','".addslashes($row['prefix'])."','".addslashes($row['topic'])."','".$thread['iconid']."','".$thread['starttime']."','".$thread['starterid']."','".addslashes($thread['starter'])."','".$thread['lastposttime']."','".$thread['lastposterid']."','".addslashes($thread['lastposter'])."','".$thread['replycount']."','".$thread['views']."','3','".$thread['voted']."','".$thread['votepoints']."','".$row['threadid']."','".$thread['visible']."')", 1);
							}	
						}
						
						// update thread
						$db->unbuffered_query("UPDATE bb".$n."_threads SET boardid='".$newboardid."' WHERE threadid IN (0".$threadids.")", 1);
					}
					
					$done = 1; 
				}
			}	
		}
		
		if ($done == 0) acp_error($lang->get("LANG_ACP_THREADS_MASS_EDIT_ERROR"));
		else acp_message($lang->get("LANG_ACP_THREADS_MASS_EDIT_DONE"));
	}	
	
	$boardcache = array();	
	$result = $db->unbuffered_query("SELECT boardid, parentid, boardorder, title FROM bb".$n."_boards ORDER by parentid ASC, boardorder ASC");
	while ($row = $db->fetch_array($result)) {
		$row['title'] = getlangvar($row['title'], $lang);
		$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
	}
	
	$boardid_options = makeboardoptions(0);
	
	eval("\$tpl->output(\"".$tpl->get("threads_mass_edit", 1)."\",1);");
}


/** thread spinning **/
if ($action == "spinning") {
	checkAdminPermissions("a_can_threads_edit", 1);
	
	if (isset($_POST['send'])) {
		$boardid = intval($_POST['boardid']);
		
		// read in modpermissions
		$board = $db->query_first("SELECT *,userid as moderatorid FROM bb".$n."_moderators WHERE userid='".$wbbuserdata['userid']."' AND boardid='".$boardid."'");
		
		if (!checkmodpermissions("m_can_thread_close") && !checkmodpermissions("m_can_thread_move") && !checkmodpermissions("m_can_thread_del")) acp_error($lang->get("LANG_ACP_THREADS_EDIT_ACCESS_ERROR"));
		
		$limit = intval($_POST['limit']);
		if (!$limit) $limit = 20;
		$offset = intval($_POST['offset']);
		if ($offset < 1) $offset = 1;
		$offset -= 1;
		
		$sortby = $_REQUEST['sortby'];
		$sortorder = $_REQUEST['sortorder'];
		
		switch ($sortorder) {
			case "ASC": break;
			case "DESC": break;
			default: $sortorder = "DESC";	
		}
		
		switch ($sortby) {
			case "topic": break;
			case "starttime": break;
			case "starter": break;
			case "lastposttime": break;
			case "lastposter": break;
			case "replycount": break;
			case "views": break;
			default: $sortby = "lastposttime";	
		}
		
		$threadbit = '';
		$count = 0;
		$result = $db->query("SELECT threadid, topic, starter, starterid FROM bb".$n."_threads WHERE boardid='$boardid' ORDER BY $sortby $sortorder", $limit, $offset);
		if (!$db->num_rows($result)) acp_error($lang->get("LANG_ACP_GLOBAL_ERROR_NORESULT"));
		while ($row = $db->fetch_array($result)) {
			$rowclass = getone($count++, "firstrow", "secondrow");
			
			$row['starter'] = htmlconverter($row['starter']);
			$row['topic'] = htmlconverter($row['topic']);
			if ($row['starterid'] != 0) $row['starter'] = makehreftag("../profile.php?userid=$row[starterid]", $row['starter'], "_blank");
			
			eval("\$threadbit .= \"".$tpl->get("threads_spinbit", 1)."\";");	
		}
		
		eval("\$tpl->output(\"".$tpl->get("threads_spin", 1)."\",1);");
		exit();	
	}
	
	$lang->load("BOARD,ACP_BOARD");
	
	// read permissions
	$permissioncache = getPermissions();
	
	// read boardoptions
	$boardcache = array();	
	$result = $db->unbuffered_query("SELECT boardid, parentid, boardorder, title FROM bb".$n."_boards ORDER by parentid ASC, boardorder ASC");
	while ($row = $db->fetch_array($result)) {
		if (!isset($permissioncache[$row['boardid']]['can_view_board'])) $permissioncache[$row['boardid']]['can_view_board'] = -1;
		if ($permissioncache[$row['boardid']]['can_view_board'] == 0 || ($permissioncache[$row['boardid']]['can_view_board'] == -1 && !$wbbuserdata['can_view_board'])) continue;
		$row['title'] = getlangvar($row['title'], $lang);
		$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
	}
	
	$boardid_options = makeboardoptions(0);	
	
	eval("\$tpl->output(\"".$tpl->get("threads", 1)."\",1);");
}


/** thread spinning (verify) **/
if ($action == "verify") {
	checkAdminPermissions("a_can_threads_edit", 1);
	
	$boardid = intval($_REQUEST['boardid']);
	
	if (isset($_POST['send'])) {
		$closethread = $_POST['closethread'];
		
		// close threads
		$close_threadids = '';
		if (is_array($closethread)) {
			reset($closethread);
			while (list($key, $val) = each($closethread)) if ($val == 1) $close_threadids .= ",$key";
		}	
		if ($close_threadids) $db->unbuffered_query("UPDATE bb".$n."_threads SET closed=1-closed WHERE threadid IN (0".$close_threadids.")", 1);	
		
		// delete threads
		$delthread = $_POST['delthread'];
		$del_threadids = '';
		if (is_array($delthread)) {
			reset($delthread);
			while (list($key, $val) = each($delthread)) if ($val == 1) $del_threadids .= ",$key";
		}	
		if ($del_threadids) {
			$board = $db->query_first("SELECT * FROM bb".$n."_boards WHERE boardid='$boardid'");	
			
			// delete threads
			$result = $db->query("SELECT pollid, replycount FROM bb".$n."_threads WHERE threadid IN (0".$del_threadids.")");
			$threadcount = $db->num_rows($result); // thread count for board counter
			$pollids = '';
			$postcount = 0;
			while ($row = $db->fetch_array($result)) {
				$postcount += 1 + $row['replycount']; // post count for board counter
				if ($row['pollid']) $pollids .= ",$row[pollid]";	
			}
			$db->query("DELETE FROM bb".$n."_threads WHERE threadid IN (0".$del_threadids.")"); // delete thread
			$db->unbuffered_query("DELETE FROM bb".$n."_threads WHERE pollid IN (0".$del_threadids.") AND closed=3", 1); // delete redirect thread
			$db->unbuffered_query("DELETE FROM bb".$n."_announcements WHERE threadid IN (0".$del_threadids.")", 1); // delete announcements
			$db->unbuffered_query("DELETE FROM bb".$n."_subscribethreads WHERE threadid IN (0".$del_threadids.")", 1); // delete subscriptions
			
			// update global stats
			$db->unbuffered_query("UPDATE bb".$n."_stats SET threadcount=threadcount-".intval($threadcount).", postcount=postcount-".intval($postcount), 1);
			
			// delete polls
			if ($pollids) {
				$db->query("DELETE FROM bb".$n."_polls WHERE pollid IN (0$pollids)");
				$pollvotes = " OR (id IN (0$pollids) AND votemode=1)";
				$db->query("DELETE FROM bb".$n."_polloptions WHERE pollid IN (0$pollids)");
			}
			else $pollvotes = '';
			$db->query("DELETE FROM bb".$n."_votes WHERE (id IN (0$del_threadids) AND votemode=2)$pollvotes"); // delete ratings
			
			/* delete attachments */
			$postids = '';
			$result = $db->unbuffered_query("SELECT postid FROM bb".$n."_posts WHERE threadid IN (0$del_threadids) AND attachments>0");
			while ($row = $db->fetch_array($result)) $postids .= (($postids != '') ? (',') : ('')) . $row['postid'];
			if ($postids != '') {
				$result = $db->unbuffered_query("SELECT attachmentid, attachmentextension, thumbnailextension FROM bb".$n."_attachments WHERE postid IN ($postids)");
				while ($row = $db->fetch_array($result)) {
					@unlink("./../attachments/attachment-".$row['attachmentid'].".".$row['attachmentextension']);
					@unlink("./../attachments/thumbnail-".$row['attachmentid'].".".$row['thumbnailextension']);
				}
				$db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE postid IN ($postids)", 1);
			}
			
			// update userposts
			if ($board['countuserposts'] == 1) {
				$result = $db->query("SELECT COUNT(postid) AS posts, userid FROM bb".$n."_posts WHERE threadid IN (0$del_threadids) AND visible=1 AND userid>0 GROUP BY userid");
				while ($row = $db->fetch_array($result)) $db->query("UPDATE bb".$n."_users SET userposts=userposts-'$row[posts]' WHERE userid='$row[userid]'");
			}
			
			// delete posts
			$db->query("DELETE FROM bb".$n."_posts WHERE threadid IN (0$del_threadids)");
			
			/* update boardcount */
			$db->query("UPDATE bb".$n."_boards SET threadcount=threadcount-'$threadcount', postcount=postcount-'$postcount' WHERE boardid IN ($boardid,$board[parentlist])");
			updateBoardInfo("$boardid,$board[parentlist]");
		}
		
		// move threads
		$movethread = $_POST['movethread'];
		$newboardid = $_POST['newboardid'];
		
		$move_threadids = '';
		if (is_array($movethread)) {
			reset($movethread);
			while (list($key, $val) = each($movethread)) if ($val) $move_threadids .= ",$key";
		}
		if ($move_threadids) {
			$board = $db->query_first("SELECT * FROM bb".$n."_boards WHERE boardid='$boardid'");	
			$result = $db->query("SELECT * FROM bb".$n."_threads WHERE threadid IN (0$move_threadids)");
			while ($thread = $db->fetch_array($result)) movethread($thread['threadid'], $movethread[$thread['threadid']], $newboardid[$thread['threadid']]);
		}
		
		header("Location: threads.php?action=spinning&sid=$session[hash]");
		exit();	
	}
	
	$threadaction = $_POST['threadaction'];
	reset($threadaction);
	
	$threadids = '';
	while (list($key, $val) = each($threadaction)) if ($val) $threadids .= ",$key";
	
	if (!$threadids) acp_error($lang->get("LANG_ACP_GLOBAL_ERROR_NORESULT"));
	
	// read permissions
	$permissioncache = getPermissions();
	
	// read boardoptions
	$boardcache = array();	
	$result = $db->unbuffered_query("SELECT boardid, parentid, boardorder, title FROM bb".$n."_boards ORDER by parentid ASC, boardorder ASC");
	while ($row = $db->fetch_array($result)) {
		if (!isset($permissioncache[$row['boardid']]['can_view_board'])) $permissioncache[$row['boardid']]['can_view_board'] = -1;
		if ($permissioncache[$row['boardid']]['can_view_board'] == 0 || ($permissioncache[$row['boardid']]['can_view_board'] == -1 && !$wbbuserdata['can_view_board'])) continue;
		$row['title'] = getlangvar($row['title'], $lang);
		$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
	}
	
	$boardid_options = makeboardoptions(0);
	
	// read in modpermissions
	$board = $db->query_first("SELECT *,userid as moderatorid FROM bb".$n."_moderators WHERE userid='".$wbbuserdata['userid']."' AND boardid='".$boardid."'");
	
	$result = $db->query("SELECT threadid, topic FROM bb".$n."_threads WHERE threadid IN (0$threadids)");
	if (!$db->num_rows($result)) acp_error($lang->get("LANG_ACP_GLOBAL_ERROR_NORESULT"));
	$threadbit1 = '';
	$threadbit2 = '';
	$threadbit3 = '';
	$count1 = 0;
	$count2 = 0;
	$count3 = 0;
	
	while ($row = $db->fetch_array($result)) {
		$row['topic'] = htmlconverter($row['topic']);
		
		if ($threadaction[$row['threadid']] == "del") {
			if (!checkmodpermissions("m_can_thread_del")) continue;
			$rowclass = getone($count1++, "firstrow", "secondrow");
			eval("\$threadbit1 .= \"".$tpl->get("threads_spindelbit", 1)."\";");
		}	
		if ($threadaction[$row['threadid']] == "move") {
			if (!checkmodpermissions("m_can_thread_move")) continue;
			$rowclass = getone($count2++, "firstrow", "secondrow");
			eval("\$threadbit2 .= \"".$tpl->get("threads_spinmovebit", 1)."\";");
		}	
		if ($threadaction[$row['threadid']] == "close") {
			if (!checkmodpermissions("m_can_thread_close")) continue;
			$rowclass = getone($count3++, "firstrow", "secondrow");
			eval("\$threadbit3 .= \"".$tpl->get("threads_spinclosebit", 1)."\";");
		}	
	}
	
	eval("\$tpl->output(\"".$tpl->get("threads_spinverify", 1)."\",1);");
}


/** moderate threads **/
if ($action == "moderate") {
	checkAdminPermissions("a_can_threads_moderate", 1);
	
	if (isset($_POST['send'])) {
		if (isset($_POST['setvisible']) && is_array($_POST['setvisible']) && count($_POST['setvisible'])) {
			$lang->load("MAIL");
			unset($defaultlangpackid);
			$langpacks = array();
			$langpacks[$lang->languagepackid] = $lang;
			
			$threadids = implode(",", $_POST['setvisible']);
			
			// is super mod?
			$boardids = '';
			if ($wbbuserdata['m_is_supermod'] == 0) {
				$result = $db->query("SELECT boardid FROM bb".$n."_moderators WHERE userid='".$wbbuserdata['userid']."'");
				while ($row = $db->fetch_array($result)) $boardids .= ",".$row['boardid'];
			}
			
			// get threads
			$threads = $db->query("SELECT t.topic, t.boardid, t.starttime, t.threadid, t.starter, " .
			"b.parentlist, b.countuserposts, b.lastposttime, b.title, " .
			"u.rankgroupid, u.userposts, u.gender, u.rankid, u.userid " .
			"FROM bb".$n."_threads t " . 
			"LEFT JOIN bb".$n."_boards b ON (t.boardid=b.boardid) " .
			"LEFT JOIN bb".$n."_users u ON (u.userid=t.starterid) " .
			"WHERE t.threadid IN (".$threadids.")" . (($wbbuserdata['m_is_supermod'] == 0) ? (" AND t.boardid IN (0".$boardids.")") : ("")) );
			
			$oldWbbuserdata = $wbbuserdata;
			while ($thread = $db->fetch_array($threads)) {
				// update board counter
				$db->unbuffered_query("UPDATE bb".$n."_boards SET threadcount=threadcount+1, postcount=postcount+1 WHERE boardid IN ($thread[parentlist],$thread[boardid])", 1);
				
				// update global stats
				$db->unbuffered_query("UPDATE bb".$n."_stats SET threadcount=threadcount+1, postcount=postcount+1", 1);
				
				// update userposts
				if ($thread['countuserposts'] == 1 && $thread['userid']) {
					$thread['userposts'] += 1;
					list($rankid) = $db->query_first("SELECT rankid FROM bb".$n."_ranks WHERE groupid IN ('0','$thread[rankgroupid]') AND needposts<='$thread[userposts]' AND gender IN ('0','$thread[gender]') ORDER BY needposts DESC, gender DESC", 1);
					$db->unbuffered_query("UPDATE bb".$n."_users SET userposts=userposts+1".(($rankid != $thread['rankid']) ? (", rankid='$rankid'") : (""))." WHERE userid = '$thread[userid]'", 1);
					
					$wbbuserdata = getwbbuserdata($thread['userid']);
					checkPosts4AI();
				}
				
				// set thread & post visible
				$db->unbuffered_query("UPDATE bb".$n."_threads SET visible=1 WHERE threadid IN ($threadids)");
				$db->unbuffered_query("UPDATE bb".$n."_posts SET visible=1 WHERE threadid IN ($threadids)");	
				
				// update board lastpostinfo
				if ($thread['lastposttime'] < $thread['starttime']) {
					$result = $db->query("SELECT boardid, childlist FROM bb".$n."_boards WHERE boardid IN ($thread[boardid],$thread[parentlist]) AND lastposttime<'$thread[starttime]'");
					while ($row = $db->fetch_array($result)) {
						$lastpost = $db->query_first("SELECT p.threadid, p.userid, p.username, p.posttime FROM bb".$n."_posts p, bb".$n."_threads t WHERE p.threadid=t.threadid AND p.visible = 1 AND t.boardid IN ($row[boardid],$row[childlist]) ORDER BY p.posttime DESC", 1);
						$db->unbuffered_query("UPDATE bb".$n."_boards SET lastthreadid='$lastpost[threadid]', lastposttime='$lastpost[posttime]', lastposterid='$lastpost[userid]', lastposter='".addslashes($lastpost['username'])."' WHERE boardid='$row[boardid]'", 1);
					}
				}
				
				// subscriptions
				$topic = $thread['topic'];
				$threadid = $thread['threadid'];
				$wbbuserdata['username'] = $thread['starter'];
				
				$result = $db->query("SELECT u.email, u.username, s.countemails, l.languagepackid FROM bb".$n."_subscribeboards s LEFT JOIN bb".$n."_users u USING(userid) LEFT JOIN bb".$n."_languagepacks l ON(l.languagepackid=u.langid) WHERE s.boardid='$thread[boardid]' AND s.userid<>'$thread[userid]' AND s.emailnotify=1 AND s.countemails<'$maxnotifymails' AND u.email is not null");
				while ($row = $db->fetch_array($result)) {
					if (!isset($langpacks[$row['languagepackid']])) {
						$langpacks[$row['languagepackid']] = new language(intval($row['languagepackid']));	
						$langpacks[$row['languagepackid']]->load("OWN,MAIL");
					}
					
					$master_board_name_email = getlangvar($o_master_board_name, $langpacks[$row['languagepackid']], 0);
					$board['title'] = getlangvar($thread['title'], $langpacks[$row['languagepackid']], 0);
					
					$mail_subject = $langpacks[$row['languagepackid']]->get("LANG_MAIL_NEWTHREAD_SUBJECT", array('$title' => $board['title']));
					$mail_text = $langpacks[$row['languagepackid']]->get("LANG_MAIL_NEWTHREAD_TEXT", array('$username' => $row['username'], '$title' => $board['title'], '$topic' => $topic, '$author' => $wbbuserdata['username'], '$url2board' => $url2board, '$threadid' => $threadid, '$master_board_name_email' => $master_board_name_email));
					mailer($row['email'], $mail_subject, $mail_text);
				}
				$db->unbuffered_query("UPDATE bb".$n."_subscribeboards SET countemails=countemails+1 WHERE boardid='$thread[boardid]' AND userid<>'$thread[userid]' AND emailnotify=1 AND countemails<'$maxnotifymails'", 1);
			}
			
			$wbbuserdata = $oldWbbuserdata;
		}	
	}
	
	// is super mod?
	if ($wbbuserdata['m_is_supermod'] == 0) {
		$boardids = '';
		$result = $db->query("SELECT boardid FROM bb".$n."_moderators WHERE userid='".$wbbuserdata['userid']."'");
		while ($row = $db->fetch_array($result)) $boardids .= ",".$row['boardid'];
		
		$result = $db->query("SELECT threadid, topic, starter, starterid FROM bb".$n."_threads WHERE visible=0 AND boardid IN (0".$boardids.") ORDER BY starttime DESC");	
	}	
	else $result = $db->query("SELECT threadid, topic, starter, starterid FROM bb".$n."_threads WHERE visible=0 ORDER BY starttime DESC");	
	
	$threadbit = '';
	$count = 0;
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count++, "firstrow", "secondrow");
		
		$row['starter'] = htmlconverter($row['starter']);
		$row['topic'] = htmlconverter($row['topic']);
		
		if ($row['starterid'] != 0) $row['starter'] = makehreftag("../profile.php?userid=$row[starterid]", $row['starter'], "_blank");
		eval("\$threadbit .= \"".$tpl->get("threads_moderatebit", 1)."\";");	
	}
	
	eval("\$tpl->output(\"".$tpl->get("threads_moderate", 1)."\",1);");
}


/** moderate posts **/
if ($action == "moderateposts") {
	checkAdminPermissions("a_can_threads_moderate_posts", 1);
	
	if (isset($_POST['send'])) {
		if (isset($_POST['setvisible']) && is_array($_POST['setvisible']) && count($_POST['setvisible'])) {
			$lang->load("MAIL");
			unset($defaultlangpackid);
			$langpacks = array();
			$langpacks[$lang->languagepackid] = $lang;
			
			$postids = implode(",", $_POST['setvisible']);
			
			// is super mod?
			$boardids = '';
			if ($wbbuserdata['m_is_supermod'] == 0) {
				$result = $db->query("SELECT boardid FROM bb".$n."_moderators WHERE userid='".$wbbuserdata['userid']."'");
				while ($row = $db->fetch_array($result)) $boardids .= ",".$row['boardid'];
			}
			
			$posts = $db->query("SELECT p.postid, p.posttime, p.userid, p.username, p.threadid, " .
			"t.topic, t.boardid, t.lastposttime, " .
			"b.parentlist, b.countuserposts, b.lastposttime as blastposttime, b.title, " .
			"u.rankgroupid, u.userposts, u.gender, u.rankid, u.userid " .
			"FROM bb".$n."_posts p " .
			"LEFT JOIN bb".$n."_users u USING (userid) " .
			"LEFT JOIN bb".$n."_threads t ON (t.threadid=p.threadid) " .
			"LEFT JOIN bb".$n."_boards b ON (t.boardid=b.boardid) " .
			"WHERE p.postid IN ($postids)" . (($wbbuserdata['m_is_supermod'] == 0) ? (" AND t.boardid IN (0".$boardids.")") : ("")) );
			
			$oldWbbuserdata = $wbbuserdata;
			while ($post = $db->fetch_array($posts)) {
				// update thread
				if ($post['posttime'] > $post['lastposttime']) $db->unbuffered_query("UPDATE bb".$n."_threads SET lastposttime = '$post[posttime]', lastposterid = '$post[userid]', lastposter = '".addslashes($post['username'])."', replycount = replycount+1 WHERE threadid = '$post[threadid]'", 1);
				else $db->unbuffered_query("UPDATE bb".$n."_threads SET replycount = replycount+1 WHERE threadid = '$post[threadid]'", 1);
				
				// update board counter
				$db->unbuffered_query("UPDATE bb".$n."_boards SET postcount=postcount+1 WHERE boardid IN ($post[parentlist],$post[boardid])", 1);
				
				// update global stats
				$db->unbuffered_query("UPDATE bb".$n."_stats SET postcount=postcount+1", 1);
				
				// update userposts
				if ($post['countuserposts'] == 1 && $post['userid']) {
					$post['userposts'] += 1;
					list($rankid) = $db->query_first("SELECT rankid FROM bb".$n."_ranks WHERE groupid IN ('0','$post[rankgroupid]') AND needposts<='$post[userposts]' AND gender IN ('0','$post[gender]') ORDER BY needposts DESC, gender DESC", 1);
					$db->unbuffered_query("UPDATE bb".$n."_users SET userposts=userposts+1".(($rankid != $post['rankid']) ? (", rankid='$rankid'") : (""))." WHERE userid = '$post[userid]'", 1);
					
					$wbbuserdata = getwbbuserdata($post['userid']);
					checkPosts4AI();
				}
				
				// set post visible
				$db->unbuffered_query("UPDATE bb".$n."_posts SET visible=1 WHERE postid IN ($postids)");
				
				// update board lastpostinfo
				if ($post['blastposttime'] < $post['posttime']) {
					$result = $db->query("SELECT boardid, childlist FROM bb".$n."_boards WHERE boardid IN ($post[boardid],$post[parentlist]) AND lastposttime<'$post[posttime]'");
					while ($row = $db->fetch_array($result)) {
						$lastpost = $db->query_first("SELECT p.threadid, p.userid, p.username, p.posttime FROM bb".$n."_posts p, bb".$n."_threads t WHERE p.threadid=t.threadid AND p.visible = 1 AND t.boardid IN ($row[boardid],$row[childlist]) ORDER BY p.posttime DESC", 1);
						$db->unbuffered_query("UPDATE bb".$n."_boards SET lastthreadid='$lastpost[threadid]', lastposttime='$lastpost[posttime]', lastposterid='$lastpost[userid]', lastposter='".addslashes($lastpost[username])."' WHERE boardid='$row[boardid]'", 1);
					}
				}
				
				// subscriptions
				$thread['topic'] = $post['topic'];
				$postid = $post['postid'];
				$wbbuserdata['username'] = $post['username'];
				
				$result = $db->query("SELECT u.email, u.username, s.countemails, l.languagepackid FROM bb".$n."_subscribethreads s LEFT JOIN bb".$n."_users u USING(userid) LEFT JOIN bb".$n."_languagepacks l ON(l.languagepackid=u.langid) WHERE s.threadid='$post[threadid]' AND s.userid<>'$post[userid]' AND s.emailnotify=1 AND s.countemails<'$maxnotifymails' AND u.email is not null");
				while ($row = $db->fetch_array($result)) {
					if (!isset($langpacks[$row['languagepackid']])) {
						$langpacks[$row['languagepackid']] = new language(intval($row['languagepackid']));	
						$langpacks[$row['languagepackid']]->load("OWN,MAIL");
					}
					
					$master_board_name_email = getlangvar($o_master_board_name, $langpacks[$row['languagepackid']], 0);   
					
					$mail_subject = $langpacks[$row['languagepackid']]->get("LANG_MAIL_NEWPOST_SUBJECT", array('$topic' => $thread['topic']));
					$mail_text = $langpacks[$row['languagepackid']]->get("LANG_MAIL_NEWPOST_TEXT", array('$username' => $row['username'], '$topic' => $thread['topic'], '$author' => $wbbuserdata['username'], '$url2board' => $url2board, '$postid' => $postid, '$master_board_name_email' => $master_board_name_email));
					mailer($row['email'], $mail_subject, $mail_text);
				}
				
				$db->unbuffered_query("UPDATE bb".$n."_subscribethreads SET countemails=countemails+1 WHERE threadid='$post[threadid]' AND userid<>'$post[userid]' AND emailnotify=1 AND countemails<'$maxnotifymails'", 1);
			}
			
			$wbbuserdata = $oldWbbuserdata;
		}	
	}
	
	// is super mod?
	if ($wbbuserdata['m_is_supermod'] == 0) {
		$boardids = '';
		$result = $db->query("SELECT boardid FROM bb".$n."_moderators WHERE userid='".$wbbuserdata['userid']."'");
		while ($row = $db->fetch_array($result)) $boardids .= ",".$row['boardid'];
		
		$result = $db->query("SELECT t.topic, p.username, p.userid, p.postid FROM bb".$n."_posts p, bb".$n."_threads t WHERE t.threadid=p.threadid AND t.visible=1 AND p.visible=0 AND t.boardid IN (0".$boardids.") ORDER BY posttime DESC");	
	}	
	else $result = $db->query("SELECT t.topic, p.username, p.userid, p.postid FROM bb".$n."_posts p, bb".$n."_threads t WHERE t.threadid=p.threadid AND t.visible=1 AND p.visible=0 ORDER BY posttime DESC");	
	
	$postbit = '';
	$count = 0;
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count++, "firstrow", "secondrow");
		
		$row['username'] = htmlconverter($row['username']);
		$row['topic'] = htmlconverter($row['topic']);
		
		if ($row['userid'] != 0) $row['username'] = makehreftag("../profile.php?userid=$row[userid]", $row['username'], "_blank");
		eval("\$postbit .= \"".$tpl->get("threads_moderatepostsbit", 1)."\";");	
	}
	
	eval("\$tpl->output(\"".$tpl->get("threads_moderateposts", 1)."\",1);");
}
?>
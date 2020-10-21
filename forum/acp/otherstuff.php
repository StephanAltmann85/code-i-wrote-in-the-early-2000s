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
// * $Date: 2005-04-21 12:15:39 +0200 (Thu, 21 Apr 2005) $
// * $Author: Burntime $
// * $Rev: 1593 $
// ************************************************************************************//


require('./global.php');
@set_time_limit(0);

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = '';

function daynumber($time) {
	global $wbbuserdata;
	$daynumber = intval(date('w', $time)) - $wbbuserdata['startweek'];
	if ($daynumber < 0) $daynumber = 7 + $daynumber;
	return $daynumber;
}

$lang->load('ACP_OTHERSTUFF');

if (!$action) {
	if (!checkAdminPermissions("a_can_otherstuff_ranks") && !checkAdminPermissions("a_can_otherstuff_threads") && !checkAdminPermissions("a_can_otherstuff_delindex") && !checkAdminPermissions("a_can_otherstuff_reindex") && !checkAdminPermissions("a_can_otherstuff_userposts") && !checkAdminPermissions("a_can_users_edit")) access_error(1);
	list($reindexposts) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_posts WHERE reindex=1");
	
	eval("\$tpl->output(\"".$tpl->get("otherstuff", 1)."\",1);");
}

if ($action == "doing") eval("\$tpl->output(\"".$tpl->get("doing", 1)."\",1);");









/** delindex **/
if ($action == "delindex") {
	checkAdminPermissions("a_can_otherstuff_delindex", 1);
	if (isset($_POST['send'])) {
		$db->unbuffered_query("DELETE FROM bb".$n."_wordlist", 1);	
		$db->unbuffered_query("DELETE FROM bb".$n."_wordmatch", 1);	
		$db->unbuffered_query("UPDATE bb".$n."_posts SET reindex=1", 1);	
		header("Location: otherstuff.php?sid=$session[hash]");
		exit();	
	}	
	
	else eval("\$tpl->output(\"".$tpl->get("delindex", 1)."\",1);");
}




/** update stats **/
if ($action == "updatestats") {
	checkAdminPermissions("a_can_otherstuff_updatestats", 1);
	
	list($threadcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_threads WHERE closed<>3 AND visible=1");
	list($postcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_posts WHERE visible=1");
	$user = $db->query_first("SELECT COUNT(*) AS usercount, MAX(userid) AS userid FROM bb".$n."_users");
	
	$db->unbuffered_query("UPDATE bb".$n."_stats SET threadcount='".$threadcount."', postcount='".$postcount."', usercount='".$user['usercount']."', lastuserid='".$user['userid']."'", 1);	
	
	header("Location: otherstuff.php?sid=$session[hash]");
	exit();	
}







/** userposts **/
if ($action == "userposts") {
	checkAdminPermissions("a_can_otherstuff_userposts", 1);
	
	if (isset($_REQUEST['perpage'])) $perpage = intval($_REQUEST['perpage']);
	else $perpage = 0;
	if ($perpage == 0) $perpage = 1;
	
	if (isset($_REQUEST['page'])) $page = intval($_REQUEST['page']);
	else $page = 0;
	if ($page == 0) $page = 1;
	
	list($totalcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_users");
	$pages = ceil($totalcount / $perpage);
	
	if ($page <= $pages) {
		refresh_start();
		$result = $db->query("SELECT userid, userposts FROM bb".$n."_users ORDER BY userid ASC", $perpage, $perpage * ($page - 1));
		while ($row = $db->fetch_array($result)) {
			list($userposts) = $db->query_first("SELECT COUNT(postid) FROM bb".$n."_posts p, bb".$n."_threads t LEFT JOIN bb".$n."_boards b ON (t.boardid=b.boardid) WHERE t.threadid=p.threadid AND p.userid='$row[userid]' AND p.visible=1 AND b.countuserposts=1");	
			if ($userposts != $row['userposts']) $db->unbuffered_query("UPDATE bb".$n."_users SET userposts='$userposts' WHERE userid='$row[userid]'", 1);
		}
		refresh("otherstuff.php?sid=$session[hash]&action=userposts&perpage=$perpage&page=".($page + 1), $lang->items['LANG_ACP_OTHERSTUFF_USERPOSTS'], round($page * $perpage / $totalcount * 100));
	}
	else eval("\$tpl->output(\"".$tpl->get("working_done", 1)."\",1);");
}






/** private message counters **/
if ($action == "pmcounters") {
	checkAdminPermissions("a_can_otherstuff_pmcounters", 1);
	
	if (isset($_REQUEST['perpage'])) $perpage = intval($_REQUEST['perpage']);
	else $perpage = 0;
	if ($perpage == 0) $perpage = 1;
	
	if (isset($_REQUEST['page'])) $page = intval($_REQUEST['page']);
	else $page = 0;
	if ($page == 0) $page = 1;
	
	list($totalcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_users");
	$pages = ceil($totalcount / $perpage);
	
	if ($page <= $pages) {
		refresh_start();
		$result = $db->query("SELECT userid, lastvisit FROM bb".$n."_users ORDER BY userid ASC", $perpage, $perpage * ($page - 1));
		while ($row = $db->fetch_array($result)) {
			// reset counters
			$pmtotalcount = 0;
			$outbox_count = 0;
			$pmnewcount = 0;
			$pmunreadcount = 0;

			// count PMs in the user's folders (except outbox)
			$pm_result = $db->query("SELECT pmr.view, p.sendtime ".
			"FROM bb".$n."_privatemessagereceipts pmr ".
			"LEFT JOIN bb".$n."_privatemessage p ON (p.privatemessageid = pmr.privatemessageid) ".
			"WHERE pmr.recipientid = '$row[userid]' AND pmr.deletepm = 0");
			while ($pm_row = $db->fetch_array($pm_result)) {
				$pmtotalcount++;
				if ($pm_row['view'] == 0) {
					$pmunreadcount++;	
					if ($pm_row['sendtime'] > $row['lastvisit']) $pmnewcount++;
				}	
			}
			
			// count PMs in the user's outbox
			list($outbox_count) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_privatemessage WHERE senderid = '".$row['userid']."' AND inoutbox = 1");
			$pmtotalcount += $outbox_count;
			$pminboxcount  = $pmtotalcount - $outbox_count;
			
			$db->unbuffered_query("UPDATE bb".$n."_users SET pmtotalcount='$pmtotalcount', pminboxcount='$pminboxcount', pmnewcount='$pmnewcount', pmunreadcount='$pmunreadcount' WHERE userid='$row[userid]'", 1);
		}
		refresh("otherstuff.php?sid=$session[hash]&action=pmcounters&perpage=$perpage&page=".($page + 1), $lang->items['LANG_ACP_OTHERSTUFF_PMCOUNTERS'], round($page * $perpage / $totalcount * 100));
	}
	else eval("\$tpl->output(\"".$tpl->get("working_done", 1)."\",1);");
}








/** threads **/
if ($action == "threads") {
	checkAdminPermissions("a_can_otherstuff_threads", 1);
	
	if (isset($_REQUEST['perpage'])) $perpage = intval($_REQUEST['perpage']);
	else $perpage = 0;
	if ($perpage == 0) $perpage = 1;
	
	if (isset($_REQUEST['page'])) $page = intval($_REQUEST['page']);
	else $page = 0;
	if ($page == 0) $page = 1;
	
	list($totalcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_threads");
	$pages = ceil($totalcount / $perpage);
	
	if ($page <= $pages) {
		refresh_start();
		$result = $db->query("SELECT MIN(p.postid) AS minpost, MAX(p.postid) AS maxpost, t.threadid, MIN(p.posttime) AS starttime, MAX(p.posttime) AS lastposttime,
		(COUNT(*)-1) AS posts
		FROM bb".$n."_posts p, bb".$n."_threads t
		WHERE t.threadid=p.threadid
		GROUP BY t.threadid", $perpage, $perpage * ($page - 1));
		
		while ($row = $db->fetch_array($result)) {
			$start = $db->query_first("SELECT p.userid, p.username, u.username AS realusername FROM bb".$n."_posts p LEFT JOIN bb".$n."_users u USING(userid) WHERE postid='$row[minpost]'");
			$lastpost = $db->query_first("SELECT p.userid, p.username, u.username AS realusername FROM bb".$n."_posts p LEFT JOIN bb".$n."_users u USING(userid) WHERE postid='$row[maxpost]'");
			
			$attachments = $db->query_first("SELECT COUNT(*) as count FROM bb".$n."_posts p, bb".$n."_attachments a WHERE p.threadid = '".$row['threadid']."' AND a.postid = p.postid");
			
			if ($start['userid'] == 0) $starter = $start['username'];
			else $starter = $start['realusername'];
			if ($lastpost['userid'] == 0) $lastposter = $lastpost['username'];
			else $lastposter = $lastpost['realusername'];
			
			$db->unbuffered_query("UPDATE bb".$n."_threads SET attachments='".$attachments['count']."', starttime='$row[starttime]', lastposttime='$row[lastposttime]', starterid='$start[userid]', lastposterid='$lastpost[userid]', starter='".addslashes($starter)."', lastposter='".addslashes($lastposter)."', replycount='$row[posts]' WHERE threadid='$row[threadid]'", 1);
		} 
		
		refresh("otherstuff.php?sid=$session[hash]&action=threads&perpage=$perpage&page=".($page + 1), $lang->items['LANG_ACP_OTHERSTUFF_THREADS'], round($page * $perpage / $totalcount * 100));
	}	
	else eval("\$tpl->output(\"".$tpl->get("working_done", 1)."\",1);");
}






/** boards **/
if ($action == "boards") {
	checkAdminPermissions("a_can_otherstuff_boards", 1);
	
	if (isset($_REQUEST['perpage'])) $perpage = intval($_REQUEST['perpage']);
	else $perpage = 0;
	if ($perpage == 0) $perpage = 1;
	
	if (isset($_REQUEST['page'])) $page = intval($_REQUEST['page']);
	else $page = 0;
	if ($page == 0) $page = 1;
	
	list($totalcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_boards");
	$pages = ceil($totalcount / $perpage);
	
	if ($page <= $pages) {
		refresh_start();
		$result = $db->query("SELECT * FROM bb".$n."_boards", $perpage, $perpage * ($page - 1));
		
		while ($row = $db->fetch_array($result)) {
			list($threadcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_threads WHERE boardid IN ($row[boardid],$row[childlist]) AND visible=1 AND closed <> 3");
			list($postcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_posts p, bb".$n."_threads t WHERE p.threadid=t.threadid AND t.boardid IN ($row[boardid],$row[childlist]) AND p.visible=1");
			
			$lastpost = $db->query_first("SELECT p.threadid, p.userid, p.username, p.posttime FROM bb".$n."_posts p, bb".$n."_threads t WHERE p.threadid=t.threadid AND t.boardid IN ($row[boardid],$row[childlist]) AND p.visible=1 ORDER BY p.posttime DESC", 1);
			$db->unbuffered_query("UPDATE bb".$n."_boards SET lastthreadid='$lastpost[threadid]', lastposttime='$lastpost[posttime]', lastposterid='$lastpost[userid]', lastposter='".addslashes($lastpost['username'])."', postcount='$postcount', threadcount='$threadcount' WHERE boardid='$row[boardid]'", 1);
		} 
		
		refresh("otherstuff.php?sid=$session[hash]&action=boards&perpage=$perpage&page=".($page + 1), $lang->items['LANG_ACP_OTHERSTUFF_BOARDS'], round($page * $perpage / $totalcount * 100));
	}	
	else eval("\$tpl->output(\"".$tpl->get("working_done", 1)."\",1);");
}








/** ranks **/
if ($action == "ranks") {
	checkAdminPermissions("a_can_otherstuff_ranks", 1);
	
	if (isset($_REQUEST['perpage'])) $perpage = intval($_REQUEST['perpage']);
	else $perpage = 0;
	if ($perpage == 0) $perpage = 1;
	
	if (isset($_REQUEST['page'])) $page = intval($_REQUEST['page']);
	else $page = 0;
	if ($page == 0) $page = 1;
	
	list($totalcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_users");
	$pages = ceil($totalcount / $perpage);
	
	if ($page <= $pages) {
		refresh_start();
		$result = $db->query("SELECT userid, rankgroupid, gender, userposts FROM bb".$n."_users", $perpage, $perpage * ($page - 1));		
		while ($row = $db->fetch_array($result)) {
			list($rankid) = $db->query_first("SELECT rankid FROM bb".$n."_ranks WHERE groupid IN ('0','$row[rankgroupid]') AND needposts<='$row[userposts]' AND gender IN ('0','$row[gender]') ORDER BY needposts DESC, gender DESC", 1);
			$db->unbuffered_query("UPDATE bb".$n."_users SET rankid='$rankid' WHERE userid='$row[userid]'", 1);
		}	
		refresh("otherstuff.php?sid=$session[hash]&action=ranks&perpage=$perpage&page=".($page + 1), $lang->items['LANG_ACP_OTHERSTUFF_RANKS'], round($page * $perpage / $totalcount * 100));
	}	
	else eval("\$tpl->output(\"".$tpl->get("working_done", 1)."\",1);");
}















/** reindex **/
if ($action == "reindex") {
	checkAdminPermissions("a_can_otherstuff_reindex", 1);
	
	if (isset($_REQUEST['perpage'])) $perpage = intval($_REQUEST['perpage']);
	else $perpage = 0;
	if ($perpage == 0) $perpage = 1;
	
	if (isset($_REQUEST['page'])) $page = intval($_REQUEST['page']);
	else $page = 0;
	if ($page == 0) $page = 1;
	
	if (isset($_REQUEST['totalcount'])) $totalcount = intval($_REQUEST['totalcount']);
	else list($totalcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_posts WHERE reindex=1"); 
	$pages = ceil($totalcount / $perpage);
	
	$caching = array();
	if ($page <= $pages) {
		refresh_start();
		$result = $db->unbuffered_query("SELECT postid, message, posttopic FROM bb".$n."_posts WHERE reindex=1 ORDER BY postid ASC", 0, $perpage);
		$postids = "0";
		while ($row = $db->fetch_array($result)) {
			$caching[] = $row;
			$postids .= ",".$row['postid'];
		}
		
		$db->unbuffered_query("DELETE FROM bb".$n."_wordmatch WHERE postid IN ($postids)", 1);
		
		$db->query("LOCK TABLES bb".$n."_wordmatch WRITE, bb".$n."_wordlist WRITE;");
		foreach ($caching as $key => $val) {
			wordmatch($val['postid'], $val['message'], $val['posttopic']);
			unset($caching[$key]);
			unset($val);
			unset($key);
		}
		$db->query("UNLOCK TABLES;");
		
		$db->unbuffered_query("UPDATE bb".$n."_posts SET reindex=0 WHERE postid IN ($postids)", 1);
		refresh("otherstuff.php?sid=$session[hash]&action=reindex&perpage=$perpage&page=".($page + 1)."&totalcount=$totalcount", $lang->items['LANG_ACP_OTHERSTUFF_REINDEX'], round($page * $perpage / $totalcount * 100));
	}
	else eval("\$tpl->output(\"".$tpl->get("working_done", 1)."\",1);");
}









/** send email from mailqueue **/
if ($action == "email") {
 	checkAdminPermissions("a_can_users_email", 1);
 	$perpage = 100;
 
 	if (isset($_REQUEST['page'])) $page = intval($_REQUEST['page']);
 	else $page = 0;
 	if ($page == 0) $page = 1;
 
 	$mailid = intval($_REQUEST['mailid']);
 	$mail_info = $db->query_first("SELECT * FROM bb".$n."_mails WHERE mailid='$mailid'");
 	list($leftcount) = $db->query_first("SELECT COUNT(*) as leftcount FROM bb".$n."_mailqueue WHERE mailid='$mailid'");
 	$totalcount = $mail_info['recipients'];
 
 	if ($leftcount > 0) {
		refresh_start();
		$userids = '';
		$result = $db->unbuffered_query("SELECT userid, username, email FROM bb".$n."_mailqueue WHERE mailid='$mailid' ORDER BY userid ASC", 0, $perpage);
  		while ($row = $db->fetch_array($result)) {
   			$temp = strtr($mail_info['message'], array('{username}' => $row['username'], '$username' => $row['username']));
   			mailer($row['email'], $mail_info['subject'], $temp, $mail_info['sender'], $mail_info['otherheaders']);
   			$userids .= ",$row[userid]";
  		}
		$db->unbuffered_query("DELETE FROM bb".$n."_mailqueue WHERE mailid='$mailid' AND userid IN (0$userids)", 1);
		
  		$page += 1;
  		refresh("otherstuff.php?sid=$session[hash]&action=email&mailid=$mailid&page=$page", $lang->items['LANG_ACP_OTHERSTUFF_EMAIL'], round($page * $perpage / $totalcount * 100));
 	}
 	else eval("\$tpl->output(\"".$tpl->get("working_emaildone", 1)."\",1);");	
}












/** cache templates **/
if ($action == "cachetemplates") {
	checkAdminPermissions("a_can_template_cache", 1);
	$lang->load("ACP_TEMPLATE");
	if (isset($_REQUEST['perpage'])) $perpage = intval($_REQUEST['perpage']);
	else $perpage = 0;
	if ($perpage == 0) $perpage = 50;
	if (isset($_REQUEST['page'])) $page = intval($_REQUEST['page']);
	else $page = 0;
	if ($page == 0) $page = 1;
	
	list($totalcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_templates");
	$pages = ceil($totalcount / $perpage);
	
	include_once("./lib/class_templateparser.php");
	if ($page <= $pages) {
		refresh_start();
		$tplparser = new TemplateParser();
		$result = $db->unbuffered_query("SELECT templateid, templatename, templatepackid, template FROM bb".$n."_templates ORDER BY templateid ASC", 0, $perpage, $perpage * ($page - 1));
		while ($row = $db->fetch_array($result)) {
			
			// parse template
			$template = $tplparser->parse(dos2unix($row['template']));
			
			if (@is_file("./../cache/templates/" . $row['templatepackid'] . "_" . $row['templatename'] . ".php") && !@is_writeable("./../cache/templates/" . $row['templatepackid'] . "_" . $row['templatename'] . ".php")) refresh_error($lang->get("LANG_ACP_TEMPLATE_ERROR_3"));
			
			// cache template
			$fp = @fopen("./../cache/templates/" . $row['templatepackid'] . "_" . $row['templatename'] . ".php", "w+b");
			@fwrite($fp, "<?php
			/*
			templatepackid: ".$row['templatepackid']."
			templatename: ".$row['templatename']."
			*/
			
			\$this->templates['".$row['templatename']."']=\"".addcslashes($template, "$\"\\")."\";
			?".">");
			@fclose($fp);
			@chmod("./../cache/templates/" . $row['templatepackid'] . "_" . $row['templatename'] . ".php", 0777);
			unset($template);
		}
		refresh("otherstuff.php?sid=$session[hash]&action=cachetemplates&perpage=$perpage&page=".($page + 1), $lang->items['LANG_ACP_GLOBAL_MENU_TEMPLATE_CACHE'], round($page * $perpage / $totalcount * 100));
	}	
	else {
		$db->unbuffered_query("UPDATE bb".$n."_templates SET recompile = 0", 1);
		eval("\$tpl->output(\"".$tpl->get("working_done", 1)."\",1);");
	}
}




/** cache only new templates which are not cached **/
if ($action == "cachetemplates_onlynew") {
	checkAdminPermissions("a_can_template_cache", 1);
	$lang->load("ACP_TEMPLATE");
	if (isset($_REQUEST['perpage'])) $perpage = intval($_REQUEST['perpage']);
	else $perpage = 0;
	if ($perpage == 0) $perpage = 50;
	if (isset($_REQUEST['page'])) $page = intval($_REQUEST['page']);
	else $page = 0;
	if ($page == 0) $page = 1;
	
	
	$totalcount = 0;
	$templateids = '';
	
	$result = $db->unbuffered_query("SELECT templateid, templatepackid, templatename, recompile FROM bb".$n."_templates");
	while ($row = $db->fetch_array($result)) {
		if ($row['recompile'] == 1 || !file_exists('../cache/templates/'.$row['templatepackid'].'_'.$row['templatename'].'.php')) {
			if ($totalcount < $perpage) $templateids .= ','.$row['templateid'];
			$totalcount++;
		}
	}

	if (isset($_REQUEST['totalcount'])) $totalcount = intval($_REQUEST['totalcount']);
	$pages = ceil($totalcount / $perpage);
	
	
	include_once("./lib/class_templateparser.php");
	if ($templateids) {
		refresh_start();
		
		$templateids = wbb_substr($templateids, 1);
		$tplparser = new TemplateParser();
		$result = $db->unbuffered_query("SELECT templateid, templatename, templatepackid, template FROM bb".$n."_templates WHERE templateid IN (".$templateids.")");
		while ($row = $db->fetch_array($result)) {
			
			// parse template
			$template = $tplparser->parse(dos2unix($row['template']));
			
			if (@is_file("./../cache/templates/" . $row['templatepackid'] . "_" . $row['templatename'] . ".php") && !@is_writeable("./../cache/templates/" . $row['templatepackid'] . "_" . $row['templatename'] . ".php")) refresh_error($lang->get("LANG_ACP_TEMPLATE_ERROR_3"));
			
			// cache template
			$fp = @fopen("./../cache/templates/" . $row['templatepackid'] . "_" . $row['templatename'] . ".php", "w+b");
			@fwrite($fp, "<?php
			/*
			templatepackid: ".$row['templatepackid']."
			templatename: ".$row['templatename']."
			*/
			
			\$this->templates['".$row['templatename']."']=\"".addcslashes($template, "$\"\\")."\";
			?".">");
			@fclose($fp);
			@chmod("./../cache/templates/" . $row['templatepackid'] . "_" . $row['templatename'] . ".php", 0777);
			unset($template);

		}
		$db->unbuffered_query("UPDATE bb".$n."_templates SET recompile = 0 WHERE templateid IN (".$templateids.")", 1);
		
		refresh("otherstuff.php?sid=$session[hash]&action=cachetemplates_onlynew&totalcount=$totalcount&perpage=$perpage&page=".($page + 1), $lang->items['LANG_ACP_GLOBAL_MENU_TEMPLATE_CACHE'], round($page * $perpage / $totalcount * 100));
	}	
	else eval("\$tpl->output(\"".$tpl->get("working_done", 1)."\",1);");
}











/** wordmatch **/
if ($action == "wordmatch") {
	checkAdminPermissions("a_can_otherstuff_wordmatch", 1);
	$result = $db->query("SELECT wordlist.word, wordlist.wordid, COUNT(wordmatch.postid) AS mount
	FROM bb".$n."_wordlist wordlist
	LEFT JOIN bb".$n."_wordmatch wordmatch USING (wordid)
	GROUP BY wordlist.wordid ORDER BY mount DESC", 100);
	
	$wordbit = '';	
	while ($row = $db->fetch_array($result)) {
		$row['word'] = htmlconverter($row['word']);
		eval("\$wordbit .= \"".$tpl->get("wordmatch_wordbit", 1)."\";");
	}
	
	eval("\$tpl->output(\"".$tpl->get("wordmatch", 1)."\",1);");
}

if ($action == "wordmatch2") {
	checkAdminPermissions("a_can_otherstuff_wordmatch2", 1);
	if ($_POST['wordids']) $wordids = implode(",", $_POST['wordids']);
	
	if ($wordids) {
		$badsearchwords = trim($badsearchwords);
		$result = $db->query("SELECT word FROM bb".$n."_wordlist WHERE wordid IN ($wordids)");
		while ($row = $db->fetch_array($result)) {
			if ($badsearchwords != '') $badsearchwords .= "\n".$row['word'];
			else $badsearchwords = $row['word'];
		}
		
		$db->query("UPDATE bb".$n."_options SET value='".addslashes($badsearchwords)."' WHERE varname='badsearchwords'");
		
		require("./lib/class_options.php");
		$option = new options("lib");
		$option->write();
		
		$db->unbuffered_query("DELETE FROM bb".$n."_wordmatch WHERE wordid IN ($wordids)", 1);
		$db->unbuffered_query("DELETE FROM bb".$n."_wordlist WHERE wordid IN ($wordids)", 1);	
	}
	
	eval("\$tpl->output(\"".$tpl->get("wordmatch2", 1)."\",1);");
}





/** password generate **/
if ($action == "password_generate") {
	checkAdminPermissions("a_can_users_edit", 1);
	
	if (isset($_REQUEST['perpage'])) $perpage = intval($_REQUEST['perpage']);
	else $perpage = 0;
	if ($perpage == 0) $perpage = 1;
	
	if (isset($_REQUEST['page'])) $page = intval($_REQUEST['page']);
	else $page = 0;
	if ($page == 0) $page = 1;
	
	if (isset($_REQUEST['totalcount'])) $totalcount = intval($_REQUEST['totalcount']);
	else list($totalcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_users WHERE sha1_password=''"); 
	$pages = ceil($totalcount / $perpage);
	
	$caching = array();
	if ($page <= $pages) {
		refresh_start();
		
		$lang->load("MAIL");
		$langpacks = array();
		$langpacks[$lang->languagepackid] = $lang;
		
		$result = $db->query("SELECT u.userid, u.username, u.email, l.languagepackid FROM bb".$n."_users u LEFT JOIN bb".$n."_languagepacks l ON (l.languagepackid=u.langid) WHERE u.sha1_password=''", $perpage);
		while ($user = $db->fetch_array($result)) {
			$newpassword = password_generate();
			
			$db->unbuffered_query("UPDATE bb".$n."_users SET password='".md5($newpassword)."', sha1_password='".sha1($newpassword)."' WHERE userid='".$user['userid']."'", 1);
			
			
			if (!isset($langpacks[$user['languagepackid']])) {
				$langpacks[$user['languagepackid']] = new language(intval($user['languagepackid']));	
				$langpacks[$user['languagepackid']]->load("OWN,MAIL");
			}
			
			$master_board_name_email = getlangvar($o_master_board_name, $langpacks[$user['languagepackid']], 0);   
			
			$mail_subject = $langpacks[$user['languagepackid']]->get("LANG_MAIL_NEWPW_SUBJECT", array('$master_board_name_email' => $master_board_name_email));
			$mail_text = $langpacks[$user['languagepackid']]->get("LANG_MAIL_NEWPW_TEXT", array('$username' => $user['username'], '$newpassword' => $newpassword, '$master_board_name_email' => $master_board_name_email));
			mailer($user['email'], $mail_subject, $mail_text);	
		}
		
		
		refresh("otherstuff.php?sid=$session[hash]&action=password_generate&perpage=$perpage&page=".($page + 1)."&totalcount=$totalcount", $lang->items['LANG_ACP_OTHERSTUFF_PASSWORD_GENERATE'], round($page * $perpage / $totalcount * 100));
	}
	else eval("\$tpl->output(\"".$tpl->get("working_done", 1)."\",1);");
}










/** generate thumbnails **/
if ($action == "thumbnails") {
	checkAdminPermissions("a_can_otherstuff_thumbnails", 1);
	if ($makethumbnails == 0) access_error(1);
	
	if (isset($_REQUEST['perpage'])) $perpage = intval($_REQUEST['perpage']);
	else $perpage = 0;
	if ($perpage == 0) $perpage = 1;
	
	if (isset($_REQUEST['page'])) $page = intval($_REQUEST['page']);
	else $page = 0;
	if ($page == 0) $page = 1;
	
	$extensions = '';
	$jpegSupport = false;
	$gifSupport = false;
	$pngSupport = false;
	if (function_exists('imagecreatefromjpeg')) {
		$extensions .= ',jpg,jpeg';
		$jpegSupport = true;
	}
	if (function_exists('imagecreatefromgif')) {
		$extensions .= ',gif';
		$gifSupport = true;
	}
	if (function_exists('imagecreatefrompng')) {
		$extensions .= ',png';
		$pngSupport = true;
	}
	
	// no gd-library found ..
	if (!$extensions) refresh_error($lang->get("LANG_ACP_OTHERSTUFF_THUMBNAILS_ERROR1"));
	
	$extensions = str_replace(",", "','", addslashes(wbb_substr($extensions, 1)));
	list($totalcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_attachments WHERE attachmentextension IN ('$extensions')");
	$pages = ceil($totalcount / $perpage);
	
	if ($page <= $pages) {
		refresh_start();
		$result = $db->query("SELECT attachmentid, attachmentextension, thumbnailextension FROM bb".$n."_attachments WHERE attachmentextension IN ('$extensions') ORDER BY attachmentid ASC", $perpage, $perpage * ($page - 1));		
		while ($row = $db->fetch_array($result)) {
			$thumbnail_type = '';
			$thumbnail = makeThumbnailImage('./../attachments/attachment-'.$row['attachmentid'].'.'.$row['attachmentextension'], $thumbnail_type, $thumbnailwidth, $thumbnailheight);
			
			// save thumbnail
			if ($thumbnail != '' && $thumbnail_type != '') {
				if ($row['thumbnailextension'] && $row['thumbnailextension'] != $thumbnail_type) @unlink('./../attachments/thumbnail-'.$row['attachmentid'].'.'.$row['thumbnailextension']);
				$fp = @fopen('./../attachments/thumbnail-'.$row['attachmentid'].'.'.$thumbnail_type, 'wb');
				@fwrite($fp, $thumbnail);
				@fclose($fp);
				@chmod('./../attachments/thumbnail-'.$row['attachmentid'].'.'.$thumbnail_type, 0777);
				$db->unbuffered_query("UPDATE bb".$n."_attachments SET thumbnailextension='".addslashes($thumbnail_type)."', thumbnailsize='".wbb_strlen($thumbnail)."' WHERE attachmentid='$row[attachmentid]'", 1);
			}
		}	
		refresh("otherstuff.php?sid=$session[hash]&action=thumbnails&perpage=$perpage&page=".($page + 1), $lang->items['LANG_ACP_OTHERSTUFF_THUMBNAILS'], round($page * $perpage / $totalcount * 100));
	}	
	else eval("\$tpl->output(\"".$tpl->get("working_done", 1)."\",1);");
}












/** adminsessions **/
if ($action == "adminsessions") {
	checkAdminPermissions("a_can_otherstuff_adminsessions", 1);
	if (isset($_POST['send'])) {
		checkAdminPermissions("a_can_otherstuff_adminsessions_kicksession", 1);
		if (isset($_POST['all']) && $_POST['all']) {
			$db->query("DELETE FROM bb".$n."_adminsessions WHERE lastactivity<='".(time() - $adminsession_timeout)."'");
			unset($_REQUEST['page']);
		}
		else {
			$kicksession = $_POST['kicksession'];
			if (is_array($kicksession) && count($kicksession)) {
				$sessionlist = str_replace(",", "','", implode(",", $kicksession));
				$db->query("DELETE FROM bb".$n."_adminsessions WHERE sessionhash IN ('$sessionlist') AND lastactivity<='".(time() - $adminsession_timeout)."'");	
			}
		}	
	}
	
	$perpage = 30;
	$sortby = $_REQUEST['sortby'];
	$sortorder = $_REQUEST['sortorder'];
	
	switch ($sortby) {
		case "username": break;
		case "starttime": break;
		case "lastactivity": break;
		case "ipaddress": break;
		case "useragent": break;
		default: $sortby = "starttime";
	}
	
	switch ($sortorder) {
		case "ASC": break;
		case "DESC": break;
		default: $sortorder = "DESC";
	}
	
	$page = intval($_REQUEST['page']);
	if ($page == 0) $page = 1;
	
	list($sessioncount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_adminsessions WHERE userid<>'0'");
	
	$pages = ceil($sessioncount / $perpage);
	if ($pages > 1) $pagelink = makePageLink("otherstuff.php?action=adminsessions&amp;sid=$session[hash]&amp;sortby=$sortby&amp;sortorder=$sortorder", $page, $pages, 2);
	else $pagelink = '';
	
	$offset = $perpage * ($page - 1);
	$result = $db->query("SELECT a.*, u.username FROM bb".$n."_adminsessions a LEFT JOIN bb".$n."_users u USING(userid) WHERE a.userid<>'0' ORDER BY $sortby $sortorder", $perpage, $offset);	
	$count = 0;
	while ($row = $db->fetch_array($result)) {
		if ($row['lastactivity'] > time() - $adminsession_timeout) $disabled = " disabled=\"disabled\"";
		else $disabled = '';
		
		$row['starttime'] = formatdate($wbbuserdata['dateformat']." ".$wbbuserdata['timeformat'], $row['starttime']);
		$row['lastactivity'] = formatdate($wbbuserdata['dateformat']." ".$wbbuserdata['timeformat'], $row['lastactivity']);
		if (wbb_strlen($row['useragent']) > 50) $row['useragent'] = wbb_substr($row['useragent'], 0, 48)."...";
		$rowclass = getone($count++, "firstrow", "secondrow");
		$row['username'] = htmlconverter($row['username']);
		$row['useragent'] = htmlconverter($row['useragent']);
		$row['ipaddress'] = htmlconverter($row['ipaddress']);
		eval("\$sessionbit .= \"".$tpl->get("adminsession_bit", 1)."\";");
	}
	
	$s_sortby[$sortby] = " selected=\"selected\"";
	$s_sortorder[$sortorder] = " selected=\"selected\"";
	
	eval("\$tpl->output(\"".$tpl->get("adminsessions", 1)."\",1);");
}








/** mailqueue: overview **/
if ($action == "mailqueue") {
	checkAdminPermissions("a_can_users_email", 1);
 	
 	if (isset($_REQUEST['deleteid'])) {
 		$deleteid = intval($_REQUEST['deleteid']);
 		$db->unbuffered_query("DELETE FROM bb".$n."_mails WHERE mailid='$deleteid'", 1);
 		$db->unbuffered_query("DELETE FROM bb".$n."_mailqueue WHERE mailid='$deleteid'", 1);
 		unset($deleteid);
 	}
 	
	$count = 0;
	$mailqueue_bit = '';
	$result = $db->query("SELECT m.*, u.username, COUNT(q.userid) as recipients_left FROM bb".$n."_mails m LEFT JOIN bb".$n."_users u USING (userid) LEFT JOIN bb".$n."_mailqueue q ON (q.mailid=m.mailid) GROUP BY m.mailid ORDER BY m.sendtime DESC");
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count++, "firstrow", "secondrow");
		if ($row['subject'] == '') $row['subject'] = '---';
		$row['username'] = htmlconverter($row['username']);
		$row['subject'] = htmlconverter($row['subject']);
		$senddate = formatdate($wbbuserdata['dateformat'], $row['sendtime'], 1);
		$sendtime = formatdate($wbbuserdata['timeformat'], $row['sendtime']);
		if ($row['recipients'] > 0) $percent = round((($row['recipients'] - $row['recipients_left']) / $row['recipients']) * 100);
		else $percent = 100;
		$finished = ($row['recipients_left'] == 0);
		eval("\$mailqueue_bit .= \"".$tpl->get("mailqueue_bit", 1)."\";");
	}
	
 	eval("\$tpl->output(\"".$tpl->get("mailqueue", 1)."\",1);");
}






/** mailqueue: read email **/
if ($action == "mailqueue_read") {
	checkAdminPermissions("a_can_users_email", 1);

	$mailid = intval($_GET['mailid']);
	$mail_info = $db->query_first("SELECT m.*, u.username, COUNT(q.userid) as recipients_left FROM bb".$n."_mails m LEFT JOIN bb".$n."_users u USING (userid) LEFT JOIN bb".$n."_mailqueue q ON (q.mailid=m.mailid) WHERE m.mailid='$mailid' GROUP BY m.mailid");
	
	$senddate = formatdate($wbbuserdata['dateformat'], $mail_info['sendtime']);
	$sendtime = formatdate($wbbuserdata['timeformat'], $mail_info['sendtime']);
	if ($mail_info['recipients'] > 0) $percent = round((($mail_info['recipients'] - $mail_info['recipients_left']) / $mail_info['recipients']) * 100);
	else $percent = 100;
	$mail_info['subject'] = htmlconverter($mail_info['subject']);
	$mail_info['message'] = nl2br(htmlconverter(strtr($mail_info['message'], array('{username}' => $wbbuserdata['username'], '$username' => $wbbuserdata['username']))));
	$mail_info['username'] = htmlconverter($mail_info['username']);

	eval("\$tpl->output(\"".$tpl->get("mailqueue_read", 1)."\",1);");
	
}






/** dump staggered database backup **/
if ($action == "dbbackup") {
	checkAdminPermissions('a_can_database_backup', 1);
	
	if (isset($_REQUEST['perpage'])) $perpage = intval($_REQUEST['perpage']);
	else $perpage = 0;
	if ($perpage == 0) $perpage = 1;
	
	if (isset($_REQUEST['totalpage'])) $totalpage = intval($_REQUEST['totalpage']);
	else $totalpage = 0;
	if (isset($_REQUEST['page'])) $page = intval($_REQUEST['page']);
	else $page = 0;
	if ($page == 0) $page = $totalpage = 1;
	
	// calculate total rows
	$totalpages = 0;
	foreach ($_POST['tables'] as $table) {
		list($rowCount) = $db->query_first("SELECT COUNT(*) FROM ".$table);
		if ($rowCount) {
			$totalpages += ceil($rowCount / $perpage) + 1;
		}
		else {
			$totalpages++;
		}
	}
	
	// get actual table
	$table = $_POST['tables'][$_POST['table']];
	list($rowCount) = $db->query_first("SELECT COUNT(*) FROM ".$table);
	$pages = ceil($rowCount / $perpage);
	if ($_POST['table'] + 1 < count($_POST['tables'])) $nextTable = $_POST['table'] + 1;
	else $nextTable = 0;
	
	// get backup filename
	if (isset($_POST['use_gz']) && $_POST['use_gz'] && function_exists("gzopen")) $use_gz = 1;
	else $use_gz = 0;
	$filename = $_POST['filename'];
	
	// backup not yet complete
	if ($page <= $pages || $nextTable) {
		// open backup file
		if ($use_gz) $fp = @gzopen($filename, "a1b");
		else $fp = @fopen($filename, "a+b");	

		// export structure
		if ($_POST['newTable'] == 1 && $_POST['structure'] == 1) {
			@wbbfwrite($fp, dumpTableStructure($table, $_POST['drop_table']));
		}
		// delete all
		elseif ($_POST['newTable'] == 1 && $_POST['delete_all'] == 1) {
			@wbbfwrite($fp, "DELETE FROM $table;\n\n");
		}
		
		// there are still rows to dump in this table
		if ($page <= $pages) {
			// dump table data
			dumpTableData($table, $fp, $perpage, $perpage * ($page - 1));		
			
			// prepare for next loop
			$newTable = 0;
			$table = $_POST['table'];
		}
		
		// this table is done, proceed to the next
		elseif ($nextTable) {
			$table = $nextTable;
			$newTable = 1;
			$page = 0;
			
			@wbbfwrite($fp, "\n\n\n\n");
		}


  		$page++;
  		$totalpage++;
  		$taskname = $lang->get("LANG_ACP_OTHERSTUFF_DBBACKUP");
  		$percent = round($totalpage / $totalpages * 100);
    
		$tables = '';
		foreach ($_POST['tables'] as $val) {
			$tables .= makeoption($val, $val, $_POST['tables']);	
		}
    
    
    		// close backup file
		@wbbfclose($fp);
		eval("\$tpl->output(\"".$tpl->get("refresh_dbbackup", 1)."\",1);");
	}
	// backup completly done	
	else {
		
		eval("\$tpl->output(\"".$tpl->get("working_dbbackupdone", 1)."\",1);");

	}
}












/** stats **/
if ($action == "selectstats") {
	checkAdminPermissions("a_can_otherstuff_stats", 1);
	
	$installday = date("j", $installdate);
	$installmonth = date("n", $installdate);
	$installyear = date("Y", $installdate);
	$currentyear = date("Y");
	$currentday = date("j");
	$currentmonth = date("n");
	
	$from_day = "";
	$from_month = "";
	$from_year = "";
	
	for ($i = 1; $i < 32; $i++) $from_day .= makeoption($i, $i, $installday);
	for ($i = 1; $i < 13; $i++) $from_month .= makeoption($i, getmonth($i), $installmonth);
	for ($i = $installyear; $i <= $currentyear; $i++) $from_year .= makeoption($i, $i, $installyear);
	
	$to_day = "";
	$to_month = "";
	$to_year = "";
	
	for ($i = 1; $i < 32; $i++) $to_day .= makeoption($i, $i, $currentday);
	for ($i = 1; $i < 13; $i++) $to_month .= makeoption($i, getmonth($i), $currentmonth);
	for ($i = $installyear; $i <= $currentyear; $i++) $to_year .= makeoption($i, $i, $currentyear);
	
	eval("\$tpl->output(\"".$tpl->get("stats_select", 1)."\",1);");
}

if ($action == "showstats") {
	checkAdminPermissions("a_can_otherstuff_stats", 1);
	switch ($_REQUEST['type']) {
		case 1: 
			$table = "bb".$n."_users";
			$datefield = "regdate";
			$stats_name = $lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TYPE1'];
		break;
		case 2: 
			$table = "bb".$n."_threads";
			$datefield = "starttime";
			$stats_name = $lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TYPE2'];
		break;
		case 3: 
			$table = "bb".$n."_posts";
			$datefield = "posttime";
			$stats_name = $lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TYPE3'];
		break;
		case 4: 
			$table = "bb".$n."_polls";
			$datefield = "starttime";
			$stats_name = $lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TYPE4'];
		break;
		default: 
			$table = "bb".$n."_privatemessage";
			$datefield = "sendtime";
			$stats_name = $lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TYPE5'];
	}
	
	switch ($_POST['timeorder']) {
		case 1:
			$sqlformat = "%w %U %m %Y";
			$phpformat = "w~, ".$wbbuserdata['dateformat'];
		break;
		case 2:
			$sqlformat = "%U %Y";
			$phpformat = "# (n~ Y)";
		break;
		default:
			$sqlformat = "%m %Y";
			$phpformat = "n~ Y";
	}
	
	switch ($_POST['sortorder']) {
		case "asc": break;
		default: $_POST['sortorder'] = "desc";
	}
	
	$to = mktime(24, 0, 0, $_POST['to_month'], $_POST['to_day'], $_POST['to_year']);
	$from = mktime(0, 0, 0, $_POST['from_month'], $_POST['from_day'], $_POST['from_year']);
	
	
	
	$max = 0;
	$cache = array();
	$result = $db->query("SELECT COUNT(*), DATE_FORMAT(FROM_UNIXTIME($datefield),'$sqlformat') AS timeorder, MAX($datefield) AS statdate FROM $table WHERE $datefield > '$from' AND $datefield < '$to' GROUP BY timeorder ORDER BY $datefield $_POST[sortorder]");
	while ($row = $db->fetch_array($result)) {
		$statdate = date($phpformat, $row['statdate']);
		
		if ($_POST['timeorder'] == 1) $statdate = preg_replace("/(\d+)~/e", "getday('\\1')", $statdate);
		if ($_POST['timeorder'] > 1) $statdate = preg_replace("/(\d+)~/e", "getmonth('\\1')", $statdate);
		if ($_POST['timeorder'] == 2) {
			$week = ceil((date('z', $row['statdate']) - daynumber($row['statdate'])) / 7) + ((daynumber(mktime(0, 0, 0, 1, 1, date('Y', $row['statdate']))) <= 3) ? (1) : (0));
			if ($week == 53 && daynumber(mktime(0, 0, 0, 12, 31, date('Y', $row['statdate']))) < 3) {
				$tempRow = $db->fetch_array($result);
				$row[0] += $tempRow[0];
				$week = 1;
			}
			$statdate = str_replace("#", "#".$week, $statdate);
		}
			
		if ($row[0] > $max) $max = $row[0];
		$cache[] = array($row[0], $statdate);
	}
	
	$showbit = '';
	if (count($cache)) {
		while (list($key, $stat) = each($cache)) {
			$width = round($stat[0] / $max * 500);
			eval("\$showbit .= \"".$tpl->get("stats_showbit", 1)."\";");
		}
	}
	
	eval("\$tpl->output(\"".$tpl->get("stats_show", 1)."\",1);");
}


















/** acpsettings **/
if ($action == "acpsettings") {
	if (isSet($_POST['send'])) {
		$db->query("UPDATE bb".$n."_users SET acpmode='".intval($_POST['acpmode'])."', acppersonalmenu='".intval($_POST['acppersonalmenu'])."', acpmenumarkfirst='".intval($_POST['acpmenumarkfirst'])."', acpmenuhidelast='".intval($_POST['acpmenuhidelast'])."' WHERE userid='".$wbbuserdata['userid']."'");
		$wbbuserdata['acpmode'] = intval($_POST['acpmode']);
		$wbbuserdata['acppersonalmenu'] = intval($_POST['acppersonalmenu']);
		$wbbuserdata['acpmenumarkfirst'] = intval($_POST['acpmenumarkfirst']);
		$wbbuserdata['acpmenuhidelast'] = intval($_POST['acpmenuhidelast']);
	}
	
	eval("\$tpl->output(\"".$tpl->get("acpsettings", 1)."\",1);");
}
?>
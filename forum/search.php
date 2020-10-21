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


$filename = 'search.php';
@set_time_limit(0);
require('./global.php');

if (!$wbbuserdata['can_use_search']) access_error();
$lang->load('SEARCH');

if (!isset($_GET['action'])) $_GET['action'] = '';


/**
* @return boardids string
* @desc returns the boards to which the current user has access.
*/
function getSearchableBoards() {
	global $db, $n, $wbbuserdata, $boardcache;
	
	if (!isset($boardcache) || !is_array($boardcache)) $boardcache = array();
	$result = $db->query("SELECT boardid,boardorder,parentid,parentlist FROM bb".$n."_boards ORDER BY parentid ASC, boardorder ASC");
	while ($row = $db->fetch_array($result)) {
		$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
	}

	$boardpermissions = getPermissions();
	$boardids = '';
	foreach ($boardcache as $key => $val) {
		foreach ($val as $key2 => $val2) {
			foreach ($val2 as $row) if (!isset($boardpermissions[$row['boardid']]['can_use_search']) || $boardpermissions[$row['boardid']]['can_use_search'] != 0) $boardids .= ",".$row['boardid'];
		}	
	}
	return $boardids;
}


/**
* @return queryhash string
* @desc returns the hash of a particular search query
*/
function getQueryHash($postIDs, $showPosts, $sortBy, $sortOrder, $userID, $ipAddress) {
	return md5($postIDs . "\n" . $showPosts . "\n" . $sortBy . "\n" . $sortOrder . "\n" . $userID . "\n" . $ipAddress);
}


/* new posts */
if ($_GET['action'] == 'new') {
	$boardids = '';
	list($boardcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_boards");
	
	$result = $db->query("SELECT boardid FROM bb".$n."_boards WHERE password='' AND boardid IN (0".getSearchableBoards().")");
	if ($db->num_rows($result) < $boardcount) {
		while ($row = $db->fetch_array($result)) {
			if ($boardids != '') $boardids .= ','.$row['boardid'];
			else $boardids = $row['boardid'];
		}
		if (!$boardids) error($lang->get("LANG_GLOBAL_ERROR_SEARCHNORESULT"));
	}
	
	$savepostids = '';
	$result = $db->unbuffered_query("SELECT p.postid FROM bb".$n."_posts p, bb".$n."_threads t WHERE p.threadid=t.threadid AND p.visible=1 AND p.posttime>'$wbbuserdata[lastvisit]'
	".(($boardids) ? ("AND t.boardid IN ($boardids)") : ("")));
	while ($row = $db->fetch_array($result)) $savepostids .= ','.$row['postid'];
	
	if (!$savepostids) error($lang->get("LANG_GLOBAL_ERROR_SEARCHNORESULT"));
	$result = $db->query_first("SELECT searchid FROM bb".$n."_searchs WHERE searchhash = '".getQueryHash($savepostids, 0, 'lastpost', 'desc', $wbbuserdata['userid'], $REMOTE_ADDR)."'");
	if ($result['searchid']) {
		header("Location: search.php?searchid=".$result['searchid'].$SID_ARG_2ND_UN);
		exit();
	}
	$db->query("INSERT INTO bb".$n."_searchs (searchhash,postids,showposts,sortby,sortorder,searchtime,userid,ipaddress)
	VALUES ('".getQueryHash($savepostids, 0, 'lastpost', 'desc', $wbbuserdata['userid'], $REMOTE_ADDR)."','$savepostids','0','lastpost','desc','".time()."','$wbbuserdata[userid]','$REMOTE_ADDR')");
	$searchid = $db->insert_id();
	
	header("Location: search.php?searchid=$searchid".$SID_ARG_2ND_UN);
	exit(); 	
}

/* new threads 24h */
if ($_GET['action'] == '24h') {
	$boardids = '';
	list($boardcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_boards");
	
	$result = $db->query("SELECT boardid FROM bb".$n."_boards WHERE password='' AND boardid IN (0".getSearchableBoards().")");
	if ($db->num_rows($result) < $boardcount) {
		while ($row = $db->fetch_array($result)) {
			if ($boardids != '') $boardids .= ','.$row['boardid'];
			else $boardids = $row['boardid'];
		}
		if (!$boardids) error($lang->get("LANG_GLOBAL_ERROR_SEARCHNORESULT"));
	}	
	
	$savepostids = '';
	$datecute = time() - 86400;
	$result = $db->unbuffered_query("SELECT p.postid FROM bb".$n."_posts p, bb".$n."_threads t WHERE p.threadid=t.threadid AND p.visible=1 AND p.posttime>'$datecute'
	".(($boardids) ? ("AND t.boardid IN ($boardids)") : ("")));
	while ($row = $db->fetch_array($result)) $savepostids .= ','.$row['postid'];
	
	if (!$savepostids) error($lang->get("LANG_GLOBAL_ERROR_SEARCHNORESULT"));
	$result = $db->query_first("SELECT searchid FROM bb".$n."_searchs WHERE searchhash = '".getQueryHash($savepostids, 0, 'lastpost', 'desc', $wbbuserdata['userid'], $REMOTE_ADDR)."'");
	if ($result['searchid']) {
		header("Location: search.php?searchid=".$result['searchid'].$SID_ARG_2ND_UN);
		exit();
	}
	$db->query("INSERT INTO bb".$n."_searchs (searchhash,postids,showposts,sortby,sortorder,searchtime,userid,ipaddress)
	VALUES ('".getQueryHash($savepostids, 0, 'lastpost', 'desc', $wbbuserdata['userid'], $REMOTE_ADDR)."','$savepostids','0','lastpost','desc','".time()."','$wbbuserdata[userid]','$REMOTE_ADDR')");
	$searchid = $db->insert_id();
	
	header("Location: search.php?searchid=$searchid".$SID_ARG_2ND_UN);
	exit(); 	
}

/* userposts */
if ($_GET['action'] == 'user') {
	if (!isset($_GET['userid'])) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
	
	$boardids = '';
	list($boardcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_boards");
	
	$result = $db->query("SELECT boardid FROM bb".$n."_boards WHERE password='' AND boardid IN (0".getSearchableBoards().")");
	if ($db->num_rows($result) < $boardcount) {
		while ($row = $db->fetch_array($result)) {
			if ($boardids != '') $boardids .= ','.$row['boardid'];
			else $boardids = $row['boardid'];
		}
		if (!$boardids) error($lang->get("LANG_GLOBAL_ERROR_SEARCHNORESULT"));
	}	
	
	$savepostids = '';
	$userid = intval($_GET['userid']);
	$result = $db->unbuffered_query("SELECT p.postid FROM bb".$n."_posts p, bb".$n."_threads t WHERE p.threadid=t.threadid AND p.visible=1 AND p.userid='$userid'
	".(($boardids) ? ("AND t.boardid IN ($boardids)") : ("")));
	while ($row = $db->fetch_array($result)) $savepostids .= ','.$row['postid'];
	
	if (!$savepostids) error($lang->get("LANG_GLOBAL_ERROR_SEARCHNORESULT"));
	$result = $db->query_first("SELECT searchid FROM bb".$n."_searchs WHERE searchhash = '".getQueryHash($savepostids, 1, 'lastpost', 'desc', $wbbuserdata['userid'], $REMOTE_ADDR)."'");
	if ($result['searchid']) {
		header("Location: search.php?searchid=".$result['searchid'].$SID_ARG_2ND_UN);
		exit();
	}
	$db->query("INSERT INTO bb".$n."_searchs (searchhash,postids,showposts,sortby,sortorder,searchtime,userid,ipaddress)
	VALUES ('".getQueryHash($savepostids, 1, 'lastpost', 'desc', $wbbuserdata['userid'], $REMOTE_ADDR)."','$savepostids','1','lastpost','desc','".time()."','$wbbuserdata[userid]','$REMOTE_ADDR')");
	$searchid = $db->insert_id();
	
	header("Location: search.php?searchid=$searchid".$SID_ARG_2ND_UN);
	exit();	
}

/* threads with polls */
if ($_GET['action'] == 'polls') {
	$boardids = '';
	list($boardcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_boards");
	
	$result = $db->query("SELECT threadid FROM bb".$n."_polls WHERE timeout = 0 OR starttime + 86400 * timeout > '".time()."'");
	$threadIDs = '';
	while ($row = $db->fetch_array($result)) {
		$threadIDs .= "," . $row['threadid'];
	}
	if (!$threadIDs) error($lang->get("LANG_GLOBAL_ERROR_SEARCHNORESULT"));
		
	$result = $db->query("SELECT boardid FROM bb".$n."_boards WHERE password='' AND boardid IN (0".getSearchableBoards().")");
	if ($db->num_rows($result) < $boardcount) {
		while ($row = $db->fetch_array($result)) {
			if ($boardids != '') $boardids .= ','.$row['boardid'];
			else $boardids = $row['boardid'];
		}
		if (!$boardids) error($lang->get("LANG_GLOBAL_ERROR_SEARCHNORESULT"));
	}	
	
	$savepostids = '';
	$time = time();
	$datecute = $time - 86400;
	$result = $db->unbuffered_query("SELECT p.postid FROM bb".$n."_posts p, bb".$n."_threads t WHERE p.threadid=t.threadid AND t.threadid IN (0".$threadIDs.") AND p.visible=1 
	".(($boardids) ? ("AND t.boardid IN ($boardids)") : ("")));
	while ($row = $db->fetch_array($result)) {
		$savepostids .= ','.$row['postid'];
	}
	
	if (!$savepostids) error($lang->get("LANG_GLOBAL_ERROR_SEARCHNORESULT"));
	$result = $db->query_first("SELECT searchid FROM bb".$n."_searchs WHERE searchhash = '".getQueryHash($savepostids, 0, 'lastpost', 'desc', $wbbuserdata['userid'], $REMOTE_ADDR)."'");
	if ($result['searchid']) {
		header("Location: search.php?searchid=".$result['searchid'].$SID_ARG_2ND_UN);
		exit();
	}
	$db->query("INSERT INTO bb".$n."_searchs (searchhash,postids,showposts,sortby,sortorder,searchtime,userid,ipaddress)
	VALUES ('".getQueryHash($savepostids, 0, 'lastpost', 'desc', $wbbuserdata['userid'], $REMOTE_ADDR)."','$savepostids','0','lastpost','desc','".time()."','$wbbuserdata[userid]','$REMOTE_ADDR')");
	$searchid = $db->insert_id();
	
	header("Location: search.php?searchid=$searchid".$SID_ARG_2ND_UN);
	exit();	
}

if (isset($_GET['searchid'])) {
	require('./acp/lib/class_parse.php');
	
	$searchid = intval($_GET['searchid']);
	if ($wbbuserdata['userid']) $search = $db->query_first("SELECT * FROM bb".$n."_searchs WHERE searchid='$searchid' AND userid='$wbbuserdata[userid]'");
	else $search = $db->query_first("SELECT * FROM bb".$n."_searchs WHERE searchid='$searchid' AND ipaddress='$REMOTE_ADDR'");
	
	if (!$search['searchid']) access_error();
	
	if ($search['showposts'] == 1) {
		$lang->load('THREAD');
		
		switch ($search['sortby']) {
			case "topic": $sortby = "p.posttopic"; break;
			case "replycount": $sortby = "t.replycount"; break;
			case "lastpost": $sortby = "p.posttime"; break;
			case "author": $sortby = "p.username"; break;
			case "board": $sortby = "b.title";
			case "views": $sortby = "t.views";
			default: $sortby = "p.posttime"; break;
		}
		
		switch ($search['sortorder']) {
			case "asc": $sortorder = "asc"; break;
			case "desc": $sortorder = "desc"; break;
			default: $sortorder = "desc"; break;
		}
		
		list($postcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_posts WHERE postid IN (0$search[postids])");
		
		if ($wbbuserdata['umaxposts']) $postsperpage = $wbbuserdata['umaxposts'];
		else $postsperpage = $default_postsperpage;
		if (isset($_GET['page'])) {
			$page = intval($_GET['page']);
			if ($page == 0) $page = 1;
		}
		else $page = 1;
		$pages = ceil($postcount / $postsperpage);
		if ($pages > 1) $pagelink = makepagelink("search.php?searchid=$searchid".$SID_ARG_2ND, $page, $pages, $showpagelinks - 1);
		
		$l_posts = ($page - 1) * $postsperpage + 1;
		$h_posts = $page * $postsperpage;
		if ($h_posts > $postcount) $h_posts = $postcount;
		
		$threadjoin = '';
		$boardjoin = '';
		if (strstr($sortby, 't.') || strstr($sortby, 'b.')) $threadjoin = "LEFT JOIN bb".$n."_threads t USING (threadid)";
		if (strstr($sortby, 'b.')) $boardjoin = "LEFT JOIN bb".$n."_boards b USING (boardid)";
		
		$postids = '';
		$result = $db->unbuffered_query("SELECT p.postid FROM bb".$n."_posts p
		$threadjoin
		$boardjoin
		WHERE p.postid IN (0$search[postids])
		ORDER BY $sortby $sortorder", 0, $postsperpage, $postsperpage * ($page - 1));
		
		while ($row = $db->fetch_array($result)) $postids .= ",".$row[postid];
		
		$parse = &new parse($docensor, 75, $wbbuserdata['showimages'], $search['searchstring'], $usecode);
		$result = $db->query("SELECT
		p.*,
		t.topic, t.replycount, t.views, t.boardid, t.lastposttime, t.closed, t.prefix, 
		b.title, b.hotthread_reply, b.hotthread_view,
		i.iconpath, i.icontitle
		".(($wbbuserdata['userid']) ? (", bv.lastvisit AS boardlastvisit, tv.lastvisit AS threadlastvisit") : (""))."
		FROM bb".$n."_posts p
		LEFT JOIN bb".$n."_threads t USING (threadid)
		LEFT JOIN bb".$n."_boards b USING (boardid)
		LEFT JOIN bb".$n."_icons i ON (p.iconid=i.iconid)
		".(($wbbuserdata['userid']) ? ("LEFT JOIN bb".$n."_boardvisit bv ON (bv.boardid=b.boardid AND bv.userid='".$wbbuserdata['userid']."') LEFT JOIN bb".$n."_threadvisit tv ON (tv.threadid=t.threadid AND tv.userid='".$wbbuserdata['userid']."')") : (""))."
		WHERE p.postid IN (0$postids)
		ORDER BY $sortby $sortorder");
		
		$count = 0;
		$postbit = '';
		while ($posts = $db->fetch_array($result)) {
			$tdclass = getone($count, "tablea", "tableb");
			
			if ($posts['hotthread_reply'] == 0) $posts['hotthread_reply'] = $default_hotthread_reply;
			if ($posts['hotthread_view'] == 0) $posts['hotthread_view'] = $default_hotthread_view;
			
			if ($posts['boardlastvisit'] > $posts['threadlastvisit']) $posts['threadlastvisit'] = $posts['boardlastvisit'];
			if ($wbbuserdata['lastvisit'] > $posts['threadlastvisit']) $posts['threadlastvisit'] = $wbbuserdata['lastvisit'];
			
			$foldericon = (($posts['lastposttime'] > $posts['threadlastvisit']) ? ("new") : ("")).(($posts['replycount'] >= $posts['hotthread_reply'] || $posts['views'] >= $posts['hotthread_view']) ? ("hot") : ("")).(($posts['closed'] != 0) ? ("lock") : (""))."folder";
			
			$posts['message'] = $parse->doparse($posts['message'], $posts['allowsmilies'], $posts['allowhtml'], $posts['allowbbcode'], $posts['allowimages']);
			$posts['posttopic'] = htmlconverter(textwrap($posts['posttopic']));
			$posts['topic'] = htmlconverter(textwrap($posts['topic']));
			$posts['username'] = htmlconverter($posts['username']);
			
			if ($posts['iconid']) $posticon = makeimgtag($posts['iconpath'], getlangvar($posts['icontitle'], $lang), 0);
			else $posticon = '';
			if ($posts['lastposttime'] > $posts['threadlastvisit']) $newpost = 1;
			else $newpost = 0;
			$postdate = formatdate($wbbuserdata['dateformat'], $posts['posttime'], 1);
			$posttime = formatdate($wbbuserdata['timeformat'], $posts['posttime']);
			
			if ($posts['replycount'] >= 1000) $posts['replycount'] = number_format($posts['replycount'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
			if ($posts['views'] >= 1000) $posts['views'] = number_format($posts['views'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
			
			$posts['title'] = getlangvar($posts['title'], $lang);
			
			eval("\$postbit .= \"".$tpl->get("search_postbit")."\";");
			$count++;
		}
		
		$lang->items['LANG_SEARCH_RESULT_HITS_POSTS'] = $lang->get("LANG_SEARCH_RESULT_HITS_POSTS", array('$l_posts' => number_format($l_posts, 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP")), '$h_posts' => number_format($h_posts, 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP")), '$postcount' => number_format($postcount, 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"))));
		eval("\$tpl->output(\"".$tpl->get("search_post")."\");");
	}
	else {
		$lang->load("BOARD");
		$board['allowratings'] = 1;
		
		switch ($search['sortby']) {
			case "topic": $sortby = "t.topic"; break;
			case "replycount": $sortby = "t.replycount"; break;
			case "lastpost": $sortby = "t.lastposttime"; break;
			case "author": $sortby = "t.starter"; break;
			case "board": $sortby = "b.title";
			case "views": $sortby = "t.views";
			default: $sortby = "t.lastposttime"; break;
		}
		
		switch ($search['sortorder']) {
			case "asc": $sortorder = "asc"; break;
			case "desc": $sortorder = "desc"; break;
			default: $sortorder = "desc"; break;
		}
		
		$search['searchstring'] = urlencode($search['searchstring']);
		
		$threadids = '';
		$result = $db->query("SELECT DISTINCT threadid FROM bb".$n."_posts WHERE postid IN (0$search[postids])");
		$threadcount = $db->num_rows($result);
		while ($row = $db->fetch_array($result)) $threadids .= ','.$row['threadid'];
		
		$threadsperpage = $default_threadsperpage;
		if (isset($_GET['page'])) {
			$page = intval($_GET['page']);
			if ($page == 0) $page = 1;
		}
		else $page = 1;
		$pages = ceil($threadcount / $threadsperpage);
		if ($pages > 1) $pagelink = makepagelink("search.php?searchid=$searchid".$SID_ARG_2ND, $page, $pages, $showpagelinks - 1);
		
		$result = $db->unbuffered_query("SELECT t.threadid FROM bb".$n."_threads t
		".(($sortby == "f.title") ? ("LEFT JOIN bb".$b."_boards b USING (boardid)") : (""))."
		WHERE t.threadid IN (0$threadids)
		ORDER BY $sortby $sortorder", 0, $threadsperpage, $threadsperpage * ($page - 1));
		$threadids = '';
		while ($row = $db->fetch_array($result)) $threadids .= ','.$row['threadid'];
		
		if ($showown && $wbbuserdata['userid']) {
			$ownuserid = "DISTINCT p.userid,";
			$ownjoin = "LEFT JOIN bb".$n."_posts p ON (t.threadid = p.threadid AND p.userid = '$wbbuserdata[userid]')";
		}
		else {
			$ownuserid = "";
			$ownjoin = "";	
		}
		
		if ($wbbuserdata['userid']) {
			$vselect = ", bv.lastvisit AS boardlastvisit, tv.lastvisit AS threadlastvisit";
			$vjoin = " LEFT JOIN bb".$n."_boardvisit bv ON (bv.boardid=b.boardid AND bv.userid='".$wbbuserdata['userid']."') LEFT JOIN bb".$n."_threadvisit tv ON (tv.threadid=t.threadid AND tv.userid='".$wbbuserdata['userid']."')";
		}
		else {
			$vselect = '';
			$vjoin = '';
		}
		
		$result = $db->unbuffered_query("SELECT
		$ownuserid
		t.*,
		b.title, b.hotthread_reply, b.hotthread_view, b.postsperpage,
		i.*
		$vselect
		FROM bb".$n."_threads t
		LEFT JOIN bb".$n."_icons i USING (iconid)
		LEFT JOIN bb".$n."_boards b ON (b.boardid=t.boardid)
		$ownjoin
		$vjoin
		WHERE t.threadid IN (0$threadids)
		ORDER BY $sortby $sortorder");
		
		while ($threads = $db->fetch_array($result)) {
			unset($firstnew);
			unset($multipages);
			unset($attachments);
			$prefix = '';
			
			if ($threads['boardlastvisit'] > $threads['threadlastvisit']) $threads['threadlastvisit'] = $threads['boardlastvisit'];
			if ($wbbuserdata['lastvisit'] > $threads['threadlastvisit']) $threads['threadlastvisit'] = $wbbuserdata['lastvisit'];
			
			$threads['topic'] = htmlconverter(textwrap($threads['topic']));
			$threads['starter'] = htmlconverter(textwrap($threads['starter'], 25));
			$threads['lastposter'] = htmlconverter(textwrap($threads['lastposter'], 25));
			$threads['prefix'] = htmlconverter($threads['prefix']);
			
			if ($threads['voted'] && $threads['voted'] >= $showvotes) $threadrating = threadrating($threads['votepoints'], $threads['voted']);
			else $threadrating = "&nbsp;";	
			
			if ($threads['hotthread_reply'] == 0) $threads['hotthread_reply'] = $default_hotthread_reply;
			if ($threads['hotthread_view'] == 0) $threads['hotthread_view'] = $default_hotthread_view;
			
			if ($threads['important'] == 2) $foldericon = "announce";	
			else $foldericon = ((isset($threads['userid']) && $threads['userid']) ? ("dot") : ("")).(($threads['lastposttime'] > $threads['threadlastvisit']) ? ("new") : ("")).(($threads['replycount'] >= $threads['hotthread_reply'] || $threads['views'] >= $threads['hotthread_view']) ? ("hot") : ("")).(($threads['closed'] != 0) ? ("lock") : (""))."folder";
			if ($threads['lastposttime'] > $threads['threadlastvisit']) $firstnew = 1;
			
			if ($threads['pollid'] != 0) $threadicon = makeimgtag($style['imagefolder']."/poll.gif", "");
			elseif ($threads['iconid']) $threadicon = makeimgtag($threads['iconpath'], getlangvar($threads['icontitle'], $lang), 0);
			else $threadicon = "&nbsp;";
			
			$lastpostdate = formatdate($wbbuserdata['dateformat'], $threads['lastposttime'], 1);
			$lastposttime = formatdate($wbbuserdata['timeformat'], $threads['lastposttime']);
			
			if ($wbbuserdata['umaxposts']) $postsperpage = $wbbuserdata['umaxposts'];
			elseif ($threads['postsperpage']) $postsperpage = $threads['postsperpage'];
			else $postsperpage = $default_postsperpage;
			
			if ($threads['replycount'] + 1 > $postsperpage && $showmultipages != 0) {
				unset($multipage);
				unset($multipages_lastpage);
				$xpages = ceil(($threads['replycount'] + 1) / $postsperpage);
				if ($xpages > $showmultipages) {
					eval("\$multipages_lastpage = \"".$tpl->get("board_threadbit_multipages_lastpage")."\";");
					$xpages = $showmultipages;
				}
				for ($i = 1; $i <= $xpages; $i++) {
					$multipage .= " ".makehreftag("thread.php?threadid=".$threads['threadid']."&amp;hilight=".$search['searchstring']."&amp;hilightuser=".$search['searchuserid']."&amp;page=$i".$SID_ARG_2ND, $i);
				}
				eval("\$multipages = \"".$tpl->get("board_threadbit_multipages")."\";");
			}
			
			if ($threads['attachments']) $LANG_BOARD_ATTACHMENTS = $lang->get("LANG_BOARD_ATTACHMENTS", array('$attachments' => $threads['attachments']));
			
			if ($threads['replycount'] >= 1000) $threads['replycount'] = number_format($threads['replycount'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
			if ($threads['views'] >= 1000) $threads['views'] = number_format($threads['views'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
			
			$threads['title'] = getlangvar($threads['title'], $lang);
			
			eval("\$threadbit .= \"".$tpl->get("board_threadbit")."\";");
		}
		
		$l_threads = ($page - 1) * $threadsperpage + 1;
		$h_threads = $page * $threadsperpage;
		if ($h_threads > $threadcount) $h_threads = $threadcount;
		
		$lang->items['LANG_SEARCH_RESULT_HITS_THREADS'] = $lang->get("LANG_SEARCH_RESULT_HITS_THREADS", array('$l_threads' => number_format($l_threads, 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP")), '$h_threads' => number_format($h_threads, 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP")), '$threadcount' => number_format($threadcount, 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"))));
		eval("\$tpl->output(\"".$tpl->get("search_thread")."\");");
	}
}
else {
	if (isset($_POST['send'])) {
		$searchstring = wbb_trim($_POST['searchstring']);
		$searchuser = wbb_trim($_POST['searchuser']);
		$searchprefix = wbb_trim($_POST['searchprefix']);
		
		if (!$searchstring && !$searchuser) error($lang->get("LANG_SEARCH_ERROR_INVALIDSEARCH"));
				
		$postids = '';
		if ($searchstring) {
			$topiconly = $_POST['topiconly'];
			
			$searchstring = preg_replace("/( \+|^\+)/s", " AND ", $searchstring);
			$searchstring = preg_replace("/( \-|^\-)/s", " NOT ", $searchstring);
			$searchstring = preg_replace("/[\/,\.:;\(\)\[\]?!#{}%_\-+=\\\\]/s", " ", $searchstring);
			$searchstring = preg_replace("/['\"]/s", "", $searchstring);
			$searchstring = preg_replace("/\s{2,}/", " ", $searchstring);
			$tempsearchstring = $searchstring;
			$searchstring = str_replace("*", "%", $searchstring);
			$searchstring = preg_replace("/(%){2,}/s", "%", $searchstring);
			$searchwords = preg_split("/[\s]/", wbb_strtolower($searchstring), - 1, PREG_SPLIT_NO_EMPTY);
			
			$badwords = array();
			if ($badsearchwords) {
				$temp = explode("\n", wbb_strtolower($badsearchwords));
				while (list($key, $val) = each($temp)) $badwords[wbb_trim($val)] = 1;
			}
			
			$goodwords = array();
			if ($goodsearchwords) {
				$temp = explode("\n", wbb_strtolower($goodsearchwords));
				while (list($key, $val) = each($temp)) {
					unset($badwords[wbb_trim($val)]);
					$goodwords[wbb_trim($val)] = 1;
				}
			}			
			
			$count_total = 0;
			$count_bad = 0;
			$firstloop = 1;
			$addsplit = '';
			$wordids = '';
			$tempwordids = array();
			$wordidcache = array();
			$andlist = array();
			$orlist = array();
			$notlist = array();
			$tempwordids = array();
			$foundwordids = array();
			$wordcache = array();
			$doublecount = 0;
			$i = array("AND" => 0, "OR" => 0, "NOT" => 0);
			while (list($key, $val) = each($searchwords)) {
				if ($val == "and" || $val == "or" || $val == "not") {
					$addsplit = wbb_strtoupper($val);	
					continue;
				}
				
				$count_total++;   
				if ((!isset($goodwords[$val]) && !$goodwords[$val]) && ((isset($badwords[$val]) && $badwords[$val] == 1) || wbb_strlen($val) < $minwordlength || wbb_strlen($val) > $maxwordlength)) {
					$count_bad++;   
					continue;
				}   
				
				$result = $db->query("SELECT wordid FROM bb".$n."_wordlist WHERE word LIKE '$val'");
				if ($db->num_rows($result)) {
					while ($row = $db->fetch_array($result)) {
						if ($firstloop == 1) $tempwordids[] = $row['wordid'];
						else {
							if ($addsplit == '') $addsplit = "AND";
							$wordidcache[$addsplit][$i[$addsplit]][] = $row['wordid'];
							if (count($tempwordids)) {
								reset($tempwordids);
								$doublecount = 1;
								while (list($key2, $wordid) = each($tempwordids)) {
									if ($addsplit == "NOT") $wordidcache['AND'][$i[$addsplit] + 1][] = $wordid;
									else $wordidcache[$addsplit][$i[$addsplit] + 1][] = $wordid;
								}
								$tempwordids = array();
							}
						}
						$wordids .= ",".$row['wordid'];
					}
					$firstloop = 0;
				}
				elseif ($firstloop == 0 && $addsplit == "AND") {
					unset($wordids);
					break;
				}
				
				
				if ($doublecount == 1) {
					$i[$addsplit]++;
					$doublecount = 0;
				}
				$i[$addsplit]++;
			}
			
			if ($count_bad > 0 && $count_bad == $count_total) error($lang->get("LANG_SEARCH_ERROR_SEARCHBAD", array('$minwordlength' => $minwordlength, '$maxwordlength' => $maxwordlength)));
						
			if (count($tempwordids)) {
				reset($tempwordids);
				while (list($key2, $wordid) = each($tempwordids)) $wordidcache['AND'][$i[$addsplit]][] = $wordid;
			}
			
			$foundpostids = array();
			if ($wordids) {
				$result = $db->unbuffered_query("SELECT wordid, postid FROM bb".$n."_wordmatch WHERE wordid IN (0$wordids)".(($topiconly == 1) ? (" AND intopic=1") : ("")));
				while ($row = $db->fetch_array($result)) {
					$foundpostids[$row['wordid']][$row['postid']] = 1;
				}
			}
			
			function myArrayMerge($array, $add) {
				while (list($key, $val) = each($add)) $array[$key] = $val;
				return $array;	
			}
			
			function mySearchArray($array, $add, $mode) {
				if ($mode == "OR") return myArrayMerge($array, $add);
				if ($mode == "AND") {
					$newarray = array();
					while (list($key, $val) = each($array)) if ($add[$key] == 1) $newarray[$key] = 1;
					return $newarray;
				}
				if ($mode == "NOT") {
					while (list($key, $val) = each($add)) if ($array[$key] == 1) $array[$key] = 0;
					return $array;	
				}
			}
			
			$globalarray = array();
			$addsplit = array("AND", "OR", "NOT");
			for ($i = 0; $i < 3; $i++) {
				$savearray = array();
				$count = 0;
				if (count($wordidcache[$addsplit[$i]])) {
					reset($wordidcache[$addsplit[$i]]);
					while (list($key, $wordids) = each($wordidcache[$addsplit[$i]])) {
						$savearray[$count] = array();
						$badx = 1;
						while (list($key2, $wordid) = each($wordids)) {
							if (isset($foundpostids[$wordid])) {
								$badx = 0;
								$savearray[$count] = myArrayMerge($savearray[$count], $foundpostids[$wordid]);
							}
						}
						
						if ($badx == 0) {
							if (!count($globalarray)) $globalarray = $savearray[$count];
							else $globalarray = mySearchArray($globalarray, $savearray[$count], $addsplit[$i]);
						}
						
						$count++;
					}
				}
			}
			
			$postids = '';
			while (list($key, $val) = each($globalarray)) {
				if ($val != 1) continue;
				if ($postids == '') $postids = $key;
				else $postids .= ",$key";	
			}
		}
		
		if ($searchuser) {
			$userids = '';
			if ($_POST['name_exactly'] == 1) $result = $db->unbuffered_query("SELECT userid FROM bb".$n."_users WHERE username='".addslashes($searchuser)."'");
			else $result = $db->unbuffered_query("SELECT userid FROM bb".$n."_users WHERE username LIKE '%".addslashes($searchuser)."%'");
			while ($row = $db->fetch_array($result)) {
				if ($userids != '') $userids .= ','.$row['userid'];
				else $userids = $row['userid'];
			}
		}
		
		if (!$userids && !$postids) error($lang->get("LANG_GLOBAL_ERROR_SEARCHNORESULT"));
		
		if ($_POST['searchdate']) {
			$cutetime = time() - 86400 * intval($_POST['searchdate']);
			if ($_POST['beforeafter'] == "after") $searchdate = "posttime>='$cutetime'";
			else $searchdate = "posttime<'$cutetime'";
		}
		if (isset($_POST['boardids']) && is_array($_POST['boardids'])) {
			reset($_POST['boardids']);
			if (count($_POST['boardids']) && $_POST['boardids'][0] != '*') {
				$tempids = '';
				while (list($key, $val) = each($_POST['boardids'])) if ($val > 0) $tempids .= ",".$val;
				if ($tempids) {
					$result = $db->unbuffered_query("SELECT boardid, childlist FROM bb".$n."_boards WHERE boardid IN (0$tempids)");
					$selectedids = '';
					while ($row = $db->fetch_array($result)) {
						$selectedids .= ",".$row['boardid'];
						if ($row['childlist']) $selectedids .= ",".$row['childlist'];
					}
				}
			}
		}
		
		$boardids = '';
		list($boardcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_boards");
		
		// use of getSearchableBoards() to get the boards the current user may access
		$result = $db->query("SELECT boardid FROM bb".$n."_boards WHERE ".(($_POST['boardids'][0] != '*') ? ("boardid IN (0$selectedids) AND ") : (""))."password='' AND boardid IN (0".getSearchableBoards().")");
		if ($db->num_rows($result) < $boardcount) {
			while ($row = $db->fetch_array($result)) {
				if ($boardids != '') $boardids .= ','.$row['boardid'];
				else $boardids = $row['boardid'];
			}
			if (!$boardids) error($lang->get("LANG_GLOBAL_ERROR_SEARCHNORESULT"));
		}
		
		$savepostids = '';
		$result = $db->unbuffered_query("SELECT p.postid FROM bb".$n."_posts p, bb".$n."_threads t WHERE p.threadid=t.threadid AND p.visible=1"
		. (($postids) ? (" AND p.postid IN (".$postids.")") : (""))
		. (($userids) ? (" AND ".((isset($_POST['onlystarter']) && $_POST['onlystarter'] == 1) ? ("t.starterid") : ("p.userid"))." IN ($userids)") : (""))
		. (($boardids) ? (" AND t.boardid IN (".$boardids.")") : (""))
		. (($searchprefix) ? (" AND t.prefix = '".addslashes($searchprefix)."'") : (""))
		. (($searchdate) ? (" AND $searchdate") : ("")));
		while ($row = $db->fetch_array($result)) $savepostids .= ','.$row['postid'];
		
		if (!$savepostids) error($lang->get("LANG_GLOBAL_ERROR_SEARCHNORESULT"));
		
		if (isset($_POST['onlystarter']) && $_POST['onlystarter'] == 1) $_POST['showposts'] = 0;
		
		$result = $db->query_first("SELECT searchid FROM bb".$n."_searchs WHERE searchhash = '".getQueryHash($savepostids, $_POST['showposts'], $_POST['sortby'], $_POST['sortorder'], $wbbuserdata['userid'], $REMOTE_ADDR)."'");
		if ($result['searchid']) {
			header("Location: search.php?searchid=".$result['searchid'].$SID_ARG_2ND_UN);	
			exit();
		}
		
		$db->query("INSERT INTO bb".$n."_searchs (searchhash,searchstring,searchuserid,postids,showposts,sortby,sortorder,searchtime,userid,ipaddress)
		VALUES ('".getQueryHash($savepostids, $_POST['showposts'], $_POST['sortby'], $_POST['sortorder'], $wbbuserdata['userid'], $REMOTE_ADDR)."','".addslashes($tempsearchstring)."','".((!strstr($userids, ',')) ? ($userids) : (0))."','$savepostids','".intval($_POST['showposts'])."','".addslashes($_POST['sortby'])."','".addslashes($_POST['sortorder'])."','".time()."','$wbbuserdata[userid]','$REMOTE_ADDR')");
		$searchid = $db->insert_id();
		
		header("Location: search.php?searchid=$searchid".$SID_ARG_2ND_UN);
		exit(); 
	}
	else {
		$prefixBoardCache = array();
		$result = $db->unbuffered_query("SELECT boardid, parentid, boardorder, title, invisible, prefixuse, prefix FROM bb".$n."_boards ORDER by parentid ASC, boardorder ASC");
		while ($row = $db->fetch_array($result)) {
			if ($row['prefixuse'] > 1 && $row['prefix'] != '') {
				$prefixBoardCache[] = $row; 
			}
			
			$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
		}
		
		$permissioncache = getPermissions();
		$board_options = makeboardselect(0);
		
		$prefixTotal = $default_prefix;
		$prefixBoardCacheCount = count($prefixBoardCache);
		for ($i = 0; $i < $prefixBoardCacheCount; $i++) {
			if (!isset($permissioncache[$prefixBoardCache[$i]['boardid']]['can_view_board']) || $permissioncache[$prefixBoardCache[$i]['boardid']]['can_view_board'] == -1) $permissioncache[$prefixBoardCache[$i]['boardid']]['can_view_board'] = $wbbuserdata['can_view_board'];
			
			if ($prefixBoardCache[$i]['invisible'] != 2 && $permissioncache[$prefixBoardCache[$i]['boardid']]['can_view_board']) {
				$prefixTotal .= "\n" . $prefixBoardCache[$i]['prefix']; 
			}
		}
				
		$prefixOptions = '';
		if ($prefixTotal != '') {
			$prefixTotal = preg_replace("/\s*\n\s*/", "\n", wbb_trim($prefixTotal));
			$prefixArray = explode("\n", $prefixTotal);	
			$prefixArray = array_unique($prefixArray);
			sort($prefixArray);
			
			$prefixArrayCount = count($prefixArray);
			for ($i = 0; $i < $prefixArrayCount; $i++) {
				$prefixArray[$i] = htmlconverter($prefixArray[$i]);
				$prefixOptions .= makeoption($prefixArray[$i], $prefixArray[$i], '', 0);	
			}
		}
		
		
		eval("\$tpl->output(\"".$tpl->get("search")."\");");
	}
}
?>
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
// * $Date: 2005-02-28 13:51:28 +0100 (Mon, 28 Feb 2005) $
// * $Author: Burntime $
// * $Rev: 1559 $
// ************************************************************************************//


$filename = 'board.php';

require('./global.php');
$lang->load('START,BOARD');

if ($showuseronlineinboard == 2 || $showuseronlineonboard == 1) {
	include('./acp/lib/class_useronline.php');
}

if (!isset($boardid)) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));

if (isset($_COOKIE[$cookieprefix.'hidecats'])) $hidecats = decode_cookie($_COOKIE[$cookieprefix.'hidecats']);
else $hidecats = array();

if (isset($_GET['hidecat'])) {
	$hidecats[$_GET['hidecat']] = 1;
	if ($wbbuserdata['usecookies'] == 1) encode_cookie('hidecats', time() + 3600 * 24 * 365, false);
	else encode_cookie('hidecats');
}
if (isset($_GET['showcat'])) {
	$hidecats[$_GET['showcat']] = 0;
	if ($wbbuserdata['usecookies'] == 1) encode_cookie('hidecats', time() + 3600 * 24 * 365, false);
	else encode_cookie('hidecats');
}




/** redirect to external url if given **/
if ($board['externalurl'] != '') {
	header("Location: $board[externalurl]");
	exit;
}


$boardnavcache = array();
/**
* board has got subboards..
*/
if ($board['childlist'] != '0') {
	$boardcache = array();
	$permissioncache = array();
	$modcache = array();
	
	switch ($boardordermode) {
		case 1: $boardorder = 'b.title ASC'; break;
		case 2: $boardorder = 'b.title DESC'; break;
		case 3: $boardorder = 'b.lastposttime DESC'; break;
		default: $boardorder = 'b.boardorder ASC'; break;
	}
	$activtime = time() - 60 * $useronlinetimeout;
	
	$boardvisit = array();
	$result = $db->unbuffered_query("
	SELECT
	b.*".(($showlastposttitle == 1) ? (", t.topic, t.prefix AS threadprefix, i.*") : (""))."
	".(($showuseronlineinboard == 1) ? (", COUNT(s.sessionhash) AS useronline") : (""))."
	".(($wbbuserdata['userid']) ? (", bv.lastvisit") : (""))."
	FROM bb".$n."_boards b
	".(($showlastposttitle == 1) ? ("LEFT JOIN bb".$n."_threads t ON (t.threadid=b.lastthreadid)
	LEFT JOIN bb".$n."_icons i USING (iconid)") : (""))."
	".(($showuseronlineinboard == 1) ? ("LEFT JOIN bb".$n."_sessions s ON (s.boardid=b.boardid AND s.lastactivity>='$activtime')") : (""))."
	".(($wbbuserdata['userid']) ? (" LEFT JOIN bb".$n."_boardvisit bv ON (bv.boardid=b.boardid AND bv.userid='".$wbbuserdata['userid']."')") : (""))."
	".(($showuseronlineinboard == 1) ? ("GROUP BY b.boardid") : (""))."
	ORDER by b.parentid ASC, $boardorder");
	while ($row = $db->fetch_array($result)) {
		$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
		$boardnavcache[$row['boardid']] = $row;
		$boardvisit[$row['boardid']] = $row['lastvisit'];
	}
	
	if ($showuseronlineinboard == 2) {
		$userinboard = array();
		$online = &new useronline($wbbuserdata['a_can_view_ghosts'], $wbbuserdata['buddylist']);
		$result = $db->unbuffered_query("SELECT s.userid, s.boardid, u.username, u.useronlinegroupid, u.invisible,g.useronlinemarking FROM bb".$n."_sessions s LEFT JOIN bb".$n."_users u USING (userid) LEFT JOIN bb".$n."_groups g ON g.groupid=u.useronlinegroupid WHERE s.lastactivity>='$activtime'".(($wbbuserdata['ignorelist']) ? (" AND s.userid NOT IN (".str_replace(" ", ",", $wbbuserdata['ignorelist']).")") : (""))." ORDER BY u.username ASC");	
		while ($row = $db->fetch_array($result)) $userinboard[$row['boardid']][] = $row;	
	}
	
	$result = $db->unbuffered_query("SELECT t.boardid, t.threadid, t.lastposttime".(($wbbuserdata['userid']) ? (", tv.lastvisit") : (""))." FROM bb".$n."_threads t".(($wbbuserdata['userid']) ? (" LEFT JOIN bb".$n."_threadvisit tv ON (tv.threadid=t.threadid AND tv.userid='".$wbbuserdata['userid']."')") : (""))." WHERE t.visible = 1 AND t.lastposttime > '$wbbuserdata[lastvisit]' AND t.closed <> 3");
	while ($row = $db->fetch_array($result)) {
		if ($row['lastposttime'] > $row['lastvisit']) $visitcache[$row['boardid']][$row['threadid']] = $row['lastposttime'];
	}
	
	$permissioncache = getPermissions();
	
	if ($hide_modcell == 0) {
		$result = $db->unbuffered_query("SELECT bb".$n."_moderators.*, username FROM bb".$n."_moderators LEFT JOIN bb".$n."_users USING (userid) ORDER BY username ASC");
		while ($row = $db->fetch_array($result)) $modcache[$row['boardid']][] = $row;
	}
	
	$tempboardcache = $boardcache;
	$temppermissioncache = $permissioncache;
	
	$index_depth = $board_depth;
	$temp_boardid = $boardid;
	$boardbit = makeboardbit($boardid);
	
	$boardcache = $tempboardcache;
	$permissioncache = $temppermissioncache;
}







if ($showboardjump == 1) $boardjump = makeboardjump($boardid);
$navbar = getNavbar($board['parentlist']);
eval("\$navbar .= \"".$tpl->get("navbar_boardend")."\";");

if (!$board['isboard']) {
	eval("\$tpl->output(\"".$tpl->get("board_cat")."\");");
	exit();
}





/********** board *********/
if ($board['threadsperpage']) $threadsperpage = $board['threadsperpage'];
else $threadsperpage = $default_threadsperpage;

if ($wbbuserdata['umaxposts']) $postsperpage = $wbbuserdata['umaxposts'];
elseif ($board['postsperpage']) $postsperpage = $board['postsperpage'];
else $postsperpage = $default_postsperpage;

if ($board['hotthread_reply'] == 0) $board['hotthread_reply'] = $default_hotthread_reply;
if ($board['hotthread_view'] == 0) $board['hotthread_view'] = $default_hotthread_view;

if (isset($_GET['page'])) {
	$page = intval($_GET['page']);
	if ($page == 0) $page = 1;
}
else $page = 1;
unset($datecute);

if (!$board['sortfield']) $board['sortfield'] = $default_sortfield;
if (isset($_GET['sortfield'])) $sortfield = $_GET['sortfield'];
else $sortfield = $board['sortfield'];

switch ($sortfield) {
	case 'prefix': break;
	case 'topic': break;
	case 'starttime': break;
	case 'replycount': break;
	case 'starter': break;
	case 'views': break;
	case 'vote': break;
	case 'lastposttime': break;
	case 'lastposter': break;
	default: $sortfield = $board['sortfield'];
}

$f_select['prefix']		= '';
$f_select['topic']		= '';
$f_select['starttime']		= '';
$f_select['replycount']		= '';
$f_select['starter']		= '';
$f_select['views']		= '';
$f_select['vote']		= '';
$f_select['lastposttime']	= '';
$f_select['lastposter']		= '';
$f_select[$sortfield]		= 'selected="selected"';

if (!$board['sortorder']) $board['sortorder'] = $default_sortorder;
if (isset($_GET['sortorder'])) $sortorder = $_GET['sortorder'];
else $sortorder = $board['sortorder'];

switch ($sortorder) {
	case 'ASC': break;
	case 'DESC': break;
	default: $sortorder = $board['sortorder'];
}
$o_select['ASC']	= '';
$o_select['DESC']	= '';
$o_select[$sortorder]	= 'selected="selected"';

if (isset($_GET['daysprune'])) $daysprune = intval($_GET['daysprune']);
elseif ($wbbuserdata['daysprune'] != 0) $daysprune = $wbbuserdata['daysprune'];
elseif ($board['daysprune'] != 0) $daysprune = $board['daysprune'];
else $daysprune = $default_daysprune;
$d_select[1500]		= '';
$d_select[1]		= '';
$d_select[2]		= '';
$d_select[5]		= '';
$d_select[10]		= '';
$d_select[20]		= '';
$d_select[30]		= '';
$d_select[45]		= '';
$d_select[60]		= '';
$d_select[75]		= '';
$d_select[100]		= '';
$d_select[365]		= '';
$d_select[1000]		= '';
$d_select[$daysprune]	= 'selected="selected"';
if ($daysprune != 1000) {
	if ($daysprune == 1500) $datecute = " AND (important=1 OR lastposttime >= '".$wbbuserdata['lastvisit']."')";	
	else {
		$tempdate = time() - ($daysprune * 86400);
		$datecute = " AND (important=1 OR lastposttime >= '".$tempdate."')";
	}
}
else $datecute = '';

/** announcements threads **/
$announcecount = 0;
$announceids = '';
$result = $db->unbuffered_query("SELECT threadid FROM bb".$n."_announcements WHERE boardid='$boardid'");
while ($row = $db->fetch_array($result)) {
	$announcecount++;
	$announceids .= ','.$row['threadid'];
}

if ($showown && $wbbuserdata['userid'] >= 1) {
	$ownuserid = "DISTINCT bb".$n."_posts.userid,";
	$ownjoin = "LEFT JOIN bb".$n."_posts ON (bb".$n."_threads.threadid = bb".$n."_posts.threadid AND bb".$n."_posts.userid = '$wbbuserdata[userid]')";
}
else {
	$ownuserid = '';
	$ownjoin = '';
}

if ($wbbuserdata['lastvisit'] > $board['lastvisit']) $board['lastvisit'] = $wbbuserdata['lastvisit'];

if ($wbbuserdata['userid']) {
	$tvselect = ', tv.lastvisit';
	$tvjoin = " LEFT JOIN bb".$n."_threadvisit tv ON (tv.threadid=bb".$n."_threads.threadid AND tv.userid = '".$wbbuserdata['userid']."')";
}
else {
	$tvselect = '';
	$tvjoin = '';
}

/** count total threads **/
$threadcount = $db->query_first("SELECT COUNT(threadid) FROM bb".$n."_threads WHERE boardid='$boardid' AND important < 2 AND visible = 1 $datecute");
$threadcount = $threadcount[0];

$pages = ceil($threadcount / $threadsperpage);
if ($pages > 1) $pagelink = makePageLink("board.php?boardid=$boardid&amp;daysprune=$daysprune&amp;sortfield=$sortfield&amp;sortorder=$sortorder".$SID_ARG_2ND, $page, $pages, $showpagelinks - 1);
else $pagelink = '';

$sqlOrderBy = "ORDER BY important DESC, " . $sortfield . " " . $sortorder . (($sortfield != $board['sortfield']) ? (", " . $board['sortfield'] . " " . $board['sortorder']) : ((($sortfield != 'lastposttime') ? (', lastposttime DESC') : (''))));

$threadids = '';
$result = $db->unbuffered_query("SELECT threadid, if (voted>0 AND voted>=".intval($showvotes).",votepoints/voted,0) AS vote FROM bb".$n."_threads WHERE boardid='$boardid' AND visible = 1 AND important < 2 $datecute " . $sqlOrderBy, 0, $threadsperpage, $threadsperpage * ($page - 1));
while ($row = $db->fetch_array($result)) $threadids .= ','.$row['threadid'];

$threadbit1 = '';
$threadbit2 = '';

$result = $db->unbuffered_query("SELECT
 $ownuserid
 bb".$n."_threads.*,
 if (voted>0 AND voted>=".intval($showvotes).",votepoints/voted,0) AS vote,
 bb".$n."_icons.*
 $tvselect
 FROM bb".$n."_threads
 LEFT JOIN bb".$n."_icons USING (iconid)
 $ownjoin
 $tvjoin
 WHERE bb".$n."_threads.threadid IN (0$announceids$threadids) " . $sqlOrderBy);

while ($threads = $db->fetch_array($result)) {
	$multipages = '';
	$attachments = '';
	$prefix = '';
	
	$threads['topic']	= htmlconverter(textwrap($threads['topic']));
	$threads['starter']	= htmlconverter(textwrap($threads['starter'], 25));
	$threads['lastposter']	= htmlconverter(textwrap($threads['lastposter'], 25));
	$threads['prefix']	= htmlconverter($threads['prefix']);
	
	$lastpostdate = formatdate($wbbuserdata['dateformat'], $threads['lastposttime'], 1);
	$lastposttime = formatdate($wbbuserdata['timeformat'], $threads['lastposttime']);
	
	// this thread is actually a link to another thread
	if ($threads['closed'] == 3) {
		$firstnew = 0;
		
		$threads['threadid'] = $threads['pollid'];
		$threadrating = '&nbsp;';	
		
		$foldericon = 'moved';
		if ($threads['iconid']) $threadicon = makeimgtag($threads['iconpath'], getlangvar($threads['icontitle'], $lang), 0);
		else $threadicon = '&nbsp;';
		
		$threads['replycount'] = '-';
		$threads['views'] = '-';	
	}
	else {
		if ($threads['lastposttime'] > $board['lastvisit'] && $threads['lastposttime'] > $threads['lastvisit']) $firstnew = 1;
		else $firstnew = 0;
		
		if ($threads['voted'] && $threads['voted'] >= $showvotes && $board['allowratings'] == 1) $threadrating = threadrating($threads['votepoints'], $threads['voted']);
		else $threadrating = '&nbsp;';
		
		if ($threads['important'] == 2) $foldericon = 'announce';
		else $foldericon = ((isset($threads['userid']) && $threads['userid']) ? ('dot') : ('')).(($threads['lastposttime'] > $board['lastvisit'] && $threads['lastposttime'] > $threads['lastvisit']) ? ('new') : ('')).(($threads['replycount'] >= $board['hotthread_reply'] || $threads['views'] >= $board['hotthread_view']) ? ('hot') : ('')).(($threads['closed'] != 0) ? ('lock') : ('')).'folder';
		if ($threads['pollid'] != 0) $threadicon = makeimgtag($style['imagefolder'].'/poll.gif');
		elseif ($threads['iconid']) $threadicon = makeimgtag($threads['iconpath'], getlangvar($threads['icontitle'], $lang), 0);
		else $threadicon = '&nbsp;';
		
		if ($threads['replycount'] + 1 > $postsperpage && $showmultipages != 0) {
			$multipage = '';
			$multipages_lastpage = '';
			$xpages = ceil(($threads['replycount'] + 1) / $postsperpage);
			if ($xpages > $showmultipages) {
				eval("\$multipages_lastpage = \"".$tpl->get("board_threadbit_multipages_lastpage")."\";");
				$xpages = $showmultipages;
			}
			for ($i = 1; $i <= $xpages; $i++) {
				$multipage .= ' '.makehreftag("thread.php?threadid=".$threads['threadid']."&amp;page=".$i.$SID_ARG_2ND, $i);
			}
			eval("\$multipages = \"".$tpl->get("board_threadbit_multipages")."\";");
		}
		
		if ($threads['attachments']) $LANG_BOARD_ATTACHMENTS = $lang->get("LANG_BOARD_ATTACHMENTS", array('$attachments' => $threads['attachments']));
	}
	
	if ($threads['replycount'] >= 1000) $threads['replycount'] = number_format($threads['replycount'], 0, '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	if ($threads['views'] >= 1000) $threads['views'] = number_format($threads['views'], 0, '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	
	if ($threads['important'] == 0) eval("\$threadbit2 .= \"".$tpl->get("board_threadbit")."\";");
	else eval("\$threadbit1 .= \"".$tpl->get("board_threadbit")."\";");
}

$threadcount += $pages * $announcecount;
$l_threads = ($page - 1) * ($threadsperpage + $announcecount) + 1;
$h_threads = $page * ($threadsperpage + $announcecount);
if ($h_threads > $threadcount) $h_threads = $threadcount;

/** moderators **/
if ($hide_modcell == 0) {
	unset($moderatorbit);
	$result = $db->unbuffered_query("SELECT bb".$n."_moderators.userid, username FROM bb".$n."_moderators LEFT JOIN bb".$n."_users USING (userid) WHERE boardid = '$boardid' ORDER BY username ASC");
	while ($row = $db->fetch_array($result)) {
		$row['username'] = htmlconverter($row['username']);
		if (isset($moderatorbit)) eval("\$moderatorbit .= \"".$tpl->get("board_moderatorbit")."\";");
		else eval("\$moderatorbit = \"".$tpl->get("board_moderatorbit")."\";");
	}
}

if ($showuseronlineonboard == 1) {
	$activtime = time() - 60 * $useronlinetimeout;
	$online = &new useronline($wbbuserdata['a_can_view_ghosts'], $wbbuserdata['buddylist']);
	$guestcount = 0;
	$result = $db->unbuffered_query("SELECT s.userid, u.username, u.useronlinegroupid, u.invisible,g.useronlinemarking FROM bb".$n."_sessions s LEFT JOIN bb".$n."_users u USING (userid) LEFT JOIN bb".$n."_groups g ON g.groupid=u.useronlinegroupid WHERE s.lastactivity > '$activtime' AND boardid = '$boardid'".(($wbbuserdata['ignorelist']) ? (" AND s.userid NOT IN (".str_replace(" ", ",", $wbbuserdata['ignorelist']).")") : (""))." ORDER BY username ASC");
	while ($row = $db->fetch_array($result)) {
		if ($row['userid'] == 0) $guestcount++; 
		else $online->user($row['userid'], htmlconverter($row['username']), $row['useronlinemarking'], $row['invisible']);
	}
	
	$useronlinebit = $online->useronlinebit;
	
	if ($guestcount == 1) $useronline_GUEST = $lang->items['LANG_START_USERONLINE_GUEST_ONE'];
	elseif ($guestcount > 1) $useronline_GUEST = $lang->items['LANG_START_USERONLINE_GUEST'];
	else {
		$useronline_GUEST = '';
		$guestcount = '';
	}
	 
	if ($guestcount > 0 && $useronlinebit != '') $useronline_AND = $lang->items['LANG_START_USERONLINE_AND'];
	else $useronline_AND = '';
	
	if ($guestcount > 0 || $useronlinebit != '') {
		$useronlinebit = $lang->get("LANG_START_USERACTIVE", array('$useronlinebit' => $useronlinebit, '$useronline_AND' => $useronline_AND, '$guestcount' => $guestcount, '$useronline_GUEST' => $useronline_GUEST));
		$useronlinebit = wbb_trim($useronlinebit);
	}
}




if ($board['closed'] == 0) eval("\$newthread = \"".$tpl->get("board_newthread")."\";");

if ($threadbit1 != '' || $threadbit2 != '') {
	$l_threads = number_format($l_threads, 0, '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	$h_threads = number_format($h_threads, 0, '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	$threadcount = number_format($threadcount, 0, '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	
	eval("\$board_sortfield = \"".$tpl->get("board_sortfield")."\";");
	eval("\$board_sortorder = \"".$tpl->get("board_sortorder")."\";");
	eval("\$board_daysprune = \"".$tpl->get("board_daysprune")."\";");
	$lang->items['LANG_BOARD_SORTOPTIONS'] = $lang->get("LANG_BOARD_SORTOPTIONS", array('$l_threads' => $l_threads, '$h_threads' => $h_threads, '$threadcount' => $threadcount, '$board_sortfield' => $board_sortfield, '$board_sortorder' => $board_sortorder, '$board_daysprune' => $board_daysprune));
}
else {
	eval("\$board_daysprune2 = \"".$tpl->get("board_daysprune2")."\";");
	$lang->items['LANG_BOARD_NOTHREADS'] = $lang->get("LANG_BOARD_NOTHREADS", array('$board_daysprune2' => $board_daysprune2));
}

$board['hotthread_reply'] = number_format($board['hotthread_reply'], 0, '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
$board['hotthread_view'] = number_format($board['hotthread_view'], 0, '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
$lang->items['LANG_BOARD_HOTFOLDER'] = $lang->get("LANG_BOARD_HOTFOLDER", array('$hotthread_reply' => $board['hotthread_reply'], '$hotthread_view' => $board['hotthread_view']));
$lang->items['LANG_BOARD_NEWHOTFOLDER'] = $lang->get("LANG_BOARD_NEWHOTFOLDER", array('$hotthread_reply' => $board['hotthread_reply'], '$hotthread_view' => $board['hotthread_view']));

if ($board['emailnotify'] == 1 && $board['countemails'] != 0) $db->unbuffered_query("UPDATE bb".$n."_subscribeboards SET countemails=0 WHERE userid = '".$wbbuserdata['userid']."' AND boardid = '".$boardid."'", 1);

eval("\$tpl->output(\"".$tpl->get("board")."\");");
?>
<?php
$filename = 'board.php';

require('./global.php');
$lang->load('ARCHIVE');

if (!isset($boardid) || !checkpermissions("can_enter_board") || $board['password'] || $board['showinarchive'] == 0 || $board['externalurl'] != '') {
	header("Location: $url2board/archive/index.html");
	exit;
}

$board['title'] = getLangvar($board['title'], $lang);
$navbar = getNavbar($board['parentlist'], 'archive_navbar');
eval("\$navbar .= \"".$tpl->get("navbar_boardend")."\";");

/********** board *********/
$threadsperpage = 50;
$sortfield = 'lastposttime';
$sortorder = 'DESC';
if (isset($_GET['page'])) {
	$page = intval($_GET['page']);
	if ($page == 0) $page = 1;
}
else $page = 1;

/** announcements threads **/
$announcecount = 0;
$announceids = '';
$result = $db->query("SELECT threadid FROM bb".$n."_announcements WHERE boardid='$boardid'");
while ($row = $db->fetch_array($result)) {
	$announcecount++;
	$announceids .= ','.$row['threadid'];
}

/** count total threads **/
$threadcount = $db->query_first("SELECT COUNT(threadid) FROM bb".$n."_threads WHERE boardid='$boardid' AND important < 2 AND visible = 1");
$threadcount = $threadcount[0];

$pages = ceil($threadcount / $threadsperpage);

$sqlOrderBy = "ORDER BY important DESC, " . $sortfield . " " . $sortorder;

$threadids = '';
$result = $db->query("SELECT threadid FROM bb".$n."_threads WHERE boardid='$boardid' AND visible = 1 AND important < 2 " . $sqlOrderBy, $threadsperpage, $threadsperpage * ($page - 1));
while ($row = $db->fetch_array($result)) $threadids .= ','.$row['threadid'];

$threadbit = '';
$result = $db->unbuffered_query("SELECT * FROM bb".$n."_threads WHERE bb".$n."_threads.threadid IN (0$announceids$threadids) " . $sqlOrderBy);
while ($threads = $db->fetch_array($result)) {
	if ($threads['closed'] == 3) {
		$threads['threadid'] = $threads['pollid'];
	}
	
	$threads['prefix'] = htmlconverter($threads['prefix']);
	$threads['topic'] = htmlconverter(textwrap($threads['topic']));
	eval("\$threadbit .= \"".$tpl->get("archive_board_threadbit")."\";");
}

eval("\$tpl->output(\"".$tpl->get("archive_board")."\");");
?>
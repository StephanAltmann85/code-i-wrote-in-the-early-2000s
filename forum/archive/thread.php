<?php
$filename = 'thread.php';

require('./global.php');
$lang->load('ARCHIVE');

if (!isset($threadid) || !checkpermissions("can_read_thread") || $board['password'] || $thread['visible'] == 0 || $thread['closed'] == 3) {
	header("Location: $url2board/archive/index.html");
	exit;
}

$board['title'] = getLangvar($board['title'], $lang);
$navbar = getNavbar($board['parentlist'], 'archive_navbar');
eval("\$navbar .= \"".$tpl->get("archive_navbar")."\";");

/********** board *********/
$postsperpage = 20;
if (isset($_GET['page'])) {
	$page = intval($_GET['page']);
	if ($page == 0) $page = 1;
}
else $page = 1;

/** count total posts **/
list($postcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_posts WHERE threadid='$threadid' AND visible = 1");

// pages
$pages = ceil($postcount / $postsperpage);

require('./acp/lib/class_parse.php');
$parse = new parse($docensor, 75, $wbbuserdata['showimages'], '', $usecode);
$postbit = '';
$result = $db->query("SELECT * FROM bb".$n."_posts WHERE threadid='$threadid' AND visible = 1 ORDER BY posttime ASC", $postsperpage, $postsperpage * ($page - 1));
while ($posts = $db->fetch_array($result)) {
	$posts['username'] = htmlconverter($posts['username']);
	$posts['message'] = $parse->doparse($posts['message'], $posts['allowsmilies'], $posts['allowhtml'], $posts['allowbbcode'], $posts['allowimages']);
		
	eval("\$postbit .= \"".$tpl->get("archive_thread_postbit")."\";");
}

$thread['prefix'] = htmlconverter($thread['prefix']);
$thread['topic'] = htmlconverter($thread['topic']);
eval("\$tpl->output(\"".$tpl->get("archive_thread")."\");");
?>
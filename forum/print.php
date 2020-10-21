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


$filename = 'print.php';

require('./global.php');
require('./acp/lib/class_parse.php');
$lang->load('THREAD');

if (!isset($threadid)) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
if (!checkpermissions("can_read_thread")) access_error();

if (isset($_GET['page'])) {
	$page = intval($_GET['page']);
	if ($page == 0) $page = 1;
}
else $page = 1;

if ($wbbuserdata['umaxposts']) $postsperpage = $wbbuserdata['umaxposts'];
elseif ($board['postsperpage']) $postsperpage = $board['postsperpage'];
else $postsperpage = $default_postsperpage;
$postorder = $board['postorder'];

list($postcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_posts WHERE threadid = '$threadid' AND visible = 1");

$parse = &new parse($docensor, 75, $wbbuserdata['showimages'], "", $usecode, 0);

$postids = '';
$result = $db->query("SELECT postid FROM bb".$n."_posts WHERE threadid = '$threadid' AND visible = 1 ORDER BY posttime ".(($postorder) ? ("DESC") : ("ASC")), $postsperpage, $postsperpage * ($page - 1));
while ($row = $db->fetch_array($result)) $postids .= ",".$row['postid'];

$result = $db->query("SELECT
p.*,
u.signature, i.iconpath, i.icontitle
FROM bb".$n."_posts p 
LEFT JOIN bb".$n."_users u USING (userid)
LEFT JOIN bb".$n."_icons i ON (p.iconid=i.iconid)
WHERE p.postid IN (0$postids)
ORDER BY p.posttime ".(($postorder) ? ("DESC") : ("ASC")));

while ($posts = $db->fetch_array($result)) {
	unset($signature);
	if ($posts['iconid']) $posticon = makeimgtag($posts['iconpath'], getlangvar($posts['icontitle'], $lang), 0);
	else $posticon = "&nbsp;";
	if ($posts['posttopic']) $posts['posttopic'] = htmlconverter(textwrap($posts['posttopic']));
	
	$posts['message'] = $parse->doparse($posts['message'], $posts['allowsmilies'], $posts['allowhtml'], $posts['allowbbcode'], $posts['allowimages']);
	
	$postdate = formatdate($wbbuserdata['dateformat'], $posts['posttime']);
	$posttime = formatdate($wbbuserdata['timeformat'], $posts['posttime']);
	
	$posts['username'] = htmlconverter($posts['username']);
	$LANG_THREAD_PRINT_POSTED_ON = $lang->get("LANG_THREAD_PRINT_POSTED_ON", array('$username' => $posts['username'], '$postdate' => $postdate, '$posttime' => $posttime));
	eval("\$print_postbit .= \"".$tpl->get("print_postbit")."\";");
}


$lines = '';
$boards = getNavbar($board['parentlist'], "print_navbar");
$lines2 = $lines.'-';
$lines3 = $lines2.'-';

$thread['topic'] = htmlconverter(textwrap($thread['topic']));
eval("\$tpl->output(\"".$tpl->get("print")."\");");
?>
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


$filename = 'misc.php';

require('./global.php');
require('./acp/lib/class_parse.php');

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = '';


/** find user popup (for private message) */	
if ($action == 'finduser') {
	$lang->load('MISC');
	$options = '';
	if (isset($_POST['send'])) {
		$username = wbb_trim($_POST['username']);
		if ($username && $username != '%') {
			$result = $db->unbuffered_query("SELECT username FROM bb".$n."_users WHERE username LIKE '%".addslashes($username)."%'");	
			while ($row = $db->fetch_array($result)) {
				$row['username'] = htmlconverter($row['username']);
				$options .= makeoption($row['username'], $row['username']);	
			}
		}
	}
	
	eval("\$tpl->output(\"".$tpl->get("finduser")."\");");	
}



/** more smilies popup **/
if ($action == 'moresmilies') {
	$lang->load('MISC');
	$rightorleft = 'left';
	if ($showsmiliesrandom == 1) $result = $db->unbuffered_query("SELECT smiliepath, smilietitle, smiliecode FROM bb".$n."_smilies ORDER BY RAND()");
	else $result = $db->unbuffered_query("SELECT smiliepath, smilietitle, smiliecode FROM bb".$n."_smilies ORDER BY smilieorder ASC");
	$j = 0;
	$popup_smiliesbits = '';
	while ($row = $db->fetch_array($result)) {
		$row['smilietitle'] 	= getlangvar($row['smilietitle'], $lang);
		$row['smiliename'] 	= htmlconverter($row['smiliecode']);
		$row['smiliecode']	= addcslashes($row['smiliecode'], "'\\");
		$row['smiliepath'] 	= replaceImagefolder($row['smiliepath']);
		
		eval("\$popup_smiliesbits .= \"".$tpl->get("popup_smiliesbits")."\";");
		
		if ($rightorleft == 'left') {
			$j++;
			$rightorleft = 'right';
		}
		else $rightorleft = 'left';
	}
	
	if ($rightorleft == 'right') $popup_smiliesbits .= '<td>&nbsp;</td><td>&nbsp;</td></tr>';
	
	eval("\$tpl->output(\"".$tpl->get("popup_smilies")."\");");	
}





/** whoposted popup **/
if ($action == 'whoposted') {
	if (!isset($threadid)) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
	$lang->load('MISC');
	
	$posts = $db->unbuffered_query("SELECT
	COUNT(p.postid) AS posts, p.userid, u.username
	FROM bb".$n."_posts p
	LEFT JOIN bb".$n."_users u USING (userid)
	WHERE threadid='$threadid'
	GROUP BY p.userid
	ORDER BY posts DESC, u.username ASC");
	$posters = '';
	$counter = 0;
	$totalposts = 0;
	while ($post = $db->fetch_array($posts)) {
		$totalposts += $post['posts'];
		$post['posts'] = number_format($post['posts'], 0, '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
		if ($post['userid']) {
			$authorname = makehreftag("profile.php?userid=".$post['userid'].$SID_ARG_2ND, "<b>".htmlconverter($post['username'])."</b>", "_blank");
			$post['posts'] = makehreftag("thread.php?threadid=".$threadid."&amp;hilightuser=".$post['userid'].$SID_ARG_2ND, "<b>$post[posts]</b>", "_blank");
		}
		else $authorname = $lang->items['LANG_MISC_WHOPOSTED_GUESTS'];
		eval("\$posters .= \"".$tpl->get("whopostedbit")."\";");
		$counter++;
	}
	
	if ($totalposts >= 1000) $totalposts = number_format($totalposts, 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));	
	$lang->items['LANG_MISC_WHOPOSTED_POSTS_TOTAL'] = $lang->get("LANG_MISC_WHOPOSTED_POSTS_TOTAL", array('$totalposts' => $totalposts));
	eval("\$tpl->output(\"".$tpl->get("whoposted")."\");");	
}








/** view ip **/
if ($action == 'viewip') {
	if (!isset($postid)) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
	if ($wbbuserdata['a_can_view_ipaddress'] != 1) access_error();
	$lang->load('MISC');
	
	$navbar = getNavbar($board['parentlist']);
	eval("\$navbar .= \"".$tpl->get("navbar_board")."\";");
	$post['host'] = htmlconverter(@gethostbyaddr($post['ipaddress']));
	
	$moreips = '';
	if ($post['userid']) {
		$result = $db->unbuffered_query("SELECT DISTINCT ipaddress FROM bb".$n."_posts WHERE userid='$post[userid]' AND ipaddress<>'".addslashes($post['ipaddress'])."' ORDER BY posttime DESC", 0, 10);
		while ($row = $db->fetch_array($result)) $moreips .= htmlconverter($row['ipaddress'])."<br />";
	}
	
	$thread['topic'] = htmlconverter(textwrap($thread['topic']));
	$post['username'] = htmlconverter($post['username']);
	$post['ipaddress'] = htmlconverter($post['ipaddress']);
	
	$lang->items['LANG_MISC_VIEWIP_POSTED_BY'] = $lang->get("LANG_MISC_VIEWIP_POSTED_BY", array('$username' => $post['username']));
	eval("\$tpl->output(\"".$tpl->get("viewip")."\");");
}






/** FAQ **/
if ($action == 'faq') {
	$lang->load('FAQ');
	
	eval("\$tpl->output(\"".$tpl->get("faq")."\");");
}


/** FAQ #1 **/
if ($action == 'faq1') {
	$lang->load('FAQ');
	$count = 0;
	$rankbit = '';
	$result = $db->unbuffered_query("SELECT r.*, g.title FROM bb".$n."_ranks r LEFT JOIN bb".$n."_groups g USING(groupid) ORDER BY g.showorder ASC, r.groupid DESC, r.needposts ASC");
	while ($row = $db->fetch_array($result)) {
		$tdclass = getone($count, "tablea", "tableb");
		
		$row['title'] = getlangvar($row['title'], $lang);
		$row['ranktitle'] = getlangvar($row['ranktitle'], $lang);
		
		$row['rankimages'] = formatRI($row['rankimages']);
		eval("\$rankbit .= \"".$tpl->get("faq1_rankbit")."\";");	
		$count++;	
	}
	
	$lang->items['LANG_FAQ_COOKIES_EXP'] = $lang->get("LANG_FAQ_COOKIES_EXP", array('$SID_ARG_2ND' => $SID_ARG_2ND));
	$lang->items['LANG_FAQ_PROFILE_EXP'] = $lang->get("LANG_FAQ_PROFILE_EXP", array('$SID_ARG_2ND' => $SID_ARG_2ND));
	$lang->items['LANG_FAQ_PASSWORD_EXP'] = $lang->get("LANG_FAQ_PASSWORD_EXP", array('$SID_ARG_1ST' => $SID_ARG_1ST));
	$lang->items['LANG_FAQ_SIGNATUR_EXP'] = $lang->get("LANG_FAQ_SIGNATUR_EXP", array('$SID_ARG_2ND' => $SID_ARG_2ND));
	$lang->items['LANG_FAQ_BUDDY_EXP'] = $lang->get("LANG_FAQ_BUDDY_EXP", array('$SID_ARG_2ND' => $SID_ARG_2ND, '$imagefolder' => $style['imagefolder']));
	$lang->items['LANG_FAQ_FAVORITES_EXP'] = $lang->get("LANG_FAQ_FAVORITES_EXP", array('$SID_ARG_2ND' => $SID_ARG_2ND));
	eval("\$tpl->output(\"".$tpl->get("faq1")."\");");	
}


/** FAQ #2 **/
if ($action == 'faq2') {
	$lang->load('FAQ');
	
	$lang->items['LANG_FAQ_EMAIL_EXP'] = $lang->get("LANG_FAQ_EMAIL_EXP", array('$SID_ARG_1ST' => $SID_ARG_1ST, '$imagefolder' => $style['imagefolder']));
	$lang->items['LANG_FAQ_PM_EXP'] = $lang->get("LANG_FAQ_PM_EXP", array('$SID_ARG_1ST' => $SID_ARG_1ST, '$SID_ARG_2ND' => $SID_ARG_2ND, '$imagefolder' => $style['imagefolder']));
	$lang->items['LANG_FAQ_MEMBERLIST_EXP'] = $lang->get("LANG_FAQ_MEMBERLIST_EXP", array('$SID_ARG_1ST' => $SID_ARG_1ST));
	$lang->items['LANG_FAQ_CALENDAR_EXP'] = $lang->get("LANG_FAQ_CALENDAR_EXP", array('$SID_ARG_1ST' => $SID_ARG_1ST, '$SID_ARG_2ND' => $SID_ARG_2ND));
	eval("\$tpl->output(\"".$tpl->get("faq2")."\");");
}



/** FAQ #3 **/
if ($action == 'faq3') {
	$lang->load('FAQ');
	
	$lang->items['LANG_FAQ_FORMAT_EXP'] = $lang->get("LANG_FAQ_FORMAT_EXP", array('$SID_ARG_2ND' => $SID_ARG_2ND));
	$lang->items['LANG_FAQ_SMILIES_EXP'] = $lang->get("LANG_FAQ_SMILIES_EXP", array('$SID_ARG_2ND' => $SID_ARG_2ND));
	$lang->items['LANG_FAQ_NOTIFICATION_EXP'] = $lang->get("LANG_FAQ_NOTIFICATION_EXP", array('$SID_ARG_2ND' => $SID_ARG_2ND));
	$lang->items['LANG_FAQ_EDIT_EXP'] = $lang->get("LANG_FAQ_EDIT_EXP", array('$imagefolder' => $style['imagefolder']));
	eval("\$tpl->output(\"".$tpl->get("faq3")."\");");
}



/** rate user **/
if ($action == 'userrating') {
	$lang->load('MISC');
	if (isset($_GET['userid'])) $userid = intval($_GET['userid']);
	elseif (isset($_POST['userid'])) $userid = intval($_POST['userid']);
	else {
		eval("\$tpl->output(\"".$tpl->get("userrating_error")."\");");
		exit();
	}
	
	if ($wbbuserdata['can_rate_users'] == 0 || $userid == $wbbuserdata['userid']) {
		eval("\$tpl->output(\"".$tpl->get("userrating_error")."\");");
		exit();	
	}
	
	if ($wbbuserdata['userid']) $result = $db->query_first("SELECT id FROM bb".$n."_votes WHERE id='$userid' AND votemode=3 AND userid='$wbbuserdata[userid]'");
	else $result = $db->query_first("SELECT id FROM bb".$n."_votes WHERE id='$userid' AND votemode=3 AND ipaddress='".addslashes($REMOTE_ADDR)."'");
	if ($result['id']) {
		eval("\$tpl->output(\"".$tpl->get("userrating_error")."\");");
		exit();	
	}
	
	$user = $db->query_first("SELECT userid, username FROM bb".$n."_users WHERE userid='$userid'");
	if (!$user['userid']) {
		eval("\$tpl->output(\"".$tpl->get("userrating_error")."\");");
		exit();	
	}
	
	if (isset($_POST['send'])) {
		$ratingpoints = intval($_POST['ratingpoints']);
		
		if ($ratingpoints >= 0 && $ratingpoints <= 10) {
			$db->unbuffered_query("UPDATE bb".$n."_users SET ratingcount=ratingcount+1, ratingpoints=ratingpoints+'$ratingpoints' WHERE userid='$userid'", 1);	
			$db->unbuffered_query("INSERT INTO bb".$n."_votes (id,votemode,userid,ipaddress) VALUES ('$userid','3','$wbbuserdata[userid]','".addslashes($REMOTE_ADDR)."')", 1);
		}
		eval("\$tpl->output(\"".$tpl->get("window_close")."\");");
		exit();	
	}
	
	$user['username'] = htmlconverter($user['username']);
	eval("\$tpl->output(\"".$tpl->get("userrating_window")."\");");
}








/** show smilies **/
if ($action == 'showsmilies') {
	$lang->load('FAQ');
	if ($showsmiliesrandom == 1) $result = $db->unbuffered_query("SELECT smiliepath, smilietitle, smiliecode FROM bb".$n."_smilies ORDER BY RAND()");
	else $result = $db->unbuffered_query("SELECT smiliepath, smilietitle, smiliecode FROM bb".$n."_smilies ORDER BY smilieorder ASC");
	
	$smiliebit = '';	
	while ($row = $db->fetch_array($result)) {
		$row['smilietitle'] = getlangvar($row['smilietitle'], $lang);
		$row['smiliecode'] = htmlconverter($row['smiliecode']);
		$row['smiliepath'] = replaceImagefolder($row['smiliepath']);
		
		eval("\$smiliebit .= \"".$tpl->get("faq_showsmiliesbit")."\";");	
	}
	eval("\$tpl->output(\"".$tpl->get("faq_showsmilies")."\");");
}






/** show bbcodes **/
if ($action == 'bbcode'){
	$lang->load('FAQ');
	$parse = &new parse(0, 75, 1, "", 0);
	$count = 1;
	$faq_bbcode_links_bit = '';
	$faq_bbcode_content = '';
	$result = $db->query("SELECT bbcodeexample, bbcodeexplanation FROM bb".$n."_bbcodes ORDER BY bbcodeid");
	while ($row = $db->fetch_array($result)) {
		$name = getlangvar($row['bbcodeexample'], $lang);
		$description = getlangvar($row['bbcodeexplanation'], $lang);
		$parsed = $parse->doparse(rehtmlconverter($name), 0, 0, 1, 1);
		
		$content = $lang->get("LANG_FAQ_BBCODES_CONTENT", array('$name' => $name, '$parsed' => $parsed));
		eval("\$faq_bbcode_links_bit .= \"".$tpl->get("faq_bbcode_links")."\";");
		eval("\$faq_bbcode_content .= \"".$tpl->get("faq_bbcode_content")."\";");
		$count++;
	}
	eval("\$tpl->output(\"".$tpl->get("faq_bbcode")."\");");
}


/** show imprint **/
if ($action == 'imprint') {
	eval("\$tpl->output(\"".$tpl->get("imprint")."\");");
}
?>
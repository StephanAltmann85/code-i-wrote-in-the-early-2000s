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
// * $Date: 2005-04-26 16:41:52 +0200 (Tue, 26 Apr 2005) $
// * $Author: Burntime $
// * $Rev: 1597 $
// ************************************************************************************//

@error_reporting(7);
$phpversion = phpversion();

/** get function libary **/
require('./acp/lib/functions.php');
if (version_compare($phpversion, '4.1.0') == -1) {
	$_REQUEST = array_merge($HTTP_COOKIE_VARS, $HTTP_POST_VARS, $HTTP_GET_VARS);
	$_COOKIE =& $HTTP_COOKIE_VARS;
	$_SERVER =& $HTTP_SERVER_VARS;
	$_FILES =& $HTTP_POST_FILES;
	$_GET =& $HTTP_GET_VARS;
	$_POST =& $HTTP_POST_VARS;
}
// remove slashes in get post cookie data...
if (get_magic_quotes_gpc()) {
	if (is_array($_REQUEST)) $_REQUEST = stripslashes_array($_REQUEST);
	if (is_array($_POST)) $_POST = stripslashes_array($_POST);
	if (is_array($_GET)) $_GET = stripslashes_array($_GET);
	if (is_array($_COOKIE)) $_COOKIE = stripslashes_array($_COOKIE);
	if (is_array($_SERVER)) $_SERVER = stripslashes_array($_SERVER);
}

@set_magic_quotes_runtime(0);
@ini_set('magic_quotes_sybase', '0');
/** connect db **/
require('./acp/lib/config.inc.php');
require('./acp/lib/class_db_mysql.php');

$db = &new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);

/** get configuration **/
require('./acp/lib/options.inc.php');

/** load smtp_socket function **/
require('./acp/lib/class_smtp.php');

/** request ids **/
if (isset($_REQUEST['postid'])) $postid = $_REQUEST['postid'];
if (isset($_REQUEST['threadid'])) $threadid = $_REQUEST['threadid'];
if (isset($_REQUEST['pollid'])) $pollid = $_REQUEST['pollid'];
if (isset($_REQUEST['attachmentid'])) $attachmentid = $_REQUEST['attachmentid'];
if (isset($_REQUEST['boardid'])) $boardid = $_REQUEST['boardid'];

/** verify ids **/
if (isset($postid)) {
	$postid = intval($postid);
	$post = $db->query_first("SELECT * FROM bb".$n."_posts WHERE postid = '$postid'");
	if (!$post['postid']) unset($postid);
	else $threadid = $post['threadid'];
}

/** start session **/
require('./acp/lib/session.php');

/** verify ids **/
if (isset($threadid)) {
	$threadid = intval($threadid);
	
	$select = '';
	$join = '';
	
	if ($filename == "thread.php") {
		$select .= ", v.id AS isvoted";
		$join .= " LEFT JOIN bb".$n."_votes v ON (v.id=t.threadid AND v.votemode=2 AND ".(($wbbuserdata['userid']) ? ("v.userid='".$wbbuserdata['userid']."'") : ("v.ipaddress='".addslashes($REMOTE_ADDR)."'")).")";
		
		if ($wbbuserdata['userid']) {
			$select .= ", tv.lastvisit, s.emailnotify, s.countemails";	
			$join .= " LEFT JOIN bb".$n."_threadvisit tv ON (tv.threadid=t.threadid AND tv.userid='".$wbbuserdata['userid']."')
			LEFT JOIN bb".$n."_subscribethreads s ON (s.userid='".$wbbuserdata['userid']."' AND s.threadid=t.threadid)";
		}
	}
	
	$thread = $db->query_first("SELECT t.*".$select." FROM bb".$n."_threads t".$join." WHERE t.threadid = '$threadid'");
	
	$select = '';
	$join = '';
	
	if (!$thread['threadid']) unset($threadid);
	else $boardid = $thread['boardid'];
}
if (isset($pollid)) {
	$pollid = intval($pollid);
	$poll = $db->query_first("SELECT bb".$n."_threads.*, bb".$n."_polls.* FROM bb".$n."_polls LEFT JOIN bb".$n."_threads USING (threadid) WHERE bb".$n."_polls.pollid = '$pollid'");
	if (!$poll['pollid']) unset($pollid);
	else {
		if ($poll['boardid']) {
			$boardid = $poll['boardid'];
			unset($threadid);
			unset($thread);
		}
	}
}
if (isset($attachmentid)) {
	$attachmentid = intval($attachmentid);
	$attachment = $db->query_first("SELECT at.*, ".
	"t.boardid, p.threadid, p.visible, p.userid, ".
	"pm.privatemessageid, pm.inoutbox, pm.senderid, pmr.recipientid, pmr.deletepm ".
	"FROM bb".$n."_attachments at ".
	"LEFT JOIN bb".$n."_posts p ON (p.postid=at.postid) ".
	"LEFT JOIN bb".$n."_threads t ON (t.threadid=p.threadid) ".
	"LEFT JOIN bb".$n."_privatemessage pm ON (pm.privatemessageid=at.privatemessageid) ".
	"LEFT JOIN bb".$n."_privatemessagereceipts pmr ON (pmr.privatemessageid=pm.privatemessageid AND pmr.recipientid='$wbbuserdata[userid]') ".
	"WHERE at.attachmentid = '$attachmentid'");

	if (!$attachment['attachmentid']) {
		unset($attachmentid);
		unset($attachment);
	}
	if ($attachment['postid'] && !$attachment['privatemessageid']) { // post attachment
		if ($attachment['boardid']) {
			$boardid = $attachment['boardid'];
			$threadid = $attachment['threadid'];
			unset($thread);
		}
	}
	elseif (!$attachment['postid'] && $attachment['privatemessageid']) { // private message attachment
		unset($boardid);
		unset($threadid);
		unset($thread);
	}
}
if (isset($boardid)) {
	$boardid = intval($boardid);
	$board = getBoardAccessData($boardid);
	if (!$board['boardid']) unset($boardid);
}

/** update session **/
$db->unbuffered_query("UPDATE bb".$n."_sessions SET lastactivity = '".$session['lastactivity']."', request_uri = '".addslashes($REQUEST_URI)."', boardid='" . ((isset($boardid)) ? ($boardid) : (0)) . "', threadid='".((isset($threadid)) ? ($threadid) : (0))."'" . ((isset($styleid)) ? (", styleid = '$styleid'") : ("")).((isset($langid)) ? (", langid='$langid'") : ("")).((isset($authentificationcode)) ? (", authentificationcode='".addslashes($authentificationcode)."'") : (""))." WHERE sessionhash = '$sid'", 1);

/** get style **/
$style = array();
if (isset($board) && ($board['enforcestyle'] == 1 || ($board['styleid'] != 0 && $wbbuserdata['styleid'] == 0))) {
	$style = $db->query_first("SELECT s.styleid, s.templatepackid, s.designpackid, tp.templatestructure FROM bb".$n."_styles s LEFT JOIN bb".$n."_templatepacks tp ON(tp.templatepackid=s.templatepackid) WHERE s.styleid = '".$board['styleid']."'");
	$wbbuserdata['designpackid'] = $style['designpackid'];
	$wbbuserdata['templatepackid'] = $style['templatepackid'];
	$wbbuserdata['styleid'] = $style['styleid'];
	$wbbuserdata['templatestructure'] = $style['templatestructure'];
}

$result = $db->unbuffered_query("SELECT * FROM bb".$n."_designelements WHERE designpackid = '$wbbuserdata[designpackid]'");
while ($row = $db->fetch_array($result)) $style[$row['element']] = $row['value'];

/** template class **/
require('./acp/lib/class_headers.php');
require('./acp/lib/class_tpl_file.php');
$tpl = &new tpl(intval($wbbuserdata['templatepackid']));

/** language packs **/
require('./acp/lib/class_language.php');
$lang = &new language($wbbuserdata['languagepackid']);
$lang->load('GLOBAL,OWN'); // global, own langcat

define('ENCODING', $lang->get('LANG_GLOBAL_ENCODING'));
$supportedCharsets = array('UCS-4', 'UCS-4BE', 'UCS-4LE', 'UCS-2', 'UCS-2BE', 'UCS-2LE', 'UTF-32', 'UTF-32BE', 'UTF-32LE', 'UCS-2LE', 
'UTF-16', 'UTF-16BE', 'UTF-16LE', 'UTF-8', 'UTF-7', 'ASCII', 'EUC-JP', 'SJIS', 'EUCJP-WIN', 'SJIS-WIN', 'ISO-2022-JP', 'JIS', 'ISO-8859-1', 
'ISO-8859-2', 'ISO-8859-3', 'ISO-8859-4', 'ISO-8859-5', 'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8', 'ISO-8859-9', 'ISO-8859-10', 
'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'BYTE2BE', 'BYTE2LE', 'BYTE4BE', 'BYTE4LE', 'BASE64', '7bit', '8bit', 'UTF7-IMAP');

if (in_array(wbb_strtoupper(ENCODING), $supportedCharsets) && extension_loaded('mbstring') && version_compare($phpversion, '4.3.0') >= 0) {
	define('USE_MBSTRING', true);
}
else {
	define('USE_MBSTRING', false);	
}

/** imagefolder prefix **/
$style['imagefolder'] = $lang->get("LANG_GLOBAL_IMAGEFOLDER_PREFIX").$style['imagefolder'];

/** OWN langvars **/
$o_master_board_name = $master_board_name;
$master_board_name = getlangvar($master_board_name, $lang);

/** Userstatistik **/
$lang->load('LEFT,OWN'); //Sprachpaket
if($wbbuserdata['userid'])
{
  $userinformation = $db->query_first("SELECT a.userid, a.username, a.userposts, a.regdate, a.gender, a.title, a.avatarid, b.avatarname, b.avatarextension, c.ranktitle, c.rankimages FROM bb".$n."_users a LEFT JOIN bb".$n."_avatars b ON a.avatarid = b.avatarid LEFT JOIN bb".$n."_ranks c ON a.rankid = c.rankid WHERE a.userid = '$wbbuserdata[userid]'");
  $regdate = formatdate($wbbuserdata['dateformat'], $userinformation['regdate']);

  if($userinformation["avatarname"] && $userinformation["avatarextension"])
  {
    $avatarname = "images/avatars/avatar-$userinformation[avatarid].".htmlconverter($userinformation['avatarextension']);
    eval("\$left_userstat_avatar = \"".$tpl->get("left_userstat_avatar")."\";");
  }

  $rankimages = formatRI($userinformation['rankimages']);
  if($userinformation['title']) $userinformation['ranktitle'] = htmlconverter($userinformation['title']);
  else $userinformation['ranktitle'] = getlangvar($userinformation['ranktitle'], $lang);

  eval("\$left_userstat = \"".$tpl->get("left_userstat_user")."\";");
}
else eval("\$left_userstat = \"".$tpl->get("left_userstat_guest")."\";");

/** Memberstatistik **/
$users_male = $db->query_first("Select COUNT(userid) AS count FROM bb".$n."_users WHERE gender = 1");
$users_female = $db->query_first("Select COUNT(userid) AS count FROM bb".$n."_users WHERE gender = 2");
$users = $db->query_first("Select COUNT(userid) As count FROM bb".$n."_users ");
$users_invisible = $db->query_first("Select COUNT(userid) AS count FROM bb".$n."_users WHERE invisible = 1");
$users_blocked = $db->query_first("Select COUNT(userid) AS count FROM bb".$n."_users WHERE blocked = 1");
$users_not_activated = $db->query_first("Select COUNT(userid) AS count FROM bb".$n."_users WHERE activation != 1");

$users_no_gender["count"] = $users["count"] - ($users_male["count"] + $users_female["count"]);
eval("\$left_memberstat = \"".$tpl->get("left_memberstat")."\";");

/** Funktionsübersicht **/
eval("\$left_functions = \"".$tpl->get("left_functions")."\";");

/** templates & style **/
$phpinclude = wbb_trim($tpl->get("phpinclude"));
if ($phpinclude != '') {
	$phpinclude = str_replace('\\"', '"', $phpinclude);
	$phpinclude = str_replace('\\\\', '\\', $phpinclude);
	
	eval($phpinclude);	
}

/** default templates **/
$header_pms = '';
$header_acp = '';
eval("\$css = \"".$tpl->get("css")."\";");
eval("\$headinclude = \"".$tpl->get("headinclude")."\";");
$lang->items['LANG_GLOBAL_COPYRIGHT'] = $lang->get("LANG_GLOBAL_COPYRIGHT", array('$boardversion' => $boardversion));
eval("\$footer = \"".$tpl->get("footer")."\";");
if ($wbbuserdata['userid']) $usercbar_username = htmlconverter($wbbuserdata['username']);
else $usercbar_username = '';
eval("\$usercbar = \"".$tpl->get("usercbar")."\";");
eval("\$header = \"".$tpl->get("header")."\";");

if ($wbbuserdata['can_view_board'] == 0 && $filename != "login.php" && $filename != "logout.php" && $filename != "register.php" && $filename != "forgotpw.php") access_error();

verify_ip($REMOTE_ADDR);
if ($offline == 1 && $wbbuserdata['can_view_off_board'] == 0 && $filename != "login.php" && $filename != "logout.php" && $filename != "forgotpw.php" && $filename != "register.php") {
	$offlinemessage = nl2br(htmlconverter($offlinemessage));
	eval("\$tpl->output(\"".$tpl->get("offline")."\");");
	exit();	
}

if ($wbbuserdata['pmpopup'] == 2) {
	if ($filename != "pms.php" && (!isset($_POST) || count($_POST) == 0) && $filename != "attachment.php" && $filename != "attachmentedit.php" && $filename != "logout.php" && $filename != "markread.php" && $filename != "misc.php" && $filename != "modcp.php" && $filename != "polledit.php" && $filename != "register.php" && $filename != "search.php" && ($filename != "thread.php" || !isset($_REQUEST['goto'])) && $filename != "threadrating.php" && $filename != "usercp.php") {
		eval("\$headinclude .= \"".$tpl->get("pmpopup_open")."\";");
	}
}

if (isset($boardid)) {
	/** OWN langvars **/
	$board['o_title'] = $board['title'];
	$board['title'] = getlangvar($board['title'], $lang);
	
	if (!checkpermissions("can_enter_board")) access_error();
	if ($board['password']) {
		$lang->load('BOARD');
		if (isset($_COOKIE[$cookieprefix.'boardpasswords'])) $boardpasswords = decode_cookie($_COOKIE[$cookieprefix.'boardpasswords']);
		else $boardpasswords = array();
		
		if (isset($_POST['boardpassword'])) {
			if ($_POST['boardpassword'] == $board['password']) {
				$boardpasswords[$boardid] = md5($board['password']);
				if ($wbbuserdata['usecookies'] == 1) encode_cookie('boardpasswords', time() + 3600 * 24 * 365, false);
				else encode_cookie('boardpasswords', 0, false);
				
				redirect($lang->items['LANG_BOARD_PASSWORD_REDIRECT'], "board.php?boardid=$boardid".$SID_ARG_2ND);
			}
			else {
				eval("error(\"".$lang->get("LANG_BOARD_ERROR_FALSEPASSWORD")."\");");
			}
		}
		elseif (!isset($boardpasswords[$boardid]) || $boardpasswords[$boardid] != md5($board['password'])) {
			eval("\$tpl->output(\"".$tpl->get("board_password")."\");");
			exit();	
		}
	}
}

if (isset($threadid) && isset($thread['visible']) && $thread['visible'] == 0 && !checkmodpermissions()) {
	error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
}
if (isset($postid) && isset($post['visible']) && $post['visible'] == 0 && !checkmodpermissions()) {
	error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
}

if (isset($_POST['change_editor']) && $_POST['change_editor']) {
	$wbbuserdata['usewysiwyg'] = $_POST['change_editor'];
}
else if (isset($_POST['usewysiwyg']) && $_POST['usewysiwyg']) {
	$wbbuserdata['usewysiwyg'] = $_POST['usewysiwyg'];
}
?>

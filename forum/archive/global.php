<?php
@error_reporting(7);
$phpversion = phpversion();
chdir('./..');

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
/** connect db **/
require('./acp/lib/config.inc.php');
require('./acp/lib/class_db_mysql.php');

$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);

/** get configuration **/
require('./acp/lib/options.inc.php');

/** request ids **/
if (isset($_REQUEST['threadid'])) $threadid = $_REQUEST['threadid'];
if (isset($_REQUEST['boardid'])) $boardid = $_REQUEST['boardid'];

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
if (isset($boardid)) {
	$boardid = intval($boardid);
	$board = getBoardAccessData($boardid);
	if (!$board['boardid']) unset($boardid);
}

/** update session **/
$db->unbuffered_query("UPDATE bb".$n."_sessions SET lastactivity = '".$session['lastactivity']."', request_uri = '".addslashes($REQUEST_URI)."', boardid='" . ((isset($boardid)) ? ($boardid) : (0)) . "', threadid='".((isset($threadid)) ? ($threadid) : (0))."'" . ((isset($styleid)) ? (", styleid = '$styleid'") : ("")).((isset($langid)) ? (", langid='$langid'") : ("")).((isset($authentificationcode)) ? (", authentificationcode='".addslashes($authentificationcode)."'") : (""))." WHERE sessionhash = '$sid'", 1);

/** template class **/
require('./acp/lib/class_headers.php');
require('./acp/lib/class_tpl_file.php');
$tpl = new tpl(0);

// image folder
$result = $db->unbuffered_query("SELECT * FROM bb".$n."_designelements WHERE designpackid = '$wbbuserdata[designpackid]'");
while ($row = $db->fetch_array($result)) $style[$row['element']] = $row['value'];

/** language packs **/
require('./acp/lib/class_language.php');
$lang = new language($wbbuserdata['languagepackid']);
$lang->load('GLOBAL,OWN'); // global, own langcat
$lang->items['LANG_GLOBAL_COPYRIGHT'] = $lang->get("LANG_GLOBAL_COPYRIGHT", array('$boardversion' => $boardversion));

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

/** OWN langvars **/
$o_master_board_name = $master_board_name;
$master_board_name = getlangvar($master_board_name, $lang);

/** templates & style **/
$phpinclude = wbb_trim($tpl->get("phpinclude"));
if ($phpinclude != '') {
	$phpinclude = str_replace('\\"', '"', $phpinclude);
	$phpinclude = str_replace('\\\\', '\\', $phpinclude);
	
	eval($phpinclude);	
}

if (!verify_ip($REMOTE_ADDR, false) || $wbbuserdata['can_view_board'] == 0 || ($offline == 1 && $wbbuserdata['can_view_off_board'] == 0)) {
	header("Location: $url2board");
	exit;
}
?>
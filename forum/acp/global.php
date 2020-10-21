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
// * $Date: 2005-04-21 14:20:04 +0200 (Thu, 21 Apr 2005) $
// * $Author: Burntime $
// * $Rev: 1595 $
// ************************************************************************************//


$disableverify = 1;

if (!defined('WBB_ACP_LOGIN')) define('WBB_ACP_LOGIN', false);
@error_reporting(7);
$phpversion = phpversion();

/** get function libary **/
require('./lib/functions.php');
require('./lib/admin_functions.php');
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
require('./lib/config.inc.php');
require('./lib/class_db_mysql.php');

$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);

/** get configuration **/
require('./lib/options.inc.php');

require('./lib/class_headers.php');
require('./lib/class_tpl_file.php');
require('./lib/class_language.php');
$tpl = new tpl(0, './..');

/** load smtp_socket function **/
require('./lib/class_smtp.php');


/** start session **/
$REMOTE_ADDR = getIpAddress();
$HTTP_USER_AGENT = substr($_SERVER['HTTP_USER_AGENT'], 0, 100);

require('./lib/class_adminsession.php');
$wbbuserdata = array();
if ($_GET['sid'] || $_POST['sid']) {
	$adminsession = new adminsession();
	if ($_GET['sid']) $adminsession_error = $adminsession->update($_GET['sid'], $REMOTE_ADDR, $HTTP_USER_AGENT);
	else $adminsession_error = $adminsession->update($_POST['sid'], $REMOTE_ADDR, $HTTP_USER_AGENT);
	$session['hash'] = $adminsession->hash;
}
else $adminsession_error = 0;

if (!$wbbuserdata['dateformat']) $wbbuserdata['dateformat'] = $dateformat;
if (!$wbbuserdata['timeformat']) $wbbuserdata['timeformat'] = $timeformat;

/** language packs **/
if (!$wbbuserdata['userid']) {
	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && $_SERVER['HTTP_ACCEPT_LANGUAGE'] != '') {
		$wbbuserdata['langid'] = 0;
		$acceptLanguages = preg_split('%[,;]%', addslashes(preg_replace('%([a-z]{1,8})-[a-z]{1,8}%i', '$1', $_SERVER['HTTP_ACCEPT_LANGUAGE'])));
		$languages = array();
		$result = $db->query("SELECT languagepackid, languagecode FROM bb".$n."_languagepacks WHERE languagecode IN ('".implode("','", $acceptLanguages)."')");
		while ($row = $db->fetch_array($result)) $languages[$row['languagecode']] = $row['languagepackid'];
		foreach ($acceptLanguages as $acceptLanguage) {
			if (isset($languages[$acceptLanguage])) {
				$wbbuserdata['langid'] = $languages[$acceptLanguage];
				break;
			}	
		}
	}
	else $wbbuserdata['langid'] = 0;
}
$lang = new language(intval($wbbuserdata['langid']));
$lang->setPath('..');
$lang->load('GLOBAL,OWN,ACP_GLOBAL'); // global, own langcat

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

/** imagefolder prefix ( set to PREFIX."images" in acp ) **/
$style = array('imagefolder' => $lang->get('LANG_GLOBAL_IMAGEFOLDER_PREFIX').'images');

/** OWN langvars **/
$o_master_board_name = $master_board_name;
$master_board_name = getlangvar($master_board_name, $lang);


/** show acess error if adminsession could not be updated **/
if ($adminsession_error) {
	eval("\$tpl->output(\"".$tpl->get("access_error", 1)."\",1);");
	exit();	
}





/** access? **/
if (!WBB_ACP_LOGIN && !$wbbuserdata['a_can_use_acp']) access_error(1);

/** switch acpmode */
if (isSet($_REQUEST['acpmode']) && $wbbuserdata['acpmode'] != intval($_REQUEST['acpmode'])) {
	$db->unbuffered_query("UPDATE bb".$n."_users SET acpmode='".intval($_REQUEST['acpmode'])."' WHERE userid='".$wbbuserdata['userid']."'");
	$wbbuserdata['acpmode'] = intval($_REQUEST['acpmode']);
}

/** count clicks on menu items for dynamic menu */
if ($wbbuserdata['acppersonalmenu'] == 1 && isSet($_REQUEST['countmenuitemgroupid'])) {
	$countmenuitemgroupid = intval($_REQUEST['countmenuitemgroupid']);
	$db->unbuffered_query("UPDATE bb".$n."_acpmenuitemgroupscount SET count=count+1,lastaccesstime='".time()."' WHERE itemgroupid='".$countmenuitemgroupid."' AND userid='".$wbbuserdata['userid']."'");
	if ($db->affected_rows() == 0) $db->unbuffered_query("INSERT IGNORE INTO bb".$n."_acpmenuitemgroupscount (userid,itemgroupid,count,lastaccesstime) VALUES ('".$wbbuserdata['userid']."','".$countmenuitemgroupid."','1','".time()."')");
	unset($countmenuitemgroupid);
}
if ($wbbuserdata['acppersonalmenu'] == 1 && isSet($_REQUEST['countmenuitemid'])) {
	$countmenuitemid = intval($_REQUEST['countmenuitemid']);
	$db->unbuffered_query("UPDATE bb".$n."_acpmenuitemscount SET count=count+1,lastaccesstime='".time()."' WHERE itemid='".$countmenuitemid."' AND userid='".$wbbuserdata['userid']."'");
	if ($db->affected_rows() == 0) $db->unbuffered_query("INSERT IGNORE INTO bb".$n."_acpmenuitemscount (userid,itemid,count,lastaccesstime) VALUES ('".$wbbuserdata['userid']."','".$countmenuitemid."','1','".time()."')");
	unset($countmenuitemid);
}
?>
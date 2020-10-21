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
// * $Date: 2005-04-12 17:42:44 +0200 (Tue, 12 Apr 2005) $
// * $Author: Burntime $
// * $Rev: 1590 $
// ************************************************************************************//


mt_srand(intval(wbb_substr(microtime(), 2, 8)));
if (mt_rand(1, 100) == 50) {
	$db->unbuffered_query("DELETE FROM bb".$n."_adminsessions WHERE userid=0 AND lastactivity<".(time() - $adminsession_timeout), 1);
	$db->unbuffered_query("DELETE FROM bb".$n."_sessions WHERE lastactivity<".(time() - $sessiontimeout), 1);
	$db->unbuffered_query("DELETE FROM bb".$n."_searchs WHERE searchtime<".(time() - 86400 * 7), 1);
}
if (mt_rand(1, 10000) == 5000) {
	// clear postcache
	$threadIDs = '';
	$result = $db->query("SELECT threadid FROM bb".$n."_threads WHERE important <> 0 OR lastposttime > '".(time() - 86400 * $postcache_daysprune)."'");
	while ($row = $db->fetch_array($result)) {
		$threadIDs .= "," . $row['threadid'];
	}
	
	$db->query("DELETE FROM bb".$n."_postcache WHERE threadid NOT IN (0".$threadIDs.")");
}

$REMOTE_ADDR = getIpAddress();
$HTTP_USER_AGENT = wbb_substr($_SERVER['HTTP_USER_AGENT'], 0, 100);
$REQUEST_URI = $_SERVER['REQUEST_URI'];
if (!$REQUEST_URI) {
	if ($_SERVER['PATH_INFO']) $REQUEST_URI = $_SERVER['PATH_INFO'];
	else $REQUEST_URI = $_SERVER['PHP_SELF'];
	if ($_SERVER['QUERY_STRING']) $REQUEST_URI .= "?".$_SERVER['QUERY_STRING'];
}
$REQUEST_URI = wbb_substr(basename($REQUEST_URI), 0, 250);
if (!strstr($REQUEST_URI, ".")) $REQUEST_URI = "index.php";

unset($wbbuserdata);
unset($session);
unset($wbb_userid);
unset($styleid);
unset($langid);
if (isset($_COOKIE[$cookieprefix.'userid'])) $wbb_userid = intval($_COOKIE[$cookieprefix.'userid']);

if (isset($_REQUEST['styleid'])) $styleid = intval($_REQUEST['styleid']);
if (isset($_REQUEST['langid'])) $langid = intval($_REQUEST['langid']);

if (isset($_GET['sid'])) $sid = $_GET['sid'];
elseif (isset($_POST['sid'])) $sid = $_POST['sid'];
else $sid = '';

if (!$sid && isset($_COOKIE[$cookieprefix.'cookiehash'])) $sid = $_COOKIE[$cookieprefix.'cookiehash'];
if ($sid && isset($_COOKIE[$cookieprefix.'cookiehash']) && $_COOKIE[$cookieprefix.'cookiehash'] && $sid != $_COOKIE[$cookieprefix.'cookiehash']) $falsecookiehash = 1;

if ($allowloginencryption == 1) {
	// generate authentificationcode
	unset($authentificationcode);
	$need = needNewAuthentificationcode();
	if ($need == 0 || $need == 1) $authentificationcode = makeAuthentificationcode();
}

$createsession = 0;
if ($sid) {
	$session = $db->query_first("SELECT * FROM bb".$n."_sessions WHERE sessionhash = '".addslashes($sid)."' AND ipaddress = '".addslashes($REMOTE_ADDR)."' AND useragent = '".addslashes($HTTP_USER_AGENT)."'");
	if ($session['sessionhash']) {
		$wbb_userid = $session['userid'];
		$session['lastactivity'] = time();
		if (!isset($styleid)) $styleid = $session['styleid'];
		if (!isset($langid)) $langid = $session['langid'];
	}
	else $createsession = 1;
}
else $createsession = 1;

if ($createsession == 1 || $session['userid'] == 0) {
	if (isset($_COOKIE[$cookieprefix.'userid']) && isset($_COOKIE[$cookieprefix.'userpassword'])) { /* maybe member */
		$wbbuserdata = getwbbuserdata(intval($_COOKIE[$cookieprefix.'userid']), "userid", 1);
		if ($_COOKIE[$cookieprefix.'userpassword'] == $wbbuserdata['password']) { /* member */
			$session = array();
			$session['sessionhash'] = md5(uniqid(microtime()));
			$session['userid'] = intval($_COOKIE[$cookieprefix.'userid']);
			$wbb_userid = $session['userid'];
			$session['ipaddress'] = $REMOTE_ADDR;
			$session['useragent'] = $HTTP_USER_AGENT;
			$session['lastactivity'] = time();
			$session['request_uri'] = $REQUEST_URI;
			if (isset($styleid)) $session['styleid'] = $styleid;
			else $session['styleid'] = $wbbuserdata['styleid'];
			if (isset($langid)) $session['langid'] = $langid;
			else $session['langid'] = $wbbuserdata['langid'];
			$db->unbuffered_query("DELETE FROM bb".$n."_sessions WHERE userid = '$session[userid]'", 1);
			$db->unbuffered_query("INSERT INTO bb".$n."_sessions (sessionhash,userid,ipaddress,useragent,lastactivity,request_uri,styleid,langid,authentificationcode) VALUES ('$session[sessionhash]','$session[userid]','".addslashes($session['ipaddress'])."','".addslashes($session['useragent'])."','$session[lastactivity]','".addslashes($session['request_uri'])."','$session[styleid]','$session[langid]','".((isset($authentificationcode)) ? ($authentificationcode) : (""))."')", 1);
			bbcookie("cookiehash", $session['sessionhash'], 0);
		}
		else {
			if ($createsession == 1) $guestsession = 1;
			unset($wbb_userid);
			unset($wbbuserdata);
			bbcookie("userid", "", 1);
			bbcookie("userpassword", "", 1);
		} 
	}
	elseif ($createsession == 1) {
		unset($wbb_userid);
		$guestsession = 1;
	}
	if (isset($guestsession)) { /* guest */
		$db->unbuffered_query("DELETE FROM bb".$n."_sessions WHERE userid='0' AND ipaddress = '".addslashes($REMOTE_ADDR)."' AND useragent = '".addslashes($HTTP_USER_AGENT)."'", 1);
		
		$session['sessionhash'] = md5(uniqid(microtime()));
		$session['userid'] = 0;
		$session['ipaddress'] = $REMOTE_ADDR;
		$session['useragent'] = $HTTP_USER_AGENT;
		$session['lastactivity'] = time();
		$session['request_uri'] = $REQUEST_URI;
		if (isset($styleid)) $session['styleid'] = $styleid;
		else $session['styleid'] = 0;
		if (isset($langid)) $session['langid'] = $langid;
		else {
			if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) && $_SERVER["HTTP_ACCEPT_LANGUAGE"] != '') {
				$acceptLanguages = preg_split('%[,;]%', addslashes(preg_replace('%([a-z]{1,8})-[a-z]{1,8}%i', '$1', $_SERVER['HTTP_ACCEPT_LANGUAGE'])));
				$languages = array();
				$result = $db->query("SELECT languagepackid, languagecode FROM bb".$n."_languagepacks WHERE languagecode IN ('".implode("','", $acceptLanguages)."')");
				while ($row = $db->fetch_array($result)) $languages[$row['languagecode']] = $row['languagepackid'];
				foreach ($acceptLanguages as $acceptLanguage) {
					if (isset($languages[$acceptLanguage])) {
						$langid = $session['langid'] = $languages[$acceptLanguage];
						break;
					}	
				}
				if (!isset($langid)) $session['langid'] = 0;
			}
			else $session['langid'] = 0;
		}
		$db->unbuffered_query("INSERT INTO bb".$n."_sessions (sessionhash,userid,ipaddress,useragent,lastactivity,request_uri,styleid,langid,authentificationcode) VALUES ('$session[sessionhash]','0','".addslashes($session['ipaddress'])."','".addslashes($session['useragent'])."','$session[lastactivity]','".addslashes($session['request_uri'])."','$session[styleid]','$session[langid]','".((isset($authentificationcode)) ? ($authentificationcode) : (""))."')", 1);
		
		bbcookie("cookiehash", $session['sessionhash'], 0);
	}
}

if (!isset($wbbuserdata)) {
	if (isset($wbb_userid) && $wbb_userid != 0) {
		/** read $wbbuserdata using the function getwbbuserdata() (@see functions.php) **/
		$wbbuserdata = getwbbuserdata($wbb_userid, "userid", 1);
	}
	
	else {
		if (!isset($_COOKIE[$cookieprefix.'lastvisit'])) bbcookie("lastvisit", time(), 0);
		/**read $wbbuserdata using the function getwbbuserdata() - search for grouptype .. (@see functions.php) **/
		$wbbuserdata = getwbbuserdata(1, "grouptype", 1);
		$wbbuserdata['userid'] = 0;
		$wbbuserdata['username'] = "guest"; //default guestname
		if (!isset($_COOKIE[$cookieprefix.'lastvisit'])) $wbbuserdata['lastvisit'] = time();
		else $wbbuserdata['lastvisit'] = intval($_COOKIE[$cookieprefix.'lastvisit']);
		$wbbuserdata['lastactivity'] = time();
		$wbbuserdata['showsignatures'] = $default_register_showsignatures;
		$wbbuserdata['showavatars'] = $default_register_showavatars;
		$wbbuserdata['showimages'] = $default_register_showimages;
		$wbbuserdata['timezoneoffset'] = $default_timezoneoffset;
		$wbbuserdata['usecookies'] = $default_register_usecookies;
		$wbbuserdata['threadview'] = $default_register_threadview;
		$wbbuserdata['startweek'] = $default_startweek;
		$wbbuserdata['styleid'] = 0;
		$wbbuserdata['pmpopup'] = 0;
		$wbbuserdata['buddylist'] = "";
		$wbbuserdata['ignorelist'] = "";
		$wbbuserdata['umaxposts'] = 0;
		$wbbuserdata['daysprune'] = 0;
		
		if ($wbbuserdata['lastactivity'] < time() - $sessiontimeout) {
			bbcookie("lastvisit", $wbbuserdata['lastactivity'], 0);
			$wbbuserdata['lastvisit'] = $wbbuserdata['lastactivity'];
		}
	} 
}
$sid = $session['sessionhash'];
unset($session['sessionhash']);
$session['hash'] = $sid;


if (isset($falsecookiehash)) {
	bbcookie("cookiehash", $session['hash'], 0);
}

if (isset($_COOKIE[$cookieprefix.'cookiehash']) && !isset($falsecookiehash)) {
	$SID_ARG_1ST = '';
	$SID_ARG_2ND = '';
	$SID_ARG_2ND_UN = '';
	$session['hash'] = '';
}
else {
	$SID_ARG_1ST = "?sid=$sid";
	$SID_ARG_2ND = "&amp;sid=$sid";
	$SID_ARG_2ND_UN = "&sid=$sid";
}

if (isset($styleid)) $wbbuserdata['styleid'] = $styleid;
if (isset($langid)) $wbbuserdata['langid'] = $langid;
if (!isset($wbbuserdata['dateformat']) || !$wbbuserdata['dateformat']) $wbbuserdata['dateformat'] = $dateformat;
if (!isset($wbbuserdata['timeformat']) || !$wbbuserdata['timeformat']) $wbbuserdata['timeformat'] = $timeformat;

if ($wbbuserdata['userid'] != 0) {
	$pmpopup_reset = (($wbbuserdata['pmpopup'] == 2 && (!isset($_POST) || count($_POST) == 0) && $filename != "attachment.php" && $filename != "attachmentedit.php" && $filename != "logout.php" && $filename != "markread.php" && $filename != "misc.php" && $filename != "modcp.php" && $filename != "polledit.php" && $filename != "register.php" && $filename != "search.php" && ($filename != "thread.php" || !isset($_REQUEST['goto'])) && $filename != "threadrating.php" && $filename != "usercp.php") ? (", pmpopup=1") : (""));
	
	if ($wbbuserdata['lastactivity'] < time() - $sessiontimeout) {
		if ($offline != 1 || $wbbuserdata['can_view_off_board'] != 0) {
			$db->unbuffered_query("UPDATE bb".$n."_users SET lastvisit=lastactivity, lastactivity = '".time()."', langid='$wbbuserdata[langid]'".$pmpopup_reset." WHERE userid = '$wbbuserdata[userid]'", 1);
			$wbbuserdata['lastvisit'] = $wbbuserdata['lastactivity'];
			$wbbuserdata['lastactivity'] = time();
		}
		checkPosts4AI();
		sessionupdate();
	}
	else {
		$db->unbuffered_query("UPDATE bb".$n."_users SET lastactivity = '".time()."', langid='$wbbuserdata[langid]'".$pmpopup_reset." WHERE userid = '$wbbuserdata[userid]'", 1);
		$wbbuserdata['lastactivity'] = time();
	}
}

if (isset($authentificationcode)) $session['authentificationcode'] = $authentificationcode;
?>
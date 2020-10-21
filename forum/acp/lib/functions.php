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
// * $Date: 2005-05-02 15:31:29 +0200 (Mon, 02 May 2005) $
// * $Author: Burntime $
// * $Rev: 1601 $
// ************************************************************************************//


/**
* use stripslashes on all array elements
* 
* @param array array to which stripslashes should be applied
* @return array new array
*/
function stripslashes_array(&$array) {
	reset($array);
	while (list($key, $val) = each($array)) {
		if (is_string($val)) $array[$key] = stripslashes($val);
		elseif (is_array($val)) $array[$key] = stripslashes_array($val);
	}
	return $array;
}


/**
* use wbb_trim on all array elements
* 
* @param array array to which wbb_trim should be applied
* @return array new array
*/
function trim_array(&$array) {
	reset($array);
	while (list($key, $val) = each($array)) {
		if (is_array($val)) $array[$key] = trim_array($val);
		elseif (is_string($val)) $array[$key] = wbb_trim($val);  
	}
	return $array;
}


/**
* use intval on all array elements
* 
* @param array array to which intval should be applied
* @return array new array
*/
function intval_array(&$array) {
	reset($array);
	while (list($key, $val) = each($array)) {
		if (is_array($val)) $array[$key] = intval_array($val);
		else $array[$key] = intval($val);
	}
	return $array;
}


/**
* setcookie function
*
* @param string name
* @param strinv value
* @param integer time
*
* @return void
*/
function bbcookie($name, $value, $time) {
	global $cookiepath, $cookiedomain, $cookieprefix, $_SERVER;
 
	if ($_SERVER['SERVER_PORT'] == '443') $ssl = 1;
	else $ssl = 0;
	
	setcookie($cookieprefix.$name, $value, $time, $cookiepath, $cookiedomain, $ssl);
}


/**
* sendmail function
*
* @param string email
* @param string subject
* @param string text
* @param string sender
* @param string other
*
* @return boolean mail
*/
function mailer($email, $subject, $text, $sender = '', $other = '') {
	global $frommail, $master_board_name, $smtp, $socket, $mailer_use_f_param;
	if ($socket && function_exists('fsockopen')) {
		global $mail_container;
		if (!isset($mail_container)) $mail_container = &new smtp_socket;
		return $mail_container->mail($email, $subject, $text, $sender, $other);
	}
	if ($smtp && ini_get('SMTP') != $smtp) {
		@ini_set('SMTP', $smtp);
		$smtp = '';
	}
	
	if ($mailer_use_f_param) return @wbb_mail($email, $subject, $text, "From: ".($sender ? $sender : $frommail).$other, "-f $frommail");
	else return @wbb_mail($email, $subject, $text, "From: ".($sender ? $sender : $frommail).$other);
}


/**
* generate an a href tag
*
* @param string url
* @param string name
* @param string target
*
* @return string a tag
*/
function makehreftag($url, $name, $target = '') {
	return "<a href=\"".$url."\"".(($target != '') ? (" target=\"".$target."\"") : ("")).">".$name."</a>";
}


/**
* generate a img tag
*
* @param string path
* @param string alt
* @param integer usehtmlconverter
*
* @return string img tag
*/
function makeimgtag($path, $alt = '', $usehtmlconverter = 1) {
 	if ($alt != '' && $usehtmlconverter == 1) $alt = htmlconverter($alt);
 
 	$path = replaceImagefolder($path);
 
 	return "<img src=\"".$path."\" border=\"0\" alt=\"".$alt."\" title=\"".$alt."\" />";
}


/**
* format an unix timestamp
*
* @param string timeformat
* @param integer timestamp
* @param integer replacetoday
*
* @return string date
*/
function formatdate($timeformat, $timestamp, $replacetoday = 0) {
	global $wbbuserdata, $lang;
	$summertime = date('I', $timestamp) * 3600;
	$timestamp += 3600 * intval($wbbuserdata['timezoneoffset']) + $summertime;
	if ($replacetoday == 1) {
		if (gmdate('Ymd', $timestamp) == gmdate('Ymd', time() + 3600 * intval($wbbuserdata['timezoneoffset']) + $summertime)) {
			return $lang->get('LANG_GLOBAL_TODAY');
		}
		elseif (gmdate('Ymd', $timestamp) == gmdate('Ymd', time() - 86400 + 3600 * intval($wbbuserdata['timezoneoffset']) + $summertime)) {
			return $lang->get('LANG_GLOBAL_YESTERDAY');
		}
	}
	
	return htmlconverter(gmdate($timeformat, $timestamp));
}


/**
* get the subboardlist fo a boardid
*
* @param integer boardid
*
* @return string subboardlist
*/
function getSubboards($boardid) {
	global $boardcache, $session, $SID_ARG_1ST, $SID_ARG_2ND, $SID_ARG_2ND_UN, $tpl, $permissioncache, $lang, $wbbuserdata;

	if (!isset($boardcache[$boardid])) return;

	$subboardbit = '';

	while (list($key1, $val1) = each($boardcache[$boardid])) {
		while (list($key2, $boards) = each($val1)) {
			if (!isset($permissioncache[$boards['boardid']]['can_view_board']) || $permissioncache[$boards['boardid']]['can_view_board'] == -1) $permissioncache[$boards['boardid']]['can_view_board'] = $wbbuserdata['can_view_board'];
			if ($boards['invisible'] == 2 || !$permissioncache[$boards['boardid']]['can_view_board']) continue;

			$boards['title'] = getlangvar($boards['title'], $lang);

			eval("\$subboardbit .= \"".$tpl->get("index_subboardbit")."\";");
			$subboardbit .= getSubboards($boards['boardid']);
		}
	}
	return $subboardbit;
}


/**
* make the boardlist for indexpage
*
* @param integer boardid
* @param integer depth
*
* @return string boardbit
*/
function makeboardbit($boardid, $depth = 1) {
	global $db, $style, $lang, $n, $tpl, $boardcache, $boardvisit, $visitcache, $permissioncache, $modcache, $wbbuserdata, $session, $hidecats, $index_depth, $show_subboards, $showlastposttitle, $dateformat, $timeformat, $showuseronlineinboard, $filename, $temp_boardid, $hide_modcell, $SID_ARG_1ST, $SID_ARG_2ND, $SID_ARG_2ND_UN;

	if (!isset($boardcache[$boardid])) return;
	reset($boardcache[$boardid]);

	$boardbit = '';
	while (list($key1, $val1) = each($boardcache[$boardid])) {
		while (list($key2, $boards) = each($val1)) {
			if (!isset($permissioncache[$boards['boardid']]['can_view_board']) || $permissioncache[$boards['boardid']]['can_view_board'] == -1) $permissioncache[$boards['boardid']]['can_view_board'] = $wbbuserdata['can_view_board'];
			if (!isset($permissioncache[$boards['boardid']]['can_enter_board']) || $permissioncache[$boards['boardid']]['can_enter_board'] == -1) $permissioncache[$boards['boardid']]['can_enter_board'] = $wbbuserdata['can_enter_board'];
			if ($boards['invisible'] == 2 || !$permissioncache[$boards['boardid']]['can_view_board']) continue;

			$boards['title'] = getlangvar($boards['title'], $lang);
			$boards['description'] = getlangvar($boards['description'], $lang, 0);

			$subboardbit = '';
			$subboards = '';

			if ($show_subboards == 1 && (($boards['isboard'] == 1 && $depth == $index_depth) || (isset($hidecats[$boards['boardid']]) && $hidecats[$boards['boardid']] == 1) || ($depth == $index_depth && !isset($hidecats[$boards['boardid']])))) {
				$subboardbit = getSubboards($boards['boardid']);
				if ($subboardbit) $subboardbit = wbb_substr($subboardbit, 0, -2);
			}

			if ($wbbuserdata['lastvisit'] > $boards['lastposttime'] || $boards['lastvisit'] > $boards['lastposttime']) $onoff = 'off';
			else {
				$onoff = 'off';
				$tempids = explode(',', "$boards[boardid],$boards[childlist]");
				$tempids_count = count($tempids);
				for ($j = 0; $j < $tempids_count; $j++) {
					if ($tempids[$j] == 0) continue;
					if (is_array($visitcache[$tempids[$j]]) && count($visitcache[$tempids[$j]])) {
						reset($visitcache[$tempids[$j]]);
						while (list($threadid, $lastposttime) = each($visitcache[$tempids[$j]])) {
							if ($lastposttime > $boardvisit[$tempids[$j]]) {
								$onoff = 'on';
								break 2;
							} // end if
						} // end while
					} // end if
				} // end for	
			} // end else

			if ($boards['isboard']) { 
				if ($boards['externalurl'] != '') $onoff = 'link';
				elseif ($boards['closed'] == 1 || !$permissioncache[$boards['boardid']]['can_enter_board']) $onoff .= 'closed';
				$useronlinebit = '';
				$guestcount = 0;
				if ($showuseronlineinboard == 2 && $boards['externalurl'] == '') {
					global $userinboard, $online;

					if (isset($userinboard[$boards['boardid']]) && count($userinboard[$boards['boardid']])) {
						while (list($key, $row) = each($userinboard[$boards['boardid']])) {
							if ($row['userid'] == 0) $guestcount++;
							else $online->user($row['userid'], htmlconverter($row['username']), $row['useronlinemarking'], $row['invisible']);
						}

						$useronlinebit = $online->useronlinebit;

						if ($guestcount == 1) $useronline_GUEST = $lang->items['LANG_START_USERONLINE_GUEST_ONE'];
						elseif ($guestcount > 1) $useronline_GUEST = $lang->items['LANG_START_USERONLINE_GUEST'];
						else $useronline_GUEST = '';

						if ($guestcount > 0 && $useronlinebit != '') $useronline_AND = $lang->items['LANG_START_USERONLINE_AND'];
						else $useronline_AND = '';

						if ($guestcount > 0 || $useronlinebit != '') {
							if ($guestcount == 0) $guestcount = '';
							
							$boards['useronline'] = $lang->get("LANG_START_USERACTIVE", array('$useronlinebit' => $useronlinebit, '$useronline_AND' => $useronline_AND, '$guestcount' => $guestcount, '$useronline_GUEST' => $useronline_GUEST));
							$boards['useronline'] = wbb_trim($boards['useronline']);
						}

						$online->useronlinebit = '';
					}
				}

				if ($showuseronlineinboard == 1 && $boards['externalurl'] == '') {
					$guestcount = '';
					$useronline_GUEST = '';
					$useronline_AND = '';
					$useronlinebit = $boards['useronline'];
					
					$boards['useronline'] = $lang->get("LANG_START_USERACTIVE", array('$useronlinebit' => $useronlinebit, '$useronline_AND' => $useronline_AND, '$guestcount' => $guestcount, '$useronline_GUEST' => $useronline_GUEST));
					$boards['useronline'] = wbb_trim($boards['useronline']);
				}

				if ($boards['threadcount']) {
					$boards['lastposter'] = htmlconverter($boards['lastposter']);

					$lastpostdate = formatdate($wbbuserdata['dateformat'], $boards['lastposttime'], 1); 
					$lastposttime = formatdate($wbbuserdata['timeformat'], $boards['lastposttime']); 
					if ($showlastposttitle == 1) {
						if ($permissioncache[$boards['boardid']]['can_enter_board']) {
							if (wbb_strlen($boards['topic']) > 30) $topic = wbb_substr($boards['topic'], 0, 30).'...';
							else $topic = $boards['topic'];

							$topic = htmlconverter($topic);
							$boards['topic'] = htmlconverter($boards['topic']);
						}
						if (isset($boards['iconid'])) $ViewPosticon = makeimgtag($boards['iconpath'], getlangvar($boards['icontitle'], $lang), 0);
						else $ViewPosticon = makeimgtag($style['imagefolder'].'/icons/icon14.gif');
					}
				}

				$moderatorbit = '';
				if (isset($modcache[$boards['boardid']])) {
					while (list($mkey, $moderator) = each($modcache[$boards['boardid']])) {
						$moderator['username'] = htmlconverter($moderator['username']);
						eval("\$moderatorbit .= \"".$tpl->get("index_moderatorbit")."\";");
					}
				}

				if ($boards['postcount'] >= 1000) $boards['postcount'] = number_format($boards['postcount'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
				if ($boards['threadcount'] >= 1000) $boards['threadcount'] = number_format($boards['threadcount'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));

				eval("\$boardbit .= \"".$tpl->get("index_boardbit")."\";");

			}
			else {
				$show_hide = 0;
				if ($boards['childlist'] != '0') {
					if ((isset($hidecats[$boards['boardid']]) && $hidecats[$boards['boardid']] == 0) || ($depth < $index_depth && (!isset($hidecats[$boards['boardid']]) || $hidecats[$boards['boardid']] != 1))) {
						$show_hide = 1;

						if ($filename == 'index.php') $current_url = "index.php?hidecat=".$boards['boardid']. $SID_ARG_2ND;
						else $current_url = "board.php?boardid=$temp_boardid&amp;hidecat=".$boards['boardid']. $SID_ARG_2ND;

						$LANG_START_DEACTIVATE_CAT = $lang->get("LANG_START_DEACTIVATE_CAT", array('$title' => $boards['title']));
					}
					else {
						$show_hide = 2;

						if ($filename == 'index.php') $current_url = "index.php?showcat=".$boards['boardid']. $SID_ARG_2ND;
						else $current_url = "board.php?boardid=$temp_boardid&amp;showcat=".$boards['boardid']. $SID_ARG_2ND;

						$LANG_START_SHOWCAT = $lang->get("LANG_START_SHOWCAT", array('$title' => $boards['title']));
					}
				}
				eval("\$boardbit .= \"".$tpl->get("index_catbit")."\";");
			}
			if ((isset($hidecats[$boards['boardid']]) && $hidecats[$boards['boardid']] == 0) || ($depth < $index_depth && (!isset($hidecats[$boards['boardid']]) || $hidecats[$boards['boardid']] != 1))) $boardbit .= makeboardbit($boards['boardid'], $depth + 1);
		} 
	} 
	unset($boardcache[$boardid]);

	return $boardbit;
}


/**
* generate the board navigationbar
*
* @param string parentlist
* @param string template
*
* @return string navbar
*/
function getNavbar($parentlist, $template = 'navbar_board') {
	global $db, $n, $session, $url2board, $lines, $tpl, $boardnavcache, $lang, $SID_ARG_1ST, $SID_ARG_2ND, $SID_ARG_2ND_UN;
	if ($parentlist == '0') return;
	else {
		$navbar = '';
		if (!isset($boardnavcache) || !is_array($boardnavcache) || !count($boardnavcache)) {
			$result = $db->unbuffered_query("SELECT boardid, title FROM bb".$n."_boards WHERE boardid IN ($parentlist)");
			while ($row = $db->fetch_array($result)) {
				$boardnavcache[$row['boardid']] = $row;
			}
		}
		$parentids = explode(',', $parentlist);
		$parentids_count = count($parentids);
		for ($i = 1; $i < $parentids_count; $i++) {
			if ($template == 'print_navbar') $lines .= str_repeat('-', $i);
			$board = $boardnavcache[$parentids[$i]];
			$board['title'] = getlangvar($board['title'], $lang);
			eval("\$navbar .= \"".$tpl->get($template)."\";");
		}
		return $navbar;
	}
}


/**
* generate the codebuttons for the message forms
*
* @return string bbcode_buttons
*/
function getcodebuttons() {
	global $_COOKIE, $tpl, $style, $lang, $session, $SID_ARG_1ST, $SID_ARG_2ND, $SID_ARG_2ND_UN;

	$modechecked = array('', '');
	if ($_COOKIE['bbcodemode'] == 1) $modechecked[1] = "checked=\"checked\"";
	else $modechecked[0] = "checked=\"checked\"";

	eval("\$bbcode_sizebits = \"".$tpl->get("bbcode_sizebits")."\";");
	eval("\$bbcode_fontbits = \"".$tpl->get("bbcode_fontbits")."\";");
	eval("\$bbcode_colorbits = \"".$tpl->get("bbcode_colorbits")."\";");
	eval("\$bbcode_buttons = \"".$tpl->get("bbcode_buttons")."\";");
	return $bbcode_buttons;
}


/**
* generate the smilielist for message forms
*
* @param integer tableColumns
* @param integer maxSmilies
*
* @return string bbcode_smilies
*/
function getclickysmilies($tableColumns = 3, $maxSmilies = -1) {
	global $db, $n, $tpl, $showsmiliesrandom, $style, $lang, $session, $SID_ARG_1ST, $SID_ARG_2ND, $SID_ARG_2ND_UN;

	if ($showsmiliesrandom == 1) $result = $db->query("SELECT smiliepath, smilietitle, smiliecode FROM bb".$n."_smilies ORDER BY RAND()");
	else $result = $db->query("SELECT smiliepath, smilietitle, smiliecode FROM bb".$n."_smilies ORDER BY smilieorder ASC");
	$totalSmilies = $db->num_rows($result);

	if (($maxSmilies == -1) || ($maxSmilies >= $totalSmilies)) $maxSmilies = $totalSmilies;
	elseif ($maxSmilies < $totalSmilies) eval("\$bbcode_smilies_getmore = \"".$tpl->get("bbcode_smilies_getmore")."\";");

	$i = 0;
	while ($row = $db->fetch_array($result)) {
		$row['smilietitle'] 	= getlangvar($row['smilietitle'], $lang);
		$row['smiliepath'] 	= replaceImagefolder($row['smiliepath']);
		$row['smiliecode']	= addcslashes($row['smiliecode'], "'\\");

		eval("\$smilieArray[\"".$i."\"] = \"".$tpl->get("bbcode_smiliebit")."\";");
		$i++;
	}

	$tableRows = ceil($maxSmilies / $tableColumns);
	$count = 0;
	$smiliebits = '';
	for ($i = 0; $i < $tableRows; $i++) {
		$smiliebits .= "\t<tr>\n";
		for ($j = 0; $j < $tableColumns; $j++) {
			$smiliebits .= $smilieArray[$count];
			$count++;
			
			if ($count >= $maxSmilies) {
				$repeat = $tableColumns - ($j + 1);
				if ($repeat > 0) $smiliebits .= str_repeat('<td class="tableb"></td>', $repeat);
				break;
			}
		}
		$smiliebits .= "\t</tr>\n";
	}

	$lang->items['LANG_POSTINGS_SMILIE_COUNT'] = $lang->get("LANG_POSTINGS_SMILIE_COUNT", array('$maxSmilies' => $maxSmilies, '$totalSmilies' => $totalSmilies));
	eval("\$bbcode_smilies = \"".$tpl->get("bbcode_smilies")."\";");
	return $bbcode_smilies;
}



function getAppletSmilies() {
	static $splitString = '^@~|';
	global $db, $n, $lang, $url2board;
	
	$smilies = '';
	$result = $db->query("SELECT smiliepath, smilietitle, smiliecode FROM bb".$n."_smilies ORDER BY smilieorder ASC");
	while ($row = $db->fetch_array($result)) {
		if ($smilies != '') $smilies .= $splitString;
		
		$row['smilietitle'] 	= getlangvar($row['smilietitle'], $lang);
		$row['smiliepath'] 	= replaceImagefolder($row['smiliepath']);
		if (!preg_match("!^http://!", $row['smiliepath'])) $row['smiliepath'] = $url2board . "/" . $row['smiliepath'];
		$row['smiliecode']	= addcslashes($row['smiliecode'], "\"\\");	
	
		$smilies .= $row['smiliecode'] . $splitString . $row['smilietitle'] . $splitString . $row['smiliepath'];
	}
	
	return $smilies;
}


/** 
* if number is odd get element one otherweise element two
*
* @param integer number
* @param mixed one
* @param mixed two
*
* @return mixed element
*/
function getone($number, $one, $two) {
	if ($number & 1) return $one;
	else return $two;
}


/**
* generate the boardlist for boardjump
*
* @param integer current boardid
*
* @return string boardjump
*/
function makeboardjump($current) {
	global $wbbuserdata, $boardcache, $permissioncache, $useuseraccess, $tpl, $session, $boardnavcache, $style, $lang, $SID_ARG_1ST, $SID_ARG_2ND, $SID_ARG_2ND_UN;

	if (!isset($boardcache) || !isset($permissioncache)) {
		global $db, $n, $wbbuserdata, $boardordermode;

		switch ($boardordermode) {
			case 1: $boardorder = 'title ASC'; break;
			case 2: $boardorder = 'title DESC'; break;
			case 3: $boardorder = 'lastposttime DESC'; break;
			default: $boardorder = 'boardorder ASC'; break;
		}

		$result = $db->unbuffered_query("SELECT boardid, parentid, boardorder, title, invisible FROM bb".$n."_boards ORDER by parentid ASC, $boardorder");
		while ($row = $db->fetch_array($result)) {
			$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
			$boardnavcache[$row['boardid']] = $row;
		}
		$permissioncache = getPermissions();
	}
	if (is_array($boardcache) && count($boardcache)) {
		reset($boardcache);
		$boardoptions = makeboardselect(0, 1, $current);
	}
	eval("\$boardjump = \"".$tpl->get("boardjump")."\";");
	return $boardjump;
}


/**
* generate a general boardlist
*
* @param integer boardid
* @param integer depth
* @param integer current
* @param string catmarking
*
* @return string boardlist
*/
function makeboardselect($boardid, $depth = 1, $current = 0, $catmarking = '%s') {
	global $boardcache, $permissioncache, $accesscache, $wbbuserdata, $lang;

	if (!isset($boardcache[$boardid])) return;
	$boardbit = '';
	while (list($key1, $val1) = each($boardcache[$boardid])) {
		while (list($key2, $boards) = each($val1)) {
			if (!isset($permissioncache[$boards['boardid']]['can_view_board']) || $permissioncache[$boards['boardid']]['can_view_board'] == -1) $permissioncache[$boards['boardid']]['can_view_board'] = $wbbuserdata['can_view_board'];
			if ($boards['invisible'] == 2 || !$permissioncache[$boards['boardid']]['can_view_board']) continue;
			if ($depth > 1) $prefix = str_repeat('--', $depth - 1).' ';
			else $prefix = '';

			$boards['title'] = getlangvar($boards['title'], $lang);
			if (((isset($boards['externalurl']) && $boards['externalurl'] != '') || (isset($boards['isboard']) && !$boards['isboard'])) && $catmarking != '%s') $boards['title'] = sprintf($catmarking, $boards['title']);
			$boardbit .= makeoption($boards['boardid'], $prefix.$boards['title'], $current, 1);
			$boardbit .= makeboardselect($boards['boardid'], $depth + 1, $current, $catmarking);
		} 
	} 
	unset($boardcache[$boardid]);
	return $boardbit;	
}


/**
* format rank images
*
* @param string images
* 
* @return string images
*/
function formatRI($images) {
	if (!$images) return;

	$imgArray = explode(';', $images);

	$RI = '';
	$imgArray_count = count($imgArray);
	for ($i = 0; $i < $imgArray_count; $i++) $RI .= makeimgtag($imgArray[$i]);

	return $RI;
}


/**
* build URLs for parseURL
*
* @param string url
* @param integer id
* @param integer ispost
*
* @return string locallink
*/
function makeLocalLink($url, $id, $ispost = 0) {
	global $threadcache, $postidcache;

	$threadid = 0;
 	
 	if ($ispost == 1 && isset($postidcache[$id])) $threadid = $postidcache[$id];
 	else $threadid = $id;
 	
 	if ($threadid != 0 && isset($threadcache[$threadid])) return "[url=".$url."]".$threadcache[$threadid]."[/url]";
 	else return "[url]".$url."[/url]";
}


/**
* parse URLs in post
*
* @param string message
*
* @return string message
*/
function parseURL($message) {
	global $db, $n, $threadcache, $postidcache, $usecode, $url2board, $boardurls;

	static $idnList = array(224, 225, 226, 227, 228, 229, 230, 231, 232, 233, 234, 235, 240, 236, 237, 238, 239, 241, 242, 243, 244, 245, 246, 248, 254, 249, 250, 251, 252, 253, 255);
	
	$idnChars = '';
	for ($i = 0, $j = count($idnList); $i < $j; $i++) {
		$idnChars .= chr($idnList[$i]);
	}
	
	$boardURL = str_replace("\n", "|", preg_quote(wbb_trim($url2board . "\n" . dos2unix($boardurls)), "%"));
	
	$threadid_pattern 	= "((".$boardURL.")/thread\.php.*threadid=([0-9]+)(&.*)?)";
 	$postid_pattern		= "((".$boardURL.")/thread\.php.*postid=([0-9]+)(&.*)?(#.*)?)";
 	
	// before parsing urls replace code tags with hash values
	// to avoid URLs within code tags to be altered
	if ($usecode == 1) {
		$parsecode = &new parsecode;
   		$message = $parsecode->doparse($message);
	}
	
 	$urlsearch[]	= "/([^]@_a-z0-9-=\"'\/])((https?|ftp):\/\/|www\.)([^ \r\n\(\)\^\$!`\"'\|\[\]\{\}<>]*)/si";
 	$urlsearch[]	= "/^((https?|ftp):\/\/|www\.)([^ \r\n\(\)\^\$!`\"'\|\[\]\{\}<>]*)/si";
 	$urlreplace[]	= "\\1[URL]\\2\\4[/URL]";
 	$urlreplace[]	= "[URL]\\1\\3[/URL]";
 	$emailsearch[]	= "/([\s])([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z" . $idnChars . "0-9-]+(\.[a-zA-Z" . $idnChars . "0-9-]+)*(\.[a-zA-Z]{2,}))/si";
 	$emailsearch[]	= "/^([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z" . $idnChars . "0-9-]+(\.[a-zA-Z" . $idnChars . "0-9-]+)*(\.[a-zA-Z]{2,}))/si";
	$emailreplace[]	= "\\1[EMAIL]\\2[/EMAIL]";
 	$emailreplace[]	= "[EMAIL]\\0[/EMAIL]";
 	$message	= preg_replace($urlsearch, $urlreplace, $message);
 	if (wbb_strpos($message, '@')) $message = preg_replace($emailsearch, $emailreplace, $message);


	// cache vars
	$threadcache = array();
	$postidcache = array();

	// get threadids & postids
 	$catched_threadids = array();
 	$catched_postids = array();
  	
	preg_replace("%\[url\]".$threadid_pattern."\[/url\]%ieU", "\$catched_threadids[]=\\3;", $message);
	preg_replace("%\[url\]".$postid_pattern."\[/url\]%ieU", "\$catched_postids[]=\\3;", $message);
	
	if (count($catched_threadids) || count($catched_postids)) {
		// get visible boards
		$result = $db->query("SELECT boardid,boardorder,parentid,parentlist FROM bb".$n."_boards WHERE password='' ORDER BY parentid ASC, boardorder ASC");
		while ($row = $db->fetch_array($result)) $boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
		
		$boardpermissions = getPermissions();
		$boardids = '';
		foreach ($boardcache as $key => $val) {
			foreach ($val as $key2 => $val2) {
				foreach ($val2 as $row) if (!isset($boardpermissions[$row['boardid']]['can_enter_board']) || $boardpermissions[$row['boardid']]['can_enter_board'] != 0) $boardids .= ','.$row['boardid'];
			}	
		}	
		
		// get threadids
		if (count($catched_postids)) {
			$result = $db->query("SELECT postid, threadid FROM bb".$n."_posts WHERE postid IN (".implode(",", $catched_postids).")");
			while ($row = $db->fetch_array($result)) {
				$postidcache[$row['postid']]	= $row['threadid'];
				$catched_threadids[]		= $row['threadid'];
			}
			
		}
		
		// get topics
		if (count($catched_threadids)) {
			$catched_threadids = array_unique($catched_threadids);
			$result = $db->query("SELECT threadid, topic FROM bb".$n."_threads WHERE threadid IN (".implode(",", $catched_threadids).") AND boardid IN (0".$boardids.")");
			while ($row = $db->fetch_array($result)) $threadcache[$row['threadid']] = $row['topic'];
		}
		
		if (count($threadcache)) {
			// insert topics
			$message = preg_replace("%\[url\]".$threadid_pattern."\[/url\]%ieU", "makeLocalLink('\\1',\\3)", $message);
			$message = preg_replace("%\[url\]".$postid_pattern."\[/url\]%ieU", "makeLocalLink('\\1',\\3,1)", $message);
		}
	}
	
	// reinsert code
	if ($usecode == 1) {
		$message = $parsecode->replacecode($message);
	}

	return $message;
}


/**
* generates ACP pagelinks
*
* @param string link
* @param integer page
* @param integer pages
* @param integer number
*
* @return string pagelinks
*/
function makePageLink($link, $page, $pages, $number) {
	global $tpl, $lang;
	
	$f_pages = number_format($pages, 0, '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	eval("\$pagelink = \"".$tpl->get("pagelink")."\";");

	if ($page - $number > 1) eval("\$pagelink .= \"".$tpl->get("pagelink_first")."\";");
	if ($page > 1) {
		$temppage = $page - 1;
		eval("\$pagelink .= \"".$tpl->get("pagelink_left")."\";");
	}
	$count = (($page + $number >= $pages) ? ($pages) : ($page + $number));
	for ($i = $page - $number; $i <= $count; $i++) {
		if ($i < 1) $i = 1;
		
		$f_i = $i;
		if ($f_i > 1000) $f_i = number_format($f_i, 0, '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
		if ($i == $page) eval("\$pagelink .= \"".$tpl->get("pagelink_current")."\";");
		else eval("\$pagelink .= \"".$tpl->get("pagelink_nocurrent")."\";");
	}

	if ($page < $pages) {
		$temppage = $page + 1;
		eval("\$pagelink .= \"".$tpl->get("pagelink_right")."\";");
	}
	if ($page + $number < $pages) eval("\$pagelink .= \"".$tpl->get("pagelink_last")."\";");

	return $pagelink;
}


/**
* generate a option tag
* @param string value
* @param string text
* @param string selected value
* @param integer selected
* @param string style
*
* @return string option tag
*/
function makeoption($value, $text, $selected_value = '', $selected = 1, $style = '') {
	$option_selected = '';
	if ($selected == 1) {
		if (is_array($selected_value)) {
			if (in_array($value, $selected_value)) $option_selected = " selected=\"selected\"";
		}
		elseif ($selected_value == $value) $option_selected = " selected=\"selected\"";
	}
	return "<option value=\"$value\"".(($style != '') ? (" style=\"color:$style\"") : ("")).$option_selected.">$text</option>";
}


/**
* get name of a month
*
* @param integer number
*
* @return string month
*/
function getmonth($number) {
	global $months, $lang;
	if (!isset($months)) $months = explode('|', $lang->get("LANG_GLOBAL_MONTHS"));
	return $months[$number - 1];
}


/**
* get name of a day
*
* @param integer number
*
* @return string day
*/
function getday($number) {
	global $days, $lang;
	if (!isset($days)) $days = explode('|', $lang->get("LANG_GLOBAL_DAYS"));
	return $days[$number];
}


/**
* show access error page and die
*
* @param integer isacp
*
* @return void
*/
function access_error($isacp = 0)
{
	if ($isacp == 0)
	{
		global $db, $n, $wbbuserdata, $header, $footer, $headinclude, $session, $sid, $master_board_name, $REQUEST_URI, $tpl, $style, $lang, $usercbar_username, $allowloginencryption, $SID_ARG_1ST, $SID_ARG_2ND, $SID_ARG_2ND_UN;
		
		$update_session = false;
		
		if (!$wbbuserdata['userid'] && $allowloginencryption == 1)
		{
			// force authentificationcode
			$authentificationcode = makeAuthentificationcode(0);
			if ($authentificationcode != $session['authentificationcode'])
			{
				$update_session = true;
				$session['authentificationcode'] = $authentificationcode;
				$db->unbuffered_query("UPDATE bb".$n."_sessions SET authentificationcode = '".addslashes($session['authentificationcode'])."', request_uri='', boardid=0, threadid=0 WHERE sessionhash = '$sid'", 1);
			}
		}
		
		if (!$update_session) $db->unbuffered_query("UPDATE bb".$n."_sessions SET request_uri='', boardid=0, threadid=0 WHERE sessionhash = '$sid'", 1);
		
		$REQUEST_URI = htmlconverter($REQUEST_URI);
		
		$lang->items['LANG_GLOBAL_ACCESS_ERROR_DESC'] = $lang->get("LANG_GLOBAL_ACCESS_ERROR_DESC", array('$SID_ARG_1ST' => $SID_ARG_1ST));
		eval("\$tpl->output(\"".$tpl->get("access_error")."\");");
		exit();
	}
	else
	{
		global $tpl, $lang, $master_board_name;
		eval("\$tpl->output(\"".$tpl->get("access_error", 1)."\",1);");
		exit;
	}
}


/**
* verify an username
* 
* @param string username
*
* @return boolean is_valid
*/
function verify_username($username) {
	global $db, $n, $minusernamelength, $maxusernamelength, $ban_name;

	if (wbb_strlen($username) < $minusernamelength || wbb_strlen($username) > $maxusernamelength) return false;
	$ban_name = explode("\n", preg_replace("/\s*\n\s*/", "\n", wbb_strtolower(wbb_trim($ban_name))));

	$ban_name_count = count($ban_name);
	for ($i = 0; $i < $ban_name_count; $i++) {
		$ban_name[$i] = wbb_trim($ban_name[$i]);
		if (!$ban_name[$i]) continue;
		if (strstr($ban_name[$i], '*')) {
			$ban_name[$i] = str_replace("*", ".*", preg_quote($ban_name[$i], "/"));
			if (preg_match("/$ban_name[$i]/i", $username)) return false;
		}
		elseif (wbb_strtolower($username) == $ban_name[$i]) return false;
	}

	$result = $db->query_first("SELECT COUNT(*) FROM bb".$n."_users WHERE username = '".addslashes($username)."'");
	if ($result[0] != 0) return false;
	else return true;
}


/**
* verify a email
*
* @param string email
*
* @return boolean is_valid
*/
function verify_email($email) {
	global $db, $n, $multipleemailuse, $ban_email;

	static $idnList = array(224, 225, 226, 227, 228, 229, 230, 231, 232, 233, 234, 235, 240, 236, 237, 238, 239, 241, 242, 243, 244, 245, 246, 248, 254, 249, 250, 251, 252, 253, 255);
	
	$idnChars = '';
	for ($i = 0, $j = count($idnList); $i < $j; $i++) {
		$idnChars .= chr($idnList[$i]);
	}
		
	$email = wbb_strtolower($email);
	if (!preg_match("/^([_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z" . $idnChars . "0-9-]+(\.[a-z" . $idnChars . "0-9-]+)*(\.[a-z]{2,}))$/si", $email)) return false;
	$ban_email = explode("\n", preg_replace("/\s*\n\s*/", "\n", wbb_strtolower(wbb_trim($ban_email))));

	$ban_email_count = count($ban_email);
	for ($i = 0; $i < $ban_email_count; $i++) {
		$ban_email[$i] = wbb_trim($ban_email[$i]);
		if (!$ban_email[$i]) continue;
		if (strstr($ban_email[$i], '*')) {
			$ban_email[$i] = str_replace("*", ".*", preg_quote($ban_email[$i], "/"));
			if (preg_match("/$ban_email[$i]/i", $email)) return false;
		}
		elseif ($email == $ban_email[$i]) return false;
	}
	if ($multipleemailuse == 1) return true;
	else {
		$result = $db->query_first("SELECT COUNT(*) FROM bb".$n."_users WHERE email = '".$email."'");
		if ($result[0] != 0) return false;
		else return true;
	}
}


/**
* verify an ip address
*
* @param string ip
*
* @return void
*/
function verify_ip($ip, $throwAccessError = true) {
	global $ban_ip;

	$valid = true;
	
	if ($ban_ip) {
		$ban_ip = explode("\n", preg_replace("/\s*\n\s*/", "\n", wbb_strtolower(wbb_trim($ban_ip))));
  
		$ban_ip_count = count($ban_ip);
		for ($i = 0; $i < $ban_ip_count; $i++) {
			$ban_ip[$i] = wbb_trim($ban_ip[$i]);
			if (!$ban_ip[$i]) continue;
			if (strstr($ban_ip[$i], '*')) {
				$ban_ip[$i] = str_replace("*", ".*", preg_quote($ban_ip[$i], "/"));
				if (preg_match("/$ban_ip[$i]/i", $ip)) $valid = false;
			}
			else if ($ip == $ban_ip[$i]) $valid = false;
		}
	}
	
	if (!$valid && $throwAccessError) access_error();
	
	return $valid;
}


/**
* verify an usertitle
*
* @param string usertitle
*
* @return boolean is_valid
*/
function verify_usertitle($usertitle) {
	global $db, $n, $wbbuserdata, $ban_usertitle;

	if ($wbbuserdata['can_avoid_ban_usertitle'] == 1) return true;
	else
	{
		if (!is_array($ban_usertitle)) $ban_usertitle = explode("\n", preg_replace("/\s*\n\s*/", "\n", wbb_strtolower(wbb_trim($ban_usertitle))));

		$ban_usertitle_count = count($ban_usertitle);
		for ($i = 0; $i < $ban_usertitle_count; $i++) {
			$ban_usertitle[$i] = wbb_trim($ban_usertitle[$i]);
			if (!$ban_usertitle[$i]) continue;
			if (strstr($ban_usertitle[$i], '*')) {
				$ban_usertitle[$i] = str_replace("*", ".*", preg_quote($ban_usertitle[$i], "/"));
				if (preg_match("/$ban_usertitle[$i]/i", $usertitle)) return false;
			}
			elseif (wbb_strtolower($usertitle) == $ban_usertitle[$i]) return false;
		}
		return true;
	}
}


/**
* verify posttime for flood control
*
* @param integer userid
* @param string ipaddress
* @param integer avoid_fc
*
* @return boolean
*/
function flood_control($userid, $ipaddress, $avoid_fc) {
	if ($avoid_fc == 1) return false;

	global $db, $n, $fctime;
	if ($userid) $result = $db->query_first("SELECT postid FROM bb".$n."_posts WHERE userid='$userid' AND posttime>='".(time() - $fctime)."'", 1);	
	else $result = $db->query_first("SELECT postid FROM bb".$n."_posts WHERE ipaddress='$ipaddress' AND posttime>='".(time() - $fctime)."'", 1);	
	if ($result['postid']) return true;
	else return false;	
}


/**
* generate a new random password
*
* @param integer number
* @param integer length
*
* @return string new password
*/
function password_generate($numbers = 2, $length = 8) {
	$time = intval(wbb_substr(microtime(), 2, 8));
	mt_srand($time);

	$numberchain = '1234567890';

	for ($i = 0; $i < $numbers; $i++) {
		$random = mt_rand(0, wbb_strlen($numberchain) - 1);
		$number[intval($numberchain[$random])] = mt_rand(1, 9);
		$numberchain = str_replace($random, '' , $numberchain);
	} 

	$chain = 'abcdefghijklmnopqrstuvwxyz';
	for ($i = 0; $i < $length; $i++) {
		if ($number[$i]) $password .= $number[$i];
		else $password .= $chain[mt_rand(0, wbb_strlen($chain) - 1)];
	}
	return $password;
}


/**
* generate a new activation code
*
* @return string activation code
*/
function code_generate() {
	$time = intval(wbb_substr(microtime(), 2, 8));
	mt_srand($time);

	return mt_rand(1000000, 10000000);
} 


/**
* show an error page and die
*
* @param string error_msg
*
* @return void
*/
function error($error_msg) {
	global $headinclude, $master_board_name, $tpl, $lang;
	eval("\$tpl->output(\"".$tpl->get("error")."\");");
	exit();
}


/**
* show a redirect page and die
*
* @param string msg
* @param string url
* @param integer waittime
*
* @return void
*/
function redirect($msg, $url, $waittime = 5) {
	global $headinclude, $master_board_name, $tpl, $lang;
	eval("\$tpl->output(\"".$tpl->get("redirect")."\");");
	exit();
}


/**
* stop shooting in topic
*
* @param string topic
* 
* @return string topic
*/
function stopShooting($topic) {
	if ($topic == wbb_strtoupper($topic)) return wbb_ucwords(wbb_strtolower($topic));
	return $topic;	
}


/**
* add an element to a list
*
* @param string list
* @param string add
*
* @return string new list
*/
function add2list($list, $add) {
	if ($list == '') return $add;
	else {
		$listelements = explode(' ', $list);
		if (!in_array($add, $listelements)) {
			$listelements[] = $add;
   			return implode(' ', $listelements);
		}
		else return - 1;
	}
}


/**
* wordmatch function
*
* @param integer postid
* @param string message
* @param string topic
*
* @return void
*/
function wordmatch($postid, $message, $topic) {
	global $db, $n, $minwordlength, $maxwordlength, $badsearchwords, $goodsearchwords;

	$topicwords = '';
	$topicwordarray = array();
	$wordcache = array();

	if ($topic) {
		$topicwords = preg_replace("/(\.+)($| |\n|\t)/s", " ", $topic);
		$topicwords = str_replace("[", " [", $topicwords);
		$topicwords = str_replace("]", "] ", $topicwords);
		$topicwords = preg_replace("/[<>\/,\.:;\(\)\[\]?!#{}%_\-+=\\\\]/s", " ", $topicwords);
		$topicwords = preg_replace("/['\"]/s", "", $topicwords);
		$topicwords = preg_replace("/[\s,]+/s", " ", $topicwords); 
		$topicwords = wbb_strtolower(wbb_trim(str_replace("  ", " ", $topicwords)));
		$temparray = explode(" ", $topicwords);
		while (list($key, $val) = each($temparray)) $topicwordarray[$val] = 1;
	}

	$words = preg_replace("/\[quote](.+)\[\/quote\]/siU", "", $message); // remove quotes
	$words = preg_replace("/(\.+)($| |\n|\t)/s", " ", $words);
	$words = str_replace("[", " [", $words);
	$words = str_replace("]", "] ", $words);
	$words = preg_replace("/[<>\/,\.:;\(\)\[\]?!#{}%_\-+=\\\\]/s", " ", $words);
	$words = preg_replace("/['\"]/s", "", $words);
	$words = preg_replace("/[\s,]+/s", " ", $words);
	$words = wbb_strtolower(wbb_trim(str_replace("  ", " ", $words)));
	if ($topicwords) $words .= " ".$topicwords;
	$wordarray = explode(" ", $words);

	$result = $db->unbuffered_query("SELECT wordid, word FROM bb".$n."_wordlist WHERE word IN ('".str_replace(" ", "','", $words)."')");
	while ($row = $db->fetch_array($result)) $wordcache[$row['word']] = $row['wordid'];

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

	$alreadyadd = array();
	$wordmatch_sql = '';
	$newtopicwords = '';
	$newwords = '';
	while (list($key, $val) = each($wordarray)) {
		if ((!isset($goodwords[$val]) && !$goodwords[$val]) && ((isset($badwords[$val]) && $badwords[$val] == 1) || wbb_strlen($val) < $minwordlength || wbb_strlen($val) > $maxwordlength)) {
			unset($wordarray[$key]);
			continue;
		}

		if ($val && !isset($alreadyadd[$val])) {
			if (isset($wordcache[$val])) $wordmatch_sql .= ",($wordcache[$val],$postid,".(($topicwordarray[$val] == 1) ? (1) : (0)).")";
			else {
				if (isset($topicwordarray[$val]) && $topicwordarray[$val] == 1) $newtopicwords .= $val." ";
				else $newwords .= $val." ";
			}
			$alreadyadd[$val] = 1;
		}
	}

	if ($wordmatch_sql) $db->query("REPLACE INTO bb".$n."_wordmatch (wordid,postid,intopic) VALUES ".wbb_substr($wordmatch_sql, 1));

	if ($newwords) {
		$newwords = wbb_trim($newwords);
		$insertwords = "(NULL,'".str_replace(" ", "'),(NULL,'", addslashes($newwords))."')";
		$db->query("INSERT IGNORE INTO bb".$n."_wordlist (wordid,word) VALUES $insertwords");
		$selectwords = "word IN('".str_replace(" ", "','", addslashes($newwords))."')";
		$db->query("INSERT IGNORE INTO bb".$n."_wordmatch (wordid,postid) SELECT DISTINCT wordid,$postid FROM bb".$n."_wordlist WHERE $selectwords");
	}

	if ($newtopicwords) {
		$newtopicwords = wbb_trim($newtopicwords);
		$insertwords = "(NULL,'".str_replace(" ", "'),(NULL,'", addslashes($newtopicwords))."')";
		$db->query("INSERT IGNORE INTO bb".$n."_wordlist (wordid,word) VALUES $insertwords");
		$selectwords = "word IN('".str_replace(" ", "','", addslashes($newtopicwords))."')";
		$db->query("REPLACE INTO bb".$n."_wordmatch (wordid,postid,intopic) SELECT DISTINCT wordid,$postid,1 FROM bb".$n."_wordlist WHERE $selectwords");
	}
}


/**
* update board information
*
* @param string boardidlist
* @param integer lastposttime
* @param integer lastthreadid
*
* @return void
*/
function updateBoardInfo($boardidlist, $lastposttime = -1, $lastthreadid = -1) {
	global $db, $n;	
	if ($lastthreadid != -1) $result = $db->query("SELECT boardid, childlist FROM bb".$n."_boards WHERE boardid IN ($boardidlist) AND lastthreadid='$lastthreadid'");
	elseif ($lastposttime != -1) $result = $db->query("SELECT boardid, childlist FROM bb".$n."_boards WHERE boardid IN ($boardidlist) AND lastposttime<='$lastposttime'");
	else $result = $db->query("SELECT boardid, childlist FROM bb".$n."_boards WHERE boardid IN ($boardidlist)");
	while ($row = $db->fetch_array($result)) {
		$lastthread = $db->query_first("SELECT threadid, lastposttime, lastposterid, lastposter FROM bb".$n."_threads WHERE boardid IN ($row[boardid],$row[childlist]) AND visible=1 AND closed<>3 ORDER BY lastposttime DESC", 1);
		$db->unbuffered_query("UPDATE bb".$n."_boards SET lastthreadid='$lastthread[threadid]', lastposttime='$lastthread[lastposttime]', lastposterid='$lastthread[lastposterid]', lastposter='".addslashes($lastthread['lastposter'])."' WHERE boardid='$row[boardid]'", 1);
	}	
}


/**
* generate userration result
*
* @param integer count
* @param integer points
* @param integer userid
*
* @return string userrating
*/
function userrating($count, $points, $userid) {
	global $tpl, $lang, $style;

	if ($count != 0) {
		$doubletemp = $points / $count;
		$temp = number_format($doubletemp, 1);
		$rating = number_format($doubletemp, 2, $lang->get("LANG_GLOBAL_DEC_POINT"), $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));

		$width = $temp * 10;
		$LANG_MEMBERS_RATING_RATINGS = $lang->get("LANG_MEMBERS_RATING_RATINGS", array('$count' => $count, '$rating' => $rating));
	}
	eval("\$userrating = \"".$tpl->get("userrating")."\";");
	return $userrating;
}


/**
* converts dos - newlines to unix - newlines
*
* @param string text
*
* @return string text
*/
function dos2unix($text) {
	if ($text != '') {
		$text = preg_replace("#(\r\n)|(\r)#", "\n", $text);
	}
	return $text;
}


/**
* strip crap from posts (i.e. sessionhash
*
* @param string post
* 
* @return string post
*/
function stripcrap($post) {
	if ($post) {
		$post = preg_replace("/(\?|\&){1}sid=[a-z0-9]{32}/", "\\1sid=", $post);	
		$post = preg_replace("/(&#)(\d+)(;)/e", "chr(intval('\\2'))", $post);
		$post = dos2unix($post);
	}
	return $post;
}


/**
* decode cookie data
*
* @param string serialized data
*
* @return array data
*/
function decode_cookie($data) {
	return unserialize($data); 
}


/**
* encode cookie data
*
* @param string name
* @param integer time
*
* @return void
*/
function encode_cookie($name, $time = 0) {
	global $$name, $wbbuserdata;
	bbcookie($name, serialize($$name), $time);	
}


/**
* generate userlevel view
*
* @param integer userposts
* @param integer regdata
*
* @return string userlevel
*/
function userlevel($userposts, $regdate) {
	global $tpl, $lang, $style;

	$regdate = (time() - $regdate) / 86400;
	$exp = ceil($userposts * $regdate);
	if ($exp != 0) $level = pow(log10($exp), 2);
	else $level = 0;
	$showlevel = floor($level) + 1;
	$nextexp = ceil(pow(10, pow($showlevel, 0.5)));
	if ($showlevel == 1) $prevexp = 0;
	else $prevexp = ceil(pow(10, pow($showlevel - 1, 0.5)));

	$width = ceil((($exp - $prevexp) / ($nextexp - $prevexp)) * 100);
	$needexp = number_format($nextexp - $exp, 0, '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));

	$exp = number_format($exp, 0, '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	$nextexp = number_format($nextexp, 0 , '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));

	$LANG_MEMBERS_USERLEVEL_NEEDEXP = $lang->get("LANG_MEMBERS_USERLEVEL_NEEDEXP", array('$needexp' => $needexp));
	eval("\$userlevel = \"".$tpl->get("userlevel")."\";");
	return $userlevel;
}


/**
* format a filesize
*
* @param integer byte
* 
* @return string filesize
*/
function formatFilesize($byte) {
	global $lang;

	$string = 'Byte';
	if ($byte > 1024) {
		$byte /= 1024;
		$string = 'KB';
	}
	if ($byte > 1024) {
		$byte /= 1024;
		$string = 'MB';
	}
	if ($byte > 1024) {
		$byte /= 1024;
		$string = 'GB';
	}	

	if ($byte - number_format($byte, 0) >= 0.005) $byte = number_format($byte, 2, $lang->get("LANG_GLOBAL_DEC_POINT"), $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	else $byte = number_format($byte, 0, '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	return $byte.' '.$string;
}


/**
* get the client ip address
*
* @return string ip address
*/
function getIpAddress() {
	global $_SERVER;

	$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $HTTP_X_FORWARDED_FOR = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else $HTTP_X_FORWARDED_FOR = '';

	if ($HTTP_X_FORWARDED_FOR != '') {
		if (preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $HTTP_X_FORWARDED_FOR, $ip_match)) {
			$private_ip_list = array("/^0\./", "/^127\.0\.0\.1/", "/^192\.168\..*/", "/^172\.16\..*/", "/^10..*/", "/^224..*/", "/^240..*/");
			$REMOTE_ADDR = preg_replace($private_ip_list, $REMOTE_ADDR, $ip_match[1]);	
		}	
	}

	if (wbb_strlen($REMOTE_ADDR) > 16) $REMOTE_ADDR = wbb_substr($REMOTE_ADDR, 0, 16);
	return $REMOTE_ADDR;
}


/** 
* returns an array with user - and groupsettings
*
* @param mixed id
* @param string bywhat
* @param integer issession
*
* @return array data
*/
function getwbbuserdata($id, $bywhat = 'userid', $issession = 0) {
	global $db, $n;
	$wbbuserdata = array();
	$variables = array();
	$groupids = array();
	
	if ($bywhat == 'userid') {
		if ($issession == 0) $wbbuserdata = $db->query_first("SELECT uf.*,u.*,gc.groupids,gc.data FROM bb".$n."_users u LEFT JOIN bb".$n."_groupcombinations gc USING(groupcombinationid) LEFT JOIN bb".$n."_userfields uf ON (uf.userid=u.userid) WHERE u.userid='$id'");
		else {
			global $styleid, $langid;
			$wbbuserdata = $db->query_first("SELECT u.*,gc.groupids,gc.data, s.styleid, s.templatepackid, s.designpackid, l.languagepackid, tp.templatestructure FROM bb".$n."_users u ".
			"LEFT JOIN bb".$n."_groupcombinations gc USING(groupcombinationid) ".
			"LEFT JOIN bb".$n."_styles s ON(s.styleid=".(($issession == 1 && isset($styleid)) ? ("'".intval($styleid)."'") : ("u.styleid")).") ".
			"LEFT JOIN bb".$n."_templatepacks tp ON(tp.templatepackid=s.templatepackid) ".
			"LEFT JOIN bb".$n."_languagepacks l ON(l.languagepackid=".(($issession == 1 && isset($langid)) ? ("'".intval($langid)."'") : ("u.langid")).") ".
			"WHERE u.userid='$id'");

			if (!isset($wbbuserdata['styleid'])) {
				$default_style = $db->query_first("SELECT s.templatepackid, s.designpackid, tp.templatestructure FROM bb".$n."_styles s LEFT JOIN bb".$n."_templatepacks tp ON(tp.templatepackid=s.templatepackid) WHERE s.styleid=0");
				$wbbuserdata['styleid']			= 0; 
				$wbbuserdata['templatepackid']		= $default_style['templatepackid'];
				$wbbuserdata['designpackid']		= $default_style['designpackid'];
				$wbbuserdata['templatestructure']	= $default_style['templatestructure'];
			}

			if (!isset($wbbuserdata['languagepackid'])) $wbbuserdata['languagepackid'] = 0;
		}

		$groupids = explode(',', $wbbuserdata['groupids']);
	}
	elseif ($bywhat == 'groupid') {
		$wbbuserdata = $db->query_first("SELECT data FROM bb".$n."_groupcombinations WHERE groupids='$id'");
		$groupids[] = $id;
	}
	elseif ($bywhat == 'grouptype') {
		if ($issession == 0) $wbbuserdata = $db->query_first("SELECT g.groupid,gc.data FROM bb".$n."_groups g LEFT JOIN bb".$n."_groupcombinations gc ON gc.groupids=g.groupid WHERE g.grouptype='$id'");
		else {
			global $styleid, $langid;	
			$wbbuserdata = $db->query_first("SELECT g.groupid,gc.data, s.styleid, s.templatepackid, s.designpackid, l.languagepackid, tp.templatestructure FROM bb".$n."_groups g ".
			"LEFT JOIN bb".$n."_groupcombinations gc ON gc.groupids=g.groupid ".
			"LEFT JOIN bb".$n."_styles s ON(s.styleid='".intval($styleid)."') ".
			"LEFT JOIN bb".$n."_templatepacks tp ON(tp.templatepackid=s.templatepackid) ".
			"LEFT JOIN bb".$n."_languagepacks l ON(l.languagepackid='".intval($langid)."') ".
			"WHERE g.grouptype='$id'");	

			if (!isset($wbbuserdata['styleid'])) {
				$default_style = $db->query_first("SELECT s.templatepackid, s.designpackid, tp.templatestructure FROM bb".$n."_styles s LEFT JOIN bb".$n."_templatepacks tp ON(tp.templatepackid=s.templatepackid) WHERE s.styleid=0");
				$wbbuserdata['styleid']			= 0; 
				$wbbuserdata['templatepackid']		= $default_style['templatepackid'];
				$wbbuserdata['designpackid']		= $default_style['designpackid'];
				$wbbuserdata['templatestructure']	= $default_style['templatestructure'];
			}

			if (!isset($wbbuserdata['languagepackid'])) $wbbuserdata['languagepackid'] = 0;
		}

		$groupids[] = $wbbuserdata['groupid'];
	}
	elseif ($bywhat == 'username') {
		$wbbuserdata = $db->query_first("SELECT u.*, gc.groupids, gc.data, l.languagepackid FROM bb".$n."_users u LEFT JOIN bb".$n."_groupcombinations gc USING(groupcombinationid) LEFT JOIN bb".$n."_languagepacks l ON (l.languagepackid=u.langid) WHERE u.username='".addslashes($id)."'");
		$groupids = explode(',', $wbbuserdata['groupids']);
	}

	$variables = unserialize($wbbuserdata['data']);
	unset($wbbuserdata['data']);
	if (is_array($variables) && count($variables)) {
		while (list($key, $val) = each($variables)) {
			$wbbuserdata[$key] = $val;
		}
	}
	$wbbuserdata['groupids'] = $groupids;
	return $wbbuserdata;
}




/**
* returns an array of arrays with user- and groupsettings
*
* @param string usernames
* 
* @return array userdatas
*/
function getwbbuserdatas($usernames) {
	global $db, $n;
	static $groupcombinationCache;
	if (!isset($groupcombinationCache)) $groupcombinationCache = array();
	$wbbuserdata = array();
	
	$usernames = explode("\n", $usernames);
	foreach ($usernames as $key => $val) {
		$usernames[$key] = addslashes(wbb_trim($val));
	}

	$result = $db->unbuffered_query("SELECT u.*, gc.groupids, gc.data, l.languagepackid FROM bb".$n."_users u LEFT JOIN bb".$n."_groupcombinations gc USING(groupcombinationid) LEFT JOIN bb".$n."_languagepacks l ON (l.languagepackid=u.langid) WHERE u.username IN ('".implode("','", $usernames)."')");
	while ($row = $db->fetch_array($result)) {
		$wbbuserdata[wbb_strtolower($row['username'])] = $row;
		$wbbuserdata[wbb_strtolower($row['username'])]['groupids'] = explode(',', $wbbuserdata[wbb_strtolower($row['username'])]['groupids']);
		
		if (!isset($groupcombinationCache[$row['groupcombinationid']])) {
			$groupcombinationCache[$row['groupcombinationid']] = unserialize($row['data']);
		}
		unset($wbbuserdata[$row['username']]['data']);
		if (is_array($groupcombinationCache[$row['groupcombinationid']])) {
			$wbbuserdata[wbb_strtolower($row['username'])] = $wbbuserdata[wbb_strtolower($row['username'])] + $groupcombinationCache[$row['groupcombinationid']];
		}
	}
	
	return $wbbuserdata;
}


/**
* returns true if the current user is moderator and has got the permission to perform this action.
*
* @param string function
*
* @return boolean permission
*/
function checkmodpermissions($function = '', $boarddata = '') {
	global $wbbuserdata;
	if ($boarddata != '') $board = $boarddata;
	else {
		global $board;
	}

	if ($function) {
		if (isset($board[$function]) && $board[$function] != -1) return $board[$function];
		elseif ($wbbuserdata['m_is_supermod'] == 1 || (isset($board['moderatorid']) && $board['moderatorid'] == $wbbuserdata['userid'] && $wbbuserdata['userid'])) return $wbbuserdata[$function];
		else return false;
	}
	elseif ($wbbuserdata['m_is_supermod'] == 1 || (isset($board['moderatorid']) && $board['moderatorid'] == $wbbuserdata['userid'] && $wbbuserdata['userid'])) return true;
	else return false;
}


/**
* get the permission for all boards
*
* @return array permissions
*/
function getPermissions() {
	global $db, $n, $wbbuserdata;

	// read in useraccess
	if ($wbbuserdata['userid'] && $wbbuserdata['useuseraccess'] == 1) {
		$useraccesscache = array();
		$result = $db->query("SELECT * FROM bb".$n."_access WHERE userid = '$wbbuserdata[userid]'");
		while ($row = $db->fetch_array($result)) $useraccesscache[$row['boardid']] = $row;
		if (count($useraccesscache)) {
			inheritpermissions(0, $useraccesscache, 'useraccess');
			foreach ($useraccesscache as $row) {
				reset($row);
				while (list($key, $val) = each($row)) if ($val != -1) $wbbuserdata['permissions'][$row['boardid']][$key] = $val;
			}
		}
	}
	
	return $wbbuserdata['permissions'];
}


/**
* check the permissions for the current board
*
* @param string permission
* @param array boarddata
*
* @return boolean permission
*/
function checkpermissions($permission, $boarddata = '') {
	global $wbbuserdata;

	if ($boarddata != '') $board = $boarddata;
	else {
		global $board;
	}

	if (!isset($board[$permission]) || $board[$permission] == -1) return $wbbuserdata[$permission];
	else return $board[$permission];
}


/**
* generate an iconlist
*
* @param integer iconid
*
* @return string iconlist
*/
function getIcons($iconid = 0) {
	global $tpl, $lang, $db, $n, $filename;

	$ICONselected[0] = '';
	$ICONselected[$iconid] = "checked=\"checked\"";

	$result = $db->query("SELECT * FROM bb".$n."_icons ORDER BY iconorder ASC");
	$iconcount = 0;
	$choice_posticons = '';
	while ($row = $db->fetch_array($result)) {
		$row_iconid = $row['iconid'];
		if (!isset($ICONselected[$row_iconid])) $ICONselected[$row_iconid] = '';

		$row['icontitle'] = getlangvar($row['icontitle'], $lang);
		$row['iconpath'] = replaceImagefolder($row['iconpath']);

		eval("\$choice_posticons .= \"".$tpl->get("newthread_iconbit")."\";");
		if ($iconcount == 6) {
			$choice_posticons .= '<br />';
			$iconcount = 0;
		}
		else $iconcount++;
	}

	eval("\$icons = \"".$tpl->get("newthread_icons")."\";");
	return $icons;
}


/** 
* generate a mysql where tag
*
* @param string add
* 
* @return string where
*/
function add2where($add) {
	global $where;
	if ($where) $where .= ' AND '.$add;
	else $where = $add;
}


/**
* format allowed extensions for output
*
* @param string extensions
*
* @return string extensions
*/
function getAllowedExtensions($extensions) {
	$extensions = dos2unix($extensions);
	$a_extensions = explode("\n", $extensions);
	$a_extensions = array_unique($a_extensions);

	$a_temp = $a_extensions;

	while (list($key, $val) = each($a_temp)) {
		if (strstr($val, '*')) {
			reset($a_extensions);
			while (list($key2, $val2) = each($a_extensions)) {
				if ($val != $val2 && preg_match("/".str_replace('*', '[a-z0-9]*', $val).'/', $val2)) unset($a_extensions[$key2]);
			}	
		}	
	}

	return implode(' ', $a_extensions);
}


/**
* htmlconverter function
*
* @param string text
*
* @return string encoded text
*/
function htmlconverter($text) {
	global $phpversion;
	$charsets = array('ISO-8859-1', 'ISO-8859-15', 'UTF-8', 'CP1252', 'WINDOWS-1252', 'KOI8-R', 'BIG5', 'GB2312', 'BIG5-HKSCS', 'SHIFT_JIS', 'EUC-JP');
	
	if (version_compare($phpversion, '4.3.0') >= 0 && in_array(wbb_strtoupper(ENCODING), $charsets)) return @htmlentities($text, ENT_COMPAT, ENCODING);
	elseif (in_array(wbb_strtoupper(ENCODING), array('ISO-8859-1', 'WINDOWS-1252'))) return htmlentities($text);
	else return htmlspecialchars($text);
}


/** 
* rehtmlconverter function
* 
* @param string text
*
* @return string text
*/
function rehtmlconverter($text) {
	global $phpversion;
	$charsets = array('ISO-8859-1', 'ISO-8859-15', 'UTF-8', 'CP1252', 'WINDOWS-1252', 'KOI8-R', 'BIG5', 'GB2312', 'BIG5-HKSCS', 'SHIFT_JIS', 'EUC-JP');
	
	if (version_compare($phpversion, '4.3.0') >= 0 && in_array(wbb_strtoupper(ENCODING), $charsets)) return @html_entity_decode($text, ENT_COMPAT, ENCODING);
	elseif (in_array(wbb_strtoupper(ENCODING), array('ISO-8859-1', 'WINDOWS-1252'))) $trans_tbl = get_html_translation_table(HTML_ENTITIES);
	else $trans_tbl = get_html_translation_table(HTML_SPECIALCHARS);
	$trans_tbl = array_flip($trans_tbl);
	return strtr($text, $trans_tbl);
}


/** 
* generate the threadrating view
*
* @param integer votepoints
* @param integer voted
*
* @return string threadrating
*/
function threadrating($votepoints, $voted) {
	global $tpl, $lang, $style;

	$avarage = $votepoints / $voted;
	$rating = round($avarage);

	$avarage = number_format($avarage, 2, $lang->get("LANG_GLOBAL_DEC_POINT"), $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	$LANG_GLOBAL_THREAD_RATING = $lang->get("LANG_GLOBAL_THREAD_RATING", array('$voted' => $voted, '$avarage' => $avarage));
	
	if ($rating < 6) {
		$rating = 6 - $rating;
		$img = makeimgtag($style['imagefolder']."/thumbs_down.gif", $LANG_GLOBAL_THREAD_RATING);
	}
	else {
		$rating -= 5;	
		$img = makeimgtag($style['imagefolder']."/thumbs_up.gif", $LANG_GLOBAL_THREAD_RATING);
	}

	return str_repeat($img, $rating);
}
 

/** 
* new textwrap function from class_parse
*
* @param string text
* @param integer wrapwidth
*
* @return string text
*/
function textwrap($text, $wrapwidth = 40) {
	if ($text && wbb_strlen($text) > $wrapwidth) {
		$text = preg_replace("/([^\n\r -]{".$wrapwidth."})/i", " \\1\n", $text);
		return $text;
	}
	else return $text;
}


/** 
* get the boardinfo and permissions for the current board 
*
* @param integer boardid
*
* @return array data
*/
function getBoardAccessData($boardid) {
	global $wbbuserdata, $db, $n, $filename, $lang;
	$select = '';
	$join = '';

	if ($wbbuserdata['userid'] && ($filename == 'thread.php' || $filename == 'board.php')) {
		$select = ", bv.lastvisit, s.emailnotify, s.countemails";
		$join = " LEFT JOIN bb".$n."_boardvisit bv ON (bv.boardid=b.boardid AND bv.userid='".$wbbuserdata['userid']."')".
		"LEFT JOIN bb".$n."_subscribeboards s ON (s.userid='".$wbbuserdata['userid']."' AND s.boardid=b.boardid)";
	}
	$board = $db->query_first("SELECT m.*, m.userid AS moderatorid,b.*".$select." FROM bb".$n."_boards b LEFT JOIN bb".$n."_moderators m ON (m.boardid=b.boardid AND m.userid='".$wbbuserdata['userid']."')".$join." WHERE b.boardid = '$boardid'");

	// permissions
	if (isset($wbbuserdata['permissions'][$boardid]) && is_array($wbbuserdata['permissions'][$boardid])) {
		foreach ($wbbuserdata['permissions'][$boardid] as $key => $val) {
			if ($key != 'boardid' && $val != -1) $board[$key] = $val;
		}
	}

	// useraccess (inherited)
	if ($wbbuserdata['userid'] && $wbbuserdata['useuseraccess'] == 1) {
		$useraccess = $db->query_first("SELECT *, LOCATE(CONCAT(',',boardid,','),',$board[parentlist],$board[boardid],') as parentlocate FROM bb".$n."_access WHERE userid = '$wbbuserdata[userid]' AND boardid".(($board['parentlist']) ? (" IN($board[parentlist],$boardid)") : ("='$boardid'"))." ORDER BY parentlocate DESC", 1);
		if (is_array($useraccess) && count($useraccess)) {
			while (list($key, $val) = each($useraccess)) if ($key != 'boardid' && $val != -1) $wbbuserdata['permissions'][$boardid][$key] = $board[$key] = $val;
  		}
	}

	return $board;	
}


/**
* make an authentification code*
*
* @param integer onlyWhenNeeded
* 
* @return string authentificationcode
*/
function makeAuthentificationcode($onlyWhenNeeded = 1)
{
	if ($onlyWhenNeeded == 1) $make = needNewAuthentificationcode();
	else $make = 1;
	
	if ($make == 1) {
		srand((double)microtime() * 1000000);
		$authentificationcode = md5(uniqid(rand().microtime(), 1));
		return $authentificationcode;
	}
	else {
		return '';
	}
}


/** 
* do we need a new authentification code? 
*
* @return integer need
*/
function needNewAuthentificationcode()
{
	global $filename, $_POST, $_REQUEST;
	
	if ($filename == 'index.php' || ($filename == 'login.php' && !isSet($_POST['send'])) || ($filename == 'usercp.php' && isSet($_REQUEST['action']) && $_REQUEST['action'] == 'password_change' && !isSet($_POST['send'])) || ($filename == 'usercp.php' && isSet($_REQUEST['action']) && $_REQUEST['action'] == 'email_change' && !isSet($_POST['send']))) {
		return 1;
	}
	elseif (($filename == 'login.php' && isSet($_POST['send'])) || ($filename == 'usercp.php' && isSet($_REQUEST['action']) && $_REQUEST['action'] == 'password_change' && isSet($_POST['send'])) || ($filename == 'usercp.php' && isSet($_REQUEST['action']) && $_REQUEST['action'] == 'email_change' && isSet($_POST['send']))) {
		return 2;
	}
	else {
		return 0;
	}
}


/** 
* str_replace with amount param
* 
* @param string needle
* @param string str
* @param string haystack
* @param integer amout
*
* @return string str
*/
function amount_str_replace($needle, $str, $haystack, $amount) {
	$start = wbb_strpos($haystack, $needle);
	if ($start === false) return $haystack;

	$end = $start + wbb_strlen($needle);
	$new_haystack = wbb_substr($haystack, 0, $start).$str.wbb_substr($haystack, $end);

	if ($amount > 1) amount_str_replace($needle, $str, $new_haystack, --$amount);
	else return $new_haystack;
}


/** 
* split hex values of a colorcode 
*
* @param string color
*
* @return array color
*/
function getHexValues($color) {
	$color = wbb_substr($color, 1);

	return array(hexdec(wbb_substr($color, 0, 2)), hexdec(wbb_substr($color, 2, 2)), hexdec(wbb_substr($color, 4, 2)));
}


/** 
* create the gradient for threadrating from 
*
* @param string color1
* @param string color2
* @param string color3
*
* @return array colors
*/
function createGradient($color1, $color2, $color3) {
	$color1codes = getHexValues($color1);
	$color2codes = getHexValues($color2);
	$color3codes = getHexValues($color3);

	$red	= ($color2codes[0] - $color1codes[0]) / 4;
	$green	= ($color2codes[1] - $color1codes[1]) / 4;
	$blue	= ($color2codes[2] - $color1codes[2]) / 4;

	$newcolor = array();

	for ($i = 0; $i < 5; $i++) {
		$newred = dechex($color1codes[0] + round($i * $red));
		if (wbb_strlen($newred) < 2) $newred = '0'.$newred;

		$newgreen = dechex($color1codes[1] + round($i * $green));
		if (wbb_strlen($newgreen) < 2) $newgreen = '0'.$newgreen;

		$newblue = dechex($color1codes[2] + round($i * $blue));
		if (wbb_strlen($newblue) < 2) $newblue = '0'.$newblue;

		$newcolor[$i] = '#'.$newred.$newgreen.$newblue;
	}

	$red	= ($color3codes[0] - $color2codes[0]) / 5;
	$green	= ($color3codes[1] - $color2codes[1]) / 5;
	$blue	= ($color3codes[2] - $color2codes[2]) / 5;

	for ($i = 1; $i < 6; $i++) {
		$newred = dechex($color2codes[0] + round($i * $red));
		if (wbb_strlen($newred) < 2) $newred = '0'.$newred;

		$newgreen = dechex($color2codes[1] + round($i * $green));
		if (wbb_strlen($newgreen) < 2) $newgreen = '0'.$newgreen;

		$newblue = dechex($color2codes[2] + round($i * $blue));
		if (wbb_strlen($newblue) < 2) $newblue = '0'.$newblue;

		$newcolor[(4 + $i)] = '#'.$newred.$newgreen.$newblue;	
	} 

	return $newcolor;	
}


/**
* session update stuff
*
* @return void
*/
function sessionupdate() {
	global $wbbuserdata, $days4AI, $db, $n;

	if ($days4AI != '') {
		$days4AI = unserialize($days4AI);
		if (is_array($days4AI) && count($days4AI)) {
			$regdays = (time() - $wbbuserdata['regdate']) / 86400;
			$updateuser = 0;
			while (list($key, $val) = each($days4AI)) {
				if ($val <= $regdays && !in_array($key, $wbbuserdata['groupids'])) {
					$db->unbuffered_query("INSERT IGNORE INTO bb".$n."_user2groups (userid,groupid) VALUES ('".$wbbuserdata['userid']."','$key')", 1);
					$wbbuserdata['groupids'][] = $key;
					$updateuser = 1;
				}
			}

			if ($updateuser == 1) {
				sort($wbbuserdata['groupids']);	
				updateMemberships($wbbuserdata['userid'], $wbbuserdata['userposts'], $wbbuserdata['gender'], implode(',', $wbbuserdata['groupids']));
			}
		}	
	}	

	$db->unbuffered_query("DELETE FROM bb".$n."_threadvisit WHERE userid = '".$wbbuserdata['userid']."' AND lastvisit<='".time()."' ", 1);
	$db->unbuffered_query("DELETE FROM bb".$n."_boardvisit WHERE userid = '".$wbbuserdata['userid']."' AND lastvisit<='".time()."' ", 1);
}


/**
* update membership (groupcombination, rank and useronlinemarking)
*
* @param integer userid
* @param integer userposts
* @param integer gender
* @param string groupids
*
* @return void
*/
function updateMemberships($userid, $userposts, $gender, $groupids) {
	global $db, $n;

	list($groupid) = $db->query_first("SELECT groupid FROM bb".$n."_groups WHERE groupid IN ($groupids) ORDER BY showorder ASC", 1);
	list($rankid) = $db->query_first("SELECT rankid FROM bb".$n."_ranks WHERE groupid IN ('0','".$groupid."') AND needposts<='".$userposts."' AND gender IN ('0','".$gender."') ORDER BY needposts DESC, gender DESC", 1);
	$db->unbuffered_query("UPDATE bb".$n."_users SET groupcombinationid='".cachegroupcombinationdata($groupids , 0)."', rankid='".$rankid."', rankgroupid='".$groupid."', useronlinegroupid='".$groupid."' WHERE userid='".$userid."'", 1);
}


/** 
* check posts for automatic group inserts
*
* @return void
*/
function checkPosts4AI() {
	global $posts4AI, $wbbuserdata, $db, $n;	

	if ($posts4AI != '') {
		$posts4AI = unserialize($posts4AI);
		if (is_array($posts4AI) && count($posts4AI)) {
			$updateuser = 0;
			while (list($key, $val) = each($posts4AI)) {
				if ($val <= $wbbuserdata['userposts'] && !in_array($key, $wbbuserdata['groupids'])) {
					$db->unbuffered_query("INSERT IGNORE INTO bb".$n."_user2groups (userid,groupid) VALUES ('".$wbbuserdata['userid']."','$key')", 1);
					$wbbuserdata['groupids'][] = $key;
					$updateuser = 1;	
				}
			}

			if ($updateuser == 1) {
				sort($wbbuserdata['groupids']);	
				updateMemberships($wbbuserdata['userid'], $wbbuserdata['userposts'], $wbbuserdata['gender'], implode(',', $wbbuserdata['groupids']));
			}
		}
	}
}


/** 
* get groupcombination data
*
* @param string groupids
* @param integer mode
* @param array data
*
* @return string serialized data
*/
function getgroupcombinationdata($groupids, $mode = 3, $data = array()) { 
	global $db, $n;
	
	if ($mode == 1 || $mode == 3) {
		// read in groupvariables
		$variables = array();
	 	$result = $db->unbuffered_query("SELECT g.groupid, g.grouptype, g.priority, var.variablename, var.type, vl.value FROM bb".$n."_groups g LEFT JOIN bb".$n."_groupvalues vl USING(groupid) LEFT JOIN bb".$n."_groupvariables var USING(variableid) WHERE g.groupid IN($groupids) ORDER BY priority ASC, grouptype DESC"); 
	 	while ($row = $db->fetch_array($result)) {
			switch ($row['type']) {
				case 'truefalse': if (!isset($variables[$row['variablename']]) || $row['value'] || $row['priority']) $variables[$row['variablename']] = $row['value']; break;
				case 'integer': if (!isset($variables[$row['variablename']]) || ($row['value'] > $variables[$row['variablename']] && $variables[$row['variablename']] != -1) || $row['priority'] || $row['value'] == -1) $variables[$row['variablename']] = $row['value']; break;
				case 'string': $variables[$row['variablename']] = (($row['priority'] == 0 && isset($variables[$row['variablename']])) ? ($variables[$row['variablename']]."\n") : ("")).$row['value']; break;
			
				case 'inverse_integer': 
					if (!isset($variables[$row['variablename']]) || ($row['value'] < $variables[$row['variablename']] && $row['value'] != -1) || $row['priority'] || $variables[$row['variablename']] == -1) $variables[$row['variablename']] = $row['value']; 
					
					break;
			}
	 	}
	 	while (list($key, $val) = each($variables)) $data[$key] = $val;
	}
	
	
	if ($mode == 2 || $mode == 3) {
		// read in forum permissions
		$result = $db->query_first("SELECT groupid FROM bb".$n."_groups WHERE groupid IN ($groupids) AND priority <> 0 ORDER BY priority DESC");
		if (isset($result['groupid'])) $groupids = $result['groupid'];
		
		$data['permissions'] = array();
		$permissioncache = array();
		$result = $db->query("SELECT p.*,g.priority,g.grouptype FROM bb".$n."_permissions p LEFT JOIN bb".$n."_groups g USING(groupid) WHERE p.groupid IN ($groupids) ORDER BY g.priority ASC, g.grouptype DESC");
		while ($row = $db->fetch_array($result, MYSQL_ASSOC)) $permissioncache[$row['boardid']][$row['groupid']] = $row;
		// inherit forum permissions
		inheritpermissions(0, $permissioncache);
		// go through forum permissions
		foreach ($permissioncache as $boardid => $val) {
			foreach ($val as $row) {
				if (isset($data['permissions'][$row['boardid']])) $tmp = $data['permissions'][$row['boardid']];
				else $tmp = array();
				reset($row);
				while (list($key, $val) = each($row)) {
					if ($val == -1 || $key == 'groupid') continue;
					if (!isset($tmp[$key])) $tmp[$key] = $val;
					if ($row['priority'] || $val == 1 || ($val == 0 && $tmp[$key] != 1)) $tmp[$key] = $val;
				}
				$data['permissions'][$row['boardid']] = $tmp;
			}
		}
	}
	
	return serialize($data);
}


/** 
* cache a groupcombination
*
* @param string groupids
* @param integer update
* @param integer mode
* @param array data
*
* @return integer groupcombinationid
*/
function cachegroupcombinationdata($groupids, $update = 1, $mode = 3, $data = array()) {
	global $db, $n;
	list($groupcombinationid) = $db->query_first("SELECT groupcombinationid FROM bb".$n."_groupcombinations WHERE groupids='$groupids'");
	
	if ($groupcombinationid > 0) {
		if ($update == 1) $db->unbuffered_query("UPDATE bb".$n."_groupcombinations SET data='".addslashes(getgroupcombinationdata($groupids, $mode, $data))."' WHERE groupcombinationid='$groupcombinationid'", 1);
	}
	else {
		$db->query("INSERT INTO bb".$n."_groupcombinations (groupids,data) VALUES ('$groupids', '".addslashes(getgroupcombinationdata($groupids))."')");
		$groupcombinationid = $db->insert_id();
	}
	return $groupcombinationid;
}



/** 
* check if a forum inherited permissions from its parent board
*
* @param integer boardid
* @param integer parentlist
* @param integer boardparentid
* @param integer parentid
* @param array permissioncache
*
* @return array groupids
*/
function checkforinheritance($boardid, $parentlist = 0, $boardparentid = '', $parentid = 0, $permissioncache = '') {
	global $db, $n, $boardcache;

	$groupids = array();
	if (!$parentlist) return $groupids;
	$parents = explode(',', $parentlist);
	if (!in_array($parentid, $parents)) return $groupids;

	// get board structure if not already loaded
	//if (!isset($boardcache) || !is_array($boardcache) || !count($boardcache)) { // perhaps its better to check if the array is totally emtpy ?
	if (!isset($boardcache) || !is_array($boardcache)) {
		$boardcache = array();
		$result = $db->query("SELECT boardid,boardorder,parentid,parentlist,childlist FROM bb".$n."_boards WHERE boardid IN ($boardid,$parentlist) ORDER BY parentid ASC, boardorder ASC");
		while ($row = $db->fetch_array($result)) {
			if ($boardid == $row['boardid'] && $boardparentid != '') $row['parentid'] = $boardparentid;
			$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
		}
	}

	// get permissioncache if not already loaded
	if (!is_array($permissioncache)) {
		$permissioncache = array();
		$result = $db->query("SELECT p.*,g.priority,g.grouptype FROM bb".$n."_permissions p LEFT JOIN bb".$n."_groups g USING(groupid) WHERE p.boardid IN ($boardid,$parentlist) ORDER BY g.priority ASC, g.grouptype DESC");
		while ($row = $db->fetch_array($result)) $permissioncache[$row['boardid']][$row['groupid']] = $row;
	}

	if (isset($boardcache[$parentid]) && is_array($boardcache[$parentid])) {
		foreach ($boardcache[$parentid] as $key => $val) {
			foreach ($val as $key2 => $boards) {
				// skip forums that are not relevant
				if (!in_array($boards['boardid'], $parents) && $boards['boardid'] != $boardid) continue;

				// inherit permissions from parent board
				if ($boards['parentid']) {
					// forum permissions
					if (isset($permissioncache[$boards['parentid']]) && is_array($permissioncache[$boards['parentid']])) {
						foreach ($permissioncache[$boards['parentid']] as $groupid => $row) {
							if (!isset($permissioncache[$boards['boardid']][$groupid])) {
								$permissioncache[$boards['boardid']][$groupid] = $row;
								$permissioncache[$boards['boardid']][$groupid]['boardid'] = $boards['boardid'];
								if ($boards['boardid'] == $boardid) $groupids[] = $groupid;
							}
						}

						// return results..
						if ($boards['boardid'] == $boardid ) { 
							return $groupids;
						}
					}
				}
				if (!isset($boards['childlist']) || $boards['childlist']) return checkforinheritance($boardid, $parentlist, $boardparentid, $boards['boardid'], $permissioncache);
			}
		}
		reset($boardcache[$parentid]);
	} 
}


/** 
* inherit forum permissions (permissions & useraccess)
*
* @param integer parentid
* @param array permissioncache
* @param string type
*
* @return void
*/
function inheritpermissions($parentid = 0, &$permissioncache, $type = 'forumpermissions') {
	global $db, $n, $boardcache;	

	// get board structure if not already loaded
	//if (!isset($boardcache) || !is_array($boardcache) || !count($boardcache)) { // perhaps its better to check if the array is totally emtpy ?
	if (!isset($boardcache) || !is_array($boardcache)) {
		$boardcache = array();
		$result = $db->query("SELECT boardid,boardorder,parentid,parentlist,childlist FROM bb".$n."_boards ORDER BY parentid ASC, boardorder ASC");
		while ($row = $db->fetch_array($result)) {
			$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
		}
	}

	if (isset($boardcache[$parentid]) && is_array($boardcache[$parentid])) {
		foreach ($boardcache[$parentid] as $key => $val) {
			foreach ($val as $key2 => $boards) {
				// inherit permissions from parent board
				if ($boards['parentid']) {
					// forum permissions
					if ($type == 'forumpermissions' && isset($permissioncache[$boards['parentid']]) && is_array($permissioncache[$boards['parentid']])) {
						$resort = false;
						foreach ($permissioncache[$boards['parentid']] as $groupid => $row) {
							if (!isset($permissioncache[$boards['boardid']][$groupid])) {
								$permissioncache[$boards['boardid']][$groupid]				= $row;
								$permissioncache[$boards['boardid']][$groupid]['boardid']		= $boards['boardid'];
								$permissioncache[$boards['boardid']][$groupid]['permissionsinherited']	= 1; // mark inheritance for permissions overview in admin panel
								$resort = true;
							}
						}
						// if permissions were inherited, we have to resort the array by grouppriority and grouptype
						// unfortenately, array_multisort resets numeric array keys..
						if ($resort) {
							$sortarray1 = array();
							$sortarray2 = array();
							foreach ($permissioncache[$boards['boardid']] as $val) {
								$sortarray1[] = $val['priority'];
								$sortarray2[] = $val['grouptype'];
							}
							array_multisort($sortarray1, SORT_ASC, SORT_NUMERIC, $sortarray2, SORT_DESC, SORT_NUMERIC, $permissioncache[$boards['boardid']]);
							unset($sortarray1);
							unset($sortarray2);
							$newarray = array();
							foreach ($permissioncache[$boards['boardid']] as $key => $val) $newarray[$val['groupid']] = $val;	
							$permissioncache[$boards['boardid']] = $newarray;
							unset($newarray);
						}
					}

					// user access
					elseif ($type == 'useraccess' && isset($permissioncache[$boards['parentid']]) && is_array($permissioncache[$boards['parentid']]) && !isset($permissioncache[$boards['boardid']])) {
						$permissioncache[$boards['boardid']]		= $permissioncache[$boards['parentid']];
						$permissioncache[$boards['boardid']]['boardid']	= $boards['boardid'];
					}
				}
				if (!isset($boards['childlist']) || $boards['childlist']) inheritpermissions($boards['boardid'], $permissioncache, $type);
			}
		}
		reset($boardcache[$parentid]);
	}
}


/** 
* own trim function for wbb
*
* @param string text
* 
* @return string text
*/
function wbb_trim($text) {
	if ($text != '') {
		// removing whitespace may not work with some charsets (like utf - 8, gb2312, etc)
		global $removewhitespace;
		if ($removewhitespace == 1) {
			$text = str_replace(chr(160), " ", $text); // remove alt + 0160
			$text = str_replace(chr(173), " ", $text); // remove alt + 0173
			$text = str_replace(chr(240), " ", $text); // remove alt + 0240
			$text = str_replace("\0", " ", $text); // remove whitespace
		}
		$text = trim($text);
	}	

	return $text;
}


/** 
* replace the key with a langvar
*
* @param string key
* @param object lang
* @param integer userhtmlconverter
*
* @return string langvar
*/
function getlangvar($key, &$lang, $usehtmlconverter = 1) {
	if (isset($lang->items['LANG_OWN_'.$key])) return $lang->items['LANG_OWN_'.$key];
	else return (($usehtmlconverter == 1) ? (htmlconverter($key)) : ($key));	
}


/** 
* get search fieldname for memberssearch
*
* @param string field
*
* @return string fieldname
*/
function getSearchFieldname($field) {
	if (strstr($field, 'profilefield')) return 'field'.wbb_substr($field, 12);
	else {
		if (in_array($field, array('pm', 'search', 'buddy', 'rankimage'))) return '';
		elseif ($field == 'avatar') return 'u.avatarid';
		else return $field;
	}
}


/** 
* generate a dynamic link
*
* @param string varname
* @param string value
* @param integer isacp
*
* @return void
*/
function linkGenerator($varname, $value) {
 	global $link;
 	$link .= urlencode($varname).'='.urlencode($value).'&amp;';
}


/** 
* anti spam roboter e - mail generator
*
* @param string text
*
* @return string text
*/
function getASCIICodeString($text) {
	if ($text != '') {
		$newtext = '';

		$length = wbb_strlen($text);
		for ($i = 0; $i < $length; $i++) {
			$newtext .= '&#'.ord($text[$i]).';';
		}

		$text = $newtext;
	}
	return $text;
}


/**
* function version_compare for php < 4.1.0
*
* @param string vercurrent
* @param string vercheck
*
* @param integer check
*/
if (!function_exists('version_compare')) {
	function version_compare($vercurrent, $vercheck) {
		$minver = explode('.', $vercheck);
		$curver = explode('.', $vercurrent);

		if (($curver[0] < $minver[0]) || (($curver[0] == $minver[0]) && ($curver[1] < $minver[1])) || (($curver[0] == $minver[0]) && ($curver[1] == $minver[1]) && ($curver[2][0] < $minver[2][0])))
		 return - 1;
		elseif ($curver[0] == $minver[0] && $curver[1] == $minver[1] && $curver[2] == $minver[2])
		 return 0;
		else
		 return 1;
	}
}


/**
* search for users with a certain groupcombination
*
* @param array variables
* @param string operator
*
* @return string groupcombinations
*/
function getUserByGroupcombination($variables, $operator = 'AND')
{
	global $db, $n;	
	
	$groupcombinations = '';
	$result = $db->query("SELECT groupcombinationid,data FROM bb".$n."_groupcombinations");
	while ($row = $db->fetch_array($result)) {
		$row['data'] = unserialize($row['data']);
		if ($operator == 'AND') {
			$goodcombination = true;
			foreach ($variables as $variablename => $value) {
				if ($row['data'][$variablename] != $value) $goodcombination = false;
			}
		}
		else {
			$goodcombination = false;
			foreach ($variables as $variablename => $value) {
				if ($row['data'][$variablename] == $value) $goodcombination = true;
			}
		}
		if ($goodcombination) $groupcombinations .= ','.$row['groupcombinationid'];
	}
	return $groupcombinations;
}


/** 
* replace "{imagefolder}" with "$style['imagefolder']"
*
* @param string text
*
* @return string text
*/
function replaceImagefolder($text) {
	if ($text != '' && strstr($text, '{imagefolder}')) {
		global $style;

		$text = str_replace('{imagefolder}', $style['imagefolder'], $text);
	}

	return $text;
}


/** 
* check the admin permission for a function
*
* @param string permission
* @param integer access_error
*
* @return boolean permission
*/
function checkAdminPermissions($permission, $access_error = 0) {
	global $wbbuserdata;
	if ($access_error == 0) {
		if ($wbbuserdata['a_can_use_acp'] == 1 && isSet($wbbuserdata[$permission]) && $wbbuserdata[$permission]) return true;
		else return false;
	}
	elseif ($access_error != 0 && (!$wbbuserdata['a_can_use_acp'] || !isSet($wbbuserdata[$permission]) || !$wbbuserdata[$permission])) {
		access_error(1);
	}
}









/** 
* extracts the embedded thumbnail picture of a jpeg or tiff image
*
* @param string filename
* @param string type
* @param integer maxWidth
* @param integer maxHeight
*
* @return string thumbnail
*/
function extractEmbeddedThumbnail($filename, &$thumbnail_type, $maxWidth = 160, $maxHeight = 160) {
	if (version_compare(phpversion(), '4.3.0') < 0 || !function_exists('exif_thumbnail')) {
		return false;
	}
	
	$width = $height = $type = 0;
	$thumbnail = @exif_thumbnail($filename, $width, $height, $type);
	if ($thumbnail && $type) {
		// resize the extracted thumbnail again if necessary
		// (normally the thumbnail size is set to 160px
		// which is recommended in EXIF >2.1 and DCF
		if (($width > $maxWidth || $height > $maxHeight) || ($width < $maxWidth && $height < $maxHeight)) {
			if (file_exists('./acp/temp/')) $tempFilename = './acp/temp/';
			else $tempFilename = './temp/';
			$tempFilename .= md5(uniqid(rand()));
			$fp = @fopen($tempFilename, 'wb');
			@fwrite($fp, $thumbnail);
			@fclose($fp);
			@chmod($tempFilename, 0777);
			
			if ($width > $maxWidth || $height > $maxHeight) {
				$thumbnail = makeThumbnailImage($tempFilename, $type, $maxWidth, $maxHeight);
			}
			else {
				if ($width > $height) {
					$newWidth = $maxWidth;
					$newHeight = round($height * ($newWidth / $width));
				}
				else {
					$newHeight = $maxHeight;	
					$newWidth = round($width * ($newHeight / $height));
				}
				$thumbnail = resizeImageTo($tempFilename, $type, $newWidth, $newHeight, $width, $height, $type);							
			}
			@unlink($tempFilename);
			
			if (!$thumbnail) {
				return false;
			}
		}
		else {
			switch ($type) {
				case 1: $type = 'gif'; break;	
				case 2: $type = 'jpg'; break;	
				case 3: $type = 'png'; break;	
			}
		}
		
		$thumbnail_type = $type;
		return $thumbnail;
	}
}











/** 
* create a thumbnail picture (jpg) of a big image
*
* @param string filename
* @param string type
* @param integer maxWidth
* @param integer maxHeight
*
* @return string thumbnail
*/
function makeThumbnailImage($filename, &$thumbnail_type, $maxWidth = 160, $maxHeight = 160) {
	global $makethumbnails;
	list($width, $height, $type) = @getimagesize($filename);

	// no need to resize this image => cancel
	if ($width <= $maxWidth && $height <= $maxHeight) {
		return false;	
	}
	
	// try to extract the embedded thumbnail first (faster)
	if ($makethumbnails == 2) {
		$thumbnail = extractEmbeddedThumbnail($filename, $thumbnail_type, $maxWidth, $maxHeight);
		if ($thumbnail != '') {
			return $thumbnail;
		}
	}
	
	// calculate uncompressed filesize
	// and cancel to avoid a memory_limit error
	$memory_limit = ini_get('memory_limit');
	if ($memory_limit != '') {
		$memory_limit = wbb_substr($memory_limit, 0, -1) * 1024 * 1024;
		$filesize = $width * $height * 3;

		if (($filesize * 2) > ($memory_limit - 1024 * 1024)) {
			if ($makethumbnails == 1) {
				$thumbnail = extractEmbeddedThumbnail($filename, $thumbnail_type, $maxWidth, $maxHeight);
				if ($thumbnail != '') {
					return $thumbnail;
				}
			}
			return false;
		}
	}
	if ($width > $height) {
		$newWidth = $maxWidth;
		$newHeight = round($height * ($newWidth / $width));
	}
	else {
		$newHeight = $maxHeight;	
		$newWidth = round($width * ($newHeight / $height));
	}
	
	$thumbnail = resizeImageTo($filename, $thumbnail_type, $newWidth, $newHeight, $width, $height, $type);
	return $thumbnail;
}




/** 
* resize image to given width and height
*
* @param string filename
* @param string type
* @param integer maxWidth
* @param integer maxHeight
* @param integer oldWidth
* @param integer oldHeight
* @param integer oldType
*
* @return string imageNew
*/
function resizeImageTo($filename, &$type, $newWidth, $newHeight, $oldWidth, $oldHeight, $oldType) {
	// jpeg image
	if ($oldType == 2 && function_exists('imagecreatefromjpeg')) {
		$imageResource = @imagecreatefromjpeg($filename);	
	}
	// gif image
	if ($oldType == 1 && function_exists('imagecreatefromgif')) {
		$imageResource = @imagecreatefromgif($filename);	
	}
	// png image
	if ($oldType == 3 && function_exists('imagecreatefrompng')) {
		$imageResource = @imagecreatefrompng($filename);	
	}
	
	// could not create image
	$type = '';
	if (!isset($imageResource) || !$imageResource) {
		return false;	
	}
	
	// resize image
	if (function_exists('imagecreatetruecolor') && function_exists('imagecopyresampled')) {
		$imageNew = @imagecreatetruecolor($newWidth, $newHeight);
		@imagecopyresampled($imageNew, $imageResource, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);
	}
	elseif (function_exists('imagecreate') && function_exists('imagecopyresized')) {
		$imageNew = @imagecreate($newWidth, $newHeight);
		@imagecopyresized($imageNew, $imageResource, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);
	}
	else return false;
	
	$imageNew = createImage($imageNew, $type);

	// return new image
	if ($imageNew != '') {
		return $imageNew;
	}
	else {
		return false;
	}
}






/** 
* creates a final image from an image resource
*
* @param resource imageResource
*
* @return string image
*/
function createImage(&$imageResource, &$type) {
	ob_start();
	
	if (function_exists('imagejpeg')) {
		@imagejpeg($imageResource);
		$type = 'jpg';
	}
	elseif (function_exists('imagepng')) {
		@imagepng($imageResource);
		$type = 'png';	
	}
	else {
		return false;
	}
	
	@imagedestroy($imageResource);
	$image = ob_get_contents();
	ob_end_clean();
	
	return $image;
}



/**
* sends a private message
*
* @param array recipientlist
* @param array recipientlist_bcc
* @param string subject
* @param string message
* @param integer senderid
* @param integer savecopy
* @param integer allowsmilies
* @param integer allowhtml
* @param integer allowbbcode
* @param integer allowimages
* @param integer showsignature
* @param integer iconid
* @param integer tracking
* @param integer attachments
* @param integer doublecheck
*
* @return integer pmid
*/
function sendPrivateMessage($recipientlist, $recipientlist_bcc, $subject, $message, $senderid = 0, $savecopy = 0, $allowsmilies = 1, $allowhtml = 0, $allowbbcode = 1, $allowimages = 1, $showsignature = 1, $iconid = 0, $tracking = 0, $attachments = 0, $doublecheck = 0) {
	global $db, $n, $pmmaxrecipientlistsize, $dpvtime;
	if (!isset($pmmaxrecipientlistsize)) $pmmaxrecipientlistsize = 10;
	
	// validate input
	$senderid = intval($senderid);
	$savecopy = intval($savecopy);
	$allowsmilies = intval($allowsmilies);
	$allowhtml = intval($allowhtml);
	$allowbbcode = intval($allowbbcode);
	$alloimages = intval($alloimages);
	$showsignature = intval($showsignature);
	$iconid = intval($iconid);
	$tracking = intval($tracking);
	$attachments = intval($attachments);
	
	// serialize recipientlist
	$recipientlistSerialized = $recipientlist + $recipientlist_bcc;
	$recipientcount = count($recipientlistSerialized);
	if ($recipientcount > $pmmaxrecipientlistsize) {
		for ($j = 0, $jmax = count($recipientlistSerialized) - $pmmaxrecipientlistsize; $j < $jmax; $j++) array_pop($recipientlistSerialized);
	}
	$recipientlistSerialized = serialize($recipientlistSerialized);
	
	// check wheater this private message already exists or not
	$pmhash = md5($senderid."\n".$recipientcount."\n".$recipientlistSerialized."\n".$subject."\n".$message);
	if ($doublecheck == 1) {
		$check = $db->query_first("SELECT privatemessageid FROM bb".$n."_privatemessage WHERE pmhash='".addslashes($pmhash)."' AND sendtime>='".(time() - $dpvtime)."'");
		if ($check['privatemessageid']) {
			return false;	
		}
	}
	
	// insert pm
	$db->unbuffered_query("INSERT INTO bb".$n."_privatemessage (senderid,recipientlist,recipientcount,subject,message,sendtime,allowsmilies,allowhtml,allowbbcode,allowimages,showsignature,iconid,inoutbox,tracking,attachments,pmhash) VALUES ('$senderid','".addslashes($recipientlistSerialized)."','".$recipientcount."','".addslashes($subject)."','".addslashes($message)."','".time()."','$allowsmilies','$allowhtml','$allowbbcode','$allowimages','$showsignature','$iconid','$savecopy','$tracking', '$attachments', '".addslashes($pmhash)."')", 1);
	$pmid = $db->insert_id();
	$recipientInsertStr = '';
	foreach ($recipientlist as $recipientid => $recipient) {
		$recipientid = intval($recipientid);
		$recipientInsertStr .= ",('$pmid', '$recipientid', '".addslashes($recipient)."', '0')";
	}
	foreach ($recipientlist_bcc as $recipientid => $recipient) {
		$recipientid = intval($recipientid);
		$recipientInsertStr .= ",('$pmid', '$recipientid', '".addslashes($recipient)."', '1')";
	}
	$db->unbuffered_query("INSERT INTO bb".$n."_privatemessagereceipts (privatemessageid, recipientid, recipient, blindcopy) VALUES ".wbb_substr($recipientInsertStr, 1), 1);
	
	// update pmcounter for recipients && sender
	$recipientUpdateList = implode(',', array_merge(array_keys($recipientlist), array_keys($recipientlist_bcc)));
	$db->unbuffered_query("UPDATE bb".$n."_users SET pmtotalcount=pmtotalcount+1,pminboxcount=pminboxcount+1,pmnewcount=pmnewcount+1,pmunreadcount=pmunreadcount+1 WHERE userid IN (".$recipientUpdateList.")", 1);
	if ($savecopy == 1 && $senderid > 0) $db->unbuffered_query("UPDATE bb".$n."_users SET pmtotalcount=pmtotalcount+1 WHERE userid='$senderid'", 1);
	
	// set popup for recipients
	$db->unbuffered_query("UPDATE bb".$n."_users SET pmpopup=2 WHERE userid IN (".$recipientUpdateList.") AND pmpopup=1", 1);
	
	return $pmid;
}

























/** wrapper functions for mb_functions **/
function wbb_mail($to, $subject, $message, $headers = null, $params = null) {
	if (USE_MBSTRING === true) {
		if (!is_null($params)) return mb_send_mail($to, $subject, $message, $headers, $params);
		elseif (!is_null($headers)) return mb_send_mail($to, $subject, $message, $headers);
		else return mb_send_mail($to, $subject, $message);
	}
	else {
		if (!is_null($params)) return mail($to, $subject, $message, $headers, $params);
		elseif (!is_null($headers)) return mail($to, $subject, $message, $headers);
		else return mail($to, $subject, $message);			
	}
}

function wbb_split($pattern, $string, $limit = null) {
	if (USE_MBSTRING === true) {
		if (!is_null($limit)) return mb_split($pattern, $string, $limit);
		else return mb_split($pattern, $string);	
	}
	else {
		if (!is_null($limit)) return split($pattern, $string, $limit);
		else return split($pattern, $string);
	}
}

function wbb_strlen($string, $encoding = null) {
	if (USE_MBSTRING === true) {
		if ($encoding) return mb_strlen($string, $encoding);
		elseif (defined('ENCODING')) return mb_strlen($string, ENCODING);	
		else return mb_strlen($string);
	}
	else {
		return strlen($string);	
	}
}

function wbb_strpos($haystack, $needle, $offset = 0, $encoding = null) {
	if (USE_MBSTRING === true) {
		if ($encoding) return mb_strpos($haystack, $needle, $offset, $encoding);
		elseif (defined('ENCODING')) return mb_strpos($haystack, $needle, $offset, ENCODING);
		else return mb_strpos($haystack, $needle, $offset);
	}
	else {
		return strpos($haystack, $needle, $offset);
	}
}

function wbb_strrpos($haystack, $needle, $encoding = null) {
	if (USE_MBSTRING === true) {
		if ($encoding) return mb_strrpos($haystack, $needle, $encoding);
		elseif (defined('ENCODING')) return mb_strrpos($haystack, $needle, ENCODING);
		else return mb_strrpos($haystack, $needle);
	}
	else {
		return strrpos($haystack, $needle);
	}
}

function wbb_strtolower($string, $encoding = null) {
	if (USE_MBSTRING === true) {
		if ($encoding) return mb_strtolower($string, $encoding);
		elseif (defined('ENCODING')) return mb_strtolower($string, ENCODING);
		else  return mb_strtolower($string);
	}
	else {
		return strtolower($string);	
	}
}

function wbb_strtoupper($string, $encoding = null) {
	if (USE_MBSTRING === true) {
		if ($encoding) return mb_strtoupper($string, $encoding);
		elseif (defined('ENCODING')) return mb_strtoupper($string, ENCODING);
		else return mb_strtoupper($string);
	}
	else {
		return strtoupper($string);
	}
}

function wbb_substr_count($haystack, $needle, $encoding = null) {
	if (USE_MBSTRING === true) {
		if ($encoding) return mb_substr_count($haystack, $needle, $encoding);
		elseif (defined('ENCODING')) return mb_substr_count($haystack, $needle, ENCODING);
		else return mb_substr_count($haystack, $needle);
	}
	else {
		return substr_count($haystack, $needle);
	}
}

function wbb_substr($string, $start, $length = null, $encoding = null) {
	if (USE_MBSTRING === true) {
		if ($encoding) return mb_substr($string, $start, $length, $encoding);
		elseif (defined('ENCODING')) {
			if (!is_null($length)) return mb_substr($string, $start, $length, ENCODING);
			else return mb_substr($string, $start, wbb_strlen($string, $encoding), ENCODING);
		}
		else {
			if (!is_null($length)) return mb_substr($string, $start, $length);
			else return mb_substr($string, $start);
		}
	}
	else {
		if (!is_null($length)) return substr($string, $start, $length);
		else return substr($string, $start);
	}
}







/** wrapper functions for other string functions **/
function wbb_ucfirst($string, $encoding = null) {
	if (USE_MBSTRING == true) {
		return wbb_strtoupper(wbb_substr($string, 0, 1, $encoding), $encoding).wbb_substr($string, 1, $encoding);
	}
	else {
		return ucfirst($string);
	}
}

function wbb_ucwords($string, $encoding = null) {
	if (USE_MBSTRING == true) {
		if ($encoding) return mb_convert_case($string, MB_CASE_TITLE, $encoding);
		elseif (defined('ENCODING')) return mb_convert_case($string, MB_CASE_TITLE, ENCODING);
		else return mb_convert_case($string, MB_CASE_TITLE);
	}
	else {
		return ucwords($string);
	}
}






/**
* function sha1 for php < 4.3.0
*
* @param string string
*
* @return string hash
*/
if (!function_exists('sha1')) {
	function sha1($string) {
		if (extension_loaded('mhash') && function_exists('mhash')) {
			return bin2hex(mhash(MHASH_SHA1, $str));
		}
		else {
			$x = sha1_str2blks($string);
			$w = Array(80);
			
			$a =  1732584193;
			$b = -271733879;
			$c = -1732584194;
			$d =  271733878;
			$e = -1009589776;
			
			for ($i = 0, $end = count($x); $i < $end; $i += 16) {
				$olda = $a;
				$oldb = $b;
				$oldc = $c;
				$oldd = $d;
				$olde = $e;
				
				for ($j = 0; $j < 80; $j++) {
					if ($j < 16) $w[$j] = $x[($i + $j)];
					else $w[$j] = sha1_rol(($w[($j - 3)] ^ $w[($j - 8)] ^ $w[($j - 14)] ^ $w[($j - 16)]), 1);
					$t = sha1_add(sha1_add(sha1_rol($a, 5), sha1_ft($j, $b, $c, $d)), sha1_add(sha1_add($e, $w[$j]), sha1_kt($j)));
					$e = $d;
					$d = $c;
					$c = sha1_rol($b, 30);
					$b = $a;
					$a = $t;
				}
				
				$a = sha1_add($a, $olda);
				$b = sha1_add($b, $oldb);
				$c = sha1_add($c, $oldc);
				$d = sha1_add($d, $oldd);
				$e = sha1_add($e, $olde);
			}
			return sha1_hex($a).sha1_hex($b).sha1_hex($c).sha1_hex($d).sha1_hex($e);
		}
	}
	
	/**
	* @desc alternative to the zero fill shift right operator
	*/
	function sha1_zeroFill($a, $b) {
		$z = hexdec(80000000);
		if ($z & $a) {
			$a >>= 1;
			$a &= (~ $z);
			$a |= 0x40000000;
			$a >>= ($b - 1);
		}
		else {
			$a >>= $b;
		}
		return $a;
	}
	
	
	/**
	* @desc conversion decimal to hexadecimal
	* @param decnum integer
	* @return hexstr string
	*/
	function sha1_hex($decnum) {
		$hexstr = dechex($decnum);
		if (wbb_strlen($hexstr) < 8) $hexstr = str_repeat('0', 8 - wbb_strlen($hexstr)).$hexstr;
		return $hexstr;
	}



	/**
	* @desc divides a string into 16 - word blocks
	* @param str string
	* @return blocks array
	*/
	function sha1_str2blks($str) {
		$nblk = ((wbb_strlen($str) + 8) >> 6) + 1;
		$blks = array($nblk * 16);
		
		for ($i = 0; $i < $nblk * 16; $i++) $blks[$i] = 0;
		for ($i = 0, $end = wbb_strlen($str); $i < $end; $i++) $blks[($i >> 2)] |= ord(wbb_substr($str, $i, 1)) << (24 - ($i % 4) * 8);
		$blks[($i >> 2)] |= 0x80 << (24 - ($i % 4) * 8);
		$blks[($nblk * 16 - 1)] = wbb_strlen($str) * 8;
		return $blks;
	}


	/**
	* @desc add integers, wrapping at 2^32. This uses 16 - bit operations internally
	*/
	function sha1_add($x, $y) {
		$lsw = ($x & 0xFFFF) + ($y & 0xFFFF);
		$msw = ($x >> 16) + ($y >> 16) + ($lsw >> 16);
		return ($msw << 16) | ($lsw & 0xFFFF);
	}




	/**
	* @desc Bitwise rotate a 32 - bit number to the left
	*/
	function sha1_rol($num, $cnt) {
		return ($num << $cnt) | sha1_zeroFill($num, (32 - $cnt));
	}



	/**
	* @desc Perform the appropriate triplet combination function for the current
	* iteration
	*/
	function sha1_ft($t, $b, $c, $d) {
		if ($t < 20) return ($b & $c) | ((~$b) & $d);
		elseif ($t < 40) return $b ^ $c ^ $d;
		elseif ($t < 60) return ($b & $c) | ($b & $d) | ($c & $d);
		else return $b ^ $c ^ $d;
	}

	/**
	* @desc Determine the appropriate additive constant for the current iteration
	*/
	function sha1_kt($t) {
		if ($t < 20) return 1518500249;
		elseif ($t < 40) return 1859775393;
		elseif ($t < 60) return - 1894007588;
		else return - 899497514;
	}	
}
?>
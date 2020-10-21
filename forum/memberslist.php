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
// * $Date: 2005-02-07 16:18:22 +0100 (Mon, 07 Feb 2005) $
// * $Author: Burntime $
// * $Rev: 1549 $
// ************************************************************************************//


$filename = 'memberslist.php';

require('./global.php');
if ($wbbuserdata['can_view_mblist'] == 0) access_error();
require('./acp/lib/class_parse.php');
$lang->load('MEMBERS');



/**
* cache custom profile fields
*
* @return void
*/
function cacheProfilefields() {
	global $profilefieldcache, $db, $n;

	$profilefieldcache = array();
	$result = $db->unbuffered_query("SELECT * FROM bb".$n."_profilefields");
	while ($row = $db->fetch_array($result)) $profilefieldcache[$row['profilefieldid']] = $row;
}

/**
* parse members bit
*
* @param string userid
*
* @return string membersbit
*/
function makeMembersbit($userids, $link) {
	global $a_show, $select, $letter, $sortby, $order, $colspan, $profilefieldcache, $fieldheader, $db, $n, $style, $tpl, $lang, $wbbuserdata, $showavatar, $allowflashavatar, $session, $SID_ARG_1ST, $SID_ARG_2ND, $SID_ARG_2ND_UN;

	$read_profilefields = 0;
	$read_avatars = 0;
	$read_ranks = 0;
	$read_useronlinemarking = 0;
	$letter_enc = urlencode($letter);

	reset($a_show);
	while (list($key, $val) = each($a_show)) {
		$fieldname = $lang->get('LANG_MEMBERS_MBL_'.wbb_strtoupper($val));

		if ($val == 'avatar') $read_avatars = 1;
		elseif ($val == 'ranktitle' || $val == 'rankimage') $read_ranks = 1;
		elseif (strstr($val, 'profilefield')) {
			$read_profilefields = 1;
			if ($profilefieldcache == 0) cacheProfilefields();

			if ($profilefieldcache[wbb_substr($val, 12)]['hidden'] == 1 && $wbbuserdata['a_can_view_hidden'] != 1) continue;

			$fieldname = getlangvar($profilefieldcache[wbb_substr($val, 12)]['title'], $lang);
		}

		$searchname = getSearchFieldname($val);

		$colspan++;
		eval("\$fieldheader .= \" ".$tpl->get("memberslist_fieldheader")."\";");
	}

	$result = $db->unbuffered_query("SELECT u.*
	".(($read_profilefields == 1) ? (", uf.*") : (""))."
	".(($read_avatars == 1) ? (", a.avatarid, a.avatarextension, a.width, a.height") : (""))."
	".(($read_ranks == 1) ? (", r.ranktitle, r.rankimages") : (""))."
	".$select."
	FROM bb".$n."_users u
	".(($read_profilefields == 1) ? (" LEFT JOIN bb".$n."_userfields uf USING (userid)") : (""))."
	".(($read_avatars == 1) ? (" LEFT JOIN bb".$n."_avatars a ON (u.avatarid=a.avatarid)") : (""))."
	".(($read_ranks == 1) ? (" LEFT JOIN bb".$n."_ranks r ON (u.rankid=r.rankid)") : (""))." 
	WHERE u.userid IN (0$userids)
	ORDER BY $sortby $order");

	$count = 0;
	$membersbit = '';
	while ($members = $db->fetch_array($result)) {
		reset($a_show);
		$fields = "";
		$count = 1;

		while (list($key, $val) = each($a_show)) {
			$tdclass = getone($count, 'tablea', 'tableb');
			$username = $members['username'];

			if (strstr($val, 'profilefield')) {
				$profilefield = $profilefieldcache[wbb_substr($val, 12)];

				if (($profilefield['hidden'] == 1 && $wbbuserdata['a_can_view_hidden'] != 1)) continue;

				$fieldcontent = $members["field".$profilefield['profilefieldid']];
				if ($fieldcontent && $fieldcontent != "0000-00-00") {
					if ($profilefield['fieldtype'] == "multiselect") $fieldcontent = str_replace("\n", "; ", $fieldcontent);
					elseif ($profilefield['fieldtype'] == "date") {
						$row_datearray = explode("-", $fieldcontent);
						if ($row_datearray[0] == "0000") $fieldcontent = $row_datearray[2].".".$row_datearray[1].".";
						else $fieldcontent = $row_datearray[2].".".$row_datearray[1].".".$row_datearray[0];
					}
					$fieldcontent = htmlconverter(textwrap($fieldcontent, 30));
					eval("\$fields .= \"".$tpl->get("memberslist_userfields")."\";");
				}
				else eval("\$fields .= \" ".$tpl->get("memberslist_none")."\";");
			}
			else {
				switch ($val) {
					case 'username':
					$members['username'] = htmlconverter($members['username']);
					eval("\$fields .= \" ".$tpl->get("memberslist_username")."\";");
					break;

					case 'email':
					$LANG_MEMBERS_SENDEMAIL = $lang->get("LANG_MEMBERS_SENDEMAIL", array('$username' => $username));
					if ($members['showemail'] == 1) {
						$members['email'] = getASCIICodeString($members['email']);
						eval("\$fields .= \" ".$tpl->get("memberslist_email")."\";");
					}
					else if ($members['usercanemail'] == 1) eval("\$fields .= \" ".$tpl->get("memberslist_formmail")."\";");
					else eval("\$fields .= \" ".$tpl->get("memberslist_none")."\";");
					break;

					case 'homepage':
					if ($members['homepage']) {
						$members['homepage'] = htmlconverter($members['homepage']);
						$LANG_MEMBERS_HOMEPAGE = $lang->get("LANG_MEMBERS_HOMEPAGE", array('$username' => $username));
						eval("\$fields .= \" ".$tpl->get("memberslist_homepage")."\";");
					}
					else eval("\$fields .= \" ".$tpl->get("memberslist_none")."\";");
					break;

					case 'pm':
					if ($members['receivepm'] && $wbbuserdata['can_use_pms'] == 1) {
						$LANG_MEMBERS_PM = $lang->get("LANG_MEMBERS_PM", array('$username' => $username));
						eval("\$fields .= \" ".$tpl->get("memberslist_pm")."\";");
					}
					else eval("\$fields .= \" ".$tpl->get("memberslist_none")."\";");
					break;

					case 'search':
					$LANG_MEMBERS_SEARCH = $lang->get("LANG_MEMBERS_SEARCH", array('$username' => $username));
					eval("\$fields .= \" ".$tpl->get("memberslist_search")."\";");
					break;

					case 'userposts':
					if ($members['userposts'] >= 1000) $userposts = number_format($members['userposts'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
					else $userposts = $members['userposts'];
					eval("\$fields .= \" ".$tpl->get("memberslist_userposts")."\";");
					break;

					case 'postsperday':
					$regdays = (time() - $members['regdate']) / 86400;
					if ($regdays < 1) $postperday = $members['userposts'];
					else $postperday = $members['userposts'] / $regdays;

					$postperday = number_format($postperday, 2, $lang->get("LANG_GLOBAL_DEC_POINT"), $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));

					$LANG_MEMBERS_PROFILE_POSTSPERDAY = $lang->get("LANG_MEMBERS_PROFILE_POSTSPERDAY", array('$postperday' => $postperday));
					eval("\$fields .= \" ".$tpl->get("memberslist_postsperday")."\";");
					break;

					case 'userlevel':
					$userlevel = userlevel($members['userposts'], $members['regdate']);
					eval("\$fields .= \" ".$tpl->get("memberslist_userlevel")."\";");
					break;

					case 'avatar':
					if ($members['avatarid'] && $showavatar == 1 && $wbbuserdata['showavatars'] == 1) {
						$avatarname = "images/avatars/avatar-".$members['avatarid'].".".$members['avatarextension'];
						$avatarwidth = $members['width'];
						$avatarheight = $members['height'];
						if ($members['avatarextension'] == "swf" && $allowflashavatar == 1) {
							eval("\$useravatar = \"".$tpl->get("avatar_flash")."\";");
							eval("\$fields .= \" ".$tpl->get("memberslist_avatar")."\";");
						}
						else if ($members['avatarextension'] != "swf") {
							eval("\$useravatar = \"".$tpl->get("avatar_image")."\";");
							eval("\$fields .= \" ".$tpl->get("memberslist_avatar")."\";");
						}
						else eval("\$fields .= \" ".$tpl->get("memberslist_none")."\";");
					}
					else eval("\$fields .= \" ".$tpl->get("memberslist_none")."\";");
					break;

					case 'ranktitle':
					if ($members['title']) $members['ranktitle'] = htmlconverter($members['title']);
					else $members['ranktitle'] = getlangvar($members['ranktitle'], $lang);
					eval("\$fields .= \" ".$tpl->get("memberslist_ranktitle")."\";");
					break;

					case 'rankimage':
					$rankimages = formatRI($members['rankimages']);
					eval("\$fields .= \" ".$tpl->get("memberslist_rankimage")."\";");
					break;

					case 'usertext':
					if ($members['usertext']) {
						$members['usertext'] = htmlconverter(textwrap($members['usertext'], 40));
						eval("\$fields .= \" ".$tpl->get("memberslist_usertext")."\";");
					}
					else eval("\$fields .= \" ".$tpl->get("memberslist_none")."\";");
					break;

					case 'icq':
					if ($members['icq']) {
						$LANG_MEMBERS_ICQ = $lang->get("LANG_MEMBERS_ICQ", array('$username' => $username));
						eval("\$fields .= \" ".$tpl->get("memberslist_icq")."\";");
					}
					else eval("\$fields .= \" ".$tpl->get("memberslist_none")."\";");
					break;

					case 'aim':
					if ($members['aim']) {
						$members['aim'] = htmlconverter($members['aim']);
						$aim = $members['aim'];
						$LANG_MEMBERS_AIM = $lang->get("LANG_MEMBERS_AIM", array('$username' => $username, '$aim' => $aim));
						eval("\$fields .= \" ".$tpl->get("memberslist_aim")."\";");
					}
					else eval("\$fields .= \" ".$tpl->get("memberslist_none")."\";");
					break;

					case 'yim':
					if ($members['yim']) {
						$members['yim'] = htmlconverter($members['yim']);
						$yim = $members['yim'];
						$LANG_MEMBERS_YIM = $lang->get("LANG_MEMBERS_YIM", array('$username' => $username, '$yim' => $yim));
						eval("\$fields .= \" ".$tpl->get("memberslist_yim")."\";");
					}
					else eval("\$fields .= \" ".$tpl->get("memberslist_none")."\";");
					break;

					case 'msn':
					if ($members['msn']) {
						$members['msn'] = htmlconverter($members['msn']);
						$LANG_MEMBERS_MSN = $lang->get("LANG_MEMBERS_MSN", array('$username' => $username));
						eval("\$fields .= \" ".$tpl->get("memberslist_msn")."\";");
					}
					else eval("\$fields .= \" ".$tpl->get("memberslist_none")."\";");
					break;

					case 'lastactivity':
					if ($members['invisible'] == 0 || $wbbuserdata['a_can_use_acp'] == 1) {
						$la_date = formatdate($wbbuserdata['dateformat'], $members['lastactivity'], 1);
						$la_time = formatdate($wbbuserdata['timeformat'], $members['lastactivity']);
						eval("\$fields .= \" ".$tpl->get("memberslist_lastactivity")."\";");
					}
					else eval("\$fields .= \" ".$tpl->get("memberslist_none")."\";");
					break;

					case 'birthday':
					if ($members['birthday'] && $members['birthday'] != "0000-00-00") {
						$birthday_array = explode("-", $members['birthday']);
						if ($birthday_array[0] == "0000") $birthday =  $birthday_array[2].".".$birthday_array[1].".";
						else $birthday =  $birthday_array[2].".".$birthday_array[1].".".$birthday_array[0];
						eval("\$fields .= \" ".$tpl->get("memberslist_birthday")."\";");
					}
					else eval("\$fields .= \" ".$tpl->get("memberslist_none")."\";");
					break;

					case 'gender':
					if ($members['gender']) {
						if ($members['gender'] == 1) $gender = $lang->items['LANG_MEMBERS_PROFILE_MALE'];
						else $gender = $lang->items['LANG_MEMBERS_PROFILE_FEMALE'];
						eval("\$fields .= \" ".$tpl->get("memberslist_gender")."\";");
					}
					else eval("\$fields .= \" ".$tpl->get("memberslist_none")."\";");
					break;

					case 'buddy':
					$LANG_MEMBERS_BUDDY = $lang->get("LANG_MEMBERS_BUDDY", array('$username' => $username));
					eval("\$fields .= \" ".$tpl->get("memberslist_buddy")."\";");
					break;

					case 'regdate':
					$regdate = formatdate($wbbuserdata['dateformat'], $members['regdate']);
					eval("\$fields .= \" ".$tpl->get("memberslist_regdate")."\";");
					break;
				}
			}

			$count++;
		}

		eval("\$membersbit .= \" ".$tpl->get("memberslist_membersbit")."\";");
	}

	return $membersbit;
}












if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = '';

$profilefieldcache = 0;

$a_show = explode("|", $memberslistoptions_show);

if (isset($_REQUEST['sortby'])) $_REQUEST['sortby'] = $_REQUEST['sortby'];
else $_REQUEST['sortby'] = '';

$sortby = '';
while (list($key, $val) = each($a_show)) {
	$fieldname = getSearchFieldname($val);
	if ($fieldname != '' && $fieldname == $_REQUEST['sortby']) {
		$sortby = $_REQUEST['sortby'];
		break;
	}
}

if ($sortby == '') $sortby = $default_memberslist_sortfield;

if (isset($_REQUEST['order'])) $order = $_REQUEST['order'];
else $order = '';

switch ($order) {
	case 'ASC': break;
	case 'DESC': break;
	default: $order = $default_memberslist_sortorder;
}

$sel_order[$order] = " selected=\"selected\" ";



// members search
if ($action == "search") {
	$colspan = 2;
	$membersbit = '';

	if (isset($_REQUEST['send'])) {
		$where = '';

		if (isset($_REQUEST['limit'])) {
			$limit = intval($_REQUEST['limit']);
			if ($limit <= 0) $limit = $membersperpage;
			if ($limit > 500) $limit = 500;
		}
		else $limit = $membersperpage;

		$link = "memberslist.php?action=search&amp;send=send&amp;limit=$limit&amp;".$SID_ARG_2ND."&amp;";

		if (isset($_REQUEST['username']) && $_REQUEST['username']) {
			add2where("username LIKE '%".addslashes($_REQUEST['username'])."%'");
			linkGenerator("username", $_REQUEST['username']);
		}
		if (isset($_REQUEST['email']) && $_REQUEST['email']) {
			add2where("showemail=1 AND email LIKE '%".addslashes($_REQUEST['email'])."%'");
			linkGenerator("email", $_REQUEST['email']);
		}
		if (isset($_REQUEST['title']) && $_REQUEST['title']) {
			add2where("title LIKE '%".addslashes($_REQUEST['title'])."%'");
			linkGenerator("title", $_REQUEST['title']);
		}
		if (isset($_REQUEST['usertext']) && $_REQUEST['usertext']) {
			add2where("usertext LIKE '%".addslashes($_REQUEST['usertext'])."%'");
			linkGenerator("usertext", $_REQUEST['usertext']);
		}
		if (isset($_REQUEST['signature']) && $_REQUEST['signature']) {
			linkGenerator("signature", $_REQUEST['signature']);
			add2where("signature LIKE '%".addslashes($_REQUEST['signature'])."%'");
		}
		if (isset($_REQUEST['homepage']) && $_REQUEST['homepage']) {
			add2where("homepage LIKE '%".addslashes($_REQUEST['homepage'])."%'");
			linkGenerator("homepage", $_REQUEST['homepage']);
		}
		if (isset($_REQUEST['icq']) && $_REQUEST['icq']) {
			add2where("icq LIKE '%".intval($_REQUEST['icq'])."%'");
			linkGenerator("icq", $_REQUEST['icq']);
		}
		if (isset($_REQUEST['aim']) && $_REQUEST['aim']) {
			add2where("aim LIKE '%".addslashes($_REQUEST['aim'])."%'");
			linkGenerator("aim", $_REQUEST['aim']);
		}
		if (isset($_REQUEST['yim']) && $_REQUEST['yim']) {
			add2where("yim LIKE '%".addslashes($_REQUEST['yim'])."%'");
			linkGenerator("yim", $_REQUEST['yim']);
		}
		if (isset($_REQUEST['msn']) && $_REQUEST['msn']) {
			add2where("msn LIKE '%".addslashes($_REQUEST['msn'])."%'");
			linkGenerator("msn", $_REQUEST['msn']);
		}
		if (isset($_REQUEST['userposts_morethen']) && $_REQUEST['userposts_morethen'] != '') {
			add2where("userposts > '".intval($_REQUEST['userposts_morethen'])."'");
			linkGenerator("userposts_morethen", $_REQUEST['userposts_morethen']);
		}
		if (isset($_REQUEST['userposts_lessthen']) && $_REQUEST['userposts_lessthen'] != '') {
			add2where("userposts < '".intval($_REQUEST['userposts_lessthen'])."'");
			linkGenerator("userposts_lessthen", $_REQUEST['userposts_lessthen']);
		}
		if (isset($_REQUEST['gender']) && $_REQUEST['gender'] != 0) {
			add2where("gender = '".intval($_REQUEST['gender'])."'");
			linkGenerator("gender", $_REQUEST['gender']);
		}

		$userfields = 0;
		$dayfield = $_REQUEST['dayfield'];
		$monthfield = $_REQUEST['monthfield'];
		$yearfield = $_REQUEST['yearfield'];
		$result_userfields = $db->unbuffered_query("SELECT profilefieldid,fieldtype FROM bb".$n."_profilefields WHERE hidden = 0 ORDER BY profilefieldid ASC");
		while ($row = $db->fetch_array($result_userfields)) {
			switch ($row['fieldtype']) {
				case 'text':
				if (isset($_REQUEST['profilefield'][$row['profilefieldid']]) && $_REQUEST['profilefield'][$row['profilefieldid']]) {
					$userfields = 1;
					add2where("field".$row['profilefieldid']." LIKE '%".addslashes($_REQUEST['profilefield'][$row['profilefieldid']])."%'");
					linkGenerator("profilefield[".$row['profilefieldid']."]", $_REQUEST['profilefield'][$row['profilefieldid']]);
				}
				break;

				case 'checkbox':
				if (isset($_REQUEST['profilefield'][$row['profilefieldid']]) && $_REQUEST['profilefield'][$row['profilefieldid']]) {
					$userfields = 1;
					add2where("field".$row['profilefieldid']."='".addslashes($_REQUEST['profilefield'][$row['profilefieldid']])."'");
					linkGenerator("profilefield[".$row['profilefieldid']."]", $_REQUEST['profilefield'][$row['profilefieldid']]);
				}
				break;

				case 'select':
				if (isset($_REQUEST['profilefield'][$row['profilefieldid']]) && $_REQUEST['profilefield'][$row['profilefieldid']]) {
					$userfields = 1;
					add2where("field".$row['profilefieldid']."='".addslashes($_REQUEST['profilefield'][$row['profilefieldid']])."'");
					linkGenerator("profilefield[".$row['profilefieldid']."]", $_REQUEST['profilefield'][$row['profilefieldid']]);
				}
				break;

				case 'multiselect':
				if (isset($_REQUEST['profilefield'][$row['profilefieldid']]) && is_array($_REQUEST['profilefield'][$row['profilefieldid']]) && count($_REQUEST['profilefield'][$row['profilefieldid']])) {
					$userfields = 1;
					$subwhere = '';
					foreach ($_REQUEST['profilefield'][$row['profilefieldid']] as $val) {
						if ($subwhere != '') $subwhere .= ' OR ';
						$subwhere .= "field".$row['profilefieldid']." like '%".addslashes($val)."%'";
						linkGenerator("profilefield[".$row['profilefieldid']."][]", $val);
					}
					
					if ($subwhere != '') add2where("(".$subwhere.")");
				}
				break;

				case 'date':
				if ($dayfield[$row['profilefieldid']] && $monthfield[$row['profilefieldid']]) {
					$userfields = 1;
					$datefield = ((wbb_strlen($yearfield[$row['profilefieldid']]) == 4) ? ($yearfield[$row['profilefieldid']]) : (((wbb_strlen($yearfield[$row['profilefieldid']]) == 2) ? ("19".$yearfield[$row['profilefieldid']]) : ("0000"))))."-".(($monthfield[$row['profilefieldid']] < 10) ? ("0".$monthfield[$row['profilefieldid']]) : ($monthfield[$row['profilefieldid']]))."-".(($dayfield[$row['profilefieldid']] < 10) ? ("0".$dayfield[$row['profilefieldid']]) : ($dayfield[$row['profilefieldid']]));
					add2where("field".$row['profilefieldid']."='".$datefield."'");
					linkGenerator("yearfield[".$row['profilefieldid']."]", $yearfield[$row['profilefieldid']]);
					linkGenerator("monthfield[".$row['profilefieldid']."]", $monthfield[$row['profilefieldid']]);
					linkGenerator("dayfield[".$row['profilefieldid']."]", $dayfield[$row['profilefieldid']]);
				}
				break;
			}
		}

		$userids = '';
		$result = $db->query("SELECT u.userid FROM bb".$n."_users u".(($userfields == 1) ? (" LEFT JOIN bb".$n."_userfields USING (userid)") : ("")).(($where) ? (" WHERE $where") : ("")));
		$memberscount = $db->num_rows($result);
		if ($memberscount == 0) error($lang->items['LANG_GLOBAL_ERROR_SEARCHNORESULT']);
		while ($row = $db->fetch_array($result)) $userids .= ",".$row['userid'];

		if (isset($_REQUEST['page'])) {
			$page = intval($_REQUEST['page']);
			if ($page < 1) $page = 1;
		}
		else $page = 1;

		$linkpages = $link . "order=$order&amp;sortby=$sortby";
		$pages = ceil($memberscount / $limit);
		if ($page > $pages) $page = 1;
		if ($pages > 1) $pagelink = makePageLink($linkpages, $page, $pages, $showpagelinks - 1);

		$select = '';
		$join = '';

		if (strstr($sortby, "field")) $join .= " LEFT JOIN bb".$n."_userfields uf USING(userid)";
		if ($sortby == "postsperday") $select .= ", IF((UNIX_TIMESTAMP()-regdate)/86400>1,userposts/((UNIX_TIMESTAMP()-regdate)/86400),userposts) AS postsperday";
		if ($sortby == "userlevel") $select .= ", userposts*((UNIX_TIMESTAMP()-regdate)/86400) AS userlevel";
		if ($sortby == "ranktitle") {
			$select .= ", IF(title<>'',title,r.ranktitle) AS ranktitle";
			$join .= " LEFT JOIN bb".$n."_ranks r ON(u.rankid=r.rankid)";
		}

		$result = $db->unbuffered_query("SELECT u.userid".$select." FROM bb".$n."_users u".$join." WHERE u.userid IN (0$userids) ORDER BY $sortby $order", 0, $limit, $limit * ($page - 1));
		$userids = '';
		while ($row = $db->fetch_array($result)) $userids .= ",".$row['userid'];

		$fieldheader = '';
		$colspan = 0;

		$membersbit = makeMembersbit($userids, $link);
		if ($membersbit == '') error($lang->items['LANG_GLOBAL_ERROR_SEARCHNORESULT']);
	}
	else  {
		$morebit = '';
		$count = 0;

		$result = $db->unbuffered_query("SELECT profilefieldid, title, fieldtype, fieldoptions FROM bb".$n."_profilefields WHERE hidden = 0 ORDER BY fieldorder ASC");
		while ($row = $db->fetch_array($result)) {
			$field_options = '';
			switch ($row['fieldtype']) {
				case 'select':
				$row_options = explode("\n", wbb_trim($row['fieldoptions']));
				$field_options = "<option value=\"\"></option>\n";
				foreach ($row_options as $option) $field_options .= makeoption(wbb_trim($option), wbb_trim($option), "");
				break;

				case 'multiselect':
				$row_options = explode("\n", wbb_trim($row['fieldoptions']));
				$field_options = '';
				foreach ($row_options as $option) $field_options .= makeoption(wbb_trim($option), wbb_trim($option), "");
				break;

				case 'date':
				$dayfield_value = "<option value=\"\"></option>\n";
				$monthfield_value = "<option value=\"\"></option>\n";
				for ($i = 1; $i <= 31; $i++) $dayfield_value .= makeoption($i, $i, "");
				for ($i = 1; $i <= 12; $i++) $monthfield_value .= makeoption($i, getmonth($i), "");
				$yearfield_value = '';
				break;
			}

			$searchfield = getlangvar($row['title'], $lang);
			if ($row['fieldtype'] == "multiselect" || $row['fieldtype'] == "text") {
				$LANG_SEARCHFIELD_PROFILEFIELD = $lang->get("LANG_MEMBERS_MBS_SEARCHFIELD_CONTAINS", array('$searchfield' => $searchfield));
			}
			else {
				$LANG_SEARCHFIELD_PROFILEFIELD = $lang->get("LANG_MEMBERS_MBS_SEARCHFIELD_IS", array('$searchfield' => $searchfield));
			}

			$rowclass = getone($count++, "tablea", "tableb");
			eval("\$morebit .= \"".$tpl->get("memberssearch_morebit_".$row['fieldtype'])."\";");
		}

		$fields_contains = array("USERNAME", "EMAIL", "TITLE", "USERTEXT", "SIGNATURE", "HOMEPAGE", "ICQ", "AIM", "YIM", "MSN");
		for ($i = 0; $i < count($fields_contains); $i++) {
			$searchfield = $lang->items['LANG_MEMBERS_MBL_'.$fields_contains[$i]];
			$name = "LANG_SEARCHFIELD_$fields_contains[$i]";
			$$name = $lang->get("LANG_MEMBERS_MBS_SEARCHFIELD_CONTAINS", array('$searchfield' => $searchfield));
		}

		$searchfield = $lang->items['LANG_MEMBERS_MBL_GENDER'];
		$LANG_SEARCHFIELD_GENDER = $lang->get("LANG_MEMBERS_MBS_SEARCHFIELD_IS", array('$searchfield' => $searchfield));
	}

	reset($a_show);
	$sortby_options = '';
	while (list($key, $val) = each($a_show)) {
		$fieldname = $lang->get("LANG_MEMBERS_MBL_".wbb_strtoupper($val));

		if (strstr($val, "profilefield")) {
			if ($profilefieldcache == 0) cacheProfilefields();

			if ($profilefieldcache[wbb_substr($val, 12)]['hidden'] == 1 && $wbbuserdata['a_can_view_hidden'] != 1) continue;

			$fieldname = getlangvar($profilefieldcache[wbb_substr($val, 12)]['title'], $lang);
		}

		$searchname = getSearchFieldname($val);
		if ($searchname != '') $sortby_options .= makeoption($searchname, $fieldname, $sortby);
	}

	eval("\$tpl->output(\"".$tpl->get("memberssearch")."\");");
}
else {
	$letteroptions = '';
	$alpha = "#ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	if (!isset($_GET['letter']) || ($_GET['letter'] && !strstr($alpha, $_GET['letter']))) $letter = '';
	else $letter = urldecode($_GET['letter']);

	for ($i = 0; $i < wbb_strlen($alpha); $i++) $letteroptions .= makeoption($alpha[$i], $alpha[$i], $letter, 1);

	eval("\$options_letter = \"".$tpl->get("memberslist_letter")."\";");

	if ($letter != '') {
		if ($letter == "#") $result = $db->query("SELECT userid FROM bb".$n."_users WHERE SUBSTRING(username,1,1) NOT IN ('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z')");
		else $result = $db->query("SELECT userid FROM bb".$n."_users WHERE SUBSTRING(username,1,1)='$letter'");

		$memberscount = $db->num_rows($result);
		$userids = '';
		while ($row = $db->fetch_array($result)) $userids .= ",".$row['userid'];
	}
	else list($memberscount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_users");

	if (isset($_GET['page'])) {
		$page = intval($_GET['page']);
		if ($page < 1) $page = 1;
	}
	else $page = 1;

	$link = "memberslist.php?letter=".urlencode($letter).$SID_ARG_2ND."&amp;";
	$pages = ceil($memberscount / $membersperpage);
	if ($page > $pages) $page = 1;
	if ($pages > 1) $pagelink = makepagelink($link . "order=$order&amp;sortby=$sortby", $page, $pages, $showpagelinks - 1);

	$select = "";
	$join = "";

	if (strstr($sortby, "field")) $join .= " LEFT JOIN bb".$n."_userfields uf USING(userid)";
	if ($sortby == "postsperday") $select .= ", IF((UNIX_TIMESTAMP()-regdate)/86400>1,userposts/((UNIX_TIMESTAMP()-regdate)/86400),userposts) AS postsperday";
	if ($sortby == "userlevel") $select .= ", userposts*((UNIX_TIMESTAMP()-regdate)/86400) AS userlevel";
	if ($sortby == "ranktitle") {
		$select .= ", IF(title<>'',title,r.ranktitle) AS ranktitle";
		$join .= " LEFT JOIN bb".$n."_ranks r ON(u.rankid=r.rankid)";
	}

	$result = $db->unbuffered_query("SELECT u.userid".$select." FROM bb".$n."_users u".$join." ".(($letter != '') ? ("WHERE u.userid IN (0$userids) ") : (""))."ORDER BY $sortby $order", 0, $membersperpage, $membersperpage * ($page - 1));
	$userids = '';
	while ($row = $db->fetch_array($result)) $userids .= ",".$row['userid'];

	$fieldheader = '';
	$colspan = 0;

	$membersbit = makeMembersbit($userids, $link);

	eval("\$options_order = \"".$tpl->get("memberslist_order")."\";");

	reset($a_show);
	$sortby_options = '';
	while (list($key, $val) = each($a_show)) {
		$fieldname = $lang->get("LANG_MEMBERS_MBL_".wbb_strtoupper($val));

		if (strstr($val, "profilefield")) {
			if ($profilefieldcache == 0) cacheProfilefields();

			if ($profilefieldcache[wbb_substr($val, 12)]['hidden'] == 1 && $wbbuserdata['a_can_view_hidden'] != 1) continue;

			$fieldname = getlangvar($profilefieldcache[wbb_substr($val, 12)]['title'], $lang);
		}

		$searchname = getSearchFieldname($val);
		if ($searchname != '') $sortby_options .= makeoption($searchname, $fieldname, $sortby);
	}

	eval("\$options_sortby = \"".$tpl->get("memberslist_sortby")."\";");

	$lang->items['LANG_MEMBERS_MBL_SORTOPTIONS'] = $lang->get("LANG_MEMBERS_MBL_SORTOPTIONS", array('$options_letter' => $options_letter, '$options_sortby' => $options_sortby, '$options_order' => $options_order));
	eval("\$tpl->output(\"".$tpl->get("memberslist")."\");");
}
?>
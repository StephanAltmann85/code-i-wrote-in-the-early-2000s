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
// * $Date: 2005-03-22 10:33:16 +0100 (Tue, 22 Mar 2005) $
// * $Author: Burntime $
// * $Rev: 1578 $
// ************************************************************************************//


require('./global.php');
$lang->load('REGISTER,ACP_USERS,POSTINGS,MEMBERS');

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = "find";

function daynumber($time) {
	global $wbbuserdata;
	$daynumber = intval(date('w', $time)) - $wbbuserdata['startweek'];
	if ($daynumber < 0) $daynumber = 7 + $daynumber;
	return $daynumber;
}

/* add a new useraccount */
if ($action == "add") {
	checkAdminPermissions("a_can_users_add", 1);



	// form has been sent
	if (isSet($_POST['send'])) {
		// most important data
		if (isSet($_POST['username'])) $username = $_POST['username'];
		else $username = '';
		if (isSet($_POST['email'])) $email = $_POST['email'];
		else $email = '';
		if (isSet($_POST['password'])) $password = $_POST['password'];
		else $password = '';
		if (isSet($_POST['groupids']) && is_array($_POST['groupids'])) $groupids = intval_array($_POST['groupids']);
		else $groupids = array();
		
		$username = preg_replace("/\s{2,}/", " ", $username);

		// other data
		if (isSet($_POST['field'])) $field = $_POST['field'];
		else $field = array();
		if (isSet($_POST['field'])) $dayfield = $_POST['dayfield'];
		else $dayfield = array();
		if (isSet($_POST['field'])) $monthfield = $_POST['monthfield'];
		else $monthfield = array();
		if (isSet($_POST['field'])) $yearfield = $_POST['yearfield'];
		else $yearfield = array();


		// signature options
		if (isSet($_POST['disablesmilies'])) $disablesmilies = $_POST['disablesmilies'];
		else $disablesmilies = 0;
		if (isSet($_POST['disablehtml'])) $disablehtml = $_POST['disablehtml'];
		else $disablehtml = 0;
		if (isSet($_POST['disablebbcode'])) $disablebbcode = $_POST['disablebbcode'];
		else $disablebbcode = 0;
		if (isSet($_POST['disableimages'])) $disableimages = $_POST['disableimages'];
		else $disableimages = 0;



		if (isSet($_POST['title'])) $title = $_POST['title'];
		else $title = '';
		if (isSet($_POST['homepage'])) $homepage = $_POST['homepage'];
		else $homepage = '';
		if (isSet($_POST['icq'])) $icq = intval(str_replace("-", "", wbb_trim($_POST['icq'])));
		else $icq = '';
		if (isSet($_POST['aim'])) $aim = $_POST['aim'];
		else $aim = '';
		if (isSet($_POST['msn'])) $msn = $_POST['msn'];
		else $msn = '';
		if (isSet($_POST['yim'])) $yim = $_POST['yim'];
		else $yim = '';
		if (isSet($_POST['day'])) $day = intval($_POST['day']);
		else $day = '';
		if (isSet($_POST['month'])) $month = intval($_POST['month']);
		else $month = '';
		if (isSet($_POST['year'])) $year = intval($_POST['year']);
		else $year = '';
		if (isSet($_POST['gender'])) $gender = intval($_POST['gender']);
		else $gender = 0;
		if (isSet($_POST['usertext'])) $usertext = $_POST['usertext'];
		else $usertext = '';
		if (isSet($_POST['signature'])) $signature = $_POST['signature'];
		else $signature = '';
		if (isSet($_POST['rankgroupid'])) $rankgroupid = intval($_POST['rankgroupid']);
		else $rankgroupid = 0;
		if (isSet($_POST['useronlinegroupid'])) $useronlinegroupid = intval($_POST['useronlinegroupid']);
		else $useronlinegroupid = 0;


		if (isSet($_POST['invisible'])) $invisible = intval($_POST['invisible']);
		else $invisible = $default_register_invisible;
		if (isSet($_POST['usecookies'])) $usecookies = intval($_POST['usecookies']);
		else $usecookies = $default_register_usecookies;
		if (isSet($_POST['admincanemail'])) $admincanemail = intval($_POST['admincanemail']);
		else $admincanemail = $default_register_admincanemail;
		if (isSet($_POST['showemail'])) $showemail = intval($_POST['showemail']);
		else $showemail = 1 - $default_register_showemail;
		if (isSet($_POST['usercanemail'])) $usercanemail = intval($_POST['usercanemail']);
		else $usercanemail = $default_register_usercanemail;
		if (isSet($_POST['emailnotify'])) $emailnotify = intval($_POST['emailnotify']);
		else $emailnotify = $default_register_emailnotify;
		if (isSet($_POST['receivepm'])) $receivepm = intval($_POST['receivepm']);
		else $receivepm = $default_register_receivepm;
		if (isSet($_POST['emailonpm'])) $emailonpm = intval($_POST['emailonpm']);
		else $emailonpm = $default_register_emailonpm;
		if (isSet($_POST['pmpopup'])) $pmpopup = intval($_POST['pmpopup']);
		else $pmpopup = $default_register_pmpopup;
		if (isSet($_POST['emailonapplication'])) $emailonapplication = intval($_POST['emailonapplication']);
		else $emailonapplication = 0;
		if (isSet($_POST['showsignatures'])) $showsignatures = intval($_POST['showsignatures']);
		else $showsignatures = $default_register_showsignatures;
		if (isSet($_POST['showavatars'])) $showavatars = intval($_POST['showavatars']);
		else $showavatars = $default_register_showavatars;
		if (isSet($_POST['showimages'])) $showimages = intval($_POST['showimages']);
		else $showimages = $default_register_showimages;
		if (isSet($_POST['threadview'])) $threadview = intval($_POST['threadview']);
		else $threadview = $default_register_threadview;
		if (isSet($_POST['timezoneoffset'])) $timezoneoffset = (float)($_POST['timezoneoffset']);
		else $timezoneoffset = $default_timezoneoffset;
		if (isSet($_POST['startweek'])) $startweek = intval($_POST['startweek']);
		else $startweek = $default_startweek;
		if (isSet($_POST['udateformat'])) $udateformat = $_POST['udateformat'];
		else $udateformat = $default_dateformat;
		if (isSet($_POST['utimeformat'])) $utimeformat = $_POST['utimeformat'];
		else $utimeformat = $default_timeformat;

		if (isSet($_POST['styleid'])) $styleid = intval($_POST['styleid']);
		else $styleid = 0;
		if (isSet($_POST['langid'])) $langid = intval($_POST['langid']);
		else $langid = 0;
		if (isSet($_POST['avatarid'])) $avatarid = intval($_POST['avatarid']);
		else $avatarid = 0;
		if (isSet($_POST['usewysiwyg'])) $usewysiwyg = intval($_POST['usewysiwyg']);
		else $usewysiwyg = 0;
		
		if (isSet($_POST['notificationperpm'])) $notificationperpm = intval($_POST['notificationperpm']);
		else $notificationperpm = 0;

		$error = '';
		if (!$username || !$email || !$password || !count($groupids)) $error .= $lang->items['LANG_POSTINGS_ERROR1'];
		if (!verify_username($username)) $error .= $lang->items['LANG_REGISTER_ERROR2'];
		if (!verify_email($email)) $error .= $lang->items['LANG_REGISTER_ERROR3'];
		
		if ($error) $error = acp_error_frame($lang->get("LANG_ACP_USERS_ADD_ERROR", array('$error' => $error)));
		else {
			$result = $db->query("SELECT groupid,securitylevel FROM bb".$n."_groups WHERE groupid IN (".implode(",", $groupids).") ORDER BY grouptype ASC, securitylevel ASC");
			$groupids = array();
			while ($row = $db->fetch_array($result)) if (checkSecurityLevel($row['securitylevel'])) $groupids[] = $row['groupid'];
			if (!count($groupids)) access_error(1);
			$rankgroupid = $groupids[count($groupids) - 1];
			$useronlinegroupid = $groupids[count($groupids) - 1];

			if ($homepage && !preg_match("/[a-zA-Z]:\/\//si", $homepage)) $homepage = "http://".$homepage;
			if ($day && $month) $birthday = ((wbb_strlen($year) == 4) ? ($year) : (((wbb_strlen($year) == 2) ? ("19$year") : ("0000"))))."-".(($month < 10) ? ("0$month") : ($month))."-".(($day < 10) ? ("0$day") : ($day));
			else $birthday = "0000-00-00";

			$fieldlist = '';
			$fieldvalues = '';
			$result = $db->query("SELECT profilefieldid, fieldtype FROM bb".$n."_profilefields ORDER BY profilefieldid ASC");
			while ($row = $db->fetch_array($result)) {
				$fieldlist .= ",field".$row['profilefieldid'];
				if ($row['fieldtype'] == "multiselect") {
					if (is_array($field[$row['profilefieldid']]) && count($field[$row['profilefieldid']])) $fieldvalues .= ",'".addslashes(trim(implode("\n", $field[$row['profilefieldid']])))."'";
					else $fieldvalues .= ",''";
				}
				elseif ($row['fieldtype'] == "date") {
					if ($dayfield[$row['profilefieldid']] && $monthfield[$row['profilefieldid']]) $datefield = ((wbb_strlen($yearfield[$row['profilefieldid']]) == 4) ? ($yearfield[$row['profilefieldid']]) : (((wbb_strlen($yearfield[$row['profilefieldid']]) == 2) ? ("19".$yearfield[$row['profilefieldid']]) : ("0000"))))."-".(($monthfield[$row['profilefieldid']] < 10) ? ("0".$monthfield[$row['profilefieldid']]) : ($monthfield[$row['profilefieldid']]))."-".(($dayfield[$row['profilefieldid']] < 10) ? ("0".$dayfield[$row['profilefieldid']]) : ($dayfield[$row['profilefieldid']]));
					else $datefield = "0000-00-00";
					$fieldvalues .= ",'".$datefield."'";
				}
				else $fieldvalues .= ",'".addslashes($field[$row['profilefieldid']])."'";
			}

			sort($groupids);

			$groupcombinationid = cachegroupcombinationdata(implode(",", $groupids), 0);
			$groupcombination = $db->query_first("SELECT data FROM bb".$n."_groupcombinations WHERE groupcombinationid='".$groupcombinationid."'");
			$groupcombinationdata = unserialize($groupcombination['data']);

			/* signature feature rights:start */
  			if (!$groupcombinationdata['can_use_sig_smilies'] || $disablesmilies == 1) $allowsmilies = 0;
  			else $allowsmilies = 1;

  			if (!$groupcombinationdata['can_use_sig_html'] || $disablehtml == 1) $allowhtml = 0;
  			else $allowhtml = 1;

  			if (!$groupcombinationdata['can_use_sig_bbcode'] || $disablebbcode == 1) $allowbbcode = 0;
  			else $allowbbcode = 1;

  			if (!$groupcombinationdata['can_use_sig_images'] || $disableimages == 1) $allowimages = 0;
  			else $allowimages = 1;
  			/* signature feature rights:end */


			// get rankid
			$rankid = $db->query_first("SELECT rankid FROM bb".$n."_ranks WHERE groupid = '".$rankgroupid."' AND needposts = 0 AND gender IN (0,'".$gender."') ORDER BY gender DESC");

			// insert user
			$db->query("INSERT INTO bb".$n."_users (username,password,sha1_password,email,groupcombinationid,rankid,title,regdate,lastvisit,lastactivity,usertext,signature,icq,aim,yim,msn,homepage,birthday,gender,showemail,admincanemail,usercanemail,invisible,usecookies,styleid,langid,activation,daysprune,timezoneoffset,startweek,dateformat,timeformat,emailnotify,notificationperpm,receivepm,emailonpm,pmpopup,emailonapplication,umaxposts,showsignatures,showavatars,showimages,avatarid,threadview,rankgroupid,useronlinegroupid,allowsigsmilies,allowsightml,allowsigbbcode,allowsigimages,usewysiwyg) VALUES " .
			"('".addslashes($username)."','".md5($password)."','".sha1($password)."','".addslashes($email)."','".$groupcombinationid."','".$rankid['rankid']."','".addslashes($title)."','".time()."','".time()."','".time()."','".addslashes($usertext)."','".addslashes($signature)."','".intval($icq)."','".addslashes($aim)."','".addslashes($yim)."','".addslashes($msn)."','".addslashes($homepage)."','".addslashes($birthday)."','".intval($gender)."','".intval($showemail)."','".intval($admincanemail)."','".intval($usercanemail)."','".intval($invisible)."','".intval($usecookies)."','".intval($styleid)."','".intval($langid)."','1','".intval($daysprune)."','".addslashes($timezoneoffset)."','".intval($startweek)."','".addslashes($udateformat)."','".addslashes($utimeformat)."','".intval($emailnotify)."','".intval($notificationperpm)."','".intval($receivepm)."','".intval($emailonpm)."','".intval($pmpopup)."','".intval($emailonapplication)."','".intval($umaxposts)."','".intval($showsignatures)."','".intval($showavatars)."','".intval($showimages)."','".intval($avatarid)."', '".intval($threadview)."', '".intval($rankgroupid)."', '".intval($useronlinegroupid)."','".$allowsmilies."','".$allowhtml."','".$allowbbcode."','".$allowimages."','".$usewysiwyg."')");

			// get insert id
			$insertid = $db->insert_id();

			$groupvalues = '';
			foreach ($groupids as $groupid) $groupvalues .= ",('".$insertid."','".$groupid."')";
			$db->query("INSERT INTO bb".$n."_user2groups (userid,groupid) VALUES ".wbb_substr($groupvalues, 1));
			$db->query("INSERT INTO bb".$n."_userfields (userid".$fieldlist.") VALUES (".$insertid.$fieldvalues.")");
			$db->query("UPDATE bb".$n."_stats SET usercount=usercount+1, lastuserid='".$insertid."'");

			header("Location: users.php?action=find&sid=$session[hash]");
			exit;
		}
	}
	else {
		$username = '';
		$email = '';
		$password = '';
		$title = '';
		$homepage = '';
		$icq = '';
		$aim = '';
		$yim = '';
		$msn = '';
		$groupids = array();
		$year = '';
		$day = 0;
		$month = 0;
		$gender = 0;
		$usertext = '';
		$signature = '';
		$disablesignature = 0;
		$langid = 0;
		$styleid = 0;
		$avatarid = 0;

		$dayfield = array();
		$monthfield = array();
		$yearfield = array();
		$field = array();

		// predefined values
		$invisible = $default_register_invisible;
		$usecookies = $default_register_usecookies;
		$admincanemail = $default_register_admincanemail;
		$showemail = 1 - $default_register_showemail;
		$usercanemail = $default_register_usercanemail;
		$emailnotify = $default_register_emailnotify;
		$receivepm = $default_register_receivepm;
		$emailonpm = $default_register_emailonpm;
		$pmpopup = $default_register_pmpopup;
		$emailonapplication = 0;
		$showsignatures = $default_register_showsignatures;
		$showavatars = $default_register_showavatars;
		$showimages = $default_register_showimages;
		$threadview = $default_register_threadview;
		$timezoneoffset = $default_timezoneoffset;
		$startweek = $default_startweek;
		$udateformat = $dateformat;
		$utimeformat = $timeformat;
		$notificationperpm = 0;

		// signature options
		$disablesmilies = $register_default_checked_0;
		$disablehtml = $register_default_checked_1;
		$disablebbcode = $register_default_checked_2;
		$disableimages = $register_default_checked_3;
		$usewysiwyg = $default_register_usewysiwyg;
		
		$groupids = array();
		list($groupids[]) = $db->query_first("SELECT groupid FROM bb".$n."_groups WHERE grouptype='4'");
	}



	/* convert html characters */
	$username = htmlconverter($username);
	$password = '';
	$email = htmlconverter($email);
	$title = htmlconverter($title);
	$usertext = htmlconverter($usertext);
	$signature = htmlconverter($signature);
	$homepage = htmlconverter($homepage);
	$aim = htmlconverter($aim);
	$msn = htmlconverter($msn);
	$yim = htmlconverter($yim);

	/* birthday options */
	$day_options = '';
	$month_options = '';
	for ($i = 1; $i <= 31; $i++) $day_options .= makeoption($i, $i, $day, 1);
	for ($i = 1; $i <= 12; $i++) $month_options .= makeoption($i, getmonth($i), $month, 1);

	/* group options */
	$group_options = '';
	$result = $db->query("SELECT groupid,title FROM bb".$n."_groups WHERE grouptype>3".(($wbbuserdata['a_override_max_securitylevel'] != -1) ? (" AND securitylevel<='".$wbbuserdata['a_override_max_securitylevel']."'") : (""))." ORDER BY grouptype DESC, title ASC");
	while ($row = $db->fetch_array($result)) $group_options .= makeoption($row['groupid'], getlangvar($row['title'], $lang), ((in_array($row['groupid'], $groupids)) ? ($row['groupid']) : ("")));

	/* timezones */
	$timezone_options = '';
	$timezones = explode("\n", $lang->items['LANG_REGISTER_TIMEZONES']);
	for ($i = 0; $i < count($timezones); $i++) {
		$parts = explode("|", trim($timezones[$i]));
		$timezone_options .= makeoption($parts[0], "(GMT".(($parts[1]) ? (" ".$parts[1]) : ("")).") $parts[2]", $timezoneoffset);
	}
	/* startweek options */
	$startweek_options = '';
	for ($i = 0; $i < 7; $i++) $startweek_options .= makeoption($i, getday($i), $startweek);

	/* profilefields */
	$y = 1;
	$result = $db->query("SELECT * FROM bb".$n."_profilefields ORDER BY fieldorder ASC");
	while ($row = $db->fetch_array($result)) {
		$field_value = '';
		$field_checked = '';
		$dayfield_value = '';
		$monthfield_value = '';
		$yearfield_value = '';
		$row_options = array();
		$selected_options = array();

		switch ($row['fieldtype']) {
			case "text":
				$field_value = ((isSet($field[$row['profilefieldid']])) ? (htmlconverter($field[$row['profilefieldid']])) : (""));
			break;

			case "select":
				$row_options = explode("\n", trim($row['fieldoptions']));
				$field_value = "<option value=\"\"></option>\n";
				foreach ($row_options as $option) $field_value .= makeoption(htmlconverter($option), htmlconverter($option), ((isSet($field[$row['profilefieldid']])) ? ($field[$row['profilefieldid']]) : ("")));
			break;

			case "multiselect":
				$row_options = explode("\n", $row['fieldoptions']);
				if (isset($_POST['send']) && is_array($field[$row['profilefieldid']]) && count($field[$row['profilefieldid']])) $selected_options = $field[$row['profilefieldid']];
				else $selected_options = array();
				foreach ($row_options as $option) $field_value .= makeoption(htmlconverter($option), htmlconverter($option), ((in_array($option, $selected_options)) ? (htmlconverter($option)) : ("")));
			break;

			case "checkbox":
				$field_value = htmlconverter($row['fieldoptions']);
				$field_checked = (($field_value == htmlconverter($field[$row['profilefieldid']])) ? (" checked=\"checked\"") : (""));
			break;

			case "date":
				$dayfield_value = "<option value=\"\"></option>\n";
				$monthfield_value = "<option value=\"\"></option>\n";
				for ($i = 1; $i <= 31; $i++) $dayfield_value .= makeoption($i, $i, $dayfield[$row['profilefieldid']]);
				for ($i = 1; $i <= 12; $i++) $monthfield_value .= makeoption($i, getmonth($i), $monthfield[$row['profilefieldid']]);
				if (intval($yearfield[$row['profilefieldid']])) $yearfield_value = $yearfield[$row['profilefieldid']];
				else $yearfield_value = '';
			break;
		}
		$row['title'] = getlangvar($row['title'], $lang);
		$row['description'] = getlangvar($row['description'], $lang);
		$rowclass = getone($y, "secondrow", "firstrow");
		eval("\$userfields .= \"".$tpl->get("users_add_userfield_".$row['fieldtype'], 1)."\";");
		$y++;
	}

	/* styles */
	$style_options = '';
	$result = $db->query("SELECT styleid, stylename FROM bb".$n."_styles ORDER BY stylename ASC");
	while ($row = $db->fetch_array($result)) $style_options .= makeoption($row['styleid'], getlangvar($row['stylename'], $lang), $styleid);

	/* language packs */
	$lang_options = '';
	$result = $db->query("SELECT languagepackid, languagepackname FROM bb".$n."_languagepacks ORDER BY languagepackname ASC");
	while ($row = $db->fetch_array($result)) $lang_options .= makeoption($row['languagepackid'], getlangvar($row['languagepackname'], $lang), $langid);

	/* avatars */
	$avatar_options = '';
	$result = $db->query("SELECT * FROM bb".$n."_avatars WHERE userid = 0 AND groupid = 0 AND needposts = 0");
	while ($row = $db->fetch_array($result)) $avatar_options .= makeoption($row['avatarid'], htmlconverter($row['avatarname'].".".$row['avatarextension']), $avatarid);

	/* selectboxes */
	$sel_gender[$gender] = " selected=\"selected\"";
	$sel_invisible[$invisible] = " selected=\"selected\"";
	$sel_usecookies[$usecookies] = " selected=\"selected\"";
	$sel_admincanemail[$admincanemail] = " selected=\"selected\"";
	$sel_showemail[$showemail] = " selected=\"selected\"";
	$sel_usercanemail[$usercanemail] = " selected=\"selected\"";
	$sel_emailnotify[$emailnotify] = " selected=\"selected\"";
	$sel_notificationperpm[$notificationperpm] = " selected=\"selected\"";
	$sel_receivepm[$receivepm] = " selected=\"selected\"";
	$sel_emailonpm[$emailonpm] = " selected=\"selected\"";
	$sel_pmpopup[$pmpopup] = " selected=\"selected\"";
	$sel_showsignatures[$showsignatures] = " selected=\"selected\"";
	$sel_showavatars[$showavatars] = " selected=\"selected\"";
	$sel_showimages[$showimages] = " selected=\"selected\"";
	$sel_daysprune[$daysprune] = " selected=\"selected\"";
	$sel_umaxposts[$umaxposts] = " selected=\"selected\"";
	$sel_threadview[$threadview] = " selected=\"selected\"";
	$sel_emailonapplication[$emailonapplication] = " selected=\"selected\"";
	$sel_usewysiwyg[$usewysiwyg] = " selected=\"selected\"";
	
	if ($disablesmilies == 1) $checked[0] = "checked=\"checked\"";
	else $checked[0] = '';
	if ($disablehtml == 1) $checked[1] = "checked=\"checked\"";
	else $checked[1] = '';
	if ($disablebbcode == 1) $checked[2] = "checked=\"checked\"";
	else $checked[2] = '';
	if ($disableimages == 1) $checked[3] = "checked=\"checked\"";
	else $checked[3] = '';

	eval("\$tpl->output(\"".$tpl->get("users_add", 1)."\",1);");
}



/* show find user form */
elseif ($action == "find") {
	if (!checkAdminPermissions("a_can_users_edit") && !checkAdminPermissions("a_can_users_delete") && !checkAdminPermissions("a_can_users_email") && !checkAdminPermissions("a_can_users_merge") && !checkAdminPermissions("a_can_users_activation") && !checkAdminPermissions("a_can_users_access") && !checkAdminPermissions("a_can_users_other")) access_error(1);
	
	$lang_options = '';
	$result = $db->query("SELECT languagepackid, languagepackname FROM bb".$n."_languagepacks ORDER BY languagepackname ASC");
	while ($row = $db->fetch_array($result)) $lang_options .= makeoption($row['languagepackid'], getlangvar($row['languagepackname'], $lang), "", 0);
	$group_options = '';
	$result = $db->query("SELECT groupid, title FROM bb".$n."_groups WHERE grouptype>1 ORDER BY title ASC");
	while ($row = $db->fetch_array($result)) $group_options .= makeoption($row['groupid'], getlangvar($row['title'], $lang), "", 0);
	$rank_options = '';
	$result = $db->query("SELECT rankid, ranktitle FROM bb".$n."_ranks ORDER BY groupid ASC, needposts DESC");
	while ($row = $db->fetch_array($result)) $rank_options .= makeoption($row['rankid'], getlangvar($row['ranktitle'], $lang), "", 0);
	$morebit = '';
	$count = 0;

	$result = $db->query("SELECT profilefieldid, title, fieldtype, fieldoptions FROM bb".$n."_profilefields ORDER BY fieldorder ASC");
	while ($row = $db->fetch_array($result)) {
		$field_options = '';
		switch ($row['fieldtype']) {
			case "text":
				//
			break;
			case "select":
				$row_options = explode("\n", wbb_trim($row['fieldoptions']));
				$field_options = "<option value=\"\"></option>\n";
				foreach ($row_options as $option) $field_options .= makeoption(htmlconverter(wbb_trim($option)), htmlconverter(wbb_trim($option)), "");
			break;
			case "multiselect":
				$row_options = explode("\n", wbb_trim($row['fieldoptions']));
				$field_options = '';
				foreach ($row_options as $option) $field_options .= makeoption(htmlconverter(wbb_trim($option)), htmlconverter(wbb_trim($option)), "");
			break;
			case "checkbox":
				//
			break;
			case "date":
				$dayfield_value = "<option value=\"\"></option>\n";
				$monthfield_value = "<option value=\"\"></option>\n";
				for ($i = 1; $i <= 31; $i++) $dayfield_value .= makeoption($i, $i, "");
				for ($i = 1; $i <= 12; $i++) $monthfield_value .= makeoption($i, getmonth($i), "");
				$yearfield_value = '';
			break;
		}
		$rowclass = getone(++$count, "secondrow" ,"firstrow");

		$searchfield = getlangvar($row['title'], $lang);
   		if ($row['fieldtype'] == "multiselect" || $row['fieldtype'] == "text") $LANG_SEARCHFIELD_PROFILEFIELD = $lang->get("LANG_MEMBERS_MBS_SEARCHFIELD_CONTAINS", array('$searchfield' => $searchfield));
   		else $LANG_SEARCHFIELD_PROFILEFIELD = $lang->get("LANG_MEMBERS_MBS_SEARCHFIELD_IS", array('$searchfield' => $searchfield));
   		
		eval("\$morebit .= \"".$tpl->get("users_find_morebit_".$row['fieldtype'], 1)."\";");
	}

	$fields_contains = array("USERNAME", "EMAIL", "TITLE", "USERTEXT", "SIGNATURE", "HOMEPAGE", "ICQ", "AIM", "YIM", "MSN");
  	for ($i = 0, $j = count($fields_contains); $i < $j; $i++) {
   		$searchfield = $lang->items['LANG_MEMBERS_MBL_'.$fields_contains[$i]];
  		
   		$name = 'LANG_SEARCHFIELD_'.$fields_contains[$i];
   		$$name = $lang->get("LANG_MEMBERS_MBS_SEARCHFIELD_CONTAINS", array('$searchfield' => $searchfield));
   	}

	$fields_is = array("LANG_MEMBERS_MBL_GENDER", "LANG_ACP_USERS_FIND_ACTIVATION", "LANG_ACP_USERS_LANGID", "LANG_ACP_USERS_FIND_USERGROUP", "LANG_ACP_USERS_FIND_RANK");
  	for ($i = 0, $j = count($fields_is); $i < $j; $i++) {
   		$searchfield = $lang->get($fields_is[$i]);

   		$temp = explode("_", $fields_is[$i]);
   		$temp = $temp[(count($temp) - 1)];

   		$name = 'LANG_SEARCHFIELD_'.$temp;
   		$$name = $lang->get("LANG_MEMBERS_MBS_SEARCHFIELD_IS", array('$searchfield' => $searchfield));
   	}

	eval("\$tpl->output(\"".$tpl->get("users_find", 1)."\",1);");
}




/* show search result */
elseif ($action == "show") {
	if (!checkAdminPermissions("a_can_users_edit") && !checkAdminPermissions("a_can_users_delete") && !checkAdminPermissions("a_can_users_email") && !checkAdminPermissions("a_can_users_merge") && !checkAdminPermissions("a_can_users_activation") && !checkAdminPermissions("a_can_users_access") && !checkAdminPermissions("a_can_users_other")) access_error(1);


	// initiate page and limit
	if (isset($_REQUEST['page'])) {
   		$page = intval($_REQUEST['page']);
   		if ($page == 0) $page = 1;
  	}
  	else $page = 1;

	if (isset($_REQUEST['limit'])) {
		$limit = intval($_REQUEST['limit']);
		if ($limit < 1) $limit = 1;
	}
	else $limit = 200;

	// initiate sortby and sortfield
	if (isset($_REQUEST['sortby'])) $sortby = $_REQUEST['sortby'];
	else $sortby = '';
	if (isset($_REQUEST['sortorder'])) $sortorder = $_REQUEST['sortorder'];
	else $sortorder = '';
	switch ($sortorder) {
		case "ASC": break;
		case "DESC": break;
		default: $sortorder = "ASC"; break;
	}
	switch ($sortby) {
		case "username": break;
		case "email": break;
		case "regdate": break;
		case "lastactivity": break;
		case "userposts": break;
		default: $sortby = "username"; break;
	}


	// build where string
	$where = '';
	$link = '';


	if (isset($_REQUEST['username']) && $_REQUEST['username']) {
	 	add2where("username LIKE '%".addslashes($_REQUEST['username'])."%'");
	 	linkGenerator("username", $_REQUEST['username']);
	}

	if (isset($_REQUEST['email']) && $_REQUEST['email']) {
		add2where("email LIKE '%".addslashes($_REQUEST['email'])."%'");
		linkGenerator("email", $_REQUEST['email']);
	}

	if (isset($_REQUEST['groupid']) && $_REQUEST['groupid']) {
		add2where("groupid = '".intval($_REQUEST['groupid'])."'");
		linkGenerator("groupid", $_REQUEST['groupid']);
	}


	if (isset($_REQUEST['rankid']) && $_REQUEST['rankid']) {
		add2where("rankid = '".intval($_REQUEST['rankid'])."'");
		linkGenerator("rankid", $_REQUEST['rankid']);
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
		add2where("signature LIKE '%".addslashes($_REQUEST['signature'])."%'");
		linkGenerator("signature", $_REQUEST['signature']);
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

	if (isset($_REQUEST['lastactivity_in']) && $_REQUEST['lastactivity_in'] != '') {
		add2where("lastactivity >= '".(time() - intval($_REQUEST['lastactivity_in']) * 3600)."'");
		linkGenerator("lastactivity_in", $_REQUEST['lastactivity_in']);
	}

	if (isset($_REQUEST['lastactivity_notin']) && $_REQUEST['lastactivity_notin'] != '') {
		add2where("lastactivity < '".(time() - intval($_REQUEST['lastactivity_notin']) * 3600)."'");
		linkGenerator("lastactivity_notin", $_REQUEST['lastactivity_notin']);
	}

	if (isset($_REQUEST['activation']) && $_REQUEST['activation'] == -1) {
		add2where("activation <> '1'");
		linkGenerator("activation", $_REQUEST['activation']);
	}

	elseif (isset($_REQUEST['activation']) && $_REQUEST['activation'] == 1) {
		add2where("activation = '1'");
		linkGenerator("activation", $_REQUEST['activation']);
	}

	if (isset($_REQUEST['blocked']) && $_REQUEST['blocked'] == 1) {
		add2where("blocked = '1'");
		linkGenerator("blocked", $_REQUEST['blocked']);
	}

	if (isset($_REQUEST['gender']) && $_REQUEST['gender'] != 0) {
		add2where("gender = '".intval($_REQUEST['gender'])."'");
		linkGenerator("gender", $_REQUEST['gender']);
	}
	if (isset($_REQUEST['langid']) && $_REQUEST['langid'] != '') {
		add2where("langid = '".intval($_REQUEST['langid'])."'");
		linkGenerator("langid", $_REQUEST['langid']);
	}

	$userfields = 0;
	if (isSet($_REQUEST['dayfield'])) $dayfield = $_REQUEST['dayfield'];
	else $dayfield = array();
	if (isSet($_REQUEST['monthfield'])) $monthfield = $_REQUEST['monthfield'];
	else $monthfield = array();
	if (isSet($_REQUEST['yearfield'])) $yearfield = $_REQUEST['yearfield'];
	else $yearfield = array();
	$result_userfields = $db->query("SELECT profilefieldid,fieldtype FROM bb".$n."_profilefields ORDER BY profilefieldid ASC");
	while ($row = $db->fetch_array($result_userfields)) {
		switch ($row['fieldtype']) {
			case "text":
				if (isset($_REQUEST['profilefield'][$row['profilefieldid']]) && $_REQUEST['profilefield'][$row['profilefieldid']]) {
					$userfields = 1;
					add2where("field".$row['profilefieldid']." LIKE '%".addslashes($_REQUEST['profilefield'][$row['profilefieldid']])."%'");
					linkGenerator("profilefield[".$row['profilefieldid']."]", $_REQUEST['profilefield'][$row['profilefieldid']]);
				}
			break;
			case "checkbox":
				if (isset($_REQUEST['profilefield'][$row['profilefieldid']]) && $_REQUEST['profilefield'][$row['profilefieldid']]) {
					$userfields = 1;
					add2where("field".$row['profilefieldid']."='".addslashes($_REQUEST['profilefield'][$row['profilefieldid']])."'");
					linkGenerator("profilefield[".$row['profilefieldid']."]", $_REQUEST['profilefield'][$row['profilefieldid']]);
				}
			break;
			case "select":
				if (isset($_REQUEST['profilefield'][$row['profilefieldid']]) && $_REQUEST['profilefield'][$row['profilefieldid']]) {
					$userfields = 1;
					add2where("field".$row['profilefieldid']."='".addslashes($_REQUEST['profilefield'][$row['profilefieldid']])."'");
					linkGenerator("profilefield[".$row['profilefieldid']."]", $_REQUEST['profilefield'][$row['profilefieldid']]);
				}
			break;
			case "multiselect":
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
			case "date":
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

	// count members
	$userids = '';
	$result = $db->query("SELECT * FROM bb".$n."_users".(($userfields == 1) ? (" LEFT JOIN bb".$n."_userfields USING (userid)") : (""))." ".((isset($_REQUEST['groupid']) && $_REQUEST['groupid']) ? (" LEFT JOIN bb".$n."_user2groups USING(userid)") : (""))." ".(($where) ? ("WHERE $where ") : ("")));
	$memberscount = $db->num_rows($result);
	if ($memberscount == 0) acp_error($lang->get("LANG_ACP_GLOBAL_ERROR_NORESULT"));
	while ($row = $db->fetch_array($result)) $userids .= ",".$row['userid'];

	$pages = ceil($memberscount / $limit);
	if ($pages > 1) $pagelink = makePageLink("users.php?action=show&amp;".$link."limit=$limit&amp;sortorder=$sortorder&amp;sortby=$sortby&amp;sid=$session[hash]", $page, $pages, $showpagelinks - 1);


	// search
	$userbit = '';
	$count = 0;
	$result = $db->unbuffered_query("SELECT * FROM bb".$n."_users WHERE userid IN (0$userids) ORDER BY $sortby $sortorder", 0, $limit, $limit * ($page - 1));
  	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count, "firstrow", "secondrow");

		$regdate = formatdate($wbbuserdata['dateformat'], $row['regdate']);
		$lastactivity = formatdate($wbbuserdata['dateformat']." ".$wbbuserdata['timeformat'], $row['lastactivity']);

		$row['username'] = htmlconverter($row['username']);
		$row['email'] = htmlconverter($row['email']);

		$username = str_replace("'", "\'", $row['username']);

		$LANG_ACP_USERS_ACTION_TITLE_EDIT = $lang->get("LANG_ACP_USERS_ACTION_TITLE_EDIT", array('$username' => $row['username']));
		$LANG_ACP_USERS_ACTION_TITLE_EMAIL = $lang->get("LANG_ACP_USERS_ACTION_TITLE_EMAIL", array('$username' => $row['username']));
		$LANG_ACP_USERS_ACTION_TITLE_DELETE = $lang->get("LANG_ACP_USERS_ACTION_TITLE_DELETE", array('$username' => $row['username']));
		$LANG_ACP_USERS_ACTION_TITLE_ACCESS = $lang->get("LANG_ACP_USERS_ACTION_TITLE_ACCESS", array('$username' => $row['username']));
		$LANG_ACP_USERS_ACTION_TITLE_CLIPBOARD = $lang->get("LANG_ACP_USERS_ACTION_TITLE_CLIPBOARD", array('$username' => $row['username']));
		
		eval("\$userbit .= \"".$tpl->get("users_showbit", 1)."\";");
		$count++;
	}

	eval("\$tpl->output(\"".$tpl->get("users_show", 1)."\",1);");
}



/* delete user */
elseif ($action == "delete") {
	checkAdminPermissions("a_can_users_delete", 1);

	if (isset($_REQUEST['userids'])) $userids = $_REQUEST['userids'];
	else {
		if (isset($_GET['userid'])) $userid = intval_array($_GET['userid']);
		elseif (isset($_POST['userid'])) $userid = intval_array($_POST['userid']);
		else $userid = array();
		$userids = implode(",", $userid);
	}

	if (!$userids) acp_error($lang->get("LANG_ACP_USERS_ERROR_SELECTNOUSER"));

	// form has been sent, delete
	if (isset($_POST['send'])) {
		if ($userids) {
			// check securitylevel
			if ($wbbuserdata['a_override_max_securitylevel'] != -1) {
				$result = $db->query("SELECT u.userid,MAX(g.securitylevel) as securitylevel FROM bb".$n."_users u LEFT JOIN bb".$n."_user2groups u2g ON u.userid=u2g.userid LEFT JOIN bb".$n."_groups g ON u2g.groupid=g.groupid WHERE u.userid IN($userids) GROUP BY u.userid");
				$userids = ",".$userids;
				while ($row = $db->fetch_array($result)) if (!checkSecurityLevel($row['securitylevel'])) $userids = str_replace(",".$row['userid'], "", $userids);
				if ($userids) $userids = wbb_substr($userids, 1);
			}
		}

		if ($userids) {
			$db->unbuffered_query("DELETE FROM bb".$n."_access WHERE userid IN ($userids)", 1);

			$result = $db->query("SELECT avatarid, avatarextension FROM bb".$n."_avatars WHERE userid IN ($userids)");
			while ($row = $db->fetch_array($result)) @unlink("./../images/avatars/avatar-$row[avatarid].$row[avatarextension]");
			$db->unbuffered_query("DELETE FROM bb".$n."_avatars WHERE userid IN ($userids)", 1);

			// delete pms sent by these users
			$pmids = '';
			$result = $db->query("SELECT privatemessageid FROM bb".$n."_privatemessage WHERE senderid IN ($userids)");
			while ($row = $db->fetch_array($result)) $pmids .= (($pmids != '') ? (',') : ('')) . $row['privatemessageid'];
			if ($pmids != '') {
				$result = $db->query("SELECT attachmentid, attachmentextension, thumbnailextension FROM bb".$n."_attachments WHERE privatemessageid IN ($pmids) AND postid = 0");
				while ($row = $db->fetch_array($result)) {
					@unlink("./../attachments/attachment-".$row['attachmentid'].".".$row['attachmentextension']);
					@unlink("./../attachments/thumbnail-".$row['attachmentid'].".".$row['thumbnailextension']);
				}
				$db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE privatemessageid IN ($pmids)", 1);
				$db->unbuffered_query("DELETE FROM bb".$n."_privatemessage WHERE privatemessageid IN ($pmids)", 1);
				$db->unbuffered_query("DELETE FROM bb".$n."_privatemessagereceipts WHERE privatemessageid IN ($pmids)", 1);
			}
			
			// delete pms sent to these users
			$db->unbuffered_query("UPDATE bb".$n."_privatemessagereceipts SET deletepm=0 WHERE recipientid IN ($userids)", 1);
			$pmids = '';
			$result = $db->query("SELECT privatemessageid FROM bb".$n."_privatemessagereceipts WHERE recipientid IN ($userids)");
			while ($row = $db->fetch_array($result)) $pmids .= ",$row[privatemessageid]";
			$deletepmids = '';
			$result = $db->query("SELECT ".
			"p.privatemessageid, p.inoutbox, COUNT(pmr.privatemessageid) as receipts ".
			"FROM bb".$n."_privatemessage p ".
			"LEFT OUTER JOIN bb".$n."_privatemessagereceipts pmr ON (pmr.privatemessageid=p.privatemessageid AND pmr.deletepm=0) ".
			"WHERE p.privatemessageid IN (0$pmids) ".
			"GROUP BY p.privatemessageid");
			while ($row = $db->fetch_array($result)) {
				if ($row['receipts'] == 0 && $row['inoutbox'] == 0) $deletepmids .= ",$row[privatemessageid]";
			}
			if ($deletepmids != '') {
				$deletepmids = wbb_substr($deletepmids, 1);
				$db->unbuffered_query("DELETE FROM bb".$n."_privatemessage WHERE privatemessageid IN (".$deletepmids.")", 1);
				$db->unbuffered_query("DELETE FROM bb".$n."_privatemessagereceipts WHERE privatemessageid IN (".$deletepmids.")", 1);
				// delete attachments as well
				$result = $db->query("SELECT attachmentid, attachmentextension, thumbnailextension FROM bb".$n."_attachments WHERE privatemessageid IN (".$deletepmids.") AND postid = 0");
				while ($row = $db->fetch_array($result)) {
					@unlink("./../attachments/attachment-".$row['attachmentid'].".".$row['attachmentextension']);
					@unlink("./../attachments/thumbnail-".$row['attachmentid'].".".$row['thumbnailextension']);
				}
				$db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE privatemessageid IN (".$deletepmids.")", 1);
			}


			$db->unbuffered_query("DELETE FROM bb".$n."_events WHERE userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_folders WHERE userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_moderators WHERE userid IN ($userids)", 1);
			$db->unbuffered_query("UPDATE bb".$n."_posts SET userid=0 WHERE userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_searchs WHERE userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_subscribeboards WHERE userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_subscribethreads WHERE userid IN ($userids)", 1);
			$db->unbuffered_query("UPDATE bb".$n."_threads SET starterid=0 WHERE starterid IN ($userids)", 1);
			$db->unbuffered_query("UPDATE bb".$n."_threads SET lastposterid=0 WHERE lastposterid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_userfields WHERE userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_users WHERE userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_votes WHERE userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_user2groups WHERE userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_votes WHERE id IN ($userids) AND votemode=3", 1);
   			$db->unbuffered_query("DELETE FROM bb".$n."_sessions WHERE userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_acpmenuitemgroupscount WHERE userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_acpmenuitemscount WHERE userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_applications WHERE userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_threadvisit WHERE userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_boardvisit WHERE userid IN ($userids)", 1);

 			$statupdate = $db->query_first("SELECT COUNT(*) AS usercount, MAX(userid) AS userid FROM bb".$n."_users");
			$db->unbuffered_query("UPDATE bb".$n."_stats SET usercount='".$statupdate['usercount']."', lastuserid='".$statupdate['userid']."'", 1);
		}
		header("Location: users.php?action=find&sid=$session[hash]");
		exit();
	}

	// check securitylevel
	$users = '';
	if ($wbbuserdata['a_override_max_securitylevel'] != -1) {
		$result = $db->query("SELECT u.userid,u.username,MAX(g.securitylevel) as securitylevel FROM bb".$n."_users u LEFT JOIN bb".$n."_user2groups u2g ON u.userid=u2g.userid LEFT JOIN bb".$n."_groups g ON u2g.groupid=g.groupid WHERE u.userid IN($userids) GROUP BY u.userid HAVING MAX(g.securitylevel)<='".$wbbuserdata['a_override_max_securitylevel']."'");
		if (!$db->num_rows($result)) acp_error($lang->get("LANG_ACP_USERS_ERROR_SELECTNOUSER"));
		$userids = '';
		while ($row = $db->fetch_array($result)) {
			$row['username'] = htmlconverter($row['username']);
			if ($users) $users .= ", ".makehreftag("../profile.php?userid=$row[userid]", $row['username'], "_blank");
			else $users = makehreftag("../profile.php?userid=$row[userid]", $row['username'], "_blank");
			if ($userids) $userids .= ",".$row['userid'];
			else $userids = $row['userid'];
		}
	}
	// no need to check the securitylevel
	else {
		$result = $db->query("SELECT userid, username FROM bb".$n."_users WHERE userid IN ($userids)");
		if (!$db->num_rows($result)) acp_error($lang->get("LANG_ACP_USERS_ERROR_SELECTNOUSER"));
		while ($row = $db->fetch_array($result)) {
			$row['username'] = htmlconverter($row['username']);
			if ($users) $users .= ", ".makehreftag("../profile.php?userid=$row[userid]", $row['username'], "_blank");
			else $users = makehreftag("../profile.php?userid=$row[userid]", $row['username'], "_blank");
		}
	}

	eval("\$tpl->output(\"".$tpl->get("users_delete", 1)."\",1);");
}



/* edit useraccess */
elseif ($action == "access") {
	checkAdminPermissions("a_can_users_access", 1);

	if (isset($_REQUEST['userids']) && $_REQUEST['userids'] != '') $userids = $_REQUEST['userids'];
	else {
		if (isset($_GET['userid'])) $userid = intval_array($_GET['userid']);
		elseif (isset($_POST['userid'])) $userid = intval_array($_POST['userid']);
		else $userid = array();
		$userids = implode(",", $userid);
	}

	if (!$userids) acp_error($lang->get("LANG_ACP_USERS_ERROR_SELECTNOUSER"));

	$boardids = '';
 	if (!checkAdminPermissions("a_can_boards_global")) {
  		$result = $db->query("SELECT boardid FROM bb".$n."_moderators WHERE userid='".$wbbuserdata['userid']."'");
  		while ($row = $db->fetch_array($result)) {
  			$boardids .= "," . $row['boardid'];
 			$modpermissions[$row['boardid']] = 1;
 		}
  		if ($boardids == '') access_error(1);
 	}

	if ($wbbuserdata['a_override_max_securitylevel'] != -1) $result = $db->query("SELECT u.userid,u.username FROM bb".$n."_users u LEFT JOIN bb".$n."_user2groups u2g USING(userid) LEFT JOIN bb".$n."_groups g USING(groupid) WHERE u.userid IN($userids) GROUP BY u.userid HAVING MAX(g.securitylevel)<='".$wbbuserdata['a_override_max_securitylevel']."'");
	else $result = $db->query("SELECT userid,username FROM bb".$n."_users WHERE userid IN($userids)");
	if (!$db->num_rows($result)) acp_error($lang->get("LANG_ACP_USERS_ERROR_SELECTNOUSER"));
	$users = '';
	$userids = array();
	while ($row = $db->fetch_array($result)) {
		$row['username'] = htmlconverter($row['username']);
		if ($users) $users .= ", ".makehreftag("../profile.php?userid=$row[userid]", $row['username'], "_blank");
		else $users = makehreftag("../profile.php?userid=$row[userid]", $row['username'], "_blank");
		$userids[] = $row['userid'];
	}

	if (isSet($_REQUEST['boardid'])) $boardid = intval($_REQUEST['boardid']);
	else $boardid = 0;

	if ($boardid && !checkAdminPermissions("a_can_boards_global") && !isset($modpermissions[$boardid]))  access_error(1);


	if (isSet($_POST['send']) && $boardid != 0) {
		$fields = '';
		$values = '';
		$useraccess = false;
		reset($_POST['permission']);
		while (list($key, $val) = each($_POST['permission'])) {
			$fields .= ",$key";
			$values .= ",'".intval($val)."'";
			if (intval($val) >= 0) $useraccess = true;
		}
		if ($useraccess) {
			foreach ($userids as $userid) $db->query("REPLACE INTO bb".$n."_access (boardid,userid".$fields.") VALUES ('$boardid','$userid'".$values.")");
			$db->unbuffered_query("UPDATE bb".$n."_users SET useuseraccess='1' WHERE userid IN(".implode(",", $userids).")");
		}
		else {
			$db->unbuffered_query("DELETE FROM bb".$n."_access WHERE boardid='$boardid' AND userid IN(".implode(",", $userids).")");

			$goodusers = '';
			$result = $db->query("SELECT DISTINCT userid FROM bb".$n."_access WHERE userid IN(".implode(",", $userids).")");
			while ($row = $db->fetch_array($result)) $goodusers .= ",".$row['userid'];

			$db->unbuffered_query("UPDATE bb".$n."_users SET useuseraccess='0' WHERE userid IN(".implode(",", $userids).") AND userid NOT IN (0".$goodusers.")");

		}
		header("Location: users.php?action=find&sid=$session[hash]");
		exit();
	}


	$result = $db->query("SELECT boardid, parentid, boardorder, title FROM bb".$n."_boards ORDER by parentid ASC, boardorder ASC");
	while ($row = $db->fetch_array($result)) {
		$row['title'] = getlangvar($row['title'], $lang);
		$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
	}
	$board_options = makeboardoptions(0, 1, 1, $boardid);

	$userids = implode(",", $userids);
	$permissionbit = '';
	if ($boardid) {
		$lang->load("ACP_GROUP");

		// read in permissions
		$permissions = array();
		$result = $db->query("SHOW FIELDS FROM bb".$n."_access");
		while ($row = $db->fetch_array($result)) {
			if ($row['Field'] == "userid" || $row['Field'] == "boardid") continue;
			else $permissions[] = $row['Field'];
		}

		// read in user access
		$result = $db->query("SELECT * FROM bb".$n."_access WHERE boardid='$boardid' AND userid IN ($userids)");
		if ($db->num_rows($result) == wbb_substr_count($userids, ",") + 1) {
			$allsame = true;
			while ($row = $db->fetch_array($result)) {
				reset($permissions);
				if (!isset($tmp)) $tmp = $row;
				foreach ($permissions as $permission) if ($row[$permission] != $tmp[$permission]) $allsame = false;
			}
		}
		else $allsame = false;


		$selected = array();
		reset($permissions);
		if ($allsame) foreach ($permissions as $permission) $selected[$permission][(($tmp[$permission] == 0 || $tmp[$permission] == 1) ? ($tmp[$permission]) : ((($tmp[$permission] == -1) ? (2) : (""))))] = " selected=\"selected\"";
		else foreach ($permissions as $permission) $selected[$permission][2] = " selected=\"selected\"";

		$count = 1;
		reset($permissions);
		foreach ($permissions as $permission) {
			$rowclass = getone($count, "firstrow", "secondrow");
			$permission_name = $lang->get("LANG_ACP_GROUP_VAR_".wbb_strtoupper($permission));
			eval("\$permissionbit .= \"".$tpl->get("users_access_permissionbit", 1)."\";");
			$count++;
		}
	}

	eval("\$tpl->output(\"".$tpl->get("users_access", 1)."\",1);");
}




/* edit user */
elseif ($action == "edit") {
	checkAdminPermissions("a_can_users_edit", 1);

	if (isSet($_GET['userid'])) $userid = intval($_GET['userid']);
	elseif (isSet($_POST['userid'])) $userid = intval($_POST['userid']);
	else $userid = 0;

	if ($wbbuserdata['a_override_max_securitylevel'] != -1) {
		$user = $db->query_first("SELECT u.*,uf.*, MAX(securitylevel) as securitylevel FROM bb".$n."_users u LEFT JOIN bb".$n."_user2groups u2g ON u2g.userid=u.userid LEFT JOIN bb".$n."_groups g ON g.groupid=u2g.groupid LEFT JOIN bb".$n."_groupvalues vl ON vl.groupid=u2g.groupid LEFT JOIN bb".$n."_groupvariables var ON var.variableid=vl.variableid LEFT JOIN bb".$n."_userfields uf ON uf.userid=u.userid WHERE u.userid='$userid' GROUP BY u.userid");
		checkSecurityLevel($user['securitylevel'], 1);
	}
	else $user = getwbbuserdata($userid);

	if (!$user['userid']) acp_error($lang->get("LANG_ACP_USERS_ERROR_SELECTNOUSER"));
	$groupresult = $db->query("SELECT groupid FROM bb".$n."_user2groups WHERE userid='$userid'");
	while ($row = $db->fetch_array($groupresult)) $user['groupids'][] = $row['groupid'];

	// form has been sent
	if (isSet($_POST['send'])) {
		// most important data
		if (isSet($_POST['username'])) $username = $_POST['username'];
		else $username = '';
		if (isSet($_POST['email'])) $email = $_POST['email'];
		else $email = '';
		if (isSet($_POST['groupids']) && is_array($_POST['groupids'])) $groupids = intval_array($_POST['groupids']);
		else $groupids = array();
		$username = preg_replace("/\s{2,}/", " ", $username);

		// other data
		if (isSet($_POST['field'])) $field = $_POST['field'];
		else $field = array();
		if (isSet($_POST['field'])) $dayfield = $_POST['dayfield'];
		else $dayfield = array();
		if (isSet($_POST['field'])) $monthfield = $_POST['monthfield'];
		else $monthfield = array();
		if (isSet($_POST['field'])) $yearfield = $_POST['yearfield'];
		else $yearfield = array();

		// signature options
		if (isSet($_POST['disablesmilies'])) $disablesmilies = $_POST['disablesmilies'];
		else $disablesmilies = 0;
		if (isSet($_POST['disablehtml'])) $disablehtml = $_POST['disablehtml'];
		else $disablehtml = 0;
		if (isSet($_POST['disablebbcode'])) $disablebbcode = $_POST['disablebbcode'];
		else $disablebbcode = 0;
		if (isSet($_POST['disableimages'])) $disableimages = $_POST['disableimages'];
		else $disableimages = 0;


		if (isSet($_POST['title'])) $title = $_POST['title'];
		else $title = '';
		if (isSet($_POST['homepage'])) $homepage = $_POST['homepage'];
		else $homepage = '';
		if (isSet($_POST['icq'])) $icq = intval(str_replace("-", "", wbb_trim($_POST['icq'])));
		else $icq = '';
		if (isSet($_POST['aim'])) $aim = $_POST['aim'];
		else $aim = '';
		if (isSet($_POST['msn'])) $msn = $_POST['msn'];
		else $msn = '';
		if (isSet($_POST['yim'])) $yim = $_POST['yim'];
		else $yim = '';
		if (isSet($_POST['day'])) $day = intval($_POST['day']);
		else $day = '';
		if (isSet($_POST['month'])) $month = intval($_POST['month']);
		else $month = '';
		if (isSet($_POST['year'])) $year = intval($_POST['year']);
		else $year = '';
		if (isSet($_POST['gender'])) $gender = intval($_POST['gender']);
		else $gender = 0;
		if (isSet($_POST['usertext'])) $usertext = $_POST['usertext'];
		else $usertext = '';
		if (isSet($_POST['signature'])) $signature = $_POST['signature'];
		else $signature = '';
		if (isSet($_POST['rankgroupid'])) $rankgroupid = intval($_POST['rankgroupid']);
		else $rankgroupid = 0;
		if (isSet($_POST['useronlinegroupid'])) $useronlinegroupid = intval($_POST['useronlinegroupid']);
		else $useronlinegroupid = 0;
		if (isSet($_POST['blocked'])) $blocked = intval($_POST['blocked']);
		else $blocked = 0;
		if (isSet($_POST['disablesignature'])) $disablesignature = intval($_POST['disablesignature']);
		else $disablesignature = 0;

		if (isSet($_POST['invisible'])) $invisible = intval($_POST['invisible']);
		else $invisible = $default_register_invisible;
		if (isSet($_POST['usecookies'])) $usecookies = intval($_POST['usecookies']);
		else $usecookies = $default_register_usecookies;
		if (isSet($_POST['admincanemail'])) $admincanemail = intval($_POST['admincanemail']);
		else $admincanemail = $default_register_admincanemail;
		if (isSet($_POST['showemail'])) $showemail = intval($_POST['showemail']);
		else $showemail = 1 - $default_register_showemail;
		if (isSet($_POST['usercanemail'])) $usercanemail = intval($_POST['usercanemail']);
		else $usercanemail = $default_register_usercanemail;
		if (isSet($_POST['emailnotify'])) $emailnotify = intval($_POST['emailnotify']);
		else $emailnotify = $default_register_emailnotify;
		if (isSet($_POST['receivepm'])) $receivepm = intval($_POST['receivepm']);
		else $receivepm = $default_register_receivepm;
		if (isSet($_POST['emailonpm'])) $emailonpm = intval($_POST['emailonpm']);
		else $emailonpm = $default_register_emailonpm;
		if (isSet($_POST['pmpopup'])) $pmpopup = intval($_POST['pmpopup']);
		else $pmpopup = $default_register_pmpopup;
		if (isSet($_POST['emailonapplication'])) $emailonapplication = intval($_POST['emailonapplication']);
		else $emailonapplication = 0;
		if (isSet($_POST['showsignatures'])) $showsignatures = intval($_POST['showsignatures']);
		else $showsignatures = $default_register_showsignatures;
		if (isSet($_POST['showavatars'])) $showavatars = intval($_POST['showavatars']);
		else $showavatars = $default_register_showavatars;
		if (isSet($_POST['showimages'])) $showimages = intval($_POST['showimages']);
		else $showimages = $default_register_showimages;
		if (isSet($_POST['threadview'])) $threadview = intval($_POST['threadview']);
		else $threadview = $default_register_threadview;
		if (isSet($_POST['timezoneoffset'])) $timezoneoffset = (float)($_POST['timezoneoffset']);
		else $timezoneoffset = $default_timezoneoffset;
		if (isSet($_POST['startweek'])) $startweek = intval($_POST['startweek']);
		else $startweek = $default_startweek;
		if (isSet($_POST['udateformat'])) $udateformat = $_POST['udateformat'];
		else $udateformat = $default_dateformat;
		if (isSet($_POST['utimeformat'])) $utimeformat = $_POST['utimeformat'];
		else $utimeformat = $default_timeformat;

		if (isSet($_POST['styleid'])) $styleid = intval($_POST['styleid']);
		else $styleid = 0;
		if (isSet($_POST['langid'])) $langid = intval($_POST['langid']);
		else $langid = 0;
		if (isSet($_POST['avatarid'])) $avatarid = intval($_POST['avatarid']);
		else $avatarid = 0;
		if (isSet($_POST['usewysiwyg'])) $usewysiwyg = intval($_POST['usewysiwyg']);
		else $usewysiwyg = 0;
		
		if (isSet($_POST['notificationperpm'])) $notificationperpm = intval($_POST['notificationperpm']);
		else $notificationperpm = 0;

		// check securitylevel
		if (!checkSecurityLevel($user['securitylevel'])) {
			$groupids = $user['groupids'];
			$blocked = $user['blocked'];
			$disablesignature = $user['disablesignature'];
		}
		else {
			if (count($groupids)) {
				$result = $db->query("SELECT groupid,securitylevel FROM bb".$n."_groups WHERE groupid IN (".implode(",", $groupids).")");
				while ($row = $db->fetch_array($result)) {
					if (!checkSecurityLevel($row['securitylevel'])) unset($groupids[array_search($row['groupid'], $groupids)]);
				}
			}
		}

		
		$error = '';
		if (!$username || !$email || !count($groupids)) $error .= $lang->items['LANG_POSTINGS_ERROR1'];
		if (wbb_strtolower($username) != wbb_strtolower($user['username']) && !verify_username($username)) $error .= $lang->items['LANG_REGISTER_ERROR2'];
		if ($email != $user['email'] && !verify_email($email)) $error .= $lang->items['LANG_REGISTER_ERROR3'];
		
		if ($error) $error = acp_error_frame($lang->get("LANG_ACP_USERS_ADD_ERROR", array('$error' => $error)));
		else {
			if ($homepage && !preg_match("/[a-zA-Z]:\/\//si", $homepage)) $homepage = "http://".$homepage;
			if ($day && $month) $birthday = ((wbb_strlen($year) == 4) ? ($year) : (((wbb_strlen($year) == 2) ? ("19$year") : ("0000"))))."-".(($month < 10) ? ("0$month") : ($month))."-".(($day < 10) ? ("0$day") : ($day));
			else $birthday = "0000-00-00";

			// change username
			if ($username != $user['username']) {
				$db->unbuffered_query("UPDATE bb".$n."_boards SET lastposter='".addslashes($username)."' WHERE lastposterid='$userid'", 1);
				$db->unbuffered_query("UPDATE bb".$n."_posts SET username='".addslashes($username)."' WHERE userid='$userid'", 1);
				$db->unbuffered_query("UPDATE bb".$n."_posts SET editor='".addslashes($username)."' WHERE editorid='$userid'", 1);
				$db->unbuffered_query("UPDATE bb".$n."_threads SET starter='".addslashes($username)."' WHERE starterid='$userid'", 1);
				$db->unbuffered_query("UPDATE bb".$n."_threads SET lastposter='".addslashes($username)."' WHERE lastposterid='$userid'", 1);
			}

			// avatar changed
			if ($user['avatarid'] && $user['avatarid'] != $avatarid) {
				$avatar = $db->query_first("SELECT * FROM bb".$n."_avatars WHERE avatarid='$user[avatarid]'");
				if ($avatar['userid'] == $userid) {
					@unlink("../images/avatars/avatar-$avatar[avatarid].$avatar[avatarextension]");
					$db->unbuffered_query("DELETE FROM bb".$n."_avatars WHERE avatarid='$avatar[avatarid]'", 1);
				}
			}

			$db->unbuffered_query("DELETE FROM bb".$n."_user2groups WHERE userid='$userid'");

			// delete old applications
			$delete_str = '';
			for ($i = 0; $i < count($user['groupids']); $i++) if (!in_array($user['groupids'][$i], $groupids)) $delete_str .= ",'".$user['groupids'][$i]."'";
			if ($delete_str) $db->unbuffered_query("DELETE FROM bb".$n."_applications WHERE userid='$userid' AND groupid IN (".wbb_substr($delete_str, 1).")");
			$delete_str = '';


			if ($user['activation'] != 1) {
				list($non_activation_groupid) = $db->query_first("SELECT groupid FROM bb".$n."_groups WHERE grouptype='2'");
				$groupids[] = $non_activation_groupid;
			}

			// block user
			if ($blocked == 1) {
				$admincanemail = 0;
				$showemail = 0;
				$usercanemail = 0;
				$receivepm = 0;
				if ($user['blocked'] == 0) {
					$db->unbuffered_query("DELETE FROM bb".$n."_subscribeboards WHERE userid='$userid'", 1);
					$db->unbuffered_query("DELETE FROM bb".$n."_subscribethreads WHERE userid='$userid'", 1);
				}
				list($blockedgroupid) = $db->query_first("SELECT groupid FROM bb".$n."_groups WHERE grouptype='3'");
				$groupids[] = $blockedgroupid;
			}
			// "unblock" user
			elseif ($blocked == 0 && $user['blocked'] == 1) {
				list($blockedgroupid) = $db->query_first("SELECT groupid FROM bb".$n."_groups WHERE grouptype='3'");
				if (in_array($blockedgroupid, $groupids)) unset($groupids[array_search($blockedgroupid, $groupids)]);
			}

			// rank verify
			if (!in_array($rankgroupid, $groupids)) $rankgroupid = $groupids[0];
			if (!in_array($useronlinegroupid, $groupids)) $useronlinegroupid = $groupids[0];
			$rankid = $db->query_first("SELECT rankid FROM bb".$n."_ranks WHERE groupid IN (0,'$rankgroupid') AND needposts <= '$user[userposts]' AND gender IN (0,'$gender') ORDER BY needposts DESC, gender DESC", 1);

			// profilefields
			$fieldvalues = '';
			$result = $db->query("SELECT profilefieldid, required, fieldtype FROM bb".$n."_profilefields ORDER BY profilefieldid ASC");
			while ($row = $db->fetch_array($result)) {
				if ($row['fieldtype'] == "multiselect") {
					if (is_array($field[$row['profilefieldid']])) {
						if ($fieldvalues) $fieldvalues .= ",field$row[profilefieldid] = '".addslashes(trim(implode("\n", $field[$row['profilefieldid']])))."'";
						else $fieldvalues .= "field$row[profilefieldid] = '".addslashes(trim(implode("\n", $field[$row['profilefieldid']])))."'";
					}
					else {
						if ($fieldvalues) $fieldvalues .= ",field$row[profilefieldid] = ''";
						else $fieldvalues .= "field$row[profilefieldid] = ''";
					}
				}
				elseif ($row['fieldtype'] == "date") {
					if ($dayfield[$row['profilefieldid']] && $monthfield[$row['profilefieldid']]) $datefield = ((wbb_strlen($yearfield[$row['profilefieldid']]) == 4) ? ($yearfield[$row['profilefieldid']]) : (((wbb_strlen($yearfield[$row['profilefieldid']]) == 2) ? ("19".$yearfield[$row['profilefieldid']]) : ("0000"))))."-".(($monthfield[$row['profilefieldid']] < 10) ? ("0".$monthfield[$row['profilefieldid']]) : ($monthfield[$row['profilefieldid']]))."-".(($dayfield[$row['profilefieldid']] < 10) ? ("0".$dayfield[$row['profilefieldid']]) : ($dayfield[$row['profilefieldid']]));
					else $datefield = "0000-00-00";
					if ($fieldvalues) $fieldvalues .= ",field$row[profilefieldid]='".$datefield."'";
					else $fieldvalues .= "field$row[profilefieldid]='".$datefield."'";
				}
				else {
					if ($fieldvalues) $fieldvalues .= ",field$row[profilefieldid]='".addslashes($field[$row['profilefieldid']])."'";
					else $fieldvalues .= "field$row[profilefieldid]='".addslashes($field[$row['profilefieldid']])."'";
				}
			}


			// insert usergroups
			$groupids = array_unique($groupids);
			reset($groupids);
			foreach ($groupids as $groupid) {
				$db->unbuffered_query("INSERT IGNORE INTO bb".$n."_user2groups (userid,groupid) VALUES ('$userid','$groupid')");
			}

			sort($groupids);

			$groupcombinationid = cachegroupcombinationdata(implode(",", $groupids), 0);
			$groupcombination = $db->query_first("SELECT data FROM bb".$n."_groupcombinations WHERE groupcombinationid='".$groupcombinationid."'");
			$groupcombinationdata = unserialize($groupcombination['data']);

			/* signature feature rights:start */
  			if (!$groupcombinationdata['can_use_sig_smilies'] || $disablesmilies == 1) $allowsmilies = 0;
  			else $allowsmilies = 1;

  			if (!$groupcombinationdata['can_use_sig_html'] || $disablehtml == 1) $allowhtml = 0;
  			else $allowhtml = 1;

  			if (!$groupcombinationdata['can_use_sig_bbcode'] || $disablebbcode == 1) $allowbbcode = 0;
  			else $allowbbcode = 1;

  			if (!$groupcombinationdata['can_use_sig_images'] || $disableimages == 1) $allowimages = 0;
  			else $allowimages = 1;
  			/* signature feature rights:end */


			// update user
			$db->unbuffered_query("UPDATE bb".$n."_users SET username='".addslashes($username)."',email='".addslashes($email)."',groupcombinationid='".$groupcombinationid."',rankid='".$rankid['rankid']."',title='".addslashes($title)."',usertext='".addslashes($usertext)."',signature='".addslashes($signature)."',disablesignature='".intval($disablesignature)."',icq='".intval($icq)."',aim='".addslashes($aim)."',yim='".addslashes($yim)."',msn='".addslashes($msn)."',homepage='".addslashes($homepage)."',birthday='".addslashes($birthday)."',gender='".intval($gender)."',showemail='".intval($showemail)."',admincanemail='".intval($admincanemail)."',usercanemail='".intval($usercanemail)."',invisible='".intval($invisible)."',usecookies='".intval($usecookies)."',styleid='".intval($styleid)."',daysprune='".intval($daysprune)."',timezoneoffset='".addslashes($timezoneoffset)."',startweek='".intval($startweek)."',dateformat='".addslashes($udateformat)."',timeformat='".addslashes($utimeformat)."',emailnotify='".intval($emailnotify)."',notificationperpm='".intval($notificationperpm)."',receivepm='".intval($receivepm)."',emailonpm='".intval($emailonpm)."',pmpopup='".intval($pmpopup)."',emailonapplication='".intval($emailonapplication)."',umaxposts='".intval($umaxposts)."',showsignatures='".intval($showsignatures)."',showavatars='".intval($showavatars)."',showimages='".intval($showimages)."', blocked='".intval($blocked)."', avatarid = '".intval($avatarid)."', threadview='".intval($threadview)."', rankgroupid='".intval($rankgroupid)."', useronlinegroupid='".intval($useronlinegroupid)."', allowsigsmilies='".$allowsmilies."', allowsightml='".$allowhtml."', allowsigbbcode='".$allowbbcode."', allowsigimages='".$allowimages."', langid='".intval($langid)."', usewysiwyg = '".$usewysiwyg."' WHERE userid='$userid'", 1);
			if ($fieldvalues) $db->unbuffered_query("UPDATE bb".$n."_userfields SET $fieldvalues WHERE userid='$userid'", 1);

			header("Location: users.php?action=find&sid=$session[hash]");
			exit;
		}
	}
	else {
		$username = $user['username'];
		$email = $user['email'];


		$title = $user['title'];
		$homepage = $user['homepage'];
		$icq = $user['icq'];
		$aim = $user['aim'];
		$msn = $user['msn'];
		$yim = $user['yim'];
		$groupids = $user['groupids'];
		$year = wbb_substr($user['birthday'], 0, 4);
		$month = wbb_substr($user['birthday'], 5, 2);
		$day = wbb_substr($user['birthday'], 8, 2);
		$gender = $user['gender'];
		$usertext = $user['usertext'];
		$signature = $user['signature'];
		$disablesignature = $user['disablesignature'];
		$blocked = $user['blocked'];
		$langid = $user['langid'];
		$styleid = $user['styleid'];
		$avatarid = $user['avatarid'];
		$rankgroupid = $user['rankgroupid'];
		$useronlinegroupid = $user['useronlinegroupid'];

		$dayfield = array();
		$monthfield = array();
		$yearfield = array();
		$field = array();

		// predefined values
		$invisible = $user['invisible'];
		$usecookies = $user['usecookies'];
		$admincanemail = $user['admincanemail'];
		$showemail = $user['showemail'];
		$showemail = $user['showemail'];
		$usercanemail = $user['usercanemail'];
		$emailnotify = $user['emailnotify'];
		$receivepm = $user['receivepm'];
		$emailonpm = $user['emailonpm'];
		$pmpopup = $user['pmpopup'];
		$emailonapplication = $user['emailonapplication'];
		$showsignatures = $user['showsignatures'];
		$showavatars = $user['showavatars'];
		$showimages = $user['showimages'];
		$threadview = $user['threadview'];
		$timezoneoffset = $user['timezoneoffset'];
		$startweek = $user['startweek'];
		$udateformat = $user['dateformat'];
		$utimeformat = $user['timeformat'];

		$daysprune = $user['daysprune'];
		$umaxposts = $user['umaxposts'];
		$usewysiwyg = $user['usewysiwyg'];
		$notificationperpm = $user['notificationperpm'];


		// signature options
		$disablesmilies = 1 - $user['allowsigsmilies'];
		$disablehtml = 1 - $user['allowsightml'];
		$disablebbcode = 1 - $user['allowsigbbcode'];
		$disableimages = 1 - $user['allowsigimages'];
	}





	/* convert html characters */
	$username = htmlconverter($username);
	$password = '';
	$email = htmlconverter($email);
	$title = htmlconverter($title);
	$usertext = htmlconverter($usertext);
	$signature = htmlconverter($signature);
	$homepage = htmlconverter($homepage);
	$aim = htmlconverter($aim);
	$msn = htmlconverter($msn);
	$yim = htmlconverter($yim);
	if ($icq == "0") $icq = '';

	/* birthday options */
	$day_options = '';
	$month_options = '';
	if ($year == "0000") $year = '';
	for ($i = 1; $i <= 31; $i++) $day_options .= makeoption($i, $i, $day, 1);
	for ($i = 1; $i <= 12; $i++) $month_options .= makeoption($i, getmonth($i), $month, 1);

	/* group options */
	$group_options = '';
	$rankgroup_options = '';
	$useronlinegroup_options = '';
	$result = $db->query("SELECT groupid,title,grouptype,securitylevel FROM bb".$n."_groups ORDER BY grouptype DESC, title ASC");
	while ($row = $db->fetch_array($result)) {
		$row['title'] = getlangvar($row['title'], $lang);

		if ($row['grouptype'] > 3 && checkSecurityLevel($row['securitylevel'])) $group_options .= makeoption($row['groupid'], $row['title'], ((in_array($row['groupid'], $groupids)) ? ($row['groupid']) : ("")));
		if (in_array($row['groupid'], $groupids)) {
			$useronlinegroup_options .= makeoption($row['groupid'], $row['title'], $useronlinegroupid);
			$rankresult = $db->query_first("SELECT * FROM bb".$n."_ranks WHERE groupid IN ('0','$row[groupid]') AND needposts<='$user[userposts]' ORDER BY needposts DESC, gender DESC", 1);
			if ($rankresult['rankid']) {
				$rankgroup_options .= makeoption($row['groupid'], getlangvar($rankresult['ranktitle'], $lang)." (".$row['title'].")", $rankgroupid);
			}
		}
	}

	/* timezones */
	$timezone_options = '';
	$timezones = explode("\n", $lang->items['LANG_REGISTER_TIMEZONES']);
	for ($i = 0; $i < count($timezones); $i++) {
		$parts = explode("|", trim($timezones[$i]));
		$timezone_options .= makeoption($parts[0], "(GMT".(($parts[1]) ? (" ".$parts[1]) : ("")).") $parts[2]", $timezoneoffset);
	}
	/* startweek options */
	$startweek_options = '';
	for ($i = 0; $i < 7; $i++) $startweek_options .= makeoption($i, getday($i), $startweek);

	/* profilefields */
	$y = 1;
	$result = $db->query("SELECT * FROM bb".$n."_profilefields ORDER BY fieldorder ASC");
	while ($row = $db->fetch_array($result)) {
		$field_value = '';
		$field_checked = '';
		$dayfield_value = '';
		$monthfield_value = '';
		$yearfield_value = '';
		$row_options = array();
		$selected_options = array();

		$current_field = ((isset($_POST['send'])) ? ($field[$row['profilefieldid']]) : ($user["field".$row['profilefieldid']]));

		switch ($row['fieldtype']) {
			case "text":
				$field_value = htmlconverter($current_field);
			break;

			case "select":
				$row_options = explode("\n", trim($row['fieldoptions']));
				$field_value = "<option value=\"\">".$lang->get("LANG_ACP_GLOBAL_PLEASE_SELECT")."</option>\n";
				foreach ($row_options as $option) $field_value .= makeoption(htmlconverter(trim($option)), htmlconverter(trim($option)), htmlconverter(trim($current_field)));
			break;

			case "multiselect":
				$row_options = explode("\n", $row['fieldoptions']);
				if (isset($_POST['send']) && is_array($field[$row['profilefieldid']]) && count($field[$row['profilefieldid']])) $selected_options = $field[$row['profilefieldid']];
				else $selected_options = explode("\n", $user['field'.$row['profilefieldid']]);
				foreach ($row_options as $option) $field_value .= makeoption(htmlconverter(trim($option)), htmlconverter(trim($option)), ((in_array(trim($option), $selected_options)) ? (htmlconverter(trim($option))) : ("")));
			break;

			case "checkbox":
				$field_value = htmlconverter($row['fieldoptions']);
				$field_checked = (($row['fieldoptions'] == $current_field) ? (" checked=\"checked\"") : (""));
			break;

			case "date":
				$dayfield_value = "<option value=\"\"></option>\n";
				$monthfield_value = "<option value=\"\"></option>\n";

				if (isset($_POST['send'])) {
					$year_tmp = $yearfield[$row['profilefieldid']];
					$month_tmp = $monthfield[$row['profilefieldid']];
					$day_tmp = $dayfield[$row['profilefieldid']];
				}
				else list($year_tmp, $month_tmp, $day_tmp) = explode("-", $user["field".$row['profilefieldid']]);
				for ($i = 1; $i <= 31; $i++) $dayfield_value .= makeoption($i, $i, $day_tmp);
				for ($i = 1; $i <= 12; $i++) $monthfield_value .= makeoption($i, getmonth($i), $month_tmp);
				if (intval($year_tmp)) $yearfield_value = $year_tmp;
				else $yearfield_value = '';
			break;
		}

		$row['title'] = getlangvar($row['title'], $lang);
		$row['description'] = getlangvar($row['description'], $lang);
		$rowclass = getone($y, "secondrow", "firstrow");
		eval("\$userfields .= \"".$tpl->get("users_add_userfield_".$row['fieldtype'], 1)."\";");
		$y++;
	}

	/* styles */
	$style_options = '';
	$result = $db->query("SELECT styleid, stylename FROM bb".$n."_styles ORDER BY stylename ASC");
	while ($row = $db->fetch_array($result)) $style_options .= makeoption($row['styleid'], getlangvar($row['stylename'], $lang), $styleid);

	/* language packs */
	$lang_options = '';
	$result = $db->query("SELECT languagepackid, languagepackname FROM bb".$n."_languagepacks ORDER BY languagepackname ASC");
	while ($row = $db->fetch_array($result)) $lang_options .= makeoption($row['languagepackid'], getlangvar($row['languagepackname'], $lang), $langid);

	/* avatars */
	$avatar_options = '';
	$color = "red";
	$result = $db->query("SELECT * FROM bb".$n."_avatars WHERE (userid = 0 AND groupid IN (0,".implode(",", $user['groupids']).") AND needposts <= '$user[userposts]') OR userid = '$userid' ORDER BY userid DESC");
	while ($row = $db->fetch_array($result)) {
		if ($color == "red" && $row['userid'] == 0) {
			$avatar_options .= makeoption(0, "---------------", "", 0);
			$color = "green";
		}
		$avatar_options .= makeoption($row['avatarid'], htmlconverter($row['avatarname'].".".$row['avatarextension']), $avatarid, 1, $color);
	}

	/* ratingcount */
	$ratingcount = $user['ratingcount'];
	if ($ratingcount != 0) $ratingpoints = $user['ratingpoints'] / $ratingcount;
	else $ratingpoints = 0;

	$ratingpoints = number_format($ratingpoints, 2, $lang->get("LANG_GLOBAL_DEC_POINT"), $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));


	/* selectboxes */
	$sel_gender[$gender] = " selected=\"selected\"";
	$sel_invisible[$invisible] = " selected=\"selected\"";
	$sel_usecookies[$usecookies] = " selected=\"selected\"";
	$sel_admincanemail[$admincanemail] = " selected=\"selected\"";
	$sel_showemail[$showemail] = " selected=\"selected\"";
	$sel_usercanemail[$usercanemail] = " selected=\"selected\"";
	$sel_emailnotify[$emailnotify] = " selected=\"selected\"";
	$sel_notificationperpm[$notificationperpm] = " selected=\"selected\"";
	$sel_receivepm[$receivepm] = " selected=\"selected\"";
	$sel_emailonpm[$emailonpm] = " selected=\"selected\"";
	$sel_pmpopup[$pmpopup] = " selected=\"selected\"";
	$sel_showsignatures[$showsignatures] = " selected=\"selected\"";
	$sel_showavatars[$showavatars] = " selected=\"selected\"";
	$sel_showimages[$showimages] = " selected=\"selected\"";
	$sel_daysprune[$daysprune] = " selected=\"selected\"";
	$sel_umaxposts[$umaxposts] = " selected=\"selected\"";
	$sel_threadview[$threadview] = " selected=\"selected\"";
	$sel_blocked[$blocked] = " selected=\"selected\"";
	$sel_disablesignature[$disablesignature] = " selected=\"selected\"";
	$sel_emailonapplication[$emailonapplication] = " selected=\"selected\"";
	$sel_usewysiwyg[$usewysiwyg] = " selected=\"selected\"";

	if ($disablesmilies == 1) $checked[0] = "checked=\"checked\"";
	else $checked[0] = '';
	if ($disablehtml == 1) $checked[1] = "checked=\"checked\"";
	else $checked[1] = '';
	if ($disablebbcode == 1) $checked[2] = "checked=\"checked\"";
	else $checked[2] = '';
	if ($disableimages == 1) $checked[3] = "checked=\"checked\"";
	else $checked[3] = '';

	$lang->items['LANG_ACP_USERS_EDIT_RATING_INFO'] = $lang->get("LANG_ACP_USERS_EDIT_RATING_INFO", array('$ratingpoints' => $ratingpoints, '$ratingcount' => $ratingcount));
	$lang->items['LANG_ACP_USERS_EDIT_TITLE'] = $lang->get("LANG_ACP_USERS_EDIT_TITLE", array('$username' => $username));
	eval("\$tpl->output(\"".$tpl->get("users_edit", 1)."\",1);");
}




/** send email */
elseif ($action == "email") {
	// check permissions
	checkAdminPermissions("a_can_users_email", 1);
	$lang->load("ACP_OTHERSTUFF");
	
	
	if (isset($_POST['send'])) {
		if (isset($_POST['groupid'])) $groupid = intval($_POST['groupid']);
		else $groupid = '';
		if (isset($_POST['userids'])) $userids = wbb_trim($_POST['userids']);
		else $userids = '';
		if (isset($_POST['subject'])) $subject = wbb_trim($_POST['subject']);
		else $subject = '';
		if (isset($_POST['message'])) $message = dos2unix(wbb_trim($_POST['message']));
		else $message = '';
		if (isset($_POST['emailtype'])) $emailtype = wbb_trim($_POST['emailtype']);
		else $emailtype = 'text';
		if ($emailtype == 'html') $otherheaders = "\nMIME-Version: 1.0\nContent-type: text/html; charset=iso-8859-1";
		else $otherheaders = "";
		
	 	if ($groupid) list($totalcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_user2groups u2g LEFT JOIN bb".$n."_users u USING(userid) WHERE u2g.groupid = '".$groupid."' AND u.admincanemail = 1");
	 	elseif ($userids == 'all') list($totalcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_users WHERE admincanemail = 1");
	 	else list($totalcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_users WHERE userid IN ($userids) AND admincanemail = 1");
		
		$db->query("INSERT INTO bb".$n."_mails (subject, message, otherheaders, userid, sendtime, recipients) VALUES ('".addslashes($subject)."', '".addslashes($message)."', '".addslashes($otherheaders)."', '$wbbuserdata[userid]', '".time()."', '$totalcount')");
		$mailid = $db->insert_id();
		
  		if ($groupid) $db->unbuffered_query("INSERT INTO bb".$n."_mailqueue (mailid, userid, email, username) SELECT '$mailid' as mailid, u.userid, u.email, u.username FROM bb".$n."_user2groups u2g LEFT JOIN bb".$n."_users u USING(userid) WHERE u2g.groupid = '".$groupid."' AND admincanemail = 1");
  		elseif ($userids == "all") $db->unbuffered_query("INSERT INTO bb".$n."_mailqueue (mailid, userid, email, username) SELECT '$mailid' as mailid, userid, email, username FROM bb".$n."_users WHERE admincanemail = 1");
  		else $db->unbuffered_query("INSERT INTO bb".$n."_mailqueue (mailid, userid, email, username) SELECT '$mailid' as mailid, userid, email, username FROM bb".$n."_users WHERE userid IN ($userids) AND admincanemail = 1");
		
		// output javascript to start sending.
		eval("\$tpl->output(\"".$tpl->get("working_loademail", 1)."\",1);");
		exit();
	}
	
	if (isset($_GET['userid']) && is_array($_GET['userid']) && count($_GET['userid'])) $userids = implode(',', $_GET['userid']);
	elseif (isset($_POST['userid']) && is_array($_POST['userid']) && count($_POST['userid'])) $userids = implode(',', $_POST['userid']);
	elseif (isset($_GET['userid']) && $_GET['userid'] == "all") $userids = "all";
	else acp_error($lang->get("LANG_ACP_USERS_ERROR_SELECTNOUSER"));
	
	if ($userids != "all") {
		$users = '';
		$result = $db->query("SELECT userid, username FROM bb".$n."_users WHERE userid IN ($userids)");
		if (!$db->num_rows($result)) acp_error($lang->get("LANG_ACP_USERS_ERROR_SELECTNOUSER"));
		while ($row = $db->fetch_array($result)) {
			$row['username'] = htmlconverter($row['username']);
			if ($users) $users .= ", ".makehreftag("../profile.php?userid=$row[userid]", $row['username'], "_blank");
			else $users = makehreftag("../profile.php?userid=$row[userid]", $row['username'], "_blank");
		}
	}
	else $users = $lang->get("LANG_ACP_USERS_EMAIL_ALL_USERS");
	
	eval("\$tpl->output(\"".$tpl->get("users_email", 1)."\",1);");
}



/** send email */
elseif ($action == "emailsend") acp_message($lang->get("LANG_ACP_USERS_EMAIL_SEND"));



/** activate useraccounts */
elseif ($action == "activate") {
	
	// check permissions
	checkAdminPermissions("a_can_users_activation", 1);
	
	if (isset($_REQUEST['userids']) && $_REQUEST['userids'] != '') $userids = $_REQUEST['userids'];
	else {
		if (isset($_GET['userid'])) $userid = intval_array($_GET['userid']);
		elseif (isset($_POST['userid'])) $userid = intval_array($_POST['userid']);
		else $userid = array();
		$userids = implode(",", $userid);
	}
	
	if (!$userids) acp_error($lang->get("LANG_ACP_USERS_ERROR_SELECTNOUSER"));
	
	$result = $db->query("SELECT u.userid, u.username, u.email, g.groupids, l.languagepackid FROM bb".$n."_users u LEFT JOIN bb".$n."_groupcombinations g USING(groupcombinationid) LEFT JOIN bb".$n."_languagepacks l ON (l.languagepackid=u.langid) WHERE u.userid IN ($userids) AND u.activation<>1");
	if ($db->num_rows($result)) {
		list($defaultgroupid) = $db->query_first("SELECT groupid FROM bb".$n."_groups WHERE grouptype='2'");
		$newgroupcombinations = array();
		
		$lang->load("MAIL");
		
		$langpacks = array();
		$langpacks[$lang->languagepackid] = $lang;
		
		while ($row = $db->fetch_array($result)) {
			$groupids = explode(",", $row['groupids']);
			while (list($key, $val) = each($groupids)) {
				if ($val == $defaultgroupid) {
					unset($groupids[$key]);
					break;
				}
			}
			
			$groupids = implode(",", $groupids);
			$newgroupcombinations[$groupids] .= ",".$row['userid'];
			
			if (!isset($langpacks[$row['languagepackid']])) {
				$langpacks[$row['languagepackid']] = new language(intval($row['languagepackid']), "..");
				$langpacks[$row['languagepackid']]->load("OWN,MAIL");
			}
			
			$master_board_name_email = getlangvar($o_master_board_name, $langpacks[$row['languagepackid']], 0);
			
			$mail_subject = $langpacks[$row['languagepackid']]->get("LANG_MAIL_ACTIVATION_SUBJECT", array('$master_board_name_email' => $master_board_name_email));
			$mail_text = $langpacks[$row['languagepackid']]->get("LANG_MAIL_ACTIVATION_TEXT", array('$username' => $row['username'], '$url2board' => $url2board, '$master_board_name_email' => $master_board_name_email));
			mailer($row['email'], $mail_subject, $mail_text);
		}
		
		if (count($newgroupcombinations)) {
			while (list($groupids, $n_userids) = each($newgroupcombinations)) $db->unbuffered_query("UPDATE bb".$n."_users SET groupcombinationid = '".cachegroupcombinationdata($groupids, 0)."' WHERE userid IN (0".$n_userids.")");
		}
		
		$db->unbuffered_query("UPDATE bb".$n."_users SET activation=1 WHERE userid IN ($userids) AND activation<>1", 1);
		$db->unbuffered_query("DELETE FROM bb".$n."_user2groups WHERE userid IN ($userids) AND groupid='$defaultgroupid'");
	}
	
	header("Location: users.php?action=find&sid=$session[hash]");
	exit();
}



/** send activation e - mail */
elseif ($action == "activation_email") {
	
	// check permissions
	checkAdminPermissions("a_can_users_other", 1);
	
	if (isset($_REQUEST['userids']) && $_REQUEST['userids'] != '') $userids = $_REQUEST['userids'];
	else {
		if (isset($_GET['userid'])) $userid = intval_array($_GET['userid']);
		elseif (isset($_POST['userid'])) $userid = intval_array($_POST['userid']);
		else $userid = array();
		$userids = implode(",", $userid);
	}
	
	if (!$userids) acp_error($lang->get("LANG_ACP_USERS_ERROR_SELECTNOUSER"));
	
	$result = $db->query("SELECT u.userid, u.username, u.email, u.activation, l.languagepackid FROM bb".$n."_users u LEFT JOIN bb".$n."_languagepacks l ON (l.languagepackid=u.langid) WHERE u.userid IN ($userids) AND u.activation<>1");
	if ($db->num_rows($result)) {
		$lang->load("MAIL");
		
		$langpacks = array();
		$langpacks[$lang->languagepackid] = $lang;
		
		while ($row = $db->fetch_array($result)) {
			
			if (!isset($langpacks[$row['languagepackid']])) {
				$langpacks[$row['languagepackid']] = new language(intval($row['languagepackid']), "..");
				$langpacks[$row['languagepackid']]->load("OWN,MAIL");
			}
			
			$master_board_name_email = getlangvar($o_master_board_name, $langpacks[$row['languagepackid']], 0);
			
			$r_username = $row['username'];
			$insertid = $row['userid'];
			$activation = $row['activation'];
			
			$mail_subject = $langpacks[$row['languagepackid']]->get("LANG_MAIL_REGISTER1_SUBJECT", array('$master_board_name_email' => $master_board_name_email));
			$mail_text = $langpacks[$row['languagepackid']]->get("LANG_MAIL_REGISTER1_TEXT", array('$r_username' => $r_username, '$url2board' => $url2board, '$insertid' => $insertid, '$activation' => $activation, '$webmastermail' => $webmastermail, '$master_board_name_email' => $master_board_name_email));
			mailer($row['email'], $mail_subject, $mail_text);
		}
	}
	
	header("Location: users.php?action=find&sid=$session[hash]");
	exit();
}




/** reset user rating */
elseif ($action == "rate") {
	
	// check permissions
	checkAdminPermissions("a_can_users_other", 1);
	
	if (isset($_GET['userid'])) $userid = intval($_GET['userid']);
	elseif (isset($_POST['userid'])) $userid = intval($_POST['userid']);
	else $userid = 0;
	
	if (isset($_POST['send'])) {
		if ($userid) {
			$db->unbuffered_query("UPDATE bb".$n."_users SET ratingcount = 0, ratingpoints = 0 WHERE userid = '$userid'", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_votes WHERE id = '$userid' AND votemode = 3", 1);
		}
		else {
			$db->unbuffered_query("UPDATE bb".$n."_users SET ratingcount = 0, ratingpoints = 0", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_votes WHERE votemode = 3", 1);
		}
		
		header("Location: users.php?action=find&sid=$session[hash]");
		exit();
	}
	
	eval("\$tpl->output(\"".$tpl->get("users_rate", 1)."\",1);");
}



/** set new password for user */
elseif ($action == "pw") {
	
	// check permissions
	checkAdminPermissions("a_can_users_edit", 1);
	
	if (isset($_GET['userid'])) $userid = intval($_GET['userid']);
	elseif (isset($_POST['userid'])) $userid = intval($_POST['userid']);
	else $userid = 0;
	
	$user = $db->query_first("SELECT u.userid, username, email, MAX(securitylevel) as securitylevel, l.languagepackid FROM bb".$n."_users u LEFT JOIN bb".$n."_user2groups u2g ON u2g.userid=u.userid LEFT JOIN bb".$n."_groups g ON g.groupid=u2g.groupid LEFT JOIN bb".$n."_languagepacks l ON (l.languagepackid=u.langid) WHERE u.userid = '$userid' GROUP BY u.userid");
	
	
	// check securitylevel
	checkSecurityLevel($user['securitylevel'], 1);
	
	if (isset($_POST['send'])) {
		if ($_POST['mode'] == 1) $newpassword = password_generate();
		else $newpassword = $_POST['newpassword'];
		
		$db->unbuffered_query("UPDATE bb".$n."_users SET password='".md5($newpassword)."', sha1_password='".sha1($newpassword)."' WHERE userid='$userid'", 1);
		
		if ($_POST['sendmail'] == 1) {
			if ($lang->languagepackid != $user['languagepackid']) $userlang = new language($user['languagepackid'], "..");
			else $userlang = $lang;
			$userlang->load("OWN,MAIL");
			
			$master_board_name_email = getlangvar($o_master_board_name, $userlang, 0);
			
			$mail_subject = $userlang->get("LANG_MAIL_NEWPW_SUBJECT", array('$master_board_name_email' => $master_board_name_email));
			$mail_text = $userlang->get("LANG_MAIL_NEWPW_TEXT", array('$username' => $user['username'], '$newpassword' => $newpassword, '$master_board_name_email' => $master_board_name_email));
			mailer($user['email'], $mail_subject, $mail_text);
		}
		
		eval("\$tpl->output(\"".$tpl->get("window_close", 1)."\",1);");
		exit();
	}
	
	$user['username'] = htmlconverter($user['username']);
	$lang->items['LANG_ACP_USERS_PASSWORD_CHANGE'] = $lang->get("LANG_ACP_USERS_PASSWORD_CHANGE", array('$username' => $user['username']));
	eval("\$tpl->output(\"".$tpl->get("users_pw", 1)."\",1);");
}



/** select user stats */
elseif ($action == "selectstats") {
	checkAdminPermissions("a_can_users_other", 1);
	
	$lang->load("ACP_OTHERSTUFF");
	
	if (isset($_GET['userid'])) $userid = intval_array($_GET['userid']);
	elseif (isset($_POST['userid'])) $userid = intval_array($_POST['userid']);
	else $userid = array();
	$userids = implode(",", $userid);
	
	if ($userids == '') acp_error($lang->get("LANG_ACP_USERS_ERROR_SELECTNOUSER"));
	
	$users = '';
	$result = $db->query("SELECT userid, username FROM bb".$n."_users WHERE userid IN ($userids)");
	if (!$db->num_rows($result)) acp_error($lang->get("LANG_ACP_USERS_ERROR_SELECTNOUSER"));
	while ($row = $db->fetch_array($result)) {
		$row['username'] = htmlconverter($row['username']);
		if ($users) $users .= ", ".makehreftag("../profile.php?userid=$row[userid]", $row['username'], "_blank");
		else $users = makehreftag("../profile.php?userid=$row[userid]", $row['username'], "_blank");
	}
	
	$installday = date("j", $installdate);
	$installmonth = date("n", $installdate);
	$installyear = date("Y", $installdate);
	$currentyear = date("Y");
	$currentday = date("j");
	$currentmonth = date("n");
	
	$from_day = "";
	$from_month = "";
	$from_year = "";
	
	for ($i = 1; $i < 32; $i++) $from_day .= makeoption($i, $i, $installday);
	for ($i = 1; $i < 13; $i++) $from_month .= makeoption($i, getmonth($i), $installmonth);
	for ($i = $installyear; $i <= $currentyear; $i++) $from_year .= makeoption($i, $i, $installyear);
	
	$to_day = "";
	$to_month = "";
	$to_year = "";
	
	for ($i = 1; $i < 32; $i++) $to_day .= makeoption($i, $i, $currentday);
	for ($i = 1; $i < 13; $i++) $to_month .= makeoption($i, getmonth($i), $currentmonth);
	for ($i = $installyear; $i <= $currentyear; $i++) $to_year .= makeoption($i, $i, $currentyear);
	
	eval("\$tpl->output(\"".$tpl->get("users_stats_select", 1)."\",1);");
}



/** show user stats */
elseif ($action == "showstats") {
	checkAdminPermissions("a_can_users_other", 1);
	$userids = trim($_POST['userids']);
	if (!$userids) acp_error($lang->get("LANG_ACP_USERS_ERROR_SELECTNOUSER"));
	
	switch ($_REQUEST['type']) {
		case 1:
			$table = "bb".$n."_threads";
			$datefield = "starttime";
			$userfield = "starterid";
			$lang->load('acp_otherstuff');
			$stats_name = $lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TYPE2'];
		break;
		default:
			$table = "bb".$n."_posts";
			$datefield = "posttime";
			$userfield = "userid";
			$lang->load('acp_otherstuff');
			$stats_name = $lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TYPE3'];
	}
	
	switch ($_POST['timeorder']) {
		case 1:
			$sqlformat = "%w %U %m %Y";
			$phpformat = "w~, ".$wbbuserdata['dateformat'];
		break;
		case 2:
			$sqlformat = "%U %Y";
			$phpformat = "# (n~ Y)";
		break;
		default:
			$sqlformat = "%m %Y";
			$phpformat = "n~ Y";
	}
	
	switch ($_POST['sortorder']) {
		case "asc": break;
		default: $_POST['sortorder'] = "desc";
	}
	
	$to = mktime(24, 0, 0, $_POST['to_month'], $_POST['to_day'], $_POST['to_year']);
	$from = mktime(0, 0, 0, $_POST['from_month'], $_POST['from_day'], $_POST['from_year']);
	
	$max = 0;
	$cache = array();
	$result = $db->query("SELECT COUNT(*), DATE_FORMAT(FROM_UNIXTIME($datefield),'$sqlformat') AS timeorder, MAX($datefield) AS statdate FROM $table WHERE $datefield > '$from' AND $datefield < '$to' AND $userfield IN ($userids) GROUP BY timeorder ORDER BY $datefield $_POST[sortorder]");
	while ($row = $db->fetch_array($result)) {
		
		
		$statdate = date($phpformat, $row['statdate']);
		
		if ($_POST['timeorder'] == 1) $statdate = preg_replace("/(\d+)~/e", "getday('\\1')", $statdate);
		if ($_POST['timeorder'] > 1) $statdate = preg_replace("/(\d+)~/e", "getmonth('\\1')", $statdate);
		if ($_POST['timeorder'] == 2) {
			$week = ceil((date('z', $row['statdate']) - daynumber($row['statdate'])) / 7) + ((daynumber(mktime(0, 0, 0, 1, 1, date('Y', $row['statdate']))) <= 3) ? (1) : (0));
			if ($week == 53 && daynumber(mktime(0, 0, 0, 12, 31, date('Y', $row['statdate']))) < 3) {
				$tempRow = $db->fetch_array($result);
				$row[0] += $tempRow[0];
				$week = 1;
			}
			$statdate = str_replace("#", "#".$week, $statdate);
		}
		
		if ($row[0] > $max) $max = $row[0];
		$cache[] = array($row[0], $statdate);
	}
	
	$showbit = '';
	if (count($cache)) {
		while (list($key, $stat) = each($cache)) {
			$width = round($stat[0] / $max * 500);
			eval("\$showbit .= \"".$tpl->get("stats_showbit", 1)."\";");
		}
	}
	
	eval("\$tpl->output(\"".$tpl->get("stats_show", 1)."\",1);");
}



/** merge user accounts */
elseif ($action == "merge") {
	checkAdminPermissions("a_can_users_merge", 1);

	if (isset($_GET['userid'])) $userid = intval_array($_GET['userid']);
        elseif (isset($_POST['userid'])) $userid = intval_array($_POST['userid']);
        else $userid = array();
        $userids = implode(",", $userid);

 	if ($userids == '') {
		if (isset($_REQUEST['userids']) && $_REQUEST['userids'] && wbb_substr_count($_REQUEST['userids'], ",") > 0) $userids = implode(",", intval_array(explode(",", $_REQUEST['userids'])));
		else acp_error($lang->get("LANG_ACP_USERS_ERROR_SELECTNOUSER"));
	}

	// check securitylevel
	if ($wbbuserdata['a_override_max_securitylevel'] != -1) {
		$result = $db->query("SELECT u.userid FROM bb".$n."_users u LEFT JOIN bb".$n."_user2groups u2g USING(userid) LEFT JOIN bb".$n."_groups g USING(groupid) WHERE u.userid IN($userids) GROUP BY u.userid HAVING MAX(g.securitylevel)<='".$wbbuserdata['a_override_max_securitylevel']."'");
		if ($db->num_rows($result) < 2) acp_error($lang->get("LANG_ACP_USERS_ERROR_SELECTNOUSER"));
		$userids = '';
		while ($row = $db->fetch_array($result)) $userids .= ",".$row['userid'];
		$userids = wbb_substr($userids, 1);
	}


	if ($_POST['send'] == "send") {
		$users = explode(",", $userids);
		if (!isset($_REQUEST['merge_userid']) || !$_REQUEST['merge_userid'] || !in_array($_REQUEST['merge_userid'], $users))  acp_error($lang->get("LANG_ACP_USERS_ERROR_SELECTNOUSER"));
		else {
			// merge
			$merge_userid = $_REQUEST['merge_userid'];
			$merge_username = $db->query_first("SELECT username FROM bb".$n."_users WHERE userid='$merge_userid'");
			$merge_username = $merge_username['username'];
			$db->unbuffered_query("UPDATE bb".$n."_posts SET userid='$merge_userid', username='".addslashes($merge_username)."' WHERE userid<>'$merge_userid' AND userid IN($userids)", 1);
			$db->unbuffered_query("UPDATE bb".$n."_posts SET editorid='$merge_userid', editor='".addslashes($merge_username)."' WHERE editorid<>'$merge_userid' AND editorid IN($userids)", 1);
			$db->unbuffered_query("UPDATE bb".$n."_threads SET starterid='$merge_userid', starter='".addslashes($merge_username)."' WHERE starterid<>'$merge_userid' AND starterid IN($userids)", 1);
			$db->unbuffered_query("UPDATE bb".$n."_threads SET lastposterid='$merge_userid', lastposter='".addslashes($merge_username)."' WHERE lastposterid<>'$merge_userid' AND lastposterid IN($userids)", 1);
			$db->unbuffered_query("UPDATE bb".$n."_boards SET lastposterid='$merge_userid', lastposter='".addslashes($merge_username)."' WHERE lastposterid<>'$merge_userid' AND lastposterid IN($userids)", 1);
			$userposts = $db->query_first("SELECT SUM(userposts) FROM bb".$n."_users WHERE userid<>'$merge_userid' AND userid IN($userids)");
			$db->unbuffered_query("UPDATE bb".$n."_users SET userposts=userposts+'".$userposts[0]."' WHERE userid='$merge_userid'", 1);
			$db->unbuffered_query("UPDATE bb".$n."_folders SET userid='$merge_userid' WHERE userid<>'$merge_userid' AND userid IN($userids)", 1);
			$db->unbuffered_query("UPDATE IGNORE bb".$n."_privatemessagereceipts SET recipientid='$merge_userid' WHERE recipientid<>'$merge_userid' AND recipientid IN($userids)", 1);
			$db->unbuffered_query("UPDATE bb".$n."_privatemessage SET senderid='$merge_userid' WHERE senderid<>'$merge_userid' AND senderid IN($userids)", 1);

			// delete other user accounts
			$db->unbuffered_query("DELETE FROM bb".$n."_access WHERE userid<>'$merge_userid' AND userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_moderators WHERE userid<>'$merge_userid' AND userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_searchs WHERE userid<>'$merge_userid' AND userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_events WHERE userid<>'$merge_userid' AND userid IN ($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_users WHERE userid<>'$merge_userid' AND userid IN($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_userfields WHERE userid<>'$merge_userid' AND userid IN($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_votes WHERE userid<>'$merge_userid' AND userid IN($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_user2groups WHERE userid<>'$merge_userid' AND userid IN($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_applications WHERE userid<>'$merge_userid' AND userid IN($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_sessions WHERE userid<>'$merge_userid' AND userid IN($userids)", 1);
			$db->unbuffered_query("DELETE FROM bb".$n."_privatemessagereceipts WHERE recipientid<>'$merge_userid' AND recipientid IN($userids)", 1);
			
			// update stats
 			$statupdate = $db->query_first("SELECT COUNT(*) AS usercount, MAX(userid) AS userid FROM bb".$n."_users");
			$db->unbuffered_query("UPDATE bb".$n."_stats SET usercount='".$statupdate['usercount']."', lastuserid='".$statupdate['userid']."'", 1);
		}
		header("Location: users.php?action=find&sid=$session[hash]");
		exit;
	}
	$users = '';
	$result = $db->query("SELECT userid, username FROM bb".$n."_users WHERE userid IN ($userids)");
	$count = $db->num_rows($result);
	if (!$count) acp_error($lang->get("LANG_ACP_USERS_ERROR_SELECTNOUSER"));
	while ($row = $db->fetch_array($result)) {
		$userid = $row['userid'];
		$row['username'] = htmlconverter($row['username']);
		if ($users) $users .= ", ".makehreftag("../profile.php?userid=$row[userid]", $row['username'], "_blank");
		else $users = makehreftag("../profile.php?userid=$row[userid]", $row['username'], "_blank");
		$merge_userselect .= makeoption($row['userid'], $row['username']);
	}

	eval("\$tpl->output(\"".$tpl->get("users_merge", 1)."\",1);");
}
?>
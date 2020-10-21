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
// * $Date: 2005-05-10 10:46:27 +0200 (Tue, 10 May 2005) $
// * $Author: Burntime $
// * $Rev: 1606 $
// ************************************************************************************//


$filename = 'usercp.php';

require('./global.php');
$lang->load('USERCP');

if (!$wbbuserdata['userid']) access_error();

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = '';


/**
* remove an element from a list
*
* @param string list
* @param string remove
*
* @return string new list
*/
function removeFromlist($list, $remove) {
	$listelements = explode(' ', $list);
	if (!in_array($remove, $listelements)) return - 1;
	else {
		$count = count($listelements);
		for ($i = 0; $i < $count; $i++) {
			if ($listelements[$i] == $remove) {
				if ($i == $count - 1) array_pop($listelements);
				else $listelements[$i] = array_pop($listelements);
				break;
			}
		}
		return implode(' ', $listelements);
	}
}







$username = htmlconverter($wbbuserdata['username']);
$lang->items['LANG_USERCP_TITLE'] = $lang->get("LANG_USERCP_TITLE", array('$username' => $username));
/** no action defined => startpage **/
if (!$action) {
	eval("\$tpl->output(\"".$tpl->get("usercp")."\");");
}






/** edit profile **/
if ($action == 'profile_edit') {
	$lang->load('REGISTER,POSTINGS');

	$usercp_error = '';
	$gender = array(1 => '', 2 => '');

	/** post data sent => verify and safe profile **/
	if (isset($_POST['send'])) {

		// profilefields
		if (isset($_POST['field']) && is_array($_POST['field'])) $field = trim_array($_POST['field']);
		else $field = array();
		if (isset($_POST['dayfield']) && is_array($_POST['dayfield'])) $dayfield = trim_array($_POST['dayfield']);
		else $dayfield = array();
		if (isset($_POST['monthfield']) && is_array($_POST['monthfield'])) $monthfield = trim_array($_POST['monthfield']);
		else $monthfield = array();
		if (isset($_POST['yearfield']) && is_array($_POST['yearfield'])) $yearfield = trim_array($_POST['yearfield']);
		else $yearfield = array();

		// profiledata
		if (isset($_POST['r_email'])) $r_email = wbb_trim($_POST['r_email']);
		if (isset($_POST['r_homepage'])) $r_homepage = wbb_trim($_POST['r_homepage']);
		if (isset($_POST['r_icq'])) $r_icq = str_replace("-", "", wbb_trim($_POST['r_icq']));
		if (isset($_POST['r_aim'])) $r_aim = wbb_trim($_POST['r_aim']);
		if (isset($_POST['r_yim'])) $r_yim = wbb_trim($_POST['r_yim']);
		if (isset($_POST['r_msn'])) $r_msn = wbb_trim($_POST['r_msn']);
		if (isset($_POST['r_day'])) $r_day = wbb_trim($_POST['r_day']);
		if (isset($_POST['r_month'])) $r_month = wbb_trim($_POST['r_month']);
		if (isset($_POST['r_year'])) $r_year = wbb_trim($_POST['r_year']);
		if (isset($_POST['r_gender'])) $r_gender = wbb_trim($_POST['r_gender']);
		if (isset($_POST['r_usertext'])) $r_usertext = wbb_trim($_POST['r_usertext']);
		if (isset($_POST['r_title']) && $wbbuserdata['can_edit_title'] == 1) $r_title = wbb_trim($_POST['r_title']);
		else $r_title = '';

		$error = '';
		$userfield_error = 0;
		$fieldvalues = '';

		/** verify required profilefields and build sql update query **/
		$result = $db->unbuffered_query("SELECT profilefieldid,required,fieldtype,choicecount,fieldoptions FROM bb".$n."_profilefields ORDER BY profilefieldid ASC");
		while ($row = $db->fetch_array($result)) {
			// is required -> check content
			if ($row['required'] == 1 && $row['fieldtype'] != "checkbox") {
				// date
				if ($row['fieldtype'] == "date") {
					if (!$dayfield[$row['profilefieldid']] || !$monthfield[$row['profilefieldid']] || !$yearfield[$row['profilefieldid']]) {
						$userfield_error = 1;
					}
				}
				// select
				else if ($row['fieldtype'] == "select") {
					$options = trim_array(explode("\n", dos2unix($row['fieldoptions'])));
					if (!isset($field[$row['profilefieldid']]) || !in_array($field[$row['profilefieldid']], $options)) {
						$userfield_error = 1;
					}
				}
				// multiselect
				else if ($row['fieldtype'] == "multiselect") {
					$options = trim_array(explode("\n", dos2unix($row['fieldoptions'])));
					if (!count($field[$row['profilefieldid']])) {
						$userfield_error = 1;
					}
					else {
						for ($i = 0, $j = count($field[$row['profilefieldid']]); $i < $j; $i++) {
							if (!in_array($field[$row['profilefieldid']][$i], $options)) {
								$userfield_error = 1;
							}
						}
					}
				}
				// other
				else {
					if (!isset($field[$row['profilefieldid']]) || $field[$row['profilefieldid']] == '') {
						$userfield_error = 1;
					}
				}
				
				if ($userfield_error == 1) break;
			}

			if ($row['fieldtype'] == "multiselect") {
				if (is_array($field[$row['profilefieldid']])) {
					if ($row['choicecount'] && count($field[$row['profilefieldid']]) > $row['choicecount']) {
						$max = count($field[$row['profilefieldid']]);
						for ($i = $row['choicecount']; $i < $max; $i++) unset($field[$row['profilefieldid']][$i]);
					}
					if ($fieldvalues) $fieldvalues .= ", field$row[profilefieldid] = '".addslashes(wbb_trim(implode("\n", $field[$row['profilefieldid']])))."'";
					else $fieldvalues .= "field$row[profilefieldid] = '".addslashes(wbb_trim(implode("\n", $field[$row['profilefieldid']])))."'";
				}
				else {
					if ($fieldvalues) $fieldvalues .= ", field$row[profilefieldid] = ''";
					else $fieldvalues .= "field$row[profilefieldid] = ''";
				}
			}
			elseif ($row['fieldtype'] == "date") {
				if ($dayfield[$row['profilefieldid']] && $monthfield[$row['profilefieldid']]) $datefield = ((wbb_strlen($yearfield[$row['profilefieldid']]) == 4) ? ($yearfield[$row['profilefieldid']]) : (((wbb_strlen($yearfield[$row['profilefieldid']]) == 2) ? ("19".$yearfield[$row['profilefieldid']]) : ("0000"))))."-".(($monthfield[$row['profilefieldid']] < 10) ? ("0".$monthfield[$row['profilefieldid']]) : ($monthfield[$row['profilefieldid']]))."-".(($dayfield[$row['profilefieldid']] < 10) ? ("0".$dayfield[$row['profilefieldid']]) : ($dayfield[$row['profilefieldid']]));
				else $datefield = "0000-00-00";
				if ($fieldvalues) $fieldvalues .= ", field$row[profilefieldid] = '".addslashes($datefield)."'";
				else $fieldvalues = "field$row[profilefieldid] = '".addslashes($datefield)."'";
			}
			else {
				if ($fieldvalues) $fieldvalues .= ", field$row[profilefieldid] = '".addslashes($field[$row['profilefieldid']])."'";
				else $fieldvalues = "field$row[profilefieldid] = '".addslashes($field[$row['profilefieldid']])."'";
			}
		}


		/** verify input, build error messages **/
		if ($userfield_error == 1) $error .= $lang->items['LANG_POSTINGS_ERROR1'];
		if (wbb_strlen($r_usertext) > $wbbuserdata['max_usertext_length']) $error .= $lang->items['LANG_REGISTER_ERROR6'];
		if ($error) eval("\$usercp_error = \"".$tpl->get("register_error")."\";");

		/** input ok **/
		else {
			if ($r_homepage && !preg_match("/[a-zA-Z]:\/\//si", $r_homepage)) $r_homepage = "http://".$r_homepage;
			if ($r_day && $r_month) {
				$r_year = ((wbb_strlen($r_year) == 4) ? ($r_year) : (((wbb_strlen($r_year) == 2) ? ("19$r_year") : ("0000"))));
				if (checkdate($r_month, $r_day, (($r_year != '0000') ? ($r_year) : (date('Y', time()))))) $birthday = $r_year."-".(($r_month < 10) ? ("0$r_month") : ($r_month))."-".(($r_day < 10) ? ("0$r_day") : ($r_day));
				else $birthday = "0000-00-00";
			}
			else $birthday = "0000-00-00";
			if ($wbbuserdata['can_edit_title'] == 1 && isset($r_title)) if (!verify_usertitle($r_title)) $r_title = '';
			list($rankid) = $db->query_first("SELECT rankid FROM bb".$n."_ranks WHERE groupid IN ('0','$wbbuserdata[rankgroupid]') AND needposts<='$wbbuserdata[userposts]' AND gender IN ('0','".intval($r_gender)."') ORDER BY needposts DESC, gender DESC", 1);

			$db->unbuffered_query("UPDATE bb".$n."_users SET ".(($wbbuserdata['can_edit_title'] == 1 && isset($r_title)) ? ("title='".addslashes($r_title)."', ") : (""))."usertext='".addslashes($r_usertext)."', icq='".intval($r_icq)."', aim='".addslashes($r_aim)."', yim='".addslashes($r_yim)."', msn='".addslashes($r_msn)."', homepage='".addslashes($r_homepage)."', birthday='".addslashes($birthday)."', gender='".intval($r_gender)."'".(($rankid != $wbbuserdata['rankid']) ? (", rankid='$rankid'") : (""))." WHERE userid = '$wbbuserdata[userid]'", 1);
			if ($fieldvalues) $db->unbuffered_query("UPDATE bb".$n."_userfields SET $fieldvalues WHERE userid = '$wbbuserdata[userid]'", 1);

			header("Location: usercp.php?action=profile_edit".$SID_ARG_2ND_UN);
			exit();
		}
	}
	/** profile saved **/


	/** no post data sent, get profile **/
	else {
		$r_homepage = $wbbuserdata['homepage'];
		$r_icq = $wbbuserdata['icq'];
		$r_aim = $wbbuserdata['aim'];
		$r_yim = $wbbuserdata['yim'];
		$r_msn = $wbbuserdata['msn'];
		$birthday = explode("-", $wbbuserdata['birthday']);
		$r_day = $birthday[2];
		$r_month = $birthday[1];
		$r_year = (($birthday[0]) ? ($birthday[0]) : (""));
		$r_gender = $wbbuserdata['gender'];
		$r_usertext = $wbbuserdata['usertext'];
		$r_title = $wbbuserdata['title'];
		$userfields = $db->query_first("SELECT * FROM bb".$n."_userfields WHERE userid='$wbbuserdata[userid]'");
	}


	/** now generate the html - form **/
	$day_options = ''; $month_options = '';
	for ($i = 1; $i <= 31; $i++) $day_options .= makeoption($i, $i, $r_day);
	for ($i = 1; $i <= 12; $i++) $month_options .= makeoption($i, getmonth($i), $r_month);

	if (isset($r_gender)) $gender[$r_gender] = ' selected="selected"';

	$z = 0;
	$y = 1;
	$profilefields_required = '';
	$profilefields = '';
	/** get profilefields **/
	$result = $db->unbuffered_query("SELECT * FROM bb".$n."_profilefields ORDER BY fieldorder ASC");
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
			if (isset($_POST['send'])) $field_value = htmlconverter($field[$row['profilefieldid']]);
			else $field_value = htmlconverter($userfields["field".$row['profilefieldid']]);
			break;

			case "select":
			$row_options = explode("\n", $row['fieldoptions']);
			$field_value = "<option value=\"\">".$lang->get("LANG_GLOBAL_PLEASE_SELECT")."</option>\n";
			foreach ($row_options as $option) $field_value .= makeoption(htmlconverter(wbb_trim($option)), htmlconverter(wbb_trim($option)), ((isset($_POST['send'])) ? (htmlconverter(wbb_trim($field[$row['profilefieldid']]))) : (htmlconverter(wbb_trim($userfields["field".$row['profilefieldid']])))));
			break;

			case "multiselect":
			$row_options = explode("\n", $row['fieldoptions']);
			if (isset($_POST['send']) && is_array($field[$row['profilefieldid']]) && count($field[$row['profilefieldid']])) $selected_options = $field[$row['profilefieldid']];
			else $selected_options = explode("\n", $userfields["field".$row['profilefieldid']]);
			foreach ($row_options as $option) $field_value .= makeoption(htmlconverter(wbb_trim($option)), htmlconverter(wbb_trim($option)), ((in_array(wbb_trim($option), $selected_options)) ? (htmlconverter(wbb_trim($option))) : ("")));
			break;

			case "checkbox":
			$field_value = htmlconverter($row['fieldoptions']);
			$field_checked = (($row['fieldoptions'] == ((isset($_POST['send'])) ? ($field[$row['profilefieldid']]) : ($userfields["field".$row['profilefieldid']]))) ? (" checked=\"checked\"") : (""));
			break;

			case "date":
			if (isset($_POST['send'])) {
				$year_tmp = $yearfield[$row['profilefieldid']];
				$month_tmp = $monthfield[$row['profilefieldid']];
				$day_tmp = $dayfield[$row['profilefieldid']];
			}
			else list($year_tmp, $month_tmp, $day_tmp) = explode("-", $userfields["field".$row['profilefieldid']]);
			for ($i = 1; $i <= 31; $i++) $dayfield_value .= makeoption($i, $i, $day_tmp);
			for ($i = 1; $i <= 12; $i++) $monthfield_value .= makeoption($i, getmonth($i), $month_tmp);
			if (intval($year_tmp)) $yearfield_value = $year_tmp;
			else $yearfield_value = '';
			break;
		}

		$row['title'] = getlangvar($row['title'], $lang);
		$row['description'] = getlangvar($row['description'], $lang);

		if ($row['required'] == 1) {
			$tdclass = getone($y, "tablea", "tableb");
			eval("\$profilefields_required .= \"".$tpl->get("register_userfield_$row[fieldtype]")."\";");
			$y++;
		}
		else {
			$tdclass = getone($z, "tablea", "tableb");
			eval("\$profilefields .= \"".$tpl->get("register_userfield_$row[fieldtype]")."\";");
			$z++;
		}
	}

	$r_homepage = htmlconverter($r_homepage);
	$r_icq = intval($r_icq);
	$r_aim = htmlconverter($r_aim);
	$r_yim = htmlconverter($r_yim);
	$r_msn = htmlconverter($r_msn);
	$r_year = htmlconverter($r_year);
	$r_gender = htmlconverter($r_gender);
	$r_usertext = htmlconverter($r_usertext);
	$r_title = htmlconverter($r_title);

	if (!$r_icq) $r_icq = '';
	if ($r_year == "0000") $r_year = '';
	/** output html - form **/
	eval("\$tpl->output(\"".$tpl->get("usercp_profile_edit")."\");");
}



/** edit signature **/
if ($action == 'signature_edit') {
	$lang->load('REGISTER,POSTINGS');
	require('./acp/lib/class_parse.php');

	$preview_signature = '';
	$old_signature = '';
	$usercp_error = '';

	if (isset($_POST['send'])) {
		// post options
		if (isset($_POST['disablesmilies'])) $disablesmilies = intval($_POST['disablesmilies']);
		else $disablesmilies = 0;
		if (isset($_POST['disablehtml'])) $disablehtml = intval($_POST['disablehtml']);
		else $disablehtml = 0;
		if (isset($_POST['disablebbcode'])) $disablebbcode = intval($_POST['disablebbcode']);
		else $disablebbcode = 0;
		if (isset($_POST['disableimages'])) $disableimages = intval($_POST['disableimages']);
		else $disableimages = 0;


		/* get message & strip crap */
		$message = stripcrap(wbb_trim($_POST['message']));

		/* posting feature rights:start */
		if (!$wbbuserdata['can_use_sig_smilies'] || $disablesmilies == 1) $allowsmilies = 0;
		else $allowsmilies = 1;

		if (!$wbbuserdata['can_use_sig_html'] || $disablehtml == 1) $allowhtml = 0;
		else $allowhtml = 1;

		if (!$wbbuserdata['can_use_sig_bbcode'] || $disablebbcode == 1) $allowbbcode = 0;
		else $allowbbcode = 1;

		if (!$wbbuserdata['can_use_sig_images'] || $disableimages == 1) $allowimages = 0;
		else $allowimages = 1;
		/* posting feature rights:end */


		if (!isset($_POST['preview']) && !$_POST['change_editor']) {
			$error = '';
			if (wbb_strlen($message) > $wbbuserdata['max_sig_length']) $error .= $lang->items['LANG_REGISTER_ERROR4'];
			if ($wbbuserdata['max_sig_image'] != -1 && wbb_substr_count(wbb_strtolower($message), "[img]") > $wbbuserdata['max_sig_image']) $error .= $lang->items['LANG_REGISTER_ERROR5'];
			if ($error) eval("\$usercp_error = \"".$tpl->get("register_error")."\";");
			else {
				$db->unbuffered_query("UPDATE bb".$n."_users SET signature='".addslashes($message)."', allowsigsmilies='$allowsmilies', allowsightml='$allowhtml', allowsigbbcode='$allowbbcode', allowsigimages='$allowimages' WHERE userid='$wbbuserdata[userid]'", 1);
				header("Location: usercp.php?action=signature_edit".$SID_ARG_2ND_UN);
				exit();
			}
		}
		else if (!$_POST['change_editor']) {
			$parse = &new parse($docensor, 75, $wbbuserdata['showimages'], "", $usecode);
			$preview_signature = $parse->doparse($message, $allowsmilies, $allowhtml, $allowbbcode, $allowimages);
		}

		if ($disablesmilies == 1) $checked[0] = 'checked="checked"';
		else $checked[0] = '';
		if ($disablehtml == 1) $checked[1] = 'checked="checked"';
		else $checked[1] = '';
		if ($disablebbcode == 1) $checked[2] = 'checked="checked"';
		else $checked[2] = '';
		if ($disableimages == 1) $checked[3] = 'checked="checked"';
		else $checked[3] = '';
	}
	else {
		$message = $wbbuserdata['signature'];

		$disablesmilies = 1 - $wbbuserdata['allowsigsmilies'];
		$disablehtml = 1 - $wbbuserdata['allowsightml'];
		$disablebbcode = 1 - $wbbuserdata['allowsigbbcode'];
		$disableimages = 1 - $wbbuserdata['allowsigimages'];

		if ($disablesmilies == 1) $checked[0] = 'checked="checked"';
		else $checked[0] = '';
		if ($disablehtml == 1) $checked[1] = 'checked="checked"';
		else $checked[1] = '';
		if ($disablebbcode == 1) $checked[2] = 'checked="checked"';
		else $checked[2] = '';
		if ($disableimages == 1) $checked[3] = 'checked="checked"';
		else $checked[3] = '';
	}

	if ($wbbuserdata['signature']) {
		if (!isset($parse)) $parse = &new parse($docensor, 75, $wbbuserdata['showimages'], "", $usecode);
		$old_signature = $parse->doparse($wbbuserdata['signature'], $wbbuserdata['allowsigsmilies'], $wbbuserdata['allowsightml'], $wbbuserdata['allowsigbbcode'], $wbbuserdata['allowsigimages']);
	}

	if ($wbbuserdata['can_use_sig_bbcode'] == 1 && $wbbuserdata['usewysiwyg'] != 1) $bbcode_buttons = getcodebuttons();
	if ($wbbuserdata['can_use_sig_smilies'] == 1)  {
		if ($wbbuserdata['usewysiwyg'] == 1) $smilies = getAppletSmilies();
		$bbcode_smilies = getclickysmilies($smilie_table_cols, $smilie_table_rows);
	}

	$note = '';
	if ($wbbuserdata['can_use_sig_html'] == 0) $note .= $lang->items['LANG_POSTINGS_HTML_NOT_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_HTML_ALLOW'];
	if ($wbbuserdata['can_use_sig_bbcode'] == 0) $note .= $lang->items['LANG_POSTINGS_BBCODE_NOT_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_BBCODE_ALLOW'];
	if ($wbbuserdata['can_use_sig_smilies'] == 0) $note .= $lang->items['LANG_POSTINGS_SMILIES_NOT_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_SMILIES_ALLOW'];
	if ($wbbuserdata['can_use_sig_images'] == 0) $note .= $lang->items['LANG_POSTINGS_HTML_IMAGES_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_IMAGES_ALLOW'];

	if (isset($message)) $message = htmlconverter($message);

	$lang->items['LANG_POSTINGS_JS_MESSAGE_TOLONG'] = $lang->items['LANG_USERCP_SIGNATURE_TOLONG'];
	$lang->items['LANG_POSTINGS_JS_MESSAGE_MAXLENGTH'] = $lang->items['LANG_USERCP_SIGNATURE_MAXLENGTH'];
	$lang->items['LANG_POSTINGS_JS_MESSAGE_CHECKLENGTH'] = $lang->items['LANG_USERCP_SIGNATURE_CHECKLENGTH_TEXT'];

	eval("\$headinclude .= \"".$tpl->get("bbcode_script")."\";");
	eval("\$editor = \"".$tpl->get("editor")."\";");
	eval("\$editor_switch = \"".$tpl->get("editor_switch")."\";");
	eval("\$tpl->output(\"".$tpl->get("usercp_signature_edit")."\");");
}


/** change options **/
if ($action == 'options_change') {
	$lang->load('REGISTER,POSTINGS');

	if (isset($_POST['send'])) {

		if (isset($_POST['r_invisible'])) $r_invisible = wbb_trim($_POST['r_invisible']);
		if (isset($_POST['r_usecookies'])) $r_usecookies = wbb_trim($_POST['r_usecookies']);
		if (isset($_POST['r_admincanemail'])) $r_admincanemail = wbb_trim($_POST['r_admincanemail']);
		if (isset($_POST['r_showemail'])) $r_showemail = wbb_trim($_POST['r_showemail']);
		if (isset($_POST['r_usercanemail'])) $r_usercanemail = wbb_trim($_POST['r_usercanemail']);
		if (isset($_POST['r_emailnotify'])) $r_emailnotify = wbb_trim($_POST['r_emailnotify']);
		if (isset($_POST['r_notificationperpm'])) $r_notificationperpm = wbb_trim($_POST['r_notificationperpm']);
		if (isset($_POST['r_receivepm'])) $r_receivepm = wbb_trim($_POST['r_receivepm']);
		if (isset($_POST['r_emailonpm'])) $r_emailonpm = wbb_trim($_POST['r_emailonpm']);
		if (isset($_POST['r_pmpopup'])) $r_pmpopup = wbb_trim($_POST['r_pmpopup']);
		if (isset($_POST['r_showsignatures'])) $r_showsignatures = wbb_trim($_POST['r_showsignatures']);
		if (isset($_POST['r_showavatars'])) $r_showavatars = wbb_trim($_POST['r_showavatars']);
		if (isset($_POST['r_showimages'])) $r_showimages = wbb_trim($_POST['r_showimages']);
		if (isset($_POST['r_daysprune'])) $r_daysprune = wbb_trim($_POST['r_daysprune']);
		if (isset($_POST['r_umaxposts'])) $r_umaxposts = wbb_trim($_POST['r_umaxposts']);
		if (isset($_POST['r_threadview'])) $r_threadview = wbb_trim($_POST['r_threadview']);
		if (isset($_POST['r_dateformat'])) $r_dateformat = wbb_trim($_POST['r_dateformat']);
		if (isset($_POST['r_timeformat'])) $r_timeformat = wbb_trim($_POST['r_timeformat']);
		if (isset($_POST['r_startweek'])) $r_startweek = wbb_trim($_POST['r_startweek']);
		if (isset($_POST['r_timezoneoffset'])) $r_timezoneoffset = wbb_trim($_POST['r_timezoneoffset']);
		if (isset($_POST['r_styleid'])) $r_styleid = wbb_trim($_POST['r_styleid']);
		if (isset($_POST['r_langid'])) $r_langid = wbb_trim($_POST['r_langid']);
		if (isset($_POST['r_emailonapplication'])) $r_emailonapplication = wbb_trim($_POST['r_emailonapplication']);
		if (isset($_POST['r_usewysiwyg'])) $r_usewysiwyg = wbb_trim($_POST['r_usewysiwyg']);

		if (!$r_dateformat) $r_dateformat = $dateformat;
		if (!$r_timeformat) $r_timeformat = $timeformat;


		$db->unbuffered_query("UPDATE bb".$n."_users SET showemail='".intval($r_showemail)."', admincanemail='".intval($r_admincanemail)."', usercanemail='".intval($r_usercanemail)."', invisible='".intval($r_invisible)."', usecookies='".intval($r_usecookies)."', styleid='".intval($r_styleid)."', daysprune='".intval($r_daysprune)."', timezoneoffset='".addslashes(htmlspecialchars($r_timezoneoffset))."', startweek='".intval($r_startweek)."', dateformat='".addslashes($r_dateformat)."', timeformat='".addslashes($r_timeformat)."', emailnotify='".intval($r_emailnotify)."', notificationperpm='".intval($r_notificationperpm)."', receivepm='".intval($r_receivepm)."', emailonpm='".intval($r_emailonpm)."', pmpopup='".intval($r_pmpopup)."', umaxposts='".intval($r_umaxposts)."', showsignatures='".intval($r_showsignatures)."', showavatars='".intval($r_showavatars)."', showimages='".intval($r_showimages)."', threadview='".intval($r_threadview)."', langid='".intval($r_langid)."'".(($wbbuserdata['isgroupleader'] == 1) ? (", emailonapplication='".intval($r_emailonapplication)."'") : ("")).", usewysiwyg='".intval($r_usewysiwyg)."' WHERE userid = '$wbbuserdata[userid]'", 1);
		if ($r_styleid != $session['styleid'] || $r_langid != $session['langid']) $db->unbuffered_query("UPDATE bb".$n."_sessions SET styleid='".intval($r_styleid)."', langid='".intval($r_langid)."' WHERE sessionhash='$sid'", 1);
		header("Location: usercp.php?action=options_change".$SID_ARG_2ND_UN);
		exit();
	}
	else {
		$r_invisible		= $wbbuserdata['invisible'];
		$r_usecookies		= $wbbuserdata['usecookies'];
		$r_admincanemail	= $wbbuserdata['admincanemail'];
		$r_showemail		= $wbbuserdata['showemail'];
		$r_usercanemail		= $wbbuserdata['usercanemail'];
		$r_emailnotify		= $wbbuserdata['emailnotify'];
		$r_notificationperpm	= $wbbuserdata['notificationperpm'];
		$r_receivepm		= $wbbuserdata['receivepm'];
		$r_emailonpm		= $wbbuserdata['emailonpm'];
		$r_pmpopup		= $wbbuserdata['pmpopup'];
		$r_showsignatures	= $wbbuserdata['showsignatures'];
		$r_showavatars		= $wbbuserdata['showavatars'];
		$r_showimages		= $wbbuserdata['showimages'];
		$r_daysprune		= $wbbuserdata['daysprune'];
		$r_umaxposts		= $wbbuserdata['umaxposts'];
		$r_dateformat		= $wbbuserdata['dateformat'];
		$r_timeformat		= $wbbuserdata['timeformat'];
		$r_startweek		= $wbbuserdata['startweek'];
		$r_timezoneoffset	= $wbbuserdata['timezoneoffset'];
		$r_styleid		= $wbbuserdata['styleid'];
		$r_langid		= $wbbuserdata['langid'];
		$r_threadview		= $wbbuserdata['threadview'];
		$r_emailonapplication	= $wbbuserdata['emailonapplication'];
		$r_usewysiwyg		= $wbbuserdata['usewysiwyg'];
	}

	$startweek_options = '';
	for ($i = 0; $i < 7; $i++) $startweek_options .= makeoption($i, getday($i), $r_startweek);

	if (isset($r_invisible)) $invisible[$r_invisible] = " selected=\"selected\"";
	if (isset($r_usecookies)) $usecookies[$r_usecookies] = " selected=\"selected\"";
	if (isset($r_admincanemail)) $admincanemail[$r_admincanemail] = " selected=\"selected\"";
	if (isset($r_showemail)) $showemail[$r_showemail] = " selected=\"selected\"";
	if (isset($r_usercanemail)) $usercanemail[$r_usercanemail] = " selected=\"selected\"";
	if (isset($r_emailnotify)) $emailnotify[$r_emailnotify] = " selected=\"selected\"";
	if (isset($r_notificationperpm)) $notificationperpm[$r_notificationperpm] = " selected=\"selected\"";
	if (isset($r_receivepm)) $receivepm[$r_receivepm] = " selected=\"selected\"";
	if (isset($r_emailonpm)) $emailonpm[$r_emailonpm] = " selected=\"selected\"";
	if (isset($r_pmpopup)) $spmpopup[$r_pmpopup] = " selected=\"selected\"";
	if (isset($r_showsignatures)) $showsignatures[$r_showsignatures] = " selected=\"selected\"";
	if (isset($r_showavatars)) $showavatars[$r_showavatars] = " selected=\"selected\"";
	if (isset($r_showimages)) $showimages[$r_showimages] = " selected=\"selected\"";
	if (isset($r_daysprune)) $sdaysprune[$r_daysprune] = " selected=\"selected\"";
	if (isset($r_umaxposts)) $sumaxposts[$r_umaxposts] = " selected=\"selected\"";
	if (isset($r_threadview)) $sthreadview[$r_threadview] = " selected=\"selected\"";
	if (isset($r_emailonapplication)) $emailonapplication[$r_emailonapplication] = " selected=\"selected\"";
	if (isset($r_usewysiwyg)) $usewysiwyg[$r_usewysiwyg] = " selected=\"selected\"";

	$timezone_options = '';
	$timezones = explode("\n", $lang->items['LANG_REGISTER_TIMEZONES']);
	for ($i = 0; $i < count($timezones); $i++) {
		$parts = explode("|", wbb_trim($timezones[$i]));
		$timezone_options .= makeoption($parts[0], "(GMT".(($parts[1]) ? (" ".$parts[1]) : ("")).") $parts[2]", $r_timezoneoffset);
	}

	/* styles */
	$style_options = '';
	$result = $db->unbuffered_query("SELECT styleid, stylename FROM bb".$n."_styles ORDER BY stylename ASC");
	while ($row = $db->fetch_array($result)) $style_options .= makeoption($row['styleid'], getlangvar($row['stylename'], $lang), $r_styleid);

	/* language packs */
	$lang_options = '';
	$result = $db->unbuffered_query("SELECT languagepackid, languagepackname FROM bb".$n."_languagepacks ORDER BY languagepackname ASC");
	while ($row = $db->fetch_array($result)) $lang_options .= makeoption($row['languagepackid'], getlangvar($row['languagepackname'], $lang), $r_langid);

	$r_dateformat = htmlconverter($r_dateformat);
	$r_timeformat = htmlconverter($r_timeformat);

	eval("\$tpl->output(\"".$tpl->get("usercp_options_change")."\");");
}

/** change password **/
if ($action == 'password_change') {
	$lang->load('REGISTER,POSTINGS');

	if (isset($_POST['send'])) {
		$new_password = $_POST['new_password'];
		$confirm_new_password = $_POST['confirm_new_password'];

		$authentification = false;
		if ($allowloginencryption == 1 && $_POST['crypted'] == "true" && $wbbuserdata['sha1_password'])	{
			if (sha1(sha1($session['authentificationcode']).$wbbuserdata['sha1_password']) == $_POST['authentificationcode']) $authentification = true;
			else $authentification = false;
		}
		else {
			if (md5($_POST['l_password']) == $wbbuserdata['password']) {
				$authentification = true;
				if (!$wbbuserdata['sha1_password']) {
					$db->unbuffered_query("UPDATE bb".$n."_users SET sha1_password='".sha1($_POST['l_password'])."' WHERE userid='$wbbuserdata[userid]'");
				}
			}
			else $authentification = false;
		}

		if (($_POST['crypted'] == "false" && !$_POST['l_password']) || !$new_password || !$confirm_new_password) error($lang->get("LANG_GLOBAL_ERROR1"));
		elseif ($new_password != $confirm_new_password) error($lang->get("LANG_USERCP_PASSWORD_CHANGE_ERROR1"));
		elseif ($authentification == false) error($lang->get("LANG_USERCP_PASSWORD_CHANGE_ERROR2"));
		else {
			$db->query("UPDATE bb".$n."_users SET password='".md5($new_password)."', sha1_password='".sha1($new_password)."' WHERE userid='$wbbuserdata[userid]'");
			if ($wbbuserdata['usecookies'] == 1) bbcookie("userpassword", md5($new_password), time() + 3600 * 24 * 365);
			
			redirect($lang->get("LANG_USERCP_PW_REDIRECT"), "usercp.php".$SID_ARG_1ST);
			exit;
		}
	}

	eval("\$tpl->output(\"".$tpl->get("usercp_password_change")."\");");
}


/** change email **/
if ($action == 'email_change') {
	$lang->load('REGISTER,POSTINGS');

	if (isset($_POST['send'])) {
		$new_email = wbb_trim($_POST['new_email']);
		$confirm_new_email = wbb_trim($_POST['confirm_new_email']);

		if ($new_email == $wbbuserdata['email']) {
			header("Location: usercp.php".$SID_ARG_1ST);
			exit();
		}


		$authentification = false;
		if ($allowloginencryption == 1 && $_POST['crypted'] == "true" && $wbbuserdata['sha1_password']) {
			if (sha1(sha1($session['authentificationcode']).$wbbuserdata['sha1_password']) == $_POST['authentificationcode']) $authentification = true;
			else $authentification = false;
		}
		else {
			if (md5($_POST['l_password']) == $wbbuserdata['password']) {
				$authentification = true;
				if (!$wbbuserdata['sha1_password']) {
					$db->unbuffered_query("UPDATE bb".$n."_users SET sha1_password='".sha1($_POST['l_password'])."' WHERE userid='$wbbuserdata[userid]'");
				}
			}
			else $authentification = false;
		}

		if (($_POST['crypted'] == "false" && !$_POST['l_password']) || !$new_email || !$confirm_new_email) error($lang->get("LANG_GLOBAL_ERROR1"));
		elseif ($authentification == false) error($lang->get("LANG_USERCP_PASSWORD_CHANGE_ERROR2"));
		elseif ($new_email != $confirm_new_email) error($lang->get("LANG_USERCP_EC_ERROR1"));
		elseif (!verify_email($new_email)) error($lang->get("LANG_USERCP_EC_ERROR2"));
		else {
			$db->query("UPDATE bb".$n."_users SET email='".addslashes($new_email)."' WHERE userid = '$wbbuserdata[userid]'");

			if ($emailverifymode == 0) {
				redirect($lang->get("LANG_USERCP_EC_REDIRECT0"), "usercp.php".$SID_ARG_1ST);
			}
			if ($emailverifymode == 3) {
				$lang->load('MAIL');

				$r_password = password_generate();
				$db->query("UPDATE bb".$n."_users SET password='".md5($r_password)."', sha1_password='".sha1($r_password)."' WHERE userid = '$wbbuserdata[userid]'");
				$db->query("UPDATE bb".$n."_sessions SET userid=0 WHERE sessionhash='$sid'");

				$master_board_name_email = getlangvar($o_master_board_name, $lang, 0);

				$subject = $lang->get("LANG_MAIL_EC3_SUBJECT", array('$master_board_name_email' => $master_board_name_email));
				$content = $lang->get("LANG_MAIL_EC3_TEXT", array('$master_board_name_email' => $master_board_name_email, '$username' => $wbbuserdata['username'], '$r_password' => $r_password));
				mailer($new_email, $subject, $content);

				redirect($lang->get("LANG_USERCP_EC_REDIRECT3", array('$new_email' => $new_email)), "index.php".$SID_ARG_1ST, 20);
			}

			if ($emailverifymode == 1 || $emailverifymode == 2) {
				$activation = code_generate();
				list($groupid) = $db->query_first("SELECT groupid FROM bb".$n."_groups WHERE grouptype = 2");
				if (!in_array($groupid, $wbbuserdata['groupids'])) {
					$wbbuserdata['groupids'][] = $groupid;
					sort($wbbuserdata['groupids']);

					$db->unbuffered_query("UPDATE bb".$n."_users SET activation='$activation', groupcombinationid='".cachegroupcombinationdata(implode(",", $wbbuserdata['groupids']), 0)."' WHERE userid='".$wbbuserdata['userid']."'", 1);
				}
				else $db->query("UPDATE bb".$n."_users SET activation='$activation' WHERE userid = '$wbbuserdata[userid]'");

				$db->query("INSERT IGNORE INTO bb".$n."_user2groups (userid,groupid) VALUES ('$wbbuserdata[userid]','$groupid')");

				if ($emailverifymode == 1) {
					$lang->load('MAIL');

					$master_board_name_email = getlangvar($o_master_board_name, $lang, 0);

					$subject = $lang->get("LANG_MAIL_EC1_SUBJECT", array('$master_board_name_email' => $master_board_name_email));
					$content = $lang->get("LANG_MAIL_EC1_TEXT", array('$master_board_name_email' => $master_board_name_email, '$username' => $wbbuserdata['username'], '$url2board' => $url2board, '$userid' => $wbbuserdata['userid'], '$activation' => $activation, '$webmastermail' => $webmastermail));
					mailer($new_email, $subject, $content);

					redirect($lang->get("LANG_USERCP_EC_REDIRECT1", array('$new_email' => $new_email)), "usercp.php".$SID_ARG_1ST, 20);
				}
				else redirect($lang->get("LANG_USERCP_EC_REDIRECT2", array('$new_email' => $new_email)), "usercp.php".$SID_ARG_1ST, 20);
			}

			exit;
		}
	}

	$wbbuserdata['email'] = htmlconverter($wbbuserdata['email']);
	eval("\$tpl->output(\"".$tpl->get("usercp_email_change")."\");");
}



/** buddy list **/
if ($action == 'buddy_list') {
	$lang->load('MEMBERS');

	if (isset($_POST['send'])) {
		list($userid) = $db->query_first("SELECT userid FROM bb".$n."_users WHERE username='".addslashes(wbb_trim($_POST['addtolist']))."'");
		if (!$userid) error($lang->items['LANG_USERCP_ERROR1']);
		elseif ($userid == $wbbuserdata['userid']) error($lang->items['LANG_USERCP_ERROR2']);
		else {
			$buddylist = add2list($wbbuserdata['buddylist'], $userid);
			if ($buddylist != -1) $db->unbuffered_query("UPDATE bb".$n."_users SET buddylist='$buddylist' WHERE userid='$wbbuserdata[userid]'", 1);
			header("Location: usercp.php?action=buddy_list".$SID_ARG_2ND_UN);
			exit();
		}
	}

	$listbit = '';
	$pmLink = '';
	$buddyCount=0;
	if ($wbbuserdata['buddylist'] != '') {
		$result = $db->unbuffered_query("SELECT u.userid, u.username, IF(s.lastactivity>=".(time() - $useronlinetimeout * 60).(($wbbuserdata['a_can_view_ghosts'] == 1) ? ("") : (" AND u.invisible=0")).",1,0) AS online FROM bb".$n."_users u
		LEFT JOIN bb".$n."_sessions s USING (userid)
		WHERE u.userid IN ('".str_replace(" ", "','", $wbbuserdata[buddylist])."') ORDER BY online DESC, u.username ASC");
		while ($row = $db->fetch_array($result)) {
			$row['username'] = htmlconverter($row['username']);
			$username = $row['username'];
			if ($row['online']) $LANG_MEMBERS_USERONLINE = $lang->get("LANG_MEMBERS_USERONLINE", array('$username' => $username));
			else $LANG_MEMBERS_USERONLINE = $lang->get("LANG_MEMBERS_USEROFFLINE", array('$username' => $username));
			$pmLink .= "&amp;userid[]=$row[userid]";
			$buddyCount++;
			eval("\$listbit .= \"".$tpl->get("usercp_buddy_listbit")."\";");
		}
	}

	eval("\$tpl->output(\"".$tpl->get("usercp_buddy_list")."\");");
}

/** ignore list **/
if ($action == 'ignore_list') {
	if (isset($_POST['send'])) {
		$result = getwbbuserdata(addslashes(wbb_trim($_POST['addtolist'])), "username");
		if (!$result['userid']) error($lang->items['LANG_USERCP_ERROR1']);
		elseif ($result['userid'] == $wbbuserdata['userid']) error($lang->items['LANG_USERCP_ERROR2']);
		else {
			if ($result['a_can_be_ignored'] !=1) {
				$ignorelist = add2list($wbbuserdata['ignorelist'], $result['userid']);
				if ($ignorelist != -1) $db->unbuffered_query("UPDATE bb".$n."_users SET ignorelist='$ignorelist' WHERE userid='$wbbuserdata[userid]'", 1);
				header("Location: usercp.php?action=ignore_list".$SID_ARG_2ND_UN);
				exit();
			}else {
			error($lang->items['LANG_USERCP_ERROR3']);
			}
		}
	}

	$listbit = '';
	if ($wbbuserdata['ignorelist'] != '') {
		$result = $db->unbuffered_query("SELECT userid, username FROM bb".$n."_users WHERE userid IN ('".str_replace(" ", "','", $wbbuserdata['ignorelist'])."') ORDER BY username ASC");
		while ($row = $db->fetch_array($result)) {
			$row['username'] = htmlconverter($row['username']);
			eval("\$listbit .= \"".$tpl->get("usercp_ignore_listbit")."\";");
		}
	}

	eval("\$tpl->output(\"".$tpl->get("usercp_ignore_list")."\");");
}





/** add / remove user to / from buddy list **/
if ($action == 'buddy') {
	if ($_GET['remove']) {
		list($userid) = $db->query_first("SELECT userid FROM bb".$n."_users WHERE userid='".intval($_GET['remove'])."'");
		if (!$userid) error($lang->items['LANG_GLOBAL_ERROR2']);
		else {
			$buddylist = removeFromlist($wbbuserdata['buddylist'], $userid);
			if ($buddylist != -1) $db->unbuffered_query("UPDATE bb".$n."_users SET buddylist='$buddylist' WHERE userid='$wbbuserdata[userid]'", 1);
			header("Location: usercp.php?action=buddy_list".$SID_ARG_2ND_UN);
			exit();
		}
	}
	if ($_GET['add']) {
		list($userid) = $db->query_first("SELECT userid FROM bb".$n."_users WHERE userid='".intval($_GET['add'])."'");
		if (!$userid) error($lang->items['LANG_GLOBAL_ERROR2']);
		elseif ($userid == $wbbuserdata['userid']) error($lang->items['LANG_USERCP_ERROR2']);
		else {
			$buddylist = add2list($wbbuserdata['buddylist'], $userid);
			if ($buddylist != -1) $db->unbuffered_query("UPDATE bb".$n."_users SET buddylist='$buddylist' WHERE userid='$wbbuserdata[userid]'", 1);
			header("Location: usercp.php?action=buddy_list".$SID_ARG_2ND_UN);
			exit();
		}
	}
}



/** add / remove user to / from ignore list **/
if ($action == 'ignore') {
	if ($_GET['remove']) {
		list($userid) = $db->query_first("SELECT userid FROM bb".$n."_users WHERE userid='".intval($_GET['remove'])."'");
		if (!$userid) error($lang->items['LANG_GLOBAL_ERROR2']);
		else {
			$ignorelist = removeFromlist($wbbuserdata['ignorelist'], $userid);
			if ($ignorelist != -1) $db->unbuffered_query("UPDATE bb".$n."_users SET ignorelist='$ignorelist' WHERE userid='$wbbuserdata[userid]'", 1);
			header("Location: usercp.php?action=ignore_list".$SID_ARG_2ND_UN);
			exit();
		}
	}
	if ($_GET['add']) {
		$result = getwbbuserdata(intval($_GET['add'], "userid"));
		if (!$result['userid']) error($lang->items['LANG_GLOBAL_ERROR2']);
		elseif ($result['userid'] == $wbbuserdata['userid']) error($lang->items['LANG_USERCP_ERROR2']);
		else {
			if ($result['a_can_be_ignored'] !=1) {
				$ignorelist = add2list($wbbuserdata['ignorelist'], $result['userid']);
				if ($ignorelist != -1) $db->unbuffered_query("UPDATE bb".$n."_users SET ignorelist='$ignorelist' WHERE userid='$wbbuserdata[userid]'", 1);
				header("Location: usercp.php?action=ignore_list".$SID_ARG_2ND_UN);
				exit();
			}else {
			error($lang->items['LANG_USERCP_ERROR3']);
			}
		}
	}
}




/** avatars **/
if ($action == 'avatars') {
	$lang->load('POSTINGS,REGISTER');

	if (isset($_POST['send'])) {
		if ($_POST['avatarid'] != 'useown') {

			if ($_POST['avatarid'] != 0) {
				if ($wbbuserdata['can_use_avatar'] == 0) access_error();
				$result = $db->query_first("SELECT avatarid FROM bb".$n."_avatars WHERE groupid IN(0,".implode(",", $wbbuserdata['groupids']).") AND needposts <= '$wbbuserdata[userposts]' AND userid = 0 AND avatarid='".intval($_POST['avatarid'])."'");
				if (!$result['avatarid']) access_error();
			}

			$oldavatar = $db->query_first("SELECT avatarid, avatarextension FROM bb".$n."_avatars WHERE userid = '$wbbuserdata[userid]'");
			if ($oldavatar['avatarid']) {
				@unlink("./images/avatars/avatar-".$oldavatar['avatarid'].".".$oldavatar['avatarextension']);
				$db->unbuffered_query("DELETE FROM bb".$n."_avatars WHERE avatarid = '$oldavatar[avatarid]'", 1);
			}
			$db->unbuffered_query("UPDATE bb".$n."_users SET avatarid = '".intval($_POST['avatarid'])."' WHERE userid = '$wbbuserdata[userid]'", 1);

			header("Location: usercp.php?action=avatars&page=".intval($_POST['page']).$SID_ARG_2ND_UN);
			exit();
		}
		else {
			$uploaderror = 0;
			if ($_FILES['avatar_file']['tmp_name'] && $_FILES['avatar_file']['tmp_name'] != "none") {
				if ($wbbuserdata['can_use_avatar'] == 0 || $wbbuserdata['can_upload_avatar'] == 0) access_error();
				$badavatar = 0;
				$avatar_file_extension = wbb_strtolower(wbb_substr(strrchr($_FILES['avatar_file']['name'], "."), 1));
				$avatar_file_name2 = wbb_substr($_FILES['avatar_file']['name'], 0, (intval(wbb_strlen($avatar_file_extension)) + 1) * -1);
				$allowed_avatar_extensions = explode("\n", $wbbuserdata['allowed_avatar_extensions']);

				if (in_array($avatar_file_extension, $allowed_avatar_extensions) && $_FILES['avatar_file']['size'] <= $wbbuserdata['max_avatar_size']) { /*  &&  */
					$db->query("INSERT INTO bb".$n."_avatars (avatarname,avatarextension,userid) VALUES ('".addslashes(htmlspecialchars($avatar_file_name2))."','".addslashes(htmlspecialchars($avatar_file_extension))."','$wbbuserdata[userid]')");
					$avatarid = $db->insert_id("bb".$n."_avatars", "avatarid");

					if (move_uploaded_file($_FILES['avatar_file']['tmp_name'], "./images/avatars/avatar-".$avatarid.".".$avatar_file_extension)) {
						@chmod ("./images/avatars/avatar-".$avatarid.".".$avatar_file_extension, 0777);

						$imgsize = @getimagesize("./images/avatars/avatar-".$avatarid.".".$avatar_file_extension);
						$width = $imgsize[0];
						$height = $imgsize[1];
						if ($avatar_file_extension == "swf") {
							if ($width > $wbbuserdata['max_avatar_width']) $width = $wbbuserdata['max_avatar_width'];
							if ($height > $wbbuserdata['max_avatar_height']) $height = $wbbuserdata['max_avatar_height'];
						}

						if ($width > $wbbuserdata['max_avatar_width'] || $height > $wbbuserdata['max_avatar_height'] || !$width || !$height) $badavatar = 2;

						if ($badavatar == 0) {
							$oldavatar = $db->query_first("SELECT avatarid, avatarextension FROM bb".$n."_avatars WHERE userid = '$wbbuserdata[userid]' AND avatarid='$wbbuserdata[avatarid]'");
							if ($oldavatar['avatarid']) {
								@unlink("./images/avatars/avatar-".$oldavatar['avatarid'].".".$oldavatar['avatarextension']);
								$db->unbuffered_query("DELETE FROM bb".$n."_avatars WHERE avatarid = '$oldavatar[avatarid]'", 1);
							}
							$db->unbuffered_query("UPDATE bb".$n."_users SET avatarid='$avatarid' WHERE userid='$wbbuserdata[userid]'", 1);
							$db->unbuffered_query("UPDATE bb".$n."_avatars SET width='$width', height='$height' WHERE avatarid='$avatarid'", 1);
							header("Location: usercp.php?action=avatars&page=$page".$SID_ARG_2ND_UN);
							exit();
						}
					}
					else $badavatar = 1;
					if ($badavatar != 0) {
						if ($badavatar == 2) @unlink("./images/avatars/avatar-".$avatarid.".".$avatar_file_extension);
						$db->query("DELETE FROM bb".$n."_avatars WHERE avatarid='$avatarid'");
						$uploaderror = 1;
					}
				}
				else $uploaderror = 1;
				if ($uploaderror == 1) error($lang->items['LANG_USERCP_AVATAR_ERROR1']);
			}
			elseif (!$havatarid) error($lang->items['LANG_USERCP_AVATAR_ERROR1']);
		}
	}

	if ($wbbuserdata['avatarid'] == 0 || ($wbbuserdata['can_use_avatar'] == 0 && $wbbuserdata['can_upload_avatar'] == 0)) $noavatar_checked = " checked=\"checked\"";
	if ($wbbuserdata['can_use_avatar'] == 1) {
		list($avatarcount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_avatars WHERE groupid IN(0,".implode(",", $wbbuserdata['groupids']).") AND needposts <= '$wbbuserdata[userposts]' AND userid = 0 ORDER BY needposts DESC");
		if ($avatarcount) {
			if (isset($_GET['page'])) {
				$page = intval($_GET['page']);
				if ($page == 0) $page = 1;
			}
			else $page = 1;
			$pages = ceil($avatarcount / $avatarsperpage);
			$result = $db->unbuffered_query("SELECT avatarid, avatarextension, width, height FROM bb".$n."_avatars WHERE groupid IN(0,".implode(",", $wbbuserdata['groupids']).") AND needposts <= '$wbbuserdata[userposts]' AND userid = 0 ORDER BY needposts DESC", 0, $avatarsperpage, $avatarsperpage * ($page - 1));
			while ($row = $db->fetch_array($result)) {
				$avatarname = "images/avatars/avatar-$row[avatarid].".htmlconverter($row['avatarextension']);
				$avatarwidth = $row['width'];
				$avatarheight = $row['height'];
				if ($row['avatarextension'] == "swf") eval("\$avatarchoice = \"".$tpl->get("avatar_flash")."\";");
				else eval("\$avatarchoice = \"".$tpl->get("avatar_image")."\";");

				if ($row['avatarid'] == $wbbuserdata['avatarid']) $checked = " checked=\"checked\"";
				else $checked = '';
				eval("\$avatarArray[] = \"".$tpl->get("usercp_avatarbit")."\";");
			}

			$tableRows = ceil(count($avatarArray) / 5);
			$count = 0;
			for ($i = 0; $i < $tableRows; $i++) {
				$avatarbit_td = '';
				for ($j = 0; $j < 5; $j++) {
					if ($i == 0 && !$avatarArray[$count]) break;
					eval("\$avatarbit_td .= \"".$tpl->get("usercp_avatarbit_td")."\";");
					$count++;
				}
				eval("\$avatarbit_tr .= \"".$tpl->get("usercp_avatarbit_tr")."\";");
			}

			$countfrom = 1 + $avatarsperpage * ($page - 1);
			$countto = $avatarsperpage * $page;
			if ($countto > $avatarcount) $countto = $avatarcount;

			if ($pages > 1) $pagelink = makepagelink("usercp.php?action=avatars".$SID_ARG_2ND, $page, $pages, $showpagelinks - 1);
			$lang->items['LANG_USERCP_AVATAR_COUNT'] = $lang->get("LANG_USERCP_AVATAR_COUNT", array('$countfrom' => $countfrom, '$countto' => $countto, '$avatarcount' => $avatarcount));
		}
	}
	if ($wbbuserdata['can_upload_avatar'] == 1) {
		$ownavatar = $db->query_first("SELECT avatarid, avatarextension, width, height FROM bb".$n."_avatars WHERE userid = '$wbbuserdata[userid]'");

		if ($ownavatar['avatarid']) {
			$avatarname = "images/avatars/avatar-$ownavatar[avatarid].".htmlconverter($ownavatar['avatarextension']);
			$avatarwidth = $ownavatar['width'];
			$avatarheight = $ownavatar['height'];
			$havatar = "<input type=\"hidden\" name=\"havatarid\" value=\"$ownavatar[avatarid]\" />";

			if ($ownavatar['avatarextension'] == "swf") eval("\$ownavatar = \"".$tpl->get("avatar_flash")."\";");
			else eval("\$ownavatar = \"".$tpl->get("avatar_image")."\";");

			$ownavatar_checked = " checked=\"checked\"";
		}
		$lang->items['LANG_USERCP_USE_OWNAVATAR_NOTE'] = $lang->get("LANG_USERCP_USE_OWNAVATAR_NOTE", array('$allowed_avatar_extensions' => getAllowedExtensions($wbbuserdata['allowed_avatar_extensions']), '$max_avatar_width' => $wbbuserdata['max_avatar_width'], '$max_avatar_height' => $wbbuserdata['max_avatar_height'], '$max_avatar_size' => formatFilesize($wbbuserdata['max_avatar_size'])));
	}
	eval("\$tpl->output(\"".$tpl->get("usercp_avatars")."\");");
}


/** subscriptions **/
if ($action == 'addsubscription') {
	if (isset($threadid)) {
		$db->unbuffered_query("INSERT IGNORE INTO bb".$n."_subscribethreads (userid,threadid,emailnotify) VALUES ('$wbbuserdata[userid]','$threadid','1')", 1);
		header("Location: thread.php?threadid=$threadid".$SID_ARG_2ND_UN);
	}
	else if (isset($boardid)) {
		$db->unbuffered_query("INSERT IGNORE INTO bb".$n."_subscribeboards (userid,boardid,emailnotify) VALUES ('$wbbuserdata[userid]','$boardid','1')", 1);
		header("Location: board.php?boardid=$boardid".$SID_ARG_2ND_UN);
	}
	exit();
}

if ($action == 'removesubscription') {
	if (isset($threadid)) $db->unbuffered_query("DELETE FROM bb".$n."_subscribethreads WHERE userid='$wbbuserdata[userid]' AND threadid='$threadid'", 1);
	else if (isset($boardid)) $db->unbuffered_query("DELETE FROM bb".$n."_subscribeboards WHERE userid='$wbbuserdata[userid]' AND boardid='$boardid'", 1);

	header("Location: usercp.php?action=favorites".$SID_ARG_2ND_UN);
	exit();
}


/** favorites **/
if ($action == 'favorites') {
	$lang->load('START,BOARD');
	include("./acp/lib/class_parse.php");
	$favorites = true;
	$depth = 2;

	// read permissions
	$permissioncache = getPermissions();

	$badBoardIDs 	= '';
	$badThreadIDs	= '';

	/** boards **/
	$result = $db->unbuffered_query("
	SELECT
	s.emailnotify, b.*".(($showlastposttitle == 1) ? (", t.topic, i.*") : (""))."
	FROM bb".$n."_subscribeboards s
	LEFT JOIN bb".$n."_boards b USING(boardid)
	".(($showlastposttitle == 1) ? ("LEFT JOIN bb".$n."_threads t ON (t.threadid=b.lastthreadid)
	LEFT JOIN bb".$n."_icons i USING (iconid)") : (""))."
	WHERE s.userid='$wbbuserdata[userid]' AND b.isboard=1
	ORDER by b.title ASC");

	$boardbit = '';
	while ($boards = $db->fetch_array($result)) {
		if (!isset($permissioncache[$boards['boardid']]['can_enter_board']) || $permissioncache[$boards['boardid']]['can_enter_board'] == -1) $permissioncache[$boards['boardid']]['can_enter_board'] = $wbbuserdata['can_enter_board']; 
		if (!isset($permissioncache[$boards['boardid']]['can_view_board']) || $permissioncache[$boards['boardid']]['can_view_board'] == -1) $permissioncache[$boards['boardid']]['can_view_board'] = $wbbuserdata['can_enter_board']; 
		
		if (!$permissioncache[$boards['boardid']]['can_enter_board']) {
			$badBoardIDs .= "," . $boards['boardid'];
			continue;
		}
		
		if ($boards['threadcount']) {
			$lastpostdate = formatdate($wbbuserdata['dateformat'], $boards['lastposttime'], 1);
			$lastposttime = formatdate($wbbuserdata['timeformat'], $boards['lastposttime']);

			$boards['lastposter'] = htmlconverter($boards['lastposter']);

			if ($showlastposttitle == 1) {
				if (wbb_strlen($boards['topic']) > 30) $topic = wbb_substr($boards['topic'], 0, 30)."...";
				else $topic = $boards['topic'];

				$topic = htmlconverter($topic);
				$boards['topic'] = htmlconverter($boards['topic']);

				if (isset($boards['iconid'])) $ViewPosticon = makeimgtag($boards['iconpath'], $boards['icontitle']);
				else $ViewPosticon = makeimgtag($style['imagefolder']."/icons/icon14.gif");
			}
			
			if ($boards['postcount'] >= 1000) $boards['postcount'] = number_format($boards['postcount'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
			if ($boards['threadcount'] >= 1000) $boards['threadcount'] = number_format($boards['threadcount'], 0, "", $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
		}
		
		$onoff = "off";
		
		$boards['title'] = getlangvar($boards['title'], $lang);
		$boards['description'] = getlangvar($boards['description'], $lang, 0); 
		
		eval("\$boardbit .= \"".$tpl->get("index_boardbit")."\";");
	}

	/** threads **/
	if ($wbbuserdata['umaxposts']) $postsperpage = $wbbuserdata['umaxposts'];
	else $postsperpage = $default_postsperpage;

	$board['hotthread_reply'] = $default_hotthread_reply;
	$board['hotthread_view'] = $default_hotthread_view;

	if (isset($_GET['daysprune'])) $daysprune = intval($_GET['daysprune']);
	elseif ($wbbuserdata['daysprune'] != 0) $daysprune = $wbbuserdata['daysprune'];
	else $daysprune = $default_daysprune;
	$d_select[$daysprune] = "selected=\"selected\"";
	if ($daysprune != 1000) {
		if ($daysprune == 1500) $datecute = " AND lastposttime >= '".$wbbuserdata['lastvisit']."'";
		else {
			$tempdate = time() - ($daysprune * 86400);
			$datecute = " AND t.lastposttime >= '".$tempdate."'";
		}
	}
	else $datecute = '';

	if ($showown == 1) {
		$ownuserid = "DISTINCT p.userid,";
		$ownjoin = "LEFT JOIN bb".$n."_posts p ON (t.threadid = p.threadid AND p.userid = '$wbbuserdata[userid]')";
	}
	else {
		$ownuserid = '';
		$ownjoin = '';
	}

	$threadids = '';
	$result = $db->unbuffered_query("SELECT t.threadid FROM bb".$n."_subscribethreads s LEFT JOIN bb".$n."_threads t USING(threadid) WHERE s.userid='$wbbuserdata[userid]' AND t.visible = 1 $datecute ORDER BY t.lastposttime DESC");
	while ($row = $db->fetch_array($result)) $threadids .= ",".$row['threadid'];

	$result = $db->unbuffered_query("SELECT
	$ownuserid
	t.*,
	i.*, bv.lastvisit AS boardlastvisit, tv.lastvisit AS threadlastvisit
	FROM bb".$n."_threads t
	LEFT JOIN bb".$n."_icons i USING (iconid)
	LEFT JOIN bb".$n."_boards b ON (b.boardid=t.boardid)
	LEFT JOIN bb".$n."_boardvisit bv ON (bv.boardid=b.boardid AND bv.userid='".$wbbuserdata['userid']."')
	LEFT JOIN bb".$n."_threadvisit tv ON (tv.threadid=t.threadid AND tv.userid='".$wbbuserdata['userid']."')
	$ownjoin
	WHERE t.threadid IN (0$threadids)
	ORDER BY t.lastposttime DESC");

	$threadbit = '';
	while ($threads = $db->fetch_array($result)) {
		if (!isset($permissioncache[$threads['boardid']]['can_enter_board']) || $permissioncache[$threads['boardid']]['can_enter_board'] == -1) $permissioncache[$threads['boardid']]['can_enter_board'] = $wbbuserdata['can_enter_board']; 
				
		if (!$permissioncache[$threads['boardid']]['can_enter_board']) {
			$badThreadIDs .= "," . $threads['threadid'];
			continue;
		}

		$firstnew = 0;
		$multipages = '';
		$attachments = '';
		$prefix = '';

		if ($threads['boardlastvisit'] > $threads['threadlastvisit']) $threads['threadlastvisit'] = $threads['boardlastvisit'];
		if ($wbbuserdata['lastvisit'] > $threads['threadlastvisit']) $threads['threadlastvisit'] = $wbbuserdata['lastvisit'];

		$threads['topic'] = htmlconverter(textwrap($threads['topic']));
		$threads['starter'] = htmlconverter(textwrap($threads['starter'], 25));
		$threads['lastposter'] = htmlconverter(textwrap($threads['lastposter'], 25));
		$threads['prefix'] = htmlconverter($threads['prefix']);

		if ($threads['pollid'] != 0) $foldericon = "poll";
		else $foldericon = (($threads['userid']) ? ("dot") : ("")).(($threads['lastposttime'] > $threads['threadlastvisit']) ? ("new") : ("")).(($threads['replycount'] >= $board['hotthread_reply'] || $threads['views'] >= $board['hotthread_view']) ? ("hot") : ("")).(($threads['closed'] != 0) ? ("lock") : (""))."folder";
		if ($threads['lastposttime'] > $threads['threadlastvisit']) $firstnew = 1;
		if ($threads['iconid']) $threadicon = makeimgtag($threads['iconpath'], $threads['icontitle']);
		else $threadicon = "&nbsp;";

		$lastpostdate = formatdate($wbbuserdata['dateformat'], $threads['lastposttime'], 1);
		$lastposttime = formatdate($wbbuserdata['timeformat'], $threads['lastposttime']);

		if ($threads['replycount'] + 1 > $postsperpage && $showmultipages != 0) {
			unset($multipage);
			unset($multipages_lastpage);
			$xpages = ceil(($threads['replycount'] + 1) / $postsperpage);
			if ($xpages > $showmultipages) {
				eval("\$multipages_lastpage = \"".$tpl->get("board_threadbit_multipages_lastpage")."\";");
				$xpages = $showmultipages;
			}
			for ($i = 1; $i <= $xpages; $i++) $multipage .= " ".makehreftag("thread.php?threadid=".$threads['threadid']."&amp;page=$i" . $SID_ARG_2ND, $i);
			eval("\$multipages = \"".$tpl->get("board_threadbit_multipages")."\";");
		}
		
		if ($threads['replycount'] >= 1000) $threads['replycount'] = number_format($threads['replycount'], 0, '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
		if ($threads['views'] >= 1000) $threads['views'] = number_format($threads['views'], 0, '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
	
		eval("\$threadbit .= \"".$tpl->get("board_threadbit")."\";");
	}

	// delete bad threads & boards
	if ($badThreadIDs != '') $db->query("DELETE FROM bb".$n."_subscribethreads WHERE threadid IN (0".$badThreadIDs.")");
	if ($badBoardIDs != '') $db->query("DELETE FROM bb".$n."_subscribeboards WHERE boardid IN (0".$badBoardIDs.")");

	if (!$threadbit) $lang->items['LANG_USERCP_FAVORITES_NO_NEWPOSTS'] = $lang->get("LANG_USERCP_FAVORITES_NO_NEWPOSTS", array('$daysprune' => $daysprune));
	eval("\$tpl->output(\"".$tpl->get("usercp_favorites")."\");");
}
















/** attachments **/
if ($action == 'attachments') {
	$pmmaxrecipientlistsize = 10;
	list($attachmentCount) = $db->query_first("SELECT COUNT(*) as attachmentCount FROM bb".$n."_attachments WHERE userid='$wbbuserdata[userid]' AND (postid <> 0 OR privatemessageid <> 0)");
	list($total_attachment_filesize) = $db->query_first("SELECT (SUM(attachmentsize) + SUM(thumbnailsize)) as total_attachment_filesize FROM bb".$n."_attachments WHERE userid='$wbbuserdata[userid]' AND (postid <> 0 OR privatemessageid <> 0)");
	
	$LANG_USERCP_ATTACHMENTS_STORAGE_USED = $lang->get('LANG_USERCP_ATTACHMENTS_STORAGE_USED', array('$attachmentCount' => number_format($attachmentCount, 0, '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP")), '$total_attachment_filesize' => formatFilesize($total_attachment_filesize)));
	if ($wbbuserdata['total_attachment_filesize_limit'] > 0) {
		$temp = $total_attachment_filesize / $wbbuserdata['total_attachment_filesize_limit'];
		if (($percent = round($temp * 100)) > 100) {
			$percent = 100;
			$temp = 1;
		}
		$percent2 = 100 - $percent;
		
		$quota_free = formatFilesize(($wbbuserdata['total_attachment_filesize_limit'] > $total_attachment_filesize) ? ($wbbuserdata['total_attachment_filesize_limit'] - $total_attachment_filesize) : (0));
		$LANG_USERCP_ATTACHMENTS_STORAGE_FREE = $lang->get('LANG_USERCP_ATTACHMENTS_STORAGE_FREE', array('$quota_free' => $quota_free));
	}
	else $LANG_USERCP_ATTACHMENTS_STORAGE_FREE = '';
	
	if ($wbbuserdata['umaxposts']) $perpage = $wbbuserdata['umaxposts'];
	else $perpage = $default_postsperpage;
	if (isset($_REQUEST['page'])) $page = intval($_REQUEST['page']);
	else $page = 1;
	$pages = ceil($attachmentCount / $perpage);
	if ($page < 1 || $page > $pages) $page = 1;
	if ($pages > 1) $pagelink = makepagelink("usercp.php?action=attachments".$SID_ARG_2ND, $page, $pages, $showpagelinks - 1);
	else $pagelink = '';
	
	$moderatorInfos = array();
	$result = $db->query("SELECT *, userid as moderatorid FROM bb".$n."_moderators WHERE userid='$wbbuserdata[userid]'");
	while ($row = $db->fetch_array($result)) $moderatorInfos[$row['boardid']] = $row;
	
	$attachmentbit = '';
	$result = $db->query("SELECT at.*, p.posttopic, p.posttime, t.boardid, t.threadid, t.topic, t.prefix, t.closed, b.title, ".
	"pm.subject, pm.sendtime, pm.recipientlist, pm.recipientcount, pm.inoutbox ".
	"FROM bb".$n."_attachments at ".
	"LEFT JOIN bb".$n."_posts p USING (postid) ".
	"LEFT JOIN bb".$n."_threads t USING (threadid) ".
	"LEFT JOIN bb".$n."_boards b USING (boardid) ".
	"LEFT JOIN bb".$n."_privatemessage pm ON (pm.privatemessageid=at.privatemessageid) ".
	"WHERE at.userid='$wbbuserdata[userid]' AND (at.postid <> 0 OR at.privatemessageid <> 0) ".
	"ORDER BY at.uploadtime DESC", $perpage, $perpage * ($page - 1));
	while ($row = $db->fetch_array($result)) {
		$undeleteable = false;
		$row['attachmentname'] = htmlconverter($row['attachmentname']);
		$row['attachmentextension'] = htmlconverter($row['attachmentextension']);
		$row['prefix'] = htmlconverter($row['prefix']);
		if ($row['postid']) {
			$ismod = 0;
			if (checkmodpermissions('m_can_post_edit', $moderatorInfos[$row['boardid']]) == 1) $ismod = 1;
			if (!checkpermissions("can_enter_board", $wbbuserdata['permissions'][$row['boardid']])) continue;
			if ($ismod == 0 && ($row['closed'] == 1 || !checkpermissions('can_edit_own_post', $wbbuserdata['permissions'][$row['boardid']]))) $undeleteable = true;	
			if ($ismod == 0 && ($wbbuserdata['edit_posttime_limit'] != -1 && (time() - $row['posttime']) > $wbbuserdata['edit_posttime_limit'] * 60)) $undeleteable = true;
			
			$row['topic'] = htmlconverter($row['topic']);
			$row['posttopic'] = $row['posttopic'] != '' ? htmlconverter($row['posttopic']) : $row['topic'];
			$row['title'] = getlangvar($row['title'], $lang);
			$postdate = formatdate($wbbuserdata['dateformat'], $row['posttime'], 1);
			$posttime = formatdate($wbbuserdata['timeformat'], $row['posttime']);
		}
		else {
			$undeleteable = true;
			$row['subject'] = htmlconverter($row['subject']);
			$row['recipientlist'] = unserialize($row['recipientlist']);
			$recipients = '';
			foreach ($row['recipientlist'] as $recipient) {
				$recipient = htmlconverter($recipient);
				if ($recipients != '') $recipients .= ', '.$recipient;
				else $recipients = $recipient;
			}
			if ($row['recpientcount'] > $pmmaxrecipientlistsize) $recipients .= ', ...';
			$senddate = formatdate($wbbuserdata['dateformat'], $row['sendtime'], 1);
			$sendtime = formatdate($wbbuserdata['timeformat'], $row['sendtime']);
		}
		
		if (file_exists($style['imagefolder'].'/filetypes/'.$row['attachmentextension'].'.gif')) $extensionimage = $row['attachmentextension'];
		else $extensionimage = 'unknown';

		$uploaddate = formatdate($wbbuserdata['dateformat'], $row['uploadtime'], 1);
		$uploadtime = formatdate($wbbuserdata['timeformat'], $row['uploadtime']);
		$attachmentsize = formatFilesize($row['attachmentsize']);
		if ($row['counter'] >= 1000) $row['counter'] = number_format($row['counter'], 0, '', $lang->get("LANG_GLOBAL_THOUSANDS_SEP"));
		$LANG_USERCP_ATTACHMENTS_ATTACHMENTINFO = $lang->get('LANG_USERCP_ATTACHMENTS_ATTACHMENTINFO', array('$attachmentname' => $row['attachmentname'], '$attachmentextension' => $row['attachmentextension'], '$attachmentsize' => $attachmentsize, '$counter' => $row['counter']));
		eval("\$attachmentbit .= \"".$tpl->get("usercp_attachmentbit")."\";");
	}
	
	eval("\$tpl->output(\"".$tpl->get("usercp_attachments")."\");");
}






/** delete attachments **/
if ($action == 'del_attachments') {
	if (isset($_POST['attachmentids']) && is_array($_POST['attachmentids'])) $attachmentids = implode(',', intval_array($_POST['attachmentids']));	
	else $attachmentids = '';
	
	if ($attachmentids != '') {
		$moderatorInfos = array();
		$result = $db->query("SELECT *, userid as moderatorid FROM bb".$n."_moderators WHERE userid='$wbbuserdata[userid]'");
		while ($row = $db->fetch_array($result)) $moderatorInfos[$row['boardid']] = $row;
	
		$result = $db->query("SELECT at.attachmentid, at.attachmentextension, at.thumbnailextension, ".
		"t.threadid, t.boardid, t.closed ".
		"FROM bb".$n."_attachments at ".
		"LEFT JOIN bb".$n."_posts p USING (postid) ".
		"LEFT JOIN bb".$n."_threads t USING (threadid) ".
		"WHERE at.attachmentid IN ($attachmentids) AND at.userid='$wbbuserdata[userid]' AND at.privatemessageid='0'");
		$attachmentids = '';
		while ($row = $db->fetch_array($result)) {
			$ismod = 0;
			if (checkmodpermissions('m_can_post_edit', $moderatorInfos[$row['boardid']]) == 1) $ismod = 1;
			if (!checkpermissions("can_enter_board", $wbbuserdata['permissions'][$row['boardid']])) continue;
			if ($ismod == 0 && ($row['closed'] == 1 || !checkpermissions('can_edit_own_post', $wbbuserdata['permissions'][$row['boardid']]))) continue;
			if ($ismod == 0 && ($wbbuserdata['edit_posttime_limit'] != -1 && (time() - $row['posttime']) > $wbbuserdata['edit_posttime_limit'] * 60)) continue;

			$attachmentids .= ",$row[attachmentid]";
			@unlink('./attachments/attachment-'.$row['attachmentid'].'.'.$row['attachmentextension']);
			@unlink('./attachments/thumbnail-'.$row['attachmentid'].'.'.$row['thumbnailextension']);
		}
		$result = $db->unbuffered_query("DELETE FROM bb".$n."_attachments WHERE attachmentid IN (0$attachmentids) AND userid='$wbbuserdata[userid]' AND privatemessageid=0");
	}
	
	header("Location: usercp.php?action=attachments{$SID_ARG_2ND}");
	exit;
}
?>
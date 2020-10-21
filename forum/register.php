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


$filename = 'register.php';

require('./global.php');
$lang->load('REGISTER');

/* register activation */
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'activation') {
	$action = $_REQUEST['action'];
	if (isset($_REQUEST['usrid']) && isset($_REQUEST['a'])) {
		$result = getwbbuserdata(intval($_REQUEST['usrid']));	
		if (!$result['userid']) error($lang->get("LANG_GLOBAL_ERROR2"));
		if ($result['activation'] == 1) error($lang->get("LANG_REGISTER_ACTIVATION_ERROR1"));
		if ($result['activation'] != intval($_REQUEST['a'])) error($lang->get("LANG_REGISTER_ACTIVATION_ERROR2"));
		
		list($oldgroupid) = $db->query_first("SELECT groupid FROM bb".$n."_groups WHERE grouptype=2");
		while (list($key, $val) = each($result['groupids'])) {
			if ($val == $oldgroupid) {
				unset($result['groupids'][$key]);
				break;
			}	
		}
		
		$db->unbuffered_query("UPDATE bb".$n."_users SET activation=1, groupcombinationid='".cachegroupcombinationdata(implode(",", $result['groupids']), 0)."' WHERE userid='".$result['userid']."'", 1);
		$db->unbuffered_query("DELETE FROM bb".$n."_user2groups WHERE userid='".$result['userid']."' AND groupid='".$oldgroupid."'", 1);
		
		$result['username'] = htmlconverter($result['username']);
		redirect($lang->get("LANG_REGISTER_ACTIVATION_REDIRECT1", array('$username' => $result['username'])), "index.php".$SID_ARG_1ST, 10);
	}	
	else eval("\$tpl->output(\"".$tpl->get("register_activation")."\");");
	exit;
}

if ($wbbuserdata['userid'] != 0) access_error();
if ($allowregister != 1) error($lang->get("LANG_REGISTER_ERROR_DISABLED"));
if ($showdisclaimer == 1 && (!isset($_POST['disclaimer']) || $_POST['disclaimer'] != "viewed")) {
	$lang->items['LANG_REGISTER_DISCLAIMER'] = $lang->get("LANG_REGISTER_DISCLAIMER", array('$master_board_name' => $master_board_name));
	eval("\$tpl->output(\"".$tpl->get("register_disclaimer")."\");");
	exit;
}
else {
	if (isset($_POST['disclaimer'])) $disclaimer = $_POST['disclaimer'];
	$register_error = '';
	$lang->load('POSTINGS');
	
	$sdaysprune = array(0 => '', 1 => '', 2 => '', 5 => '', 10 => '', 20 => '', 30 => '', 45 => '', 60 => '', 75 => '', 100 => '', 365 => '', 1000 => '', 1500 => '');
	$sumaxposts = array(0 => '', 5 => '', 10 => '', 20 => '', 30 => '', 40 => '');
	$gender = array(0 => '', 1 => '', 2 => '');
	$invisible = array(0 => '', 1 => '');
	$usecookies = array(0 => '', 1 => '');
	$admincanemail = array(0 => '', 1 => '');
	$showemail = array(0 => '', 1 => '');
	$usercanemail = array(0 => '', 1 => '');
	$emailnotify = array(0 => '', 1 => '');
	$receivepm = array(0 => '', 1 => '');
	$emailonpm = array(0 => '', 1 => '');
	$spmpopup = array(0 => '', 1 => '');
	$showsignatures = array(0 => '', 1 => '');
	$showavatars = array(0 => '', 1 => '');
	$showimages = array(0 => '', 1 => '');
	$sthreadview = array(0 => '', 1 => '');
	
	if ($emailverifymode == 1 || $emailverifymode == 2) {
		$wbbuserdata = getwbbuserdata(2, "grouptype", 1);
		list($groupid) = $db->query_first("SELECT groupid FROM bb".$n."_groups WHERE grouptype=4");
	}
	else {
		$wbbuserdata = getwbbuserdata(4, "grouptype", 1);
		$groupid = $wbbuserdata['groupid'];
	}
	
	if (isset($_POST['send'])) {
		/* signature feature rights:start */
		if (!$wbbuserdata['can_use_sig_smilies'] || (isset($_POST['disablesmilies']) && $_POST['disablesmilies'] == 1)) $allowsmilies = 0;
		else $allowsmilies = 1;	
		
		if (!$wbbuserdata['can_use_sig_html'] || (isset($_POST['disablehtml']) && $_POST['disablehtml'] == 1)) $allowhtml = 0;
		else $allowhtml = 1;	
		
		if (!$wbbuserdata['can_use_sig_bbcode'] || (isset($_POST['disablebbcode']) && $_POST['disablebbcode'] == 1)) $allowbbcode = 0;
		else $allowbbcode = 1;	
		
		if (!$wbbuserdata['can_use_sig_images'] || (isset($_POST['disableimages']) && $_POST['disableimages'] == 1)) $allowimages = 0;
		else $allowimages = 1;	
		/* signature feature rights:end */
		
		$lang->load('MAIL');
		
		if (isset($_POST['field']) && is_array($_POST['field'])) $field = trim_array($_POST['field']);
		if (isset($_POST['dayfield']) && is_array($_POST['dayfield'])) $dayfield = trim_array($_POST['dayfield']);
		if (isset($_POST['monthfield']) && is_array($_POST['monthfield'])) $monthfield = trim_array($_POST['monthfield']);
		if (isset($_POST['yearfield']) && is_array($_POST['yearfield'])) $yearfield = trim_array($_POST['yearfield']);
		
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
		if (isset($_POST['r_username'])) $r_username = wbb_trim($_POST['r_username']);
		if (isset($_POST['r_password'])) $r_password = wbb_trim($_POST['r_password']);
		if (isset($_POST['r_confirmpassword'])) $r_confirmpassword = wbb_trim($_POST['r_confirmpassword']);
		if (isset($_POST['r_signature'])) $r_signature = wbb_trim($_POST['r_signature']);
		
		if (isset($_POST['r_invisible'])) $r_invisible = $_POST['r_invisible'];
		if (isset($_POST['r_usecookies'])) $r_usecookies = $_POST['r_usecookies'];
		if (isset($_POST['r_admincanemail'])) $r_admincanemail = $_POST['r_admincanemail'];
		if (isset($_POST['r_showemail'])) $r_showemail = $_POST['r_showemail'];
		if (isset($_POST['r_usercanemail'])) $r_usercanemail = $_POST['r_usercanemail'];
		if (isset($_POST['r_emailnotify'])) $r_emailnotify = $_POST['r_emailnotify'];
		if (isset($_POST['r_receivepm'])) $r_receivepm = $_POST['r_receivepm'];
		if (isset($_POST['r_emailonpm'])) $r_emailonpm = $_POST['r_emailonpm'];
		if (isset($_POST['r_pmpopup'])) $r_pmpopup = $_POST['r_pmpopup'];
		if (isset($_POST['r_showsignatures'])) $r_showsignatures = $_POST['r_showsignatures'];
		if (isset($_POST['r_showavatars'])) $r_showavatars = $_POST['r_showavatars'];
		if (isset($_POST['r_showimages'])) $r_showimages = $_POST['r_showimages'];
		if (isset($_POST['r_daysprune'])) $r_daysprune = $_POST['r_daysprune'];
		if (isset($_POST['r_umaxposts'])) $r_umaxposts = $_POST['r_umaxposts'];
		if (isset($_POST['r_threadview'])) $r_threadview = $_POST['r_threadview'];
		if (isset($_POST['r_dateformat'])) $r_dateformat = wbb_trim($_POST['r_dateformat']);
		if (isset($_POST['r_timeformat'])) $r_timeformat = wbb_trim($_POST['r_timeformat']);
		if (isset($_POST['r_startweek'])) $r_startweek = $_POST['r_startweek'];
		if (isset($_POST['r_timezoneoffset'])) $r_timezoneoffset = $_POST['r_timezoneoffset'];
		if (isset($_POST['r_styleid'])) $r_styleid = $_POST['r_styleid'];
		if (isset($_POST['r_langid'])) $r_langid = $_POST['r_langid'];
		if (isset($_POST['r_usewysiwyg'])) $r_usewysiwyg = wbb_trim($_POST['r_usewysiwyg']);
		
		$r_username = preg_replace("/\s{2,}/", " ", $r_username);
		
		$error = '';
		$userfield_error = 0;
		$fieldvalues = '';
		$fieldlist = '';
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
			
			$fieldlist .= ",field".$row['profilefieldid'];
			if ($row['fieldtype'] == "multiselect") {
				if (isset($field[$row['profilefieldid']]) && is_array($field[$row['profilefieldid']])) {
					if ($row['choicecount'] && count($field[$row['profilefieldid']]) > $row['choicecount']) {
						$max = count($field[$row['profilefieldid']]);
						for ($i = $row['choicecount']; $i < $max; $i++) unset($field[$row['profilefieldid']][$i]);
					}
					
					$fieldvalues .= ",'".addslashes(wbb_trim(implode("\n", $field[$row['profilefieldid']])))."'";
					
				}
				else $fieldvalues .= ",''";
			}
			elseif ($row['fieldtype'] == "date") {
				if ($dayfield[$row['profilefieldid']] && $monthfield[$row['profilefieldid']]) $datefield = ((wbb_strlen($yearfield[$row['profilefieldid']]) == 4) ? ($yearfield[$row['profilefieldid']]) : (((wbb_strlen($yearfield[$row['profilefieldid']]) == 2) ? ("19".$yearfield[$row['profilefieldid']]) : ("0000"))))."-".(($monthfield[$row['profilefieldid']] < 10) ? ("0".$monthfield[$row['profilefieldid']]) : ($monthfield[$row['profilefieldid']]))."-".(($dayfield[$row['profilefieldid']] < 10) ? ("0".$dayfield[$row['profilefieldid']]) : ($dayfield[$row['profilefieldid']]));
				else $datefield = "0000-00-00";
				$fieldvalues .= ",'".addslashes($datefield)."'";
			}
			else $fieldvalues .= ",'".addslashes($field[$row['profilefieldid']])."'";
		}
		
		if ($userfield_error == 1 || !$r_username || !$r_email || ($emailverifymode != 3 && (!$r_password || !$r_confirmpassword))) $error .= $lang->items['LANG_POSTINGS_ERROR1'];
		if ($emailverifymode != 3 && $r_password != $r_confirmpassword) $error .= $lang->items['LANG_REGISTER_ERROR1'];
		if (!verify_username($r_username)) $error .= $lang->items['LANG_REGISTER_ERROR2'];
		if (!verify_email($r_email)) $error .= $lang->items['LANG_REGISTER_ERROR3'];
		if (wbb_strlen($r_signature) > $wbbuserdata['max_sig_length']) $error .= $lang->items['LANG_REGISTER_ERROR4'];
		if ($wbbuserdata['max_sig_image'] != -1 && wbb_substr_count(wbb_strtolower($r_signature), "[img]") > $wbbuserdata['max_sig_image']) $error .= $lang->items['LANG_REGISTER_ERROR5'];
		if (wbb_strlen($r_usertext) > $wbbuserdata['max_usertext_length']) $error .= $lang->items['LANG_REGISTER_ERROR6'];
		if ($error) eval("\$register_error = \"".$tpl->get("register_error")."\";");
		else {
			if ($emailverifymode == 3) $r_password = password_generate();
			if ($emailverifymode == 1 || $emailverifymode == 2) $activation = code_generate();
			else $activation = 1;
			
			if ($r_homepage && !preg_match("/[a-zA-Z]:\/\//si", $r_homepage)) $r_homepage = "http://".$r_homepage;  
			if ($r_day && $r_month && $r_year) $birthday = ((wbb_strlen($r_year) == 4) ? ($r_year) : (((wbb_strlen($r_year) == 2) ? ("19$r_year") : ("0000"))))."-".(($r_month < 10) ? ("0$r_month") : ($r_month))."-".(($r_day < 10) ? ("0$r_day") : ($r_day));
			else $birthday = "0000-00-00";
			
			if ($emailverifymode == 1 || $emailverifymode == 2) {
				if ($groupid > $wbbuserdata['groupid']) $groupids = $wbbuserdata['groupid'] . "," . $groupid;
				else $groupids = $groupid . "," . $wbbuserdata['groupid'];
			}
			else $groupids = $wbbuserdata['groupid'];
			
			$groupcombinationid = cachegroupcombinationdata($groupids, 0);
			
			$rankid = $db->query_first("SELECT rankid FROM bb".$n."_ranks WHERE groupid IN ('0','$groupid') AND needposts='0' AND gender IN ('0','".intval($r_gender)."') ORDER BY gender DESC", 1);
			
			if (!$r_dateformat) $r_dateformat = $dateformat;
			if (!$r_timeformat) $r_timeformat = $timeformat;
			
			$db->query("INSERT INTO bb".$n."_users (username,password,sha1_password,email,groupcombinationid,rankid,regdate,lastvisit,lastactivity,usertext,signature,icq,aim,yim,msn,homepage,birthday,gender,showemail,admincanemail,usercanemail,invisible,usecookies,styleid,activation,daysprune,timezoneoffset,startweek,dateformat,timeformat,emailnotify,notificationperpm,receivepm,emailonpm,pmpopup,umaxposts,showsignatures,showavatars,showimages,threadview,langid,rankgroupid,useronlinegroupid,allowsigsmilies,allowsightml,allowsigbbcode,allowsigimages,usewysiwyg) ".
			"VALUES ('".addslashes($r_username)."','".md5($r_password)."', '".sha1($r_password)."', '".addslashes($r_email)."','$groupcombinationid','$rankid[rankid]','".time()."','".time()."','".time()."','".addslashes($r_usertext)."','".addslashes($r_signature)."','".intval($r_icq)."','".addslashes($r_aim)."','".addslashes($r_yim)."','".addslashes($r_msn)."','".addslashes($r_homepage)."','".addslashes($birthday)."','".intval($r_gender)."','".intval($r_showemail)."','".intval($r_admincanemail)."','".intval($r_usercanemail)."','".intval($r_invisible)."','".intval($r_usecookies)."','".intval($r_styleid)."','".intval($activation)."','".intval($r_daysprune)."','".addslashes($r_timezoneoffset)."','".intval($r_startweek)."','".addslashes($r_dateformat)."','".addslashes($r_timeformat)."','".intval($r_emailnotify)."','".intval($r_notificationperpm)."','".intval($r_receivepm)."','".intval($r_emailonpm)."','".intval($r_pmpopup)."','".intval($r_umaxposts)."','".intval($r_showsignatures)."','".intval($r_showavatars)."','".intval($r_showimages)."','".intval($r_threadview)."','".intval($r_langid)."','$groupid','$groupid','$allowsmilies','$allowhtml','$allowbbcode','$allowimages','".intval($r_usewysiwyg)."')");
			$insertid = $db->insert_id();
			$db->query("INSERT INTO bb".$n."_userfields (userid".$fieldlist.") VALUES (".$insertid.$fieldvalues.")");
			
			$db->query("INSERT INTO bb".$n."_user2groups (userid,groupid) SELECT '$insertid' as userid,groupid FROM bb".$n."_groups WHERE grouptype='4'");   
			if ($emailverifymode == 1 || $emailverifymode == 2) $db->query("INSERT INTO bb".$n."_user2groups (userid,groupid) SELECT '$insertid' as userid,groupid FROM bb".$n."_groups WHERE grouptype='2'");
			
			/* update global usercount & lastuserid */
			$db->unbuffered_query("UPDATE bb".$n."_stats SET usercount=usercount+1, lastuserid='".$insertid."'", 1);
			
			if ($regnotify == 1) {
				if ($session['langid'] != 0) {
					$adminLang = &new language(0);
					$adminLang->load('OWN,MAIL');
				}
				else $adminLang =& $lang;
								
				$master_board_name_email = getlangvar($o_master_board_name, $adminLang, 0);
				
				$subject = $adminLang->get("LANG_MAIL_REGNOTIFY_SUBJECT", array('$master_board_name_email' => $master_board_name_email));
				$content = $adminLang->get("LANG_MAIL_REGNOTIFY_TEXT", array('$master_board_name_email' => $master_board_name_email, '$r_username' => $r_username));
				mailer($webmastermail, $subject, $content);	
			}
			
			if ($emailverifymode == 0 || $emailverifymode == 1 || $emailverifymode == 2) {
				if ($r_usecookies == 1) {
					bbcookie("userid", "$insertid", time() + 3600 * 24 * 365);
					bbcookie("userpassword", md5($r_password), time() + 3600 * 24 * 365);
				}
				$db->query("UPDATE bb".$n."_sessions SET userid = '".$insertid."', styleid='".intval($r_styleid)."', langid='".intval($r_langid)."' WHERE sessionhash = '$sid'"); 
				
				if ($emailverifymode == 0) {
					header("Location: index.php".$SID_ARG_1ST);
					exit;
				}
			}
			if ($emailverifymode == 1) {
				$master_board_name_email = getlangvar($o_master_board_name, $lang, 0);
				
				$subject = $lang->get("LANG_MAIL_REGISTER1_SUBJECT", array('$master_board_name_email' => $master_board_name_email));
				$content = $lang->get("LANG_MAIL_REGISTER1_TEXT", array('$master_board_name_email' => $master_board_name_email, '$r_username' => $r_username, '$url2board' => $url2board, '$insertid' => $insertid, '$activation' => $activation, '$webmastermail' => $webmastermail));
				mailer($r_email, $subject, $content);
				
				$r_username = htmlconverter($r_username);
				redirect($lang->get("LANG_REGISTER_REDIRECT1", array('$r_username' => $r_username, '$r_email' => $r_email)), "index.php".$SID_ARG_1ST, 20);
			}
			if ($emailverifymode == 2) {
				$r_username = htmlconverter($r_username);
				redirect($lang->get("LANG_REGISTER_REDIRECT2", array('$r_username' => $r_username)), "index.php".$SID_ARG_1ST, 20);
			}
			if ($emailverifymode == 3) {
				$master_board_name_email = getlangvar($o_master_board_name, $lang, 0);
				
				$subject = $lang->get("LANG_MAIL_REGISTER3_SUBJECT", array('$master_board_name_email' => $master_board_name_email));
				$content = $lang->get("LANG_MAIL_REGISTER3_TEXT", array('$master_board_name_email' => $master_board_name_email, '$r_username' => $r_username, '$url2board' => $url2board, '$r_password' => $r_password, '$webmastermail' => $webmastermail));
				mailer($r_email, $subject, $content);
				
				$r_username = htmlconverter($r_username);
				redirect($lang->get("LANG_REGISTER_REDIRECT3", array('$r_username' => $r_username, '$r_email' => $r_email)), "index.php".$SID_ARG_1ST, 20);
			}
		}
		
		/* checkbox select */
		if (isset($_POST['disablesmilies']) && $_POST['disablesmilies'] == 1) $checked[0] = "checked=\"checked\"";
		else $checked[0] = '';
		if (isset($_POST['disablehtml']) && $_POST['disablehtml'] == 1) $checked[1] = "checked=\"checked\"";
		else $checked[1] = '';
		if (isset($_POST['disablebbcode']) && $_POST['disablebbcode'] == 1) $checked[2] = "checked=\"checked\"";
		else $checked[2] = '';
		if (isset($_POST['disableimages']) && $_POST['disableimages'] == 1) $checked[3] = "checked=\"checked\"";
		else $checked[3] = '';
	}
	else {
		$r_invisible		= $default_register_invisible;
		$r_usecookies		= $default_register_usecookies;
		$r_admincanemail	= $default_register_admincanemail;
		$r_showemail		= 1 - $default_register_showemail;
		$r_usercanemail		= $default_register_usercanemail;
		$r_emailnotify		= $default_register_emailnotify;
		$r_notificationperpm	= $default_register_notificationperpm;
		$r_receivepm		= $default_register_receivepm;
		$r_emailonpm		= $default_register_emailonpm;
		$r_pmpopup		= $default_register_pmpopup;
		$r_showsignatures	= $default_register_showsignatures;
		$r_showavatars		= $default_register_showavatars;
		$r_showimages		= $default_register_showimages;
		$r_threadview		= $default_register_threadview;
		$r_timezoneoffset	= $default_timezoneoffset;
		$r_startweek		= $default_startweek;
		$r_dateformat		= $dateformat;
		$r_timeformat		= $timeformat;
		$r_day			= 0;
		$r_month		= 0;
		$r_password		= '';
		$r_confirmpassword	= '';
		$r_icq			= '';
		$r_year			= 0;
		$r_username		= '';
		$r_email		= '';
		$r_homepage		= '';
		$r_yim			= '';
		$r_aim			= '';
		$r_msn			= '';
		$r_signature		= '';
		$r_usertext		= '';
		$r_styleid		= 0;
		$r_usewysiwyg		= $default_register_usewysiwyg;
		if (isset($session['langid'])) $r_langid = $session['langid'];
		else $r_langid = 0;
		
		/* checkbox preselect */
		if ($register_default_checked_0 == 1) $checked[0] = 'checked="checked"';
		else $checked[0] = '';
		if ($register_default_checked_1 == 1) $checked[1] = 'checked="checked"';
		else $checked[1] = '';
		if ($register_default_checked_2 == 1) $checked[2] = 'checked="checked"';
		else $checked[2] = '';
		if ($register_default_checked_3 == 1) $checked[3] = 'checked="checked"';
		else $checked[3] = '';
	}
	
	$day_options = '';
	for ($i = 1; $i <= 31; $i++) $day_options .= makeoption($i, $i, $r_day);
	
	$month_options = '';
	for ($i = 1; $i <= 12; $i++) $month_options .= makeoption($i, getmonth($i), $r_month);
	
	$startweek_options = '';
	for ($i = 0; $i < 7; $i++) $startweek_options .= makeoption($i, getday($i), $r_startweek);
	
	if (isset($r_gender)) $gender[$r_gender]					= ' selected="selected"';
	if (isset($r_invisible)) $invisible[$r_invisible]				= ' selected="selected"';
	if (isset($r_usecookies)) $usecookies[$r_usecookies]				= ' selected="selected"';
	if (isset($r_admincanemail)) $admincanemail[$r_admincanemail]			= ' selected="selected"';
	if (isset($r_showemail)) $showemail[$r_showemail]				= ' selected="selected"';
	if (isset($r_usercanemail)) $usercanemail[$r_usercanemail]			= ' selected="selected"';
	if (isset($r_emailnotify)) $emailnotify[$r_emailnotify]				= ' selected="selected"';
	if (isset($r_notificationperpm)) $notificationperpm[$r_notificationperpm]	= ' selected="selected"';
	if (isset($r_receivepm)) $receivepm[$r_receivepm]				= ' selected="selected"';
	if (isset($r_emailonpm)) $emailonpm[$r_emailonpm]				= ' selected="selected"';
	if (isset($r_pmpopup)) $spmpopup[$r_pmpopup]					= ' selected="selected"';
	if (isset($r_showsignatures)) $showsignatures[$r_showsignatures]		= ' selected="selected"';
	if (isset($r_showavatars)) $showavatars[$r_showavatars]				= ' selected="selected"';
	if (isset($r_showimages)) $showimages[$r_showimages]				= ' selected="selected"';
	if (isset($r_daysprune)) $sdaysprune[$r_daysprune]				= ' selected="selected"';
	if (isset($r_umaxposts)) $sumaxposts[$r_umaxposts]				= ' selected="selected"';
	if (isset($r_threadview)) $sthreadview[$r_threadview]				= ' selected="selected"';
	if (isset($r_usewysiwyg)) $usewysiwyg[$r_usewysiwyg] 				= ' selected="selected"';
	
	/* timezones */
	$timezone_options = '';
	$timezones = explode("\n", $lang->items['LANG_REGISTER_TIMEZONES']);
	for ($i = 0; $i < count($timezones); $i++) {
		$parts = explode("|", wbb_trim($timezones[$i]));  
		$timezone_options .= makeoption($parts[0], "(GMT".(($parts[1]) ? (" ".$parts[1]) : ("")).") $parts[2]", $r_timezoneoffset);
	}
	$z = 1;
	$y = (($emailverifymode != 3) ? (0) : (1));
	
	/* profilefields */
	$profilefields_required = '';
	$profilefields = '';
	$result = $db->unbuffered_query("SELECT * FROM bb".$n."_profilefields ORDER BY fieldorder ASC");
	while ($row = $db->fetch_array($result)) {
		$field_value = '';
		$field_checked = '';
		$dayfield_value = '';
		$monthfield_value = '';
		$yearfield_value = '';
		if (!isset($field[$row['profilefieldid']])) $field[$row['profilefieldid']] = '';
		
		switch ($row['fieldtype']) {
			case "text":
			$field_value = htmlconverter($field[$row['profilefieldid']]);
			break;
			
			case "select":
			$row_options = explode("\n", $row['fieldoptions']);
			$field_value = "<option value=\"\"></option>\n";
			foreach ($row_options as $option) $field_value .= makeoption(wbb_trim($option), wbb_trim($option), $field[$row['profilefieldid']]);
			break;
			
			case "multiselect":
			$row_options = explode("\n", $row['fieldoptions']);
			if (isset($_POST['send']) && is_array($field[$row['profilefieldid']]) && count($field[$row['profilefieldid']])) $selected_options = $field[$row['profilefieldid']];
			else $selected_options = array();
			foreach ($row_options as $option) $field_value .= makeoption(wbb_trim($option), wbb_trim($option), ((in_array(wbb_trim($option), $selected_options)) ? (wbb_trim($option)) : ("")));
			break;
			
			case "checkbox":
			$field_value = $row['fieldoptions'];
			$field_checked = (($field_value == $field[$row['profilefieldid']]) ? (" checked=\"checked\"") : (""));
			break;
			
			case "date":
			$year_tmp = $yearfield[$row['profilefieldid']];
			$month_tmp = $monthfield[$row['profilefieldid']];
			$day_tmp = $dayfield[$row['profilefieldid']];
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
	
	/* styles */
	$style_options = '';
	$result = $db->unbuffered_query("SELECT styleid, stylename FROM bb".$n."_styles ORDER BY stylename ASC");
	while ($row = $db->fetch_array($result)) $style_options .= makeoption($row['styleid'], getlangvar($row['stylename'], $lang), $r_styleid);
	
	/* language packs */
	$lang_options = '';
	$result = $db->unbuffered_query("SELECT languagepackid, languagepackname FROM bb".$n."_languagepacks ORDER BY languagepackname ASC");
	while ($row = $db->fetch_array($result)) $lang_options .= makeoption($row['languagepackid'], getlangvar($row['languagepackname'], $lang), $r_langid);
	
	/* signature notes */
	$note = '';
	if ($wbbuserdata['can_use_sig_html'] == 0) $note .= $lang->items['LANG_POSTINGS_HTML_NOT_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_HTML_ALLOW'];
	if ($wbbuserdata['can_use_sig_bbcode'] == 0) $note .= $lang->items['LANG_POSTINGS_BBCODE_NOT_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_BBCODE_ALLOW'];
	if ($wbbuserdata['can_use_sig_smilies'] == 0) $note .= $lang->items['LANG_POSTINGS_SMILIES_NOT_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_SMILIES_ALLOW'];
	if ($wbbuserdata['can_use_sig_images'] == 0) $note .= $lang->items['LANG_POSTINGS_HTML_IMAGES_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_IMAGES_ALLOW'];
	
	$r_email = htmlconverter($r_email);
	$r_homepage = htmlconverter($r_homepage);
	$r_icq = intval($r_icq);
	$r_aim = htmlconverter($r_aim);
	$r_yim = htmlconverter($r_yim);
	$r_msn = htmlconverter($r_msn);
	$r_year = htmlconverter($r_year);
	$r_gender = htmlconverter($r_gender);
	$r_usertext = htmlconverter($r_usertext);
	$r_username = htmlconverter($r_username);
	$r_password = htmlconverter($r_password);
	$r_confirmpassword = htmlconverter($r_confirmpassword);
	$r_signature = htmlconverter($r_signature);
	
	if (!$r_icq) $r_icq = '';
	if ($r_year == "0000") $r_year = '';
	
	eval("\$tpl->output(\"".$tpl->get("register")."\");"); 
}
?>
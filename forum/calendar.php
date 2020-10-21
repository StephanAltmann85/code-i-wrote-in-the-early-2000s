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


$filename = 'calendar.php';

require('./global.php');
require('./acp/lib/class_parse.php');
require('./acp/lib/class_parsecode.php');
$lang->load('CALENDAR');

if ($wbbuserdata['can_view_calendar'] == 0) access_error();


$startofweek = intval($wbbuserdata['startweek']);

/**
* returns the daynumber of an unix timestamp
*
* @param integer timestamp
*
* @return integer daynumber
*/
function daynumber($time) {
	global $startofweek;
	$daynumber = intval(date('w', $time)) - $startofweek;
	if ($daynumber < 0) $daynumber = 7 + $daynumber;
	return $daynumber;
}


if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = '';
	




// view calendar
if ($action == '') {
	
	$today_day = formatdate('j', time());
	$today_month = formatdate('n', time());
	$today_year = formatdate('Y', time());
	
	if (isset($_GET['month'])) $month = intval($_GET['month']);
	else $month = 0;
	if (isset($_GET['year'])) $year = intval($_GET['year']);
	else $year = 0;
	if (!$month || $month < 1 || $month > 12) $month = $today_month;
	if (!$year || $year < 1970) $year = $today_year;
	$countdays = 1;
	$monthname = getmonth($month);
	
	if ($month == 1) {
		$prev_month = 12;
		$prev_year = $year - 1;
		$prev_monthname = getmonth($prev_month);
	}
	else {
		$prev_month = $month - 1;
		$prev_year = $year;
		$prev_monthname = getmonth($prev_month);
	}
	if ($month == 12) {
		$next_month = 1;
		$next_year = $year + 1;
		$next_monthname = getmonth($next_month);
	}
	else {
		$next_month = $month + 1;
		$next_year = $year;
		$next_monthname = getmonth($next_month);
	}
	
	$result = $db->unbuffered_query("SELECT userid, username, birthday FROM bb".$n."_users WHERE birthday LIKE '%-".(($month < 10) ? ("0") : (""))."$month-%' ORDER BY username ASC");
	if ($listallbirthdays == 1) {
		while ($row = $db->fetch_array($result)) $birthdaycache[intval(wbb_substr($row['birthday'], 8))][] = $row;
	}
	else {
		while ($row = $db->fetch_array($result)) {
			
			$tempday = intval(wbb_substr($row['birthday'], 8));
			if (isset($birthdaycount[$tempday])) $birthdaycount[$tempday]++;
			else $birthdaycount[$tempday] = 1;
		}	
	}
	
	$currentmonth = "$year-".(($month < 10) ? ("0") : (""))."$month";
	$result = $db->unbuffered_query("SELECT eventid, subject, eventdate, public FROM bb".$n."_events WHERE eventdate LIKE '$currentmonth-%' AND (public=2 OR (public=0 AND userid = '$wbbuserdata[userid]')) ORDER BY public ASC, subject ASC");
	while ($row = $db->fetch_array($result)) $eventcache[intval(wbb_substr($row['eventdate'], 8))][] = $row;
	
	$j = 0;
	for ($i = 0; $i < 7; $i++) {
		$dayid = $j + $startofweek;
		$daynames[$i] = getday($dayid);
		if ($dayid == 6 && $i != 6) $j = $startofweek * -1;
		else $j++;
	}
	
	$yearbits = '';
	for ($i = $today_year - 1; $i < $today_year + 4; $i++) $yearbits .= makeoption($i , $i , '', 0);
	
	while (checkdate($month, $countdays, $year)) $countdays++;
	
	$day = 1;
	$weeknumber = ceil((date('z', mktime(0, 0, 0, $month, $day, $year)) - daynumber(mktime(0, 0, 0, $month, $day, $year))) / 7) + ((daynumber(mktime(0, 0, 0, 1, 1, $year)) <= 3) ? (1) : (0));
	
	$day_bits = '';
	while ($day < $countdays) {
		$events = '';
		$week = '';
		
		$daynumber = daynumber(mktime(0, 0, 0, $month, $day, $year));
		if ($day == 1 && $daynumber > 0) $day_bits .= str_repeat('<td class="mainpage">&nbsp;</td>', $daynumber);
		
		$events = '';
		if (isset($eventcache[$day]) && is_array($eventcache[$day]) && count($eventcache[$day])) {
			while (list($key, $event) = each($eventcache[$day])) {
				$event['subject'] = htmlconverter($event['subject']);
				eval("\$events .= \"".$tpl->get("calendar_event")."\";");
			}
		}
		
		if ($listallbirthdays == 1) {
			if (count($birthdaycache[$day])) {
				while (list($key, $birthday) = each($birthdaycache[$day])) {
					$birthday['username'] = htmlconverter($birthday['username']);
					$age = $year - wbb_substr($birthday['birthday'], 0, 4);
					if ($age < 1 || $age > 200) $age = '';
					else $age = "&nbsp;($age)";
					eval("\$events .= \"".$tpl->get("calendar_birthday")."\";");
				}
			}
		}
		elseif (isset($birthdaycount[$day]) && $birthdaycount[$day]) eval("\$events .= \"".$tpl->get("calendar_birthdays")."\";");
		
		eval("\$day_bits .= \"".$tpl->get("calendar_daybits")."\";");
		
		if ($day + 1 == $countdays) {
			if ($daynumber < 6) $day_bits .= str_repeat('<td class="mainpage">&nbsp;</td>', 6 - $daynumber).'</tr>';
			else $day_bits .= '</tr>';
		}
		elseif ($daynumber == 6) {
			$day_bits .= '</tr><tr>';
			$weeknumber++;
	
			if ($weeknumber == 53 && daynumber(mktime(0, 0, 0, 12, 31, $year)) < 3) $weeknumber = 1;
		}
		$day++;
	}
	
	$month_options = '';
	for ($i = 1; $i < 13; $i++) $month_options .= makeoption($i, getmonth($i), '', 0);
	
	eval("\$tpl->output(\"".$tpl->get("calendar_view")."\");");
}







// view event
if ($action == 'viewevent') {
	if (isset($_GET['id'])) $eventid = intval($_GET['id']);	
	else error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
	
	$event = $db->query_first("SELECT e.*, u.username FROM bb".$n."_events e LEFT JOIN bb".$n."_users u USING (userid) WHERE eventid='$eventid'");
	if (!$event['eventid']) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
	if (($event['public'] == 0 && $event['userid'] != $wbbuserdata['userid'])) access_error();	
	
	$parse			= &new parse($docensor, 90, $wbbuserdata['showimages'], '', $usecode);
	$event['event']		= $parse->doparse($event['event'], $event['allowsmilies'], $event['allowhtml'], $event['allowbbcode'], $event['allowimages']);
	$event['subject']	= htmlconverter(textwrap($event['subject']));
	$event['username']	= htmlconverter($event['username']);
	$eventDateArray		= explode('-', $event['eventdate']);
	$eventdate		= formatdate($wbbuserdata['dateformat'], gmmktime(0, 0, 0, $eventDateArray[1], $eventDateArray[2], $eventDateArray[0])); 
	
	eval("\$tpl->output(\"".$tpl->get("calendar_viewevent")."\");");
}





// view birthdays
if ($action == 'viewbirthdays') {
	if (isset($_GET['day'])) $eventdate = explode('-', $_GET['day']);
	else error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
	
	$eventdate[0] = intval($eventdate[0]);
	$eventdate[1] = intval($eventdate[1]);
	$eventdate[2] = intval($eventdate[2]);
	
	if ($eventdate[1] == 0 || $eventdate[2] == 0) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
	
	$currentdate = (($eventdate[1] < 10) ? ('0') : ('')).$eventdate[1].'-'.(($eventdate[2] < 10) ? ('0') : ('')).$eventdate[2];
	$result = $db->unbuffered_query("SELECT userid, username, birthday FROM bb".$n."_users WHERE birthday LIKE '%-$currentdate' ORDER BY username ASC");
	while ($row = $db->fetch_array($result)) {
		$row['username'] = htmlconverter($row['username']);
		$birthyear = intval(wbb_substr($row['birthday'], 0, 4));
		$age = $eventdate[0] - $birthyear;
		if ($age < 1 || $age > 200) $age = '';
		else $age = "&nbsp;($age)";
		if (isset($birthdaybit)) eval("\$birthdaybit .= \"".$tpl->get("index_birthdaybit")."\";");
		else eval("\$birthdaybit = \"".$tpl->get("index_birthdaybit")."\";");
	}

	$eventdate = formatdate($wbbuserdata['dateformat'], gmmktime(0, 0, 0, $eventdate[1], $eventdate[2], $eventdate[0])); 
	
	eval("\$tpl->output(\"".$tpl->get("calendar_viewbirthdays")."\");");
}











// add event
if ($action == 'addevent') {
	$lang->load('POSTINGS');
	if (isset($_REQUEST['type'])) $type = $_REQUEST['type'];
	else $type = 'private';
	
	$event_error	= '';
	$subject	= '';
	$message	= '';
	$checked	= array('', '', '', '', '');
	
	if ($type != 'private') $type = 'public';
	if (($type == 'public' && $wbbuserdata['can_public_event'] == 0) || ($type == 'private' && $wbbuserdata['can_private_event'] == 0)) access_error();
	
	if (isset($_POST['send'])) {
		// post options
		if (isset($_POST['parseurl'])) $parseurl = intval($_POST['parseurl']);
		else $parseurl = 0;
		if (isset($_POST['disablesmilies'])) $disablesmilies = intval($_POST['disablesmilies']);
		else $disablesmilies = 0;
		if (isset($_POST['disablehtml'])) $disablehtml = intval($_POST['disablehtml']);
		else $disablehtml = 0;
		if (isset($_POST['disablebbcode'])) $disablebbcode = intval($_POST['disablebbcode']);
		else $disablebbcode = 0;
		if (isset($_POST['disableimages'])) $disableimages = intval($_POST['disableimages']);
		else $disableimages = 0;
		
		/* posting feature rights:start */
		if (!$wbbuserdata['can_use_event_smilies'] || $disablesmilies == 1) $allowsmilies = 0;
		else $allowsmilies = 1;	
		
		if (!$wbbuserdata['can_use_event_html'] || $disablehtml == 1) $allowhtml = 0;
		else $allowhtml = 1;	
		
		if (!$wbbuserdata['can_use_event_bbcode'] || $disablebbcode == 1) $allowbbcode = 0;
		else $allowbbcode = 1;	
		
		if (!$wbbuserdata['can_use_event_images'] || $disableimages == 1) $allowimages = 0;
		else $allowimages = 1;	
		/* posting feature rights:end */
		
		if ($parseurl == 1) $checked[0]		= 'checked="checked"';
		if ($disablesmilies == 1) $checked[1]	= 'checked="checked"';	
		if ($disablehtml == 1) $checked[2]	= 'checked="checked"';	
		if ($disablebbcode == 1) $checked[3]	= 'checked="checked"';	
		if ($disableimages == 1) $checked[4]	= 'checked="checked"';	
		
		$day = intval($_POST['day']);
		$month = intval($_POST['month']);
		$year = intval($_POST['year']);	
		
		$subject = wbb_trim($_POST['subject']);
		$message = stripcrap(wbb_trim($_POST['message']));
		if (wbb_strlen($message) > $eventmaxchars) $message = wbb_substr($message, 0, $eventmaxchars);
			
		$error = '';
		
		if (!$_POST['change_editor']) {
			if (!$subject || !$message) $error .= $lang->items['LANG_POST_ERROR1'];
			if (!checkdate($month, $day, $year)) $error .= $lang->items['LANG_CALENDAR_ERROR1'];
			if ($error) eval("\$event_error = \"".$tpl->get("newthread_error")."\";");
			else {
				if ($parseurl == 1) $message = parseURL($message);
				
				if ($type == 'public') $public = 2;
				else $public = 0;
			
				$eventdate = $year.'-'.(($month < 10) ? ('0') : ('')).$month.'-'.(($day < 10) ? ('0') : ('')).$day;
			
				$db->unbuffered_query("INSERT INTO bb".$n."_events (userid,subject,event,eventdate,public,allowsmilies,allowhtml,allowbbcode,allowimages) VALUES ('$wbbuserdata[userid]','".addslashes($subject)."','".addslashes($message)."','$eventdate','$public','$allowsmilies','$allowhtml','$allowbbcode','$allowimages')", 1);	
				header("Location: calendar.php".$SID_ARG_1ST);
				exit();
			}
		}
	}
	else {
		if ($event_default_checked_0 == 1) $checked[0] = 'checked="checked"';
		if ($event_default_checked_1 == 1) $checked[1] = 'checked="checked"';
		if ($event_default_checked_2 == 1) $checked[2] = 'checked="checked"';
		if ($event_default_checked_3 == 1) $checked[3] = 'checked="checked"';
		if ($event_default_checked_4 == 1) $checked[4] = 'checked="checked"';
	}
	
	if ($wbbuserdata['can_use_event_bbcode'] && $wbbuserdata['usewysiwyg'] != 1) $bbcode_buttons = getcodebuttons();
	if ($wbbuserdata['can_use_event_smilies']) {
		if ($wbbuserdata['usewysiwyg'] == 1) $smilies = getAppletSmilies();
		$bbcode_smilies = getclickysmilies($smilie_table_cols, $smilie_table_rows);
	}
	
	if (!isset($day)) $day = formatdate('j', time());
	if (!isset($month)) $month = formatdate('n', time());
	$current_year = formatdate('Y', time());
	if (!isset($year)) $year = $current_year;
	
	$day_options = '';
	$month_options = '';
	$year_options = '';
	for ($i = 1; $i < 32; $i++) $day_options .= makeoption($i, $i, $day, 1);
	for ($i = 1; $i < 13; $i++) $month_options .= makeoption($i, getmonth($i), $month, 1);
	for ($i = $current_year; $i < $current_year + 5; $i++) $year_options .= makeoption($i, $i, $year, 1);
	
	$note = '';
	if ($wbbuserdata['can_use_event_html'] == 0) $note .= $lang->items['LANG_POSTINGS_HTML_NOT_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_HTML_ALLOW'];
	if ($wbbuserdata['can_use_event_bbcode'] == 0) $note .= $lang->items['LANG_POSTINGS_BBCODE_NOT_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_BBCODE_ALLOW'];
	if ($wbbuserdata['can_use_event_smilies'] == 0) $note .= $lang->items['LANG_POSTINGS_SMILIES_NOT_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_SMILIES_ALLOW'];
	if ($wbbuserdata['can_use_event_images'] == 0) $note .= $lang->items['LANG_POSTINGS_HTML_IMAGES_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_IMAGES_ALLOW'];
	
	if (isset($message)) $message = htmlconverter($message);
	if (isset($subject)) $subject = htmlconverter($subject);
	
	eval("\$headinclude .= \"".$tpl->get("bbcode_script")."\";");
	eval("\$editor = \"".$tpl->get("editor")."\";");
	eval("\$editor_switch = \"".$tpl->get("editor_switch")."\";");
	eval("\$tpl->output(\"".$tpl->get("calendar_addevent")."\");");
}









// edit event
if ($action == 'editevent') {
	if (isset($_REQUEST['id'])) $id = intval($_REQUEST['id']);	
	else error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
	$lang->load("POSTINGS");
	

	$event_error	= '';
	$checked	= array('', '', '', '', '');
	
	$event = $db->query_first("SELECT * FROM bb".$n."_events WHERE eventid='$id'");
	if ($event['userid'] != $wbbuserdata['userid'] && ($event['public'] != 2 || $wbbuserdata['can_edit_public_event'] == 0)) access_error();
	if (isset($_POST['send'])) {
		// post options
		if (isset($_POST['parseurl'])) $parseurl = intval($_POST['parseurl']);
		else $parseurl = 0;
		if (isset($_POST['disablesmilies'])) $disablesmilies = intval($_POST['disablesmilies']);
		else $disablesmilies = 0;
		if (isset($_POST['disablehtml'])) $disablehtml = intval($_POST['disablehtml']);
		else $disablehtml = 0;
		if (isset($_POST['disablebbcode'])) $disablebbcode = intval($_POST['disablebbcode']);
		else $disablebbcode = 0;
		if (isset($_POST['disableimages'])) $disableimages = intval($_POST['disableimages']);
		else $disableimages = 0;
		
		if (isset($_POST['deleteevent']) && $_POST['deleteevent'] == 1) {
			$db->unbuffered_query("DELETE FROM bb".$n."_events WHERE eventid='$id'", 1);	
			header("Location: calendar.php".$SID_ARG_1ST);
			exit();	
		}
		
		/* posting feature rights:start */
		if (!$wbbuserdata['can_use_event_smilies'] || (isset($_POST['disablesmilies']) && $_POST['disablesmilies'] == 1)) $allowsmilies = 0;
		else $allowsmilies = 1;	
		
		if (!$wbbuserdata['can_use_event_html'] || (isset($_POST['disablehtml']) && $_POST['disablehtml'] == 1)) $allowhtml = 0;
		else $allowhtml = 1;	
		
		if (!$wbbuserdata['can_use_event_bbcode'] || (isset($_POST['disablebbcode']) && $_POST['disablebbcode'] == 1)) $allowbbcode = 0;
		else $allowbbcode = 1;	
		
		if (!$wbbuserdata['can_use_event_images'] || (isset($_POST['disableimages']) && $_POST['disableimages'] == 1)) $allowimages = 0;
		else $allowimages = 1;	
		/* posting feature rights:end */
		
		
		if ($parseurl == 1) $checked[0]		= 'checked="checked"';
		if ($disablesmilies == 1) $checked[1]	= 'checked="checked"';	
		if ($disablehtml == 1) $checked[2]	= 'checked="checked"';	
		if ($disablebbcode == 1) $checked[3]	= 'checked="checked"';	
		if ($disableimages == 1) $checked[4]	= 'checked="checked"';	
		
		$day = intval($_POST['day']);
		$month = intval($_POST['month']);
		$year = intval($_POST['year']);	
		
		$subject = wbb_trim($_POST['subject']);
		$message = stripcrap(wbb_trim($_POST['message']));
		if (wbb_strlen($message) > $eventmaxchars) $message = wbb_substr($message, 0, $eventmaxchars);
		
		$error = '';
		
		if (!$_POST['change_editor']) {
			if (!$subject || !$message) $error .= $lang->items['LANG_POST_ERROR1'];
			if (!checkdate($month, $day, $year)) $error .= $lang->items['LANG_CALENDAR_ERROR1'];
			if ($error) eval("\$event_error = \"".$tpl->get("newthread_error")."\";");
			else {
				$eventdate = $year.'-'.(($month < 10) ? ('0') : ('')).$month.'-'.(($day < 10) ? ('0') : ('')).$day;
			
				if ($parseurl == 1) $message = parseURL($message);
			
				$db->unbuffered_query("UPDATE bb".$n."_events SET subject='".addslashes($subject)."', event='".addslashes($message)."', eventdate='$eventdate', allowsmilies='$allowsmilies', allowhtml='$allowhtml', allowbbcode='$allowbbcode', allowimages='$allowimages' WHERE eventid='$id'", 1);
				header("Location: calendar.php".$SID_ARG_1ST);
				exit();	
			}
		}
	}
	else {
		$temp = explode('-', $event['eventdate']);
		$day = intval($temp[2]);	
		$month = intval($temp[1]);
		$year = intval($temp[0]);
		$subject = $event['subject'];
		$message = $event['event'];
		
		if ($event_default_checked_0 == 1) $checked[0]	= 'checked="checked"';
		if ($event['allowsmilies'] == 0) $checked[1]	= 'checked="checked"';
		if ($event['allowhtml'] == 0) $checked[2]	= 'checked="checked"';
		if ($event['allowbbcode'] == 0) $checked[3]	= 'checked="checked"';
		if ($event['allowimages'] == 0) $checked[4]	= 'checked="checked"';
	}
	
	if ($wbbuserdata['can_use_event_bbcode'] && $wbbuserdata['usewysiwyg'] != 1) $bbcode_buttons = getcodebuttons();
	if ($wbbuserdata['can_use_event_smilies']) {
		if ($wbbuserdata['usewysiwyg'] == 1) $smilies = getAppletSmilies();
		$bbcode_smilies = getclickysmilies($smilie_table_cols, $smilie_table_rows);
	}
	
	$current_year = formatdate('Y', time());
	
	$day_options = '';
	$month_options = '';
	$year_options = '';
	for ($i = 1; $i < 32; $i++) $day_options .= makeoption($i, $i, $day, 1);
	for ($i = 1; $i < 13; $i++) $month_options .= makeoption($i, getmonth($i), $month, 1);
	for ($i = $current_year; $i < $current_year + 5; $i++) $year_options .= makeoption($i, $i, $year, 1);
	
	$note = '';
	if ($wbbuserdata['can_use_event_html'] == 0) $note .= $lang->items['LANG_POSTINGS_HTML_NOT_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_HTML_ALLOW'];
	if ($wbbuserdata['can_use_event_bbcode'] == 0) $note .= $lang->items['LANG_POSTINGS_BBCODE_NOT_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_BBCODE_ALLOW'];
	if ($wbbuserdata['can_use_event_smilies'] == 0) $note .= $lang->items['LANG_POSTINGS_SMILIES_NOT_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_SMILIES_ALLOW'];
	if ($wbbuserdata['can_use_event_images'] == 0) $note .= $lang->items['LANG_POSTINGS_HTML_IMAGES_ALLOW'];
	else $note .= $lang->items['LANG_POSTINGS_IMAGES_ALLOW'];
	
	if (isset($message)) $message = htmlconverter($message);
	if (isset($subject)) $subject = htmlconverter($subject);
	
	eval("\$headinclude .= \"".$tpl->get("bbcode_script")."\";");
	eval("\$editor = \"".$tpl->get("editor")."\";");
	eval("\$editor_switch = \"".$tpl->get("editor_switch")."\";");
	eval("\$tpl->output(\"".$tpl->get("calendar_editevent")."\");");
}









// eventcalendar
if ($action == 'eventcalendar') {
	
	$today_day = formatdate('j', time());
	$today_month = formatdate('n', time());
	$today_year = formatdate('Y', time());
	
	$result = $db->query("SELECT
	SUBSTRING(e.eventdate,1,4) AS year,
	SUBSTRING(e.eventdate,6,2) AS month,
	SUBSTRING(e.eventdate,9,2) AS day,
	e.*, u.username
	FROM bb".$n."_events e
	LEFT JOIN bb".$n."_users u USING(userid)
	WHERE SUBSTRING(e.eventdate,1,4)='$today_year' AND (public=2 OR (e.public=0 AND e.userid = '$wbbuserdata[userid]'))
	ORDER BY month ASC, day ASC, e.subject ASC");	
	
	$monthbit = '';
	$eventbit = '';
	$lastmonth = 0;
	$parse = &new parse($docensor, 90, $wbbuserdata['showimages'], '', $usecode);
	while ($row = $db->fetch_array($result)) {
		if ($lastmonth != 0 && $lastmonth != $row['month']) {
			$monthname = getmonth($lastmonth);
			eval("\$monthbit .= \"".$tpl->get("calendar_monthbit")."\";");	
			$eventbit = '';
		}
		$row['event'] = $parse->doparse($row['event'], $row['allowsmilies'], $row['allowhtml'], $row['allowbbcode'], $row['allowimages']);
		$row['subject'] = htmlconverter(textwrap($row['subject']));
		$row['username'] = htmlconverter($row['username']);
		
		$dayname = getday(date('w', mktime(0, 0, 0, $row['month'], $row['day'], $row['year'])));
		eval("\$eventbit .= \"".$tpl->get("calendar_eventbit")."\";");
		$lastmonth = $row['month'];
	}
	
	if ($lastmonth != 0) {
		$monthname = getmonth($lastmonth);
		eval("\$monthbit .= \"".$tpl->get("calendar_monthbit")."\";");	
	}
	eval("\$tpl->output(\"".$tpl->get("calendar_events")."\");");
}
?>
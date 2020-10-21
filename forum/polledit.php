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
// * $Date: 2004-10-20 13:24:57 +0200 (Wed, 20 Oct 2004) $
// * $Author: Burntime $
// * $Rev: 1453 $
// ************************************************************************************//


$filename = 'polledit.php';
require('./global.php');

if (!isset($pollid)) error($lang->get("LANG_GLOBAL_ERROR_FALSELINK", array('$adminmail' => $adminmail)));
if (isset($_REQUEST['idhash'])) $idhash = $_REQUEST['idhash'];
else $idhash = '';
if ($idhash != '' && $idhash == $thread['idhash']) {
	if (!checkpermissions('can_post_poll')) access_error();
}
else {
	if (!checkmodpermissions('m_can_edit_poll')) access_error();	
}
$lang->load('POLL');

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = '';
if (isset($_REQUEST['polloptionid'])) $polloptionid = intval($_REQUEST['polloptionid']);
else $polloptionid = 0;

if ($action == 'polldelete') {
	if (isset($_POST['deletepoll']) && $_POST['deletepoll'] == 1) {
		$db->unbuffered_query("DELETE FROM bb".$n."_polls WHERE pollid='$pollid'", 1);	
		$db->unbuffered_query("DELETE FROM bb".$n."_polloptions WHERE pollid='$pollid'", 1);	
		$db->unbuffered_query("DELETE FROM bb".$n."_votes WHERE id='$pollid' AND votemode='1'", 1);	
		$db->unbuffered_query("UPDATE bb".$n."_threads SET pollid='0' WHERE pollid='$pollid'", 1);
		
		if ($idhash != '') {
			$pollid = '';
			eval("\$tpl->output(\"".$tpl->get("pollstart_give_parent")."\");");
		}	
		else {
			eval("\$tpl->output(\"".$tpl->get("polledit_reloadthread")."\");");
		}
		exit;
	}	
}

if ($action == 'ShiftToTop' && $polloptionid) {
	list($showorder) = $db->query_first("SELECT showorder FROM bb".$n."_polloptions WHERE polloptionid='$polloptionid'");
	if ($showorder > 1) {
		$db->query("UPDATE bb".$n."_polloptions SET showorder=showorder+1 WHERE pollid='$pollid' AND showorder<'$showorder'");	
		$db->query("UPDATE bb".$n."_polloptions SET showorder=1 WHERE polloptionid='$polloptionid'");	
	}
}

if ($action == 'ShiftUp' && $polloptionid) {
	list($showorder) = $db->query_first("SELECT showorder FROM bb".$n."_polloptions WHERE polloptionid='$polloptionid'");
	if ($showorder > 1) {
		$db->query("UPDATE bb".$n."_polloptions SET showorder=showorder+1 WHERE pollid='$pollid' AND showorder='".($showorder - 1)."'");	
		$db->query("UPDATE bb".$n."_polloptions SET showorder=showorder-1 WHERE polloptionid='$polloptionid'");
	}
}

if ($action == 'ShiftDown' && $polloptionid) {
	list($optioncount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_polloptions WHERE pollid='$pollid'");
	list($showorder) = $db->query_first("SELECT showorder FROM bb".$n."_polloptions WHERE polloptionid='$polloptionid'");
	if ($showorder < $optioncount) {
		$db->query("UPDATE bb".$n."_polloptions SET showorder=showorder-1 WHERE pollid='$pollid' AND showorder='".($showorder + 1)."'");	
		$db->query("UPDATE bb".$n."_polloptions SET showorder=showorder+1 WHERE polloptionid='$polloptionid'");	
	}
}

if ($action == 'ShiftToBottom' && $polloptionid) {
	list($optioncount) = $db->query_first("SELECT COUNT(*) FROM bb".$n."_polloptions WHERE pollid='$pollid'");
	list($showorder) = $db->query_first("SELECT showorder FROM bb".$n."_polloptions WHERE polloptionid='$polloptionid'");
	if ($showorder < $optioncount) {
		$db->query("UPDATE bb".$n."_polloptions SET showorder=showorder-1 WHERE pollid='$pollid' AND showorder>'$showorder'");	
		$db->query("UPDATE bb".$n."_polloptions SET showorder='$optioncount' WHERE polloptionid='$polloptionid'");	
	}
}

if ($action == 'delentry' && $polloptionid) {
	list($showorder) = $db->query_first("SELECT showorder FROM bb".$n."_polloptions WHERE polloptionid='$polloptionid'");
	$db->query("DELETE FROM bb".$n."_polloptions WHERE polloptionid='$polloptionid'");
	$db->query("UPDATE bb".$n."_polloptions SET showorder=showorder-1 WHERE pollid='$pollid' AND showorder>'$showorder'");
}

if ($action == 'addentry') {
	list($showorder) = $db->query_first("SELECT MAX(showorder) FROM bb".$n."_polloptions WHERE pollid='$pollid'");
	$db->query("INSERT INTO bb".$n."_polloptions (polloptionid,pollid,polloption,votes,showorder) VALUES (NULL,'$pollid','".addslashes($_REQUEST['option'])."','0','".($showorder + 1)."')");	
}

if ($action == 'saveentry' && $polloptionid) {
	$db->query("UPDATE bb".$n."_polloptions SET polloption='".addslashes($_REQUEST['option'])."' WHERE polloptionid='$polloptionid'");
}

if ($action == 'savepoll') {
	$db->unbuffered_query("UPDATE bb".$n."_polls SET question='".addslashes($_REQUEST['question'])."', choicecount='".addslashes($_REQUEST['choicecount'])."', timeout='".addslashes($_REQUEST['timeout'])."' WHERE pollid='$pollid'");	
	if ($idhash != '') {
		eval("\$tpl->output(\"".$tpl->get("pollstart_give_parent")."\");");
	}
	else {
		eval("\$tpl->output(\"".$tpl->get("polledit_reloadthread")."\");");
	}
	exit();
}

if (!$action) {
	$question = $poll['question'];
	$choicecount = $poll['choicecount'];
	$timeout = $poll['timeout'];
}
else {
	$question = $_REQUEST['question'];
	$choicecount = intval($_REQUEST['choicecount']);
	$timeout = intval($_REQUEST['timeout']);
}

$question = htmlconverter($question);

$result = $db->query("SELECT * FROM bb".$n."_polloptions WHERE pollid='$pollid' ORDER BY showorder ASC");
while ($row = $db->fetch_array($result)) $polloptions .= makeoption($row['polloptionid'], htmlconverter($row['polloption']), $polloptionid);


$poll['topic'] = htmlconverter(textwrap($poll['topic']));

eval("\$tpl->output(\"".$tpl->get("polledit")."\");");
?>
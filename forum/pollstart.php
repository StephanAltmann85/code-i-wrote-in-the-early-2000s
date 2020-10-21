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


$filename = 'pollstart.php';
require('./global.php');
$lang->load('POLL');

if (isset($_REQUEST['idhash'])) {
	$idhash = $_REQUEST['idhash'];	
}
else {
	$idhash = '';	
}

if (!checkpermissions('can_post_poll') || !$idhash) {
	eval("\$tpl->output(\"".$tpl->get("window_close")."\");");
	exit();
}

// check if 
list ($pollid) = $db->query_first("SELECT pollid FROM bb".$n."_polls WHERE idhash = '".addslashes($idhash)."'");
if ($pollid) {
	header("Location: polledit.php?pollid=$pollid&boardid=$boardid&idhash=$idhash$SID_ARG_2ND_UN");
	exit;	
}


if (isset($_POST['send'])) {
	$question = wbb_trim($_POST['question']);
	$db->query("INSERT INTO bb".$n."_polls (question,starttime,choicecount,timeout,idhash) VALUES ('".addslashes($question)."','".time()."','".intval($_POST['choicecount'])."','".intval($_POST['timeout'])."','".addslashes($idhash)."')");
	$pollid = $db->insert_id();
	
	$options = explode("\n", $_POST['polloptions']);
	$count = 1;
	for ($i = 0; $i < count($options); $i++) {
		$options[$i] = wbb_trim($options[$i]);
		if (!$options[$i]) continue;
		$db->query("INSERT INTO bb".$n."_polloptions (pollid,polloption,showorder) VALUES ('$pollid','".addslashes($options[$i])."','$count')");
		$count++;
	}
	
	$question = str_replace("'", "\'", $question);
	eval("\$tpl->output(\"".$tpl->get("pollstart_give_parent")."\");");
	exit();
}
else {
	$choicecount = 1;
	$timeout = 0;
}

eval("\$tpl->output(\"".$tpl->get("pollstart")."\");");
?>
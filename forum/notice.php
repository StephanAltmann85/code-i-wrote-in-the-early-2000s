<?php
// Name der Datei hier! Ändert diesen Teil wenn ihr die Seite umbenennt !
$filename="notice.php";
require("./global.php");
global $thread, $board, $tpl, $wbbuserdata, $style, $lang, $session, $userratings, $showuserratinginthread;

//Sprachpacket auswählen
$lang->load("NOTICE");

if(isset($_POST['notice_send']) && $_POST['notice_send'] == 1)
{
  $write = addslashes($_POST['notice_main']);
  $write = htmlconverter($write);
  $db->query("UPDATE bb".$n."_users SET notice_notice='$write' WHERE userid='$wbbuserdata[userid]'");
}

//Notizausgabe:
$result = $db->query("SELECT userid, username, notice_notice FROM bb".$n."_users WHERE userid='$wbbuserdata[userid]'");
while($notice = $db->fetch_array($result)) $ausgabe = $notice['notice_notice'];

//Templateausgabe
eval("\$tpl->output(\"".$tpl->get("notice_popup")."\");");
?>

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


require('./global.php');

$lang->load('ACP_LOCATOR');


/** edit icons **/
if($_REQUEST["action"] == "delete")
{
  $db->query("DELETE FROM bb".$n."_locator WHERE userid = '$_REQUEST[userid]'");
  header("Location: locator.php?action=&sid=$session[hash]");
}
else
{
  $count = 0;
  $result = $db->query("SELECT a.*, b.username FROM bb".$n."_locator a LEFT JOIN bb".$n."_users b ON a.userid = b.userid");
  while($row = $db->fetch_array($result))
  {
    $rowclass = getone($count++, "firstrow", "secondrow");
    eval("\$locator_bit .= \"".$tpl->get("locator_bit", 1)."\";");
  }
  eval("\$tpl->output(\"".$tpl->get("locator", 1)."\",1);");
}
?>

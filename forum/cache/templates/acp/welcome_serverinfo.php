<?php
/*
acp template
templatename: welcome_serverinfo
*/

$this->templates['acp_welcome_serverinfo']="<table cellpadding=4 cellspacing=1 border=0 class=\\\"tblborder\\\" width=\\\"95%\\\" align=\\\"center\\\">
 <tr class=\\\"tblhead\\\">
  <td colspan=2>Server-Information</td>
 </tr>
 <tr class=\\\"firstrow\\\">
  <td>CPU Auslastung der letzten Minute:</td>
  <td>\$match[1]%</td>
 </tr>
 <tr class=\\\"secondrow\\\">
  <td>CPU Auslastung der letzten 5 Minuten:</td>
  <td>\$match[2]%</td>
 </tr>
 <tr class=\\\"firstrow\\\">
  <td>CPU Auslastung der letzten 15 Minuten:</td>
  <td>\$match[3]%</td>
 </tr>
</table><br>";
?>
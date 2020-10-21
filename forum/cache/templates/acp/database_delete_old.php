<?php
/*
acp template
templatename: database_delete_old
*/

$this->templates['acp_database_delete_old']="<form method=\\\"post\\\" action=\\\"database.php\\\" enctype=\\\"multipart/form-data\\\">
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\">
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"delete_old\\\">
  <table cellpadding=4 cellspacing=1 width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
   <tr class=\\\"tblhead\\\">
    <td colspan=3>Tabellen vom wBB1 entfernen</td>
   </tr>
   <tr>
    <td class=\\\"firstrow\\\"><input type=\\\"checkbox\\\" name=\\\"sure\\\" value=\\\"1\\\">&nbsp;<b>Tabellen&nbsp;entfernen?</b></td>
    <td class=\\\"secondrow\\\">Um die alten Tabellen vom wBB1 zu löschen, markieren Sie das Kästchen und klicken auf \\\"Tabellen entfernen\\\".</td>
    <td class=\\\"firstrow\\\"><input type=\\\"submit\\\" value=\\\"Tabellen entfernen\\\"></td>
   </tr>
  </table></form>";
?>
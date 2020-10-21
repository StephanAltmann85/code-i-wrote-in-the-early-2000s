<?php
/*
acp template
templatename: ranks_del_confirm
*/

$this->templates['acp_ranks_del_confirm']="<html>

<head>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset=iso-8859-1\\\">
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\">
</head>

<body>

<form method=\\\"post\\\" action=\\\"ranks.php\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\">
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"del\\\">
<input type=\\\"hidden\\\" name=\\\"rankid\\\" value=\\\"\$_REQUEST[rankid]\\\">
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\">
 <table cellpadding=4 cellspacing=1 border=0 class=\\\"tblborder\\\" width=\\\"95%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=2>Rang: \\\"\$rank_delete_row[ranktitle]\\\" entfernen</td>
  </tr>
  <tr>
   <td class=\\\"firstrow\\\">Wollen Sie diesen Rang wirklich löschen?</td>
   <td class=\\\"secondrow\\\"><input type=\\\"submit\\\" value=\\\"Ja\\\"> <input type=\\\"button\\\" value=\\\"Nein\\\" onclick=\\\"history.back();\\\"></td>
  </tr>
 </table>
</form>
</body>
 </html>";
?>
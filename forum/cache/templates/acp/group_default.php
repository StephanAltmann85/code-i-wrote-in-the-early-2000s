<?php
/*
acp template
templatename: group_default
*/

$this->templates['acp_group_default']="<html>

<head>
<meta http-equiv=\\\"content-type\\\" content=\\\"text/html;charset=iso-8859-1\\\">
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\">
</head>

<body>

<form method=\\\"post\\\" action=\\\"group.php\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\">
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\">
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\">
 <table cellpadding=4 cellspacing=1 border=0 class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">Standardgruppen festlegen</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>Standardgruppe f�r Besucher</b></td>
   <td><select name=\\\"default1\\\">\$options1</select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>Standardgruppe f�r neue Mitglieder</b></td>
   <td><select name=\\\"default2\\\">\$options2</select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"Speichern\\\"> <input type=\\\"reset\\\" value=\\\"Zur�cksetzen\\\"></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
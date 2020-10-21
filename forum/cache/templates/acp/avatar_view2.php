<?php
/*
acp template
templatename: avatar_view2
*/

$this->templates['acp_avatar_view2']="<html>

<head>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset=iso-8859-1\\\">
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\">
</head>

<body>
<form method=\\\"post\\\" action=\\\"avatar.php\\\">
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\">
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"view\\\">
<table cellpadding=4 cellspacing=1 border=0 class=\\\"tblborder\\\" width=\\\"95%\\\" align=\\\"center\\\">
 <tr class=\\\"tblhead\\\">
  <td colspan=\\\"4\\\">Avatar bearbeiten</td>
 </tr>
 <tr class=\\\"tblsection\\\" align=\\\"center\\\">
  <td>Avatar</td>
  <td width=\\\"50%\\\">Avatarname</td>
  <td width=\\\"50%\\\">Benutzer</td>
  <td>entfernen</td>
 </tr>
  \$avatar_viewbit
<tr class=\\\"tblsection\\\" align=\\\"center\\\">
<td colspan=\\\"4\\\">
<normalfont>
Anzeige der Avatare \$countfrom bis \$countto von \$avatarcount
</font><br>
<smallfont>
\$pagelink
</font>
</td>
</tr>
<tr align=\\\"center\\\" class=\\\"tblsection\\\">
<td colspan=\\\"6\\\">
<form action=\\\"avatar.php\\\" method=\\\"get\\\">
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"view\\\">
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\">
<select name=\\\"sortby\\\">
<option value=\\\"0\\\"\$sel_sortby[0]>ACP Avatare anzeigen</option>
<option value=\\\"1\\\"\$sel_sortby[1]>User-Avatare anzeigen</option>
</select>
&nbsp;
<select name=\\\"orderby\\\">
<option value=\\\"ASC\\\"\$sel_orderby[ASC]>Aufsteigend sortieren</option>
<option value=\\\"DESC\\\"\$sel_orderby[DESC]>Absteigend sortieren</option>
</select>
&nbsp;
<input type=\\\"submit\\\" value=\\\"Go\\\">
</td>
</tr></form>
</table>
</body>
</html>";
?>
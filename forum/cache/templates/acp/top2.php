<?php
/*
acp template
templatename: top2
*/

$this->templates['acp_top2']="<html>

<head>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset=iso-8859-1\\\">
<link rel=\\\"stylesheet\\\" href=\\\"css/other.css\\\">
</head>

<body><table border=\\\"0\\\" cellpadding=\\\"2\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">
<tr>
 <td><b><a href=\\\"http://www.woltlab.de\\\" target=\\\"_blank\\\">Woltlab Burning Board</a></b> - Moderator Control Panel (Version \$boardversion)</td>
 <td align=\\\"right\\\"><b><a href=\\\"logout.php?sid=\$session[hash]\\\" target=\\\"_parent\\\">Abmelden</a></b> | <b><a href=\\\"../index.php\\\" target=\\\"_blank\\\">Zum Forum</a></b></td>
</tr>
</table>
</body>
</html>";
?>
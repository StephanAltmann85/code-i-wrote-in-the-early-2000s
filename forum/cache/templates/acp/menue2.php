<?php
/*
acp template
templatename: menue2
*/

$this->templates['acp_menue2']="<html>

<head>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset=iso-8859-1\\\">
<link rel=\\\"stylesheet\\\" href=\\\"css/menue.css\\\">
</head>

<body>
  <p><b><a href=\\\"threads.php?action=spinning&sid=\$session[hash]\\\" target=\\\"main\\\">Themen bearbeiten</a></b></p>
  <p><a href=\\\"threads.php?action=moderate&sid=\$session[hash]\\\" target=\\\"main\\\">Themen freischalten</a></p>
  <p><a href=\\\"threads.php?action=moderateposts&sid=\$session[hash]\\\" target=\\\"main\\\">Beiträge freischalten</a></p>
 <hr>
</body>
</html>";
?>
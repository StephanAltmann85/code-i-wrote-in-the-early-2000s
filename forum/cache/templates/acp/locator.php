<?php
/*
acp template
templatename: locator
*/

$this->templates['acp_locator']="<html>

<head>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset=iso-8859-1\\\">
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\">

<script language=\\\"JavaScript\\\">
<!--
 function Message(Message) {
  var x = window.confirm(Message);
  return x;
 }
//-->
</script>
<noscript></noscript>
</head>



<body>

<table cellpadding=4 cellspacing=1 border=0 class=\\\"tblborder\\\" width=\\\"95%\\\" align=\\\"center\\\">
 <tr class=\\\"tblhead\\\">
  <td colspan=\\\"5\\\">{\$lang->items['LANG_ACP_LOCATOR_TITLE']}</td>
 </tr>
 <tr class=\\\"tblsection\\\" align=\\\"center\\\">
  <td>{\$lang->items['LANG_ACP_LOCATOR_COORDS']}</td>
  <td>{\$lang->items['LANG_ACP_LOCATOR_USERNAME']}</td>
  <td>{\$lang->items['LANG_ACP_LOCATOR_RESIDENCE']}</td>
  <td>{\$lang->items['LANG_ACP_LOCATOR_DELETE']}</td>
 </tr>
  \$locator_bit
</table>
</body>
</html>";
?>
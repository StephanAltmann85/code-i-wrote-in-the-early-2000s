<?php
/*
acp template
templatename: workingtop
*/

$this->templates['acp_workingtop']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/other.css\\\" />
</head>

<body>
<table border=\\\"0\\\" cellpadding=\\\"2\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">
<tr valign=\\\"middle\\\">
 <td height=\\\"100%\\\" nowrap=\\\"nowrap\\\">\".((\$taskname!=\"\") ? (\"<b>{\$lang->items['LANG_ACP_OTHERSTUFF_WORKINGTOP_TASK']}</b>&nbsp;\$taskname&nbsp;(\".((\$percent<100) ? (\"\$percent\") : (\"100\")).\"%)\") : (\"&nbsp;\")).\"</td>
</tr>
</table>
</body>
</html>";
?>
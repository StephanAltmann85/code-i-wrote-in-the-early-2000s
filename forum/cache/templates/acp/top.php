<?php
/*
acp template
templatename: top
*/

$this->templates['acp_top']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/other.css\\\" />
</head>

<body><table border=\\\"0\\\" cellpadding=\\\"2\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">
<tr>
 <td><b><a href=\\\"http://www.woltlab.de\\\" target=\\\"_blank\\\">Woltlab Burning Board</a></b> - \".((\$wbbuserdata['a_acp_or_mcp']==1) ? (\"{\$lang->items['LANG_ACP_GLOBAL_ACP']}\") : (\"{\$lang->items['LANG_ACP_GLOBAL_MODCP']}\")).\" {\$lang->items['LANG_ACP_GLOBAL_BOARDVERSION']}</td>
 <td align=\\\"right\\\"><b><a href=\\\"logout.php?sid=\$session[hash]\\\" target=\\\"_parent\\\">{\$lang->items['LANG_ACP_MISC_TOP_LOGOUT']}</a></b> | <b><a href=\\\"../index.php\\\" target=\\\"_blank\\\">{\$lang->items['LANG_ACP_MISC_TOP_TOBOARD']}</a></b> |
   \".((\$wbbuserdata['acpmode']==1) 
 	? (\"<b><a href=\\\"index.php?sid=\$session[hash]&amp;acpmode=2\\\" target=\\\"_top\\\">{\$lang->items['LANG_ACP_GLOBAL_MODE_2']}</a></b>\") 
	: (\"<b><a href=\\\"index.php?sid=\$session[hash]&amp;acpmode=1\\\" target=\\\"_top\\\">{\$lang->items['LANG_ACP_GLOBAL_MODE_1']}</a></b>\")
   ).\"
 </td>
</tr>
</table>
</body>
</html>";
?>
<?php
/*
acp template
templatename: storagetop
*/

$this->templates['acp_storagetop']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/other.css\\\" />
</head>

<body>
<table border=\\\"0\\\" cellpadding=\\\"1\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">
<tr>
 <td><b>{\$lang->items['LANG_ACP_MISC_CLIPBOARD']}</b></td>
 <td width=\\\"100%\\\" nowrap=\\\"nowrap\\\"><a href=\\\"javascript:parent.storage.show();\\\"><img src=\\\"{\$style['imagefolder']}/jump.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_ACP_MISC_CLIPBOARD_JUMP']}\\\" title=\\\"{\$lang->items['LANG_ACP_MISC_CLIPBOARD_JUMP']}\\\" /></a></td>
 <td align=\\\"right\\\" nowrap=\\\"nowrap\\\"><a href=\\\"misc.php?action=sync&amp;sid=\$session[hash]\\\" target=\\\"main\\\"><img src=\\\"{\$style['imagefolder']}/storage_show.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_ACP_MISC_CLIPBOARD_SHOW']}\\\" title=\\\"{\$lang->items['LANG_ACP_MISC_CLIPBOARD_SHOW']}\\\" /></a>&nbsp;&nbsp;<a href=\\\"javascript:parent.storage.del();\\\"><img src=\\\"{\$style['imagefolder']}/storage_delsel.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_ACP_MISC_CLIPBOARD_DELSEL']}\\\" title=\\\"{\$lang->items['LANG_ACP_MISC_CLIPBOARD_DELSEL']}\\\" /></a>&nbsp;&nbsp;<a href=\\\"javascript:parent.storage.selall(true);\\\"><img src=\\\"{\$style['imagefolder']}/storage_selall.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_ACP_MISC_CLIPBOARD_SELALL']}\\\" title=\\\"{\$lang->items['LANG_ACP_MISC_CLIPBOARD_SELALL']}\\\" /></a>&nbsp;&nbsp;<a href=\\\"javascript:parent.storage.selall(false);\\\"><img src=\\\"{\$style['imagefolder']}/storage_unselall.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_ACP_MISC_CLIPBOARD_UNSELALL']}\\\" title=\\\"{\$lang->items['LANG_ACP_MISC_CLIPBOARD_UNSELALL']}\\\" /></a>&nbsp;&nbsp;</td>
</tr>
</table>
</body>
</html>";
?>
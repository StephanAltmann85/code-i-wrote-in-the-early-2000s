<?php
/*
acp template
templatename: bbcodes_view
*/

$this->templates['acp_bbcodes_view']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>

<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
 <tr class=\\\"tblhead\\\">
  <td colspan=\\\"\".(1 + (int)checkAdminPermissions(\"a_can_bbcodes_edit\") + (int)checkAdminPermissions(\"a_can_bbcodes_del\")).\"\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_BBCODES_EDIT']}</td>
 </tr>
 <tr class=\\\"tblsection\\\" align=\\\"center\\\">
  <td nowrap=\\\"nowrap\\\">{\$lang->items['LANG_ACP_BBCODES_TAG']}</td>
  \".((checkAdminPermissions(\"a_can_bbcodes_edit\")) ? (\"<td nowrap=\\\"nowrap\\\">{\$lang->items['LANG_ACP_GLOBAL_EDIT']}</td>\") : (\"\")).\"
  \".((checkAdminPermissions(\"a_can_bbcodes_del\")) ? (\"<td nowrap=\\\"nowrap\\\">{\$lang->items['LANG_ACP_GLOBAL_DELETE']}</td>\") : (\"\")).\"
 </tr>
  \$bbcodes_viewbit
</table>
</body>
</html>";
?>
<?php
/*
acp template
templatename: group_view
*/

$this->templates['acp_group_view']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />

<script type=\\\"text/javascript\\\">
<!--
function groupAction(theSelect) {
 if(theSelect.options[theSelect.selectedIndex].value!='') document.location.href=theSelect.options[theSelect.selectedIndex].value;
}
//-->
</script>
</head>

<body>
<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
 <tr class=\\\"tblhead\\\">
  <td colspan=\\\"4\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_GROUP_EDIT']}</td>
 </tr>
 <tr class=\\\"tblsection\\\" align=\\\"center\\\">
  <td nowrap=\\\"nowrap\\\">{\$lang->items['LANG_ACP_GROUP_ID']}</td>
  <td nowrap=\\\"nowrap\\\">{\$lang->items['LANG_ACP_GROUP_GROUPTITLE']}</td>
  <td nowrap=\\\"nowrap\\\">{\$lang->items['LANG_ACP_GROUP_USERCOUNT']}</td>
  <td>&nbsp;</td>
 </tr>
  \$group_viewbit
</table>
</body>
</html>";
?>
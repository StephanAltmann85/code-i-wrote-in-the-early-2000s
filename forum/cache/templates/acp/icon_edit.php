<?php
/*
acp template
templatename: icon_edit
*/

$this->templates['acp_icon_edit']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>
<form method=\\\"post\\\" action=\\\"icon.php\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<input type=\\\"hidden\\\" name=\\\"iconid\\\" value=\\\"\$_REQUEST[iconid]\\\" />
<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_ICON_EDIT']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_ICON_ICONTITLE']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"icontitle\\\" value=\\\"\$icon[icontitle]\\\" maxlength=\\\"100\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_ICON_ICONPATH']}</b><br />{\$lang->items['LANG_ACP_ICON_ICONPATH_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"iconpath\\\" value=\\\"\$icon[iconpath]\\\" maxlength=\\\"250\\\" size=\\\"30\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_ICON_ICONORDER']}</b><br />{\$lang->items['LANG_ACP_ICON_ICONORDER_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"iconorder\\\" value=\\\"\$icon[iconorder]\\\" maxlength=\\\"7\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
</form>

</body>

</html>";
?>
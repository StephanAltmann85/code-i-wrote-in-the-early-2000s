<?php
/*
acp template
templatename: languagepack_additem
*/

$this->templates['acp_languagepack_additem']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>

<form method=\\\"post\\\" action=\\\"languagepack.php\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_LANGUAGEITEM_ADD']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_LANGUAGEPACK_LANGUAGEPACK']}:</b></td>
   <td><select name=\\\"languagepackid\\\">
    \$lp_options
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_LANGUAGEPACK_CATEGORY']}</b></td>
   <td><select name=\\\"catid\\\">
    \$cat_options
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_LANGUAGEPACK_ITEM']}:</b></td>
   <td><input type=\\\"text\\\" name=\\\"itemname\\\" value=\\\"\\\" size=\\\"70\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_LANGUAGEPACK_ITEMVALUE']}</b></td>
   <td><textarea name=\\\"item\\\" cols=\\\"70\\\" rows=\\\"5\\\"></textarea></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
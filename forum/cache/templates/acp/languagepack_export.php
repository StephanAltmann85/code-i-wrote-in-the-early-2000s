<?php
/*
acp template
templatename: languagepack_export
*/

$this->templates['acp_languagepack_export']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
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
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
 <input type=\\\"hidden\\\" name=\\\"languagepackid\\\" value=\\\"\$languagepackid\\\" />
  <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
   <tr class=\\\"tblhead\\\">
    <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_LANGUAGEPACK_EXPORT']}</td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_LANGUAGEPACK_EXPORT_CATEGORIES']}</b><br />{\$lang->items['LANG_ACP_LANGUAGEPACK_EXPORT_CATEGORIES_DESC']}</td>
    <td><select name=\\\"catids[]\\\" multiple=\\\"multiple\\\">
    <option value=\\\"*\\\" selected=\\\"selected\\\">{\$lang->items['LANG_ACP_LANGUAGEPACK_EXPORT_CATEGORIES_ALL']}</option>
    \$cat_options
    </select></td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td colspan=\\\"2\\\" align=\\\"right\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_START']}\\\" /></td>
   </tr>
  </table>
 </form>
</body>
</html>";
?>
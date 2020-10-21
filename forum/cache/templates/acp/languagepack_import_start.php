<?php
/*
acp template
templatename: languagepack_import_start
*/

$this->templates['acp_languagepack_import_start']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
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
 <input type=\\\"hidden\\\" name=\\\"lngfile\\\" value=\\\"\$lngfile\\\" />
 <input type=\\\"hidden\\\" name=\\\"start\\\" value=\\\"2\\\" />
  <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
   <tr class=\\\"tblhead\\\">
    <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_LANGUAGEPACK_IMPORT']}</td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td><b>{\$lang->items['LANG_ACP_GLOBAL_IMPORT_VERSION']}</b></td>
    <td>\$exportwbbversion</td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td><b>{\$lang->items['LANG_ACP_GLOBAL_IMPORT_DATE']}</b></td>
    <td>\$exportdate</td>
   </tr>
   <tr class=\\\"tblsection\\\">
    <td colspan=\\\"2\\\"><input type=\\\"radio\\\" name=\\\"createnew\\\" id=\\\"radio1\\\" value=\\\"1\\\" checked=\\\"checked\\\" /><label for=\\\"radio1\\\"> {\$lang->items['LANG_ACP_LANGUAGEPACK_IMPORT_CREATE_NEW']}</label></td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td><b>{\$lang->items['LANG_ACP_LANGUAGEPACK_IMPORT_CREATE_NEW_NAME']}</b></td>
    <td><input type=\\\"text\\\" name=\\\"languagepackname\\\" value=\\\"\$languagepackname\\\" /></td>
   </tr>
   <tr class=\\\"tblsection\\\">
    <td colspan=\\\"2\\\"><input type=\\\"radio\\\" name=\\\"createnew\\\" id=\\\"radio2\\\" value=\\\"0\\\" /><label for=\\\"radio2\\\"> {\$lang->items['LANG_ACP_LANGUAGEPACK_IMPORT_OVERWRITE']}</label></td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td><b>{\$lang->items['LANG_ACP_LANGUAGEPACK_IMPORT_OVERWRITE_NAME']}</b></td>
    <td><select name=\\\"languagepackid\\\">\$languagepack_options</select></td>
   </tr>
   <tr class=\\\"tblsection\\\">
    <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_LANGUAGEPACK_EXPORT_CATEGORIES']}</td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td valign=\\\"top\\\">{\$lang->items['LANG_ACP_LANGUAGEPACK_IMPORT_CATEGORIES_DESC']}</td>
    <td><select name=\\\"cats2import[]\\\" multiple=\\\"multiple\\\">
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
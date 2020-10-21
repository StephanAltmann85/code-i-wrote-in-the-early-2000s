<?php
/*
acp template
templatename: database_query
*/

$this->templates['acp_database_query']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>
<body>

\".((checkAdminPermissions(\"a_can_database_extra\")) 
? (\"
 <form method=\\\"post\\\" action=\\\"database.php\\\">
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"extra\\\" />
  <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
   <tr class=\\\"tblhead\\\">
    <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_DATABASE_EXTRA']}</td>
   </tr>
   <tr class=\\\"tblsection\\\">
    <td colspan=\\\"2\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\" class=\\\"tblsection\\\">
     <tr>
      <td width=\\\"50%\\\" align=\\\"center\\\">{\$lang->items['LANG_ACP_DATABASE_TABLES']}</td>
      <td width=\\\"50%\\\" align=\\\"center\\\">{\$lang->items['LANG_ACP_DATABASE_OPTIONS']}</td>
     </tr>
    </table></td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td width=\\\"50%\\\" align=\\\"center\\\">
     <select size=\\\"10\\\" name=\\\"tables[]\\\" multiple=\\\"multiple\\\">
      \$table_options
     </select>
    </td>
    <td width=\\\"50%\\\" valign=\\\"top\\\">
    <b>{\$lang->items['LANG_ACP_DATABASE_EXTRA_OPTIONS']}</b><br />
    <input type=\\\"radio\\\" name=\\\"what\\\" id=\\\"radio1\\\" value=\\\"1\\\" checked=\\\"checked\\\" /><label for=\\\"radio1\\\"> {\$lang->items['LANG_ACP_DATABASE_EXTRA_OPTION_1']}</label><br />
    {\$lang->items['LANG_ACP_DATABASE_EXTRA_OPTION_1_DESC']}<br /><br />
    <input type=\\\"radio\\\" name=\\\"what\\\" id=\\\"radio2\\\" value=\\\"2\\\" /><label for=\\\"radio2\\\"> {\$lang->items['LANG_ACP_DATABASE_EXTRA_OPTION_2']}</label><br />
    {\$lang->items['LANG_ACP_DATABASE_EXTRA_OPTION_2_DESC']}
    </td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td colspan=\\\"2\\\" align=\\\"right\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_START']}\\\" /></td>
   </tr>
  </table>
  </form><br />
\") : (\"\")
).\"

\".((checkAdminPermissions(\"a_can_database_query\")) 
? (\"
<form method=\\\"post\\\" action=\\\"database.php\\\" enctype=\\\"multipart/form-data\\\">
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"query\\\" />
  <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
   <tr class=\\\"tblhead\\\">
    <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_DATABASE_QUERY']}</td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td><b>{\$lang->items['LANG_ACP_DATABASE_QUERY_FILENAME']}</b> {\$lang->items['LANG_ACP_DATABASE_QUERY_FILENAME_DESC']}</td>
    <td><input type=\\\"text\\\" name=\\\"filename\\\" value=\\\"\\\" /></td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td><b>{\$lang->items['LANG_ACP_DATABASE_QUERY_UPLOADFILE']}</b> {\$lang->items['LANG_ACP_DATABASE_QUERY_UPLOADFILE_DESC']}</td>
    <td><input type=\\\"file\\\" name=\\\"uploadfile\\\" /></td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DATABASE_QUERY_QUERY']}</b><br /><br />{\$lang->items['LANG_ACP_DATABASE_QUERY_QUERY_DESC']}</td>
    <td><textarea cols=\\\"50\\\" rows=\\\"5\\\" name=\\\"query\\\"></textarea></td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td colspan=\\\"2\\\" align=\\\"right\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_START']}\\\" /></td>
   </tr>
  </table>
 </form>
\") : (\"\")
).\"
</body>
</html>";
?>
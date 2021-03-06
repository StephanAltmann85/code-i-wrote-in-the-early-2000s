<?php
/*
acp template
templatename: database_backup
*/

$this->templates['acp_database_backup']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>
 <form method=\\\"post\\\" action=\\\"database.php\\\">
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"backup\\\" />
  <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
   <tr class=\\\"tblhead\\\">
    <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_DATABASE_BACKUP']}</td>
   </tr>
   <tr class=\\\"tblsection\\\">
    <td colspan=\\\"2\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\" class=\\\"tblsection\\\">
     <tr align=\\\"center\\\">
      <td width=\\\"50%\\\">{\$lang->items['LANG_ACP_DATABASE_TABLES']}</td>
      <td width=\\\"50%\\\">{\$lang->items['LANG_ACP_DATABASE_OPTIONS']}</td>
     </tr>
    </table></td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td width=\\\"50%\\\" align=\\\"center\\\">
     <select size=\\\"11\\\" name=\\\"tables[]\\\" multiple=\\\"multiple\\\">
      \$table_options
     </select>
    </td>
    <td width=\\\"50%\\\" valign=\\\"top\\\">
    <b>{\$lang->items['LANG_ACP_DATABASE_EXPORT_OPTIONS']}</b><br />
    <input type=\\\"radio\\\" name=\\\"structure\\\" id=\\\"radio1\\\"value=\\\"1\\\" checked=\\\"checked\\\" /><label for=\\\"radio1\\\"> {\$lang->items['LANG_ACP_DATABASE_STRUCTURE_1']}</label>
	\".((\$wbbuserdata['acpmode']>1) ? (\"<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\\\"checkbox\\\" id=\\\"checkbox1\\\" name=\\\"drop_table\\\" value=\\\"1\\\" /><label for=\\\"checkbox1\\\"> {\$lang->items['LANG_ACP_DATABASE_DROP_TABLE']}</label>\") : (\"<input type=\\\"hidden\\\" name=\\\"drop_table\\\" value=\\\"0\\\" />\")).\"
    <br /><input type=\\\"radio\\\" name=\\\"structure\\\" id=\\\"radio2\\\" value=\\\"0\\\" /><label for=\\\"radio2\\\"> {\$lang->items['LANG_ACP_DATABASE_STRUCTURE_0']}</label>
	\".((\$wbbuserdata['acpmode']>1) ? (\"<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\\\"checkbox\\\" id=\\\"checkbox2\\\" name=\\\"delete_all\\\" value=\\\"1\\\" /><label for=\\\"checkbox2\\\"> {\$lang->items['LANG_ACP_DATABASE_DELETE_ALL']}</label>\") : (\"<input type=\\\"hidden\\\" name=\\\"delete_all\\\" value=\\\"0\\\" />\")).\"
    <br /><b>{\$lang->items['LANG_ACP_DATABASE_SAVE_OPTIONS']}</b><br />
    <input type=\\\"radio\\\" id=\\\"radio3\\\" name=\\\"download\\\" value=\\\"0\\\" /><label for=\\\"radio3\\\"> {\$lang->items['LANG_ACP_DATABASE_DOWNLOAD_0']}</label><br />
    <input type=\\\"radio\\\" id=\\\"radio4\\\" name=\\\"download\\\" value=\\\"1\\\" checked=\\\"checked\\\" /><label for=\\\"radio4\\\"> {\$lang->items['LANG_ACP_DATABASE_DOWNLOAD_1']}</label><br />
    <input type=\\\"radio\\\" id=\\\"radio5\\\" name=\\\"download\\\" value=\\\"2\\\" /><label for=\\\"radio5\\\"> {\$lang->items['LANG_ACP_DATABASE_DOWNLOAD_2']}</label><br />
    \".((function_exists(\"gzopen\")) ? (\"<input type=\\\"checkbox\\\" name=\\\"use_gz\\\" id=\\\"checkbox3\\\" value=\\\"1\\\" /><label for=\\\"checkbox3\\\"> {\$lang->items['LANG_ACP_DATABASE_GZIP']}</label>\") : (\"<input type=\\\"hidden\\\" name=\\\"use_gz\\\" value=\\\"0\\\" />\")).\"
    </td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td colspan=\\\"2\\\" align=\\\"right\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_START']}\\\" /></td>
   </tr>
  </table>
 </form>
</body>
</html>";
?>
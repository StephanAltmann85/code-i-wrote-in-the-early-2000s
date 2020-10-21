<?php
/*
acp template
templatename: threads
*/

$this->templates['acp_threads']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>
<form action=\\\"threads.php\\\" method=\\\"post\\\">
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_THREADS_EDIT']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_THREADS_EDIT_BOARD']}</td>
   <td><select name=\\\"boardid\\\">\$boardid_options</select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>{\$lang->items['LANG_ACP_BOARD_SORTFIELD']}</td>
   <td><select name=\\\"sortby\\\">
    <option value=\\\"topic\\\">{\$lang->items['LANG_BOARD_SORTFIELD_TOPIC']}</option>
    <option value=\\\"starttime\\\">{\$lang->items['LANG_BOARD_SORTFIELD_STARTTIME']}</option>
    <option value=\\\"replycount\\\">{\$lang->items['LANG_BOARD_SORTFIELD_REPLYCOUNT']}</option>
    <option value=\\\"starter\\\">{\$lang->items['LANG_BOARD_SORTFIELD_STARTER']}</option>
    <option value=\\\"views\\\">{\$lang->items['LANG_BOARD_SORTFIELD_VIEWS']}</option>
    <option value=\\\"lastposttime\\\" selected=\\\"selected\\\">{\$lang->items['LANG_BOARD_SORTFIELD_LASTPOSTTIME']}</option>
    <option value=\\\"lastposter\\\">{\$lang->items['LANG_BOARD_SORTFIELD_LASTPOSTER']}</option>
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_BOARD_SORTORDER']}</td>
   <td><select name=\\\"sortorder\\\">
    <option value=\\\"ASC\\\">{\$lang->items['LANG_BOARD_SORTORDER_ASC']}</option>
    <option value=\\\"DESC\\\" selected=\\\"selected\\\">{\$lang->items['LANG_BOARD_SORTORDER_DESC']}</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>{\$lang->items['LANG_ACP_THREADS_EDIT_LIMIT']}</td>
   <td><input type=\\\"text\\\" name=\\\"limit\\\" value=\\\"20\\\" maxlength=\\\"255\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_THREADS_EDIT_OFFSET']}</td>
   <td><input type=\\\"text\\\" name=\\\"offset\\\" value=\\\"1\\\" maxlength=\\\"255\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td align=\\\"center\\\" colspan=\\\"2\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_START']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
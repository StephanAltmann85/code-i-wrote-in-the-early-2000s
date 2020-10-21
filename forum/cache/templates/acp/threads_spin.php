<?php
/*
acp template
templatename: threads_spin
*/

$this->templates['acp_threads_spin']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>
<form action=\\\"threads.php\\\" method=\\\"post\\\">
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"verify\\\" />
 <input type=\\\"hidden\\\" name=\\\"boardid\\\" value=\\\"\$boardid\\\" />
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"6\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_THREADS_EDIT']}</td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td>{\$lang->items['LANG_ACP_THREADS_TOPIC']}</td>
   <td>{\$lang->items['LANG_ACP_THREADS_STARTER']}</td>
   <td colspan=\\\"4\\\">{\$lang->items['LANG_ACP_THREADS_ACTION']}</td>
  </tr>
  \$threadbit
  <tr class=\\\"firstrow\\\">
   <td align=\\\"center\\\" colspan=\\\"6\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_START']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
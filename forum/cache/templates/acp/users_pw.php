<?php
/*
acp template
templatename: users_pw
*/

$this->templates['acp_users_pw']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title>{\$lang->items['LANG_ACP_USERS_PASSWORD_CHANGE']}</title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>

<form method=\\\"post\\\" action=\\\"users.php\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"pw\\\" />
<input type=\\\"hidden\\\" name=\\\"userid\\\" value=\\\"\$userid\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_USERS_PASSWORD_CHANGE']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_USERS_PASSWORD_CHANGE_NEW']}</b></td>
   <td><input type=\\\"radio\\\" name=\\\"mode\\\" id=\\\"radio1\\\" value=\\\"1\\\" checked=\\\"checked\\\" /><label for=\\\"radio1\\\"> {\$lang->items['LANG_ACP_USERS_PASSWORD_CHANGE_MODE_1']}</label><br />
   <input type=\\\"radio\\\" name=\\\"mode\\\" value=\\\"2\\\" /> <input type=\\\"text\\\" name=\\\"newpassword\\\" value=\\\"\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>{\$lang->items['LANG_ACP_USERS_PASSWORD_CHANGE_NOTIFY']}</td>
   <td><input type=\\\"checkbox\\\" name=\\\"sendmail\\\" id=\\\"checkbox1\\\" value=\\\"1\\\" checked=\\\"checked\\\" /><label for=\\\"checkbox1\\\"> {\$lang->items['LANG_ACP_GLOBAL_YES']}</label></td>
  </tr>
 </table>
 <p align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_WINDOW_CLOSE']}\\\" onclick=\\\"self.close();\\\" /></p>
</form>
</body>
</html>";
?>
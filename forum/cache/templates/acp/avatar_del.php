<?php
/*
acp template
templatename: avatar_del
*/

$this->templates['acp_avatar_del']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>
<form method=\\\"post\\\" action=\\\"avatar.php\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"del\\\" />
<input type=\\\"hidden\\\" name=\\\"avatarid\\\" value=\\\"\$avatarid\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_AVATAR_DEL']}</td>
  </tr>
  <tr>
   <td rowspan=\\\"2\\\" class=\\\"secondrow\\\">\$avatarimage</td>
   <td width=\\\"75%\\\" class=\\\"firstrow\\\" nowrap=\\\"nowrap\\\">{\$lang->items['LANG_ACP_AVATAR_DEL_SURE']}</td>
   <td width=\\\"25%\\\" class=\\\"secondrow\\\" nowrap=\\\"nowrap\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_YES']}\\\" /> <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_NO']}\\\" onclick=\\\"history.back();\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
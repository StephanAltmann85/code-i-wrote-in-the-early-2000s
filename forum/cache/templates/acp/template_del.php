<?php
/*
acp template
templatename: template_del
*/

$this->templates['acp_template_del']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>
<body>
 <form method=\\\"post\\\" action=\\\"template.php\\\" name=\\\"tform\\\">
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
 <input type=\\\"hidden\\\" name=\\\"templateid\\\" value=\\\"\$templateid\\\" />
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_TEMPLATE_DEL']}</td>
  </tr>
  <tr>
   <td class=\\\"firstrow\\\">{\$lang->items['LANG_ACP_TEMPLATE_DEL_SURE']}</td>
   <td class=\\\"secondrow\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_YES']}\\\" /> <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_NO']}\\\" onclick=\\\"history.back()\\\" /></td>
  </tr>
 </table></form>
</body>
</html>";
?>
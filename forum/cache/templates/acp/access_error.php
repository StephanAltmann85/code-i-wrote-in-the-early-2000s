<?php
/*
acp template
templatename: access_error
*/

$this->templates['acp_access_error']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td>{\$lang->items['LANG_ACP_GLOBAL_ERROR']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_GLOBAL_ACCESS_ERROR']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td align=\\\"center\\\"><input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_LOGIN_SUBMIT']}\\\" onclick=\\\"parent.location.href='index.php';\\\" /> <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_BACK']}\\\" onclick=\\\"history.back();\\\" /></td>  
  </tr>
 </table>
</body>
</html>";
?>
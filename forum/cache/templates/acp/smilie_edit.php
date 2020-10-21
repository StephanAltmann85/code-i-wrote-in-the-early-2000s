<?php
/*
acp template
templatename: smilie_edit
*/

$this->templates['acp_smilie_edit']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>
<form method=\\\"post\\\" action=\\\"smilie.php\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<input type=\\\"hidden\\\" name=\\\"smilieid\\\" value=\\\"\$smilieid\\\" />
<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_SMILIE_EDIT']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_SMILIE_SMILIETITLE']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"smilietitle\\\" value=\\\"\$smilie[smilietitle]\\\" maxlength=\\\"100\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_SMILIE_SMILIEPATH']}</b><br />{\$lang->items['LANG_ACP_SMILIE_SMILIEPATH_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"smiliepath\\\" value=\\\"\$smilie[smiliepath]\\\" maxlength=\\\"250\\\" size=\\\"30\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_SMILIE_SMILIECODE']}:</b><br />{\$lang->items['LANG_ACP_SMILIE_SMILIECODE_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"smiliecode\\\" value=\\\"\$smilie[smiliecode]\\\" maxlength=\\\"250\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_SMILIE_SMILIEORDER']}</b><br />{\$lang->items['LANG_ACP_SMILIE_SMILIEORDER_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"smilieorder\\\" value=\\\"\$smilie[smilieorder]\\\" maxlength=\\\"7\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
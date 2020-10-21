<?php
/*
acp template
templatename: acpsettings
*/

$this->templates['acp_acpsettings']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title></title>
<meta http-equiv=\\\"content-type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body\".((isSet(\$_POST['send'])) ? (\" onload=\\\"top.location.href='index.php?sid=\$session[hash]';\\\"\") : (\"\")).\">
<form method=\\\"post\\\" action=\\\"otherstuff.php\\\">
<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
 <tr class=\\\"tblhead\\\">
  <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_OTHERSTUFF_ACPSETTINGS']}</td>
 </tr>
<tr class=\\\"secondrow\\\">
 <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_OTHERSTUFF_ACPSETTINGS_ACPMODE']}</b><br />{\$lang->items['LANG_ACP_OTHERSTUFF_ACPSETTINGS_ACPMODE_DESCRIPTION']}</td>
 <td><select name=\\\"acpmode\\\"><option value=\\\"1\\\"\".((\$wbbuserdata['acpmode']==1) ? (\" selected=\\\"selected\\\"\") : (\"\")).\">{\$lang->items['LANG_ACP_OTHERSTUFF_ACPSETTINGS_ACPMODE_MODE1']}</option><option value=\\\"2\\\"\".((\$wbbuserdata['acpmode']==2) ? (\" selected=\\\"selected\\\"\") : (\"\")).\">{\$lang->items['LANG_ACP_OTHERSTUFF_ACPSETTINGS_ACPMODE_MODE2']}</option></select></td>
</tr>
<tr class=\\\"firstrow\\\">
 <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_OTHERSTUFF_ACPSETTINGS_PERSONALMENU']}</b><br />{\$lang->items['LANG_ACP_OTHERSTUFF_ACPSETTINGS_PERSONALMENU_DESCRIPTION']}</td>
 <td><select name=\\\"acppersonalmenu\\\"><option value=\\\"1\\\"\".((\$wbbuserdata['acppersonalmenu']==1) ? (\" selected=\\\"selected\\\"\") : (\"\")).\">{\$lang->items['LANG_ACP_GLOBAL_YES']}</option><option value=\\\"0\\\"\".((\$wbbuserdata['acppersonalmenu']==0) ? (\" selected=\\\"selected\\\"\") : (\"\")).\">{\$lang->items['LANG_ACP_GLOBAL_NO']}</option></select></td>
</tr>
<tr class=\\\"secondrow\\\">
 <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_OTHERSTUFF_ACPSETTINGS_MARKFIRST']}</b><br />{\$lang->items['LANG_ACP_OTHERSTUFF_ACPSETTINGS_MARKFIRST_DESC']}</td>
 <td><input type=\\\"text\\\" size=\\\"3\\\" maxlength=\\\"3\\\" name=\\\"acpmenumarkfirst\\\" value=\\\"\$wbbuserdata[acpmenumarkfirst]\\\" /></td>
</tr>
<tr class=\\\"firstrow\\\">
 <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_OTHERSTUFF_ACPSETTINGS_HIDELAST']}</b><br />{\$lang->items['LANG_ACP_OTHERSTUFF_ACPSETTINGS_HIDELAST_DESC']}</td>
 <td><input type=\\\"text\\\" size=\\\"3\\\" maxlength=\\\"3\\\" name=\\\"acpmenuhidelast\\\" value=\\\"\$wbbuserdata[acpmenuhidelast]\\\" /></td>
</tr>
 <tr class=\\\"firstrow\\\">
  <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
 </tr>
</table>
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
</form>
</body>
</html>";
?>
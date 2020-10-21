<?php
/*
acp template
templatename: group_copy
*/

$this->templates['acp_group_copy']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>
<form method=\\\"post\\\" action=\\\"group.php\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"groupid\\\" value=\\\"\$groupid\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GROUP_ACTION_COPY']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
		<td><b>{\$lang->items['LANG_ACP_GROUP_GROUPNAME']}</b></td>
		<td><input type=\\\"text\\\" name=\\\"title\\\" value=\\\"{\$group[title]}(1)\\\" maxlength=\\\"30\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
		<td><b>{\$lang->items['LANG_ACP_GROUP_COPYUSER']}</b></td>
		<td><select name=\\\"copyuser\\\">
		 <option value=\\\"1\\\">{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
		 <option value=\\\"0\\\" selected=\\\"selected\\\">{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
		</select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
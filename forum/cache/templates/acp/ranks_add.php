<?php
/*
acp template
templatename: ranks_add
*/

$this->templates['acp_ranks_add']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>
<form method=\\\"post\\\" action=\\\"ranks.php\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_RANKS_ADD']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_RANKS_RANKNAME']}:</b></td>
   <td><input type=\\\"text\\\" name=\\\"title\\\" value=\\\"\\\" maxlength=\\\"30\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_RANKS_USERGROUP']}</b><br />{\$lang->items['LANG_ACP_RANKS_USERGROUP_DESC']}</td>
   <td><select name=\\\"group\\\">
   \$ranks_groupsbit 
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_RANKS_GENDER']}</b><br />{\$lang->items['LANG_ACP_RANKS_GENDER_DESC']}</td>
   <td><select name=\\\"gender\\\">
		<option value=\\\"0\\\" selected=\\\"selected\\\">{\$lang->items['LANG_ACP_RANKS_GENDER_0']}</option>
		<option value=\\\"1\\\">{\$lang->items['LANG_ACP_RANKS_GENDER_1']}</option>
		<option value=\\\"2\\\">{\$lang->items['LANG_ACP_RANKS_GENDER_2']}</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_RANKS_NEEDPOSTS']}</b><br />{\$lang->items['LANG_ACP_RANKS_NEEDPOSTS_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"quantity\\\" value=\\\"\\\" maxlength=\\\"30\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_RANKS_RANKIMAGES']}</b><br />{\$lang->items['LANG_ACP_RANKS_RANKIMAGES_DESC']}</td>
   <td><textarea cols=\\\"50\\\" rows=\\\"15\\\" name=\\\"images\\\"></textarea></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
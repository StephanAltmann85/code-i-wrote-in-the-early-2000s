<?php
/*
acp template
templatename: board_permissions
*/

$this->templates['acp_board_permissions']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>

<form method=\\\"get\\\" action=\\\"board.php\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"boardid\\\" value=\\\"\$boardid\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_BOARD_PERMISSIONS_TITLE']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_BOARD_PERMISSIONS_GROUP']}</td>
   <td><select name=\\\"groupid\\\" onchange=\\\"window.location=('board.php?action=\$action&amp;boardid=\$boardid&amp;sid=\$session[hash]&amp;groupid='+this.options[this.selectedIndex].value)\\\">
    <option value=\\\"0\\\">{\$lang->items['LANG_ACP_GLOBAL_PLEASE_SELECT']}</option>
    \$group_options
   </select>&nbsp;<input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_GO']}\\\" /></td>
  </tr>
 </table>
</form>


\".((\$permissionbit!=\"\") 
 ? (\"
  <br />
  <form method=\\\"post\\\" action=\\\"board.php\\\">
  <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
  <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
  <input type=\\\"hidden\\\" name=\\\"boardid\\\" value=\\\"\$boardid\\\" />
  <input type=\\\"hidden\\\" name=\\\"groupid\\\" value=\\\"\$groupid\\\" />
  <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
   <tr class=\\\"tblhead\\\">
    <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_BOARD_PERMISSIONS']}</td>
   </tr>
   \$permissionbit
   <tr class=\\\"tblsection\\\">
    <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
   </tr>
  </table>
  </form>
 \") : (\"\")
).\"
</body>
</html>";
?>
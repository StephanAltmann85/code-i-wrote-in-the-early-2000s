<?php
/*
acp template
templatename: adminsessions
*/

$this->templates['acp_adminsessions']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"content-type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>

<form method=\\\"post\\\" action=\\\"otherstuff.php\\\">
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"page\\\" value=\\\"\$page\\\" />
<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"\".(3 + 2*(int)checkAdminPermissions(\"a_can_view_ipaddress\") + (int)checkAdminPermissions(\"a_can_otherstuff_adminsessions_kicksession\")).\"\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_OTHERSTUFF_ADMINSESSIONS']}</td>
  </tr>
  <tr class=\\\"tblsection\\\" align=\\\"center\\\">
   \".((checkAdminPermissions(\"a_can_otherstuff_adminsessions_kicksession\")) ? (\"<td>&nbsp;</td>\") : (\"\")).\"
   <td>{\$lang->items['LANG_ACP_OTHERSTUFF_ADMINSESSIONS_USERNAME']}</td>
   <td>{\$lang->items['LANG_ACP_OTHERSTUFF_ADMINSESSIONS_STARTTIME']}</td>
   <td nowrap=\\\"nowrap\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_ADMINSESSIONS_LASTACTIVITY']}</td>
   \".((checkAdminPermissions(\"a_can_view_ipaddress\")) ? (\"<td nowrap=\\\"nowrap\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_ADMINSESSIONS_IPADDRESS']}</td>
   <td>{\$lang->items['LANG_ACP_OTHERSTUFF_ADMINSESSIONS_USERAGENT']}</td>\") : (\"\")).\"
  </tr>
  \$sessionbit
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"\".(3 + 2*(int)checkAdminPermissions(\"a_can_view_ipaddress\") + (int)checkAdminPermissions(\"a_can_otherstuff_adminsessions_kicksession\")).\"\\\">
   <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" width=\\\"100%\\\">
    <tr>
     <td>\".((checkAdminPermissions(\"a_can_otherstuff_adminsessions_kicksession\")) ? (\"<input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_OTHERSTUFF_ADMINSESSIONS_DELETE']}\\\" /> <input type=\\\"submit\\\" name=\\\"all\\\" value=\\\"{\$lang->items['LANG_ACP_OTHERSTUFF_ADMINSESSIONS_DELETEALL']}\\\" />\") : (\"&nbsp;\")).\"</td>
     <td align=\\\"right\\\"><select name=\\\"sortby\\\">
      <option value=\\\"\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_ADMINSESSIONS_SORTBY']}</option>
      <option value=\\\"username\\\"\$s_sortby[username]>{\$lang->items['LANG_ACP_OTHERSTUFF_ADMINSESSIONS_USERNAME']}</option>
      <option value=\\\"starttime\\\"\$s_sortby[starttime]>{\$lang->items['LANG_ACP_OTHERSTUFF_ADMINSESSIONS_STARTTIME']}</option>
      <option value=\\\"lastactivity\\\"\$s_sortby[lastactivity]>{\$lang->items['LANG_ACP_OTHERSTUFF_ADMINSESSIONS_LASTACTIVITY']}</option>
      \".((checkAdminPermissions(\"a_can_view_ipaddress\")) ? (\"<option value=\\\"ipaddress\\\"\$s_sortby[ipaddress]>{\$lang->items['LANG_ACP_OTHERSTUFF_ADMINSESSIONS_IPADDRESS']}</option>
      <option value=\\\"useragent\\\"\$s_sortby[useragent]>{\$lang->items['LANG_ACP_OTHERSTUFF_ADMINSESSIONS_USERAGENT']}</option>\") : (\"\")).\"
     </select> <select name=\\\"sortorder\\\">
      <option value=\\\"\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_ADMINSESSIONS_SORTORDER']}</option>
      <option value=\\\"ASC\\\"\$s_sortorder[ASC]>{\$lang->items['LANG_ACP_OTHERSTUFF_ADMINSESSIONS_SORTORDER_ASC']}</option>
      <option value=\\\"DESC\\\"\$s_sortorder[DESC]>{\$lang->items['LANG_ACP_OTHERSTUFF_ADMINSESSIONS_SORTORDER_DESC']}</option>
     </select> <input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_OTHERSTUFF_ADMINSESSIONS_SORT']}\\\" /></td>
    </tr>
   </table>
   </td>
  </tr>
 </table>
 <p align=\\\"center\\\">\$pagelink</p>
</form>
</body>
</html>";
?>
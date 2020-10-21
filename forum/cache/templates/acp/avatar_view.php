<?php
/*
acp template
templatename: avatar_view
*/

$this->templates['acp_avatar_view']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>

<form method=\\\"post\\\" action=\\\"avatar.php\\\">
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"view\\\" />
<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
 <tr class=\\\"tblhead\\\">
  <td colspan=\\\"\$colspan\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_AVATAR_EDIT']}</td>
 </tr>
 <tr class=\\\"tblsection\\\" align=\\\"center\\\">
  <td nowrap=\\\"nowrap\\\">{\$lang->items['LANG_ACP_AVATAR_AVATAR']}</td>
  <td width=\\\"50%\\\" nowrap=\\\"nowrap\\\">{\$lang->items['LANG_ACP_AVATAR_AVATARNAME']}</td>
  <td width=\\\"50%\\\" nowrap=\\\"nowrap\\\">\".((\$_REQUEST['sortby']!=\"1\") ? (\"{\$lang->items['LANG_ACP_AVATAR_GROUP']}\") : (\"{\$lang->items['LANG_ACP_AVATAR_USER']}\")).\"</td>
  \".((\$_REQUEST['sortby']!=\"1\") ? (\"<td nowrap=\\\"nowrap\\\">{\$lang->items['LANG_ACP_AVATAR_POSTS']}</td>\") : (\"\")).\"
  \".((\$_REQUEST['sortby']!=\"1\" && checkAdminPermissions(\"a_can_avatars_edit\")) ? (\"<td nowrap=\\\"nowrap\\\">{\$lang->items['LANG_ACP_GLOBAL_EDIT']}</td>\") : (\"\")).\"
  \".((checkAdminPermissions(\"a_can_avatars_del\")) ? (\"<td nowrap=\\\"nowrap\\\">{\$lang->items['LANG_ACP_GLOBAL_DELETE']}</td>\") : (\"\")).\"
 </tr>
 
 \$avatar_viewbit
  
 <tr class=\\\"tblsection\\\" align=\\\"center\\\">
  <td colspan=\\\"\$colspan\\\">{\$lang->items['LANG_ACP_AVATAR_SHOW']}<br />\$pagelink</td>
 </tr>
 <tr align=\\\"center\\\" class=\\\"tblsection\\\">
  <td colspan=\\\"\$colspan\\\">
   <select name=\\\"sortby\\\">
    <option value=\\\"0\\\"\$sel_sortby[0]>{\$lang->items['LANG_ACP_AVATAR_ACPAVATAR']}</option>
    <option value=\\\"1\\\"\$sel_sortby[1]>{\$lang->items['LANG_ACP_AVATAR_USERAVATAR']}</option>
   </select>
   &nbsp;
   <select name=\\\"orderby\\\">
    <option value=\\\"ASC\\\"\$sel_orderby[ASC]>{\$lang->items['LANG_ACP_AVATAR_UP']}</option>
    <option value=\\\"DESC\\\"\$sel_orderby[DESC]>{\$lang->items['LANG_ACP_AVATAR_DOWN']}</option>
   </select>
   &nbsp;
   <input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_AVATAR_GO']}\\\" />
  </td>
 </tr>
</table>
</form>
</body>
</html>";
?>
<?php
/*
acp template
templatename: sync_show
*/

$this->templates['acp_sync_show']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />

<script type=\\\"text/javascript\\\">
 <!--
  function select_all(status) {
   var sbox = document.bbform.elements[2];
   for(i=0;i<sbox.options.length;i++) sbox.options[i].selected=status;
  }
 //-->
</script>

</head>
<body>
 <form method=\\\"post\\\" action=\\\"users.php\\\" name=\\\"bbform\\\">
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_MISC_SYNC_CLIPBOARD_USER']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"70%\\\"><select name=\\\"userid[]\\\" size=\\\"\$sboxsize\\\" style=\\\"width:95%\\\" multiple=\\\"multiple\\\">
    \$users
   </select></td>
   <td width=\\\"30%\\\" valign=\\\"top\\\" style=\\\"text-align:justify\\\"><p>&nbsp;</p>
    {\$lang->items['LANG_ACP_MISC_SYNC_SELECT']}
    <p><a href=\\\"javascript:select_all(true);\\\">{\$lang->items['LANG_ACP_MISC_SYNC_MARK_ALL']}</a></p>
    <p><a href=\\\"javascript:select_all(false);\\\">{\$lang->items['LANG_ACP_MISC_SYNC_DEMARK_ALL']}</a></p>
    </td>
  </tr>
 </table>
 <table align=\\\"right\\\">
 <tr>
  <td><select name=\\\"action\\\">
   <option value=\\\"-1\\\">{\$lang->items['LANG_ACP_USERS_SELECT_ACTION']}</option>
   \".((checkAdminPermissions(\"a_can_users_email\")) ? (\"<option value=\\\"email\\\">{\$lang->items['LANG_ACP_USERS_ACTION_EMAIL']}</option>\") : (\"\")).\"
   \".((checkAdminPermissions(\"a_can_users_delete\")) ? (\"<option value=\\\"delete\\\">{\$lang->items['LANG_ACP_USERS_ACTION_DELETE']}</option>\") : (\"\")).\"
   \".((checkAdminPermissions(\"a_can_users_access\")) ? (\"<option value=\\\"access\\\">{\$lang->items['LANG_ACP_USERS_ACTION_ACCESS']}</option>\") : (\"\")).\"
   \".((checkAdminPermissions(\"a_can_users_edit\")) ? (\"<option value=\\\"activate\\\">{\$lang->items['LANG_ACP_USERS_ACTION_ACTIVATION']}</option>\") : (\"\")).\"
   \".((checkAdminPermissions(\"a_can_users_other\")) ? (\"<option value=\\\"activation_email\\\">{\$lang->items['LANG_ACP_USERS_ACTION_ACTIVATION_EMAIL']}</option>\") : (\"\")).\"
   \".((checkAdminPermissions(\"a_can_users_other\")) ? (\"<option value=\\\"selectstats\\\">{\$lang->items['LANG_ACP_USERS_ACTION_STATS']}</option>\") : (\"\")).\"
   \".((checkAdminPermissions(\"a_can_users_merge\")) ? (\"<option value=\\\"merge\\\">{\$lang->items['LANG_ACP_USERS_ACTION_MERGE']}</option>\") : (\"\")).\"
  </select> <input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_GO']}\\\" /></td>
 </tr>
</table></form>
</body>
</html>";
?>
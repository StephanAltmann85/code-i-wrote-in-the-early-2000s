<?php
/*
acp template
templatename: group_viewbit
*/

$this->templates['acp_group_viewbit']="<tr class=\\\"\$rowclass\\\">
 <td>\$row[groupid]</td>
 <td width=\\\"100%\\\"><b>\$row[title]</b></td>
 <td>\$row[count]</td>
 <td nowrap=\\\"nowrap\\\"><form action=\\\"group.php\\\" method=\\\"post\\\">
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\">
 <select name=\\\"groupaction\\\" onchange=\\\"groupAction(this)\\\">
  <option value=\\\"\\\">{\$lang->items['LANG_ACP_GROUP_ACTIONS']}</option>
  <option value=\\\"\\\">--------------------</option>
  \".((checkAdminPermissions(\"a_can_groups_add\") || checkAdminPermissions(\"a_can_groups_add_own\")) ? (\"<option value=\\\"group.php?action=edit&amp;groupid=\$row[groupid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GROUP_ACTION_EDIT']}</option>\") : (\"\")).\"
  \".((checkAdminPermissions(\"a_can_groups_del\")) ? (\"<option value=\\\"group.php?action=del&amp;groupid=\$row[groupid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GROUP_ACTION_DEL']}</option>\") : (\"\")).\"
  \".((checkAdminPermissions(\"a_can_groups_add\")) ? (\"<option value=\\\"group.php?action=copy&amp;groupid=\$row[groupid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GROUP_ACTION_COPY']}</option>\") : (\"\")).\"
  \".((checkAdminPermissions(\"a_can_boards_permissions\")) ? (\"<option value=\\\"group.php?action=permissions&amp;groupid=\$row[groupid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GROUP_ACTION_PERMISSIONS']}</option>\") : (\"\")).\"
  \".((checkAdminPermissions(\"a_can_users_edit\") || checkAdminPermissions(\"a_can_users_delete\") || checkAdminPermissions(\"a_can_users_merge\") || checkAdminPermissions(\"a_can_users_access\") || checkAdminPermissions(\"a_can_users_other\") || checkAdminPermissions(\"a_can_users_activation\")) ? (\"<option value=\\\"users.php?action=show&amp;groupid=\$row[groupid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GROUP_ACTION_SHOW_MEMBERS']}</option>\") : (\"\")).\"
  \".((checkAdminPermissions(\"a_can_users_email\") && \$row[count]) ? (\"<option value=\\\"group.php?action=email&amp;groupid=\$row[groupid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GROUP_ACTION_EMAIL']}</option>\") : (\"\")).\"
  \".((checkAdminPermissions(\"a_can_groups_pmsend\") && checkAdminPermissions(\"a_can_users_email\")) ? (\"<option value=\\\"group.php?action=pmsend&amp;groupids[]=\$row[groupid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GROUP_ACTION_PMSEND']}</option>\") : (\"\")).\"
  \".((\$group_options!=\"\") 
   ? (\"  
	  <option value=\\\"\\\">--------------------</option>
	  <option value=\\\"\\\">{\$lang->items['LANG_ACP_GROUP_ACTION_EDIT_RIGHTS']}</option>
	  \$group_options
   \") : (\"\")
  ).\"
 </select>&nbsp;<input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_GO']}\\\" /></form></td>
</tr>";
?>
<?php
/*
acp template
templatename: profilefield_viewbit
*/

$this->templates['acp_profilefield_viewbit']="<tr class=\\\"\$rowclass\\\">
 <td width=\\\"100%\\\"><b>\$row[title] (\$row[fieldorder])</b></td>
 \".((checkAdminPermissions(\"a_can_profilefield_edit\")) ? (\"<td><a href=\\\"profilefield.php?action=edit&amp;profilefieldid=\$row[profilefieldid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_EDIT']}</a></td>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_profilefield_del\")) ? (\"<td><a href=\\\"profilefield.php?action=del&amp;profilefieldid=\$row[profilefieldid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_DELETE']}</a></td>\") : (\"\")).\"
</tr>";
?>
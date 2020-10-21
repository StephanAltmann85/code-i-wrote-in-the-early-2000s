<?php
/*
acp template
templatename: smilie_viewbit
*/

$this->templates['acp_smilie_viewbit']="<tr class=\\\"\$rowclass\\\">
 <td>\$smiliepathimage</td>
 <td width=\\\"100%\\\"><b>\$row[smilietitle] (\$row[smilieorder])</b></td>
 <td align=\\\"center\\\">\$row[smiliecode]</td>
 \".((checkAdminPermissions(\"a_can_smilie_edit\")) ? (\"<td><a href=\\\"smilie.php?action=edit&amp;smilieid=\$row[smilieid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_EDIT']}</a></td>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_smilie_del\")) ? (\"<td><a href=\\\"smilie.php?action=del&amp;smilieid=\$row[smilieid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_DELETE']}</a></td>\") : (\"\")).\"
</tr>";
?>
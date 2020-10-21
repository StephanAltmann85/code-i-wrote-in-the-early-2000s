<?php
/*
acp template
templatename: icon_viewbit
*/

$this->templates['acp_icon_viewbit']="<tr class=\\\"\$rowclass\\\">
 <td>\$iconpathimage</td>
 <td width=\\\"100%\\\"><b>\$row[icontitle] (\$row[iconorder])</b></td>
 \".((checkAdminPermissions(\"a_can_icon_edit\")) ? (\"<td><a href=\\\"icon.php?action=edit&amp;iconid=\$row[iconid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_EDIT']}</a></td>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_icon_del\")) ? (\"<td><a href=\\\"icon.php?action=del&amp;iconid=\$row[iconid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_DELETE']}</a></td>\") : (\"\")).\"
</tr>";
?>
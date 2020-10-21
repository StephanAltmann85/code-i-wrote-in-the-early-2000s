<?php
/*
acp template
templatename: style_viewbit
*/

$this->templates['acp_style_viewbit']="<tr class=\\\"\$rowclass\\\">
 <td width=\\\"33%\\\"><b>\$row[stylename]</b></td>
 <td width=\\\"33%\\\"><b>\$row[templatepackname]</b></td>
 <td width=\\\"33%\\\"><b>\$row[designpackname]</b></td>
 \".((checkAdminPermissions(\"a_can_style_edit\")) ? (\"<td nowrap=\\\"nowrap\\\"><a href=\\\"style.php?action=edit&amp;styleid=\$row[styleid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_EDIT']}</a></td>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_style_del\")) ? (\"<td nowrap=\\\"nowrap\\\"><a href=\\\"style.php?action=del&amp;styleid=\$row[styleid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_DELETE']}</a></td>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_style_export\")) ? (\"<td nowrap=\\\"nowrap\\\"><a href=\\\"style.php?action=export&amp;styleid=\$row[styleid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_EXPORT']}</a></td>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_style_edit\")) ? (\"<td nowrap=\\\"nowrap\\\"><a href=\\\"style.php?action=default&amp;styleid=\$row[styleid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_SETDEFAULT']}</a>&nbsp;\$star</td>\") : (\"\")).\"
</tr>";
?>
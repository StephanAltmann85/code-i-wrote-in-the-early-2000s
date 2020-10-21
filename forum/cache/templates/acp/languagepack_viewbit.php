<?php
/*
acp template
templatename: languagepack_viewbit
*/

$this->templates['acp_languagepack_viewbit']="<tr class=\\\"\$rowclass\\\">
 <td width=\\\"100%\\\"><b>\$row[languagepackname] (\$row[languages])</b></td>
 \".((checkAdminPermissions(\"a_can_languagepack_edit\")) ? (\"<td><a href=\\\"languagepack.php?action=edit&amp;languagepackid=\$row[languagepackid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_EDIT']}</a></td>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_languagepack_translate\")) ? (\"<td><a href=\\\"languagepack.php?action=translate&amp;languagepackid=\$row[languagepackid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_LANGUAGEPACK_TRANSLATE']}</a></td>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_languagepack_add\")) ? (\"<td><a href=\\\"languagepack.php?action=add&amp;mode=copy&amp;languagepackid=\$row[languagepackid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_COPY']}</a></td>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_languagepack_del\")) ? (\"<td><a href=\\\"languagepack.php?action=del&amp;languagepackid=\$row[languagepackid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_DELETE']}</a></td>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_languagepack_export\")) ? (\"<td><a href=\\\"languagepack.php?action=export&amp;languagepackid=\$row[languagepackid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_EXPORT']}</a></td>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_languagepack_edit\")) ? (\"<td><a href=\\\"languagepack.php?action=default&amp;languagepackid=\$row[languagepackid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_SETDEFAULT']}</a>\".((\$row['languagepackid']==0) ? (\"&nbsp;&nbsp;*\") : (\"\")).\"</td>\") : (\"\")).\"
</tr>";
?>
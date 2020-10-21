<?php
/*
acp template
templatename: avatar_viewbit
*/

$this->templates['acp_avatar_viewbit']="<tr class=\\\"\$rowclass\\\">
 <td>\$avatarimage</td>
 <td align=\\\"center\\\">\$row[avatarname].\$row[avatarextension]</td>
 <td align=\\\"center\\\">\$row[title]</td>
 <td align=\\\"center\\\">\$row[needposts]</td>
 \".((checkAdminPermissions(\"a_can_avatars_edit\")) ? (\"<td align=\\\"center\\\"><a href=\\\"avatar.php?action=edit&amp;avatarid=\$row[avatarid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_EDIT']}</a></td>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_avatars_del\")) ? (\"<td align=\\\"center\\\"><a href=\\\"avatar.php?action=del&amp;avatarid=\$row[avatarid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_DELETE']}</a></td>\") : (\"\")).\"
</tr>";
?>
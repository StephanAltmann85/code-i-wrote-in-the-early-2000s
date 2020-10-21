<?php
/*
acp template
templatename: avatar_viewbit2
*/

$this->templates['acp_avatar_viewbit2']="<tr class=\\\"\$rowclass\\\">
 <td>\$avatarimage</td>
 <td align=\\\"center\\\">\$row[avatarname].\$row[avatarextension]</td>
 <td align=\\\"center\\\"><a href=\\\"../profile.php?userid=\$row[userid]\\\" target=\\\"_blank\\\">\$row[username]</a></td>
 \".((checkAdminPermissions(\"a_can_avatars_del\")) ? (\"<td align=\\\"center\\\"><a href=\\\"avatar.php?action=del&amp;avatarid=\$row[avatarid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_DELETE']}</a></td>\") : (\"\")).\"
</tr>";
?>
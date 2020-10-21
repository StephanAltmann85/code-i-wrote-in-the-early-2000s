<?php
/*
acp template
templatename: bbcodes_viewbit
*/

$this->templates['acp_bbcodes_viewbit']="<tr class=\\\"\$rowclass\\\">
 <td width=\\\"100%\\\"><b>\$row[bbcodetag]</b></td>
 \".((checkAdminPermissions(\"a_can_bbcodes_edit\")) ? (\"<td nowrap=\\\"nowrap\\\"><a href=\\\"bbcodes.php?action=edit&amp;bbcodeid=\$row[bbcodeid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_EDIT']}</a></td>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_bbcodes_del\")) ? (\"<td nowrap=\\\"nowrap\\\"><a href=\\\"bbcodes.php?action=del&amp;bbcodeid=\$row[bbcodeid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_DELETE']}</a></td>\") : (\"\")).\"
</tr>";
?>
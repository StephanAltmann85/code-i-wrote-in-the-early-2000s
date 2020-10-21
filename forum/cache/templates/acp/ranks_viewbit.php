<?php
/*
acp template
templatename: ranks_viewbit
*/

$this->templates['acp_ranks_viewbit']="<tr class=\\\"\$rowclass\\\">
 <td width=\\\"100%\\\"><b>\$row[ranktitle]</b></td>
 \".((checkAdminPermissions(\"a_can_ranks_edit\")) ? (\"<td nowrap=\\\"nowrap\\\"><a href=\\\"ranks.php?action=edit&amp;rankid=\$row[rankid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_EDIT']}</a></td>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_ranks_del\")) ? (\"<td nowrap=\\\"nowrap\\\"><a href=\\\"ranks.php?action=del&amp;rankid=\$row[rankid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_DELETE']}</a></td>\") : (\"\")).\"
</tr>";
?>
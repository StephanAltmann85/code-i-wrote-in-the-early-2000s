<?php
/*
acp template
templatename: board_moderator_view_moderatorbit
*/

$this->templates['acp_board_moderator_view_moderatorbit']="<tr class=\\\"\$rowclass\\\" align=\\\"center\\\">
 <td align=\\\"left\\\" width=\\\"100%\\\"><a href=\\\"../profile.php?userid=\$row[userid]\\\" target=\\\"_blank\\\">\$row[username]</a></td>
 <td nowrap=\\\"nowrap\\\"><a href=\\\"board.php?action=editmoderator&amp;boardid=\$boardid&amp;userid=\$row[userid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_EDIT']}</a></td>
 <td nowrap=\\\"nowrap\\\"><a href=\\\"board.php?action=delmoderator&amp;boardid=\$boardid&amp;userid=\$row[userid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_DELETE']}</a></td>
</tr>";
?>
<?php
/*
acp template
templatename: board_viewbit
*/

$this->templates['acp_board_viewbit']="<tr>
 \$tds
 <td colspan=\\\"\$colspan\\\" class=\\\"firstrow\\\" width=\\\"100%\\\"><select name=\\\"boardorder[\$boards[boardid]]\\\">\$options</select>&nbsp;<b><a href=\\\"../board.php?boardid=\$boards[boardid]\\\" target=\\\"_blank\\\">\$boards[title]</a></b></td>
 <td class=\\\"secondrow\\\">
 <select name=\\\"boardaction[]\\\" onchange=\\\"boardAction(this)\\\">
  <option value=\\\"\\\">{\$lang->items['LANG_ACP_GLOBAL_PLEASE_SELECT']}</option>
  <option value=\\\"\\\">--------------------</option>
  \".((checkAdminPermissions(\"a_can_boards_edit\")) ? (\"<option value=\\\"board.php?action=edit&amp;boardid=\$boards[boardid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_EDIT']}</option>\") : (\"\")).\"
  \".((checkAdminPermissions(\"a_can_boards_del\")) ? (\"<option value=\\\"board.php?action=del&amp;boardid=\$boards[boardid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_DELETE']}</option>\") : (\"\")).\"
  \".((checkAdminPermissions(\"a_can_boards_empty\")) ? (\"<option value=\\\"board.php?action=empty&amp;boardid=\$boards[boardid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_EMPTY']}</option>\") : (\"\")).\"
  \".((checkAdminPermissions(\"a_can_boards_permissions\")) ? (\"<option value=\\\"board.php?action=permissions&amp;boardid=\$boards[boardid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_BOARD_PERMISSIONS']}</option>\") : (\"\")).\"
  \".((checkAdminPermissions(\"a_can_boards_rights\")) ? (\"<option value=\\\"board.php?action=rights&amp;boardid=\$boards[boardid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_BOARD_RIGHTS']}</option>\") : (\"\")).\"
  \".((checkAdminPermissions(\"a_can_moderator_add\")) ? (\"<option value=\\\"board.php?action=addmoderator&amp;boardid=\$boards[boardid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_BOARD_MODERATOR_ADD']}</option>\") : (\"\")).\"
  \".((checkAdminPermissions(\"a_can_moderator_edit\") || checkAdminPermissions(\"a_can_moderator_del\")) ? (\"<option value=\\\"board.php?action=viewmoderator&amp;boardid=\$boards[boardid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_BOARD_MODERATOR_EDIT']}</option>\") : (\"\")).\"
 </select>&nbsp;<input type=\\\"submit\\\" name=\\\"submit_boardaction\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_GO']}\\\" /></td>
</tr>";
?>
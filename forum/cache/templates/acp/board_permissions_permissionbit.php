<?php
/*
acp template
templatename: board_permissions_permissionbit
*/

$this->templates['acp_board_permissions_permissionbit']="<tr class=\\\"\$rowclass\\\">
 <td>\$row[title]</td>
 <td><select name=\\\"permission[\$row[Field]]\\\">
  <option value=\\\"-1\\\" \$selected[2]>{\$lang->items['LANG_ACP_BOARD_USEGLOBAL']}</option>
  <option value=\\\"1\\\" \$selected[1]>{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
  <option value=\\\"0\\\" \$selected[0]>{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
 </select></td>
</tr>";
?>
<?php
/*
acp template
templatename: locator_bit
*/

$this->templates['acp_locator_bit']="<tr class=\\\"\$rowclass\\\">
 <td width=\\\"80\\\" align=\\\"center\\\">(\$row[x];\$row[y])</td>
 <td width=\\\"220\\\"><b>\$row[username]</b></td>
 <td align=\\\"left\\\">\$row[postcode] \$row[residence]</td>
 <td width=\\\"60\\\" align=\\\"center\\\"><a href=\\\"locator.php?action=delete&sid=\$session[hash]&userid=\$row[userid]\\\" onClick=\\\"return Message('{\$lang->items['LANG_ACP_LOCATOR_DELETE_REQUEST']}')\\\">X</a></td>
</tr>";
?>
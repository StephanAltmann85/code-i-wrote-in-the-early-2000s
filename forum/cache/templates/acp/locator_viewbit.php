<?php
/*
acp template
templatename: locator_viewbit
*/

$this->templates['acp_locator_viewbit']="<tr class=\\\"\$rowclass\\\">
 <td width=\\\"80\\\" align=\\\"center\\\">(\$x;\$y)</td>
 <td width=\\\"120\\\"><b>\$username</b></td>
 <td align=\\\"center\\\">\$postal \$location</td>
 <td width=\\\"60\\\"><a href=\\\"locator.php?action=del&sid=\$session[hash]&id=\$id\\\">Entfernen</a></td>
</tr>";
?>
<?php
/*
acp template
templatename: adminsession_bit
*/

$this->templates['acp_adminsession_bit']="<tr class=\\\"\$rowclass\\\">
 \".((checkAdminPermissions(\"a_can_otherstuff_adminsessions_kicksession\")) ? (\"<td><input type=\\\"checkbox\\\" name=\\\"kicksession[]\\\" value=\\\"\$row[sessionhash]\\\"\$disabled /></td>\") : (\"\")).\"
 <td align=\\\"center\\\" width=\\\"100%\\\"><a href=\\\"../profile.php?userid=\$row[userid]\\\" target=\\\"_blank\\\">\$row[username]</a></td>
 <td align=\\\"center\\\" nowrap=\\\"nowrap\\\">\$row[starttime]</td>
 <td align=\\\"center\\\" nowrap=\\\"nowrap\\\">\$row[lastactivity]</td>
 \".((checkAdminPermissions(\"a_can_view_ipaddress\")) ? (\"<td align=\\\"center\\\" nowrap=\\\"nowrap\\\">\$row[ipaddress]</td>
 <td nowrap=\\\"nowrap\\\">\$row[useragent]</td>\") : (\"\")).\"
</tr>";
?>
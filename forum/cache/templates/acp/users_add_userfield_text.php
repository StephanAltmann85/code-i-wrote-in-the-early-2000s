<?php
/*
acp template
templatename: users_add_userfield_text
*/

$this->templates['acp_users_add_userfield_text']="<tr class=\\\"\$rowclass\\\">
 <td><b>\$row[title]:</b><br />\$row[description]</td>
 <td><input type=\\\"text\\\" name=\\\"field[\$row[profilefieldid]]\\\" value=\\\"\$field_value\\\" maxlength=\\\"\$row[maxlength]\\\" size=\\\"\$row[fieldsize]\\\" /></td>
</tr>";
?>
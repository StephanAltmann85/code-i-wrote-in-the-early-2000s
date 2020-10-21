<?php
/*
acp template
templatename: users_add_userfield_checkbox
*/

$this->templates['acp_users_add_userfield_checkbox']="<tr class=\\\"\$rowclass\\\">
 <td><b>\$row[title]:</b><br />\$row[description]</td>
 <td><input type=\\\"checkbox\\\" name=\\\"field[\$row[profilefieldid]]\\\" value=\\\"\$field_value\\\"\$field_checked /></td>
</tr>";
?>
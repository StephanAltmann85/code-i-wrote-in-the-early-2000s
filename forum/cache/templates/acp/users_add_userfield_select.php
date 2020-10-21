<?php
/*
acp template
templatename: users_add_userfield_select
*/

$this->templates['acp_users_add_userfield_select']="<tr class=\\\"\$rowclass\\\">
 <td><b>\$row[title]:</b><br />\$row[description]</td>
 <td>
 <select name=\\\"field[\$row[profilefieldid]]\\\">\$field_value</select>
 </td>
</tr>";
?>
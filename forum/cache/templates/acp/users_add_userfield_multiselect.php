<?php
/*
acp template
templatename: users_add_userfield_multiselect
*/

$this->templates['acp_users_add_userfield_multiselect']="<tr class=\\\"\$rowclass\\\">
 <td><b>\$row[title]:</b><br />\$row[description]</td>
 <td>
 <select name=\\\"field[\$row[profilefieldid]][]\\\" multiple=\\\"multiple\\\">\$field_value</select>
 </td>
</tr>";
?>
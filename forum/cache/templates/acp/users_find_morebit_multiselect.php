<?php
/*
acp template
templatename: users_find_morebit_multiselect
*/

$this->templates['acp_users_find_morebit_multiselect']="<tr class=\\\"\$rowclass\\\">
 <td>\$LANG_SEARCHFIELD_PROFILEFIELD</td>
 <td>
 <select name=\\\"profilefield[\$row[profilefieldid]][]\\\" multiple=\\\"multiple\\\">
 \$field_options
 </select>
 </td>
</tr>";
?>
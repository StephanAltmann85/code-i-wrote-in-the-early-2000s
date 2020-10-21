<?php
/*
acp template
templatename: users_add_userfield_date
*/

$this->templates['acp_users_add_userfield_date']="<tr class=\\\"\$rowclass\\\">
 <td><b>\$row[title]:</b><br />\$row[description]</td>
 <td>
<table>
     <tr>
      <td>{\$lang->items['LANG_REGISTER_BIRTHDAY_DAY']}</td>
      <td>{\$lang->items['LANG_REGISTER_BIRTHDAY_MONTH']}</td>
      <td>{\$lang->items['LANG_REGISTER_BIRTHDAY_YEAR']}</td>
     </tr>
     <tr>
      <td><select name=\\\"dayfield[\$row[profilefieldid]]\\\">
       \$dayfield_value
      </select></td>
      <td><select name=\\\"monthfield[\$row[profilefieldid]]\\\">
       \$monthfield_value
      </select></td>
      <td><input type=\\\"text\\\" class=\\\"input\\\" name=\\\"yearfield[\$row[profilefieldid]]\\\" value=\\\"\$yearfield_value\\\" maxlength=\\\"4\\\" size=\\\"5\\\" /></td>
     </tr>
    </table> 
 </td>
</tr>";
?>
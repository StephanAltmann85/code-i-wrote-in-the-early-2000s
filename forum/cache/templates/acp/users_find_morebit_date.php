<?php
/*
acp template
templatename: users_find_morebit_date
*/

$this->templates['acp_users_find_morebit_date']="<tr class=\\\"\$rowclass\\\">
 <td>\$LANG_SEARCHFIELD_PROFILEFIELD</td>
 <td>
  <table>
     <tr>
      <td>{\$lang->items['LANG_MEMBERS_MBS_DATE_DAY']}</td>
      <td>{\$lang->items['LANG_MEMBERS_MBS_DATE_MONTH']}</td>
      <td>{\$lang->items['LANG_MEMBERS_MBS_DATE_YEAR']}</td>
     </tr>
     <tr>
      <td><select name=\\\"dayfield[\$row[profilefieldid]]\\\">
       \$dayfield_value
      </select></td>
      <td><select name=\\\"monthfield[\$row[profilefieldid]]\\\">
       \$monthfield_value
      </select></td>
      <td><input type=\\\"text\\\" class=\\\"input\\\" name=\\\"yearfield[\$row[profilefieldid]]\\\" maxlength=\\\"4\\\" size=\\\"5\\\" /></td>
     </tr>
    </table> 
 </td>
</tr>";
?>
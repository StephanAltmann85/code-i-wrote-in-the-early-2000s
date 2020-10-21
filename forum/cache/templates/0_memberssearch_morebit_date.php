<?php
			/*
			templatepackid: 0
			templatename: memberssearch_morebit_date
			*/
			
			$this->templates['memberssearch_morebit_date']="<tr align=\\\"left\\\">
 <td class=\\\"\$rowclass\\\"><span class=\\\"normalfont\\\">\$LANG_SEARCHFIELD_PROFILEFIELD</span></td>
 <td class=\\\"\$rowclass\\\"><table>
     <tr align=\\\"left\\\">
      <td><span class=\\\"smallfont\\\">{\$lang->items['LANG_MEMBERS_MBS_DATE_DAY']}</span></td>
      <td><span class=\\\"smallfont\\\">{\$lang->items['LANG_MEMBERS_MBS_DATE_MONTH']}</span></td>
      <td><span class=\\\"smallfont\\\">{\$lang->items['LANG_MEMBERS_MBS_DATE_YEAR']}</span></td>
     </tr>
     <tr align=\\\"left\\\">
      <td><select name=\\\"dayfield[\$row[profilefieldid]]\\\">
       \$dayfield_value
      </select></td>
      <td><select name=\\\"monthfield[\$row[profilefieldid]]\\\">
       \$monthfield_value
      </select></td>
      <td><input type=\\\"text\\\" class=\\\"input\\\" name=\\\"yearfield[\$row[profilefieldid]]\\\" maxlength=\\\"4\\\" size=\\\"5\\\" /></td>
     </tr>
    </table></td>
</tr>";
			?>
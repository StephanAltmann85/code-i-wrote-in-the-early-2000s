<?php
			/*
			templatepackid: 0
			templatename: register_userfield_date
			*/
			
			$this->templates['register_userfield_date']="  <tr align=\\\"left\\\">
    <td class=\\\"\$tdclass\\\"><span class=\\\"normalfont\\\"><b>\$row[title]:</b></span><br /><span class=\\\"smallfont\\\">\$row[description]</span></td>
    <td class=\\\"\$tdclass\\\"><table>
     <tr>
      <td><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_BIRTHDAY_DAY']}</span></td>
      <td><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_BIRTHDAY_MONTH']}</span></td>
      <td><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_BIRTHDAY_YEAR']}</span></td>
     </tr>
     <tr>
      <td><select name=\\\"dayfield[\$row[profilefieldid]]\\\">
       <option value=\\\"0\\\"></option>
       \$dayfield_value
      </select></td>
      <td><select name=\\\"monthfield[\$row[profilefieldid]]\\\">
       <option value=\\\"0\\\"></option>
       \$monthfield_value
      </select></td>
      <td><input type=\\\"text\\\" class=\\\"input\\\" name=\\\"yearfield[\$row[profilefieldid]]\\\" value=\\\"\$yearfield_value\\\" maxlength=\\\"4\\\" size=\\\"5\\\" /></td>
     </tr>
    </table></td>
   </tr>";
			?>
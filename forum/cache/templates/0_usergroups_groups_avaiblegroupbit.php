<?php
			/*
			templatepackid: 0
			templatename: usergroups_groups_avaiblegroupbit
			*/
			
			$this->templates['usergroups_groups_avaiblegroupbit']="   <tr align=\\\"left\\\">
    <td class=\\\"\$tdclass\\\" style=\\\"width:20%\\\"><span class=\\\"normalfont\\\">\$group[title]</span>\".((\$groupleaderbit!=\"\") 
     ? (\"<span class=\\\"smallfont\\\"><br />({\$lang->items['LANG_USERGROUPS_GROUPS_GROUPLEADERS']} \$groupleaderbit)</span>\") : (\"\")
    ).\"</td>
    <td class=\\\"\$tdclass\\\" style=\\\"width:30%\\\"><span class=\\\"smallfont\\\">\$group[description]&nbsp;</span></td>
    <td class=\\\"\$tdclass\\\" style=\\\"width:30%\\\"><span class=\\\"smallfont\\\">\$grouptype</span></td>
    <td class=\\\"\$tdclass\\\" style=\\\"width:20%\\\"><span class=\\\"smallfont\\\"><a href=\\\"usergroups.php?action=join&amp;groupid=\$group[groupid]{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERGROUPS_GROUPS_JOINGROUP']}</a></span></td>
   </tr>";
			?>
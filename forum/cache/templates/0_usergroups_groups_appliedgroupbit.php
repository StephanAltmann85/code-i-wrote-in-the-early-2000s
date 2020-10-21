<?php
			/*
			templatepackid: 0
			templatename: usergroups_groups_appliedgroupbit
			*/
			
			$this->templates['usergroups_groups_appliedgroupbit']="   <tr align=\\\"left\\\">
    <td class=\\\"\$tdclass\\\" style=\\\"width:20%\\\"><span class=\\\"normalfont\\\">\$group[title]</span>\".((\$groupleaderbit!=\"\") 
     ? (\"<span class=\\\"smallfont\\\"><br />({\$lang->items['LANG_USERGROUPS_GROUPS_GROUPLEADERS']} \$groupleaderbit)</span>\") : (\"\")
    ).\"</td>
    <td class=\\\"\$tdclass\\\" style=\\\"width:30%\\\"><span class=\\\"smallfont\\\">\$group[description]&nbsp;</span></td>
    <td class=\\\"\$tdclass\\\" style=\\\"width:30%\\\"><span class=\\\"smallfont\\\">\$senddate <span class=\\\"time\\\">\$sendtime</span></span></td>
    <td class=\\\"\$tdclass\\\" style=\\\"width:20%\\\"><span class=\\\"smallfont\\\"><a href=\\\"usergroups.php?action=editapplication&amp;applicationid=\$group[applicationid]{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERGROUPS_GROUPS_APPLICATIONDETAILS']}</a></span></td>
   </tr>";
			?>
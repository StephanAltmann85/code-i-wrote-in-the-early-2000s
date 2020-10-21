<?php
			/*
			templatepackid: 0
			templatename: usergroups_groups_memberships
			*/
			
			$this->templates['usergroups_groups_memberships']="   <tr align=\\\"left\\\">
    <td class=\\\"\$tdclass\\\" style=\\\"width:20%\\\"><span class=\\\"normalfont\\\">\$group[title]</span>\".((\$groupleaderbit!=\"\") 
     ? (\"<span class=\\\"smallfont\\\"><br />({\$lang->items['LANG_USERGROUPS_GROUPS_GROUPLEADERS']} \$groupleaderbit)</span>\") : (\"\")
    ).\"</td>
    <td class=\\\"\$tdclass\\\" style=\\\"width:30%\\\"><span class=\\\"smallfont\\\">\$group[description]&nbsp;</span></td>
    <td class=\\\"\$tdclass\\\" style=\\\"width:30%\\\"><span class=\\\"smallfont\\\">\$grouptype</span></td>
    <td class=\\\"\$tdclass\\\" style=\\\"width:20%\\\"><span class=\\\"smallfont\\\">
	\".((\$group[grouptype]>4 && \$group[grouptype]<7) 
		? (\"<a href=\\\"usergroups.php?action=leave&amp;groupid=\$group[groupid]{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERGROUPS_GROUPS_LEAVEGROUP']}</a>\") 
		: (\"&nbsp;\")
	).\"
	</span></td>
   </tr>";
			?>
<?php
			/*
			templatepackid: 0
			templatename: usergroups_groupleaders_applicationbit
			*/
			
			$this->templates['usergroups_groupleaders_applicationbit']="   <tr align=\\\"left\\\">
    <td class=\\\"\$tdclass\\\">\$new</td>
    <td class=\\\"\$tdclass\\\" style=\\\"width:30%\\\"><span class=\\\"normalfont\\\"><a href=\\\"profile.php?userid=\$application[userid]{\$SID_ARG_2ND}\\\" target=\\\"_blank\\\">\$application[username]</a></span></td>
    <td class=\\\"\$tdclass\\\" style=\\\"width:30%\\\"><span class=\\\"normalfont\\\">\$application[title]</span></td>
    <td class=\\\"\$tdclass\\\" style=\\\"width:20%\\\"><span class=\\\"normalfont\\\">\$senddate <span class=\\\"time\\\">\$sendtime</span></span></td>
    <td class=\\\"\$tdclass\\\" style=\\\"width:20%\\\"><span class=\\\"normalfont\\\"><a href=\\\"usergroups.php?action=groupleaders_editapplication&amp;applicationid=\$application[applicationid]{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERGROUPS_GROUPLEADERS_EDIT_APPLICATION']}</a></span></td>
   </tr>";
			?>
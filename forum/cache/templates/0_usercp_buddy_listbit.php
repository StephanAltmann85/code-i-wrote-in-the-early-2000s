<?php
			/*
			templatepackid: 0
			templatename: usercp_buddy_listbit
			*/
			
			$this->templates['usercp_buddy_listbit']="<tr align=\\\"left\\\">
       <td class=\\\"tablea\\\">\".((\$row['online']) 
        ? (\"<img src=\\\"{\$style['imagefolder']}/user_online.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_USERONLINE}\\\" title=\\\"{\$LANG_MEMBERS_USERONLINE}\\\" />\") 
        : (\"<img src=\\\"{\$style['imagefolder']}/user_offline.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_USERONLINE}\\\" title=\\\"{\$LANG_MEMBERS_USERONLINE}\\\" />\")
       ).\"</td>
       <td class=\\\"tableb\\\" style=\\\"width:100%\\\"><span class=\\\"normalfont\\\"><a href=\\\"profile.php?userid=\$row[userid]{\$SID_ARG_2ND}\\\">\$row[username]</a></span></td>
       <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><a href=\\\"pms.php?action=newpm&amp;userid=\$row[userid]{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERCP_BUDDY_LIST_PM']}</a></span></td>
       <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><a href=\\\"usercp.php?action=buddy&amp;remove=\$row[userid]{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERCP_LIST_REMOVE']}</a></span></td>
      </tr>";
			?>
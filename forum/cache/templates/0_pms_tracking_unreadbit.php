<?php
			/*
			templatepackid: 0
			templatename: pms_tracking_unreadbit
			*/
			
			$this->templates['pms_tracking_unreadbit']="<tr>
 <td class=\\\"tablea\\\"><img src=\\\"{\$style['imagefolder']}/pm_unread.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_PMS_UNREAD_MESSAGE']}\\\" title=\\\"{\$lang->items['LANG_PMS_UNREAD_MESSAGE']}\\\" /></td>
 <td class=\\\"tableb\\\">\$icon</td>
 <td class=\\\"tablea\\\" style=\\\"width:60%\\\"><span class=\\\"normalfont\\\">\$row[subject]</span></td>
 <td class=\\\"tableb\\\" style=\\\"width:20%\\\" align=\\\"center\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"1\\\" border=\\\"0\\\"><tr><td>\".((\$user_online==1) 
        ? (\"<img src=\\\"{\$style['imagefolder']}/user_online.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_USERONLINE}\\\" title=\\\"{\$LANG_MEMBERS_USERONLINE}\\\" />\") 
        : (\"<img src=\\\"{\$style['imagefolder']}/user_offline.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_USEROFFLINE}\\\" title=\\\"{\$LANG_MEMBERS_USEROFFLINE}\\\" />\")
       ).\"&nbsp;</td><td nowrap=\\\"nowrap\\\"><span class=\\\"normalfont\\\"><a href=\\\"profile.php?userid=\$row[recipientid]{\$SID_ARG_2ND}\\\">\$row[username]</a></span></td></tr></table></td>
 <td class=\\\"tablea\\\" style=\\\"width:20%\\\" align=\\\"center\\\" nowrap=\\\"nowrap\\\"><span class=\\\"normalfont\\\">\$senddate <span class=\\\"time\\\">\$sendtime</span></span></td>
 <td class=\\\"tableb\\\"><input type=\\\"checkbox\\\" name=\\\"pmid[]\\\" value=\\\"\$row[privatemessageid]-\$row[recipientid]\\\" /></td>
</tr>";
			?>
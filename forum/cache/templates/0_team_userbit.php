<?php
			/*
			templatepackid: 0
			templatename: team_userbit
			*/
			
			$this->templates['team_userbit']="<tr align=\\\"left\\\">
 <td class=\\\"tableb\\\" nowrap=\\\"nowrap\\\">\".((\$user_online==1) 
        ? (\"<img src=\\\"{\$style['imagefolder']}/user_online.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_USERONLINE}\\\" title=\\\"{\$LANG_MEMBERS_USERONLINE}\\\" />\") 
        : (\"<img src=\\\"{\$style['imagefolder']}/user_offline.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_USERONLINE}\\\" title=\\\"{\$LANG_MEMBERS_USERONLINE}\\\" />\")
       ).\"</td>
 <td class=\\\"tablea\\\" nowrap=\\\"nowrap\\\" style=\\\"width:100%\\\"><span class=\\\"normalfont\\\"><b><a href=\\\"profile.php?userid=\$user[userid]{\$SID_ARG_2ND}\\\">\$user[username]</a></b></span></td>
 <td class=\\\"tableb\\\" nowrap=\\\"nowrap\\\" style=\\\"width:100%\\\"><span class=\\\"normalfont\\\">
 
 \".((\$user['showemail'] == 1) ? (\"<a href=\\\"mailto:\$user[email]\\\"><img src=\\\"{\$style['imagefolder']}/email.gif\\\" border=\\\"0\\\" alt=\\\"\$LANG_MEMBERS_SENDEMAIL\\\" title=\\\"\$LANG_MEMBERS_SENDEMAIL\\\" /></a>\") 
 : (\"
  \".((\$user['usercanemail'] == 1) ? (\"<a href=\\\"formmail.php?userid=\$user[userid]{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/email.gif\\\" border=\\\"0\\\" alt=\\\"\$LANG_MEMBERS_SENDEMAIL\\\" title=\\\"\$LANG_MEMBERS_SENDEMAIL\\\" /></a>\") 
  : (\"&nbsp;\")
  ).\"
 \")
 ).\"
 
 </span></td>
 <td class=\\\"tablea\\\" nowrap=\\\"nowrap\\\"><span class=\\\"normalfont\\\">\".((\$wbbuserdata['can_use_pms']==1 && \$user['receivepm']==1) ? (\"<a href=\\\"pms.php?action=newpm&amp;userid=\$user[userid]{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/pm.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_PM}\\\" title=\\\"{\$LANG_MEMBERS_PM}\\\" /></a>\") : (\"&nbsp;\")).\"</span></td> 
</tr>";
			?>
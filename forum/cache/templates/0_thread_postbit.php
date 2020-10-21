<?php
			/*
			templatepackid: 0
			templatename: thread_postbit
			*/
			
			$this->templates['thread_postbit']="<table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\"><tr>\".((\$indentwidth!=0) ? (\"<td><img src=\\\"{\$style['imagefolder']}/spacer.gif\\\" height=\\\"10\\\" width=\\\"\$indentwidth\\\" border=\\\"0\\\" alt=\\\"\\\" title=\\\"\\\" /></td>\") : (\"\")).\"<td width=\\\"100%\\\"><table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:100%\\\" class=\\\"tableinborder\\\">
 <tr align=\\\"left\\\">	
  <td class=\\\"\$tdclass\\\" valign=\\\"top\\\"><a name=\\\"post\$posts[postid]\\\" id=\\\"post\$posts[postid]\\\"></a>
   <table style=\\\"width:100%\\\" cellpadding=\\\"4\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" class=\\\"{\$tdclass}_fc\\\">
    <tr>
     <td style=\\\"width:100%\\\" class=\\\"smallfont\\\">\".((\$posts['userid']) ? (\"<span class=\\\"normalfont\\\"><b><a href=\\\"profile.php?userid=\$posts[userid]{\$SID_ARG_2ND}\\\">\$posts[username]</a></b></span> \".((\$posts['gender'] == 1) ? (\"<img src=\\\"{\$style['imagefolder']}/male.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_THREAD_MALE}\\\" title=\\\"{\$LANG_THREAD_MALE}\\\" />\") : (\"\")).\"
     \".((\$posts['gender'] == 2) ? (\"<img src=\\\"{\$style['imagefolder']}/female.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_THREAD_FEMALE}\\\" title=\\\"{\$LANG_THREAD_FEMALE}\\\" />\") : (\"\")).\"<br />
      \$posts[ranktitle]
        \".((\$rankimages!=\"\") ? (\"<br />\$rankimages\") : (\"\")).\"
        \".((\$useravatar!=\"\") ? (\"<br /><br />\$useravatar\") : (\"\")).\"<br /><br />
	\".((\$showregdateinthread==1) ? (\"{\$lang->items['LANG_THREAD_REGDATE']} \$posts[regdate]<br />\") : (\"\")).\"
	\".((\$showuserpostsinthread==1) ? (\"{\$lang->items['LANG_THREAD_USERPOSTS']} \$posts[userposts]<br />\") : (\"\")).\"
	\$userfields
	\$userrating
	\".((\$userlevel) ? (\"<br />\$userlevel\") : (\"\")).\"
	\".((\$threadstarter==1) ? (\"<br />{\$lang->items['LANG_THREAD_THREADSTARTER']} <img src=\\\"{\$style['imagefolder']}/threadstarter.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_THREAD_THREADSTARTER_ALT}\\\" title=\\\"{\$LANG_THREAD_THREADSTARTER_ALT}\\\" />\") : (\"\")).\"
	 \") 
	 : (\"<span class=\\\"normalfont\\\"><b>\$posts[username]</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_THREAD_UNREGISTERED']}</span>\")
	 ).\"
     <br /><img src=\\\"{\$style['imagefolder']}/spacer.gif\\\" width=\\\"159\\\" height=\\\"1\\\" border=\\\"0\\\" alt=\\\"\\\" title=\\\"\\\" /></td>
    </tr>
   </table>
  </td>
  <td class=\\\"\$tdclass\\\" valign=\\\"top\\\" style=\\\"width:100%\\\">
   <table style=\\\"width:100%\\\" cellpadding=\\\"4\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" class=\\\"{\$tdclass}_fc\\\">
    <tr>
     <td style=\\\"width:100%\\\" class=\\\"normalfont\\\" align=\\\"left\\\">
      <table style=\\\"width:100%\\\" cellpadding=\\\"4\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" class=\\\"{\$tdclass}_fc\\\">
       <tr>
        <td><span class=\\\"smallfont\\\">\$posticon <b>\$posts[posttopic]</b></span></td>
        <td align=\\\"right\\\" nowrap=\\\"nowrap\\\"><a href=\\\"addreply.php?postid=\$posts[postid]{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/replypost.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_THREAD_REPLYPOST']}\\\" title=\\\"{\$lang->items['LANG_THREAD_REPLYPOST']}\\\" /></a> <a href=\\\"addreply.php?action=quote&amp;postid=\$posts[postid]{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/quote.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_THREAD_QUOTE']}\\\" title=\\\"{\$lang->items['LANG_THREAD_QUOTE']}\\\" /></a> <a href=\\\"editpost.php?postid=\$posts[postid]{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/editpost.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_THREAD_EDITPOST']}\\\" title=\\\"{\$lang->items['LANG_THREAD_EDITPOST']}\\\" /></a> <a href=\\\"report.php?postid=\$posts[postid]{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/report.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_THREAD_REPORT']}\\\" title=\\\"{\$lang->items['LANG_THREAD_REPORT']}\\\" /></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\".((\$wbbuserdata['a_can_view_ipaddress']==1) ? (\"<a href=\\\"misc.php?action=viewip&amp;postid=\$posts[postid]{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/ip.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_THREAD_VIEWIP']}\\\" title=\\\"{\$lang->items['LANG_THREAD_VIEWIP']}\\\" /></a> \") : (\"\")).\"<a href=\\\"javascript:self.scrollTo(0,0);\\\"><img src=\\\"{\$style['imagefolder']}/goup.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_THREAD_GOUP']}\\\" title=\\\"{\$lang->items['LANG_THREAD_GOUP']}\\\" /></a></td>
       </tr>
      </table><hr size=\\\"{\$style['tableincellspacing']}\\\" class=\\\"threadline\\\" />
      \$posts[message]
      \$attachments
      \$signature
      \".((\$posts['editorid']) ? (\"<p><span class=\\\"smallfont\\\">{\$LANG_THREAD_EDITOR}</span></p>\") : (\"\")).\"
      \".((\$invisible==1) ? (\"<p align=\\\"right\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_THREAD_INVISIBLE']}</span></p>\") : (\"\")).\"
     </td>
    </tr>
   </table>
  </td>
 </tr>
 <tr>
  <td class=\\\"\$tdclass\\\" align=\\\"center\\\" nowrap=\\\"nowrap\\\"><span class=\\\"smallfont\\\">
   \".((\$newpost==1) 
    ? (\"<a href=\\\"thread.php?postid=\$posts[postid]#post\$posts[postid]\\\"><img src=\\\"{\$style['imagefolder']}/posticonnew.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_THREAD_NEWPOST']}\\\" title=\\\"{\$lang->items['LANG_THREAD_NEWPOST']}\\\" /></a>\") 
    : (\"<a href=\\\"thread.php?postid=\$posts[postid]#post\$posts[postid]\\\"><img src=\\\"{\$style['imagefolder']}/posticon.gif\\\" border=\\\"0\\\" alt=\\\"\\\" title=\\\"\\\" /></a>\")
   ).\"  
   \$postdate <span class=\\\"time\\\">\$posttime</span></span></td>
  <td class=\\\"\$tdclass\\\" align=\\\"left\\\" style=\\\"width:100%\\\" valign=\\\"middle\\\"><span class=\\\"smallfont\\\">
   \".((\$posts['userid']) 
    ? (\"
     \".((\$showonlineinthread==1) 
      ? (\"
       \".((\$user_online==1) 
        ? (\"<img src=\\\"{\$style['imagefolder']}/user_online.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_USERONLINE}\\\" title=\\\"{\$LANG_MEMBERS_USERONLINE}\\\" />\") 
        : (\"<img src=\\\"{\$style['imagefolder']}/user_offline.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_USERONLINE}\\\" title=\\\"{\$LANG_MEMBERS_USERONLINE}\\\" />\")
       ).\"
      \") : (\"\")
     ).\"
     
     \".((\$posts['showemail']==1) 
      ? (\"<a href=\\\"mailto:\$posts[email]\\\"><img src=\\\"{\$style['imagefolder']}/email.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_SENDEMAIL}\\\" title=\\\"{\$LANG_MEMBERS_SENDEMAIL}\\\" /></a>\") 
      : (\"
       \".((\$posts['usercanemail']==1) 
        ? (\"<a href=\\\"formmail.php?userid=\$posts[userid]{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/email.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_SENDEMAIL}\\\" title=\\\"{\$LANG_MEMBERS_SENDEMAIL}\\\" /></a>\") : (\"\")
       ).\"
      \")
     ).\"
     
     \".((\$posts['homepage']) 
      ? (\"<a href=\\\"\$posts[homepage]\\\" target=\\\"_blank\\\"><img src=\\\"{\$style['imagefolder']}/www.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_HOMEPAGE}\\\" title=\\\"{\$LANG_MEMBERS_HOMEPAGE}\\\" /></a>\") : (\"\")
     ).\"
   
     <a href=\\\"search.php?action=user&amp;userid=\$posts[userid]{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/search.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_SEARCH}\\\" title=\\\"{\$LANG_MEMBERS_SEARCH}\\\" /></a>
  
     <a href=\\\"usercp.php?action=buddy&amp;add=\$posts[userid]{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/homie.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_BUDDY}\\\" title=\\\"{\$LANG_MEMBERS_BUDDY}\\\" /></a>
    
     \".((\$posts['receivepm']==1 && \$wbbuserdata['can_use_pms']==1) ? (\"<a href=\\\"pms.php?action=newpm&amp;userid=\$posts[userid]{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/pm.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_PM}\\\" title=\\\"{\$LANG_MEMBERS_PM}\\\" /></a>\") : (\"\")).\"
     
     \".((\$posts['icq']) ? (\"<a href=\\\"http://web.icq.com/whitepages/add_me/1,,,00.icq?uin=\$posts[icq]&amp;action=add\\\"><img src=\\\"http://web.icq.com/whitepages/online?icq=\$posts[icq]&amp;img=5\\\" width=\\\"18\\\" height=\\\"18\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_ICQ}\\\" title=\\\"{\$LANG_MEMBERS_ICQ}\\\" /></a>\") : (\"\")).\"
     
     \".((\$posts['aim']) ? (\"<a href=\\\"aim:goim?screenname=\$posts[aim]&amp;message=Hi.+Are+you+there?\\\"><img src=\\\"{\$style['imagefolder']}/aim.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_AIM}\\\" title=\\\"{\$LANG_MEMBERS_AIM}\\\" /></a>\") : (\"\")).\"
     
     \".((\$posts['yim']) ? (\"<a href=\\\"http://edit.yahoo.com/config/send_webmesg?.target=\$posts[yim]&amp;.src=pg\\\"><img src=\\\"{\$style['imagefolder']}/yim.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_YIM}\\\" title=\\\"{\$LANG_MEMBERS_YIM}\\\" /></a>\") : (\"\")).\"
     
     \".((\$posts['msn']) ? (\"<a href=\\\"http://members.msn.com/?mem=\$posts[msn]\\\"><img src=\\\"{\$style['imagefolder']}/msn.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_MEMBERS_MSN}\\\" title=\\\"{\$LANG_MEMBERS_MSN}\\\" /></a>\") : (\"\")).\"
     
    \") : (\"\")
   ).\" 
  </span></td>
 </tr>
</table></td></tr></table>";
			?>
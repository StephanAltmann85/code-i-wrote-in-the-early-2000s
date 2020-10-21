<?php
			/*
			templatepackid: 0
			templatename: profile
			*/
			
			$this->templates['profile']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_MEMBERS_PROFILE_TITLE']}</title>
\$headinclude

<script type=\\\"text/javascript\\\">
<!--
function rating(userid) {
 window.open(\\\"misc.php?action=userrating&userid=\\\"+userid+\\\"{\$SID_ARG_2ND_UN}\\\", \\\"moo\\\", \\\"toolbar=no,scrollbars=yes,resizable=yes,width=350,height=205\\\");
}
//-->
</script>
</head>

<body>
 \$header
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; {\$lang->items['LANG_MEMBERS_PROFILE_TITLE']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td> 
 </tr> 
</table><br />
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tabletitle_fc\\\">
    <td style=\\\"width:100%\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_TITLE']}</b></span></td>
    <td style=\\\"width:200px\\\" align=\\\"center\\\" nowrap=\\\"nowrap\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_CAPTION']}</b></span></td>
   </tr>
  </table></td>
 </tr>
 <tr>
  <td class=\\\"tablea\\\" style=\\\"width:100%\\\"><table style=\\\"width:100%\\\" class=\\\"tablea_fc\\\">
   <tr align=\\\"left\\\">
    <td><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_REGDATE']}</b></span></td>
    <td><span class=\\\"normalfont\\\">\$regdate</span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td valign=\\\"top\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_RANK']}</b></span></td>
    <td><span class=\\\"normalfont\\\">\$user_info[ranktitle] \$rankimages</span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_POSTS']}</b></span></td>
    <td><span class=\\\"normalfont\\\">\$user_info[userposts] ({\$lang->items['LANG_MEMBERS_PROFILE_POSTSPERDAY']})</span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_LASTACTIVITY']}</b></span></td>
    <td><span class=\\\"normalfont\\\">\$la_date <span class=\\\"{time}\\\">\$la_time</span></span></td>
   </tr>
   
   \".((\$userlocation!=\"\") 
   ? (\"
   <tr align=\\\"left\\\">
    <td><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_LOCATION']}</b></span></td>
    <td><span class=\\\"normalfont\\\">\$userlocation</span></td>
   </tr>
   \") : (\"\")
   ).\"
   
   \".((\$showlastpost==1) 
    ? (\"
     <tr align=\\\"left\\\">
      <td><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_LASTPOST']}</b></span></td>
      <td><span class=\\\"normalfont\\\"><b>&raquo; <a href=\\\"thread.php?postid=\$lastpost[postid]{\$SID_ARG_2ND}#post\$lastpost[postid]\\\">\$lastpost[topic]</a></b></span><br />
      <span class=\\\"smallfont\\\">{\$lang->items['LANG_MEMBERS_PROFILE_POSTED_ON']} \$lastpostdate <span class=\\\"time\\\">\$lastposttime</span><br />
      {\$lang->items['LANG_MEMBERS_PROFILE_FORUM']} <b><a href=\\\"board.php?boardid=\$lastpost[boardid]{\$SID_ARG_2ND}\\\">\$lastpost[title]</a></b></span></td>
     </tr>
    \") : (\"\")
   ).\"

   \".((\$showlanguageinprofile==1) 
   ? (\"
   <tr align=\\\"left\\\">
    <td><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_LANGUAGE']}</b></span></td>
    <td><span class=\\\"normalfont\\\">\$languagepackname</span></td>
   </tr>
   \") : (\"\")
   ).\"
   
   <tr>
    <td align=\\\"left\\\" colspan=\\\"2\\\"><hr size=\\\"{\$style['tableincellspacing']}\\\" class=\\\"threadline\\\" /></td>
   </tr>
   <tr align=\\\"left\\\">
    <td><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_ICQ']}</b></span></td>
    <td><span class=\\\"normalfont\\\">\$user_info[icq]</span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_AIM']}</b></span></td>
    <td><span class=\\\"normalfont\\\">\$user_info[aim]</span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_YIM']}</b></span></td>
    <td><span class=\\\"normalfont\\\">\$user_info[yim]</span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_MSN']}</b></span></td>
    <td><span class=\\\"normalfont\\\">\$user_info[msn]</span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_EMAIL']}</b></span></td>
    <td><span class=\\\"normalfont\\\">\$useremail</span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_HOMEPAGE']}</b></span></td>
    <td><span class=\\\"normalfont\\\">\$userhomepage</span></td>
   </tr>
   <tr>
    <td align=\\\"left\\\" colspan=\\\"2\\\"><hr size=\\\"{\$style['tableincellspacing']}\\\" class=\\\"threadline\\\" /></td>
   </tr>
   <tr align=\\\"left\\\">
    <td><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_GENDER']}</b></span></td>
    <td><span class=\\\"normalfont\\\">\$gender</span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_BIRTHDAY']}</b></span></td>
    <td><span class=\\\"normalfont\\\">\$birthday</span></td>
   </tr>
   \".((\$profilefields) 
    ? (\"
     <tr>
      <td align=\\\"left\\\" colspan=\\\"2\\\"><hr size=\\\"{\$style['tableincellspacing']}\\\" class=\\\"threadline\\\" /></td>
     </tr>
    \") : (\"\")
   ).\"
   \$profilefields					
  </table></td>
  <td class=\\\"tableb\\\" style=\\\"width:200px\\\" align=\\\"center\\\">\$useravatar<br /><span class=\\\"normalfont\\\">\$user_text</span>\$userrating<br />\$userlevel<p>\".((\$user_online==1) 
    ? (\"<img src=\\\"{\$style['imagefolder']}/user_online.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_MEMBERS_USERONLINE']}\\\" title=\\\"{\$lang->items['LANG_MEMBERS_USERONLINE']}\\\" />\") 
    : (\"<img src=\\\"{\$style['imagefolder']}/user_offline.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_MEMBERS_USEROFFLINE']}\\\" title=\\\"{\$lang->items['LANG_MEMBERS_USEROFFLINE']}\\\" />\")
   ).\"</p><img src=\\\"{\$style['imagefolder']}/spacer.gif\\\" width=\\\"159\\\" height=\\\"1\\\" border=\\\"0\\\" alt=\\\"\\\" title=\\\"\\\" /></td>
 </tr>
 <tr>
  <td class=\\\"tabletitle\\\" colspan=\\\"2\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tabletitle_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_CONTACT']}</b></span></td>
    <td align=\\\"right\\\">
    
    \".((\$user_info['showemail']==0 && \$user_info['usercanemail']==1) 
     ? (\"<a href=\\\"formmail.php?userid=\$user_info[userid]{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/email.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_MEMBERS_SENDEMAIL']}\\\" title=\\\"{\$lang->items['LANG_MEMBERS_SENDEMAIL']}\\\" /></a>\") : (\"\")
    ).\" 
    
    \".((\$user_info['receivepm']==1 && \$wbbuserdata['can_use_pms']==1) ? (\"<a href=\\\"pms.php?action=newpm&amp;userid=\$user_info[userid]{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/pm.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_MEMBERS_PM']}\\\" title=\\\"{\$lang->items['LANG_MEMBERS_PM']}\\\" /></a>\") : (\"\")).\"
        
    <a href=\\\"search.php?action=user&amp;userid=\$user_info[userid]{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/search.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_MEMBERS_SEARCH']}\\\" title=\\\"{\$lang->items['LANG_MEMBERS_SEARCH']}\\\" /></a>
      
    <a href=\\\"usercp.php?action=buddy&amp;add=\$user_info[userid]{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/homie.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_MEMBERS_BUDDY']}\\\" title=\\\"{\$lang->items['LANG_MEMBERS_BUDDY']}\\\" /></a></td>
   </tr>
  </table></td>
 </tr>
</table>
\".((checkAdminPermissions(\"a_can_users_edit\") || checkAdminPermissions(\"a_can_users_delete\")) 
? (\"
<p align=\\\"center\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_MEMBERS_PROFILE_ADMINOPTIONS']}</b> 
 \".((checkAdminPermissions(\"a_can_users_edit\")) ? (\"<a href=\\\"acp/index.php?url=users.php%3Faction%3Dedit%26userid%3D\$user_info[userid]\\\" target=\\\"_blank\\\">{\$lang->items['LANG_MEMBERS_PROFILE_USEREDIT']}</a>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_users_edit\") && checkAdminPermissions(\"a_can_users_delete\")) ? (\" | \") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_users_delete\")) ? (\"<a href=\\\"acp/index.php?url=users.php%3Faction%3Ddelete%26userid%5B%5D%3D\$user_info[userid]\\\" target=\\\"_blank\\\">{\$lang->items['LANG_MEMBERS_PROFILE_USERDEL']}</a>\") : (\"\")).\"</span></p>
\") : (\"\")
).\"
\$footer
</body>
</html>";
			?>
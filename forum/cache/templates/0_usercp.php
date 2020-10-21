<?php
			/*
			templatepackid: 0
			templatename: usercp
			*/
			
			$this->templates['usercp']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']}</title>
\$headinclude
</head>
<body>
\$header
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; {\$lang->items['LANG_USERCP_TITLE']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" colspan=\\\"3\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_OVERVIEW']}</b></span></td>
 </tr>
 <tr align=\\\"center\\\">
  <td class=\\\"tablea\\\" style=\\\"width:33%\\\">
   <a href=\\\"usercp.php?action=profile_edit{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/usercp_profile_edit.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_USERCP_PROFILE_EDIT']}\\\" title=\\\"{\$lang->items['LANG_USERCP_PROFILE_EDIT']} - {\$lang->items['LANG_USERCP_PROFILE_EDIT_DESC']}\\\" /></a><br />
   <span class=\\\"normalfont\\\"><b><a href=\\\"usercp.php?action=profile_edit{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERCP_PROFILE_EDIT']}</a></b></span><br />
   <span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_PROFILE_EDIT_DESC']}</span></td>
  <td class=\\\"tableb\\\" style=\\\"width:33%\\\">
   <a href=\\\"usercp.php?action=signature_edit{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/usercp_signature_edit.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_USERCP_SIGNATURE_EDIT']}\\\" title=\\\"{\$lang->items['LANG_USERCP_SIGNATURE_EDIT']} - {\$lang->items['LANG_USERCP_SIGNATURE_EDIT_DESC']}\\\" /></a><br />
   <span class=\\\"normalfont\\\"><b><a href=\\\"usercp.php?action=signature_edit{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERCP_SIGNATURE_EDIT']}</a></b></span><br />
   <span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_SIGNATURE_EDIT_DESC']}</span></td>
  <td class=\\\"tablea\\\" style=\\\"width:33%\\\">
   <a href=\\\"usercp.php?action=options_change{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/usercp_options_change.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_USERCP_OPTIONS_CHANGE']}\\\" title=\\\"{\$lang->items['LANG_USERCP_OPTIONS_CHANGE']} - {\$lang->items['LANG_USERCP_OPTIONS_CHANGE_DESC']}\\\" /></a><br />
   <span class=\\\"normalfont\\\"><b><a href=\\\"usercp.php?action=options_change{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERCP_OPTIONS_CHANGE']}</a></b></span><br />
   <span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_OPTIONS_CHANGE_DESC']}</span></td>
 </tr>
 <tr align=\\\"center\\\">
  <td class=\\\"tableb\\\" style=\\\"width:33%\\\">
   <a href=\\\"usercp.php?action=password_change{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/usercp_password_change.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_USERCP_PASSWORD_CHANGE']}\\\" title=\\\"{\$lang->items['LANG_USERCP_PASSWORD_CHANGE']} - {\$lang->items['LANG_USERCP_PASSWORD_CHANGE_DESC']}\\\" /></a><br />
   <span class=\\\"normalfont\\\"><b><a href=\\\"usercp.php?action=password_change{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERCP_PASSWORD_CHANGE']}</a></b></span><br />
   <span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_PASSWORD_CHANGE_DESC']}</span></td>
  <td class=\\\"tablea\\\" style=\\\"width:33%\\\">
   <a href=\\\"usercp.php?action=email_change{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/usercp_email_change.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_USERCP_EMAIL_CHANGE']}\\\" title=\\\"{\$lang->items['LANG_USERCP_EMAIL_CHANGE']} - {\$lang->items['LANG_USERCP_EMAIL_CHANGE_DESC']}\\\" /></a><br />
   <span class=\\\"normalfont\\\"><b><a href=\\\"usercp.php?action=email_change{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERCP_EMAIL_CHANGE']}</a></b></span><br />
   <span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_EMAIL_CHANGE_DESC']}</span></td>
  <td class=\\\"tableb\\\" style=\\\"width:33%\\\">
   <a href=\\\"usercp.php?action=buddy_list{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/usercp_buddy_list.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_USERCP_BUDDY_LIST']}\\\" title=\\\"{\$lang->items['LANG_USERCP_BUDDY_LIST']} - {\$lang->items['LANG_USERCP_BUDDY_LIST_DESC']}\\\" /></a><br />
   <span class=\\\"normalfont\\\"><b><a href=\\\"usercp.php?action=buddy_list{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERCP_BUDDY_LIST']}</a></b></span><br />
   <span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_BUDDY_LIST_DESC']}</span></td>
 </tr>
 <tr align=\\\"center\\\">
  <td class=\\\"tablea\\\" style=\\\"width:33%\\\">
   <a href=\\\"usercp.php?action=ignore_list{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/usercp_ignore_list.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_USERCP_IGNORE_LIST']}\\\" title=\\\"{\$lang->items['LANG_USERCP_IGNORE_LIST']} - {\$lang->items['LANG_USERCP_IGNORE_LIST_DESC']}\\\" /></a><br />
   <span class=\\\"normalfont\\\"><b><a href=\\\"usercp.php?action=ignore_list{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERCP_IGNORE_LIST']}</a></b></span><br />
   <span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_IGNORE_LIST_DESC']}</span></td>
  <td class=\\\"tableb\\\" style=\\\"width:33%\\\">
   <a href=\\\"usercp.php?action=favorites{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/usercp_favorites.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_USERCP_FAVORITES']}\\\" title=\\\"{\$lang->items['LANG_USERCP_FAVORITES']} - {\$lang->items['LANG_USERCP_FAVORITES_DESC']}\\\" /></a><br />
   <span class=\\\"normalfont\\\"><b><a href=\\\"usercp.php?action=favorites{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERCP_FAVORITES']}</a></b></span><br />
   <span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_FAVORITES_DESC']}</span></td>
  <td class=\\\"tablea\\\" style=\\\"width:33%\\\">
   <a href=\\\"usercp.php?action=avatars{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/usercp_avatars.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_USERCP_AVATARS']}\\\" title=\\\"{\$lang->items['LANG_USERCP_AVATARS']} - {\$lang->items['LANG_USERCP_AVATARS_DESC']}\\\" /></a><br />
   <span class=\\\"normalfont\\\"><b><a href=\\\"usercp.php?action=avatars{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERCP_AVATARS']}</a></b></span><br />
   <span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_AVATARS_DESC']}</span></td>
 </tr>
 <tr align=\\\"center\\\">
  <td class=\\\"tableb\\\" style=\\\"width:33%\\\">
   <a href=\\\"pms.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['imagefolder']}/usercp_pm.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_PMS']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_PMS']} - {\$lang->items['LANG_USERCP_PMS_DESC']}\\\" /></a><br />
   <span class=\\\"normalfont\\\"><b><a href=\\\"pms.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_GLOBAL_PMS']}</a></b></span><br />
   <span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_PMS_DESC']}</span></td>
  <td class=\\\"tablea\\\" style=\\\"width:33%\\\">
   <a href=\\\"usercp.php?action=attachments{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/usercp_attachments.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_USERCP_ATTACHMENTS']}\\\" title=\\\"{\$lang->items['LANG_USERCP_ATTACHMENTS']} - {\$lang->items['LANG_USERCP_ATTACHMENTS_DESC']}\\\" /></a><br />
   <span class=\\\"normalfont\\\"><b><a href=\\\"usercp.php?action=attachments{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERCP_ATTACHMENTS']}</a></b></span><br />
   <span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_ATTACHMENTS_DESC']}</span></td>
  <td class=\\\"tableb\\\" style=\\\"width:33%\\\">
   <a href=\\\"usergroups.php?action=groups{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/usercp_usergroups.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_USERCP_USERGROUPS']}\\\" title=\\\"{\$lang->items['LANG_USERCP_USERGROUPS']} - {\$lang->items['LANG_USERCP_USERGROUPS_DESC']}\\\" /></a><br />
   <span class=\\\"normalfont\\\"><b><a href=\\\"usergroups.php?action=groups{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERCP_USERGROUPS']}</a></b></span><br />
   <span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_USERGROUPS_DESC']}</span></td>
 </tr>
 \".((\$wbbuserdata['isgroupleader']==1) 
  ? (\"
 <tr align=\\\"center\\\">
  <td class=\\\"tablea\\\" style=\\\"width:33%\\\">
     <a href=\\\"usergroups.php?action=groupleaders{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/usercp_groupleader.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_USERCP_GROUPLEADER']}\\\" title=\\\"{\$lang->items['LANG_USERCP_GROUPLEADER']} - {\$lang->items['LANG_USERCP_GROUPLEADER_DESC']}\\\" /></a><br />
     <span class=\\\"normalfont\\\"><b><a href=\\\"usergroups.php?action=groupleaders{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERCP_GROUPLEADER']}</a></b></span><br />
     <span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_GROUPLEADER_DESC']}</span>
  </td>
  <td class=\\\"tableb\\\" style=\\\"width:33%\\\">&nbsp;</td>
  <td class=\\\"tablea\\\" style=\\\"width:33%\\\">&nbsp;</td>
 </tr>
  \") : (\"\")
 ).\"
 
 
</table>
\$footer
</body>
</html>";
			?>
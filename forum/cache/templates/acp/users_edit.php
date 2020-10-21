<?php
/*
acp template
templatename: users_edit
*/

$this->templates['acp_users_edit']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<script type=\\\"text/javascript\\\">
 <!--
  function AvatarChange() {
   var avatars = document.userform.avatarid;
   if (avatars.options[avatars.selectedIndex].value == 0) {
    document.preview.src = '../images/spacer.gif';
   }
   else {
    var temp = avatars.options[avatars.selectedIndex].text.split(\\\".\\\");
    if (temp[temp.length - 1] == 'swf') document.preview.src = '../images/spacer.gif';
    else document.preview.src = '../images/avatars/avatar-'+ avatars.options[avatars.selectedIndex].value +'.'+ temp[temp.length - 1];
   }
  }
 //-->
</script>
</head>

<body>
<form method=\\\"post\\\" action=\\\"users.php\\\" name=\\\"userform\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"userid\\\" value=\\\"\$userid\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 \$error
 
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_USERS_EDIT_TITLE']}</td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_REGISTER_NEEDED_INFORMATION']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_USERNAME']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"username\\\" maxlength=\\\"50\\\" value=\\\"\$username\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_EMAILADDRESS']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"email\\\" maxlength=\\\"150\\\" value=\\\"\$email\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_PASSWORD']}</b></td>
   <td><input type=\\\"text\\\" value=\\\"********\\\" readonly=\\\"readonly\\\" /> <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_USERS_EDIT_PASSWORD_CHANGE']}\\\" onclick='window.open(\\\"users.php?action=pw&amp;userid=\$userid&amp;sid=\$session[hash]\\\", \\\"moo\\\", \\\"toolbar=no,scrollbars=yes,resizable=yes,width=400,height=200\\\");' /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_USERS_OTHER_USERGROUPS']}</b></td>
   <td><select name=\\\"groupids[]\\\" size=\\\"5\\\" multiple=\\\"multiple\\\">
    \$group_options
   </select></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_REGISTER_OTHER_INFORMATION']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_USERS_USERTITLE']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"title\\\" maxlength=\\\"50\\\" value=\\\"\$title\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_HOMEPAGE']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"homepage\\\" maxlength=\\\"250\\\" value=\\\"\$homepage\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_ICQ']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"icq\\\" maxlength=\\\"30\\\" value=\\\"\$icq\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_AIM']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"aim\\\" maxlength=\\\"30\\\" value=\\\"\$aim\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_YIM']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"yim\\\" maxlength=\\\"30\\\" value=\\\"\$yim\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_MSN']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"msn\\\" maxlength=\\\"30\\\" value=\\\"\$msn\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_BIRTHDAY']}</b></td>
   <td><table class=\\\"secondrow\\\">
     <tr>
      <td>{\$lang->items['LANG_REGISTER_BIRTHDAY_DAY']}</td>
      <td>{\$lang->items['LANG_REGISTER_BIRTHDAY_MONTH']}</td>
      <td>{\$lang->items['LANG_REGISTER_BIRTHDAY_YEAR']}</td>
     </tr>
     <tr>
      <td><select name=\\\"day\\\">
       <option value=\\\"0\\\"></option>
       \$day_options
      </select></td>
      <td><select name=\\\"month\\\">
       <option value=\\\"0\\\"></option>
       \$month_options
      </select></td>
      <td><input type=\\\"text\\\" class=\\\"input\\\" name=\\\"year\\\" value=\\\"\$year\\\" maxlength=\\\"4\\\" size=\\\"5\\\" /></td>
     </tr>
    </table></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_GENDER']}</b></td>
   <td><select name=\\\"gender\\\">
    <option value=\\\"0\\\">{\$lang->items['LANG_REGISTER_NODECLARATION']}</option>
    <option value=\\\"1\\\"\$sel_gender[1]>{\$lang->items['LANG_REGISTER_MALE']}</option>
    <option value=\\\"2\\\"\$sel_gender[2]>{\$lang->items['LANG_REGISTER_FEMALE']}</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td valign=\\\"top\\\"><b>{\$lang->items['LANG_REGISTER_USERTEXT']}</b></td>
   <td><textarea rows=\\\"7\\\" cols=\\\"55\\\" name=\\\"usertext\\\">\$usertext</textarea></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td valign=\\\"top\\\"><b>{\$lang->items['LANG_REGISTER_SIGNATURE']}</b><br />
   <br /><input type=\\\"checkbox\\\" name=\\\"disablesmilies\\\" id=\\\"checkbox1\\\" value=\\\"1\\\" \$checked[0] /><label for=\\\"checkbox1\\\"> {\$lang->items['LANG_REGISTER_DISABLESMILIES']}</label>
   <br /><input type=\\\"checkbox\\\" name=\\\"disablehtml\\\" id=\\\"checkbox2\\\" value=\\\"1\\\" \$checked[1] /><label for=\\\"checkbox2\\\"> {\$lang->items['LANG_REGISTER_DISABLEHTML']}</label>
   <br /><input type=\\\"checkbox\\\" name=\\\"disablebbcode\\\" id=\\\"checkbox3\\\" value=\\\"1\\\" \$checked[2] /><label for=\\\"checkbox3\\\"> {\$lang->items['LANG_REGISTER_DISABLEBBCODE']}</label>
   <br /><input type=\\\"checkbox\\\" name=\\\"disableimages\\\" id=\\\"checkbox4\\\" value=\\\"1\\\" \$checked[3] /><label for=\\\"checkbox4\\\"> {\$lang->items['LANG_REGISTER_DISABLEIMAGES']}</label>
   </td>
   <td><textarea rows=\\\"7\\\" cols=\\\"55\\\" name=\\\"signature\\\">\$signature</textarea></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_USERS_RANKGROUP']}</b></td>
   <td><select name=\\\"rankgroupid\\\">\$rankgroup_options</select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_USERS_USERONLINEGROUP']}</b></td>
   <td><select name=\\\"useronlinegroupid\\\">\$useronlinegroup_options</select></td>
  </tr>
  \$userfields
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_REGISTER_OPTIONS_TITLE']}</td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_REGISTER_OPTIONS_SECURIRY']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_OPTIONS_INVISIBLE']}</b></td>
   <td><select name=\\\"invisible\\\">
    <option value=\\\"1\\\"\$sel_invisible[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
    <option value=\\\"0\\\"\$sel_invisible[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_OPTIONS_USECOOKIES']}</b></td>
   <td><select name=\\\"usecookies\\\">
    <option value=\\\"1\\\"\$sel_usecookies[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
    <option value=\\\"0\\\"\$sel_usecookies[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_REGISTER_OPTIONS_MESSAGING']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_USERS_OPTIONS_ADMINCANEMAIL']}</b></td>
   <td><select name=\\\"admincanemail\\\">
    <option value=\\\"1\\\"\$sel_admincanemail[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
    <option value=\\\"0\\\"\$sel_admincanemail[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_USERS_OPTIONS_SHOWEMAIL']}</b></td>
   <td><select name=\\\"showemail\\\">
    <option value=\\\"0\\\"\$sel_showemail[0]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
    <option value=\\\"1\\\"\$sel_showemail[1]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_USERS_OPTIONS_USERCANEMAIL']}</b></td>
   <td><select name=\\\"usercanemail\\\">
    <option value=\\\"1\\\"\$sel_usercanemail[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
    <option value=\\\"0\\\"\$sel_usercanemail[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_USERS_OPTIONS_EMAILNOTIFY']}</b></td>
   <td><select name=\\\"emailnotify\\\">
    <option value=\\\"1\\\"\$sel_emailnotify[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
    <option value=\\\"0\\\"\$sel_emailnotify[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_USERS_OPTIONS_NOTIFICATIONPERPM']}</b></td>
   <td><select name=\\\"notificationperpm\\\">
    <option value=\\\"1\\\"\$sel_notificationperpm[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
    <option value=\\\"0\\\"\$sel_notificationperpm[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_USERS_OPTIONS_RECEIVEPM']}</b></td>
   <td><select name=\\\"receivepm\\\">
    <option value=\\\"1\\\"\$sel_receivepm[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
    <option value=\\\"0\\\"\$sel_receivepm[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_USERS_OPTIONS_EMAILONPM']}</b></td>
   <td><select name=\\\"emailonpm\\\">
    <option value=\\\"1\\\"\$sel_emailonpm[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
    <option value=\\\"0\\\"\$sel_emailonpm[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_USERS_OPTIONS_PMPOPUP']}</b></td>
   <td><select name=\\\"pmpopup\\\">
    <option value=\\\"1\\\"\$sel_pmpopup[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
    <option value=\\\"0\\\"\$sel_pmpopup[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_USERS_OPTIONS_EMAILONAPPLICATION']}</b></td>
   <td><select name=\\\"emailonapplication\\\">
    <option value=\\\"1\\\"\$sel_emailonapplication[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
    <option value=\\\"0\\\"\$sel_emailonapplication[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_REGISTER_OPTIONS_BOARDVIEW']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_OPTIONS_SHOWSIGNATURES']}</b></td>
   <td><select name=\\\"showsignatures\\\">
    <option value=\\\"1\\\"\$sel_showsignatures[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
    <option value=\\\"0\\\"\$sel_showsignatures[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_OPTIONS_SHOWAVATARS']}</b></td>
   <td><select name=\\\"showavatars\\\">
    <option value=\\\"1\\\"\$sel_showavatars[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
    <option value=\\\"0\\\"\$sel_showavatars[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_OPTIONS_SHOWIMAGES']}</b></td>
   <td><select name=\\\"showimages\\\">
    <option value=\\\"1\\\"\$sel_showimages[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
    <option value=\\\"0\\\"\$sel_showimages[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_OPTIONS_DAYSPRUNE']}</b></td>
   <td><select name=\\\"daysprune\\\">
     <option value=\\\"0\\\"\$sel_daysprune[0]>{\$lang->items['LANG_REGISTER_OPTIONS_BOARDDEFAULT']}</option>
     <option value=\\\"1500\\\"\$sel_daysprune[1500]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_1500']}</option>
     <option value=\\\"1\\\"\$sel_daysprune[1]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_1']}</option>
     <option value=\\\"2\\\"\$sel_daysprune[2]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_2']}</option>
     <option value=\\\"5\\\"\$sel_daysprune[5]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_5']}</option>
     <option value=\\\"10\\\"\$sel_daysprune[10]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_10']}</option>
     <option value=\\\"20\\\"\$sel_daysprune[20]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_20']}</option>
     <option value=\\\"30\\\"\$sel_daysprune[30]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_30']}</option>
     <option value=\\\"45\\\"\$sel_daysprune[45]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_45']}</option>
     <option value=\\\"60\\\"\$sel_daysprune[60]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_60']}</option>
     <option value=\\\"75\\\"\$sel_daysprune[75]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_75']}</option>
     <option value=\\\"100\\\"\$sel_daysprune[100]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_100']}</option>
     <option value=\\\"365\\\"\$sel_daysprune[365]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_365']}</option>
     <option value=\\\"1000\\\"\$sel_daysprune[1000]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_1000']}</option>
    </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_OPTIONS_UMAXPOSTS']}</b></td>
   <td><select name=\\\"umaxposts\\\">
     <option value=\\\"0\\\"\$sel_umaxposts[0]>{\$lang->items['LANG_REGISTER_OPTIONS_BOARDDEFAULT']}</option>
     <option value=\\\"5\\\"\$sel_umaxposts[5]>{\$lang->items['LANG_REGISTER_OPTIONS_UMAXPOSTS_5']}</option>
     <option value=\\\"10\\\"\$sel_umaxposts[10]>{\$lang->items['LANG_REGISTER_OPTIONS_UMAXPOSTS_10']}</option>
     <option value=\\\"20\\\"\$sel_umaxposts[20]>{\$lang->items['LANG_REGISTER_OPTIONS_UMAXPOSTS_20']}</option>
     <option value=\\\"30\\\"\$sel_umaxposts[30]>{\$lang->items['LANG_REGISTER_OPTIONS_UMAXPOSTS_30']}</option>
     <option value=\\\"40\\\"\$sel_umaxposts[40]>{\$lang->items['LANG_REGISTER_OPTIONS_UMAXPOSTS_40']}</option>
    </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_OPTIONS_THREADVIEW']}</b></td>
   <td><select name=\\\"threadview\\\">
     <option value=\\\"1\\\"\$sel_threadview[1]>{\$lang->items['LANG_REGISTER_OPTIONS_THREADVIEW_THREADED']}</option>
     <option value=\\\"0\\\"\$sel_threadview[0]>{\$lang->items['LANG_REGISTER_OPTIONS_THREADVIEW_FLAT']}</option>
    </select></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_REGISTER_OPTIONS_DATE_TIME']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_OPTIONS_DATEFORMAT']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"udateformat\\\" value=\\\"\$udateformat\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_OPTIONS_TIMEFORMAT']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"utimeformat\\\" value=\\\"\$utimeformat\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_OPTIONS_STARTWEEK']}</b></td>
   <td><select name=\\\"startweek\\\">
    \$startweek_options
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_OPTIONS_TIMEZONEOFFSET']}</b></td>
   <td><select name=\\\"timezoneoffset\\\">
    \$timezone_options
   </select></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_REGISTER_OPTIONS_OTHER']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_OPTIONS_USEWYSIWYG']}</b></td>
   <td><select name=\\\"usewysiwyg\\\">
     <option value=\\\"1\\\"\$sel_usewysiwyg[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
     <option value=\\\"0\\\"\$sel_usewysiwyg[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
    </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_OPTIONS_STYLE']}</b></td>
   <td><select name=\\\"styleid\\\">
    \$style_options
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_REGISTER_OPTIONS_LANG']}</b></td>
   <td><select name=\\\"langid\\\">
    \$lang_options
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_USERS_AVATAR']}</b><br />{\$lang->items['LANG_ACP_USERS_USERAVATAR']}</td>
   <td><table>
    <tr>
     <td valign=\\\"top\\\"><select name=\\\"avatarid\\\" onchange=\\\"AvatarChange()\\\">
      <option value=\\\"0\\\"></option>
      \$avatar_options
     </select></td>
     <td><img src=\\\"\\\" border=\\\"0\\\" name=\\\"preview\\\" alt=\\\"\\\" /></td>
    </tr>
   </table></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_USERS_EDIT_BLOCK']}</b></td>
   <td><select name=\\\"blocked\\\">
    <option value=\\\"1\\\"\$sel_blocked[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
    <option value=\\\"0\\\"\$sel_blocked[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_USERS_EDIT_SIGNATURE_BLOCK']}</b></td>
   <td><select name=\\\"disablesignature\\\">
    <option value=\\\"1\\\"\$sel_disablesignature[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
    <option value=\\\"0\\\"\$sel_disablesignature[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_USERS_EDIT_RATING_TITLE']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_USERS_EDIT_RATING']}</b> <a href=\\\"users.php?sid=\$session[hash]&amp;action=rate&amp;userid=\$userid\\\">[{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}]</a></td>
   <td>{\$lang->items['LANG_ACP_USERS_EDIT_RATING_INFO']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
</form>
<script type=\\\"text/javascript\\\">
 <!--
  AvatarChange();
 //-->
</script>
</body>
</html>";
?>
<?php
/*
acp template
templatename: users_find
*/

$this->templates['acp_users_find']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>
<b>{\$lang->items['LANG_ACP_USERS_FIND_SIMPLESEARCH']}</b>
<ul>
<li><a href=\\\"users.php?action=show&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_USERS_FIND_ALL_MEMBERS']}</a></li>
<li><a href=\\\"users.php?action=show&amp;activation=-1&amp;sid=\$session[hash]&amp;sortby=regdate&amp;sortorder=DESC\\\">{\$lang->items['LANG_ACP_USERS_FIND_NO_ACTIVATION']}</a></li>
<li><a href=\\\"users.php?action=show&amp;blocked=1&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_USERS_FIND_BLOCKED']}</a></li>
<li><a href=\\\"users.php?action=show&amp;sortby=regdate&amp;sortorder=DESC&amp;limit=20&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_USERS_FIND_NEWEST']}</a></li>
</ul>
<br />
<b>{\$lang->items['LANG_ACP_USERS_FIND_ADVANCEDSEARCH']}</b>
<br /><br />
<form method=\\\"post\\\" action=\\\"users.php\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"show\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_USERS_FIND']}</td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_MEMBERS_MBS_SEARCHFIELDS']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>\$LANG_SEARCHFIELD_USERNAME</td>
   <td><input type=\\\"text\\\" name=\\\"username\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>\$LANG_SEARCHFIELD_EMAIL</td>
   <td><input type=\\\"text\\\" name=\\\"email\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>\$LANG_SEARCHFIELD_USERGROUP</td>
   <td><select name=\\\"groupid\\\">
    <option value=\\\"0\\\"></option>
    \$group_options
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>\$LANG_SEARCHFIELD_RANK</td>
   <td><select name=\\\"rankid\\\">
    <option value=\\\"0\\\"></option>
    \$rank_options
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>\$LANG_SEARCHFIELD_TITLE</td>
   <td><input type=\\\"text\\\" name=\\\"title\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>\$LANG_SEARCHFIELD_USERTEXT</td>
   <td><input type=\\\"text\\\" name=\\\"usertext\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>\$LANG_SEARCHFIELD_SIGNATURE</td>
   <td><input type=\\\"text\\\" name=\\\"signature\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>\$LANG_SEARCHFIELD_HOMEPAGE</td>
   <td><input type=\\\"text\\\" name=\\\"homepage\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>\$LANG_SEARCHFIELD_ICQ</td>
   <td><input type=\\\"text\\\" name=\\\"icq\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>\$LANG_SEARCHFIELD_AIM</td>
   <td><input type=\\\"text\\\" name=\\\"aim\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>\$LANG_SEARCHFIELD_YIM</td>
   <td><input type=\\\"text\\\" name=\\\"yim\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>\$LANG_SEARCHFIELD_MSN</td>
   <td><input type=\\\"text\\\" name=\\\"msn\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>\$LANG_SEARCHFIELD_GENDER</td>
   <td><select name=\\\"gender\\\">
    <option value=\\\"0\\\"></option>
    <option value=\\\"1\\\">{\$lang->items['LANG_MEMBERS_PROFILE_MALE']}</option>
    <option value=\\\"2\\\">{\$lang->items['LANG_MEMBERS_PROFILE_FEMALE']}</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>{\$lang->items['LANG_MEMBERS_MBS_USERPOSTS_MORETHEN']}</td>
   <td><input type=\\\"text\\\" name=\\\"userposts_morethen\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_MEMBERS_MBS_USERPOSTS_LESSTHEN']}</td>
   <td><input type=\\\"text\\\" name=\\\"userposts_lessthen\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>\$LANG_SEARCHFIELD_LANGID</td>
    <td><select name=\\\"langid\\\">
    <option value=\\\"\\\"></option>
    \$lang_options
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>\$LANG_SEARCHFIELD_ACTIVATION</td>
   <td><select name=\\\"activation\\\">
    <option value=\\\"0\\\"></option>
    <option value=\\\"1\\\">{\$lang->items['LANG_ACP_USERS_FIND_ACTIVATION_1']}</option>
    <option value=\\\"-1\\\">{\$lang->items['LANG_ACP_USERS_FIND_ACTIVATION_2']}</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>{\$lang->items['LANG_ACP_USERS_FIND_LASTACTIVITY_IN']}</td>
   <td><input type=\\\"text\\\" name=\\\"lastactivity_in\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_USERS_FIND_LASTACTIVITY_NOTIN']}</td>
   <td><input type=\\\"text\\\" name=\\\"lastactivity_notin\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
  </tr>

  \$morebit

  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_MEMBERS_MBS_VIEW_AND_SORT']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_MEMBERS_MBS_SORT']}</td>
   <td><select name=\\\"sortby\\\">
    <option value=\\\"username\\\">{\$lang->items['LANG_MEMBERS_MBL_USERNAME']}</option>
    <option value=\\\"email\\\">{\$lang->items['LANG_MEMBERS_MBL_EMAIL']}</option>
    <option value=\\\"regdate\\\">{\$lang->items['LANG_MEMBERS_MBL_REGDATE']}</option>
    <option value=\\\"lastactivity\\\">{\$lang->items['LANG_MEMBERS_MBL_LASTACTIVITY']}</option>
    <option value=\\\"userposts\\\">{\$lang->items['LANG_MEMBERS_MBL_USERPOSTS']}</option>
   </select> <select name=\\\"sortorder\\\">
    <option value=\\\"ASC\\\">{\$lang->items['LANG_MEMBERS_MBS_ORDER_ASC']}</option>
    <option value=\\\"DESC\\\">{\$lang->items['LANG_MEMBERS_MBS_ORDER_DESC']}</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>{\$lang->items['LANG_MEMBERS_MBS_USERPERPAGE']}</td>
   <td><input type=\\\"text\\\" name=\\\"limit\\\" value=\\\"200\\\" maxlength=\\\"255\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SEARCHFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
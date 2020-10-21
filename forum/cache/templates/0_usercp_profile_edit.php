<?php
			/*
			templatepackid: 0
			templatename: usercp_profile_edit
			*/
			
			$this->templates['usercp_profile_edit']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
 <head>
  <title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']} | {\$lang->items['LANG_USERCP_PROFILE_EDIT']}</title>
  \$headinclude
 </head>
 <body>
  \$header
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"usercp.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_TITLE']}</a> &raquo; {\$lang->items['LANG_USERCP_PROFILE_EDIT']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />\$usercp_error
  <form action=\\\"usercp.php\\\" method=\\\"post\\\">
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
   <tr>
    <td class=\\\"tablecat\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_PROFILE_EDIT']}</b></span></td>
   </tr>
   \".((\$profilefields_required!=\"\") 
    ? (\"
     <tr>
      <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_NEEDED_INFORMATION']}</span></td>
     </tr>
     \$profilefields_required
    \") : (\"\")
   ).\"
   <tr>
    <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OTHER_INFORMATION']}</span></td>
   </tr>
   \".((\$wbbuserdata['can_edit_title']==1) 
   ? (\"
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_USERTITLE']}</b></span></td>
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><input type=\\\"text\\\" class=\\\"input\\\" name=\\\"r_title\\\" value=\\\"\$r_title\\\" maxlength=\\\"50\\\" /></span></td>
   </tr>
   \") : (\"\")
   ).\"
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_HOMEPAGE']}</b></span></td>
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><input type=\\\"text\\\" class=\\\"input\\\" name=\\\"r_homepage\\\" value=\\\"\$r_homepage\\\" maxlength=\\\"250\\\" /></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_ICQ']}</b></span></td>
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><input type=\\\"text\\\" class=\\\"input\\\" name=\\\"r_icq\\\" value=\\\"\$r_icq\\\" maxlength=\\\"30\\\" /></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_AIM']}</b></span></td>
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><input type=\\\"text\\\" class=\\\"input\\\" name=\\\"r_aim\\\" value=\\\"\$r_aim\\\" maxlength=\\\"30\\\" /></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_YIM']}</b></span></td>
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><input type=\\\"text\\\" class=\\\"input\\\" name=\\\"r_yim\\\" value=\\\"\$r_yim\\\" maxlength=\\\"30\\\" /></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_MSN']}</b></span></td>
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><input type=\\\"text\\\" class=\\\"input\\\" name=\\\"r_msn\\\" value=\\\"\$r_msn\\\" maxlength=\\\"30\\\" /></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_BIRTHDAY']}</b></span></td>
    <td class=\\\"tablea\\\"><table>
     <tr align=\\\"center\\\" class=\\\"tablea_fc\\\">
      <td><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_BIRTHDAY_DAY']}</span></td>
      <td><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_BIRTHDAY_MONTH']}</span></td>
      <td><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_BIRTHDAY_YEAR']}</span></td>
     </tr>
     <tr>
      <td><select name=\\\"r_day\\\">
       <option value=\\\"0\\\"></option>
       \$day_options
      </select></td>
      <td><select name=\\\"r_month\\\">
       <option value=\\\"0\\\"></option>
       \$month_options
      </select></td>
      <td><input type=\\\"text\\\" class=\\\"input\\\" name=\\\"r_year\\\" value=\\\"\$r_year\\\" maxlength=\\\"4\\\" size=\\\"5\\\" /></td>
     </tr>
    </table></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_GENDER']}</b></span></td>
    <td class=\\\"tableb\\\"><select name=\\\"r_gender\\\">
     <option value=\\\"0\\\">{\$lang->items['LANG_REGISTER_NODECLARATION']}</option>
     <option value=\\\"1\\\"\$gender[1]>{\$lang->items['LANG_REGISTER_MALE']}</option>
     <option value=\\\"2\\\"\$gender[2]>{\$lang->items['LANG_REGISTER_FEMALE']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\" valign=\\\"top\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_USERTEXT']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_USERTEXT_DESC']}</span></td>
    <td class=\\\"tablea\\\"><textarea name=\\\"r_usertext\\\" rows=\\\"6\\\" cols=\\\"40\\\">\$r_usertext</textarea></td>
   </tr>
   \$profilefields
  </table><br />
  <p align=\\\"center\\\"><input class=\\\"input\\\" type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_POSTINGS_SAVE']}\\\" /> <input class=\\\"input\\\" type=\\\"reset\\\" accesskey=\\\"R\\\" value=\\\"{\$lang->items['LANG_POSTINGS_RESET']}\\\" /></p>
   <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
   <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
   <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  </form>
  \$footer
 </body>
</html>";
			?>
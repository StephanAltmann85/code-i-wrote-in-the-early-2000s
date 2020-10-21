<?php
			/*
			templatepackid: 0
			templatename: usercp_avatars
			*/
			
			$this->templates['usercp_avatars']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
 <head>
  <title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']} | {\$lang->items['LANG_USERCP_AVATARS']}</title>
  \$headinclude

 </head>
 <body>
  \$header
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"usercp.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_TITLE']}</a> &raquo; {\$lang->items['LANG_USERCP_AVATARS']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br /><form action=\\\"usercp.php\\\" method=\\\"post\\\" name=\\\"bbform\\\" enctype=\\\"multipart/form-data\\\">
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
   <tr>
    <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_AVATARS']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\" style=\\\"width:50%\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_USE_AVATAR']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_AVATARS_DESC']}</span></td>
    <td class=\\\"tablea\\\" style=\\\"width:50%\\\"><span class=\\\"normalfont\\\"><input type=\\\"radio\\\" name=\\\"avatarid\\\" id=\\\"radio1\\\" value=\\\"0\\\"\$noavatar_checked /><label for=\\\"radio1\\\"> {\$lang->items['LANG_REGISTER_OPTIONS_NO']}</label></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_USE_AVATAR_NOTE']}</span></td>
   </tr>
   
   \".((\$wbbuserdata['can_use_avatar']==1 && \$avatarcount) 
    ? (\"
     <tr>
      <td class=\\\"tableb\\\" align=\\\"center\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_AVATAR_CHOICE']}</b></span></td>
     </tr>
     <tr>
      <td class=\\\"tablea\\\" align=\\\"center\\\" colspan=\\\"2\\\"><table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\">\$avatarbit_tr</table><span class=\\\"normalfont\\\">{\$lang->items['LANG_USERCP_AVATAR_COUNT']}</span><br /><span class=\\\"smallfont\\\">\$pagelink</span></td>
     </tr>
    \") : (\"\")
   ).\"
   
   \".((\$wbbuserdata['can_upload_avatar']==1) 
    ? (\"
     <tr align=\\\"left\\\">
      <td class=\\\"tableb\\\" style=\\\"width:50%\\\" valign=\\\"top\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_USE_OWNAVATAR']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_USE_OWNAVATAR_NOTE']}</span></td>
      <td class=\\\"tableb\\\" style=\\\"width:50%\\\"><span class=\\\"normalfont\\\"><input type=\\\"radio\\\" id=\\\"radio2\\\" name=\\\"avatarid\\\" value=\\\"useown\\\"\$ownavatar_checked /><label for=\\\"radio2\\\"> {\$lang->items['LANG_REGISTER_OPTIONS_YES']}</label></span><br />\$ownavatar</td>
     </tr>
     <tr align=\\\"left\\\">
      <td class=\\\"tablea\\\" style=\\\"width:50%\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_UPLOAD_AVATAR']}</b></span></td>
      <td class=\\\"tablea\\\" style=\\\"width:50%\\\">\$havatar<input type=\\\"hidden\\\" name=\\\"MAX_FILE_SIZE\\\" value=\\\"\$wbbuserdata[max_avatar_size]\\\" /><input name=\\\"avatar_file\\\" type=\\\"file\\\" class=\\\"input\\\" size=\\\"35\\\" /></td>
     </tr>
    \") : (\"\")
   ).\"
   
  </table><br />
  <p align=\\\"center\\\"><input class=\\\"input\\\" type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_POSTINGS_SAVE']}\\\" /> <input class=\\\"input\\\" accesskey=\\\"R\\\" type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_POSTINGS_RESET']}\\\" /></p>
   <input type=\\\"hidden\\\" name=\\\"page\\\" value=\\\"\$page\\\" />
   <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
   <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
   <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  </form>
  \$footer
 </body>
</html>";
			?>
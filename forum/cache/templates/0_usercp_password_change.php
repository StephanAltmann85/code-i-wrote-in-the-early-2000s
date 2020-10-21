<?php
			/*
			templatepackid: 0
			templatename: usercp_password_change
			*/
			
			$this->templates['usercp_password_change']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
 <head>
  <title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']} | {\$lang->items['LANG_USERCP_PASSWORD_CHANGE']}</title>
  \$headinclude
 </head>
 <body>
  \$header
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"usercp.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_TITLE']}</a> &raquo; {\$lang->items['LANG_USERCP_PASSWORD_CHANGE']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />
  \".((\$allowloginencryption==1) ? (\"
  <script type=\\\"text/javascript\\\" src=\\\"js/sha1.js\\\"></script>
  <script type=\\\"text/javascript\\\" src=\\\"js/crypt.js\\\"></script>\") : (\"\")).\"
   <form action=\\\"usercp.php\\\" method=\\\"post\\\" name=\\\"loginform\\\"\".((\$allowloginencryption==1) ? (\" onsubmit=\\\"return encryptlogin(this);\\\"\") : (\"\")).\">
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:{\$style['tableinwidth']}\\\">
   <tr>
    <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_PASSWORD_CHANGE']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_PW_OLD_PASSWORD']}</b></span></td>
    <td class=\\\"tablea\\\"><input type=\\\"password\\\" class=\\\"input\\\" name=\\\"l_password\\\" /><span class=\\\"smallfont\\\"> <a href=\\\"forgotpw.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_PW_FORGOTPW']}</a></span></td>
   </tr>
   \".((\$allowloginencryption==1) ? (\"
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b><label for=\\\"checkbox1\\\">{\$lang->items['LANG_GLOBAL_ENCRYPT_TRANSFER']}</label></b></span></td>
    <td class=\\\"tablea\\\"><input type=\\\"checkbox\\\" id=\\\"checkbox1\\\" name=\\\"activateencryption\\\" onclick=\\\"activate_loginencryption(document.loginform);\\\" /></td>
   </tr>\") : (\"\")).\"
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_PW_NEW_PASSWORD']}</b></span></td>
    <td class=\\\"tableb\\\"><input type=\\\"password\\\" class=\\\"input\\\" name=\\\"new_password\\\" /></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_PW_CONFIRM_NEW_PASSWORD']}</b></span></td>
    <td class=\\\"tableb\\\"><input type=\\\"password\\\" class=\\\"input\\\" name=\\\"confirm_new_password\\\" /></td>
   </tr>
  </table><br />
  <p align=\\\"center\\\"><input class=\\\"input\\\" type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_POSTINGS_SAVE']}\\\" /> <input class=\\\"input\\\" type=\\\"reset\\\" accesskey=\\\"R\\\" value=\\\"{\$lang->items['LANG_POSTINGS_RESET']}\\\" /></p>
   <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
   <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
   <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
   \".((\$allowloginencryption==1) ? (\"
   <input type=\\\"hidden\\\" name=\\\"authentificationcode\\\" value=\\\"\$session[authentificationcode]\\\" />
   <input type=\\\"hidden\\\" name=\\\"crypted\\\" value=\\\"false\\\" />\") : (\"\")).\"
  </form>
  \".((\$allowloginencryption==1) ? (\"
  <script type=\\\"text/javascript\\\">
   <!--
    activate_loginencryption(document.loginform);
   //-->
  </script>\") : (\"\")).\"
  \$footer
 </body>
</html>";
			?>
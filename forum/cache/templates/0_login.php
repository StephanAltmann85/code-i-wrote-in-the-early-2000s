<?php
			/*
			templatepackid: 0
			templatename: login
			*/
			
			$this->templates['login']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_USERCP_LOGIN_TITLE']}</title>
\$headinclude
\".((\$allowloginencryption==1) ? (\"
<script type=\\\"text/javascript\\\" src=\\\"js/sha1.js\\\"></script>
<script type=\\\"text/javascript\\\" src=\\\"js/crypt.js\\\"></script>\") : (\"\")).\"
</head>

<body>
 \$header
<form action=\\\"login.php\\\" method=\\\"post\\\" name=\\\"loginform\\\"\".((\$allowloginencryption==1) ? (\" onsubmit=\\\"return encryptlogin(this);\\\"\") : (\"\")).\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
\".((\$allowloginencryption==1) ? (\"
<input type=\\\"hidden\\\" name=\\\"authentificationcode\\\" value=\\\"\$session[authentificationcode]\\\" />
<input type=\\\"hidden\\\" name=\\\"crypted\\\" value=\\\"false\\\" />\") : (\"\")).\"
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\">
  <tr>
   <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_LOGIN_TITLE']}</b></span></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_USERCP_LOGIN_USERNAME']}</span></td>
   <td class=\\\"tableb\\\"><input type=\\\"text\\\" class=\\\"input\\\" name=\\\"l_username\\\" size=\\\"20\\\" maxlength=\\\"50\\\" tabindex=\\\"1\\\" /><span class=\\\"smallfont\\\"> <a href=\\\"register.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_LOGIN_REGISTER']}</a></span></td>	
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_USERCP_LOGIN_PASSWORT']}</span></td>
   <td class=\\\"tablea\\\"><input type=\\\"password\\\" class=\\\"input\\\" name=\\\"l_password\\\" size=\\\"20\\\" maxlength=\\\"30\\\" tabindex=\\\"2\\\" /><span class=\\\"smallfont\\\"> <a href=\\\"forgotpw.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_PW_FORGOTPW']}</a></span></td>	
  </tr>
  \".((\$allowloginencryption==1) ? (\"
  <tr align=\\\"left\\\">
   <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><label for=\\\"checkbox1\\\">{\$lang->items['LANG_GLOBAL_ENCRYPT_TRANSFER']}</label></span></td>
   <td class=\\\"tableb\\\"><input type=\\\"checkbox\\\" id=\\\"checkbox1\\\" name=\\\"activateencryption\\\" onclick=\\\"activate_loginencryption(document.loginform);\\\" /></td>
  </tr>\") : (\"\")).\"
 </table>
 <p align=\\\"center\\\"><input class=\\\"input\\\" type=\\\"submit\\\" name=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_USERCP_LOGIN_LOGIN']}\\\" tabindex=\\\"3\\\" /> <input class=\\\"input\\\" type=\\\"reset\\\" accesskey=\\\"R\\\" value=\\\"{\$lang->items['LANG_USERCP_LOGIN_RESET']}\\\" /></p>
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
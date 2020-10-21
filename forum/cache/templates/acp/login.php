<?php
/*
acp template
templatename: login
*/

$this->templates['acp_login']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title>\$master_board_name | {\$lang->items['LANG_ACP_GLOBAL_LOGIN_TITLE']}</title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/other.css\\\" />

<style type=\\\"text/css\\\">
 <!--
INPUT {
 FONT-SIZE: 12px;
 FONT-FAMILY: Tahoma,Helvetica;
 COLOR: #000000;
 BACKGROUND-COLOR: #CFCFCF;

 border-top-width : 1px;
 border-right-width : 1px;
 border-bottom-width : 1px;
 border-left-width : 1px;
 text-indent : 2px;
}
-->
</style>
\".((\$allowloginencryption==1) ? (\"
<script type=\\\"text/javascript\\\" src=\\\"../js/sha1.js\\\"></script>
<script type=\\\"text/javascript\\\" src=\\\"../js/crypt.js\\\"></script>\") : (\"\")).\"
</head>

<body onload=\\\"document.lform.\".((\$l_username) ? (\"l_password\") : (\"l_username\")).\".focus();\\\">
 <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
 <form method=\\\"post\\\" action=\\\"login.php\\\" name=\\\"lform\\\"\".((\$allowloginencryption==1) ? (\" onsubmit=\\\"return encryptlogin(this);\\\"\") : (\"\")).\">
 <table align=\\\"center\\\">
  <tr>
   <td align=\\\"left\\\"><img src=\\\"{\$style['imagefolder']}/acp-logo.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_ACP_GLOBAL_ACP']}\\\" /></td>
  </tr>
  <tr>
   <td><table align=\\\"center\\\">
    <tr>
     <td><b>{\$lang->items['LANG_ACP_GLOBAL_LOGIN_USERNAME']}</b></td>
     <td><input type=\\\"text\\\" name=\\\"l_username\\\" value=\\\"\$l_username\\\" maxlength=\\\"50\\\" /></td>
    </tr>
    <tr>
     <td><b>{\$lang->items['LANG_ACP_GLOBAL_LOGIN_PASSWORD']}</b></td>
     <td><input type=\\\"password\\\" name=\\\"l_password\\\" maxlength=\\\"50\\\" /></td>
    </tr>
   \".((\$allowloginencryption==1) ? (\"
    <tr>
     <td><label for=\\\"checkbox1\\\">{\$lang->items['LANG_GLOBAL_ENCRYPT_TRANSFER']}</label></td>
     <td><input type=\\\"checkbox\\\" id=\\\"checkbox1\\\" name=\\\"activateencryption\\\" onclick=\\\"activate_loginencryption(document.lform);\\\" style=\\\"background: transparent;\\\" /></td>
    </tr>
   \") : (\"\")).\"
   </table></td>
  </tr>
  <tr>
   <td colspan=\\\"2\\\" align=\\\"right\\\"><input type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_LOGIN_SUBMIT']}\\\" /></td>
  </tr>
 </table>
 <p align=\\\"center\\\">WoltLab Burning Board \$boardversion - {\$lang->items['LANG_ACP_GLOBAL_ACP']}</p>
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input type=\\\"hidden\\\" name=\\\"url\\\" value=\\\"\$url\\\" />
  \".((\$allowloginencryption==1) ? (\"
  <input type=\\\"hidden\\\" name=\\\"authentificationcode\\\" value=\\\"\$authentificationcode\\\" />
  <input type=\\\"hidden\\\" name=\\\"crypted\\\" value=\\\"false\\\" />\") : (\"\")).\"
  </form>
 \".((\$allowloginencryption==1) ? (\"
 <script type=\\\"text/javascript\\\">
 <!--
  activate_loginencryption(document.lform);
 //-->
</script>\") : (\"\")).\"
</body>
</html>";
?>
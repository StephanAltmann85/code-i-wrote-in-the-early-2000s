<?php
/*
acp template
templatename: group_finduser
*/

$this->templates['acp_group_finduser']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title>{\$lang->items['LANG_ACP_GROUP_FIND_USER']}</title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<script type=\\\"text/javascript\\\">
<!--
 function send_username(userid,username) {
  opener.addToGroupleaderList(userid,username);
  self.close();
 }
//-->
</script>
</head>
<body onload=\\\"document.sform.username.focus()\\\">
<form method=\\\"post\\\" action=\\\"group.php\\\" name=\\\"sform\\\">
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />

 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td>{\$lang->items['LANG_ACP_GROUP_FIND_USER']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
    <td><input type=\\\"text\\\" name=\\\"username\\\" value=\\\"\\\" maxlength=\\\"50\\\" /> <input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SEARCHFORM']}\\\" /></td>
  </tr>
   \".((\$options!=\"\") 
    ? (\"
     <tr class=\\\"secondrow\\\">
      <td><select name=\\\"susername\\\">\$options</select>&nbsp;<input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_GROUP_FIND_USER_SELECT']}\\\" onclick=\\\"send_username(document.sform.susername.options[document.sform.susername.selectedIndex].value, document.sform.susername.options[document.sform.susername.selectedIndex].text)\\\" /></td>
     </tr>
    \") : (\"\")
   ).\"
  <tr class=\\\"tblhead\\\">
   <td align=\\\"center\\\"><a href=\\\"javascript:self.close();\\\">[{\$lang->items['LANG_ACP_GLOBAL_WINDOW_CLOSE']}]</a></td>
  </tr>
</table></form>
</body>
</html>";
?>
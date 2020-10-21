<?php
/*
acp template
templatename: group_pmsend
*/

$this->templates['acp_group_pmsend']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>

<form method=\\\"post\\\" action=\\\"group.php\\\" name=\\\"bbform\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GROUP_PMSEND']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_USERS_OTHER_USERGROUPS']}</b></td>
   <td><select name=\\\"groupids[]\\\" multiple=\\\"multiple\\\" size=\\\"5\\\">\$group_options</select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_PMS_SUBJECT']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"subject\\\" maxlength=\\\"250\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td valign=\\\"top\\\"><b>{\$lang->items['LANG_PMS_MESSAGE']}</b></td>
   <td><textarea rows=\\\"15\\\" cols=\\\"75\\\" name=\\\"message\\\"></textarea></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>{\$lang->items['LANG_POSTINGS_OPTIONS']}</td>
   <td><input type=\\\"checkbox\\\" id=\\\"checkbox1\\\" name=\\\"parseurl\\\" value=\\\"1\\\" \$checked[0] /><label for=\\\"checkbox1\\\"> {\$lang->items['LANG_POSTINGS_PARSEURL']}</label>
   \".((\$wbbuserdata['can_use_pn_smilies']==1) ? (\"<br /><input type=\\\"checkbox\\\" id=\\\"checkbox2\\\" name=\\\"disablesmilies\\\" value=\\\"1\\\" \$checked[1] /><label for=\\\"checkbox2\\\"> {\$lang->items['LANG_POSTINGS_DISABLESMILIES']}</label>\") : (\"\")).\"
   \".((\$wbbuserdata['can_use_pn_html']==1) ? (\"<br /><input type=\\\"checkbox\\\" id=\\\"checkbox3\\\" name=\\\"disablehtml\\\" value=\\\"1\\\" \$checked[2] /><label for=\\\"checkbox3\\\"> {\$lang->items['LANG_POSTINGS_DISABLEHTML']}</label>\") : (\"\")).\"
   \".((\$wbbuserdata['can_use_pn_bbcode']==1) ? (\"<br /><input type=\\\"checkbox\\\" id=\\\"checkbox4\\\" name=\\\"disablebbcode\\\" value=\\\"1\\\" \$checked[3] /><label for=\\\"checkbox4\\\"> {\$lang->items['LANG_POSTINGS_DISABLEBBCODE']}</label>\") : (\"\")).\"
   \".((\$wbbuserdata['can_use_pn_images']==1) ? (\"<br /><input type=\\\"checkbox\\\" id=\\\"checkbox5\\\" name=\\\"disableimages\\\" value=\\\"1\\\" \$checked[4] /><label for=\\\"checkbox5\\\"> {\$lang->items['LANG_POSTINGS_DISABLEIMAGES']}</label>\") : (\"\")).\"
   <br /><input type=\\\"checkbox\\\" id=\\\"checkbox6\\\" name=\\\"showsignature\\\" value=\\\"1\\\" \$checked[5] /><label for=\\\"checkbox6\\\"> {\$lang->items['LANG_POSTINGS_SHOWSIGNATURE']}</label>
   <br /><input type=\\\"checkbox\\\" id=\\\"checkbox7\\\" name=\\\"savecopy\\\" value=\\\"1\\\" \$checked[6] /><label for=\\\"checkbox7\\\"> {\$lang->items['LANG_PMS_SAVE_COPY']}</label>
   <br /><input type=\\\"checkbox\\\" id=\\\"checkbox8\\\" name=\\\"blindcopy\\\" value=\\\"1\\\" \$checked[7] /><label for=\\\"checkbox8\\\"> {\$lang->items['LANG_ACP_GROUP_PMSEND_BLINDCOPY']}</label>
   </td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_START']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
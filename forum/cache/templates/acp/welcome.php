<?php
/*
acp template
templatename: welcome
*/

$this->templates['acp_welcome']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>

<p align=\\\"center\\\">\".((\$wbbuserdata['a_acp_or_mcp']==1) ? (\"{\$lang->items['LANG_ACP_WELCOME_TITLE_ACP']}\") : (\"{\$lang->items['LANG_ACP_WELCOME_TITLE_MODCP']}\")).\"</p>
<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
 <tr class=\\\"tblhead\\\">
  <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_WELCOME_INFORMATION']}</td>
 </tr>
 <tr class=\\\"firstrow\\\">
  <td><b>{\$lang->items['LANG_ACP_WELCOME_BOARDVERSION']}</b></td>
  <td>\$boardversion</td>
 </tr>
 <tr class=\\\"secondrow\\\">
  <td><b>{\$lang->items['LANG_ACP_WELCOME_INSTALLDATE']}</b></td>
  <td>\$install_date</td>
 </tr>
 <tr class=\\\"firstrow\\\">
  <td><b>{\$lang->items['LANG_ACP_WELCOME_MEMBERS']}</b></td>
  <td>\$stats[usercount]</td>
 </tr>
 <tr class=\\\"secondrow\\\">
  <td><b>{\$lang->items['LANG_ACP_WELCOME_USERONLINE']}</b></td>
  <td>\$useronlinecount</td>
 </tr>
 <tr class=\\\"firstrow\\\">
  <td><b>{\$lang->items['LANG_ACP_WELCOME_POSTS']}</b></td>
  <td>\$stats[postcount] \$postsperday</td>
 </tr>
 <tr class=\\\"secondrow\\\">
  <td><b>{\$lang->items['LANG_ACP_WELCOME_THREADS']}</b></td>
  <td>\$stats[threadcount] \$threadsperday</td>
 </tr>
 <tr class=\\\"firstrow\\\">
  <td><b>{\$lang->items['LANG_ACP_WELCOME_PMSGS']}</b></td>
  <td>\$pncount</td>
 </tr>
 <tr class=\\\"secondrow\\\">
  <td><b>{\$lang->items['LANG_ACP_WELCOME_ATTACHMENTS']}</b></td>
  <td>\$attachmentcount (\$attachmentsize)</td>
 </tr>
 \".((checkAdminPermissions(\"a_can_users_activation\")) 
 ? (\"
 <tr class=\\\"firstrow\\\">
  <td colspan=\\\"2\\\"><a href=\\\"users.php?action=show&amp;activation=-1&amp;sid=\$session[hash]&amp;sortby=regdate&amp;sortorder=DESC\\\">{\$lang->items['LANG_ACP_WELCOME_W4ACTIVATION']}</a></td>
 </tr>
 \") : (\"\")
 ).\"
</table><br />

\".((checkAdminPermissions(\"a_can_template_search\") || checkAdminPermissions(\"a_can_languagepack_search\") || checkAdminPermissions(\"a_can_users_edit\") || checkAdminPermissions(\"a_can_users_delete\") || checkAdminPermissions(\"a_can_users_email\") || checkAdminPermissions(\"a_can_users_merge\") || checkAdminPermissions(\"a_can_users_other\")) 
? (\"
 
<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
 <tr class=\\\"tblhead\\\">
  <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_WELCOME_QUICKSEARCH']}</td>
 </tr>
 
 \".((checkAdminPermissions(\"a_can_users_edit\") || checkAdminPermissions(\"a_can_users_delete\") || checkAdminPermissions(\"a_can_users_email\") || checkAdminPermissions(\"a_can_users_merge\") || checkAdminPermissions(\"a_can_users_other\")) 
 ? (\"
 
 <tr class=\\\"firstrow\\\">
  <td><b>{\$lang->items['LANG_ACP_WELCOME_QUICKSEARCH_USERNAME']}</b></td>
  <td>
   <form method=\\\"post\\\" action=\\\"users.php\\\">
    <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
    <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"show\\\" />
    <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
    <input type=\\\"text\\\" name=\\\"username\\\" value=\\\"\\\" size=\\\"40\\\" maxlength=\\\"255\\\" />
    <input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SEARCHFORM']}\\\" />
   </form>  
  </td>
 </tr>
 
 \") : (\"\")
 ).\"
 
 \".((checkAdminPermissions(\"a_can_template_search\")) 
 ? (\"
 
 <tr class=\\\"secondrow\\\">
  <td><b>{\$lang->items['LANG_ACP_WELCOME_QUICKSEARCH_TEMPLATE']}</b></td>
  <td>
   <form method=\\\"post\\\" action=\\\"template.php\\\">
    <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
    <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"search\\\" />
    <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
    <input type=\\\"hidden\\\" name=\\\"templatepackid\\\" value=\\\"*\\\" />
    <input type=\\\"hidden\\\" name=\\\"dosearch\\\" value=\\\"1\\\" />
    <input type=\\\"text\\\" name=\\\"search\\\" value=\\\"\\\" size=\\\"40\\\" maxlength=\\\"255\\\" />
    <input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SEARCHFORM']}\\\" />
   </form>  
  </td>
 </tr>
 
 \") : (\"\")
 ).\"
 
 \".((checkAdminPermissions(\"a_can_languagepack_search\")) 
 ? (\"
 
 <tr class=\\\"firstrow\\\">
  <td><b>{\$lang->items['LANG_ACP_WELCOME_QUICKSEARCH_LANGITEM']}</b></td>
  <td>
   <form method=\\\"post\\\" action=\\\"languagepack.php\\\">
    <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
    <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"search\\\" />
    <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
    <input type=\\\"hidden\\\" name=\\\"languagepackid\\\" value=\\\"0\\\" />
    <input type=\\\"hidden\\\" name=\\\"dosearch\\\" value=\\\"1\\\" />
    <input type=\\\"text\\\" name=\\\"search\\\" value=\\\"\\\" size=\\\"40\\\" maxlength=\\\"255\\\" />
    <input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SEARCHFORM']}\\\" />
   </form>  
  </td>
 </tr>
 
 \") : (\"\")
 ).\"
 
</table>
<br />
\") : (\"\")
).\"

\".((\$serverinfo==1) 
? (\"
<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
 <tr class=\\\"tblhead\\\">
  <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_WELCOME_SERVERLOAD']}</td>
 </tr>
 <tr class=\\\"firstrow\\\">
  <td><b>{\$lang->items['LANG_ACP_WELCOME_SERVERLOAD_1']}</b></td>
  <td\".((\$match[1]>100) ? (\" style=\\\"color: red; font-weight: bold;\\\"\") : (\"\")).\">\$match[1]%</td>
 </tr>
 <tr class=\\\"secondrow\\\">
  <td><b>{\$lang->items['LANG_ACP_WELCOME_SERVERLOAD_5']}</b></td>
  <td\".((\$match[2]>100) ? (\" style=\\\"color: red; font-weight: bold;\\\"\") : (\"\")).\">\$match[2]%</td>
 </tr>
 <tr class=\\\"firstrow\\\">
  <td><b>{\$lang->items['LANG_ACP_WELCOME_SERVERLOAD_15']}</b></td>
  <td\".((\$match[3]>100) ? (\" style=\\\"color: red; font-weight: bold;\\\"\") : (\"\")).\">\$match[3]%</td>
 </tr>
</table><br />
\") : (\"\")
).\"

<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
 <tr class=\\\"tblhead\\\">
  <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_WELCOME_SUPPORT']}</td>
 </tr>
 <tr class=\\\"firstrow\\\">
  <td><b>{\$lang->items['LANG_ACP_WELCOME_DOCUMENTATION']}</b></td>
  <td>{\$lang->items['LANG_ACP_WELCOME_DOCUMENTATION_URL']}</td>
 </tr>
 <tr class=\\\"secondrow\\\">
  <td><b>{\$lang->items['LANG_ACP_WELCOME_SUPPORTBOARD']}</b></td>
  <td>{\$lang->items['LANG_ACP_WELCOME_SUPPORTBOARD_URL']}</td>
 </tr>
 <tr class=\\\"firstrow\\\">
  <td><b>{\$lang->items['LANG_ACP_WELCOME_MEMBERSAREA']}</b></td>
  <td>{\$lang->items['LANG_ACP_WELCOME_MEMBERSAREA_URL']}</td>
 </tr>
</table>
</body>
</html>";
?>
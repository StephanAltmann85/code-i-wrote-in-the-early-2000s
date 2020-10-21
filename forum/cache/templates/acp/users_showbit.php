<?php
/*
acp template
templatename: users_showbit
*/

$this->templates['acp_users_showbit']="<tr class=\\\"\$rowclass\\\">
 <td align=\\\"center\\\" nowrap=\\\"nowrap\\\">
 \".((checkAdminPermissions(\"a_can_users_edit\")) ? (\"<a href=\\\"users.php?action=edit&amp;userid=\$row[userid]&amp;sid=\$session[hash]\\\"><img src=\\\"{\$style['imagefolder']}/edit.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_ACP_USERS_ACTION_TITLE_EDIT}\\\" title=\\\"{\$LANG_ACP_USERS_ACTION_TITLE_EDIT}\\\" /></a>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_users_email\")) ? (\"<a href=\\\"users.php?action=email&amp;userid[]=\$row[userid]&amp;sid=\$session[hash]\\\"><img src=\\\"{\$style['imagefolder']}/email.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_ACP_USERS_ACTION_TITLE_EMAIL}\\\" title=\\\"{\$LANG_ACP_USERS_ACTION_TITLE_EMAIL}\\\" /></a>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_users_delete\")) ? (\"<a href=\\\"users.php?action=delete&amp;userid[]=\$row[userid]&amp;sid=\$session[hash]\\\"><img src=\\\"{\$style['imagefolder']}/delete.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_ACP_USERS_ACTION_TITLE_DELETE}\\\" title=\\\"{\$LANG_ACP_USERS_ACTION_TITLE_DELETE}\\\" /></a>\") : (\"\")).\"
 \".((checkAdminPermissions(\"a_can_users_access\")) ? (\"<a href=\\\"users.php?action=access&amp;userid[]=\$row[userid]&amp;sid=\$session[hash]\\\"><img src=\\\"{\$style['imagefolder']}/rights.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_ACP_USERS_ACTION_TITLE_ACCESS}\\\" title=\\\"{\$LANG_ACP_USERS_ACTION_TITLE_ACCESS}\\\" /></a>\") : (\"\")).\"
 <a href=\\\"javascript:tostorage('user',\$row[userid],'\$username')\\\"><img src=\\\"{\$style['imagefolder']}/tostorage.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_ACP_USERS_ACTION_TITLE_CLIPBOARD}\\\" title=\\\"{\$LANG_ACP_USERS_ACTION_TITLE_CLIPBOARD}\\\" /></a>
 </td>
 <td>\".((\$row['activation']==1) 
 
 ? (\"\".((\$row['blocked']==1) 
 ? (\"<img src=\\\"../images/onclosed.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_ACP_USERS_SHOW_ONCLOSED']}\\\" title=\\\"{\$lang->items['LANG_ACP_USERS_SHOW_ONCLOSED']}\\\" />\") 
 : (\"<img src=\\\"../images/on.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_ACP_USERS_SHOW_ON']}\\\" title=\\\"{\$lang->items['LANG_ACP_USERS_SHOW_ON']}\\\" />\")
 ).\"\") 
 
 : (\"\".((\$row['blocked']==1) 
 ? (\"<img src=\\\"../images/offclosed.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_ACP_USERS_SHOW_OFFCLOSED']}\\\" title=\\\"{\$lang->items['LANG_ACP_USERS_SHOW_OFFCLOSED']}\\\" />\") 
 : (\"<img src=\\\"../images/off.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_ACP_USERS_SHOW_OFF']}\\\" title=\\\"{\$lang->items['LANG_ACP_USERS_SHOW_OFF']}\\\" />\")
 ).\"\")
 
 ).\"</td>
 <td width=\\\"30%\\\"><a href=\\\"../profile.php?userid=\$row[userid]\\\" target=\\\"_blank\\\">\$row[username]</a></td>
 <td width=\\\"30%\\\">\$row[email]</td>
 <td width=\\\"15%\\\" align=\\\"center\\\">\$regdate</td>
 <td width=\\\"25%\\\" align=\\\"center\\\">\$lastactivity</td>
 <td align=\\\"center\\\"><input type=\\\"checkbox\\\" name=\\\"userid[]\\\" value=\\\"\$row[userid]\\\" /><input type=\\\"hidden\\\" name=\\\"u\$row[userid]\\\" value=\\\"\$row[username]\\\" /></td>
</tr>";
?>
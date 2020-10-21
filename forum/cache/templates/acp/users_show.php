<?php
/*
acp template
templatename: users_show
*/

$this->templates['acp_users_show']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<script type=\\\"text/javascript\\\">
<!--
 function tostorage(mode,id,title) {
  parent.storage.add(mode,id,title);
 }

 function select_all(status) {
  for (i=0;i<document.bbform.length;i++) {
   if(document.bbform.elements[i].name==\\\"userid[]\\\") document.bbform.elements[i].checked = status;    
  }
 }
 
 function validate(theform) {
  if(theform.action.options[theform.action.selectedIndex].value=='tostorage') {
   for (i=0;i<theform.length;i++) {
    if(theform.elements[i].name==\\\"userid[]\\\" && document.bbform.elements[i].checked ) {
     id = theform.elements[i].value;
     title = eval('theform.u'+id+'.value');
     parent.storage.add('user',id,title);
    }
   }
   return false;
  }
  else return true;
 }
//-->
</script>
</head>

<body>
<form method=\\\"post\\\" action=\\\"users.php\\\" name=\\\"bbform\\\" onsubmit=\\\"return validate(this)\\\">
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
 <tr class=\\\"tblhead\\\">
  <td colspan=\\\"7\\\">{\$lang->items['LANG_ACP_USERS_FIND_RESULT']}</td>
 </tr>
 <tr class=\\\"tblsection\\\">
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td nowrap=\\\"nowrap\\\">{\$lang->items['LANG_MEMBERS_MBL_USERNAME']}</td>
  <td nowrap=\\\"nowrap\\\">{\$lang->items['LANG_MEMBERS_MBL_EMAIL']}</td>
  <td align=\\\"center\\\" nowrap=\\\"nowrap\\\">{\$lang->items['LANG_MEMBERS_MBL_REGDATE']}</td>
  <td align=\\\"center\\\" nowrap=\\\"nowrap\\\">{\$lang->items['LANG_MEMBERS_MBL_LASTACTIVITY']}</td>
  <td align=\\\"center\\\"><input type=\\\"checkbox\\\" name=\\\"all\\\" value=\\\"1\\\" onclick=\\\"select_all(this.checked)\\\" /></td>
 </tr>
 \$userbit
</table>
<table align=\\\"right\\\">
 <tr>
  <td><select name=\\\"action\\\">
   <option value=\\\"find\\\">{\$lang->items['LANG_ACP_USERS_SELECT_ACTION']}</option>
   \".((checkAdminPermissions(\"a_can_users_email\")) ? (\"<option value=\\\"email\\\">{\$lang->items['LANG_ACP_USERS_ACTION_EMAIL']}</option>\") : (\"\")).\"
   \".((checkAdminPermissions(\"a_can_users_delete\")) ? (\"<option value=\\\"delete\\\">{\$lang->items['LANG_ACP_USERS_ACTION_DELETE']}</option>\") : (\"\")).\"
   \".((checkAdminPermissions(\"a_can_users_access\")) ? (\"<option value=\\\"access\\\">{\$lang->items['LANG_ACP_USERS_ACTION_ACCESS']}</option>\") : (\"\")).\"
   <option value=\\\"tostorage\\\">{\$lang->items['LANG_ACP_USERS_ACTION_CLIPBOARD']}</option>
   \".((checkAdminPermissions(\"a_can_users_activation\")) ? (\"<option value=\\\"activate\\\">{\$lang->items['LANG_ACP_USERS_ACTION_ACTIVATION']}</option>\") : (\"\")).\"
   \".((checkAdminPermissions(\"a_can_users_other\")) ? (\"<option value=\\\"activation_email\\\">{\$lang->items['LANG_ACP_USERS_ACTION_ACTIVATION_EMAIL']}</option>\") : (\"\")).\"
   \".((checkAdminPermissions(\"a_can_users_other\")) ? (\"<option value=\\\"selectstats\\\">{\$lang->items['LANG_ACP_USERS_ACTION_STATS']}</option>\") : (\"\")).\"
   \".((checkAdminPermissions(\"a_can_users_merge\")) ? (\"<option value=\\\"merge\\\">{\$lang->items['LANG_ACP_USERS_ACTION_MERGE']}</option>\") : (\"\")).\"
  </select> <input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_GO']}\\\" /></td>
 </tr>
</table>
</form>
<p align=\\\"center\\\">\$pagelink</p>

</body>
</html>";
?>
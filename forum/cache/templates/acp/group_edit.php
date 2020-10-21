<?php
/*
acp template
templatename: group_edit
*/

$this->templates['acp_group_edit']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<script type=\\\"text/javascript\\\">
<!--

 function addToGroupleaderList(userid,username)
 {
 	var selectlist = document.getElementById('groupleaders');
	if(userid>0 && username!='' && !isInList(userid))
	{
		var count=selectlist.length;
		newoption = new Option(username,userid,true,true);
		selectlist.options[count] = newoption;
		selectlist.options[count].text=username;
		selectlist.options[count].value=userid;
		selectlist.options[count].selected=true;
	}
 }

 function isInList(userid)
 {
 	var selectlist = document.getElementById('groupleaders');
 	for(i=0;i<selectlist.length;i++)
	{
		if(selectlist.options[i].value==userid) return true;
	}
	return false;
 }
//-->
</script>
</head>

<body>
<form method=\\\"post\\\" action=\\\"group.php\\\" name=\\\"bbform\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"groupid\\\" value=\\\"\$groupid\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GROUP_ACTION_EDIT']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
		<td><b>{\$lang->items['LANG_ACP_GROUP_GROUPNAME']}</b></td>
		<td><input type=\\\"text\\\" name=\\\"title\\\" value=\\\"\$group[title]\\\" maxlength=\\\"50\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
		<td><b>{\$lang->items['LANG_ACP_GROUP_GROUPDESC']}</b></td>
		<td><textarea name=\\\"description\\\" rows=\\\"5\\\" cols=\\\"50\\\">\$group[description]</textarea></td>
  </tr>
  <tr class=\\\"firstrow\\\">
		<td><b>{\$lang->items['LANG_ACP_GROUP_GROUPTYPE']}</b></td>
		<td><select name=\\\"grouptype\\\"\$grouptypedisabled>

		\".((\$group['grouptype']>4) 
		? (\"

		<option value=\\\"5\\\"\$selected[5]>{\$lang->items['LANG_ACP_GROUP_GROUPTYPE_5']}</option>
		<option value=\\\"6\\\"\$selected[6]>{\$lang->items['LANG_ACP_GROUP_GROUPTYPE_6']}</option>
		<option value=\\\"7\\\"\$selected[7]>{\$lang->items['LANG_ACP_GROUP_GROUPTYPE_7']}</option>

		\") 
		: (\"

		<option value=\\\"1\\\"\$selected[1]>{\$lang->items['LANG_ACP_GROUP_GROUPTYPE_1']}</option>
		<option value=\\\"2\\\"\$selected[2]>{\$lang->items['LANG_ACP_GROUP_GROUPTYPE_2']}</option>
		<option value=\\\"3\\\"\$selected[3]>{\$lang->items['LANG_ACP_GROUP_GROUPTYPE_3']}</option>
		<option value=\\\"4\\\"\$selected[4]>{\$lang->items['LANG_ACP_GROUP_GROUPTYPE_4']}</option>

		\")
		).\"

		</select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
		<td><b>{\$lang->items['LANG_ACP_GROUP_SECURITYLEVEL']}</b></td>
		<td><input type=\\\"text\\\" name=\\\"securitylevel\\\" value=\\\"\$group[securitylevel]\\\" size=\\\"3\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
		<td><b>{\$lang->items['LANG_ACP_GROUP_USERONLINEMARKING']}</b><br />{\$lang->items['LANG_ACP_GROUP_USERONLINEMARKING_DESC']}</td>
		<td><input type=\\\"text\\\" name=\\\"useronlinemarking\\\" value=\\\"\$group[useronlinemarking]\\\" maxlength=\\\"255\\\" /></td>
  </tr>
  
  \".((\$group['grouptype']>1) 
  ? (\"
  <tr class=\\\"secondrow\\\">
		<td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_GROUP_GROUPLEADER']}</b></td>
		<td><select name=\\\"groupleaders[]\\\" id=\\\"groupleaders\\\" multiple=\\\"multiple\\\">\$groupleaders_options</select> <input type=\\\"button\\\" onclick=\\\"window.open('group.php?action=group_finduser&sid=\$session[hash]', 'moo', 'toolbar=no,scrollbars=yes,resizable=yes,width=300,height=180');\\\" value=\\\"{\$lang->items['LANG_ACP_GROUP_FIND_USER']}\\\" /></td>
  </tr>
  \") : (\"\")
  ).\"

  \".((\$group['grouptype']>4) 
  ? (\"
  <tr class=\\\"firstrow\\\">
		<td><b>{\$lang->items['LANG_ACP_GROUP_AI_POSTS']}</b><br />{\$lang->items['LANG_ACP_GROUP_AI_POSTS_DESC']}</td>
		<td><input type=\\\"text\\\" name=\\\"ai_posts\\\" value=\\\"\$group[ai_posts]\\\" maxlength=\\\"5\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
		<td><b>{\$lang->items['LANG_ACP_GROUP_AI_DAYS']}</b><br />{\$lang->items['LANG_ACP_GROUP_AI_DAYS_DESC']}</td>
		<td><input type=\\\"text\\\" name=\\\"ai_days\\\" value=\\\"\$group[ai_days]\\\" maxlength=\\\"5\\\" /></td>
  </tr>

  <tr class=\\\"firstrow\\\">
		<td><b>{\$lang->items['LANG_ACP_GROUP_SHOWONTEAM']}</b><br />{\$lang->items['LANG_ACP_GROUP_SHOWONTEAM_DESC']}</td>
		<td><select name=\\\"showonteam\\\">
		 <option value=\\\"1\\\"\$sel_showonteam[1]>{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
		 <option value=\\\"0\\\"\$sel_showonteam[0]>{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
		</select></td>
  </tr>

  \") : (\"\")
  ).\"

  <tr class=\\\"secondrow\\\">
		<td><b>{\$lang->items['LANG_ACP_GROUP_SHOWORDER']}</b><br />{\$lang->items['LANG_ACP_GROUP_SHOWORDER_DESC']}</td>
		<td><input type=\\\"text\\\" name=\\\"showorder\\\" value=\\\"\$group[showorder]\\\" maxlength=\\\"5\\\" /></td>
  </tr>


  <tr class=\\\"firstrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
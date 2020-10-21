<?php
/*
acp template
templatename: profilefield_edit
*/

$this->templates['acp_profilefield_edit']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<script type=\\\"text/javascript\\\">
<!--
function changeFieldType(fieldtype)
{
	var maxlength=document.bbform.maxlength;
	var fieldsize=document.bbform.fieldsize;
	var fieldoptions=document.bbform.fieldoptions;
	var choicecount=document.bbform.choicecount;

	if(fieldtype==\\\"text\\\")
	{
		maxlength.disabled=false;
		fieldsize.disabled=false;
		fieldoptions.disabled=true;
		choicecount.disabled=true;
	}
	else if(fieldtype==\\\"date\\\")
	{
		maxlength.disabled=true;
		fieldsize.disabled=true;
		fieldoptions.disabled=true;
		choicecount.disabled=true;
	}
	else if(fieldtype==\\\"checkbox\\\")
	{
		maxlength.disabled=true;
		fieldsize.disabled=true;
		fieldoptions.disabled=false;
		choicecount.disabled=true;
	}
	else if(fieldtype==\\\"select\\\")
	{
		maxlength.disabled=true;
		fieldsize.disabled=true;
		fieldoptions.disabled=false;
		choicecount.disabled=true;
	}
	else if(fieldtype==\\\"multiselect\\\")
	{
		maxlength.disabled=true;
		fieldsize.disabled=true;
		fieldoptions.disabled=false;
		choicecount.disabled=false;
	}
}
//-->
</script>
</head>

<body>
<form method=\\\"post\\\" action=\\\"profilefield.php\\\" name=\\\"bbform\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<input type=\\\"hidden\\\" name=\\\"profilefieldid\\\" value=\\\"\$_REQUEST[profilefieldid]\\\" />
<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_PROFILEFIELD_EDIT']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_PROFILEFIELD_TITLE']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"title\\\" value=\\\"\$profile[title]\\\" maxlength=\\\"100\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_PROFILEFIELD_DESCRIPTION']}</b><br />{\$lang->items['LANG_ACP_PROFILEFIELD_DESCRIPTION_DESC']}</td>
   <td><textarea cols=\\\"50\\\" rows=\\\"5\\\" name=\\\"description\\\">\$profile[description]</textarea></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_PROFILEFIELD_REQUIRED']}</b><br />{\$lang->items['LANG_ACP_PROFILEFIELD_REQUIRED_DESC']}</td>
   <td><select name=\\\"required\\\">
		<option value=\\\"1\\\"\$profilesel[0]>{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
		<option value=\\\"0\\\"\$profilesel[1]>{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_PROFILEFIELD_SHOWINTHREAD']}</b><br />{\$lang->items['LANG_ACP_PROFILEFIELD_SHOWINTHREAD_DESC']}</td>
   <td><select name=\\\"showinthread\\\">
		<option value=\\\"1\\\"\$profilesel[2]>{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
		<option value=\\\"0\\\"\$profilesel[3]>{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_PROFILEFIELD_HIDDEN']}</b><br />{\$lang->items['LANG_ACP_PROFILEFIELD_HIDDEN_DESC']}</td>
   <td><select name=\\\"hidden\\\">
		<option value=\\\"1\\\"\$profilesel[4]>{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
		<option value=\\\"0\\\"\$profilesel[5]>{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_PROFILEFIELD_FIELDTYPE']}</b><br />{\$lang->items['LANG_ACP_PROFILEFIELD_FIELDTYPE_DESC']}</td>
   <td><select name=\\\"fieldtype\\\" onchange=\\\"changeFieldType(this.options[this.selectedIndex].value);\\\">
		<option value=\\\"text\\\"\$profilesel[6]>{\$lang->items['LANG_ACP_PROFILEFIELD_FIELDTYPE_TEXT']}</option>
		<option value=\\\"select\\\"\$profilesel[7]>{\$lang->items['LANG_ACP_PROFILEFIELD_FIELDTYPE_SELECT']}</option>
		<option value=\\\"checkbox\\\"\$profilesel[8]>{\$lang->items['LANG_ACP_PROFILEFIELD_FIELDTYPE_CHECKBOX']}</option>
		<option value=\\\"date\\\"\$profilesel[9]>{\$lang->items['LANG_ACP_PROFILEFIELD_FIELDTYPE_DATE']}</option>
		<option value=\\\"multiselect\\\"\$profilesel[10]>{\$lang->items['LANG_ACP_PROFILEFIELD_FIELDTYPE_MULTISELECT']}</option>
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_PROFILEFIELD_FIELDTYPE_HINT']}</td>
   <td><textarea name=\\\"fieldoptions\\\" rows=\\\"6\\\" cols=\\\"50\\\">\$profile[fieldoptions]</textarea></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_PROFILEFIELD_MAXLENGTH']}</b><br />{\$lang->items['LANG_ACP_PROFILEFIELD_MAXLENGTH_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"maxlength\\\" value=\\\"\$profile[maxlength]\\\" maxlength=\\\"5\\\" /></td>
  </tr>
   <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_PROFILEFIELD_FIELDSIZE']}</b><br />{\$lang->items['LANG_ACP_PROFILEFIELD_FIELDSIZE_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"fieldsize\\\" value=\\\"\$profile[fieldsize]\\\" maxlength=\\\"3\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_PROFILEFIELD_FIELDORDER']}</b><br />{\$lang->items['LANG_ACP_PROFILEFIELD_FIELDORDER_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"fieldorder\\\" value=\\\"\$profile[fieldorder]\\\" maxlength=\\\"7\\\" /></td>
  </tr>
   <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_PROFILEFIELD_CHOICECOUNT']}</b><br />{\$lang->items['LANG_ACP_PROFILEFIELD_CHOICECOUNT_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"choicecount\\\" value=\\\"\$profile[choicecount]\\\" maxlength=\\\"3\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
<?php
/*
acp template
templatename: group_permissions
*/

$this->templates['acp_group_permissions']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />

<style type=\\\"text/css\\\">
<!--
select {
 font-size: 11px;
}
.small {
 font-size: 11px;
}
.redBG {
 background-color: red;
}
.greenBG {
 background-color: green;
}
.whiteBG {
 background-color: #ffffff;
}

-->
</style>


<script type=\\\"text/javascript\\\">
<!--
function setvalues(field, value)
{
	var form = document.permform;
	var fieldi = '';
	var pos = 0;

	for(var i=0; i<form.elements.length; i++)
	{
		pos = form.elements[i].name.indexOf('[');
		fieldi = form.elements[i].name.substring(0,pos);
		
		if((field!='' && field==fieldi) || (field=='' && (fieldi=='boardpermission' || fieldi=='startpermission' || fieldi=='replypermission')))
		{
			for(var e=0; e<form.elements[i].options.length; e++)
			{
				if(form.elements[i].options[e].value==value) form.elements[i].options[e].selected=true;
				else form.elements[i].options[e].selected=false;
			}
			
			setBackgroundClass(form.elements[i]);
		}
	}
}
function setBackgroundClass(selectBox) 
{
	var className = selectBox.options[selectBox.options.selectedIndex].className;
	selectBox.className = className;
	
	var x = selectBox.name == 'foo' ? 1 : 0;
		
	if (className == 'whiteBG') selectBox.options[x].selected = true;
	else if (className == 'redBG') selectBox.options[x + 1].selected = true;
	else if (className == 'greenBG') selectBox.options[x + 2].selected = true;
	else selectBox.options[0].selected = true;
}
function resetAll(form) {
	for(var i=0; i<form.elements.length; i++)
	{
		if (form.elements[i].options) 
		{
			for(var j=0; j<form.elements[i].options.length; j++) 
			{
				if (form.elements[i].options[j].defaultSelected == true) 
				{
					var className = form.elements[i].options[j].className;
					form.elements[i].className = className;
				}
			}
		}
	}
}
//-->
</script>

</head>

<body>
<form method=\\\"post\\\" action=\\\"group.php\\\" name=\\\"permform\\\" onreset=\\\"resetAll(this);\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"groupid\\\" value=\\\"\$groupid\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"\$maxcolspan2\\\">{\$lang->items['LANG_ACP_GROUP_PERMISSIONS']}</td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td nowrap=\\\"nowrap\\\" class=\\\"small\\\">{\$lang->items['LANG_ACP_GROUP_PERMISSIONS_BOARDPERMISSION']}</td>
   <td nowrap=\\\"nowrap\\\" class=\\\"small\\\">{\$lang->items['LANG_ACP_GROUP_PERMISSIONS_STARTPERMISSION']}</td>
   <td nowrap=\\\"nowrap\\\" class=\\\"small\\\">{\$lang->items['LANG_ACP_GROUP_PERMISSIONS_REPLYPERMISSION']}</td>
   <td nowrap=\\\"nowrap\\\" class=\\\"small\\\" colspan=\\\"\$maxcolspan\\\">{\$lang->items['LANG_ACP_GROUP_PERMISSIONS_BOARD']}</td>
  </tr>
  
  <tr class=\\\"tblsection\\\" align=\\\"center\\\">
   <td nowrap=\\\"nowrap\\\"><select name=\\\"foo\\\" onchange=\\\"if(this.options[this.options.selectedIndex].value!='') { setvalues('boardpermission',this.options[this.options.selectedIndex].value); } setBackgroundClass(this);\\\">
          <option value=\\\"\\\" selected=\\\"selected\\\">--</option>
          <option value=\\\"-1\\\" class=\\\"whiteBG\\\">{\$lang->items['LANG_ACP_GROUP_GROUPDEFAULT']}</option>
          <option value=\\\"0\\\" class=\\\"redBG\\\">{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
          <option value=\\\"1\\\" class=\\\"greenBG\\\">{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
        </select></td>
   <td nowrap=\\\"nowrap\\\"><select name=\\\"foo\\\" onchange=\\\"if(this.options[this.options.selectedIndex].value!='') { setvalues('startpermission',this.options[this.options.selectedIndex].value); } setBackgroundClass(this);\\\">
          <option value=\\\"\\\" selected=\\\"selected\\\">--</option>
          <option value=\\\"-1\\\" class=\\\"whiteBG\\\">{\$lang->items['LANG_ACP_GROUP_GROUPDEFAULT']}</option>
          <option value=\\\"0\\\" class=\\\"redBG\\\">{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
          <option value=\\\"1\\\" class=\\\"greenBG\\\">{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
        </select></td>
   <td nowrap=\\\"nowrap\\\"><select name=\\\"foo\\\" onchange=\\\"if(this.options[this.options.selectedIndex].value!='') { setvalues('replypermission',this.options[this.options.selectedIndex].value); } setBackgroundClass(this);\\\">
          <option value=\\\"\\\" selected=\\\"selected\\\">--</option>
          <option value=\\\"-1\\\" class=\\\"whiteBG\\\">{\$lang->items['LANG_ACP_GROUP_GROUPDEFAULT']}</option>
          <option value=\\\"0\\\" class=\\\"redBG\\\">{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
          <option value=\\\"1\\\" class=\\\"greenBG\\\">{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
        </select></td>
   <td nowrap=\\\"nowrap\\\" class=\\\"small\\\" colspan=\\\"\$maxcolspan\\\">&nbsp;</td>
  </tr>
  
  \$boardlist
  
  <tr class=\\\"firstrow\\\">
   <td colspan=\\\"\$maxcolspan2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
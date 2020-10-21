<?php
/*
acp template
templatename: style_export
*/

$this->templates['acp_style_export']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<script type=\\\"text/javascript\\\">
<!--
function select_all(what, status)
{
	list=eval(\\\"document.forms[0].elements[\\\"+what+\\\"]\\\");
	for(i=0;i<list.length;i++)
	{
		list.options[i].selected=true;
	}
}

function preview_image(what)
{
	list=eval(\\\"document.forms[0].elements[\\\"+what+\\\"]\\\");
	if(list.selectedIndex>=0 && list.options[list.selectedIndex].value!='') document.imagepreview.src='../\$designelements[imagefolder]/'+list.options[list.selectedIndex].value;
	else document.imagepreview.src='{\$style['imagefolder']}/blank.gif';
}
//-->
</script>
</head>
<body>
<form method=\\\"post\\\" action=\\\"style.php\\\" name=\\\"bbform\\\">

<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
 <tr class=\\\"tblhead\\\">
  <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_STYLE_EXPORT']}</td>
 </tr>
<tr class=\\\"firstrow\\\">
 <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_STYLE_STYLENAME']}:</b><br />{\$lang->items['LANG_ACP_STYLE_EXPORT_STYLENAME_DESC']}</td>
 <td width=\\\"60%\\\"><input type=\\\"text\\\" size=\\\"40\\\" name=\\\"stylename\\\" value=\\\"\$style_info[stylename]\\\" /></td>
</tr>
<tr class=\\\"secondrow\\\">
 <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_STYLE_EXPORT_DESIGNPACK']}</b><br />{\$lang->items['LANG_ACP_STYLE_EXPORT_DESIGNPACK_DESC']}</td>
 <td width=\\\"60%\\\"><input type=\\\"checkbox\\\" name=\\\"exportdesignpack\\\" value=\\\"1\\\" checked=\\\"checked\\\" /></td>
</tr>
<tr class=\\\"firstrow\\\">
 <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_STYLE_DESIGNPACKNAME']}:</b><br />{\$lang->items['LANG_ACP_STYLE_EXPORT_DESIGNPACKNAME_DESC']}</td>
 <td width=\\\"60%\\\"><input type=\\\"text\\\" size=\\\"40\\\" name=\\\"designpackname\\\" value=\\\"\$designpack_info[designpackname]\\\" /></td>
</tr>
<tr class=\\\"secondrow\\\">
 <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_STYLE_EXPORT_TEMPLATE']}</b><br />{\$lang->items['LANG_ACP_STYLE_EXPORT_TEMPLATE_DESC']}<br /><a href=\\\"#\\\" onclick=\\\"select_all('3',true); return false;\\\">{\$lang->items['LANG_ACP_STYLE_SELECT_ALL']}</a></td>
  <td width=\\\"60%\\\"><select name=\\\"templates[]\\\" size=\\\"20\\\" style=\\\"width: 95%;\\\" multiple=\\\"multiple\\\">\$template_options</select></td>
 </tr>
<tr class=\\\"firstrow\\\">
 <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_STYLE_EXPORT_IMAGES']}</b><br />{\$lang->items['LANG_ACP_STYLE_EXPORT_IMAGES_DESC']}<br />
 <a href=\\\"#\\\" onclick=\\\"select_all('4',true); return false;\\\">{\$lang->items['LANG_ACP_STYLE_SELECT_ALL']}</a><br /><br /><img name=\\\"imagepreview\\\" src=\\\"{\$style['imagefolder']}/blank.gif\\\" alt=\\\"\\\" border=\\\"0\\\" />
 </td>
  <td width=\\\"60%\\\"><select name=\\\"images[]\\\" size=\\\"20\\\" style=\\\"width: 95%;\\\" multiple=\\\"multiple\\\" onchange=\\\"preview_image('4');\\\">\$image_options</select></td>
</tr>

\".((function_exists(\"gzencode\")) ? (\"
<tr class=\\\"secondrow\\\">
 <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_STYLE_EXPORT_GZIP']}</b><br />{\$lang->items['LANG_ACP_STYLE_EXPORT_GZIP_DESC']}</td>
 <td width=\\\"60%\\\"><input type=\\\"checkbox\\\" name=\\\"gzip\\\" value=\\\"1\\\" /></td>
</tr>\") : (\"\")).\"

<tr class=\\\"firstrow\\\">
  <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_START']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
</tr>
</table>

<input type=\\\"hidden\\\" name=\\\"styleid\\\" value=\\\"\$styleid\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
</form>
 
</body>
</html>";
?>
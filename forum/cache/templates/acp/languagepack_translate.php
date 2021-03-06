<?php
/*
acp template
templatename: languagepack_translate
*/

$this->templates['acp_languagepack_translate']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<script type=\\\"text/javascript\\\">
<!--
function changeCat()
{
	var form=document.languageform;
	window.location='languagepack.php?action=\$action&languagepackid=\$languagepackid&catid='+form.catid.options[form.catid.selectedIndex].value+'&translation='+form.translation.options[form.translation.selectedIndex].value+'&sid=\$session[hash]';
}
//-->
</script>
</head>

<body>

<form method=\\\"get\\\" action=\\\"languagepack.php\\\" name=\\\"languageform\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"languagepackid\\\" value=\\\"\$languagepackid\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_LANGUAGEPACK_TRANSLATEPACK']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_LANGUAGEPACK_CATEGORY']}</td>
   <td><select name=\\\"catid\\\" onchange=\\\"changeCat();\\\">
    <option value=\\\"0\\\">{\$lang->items['LANG_ACP_GLOBAL_PLEASE_SELECT']}</option>
    \$cat_options
   </select>&nbsp;<input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_GO']}\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>{\$lang->items['LANG_ACP_LANGUAGEPACK_TRANSLATION']}</td>
   <td><select name=\\\"translation\\\" onchange=\\\"changeCat();\\\">
    <option value=\\\"-1\\\">{\$lang->items['LANG_ACP_GLOBAL_PLEASE_SELECT']}</option>
    \$translation_options
   </select>&nbsp;<input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_GO']}\\\" /></td>
  </tr>
 </table>
</form>

\".((\$itembit!=\"\") 
 ? (\"
  <br />
  <form method=\\\"post\\\" action=\\\"languagepack.php\\\">
  <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
  <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
  <input type=\\\"hidden\\\" name=\\\"languagepackid\\\" value=\\\"\$languagepackid\\\" />
  <input type=\\\"hidden\\\" name=\\\"catid\\\" value=\\\"\$catid\\\" />
  <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
   <tr class=\\\"tblhead\\\">
    <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_LANGUAGEPACK_ITEMS']}</td>
   </tr>
   \$itembit
   <tr class=\\\"tblsection\\\">
    <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
   </tr>
  </table>
  \") : (\"\")
 ).\"
</form>
</body>
</html>";
?>
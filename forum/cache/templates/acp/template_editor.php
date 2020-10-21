<?php
/*
acp template
templatename: template_editor
*/

$this->templates['acp_template_editor']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>
<body>
 \$error
 <form method=\\\"post\\\" action=\\\"template.php\\\" name=\\\"tform\\\">
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
 <input type=\\\"hidden\\\" name=\\\"templateid\\\" value=\\\"\$templateid\\\" />
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_TEMPLATE_TEMPLATEEDITOR']}</td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_TEMPLATE_CHOICE_TEMPLATEPACK']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_TEMPLATE_TEMPLATEPACK']}:</b></td>
   <td width=\\\"50%\\\"><select class=\\\"input\\\" name=\\\"templatepackid\\\">
    \$templatepack_options				
   </select></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_TEMPLATE_TEMPLATE']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_TEMPLATE_TEMPLATENAME']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"templatename\\\" value=\\\"\$templatename\\\" class=\\\"input\\\" maxlength=\\\"100\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td colspan=\\\"2\\\"><textarea rows=\\\"24\\\" cols=\\\"90\\\" name=\\\"template\\\" class=\\\"input\\\" style=\\\"width:100%;\\\" wrap=\\\"off\\\">\$template</textarea></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /> <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_CANCELFORM']}\\\" onclick=\\\"window.location.href='template.php?action=view&amp;templatepackid=\$templatepackid&amp;sid=\$session[hash]'\\\" /></td>
  </tr>
 </table></form>
</body>
</html>";
?>
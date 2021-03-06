<?php
/*
acp template
templatename: template_import_export
*/

$this->templates['acp_template_import_export']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<script type=\\\"text/javascript\\\">
 <!--
  function select_all(status) {
   var sbox = document.tform.elements[3];
   for(i=0;i<sbox.options.length;i++) sbox.options[i].selected=status;
  }
  
  function previewFiles(theForm) {
  	theForm.action.value = 'import/export';
  	theForm.submit();
  }
 //-->
</script>
</head>
<body>
 \".((checkAdminPermissions(\"a_can_template_import\")) 
 ? (\"
 <form method=\\\"post\\\" action=\\\"template.php\\\">
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$fileimportAction\\\" />
  <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
   <tr class=\\\"tblhead\\\">
    <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_TEMPLATE_IMPORT']}</td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td><b>{\$lang->items['LANG_ACP_TEMPLATE_SAVE_IN_TEMPLATEPACK']}</b></td>
    <td><select class=\\\"input\\\" name=\\\"templatepackid\\\">
     \$templatepack_options				
    </select></td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td width=\\\"100%\\\"><b>{\$lang->items['LANG_ACP_TEMPLATE_TEMPLATEFOLDER']}</b><br />{\$lang->items['LANG_ACP_TEMPLATE_TEMPLATEFOLDER_DESC']}</td>
    <td><input type=\\\"text\\\" name=\\\"templatefolder\\\" value=\\\"\$templatefolderValue\\\" /><br /><input type=\\\"button\\\" onclick=\\\"previewFiles(this.form)\\\" value=\\\"{\$lang->items['LANG_ACP_TEMPLATE_TEMPLATEFOLDER_SHOW']}\\\" /></td>
   </tr>
   \$importSelect
   <tr class=\\\"firstrow\\\">
    <td colspan=\\\"2\\\" align=\\\"right\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_TEMPLATE_IMPORT_GO']}\\\" /></td>
   </tr>
  </table>
 </form>
 \") : (\"\")
 ).\"
 
 \".((checkAdminPermissions(\"a_can_template_export\")) 
 ? (\"
 <br />
 <form method=\\\"post\\\" action=\\\"template.php\\\" name=\\\"tform\\\">
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"export\\\" />
  <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
   <tr class=\\\"tblhead\\\">
    <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_TEMPLATE_EXPORT']}</td>
   </tr>
   <tr class=\\\"tblsection\\\">
    <td colspan=\\\"2\\\"><select class=\\\"input\\\" name=\\\"templatepackid\\\" onchange=\\\"window.location=('template.php?action=\$action&amp;sid=\$session[hash]&amp;templatepackid='+this.options[this.selectedIndex].value)\\\">
     <option value=\\\"*\\\">{\$lang->items['LANG_ACP_TEMPLATE_ALL_TEMPLATES']}</option>
     \$templatepack_options				
    </select></td>
   </tr>
   
   \".((\$templatepackid!=\"*\") 
   ? (\"
   
   <tr class=\\\"firstrow\\\">
    <td width=\\\"70%\\\">
     <select size=\\\"20\\\" name=\\\"templateid[]\\\" style=\\\"width:95%\\\" multiple=\\\"multiple\\\">
	 \$template_options				
	</select>
    </td>
    <td width=\\\"30%\\\" valign=\\\"top\\\" style=\\\"text-align:justify\\\"><p>&nbsp;</p>
    {\$lang->items['LANG_ACP_TEMPLATE_SELECT']}
    <p><a href=\\\"javascript:select_all(true);\\\">{\$lang->items['LANG_ACP_TEMPLATE_MARK_ALL']}</a></p>
    <p><a href=\\\"javascript:select_all(false);\\\">{\$lang->items['LANG_ACP_TEMPLATE_DEMARK_ALL']}</a></p>
    </td>
   </tr>
   
   \") : (\"\")
   ).\"
   
   <tr class=\\\"secondrow\\\">
    <td colspan=\\\"2\\\" align=\\\"right\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_TEMPLATE_EXPORT_GO']}\\\" /></td>
   </tr>
  </table>
 </form>
 \") : (\"\")
 ).\"
</body>
</html>";
?>
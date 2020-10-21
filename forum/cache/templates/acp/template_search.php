<?php
/*
acp template
templatename: template_search
*/

$this->templates['acp_template_search']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<script type=\\\"text/javascript\\\">
 <!--
  function select_all(status) {
   var sbox = document.tform.elements[4];
   for(i=0;i<sbox.options.length;i++) sbox.options[i].selected=status;
  }
 //-->
</script>
</head>
<body onload=\\\"document.tform.search.focus();\\\">
 <form method=\\\"post\\\" action=\\\"template.php\\\" name=\\\"tform\\\">
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
  <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
   <tr class=\\\"tblhead\\\">
    <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_TEMPLATE_SEARCH_REPLACE']}</td>
   </tr>
   <tr class=\\\"tblsection\\\">
    <td colspan=2><select class=\\\"input\\\" name=\\\"templatepackid\\\" onchange=\\\"window.location=('template.php?action=\$action&amp;sid=\$session[hash]&amp;templatepackid='+this.options[this.selectedIndex].value)\\\">
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
    <td><b>{\$lang->items['LANG_ACP_TEMPLATE_SEARCH']}</b><br>{\$lang->items['LANG_ACP_TEMPLATE_SEARCH_DESC']}</td>
    <td><input type=\\\"text\\\" name=\\\"search\\\" maxlength=\\\"250\\\" />&nbsp;<input type=\\\"submit\\\" name=\\\"dosearch\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SEARCHFORM']}\\\" /></td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td><b>{\$lang->items['LANG_ACP_TEMPLATE_REPLACE']}</b><br>{\$lang->items['LANG_ACP_TEMPLATE_REPLACE_DESC']}</td>
    <td><input type=\\\"text\\\" name=\\\"replace\\\" maxlength=\\\"250\\\" />&nbsp;<input type=\\\"submit\\\" name=\\\"doreplace\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_REPLACEFORM']}\\\" /></td>
   </tr>   
  </table>
 </form>
</body>
</html>";
?>
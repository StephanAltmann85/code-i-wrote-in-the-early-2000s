<?php
/*
acp template
templatename: template_view
*/

$this->templates['acp_template_view']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<script type=\\\"text/javascript\\\">
 <!--
  var sessionhash = '\$session[hash]';
 //-->
</script>

<script type=\\\"text/javascript\\\" src=\\\"../js/template.js\\\"></script>	
</head>
<body onload=\\\"document.tform.quicksearch.focus();\\\">
 <form onsubmit=\\\"return false;\\\" name=\\\"tform\\\" action=\\\"\\\">
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
  <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
   <tr class=\\\"tblhead\\\">
    <td>{\$lang->items['LANG_ACP_GLOBAL_MENU_TEMPLATE_EDIT']}</td>
   </tr>
   <tr class=\\\"tblsection\\\">
    <td><select class=\\\"input\\\" name=\\\"templatepackid\\\" onchange=\\\"window.location=('template.php?action=\$action&amp;sid=\$session[hash]&amp;templatepackid='+this.options[this.selectedIndex].value)\\\">
     \$templatepack_options				
    </select></td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td>
     <table width=\\\"100%\\\">
      <tr>
       <td width=\\\"30%\\\" valign=\\\"top\\\" class=\\\"firstrow\\\">{\$lang->items['LANG_ACP_TEMPLATE_COUNT']}</td>
       <td rowspan=\\\"2\\\" width=\\\"70%\\\" align=\\\"right\\\">
        <select size=\\\"20\\\" name=\\\"templateid\\\" style=\\\"width:95%\\\" onDblClick=\\\"editTemplate();\\\">
	 \$template_options				
	</select>
       </td>
      </tr>
      <tr class=\\\"firstrow\\\">
       <td valign=\\\"top\\\">
       <a href=\\\"javascript:addTemplate();\\\">{\$lang->items['LANG_ACP_TEMPLATE_ADD']}</a><br />
       <a href=\\\"javascript:editTemplate();\\\">{\$lang->items['LANG_ACP_TEMPLATE_EDIT']}</a><br />
       <a href=\\\"javascript:copyTemplate();\\\">{\$lang->items['LANG_ACP_TEMPLATE_COPY']}</a><br />
       <a href=\\\"javascript:delTemplate();\\\">{\$lang->items['LANG_ACP_TEMPLATE_DEL']}</a><br /><br />
       <b>{\$lang->items['LANG_ACP_TEMPLATE_QUICKSEARCH']}</b><br />
       <input type=\\\"text\\\" name=\\\"quicksearch\\\" value=\\\"\\\" onkeyup=\\\"quick_search(this.form,this.value)\\\" />
	</td>
      </tr>
     </table>
    </td>
   </tr>
  </table>
 </form>
</body>
</html>";
?>
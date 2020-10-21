<?php
/*
acp template
templatename: wordmatch
*/

$this->templates['acp_wordmatch']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"content-type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<script type=\\\"text/javascript\\\">
  <!--
  function select_all(status) {
   for (i=0;i<document.bbform.length;i++) {
    if(document.bbform.elements[i].name==\\\"wordids[]\\\") document.bbform.elements[i].checked = status;    
   }
  }
  //-->
 </script>
</head>

<body>
<form method=\\\"post\\\" action=\\\"otherstuff.php\\\" name=\\\"bbform\\\">
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"\".(2+(int)checkAdminPermissions(\"a_can_otherstuff_wordmatch2\")).\"\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_OTHERSTUFF_WORDMATCH']}</td>
  </tr>
  <tr class=\\\"tblsection\\\" align=\\\"center\\\">
   \".((checkAdminPermissions(\"a_can_otherstuff_wordmatch2\")) 
   ? (\"
   <td><input type=\\\"checkbox\\\" id=\\\"checkbox1\\\" onclick=\\\"select_all(this.checked)\\\" /></td>
   <td align=\\\"left\\\"><label for=\\\"checkbox1\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_WORDMATCH_WORD']}</label></td>
   \") 
   : (\"
   <td align=\\\"left\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_WORDMATCH_WORD']}</td>
   \")
   ).\"
   <td nowrap=\\\"nowrap\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_WORDMATCH_MOUNT']}</td>
  </tr>
  \$wordbit
 </table>
 \".((checkAdminPermissions(\"a_can_otherstuff_wordmatch2\")) 
 ? (\"
 <table>
  <tr>
   <td><select name=\\\"action\\\">
    <option value=\\\"wordmatch\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_WORDMATCH_CHOOSE_ACTION']}</option>
    <option value=\\\"wordmatch2\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_WORDMATCH_ACTION']}</option>
   </select> <input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_OTHERSTUFF_WORDMATCH_SUBMIT']}\\\" /></td>
  </tr>
 </table>
 \") : (\"\")
 ).\"
</form>
</body>
</html>";
?>
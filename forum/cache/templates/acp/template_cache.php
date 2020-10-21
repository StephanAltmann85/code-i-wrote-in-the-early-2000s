<?php
/*
acp template
templatename: template_cache
*/

$this->templates['acp_template_cache']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<script type=\\\"text/javascript\\\">
 <!--
  function update(action,perpage,taskname) {
   if(parent.working.document.bbform) {
    parent.workingtop.location.href='misc.php?sid=\$session[hash]&action=workingtop&taskname='+taskname;
    parent.working.location.href='otherstuff.php?sid=\$session[hash]&action='+action+'&perpage='+perpage;
    window.location.href='otherstuff.php?sid=\$session[hash]&action=doing';
   }
   else alert('{\$lang->items['LANG_ACP_OTHERSTUFF_WORKING_ALREADYWORKING']}'); 
  }
 //-->
</script>
</head>

<body>

<form name=\\\"bbform\\\" method=\\\"post\\\" action=\\\"#\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_TEMPLATE_CACHE']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_TEMPLATE_CACHE_SURE']}<br />{\$lang->items['LANG_ACP_TEMPLATE_CACHE_SURE_DESC']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_OTHERSTUFF_INTERVAL']}</b><br />{\$lang->items['LANG_ACP_TEMPLATE_CACHE_INTERVAL_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"perpage\\\" value=\\\"50\\\" maxlength=\\\"4\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_TEMPLATE_CACHE_ALL']}\\\" onclick=\\\"update('cachetemplates',this.form.perpage.value,'{\$lang->items['LANG_ACP_GLOBAL_MENU_TEMPLATE_CACHE']}')\\\" />&nbsp;<input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_TEMPLATE_CACHE_ONLYNEW']}\\\" onclick=\\\"update('cachetemplates_onlynew',this.form.perpage.value,'{\$lang->items['LANG_ACP_GLOBAL_MENU_TEMPLATE_CACHE']}')\\\" />&nbsp;<input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_NO']}\\\" onclick=\\\"window.location=('template.php?action=view&amp;sid=\$session[hash]')\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
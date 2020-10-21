<?php
/*
acp template
templatename: mailqueue
*/

$this->templates['acp_mailqueue']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"content-type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<script type=\\\"text/javascript\\\">
 <!--
  function update(action,mailid,taskname) {
   if(parent.working.document.bbform) {
    parent.workingtop.location.href='misc.php?sid=\$session[hash]&action=workingtop&taskname='+taskname;
    parent.working.location.href='otherstuff.php?sid=\$session[hash]&action='+action+'&mailid='+mailid;
    window.location.href='otherstuff.php?sid=\$session[hash]&action=doing';
   }
   else alert('{\$lang->items['LANG_ACP_OTHERSTUFF_WORKING_ALREADYWORKING']}'); 
  }
 //-->
</script>
</head>

<body>

<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"6\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_MAILQUEUE']}</td>
  </tr>
  <tr class=\\\"tblsection\\\" align=\\\"center\\\">
   <td>{\$lang->items['LANG_ACP_OTHERSTUFF_MAILQUEUE_SUBJECT']}</td>
   <td>{\$lang->items['LANG_ACP_OTHERSTUFF_MAILQUEUE_SENDER']}</td>
   <td>{\$lang->items['LANG_ACP_OTHERSTUFF_MAILQUEUE_SENDTIME']}</td>
   <td nowrap=\\\"nowrap\\\" colspan=\\\"3\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_MAILQUEUE_PROGRESS']}</td>
  </tr>
  \$mailqueue_bit
 </table>
</body>
</html>";
?>
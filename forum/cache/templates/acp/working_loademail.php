<?php
/*
acp template
templatename: working_loademail
*/

$this->templates['acp_working_loademail']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name</title>
<meta http-equiv=\\\"content-type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
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

<script type=\\\"text/javascript\\\">
 <!--
 update('email',\$mailid,'{\$lang->items['LANG_ACP_OTHERSTUFF_EMAIL']}');
 //-->
</script>

</body>
</html>";
?>
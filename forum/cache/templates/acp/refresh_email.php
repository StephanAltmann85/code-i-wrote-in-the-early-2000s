<?php
/*
acp template
templatename: refresh_email
*/

$this->templates['acp_refresh_email']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name</title>
<meta http-equiv=\\\"content-type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<script type=\\\"text/javascript\\\">
 <!--
  parent.workingtop.location.href='misc.php?sid=\$session[hash]&action=workingtop&taskname=\$taskname&percent=\$percent';
 //-->
</script>
</head>
<body onload=\\\"document.mailform.submit();\\\">
<form name=\\\"mailform\\\" method=\\\"post\\\" action=\\\"otherstuff.php\\\">
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"email\\\" />
<input type=\\\"hidden\\\" name=\\\"page\\\" value=\\\"\$page\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<input type=\\\"hidden\\\" name=\\\"userids\\\" value=\\\"\$userids\\\" />
<input type=\\\"hidden\\\" name=\\\"groupid\\\" value=\\\"\$groupid\\\" />
<input type=\\\"hidden\\\" name=\\\"subject\\\" value=\\\"\$subject\\\" />
<input type=\\\"hidden\\\" name=\\\"message\\\" value=\\\"\$message\\\" />
<input type=\\\"hidden\\\" name=\\\"emailtype\\\" value=\\\"\$emailtype\\\" />
</form>
</body>
</html>";
?>
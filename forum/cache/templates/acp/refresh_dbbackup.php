<?php
/*
acp template
templatename: refresh_dbbackup
*/

$this->templates['acp_refresh_dbbackup']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
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
<body onload=\\\"document.backupform.submit();\\\">
<form name=\\\"backupform\\\" method=\\\"post\\\" action=\\\"otherstuff.php\\\">
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />

<select name=\\\"tables[]\\\" multiple=\\\"multiple\\\">\$tables</select>
<input type=\\\"hidden\\\" name=\\\"structure\\\" value=\\\"\$_POST[structure]\\\" />
<input type=\\\"hidden\\\" name=\\\"drop_table\\\" value=\\\"\$_POST[drop_table]\\\" />
<input type=\\\"hidden\\\" name=\\\"delete_all\\\" value=\\\"\$_POST[delete_all]\\\" />
<input type=\\\"hidden\\\" name=\\\"download\\\" value=\\\"\$_POST[download]\\\" />
<input type=\\\"hidden\\\" name=\\\"use_gz\\\" value=\\\"\$_POST[use_gz]\\\" />

<input type=\\\"hidden\\\" name=\\\"table\\\" value=\\\"\$table\\\" />
<input type=\\\"hidden\\\" name=\\\"newTable\\\" value=\\\"\$newTable\\\" />
<input type=\\\"hidden\\\" name=\\\"filename\\\" value=\\\"\$filename\\\" />
<input type=\\\"hidden\\\" name=\\\"perpage\\\" value=\\\"\$perpage\\\" />
<input type=\\\"hidden\\\" name=\\\"page\\\" value=\\\"\$page\\\" />
<input type=\\\"hidden\\\" name=\\\"totalpage\\\" value=\\\"\$totalpage\\\" />
</form>
</body>
</html>";
?>
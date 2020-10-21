<?php
/*
acp template
templatename: working_dbbackupdone
*/

$this->templates['acp_working_dbbackupdone']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"content-type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
</head>

<body>
<form name=\\\"bbform\\\" action=\\\"#\\\" method=\\\"post\\\">
<input type=\\\"hidden\\\" name=\\\"working\\\" value=\\\"no\\\" />
</form>


<script type=\\\"text/javascript\\\">
 <!--
\".((\$_POST['download'] == 1) ? (\"
  alert('{\$lang->items['LANG_ACP_OTHERSTUFF_DBBACKUP_DONE1']}');
  parent.main.location.href='database.php?sid=\$session[hash]&action=backup_download&filename=\$filename&use_gz=\$_POST[use_gz]';
\") 
: (\"
  alert('{\$lang->items['LANG_ACP_OTHERSTUFF_DBBACKUP_DONE2']}');
\")).\"
 //-->
</script>
</body>
</html>";
?>
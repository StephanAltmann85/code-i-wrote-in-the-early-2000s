<?php
/*
acp template
templatename: working_done
*/

$this->templates['acp_working_done']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"content-type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
</head>

<body onload=\\\"javascript:alert('{\$lang->items['LANG_ACP_OTHERSTUFF_WORKING_DONE']}')\\\">
<form name=\\\"bbform\\\" action=\\\"#\\\" method=\\\"post\\\">
<input type=\\\"hidden\\\" name=\\\"working\\\" value=\\\"no\\\" />
</form>
</body>
</html>";
?>
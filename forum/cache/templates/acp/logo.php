<?php
/*
acp template
templatename: logo
*/

$this->templates['acp_logo']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/other.css\\\" />
</head>

<body>
<div align=\\\"center\\\">
<a href=\\\"welcome.php?sid=\$session[hash]\\\" target=\\\"main\\\">\".((\$wbbuserdata['a_acp_or_mcp']==1) 
? (\"<img src=\\\"{\$style['imagefolder']}/acp-logo.gif\\\" border=\\\"0\\\" alt=\\\"\\\" />\") 
: (\"<img src=\\\"{\$style['imagefolder']}/mcp-logo.gif\\\" border=\\\"0\\\" alt=\\\"\\\" />\")
).\"</a>
</div>
</body>
</html>";
?>
<?php
			/*
			templatepackid: 0
			templatename: polledit_reloadthread
			*/
			
			$this->templates['polledit_reloadthread']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
\$headinclude
<script type=\\\"text/javascript\\\">
<!--
function reloadthread() {
 opener.location.reload();
}

reloadthread();
self.close();
//-->
</script>
</head>
<body>
</body>
</html>";
			?>
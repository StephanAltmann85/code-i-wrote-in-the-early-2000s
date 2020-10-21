<?php
			/*
			templatepackid: 0
			templatename: archive_index
			*/
			
			$this->templates['archive_index']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_START_TITLE']}</title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<base href=\\\"\$url2board/\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"archive/archive.css\\\" />
<script type=\\\"text/javascript\\\">
<!--
window.setTimeout(\\\"window.location.href = '\$url2board/index.php';\\\", 5000);
//-->
</script>
</head>

<body>
<div class=\\\"page\\\">
<h1><a href=\\\"index.php\\\">\$master_board_name</a></h1>

<div class=\\\"content\\\">
\".((\$boardbit != '') ? (\"<ul>\$boardbit</ul>\") : (\"\")).\"
</div>
<div class=\\\"copyright\\\">
<a href=\\\"http://www.woltlab.de\\\" target=\\\"_blank\\\">{\$lang->items['LANG_GLOBAL_COPYRIGHT']}</a>
</div>
</div>
</body>
</html>";
			?>
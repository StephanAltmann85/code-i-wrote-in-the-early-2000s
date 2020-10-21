<?php
			/*
			templatepackid: 0
			templatename: archive_thread
			*/
			
			$this->templates['archive_thread']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\".((\$thread['prefix']!=\"\") ? (\"\$thread[prefix] \") : (\"\")).\"\$thread[topic] | \$master_board_name</title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<base href=\\\"\$url2board/\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"archive/archive.css\\\" />
<script type=\\\"text/javascript\\\">
<!--
window.setTimeout(\\\"window.location.href = '\$url2board/thread.php?threadid=\$threadid';\\\", 5000);
//-->
</script>
</head>

<body>
<div class=\\\"page\\\">
<div class=\\\"navbar\\\"><a href=\\\"archive/index.html\\\">\$master_board_name</a>\$navbar &raquo; \$thread[prefix] \$thread[topic]</div>

<h1>\".((\$thread['prefix']!=\"\") ? (\"\$thread[prefix] \") : (\"\")).\"<a href=\\\"thread.php?threadid=\$threadid\\\">\$thread[topic]</a></h1>

\$postbit

<table class=\\\"pagelinks\\\">
<tr><td>
\".((\$page>1) ? (\"
<div class=\\\"priorpage\\\">
<a href=\\\"archive/\$threadid/\".(\$page - 1).\"/thread.html\\\">{\$lang->items['LANG_ARCHIVE_PRIORPAGE']}</a>
</div>
\") : (\"\")).\"
</td>
<td>
\".((\$pages>\$page) ? (\"
<div class=\\\"nextpage\\\">
<a href=\\\"archive/\$threadid/\".(\$page + 1).\"/thread.html\\\">{\$lang->items['LANG_ARCHIVE_NEXTPAGE']}</a>
</div>
\") : (\"\")).\"
</td></tr>
</table>
<div class=\\\"copyright\\\">
<a href=\\\"http://www.woltlab.de\\\" target=\\\"_blank\\\">{\$lang->items['LANG_GLOBAL_COPYRIGHT']}</a>
</div>
</div>
</body>
</html>";
			?>
<?php
			/*
			templatepackid: 0
			templatename: print
			*/
			
			$this->templates['print']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_THREAD_PRINT_PRINTTHREAD']} \$thread[topic] | {\$lang->items['LANG_THREAD_PRINT_PAGE']} \$page</title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<style type=\\\"text/css\\\">
<!--
body  {
 color: #000000; 
 background-color: #ffffff; 
 \".((\$style['fontfamily']!=\"\") ? (\"font-family: {\$style['fontfamily']};\") : (\"\")).\"
}

.smallfont {
 \".((\$style['smallfontsize']!=\"\") ? (\"font-size: {\$style['smallfontsize']}px;\") : (\"\")).\"
 \".((\$style['smallfontface']!=\"\") ? (\"font-family: {\$style['smallfontface']};\") : (\"\")).\"
 {\$style['smallfontmore']}
}

.normalfont {
 \".((\$style['normalfontsize']!=\"\") ? (\"font-size: {\$style['normalfontsize']}px;\") : (\"\")).\"
 \".((\$style['normalfontface']!=\"\") ? (\"font-family: {\$style['normalfontface']};\") : (\"\")).\"
 {\$style['normalfontmore']}
}

.time {
 \".((\$style['timefontweight']!=\"\") ? (\"font-weight: {\$style['timefontweight']};\") : (\"\")).\"
 \".((\$style['timedeco']!=\"\") ? (\"text-decoration: {\$style['timedeco']};\") : (\"\")).\"
 {\$style['timemore']}
}

a:link, a:visited, a:hover, a:active {
 color: #0000ff;
}

.inposttable {
 \".((\$style['inposttablebgcolor']!=\"\") ? (\"background-color: {\$style['inposttablebgcolor']};\") : (\"\")).\"
 {\$style['inposttablemore']}
}

.tablecat {
 background-color: #ffffff;
}

\".((\$style['tableinbordercolor']!=\"\") 
? (\"
.tableinborder {
 background-color: {\$style['tableinbordercolor']};
}
\") : (\"\")
).\"

{\$style['cssmore']}

-->
</style>
</head>

<body>
 <p><span class=\\\"normalfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a></b> (\$url2board/index.php)<br />
 \$boards
 \$lines2 <b><a href=\\\"board.php?boardid=\$boardid{\$SID_ARG_2ND}\\\">\$board[title]</a></b> (\$url2board/board.php?boardid=\$boardid)<br />
 \$lines3 \".((\$thread['prefix']!=\"\") ? (\"<span class=\\\"prefix\\\">\$thread[prefix]</span> \") : (\"\")).\" <b><a href=\\\"thread.php?threadid=\$threadid{\$SID_ARG_2ND}\\\">\$thread[topic]</a></b> (\$url2board/thread.php?threadid=\$threadid)</span></p>
 \$print_postbit
 <p align=\\\"center\\\"><span class=\\\"normalfont\\\"><a href=\\\"http://www.woltlab.de\\\" target=\\\"_blank\\\" style=\\\"text-decoration: none\\\">{\$lang->items['LANG_GLOBAL_COPYRIGHT']}</a></span></p>
</body>
</html>";
			?>
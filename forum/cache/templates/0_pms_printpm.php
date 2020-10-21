<?php
			/*
			templatepackid: 0
			templatename: pms_printpm
			*/
			
			$this->templates['pms_printpm']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']} | {\$lang->items['LANG_GLOBAL_PMS']} | {\$lang->items['LANG_PMS_PRINTPREVIEW']} \$pm[subject]</title>
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
 <span class=\\\"normalfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a></b> (\$url2board/index.php)</span>
 <hr />
 <span class=\\\"normalfont\\\"><i>{\$lang->items['LANG_PMS_PRINT_MESSAGE']}</i>
 <br /><br />\$pm[message]</span>
 <p align=\\\"center\\\"><span class=\\\"normalfont\\\"><a href=\\\"http://www.woltlab.de\\\" target=\\\"_blank\\\" style=\\\"text-decoration: none\\\">{\$lang->items['LANG_GLOBAL_COPYRIGHT']}</a></span></p>
</body>
</html>";
			?>
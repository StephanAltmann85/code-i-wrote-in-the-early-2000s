<?php
			/*
			templatepackid: 0
			templatename: whoposted
			*/
			
			$this->templates['whoposted']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_MISC_WHOPOSTED_TITLE']}</title>
\$headinclude
</head>
<body>
<table cellpadding=\\\"8\\\" cellspacing=\\\"{\$style['tableoutcellspacing']}\\\" align=\\\"center\\\" border=\\\"{\$style['tableoutborder']}\\\" class=\\\"tableoutborder\\\" style=\\\"width:100%\\\">
 <tr><td class=\\\"mainpage\\\" align=\\\"center\\\">
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:100%\\\" class=\\\"tableinborder\\\">
   <tr>
    <td align=\\\"left\\\" colspan=\\\"2\\\" class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_MISC_WHOPOSTED_POSTS_TOTAL']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\" style=\\\"width:100%\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_MISC_WHOPOSTED_USERNAME']}</span></td>
    <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_MISC_WHOPOSTED_POSTS']}</span></td>
   </tr>
   \$posters
   <tr>
    <td colspan=\\\"2\\\" align=\\\"center\\\" class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\"><a href=\\\"javascript:self.close()\\\">{\$lang->items['LANG_MISC_WINDOW_CLOSE']}</a></span></td>
   </tr>
  </table>
 </td></tr>
</table>
</body>
</html>";
			?>
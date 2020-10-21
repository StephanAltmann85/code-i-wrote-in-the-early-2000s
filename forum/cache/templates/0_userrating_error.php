<?php
			/*
			templatepackid: 0
			templatename: userrating_error
			*/
			
			$this->templates['userrating_error']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_MISC_USERRATING_TITLE']}</title>
\$headinclude

</head>

<body><form action=\\\"#\\\" method=\\\"post\\\">
<table cellpadding=\\\"8\\\" cellspacing=\\\"{\$style['tableoutcellspacing']}\\\" align=\\\"center\\\" border=\\\"{\$style['tableoutborder']}\\\" class=\\\"tableoutborder\\\" style=\\\"width:100%\\\">
 <tr><td class=\\\"mainpage\\\" align=\\\"center\\\"><table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:100%\\\" class=\\\"tableinborder\\\">
  <tr>
   <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MISC_USERRATING_TITLE']}</b></span></td>
  </tr>
  <tr>
   <td class=\\\"tablea\\\" align=\\\"left\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_MISC_USERRATING_ERROR']}</span></td>
  </tr>
 </table>
 <p align=\\\"center\\\">
  <input class=\\\"input\\\" type=\\\"button\\\" accesskey=\\\"C\\\" value=\\\"{\$lang->items['LANG_MISC_CLOSE']}\\\" onclick=\\\"self.close();\\\" />
 </p>
</td></tr></table></form>
</body>
</html>";
			?>
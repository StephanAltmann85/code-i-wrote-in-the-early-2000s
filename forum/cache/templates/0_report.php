<?php
			/*
			templatepackid: 0
			templatename: report
			*/
			
			$this->templates['report']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_MISC_REPORT']}</title>
\$headinclude
</head>

<body>
 \$header
 <form action=\\\"report.php\\\" method=\\\"post\\\">
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  <tr>
   <td class=\\\"tabletitle\\\" colspan=\\\"2\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MISC_REPORT']}</b></span></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_MISC_REPORT_MODOPTIONS']}</span></td>
   <td class=\\\"tablea\\\"><select name=\\\"modid\\\">\$mod_options</select></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tableb\\\" valign=\\\"top\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MISC_REPORT_REASON']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_MISC_REPORT_REASON_DESC']}</span></td>
   <td class=\\\"tableb\\\"><textarea name=\\\"reason\\\" rows=\\\"14\\\" cols=\\\"70\\\"></textarea></td>
  </tr>
 </table>
<p align=\\\"center\\\">
<input type=\\\"hidden\\\" name=\\\"postid\\\" value=\\\"\$postid\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_MISC_SEND']}\\\" class=\\\"input\\\" /> <input type=\\\"reset\\\" accesskey=\\\"R\\\" value=\\\"{\$lang->items['LANG_POSTINGS_RESET']}\\\" class=\\\"input\\\" />
</p></form>	
 \$footer
</body>
</html>";
			?>
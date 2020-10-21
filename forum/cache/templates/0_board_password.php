<?php
			/*
			templatepackid: 0
			templatename: board_password
			*/
			
			$this->templates['board_password']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | \$board[title]</title>
\$headinclude
</head>

<body>
 \$header
 <form method=\\\"post\\\" action=\\\"board.php\\\">
  <input type=\\\"hidden\\\" name=\\\"boardid\\\" value=\\\"\$boardid\\\" />
  <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  <tr align=\\\"left\\\">
   <td class=\\\"tabletitle\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>\$board[title]</b></span></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_BOARD_PASSWORD']}</span></td>
   <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><input type=\\\"password\\\" name=\\\"boardpassword\\\" value=\\\"\\\" maxlength=\\\"25\\\" class=\\\"input\\\" />&nbsp;<input type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_BOARD_PASSWORD_NEXT']}\\\" class=\\\"input\\\" /></span></td>
  </tr>
 </table></form>	
 \$footer
</body>
</html>";
			?>
<?php
			/*
			templatepackid: 0
			templatename: register_activation
			*/
			
			$this->templates['register_activation']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_REGISTER_ACTIVATION_TITLE']}</title>
\$headinclude
</head>

<body>
 \$header
 <form method=\\\"post\\\" action=\\\"register.php\\\">
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\">
  <tr align=\\\"left\\\">
   <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_REGISTER_ACTIVATION_USERID']}</span></td>
   <td class=\\\"tablea\\\"><input type=\\\"text\\\" name=\\\"usrid\\\" class=\\\"input\\\" /></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_REGISTER_ACTIVATION_CODE']}</span></td>
   <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><input type=\\\"text\\\" name=\\\"a\\\" class=\\\"input\\\" />&nbsp;<input type=\\\"submit\\\" accesskey=\\\"S\\\" class=\\\"input\\\" value=\\\"{\$lang->items['LANG_REGISTER_ACTIVATION_SEND']}\\\" /></span></td>
  </tr>
 </table></form>
 \$footer
</body>
</html>";
			?>
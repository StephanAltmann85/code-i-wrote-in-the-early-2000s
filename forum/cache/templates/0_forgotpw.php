<?php
			/*
			templatepackid: 0
			templatename: forgotpw
			*/
			
			$this->templates['forgotpw']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_USERCP_FORGOTPW']}</title>
\$headinclude
</head>

<body>
 \$header
 <form method=\\\"post\\\" action=\\\"forgotpw.php\\\">
  <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
  <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
  <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\">
  <tr>
   <td class=\\\"tabletitle\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_FORGOTPW']}</b></span></td>
  </tr>
  <tr>
   <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_FORGOTPW_USERNAME']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_FORGOTPW_DESC']}</span></td>
   <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><input type=\\\"text\\\" name=\\\"username\\\" value=\\\"\$usercbar_username\\\" class=\\\"input\\\" />&nbsp;<input type=\\\"submit\\\" class=\\\"input\\\" value=\\\"{\$lang->items['LANG_USERCP_FORGOTPW_NEXT']}\\\" /></span></td>
  </tr>
 </table></form>	
 \$footer
</body>
</html>";
			?>
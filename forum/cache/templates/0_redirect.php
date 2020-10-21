<?php
			/*
			templatepackid: 0
			templatename: redirect
			*/
			
			$this->templates['redirect']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name</title>
\$headinclude
<meta http-equiv=\\\"refresh\\\" content=\\\"\$waittime;URL=\$url\\\" />
</head>

<body>
<div style=\\\"position:absolute; bottom:50%; top:50%; left:0px; right:0px; width: 100%\\\" align=\\\"center\\\">
 <table style=\\\"width: 80%\\\" cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tableoutborder\\\">
  <tr class=\\\"mainpage\\\" valign=\\\"middle\\\" align=\\\"center\\\">
   <td><span class=\\\"normalfont\\\"><b>\$msg</b></span><br /><span class=\\\"smallfont\\\"><a href=\\\"\$url\\\">{\$lang->items['LANG_GLOBAL_REDIRECT_FORWARD']}</a></span></td>
  </tr>
 </table>
</div>		
</body>
</html>";
			?>
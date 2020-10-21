<?php
			/*
			templatepackid: 0
			templatename: modcp_announce
			*/
			
			$this->templates['modcp_announce']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | \$thread[topic] | {\$lang->items[LANG_MODCP_ASSIGN_FORUMS]}</title>
\$headinclude
</head>

<body>
\$header
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a>\$navbar &raquo; </b>\".((\$thread['prefix']!=\"\") ? (\"<span class=\\\"prefix\\\">\$thread[prefix]</span> \") : (\"\")).\"<b> <a href=\\\"thread.php?threadid=\$threadid{\$SID_ARG_2ND}\\\">\$thread[topic]</a> &raquo; {\$lang->items[LANG_MODCP_ASSIGN_FORUMS]}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br /><form action=\\\"modcp.php\\\" method=\\\"post\\\">
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items[LANG_MODCP_ASSIGN_FORUMS]}</b></span></td>
 </tr>
 <tr>
   <td class=\\\"tablea\\\" align=\\\"left\\\"><span class=\\\"smallfont\\\">{\$lang->items[LANG_MODCP_ASSIGN_INFO]}</span></td>
 </tr>
 <tr>
   <td class=\\\"tableb\\\" align=\\\"left\\\"><select name=\\\"boardids[]\\\" style=\\\"width:100%;\\\" size=\\\"15\\\" multiple=\\\"multiple\\\">
   \$board_options
  </select><br /><span class=\\\"smallfont\\\">{\$lang->items[LANG_MODCP_MARK_STRG]}</span></td>
 </tr>
</table>
<p align=\\\"center\\\">
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
 <input type=\\\"hidden\\\" name=\\\"threadid\\\" value=\\\"\$threadid\\\" />
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input class=\\\"input\\\" type=\\\"submit\\\" name=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items[LANG_MODCP_ASSIGN_FORUMS]}\\\" />
 <input class=\\\"input\\\" type=\\\"reset\\\" accesskey=\\\"R\\\" value=\\\"{\$lang->items[LANG_GLOBAL_BUTTON_RESET]}\\\" />
</p></form>
\$footer
</body>
</html>";
			?>
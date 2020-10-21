<?php
			/*
			templatepackid: 0
			templatename: modcp_thread_merge
			*/
			
			$this->templates['modcp_thread_merge']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | \$thread[topic] | {\$lang->items[LANG_MODCP_THREAD_MERGE]}</title>
\$headinclude
</head>

<body>
\$header
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a>\$navbar &raquo; </b>\".((\$thread['prefix']!=\"\") ? (\"<span class=\\\"prefix\\\">\$thread[prefix]</span> \") : (\"\")).\"<b> <a href=\\\"thread.php?threadid=\$threadid{\$SID_ARG_2ND}\\\">\$thread[topic]</a> &raquo; {\$lang->items[LANG_MODCP_THREAD_MERGE]}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br /><form action=\\\"modcp.php\\\" method=\\\"post\\\">
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
 <input type=\\\"hidden\\\" name=\\\"threadid\\\" value=\\\"\$threadid\\\" />
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr align=\\\"left\\\">
  <td class=\\\"tabletitle\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items[LANG_MODCP_THREAD_MERGE]}</b></span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td style=\\\"width:50%\\\" class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items[LANG_MODCP_THREAD_MERGE_INFO]}</b></span><br /><span class=\\\"smallfont\\\">
  {\$lang->items[LANG_MODCP_THREAD_MERGE_INFO1]}</span></td>
  <td style=\\\"width:50%\\\" class=\\\"tableb\\\"><input type=\\\"text\\\" name=\\\"mergeurl\\\" size=\\\"50\\\" class=\\\"input\\\" /></td>
 </tr>
</table>
<p align=\\\"center\\\">
 <input class=\\\"input\\\" type=\\\"submit\\\" name=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items[LANG_MODCP_THREAD_MERGE]}\\\" />
 <input class=\\\"input\\\" type=\\\"button\\\" onclick=\\\"history.back()\\\" value=\\\"{\$lang->items[LANG_MODCP_BACK]}\\\" />
</p>
</form>
\$footer
</body>
</html>";
			?>
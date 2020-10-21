<?php
			/*
			templatepackid: 0
			templatename: viewip
			*/
			
			$this->templates['viewip']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_MISC_VIEWIP_TITLE']}</title>
\$headinclude
</head>

<body>
 \$header
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a>\$navbar &raquo; </b>\".((\$thread['prefix']!=\"\") ? (\"<span class=\\\"prefix\\\">\$thread[prefix]</span> \") : (\"\")).\"<b> <a href=\\\"thread.php?threadid=\$threadid{\$SID_ARG_2ND}\\\">\$thread[topic]</a> &raquo; <a href=\\\"thread.php?postid=\$postid{\$SID_ARG_2ND}#post\$postid\\\">{\$lang->items['LANG_MISC_VIEWIP_POSTED_BY']}</a> &raquo; {\$lang->items['LANG_MISC_VIEWIP_TITLE']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MISC_VIEWIP_TITLE']}</b></span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_MISC_VIEWIP_IPADDRESS']}</span></td>
  <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\">\$post[ipaddress] (\$post[host])</span></td>
 </tr>
 \".((\$post['userid']) 
  ? (\"
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_MISC_VIEWIP_USER']}</span></td>
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><a href=\\\"profile.php?userid=\$post[userid]{\$SID_ARG_2ND}\\\">\$post[username]</a></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\" valign=\\\"top\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_MISC_VIEWIP_OTHER_IPADDRESS']}</span></td>
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\">\$moreips</span></td>
   </tr>
  \") : (\"\")
 ).\"
</table>
\$footer
</body>
</html>";
			?>
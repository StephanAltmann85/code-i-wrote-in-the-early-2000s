<?php
/*
templatepackid: 1
templatename: memberslist
*/

$this->templates['memberslist']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_GLOBAL_MEMBERSLIST']}</title>
\$headinclude
</head>

<body>
 \$header
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; {\$lang->items['LANG_GLOBAL_MEMBERSLIST']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br /><form method=\\\"get\\\" action=\\\"memberslist.php\\\">
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablecat\\\" align=\\\"left\\\" colspan=\\\"\$colspan\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_GLOBAL_MEMBERSLIST']}</b> [<a href=\\\"memberslist.php?action=search{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_MEMBERS_MBS_TITLE']}</a>]</span></td>
 </tr>
 <tr height=\\\"5\\\">
  <td class=\\\"tableb\\\" align=\\\"left\\\" colspan=\\\"\$colspan\\\"></td>
 </tr>
 <tr align=\\\"center\\\">
  \$fieldheader
 </tr>
 \$membersbit
 <tr>
  <td class=\\\"tableb\\\" align=\\\"center\\\" colspan=\\\"\$colspan\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_MEMBERS_MBL_SORTOPTIONS']}
  <input src=\\\"{\$style['imagefolder']}/go.gif\\\" type=\\\"image\\\" />
  <input type=\\\"hidden\\\" name=\\\"page\\\" value=\\\"\$page\\\" />
  <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  </span></td>
 </tr>
</table>
<table align=\\\"center\\\">
 <tr>
  <td><span class=\\\"smallfont\\\">\$pagelink</span></td>
 </tr>
</table></form>
\$footer
</body>
</html>";
?>
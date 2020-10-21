<?php
			/*
			templatepackid: 0
			templatename: search_post
			*/
			
			$this->templates['search_post']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_SEARCH_RESULT']}</title>
\$headinclude

<script type=\\\"text/javascript\\\">
<!--
var imageMaxWidth = \$picmaxwidth;
var imageMaxHeight = \$picmaxheight;
//-->
</script>
<script type=\\\"text/javascript\\\" src=\\\"js/images.js\\\"></script>
</head>

<body onload=\\\"resizeImages();\\\">
\$header
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"search.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_GLOBAL_SEARCH']}</a> &raquo; {\$lang->items['LANG_SEARCH_RESULT']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table>
<table style=\\\"width:{\$style['tableinwidth']}\\\">
 <tr>
  <td align=\\\"left\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_SEARCH_RESULT_HITS_POSTS']}</span></td>
  <td align=\\\"right\\\" valign=\\\"bottom\\\"><span class=\\\"smallfont\\\">\$pagelink</span></td>
 </tr>
</table>
<table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" class=\\\"tableinborder\\\" style=\\\"width:{\$style['tableinwidth']}\\\" align=\\\"center\\\">
 <tr align=\\\"left\\\">
  <td><table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:100%\\\">
   <tr align=\\\"left\\\">
    <td class=\\\"tabletitle\\\" style=\\\"width:175px\\\" nowrap=\\\"nowrap\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_THREAD_AUTHOR']}</b></span></td>
    <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_THREAD_POST']}</b></span></td>
   </tr>
  </table>
  \$postbit
  </td>
 </tr>
</table>
<table style=\\\"width:{\$style['tableinwidth']}\\\">
 <tr>
  <td align=\\\"left\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_SEARCH_RESULT_HITS_POSTS']}</span></td>
  <td align=\\\"right\\\" valign=\\\"bottom\\\"><span class=\\\"smallfont\\\">\$pagelink</span></td>
 </tr>
</table>
\$footer
</body>
</html>";
			?>
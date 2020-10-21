<?php
			/*
			templatepackid: 0
			templatename: search_thread
			*/
			
			$this->templates['search_thread']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_SEARCH_RESULT']}</title>
\$headinclude

<script type=\\\"text/javascript\\\">
<!--
function who(threadid) {
 window.open(\\\"misc.php?action=whoposted&threadid=\\\"+threadid+\\\"{\$SID_ARG_2ND_UN}\\\", \\\"moo\\\", \\\"toolbar=no,scrollbars=yes,resizable=yes,width=250,height=300\\\");
}
//-->
</script>
</head>

<body>
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
  <td align=\\\"left\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_SEARCH_RESULT_HITS_THREADS']}</span></td>
  <td align=\\\"right\\\" valign=\\\"bottom\\\"><span class=\\\"smallfont\\\">\$pagelink</span></td>
 </tr>
</table>
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr align=\\\"center\\\" class=\\\"smallfont\\\">
  <td class=\\\"tabletitle\\\" colspan=\\\"3\\\"><b>{\$lang->items['LANG_BOARD_THREAD']}</b></td>
  <td class=\\\"tabletitle\\\" nowrap=\\\"nowrap\\\"><b>{\$lang->items['LANG_BOARD_REPLIES']}</b></td>
  <td class=\\\"tabletitle\\\"><b>{\$lang->items['LANG_BOARD_AUTHOR']}</b></td>
  <td class=\\\"tabletitle\\\"><b>{\$lang->items['LANG_BOARD_VIEWS']}</b></td>
  <td class=\\\"tabletitle\\\"><b>{\$lang->items['LANG_BOARD_RATING']}</b></td>
  <td class=\\\"tabletitle\\\" nowrap=\\\"nowrap\\\"><b>{\$lang->items['LANG_BOARD_LASTPOST']}</b></td>
 </tr>
 \$threadbit
 </table>
<table style=\\\"width:{\$style['tableinwidth']}\\\">
 <tr>
  <td align=\\\"left\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_SEARCH_RESULT_HITS_THREADS']}</span></td>
  <td align=\\\"right\\\" valign=\\\"bottom\\\"><span class=\\\"smallfont\\\">\$pagelink</span></td>
 </tr>
</table><br />
\$footer
</body>
</html>";
			?>
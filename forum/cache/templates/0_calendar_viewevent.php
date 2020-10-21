<?php
			/*
			templatepackid: 0
			templatename: calendar_viewevent
			*/
			
			$this->templates['calendar_viewevent']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
 <head>
  <title>\$master_board_name | {\$lang->items['LANG_CALENDAR_CALENDAR']} | \$eventdate: \$event[subject]</title>
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
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"calendar.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_CALENDAR_CALENDAR']}</a> &raquo; \$eventdate: \$event[subject]</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table>
<table style=\\\"width:{\$style['tableinwidth']}\\\">
 <tr>
  <td align=\\\"right\\\"><a href=\\\"calendar.php?action=editevent&amp;id=\$eventid{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/editpost.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_CALENDAR_EDIT']}\\\" title=\\\"{\$lang->items['LANG_CALENDAR_EDIT']}\\\" /></a></td>
 </tr>
</table>
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_CALENDAR_EVENTBY']} \$eventdate</b></span></td>
 </tr>
 <tr align=\\\"left\\\" class=\\\"normalfont\\\">
  <td class=\\\"tablea\\\"><table style=\\\"width:100%\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\">
   <tr align=\\\"left\\\" class=\\\"tablea_fc\\\">
    <td><span class=\\\"normalfont\\\"><b>\$event[subject]</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_CALENDAR_BY']} <b><a href=\\\"profile.php?userid=\$event[userid]{\$SID_ARG_2ND}\\\">\$event[username]</a></b></span></td>
   </tr>
  </table>
  <br />
  \$event[event]
  </td>
 </tr>
</table>
\$footer
</body>
</html>";
			?>
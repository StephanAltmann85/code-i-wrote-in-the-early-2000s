<?php
			/*
			templatepackid: 0
			templatename: calendar_view
			*/
			
			$this->templates['calendar_view']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\"><html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_CALENDAR_CALENDAR']} \$monthname \$year</title>
\$headinclude
</head>

<body>
\$header
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"calendar.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_CALENDAR_CALENDAR']}</a> &raquo; \$monthname \$year</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"7\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_CALENDAR_CALENDAR']} \$monthname \$year</b></span></td>
 </tr>
 <tr align=\\\"center\\\">
  <td class=\\\"tableb\\\" style=\\\"width:14%\\\"><span class=\\\"smallfont\\\"><b>\$daynames[0]</b></span></td>
  <td class=\\\"tableb\\\" style=\\\"width:14%\\\"><span class=\\\"smallfont\\\"><b>\$daynames[1]</b></span></td>
  <td class=\\\"tableb\\\" style=\\\"width:14%\\\"><span class=\\\"smallfont\\\"><b>\$daynames[2]</b></span></td>
  <td class=\\\"tableb\\\" style=\\\"width:14%\\\"><span class=\\\"smallfont\\\"><b>\$daynames[3]</b></span></td>
  <td class=\\\"tableb\\\" style=\\\"width:14%\\\"><span class=\\\"smallfont\\\"><b>\$daynames[4]</b></span></td>
  <td class=\\\"tableb\\\" style=\\\"width:14%\\\"><span class=\\\"smallfont\\\"><b>\$daynames[5]</b></span></td>
  <td class=\\\"tableb\\\" style=\\\"width:14%\\\"><span class=\\\"smallfont\\\"><b>\$daynames[6]</b></span></td>
 </tr><tr>
 \$day_bits
</table><br /><form method=\\\"get\\\" action=\\\"calendar.php\\\">
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr align=\\\"center\\\">
  <td class=\\\"tablea\\\" style=\\\"width:25%\\\"><span class=\\\"smallfont\\\">
\".((\$wbbuserdata['can_public_event']==1) 
	? (\"<a href=\\\"calendar.php?action=addevent&amp;type=public{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/publicevent.gif\\\" border=\\\"0\\\" alt=\\\"\\\" title=\\\"\\\" /></a>\") : (\"\")
).\"&nbsp;
\".((\$wbbuserdata['can_private_event']==1) 
	? (\"<a href=\\\"calendar.php?action=addevent&amp;type=private{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/privateevent.gif\\\" border=\\\"0\\\" alt=\\\"\\\" title=\\\"\\\" /></a>\") : (\"\")
).\"
</span></td>
  <td class=\\\"tableb\\\" style=\\\"width:25%\\\" nowrap=\\\"nowrap\\\"><select name=\\\"month\\\">
    <option value=\\\"\$month\\\">\$monthname</option>
    <option value=\\\"\\\">---------</option>
    \$month_options
   </select>
		  
   <select name=\\\"year\\\">
    <option value=\\\"\$year\\\">\$year</option>
    <option value=\\\"\\\">---------</option>
    \$yearbits
   </select>
		  
   <input src=\\\"{\$style['imagefolder']}/go.gif\\\" type=\\\"image\\\" />
   <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  </td>
  <td class=\\\"tablea\\\" align=\\\"center\\\" style=\\\"width:25%\\\"><span class=\\\"normalfont\\\"><b><a href=\\\"calendar.php?action=eventcalendar{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_CALENDAR_EVENTCALENDAR']}</a></b></span></td>
  <td class=\\\"tableb\\\" align=\\\"right\\\" style=\\\"width:25%\\\" nowrap=\\\"nowrap\\\"><span class=\\\"normalfont\\\"><b><a href=\\\"calendar.php?month=\$prev_month&amp;year=\$prev_year{\$SID_ARG_2ND}\\\">&laquo; \$prev_monthname \$prev_year</a></b> | <b><a href=\\\"calendar.php?month=\$next_month&amp;year=\$next_year{\$SID_ARG_2ND}\\\">\$next_monthname \$next_year &raquo;</a></b></span></td>
  </tr>
</table></form>
\$footer
</body>
</html>";
			?>
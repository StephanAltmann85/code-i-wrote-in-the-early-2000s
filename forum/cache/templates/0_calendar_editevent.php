<?php
			/*
			templatepackid: 0
			templatename: calendar_editevent
			*/
			
			$this->templates['calendar_editevent']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_CALENDAR_EDIT']}</title>
\$headinclude
</head>

<body>
\$header
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"calendar.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_CALENDAR_CALENDAR']}</a> &raquo; {\$lang->items['LANG_CALENDAR_EDIT']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />\$event_error<form action=\\\"calendar.php\\\" method=\\\"post\\\" name=\\\"bbform\\\" onsubmit=\\\"return validate(this)\\\" onreset=\\\"resetAppletText()\\\">
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_CALENDAR_EDIT']}</b></span></td>
 </tr>
 <tr>
  <td class=\\\"tableb\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><input type=\\\"checkbox\\\" id=\\\"checkbox_del\\\" name=\\\"deleteevent\\\" value=\\\"1\\\" /><label for=\\\"checkbox_del\\\"> {\$lang->items['LANG_CALENDAR_DELETE']}</label></span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\" valign=\\\"top\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_CALENDAR_DATE']}</b></span></td>
  <td class=\\\"tablea\\\"><table border=\\\"0\\\" cellspacing=\\\"0\\\" cellpadding=\\\"2\\\">
                                 <tr align=\\\"center\\\">
                                  <td><span class=\\\"smallfont\\\">{\$lang->items['LANG_CALENDAR_DAY']}</span></td>
                                  <td><span class=\\\"smallfont\\\">{\$lang->items['LANG_CALENDAR_MONTH']}</span></td>
                                  <td><span class=\\\"smallfont\\\">{\$lang->items['LANG_CALENDAR_YEAR']}</span></td>
                                 </tr>
                                 <tr align=\\\"center\\\">
                                  <td><select name=\\\"day\\\">
                                   \$day_options
                                  </select></td>
                                  <td><select name=\\\"month\\\">
                                   \$month_options
                                  </select></td>
                                  <td><select name=\\\"year\\\">
                                   \$year_options
                                  </select>
                                  </td>
                                 </tr>
                                </table></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_CALENDAR_HEADLINE']}</b></span></td>
  <td class=\\\"tableb\\\"><input class=\\\"input\\\" type=\\\"text\\\" name=\\\"subject\\\" value=\\\"\$subject\\\" size=\\\"40\\\" maxlength=\\\"100\\\" /></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\" valign=\\\"top\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_CALENDAR_INFORMATION']}</b></span>
   <br /><br /><table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\">
    <tr align=\\\"left\\\">
     <td class=\\\"tableb\\\" nowrap=\\\"nowrap\\\"><span class=\\\"smallfont\\\">\$note</span></td>
    </tr>
   </table>
   <br />\$bbcode_smilies
  </td>
  <td class=\\\"tablea\\\"><table>
   <tr>
    <td align=\\\"center\\\">\$bbcode_buttons</td>
   </tr>
   <tr align=\\\"left\\\">
    <td align=\\\"left\\\">\$editor</td>
   </tr>
   <tr>
    <td align=\\\"left\\\">
     <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_POSTINGS_OPTIONS']}\\\" class=\\\"input\\\" onclick=\\\"toggleMenu('newthreadOptions', this);\\\" />
     \$editor_switch
    </td>
   </tr>   
  </table></td>
 </tr>
</table>
<div id=\\\"newthreadOptions\\\" class=\\\"hoverMenu\\\">
 <ul class=\\\"smallfont\\\">
  <li><input type=\\\"checkbox\\\" id=\\\"checkbox1\\\" name=\\\"parseurl\\\" value=\\\"1\\\" \$checked[0] /><label for=\\\"checkbox1\\\"> {\$lang->items['LANG_POSTINGS_PARSEURL']}</label></li>
  \".((\$wbbuserdata['can_use_event_smilies']==1) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox2\\\" name=\\\"disablesmilies\\\" value=\\\"1\\\" \$checked[1] /><label for=\\\"checkbox2\\\"> {\$lang->items['LANG_POSTINGS_DISABLESMILIES']}</label></li>\") : (\"\")).\"
  \".((\$wbbuserdata['can_use_event_html']==1) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox3\\\" name=\\\"disablehtml\\\" value=\\\"1\\\" \$checked[2] /><label for=\\\"checkbox3\\\"> {\$lang->items['LANG_POSTINGS_DISABLEHTML']}</label></li>\") : (\"\")).\"
  \".((\$wbbuserdata['can_use_event_bbcode']==1) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox4\\\" name=\\\"disablebbcode\\\" value=\\\"1\\\" \$checked[3] /><label for=\\\"checkbox4\\\"> {\$lang->items['LANG_POSTINGS_DISABLEBBCODE']}</label></li>\") : (\"\")).\"
  \".((\$wbbuserdata['can_use_event_images']==1) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox5\\\" name=\\\"disableimages\\\" value=\\\"1\\\" \$checked[4] /><label for=\\\"checkbox5\\\"> {\$lang->items['LANG_POSTINGS_DISABLEIMAGES']}</label></li>\") : (\"\")).\"
  <li><input type=\\\"checkbox\\\" id=\\\"checkbox_checklength\\\" onclick=\\\"checklength(document.bbform); this.checked = false;\\\" value=\\\"0\\\" /><label for=\\\"checkbox_checklength\\\"><b> {\$lang->items['LANG_POSTINGS_CHECKLENGTH']}</b></label></li>
 </ul>
</div>  
<p align=\\\"center\\\">
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
 <input type=\\\"hidden\\\" name=\\\"id\\\" value=\\\"\$id\\\" />
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input type=\\\"hidden\\\" name=\\\"change_editor\\\" value=\\\"\\\" />
 <input type=\\\"hidden\\\" name=\\\"usewysiwyg\\\" value=\\\"\$wbbuserdata[usewysiwyg]\\\" />
 <input class=\\\"input\\\" type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_CALENDAR_SAVE']}\\\" />
 <input class=\\\"input\\\" type=\\\"reset\\\" accesskey=\\\"R\\\" value=\\\"{\$lang->items['LANG_POSTINGS_RESET']}\\\" />
</p></form>
\$footer
</body>
</html>";
			?>
<?php
			/*
			templatepackid: 0
			templatename: usercp_options_change
			*/
			
			$this->templates['usercp_options_change']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
 <head>
  <title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']} | {\$lang->items['LANG_USERCP_OPTIONS_CHANGE']}</title>
  \$headinclude
 </head>
 <body>
  \$header
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"usercp.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_TITLE']}</a> &raquo; {\$lang->items['LANG_USERCP_OPTIONS_CHANGE']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />
  <form action=\\\"usercp.php\\\" method=\\\"post\\\">
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:{\$style['tableinwidth']}\\\">
   <tr>
    <td class=\\\"tablecat\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_OPTIONS_CHANGE']}</b></span></td>
   </tr>
   <tr>
    <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_SECURIRY']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_INVISIBLE']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_INVISIBLE_DESC']}</span></td>
    <td class=\\\"tableb\\\"><select name=\\\"r_invisible\\\">
     <option value=\\\"1\\\"\$invisible[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
     <option value=\\\"0\\\"\$invisible[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_USECOOKIES']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_USECOOKIES_DESC']}</span></td>
    <td class=\\\"tablea\\\"><select name=\\\"r_usecookies\\\">
     <option value=\\\"1\\\"\$usecookies[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
     <option value=\\\"0\\\"\$usecookies[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tabletitle\\\" colspan=\\\"2\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_MESSAGING']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_ADMINCANEMAIL']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_ADMINCANEMAIL_DESC']}</span></td>
    <td class=\\\"tableb\\\"><select name=\\\"r_admincanemail\\\">
     <option value=\\\"1\\\"\$admincanemail[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
     <option value=\\\"0\\\"\$admincanemail[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_SHOWEMAIL']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_SHOWEMAIL_DESC']}</span></td>
    <td class=\\\"tablea\\\"><select name=\\\"r_showemail\\\">
     <option value=\\\"0\\\"\$showemail[0]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
     <option value=\\\"1\\\"\$showemail[1]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_USERCANEMAIL']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_USERCANEMAIL_DESC']}</span></td>
    <td class=\\\"tableb\\\"><select name=\\\"r_usercanemail\\\">
     <option value=\\\"1\\\"\$usercanemail[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
     <option value=\\\"0\\\"\$usercanemail[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_EMAILNOTIFY']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_EMAILNOTIFY_DESC']}</span></td>
    <td class=\\\"tablea\\\"><select name=\\\"r_emailnotify\\\">
     <option value=\\\"1\\\"\$emailnotify[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
     <option value=\\\"0\\\"\$emailnotify[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_NOTIFICATIONPERPM']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_NOTIFICATIONPERPM_DESC']}</span></td>
    <td class=\\\"tableb\\\"><select name=\\\"r_notificationperpm\\\">
     <option value=\\\"1\\\"\$notificationperpm[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
     <option value=\\\"0\\\"\$notificationperpm[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_RECEIVEPM']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_RECEIVEPM_DESC']}</span></td>
    <td class=\\\"tablea\\\"><select name=\\\"r_receivepm\\\">
     <option value=\\\"1\\\"\$receivepm[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
     <option value=\\\"0\\\"\$receivepm[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_EMAILONPM']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_EMAILONPM_DESC']}</span></td>
    <td class=\\\"tableb\\\"><select name=\\\"r_emailonpm\\\">
     <option value=\\\"1\\\"\$emailonpm[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
     <option value=\\\"0\\\"\$emailonpm[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_PMPOPUP']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_PMPOPUP_DESC']}</span></td>
    <td class=\\\"tablea\\\"><select name=\\\"r_pmpopup\\\">
     <option value=\\\"1\\\"\$spmpopup[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
     <option value=\\\"0\\\"\$spmpopup[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
    </select></td>
   </tr>
   \".((\$wbbuserdata['isgroupleader']) 
    ? (\"
     <tr align=\\\"left\\\">
      <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_OPTIONS_EMAILONAPPLICATION']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_OPTIONS_EMAILONAPPLICATION_DESC']}</span></td>
      <td class=\\\"tableb\\\"><select name=\\\"r_emailonapplication\\\">
       <option value=\\\"1\\\"\$emailonapplication[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
       <option value=\\\"0\\\"\$emailonapplication[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
      </select></td>
     </tr>
    \") : (\"\")
   ).\"
   <tr align=\\\"left\\\">
    <td class=\\\"tabletitle\\\" colspan=\\\"2\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_BOARDVIEW']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_SHOWSIGNATURES']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_SHOWSIGNATURES_DESC']}</span></td>
    <td class=\\\"tablea\\\"><select name=\\\"r_showsignatures\\\">
     <option value=\\\"1\\\"\$showsignatures[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
     <option value=\\\"0\\\"\$showsignatures[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_SHOWAVATARS']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_SHOWAVATARS_DESC']}</span></td>
    <td class=\\\"tableb\\\"><select name=\\\"r_showavatars\\\">
     <option value=\\\"1\\\"\$showavatars[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
     <option value=\\\"0\\\"\$showavatars[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_SHOWIMAGES']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_SHOWIMAGES_DESC']}</span></td>
    <td class=\\\"tablea\\\"><select name=\\\"r_showimages\\\">
     <option value=\\\"1\\\"\$showimages[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
     <option value=\\\"0\\\"\$showimages[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_DAYSPRUNE']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_DAYSPRUNE_DESC']}</span></td>
    <td class=\\\"tableb\\\"><select name=\\\"r_daysprune\\\">
     <option value=\\\"0\\\"\$sdaysprune[0]>{\$lang->items['LANG_REGISTER_OPTIONS_BOARDDEFAULT']}</option>
     <option value=\\\"1500\\\"\$sdaysprune[1500]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_1500']}</option>
     <option value=\\\"1\\\"\$sdaysprune[1]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_1']}</option>
     <option value=\\\"2\\\"\$sdaysprune[2]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_2']}</option>
     <option value=\\\"5\\\"\$sdaysprune[5]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_5']}</option>
     <option value=\\\"10\\\"\$sdaysprune[10]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_10']}</option>
     <option value=\\\"20\\\"\$sdaysprune[20]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_20']}</option>
     <option value=\\\"30\\\"\$sdaysprune[30]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_30']}</option>
     <option value=\\\"45\\\"\$sdaysprune[45]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_45']}</option>
     <option value=\\\"60\\\"\$sdaysprune[60]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_60']}</option>
     <option value=\\\"75\\\"\$sdaysprune[75]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_75']}</option>
     <option value=\\\"100\\\"\$sdaysprune[100]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_100']}</option>
     <option value=\\\"365\\\"\$sdaysprune[365]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_365']}</option>
     <option value=\\\"1000\\\"\$sdaysprune[1000]>{\$lang->items['LANG_REGISTER_DAYSPRUNE_1000']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_UMAXPOSTS']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_UMAXPOSTS_DESC']}</span></td>
    <td class=\\\"tablea\\\"><select name=\\\"r_umaxposts\\\">
     <option value=\\\"0\\\"\$sumaxposts[0]>{\$lang->items['LANG_REGISTER_OPTIONS_BOARDDEFAULT']}</option>
     <option value=\\\"5\\\"\$sumaxposts[5]>{\$lang->items['LANG_REGISTER_OPTIONS_UMAXPOSTS_5']}</option>
     <option value=\\\"10\\\"\$sumaxposts[10]>{\$lang->items['LANG_REGISTER_OPTIONS_UMAXPOSTS_10']}</option>
     <option value=\\\"20\\\"\$sumaxposts[20]>{\$lang->items['LANG_REGISTER_OPTIONS_UMAXPOSTS_20']}</option>
     <option value=\\\"30\\\"\$sumaxposts[30]>{\$lang->items['LANG_REGISTER_OPTIONS_UMAXPOSTS_30']}</option>
     <option value=\\\"40\\\"\$sumaxposts[40]>{\$lang->items['LANG_REGISTER_OPTIONS_UMAXPOSTS_40']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_THREADVIEW']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_THREADVIEW_DESC']}</span></td>
    <td class=\\\"tableb\\\"><select name=\\\"r_threadview\\\">
     <option value=\\\"1\\\"\$sthreadview[1]>{\$lang->items['LANG_REGISTER_OPTIONS_THREADVIEW_THREADED']}</option>
     <option value=\\\"0\\\"\$sthreadview[0]>{\$lang->items['LANG_REGISTER_OPTIONS_THREADVIEW_FLAT']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tabletitle\\\" colspan=\\\"2\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_DATE_TIME']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_DATEFORMAT']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_DATEFORMAT_DESC']}</span></td>
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><input type=\\\"text\\\" class=\\\"input\\\" name=\\\"r_dateformat\\\" value=\\\"\$r_dateformat\\\" maxlength=\\\"10\\\" /></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_TIMEFORMAT']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_TIMEFORMAT_DESC']}</span></td>
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><input type=\\\"text\\\" class=\\\"input\\\" name=\\\"r_timeformat\\\" value=\\\"\$r_timeformat\\\" maxlength=\\\"10\\\" /></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_STARTWEEK']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_STARTWEEK_DESC']}</span></td>
    <td class=\\\"tablea\\\"><select name=\\\"r_startweek\\\">
     \$startweek_options
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_TIMEZONEOFFSET']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_TIMEZONEOFFSET_DESC']}</span></td>
    <td class=\\\"tableb\\\"><select name=\\\"r_timezoneoffset\\\">
     \$timezone_options
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tabletitle\\\" colspan=\\\"2\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_OTHER']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_USEWYSIWYG']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_USEWYSIWYG_DESC']}</span></td>
    <td class=\\\"tablea\\\"><select name=\\\"r_usewysiwyg\\\">
     <option value=\\\"1\\\"\$usewysiwyg[1]>{\$lang->items['LANG_REGISTER_OPTIONS_YES']}</option>
     <option value=\\\"0\\\"\$usewysiwyg[0]>{\$lang->items['LANG_REGISTER_OPTIONS_NO']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_STYLE']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_STYLE_DESC']}</span></td>
    <td class=\\\"tableb\\\"><select name=\\\"r_styleid\\\">
     \$style_options
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_REGISTER_OPTIONS_LANG']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_REGISTER_OPTIONS_LANG_DESC']}</span></td>
    <td class=\\\"tablea\\\"><select name=\\\"r_langid\\\">
     \$lang_options
    </select></td>
   </tr>
  </table>
  <p align=\\\"center\\\"><input class=\\\"input\\\" type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_POSTINGS_SAVE']}\\\" /> <input class=\\\"input\\\" type=\\\"reset\\\" accesskey=\\\"R\\\" value=\\\"{\$lang->items['LANG_POSTINGS_RESET']}\\\" /></p>
  \".((!\$wbbuserdata['isgroupleader']) ? (\"<input type=\\\"hidden\\\" name=\\\"r_emailonapplication\\\" value=\\\"\$r_emailonapplication\\\" />\") : (\"\")).\"
   <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
   <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
   <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  </form>
  \$footer
 </body>
</html>";
			?>
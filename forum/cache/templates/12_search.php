<?php
			/*
			templatepackid: 12
			templatename: search
			*/
			
			$this->templates['search']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_GLOBAL_SEARCH']}</title>
\$headinclude
</head>

<body onload=\\\"document.forms[0].searchstring.focus()\\\">
 \$header
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; {\$lang->items['LANG_GLOBAL_SEARCH']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br /><form action=\\\"search.php\\\" method=\\\"post\\\">
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablecat\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>\$master_board_name {\$lang->items['LANG_SEARCH_SEARCHING']}</b></span></td>
 </tr>
 <tr height=\\\"5\\\">
  <td class=\\\"tableb\\\" align=\\\"left\\\" colspan=\\\"2\\\"></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_SEARCH_KEYWORDSEARCH']}</span></td>
  <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_SEARCH_USERNAMESEARCH']}</span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\" valign=\\\"top\\\"><span class=\\\"smallfont\\\">
  \".((\$prefixOptions != '') 
  ? (\"
  <select name=\\\"searchprefix\\\">
   <option value=\\\"\\\">{\$lang->items['LANG_SEARCH_PREFIXSEARCH']}</option>
   \$prefixOptions
  </select>
  \") : (\"\")
  ).\"  
  <input type=\\\"text\\\" name=\\\"searchstring\\\" value=\\\"\\\" class=\\\"input\\\" size=\\\"40\\\" />
  <br /><br />
  {\$lang->items['LANG_SEARCH_KEYWORDSEARCH_DESC']}
  </span></td>
  <td class=\\\"tablea\\\" valign=\\\"top\\\"><span class=\\\"smallfont\\\">
  <input type=\\\"text\\\" name=\\\"searchuser\\\" value=\\\"\\\" class=\\\"input\\\" size=\\\"20\\\" maxlength=\\\"50\\\" />
  <br /><br />
  <input type=\\\"radio\\\" name=\\\"name_exactly\\\" id=\\\"radio1\\\" value=\\\"1\\\" checked=\\\"checked\\\" /><label for=\\\"radio1\\\"> {\$lang->items['LANG_SEARCH_USERNAMESEARCH_EXACT']}</label><br />
  <input type=\\\"radio\\\" name=\\\"name_exactly\\\" id=\\\"radio2\\\" value=\\\"0\\\" /><label for=\\\"radio2\\\"> {\$lang->items['LANG_SEARCH_USERNAMESEARCH_UNEXACT']}</label><br />
  <input type=\\\"checkbox\\\" id=\\\"checkbox1\\\" name=\\\"onlystarter\\\" value=\\\"1\\\" /><label for=\\\"checkbox1\\\"> {\$lang->items['LANG_SEARCH_USERNAMESEARCH_ONLYSTARTER']}</label>
  </span></td>
 </tr>
</table>
<br />
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablecat\\\" align=\\\"left\\\" colspan=\\\"3\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_SEARCH_SEARCHOPTIONS']}</b></span></td>
 </tr>
 <tr height=\\\"5\\\">
  <td class=\\\"tableb\\\" align=\\\"left\\\" colspan=\\\"3\\\"></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_SEARCH_BOARDS']}</span></td>
  <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_SEARCH_CONTENT']}</span></td>
  <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_SEARCH_VIEWMODE']}</span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\" rowspan=\\\"3\\\"><select name=\\\"boardids[]\\\" style=\\\"width:100%;\\\" size=\\\"10\\\" multiple=\\\"multiple\\\">
   <option value=\\\"*\\\" selected=\\\"selected\\\">{\$lang->items['LANG_SEARCH_BOARDS_ALL']}</option>
   <option value=\\\"-1\\\">--------------------</option>
   \$board_options
  </select><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_SEARCH_BOARDS_DESC']}</span></td>
  <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\">
  <input type=\\\"radio\\\" name=\\\"topiconly\\\" id=\\\"radio3\\\" value=\\\"0\\\" checked=\\\"checked\\\" /><label for=\\\"radio3\\\"> {\$lang->items['LANG_SEARCH_CONTENT_POST']}</label><br />
  <input type=\\\"radio\\\" name=\\\"topiconly\\\" id=\\\"radio4\\\" value=\\\"1\\\" /><label for=\\\"radio4\\\"> {\$lang->items['LANG_SEARCH_CONTENT_TOPIC']}</label>
  </span></td>
  <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\">
  <input type=\\\"radio\\\" name=\\\"showposts\\\" id=\\\"radio5\\\" value=\\\"1\\\" /><label for=\\\"radio5\\\"> {\$lang->items['LANG_SEARCH_SHOWPOSTS']}</label><br />
  <input type=\\\"radio\\\" name=\\\"showposts\\\" id=\\\"radio6\\\" value=\\\"0\\\" checked=\\\"checked\\\" /><label for=\\\"radio6\\\"> {\$lang->items['LANG_SEARCH_SHOWTHREADS']}</label>
  </span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_SEARCH_SEARCHDATE']}</span></td>
  <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_SEARCH_SORTBY']}</span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tableb\\\"><span class=\\\"smallfont\\\">
  <select name=\\\"searchdate\\\">
   <option value=\\\"0\\\">{\$lang->items['LANG_SEARCH_SEARCHDATE_0']}</option>
   <option value=\\\"1\\\">{\$lang->items['LANG_SEARCH_SEARCHDATE_1']}</option>
   <option value=\\\"7\\\">{\$lang->items['LANG_SEARCH_SEARCHDATE_7']}</option>
   <option value=\\\"14\\\">{\$lang->items['LANG_SEARCH_SEARCHDATE_14']}</option>
   <option value=\\\"30\\\">{\$lang->items['LANG_SEARCH_SEARCHDATE_30']}</option>
   <option value=\\\"90\\\">{\$lang->items['LANG_SEARCH_SEARCHDATE_90']}</option>
   <option value=\\\"180\\\">{\$lang->items['LANG_SEARCH_SEARCHDATE_180']}</option>
   <option value=\\\"365\\\">{\$lang->items['LANG_SEARCH_SEARCHDATE_365']}</option>
  </select><br /><br />
  <input type=\\\"radio\\\" name=\\\"beforeafter\\\" id=\\\"radio7\\\" value=\\\"after\\\" checked=\\\"checked\\\" /><label for=\\\"radio7\\\"> {\$lang->items['LANG_SEARCH_SEARCHDATE_AFTER']}</label><br />
  <input type=\\\"radio\\\" name=\\\"beforeafter\\\" id=\\\"radio8\\\" value=\\\"before\\\" /><label for=\\\"radio8\\\"> {\$lang->items['LANG_SEARCH_SEARCHDATE_BEFORE']}</label>
  </span></td>
  <td class=\\\"tableb\\\"><span class=\\\"smallfont\\\">
   <select name=\\\"sortby\\\">
    <option value=\\\"topic\\\">{\$lang->items['LANG_SEARCH_SORTBY_TOPIC']}</option>
    <option value=\\\"replycount\\\">{\$lang->items['LANG_SEARCH_SORTBY_REPLYCOUNT']}</option>
    <option value=\\\"views\\\">{\$lang->items['LANG_SEARCH_SORTBY_VIEWS']}</option>
    <option value=\\\"lastpost\\\" selected=\\\"selected\\\">{\$lang->items['LANG_SEARCH_SORTBY_LASTPOST']}</option>
    <option value=\\\"author\\\">{\$lang->items['LANG_SEARCH_SORTBY_AUTHOR']}</option>
    <option value=\\\"board\\\">{\$lang->items['LANG_SEARCH_SORTBY_BOARD']}</option>
   </select><br /><br />
  <input type=\\\"radio\\\" name=\\\"sortorder\\\" id=\\\"radio9\\\" value=\\\"asc\\\" /><label for=\\\"radio9\\\"> {\$lang->items['LANG_SEARCH_SORTBY_ASC']}</label><br />
  <input type=\\\"radio\\\" name=\\\"sortorder\\\" id=\\\"radio10\\\" value=\\\"desc\\\" checked=\\\"checked\\\" /><label for=\\\"radio10\\\"> {\$lang->items['LANG_SEARCH_SORTBY_DESC']}</label>
  </span></td>
 </tr>
</table>
<p align=\\\"center\\\">
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input class=\\\"input\\\" type=\\\"submit\\\" name=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_GLOBAL_BUTTON_SEARCH']}\\\" />
 <input class=\\\"input\\\" type=\\\"reset\\\" accesskey=\\\"R\\\" value=\\\"{\$lang->items['LANG_GLOBAL_BUTTON_RESET']}\\\" />
</p></form>
\$footer
</body>
</html>";
			?>
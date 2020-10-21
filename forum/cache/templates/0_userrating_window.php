<?php
			/*
			templatepackid: 0
			templatename: userrating_window
			*/
			
			$this->templates['userrating_window']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_MISC_USERRATING_TITLE']}</title>
\$headinclude

</head>

<body><form action=\\\"misc.php\\\" method=\\\"post\\\">
<table cellpadding=\\\"8\\\" cellspacing=\\\"{\$style['tableoutcellspacing']}\\\" align=\\\"center\\\" border=\\\"{\$style['tableoutborder']}\\\" class=\\\"tableoutborder\\\" style=\\\"width:100%\\\">
 <tr><td class=\\\"mainpage\\\" align=\\\"center\\\"><table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:100%\\\" class=\\\"tableinborder\\\">
  <tr>
   <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MISC_USERRATING_TITLE']}</b></span></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MISC_USERRATING_USERNAME']}</b></span></td>
   <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">\$user[username]</span></td>
  </tr>
  <tr align=\\\"left\\\">
   <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MISC_USERRATING_RATING']}</b></span></td>
   <td class=\\\"tableb\\\"><select name=\\\"ratingpoints\\\">
    <option value=\\\"10\\\">10 .. {\$lang->items['LANG_MISC_USERRATING_RATING_10']}</option>
    <option value=\\\"9\\\">9</option>
    <option value=\\\"8\\\">8</option>
    <option value=\\\"7\\\">7</option>
    <option value=\\\"6\\\">6</option>
    <option value=\\\"5\\\" selected=\\\"selected\\\">5 .. {\$lang->items['LANG_MISC_USERRATING_RATING_5']}</option>
    <option value=\\\"4\\\">4</option>
    <option value=\\\"3\\\">3</option>
    <option value=\\\"2\\\">2</option>
    <option value=\\\"1\\\">1 .. {\$lang->items['LANG_MISC_USERRATING_RATING_1']}</option>
   </select></td>
  </tr>
 </table>
 <p align=\\\"center\\\">
  <input type=\\\"hidden\\\" name=\\\"userid\\\" value=\\\"\$userid\\\" />
  <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
  <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
  <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  <input class=\\\"input\\\" type=\\\"submit\\\" name=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_MISC_SAVE']}\\\" />
  <input class=\\\"input\\\" type=\\\"button\\\" accesskey=\\\"C\\\" value=\\\"{\$lang->items['LANG_MISC_CLOSE']}\\\" onclick=\\\"self.close();\\\" />
 </p>
</td></tr></table></form>
</body>
</html>";
			?>
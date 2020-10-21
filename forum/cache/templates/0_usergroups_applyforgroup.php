<?php
			/*
			templatepackid: 0
			templatename: usergroups_applyforgroup
			*/
			
			$this->templates['usergroups_applyforgroup']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
 <head>
  <title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']} | {\$lang->items['LANG_USERGROUPS_GROUPS_TITLE']}</title>
  \$headinclude

 </head>
 <body>
  \$header
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"usercp.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_TITLE']}</a> &raquo; {\$lang->items['LANG_USERGROUPS_GROUPS_TITLE']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />


 <form method=\\\"post\\\" action=\\\"usergroups.php\\\">
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
   <tr>
    <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_APPLICATION']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
	<td class=\\\"tablea\\\" valign=\\\"top\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_APPLICATION_TEXT']}</b></span></td>
	<td class=\\\"tablea\\\"><textarea name=\\\"reason\\\" rows=\\\"6\\\" cols=\\\"60\\\"></textarea></td>
   </tr>
   <tr align=\\\"left\\\">
	<td class=\\\"tableb\\\" valign=\\\"top\\\"><span class=\\\"normalfont\\\"><b><label for=\\\"checkbox1\\\">{\$lang->items['LANG_USERGROUPS_GROUPS_APPLICATION_NOTIFYPEREMAIL']}</label></b></span></td>
	<td class=\\\"tableb\\\"><input type=\\\"checkbox\\\" id=\\\"checkbox1\\\" name=\\\"notifyperemail\\\" value=\\\"1\\\" checked=\\\"checked\\\" /></td>
   </tr>
  </table>
  <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"apply\\\" />
  <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
  <input type=\\\"hidden\\\" name=\\\"groupid\\\" value=\\\"\$groupid\\\" />
  <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  <p align=\\\"center\\\"><input class=\\\"input\\\" type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_USERGROUPS_GROUPS_SEND_APPLICATION']}\\\" /> <input class=\\\"input\\\" type=\\\"reset\\\" accesskey=\\\"R\\\" value=\\\"{\$lang->items['LANG_POSTINGS_RESET']}\\\" /></p>
  </form>
  \$footer
 </body>
</html>";
			?>
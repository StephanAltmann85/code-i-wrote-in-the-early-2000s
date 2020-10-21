<?php
			/*
			templatepackid: 0
			templatename: usergroups_groupleaders_editapplication
			*/
			
			$this->templates['usergroups_groupleaders_editapplication']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
 <head>
  <title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']} | {\$lang->items['LANG_USERGROUPS_GROUPS_TITLE']} | {\$lang->items['LANG_USERGROUPS_EDITAPPLICATION_TITLE']}</title>
  \$headinclude

 </head>
 <body>
  \$header
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"usercp.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_TITLE']}</a> &raquo; <a href=\\\"usergroups.php?action=groupleaders{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERGROUPS_GROUPS_TITLE']}</a> &raquo; {\$lang->items['LANG_USERGROUPS_EDITAPPLICATION_TITLE']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />

  <form method=\\\"post\\\" action=\\\"usergroups.php\\\">
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
   <tr>
    <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_EDITAPPLICATION_TITLE']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_EDITAPPLICATION_USER']}</b></span></td>
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><a href=\\\"profile.php?userid=\$application[userid]{\$SID_ARG_2ND}\\\">\$application[username]</a></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_EDITAPPLICATION_DATE']}</b></span></td>
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\">\$senddate <span class=\\\"time\\\">\$sendtime</span></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_EDITAPPLICATION_STATUS']}</b></span></td>
    <td class=\\\"tablea\\\"><select name=\\\"status\\\">
	<option value=\\\"0\\\"\$status_selected[0]>{\$lang->items['LANG_USERGROUPS_EDITAPPLICATION_STATUS_0']}</option>
	<option value=\\\"1\\\"\$status_selected[1]>{\$lang->items['LANG_USERGROUPS_EDITAPPLICATION_STATUS_1']}</option>
	<option value=\\\"2\\\"\$status_selected[2]>{\$lang->items['LANG_USERGROUPS_EDITAPPLICATION_STATUS_2']}</option>
	<option value=\\\"3\\\"\$status_selected[3]>{\$lang->items['LANG_USERGROUPS_EDITAPPLICATION_STATUS_3']}</option>
	</select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_APPLICATION_TEXT']}</b></span></td>
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\">\$application[reason]</span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPLEADERS_APPLICATION_REPLY']}</b></span></td>
    <td class=\\\"tablea\\\"><textarea name=\\\"reply\\\" cols=\\\"60\\\" rows=\\\"5\\\">\$application[reply]</textarea></td>
   </tr>
   <tr>
    <td class=\\\"tablea\\\" align=\\\"center\\\" colspan=\\\"2\\\"><input class=\\\"input\\\" type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_USERGROUPS_GROUPLEADERS_EDIT_APPLICATION']}\\\" /> <input class=\\\"input\\\" type=\\\"reset\\\" accesskey=\\\"R\\\" value=\\\"{\$lang->items['LANG_POSTINGS_RESET']}\\\" /></td>
   </tr>   
  </table>
  <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
  <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"groupleaders_editapplication\\\" />
  <input type=\\\"hidden\\\" name=\\\"applicationid\\\" value=\\\"\$applicationid\\\" />
  </form>
  

  \$footer
 </body>
</html>";
			?>
<?php
			/*
			templatepackid: 0
			templatename: usergroups_groups
			*/
			
			$this->templates['usergroups_groups']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
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


  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
   <tr>
    <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"4\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_MEMBERSHIPS']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_GROUPNAME']}</b></span></td>
    <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_GROUPDESC']}</b></span></td>
    <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_GROUPTYPE']}</b></span></td>
    <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_OPTIONS']}</b></span></td>
   </tr>
   \$groups_memberships
  </table><br />

  \".((\$appliedgroups) ? (\"
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
   <tr>
    <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"4\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_APPLIEDGROUPS']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_GROUPNAME']}</b></span></td>
    <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_GROUPDESC']}</b></span></td>
    <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_APPLICATIONDATE']}</b></span></td>
    <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_OPTIONS']}</b></span></td>
   </tr>
   \$appliedgroups
  </table><br />
  \") : (\"\")).\"

  \".((\$avaiblegroups) ? (\"
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
   <tr>
    <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"4\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_AVAIBLEGROUPS']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_GROUPNAME']}</b></span></td>
    <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_GROUPDESC']}</b></span></td>
    <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_GROUPTYPE']}</b></span></td>
    <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_OPTIONS']}</b></span></td>
   </tr>
   \$avaiblegroups
  </table><br />
  \") : (\"\")).\"

  \".((count(\$wbbuserdata[groupids]) > 1 && \$wbbuserdata[can_select_rankgroup]==1) 
  ? (\"
  <form method=\\\"post\\\" action=\\\"usergroups.php\\\">
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
   <tr>
    <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_RANKS']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\">&nbsp;</span></td>
    <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_RANK']}</b></span></td>
   </tr>
   \$ranks
  </table>
  <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"rankgroup\\\" />
  <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
  <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  <p align=\\\"center\\\"><input class=\\\"input\\\" type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_POSTINGS_SAVE']}\\\" /> <input class=\\\"input\\\" type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_POSTINGS_RESET']}\\\" /></p>
  </form>
  \") : (\"\")).\"

  \".((count(\$wbbuserdata[groupids]) > 1 && \$wbbuserdata[can_select_useronlinegroup]==1) 
  ? (\"
  <form method=\\\"post\\\" action=\\\"usergroups.php\\\">
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
   <tr>
    <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_USERONLINEGROUPS']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\">&nbsp;</span></td>
    <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_USERGROUPS_GROUPS_USERONLINEVIEW']}</b></span></td>
   </tr>
   \$useronlinegroups
  </table>
  <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"useronlinegroup\\\" />
  <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
  <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  <p align=\\\"center\\\"><input class=\\\"input\\\" type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_POSTINGS_SAVE']}\\\" /> <input class=\\\"input\\\" type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_POSTINGS_RESET']}\\\" /></p>
  </form>
  \") : (\"\")).\"
  \$footer
 </body>
</html>";
			?>
<?php
			/*
			templatepackid: 0
			templatename: usercp_buddy_list
			*/
			
			$this->templates['usercp_buddy_list']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
 <head>
  <title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']} | {\$lang->items['LANG_USERCP_BUDDY_LIST']}</title>
  \$headinclude
 
 </head>
 <body onload=\\\"document.bbform.addtolist.focus();\\\">
  \$header
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"usercp.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_TITLE']}</a> &raquo; {\$lang->items['LANG_USERCP_BUDDY_LIST']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br /><form action=\\\"usercp.php\\\" method=\\\"post\\\" name=\\\"bbform\\\">
  <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:{\$style['tableinwidth']}\\\">
   <tr>
    <td style=\\\"width:200px\\\" valign=\\\"top\\\">
     <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:200px\\\">
      <tr>
       <td class=\\\"tabletitle\\\" colspan=\\\"4\\\" align=\\\"center\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_BUDDY_LIST']}</b></span></td>
      </tr>
      \$listbit
      \".((\$buddyCount > 0 && (\$wbbuserdata['max_pms_recipients'] == -1 || \$buddyCount <= \$wbbuserdata['max_pms_recipients'])) ? (\"
      <tr>
       <td class=\\\"tablea\\\" colspan=\\\"4\\\"><span class=\\\"normalfont\\\"><a href=\\\"pms.php?action=newpm{\$pmLink}{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERCP_BUDDY_LIST_PMALL']}</a></span></td>
      </tr>
      \") : (\"\")).\"
     </table>
    </td>
    <td><img src=\\\"{\$style['imagefolder']}/spacer.gif\\\" height=\\\"1\\\" width=\\\"5\\\" alt=\\\"\\\" border=\\\"0\\\" /></td>
    <td style=\\\"width:100%\\\" valign=\\\"top\\\">
     <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:100%\\\">
      <tr align=\\\"left\\\">
       <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_BUDDY_LIST_USER_ADD']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_BUDDY_LIST_USER_ADD_DESC']}</span></td>
       <td class=\\\"tableb\\\" nowrap=\\\"nowrap\\\"><input type=\\\"text\\\" class=\\\"input\\\" name=\\\"addtolist\\\" maxlength=\\\"50\\\" /> <input class=\\\"input\\\" type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_USERCP_LIST_ADD']}\\\" /></td>
      </tr>
     </table>
    </td>
   </tr>
  </table><br />
   <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
   <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
   <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  </form>
  \$footer
 </body>
</html>";
			?>
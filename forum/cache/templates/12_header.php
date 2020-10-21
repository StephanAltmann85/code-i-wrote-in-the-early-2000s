<?php
			/*
			templatepackid: 12
			templatename: header
			*/
			
			$this->templates['header']="<table bgcolor=\\\"#000000\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">
<tr class=\\\"logobackground\\\">
 <td  style=\\\"border-top: 1px #000000 solid; border-left: 1px #000000 solid;\\\" align=\\\"left\\\">\".((\$style['logoimage']!=\"\") ? (\"<a href=\\\"index.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['logoimage']}\\\" border=\\\"0\\\" alt=\\\"\$master_board_name\\\" title=\\\"\$master_board_name\\\" /></a>\") : (\"\")).\"</td>
 <td align=\\\"right\\\" style=\\\"border-top: 1px #000000 solid; border-right: 1px #000000 solid;\\\"><img src=\\\"{\$style['imagefolder']}/top_right.gif\\\" border=\\\"0\\\" alt=\\\"\\\"></td>
</tr>
</table>
<table bgcolor=\\\"#000000\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" width=\\\"100%\\\">
<tr height=\\\"29\\\">
 <td bgcolor=\\\"#FFFFFF\\\" align=\\\"center\\\" class=\\\"nav\\\" style=\\\"border-top: 1px #000000 solid; border-left: 1px #000000 solid; border-right 1px #000000 solid; border-bottom: 1px #000000 solid;\\\"><span class=\\\"none\\\"> 
  \".((\$wbbuserdata['userid']) ? (\"<a href=\\\"usercp.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['imagefolder']}/top_usercp.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_USERCP']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_USERCP']}\\\" /></a>
  <a href=\\\"pms.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['imagefolder']}/top_pms.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_PMS']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_PMS']}\\\" /></a>\") 
  : (\"<a href=\\\"register.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['imagefolder']}/top_register.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_REGISTER']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_REGISTER']}\\\" /></a>\")).\"
  <a href=\\\"calendar.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['imagefolder']}/top_calendar.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_CALENDAR']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_CALENDAR']}\\\" /></a>
  <a href=\\\"memberslist.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['imagefolder']}/top_members.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_MEMBERSLIST']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_MEMBERSLIST']}\\\" /></a>
  <a href=\\\"team.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['imagefolder']}/top_team.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_TEAM']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_TEAM']}\\\" /></a>
  <a href=\\\"search.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['imagefolder']}/top_search.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_SEARCH']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_SEARCH']}\\\" /></a>
  <a href=\\\"misc.php?action=faq{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/top_faq.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_FAQ']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_FAQ']}\\\" /></a>
  \".((\$wbbuserdata['a_can_use_acp']==1 && \$wbbuserdata['a_acp_or_mcp']==1) ? (\"<a href=\\\"acp/index.php\\\" target=\\\"_blank\\\"><img src=\\\"{\$style['imagefolder']}/top_acp.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_ACP']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_ACP']}\\\" /></a>\") : (\"\")).\"
  \".((\$wbbuserdata['a_can_use_acp']==1 && \$wbbuserdata['a_acp_or_mcp']==0) ? (\"<a href=\\\"acp/index.php\\\" target=\\\"_blank\\\"><img src=\\\"{\$style['imagefolder']}/top_modcp.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_MODCP']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_MODCP']}\\\" /></a>\") : (\"\")).\"
  <a href=\\\"index.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['imagefolder']}/top_start.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_TOINDEX']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_TOINDEX']}\\\" /></a>
  </span>
 </td>
</tr>
</table>

<table style=\\\"width:{\$style['tableoutwidth']}\\\" cellpadding=\\\"{\$style['tableoutcellpadding']}\\\" cellspacing=\\\"{\$style['tableoutcellspacing']}\\\" align=\\\"center\\\" border=\\\"{\$style['tableoutborder']}\\\" class=\\\"tableoutborder\\\">
 <tr>
  <td width=\\\"180\\\" valign=\\\"top\\\" bgcolor=\\\"#D6E2F1\\\" align=\\\"left\\\">

   <table bgcolor=\\\"#000000\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"180\\\">
    <tr height=\\\"25\\\" class=\\\"tabletitle\\\">
     <td bgcolor=\\\"#FFFFFF\\\" valign=\\\"middle\\\" align=\\\"left\\\" style=\\\"border-right: 1px #000000 solid; border-bottom: 1px #000000 solid; border-left: 1px #000000 solid; padding-left: 5px;\\\">{\$lang->items['LANG_GLOBAL_WELCOME']} </td>
    </tr>
   </table>
   <table bgcolor=\\\"#000000\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"180\\\">
   <tr>
    <td bgcolor=\\\"#A7BFDB\\\" valign=\\\"middle\\\" style=\\\"border-left: 1px #000000 solid; padding-left: 5px; padding: 5px; border-bottom: 1px #000000 solid; border-right: 1px #000000 solid;\\\">\$left_userstat</td>
  </tr>
  </table>

  <table bgcolor=\\\"#000000\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"180\\\">
    <tr height=\\\"25\\\" class=\\\"tabletitle\\\">
     <td bgcolor=\\\"#FFFFFF\\\" valign=\\\"middle\\\" align=\\\"left\\\" style=\\\"border-right: 1px #000000 solid; border-bottom: 1px #000000 solid; border-left: 1px #000000 solid; padding-left: 5px;\\\">Funktionsübersicht</td>
    </tr>
   </table>
   <table bgcolor=\\\"#000000\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"180\\\">
   <tr>
    <td bgcolor=\\\"#A7BFDB\\\" valign=\\\"middle\\\" style=\\\"border-left: 1px #000000 solid; padding-left: 5px; padding: 5px; border-bottom: 1px #000000 solid; border-right: 1px #000000 solid;\\\">\$left_functions</td>
  </tr>
  </table>

   <table bgcolor=\\\"#000000\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"180\\\">
    <tr height=\\\"25\\\" class=\\\"tabletitle\\\">
     <td bgcolor=\\\"#FFFFFF\\\" valign=\\\"middle\\\" align=\\\"left\\\" style=\\\"border-right: 1px #000000 solid; border-bottom: 1px #000000 solid; border-left: 1px #000000 solid; padding-left: 5px; \\\">{\$lang->items['LANG_GLOBAL_STATISTIC']} </td>
    </tr>
   </table>
   <table bgcolor=\\\"#000000\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"180\\\">
   <tr>
    <td bgcolor=\\\"#A7BFDB\\\" valign=\\\"middle\\\" style=\\\"border-left: 1px #000000 solid; padding-left: 5px; padding: 5px; border-bottom: 1px #000000 solid; border-right: 1px #000000 solid;\\\">\$left_memberstat</td>
  </tr>
  <tr>
   <td bgcolor=\\\"#A7BFDB\\\" valign=\\\"middle\\\" style=\\\"border-left: 1px #000000 solid; padding-left: 5px; padding: 5px; border-bottom: 1px #000000 solid; border-right: 1px #000000 solid;\\\" class=\\\"smallfont\\\">{\$lang->items['LANG_GLOBAL_COPYRIGHT']} </td>
  <td>
  </table>
 
  </td> 
 <td class=\\\"mainpage\\\" align=\\\"center\\\" valign=\\\"top\\\"><br />";
			?>
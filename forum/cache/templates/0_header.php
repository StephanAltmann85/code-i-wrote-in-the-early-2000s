<?php
			/*
			templatepackid: 0
			templatename: header
			*/
			
			$this->templates['header']="<table style=\\\"width:{\$style['tableoutwidth']}\\\" cellpadding=\\\"{\$style['tableoutcellpadding']}\\\" cellspacing=\\\"{\$style['tableoutcellspacing']}\\\" align=\\\"center\\\" border=\\\"{\$style['tableoutborder']}\\\" class=\\\"tableoutborder\\\">
 <tr>
  <td class=\\\"mainpage\\\" align=\\\"center\\\">
   <table style=\\\"width:100%\\\" border=\\\"0\\\" cellspacing=\\\"0\\\" cellpadding=\\\"0\\\">
    <tr> 
     <td class=\\\"logobackground\\\" align=\\\"center\\\">\".((\$style['logoimage']!=\"\") ? (\"<a href=\\\"index.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['logoimage']}\\\" border=\\\"0\\\" alt=\\\"\$master_board_name\\\" title=\\\"\$master_board_name\\\" /></a>\") : (\"\")).\"</td>
    </tr>
    <tr>
     <td align=\\\"center\\\"><span class=\\\"smallfont\\\">\".((\$wbbuserdata['userid']) ? (\"<a href=\\\"usercp.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['imagefolder']}/top_usercp.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_USERCP']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_USERCP']}\\\" /></a>
     <a href=\\\"pms.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['imagefolder']}/top_pms.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_PMS']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_PMS']}\\\" /></a>\") 
     : (\"<a href=\\\"register.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['imagefolder']}/top_register.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_REGISTER']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_REGISTER']}\\\" /></a>\")).\"
     <a href=\\\"calendar.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['imagefolder']}/top_calendar.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_CALENDAR']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_CALENDAR']}\\\" /></a>
     <a href=\\\"memberslist.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['imagefolder']}/top_members.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_MEMBERSLIST']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_MEMBERSLIST']}\\\" /></a>
     <a href=\\\"team.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['imagefolder']}/top_team.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_TEAM']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_TEAM']}\\\" /></a>
     <a href=\\\"search.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['imagefolder']}/top_search.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_SEARCH']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_SEARCH']}\\\" /></a>
     <a href=\\\"misc.php?action=faq{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/top_faq.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_FAQ']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_FAQ']}\\\" /></a>
     \".((\$wbbuserdata['a_can_use_acp']==1 && \$wbbuserdata['a_acp_or_mcp']==1) ? (\"<a href=\\\"acp/index.php\\\" target=\\\"_blank\\\"><img src=\\\"{\$style['imagefolder']}/top_acp.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_ACP']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_ACP']}\\\" /></a>\") : (\"\")).\"
     \".((\$wbbuserdata['a_can_use_acp']==1 && \$wbbuserdata['a_acp_or_mcp']==0) ? (\"<a href=\\\"acp/index.php\\\" target=\\\"_blank\\\"><img src=\\\"{\$style['imagefolder']}/top_modcp.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_MODCP']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_MODCP']}\\\" /></a>\") : (\"\")).\"
     <a href=\\\"index.php{\$SID_ARG_1ST}\\\"><img src=\\\"{\$style['imagefolder']}/top_start.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_GLOBAL_TOINDEX']}\\\" title=\\\"{\$lang->items['LANG_GLOBAL_TOINDEX']}\\\" /></a></span></td>
    </tr>     
   </table><br />";
			?>
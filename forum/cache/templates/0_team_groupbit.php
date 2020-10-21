<?php
			/*
			templatepackid: 0
			templatename: team_groupbit
			*/
			
			$this->templates['team_groupbit']="<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:100%\\\" class=\\\"tableinborder\\\">
   <tr>
     <td align=\\\"left\\\" colspan=\\\"4\\\" nowrap=\\\"nowrap\\\" class=\\\"tabletitle\\\"><span class=\\\"normalfont\\\"><b>\$master_board_name \$grouptitle</b></span></td>
    </tr>
    <tr align=\\\"left\\\">
     <td colspan=\\\"2\\\" class=\\\"tablea\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_MISC_TEAM_USERNAME']}</span></td>
     <td colspan=\\\"2\\\" class=\\\"tablea\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_MISC_TEAM_CONTACT']}</span></td>
    </tr>
    \".((\$groupleaderbits[\$groupid]) 
    ? (\"
    <tr>
     <td align=\\\"left\\\" colspan=\\\"4\\\" class=\\\"tablecat\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_MISC_TEAM_GROUPLEADERS']}</span></td>
    </tr>
    \$groupleaderbits[\$groupid]
    \") : (\"\")
    ).\"
    
    \".((\$userbits[\$groupid]) 
    ? (\"
    <tr>
     <td align=\\\"left\\\" colspan=\\\"4\\\" class=\\\"tablecat\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_MISC_TEAM_GROUPMEMBERS']}</span></td>
    </tr>
    \$userbits[\$groupid]
    \") : (\"\")
    ).\"
</table><br />";
			?>
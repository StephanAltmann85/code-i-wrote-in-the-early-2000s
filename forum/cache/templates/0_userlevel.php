<?php
			/*
			templatepackid: 0
			templatename: userlevel
			*/
			
			$this->templates['userlevel']="<div align=\\\"center\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_MEMBERS_USERLEVEL_LEVEL']} \$showlevel <a href=\\\"misc.php?action=faq2{\$SID_ARG_2ND}#11\\\">[?]</a><br />
{\$lang->items['LANG_MEMBERS_USERLEVEL_EXPERIENCE']} \$exp<br />
{\$lang->items['LANG_MEMBERS_USERLEVEL_NEXTLEVEL']} \$nextexp</span><br />
<table cellpadding=\\\"1\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tableinborder\\\" style=\\\"width:100px\\\">
   <tr>
    <td align=\\\"left\\\" class=\\\"inposttable\\\"><span class=\\\"smallfont\\\"><img src=\\\"{\$style['imagefolder']}/userlevel.gif\\\" width=\\\"\$width\\\" height=\\\"9\\\" alt=\\\"{\$LANG_MEMBERS_USERLEVEL_NEEDEXP}\\\" title=\\\"{\$LANG_MEMBERS_USERLEVEL_NEEDEXP}\\\" /></span></td>
   </tr>
  </table></div>";
			?>
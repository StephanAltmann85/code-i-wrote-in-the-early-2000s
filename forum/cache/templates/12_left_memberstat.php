<?php
			/*
			templatepackid: 12
			templatename: left_memberstat
			*/
			
			$this->templates['left_memberstat']="<table style=\\\"width:100%\\\" cellpadding=\\\"4\\\" cellspacing=\\\"0\\\" border=\\\"0\\\">
    <tr>
     <td style=\\\"width:100%\\\" class=\\\"normalfont\\\">
     
    <table cellspacing=\\\"0\\\" cellpadding=\\\"0\\\" border=\\\"0\\\" width=\\\"100%\\\" class=\\\"smallfont\\\">
    <tr>
     <td><b>{\$lang->items['LANG_GLOBAL_MEMBERS_COUNT']}:</b></td>
     <td align=\\\"right\\\" width=\\\"15\\\">\$users[count]</td>
    </tr>
    <tr>
     <td colspan=\\\"2\\\" height=\\\"25\\\" valign=\\\"bottom\\\"><b><u>{\$lang->items['LANG_GLOBAL_GENDER_DISTRIBUTION']}</u></b></td>
    </tr>
    <tr>
     <td style=\\\"padding-top: 2px;\\\">&nbsp;{\$lang->items['LANG_GLOBAL_GENDER_MALE']}:</td>
     <td align=\\\"right\\\" width=\\\"15\\\">\$users_male[count]</td>
    </tr>
    <tr>
     <td style=\\\"padding-top: 2px;\\\">&nbsp;{\$lang->items['LANG_GLOBAL_GENDER_FEMALE']}:</td>
     <td align=\\\"right\\\" width=\\\"15\\\">\$users_female[count]</td>
    </tr>
    <tr>
     <td style=\\\"padding-top: 2px;\\\">&nbsp;{\$lang->items['LANG_GLOBAL_GENDER_NONE']}:</td>
     <td align=\\\"right\\\" width=\\\"15\\\">\$users_no_gender[count]</td>
    </tr>
    <tr>
     <td colspan=\\\"2\\\" height=\\\"25\\\" valign=\\\"bottom\\\"><b><u>{\$lang->items['LANG_GLOBAL_OTHER']}</u></b></td>
    </tr>
    <tr>
     <td style=\\\"padding-top: 2px;\\\">&nbsp;{\$lang->items['LANG_GLOBAL_GHOSTMODE']}:</td>
     <td align=\\\"right\\\" width=\\\"15\\\">\$users_invisible[count]</td>
    </tr>
    <tr>
     <td style=\\\"padding-top: 2px;\\\">&nbsp;{\$lang->items['LANG_GLOBAL_BLOCKED']}:</td>
     <td align=\\\"right\\\" width=\\\"15\\\">\$users_blocked[count]</td>
    </tr>
    <tr>
     <td style=\\\"padding-top: 2px;\\\">&nbsp;{\$lang->items['LANG_GLOBAL_NOT_ACTIVATED']}:</td>
     <td align=\\\"right\\\" width=\\\"15\\\">\$users_not_activated[count]</td>
    </tr>
    </table>  


     </td>
    </tr>
   </table>";
			?>
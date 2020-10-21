<?php
			/*
			templatepackid: 0
			templatename: pmpopup_pmbit
			*/
			
			$this->templates['pmpopup_pmbit']="<tr align=\\\"left\\\">
 <td class=\\\"tableb\\\">\$icon</td>
 <td class=\\\"tablea\\\" style=\\\"width:60%\\\">\".((\$row['attachments']) ? (\"<img src=\\\"{\$style['imagefolder']}/paperclip.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_PMS_ATTACHMENTS}\\\" title=\\\"{\$LANG_PMS_ATTACHMENTS}\\\" /> \") : (\"\")).\"<span class=\\\"normalfont\\\"><a href=\\\"javascript:toOpener('pms.php?action=viewpm&pmid=\$row[privatemessageid]{\$SID_ARG_2ND_UN}');\\\">\$row[subject]</a></span></td>
 <td class=\\\"tableb\\\" style=\\\"width:20%\\\" align=\\\"center\\\" nowrap=\\\"nowrap\\\"><span class=\\\"normalfont\\\">\".((\$row['userid'] > 0) ? (\"<a href=\\\"javascript:toOpener('profile.php?userid=\$row[userid]{\$SID_ARG_2ND}');\\\">\$row[username]</a>\") : (\"\$row[username]\")).\"</span></td>
 <td class=\\\"tablea\\\" style=\\\"width:20%\\\" align=\\\"center\\\" nowrap=\\\"nowrap\\\"><span class=\\\"normalfont\\\">\$senddate <span class=\\\"time\\\">\$sendtime</span></span></td>
</tr>";
			?>
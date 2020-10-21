<?php
			/*
			templatepackid: 0
			templatename: pms_bit
			*/
			
			$this->templates['pms_bit']="<tr align=\\\"left\\\">
 \".((\$folderid!=\"outbox\") ? (\"<td class=\\\"tablea\\\">\$pm_image</td>\") : (\"\")).\"
 <td class=\\\"tableb\\\">\$icon</td>
 <td class=\\\"tablea\\\" style=\\\"width:60%\\\">\".((\$row['attachments']) ? (\"<img src=\\\"{\$style['imagefolder']}/paperclip.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_PMS_ATTACHMENTS}\\\" title=\\\"{\$LANG_PMS_ATTACHMENTS}\\\" /> \") : (\"\")).\"<span class=\\\"normalfont\\\"><a href=\\\"pms.php?action=viewpm&amp;pmid=\$row[privatemessageid]\".((\$folderid==\"outbox\") ? (\"&amp;outbox=1\") : (\"\")).\"{\$SID_ARG_2ND}\\\">\$row[subject]</a></span></td>
 <td class=\\\"tableb\\\" style=\\\"width:20%\\\" align=\\\"center\\\"><span class=\\\"normalfont\\\">\".((\$folderid==\"outbox\") ? (\"\$recipients\") : (\"\".((\$row['userid'] > 0) ? (\"<a href=\\\"profile.php?userid=\$row[userid]{\$SID_ARG_2ND}\\\">\$row[username]</a>\") : (\"\$row[username]\")).\"\")).\"</span></td>
 <td class=\\\"tablea\\\" style=\\\"width:20%\\\" align=\\\"center\\\" nowrap=\\\"nowrap\\\"><span class=\\\"normalfont\\\">\$senddate <span class=\\\"time\\\">\$sendtime</span></span></td>
 <td class=\\\"tableb\\\"><input type=\\\"checkbox\\\" name=\\\"pmid[]\\\" value=\\\"\$row[privatemessageid]\\\" /></td>
</tr>";
			?>
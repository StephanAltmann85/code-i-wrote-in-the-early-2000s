<?php
			/*
			templatepackid: 0
			templatename: usercp_attachmentbit
			*/
			
			$this->templates['usercp_attachmentbit']="   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><input type=\\\"checkbox\\\" name=\\\"attachmentids[]\\\" value=\\\"\$row[attachmentid]\\\"\".((\$undeleteable) ? (\" disabled=\\\"disabled\\\"\") : (\"\")).\" /></td>
    <td class=\\\"tableb\\\" style=\\\"width:40%\\\"><img src=\\\"{\$style['imagefolder']}/filetypes/\$extensionimage.gif\\\" border=\\\"0\\\" alt=\\\"\$extensionimage\\\" /> <span class=\\\"normalfont\\\">\".((\$row[postid] || \$row[inoutbox] == 1) ? (\"<a href=\\\"attachment.php?attachmentid=\$row[attachmentid]{\$SID_ARG_2ND}\\\">\$row[attachmentname].\$row[attachmentextension]</a>\") : (\"\$row[attachmentname].\$row[attachmentextension]\")).\"</span><br /><span class=\\\"smallfont\\\">\$LANG_USERCP_ATTACHMENTS_ATTACHMENTINFO</span></td>
    <td class=\\\"tablea\\\" style=\\\"width:40%\\\"><span class=\\\"normalfont\\\">
    \".((\$row['postid']) ? (\"
    {\$lang->items['LANG_USERCP_ATTACHMENTS_THREAD']} <a href=\\\"thread.php?postid=\$row[postid]{\$SID_ARG_2ND}#post\$row[postid]\\\" target=\\\"_blank\\\">\$row[posttopic]</a><br />
    {\$lang->items['LANG_USERCP_ATTACHMENTS_BOARD']} <a href=\\\"board.php?boardid=\$row[boardid]{\$SID_ARG_2ND}\\\" target=\\\"_blank\\\">\$row[title]</a>
    \") : (\"
    {\$lang->items['LANG_USERCP_ATTACHMENTS_PM']} \".((\$row['inoutbox'] == 1) ? (\"<a href=\\\"pms.php?action=viewpm&amp;pmid=\$row[privatemessageid]&amp;outbox=1{\$SID_ARG_2ND}\\\" target=\\\"_blank\\\">\$row[subject]</a>\") : (\"\$row[subject]\")).\"<br />
    {\$lang->items['LANG_USERCP_ATTACHMENTS_PM_RECIPIENTS']} \$recipients
    \")).\"
    </span></td>
    <td class=\\\"tableb\\\" style=\\\"width:20%\\\"><span class=\\\"normalfont\\\">\$uploaddate <span class=\\\"time\\\">\$uploadtime</span></span></td>
   </tr>";
			?>
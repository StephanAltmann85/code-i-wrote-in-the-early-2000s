<?php
/*
acp template
templatename: mailqueue_bit
*/

$this->templates['acp_mailqueue_bit']="<tr class=\\\"\$rowclass\\\">
 <td width=\\\"100%\\\"><a href=\\\"otherstuff.php?action=mailqueue_read&amp;mailid=\$row[mailid]&amp;sid=\$session[hash]\\\">\$row[subject]</a></td>
 <td nowrap=\\\"nowrap\\\"><a href=\\\"../profile.php?userid=\$row[userid]\\\" target=\\\"_blank\\\">\$row[username]</a></td>
 <td nowrap=\\\"nowrap\\\">\$senddate \$sendtime</td>
 <td nowrap=\\\"nowrap\\\">\".((\$finished) ? (\"\$percent%\") : (\"<span style=\\\"color: red;\\\">\$percent%</span>\")).\"</td>
 \".((!\$finished) ? (\"<td nowrap=\\\"nowrap\\\"><input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_OTHERSTUFF_MAILQUEUE_SEND']}\\\" onclick=\\\"update('email', \$row[mailid], '{\$lang->items['LANG_ACP_OTHERSTUFF_EMAIL']}');\\\" /></td>\") : (\"\")).\"
 <td nowrap=\\\"nowrap\\\"\".((\$finished) ? (\" colspan=\\\"2\\\"\") : (\"\")).\"><input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_OTHERSTUFF_MAILQUEUE_DELETE']}\\\" onclick=\\\"window.location.href='otherstuff.php?action=mailqueue&deleteid=\$row[mailid]&sid=\$session[hash]';\\\" /></td>
</tr>";
?>
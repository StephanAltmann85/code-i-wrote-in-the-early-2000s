<?php
/*
acp template
templatename: templatepack_viewbit
*/

$this->templates['acp_templatepack_viewbit']="<tr>
 \$tds
 <td width=\\\"60%\\\" colspan=\\\"\$colspan\\\" class=\\\"firstrow\\\"><b>\$row[templatepackname]</b></td>
 <td width=\\\"40%\\\" class=\\\"secondrow\\\"><b>\$row[templatefolder]</b></td>
 <td class=\\\"firstrow\\\">\".((\$row['templatepackid']!=0) ? (\"<a href=\\\"template.php?action=editpack&amp;templatepackid=\$row[templatepackid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_EDIT']}</a>\") : (\"&nbsp;\")).\"</td>
 <td class=\\\"secondrow\\\">\".((\$row['templatepackid']!=0) ? (\"<a href=\\\"template.php?action=delpack&amp;templatepackid=\$row[templatepackid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_DELETE']}</a>\") : (\"&nbsp;\")).\"</td>
</tr>";
?>
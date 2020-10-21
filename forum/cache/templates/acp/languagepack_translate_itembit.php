<?php
/*
acp template
templatename: languagepack_translate_itembit
*/

$this->templates['acp_languagepack_translate_itembit']="<tr class=\\\"\$rowclass\\\">
 <td colspan=\\\"2\\\"><a name=\\\"\$row[itemname]\\\" id=\\\"\$row[itemname]\\\"></a>\$row[itemname]:\".((checkAdminPermissions(\"a_can_languagepack_delitem\")) ? (\" (<a href=\\\"languagepack.php?action=delitem&amp;itemid=\$row[itemid]&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_GLOBAL_DELETE']}</a>)\") : (\"\")).\"</td>
</tr>
<tr class=\\\"\$rowclass\\\">
 <td colspan=\\\"2\\\"><textarea name=\\\"items[\$row[itemid]]\\\" rows=\\\"4\\\" cols=\\\"100\\\">\$row[item]</textarea>
 \".((\$row['translation']) ? (\"
 <br /><br />{\$lang->items['LANG_ACP_LANGUAGEPACK_ORIGINAL']} (\$translation_languagepackname):<br />
 <textarea name=\\\"foo\\\" rows=\\\"4\\\" cols=\\\"100\\\" readonly=\\\"readonly\\\">\$row[translation]</textarea>
 \") : (\"\")).\"
 <br />&nbsp;</td>
</tr>";
?>
<?php
/*
acp template
templatename: languagepack_search_resultbit
*/

$this->templates['acp_languagepack_search_resultbit']="<tr class=\\\"\$rowclass\\\">
 <td><a href=\\\"languagepack.php?action=edit&amp;languagepackid=\$row[languagepackid]&amp;sid=\$session[hash]\\\">\$row[languagepackname]</a></td>
 <td><a href=\\\"languagepack.php?action=translate&amp;languagepackid=\$row[languagepackid]&amp;catid=\$row[catid]&amp;sid=\$session[hash]#\$row[itemname]\\\">\$row[itemname]</a></td>
</tr>";
?>
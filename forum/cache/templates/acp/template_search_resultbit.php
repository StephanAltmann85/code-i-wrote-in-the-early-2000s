<?php
/*
acp template
templatename: template_search_resultbit
*/

$this->templates['acp_template_search_resultbit']="<tr class=\\\"\$rowclass\\\"> 
<td>\$defaultname<a href=\\\"template.php?action=editpack&templatepackid=\$row[templatepackid]&sid=\$session[hash]\\\">\$row[templatepackname]</a></td> 
<td><a href=\\\"template.php?action=edit&templateid=\$row[templateid]&sid=\$session[hash]\\\">\$row[templatename]</a></td> 
</tr>";
?>
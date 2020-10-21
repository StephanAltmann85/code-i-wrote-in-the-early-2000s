<?php
/*
acp template
templatename: template_import_selectbit
*/

$this->templates['acp_template_import_selectbit']="<tr align=\\\"left\\\">
 <td><input type=\\\"checkbox\\\" name=\\\"files[]\\\" id=\\\"file_\$file\\\" value=\\\"\$templatefolder/\$file\\\" checked=\\\"checked\\\" /></td>
 <td><label for=\\\"file_\$file\\\">\$file</label></td>
 <td>\$filesize</td>
 <td>\$changedate</td>
 <td>\$perms</td>
</tr>";
?>
<?php
/*
acp template
templatename: wordmatch_wordbit
*/

$this->templates['acp_wordmatch_wordbit']="<tr align=\\\"center\\\">
 \".((checkAdminPermissions(\"a_can_otherstuff_wordmatch2\")) 
 ? (\"
 <td class=\\\"firstrow\\\"><input type=\\\"checkbox\\\" name=\\\"wordids[]\\\" id=\\\"word_{\$row[wordid]}\\\" value=\\\"\$row[wordid]\\\" /></td>
 <td align=\\\"left\\\" class=\\\"secondrow\\\" width=\\\"100%\\\"><label for=\\\"word_{\$row[wordid]}\\\">\$row[word]</label></td>
 \") 
 : (\"
 <td align=\\\"left\\\" class=\\\"secondrow\\\" width=\\\"100%\\\">\$row[word]</td>
 \")
 ).\"
 <td class=\\\"firstrow\\\">\$row[mount]</td>
</tr>";
?>
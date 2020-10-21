<?php
/*
acp template
templatename: threads_moderatepostsbit
*/

$this->templates['acp_threads_moderatepostsbit']="<tr class=\\\"\$rowclass\\\">
 <td><a href=\\\"../thread.php?postid=\$row[postid]#post\$row[postid]\\\" target=\\\"_blank\\\">\$row[topic]</a></td>
 <td>\$row[username]</td>
 <td><input type=\\\"checkbox\\\" name=\\\"setvisible[]\\\" value=\\\"\$row[postid]\\\" />&nbsp;{\$lang->items['LANG_ACP_THREADS_ACTIVATE']}</td>
</tr>";
?>
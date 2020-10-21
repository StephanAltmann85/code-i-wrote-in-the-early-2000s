<?php
/*
acp template
templatename: threads_spindelbit
*/

$this->templates['acp_threads_spindelbit']="<tr class=\\\"\$rowclass\\\">
 <td><a href=\\\"../thread.php?threadid=\$row[threadid]\\\" target=\\\"_blank\\\">\$row[topic]</a></td>
 <td><input type=\\\"radio\\\" name=\\\"delthread[\$row[threadid]]\\\" id=\\\"radio_{\$row[threadid]}_1\\\" value=\\\"1\\\" checked=\\\"checked\\\" /><label for=\\\"radio_{\$row[threadid]}_1\\\">&nbsp;{\$lang->items['LANG_ACP_GLOBAL_YES']}</label>&nbsp;<input type=\\\"radio\\\" name=\\\"delthread[\$row[threadid]]\\\" id=\\\"radio_{\$row[threadid]}_2\\\" value=\\\"0\\\" /><label for=\\\"radio_{\$row[threadid]}_2\\\">&nbsp;{\$lang->items['LANG_ACP_GLOBAL_NO']}</label></td>
</tr>";
?>
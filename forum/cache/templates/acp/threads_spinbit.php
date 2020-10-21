<?php
/*
acp template
templatename: threads_spinbit
*/

$this->templates['acp_threads_spinbit']="<tr class=\\\"\$rowclass\\\">
 <td><a href=\\\"../thread.php?threadid=\$row[threadid]\\\" target=\\\"_blank\\\">\$row[topic]</a></td>
 <td>\$row[starter]</td>
 <td><input type=\\\"radio\\\" id=\\\"radio_{\$row[threadid]}_1\\\" name=\\\"threadaction[\$row[threadid]]\\\" value=\\\"0\\\" checked=\\\"checked\\\" /><label for=\\\"radio_{\$row[threadid]}_1\\\">&nbsp;{\$lang->items['LANG_ACP_THREADS_ACTION_NONE']}</label></td>
 <td><input type=\\\"radio\\\" id=\\\"radio_{\$row[threadid]}_2\\\" name=\\\"threadaction[\$row[threadid]]\\\" value=\\\"del\\\" /><label for=\\\"radio_{\$row[threadid]}_2\\\">&nbsp;{\$lang->items['LANG_ACP_GLOBAL_DELETE']}</label></td>
 <td><input type=\\\"radio\\\" id=\\\"radio_{\$row[threadid]}_3\\\" name=\\\"threadaction[\$row[threadid]]\\\" value=\\\"move\\\" /><label for=\\\"radio_{\$row[threadid]}_3\\\">&nbsp;{\$lang->items['LANG_ACP_THREADS_ONLYMOVE']}</label></td>
 <td><input type=\\\"radio\\\" id=\\\"radio_{\$row[threadid]}_4\\\" name=\\\"threadaction[\$row[threadid]]\\\" value=\\\"close\\\" /><label for=\\\"radio_{\$row[threadid]}_4\\\">&nbsp;{\$lang->items['LANG_ACP_THREADS_CLOSE']}</label></td>
</tr>";
?>
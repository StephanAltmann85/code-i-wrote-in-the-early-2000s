<?php
/*
acp template
templatename: threads_spinmovebit
*/

$this->templates['acp_threads_spinmovebit']="<tr class=\\\"\$rowclass\\\">
 <td valign=\\\"top\\\"><a href=\\\"../thread.php?threadid=\$row[threadid]\\\" target=\\\"_blank\\\">\$row[topic]</a><br /><br /><b>{\$lang->items['LANG_ACP_THREADS_MOVE_TO']}</b><br /><select name=\\\"newboardid[\$row[threadid]]\\\">\$boardid_options</select></td>
 <td><input type=\\\"radio\\\" name=\\\"movethread[\$row[threadid]]\\\" id=\\\"radio_{\$row[threadid]}_1\\\" value=\\\"onlymove\\\" /><label for=\\\"radio_{\$row[threadid]}_1\\\">&nbsp;{\$lang->items['LANG_ACP_THREADS_ONLYMOVE']}</label><br />
 <input type=\\\"radio\\\" name=\\\"movethread[\$row[threadid]]\\\" id=\\\"radio_{\$row[threadid]}_2\\\" value=\\\"movewithredirect\\\" checked=\\\"checked\\\" /><label for=\\\"radio_{\$row[threadid]}_2\\\">&nbsp;{\$lang->items['LANG_ACP_THREADS_MOVEWITHREDIRECT']}</label><br />
 <input type=\\\"radio\\\" name=\\\"movethread[\$row[threadid]]\\\" id=\\\"radio_{\$row[threadid]}_3\\\" value=\\\"copy\\\" /><label for=\\\"radio_{\$row[threadid]}_3\\\">&nbsp;{\$lang->items['LANG_ACP_GLOBAL_COPY']}</label><br />
 <input type=\\\"radio\\\" name=\\\"movethread[\$row[threadid]]\\\" id=\\\"radio_{\$row[threadid]}_4\\\" value=\\\"0\\\" /><label for=\\\"radio_{\$row[threadid]}_4\\\">&nbsp;{\$lang->items['LANG_ACP_THREADS_DONTMOVE']}</label></td>
</tr>";
?>
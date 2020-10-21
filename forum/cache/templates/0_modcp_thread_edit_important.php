<?php
			/*
			templatepackid: 0
			templatename: modcp_thread_edit_important
			*/
			
			$this->templates['modcp_thread_edit_important']="<tr align=\\\"left\\\">
 <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items[LANG_MODCP_THREADMODE]}</b></span></td>
 <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><input type=\\\"radio\\\" name=\\\"important\\\" id=\\\"radio_threadmode_1\\\" value=\\\"0\\\" \$imp_checked[0] /><label for=\\\"radio_threadmode_1\\\"> {\$lang->items[LANG_MODCP_NORMAL]}</label> <input type=\\\"radio\\\" name=\\\"important\\\" id=\\\"radio_threadmode_2\\\" value=\\\"1\\\" \$imp_checked[1] /><label for=\\\"radio_threadmode_2\\\"> {\$lang->items[LANG_MODCP_IMPORTANT]}</label> <input type=\\\"radio\\\" name=\\\"important\\\" id=\\\"radio_threadmode_3\\\" value=\\\"2\\\" \$imp_checked[2] /><label for=\\\"radio_threadmode_3\\\"> {\$lang->items[LANG_MODCP_ANNOUNCEMENT]}</label> (<a href=\\\"javascript:announce();\\\">{\$lang->items[LANG_MODCP_ASSIGN_FORUMS]}</a>)</span></td>
</tr>";
			?>
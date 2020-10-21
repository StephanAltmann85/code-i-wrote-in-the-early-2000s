<?php
			/*
			templatepackid: 0
			templatename: thread_poll
			*/
			
			$this->templates['thread_poll']="<form method=\\\"post\\\" action=\\\"pollvote.php\\\">
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" style=\\\"width:100%\\\" colspan=\\\"2\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_THREAD_POLL']}</b> \$poll[question]</span></td>
 </tr>
 \$thread_pollbit
 <tr>	
  <td class=\\\"tabletitle\\\" colspan=\\\"2\\\" align=\\\"center\\\"><span class=\\\"normalfont\\\"><input class=\\\"input\\\" type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_THREAD_POLL_VOTE']}\\\" /> <input type=\\\"button\\\" class=\\\"input\\\" value=\\\"{\$lang->items['LANG_THREAD_POLL_RESULT']}\\\" onclick=\\\"window.location='thread.php?threadid=\$threadid&amp;threadview=\$threadview&amp;hilight=\$hilight&amp;hilightuser=\$hilightuser&amp;page=\$page&amp;preresult=1{\$SID_ARG_2ND}'\\\" /></span></td>
 </tr>
</table>
<table style=\\\"width:{\$style['tableinwidth']}\\\">
 <tr>
  <td align=\\\"right\\\"><span class=\\\"normalfont\\\">&nbsp;\$mod_poll_edit</span></td>
 </tr>
</table>
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<input type=\\\"hidden\\\" name=\\\"pollid\\\" value=\\\"\$thread[pollid]\\\" />
</form>";
			?>
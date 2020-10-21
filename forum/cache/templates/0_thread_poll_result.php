<?php
			/*
			templatepackid: 0
			templatename: thread_poll_result
			*/
			
			$this->templates['thread_poll_result']="<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" style=\\\"width:100%\\\" colspan=\\\"4\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_THREAD_POLL']}</b> \$poll[question]</span></td>
 </tr>
 \$thread_poll_resultbit
 <tr align=\\\"left\\\">	
  <td class=\\\"tabletitle\\\" align=\\\"right\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_THREAD_POLL_TOTAL']}</span></td>
  <td class=\\\"tabletitle\\\" nowrap=\\\"nowrap\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_THREAD_POLL_VOTES']}</span></td>
  <td class=\\\"tabletitle\\\" nowrap=\\\"nowrap\\\"><span class=\\\"normalfont\\\">100%</span></td>
 </tr>
 </table>
<table style=\\\"width:{\$style['tableinwidth']}\\\">
 <tr>
  <td align=\\\"right\\\"><span class=\\\"normalfont\\\">&nbsp;\$mod_poll_edit</span></td>
 </tr>
</table>";
			?>
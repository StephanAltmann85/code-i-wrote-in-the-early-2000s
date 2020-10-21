<?php
			/*
			templatepackid: 0
			templatename: newthread_preview
			*/
			
			$this->templates['newthread_preview']="<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td align=\\\"left\\\" class=\\\"tabletitle\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POSTINGS_PREVIEW']}</b></span></td>
 </tr>
 <tr align=\\\"left\\\" class=\\\"normalfont\\\">
  <td class=\\\"tableb\\\"><span class=\\\"smallfont\\\"><b>\$preview_posticon&nbsp;\$preview_topic</b></span>
  <br /><br />\$preview_message</td>
 </tr>
</table>
<br />";
			?>
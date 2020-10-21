<?php
			/*
			templatepackid: 0
			templatename: modcp_postbit2
			*/
			
			$this->templates['modcp_postbit2']="<tr align=\\\"left\\\">	
 <td class=\\\"\$tdclass\\\" style=\\\"width:175px\\\" valign=\\\"top\\\"><span class=\\\"smallfont\\\">{\$lang->items[LANG_MODCP_CUT_POST]}<br />
  <input type=\\\"checkbox\\\" id=\\\"checkbox\$row[postid]\\\" name=\\\"postids[]\\\" value=\\\"\$row[postid]\\\" /><label for=\\\"checkbox\$row[postid]\\\"> {\$lang->items[LANG_MODCP_YES]}</label>
  </span><br /><img src=\\\"{\$style[imagefolder]}/spacer.gif\\\" width=\\\"159\\\" height=\\\"1\\\" border=\\\"0\\\" alt=\\\"\\\" title=\\\"\\\" /></td>
 <td class=\\\"\$tdclass\\\" valign=\\\"top\\\" style=\\\"width:100%\\\"><span class=\\\"smallfont\\\">{\$LANG_MODCP_BY}</span><p><span class=\\\"normalfont\\\">\$row[message]</span></p></td>
</tr>";
			?>
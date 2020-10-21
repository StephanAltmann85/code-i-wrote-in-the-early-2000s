<?php
			/*
			templatepackid: 0
			templatename: calendar_event
			*/
			
			$this->templates['calendar_event']="<table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\">
	<tr>
		<td valign=\\\"top\\\"><img src=\\\"{\$style['imagefolder']}/listitem.gif\\\" alt=\\\"-\\\" border=\\\"0\\\" /></td>
		<td><a href=\\\"calendar.php?action=viewevent&amp;id=\$event[eventid]{\$SID_ARG_2ND}\\\"><span class=\\\"smallfont\\\"><span class=\\\"\".((\$event['public']==2) ? (\"publicevent\") : (\"privateevent\")).\"\\\">\$event[subject]</span></span></a></td>
	</tr>
</table>";
			?>
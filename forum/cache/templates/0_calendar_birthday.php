<?php
			/*
			templatepackid: 0
			templatename: calendar_birthday
			*/
			
			$this->templates['calendar_birthday']="<table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\">
	<tr>
		<td valign=\\\"top\\\"><img src=\\\"{\$style['imagefolder']}/listitem.gif\\\" alt=\\\"-\\\" border=\\\"0\\\" /></td>
		<td><span class=\\\"smallfont\\\"><a href=\\\"profile.php?userid=\$birthday[userid]{\$SID_ARG_2ND}\\\">\$birthday[username]</a>\$age</span></td>
	</tr>
</table>";
			?>
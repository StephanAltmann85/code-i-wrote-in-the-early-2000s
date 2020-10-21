<?php
			/*
			templatepackid: 0
			templatename: wiw_userbit
			*/
			
			$this->templates['wiw_userbit']="<tr align=\\\"left\\\">
 <td class=\\\"tableb\\\"><span class=\\\"smallfont\\\">\$username</span></td>
 \".((\$wbbuserdata['a_can_view_ipaddress']==1) 
 ? (\"
 <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\">\$ipadress</span></td>
 <td class=\\\"tableb\\\"><span class=\\\"smallfont\\\" title=\\\"\$row[useragent]\\\">\$browser</span></td>
 \") : (\"\")
 ).\"
 <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\">\$time</span></td>
 <td class=\\\"tableb\\\"><span class=\\\"smallfont\\\">\$location</span></td>
</tr>";
			?>
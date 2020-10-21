<?php
			/*
			templatepackid: 0
			templatename: usercp_ignore_listbit
			*/
			
			$this->templates['usercp_ignore_listbit']="<tr align=\\\"left\\\">
       <td class=\\\"tablea\\\" style=\\\"width:100%\\\"><span class=\\\"normalfont\\\"><a href=\\\"profile.php?userid=\$row[userid]{\$SID_ARG_2ND}\\\">\$row[username]</a></span></td>
       <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><a href=\\\"usercp.php?action=ignore&amp;remove=\$row[userid]{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_USERCP_LIST_REMOVE']}</a></span></td>
      </tr>";
			?>
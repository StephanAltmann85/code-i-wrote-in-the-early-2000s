<?php
			/*
			templatepackid: 0
			templatename: pms_folderbit
			*/
			
			$this->templates['pms_folderbit']="<tr align=\\\"left\\\">
       <td class=\\\"tablea\\\"><img src=\\\"{\$style[imagefolder]}/msg-folder.gif\\\" alt=\\\"msg-folder.gif\\\" title=\\\"\\\" border=\\\"0\\\" /></td>
       <td class=\\\"tableb\\\" style=\\\"width: 250px\\\"><span class=\\\"normalfont\\\"><a href=\\\"pms.php?folderid=\$row[folderid]{\$SID_ARG_2ND}\\\">\$row[title]</a></span></td>
       <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><a href=\\\"pms.php?action=removefolder&amp;folderid=\$row[folderid]{\$SID_ARG_2ND}\\\">X</a></span></td>
       <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">\$folder_count</span></td>
      </tr>";
			?>
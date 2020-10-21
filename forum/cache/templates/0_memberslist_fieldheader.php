<?php
			/*
			templatepackid: 0
			templatename: memberslist_fieldheader
			*/
			
			$this->templates['memberslist_fieldheader']="<td class=\\\"tabletitle\\\" nowrap=\\\"nowrap\\\"><span class=\\\"smallfont\\\"><b>\".((\$searchname != '') ? (\"<a href=\\\"{\$link}sortby=\$searchname&amp;order=\".((\$sortby == \$searchname && \$order == 'ASC') ? (\"DESC\") : (\"ASC\")).\"\\\">\$fieldname</a>\") : (\"\$fieldname\")).\"</b> \".((\$searchname != '' && \$sortby == \$searchname) ? (\"<a href=\\\"memberslist.php?letter=\$letter&amp;sortby=\$searchname&amp;order=\".((\$order == 'DESC') ? (\"ASC\") : (\"DESC\")).\"{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/\".((\$order == 'DESC') ? (\"sortasc.gif\") : (\"sortdesc.gif\")).\"\\\" alt=\\\"\\\" border=\\\"0\\\" /></a>\") : (\"\")).\"</span></td>";
			?>
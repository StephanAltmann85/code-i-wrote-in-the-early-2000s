<?php
			/*
			templatepackid: 0
			templatename: board_moderatorbit
			*/
			
			$this->templates['board_moderatorbit']="\".((isset(\$moderatorbit)) ? (\", \") : (\"\")).\"<a href=\\\"profile.php?userid=\$row[userid]{\$SID_ARG_2ND}\\\">\$row[username]</a>";
			?>
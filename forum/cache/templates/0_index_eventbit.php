<?php
			/*
			templatepackid: 0
			templatename: index_eventbit
			*/
			
			$this->templates['index_eventbit']="\".((isset(\$eventbit)) ? (\", \") : (\"\")).\"<a href=\\\"calendar.php?action=viewevent&amp;id=\$row[eventid]{\$SID_ARG_2ND}\\\">\$row[subject]</a>";
			?>
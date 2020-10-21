<?php
			/*
			templatepackid: 0
			templatename: board_threadbit_multipages_lastpage
			*/
			
			$this->templates['board_threadbit_multipages_lastpage']=" ... <a href=\\\"thread.php?threadid=\$threads[threadid]\".((\$search[searchstring]) ? (\"&amp;hilight=\$search[searchstring]\") : (\"\")).\"\".((\$search[searchuserid]) ? (\"&amp;hilightuser=\$search[searchuserid]\") : (\"\")).\"&amp;page=\$xpages{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_BOARD_LASTPAGE']}</a>";
			?>
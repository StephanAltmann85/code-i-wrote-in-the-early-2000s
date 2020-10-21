<?php
			/*
			templatepackid: 0
			templatename: archive_index_boardbit
			*/
			
			$this->templates['archive_index_boardbit']="<li><a href=\\\"archive/\$boards[boardid]/board.html\\\">\$boards[title]</a>
\".((\$subBoardBit != '') ? (\"<ul>\$subBoardBit</ul>\") : (\"\")).\"
</li>";
			?>
<?php
			/*
			templatepackid: 0
			templatename: thread_attachmentbit_show_thumbnail
			*/
			
			$this->templates['thread_attachmentbit_show_thumbnail']="<a href=\\\"attachment.php?attachmentid=\$attachment[attachmentid]{\$SID_ARG_2ND}\\\" target=\\\"_blank\\\"><img style=\\\"padding-bottom: 3px;\\\" src=\\\"attachment.php?attachmentid=\$attachment[attachmentid]&amp;thumbnail=1{\$SID_ARG_2ND}\\\" border=\\\"0\\\" alt=\\\"\$attachment[attachmentname].\$attachment[attachmentextension]\\\" title=\\\"\$attachment[attachmentname].\$attachment[attachmentextension]\\\" /></a> \".((\$thumbnailNewline) ? (\"<br />\") : (\"\")).\"";
			?>
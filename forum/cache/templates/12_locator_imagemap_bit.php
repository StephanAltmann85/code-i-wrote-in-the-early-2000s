<?php
			/*
			templatepackid: 12
			templatename: locator_imagemap_bit
			*/
			
			$this->templates['locator_imagemap_bit']="<area onmouseover=\\\"return overlib('\$row[username]<br>\$row[postcode] \$row[residence]');\\\" onmouseout=\\\"return nd();\\\" shape=\\\"circle\\\" coords=\\\"\$row[x], \$row[y], 4\\\" href=\\\"locator.php?&action=get_user&x=\$row[x]&y=\$row[y]{\$SID_ARG_2ND}\\\" alt=\\\"\\\">";
			?>
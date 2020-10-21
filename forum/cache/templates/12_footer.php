<?php
			/*
			templatepackid: 12
			templatename: footer
			*/
			
			$this->templates['footer']="<br />

\".((\$imprint_url != '') 
	? (\"
		<p align=\\\"center\\\" class=\\\"normalfont\\\"><a href=\\\"{\$imprint_url}\\\">{\$lang->items['LANG_GLOBAL_IMPRINT']}</a></p>
	\") 
	: (\"
		\".((\$imprint_text != '') 
			? (\"
				<p align=\\\"center\\\" class=\\\"normalfont\\\"><a href=\\\"misc.php?action=imprint{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_GLOBAL_IMPRINT']}</a></p>
			\") : (\"\")
		).\"
	\")
).\"

</td>
</tr>
</table>";
			?>
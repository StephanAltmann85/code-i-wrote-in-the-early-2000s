<?php
			/*
			templatepackid: 0
			templatename: popup_smiliesbits
			*/
			
			$this->templates['popup_smiliesbits']="\".((\$rightorleft == \"left\") ? (\"<tr align=\\\"left\\\">\") : (\"\")).\"
<td class=\\\"\".getone(\$j,\"tablea\",\"tableb\").\"\\\"><img src=\\\"\$row[smiliepath]\\\" border=\\\"0\\\" alt=\\\"\$row[smilietitle]\\\" title=\\\"\$row[smilietitle]\\\" onclick=\\\"smilie('\$row[smiliecode]')\\\" onmouseover=\\\"this.style.cursor='hand';\\\" /></td>
<td class=\\\"\".getone(\$j,\"tablea\",\"tableb\").\"\\\"><span class=\\\"normalfont\\\">\$row[smiliename]</span></td>
\".((\$rightorleft == \"right\") ? (\"</tr>\") : (\"\")).\"";
			?>
<?php
			/*
			templatepackid: 0
			templatename: bbcode_smilies
			*/
			
			$this->templates['bbcode_smilies']="\".((\$smiliebits != '') ? (\"
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td align=\\\"left\\\" colspan=\\\"\$tableColumns\\\" class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_POSTINGS_SMILIES']}</b> {\$lang->items['LANG_POSTINGS_SMILIE_COUNT']}</span></td>
 </tr>
 \$smiliebits
 \$bbcode_smilies_getmore
</table>
\") : (\"\")).\"";
			?>
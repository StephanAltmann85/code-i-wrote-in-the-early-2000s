<?php
			/*
			templatepackid: 0
			templatename: editor_switch
			*/
			
			$this->templates['editor_switch']="\".((\$wbbuserdata['usewysiwyg'] == 1) ? (\"
<input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_POSTINGS_CHANGE_EDITOR_NORMAL']}\\\" class=\\\"input\\\" onclick=\\\"changeEditor(document.bbform, -1);\\\" />
\") : (\"
<input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_POSTINGS_CHANGE_EDITOR_WYSIWYG']}\\\" class=\\\"input\\\" onclick=\\\"changeEditor(document.bbform, 1);\\\" />
\")).\"";
			?>
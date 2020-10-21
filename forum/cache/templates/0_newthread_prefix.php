<?php
			/*
			templatepackid: 0
			templatename: newthread_prefix
			*/
			
			$this->templates['newthread_prefix']="<select name=\\\"prefix\\\">
 <option value=\\\"\\\">\".((\$board['prefixrequired'] == 1) ? (\"{\$lang->items['LANG_POST_PREFIXREQUIRED']}\") : (\"\")).\"</option>
 \$prefix_options
</select>
";
			?>
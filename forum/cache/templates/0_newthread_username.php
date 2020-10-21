<?php
			/*
			templatepackid: 0
			templatename: newthread_username
			*/
			
			$this->templates['newthread_username']="\".((\$wbbuserdata['userid']==0) 
 ? (\"<input class=\\\"input\\\" type=\\\"text\\\" name=\\\"guestname\\\" value=\\\"\$guestname\\\" size=\\\"20\\\" maxlength=\\\"50\\\" />\") 
 : (\"<span class=\\\"normalfont\\\">\$usercbar_username</span><span class=\\\"smallfont\\\">&nbsp;<a href=\\\"logout.php{\$SID_ARG_1ST}\\\">[{\$lang->items['LANG_POST_LOGOUT']}]</a></span>\")
).\"";
			?>
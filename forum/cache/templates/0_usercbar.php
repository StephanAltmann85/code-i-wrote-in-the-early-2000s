<?php
			/*
			templatepackid: 0
			templatename: usercbar
			*/
			
			$this->templates['usercbar']="\".((\$wbbuserdata['userid']) ? (\"&raquo; {\$lang->items['LANG_GLOBAL_USERCBAR_HELLO']} \$usercbar_username [<a href=\\\"logout.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_GLOBAL_USERCBAR_LOGOUT']}</a>]\") 
: (\"&raquo; {\$lang->items['LANG_GLOBAL_USERCBAR_HELLO_GUEST']} [<a href=\\\"login.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_GLOBAL_USERCBAR_LOGIN']}</a>|<a href=\\\"register.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_GLOBAL_USERCBAR_REGISTER']}</a>]\")
).\"";
			?>
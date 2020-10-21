<?php
			/*
			templatepackid: 0
			templatename: thread_postbitlist
			*/
			
			$this->templates['thread_postbitlist']="<tr align=\\\"center\\\">
 <td class=\\\"tablea\\\" style=\\\"width:80%\\\" align=\\\"left\\\"><img src=\\\"{\$style['imagefolder']}/spacer.gif\\\" width=\\\"\$imgwidth\\\" height=\\\"1\\\" border=\\\"0\\\" alt=\\\"\\\" /><span class=\\\"normalfont\\\">\".((\$newpost==1) 
    ? (\"<img src=\\\"{\$style['imagefolder']}/posticonnew.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_THREAD_NEWPOST']}\\\" title=\\\"{\$lang->items['LANG_THREAD_NEWPOST']}\\\" />\") 
    : (\"<img src=\\\"{\$style['imagefolder']}/posticon.gif\\\" border=\\\"0\\\" alt=\\\"\\\" title=\\\"\\\" />\")
   ).\"&nbsp;<a href=\\\"#post\$posts[postid]\\\">\$posts[posttopic]</a></span></td>
 <td class=\\\"tablea\\\" style=\\\"width:20%\\\"><span class=\\\"normalfont\\\">\".((\$posts['userid']) ? (\"<a href=\\\"profile.php?userid=\$posts[userid]{\$SID_ARG_2ND}\\\">\$posts[username]</a>\") : (\"\$posts[username]\")).\"</span></td>
 <td class=\\\"tablea\\\" nowrap=\\\"nowrap\\\"><span class=\\\"normalfont\\\">\$postdate <span class=\\\"time\\\">\$posttime</span></span></td>
</tr>";
			?>
<?php
			/*
			templatepackid: 0
			templatename: search_postbit
			*/
			
			$this->templates['search_postbit']="<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:100%\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"\$tdclass\\\" align=\\\"left\\\" colspan=\\\"2\\\"><img src=\\\"{\$style[imagefolder]}/\$foldericon.gif\\\" border=\\\"0\\\" alt=\\\"\\\" title=\\\"\\\" /><span class=\\\"normalfont\\\"> <b>{\$lang->items['LANG_SEARCH_THREAD']} </b>\".((\$posts['prefix']!=\"\") ? (\"<span class=\\\"prefix\\\">\$posts[prefix]</span> \") : (\"\")).\"<b><a href=\\\"thread.php?threadid=\$posts[threadid]{\$SID_ARG_2ND}\\\">\$posts[topic]</a></b></span></td>
 </tr>
 <tr align=\\\"left\\\">	
  <td class=\\\"\$tdclass\\\" style=\\\"width:175px\\\" valign=\\\"top\\\" nowrap=\\\"nowrap\\\"><a name=\\\"post\$posts[postid]\\\" id=\\\"post\$posts[postid]\\\"></a>
   <table style=\\\"width:100%\\\" cellpadding=\\\"4\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" class=\\\"{\$tdclass}_fc\\\">
    <tr align=\\\"left\\\">
     <td style=\\\"width:100%\\\"><span class=\\\"normalfont\\\"><b>\".((\$posts['userid']) ? (\"<a href=\\\"profile.php?userid=\$posts[userid]{\$SID_ARG_2ND}\\\">\$posts[username]</a>\") : (\"\$posts[username]\")).\"</b></span>
      <br /><br /><table class=\\\"{\$tdclass}_fc\\\">
       <tr align=\\\"left\\\">
        <td><span class=\\\"smallfont\\\">{\$lang->items['LANG_SEARCH_REPLYCOUNT']}</span></td>
        <td><span class=\\\"smallfont\\\">\$posts[replycount]</span></td>
       </tr>
       <tr align=\\\"left\\\">
        <td><span class=\\\"smallfont\\\">{\$lang->items['LANG_SEARCH_VIEWS']}</span></td>
        <td><span class=\\\"smallfont\\\">\$posts[views]</span></td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
  </td>
  <td class=\\\"\$tdclass\\\" valign=\\\"top\\\">
   <table style=\\\"width:100%\\\" cellpadding=\\\"4\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" class=\\\"{\$tdclass}_fc\\\">
    <tr align=\\\"left\\\">
     <td style=\\\"width:100%\\\" class=\\\"normalfont\\\">
      <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\" class=\\\"{\$tdclass}_fc\\\">
       <tr align=\\\"left\\\">
        <td>\".((\$newpost==1) 
    ? (\"<a href=\\\"thread.php?postid=\$posts[postid]#post\$posts[postid]\\\"><img src=\\\"{\$style['imagefolder']}/posticonnew.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_THREAD_NEWPOST']}\\\" title=\\\"{\$lang->items['LANG_THREAD_NEWPOST']}\\\" /></a>\") 
    : (\"<a href=\\\"thread.php?postid=\$posts[postid]#post\$posts[postid]\\\"><img src=\\\"{\$style['imagefolder']}/posticon.gif\\\" border=\\\"0\\\" alt=\\\"\\\" title=\\\"\\\" /></a>\")
   ).\" <span class=\\\"smallfont\\\"><b><a href=\\\"thread.php?postid=\$posts[postid]{\$SID_ARG_2ND}#\$posts[postid]\\\">\$posts[posttopic]</a></b></span> <span class=\\\"smallfont\\\">\$postsign \$postdate <span class=\\\"time\\\">\$posttime</span></span></td>
        <td align=\\\"right\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_SEARCH_BOARD']} <b><a href=\\\"board.php?boardid=\$posts[boardid]{\$SID_ARG_2ND}\\\">\$posts[title]</a></b></span></td>
       </tr>
      </table><hr size=\\\"{\$style['tableincellspacing']}\\\" class=\\\"threadline\\\" />
      <br />\$posts[message]
     </td>
    </tr>
   </table>
  </td>
 </tr>
</table>";
			?>
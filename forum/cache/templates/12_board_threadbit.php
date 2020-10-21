<?php
			/*
			templatepackid: 12
			templatename: board_threadbit
			*/
			
			$this->templates['board_threadbit']="<tr align=\\\"center\\\">
  <td class=\\\"tablea\\\"><img src=\\\"{\$style['imagefolder']}/\$foldericon.gif\\\" border=\\\"0\\\" alt=\\\"\\\" title=\\\"\\\" /></td>
  <td class=\\\"tableb\\\">\$threadicon</td>
  <td class=\\\"tablea\\\" style=\\\"width:80%\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\">
  
  \".((\$threads['attachments']) 
   ? (\"<img src=\\\"{\$style['imagefolder']}/paperclip.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_BOARD_ATTACHMENTS}\\\" title=\\\"{\$LANG_BOARD_ATTACHMENTS}\\\" /> \") : (\"\")
  ).\"
  
  \".((\$firstnew==1) 
   ? (\"<a href=\\\"thread.php?threadid=\$threads[threadid]&amp;goto=firstnew{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/firstnew.gif\\\" alt=\\\"{\$lang->items['LANG_BOARD_GOTO_FIRSTNEW']}\\\" title=\\\"{\$lang->items['LANG_BOARD_GOTO_FIRSTNEW']}\\\" border=\\\"0\\\" /></a> \") : (\"\")
  ).\"  
  
  <span class=\\\"prefix\\\">
  
  \".((\$threads['closed']==3) 
   ? (\"<b>{\$lang->items['LANG_BOARD_MOVED']}</b> \") : (\"\")
  ).\"
  
  \".((\$threads['important']==2) 
   ? (\"<b>{\$lang->items['LANG_BOARD_ANNOUNCEMENT']}</b> \") : (\"\")
  ).\"
  
  \".((\$threads['important']==1) 
   ? (\"<b>{\$lang->items['LANG_BOARD_IMPORTANT']}</b> \") : (\"\")
  ).\"

   \".((\$threads['done']==1) 
    ? (\"<img src=\\\"{\$style['imagefolder']}/done.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_BOARD_DONE']}\\\" title=\\\"{\$lang->items['LANG_BOARD_DONE']}\\\" />\") : (\"\")
   ).\"
  
  \".((\$threads['pollid']!=0 && \$threads['closed']!=3) 
   ? (\"<b>{\$lang->items['LANG_BOARD_POLL']}</b> \") : (\"\")
  ).\"
  
  \".((\$threads['prefix']!=\"\") 
   ? (\"\$threads[prefix] \") : (\"\")
  ).\"
  
  </span>
  <a href=\\\"thread.php?threadid=\$threads[threadid]\".((\$search[searchstring]) ? (\"&amp;hilight=\$search[searchstring]\") : (\"\")).\"\".((\$search[searchuserid]) ? (\"&amp;hilightuser=\$search[searchuserid]\") : (\"\")).\"{\$SID_ARG_2ND}\\\">\$threads[topic]</a></span>\$multipages<span class=\\\"smallfont\\\">
  
  \".((isset(\$favorites) && \$favorites) 
   ? (\"<br /><b><a href=\\\"addreply.php?threadid=\$threads[threadid]{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_BOARD_REPLY']}</a> <a href=\\\"usercp.php?threadid=\$threads[threadid]&amp;action=removesubscription{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_BOARD_REMOVE_SUBSCRIPTION']}</a></b>\") : (\"\")
  ).\"
  
  \".((\$filename==\"search.php\") 
   ? (\"<br />{\$lang->items['LANG_SEARCH_BOARD']} <b><a href=\\\"board.php?boardid=\$threads[boardid]{\$SID_ARG_2ND}\\\">\$threads[title]</a></b>\") : (\"\")
  ).\"
  </span></td>
  
  <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><a href=\\\"javascript:who(\$threads[threadid])\\\">\$threads[replycount]</a></span></td>
  <td class=\\\"tablea\\\" style=\\\"width:20%\\\"><span class=\\\"normalfont\\\">\".((\$threads['starterid']!=0) ? (\"<a href=\\\"profile.php?userid=\$threads[starterid]{\$SID_ARG_2ND}\\\">\$threads[starter]</a>\") : (\"\$threads[starter]\")).\"</span></td>
  <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\">\$threads[views]</span></td>
  \".((\$board['allowratings']==1) ? (\"<td class=\\\"tablea\\\" nowrap=\\\"nowrap\\\">\$threadrating</td>\") : (\"\")).\"
  <td class=\\\"\".((\$board['allowratings']==1) ? (\"tableb\") : (\"tablea\")).\"\\\" align=\\\"left\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr align=\\\"right\\\" class=\\\"\".((\$board['allowratings']==1) ? (\"tableb\") : (\"tablea\")).\"_fc\\\">
    <td align=\\\"right\\\" nowrap=\\\"nowrap\\\"><span class=\\\"smallfont\\\">\$lastpostdate <span class=\\\"time\\\">\$lastposttime</span><br />
    {\$lang->items['LANG_BOARD_FROM']} \".((\$threads['lastposterid']!=0) ? (\"<b><a href=\\\"profile.php?userid=\$threads[lastposterid]{\$SID_ARG_2ND}\\\">\$threads[lastposter]</a></b>\") : (\"\$threads[lastposter]\")).\"</span></td>
    <td nowrap=\\\"nowrap\\\"><span class=\\\"smallfont\\\">&nbsp;<a href=\\\"thread.php?threadid=\$threads[threadid]&amp;goto=lastpost{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/lastpost.gif\\\" alt=\\\"{\$lang->items['LANG_BOARD_GOTO_LASTPOST']}\\\" title=\\\"{\$lang->items['LANG_BOARD_GOTO_LASTPOST']}\\\" border=\\\"0\\\" /></a></span></td>
   </tr>
  </table></td>
 </tr>";
			?>
<?php
			/*
			templatepackid: 0
			templatename: index_boardbit
			*/
			
			$this->templates['index_boardbit']="<tr>
 \".((\$depth == 1) 
  ? (\"
  
   <td align=\\\"left\\\" class=\\\"tablea\\\"\".((\$boards['externalurl'] != '') ? (\" colspan=\\\"\".((\$hide_modcell==0) ? (\"6\") : (\"5\")).\"\\\"\") : (\" colspan=\\\"2\\\"\")).\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\">
    <tr class=\\\"tablea_fc\\\">
     <td><img src=\\\"{\$style['imagefolder']}/\$onoff.gif\\\" alt=\\\"\\\" title=\\\"\\\" />&nbsp;&nbsp;</td>
     <td align=\\\"left\\\"><span class=\\\"normalfont\\\"><a href=\\\"board.php?boardid=\$boards[boardid]{\$SID_ARG_2ND}\\\"><b>\$boards[title]</b></a></span><span class=\\\"smallfont\\\">
      \".((\$boards['description']!=\"\") ? (\"<br />\$boards[description]\") : (\"\")).\"\".((\$subboardbit!=\"\") ? (\"<br />{\$lang->items['LANG_START_INCLUSIVE']} \$subboardbit\") : (\"\")).\"\".((isset(\$boards['useronline']) && \$boards['useronline']) ? (\"<br />(\$boards[useronline])\") : (\"\")).\"</span></td>
    </tr>
   </table></td>
  
  \") 
  
  : (\"
  
  
  \".((\$depth == 2) 
   ? (\"
  
   <td class=\\\"tableb\\\" align=\\\"center\\\"><img src=\\\"{\$style['imagefolder']}/\$onoff.gif\\\" alt=\\\"\\\" title=\\\"\\\" /></td>
   <td align=\\\"left\\\" class=\\\"tablea\\\"\".((\$boards['externalurl'] != '') ? (\" colspan=\\\"\".((\$hide_modcell==0) ? (\"5\") : (\"4\")).\"\\\"\") : (\"\")).\"><span class=\\\"normalfont\\\"><a href=\\\"board.php?boardid=\$boards[boardid]{\$SID_ARG_2ND}\\\"><b>\$boards[title]</b></a></span><span class=\\\"smallfont\\\">
    \".((\$boards['description']!=\"\") ? (\"<br />\$boards[description]\") : (\"\")).\"\".((\$subboardbit!=\"\") ? (\"<br />{\$lang->items['LANG_START_INCLUSIVE']} \$subboardbit\") : (\"\")).\"\".((isset(\$boards['useronline']) && \$boards['useronline']) ? (\"<br />(\$boards[useronline])\") : (\"\")).\"
    
    \".((isset(\$favorites) && \$favorites) 
     ? (\"<br /><b><a href=\\\"newthread.php?boardid=\$boards[boardid]{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_START_NEWTHREAD']}</a> <a href=\\\"usercp.php?action=removesubscription&amp;boardid=\$boards[boardid]{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_START_UNSUBSCRIBE']}</a></b>\") : (\"\")
    ).\"
    
    </span></td>
 
  \") 
  
  : (\"
  
   <td class=\\\"tableb\\\" align=\\\"center\\\">&nbsp;</td>
   <td class=\\\"tablea\\\" align=\\\"left\\\"\".((\$boards['externalurl'] != '') ? (\" colspan=\\\"\".((\$hide_modcell==0) ? (\"5\") : (\"4\")).\"\\\"\") : (\"\")).\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\">
    <tr class=\\\"tablea_fc\\\">
     <td><img src=\\\"{\$style['imagefolder']}/\$onoff.gif\\\" alt=\\\"\\\" title=\\\"\\\" />&nbsp;&nbsp;</td>
     <td><span class=\\\"normalfont\\\"><a href=\\\"board.php?boardid=\$boards[boardid]{\$SID_ARG_2ND}\\\"><b>\$boards[title]</b></a></span><span class=\\\"smallfont\\\">
      \".((\$boards['description']!=\"\") ? (\"<br />\$boards[description]\") : (\"\")).\"\".((\$subboardbit!=\"\") ? (\"<br />{\$lang->items['LANG_START_INCLUSIVE']} \$subboardbit\") : (\"\")).\"\".((isset(\$boards['useronline']) && \$boards['useronline']) ? (\"<br />(\$boards[useronline])\") : (\"\")).\"</span></td>
    </tr>
   </table></td>
  
  \")
  ).\"
  
  \")
 ).\"
 
 \".((\$boards['externalurl'] == '') ? (\"
 
 <td class=\\\"tableb\\\" align=\\\"center\\\" nowrap=\\\"nowrap\\\"><span class=\\\"normalfont\\\">\$boards[postcount]</span></td>
 <td class=\\\"tablea\\\" align=\\\"center\\\" nowrap=\\\"nowrap\\\"><span class=\\\"normalfont\\\">\$boards[threadcount]</span></td>
 <td class=\\\"tableb\\\" nowrap=\\\"nowrap\\\" align=\\\"left\\\">\".((\$boards['threadcount']!=0) 
  
  ? (\"
   \".((\$showlastposttitle==1) 
    ? (\"
    
     <table border=\\\"0\\\" cellspacing=\\\"0\\\" cellpadding=\\\"0\\\">
      <tr align=\\\"left\\\" class=\\\"tableb_fc\\\">
       <td nowrap=\\\"nowrap\\\">&nbsp;&nbsp;\$ViewPosticon&nbsp;</td>
       <td nowrap=\\\"nowrap\\\"><span class=\\\"smallfont\\\">\".((\$boards['threadprefix']!=\"\" && \$permissioncache[\$boards['boardid']]['can_enter_board'] && \$boards['password']==\"\") ? (\"<span class=\\\"prefix\\\">\$boards[threadprefix]</span><br />\") : (\"\")).\" \".((\$permissioncache[\$boards['boardid']]['can_enter_board'] && \$boards['password']==\"\") ? (\"<b><a href=\\\"thread.php?goto=lastpost&amp;threadid=\$boards[lastthreadid]{\$SID_ARG_2ND}\\\" title=\\\"\$boards[topic]\\\">\$topic</a></b>\") : (\"<b>{\$lang->items['LANG_START_UNKNOWN']}</b>\")).\"<br />\$lastpostdate <span class=\\\"time\\\">\$lastposttime</span>&nbsp;{\$lang->items['LANG_START_FROM']}&nbsp;\".((\$boards['lastposterid']) ? (\"<b><a href=\\\"profile.php?userid=\$boards[lastposterid]{\$SID_ARG_2ND}\\\">\$boards[lastposter]</a></b>\") : (\"\$boards[lastposter]\")).\"</span></td>
      </tr>
     </table>
    
    \") 
    : (\"
    
     <table style=\\\"width:100%\\\">
      <tr class=\\\"tableb_fc\\\">
       <td nowrap=\\\"nowrap\\\" align=\\\"right\\\" style=\\\"width:100%\\\"><span class=\\\"smallfont\\\">\$lastpostdate <span class=\\\"time\\\">\$lastposttime</span><br />{\$lang->items['LANG_START_FROM']} \".((\$boards['lastposterid']) ? (\"<b><a href=\\\"profile.php?userid=\$boards[lastposterid]{\$SID_ARG_2ND}\\\">\$boards[lastposter]</a></b>\") : (\"\$boards[lastposter]\")).\"</span></td>
       <td><a href=\\\"thread.php?goto=lastpost&amp;threadid=\$boards[lastthreadid]{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/lastpost.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_START_GOTO_LASTPOST']}\\\" title=\\\"{\$lang->items['LANG_START_GOTO_LASTPOST']}\\\" /></a></td>
      </tr>
     </table>
    
    \")
   ).\"
  \") 
  
  : (\"
   <div align=\\\"center\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_START_NOPOSTS']}</span></div>
  \")
  
 ).\"</td>
 \".((\$hide_modcell==0 && (!isset(\$favorites) || !\$favorites)) ? (\"<td class=\\\"tablea\\\" align=\\\"center\\\"><span class=\\\"smallfont\\\">\".((\$moderatorbit!=\"\") ? (\"\$moderatorbit\") : (\"&nbsp;\")).\"</span></td>\") : (\"\")).\"
 
 \") : (\"\")).\"
</tr>";
			?>
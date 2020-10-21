<tr>
 <if($depth == 1)>
  <then>
  
   <td align="left" class="tablea"<if($boards['externalurl'] != '')><then> colspan="<if($hide_modcell==0)><then>6</then><else>5</else></if>"</then><else> colspan="2"</else></if>><table cellpadding="0" cellspacing="0">
    <tr class="tablea_fc">
     <td><img src="{$style['imagefolder']}/$onoff.gif" alt="" title="" />&nbsp;&nbsp;</td>
     <td align="left"><span class="normalfont"><a href="board.php?boardid=$boards[boardid]{$SID_ARG_2ND}"><b>$boards[title]</b></a></span><span class="smallfont">
      <if($boards['description']!="")><then><br />$boards[description]</then></if><if($subboardbit!="")><then><br />{$lang->items['LANG_START_INCLUSIVE']} $subboardbit</then></if><if(isset($boards['useronline']) && $boards['useronline'])><then><br />($boards[useronline])</then></if></span></td>
    </tr>
   </table></td>
  
  </then>
  
  <else>
  
  
  <if($depth == 2)>
   <then>
  
   <td class="tableb" align="center"><img src="{$style['imagefolder']}/$onoff.gif" alt="" title="" /></td>
   <td align="left" class="tablea"<if($boards['externalurl'] != '')><then> colspan="<if($hide_modcell==0)><then>5</then><else>4</else></if>"</then></if>><span class="normalfont"><a href="board.php?boardid=$boards[boardid]{$SID_ARG_2ND}"><b>$boards[title]</b></a></span><span class="smallfont">
    <if($boards['description']!="")><then><br />$boards[description]</then></if><if($subboardbit!="")><then><br />{$lang->items['LANG_START_INCLUSIVE']} $subboardbit</then></if><if(isset($boards['useronline']) && $boards['useronline'])><then><br />($boards[useronline])</then></if>
    
    <if(isset($favorites) && $favorites)>
     <then><br /><b><a href="newthread.php?boardid=$boards[boardid]{$SID_ARG_2ND}">{$lang->items['LANG_START_NEWTHREAD']}</a> <a href="usercp.php?action=removesubscription&amp;boardid=$boards[boardid]{$SID_ARG_2ND}">{$lang->items['LANG_START_UNSUBSCRIBE']}</a></b></then>
    </if>
    
    </span></td>
 
  </then>
  
  <else>
  
   <td class="tableb" align="center">&nbsp;</td>
   <td class="tablea" align="left"<if($boards['externalurl'] != '')><then> colspan="<if($hide_modcell==0)><then>5</then><else>4</else></if>"</then></if>><table cellpadding="0" cellspacing="0">
    <tr class="tablea_fc">
     <td><img src="{$style['imagefolder']}/$onoff.gif" alt="" title="" />&nbsp;&nbsp;</td>
     <td><span class="normalfont"><a href="board.php?boardid=$boards[boardid]{$SID_ARG_2ND}"><b>$boards[title]</b></a></span><span class="smallfont">
      <if($boards['description']!="")><then><br />$boards[description]</then></if><if($subboardbit!="")><then><br />{$lang->items['LANG_START_INCLUSIVE']} $subboardbit</then></if><if(isset($boards['useronline']) && $boards['useronline'])><then><br />($boards[useronline])</then></if></span></td>
    </tr>
   </table></td>
  
  </else>
  </if>
  
  </else>
 </if>
 
 <if($boards['externalurl'] == '')><then>
 
 <td class="tableb" align="center" nowrap="nowrap"><span class="normalfont">$boards[postcount]</span></td>
 <td class="tablea" align="center" nowrap="nowrap"><span class="normalfont">$boards[threadcount]</span></td>
 <td class="tableb" nowrap="nowrap" align="left"><if($boards['threadcount']!=0)>
  
  <then>
   <if($showlastposttitle==1)>
    <then>
    
     <table border="0" cellspacing="0" cellpadding="0">
      <tr align="left" class="tableb_fc">
       <td nowrap="nowrap">&nbsp;&nbsp;$ViewPosticon&nbsp;</td>
       <td nowrap="nowrap"><span class="smallfont"><if($boards['threadprefix']!="" && $permissioncache[$boards['boardid']]['can_enter_board'] && $boards['password']=="")><then><span class="prefix">$boards[threadprefix]</span><br /></then></if> <if($permissioncache[$boards['boardid']]['can_enter_board'] && $boards['password']=="")><then><b><a href="thread.php?goto=lastpost&amp;threadid=$boards[lastthreadid]{$SID_ARG_2ND}" title="$boards[topic]">$topic</a></b></then><else><b>{$lang->items['LANG_START_UNKNOWN']}</b></else></if><br />$lastpostdate <span class="time">$lastposttime</span>&nbsp;{$lang->items['LANG_START_FROM']}&nbsp;<if($boards['lastposterid'])><then><b><a href="profile.php?userid=$boards[lastposterid]{$SID_ARG_2ND}">$boards[lastposter]</a></b></then><else>$boards[lastposter]</else></if></span></td>
      </tr>
     </table>
    
    </then>
    <else>
    
     <table style="width:100%">
      <tr class="tableb_fc">
       <td nowrap="nowrap" align="right" style="width:100%"><span class="smallfont">$lastpostdate <span class="time">$lastposttime</span><br />{$lang->items['LANG_START_FROM']} <if($boards['lastposterid'])><then><b><a href="profile.php?userid=$boards[lastposterid]{$SID_ARG_2ND}">$boards[lastposter]</a></b></then><else>$boards[lastposter]</else></if></span></td>
       <td><a href="thread.php?goto=lastpost&amp;threadid=$boards[lastthreadid]{$SID_ARG_2ND}"><img src="{$style['imagefolder']}/lastpost.gif" border="0" alt="{$lang->items['LANG_START_GOTO_LASTPOST']}" title="{$lang->items['LANG_START_GOTO_LASTPOST']}" /></a></td>
      </tr>
     </table>
    
    </else>
   </if>
  </then>
  
  <else>
   <div align="center"><span class="smallfont">{$lang->items['LANG_START_NOPOSTS']}</span></div>
  </else>
  
 </if></td>
 <if($hide_modcell==0 && (!isset($favorites) || !$favorites))><then><td class="tablea" align="center"><span class="smallfont"><if($moderatorbit!="")><then>$moderatorbit</then><else>&nbsp;</else></if></span></td></then></if>
 
 </then></if>
</tr>
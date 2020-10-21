<tr align="center">
  <td class="tablea"><img src="{$style['imagefolder']}/$foldericon.gif" border="0" alt="" title="" /></td>
  <td class="tableb">$threadicon</td>
  <td class="tablea" style="width:80%" align="left"><span class="normalfont">
  
  <if($threads['attachments'])>
   <then><img src="{$style['imagefolder']}/paperclip.gif" border="0" alt="{$LANG_BOARD_ATTACHMENTS}" title="{$LANG_BOARD_ATTACHMENTS}" /> </then>
  </if>
  
  <if($firstnew==1)>
   <then><a href="thread.php?threadid=$threads[threadid]&amp;goto=firstnew{$SID_ARG_2ND}"><img src="{$style['imagefolder']}/firstnew.gif" alt="{$lang->items['LANG_BOARD_GOTO_FIRSTNEW']}" title="{$lang->items['LANG_BOARD_GOTO_FIRSTNEW']}" border="0" /></a> </then>
  </if>  
  
  <span class="prefix">
  
  <if($threads['closed']==3)>
   <then><b>{$lang->items['LANG_BOARD_MOVED']}</b> </then>
  </if>
  
  <if($threads['important']==2)>
   <then><b>{$lang->items['LANG_BOARD_ANNOUNCEMENT']}</b> </then>
  </if>
  
  <if($threads['important']==1)>
   <then><b>{$lang->items['LANG_BOARD_IMPORTANT']}</b> </then>
  </if>

   <if($threads['done']==1)>
    <then><img src="{$style['imagefolder']}/done.gif" border="0" alt="{$lang->items['LANG_BOARD_DONE']}" title="{$lang->items['LANG_BOARD_DONE']}" /></then>
   </if>
  
  <if($threads['pollid']!=0 && $threads['closed']!=3)>
   <then><b>{$lang->items['LANG_BOARD_POLL']}</b> </then>
  </if>
  
  <if($threads['prefix']!="")>
   <then>$threads[prefix] </then>
  </if>
  
  </span>
  <a href="thread.php?threadid=$threads[threadid]<if($search[searchstring])><then>&amp;hilight=$search[searchstring]</then></if><if($search[searchuserid])><then>&amp;hilightuser=$search[searchuserid]</then></if>{$SID_ARG_2ND}">$threads[topic]</a></span>$multipages<span class="smallfont">
  
  <if(isset($favorites) && $favorites)>
   <then><br /><b><a href="addreply.php?threadid=$threads[threadid]{$SID_ARG_2ND}">{$lang->items['LANG_BOARD_REPLY']}</a> <a href="usercp.php?threadid=$threads[threadid]&amp;action=removesubscription{$SID_ARG_2ND}">{$lang->items['LANG_BOARD_REMOVE_SUBSCRIPTION']}</a></b></then>
  </if>
  
  <if($filename=="search.php")>
   <then><br />{$lang->items['LANG_SEARCH_BOARD']} <b><a href="board.php?boardid=$threads[boardid]{$SID_ARG_2ND}">$threads[title]</a></b></then>
  </if>
  </span></td>
  
  <td class="tableb"><span class="normalfont"><a href="javascript:who($threads[threadid])">$threads[replycount]</a></span></td>
  <td class="tablea" style="width:20%"><span class="normalfont"><if($threads['starterid']!=0)><then><a href="profile.php?userid=$threads[starterid]{$SID_ARG_2ND}">$threads[starter]</a></then><else>$threads[starter]</else></if></span></td>
  <td class="tableb"><span class="normalfont">$threads[views]</span></td>
  <if($board['allowratings']==1)><then><td class="tablea" nowrap="nowrap">$threadrating</td></then></if>
  <td class="<if($board['allowratings']==1)><then>tableb</then><else>tablea</else></if>" align="left"><table cellpadding="0" cellspacing="0" border="0" style="width:100%">
   <tr align="right" class="<if($board['allowratings']==1)><then>tableb</then><else>tablea</else></if>_fc">
    <td align="right" nowrap="nowrap"><span class="smallfont">$lastpostdate <span class="time">$lastposttime</span><br />
    {$lang->items['LANG_BOARD_FROM']} <if($threads['lastposterid']!=0)><then><b><a href="profile.php?userid=$threads[lastposterid]{$SID_ARG_2ND}">$threads[lastposter]</a></b></then><else>$threads[lastposter]</else></if></span></td>
    <td nowrap="nowrap"><span class="smallfont">&nbsp;<a href="thread.php?threadid=$threads[threadid]&amp;goto=lastpost{$SID_ARG_2ND}"><img src="{$style['imagefolder']}/lastpost.gif" alt="{$lang->items['LANG_BOARD_GOTO_LASTPOST']}" title="{$lang->items['LANG_BOARD_GOTO_LASTPOST']}" border="0" /></a></span></td>
   </tr>
  </table></td>
 </tr>
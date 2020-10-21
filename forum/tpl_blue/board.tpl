<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">
<head>
<title>$master_board_name | $board[title]</title>
$headinclude

<if($pages>1)>
<then>
<link rel="first" href="board.php?boardid=$boardid&amp;daysprune=$daysprune&amp;sortfield=$sortfield&amp;sortorder=$sortorder&amp;page=1{$SID_ARG_2ND}" />
<link rel="last" href="board.php?boardid=$boardid&amp;daysprune=$daysprune&amp;sortfield=$sortfield&amp;sortorder=$sortorder&amp;page=$pages{$SID_ARG_2ND}" />

<if($pages>$page)><then><link rel="next" href="board.php?boardid=$boardid&amp;daysprune=$daysprune&amp;sortfield=$sortfield&amp;sortorder=$sortorder&amp;page=$page+1{$SID_ARG_2ND}" /></then></if>
<if($page>1)><then><link rel="prev" href="board.php?boardid=$boardid&amp;daysprune=$daysprune&amp;sortfield=$sortfield&amp;sortorder=$sortorder&amp;page=$page-1{$SID_ARG_2ND}" /></then></if>

</then>
</if>

<script type="text/javascript">
<!--
function who(threadid) {
 window.open("misc.php?action=whoposted&threadid="+threadid+"{$SID_ARG_2ND_UN}", "moo", "toolbar=no,scrollbars=yes,resizable=yes,width=250,height=300");
}
//-->
</script>
</head>

<body>
$header
<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
 <tr>
  <td class="tablea"><table cellpadding="0" cellspacing="0" border="0" style="width:100%">
   <tr class="tablea_fc">
    <td align="left"><span class="smallfont"><b><a href="index.php{$SID_ARG_1ST}">$master_board_name</a>$navbar</b></span></td>
    <td align="right"><span class="smallfont"><b>$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
 <tr>
  <td class="tabletitle"><table cellpadding="0" cellspacing="0" border="0" style="width:100%">
   <tr class="tabletitle_fc">
    <td align="left"><span class="smallfont"><if(isset($moderatorbit))><then>({$lang->items['LANG_BOARD_MODERATED_BY']} $moderatorbit)</then></if></span></td>
    <td align="right" valign="top"><span class="smallfont"><a href="usercp.php?action=addsubscription&amp;boardid=$boardid{$SID_ARG_2ND}">{$lang->items['LANG_BOARD_ADD_FAVORITES']}</a> | <a href="markread.php?boardid=$boardid{$SID_ARG_2ND}">{$lang->items['LANG_BOARD_MARKREAD']}</a></span></td>
   </tr>
  </table></td>
 </tr>
</table>

<if(isset($boardbit) && $boardbit)>
 <then>
  <br />
  <table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
   <tr class="smallfont" align="center">
    <td class="tabletitle">&nbsp;</td>
    <td class="tabletitle" style="width:<if($hide_modcell==0)><then>80</then><else>100</else></if>%" align="left"><b>{$lang->items['LANG_START_BOARDS']}</b></td>
    <td class="tabletitle"><b>{$lang->items['LANG_START_POSTS']}</b></td>
    <td class="tabletitle"><b>{$lang->items['LANG_START_THREADS']}</b></td>
    <td class="tabletitle" nowrap="nowrap"><b>{$lang->items['LANG_START_LASTPOST']}</b></td>
    <if($hide_modcell==0)><then><td class="tabletitle" style="width:20%"><b>{$lang->items['LANG_START_MODERATORS']}</b></td></then></if>
   </tr>
   $boardbit
  </table>
 </then>
</if>

<table style="width:{$style['tableinwidth']}">
 <tr>
  <td align="left"><span class="smallfont"><if($useronlinebit!="")><then>($useronlinebit)</then><else>&nbsp;</else></if></span></td>
  <td align="right" valign="bottom">$newthread</td>
 </tr>
</table>

<if($threadbit1!="" || $threadbit2!="")>
 <then>
 <form method="get" action="board.php">
<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
 <tr align="center" class="smallfont">
  <td class="tabletitle" colspan="3"><b><a href="board.php?boardid=$boardid&amp;daysprune=$daysprune&amp;sortfield=topic&amp;sortorder=<if($sortfield == 'topic' && $sortorder == 'ASC')><then>DESC</then><else>ASC</else></if>{$SID_ARG_2ND}">{$lang->items['LANG_BOARD_THREAD']}</a></b> <if($sortfield == 'topic')><then><a href="board.php?boardid=$boardid&amp;daysprune=$daysprune&amp;sortfield=$sortfield&amp;sortorder=<if($sortorder == 'DESC')><then>ASC</then><else>DESC</else></if>{$SID_ARG_2ND}"><img src="{$style['imagefolder']}/<if($sortorder == 'DESC')><then>sortasc.gif</then><else>sortdesc.gif</else></if>" alt="" border="0" /></a></then></if></td>
  <td class="tabletitle" nowrap="nowrap"><b><a href="board.php?boardid=$boardid&amp;daysprune=$daysprune&amp;sortfield=replycount&amp;sortorder=<if($sortfield == 'replycount' && $sortorder == 'ASC')><then>DESC</then><else>ASC</else></if>{$SID_ARG_2ND}">{$lang->items['LANG_BOARD_REPLIES']}</a></b> <if($sortfield == 'replycount')><then><a href="board.php?boardid=$boardid&amp;daysprune=$daysprune&amp;sortfield=$sortfield&amp;sortorder=<if($sortorder == 'DESC')><then>ASC</then><else>DESC</else></if>{$SID_ARG_2ND}"><img src="{$style['imagefolder']}/<if($sortorder == 'DESC')><then>sortasc.gif</then><else>sortdesc.gif</else></if>" alt="" border="0" /></a></then></if></td>
  <td class="tabletitle" nowrap="nowrap"><b><a href="board.php?boardid=$boardid&amp;daysprune=$daysprune&amp;sortfield=starter&amp;sortorder=<if($sortfield == 'starter' && $sortorder == 'ASC')><then>DESC</then><else>ASC</else></if>{$SID_ARG_2ND}">{$lang->items['LANG_BOARD_AUTHOR']}</a></b> <if($sortfield == 'starter')><then><a href="board.php?boardid=$boardid&amp;daysprune=$daysprune&amp;sortfield=$sortfield&amp;sortorder=<if($sortorder == 'DESC')><then>ASC</then><else>DESC</else></if>{$SID_ARG_2ND}"><img src="{$style['imagefolder']}/<if($sortorder == 'DESC')><then>sortasc.gif</then><else>sortdesc.gif</else></if>" alt="" border="0" /></a></then></if></td>
  <td class="tabletitle" nowrap="nowrap"><b><a href="board.php?boardid=$boardid&amp;daysprune=$daysprune&amp;sortfield=views&amp;sortorder=<if($sortfield == 'views' && $sortorder == 'ASC')><then>DESC</then><else>ASC</else></if>{$SID_ARG_2ND}">{$lang->items['LANG_BOARD_VIEWS']}</a></b> <if($sortfield == 'views')><then><a href="board.php?boardid=$boardid&amp;daysprune=$daysprune&amp;sortfield=$sortfield&amp;sortorder=<if($sortorder == 'DESC')><then>ASC</then><else>DESC</else></if>{$SID_ARG_2ND}"><img src="{$style['imagefolder']}/<if($sortorder == 'DESC')><then>sortasc.gif</then><else>sortdesc.gif</else></if>" alt="" border="0" /></a></then></if></td>
  <if($board['allowratings']==1)><then><td class="tabletitle" nowrap="nowrap"><b><a href="board.php?boardid=$boardid&amp;daysprune=$daysprune&amp;sortfield=vote&amp;sortorder=<if($sortfield == 'vote' && $sortorder == 'ASC')><then>DESC</then><else>ASC</else></if>{$SID_ARG_2ND}">{$lang->items['LANG_BOARD_RATING']}</a></b> <if($sortfield == 'vote')><then><a href="board.php?boardid=$boardid&amp;daysprune=$daysprune&amp;sortfield=$sortfield&amp;sortorder=<if($sortorder == 'DESC')><then>ASC</then><else>DESC</else></if>{$SID_ARG_2ND}"><img src="{$style['imagefolder']}/<if($sortorder == 'DESC')><then>sortasc.gif</then><else>sortdesc.gif</else></if>" alt="" border="0" /></a></then></if></td></then></if>
  <td class="tabletitle" nowrap="nowrap"><b><a href="board.php?boardid=$boardid&amp;daysprune=$daysprune&amp;sortfield=lastposttime&amp;sortorder=<if($sortfield == 'lastposttime' && $sortorder == 'ASC')><then>DESC</then><else>ASC</else></if>{$SID_ARG_2ND}">{$lang->items['LANG_BOARD_LASTPOST']}</a></b> <if($sortfield == 'lastposttime')><then><a href="board.php?boardid=$boardid&amp;daysprune=$daysprune&amp;sortfield=$sortfield&amp;sortorder=<if($sortorder == 'DESC')><then>ASC</then><else>DESC</else></if>{$SID_ARG_2ND}"><img src="{$style['imagefolder']}/<if($sortorder == 'DESC')><then>sortasc.gif</then><else>sortdesc.gif</else></if>" alt="" border="0" /></a></then></if></td>
 </tr>
 <tr height="5">
  <td class="tableb" align="left" colspan="<if($board['allowratings']==1)><then>8</then><else>7</else></if>"></td>
 </tr>
 
 <if($splithreadbit==1 && $threadbit1!="" && $threadbit2!="")>
  <then>
   <tr>
    <td align="left" class="tablecat" colspan="<if($board['allowratings']==1)><then>8</then><else>7</else></if>"><span class="normalfont"><b>{$lang->items['LANG_BOARD_IMPORTANT_THREADS']}</b></span></td>
   </tr>
  </then>
 </if>
 
 $threadbit1
 
 <if($splithreadbit==1 && $threadbit2!="" && $threadbit1!="")>
  <then>
   <tr>
    <td align="left" class="tablecat" colspan="<if($board['allowratings']==1)><then>8</then><else>7</else></if>"><span class="normalfont"><b>{$lang->items['LANG_BOARD_THREADS']}</b></span></td>
   </tr>
  </then>
 </if>
 
 $threadbit2
 <tr>
  <td class="tableb" colspan="<if($board['allowratings']==1)><then>8</then><else>7</else></if>" align="center">
   <input type="hidden" name="page" value="$page" />
   <input type="hidden" name="boardid" value="$boardid" />
   <input type="hidden" name="sid" value="$session[hash]" />
   <span class="normalfont">{$lang->items['LANG_BOARD_SORTOPTIONS']}
        <input src="{$style['imagefolder']}/go.gif" type="image" /></span></td>
 </tr>
</table>
 </form>
 </then>
 <else>
 
<form method="get" action="board.php" name="dform">
<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
 <tr>
  <td class="tablea" colspan="8" align="center"><span class="normalfont">{$lang->items['LANG_BOARD_NOTHREADS']}</span></td>
 </tr>
</table>
<input type="hidden" name="boardid" value="$boardid" />
 <input type="hidden" name="sid" value="$session[hash]" />
 </form>
 
 </else>
</if>

<table style="width:{$style['tableinwidth']}">
 <tr>
  <td align="left" valign="top"><span class="smallfont">$pagelink</span></td>
  <td align="right" valign="top">$newthread</td>
 </tr>
 <tr>
  <if(checkpermissions("can_use_search")==1)>
   <then>
    <td align="left" valign="top">
    <form action="search.php" method="post">
    <input type="hidden" name="sid" value="$session[hash]" />
    <input type="hidden" name="topiconly" value="0" />
    <input type="hidden" name="showposts" value="0" />
    <input type="hidden" name="beforeafter" value="after" />
    <input type="hidden" name="searchdate" value="0" />
    <input type="hidden" name="sortorder" value="desc" />
    <input type="hidden" name="sortby" value="lastpost" />
    <input type="hidden" name="send" value="send" />
    <input type="hidden" name="boardids[]" value="$boardid" />
    <span class="smallfont"><b>{$lang->items['LANG_BOARD_SEARCH']}<br /><input class="input" type="text" name="searchstring" value="" /> <input src="{$style['imagefolder']}/go.gif" type="image" /></b></span>
    </form></td>
   </then>
   <else><td></td></else>
  </if> 
  <td valign="top" align="right">$boardjump</td>
 </tr>
 </table>
<table align="center">
 <tr align="left">
  <td><span class="smallfont"><img src="{$style['imagefolder']}/newfolder.gif" alt="" title="" border="0" />&nbsp;<b>{$lang->items['LANG_BOARD_NEWFOLDER']}</b></span></td>
  <td><span class="smallfont">(&nbsp;<img src="{$style['imagefolder']}/newhotfolder.gif" alt="" title="" border="0" />&nbsp;<b>{$lang->items['LANG_BOARD_NEWHOTFOLDER']}</span></td>
  <td><span class="smallfont"><img src="{$style['imagefolder']}/lockfolder.gif" alt="" title="" border="0" />&nbsp;<b>{$lang->items['LANG_BOARD_LOCKFOLDER']}</b></span></td>
 </tr>
 <tr align="left">
  <td><span class="smallfont"><img src="{$style['imagefolder']}/folder.gif" alt="" title="" border="0" />&nbsp;<b>{$lang->items['LANG_BOARD_FOLDER']}</b></span></td>
  <td><span class="smallfont">(&nbsp;<img src="{$style['imagefolder']}/hotfolder.gif" alt="" title="" border="0" />&nbsp;<b>{$lang->items['LANG_BOARD_HOTFOLDER']}</span></td>
  <td><span class="smallfont"><img src="{$style['imagefolder']}/dotfolder.gif" alt="" title="" border="0" />&nbsp;<b>{$lang->items['LANG_BOARD_DOTFOLDER']}</b></span></td>
 </tr>
</table>
$footer
</body>
</html>
<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">
<head>
<title>$master_board_name | $board[title] | $thread[prefix] $thread[topic]</title>
$headinclude

<link rel="contents" href="board.php?boardid=$boardid{$SID_ARG_2ND}" />
<if($t->pages>1)>
<then>
<link rel="first" href="thread.php?threadid=$threadid&amp;threadview=$threadview&amp;hilight=$hilight&amp;hilightuser=$hilightuser&amp;page=1{$SID_ARG_2ND}" />
<link rel="last" href="thread.php?threadid=$threadid&amp;threadview=$threadview&amp;hilight=$hilight&amp;hilightuser=$hilightuser&amp;page=$t->pages{$SID_ARG_2ND}" />

<if($t->pages>$t->page)><then><link rel="next" href="thread.php?threadid=$threadid&amp;threadview=$threadview&amp;hilight=$hilight&amp;hilightuser=$hilightuser&amp;page=$t->page+1{$SID_ARG_2ND}" /></then></if>
<if($t->page>1)><then><link rel="prev" href="thread.php?threadid=$threadid&amp;threadview=$threadview&amp;hilight=$hilight&amp;hilightuser=$hilightuser&amp;page=$t->page-1{$SID_ARG_2ND}" /></then></if>

</then>
</if>

<script type="text/javascript">
<!--
var imageMaxWidth = $picmaxwidth;
var imageMaxHeight = $picmaxheight;
//-->
</script>
<script type="text/javascript" src="js/images.js"></script>
<script type="text/javascript">
<!--
function rating(userid) {
 window.open("misc.php?action=userrating&userid="+userid+"{$SID_ARG_2ND_UN}", "moo", "toolbar=no,scrollbars=yes,resizable=yes,width=350,height=205");
}
//-->
</script>
</head>

<body onload="resizeImages();">
$header
 <table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
 <tr>
  <td class="tablea"><table cellpadding="0" cellspacing="0" border="0" style="width:100%">
   <tr class="tablea_fc">
    <td align="left"><span class="smallfont"><b><a href="index.php{$SID_ARG_1ST}">$master_board_name</a>$navbar &raquo; </b><if($thread['prefix']!="")><then><span class="prefix">$thread[prefix]</span> </then></if><b>$thread[topic]</b></span></td>
    <td align="right"><span class="smallfont"><b>$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
 <tr>
  <td class="tabletitle"><table cellpadding="0" cellspacing="0" border="0" style="width:100%">
   <tr class="tabletitle_fc">
    <td align="left"><span class="smallfont"><a href="thread.php?goto=lastpost&amp;threadid=$threadid{$SID_ARG_2ND}">{$lang->items['LANG_THREAD_LASTPOST']}</a> | <a href="thread.php?goto=firstnew_thread&amp;threadid=$threadid{$SID_ARG_2ND}">{$lang->items['LANG_THREAD_FIRST_NEWPOST']}</a></span></td>
    <td align="right" valign="top"><span class="smallfont"><a href="print.php?threadid=$threadid&amp;page=$t->page{$SID_ARG_2ND}">{$lang->items['LANG_THREAD_PRINTTHREAD']}</a> | <if($turnoff_formmail==0)><then><a href="formmail.php?threadid=$threadid{$SID_ARG_2ND}">{$lang->items['LANG_THREAD_SENDTOFRIEND']}</a> |</then></if> <a href="usercp.php?action=addsubscription&amp;threadid=$threadid{$SID_ARG_2ND}">{$lang->items['LANG_THREAD_ADD_FAVORITES']}</a></span></td>
   </tr>
  </table></td>
 </tr>
</table>
<table style="width:{$style['tableinwidth']}">
 <tr>
  <td align="right" valign="bottom"><span class="smallfont">$newthread $addreply</span></td>
 </tr>
</table>
$thread_poll
<table cellpadding="0" cellspacing="0" border="0" style="width:{$style['tableinwidth']}" align="center">
 <tr>
  <td><table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" class="tableinborder" style="width:100%">
   <tr>
    <td class="tablea" align="left"<if(isset($t->postbitlist))><then> colspan="3"</then></if>>
    <table cellpadding="0" cellspacing="0" border="0" style="width:100%" >
    <tr>
     <td align="left"><span class="normalfont"><a href="javascript:self.scrollTo(0,50000);"><img src="{$style['imagefolder']}/asc.gif" border="0" alt="{$lang->items['LANG_THREAD_GODOWN']}" title="{$lang->items['LANG_THREAD_GODOWN']}" /></a> <b>$thread[topic] $threadrating</b></span></td>
     <td align="right" valign="bottom" class="tablea"><span class="smallfont">$t->pagelink</span></td>
    </tr>
    </table>
   </td>
  </tr>  
 <tr class="tabletitle">
  <td align="right"><span class="smallfont"><a href="thread.php?threadid=$threadid&amp;threadview=1&amp;hilight=$hilight&amp;hilightuser=$hilightuser{$SID_ARG_2ND}">{$lang->items['LANG_THREAD_THREADED']}</a> | <a href="thread.php?threadid=$threadid&amp;threadview=0&amp;hilight=$hilight&amp;hilightuser=$hilightuser{$SID_ARG_2ND}">{$lang->items['LANG_THREAD_FLATTHREAD']}</a></span></td>
 </tr>

   <if(isset($t->postbitlist))>
   <then>
   
    <tr align="center">
     <td class="tablecat" style="width:80%"><span class="smallfont"><b>{$lang->items['LANG_THREAD_POSTBITLIST']}</b></span></td>
     <td class="tablecat" style="width:20%"><span class="smallfont"><b>{$lang->items['LANG_THREAD_AUTHOR']}</b></span></td>
     <td class="tablecat" nowrap="nowrap"><span class="smallfont"><b>{$lang->items['LANG_THREAD_DATE']}</b></span></td>
    </tr>
    
    <if($t->page!=1)>
    <then>
    
    <tr align="center">
     <td class="tableb" colspan="3"><span class="normalfont"><a href="thread.php?threadid=$threadid&amp;threadview=$threadview&amp;hilight=$hilight&amp;hilightuser=$hilightuser&amp;page=<expression>($t->page-1)</expression>{$SID_ARG_2ND}">{$lang->items['LANG_THREAD_PREVPAGE']}</a></span></td>
    </tr>
    
    </then>
    </if>
    
    {$t->postbitlist}    
    
    <if($t->page<$t->pages)>
    <then>
    
    <tr align="center">
     <td class="tableb" colspan="3"><span class="normalfont"><a href="thread.php?threadid=$threadid&amp;threadview=$threadview&amp;hilight=$hilight&amp;hilightuser=$hilightuser&amp;page=<expression>($t->page+1)</expression>{$SID_ARG_2ND}">{$lang->items['LANG_THREAD_NEXTPAGE']}</a></span></td>
    </tr>
    
    </then>
    </if>
   
   </table><br />
   <table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" class="tableinborder" style="width:100%">
   
   </then>
   <else>
   	</table><br />
   </else>
   </if>
   
   
   <table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" class="tableinborder" style="width:100%">
   <tr>
    <td class="tabletitle" align="left" style="width:<expression>((2*$style['tableincellpadding'])+159)</expression>px" nowrap="nowrap"><span class="smallfont"><b>{$lang->items['LANG_THREAD_AUTHOR']}</b></span></td>
    <td class="tabletitle"><table cellpadding="0" cellspacing="0" border="0" style="width:100%">
     <tr class="tabletitle_fc">
      <td align="left"><span class="smallfont"><b>{$lang->items['LANG_THREAD_POST']}</b></span></td>
      <td align="right"><span class="smallfont"><b>&laquo;</b> <a href="thread.php?goto=nextoldest&amp;threadid=$threadid{$SID_ARG_2ND}">{$lang->items['LANG_THREAD_NEXTOLDEST']}</a> | <a href="thread.php?goto=nextnewest&amp;threadid=$threadid{$SID_ARG_2ND}">{$lang->items['LANG_THREAD_NEXTNEWEST']}</a> <b>&raquo;</b></span></td>
     </tr>
    </table></td>
   </tr>
  </table>
  $postbit
  <table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" class="tableinborder" style="width:100%">
   <tr>
    <td class="tabletitle" colspan="2">
     <table cellpadding="0" cellspacing="0" border="0" style="width:100%">
      <tr class="tabletitle_fc">
       <td align="left"><span class="smallfont">$t->pagelink &nbsp;</span></td>
      </tr>
     </table>
    </td>
   </tr>
  </table></td>
 </tr>
</table>
<table style="width:{$style['tableinwidth']}">
 <tr>
  <td align="left" valign="top">$boardjump</td>
  <td align="right" valign="top"><span class="smallfont">$newthread $addreply</span></td>
 </tr>
</table>

<if(checkpermissions("can_rate_thread")==1 && $board['allowratings']==1 && !$thread['isvoted'])>
 <then>
 <table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
  
  <tr>
   <td class="tablea"><form action="threadrating.php" method="post"><table border="0" cellspacing="0" cellpadding="0" align="center" class="tablea_fc">
                      <tr align="center"> 
                        <td valign="bottom" align="right"><span class="normalfont"><b>{$lang->items['LANG_THREAD_THREADRATING']}</b>&nbsp;</span><span class="smallfont"><br /><br />
                          {$lang->items['LANG_THREAD_VERYPOOR']}&nbsp;<img src="{$style['imagefolder']}/thumbs_down.gif" border="0" alt="{$lang->items['LANG_THREAD_VERYPOOR']}" title="{$lang->items['LANG_THREAD_VERYPOOR']}" />&nbsp;</span> 
                        </td>
                        <td style="background-color: $colors[0]"><span class="smallfont"> 
                          <input type="radio" name="rating" value="1" onclick="this.form.submit();" />
                          <br />
                          1 </span></td>
                        <td style="background-color: $colors[1]"><span class="smallfont"> 
                          <input type="radio" name="rating" value="2" onclick="this.form.submit();" />
                          <br />
                          2 </span></td>
                        <td style="background-color: $colors[2]"><span class="smallfont"> 
                          <input type="radio" name="rating" value="3" onclick="this.form.submit();" />
                          <br />
                          3 </span></td>
                        <td style="background-color: $colors[3]"><span class="smallfont"> 
                          <input type="radio" name="rating" value="4" onclick="this.form.submit();" />
                          <br />
                          4 </span></td>
                        <td style="background-color: $colors[4]"><span class="smallfont"> 
                          <input type="radio" name="rating" value="5" onclick="this.form.submit();" />
                          <br />
                          5 </span></td>
                        <td style="background-color: $colors[5]"><span class="smallfont"> 
                          <input type="radio" name="rating" value="6" onclick="this.form.submit();" />
                          <br />
                          6 </span></td>
                        <td style="background-color: $colors[6]"><span class="smallfont"> 
                          <input type="radio" name="rating" value="7" onclick="this.form.submit();" />
                          <br />
                          7 </span></td>
                        <td style="background-color: $colors[7]"><span class="smallfont"> 
                          <input type="radio" name="rating" value="8" onclick="this.form.submit();" />
                          <br />
                          8 </span></td>
                        <td style="background-color: $colors[8]"><span class="smallfont"> 
                          <input type="radio" name="rating" value="9" onclick="this.form.submit();" />
                          <br />
                          9 </span></td>
                        <td style="background-color: $colors[9]"><span class="smallfont"> 
                          <input type="radio" name="rating" value="10" onclick="this.form.submit();" />
                          <br />
                          10 </span></td>
                        <td align="left" valign="bottom"><span class="smallfont">&nbsp;<img src="{$style['imagefolder']}/thumbs_up.gif" border="0" alt="{$lang->items['LANG_THREAD_VERYGOOD']}" title="{$lang->items['LANG_THREAD_VERYGOOD']}" />&nbsp;{$lang->items['LANG_THREAD_VERYGOOD']}</span></td>
                      </tr>
                    </table>
                    <input type="hidden" name="sid" value="$session[hash]" />
  <input type="hidden" name="threadid" value="$threadid" />
  <input type="hidden" name="page" value="{$t->page}" />
  </form></td>
  </tr>
   </table><br />
  </then>
</if>
<table style="width:{$style['tableinwidth']}">
 <tr>
  <td align="right">
   <if(checkmodpermissions())>
    <then>
     <form action="modcp.php" method="get" name="modoption">
      <select name="action">
       <option value="-1">{$lang->items['LANG_THREAD_ADMINOPTIONS']}</option>
       <if(checkmodpermissions("m_can_thread_close"))>
  	<then><option value="thread_close">{$lang->items['LANG_THREAD_THREADCLOSE']}</option></then>
       </if>
       <if(checkmodpermissions("m_can_thread_move"))>
  	<then><option value="thread_move">{$lang->items['LANG_THREAD_THREADMOVE']}</option></then>
       </if>
       <if($board[done_field])>
  	<then><option value="thread_define_done">{$lang->items['LANG_THREAD_DEFINE_DONE']}</option></then>
       </if>
       <if(checkmodpermissions("m_can_thread_edit"))>
  	<then><option value="thread_edit">{$lang->items['LANG_THREAD_THREADEDIT']}</option></then>
       </if>
       <if(checkmodpermissions("m_can_post_del"))>
  	<then><option value="post_del">{$lang->items['LANG_THREAD_POSTDEL']}</option></then>
       </if>
       <if(checkmodpermissions("m_can_thread_del"))>
  	<then><option value="thread_del">{$lang->items['LANG_THREAD_THREADDEL']}</option></then>
       </if>
       <if(checkmodpermissions("m_can_thread_merge"))>
  	<then><option value="thread_merge">{$lang->items['LANG_THREAD_THREADMERGE']}</option></then>
       </if>
       <if(checkmodpermissions("m_can_thread_cut"))>
  	<then><option value="thread_cut">{$lang->items['LANG_THREAD_THREADCUT']}</option></then>
       </if>
       <if(checkmodpermissions("m_can_thread_top"))>
  	<then><option value="thread_top">{$lang->items['LANG_THREAD_THREADTOP']}</option></then>
       </if>
       <if(checkmodpermissions("m_can_add_poll"))>
  	<then><option value="polladd">{$lang->items['LANG_THREAD_POLLADD']}</option></then>
       </if>
      </select>
      <input src="{$style['imagefolder']}/go.gif" type="image" />
      <input type="hidden" name="threadid" value="$threadid" />
      <input type="hidden" name="sid" value="$session[hash]" />
     </form>
    </then>
    <else>
     <if($wbbuserdata['userid'] && $wbbuserdata['userid']==$thread['starterid'] && (checkpermissions("can_close_own_topic")==1 || checkpermissions("can_del_own_topic")==1 || checkpermissions("can_edit_own_topic")==1 || checkpermissions("can_move_own_topic")==1))>
      <then>
       <form action="modcp.php" method="get" name="modoption">
        <select name="action">
         <option value="-1">{$lang->items['LANG_THREAD_OTHEROPTIONS']}</option>
         <if(checkpermissions("can_close_own_topic")==1)>
  	  <then><option value="thread_close">{$lang->items['LANG_THREAD_THREADCLOSE']}</option></then>
         </if>
         <if(checkpermissions("can_move_own_topic")==1)>
  	  <then><option value="thread_move">{$lang->items['LANG_THREAD_THREADMOVE']}</option></then>
         </if>
         <if(checkpermissions("can_edit_own_topic")==1)>
  	  <then><option value="thread_edit">{$lang->items['LANG_THREAD_THREADEDIT']}</option></then>
         </if>
         <if(checkpermissions("can_del_own_topic")==1)>
  	  <then><option value="thread_del">{$lang->items['LANG_THREAD_THREADDEL']}</option></then>
         </if>
        </select>
        <input src="{$style['imagefolder']}/go.gif" type="image" />
        <input type="hidden" name="threadid" value="$threadid" />
        <input type="hidden" name="sid" value="$session[hash]" />
       </form>
      </then>
     </if>
    </else>
   </if>
  </td>
 </tr>
</table>
$footer

</body>
</html>
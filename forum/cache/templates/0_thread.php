<?php
			/*
			templatepackid: 0
			templatename: thread
			*/
			
			$this->templates['thread']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | \$board[title] | \$thread[prefix] \$thread[topic]</title>
\$headinclude

<link rel=\\\"contents\\\" href=\\\"board.php?boardid=\$boardid{\$SID_ARG_2ND}\\\" />
\".((\$t->pages>1) 
? (\"
<link rel=\\\"first\\\" href=\\\"thread.php?threadid=\$threadid&amp;threadview=\$threadview&amp;hilight=\$hilight&amp;hilightuser=\$hilightuser&amp;page=1{\$SID_ARG_2ND}\\\" />
<link rel=\\\"last\\\" href=\\\"thread.php?threadid=\$threadid&amp;threadview=\$threadview&amp;hilight=\$hilight&amp;hilightuser=\$hilightuser&amp;page=\$t->pages{\$SID_ARG_2ND}\\\" />

\".((\$t->pages>\$t->page) ? (\"<link rel=\\\"next\\\" href=\\\"thread.php?threadid=\$threadid&amp;threadview=\$threadview&amp;hilight=\$hilight&amp;hilightuser=\$hilightuser&amp;page=\$t->page+1{\$SID_ARG_2ND}\\\" />\") : (\"\")).\"
\".((\$t->page>1) ? (\"<link rel=\\\"prev\\\" href=\\\"thread.php?threadid=\$threadid&amp;threadview=\$threadview&amp;hilight=\$hilight&amp;hilightuser=\$hilightuser&amp;page=\$t->page-1{\$SID_ARG_2ND}\\\" />\") : (\"\")).\"

\") : (\"\")
).\"

<script type=\\\"text/javascript\\\">
<!--
var imageMaxWidth = \$picmaxwidth;
var imageMaxHeight = \$picmaxheight;
//-->
</script>
<script type=\\\"text/javascript\\\" src=\\\"js/images.js\\\"></script>
<script type=\\\"text/javascript\\\">
<!--
function rating(userid) {
 window.open(\\\"misc.php?action=userrating&userid=\\\"+userid+\\\"{\$SID_ARG_2ND_UN}\\\", \\\"moo\\\", \\\"toolbar=no,scrollbars=yes,resizable=yes,width=350,height=205\\\");
}
//-->
</script>
</head>

<body onload=\\\"resizeImages();\\\">
\$header
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a>\$navbar &raquo; </b>\".((\$thread['prefix']!=\"\") ? (\"<span class=\\\"prefix\\\">\$thread[prefix]</span> \") : (\"\")).\"<b>\$thread[topic]</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
 <tr>
  <td class=\\\"tabletitle\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tabletitle_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><a href=\\\"thread.php?goto=lastpost&amp;threadid=\$threadid{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_THREAD_LASTPOST']}</a> | <a href=\\\"thread.php?goto=firstnew_thread&amp;threadid=\$threadid{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_THREAD_FIRST_NEWPOST']}</a></span></td>
    <td align=\\\"right\\\" valign=\\\"top\\\"><span class=\\\"smallfont\\\"><a href=\\\"print.php?threadid=\$threadid&amp;page=\$t->page{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_THREAD_PRINTTHREAD']}</a> | \".((\$turnoff_formmail==0) ? (\"<a href=\\\"formmail.php?threadid=\$threadid{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_THREAD_SENDTOFRIEND']}</a> |\") : (\"\")).\" <a href=\\\"usercp.php?action=addsubscription&amp;threadid=\$threadid{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_THREAD_ADD_FAVORITES']}</a></span></td>
   </tr>
  </table></td>
 </tr>
</table>
<table style=\\\"width:{\$style['tableinwidth']}\\\">
 <tr>
  <td align=\\\"left\\\" valign=\\\"bottom\\\"><span class=\\\"smallfont\\\">\$t->pagelink</span></td>
  <td align=\\\"right\\\" valign=\\\"bottom\\\"><span class=\\\"smallfont\\\">\$newthread \$addreply</span></td>
 </tr>
</table>
\$thread_poll
<table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:{\$style['tableinwidth']}\\\" align=\\\"center\\\">
 <tr>
  <td><table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:100%\\\">
   <tr>
    <td class=\\\"tablecat\\\" align=\\\"left\\\"\".((isset(\$t->postbitlist)) ? (\" colspan=\\\"3\\\"\") : (\"\")).\"><span class=\\\"normalfont\\\"><a href=\\\"javascript:self.scrollTo(0,50000);\\\"><img src=\\\"{\$style['imagefolder']}/asc.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_THREAD_GODOWN']}\\\" title=\\\"{\$lang->items['LANG_THREAD_GODOWN']}\\\" /></a> <b>\$thread[topic] \$threadrating</b></span></td>
   </tr>
   
   \".((isset(\$t->postbitlist)) 
   ? (\"
   
    <tr align=\\\"center\\\">
     <td class=\\\"tabletitle\\\" style=\\\"width:80%\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_THREAD_POSTBITLIST']}</b></span></td>
     <td class=\\\"tabletitle\\\" style=\\\"width:20%\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_THREAD_AUTHOR']}</b></span></td>
     <td class=\\\"tabletitle\\\" nowrap=\\\"nowrap\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_THREAD_DATE']}</b></span></td>
    </tr>
    
    \".((\$t->page!=1) 
    ? (\"
    
    <tr align=\\\"center\\\">
     <td class=\\\"tableb\\\" colspan=\\\"3\\\"><span class=\\\"normalfont\\\"><a href=\\\"thread.php?threadid=\$threadid&amp;threadview=\$threadview&amp;hilight=\$hilight&amp;hilightuser=\$hilightuser&amp;page=\".(\$t->page-1).\"{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_THREAD_PREVPAGE']}</a></span></td>
    </tr>
    
    \") : (\"\")
    ).\"
    
    {\$t->postbitlist}    
    
    \".((\$t->page<\$t->pages) 
    ? (\"
    
    <tr align=\\\"center\\\">
     <td class=\\\"tableb\\\" colspan=\\\"3\\\"><span class=\\\"normalfont\\\"><a href=\\\"thread.php?threadid=\$threadid&amp;threadview=\$threadview&amp;hilight=\$hilight&amp;hilightuser=\$hilightuser&amp;page=\".(\$t->page+1).\"{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_THREAD_NEXTPAGE']}</a></span></td>
    </tr>
    
    \") : (\"\")
    ).\"
   
   </table><br />
   <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:100%\\\">
   
   \") 
   : (\"
   	</table>
   \")
   ).\"
   
   
   <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:100%\\\">
   <tr>
    <td class=\\\"tabletitle\\\" align=\\\"left\\\" style=\\\"width:\".((2*\$style['tableincellpadding'])+159).\"px\\\" nowrap=\\\"nowrap\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_THREAD_AUTHOR']}</b></span></td>
    <td class=\\\"tabletitle\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
     <tr class=\\\"tabletitle_fc\\\">
      <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_THREAD_POST']}</b></span></td>
      <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>&laquo;</b> <a href=\\\"thread.php?goto=nextoldest&amp;threadid=\$threadid{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_THREAD_NEXTOLDEST']}</a> | <a href=\\\"thread.php?goto=nextnewest&amp;threadid=\$threadid{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_THREAD_NEXTNEWEST']}</a> <b>&raquo;</b></span></td>
     </tr>
    </table></td>
   </tr>
  </table>
  \$postbit
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:100%\\\">
   <tr>
    <td class=\\\"tabletitle\\\" colspan=\\\"2\\\">
     <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
      <tr class=\\\"tabletitle_fc\\\">
       <td align=\\\"left\\\"><span class=\\\"smallfont\\\">\$t->pagelink</span></td>
       <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><a href=\\\"thread.php?threadid=\$threadid&amp;threadview=1&amp;hilight=\$hilight&amp;hilightuser=\$hilightuser{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_THREAD_THREADED']}</a> | <a href=\\\"thread.php?threadid=\$threadid&amp;threadview=0&amp;hilight=\$hilight&amp;hilightuser=\$hilightuser{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_THREAD_FLATTHREAD']}</a></span></td>
      </tr>
     </table>
    </td>
   </tr>
  </table></td>
 </tr>
</table>
<table style=\\\"width:{\$style['tableinwidth']}\\\">
 <tr>
  <td align=\\\"left\\\" valign=\\\"top\\\">\$boardjump</td>
  <td align=\\\"right\\\" valign=\\\"top\\\"><span class=\\\"smallfont\\\">\$newthread \$addreply</span></td>
 </tr>
</table>

\".((checkpermissions(\"can_rate_thread\")==1 && \$board['allowratings']==1 && !\$thread['isvoted']) 
 ? (\"
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  
  <tr>
   <td class=\\\"tablea\\\"><form action=\\\"threadrating.php\\\" method=\\\"post\\\"><table border=\\\"0\\\" cellspacing=\\\"0\\\" cellpadding=\\\"0\\\" align=\\\"center\\\" class=\\\"tablea_fc\\\">
                      <tr align=\\\"center\\\"> 
                        <td valign=\\\"bottom\\\" align=\\\"right\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_THREAD_THREADRATING']}</b>&nbsp;</span><span class=\\\"smallfont\\\"><br /><br />
                          {\$lang->items['LANG_THREAD_VERYPOOR']}&nbsp;<img src=\\\"{\$style['imagefolder']}/thumbs_down.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_THREAD_VERYPOOR']}\\\" title=\\\"{\$lang->items['LANG_THREAD_VERYPOOR']}\\\" />&nbsp;</span> 
                        </td>
                        <td style=\\\"background-color: \$colors[0]\\\"><span class=\\\"smallfont\\\"> 
                          <input type=\\\"radio\\\" name=\\\"rating\\\" value=\\\"1\\\" onclick=\\\"this.form.submit();\\\" />
                          <br />
                          1 </span></td>
                        <td style=\\\"background-color: \$colors[1]\\\"><span class=\\\"smallfont\\\"> 
                          <input type=\\\"radio\\\" name=\\\"rating\\\" value=\\\"2\\\" onclick=\\\"this.form.submit();\\\" />
                          <br />
                          2 </span></td>
                        <td style=\\\"background-color: \$colors[2]\\\"><span class=\\\"smallfont\\\"> 
                          <input type=\\\"radio\\\" name=\\\"rating\\\" value=\\\"3\\\" onclick=\\\"this.form.submit();\\\" />
                          <br />
                          3 </span></td>
                        <td style=\\\"background-color: \$colors[3]\\\"><span class=\\\"smallfont\\\"> 
                          <input type=\\\"radio\\\" name=\\\"rating\\\" value=\\\"4\\\" onclick=\\\"this.form.submit();\\\" />
                          <br />
                          4 </span></td>
                        <td style=\\\"background-color: \$colors[4]\\\"><span class=\\\"smallfont\\\"> 
                          <input type=\\\"radio\\\" name=\\\"rating\\\" value=\\\"5\\\" onclick=\\\"this.form.submit();\\\" />
                          <br />
                          5 </span></td>
                        <td style=\\\"background-color: \$colors[5]\\\"><span class=\\\"smallfont\\\"> 
                          <input type=\\\"radio\\\" name=\\\"rating\\\" value=\\\"6\\\" onclick=\\\"this.form.submit();\\\" />
                          <br />
                          6 </span></td>
                        <td style=\\\"background-color: \$colors[6]\\\"><span class=\\\"smallfont\\\"> 
                          <input type=\\\"radio\\\" name=\\\"rating\\\" value=\\\"7\\\" onclick=\\\"this.form.submit();\\\" />
                          <br />
                          7 </span></td>
                        <td style=\\\"background-color: \$colors[7]\\\"><span class=\\\"smallfont\\\"> 
                          <input type=\\\"radio\\\" name=\\\"rating\\\" value=\\\"8\\\" onclick=\\\"this.form.submit();\\\" />
                          <br />
                          8 </span></td>
                        <td style=\\\"background-color: \$colors[8]\\\"><span class=\\\"smallfont\\\"> 
                          <input type=\\\"radio\\\" name=\\\"rating\\\" value=\\\"9\\\" onclick=\\\"this.form.submit();\\\" />
                          <br />
                          9 </span></td>
                        <td style=\\\"background-color: \$colors[9]\\\"><span class=\\\"smallfont\\\"> 
                          <input type=\\\"radio\\\" name=\\\"rating\\\" value=\\\"10\\\" onclick=\\\"this.form.submit();\\\" />
                          <br />
                          10 </span></td>
                        <td align=\\\"left\\\" valign=\\\"bottom\\\"><span class=\\\"smallfont\\\">&nbsp;<img src=\\\"{\$style['imagefolder']}/thumbs_up.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_THREAD_VERYGOOD']}\\\" title=\\\"{\$lang->items['LANG_THREAD_VERYGOOD']}\\\" />&nbsp;{\$lang->items['LANG_THREAD_VERYGOOD']}</span></td>
                      </tr>
                    </table>
                    <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  <input type=\\\"hidden\\\" name=\\\"threadid\\\" value=\\\"\$threadid\\\" />
  <input type=\\\"hidden\\\" name=\\\"page\\\" value=\\\"{\$t->page}\\\" />
  </form></td>
  </tr>
   </table><br />
  \") : (\"\")
).\"
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\" align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a>\$navbar &raquo; </b>\".((\$thread['prefix']!=\"\") ? (\"<span class=\\\"prefix\\\">\$thread[prefix]</span> \") : (\"\")).\"<b>\$thread[topic]</b></span></td>
 </tr>
</table>

<table style=\\\"width:{\$style['tableinwidth']}\\\">
 <tr>
  <td align=\\\"right\\\">
   \".((checkmodpermissions()) 
    ? (\"
     <form action=\\\"modcp.php\\\" method=\\\"get\\\" name=\\\"modoption\\\">
      <select name=\\\"action\\\">
       <option value=\\\"-1\\\">{\$lang->items['LANG_THREAD_ADMINOPTIONS']}</option>
       \".((checkmodpermissions(\"m_can_thread_close\")) 
  	? (\"<option value=\\\"thread_close\\\">{\$lang->items['LANG_THREAD_THREADCLOSE']}</option>\") : (\"\")
       ).\"
       \".((checkmodpermissions(\"m_can_thread_move\")) 
  	? (\"<option value=\\\"thread_move\\\">{\$lang->items['LANG_THREAD_THREADMOVE']}</option>\") : (\"\")
       ).\"
       \".((checkmodpermissions(\"m_can_thread_edit\")) 
  	? (\"<option value=\\\"thread_edit\\\">{\$lang->items['LANG_THREAD_THREADEDIT']}</option>\") : (\"\")
       ).\"
       \".((checkmodpermissions(\"m_can_post_del\")) 
  	? (\"<option value=\\\"post_del\\\">{\$lang->items['LANG_THREAD_POSTDEL']}</option>\") : (\"\")
       ).\"
       \".((checkmodpermissions(\"m_can_thread_del\")) 
  	? (\"<option value=\\\"thread_del\\\">{\$lang->items['LANG_THREAD_THREADDEL']}</option>\") : (\"\")
       ).\"
       \".((checkmodpermissions(\"m_can_thread_merge\")) 
  	? (\"<option value=\\\"thread_merge\\\">{\$lang->items['LANG_THREAD_THREADMERGE']}</option>\") : (\"\")
       ).\"
       \".((checkmodpermissions(\"m_can_thread_cut\")) 
  	? (\"<option value=\\\"thread_cut\\\">{\$lang->items['LANG_THREAD_THREADCUT']}</option>\") : (\"\")
       ).\"
       \".((checkmodpermissions(\"m_can_thread_top\")) 
  	? (\"<option value=\\\"thread_top\\\">{\$lang->items['LANG_THREAD_THREADTOP']}</option>\") : (\"\")
       ).\"
       \".((checkmodpermissions(\"m_can_add_poll\")) 
  	? (\"<option value=\\\"polladd\\\">{\$lang->items['LANG_THREAD_POLLADD']}</option>\") : (\"\")
       ).\"
      </select>
      <input src=\\\"{\$style['imagefolder']}/go.gif\\\" type=\\\"image\\\" />
      <input type=\\\"hidden\\\" name=\\\"threadid\\\" value=\\\"\$threadid\\\" />
      <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
     </form>
    \") 
    : (\"
     \".((\$wbbuserdata['userid'] && \$wbbuserdata['userid']==\$thread['starterid'] && (checkpermissions(\"can_close_own_topic\")==1 || checkpermissions(\"can_del_own_topic\")==1 || checkpermissions(\"can_edit_own_topic\")==1 || checkpermissions(\"can_move_own_topic\")==1)) 
      ? (\"
       <form action=\\\"modcp.php\\\" method=\\\"get\\\" name=\\\"modoption\\\">
        <select name=\\\"action\\\">
         <option value=\\\"-1\\\">{\$lang->items['LANG_THREAD_OTHEROPTIONS']}</option>
         \".((checkpermissions(\"can_close_own_topic\")==1) 
  	  ? (\"<option value=\\\"thread_close\\\">{\$lang->items['LANG_THREAD_THREADCLOSE']}</option>\") : (\"\")
         ).\"
         \".((checkpermissions(\"can_move_own_topic\")==1) 
  	  ? (\"<option value=\\\"thread_move\\\">{\$lang->items['LANG_THREAD_THREADMOVE']}</option>\") : (\"\")
         ).\"
         \".((checkpermissions(\"can_edit_own_topic\")==1) 
  	  ? (\"<option value=\\\"thread_edit\\\">{\$lang->items['LANG_THREAD_THREADEDIT']}</option>\") : (\"\")
         ).\"
         \".((checkpermissions(\"can_del_own_topic\")==1) 
  	  ? (\"<option value=\\\"thread_del\\\">{\$lang->items['LANG_THREAD_THREADDEL']}</option>\") : (\"\")
         ).\"
        </select>
        <input src=\\\"{\$style['imagefolder']}/go.gif\\\" type=\\\"image\\\" />
        <input type=\\\"hidden\\\" name=\\\"threadid\\\" value=\\\"\$threadid\\\" />
        <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
       </form>
      \") : (\"\")
     ).\"
    \")
   ).\"
  </td>
 </tr>
</table>
\$footer

</body>
</html>";
			?>
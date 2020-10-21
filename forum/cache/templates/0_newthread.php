<?php
			/*
			templatepackid: 0
			templatename: newthread
			*/
			
			$this->templates['newthread']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | \$board[title] | {\$lang->items['LANG_POST_NEWTHREAD']}</title>
\$headinclude

<script type=\\\"text/javascript\\\">
<!--
var imageMaxWidth = \$picmaxwidth;
var imageMaxHeight = \$picmaxheight;
//-->
</script>
<script type=\\\"text/javascript\\\" src=\\\"js/images.js\\\"></script>
</head>

<body onload=\\\"resizeImages();\\\">
\$header
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a>\$navbar &raquo; {\$lang->items['LANG_POST_NEWTHREAD']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />\$preview_window \$newthread_error
<form action=\\\"newthread.php\\\" method=\\\"post\\\" name=\\\"bbform\\\" onsubmit=\\\"return validate(this)\\\" onreset=\\\"resetAppletText()\\\">
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POST_NEWTHREAD']}</b></span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_POST_USERNAME']}</span></td>
  <td class=\\\"tableb\\\">\$newthread_username</td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POST_TOPIC']}</b></span></td>
  <td class=\\\"tablea\\\">\$select_prefix<input class=\\\"input\\\" type=\\\"text\\\" name=\\\"topic\\\" value=\\\"\$topic\\\" size=\\\"40\\\" maxlength=\\\"100\\\" /></td>
 </tr>
 \$newthread_icons
 <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\" valign=\\\"top\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POST_MESSAGE']}</b></span><br /><br />
   <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\">
    <tr>
     <td align=\\\"left\\\" class=\\\"tableb\\\" nowrap=\\\"nowrap\\\"><span class=\\\"smallfont\\\">\$note</span></td>
    </tr>
   </table>
   <br />\$bbcode_smilies
  </td>
  <td class=\\\"tablea\\\"><table>
   <tr>
    <td align=\\\"center\\\">\$bbcode_buttons</td>
   </tr>
   <tr>
    <td align=\\\"left\\\">\$editor</td>
   </tr>
   <tr>
    <td align=\\\"left\\\">
     <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_POSTINGS_OPTIONS']}\\\" class=\\\"input\\\" onclick=\\\"toggleMenu('newthreadOptions', this);\\\" />
     \$attachment
     \".((checkpermissions(\"can_post_poll\")) 
      ? (\"
       <input type=\\\"button\\\" name=\\\"pollbutton\\\" value=\\\"{\$lang->items['LANG_POST_POLL']}\\\" class=\\\"input\\\" onclick='window.open(\\\"pollstart.php?boardid=\$boardid&idhash=\$idhash{\$SID_ARG_2ND_UN}\\\", \\\"moo\\\", \\\"toolbar=no,scrollbars=yes,resizable=yes,width=700,height=550\\\");' />
      \") : (\"\")
     ).\"
     \$editor_switch
    </td>
   </tr>
  </table>
  </td>
 </tr>
 \".((checkmodpermissions(\"m_can_announce\") || checkmodpermissions(\"m_can_thread_top\")) 
  ? (\"
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POST_CREATE_THREAD_AS']}</b></span></td>
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><input type=\\\"radio\\\" id=\\\"radio1\\\" name=\\\"important\\\" value=\\\"0\\\" \$imp_checked[0] /><label for=\\\"radio1\\\"> {\$lang->items['LANG_POST_IMPORTANT0']}</label>\".((checkmodpermissions(\"m_can_thread_top\")==1) ? (\" <input type=\\\"radio\\\" name=\\\"important\\\" id=\\\"radio2\\\" value=\\\"1\\\" \$imp_checked[1] /><label for=\\\"radio2\\\"> {\$lang->items['LANG_POST_IMPORTANT1']}</label>\") : (\"\")).\" \".((checkmodpermissions(\"m_can_announce\")==1) ? (\" <input type=\\\"radio\\\" name=\\\"important\\\" id=\\\"radio3\\\" value=\\\"2\\\" \$imp_checked[2] /><label for=\\\"radio3\\\"> {\$lang->items['LANG_POST_IMPORTANT2']}</label>\") : (\"\")).\"</span></td>
   </tr> 
  \") : (\"\")
 ).\"
</table>
<div id=\\\"newthreadOptions\\\" class=\\\"hoverMenu\\\">
 <ul class=\\\"smallfont\\\">
  <li><input type=\\\"checkbox\\\" id=\\\"checkbox1\\\" name=\\\"parseurl\\\" value=\\\"1\\\" \$checked[0] /><label for=\\\"checkbox1\\\"> {\$lang->items['LANG_POSTINGS_PARSEURL']}</label></li>
  \".((\$wbbuserdata['userid']) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox2\\\" name=\\\"emailnotify\\\" value=\\\"1\\\" \$checked[1] /><label for=\\\"checkbox2\\\"> {\$lang->items['LANG_POST_EMAILNOTIFY']}</label></li>\") : (\"\")).\"
  \".((checkpermissions(\"can_use_post_smilies\")==1) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox3\\\" name=\\\"disablesmilies\\\" value=\\\"1\\\" \$checked[2] /><label for=\\\"checkbox3\\\"> {\$lang->items['LANG_POSTINGS_DISABLESMILIES']}</label></li>\") : (\"\")).\"
  \".((checkpermissions(\"can_use_post_html\")==1) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox4\\\" name=\\\"disablehtml\\\" value=\\\"1\\\" \$checked[3] /><label for=\\\"checkbox4\\\"> {\$lang->items['LANG_POSTINGS_DISABLEHTML']}</label></li>\") : (\"\")).\"
  \".((checkpermissions(\"can_use_post_bbcode\")==1) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox5\\\" name=\\\"disablebbcode\\\" value=\\\"1\\\" \$checked[4] /><label for=\\\"checkbox5\\\"> {\$lang->items['LANG_POSTINGS_DISABLEBBCODE']}</label></li>\") : (\"\")).\"
  \".((checkpermissions(\"can_use_post_images\")==1) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox6\\\" name=\\\"disableimages\\\" value=\\\"1\\\" \$checked[5] /><label for=\\\"checkbox6\\\"> {\$lang->items['LANG_POSTINGS_DISABLEIMAGES']}</label></li>\") : (\"\")).\"
  <li><input type=\\\"checkbox\\\" id=\\\"checkbox7\\\" name=\\\"showsignature\\\" value=\\\"1\\\" \$checked[6] /><label for=\\\"checkbox7\\\"> {\$lang->items['LANG_POSTINGS_SHOWSIGNATURE']}</label></li>
  <li><input type=\\\"checkbox\\\" id=\\\"checkbox_checklength\\\" onclick=\\\"checklength(document.bbform); this.checked = false;\\\" value=\\\"0\\\" /><label for=\\\"checkbox_checklength\\\"><b> {\$lang->items['LANG_POSTINGS_CHECKLENGTH']}</b></label></li>
 </ul>
</div>  
<p align=\\\"center\\\">
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
 <input type=\\\"hidden\\\" name=\\\"boardid\\\" value=\\\"\$boardid\\\" />
 <input type=\\\"hidden\\\" name=\\\"idhash\\\" value=\\\"\$idhash\\\" />
 <input type=\\\"hidden\\\" name=\\\"attachmentids\\\" value=\\\"\$attachmentids\\\" />
 <input type=\\\"hidden\\\" name=\\\"change_editor\\\" value=\\\"\\\" />
 <input type=\\\"hidden\\\" name=\\\"usewysiwyg\\\" value=\\\"\$wbbuserdata[usewysiwyg]\\\" />
 \".((checkpermissions(\"can_post_poll\")) 
  ? (\"
   <input type=\\\"hidden\\\" name=\\\"poll_id\\\" value=\\\"\$poll_id\\\" />
  \") : (\"\")
 ).\"
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input class=\\\"input\\\" type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_POST_NEWTHREAD']}\\\" />
 <input class=\\\"input\\\" type=\\\"submit\\\" name=\\\"preview\\\" accesskey=\\\"P\\\" value=\\\"{\$lang->items['LANG_POSTINGS_PREVIEW']}\\\" />
 <input class=\\\"input\\\" type=\\\"reset\\\" accesskey=\\\"R\\\" value=\\\"{\$lang->items['LANG_POSTINGS_RESET']}\\\" />
</p>
</form>
\$footer

</body>
</html>";
			?>
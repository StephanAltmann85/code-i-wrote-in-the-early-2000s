<?php
			/*
			templatepackid: 0
			templatename: addreply
			*/
			
			$this->templates['addreply']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | \$board[title] | \$thread[topic] | {\$lang->items['LANG_POST_REPLY']}</title>
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
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a>\$navbar &raquo; </b>\".((\$thread['prefix']!=\"\") ? (\"<span class=\\\"prefix\\\">\$thread[prefix]</span> \") : (\"\")).\"<b> <a href=\\\"thread.php?threadid=\$threadid{\$SID_ARG_2ND}\\\">\$thread[topic]</a> &raquo; {\$lang->items['LANG_POST_REPLY']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />\$preview_window \$addreply_error
<form action=\\\"addreply.php\\\" method=\\\"post\\\" name=\\\"bbform\\\" onsubmit=\\\"return validate(this)\\\" onreset=\\\"resetAppletText()\\\">
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POST_REPLY']}</b></span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_POST_USERNAME']}</span></td>
  <td class=\\\"tableb\\\">\$newthread_username</td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_POST_TOPIC']}</span></td>
  <td class=\\\"tablea\\\"><input class=\\\"input\\\" type=\\\"text\\\" name=\\\"topic\\\" value=\\\"\$topic\\\" size=\\\"40\\\" maxlength=\\\"100\\\" /></td>
 </tr>
 \$newthread_icons
 <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\" valign=\\\"top\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POST_MESSAGE']}</b></span><br /><br />
   <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\">
    <tr>
     <td align=\\\"left\\\" class=\\\"tableb\\\" nowrap=\\\"nowrap\\\"><span class=\\\"smallfont\\\">\$note</span></td>
    </tr>
   </table><br />
   \$bbcode_smilies
  </td>
  <td class=\\\"tablea\\\"><table>
   <tr>
    <td align=\\\"center\\\">\$bbcode_buttons</td>
   </tr>
   <tr>
    <td align=\\\"left\\\">\$editor</td>
   </tr>
   <tr>
    <td>
     <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_POSTINGS_OPTIONS']}\\\" class=\\\"input\\\" onclick=\\\"toggleMenu('newthreadOptions', this);\\\" />
     \$attachment
     \$editor_switch
    </td>
   </tr>
  </table></td>
 </tr>
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
  \".((checkmodpermissions(\"m_can_thread_close\") || (\$wbbuserdata['userid'] && \$wbbuserdata['userid']==\$thread['starterid'] && checkpermissions(\"can_close_own_topic\")==1)) 
  ? (\"
  <li><input type=\\\"checkbox\\\" id=\\\"checkbox8\\\" name=\\\"threadclose\\\" value=\\\"1\\\" \$checked[7] /><label for=\\\"checkbox8\\\"> {\$lang->items['LANG_POSTINGS_THREADCLOSE']}</label></li>
  \") : (\"\")
  ).\" 
  <li><input type=\\\"checkbox\\\" id=\\\"checkbox_checklength\\\" onclick=\\\"checklength(document.bbform); this.checked = false;\\\" value=\\\"0\\\" /><label for=\\\"checkbox_checklength\\\"><b> {\$lang->items['LANG_POSTINGS_CHECKLENGTH']}</b></label></li>
 </ul>
</div>  
<p align=\\\"center\\\">
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
 <input type=\\\"hidden\\\" name=\\\"threadid\\\" value=\\\"\$threadid\\\" />
 <input type=\\\"hidden\\\" name=\\\"change_editor\\\" value=\\\"\\\" />
 <input type=\\\"hidden\\\" name=\\\"usewysiwyg\\\" value=\\\"\$wbbuserdata[usewysiwyg]\\\" />
 \".((isset(\$postid)) ? (\"<input type=\\\"hidden\\\" name=\\\"postid\\\" value=\\\"\$postid\\\" />\") : (\"\")).\"
 <input type=\\\"hidden\\\" name=\\\"idhash\\\" value=\\\"\$idhash\\\" />
 <input type=\\\"hidden\\\" name=\\\"attachmentids\\\" value=\\\"\$attachmentids\\\" />
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input class=\\\"input\\\" type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_POST_REPLY']}\\\" />
 <input class=\\\"input\\\" type=\\\"submit\\\" name=\\\"preview\\\" accesskey=\\\"P\\\" value=\\\"{\$lang->items['LANG_POSTINGS_PREVIEW']}\\\" />
 <input class=\\\"input\\\" type=\\\"reset\\\" accesskey=\\\"R\\\" value=\\\"{\$lang->items['LANG_POSTINGS_RESET']}\\\" />
</p></form>
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POST_LAST_X_POSTS']}</b></span></td>
 </tr>
 \$postbit
 \".((\$complete_thread==1) 
  ? (\"
   <tr align=\\\"left\\\">
    <td class=\\\"tabletitle\\\" colspan=\\\"2\\\"><span class=\\\"smallfont\\\">{\$lang->items['LANG_POST_MORE_POSTS']}</span></td>
   </tr>
  \") : (\"\")
 ).\"
</table>
\$footer
</body>
</html>";
			?>
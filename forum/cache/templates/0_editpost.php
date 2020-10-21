<?php
			/*
			templatepackid: 0
			templatename: editpost
			*/
			
			$this->templates['editpost']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | \$board[title] | \$thread[topic] | {\$lang->items['LANG_POST_EDITPOST']}</title>
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
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a>\$navbar &raquo; </b>\".((\$thread['prefix']!=\"\") ? (\"<span class=\\\"prefix\\\">\$thread[prefix]</span> \") : (\"\")).\"<b> <a href=\\\"thread.php?threadid=\$threadid{\$SID_ARG_2ND}\\\">\$thread[topic]</a> &raquo; {\$lang->items['LANG_POST_EDITPOST']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />
\$preview_window
\$editpost_error
\".(((\$isuser==1 && checkpermissions(\"can_del_own_post\")==1) || checkmodpermissions(\"m_can_post_del\")==1) 
? (\"
<form action=\\\"editpost.php\\\" method=\\\"post\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send2\\\" />
<input type=\\\"hidden\\\" name=\\\"postid\\\" value=\\\"\$postid\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" colspan=\\\"3\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POST_DELETE']}</b></span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><input type=\\\"checkbox\\\" id=\\\"checkbox_del\\\" name=\\\"deletepost\\\" value=\\\"1\\\" /><label for=\\\"checkbox_del\\\"> <b>{\$lang->items['LANG_POST_DELETE_CHECKBOX']}</b></label></span></td>
  <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_POST_DELETE_DESC']}</span></td>
  <td class=\\\"tableb\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_POST_DELETE']}\\\" class=\\\"input\\\" /></td>
 </tr>
</table><br /></form>
\") : (\"\")
).\"
\".(((\$isuser==1 && checkpermissions(\"can_edit_own_post\")==1) || checkmodpermissions(\"m_can_post_edit\")==1) 
? (\"
<form action=\\\"editpost.php\\\" method=\\\"post\\\" name=\\\"bbform\\\" onsubmit=\\\"return validate(this)\\\" onreset=\\\"resetAppletText()\\\">
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" colspan=\\\"2\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POST_EDITPOST']}</b></span></td>
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
  <td class=\\\"tablea\\\" valign=\\\"top\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POST_MESSAGE']}</b></span>
   <br /><br /><table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\">
    <tr>
     <td align=\\\"left\\\" class=\\\"tableb\\\" nowrap=\\\"nowrap\\\"><span class=\\\"smallfont\\\">\$note</span></td>
    </tr>
   </table>
   <br />\$bbcode_smilies
  </td>
  <td class=\\\"tablea\\\" align=\\\"left\\\"><table>
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
  \".((\$wbbuserdata['dont_append_editnote']==1) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox8\\\" name=\\\"dont_append_editnote\\\" value=\\\"1\\\" \$checked[7] /><label for=\\\"checkbox8\\\"> {\$lang->items['LANG_POST_DONT_APPEND_EDITNOTE']}</label></li>\") : (\"\")).\"
  <li><input type=\\\"checkbox\\\" id=\\\"checkbox_checklength\\\" onclick=\\\"checklength(document.bbform); this.checked = false;\\\" value=\\\"0\\\" /><label for=\\\"checkbox_checklength\\\"><b> {\$lang->items['LANG_POSTINGS_CHECKLENGTH']}</b></label></li>
 </ul>
 \".((\$wbbuserdata['dont_append_editnote']!=1) ? (\"<input type=\\\"hidden\\\" name=\\\"dont_append_editnote\\\" value=\\\"0\\\" />\") : (\"\")).\"
</div>
<p align=\\\"center\\\">
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
 <input type=\\\"hidden\\\" name=\\\"postid\\\" value=\\\"\$postid\\\" />
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input type=\\\"hidden\\\" name=\\\"attachmentids\\\" value=\\\"\$attachmentids\\\" />
 <input type=\\\"hidden\\\" name=\\\"change_editor\\\" value=\\\"\\\" />
 <input type=\\\"hidden\\\" name=\\\"usewysiwyg\\\" value=\\\"\$wbbuserdata[usewysiwyg]\\\" />
 <input class=\\\"input\\\" type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_POST_SAVEPOST']}\\\" />
 <input class=\\\"input\\\" type=\\\"submit\\\" name=\\\"preview\\\" accesskey=\\\"P\\\" value=\\\"{\$lang->items['LANG_POSTINGS_PREVIEW']}\\\" />
 <input class=\\\"input\\\" type=\\\"reset\\\" accesskey=\\\"R\\\" value=\\\"{\$lang->items['LANG_POSTINGS_RESET']}\\\" />
</p></form>
\") : (\"\")
).\"
\$footer
</body>
</html>";
			?>
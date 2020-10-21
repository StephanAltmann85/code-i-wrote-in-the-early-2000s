<?php
			/*
			templatepackid: 0
			templatename: pms_newpm
			*/
			
			$this->templates['pms_newpm']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']} | {\$lang->items['LANG_GLOBAL_PMS']} | {\$lang->items['LANG_PMS_CREATE_PM']}</title>
\$headinclude
<script type=\\\"text/javascript\\\">
<!--
function expandTextarea(textarea) {
 var length = textarea.value.length - 1;
 if (textarea.value.charAt(length) == \\\"\\\\n\\\") { 
  var rows = textarea.rows;
  if (rows < 3) {
   textarea.rows=textarea.rows + 1;
  }
 }
}
function sendToBuddies() {
 document.bbform.recipients.value = '{\$sendToBuddies}';
 expandTextarea(document.bbform.recipients);
}
//-->
</script>
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
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"usercp.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_TITLE']}</a> &raquo; <a href=\\\"pms.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_GLOBAL_PMS']}</a> &raquo; {\$lang->items['LANG_PMS_CREATE_PM']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />
\".((isset(\$_POST['preview'])) 
 ? (\"<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
  <tr>
   <td class=\\\"tabletitle\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POSTINGS_PREVIEW']}</b></span></td>
  </tr>
  <tr align=\\\"left\\\" class=\\\"normalfont\\\">
   <td class=\\\"tableb\\\"><b>\$preview_posticon&nbsp;\$preview_subject</b><br /><br />
   \$preview_message</td>
  </tr>
 </table>
 <br />\") : (\"\")
).\"
 \$pm_error
 <form action=\\\"pms.php\\\" method=\\\"post\\\" name=\\\"bbform\\\" onsubmit=\\\"return validate(this)\\\" onreset=\\\"resetAppletText()\\\">
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_PMS_CREATE_PM']}</b></span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\" valign=\\\"top\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_PMS_RECIPIENTS']}</b></span>
   <br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_PMS_RECIPIENTS_NOTE']} {\$LANG_PMS_MAX_RECIPIENTS}</span>
  </td>
  <td class=\\\"tablea\\\" valign=\\\"top\\\">
   <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\">
    <tr valign=\\\"top\\\">
     <td><textarea name=\\\"recipients\\\" rows=\\\"\".((\$wbbuserdata['max_pms_recipients'] == -1 || \$wbbuserdata['max_pms_recipients'] > 1) ? (\"2\") : (\"1\")).\"\\\" cols=\\\"40\\\" onkeyup=\\\"expandTextarea(this);\\\">\$recipients</textarea></td>
     <td><div style=\\\"margin-left: 5px\\\"><span class=\\\"smallfont\\\"><a href=\\\"#\\\" onclick='window.open(\\\"misc.php?action=finduser{\$SID_ARG_2ND}\\\", \\\"moo\\\", \\\"toolbar=no,scrollbars=yes,resizable=yes,width=300,height=180\\\"); return false;'>{\$lang->items['LANG_PMS_FIND_USER']}</a>
     \".((\$wbbuserdata['buddylist'] != '') ? (\"<br /><a href=\\\"#\\\" onclick='sendToBuddies(); return false;'>{\$lang->items['LANG_PMS_SEND_TO_BUDDIES']}</a>\") : (\"\")).\"
     </span></div></td>
    </tr>
   </table>
  </td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tableb\\\" valign=\\\"top\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_PMS_RECIPIENTS_BCC']}</b></span>
  <br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_PMS_RECIPIENTS_NOTE']}</span></td>
  <td class=\\\"tableb\\\" valign=\\\"top\\\"><textarea name=\\\"recipients_bcc\\\" rows=\\\"2\\\" cols=\\\"40\\\" onkeyup=\\\"expandTextarea(this);\\\">\$recipients_bcc</textarea></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_PMS_SUBJECT']}</b></span></td>
  <td class=\\\"tablea\\\"><input class=\\\"input\\\" type=\\\"text\\\" name=\\\"subject\\\" value=\\\"\$subject\\\" size=\\\"40\\\" maxlength=\\\"100\\\" /></td>
 </tr>
 \$pm_icons
 <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\" valign=\\\"top\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_PMS_MESSAGE']}</b></span>
   <br /><br /><table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\">
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
  \".((\$wbbuserdata['can_use_pn_smilies']==1) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox2\\\" name=\\\"disablesmilies\\\" value=\\\"1\\\" \$checked[1] /><label for=\\\"checkbox2\\\"> {\$lang->items['LANG_POSTINGS_DISABLESMILIES']}</label></li>\") : (\"\")).\"
  \".((\$wbbuserdata['can_use_pn_html']==1) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox3\\\" name=\\\"disablehtml\\\" value=\\\"1\\\" \$checked[2] /><label for=\\\"checkbox3\\\"> {\$lang->items['LANG_POSTINGS_DISABLEHTML']}</label></li>\") : (\"\")).\"
  \".((\$wbbuserdata['can_use_pn_bbcode']==1) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox4\\\" name=\\\"disablebbcode\\\" value=\\\"1\\\" \$checked[3] /><label for=\\\"checkbox4\\\"> {\$lang->items['LANG_POSTINGS_DISABLEBBCODE']}</label></li>\") : (\"\")).\"
  \".((\$wbbuserdata['can_use_pn_images']==1) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox5\\\" name=\\\"disableimages\\\" value=\\\"1\\\" \$checked[4] /><label for=\\\"checkbox5\\\"> {\$lang->items['LANG_POSTINGS_DISABLEIMAGES']}</label></li>\") : (\"\")).\"
  <li><input type=\\\"checkbox\\\" id=\\\"checkbox6\\\" name=\\\"showsignature\\\" value=\\\"1\\\" \$checked[5] /><label for=\\\"checkbox6\\\"> {\$lang->items['LANG_POSTINGS_SHOWSIGNATURE']}</label></li>
  <li><input type=\\\"checkbox\\\" id=\\\"checkbox7\\\" name=\\\"savecopy\\\" value=\\\"1\\\" \$checked[6] /><label for=\\\"checkbox7\\\"> {\$lang->items['LANG_PMS_SAVE_COPY']}</label></li>
  <li><input type=\\\"checkbox\\\" id=\\\"checkbox8\\\" name=\\\"tracking\\\" value=\\\"1\\\" \$checked[7] /><label for=\\\"checkbox8\\\"> {\$lang->items['LANG_PMS_TRACKING_ON']}</label></li>
  <li><input type=\\\"checkbox\\\" id=\\\"checkbox_checklength\\\" onclick=\\\"checklength(document.bbform); this.checked = false;\\\" value=\\\"0\\\" /><label for=\\\"checkbox_checklength\\\"><b> {\$lang->items['LANG_POSTINGS_CHECKLENGTH']}</b></label></li>
 </ul>
</div>  
<p align=\\\"center\\\">
 <input type=\\\"hidden\\\" name=\\\"pmid\\\" value=\\\"\$pmid\\\" />
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
 <input type=\\\"hidden\\\" name=\\\"attachmentids\\\" value=\\\"\$attachmentids\\\" />
 <input type=\\\"hidden\\\" name=\\\"idhash\\\" value=\\\"\$idhash\\\" />
 <input type=\\\"hidden\\\" name=\\\"change_editor\\\" value=\\\"\\\" />
 <input type=\\\"hidden\\\" name=\\\"usewysiwyg\\\" value=\\\"\$wbbuserdata[usewysiwyg]\\\" />
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input class=\\\"input\\\" type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_PMS_SUBMIT']}\\\" />
 <input class=\\\"input\\\" type=\\\"submit\\\" name=\\\"preview\\\" accesskey=\\\"P\\\" value=\\\"{\$lang->items['LANG_POSTINGS_PREVIEW']}\\\" />
 <input class=\\\"input\\\" type=\\\"reset\\\" accesskey=\\\"R\\\" value=\\\"{\$lang->items['LANG_POSTINGS_RESET']}\\\" />
</p></form>
\$footer
</body>
</html>";
			?>
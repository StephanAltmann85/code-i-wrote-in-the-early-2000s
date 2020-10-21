<?php
			/*
			templatepackid: 0
			templatename: usercp_signature_edit
			*/
			
			$this->templates['usercp_signature_edit']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
 <head>
  <title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']} | {\$lang->items['LANG_USERCP_SIGNATURE_EDIT']}</title>
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
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"usercp.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_TITLE']}</a> &raquo; {\$lang->items['LANG_USERCP_SIGNATURE_EDIT']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />\$usercp_error

  \".((\$old_signature!=\"\") 
   ? (\"
    <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:{\$style['tableinwidth']}\\\">
     <tr>
      <td class=\\\"tabletitle\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_SIGNATURE_OLD']}</b></span></td>
     </tr>
     <tr class=\\\"normalfont\\\">
      <td align=\\\"left\\\" class=\\\"tableb\\\">\$old_signature</td>				
     </tr>
    </table><br />
   \") : (\"\")
  ).\"
  
  \".((\$preview_signature!=\"\") 
   ? (\"
    <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:{\$style['tableinwidth']}\\\">
     <tr>
      <td class=\\\"tabletitle\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_POSTINGS_PREVIEW']}</b></span></td>
     </tr>
     <tr class=\\\"normalfont\\\">
      <td align=\\\"left\\\" class=\\\"tableb\\\">\$preview_signature</td>				
     </tr>
    </table><br />
   \") : (\"\")
  ).\"

<form action=\\\"usercp.php\\\" method=\\\"post\\\" name=\\\"bbform\\\" onsubmit=\\\"return validate(this)\\\" onreset=\\\"resetAppletText()\\\">
  
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
   <tr>
    <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_SIGNATURE_TITLE']}</b></span></td>
   </tr>
   <tr>
    <td class=\\\"tablea\\\" align=\\\"left\\\" valign=\\\"top\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_SIGNATURE']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_USERCP_SIGNATURE_DESC']}</span><br /><br /><table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\">
     <tr>
      <td align=\\\"left\\\" class=\\\"tableb\\\" nowrap=\\\"nowrap\\\"><span class=\\\"smallfont\\\">\$note</span></td>
     </tr>
    </table><br />
    \$bbcode_smilies
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
       \$editor_switch
      </td>
     </tr>
    </table></td>
   </tr>
  </table>
  <div id=\\\"newthreadOptions\\\" class=\\\"hoverMenu\\\">
   <ul class=\\\"smallfont\\\">
    \".((\$wbbuserdata['can_use_sig_smilies']==1) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox1\\\" name=\\\"disablesmilies\\\" value=\\\"1\\\" \$checked[0] /><label for=\\\"checkbox1\\\"> {\$lang->items['LANG_REGISTER_DISABLESMILIES']}</label></li>\") : (\"\")).\"
    \".((\$wbbuserdata['can_use_sig_html']==1) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox2\\\" name=\\\"disablehtml\\\" value=\\\"1\\\" \$checked[1] /><label for=\\\"checkbox2\\\"> {\$lang->items['LANG_REGISTER_DISABLEHTML']}</label></li>\") : (\"\")).\"
    \".((\$wbbuserdata['can_use_sig_bbcode']==1) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox3\\\" name=\\\"disablebbcode\\\" value=\\\"1\\\" \$checked[2] /><label for=\\\"checkbox3\\\"> {\$lang->items['LANG_REGISTER_DISABLEBBCODE']}</label></li>\") : (\"\")).\"
    \".((\$wbbuserdata['can_use_sig_images']==1) ? (\"<li><input type=\\\"checkbox\\\" id=\\\"checkbox4\\\" name=\\\"disableimages\\\" value=\\\"1\\\" \$checked[3] /><label for=\\\"checkbox4\\\"> {\$lang->items['LANG_REGISTER_DISABLEIMAGES']}</label></li>\") : (\"\")).\"
    <li><input type=\\\"checkbox\\\" id=\\\"checkbox_checklength\\\" onclick=\\\"checklength(document.bbform); this.checked = false;\\\" value=\\\"0\\\" /><label for=\\\"checkbox_checklength\\\"><b> {\$lang->items['LANG_USERCP_SIGNATURE_CHECKLENGTH']}</b></label></li>
   </ul>
  </div>   
  <p align=\\\"center\\\"><input class=\\\"input\\\" type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_POSTINGS_SAVE']}\\\" /> <input class=\\\"input\\\" type=\\\"submit\\\" accesskey=\\\"P\\\" name=\\\"preview\\\" value=\\\"{\$lang->items['LANG_POSTINGS_PREVIEW']}\\\" /> <input class=\\\"input\\\" type=\\\"reset\\\" accesskey=\\\"R\\\" value=\\\"{\$lang->items['LANG_POSTINGS_RESET']}\\\" /></p>
   <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
   <input type=\\\"hidden\\\" name=\\\"change_editor\\\" value=\\\"\\\" />
   <input type=\\\"hidden\\\" name=\\\"usewysiwyg\\\" value=\\\"\$wbbuserdata[usewysiwyg]\\\" />
   <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
   <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  </form>
  \$footer
 </body>
</html>";
			?>
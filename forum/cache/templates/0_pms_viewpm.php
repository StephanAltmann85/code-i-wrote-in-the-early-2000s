<?php
			/*
			templatepackid: 0
			templatename: pms_viewpm
			*/
			
			$this->templates['pms_viewpm']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
 <head>
  <title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']} | {\$lang->items['LANG_GLOBAL_PMS']}: \$pm[title] | \$pm[subject]</title>
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
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"usercp.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_TITLE']}</a> &raquo; <a href=\\\"pms.php?folderid=\$pm[folderid]{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_GLOBAL_PMS']}: \$pm[title]</a> &raquo; \$pm[subject]</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table>
<table style=\\\"width:{\$style['tableinwidth']}\\\">
 <tr>
  <td align=\\\"center\\\"><a href=\\\"pms.php?action=newpm{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/newpm.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_PMS_CREATE_NEWPM']}\\\" title=\\\"{\$lang->items['LANG_PMS_CREATE_NEWPM']}\\\" /></a>
  \".((\$pm['userid'] > 0) ? (\"<a href=\\\"pms.php?action=replypm&amp;pmid=\$pmid{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/replypm.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_PMS_REPLY']}\\\" title=\\\"{\$lang->items['LANG_PMS_REPLY']}\\\" /></a>\") : (\"\")).\"
  <a href=\\\"pms.php?action=forwardpm&amp;pmid=\$pmid{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/forwardpm.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_PMS_FORWARD']}\\\" title=\\\"{\$lang->items['LANG_PMS_FORWARD']}\\\" /></a>
  <a href=\\\"pms.php?action=downloadpm&amp;pmid=\$pmid{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/downloadpm.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_PMS_SAVE_AS']}\\\" title=\\\"{\$lang->items['LANG_PMS_SAVE_AS']}\\\" /></a>
  <a href=\\\"pms.php?action=printpm&amp;pmid=\$pmid{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/printpm.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_PMS_PRINT_PREVIEW']}\\\" title=\\\"{\$lang->items['LANG_PMS_PRINT_PREVIEW']}\\\" /></a>
  <a href=\\\"pms.php?action=deletepm&amp;pmid=\$pmid{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/deletepm.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_PMS_DELETE_PM']}\\\" title=\\\"{\$lang->items['LANG_PMS_DELETE_PM']}\\\" /></a></td>
 </tr>
</table>
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_PMS_MESSAGE_FROM_USER']}</b></span></td>
 </tr>
 <tr align=\\\"left\\\" class=\\\"normalfont\\\">
  <td class=\\\"tablea\\\">
  \$icon <b>\$pm[subject]</b>
  <br /><br />
  \$pm[message]
  \$attachments
  \$signature
  </td>
 </tr>
 \".((\$recipients != '') ? (\"
 <tr align=\\\"left\\\" class=\\\"normalfont\\\">
  <td class=\\\"tableb\\\">
   {\$lang->items['LANG_PMS_MESSAGE_FURTHER_RECIPIENTS']}
  </td>
 </tr>
 \") : (\"\")).\"
</table>
<table style=\\\"width:{\$style['tableinwidth']}\\\">
 <tr>
  <td align=\\\"center\\\"><a href=\\\"pms.php?action=newpm{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/newpm.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_PMS_CREATE_NEWPM']}\\\" title=\\\"{\$lang->items['LANG_PMS_CREATE_NEWPM']}\\\" /></a>
  \".((\$pm['userid'] > 0) ? (\"<a href=\\\"pms.php?action=replypm&amp;pmid=\$pmid{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/replypm.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_PMS_REPLY']}\\\" title=\\\"{\$lang->items['LANG_PMS_REPLY']}\\\" /></a>\") : (\"\")).\"
  <a href=\\\"pms.php?action=forwardpm&amp;pmid=\$pmid{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/forwardpm.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_PMS_FORWARD']}\\\" title=\\\"{\$lang->items['LANG_PMS_FORWARD']}\\\" /></a>
  <a href=\\\"pms.php?action=downloadpm&amp;pmid=\$pmid{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/downloadpm.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_PMS_SAVE_AS']}\\\" title=\\\"{\$lang->items['LANG_PMS_SAVE_AS']}\\\" /></a>
  <a href=\\\"pms.php?action=printpm&amp;pmid=\$pmid{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/printpm.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_PMS_PRINT_PREVIEW']}\\\" title=\\\"{\$lang->items['LANG_PMS_PRINT_PREVIEW']}\\\" /></a>
  <a href=\\\"pms.php?action=deletepm&amp;pmid=\$pmid{\$SID_ARG_2ND}\\\"><img src=\\\"{\$style['imagefolder']}/deletepm.gif\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_PMS_DELETE_PM']}\\\" title=\\\"{\$lang->items['LANG_PMS_DELETE_PM']}\\\" /></a></td>
 </tr>
</table>
\$footer
</body>
</html>";
			?>
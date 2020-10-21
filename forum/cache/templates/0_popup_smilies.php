<?php
			/*
			templatepackid: 0
			templatename: popup_smilies
			*/
			
			$this->templates['popup_smilies']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_MISC_MORESMILIES_TITLE']}</title>
\$headinclude
<script type=\\\"text/javascript\\\">
<!--
function smilie(smilietext) {
 opener.smilie(smilietext);
 //opener.document.bbform.message.focus();
}
//-->
</script>
</head>

<body>
<table cellpadding=\\\"8\\\" cellspacing=\\\"{\$style['tableoutcellspacing']}\\\" align=\\\"center\\\" border=\\\"{\$style['tableoutborder']}\\\" class=\\\"tableoutborder\\\" style=\\\"width:100%\\\">
 <tr><td class=\\\"mainpage\\\" align=\\\"center\\\"><table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:100%\\\" class=\\\"tableinborder\\\">
  <tr>
   <td class=\\\"tabletitle\\\" colspan=\\\"4\\\" align=\\\"left\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MISC_MORESMILIES_TITLE']}</b></span><br /><span class=\\\"smallfont\\\">{\$lang->items['LANG_MISC_MORESMILIES_DESC']}</span></td>
  </tr>
  \$popup_smiliesbits
  <tr>
   <td class=\\\"tabletitle\\\" colspan=\\\"4\\\" align=\\\"center\\\"><span class=\\\"smallfont\\\"><a href=\\\"javascript:self.close()\\\">{\$lang->items['LANG_MISC_WINDOW_CLOSE']}</a></span></td>
  </tr>
 </table></td></tr>
</table>
</body>
</html>";
			?>
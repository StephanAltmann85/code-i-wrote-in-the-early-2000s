<?php
			/*
			templatepackid: 0
			templatename: pmpopup
			*/
			
			$this->templates['pmpopup']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_GLOBAL_PMS']}</title>
\$headinclude
<script type=\\\"text/javascript\\\">
<!--
function toOpener(url) {
 opener.location.href=url;
 opener.document.focus();
}

function goToInbox() {
 toOpener('pms.php{\$SID_ARG_1ST}');
 self.close();
}
//-->
</script>
</head>

<body>
<table cellpadding=\\\"8\\\" cellspacing=\\\"{\$style['tableoutcellspacing']}\\\" align=\\\"center\\\" border=\\\"{\$style['tableoutborder']}\\\" class=\\\"tableoutborder\\\" style=\\\"width:100%\\\">
 <tr><td class=\\\"mainpage\\\" align=\\\"center\\\"><table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:100%\\\" class=\\\"tableinborder\\\">
  <tr>
   <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"4\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_PMS_POPUP_NEWMESSAGE']}</b></span></td>
  </tr> 
  \$pmbit
  <tr>
   <td class=\\\"tableb\\\" colspan=\\\"4\\\" align=\\\"center\\\"><input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_PMS_POPUP_GOTO_INBOX']}\\\" class=\\\"input\\\" onclick=\\\"javascript:goToInbox();\\\" /> <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_PMS_POPUP_CANCEL']}\\\" class=\\\"input\\\" onclick=\\\"javascript:self.close();\\\" /></td>
  </tr>
 </table></td></tr>
</table>
</body>
</html>";
			?>
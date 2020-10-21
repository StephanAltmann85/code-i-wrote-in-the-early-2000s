<?php
			/*
			templatepackid: 0
			templatename: pms_deletepm
			*/
			
			$this->templates['pms_deletepm']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']} | {\$lang->items['LANG_GLOBAL_PMS']} | {\$lang->items['LANG_PMS_DELETE_PM']}</title>
\$headinclude
</head>

<body>
\$header
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a>\$navbar &raquo; <a href=\\\"usercp.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_TITLE']}</a> &raquo; <a href=\\\"pms.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_GLOBAL_PMS']}</a> &raquo; {\$lang->items['LANG_PMS_DELETE_PM']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br /><form action=\\\"pms.php\\\" method=\\\"post\\\">
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
 <input type=\\\"hidden\\\" name=\\\"outbox\\\" value=\\\"\$outbox\\\" />
 <input type=\\\"hidden\\\" name=\\\"pmid\\\" value=\\\"\$pmid\\\" />
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_PMS_DELETE_PM']}</b></span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td style=\\\"width:50%\\\" class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_PMS_DELETE_SURE']}</b></span></td>
  <td style=\\\"width:50%\\\" class=\\\"tableb\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_PMS_YES']}\\\" class=\\\"input\\\" /> <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_PMS_NO']}\\\" onclick=\\\"history.back();\\\" class=\\\"input\\\" /></td>
 </tr>
</table></form>
\$footer
</body>
</html>";
			?>
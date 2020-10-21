<?php
			/*
			templatepackid: 0
			templatename: wiw
			*/
			
			$this->templates['wiw']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_WIW_TITLE']}</title>
\$headinclude

\".((\$wiw_autorefresh > 0) ? (\"<meta http-equiv=\\\"refresh\\\" content=\\\"\$wiw_autorefresh; url=wiw.php?sortby=\$_GET[sortby]&order=\$_GET[order]{\$SID_ARG_2ND_UN}\\\" />\") : (\"\")).\"

</head>
<body>
\$header
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; {\$lang->items['LANG_WIW_TITLE']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />
<form method=\\\"get\\\" action=\\\"wiw.php\\\">
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_WIW_USERNAME']}</b></span></td>
  \".((\$wbbuserdata['a_can_view_ipaddress']==1) 
  ? (\"
  <td class=\\\"tabletitle\\\" nowrap=\\\"nowrap\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_WIW_IPADDRESS']}</b></span></td>
  <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_WIW_USERAGENT']}</b></span></td>
  \") : (\"\")
  ).\"
  <td class=\\\"tabletitle\\\" nowrap=\\\"nowrap\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_WIW_LASTACTIVITY']}</b></span></td>
  <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_WIW_REQUEST_URI']}</b></span></td>
 </tr>
 \$useronline
 <tr>
  <td class=\\\"tablea\\\" align=\\\"center\\\" colspan=\\\"\".((\$wbbuserdata['a_can_view_ipaddress']==1) ? (\"5\") : (\"3\")).\"\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_WIW_SORTOPTIONS']}
  <input src=\\\"{\$style['imagefolder']}/go.gif\\\" type=\\\"image\\\" />
  <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  </span></td>
 </tr>
</table>
</form>
\$footer
</body>
</html>";
			?>
<?php
			/*
			templatepackid: 12
			templatename: locator_popup_show
			*/
			
			$this->templates['locator_popup_show']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_LOCATOR_TITLE']}</title>
\$headinclude
</head>

<body>
\".((\$_REQUEST[action] == \"show\") ? (\"<div id=\\\"overDiv\\\" style=\\\"position:absolute; visibility:hidden; z-index:1000;\\\"></div>
<script language=\\\"JavaScript\\\" src=\\\"overlib.js\\\"><!-- overLIB (c) Erik Bosrup --></script> 

<img name=\\\"locator\\\" style=\\\"cursor:pointer;\\\" src=\\\"locator.php?action=image&id=\$_REQUEST[id]\\\" border=\\\"0\\\" alt=\\\"\\\" usemap=\\\"#locator\\\">
<map name=\\\"locator\\\">
 \$locator_imagemap_bit
</map>\") : (\"\")).\"

\".((\$_REQUEST[action] == \"get_user\") ? (\"
<table style=\\\"width:100%; height: 100%;\\\">
<tr>
 <td valign=\\\"middle\\\" align=\\\"center\\\">

 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:300\\\">
 <tr class=\\\"tabletitle\\\">
  <td align=\\\"left\\\" colspan=\\\"4\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_LOCATOR_TITLE']}</b></span></td>
 </tr>
 <tr>
  <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_LOCATOR_USERNAME']}:</b></span></td>
  <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_LOCATOR_POSTS']}:</b></span></td>
  <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_LOCATOR_POSTCODE']}:</b></span></td>
  <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_LOCATOR_RESIDENCE']}:</b></span></td>
 </tr>
 \$locator_get_user_bit 
 </table><br /><br />

<span class=\\\"smallfont\\\"><a href=\\\"javascript:self.close()\\\">{\$lang->items['LANG_LOCATOR_POPUP_CLOSE']}</a></span>

 </td>
</tr>
</table>
\") : (\"\")).\"


</body>
</html>";
			?>
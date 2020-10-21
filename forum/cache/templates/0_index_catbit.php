<?php
			/*
			templatepackid: 0
			templatename: index_catbit
			*/
			
			$this->templates['index_catbit']="\".((\$depth == 1) 
 ? (\"
 
 <tr>
 <td class=\\\"tablecat\\\" align=\\\"left\\\" colspan=\\\"\".((\$hide_modcell==0) ? (\"6\") : (\"5\")).\"\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\">
  <tr class=\\\"tablecat_fc\\\">
   <td><span class=\\\"normalfont\\\">&nbsp;\".((\$show_hide == 1) ? (\"<a href=\\\"\$current_url\\\"><img src=\\\"{\$style['imagefolder']}/minus.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_START_DEACTIVATE_CAT}\\\" title=\\\"{\$LANG_START_DEACTIVATE_CAT}\\\" /></a>\") : (\"\".((\$show_hide == 2) ? (\"<a href=\\\"\$current_url\\\"><img src=\\\"{\$style['imagefolder']}/plus.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_START_SHOWCAT}\\\" title=\\\"{\$LANG_START_SHOWCAT}\\\" /></a>\") : (\"\")).\"\")).\"&nbsp;</span></td>
   <td><span class=\\\"normalfont\\\"><a href=\\\"board.php?boardid=\$boards[boardid]{\$SID_ARG_2ND}\\\"><b>\$boards[title]</b></a></span><span class=\\\"smallfont\\\">\".((\$boards['description']!=\"\") ? (\"<br />\$boards[description]\") : (\"\")).\"\".((\$subboardbit!=\"\") ? (\"<br />{\$lang->items['LANG_START_INCLUSIVE']} \$subboardbit\") : (\"\")).\"</span></td>
  </tr>
 </table></td>
</tr>
 
 \") 
  : (\"
  
  \".((\$depth == 2) 
   ? (\"
 
 <tr>
 <td class=\\\"tableb\\\" align=\\\"center\\\"><img src=\\\"{\$style['imagefolder']}/\$onoff.gif\\\" alt=\\\"\\\" title=\\\"\\\" border=\\\"0\\\" /></td>
 <td class=\\\"tablecat\\\" colspan=\\\"\".((\$hide_modcell==0) ? (\"5\") : (\"4\")).\"\\\" align=\\\"left\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\">
  <tr class=\\\"tablecat_fc\\\">
   <td><span class=\\\"normalfont\\\">&nbsp;\".((\$show_hide == 1) ? (\"<a href=\\\"\$current_url\\\"><img src=\\\"{\$style['imagefolder']}/minus.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_START_DEACTIVATE_CAT}\\\" title=\\\"{\$LANG_START_DEACTIVATE_CAT}\\\" /></a>\") : (\"\".((\$show_hide == 2) ? (\"<a href=\\\"\$current_url\\\"><img src=\\\"{\$style['imagefolder']}/plus.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_START_SHOWCAT}\\\" title=\\\"{\$LANG_START_SHOWCAT}\\\" /></a>\") : (\"\")).\"\")).\"&nbsp;</span></td>
   <td><span class=\\\"normalfont\\\"><a href=\\\"board.php?boardid=\$boards[boardid]{\$SID_ARG_2ND}\\\"><b>\$boards[title]</b></a></span><span class=\\\"smallfont\\\">\".((\$boards['description']!=\"\") ? (\"<br />\$boards[description]\") : (\"\")).\"\".((\$subboardbit!=\"\") ? (\"<br />{\$lang->items['LANG_START_INCLUSIVE']} \$subboardbit\") : (\"\")).\"</span></td>
  </tr>
 </table></td>
</tr>
 
 \") 
  
  : (\"
 
 <tr>
 <td class=\\\"tableb\\\" align=\\\"center\\\">&nbsp;</td>
 <td class=\\\"tablecat\\\" colspan=\\\"\".((\$hide_modcell==0) ? (\"5\") : (\"4\")).\"\\\" align=\\\"left\\\">
  <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\">
   <tr class=\\\"tablecat_fc\\\">
    <td><img src=\\\"{\$style['imagefolder']}/\$onoff.gif\\\" border=\\\"0\\\" alt=\\\"\\\" title=\\\"\\\" /></td>
    <td><span class=\\\"normalfont\\\">&nbsp;\".((\$show_hide == 1) ? (\"<a href=\\\"\$current_url\\\"><img src=\\\"{\$style['imagefolder']}/minus.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_START_DEACTIVATE_CAT}\\\" title=\\\"{\$LANG_START_DEACTIVATE_CAT}\\\" /></a>\") : (\"\".((\$show_hide == 2) ? (\"<a href=\\\"\$current_url\\\"><img src=\\\"{\$style['imagefolder']}/plus.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_START_SHOWCAT}\\\" title=\\\"{\$LANG_START_SHOWCAT}\\\" /></a>\") : (\"\")).\"\")).\"&nbsp;</span></td>
    <td><span class=\\\"normalfont\\\"><a href=\\\"board.php?boardid=\$boards[boardid]{\$SID_ARG_2ND}\\\"><b>\$boards[title]</b></a></span><span class=\\\"smallfont\\\">\".((\$boards['description']!=\"\") ? (\"<br />\$boards[description]\") : (\"\")).\"\".((\$subboardbit!=\"\") ? (\"<br />{\$lang->items['LANG_START_INCLUSIVE']} \$subboardbit\") : (\"\")).\"</span></td>
   </tr>
  </table>
 </td>
</tr>
 
 
 \")
  ).\"
  
  \")
 ).\"";
			?>
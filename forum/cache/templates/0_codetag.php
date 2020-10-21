<?php
			/*
			templatepackid: 0
			templatename: codetag
			*/
			
			$this->templates['codetag']="<table align='center' style='width:98%; table-layout: fixed;'>
 <tr>
  <td><div style='\".((\$filename != 'print.php') ? (\"overflow: auto; height: {\$height}px; \") : (\"\")).\"width: 100%;'>
   <table cellpadding='4' cellspacing='1' style='width:100%' class='tableinborder'>
    <tr class='smallfont'>
     <td class='tablecat'\".((\$linenumbers!=\"\") ? (\" colspan='2'\") : (\"\")).\"><span class='smallfont'><b>{\$lang->items['LANG_GLOBAL_CODE']}</b></span></td>
    </tr>
    <tr class='smallfont'>
     \".((\$linenumbers!=\"\") ? (\"<td class='inposttable' nowrap='nowrap' align='right'><pre>\$linenumbers</pre></td>\") : (\"\")).\"
     <td valign='top' class='inposttable' nowrap='nowrap' align='left' style='width:100%'><pre>\$code</pre></td>
    </tr>
   </table>
  </div></td>
 </tr>
</table>";
			?>
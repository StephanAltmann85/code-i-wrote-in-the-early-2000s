<table align='center' style='width:98%; table-layout: fixed;'>
 <tr>
  <td><div style='<if($filename != 'print.php')><then>overflow: auto; height: {$height}px; </then></if>width: 100%;'>
   <table cellpadding='4' cellspacing='1' style='width:100%' class='tableinborder'>
    <tr class='smallfont'>
     <td class='tablecat'<if($linenumbers!="")><then> colspan='2'</then></if>><span class='smallfont'><b>{$lang->items['LANG_GLOBAL_CODE']}</b></span></td>
    </tr>
    <tr class='smallfont'>
     <if($linenumbers!="")><then><td class='inposttable' nowrap='nowrap' align='right'><pre>$linenumbers</pre></td></then></if>
     <td valign='top' class='inposttable' nowrap='nowrap' align='left' style='width:100%'><pre>$code</pre></td>
    </tr>
   </table>
  </div></td>
 </tr>
</table>
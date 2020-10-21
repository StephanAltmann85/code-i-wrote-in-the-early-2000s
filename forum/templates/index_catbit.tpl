<if($depth == 1)>
 <then>
 
 <tr>
 <td class="tablecat" align="left" colspan="<if($hide_modcell==0)><then>6</then><else>5</else></if>"><table cellpadding="0" cellspacing="0">
  <tr class="tablecat_fc">
   <td><span class="normalfont">&nbsp;<if($show_hide == 1)><then><a href="$current_url"><img src="{$style['imagefolder']}/minus.gif" border="0" alt="{$LANG_START_DEACTIVATE_CAT}" title="{$LANG_START_DEACTIVATE_CAT}" /></a></then><else><if($show_hide == 2)><then><a href="$current_url"><img src="{$style['imagefolder']}/plus.gif" border="0" alt="{$LANG_START_SHOWCAT}" title="{$LANG_START_SHOWCAT}" /></a></then></if></else></if>&nbsp;</span></td>
   <td><span class="normalfont"><a href="board.php?boardid=$boards[boardid]{$SID_ARG_2ND}"><b>$boards[title]</b></a></span><span class="smallfont"><if($boards['description']!="")><then><br />$boards[description]</then></if><if($subboardbit!="")><then><br />{$lang->items['LANG_START_INCLUSIVE']} $subboardbit</then></if></span></td>
  </tr>
 </table></td>
</tr>
 
 </then>
  <else>
  
  <if($depth == 2)>
   <then>
 
 <tr>
 <td class="tableb" align="center"><img src="{$style['imagefolder']}/$onoff.gif" alt="" title="" border="0" /></td>
 <td class="tablecat" colspan="<if($hide_modcell==0)><then>5</then><else>4</else></if>" align="left"><table cellpadding="0" cellspacing="0">
  <tr class="tablecat_fc">
   <td><span class="normalfont">&nbsp;<if($show_hide == 1)><then><a href="$current_url"><img src="{$style['imagefolder']}/minus.gif" border="0" alt="{$LANG_START_DEACTIVATE_CAT}" title="{$LANG_START_DEACTIVATE_CAT}" /></a></then><else><if($show_hide == 2)><then><a href="$current_url"><img src="{$style['imagefolder']}/plus.gif" border="0" alt="{$LANG_START_SHOWCAT}" title="{$LANG_START_SHOWCAT}" /></a></then></if></else></if>&nbsp;</span></td>
   <td><span class="normalfont"><a href="board.php?boardid=$boards[boardid]{$SID_ARG_2ND}"><b>$boards[title]</b></a></span><span class="smallfont"><if($boards['description']!="")><then><br />$boards[description]</then></if><if($subboardbit!="")><then><br />{$lang->items['LANG_START_INCLUSIVE']} $subboardbit</then></if></span></td>
  </tr>
 </table></td>
</tr>
 
 </then>
  
  <else>
 
 <tr>
 <td class="tableb" align="center">&nbsp;</td>
 <td class="tablecat" colspan="<if($hide_modcell==0)><then>5</then><else>4</else></if>" align="left">
  <table cellpadding="0" cellspacing="0">
   <tr class="tablecat_fc">
    <td><img src="{$style['imagefolder']}/$onoff.gif" border="0" alt="" title="" /></td>
    <td><span class="normalfont">&nbsp;<if($show_hide == 1)><then><a href="$current_url"><img src="{$style['imagefolder']}/minus.gif" border="0" alt="{$LANG_START_DEACTIVATE_CAT}" title="{$LANG_START_DEACTIVATE_CAT}" /></a></then><else><if($show_hide == 2)><then><a href="$current_url"><img src="{$style['imagefolder']}/plus.gif" border="0" alt="{$LANG_START_SHOWCAT}" title="{$LANG_START_SHOWCAT}" /></a></then></if></else></if>&nbsp;</span></td>
    <td><span class="normalfont"><a href="board.php?boardid=$boards[boardid]{$SID_ARG_2ND}"><b>$boards[title]</b></a></span><span class="smallfont"><if($boards['description']!="")><then><br />$boards[description]</then></if><if($subboardbit!="")><then><br />{$lang->items['LANG_START_INCLUSIVE']} $subboardbit</then></if></span></td>
   </tr>
  </table>
 </td>
</tr>
 
 
 </else>
  </if>
  
  </else>
 </if>
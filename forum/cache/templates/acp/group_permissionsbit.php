<?php
/*
acp template
templatename: group_permissionsbit
*/

$this->templates['acp_group_permissionsbit']="<tr align=\\\"center\\\">
 <td class=\\\"firstrow\\\" nowrap=\\\"nowrap\\\"><select name=\\\"boardpermission[\$boards[boardid]]\\\" class=\\\"\$boardpermission_bgClass\\\" onchange=\\\"setBackgroundClass(this);\\\">
          <option value=\\\"-1\\\" class=\\\"whiteBG\\\"\$sel_boardpermission[2]>{\$lang->items['LANG_ACP_GROUP_GROUPDEFAULT']}</option>
          <option value=\\\"0\\\" class=\\\"redBG\\\"\$sel_boardpermission[0]>{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
          <option value=\\\"1\\\" class=\\\"greenBG\\\"\$sel_boardpermission[1]>{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
        </select></td>
 <td class=\\\"firstrow\\\"><select name=\\\"startpermission[\$boards[boardid]]\\\" class=\\\"\$startpermission_bgClass\\\" onchange=\\\"setBackgroundClass(this);\\\">
          <option value=\\\"-1\\\" class=\\\"whiteBG\\\"\$sel_startpermission[2]>{\$lang->items['LANG_ACP_GROUP_GROUPDEFAULT']}</option>
          <option value=\\\"0\\\" class=\\\"redBG\\\"\$sel_startpermission[0]>{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
          <option value=\\\"1\\\" class=\\\"greenBG\\\"\$sel_startpermission[1]>{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
        </select></td>
 <td class=\\\"firstrow\\\"><select name=\\\"replypermission[\$boards[boardid]]\\\" class=\\\"\$replypermission_bgClass\\\" onchange=\\\"setBackgroundClass(this);\\\">
          <option value=\\\"-1\\\" class=\\\"whiteBG\\\"\$sel_replypermission[2]>{\$lang->items['LANG_ACP_GROUP_GROUPDEFAULT']}</option>
          <option value=\\\"0\\\" class=\\\"redBG\\\"\$sel_replypermission[0]>{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
          <option value=\\\"1\\\" class=\\\"greenBG\\\"\$sel_replypermission[1]>{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
        </select></td>
 \$tds
 <td class=\\\"firstrow\\\" colspan=\\\"\$colspan\\\" width=\\\"100%\\\" align=\\\"left\\\">
 <b><a href=\\\"../board.php?boardid=\$boards[boardid]\\\" target=\\\"_blank\\\">\$boards[title]</a></b>
 \".((\$boardpermissionIncomplete == 1) ? (\"
 (<label for=\\\"ignoreBoardpermission_{\$boards[boardid]}\\\">{\$lang->items['LANG_ACP_GROUP_PERMISSIONS_IGNOREBOARDPERMISSION']} </label><input type=\\\"checkbox\\\" name=\\\"ignoreBoardpermission[\$boards[boardid]]\\\" value=\\\"1\\\" checked=\\\"checked\\\" id=\\\"ignoreBoardpermission_{\$boards[boardid]}\\\" />)
 \") : (\"\")).\"
 </td>
</tr>";
?>
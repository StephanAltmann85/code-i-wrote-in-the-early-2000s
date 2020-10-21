<?php
/*
templatepackid: 1
templatename: left_userstat_user
*/

$this->templates['left_userstat_user']="<table style=\\\"width:100%\\\" cellpadding=\\\"4\\\" cellspacing=\\\"0\\\" border=\\\"0\\\">
    <tr>
     <td style=\\\"width:100%\\\" class=\\\"normalfont\\\"><b><a href=\\\"profile.php?userid=\$userinformation[userid]{\$SID_ARG_2ND}\\\">\$userinformation[username]</a></b>
     \".((\$userinformation['gender'] == 1) ? (\"<img src=\\\"{\$style['imagefolder']}/male.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_THREAD_MALE}\\\" title=\\\"{\$LANG_THREAD_MALE}\\\" />\") : (\"\")).\"
     \".((\$userinformation['gender'] == 2) ? (\"<img src=\\\"{\$style['imagefolder']}/female.gif\\\" border=\\\"0\\\" alt=\\\"{\$LANG_THREAD_FEMALE}\\\" title=\\\"{\$LANG_THREAD_FEMALE}\\\" />\") : (\"\")).\"<br />
     <div class=\\\"smallfont\\\">\$userinformation[ranktitle]
     \".((\$rankimages!=\"\") ? (\"<br />\$rankimages\") : (\"\")).\"<br /><br />
     
     \$left_userstat_avatar
     
     <br />
     <b>{\$lang->items['LANG_GLOBAL_POSTS']}</b> \$userinformation[userposts]<br/>
     <b>{\$lang->items['LANG_GLOBAL_REGDATE']}</b> \$regdate<br />
</div>
     </td>
    </tr>
   </table>";
?>
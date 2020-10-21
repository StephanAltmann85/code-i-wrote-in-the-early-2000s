<table style="width:100%" cellpadding="4" cellspacing="0" border="0">
    <tr>
     <td style="width:100%" class="normalfont"><b><a href="profile.php?userid=$userinformation[userid]{$SID_ARG_2ND}">$userinformation[username]</a></b>
     <if($userinformation['gender'] == 1)><then><img src="{$style['imagefolder']}/male.gif" border="0" alt="{$LANG_THREAD_MALE}" title="{$LANG_THREAD_MALE}" /></then></if>
     <if($userinformation['gender'] == 2)><then><img src="{$style['imagefolder']}/female.gif" border="0" alt="{$LANG_THREAD_FEMALE}" title="{$LANG_THREAD_FEMALE}" /></then></if><br />
     <div class="smallfont">$userinformation[ranktitle]
     <if($rankimages!="")><then><br />$rankimages</then></if><br /><br />
     
     $left_userstat_avatar
     
     <br />
     <b>{$lang->items['LANG_GLOBAL_POSTS']}</b> $userinformation[userposts]<br/>
     <b>{$lang->items['LANG_GLOBAL_REGDATE']}</b> $regdate<br />
</div>
     </td>
    </tr>
   </table>
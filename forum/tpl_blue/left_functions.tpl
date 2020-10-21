<table style="width:100%" cellpadding="4" cellspacing="0" border="0">
    <tr>
     <td style="width:100%" class="smallfont">
<if($wbbuserdata['userid'])><then><a href="search.php?action=new{$SID_ARG_2ND}"><b>{$lang->items['LANG_GLOBAL_NEW_POSTS']}</b></a><br />
<br />
<a href="search.php?action=24h{$SID_ARG_2ND}">{$lang->items['LANG_GLOBAL_CURRENT_THREADS']}</a><br />
<a href="search.php?action=polls{$SID_ARG_2ND}">{$lang->items['LANG_GLOBAL_CURRENT_POLLS']}</a><br />
<a href="markread.php{$SID_ARG_1ST}">{$lang->items['LANG_GLOBAL_MARKREAD_ALL']}</a><br />
<br />
<a href="javascript:noticepopup()">{$lang->items['LANG_GLOBAL_NOTICE']}</a><br /></then></if>

<a href="wiw.php{$SID_ARG_1ST}">{$lang->items['LANG_GLOBAL_WIW']}</a><br />
<a href="locator.php{$SID_ARG_1ST}">{$lang->items['LANG_GLOBAL_WLW']}</a><br /><br />


<a href="http://www.programmers-club.de" target="_blank"><b>Homepage</b></a><br />
<a href="http://firstnews.programmers-club.de" target="_blank"><b>1st News - Projektseite</b></a>
     </td>
    </tr>
   </table>
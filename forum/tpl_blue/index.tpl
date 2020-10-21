<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">
<head>
<title>$master_board_name | {$lang->items['LANG_START_TITLE']}</title>
$headinclude
</head>

<body <if($pms_error == 1)><then>onload="window.open('pms.php?action=pms_error{$SID_ARG_2ND_UND}', 'moo', 'toolbar=no,scrollbars=no,resizable=no,width=150,height=200')"</then></if>>
 $header
<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
 <if($wbbuserdata['userid']==0)>
  <then>
   <tr>
    <td class="tablea" align="left"><span class="normalfont"><b>{$lang->items['LANG_START_WELCOME_TITLE']}</b></span></td>
   </tr>
   <tr>
    <td class="tableb" align="left" style="text-align: justify"><span class="smallfont">{$lang->items['LANG_START_WELCOME']}</span></td>
   </tr>
  </then>

  <else>
   <tr>
    <td class="tablea"><table style="width:100%" cellspacing="0" cellpadding="0" border="0">
     <tr class="tablea_fc">
      <td align="left"><span class="smallfont">{$lang->items['LANG_START_WELCOMEBACK']} <b>$usercbar_username</b> <a href="logout.php{$SID_ARG_1ST}">{$lang->items['LANG_START_LOGOUT']}</a><br /><b><a href="search.php?action=new{$SID_ARG_2ND}">{$lang->items['LANG_START_NEWPOSTS']} $lastvisitdate <span class="time">$lastvisittime</span>.</span></td>
      <td align="right"><span class="smallfont">{$lang->items['LANG_START_CURRENTTIME']} <span class="time">$currenttime</span>.<br />{$lang->items['LANG_START_TIMEZONE']}</span></td>
     </tr>
    </table></td>
   </tr>
  </else>
 </if>
 
</table><br />
<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
 <tr>
  <td class="tabletitle"><span class="smallfont">&nbsp;</span></td>
  <td class="tabletitle" style="width:<if($hide_modcell==0)><then>80</then><else>100</else></if>%" align="left"><span class="smallfont"><b>{$lang->items['LANG_START_BOARDS']}</b></span></td>
  <td class="tabletitle" align="center"><span class="smallfont"><b>{$lang->items['LANG_START_POSTS']}</b></span></td>
  <td class="tabletitle" align="center"><span class="smallfont"><b>{$lang->items['LANG_START_THREADS']}</b></span></td>
  <td class="tabletitle" align="center" nowrap="nowrap"><span class="smallfont"><b>{$lang->items['LANG_START_LASTPOST']}</b></span></td>
  <if($hide_modcell==0)><then><td class="tabletitle" style="width:20%" align="center"><span class="smallfont"><b>{$lang->items['LANG_START_MODERATORS']}</b></span></td></then></if>
 </tr>
 <tr height="5">
  <td class="mainpage"></td>
  <td class="mainpage"></td>
  <td class="mainpage"></td>
  <td class="mainpage"></td>
  <td class="mainpage"></td>
  <if($hide_modcell==0)><then><td class="mainpage"></td></then></if>
 </tr>

 $boardbit
 
 <if($showuseronline==1)>
  <then>
   <tr>
    <td class="tabletitle" colspan="<if($hide_modcell==0)><then>6</then><else>5</else></if>" align="left"><span class="smallfont"><b><a href="wiw.php{$SID_ARG_1ST}">{$lang->items['LANG_START_SHOWUSERONLINE']}</a></b></span></td> 
   </tr>
   <tr>
    <td rowspan="2" class="tableb" align="center"><img src="{$style['imagefolder']}/online.gif" alt="" title="" /></td>
    <td colspan="<if($hide_modcell==0)><then>5</then><else>4</else></if>" class="tablea" align="left"><span class="smallfont">{$lang->items['LANG_START_USERONLINE']}</span></td>
   </tr>
   <tr>
    <td class="tablea" colspan="<if($hide_modcell==0)><then>5</then><else>4</else></if>" align="left"><span class="smallfont"><if($useronline=="")><then>&nbsp;</then></if>$useronline</span></td>
   </tr>	
  
  </then>
 </if>
 
 
 <if($showpmonindex==1 && $wbbuserdata['userid']!=0 && $wbbuserdata['can_use_pms']==1 && $wbbuserdata['receivepm']==1)>
  <then>
   <tr>
    <td class="tabletitle" align="left" colspan="<if($hide_modcell==0)><then>6</then><else>5</else></if>"><span class="smallfont"><b>{$lang->items['LANG_START_PM']}</b></span></td>
   </tr>
   <tr>
    <td align="center" class="tableb"><if($countnew>0)>
     <then><img src="{$style['imagefolder']}/on.gif" alt="{$lang->items['LANG_START_NEWPM']}" title="{$lang->items['LANG_START_NEWPM']}" /></then>
     <else><img src="{$style['imagefolder']}/off.gif" alt="{$lang->items['LANG_START_NONEWPM']}" title="{$lang->items['LANG_START_NONEWPM']}" /></else>
    </if></td>
    <td align="left" colspan="<if($hide_modcell==0)><then>5</then><else>4</else></if>" class="tablea"><span class="smallfont"><b><a href="pms.php{$SID_ARG_1ST}">{$lang->items['LANG_START_PMIN']}</a></b><br />{$lang->items['LANG_START_PMS']}</span></td>
   </tr>  
  
  </then>
 </if>
 
 <if(isset($birthdaybit) || isset($eventbit))>
  <then>
   <tr>
    <td class="tabletitle" align="left" colspan="<if($hide_modcell==0)><then>6</then><else>5</else></if>"><span class="smallfont"><b>{$lang->items['LANG_START_SHOWEVENTS']}</b></span></td>
   </tr>
   
   <if(isset($birthdaybit))>
    <then>
     <tr>
      <td class="tableb" align="center"><img src="{$style['imagefolder']}/birthday.gif" alt="" title="" border="0" /></td>
      <td class="tablea" colspan="<if($hide_modcell==0)><then>5</then><else>4</else></if>" align="left"><span class="smallfont"><b>{$lang->items['LANG_START_BIRTHDAY']}</b><br />$birthdaybit</span></td>
     </tr>
    </then>
   </if>
   
   <if(isset($eventbit))>
    <then>
     <tr>
      <td class="tableb" align="center"><img src="{$style['imagefolder']}/events.gif" alt="" title="" border="0" /></td>
      <td class="tablea" colspan="<if($hide_modcell==0)><then>5</then><else>4</else></if>" align="left"><span class="smallfont"><b>{$lang->items['LANG_START_TODAYEVENT']}</b><br />$eventbit</span></td>
     </tr>
    </then>
   </if> 
  </then>
 </if>
 
 <if($showstats==1)>
  <then>
   <tr>
    <td class="tabletitle" align="left" colspan="<if($hide_modcell==0)><then>6</then><else>5</else></if>"><span class="smallfont"><b>{$lang->items['LANG_START_STATISTIC']}</b></span></td> 
   </tr>
   <tr>
    <td class="tableb" align="center"><img src="{$style['imagefolder']}/stats.gif" alt="" border="0" /></td>
    <td colspan="<if($hide_modcell==0)><then>5</then><else>4</else></if>" class="tablea" align="left"><span class="smallfont">{$lang->items['LANG_START_STATISTIC_MEMBERS']} $stats[usercount] | {$lang->items['LANG_START_STATISTIC_THREADS']} $stats[threadcount] | {$lang->items['LANG_START_STATISTIC_POSTS']} $stats[postcount] ({$lang->items['LANG_START_STATISTIC_AVERAGE']} $postperday {$lang->items['LANG_START_STATISTIC_POSTPERDAY']})<br />
    {$lang->items['LANG_START_STATISTIC_NEWESTMEMBER']} <a href="profile.php?userid=$stats[lastuserid]{$SID_ARG_2ND}">$stats[username]</a>.</span></td>
   </tr>
  </then>
 </if>
  
</table>

<if($wbbuserdata['userid']==0)>
 <then>
  <br /><a name="login" id="login"></a>
  <if($allowloginencryption==1)><then>
  <script type="text/javascript" src="js/sha1.js"></script>
  <script type="text/javascript" src="js/crypt.js"></script>
  </then></if>
  <form method="post" action="login.php" name="loginform"<if($allowloginencryption==1)><then> onsubmit="return encryptlogin(this);"</then></if>>
  <input type="hidden" name="send" value="send" />
  <input type="hidden" name="sid" value="$session[hash]" />
  <if($allowloginencryption==1)><then>
  <input type="hidden" name="authentificationcode" value="$session[authentificationcode]" />
  <input type="hidden" name="crypted" value="false" /></then></if>
  <table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
   <tr>
    <td class="tabletitle" align="left"><span class="smallfont"><b>{$lang->items['LANG_START_LOGIN']}</b></span></td> 
   </tr>
   <tr>
    <td class="tableb"><table cellpadding="0" cellspacing="5" align="center" class="tableb_fc">
     <tr>
      <td><span class="smallfont">{$lang->items['LANG_START_USERNAME']}</span></td>
      <td><span class="smallfont"><input type="text" name="l_username" maxlength="50" size="20" class="input" tabindex="1" />&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
      <td><span class="smallfont">{$lang->items['LANG_START_PASSWORD']} (<a href="forgotpw.php{$SID_ARG_1ST}">{$lang->items['LANG_START_LOSTPW']}</a>):</span></td>
      <td><span class="smallfont"><input type="password" name="l_password" maxlength="30" size="20" class="input" tabindex="2" />&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
	  <if($allowloginencryption==1)><then>
      <td><span class="smallfont"><label for="checkbox1">{$lang->items['LANG_GLOBAL_ENCRYPT_TRANSFER']}</label></span></td>
      <td><span class="smallfont"><input type="checkbox" id="checkbox1" name="activateencryption" onclick="activate_loginencryption(document.loginform);" />&nbsp;&nbsp;&nbsp;&nbsp;</span></td></then></if>
      <td><input type="submit" value="{$lang->items['LANG_START_LOGIN']}" class="input" tabindex="3" /></td>
     </tr>
    </table></td>
   </tr>
  </table></form>
  <if($allowloginencryption==1)><then>
  <script type="text/javascript">
   <!--
    activate_loginencryption(document.loginform);
   //-->
  </script></then></if>
 </then>
</if>

<br />
<table cellpadding="0" cellspacing="1" border="0" style="width:{$style['tableinwidth']}" class="tableinborder">
   <tr>
    <td class="tablea"><table style="width:100%" cellspacing="0" cellpadding="4" border="0">
     <tr class="tablea_fc">
     <td class="tableb"><img src="{$style['imagefolder']}/on.gif" alt="{$lang->items['LANG_START_NEW_POSTS']}" title="{$lang->items['LANG_START_NEW_POSTS']}" border="0" /></td>
     <td class="tableb"><span class="smallfont">{$lang->items['LANG_START_NEW_POSTS']}&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
     <td class="tableb"><img src="{$style['imagefolder']}/off.gif" alt="{$lang->items['LANG_START_NONEW_POSTS']}" title="{$lang->items['LANG_START_NONEW_POSTS']}" border="0" /></td>
     <td class="tableb"><span class="smallfont">{$lang->items['LANG_START_NONEW_POSTS']}&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
     <td class="tableb"><img src="{$style['imagefolder']}/offclosed.gif" alt="{$lang->items['LANG_START_BOARD_CLOSED']}" title="{$lang->items['LANG_START_BOARD_CLOSED']}" border="0" /></td>
     <td class="tableb"><span class="smallfont">{$lang->items['LANG_START_BOARD_CLOSED']}&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
     <td class="tableb"><img src="{$style['imagefolder']}/link.gif" alt="{$lang->items['LANG_START_BOARD_LINK']}" title="{$lang->items['LANG_START_BOARD_LINK']}" border="0" /></td>
     <td class="tableb"><span class="smallfont">{$lang->items['LANG_START_BOARD_LINK']}</span></td>
    </tr>
    </table></td>
   </tr>
</table><br />

$footer
</body>
</html>
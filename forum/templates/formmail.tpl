<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">
<head>
<title>$master_board_name | {$lang->items['LANG_MISC_FORMMAIL_TITLE']}</title>
$headinclude
</head>

<body>
$header
<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
 <tr>
  <td class="tablea"><table cellpadding="0" cellspacing="0" border="0" style="width:100%">
   <tr class="tablea_fc">
    <td align="left"><span class="smallfont"><b><a href="index.php{$SID_ARG_1ST}">$master_board_name</a> &raquo; {$lang->items['LANG_MISC_FORMMAIL_TITLE']}</b></span></td>
    <td align="right"><span class="smallfont"><b>$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br /><form action="formmail.php" method="post">
<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
 <tr>
 <td class="tabletitle" colspan="2" align="left"><span class="normalfont"><b>{$lang->items['LANG_MISC_FORMMAIL_TITLE']}</b></span></td>
 </tr>
 
 <if($userid)>
  <then>
   <tr align="left">
    <td class="tableb"><span class="normalfont">{$lang->items['LANG_MISC_FORMMAIL_RECIPIENTNAME']}</span></td>
    <td class="tableb"><span class="normalfont"><a href="profile.php?userid=$userid{$SID_ARG_2ND}">$recipientName</a></td>
   </tr>
  </then>
  <else>
   <tr align="left">
    <td class="tableb"><span class="normalfont">{$lang->items['LANG_MISC_FORMMAIL_RECIPIENT']}</span></td>
    <td class="tableb"><input class="input" type="text" name="recipient" size="20" maxlength="255" /></td>
   </tr>
  </else>
 </if>
 
 <tr align="left">
  <td class="tablea"><span class="normalfont">{$lang->items['LANG_MISC_FORMMAIL_SUBJECT']}</span></td>
  <td class="tablea"><input class="input" type="text" name="subject" size="50" maxlength="255" value="$subject" /></td>
 </tr>
 <tr align="left">
  <td class="tableb" valign="top"><span class="normalfont">{$lang->items['LANG_MISC_FORMMAIL_MESSAGE']}</span></td>
  <td class="tableb"><textarea name="message" rows="14" cols="70">$message</textarea></td>
 </tr>
</table>
<p align="center">
 <input type="hidden" name="sid" value="$session[hash]" />
 <input type="hidden" name="send" value="send" />
 
 <if($userid!=0)>
  <then><input type="hidden" name="userid" value="$userid" /></then>
 </if>
 
 <input class="input" type="submit" name="submit" accesskey="S" value="{$lang->items['LANG_MISC_SEND']}" />
 <input class="input" type="reset" name="reset" accesskey="R" value="{$lang->items['LANG_MISC_FORMMAIL_RESET']}" />
</p>
</form>
$footer
</body>
</html>
<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">
<head>
<title>$master_board_name | $board[title]</title>
$headinclude
</head>

<body>
$header
<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
 <tr>
  <td class="tablea"><table cellpadding="0" cellspacing="0" border="0" style="width:100%">
   <tr class="tablea_fc">
    <td align="left"><span class="smallfont"><b><a href="index.php{$SID_ARG_1ST}">$master_board_name</a>$navbar</b></span></td>
    <td align="right"><span class="smallfont"><b>$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />
<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
 <tr align="center" class="smallfont">
  <td class="tabletitle">&nbsp;</td>
  <td class="tabletitle" style="width:<if($hide_modcell==0)><then>80</then><else>100</else></if>%" align="left"><b>{$lang->items['LANG_START_BOARDS']}</b></td>
  <td class="tabletitle"><b>{$lang->items['LANG_START_POSTS']}</b></td>
  <td class="tabletitle"><b>{$lang->items['LANG_START_THREADS']}</b></td>
  <td class="tabletitle" nowrap="nowrap"><b>{$lang->items['LANG_START_LASTPOST']}</b></td>
  <if($hide_modcell==0)><then><td class="tabletitle" style="width:20%"><b>{$lang->items['LANG_START_MODERATORS']}</b></td></then></if>
 </tr>
 $boardbit
</table>
<table style="width:{$style['tableinwidth']}">
 <tr>
  <td align="right">$boardjump</td>
 </tr>
</table><br />
<table>
 <tr align="center">
  <td><img src="{$style['imagefolder']}/on.gif" alt="{$lang->items['LANG_START_NEW_POSTS']}" title="{$lang->items['LANG_START_NEW_POSTS']}" border="0" /></td>
  <td><span class="smallfont">{$lang->items['LANG_START_NEW_POSTS']}&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
  <td><img src="{$style['imagefolder']}/off.gif" alt="{$lang->items['LANG_START_NONEW_POSTS']}" title="{$lang->items['LANG_START_NONEW_POSTS']}" border="0" /></td>
  <td><span class="smallfont">{$lang->items['LANG_START_NONEW_POSTS']}&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
  <td><img src="{$style['imagefolder']}/offclosed.gif" alt="{$lang->items['LANG_START_BOARD_CLOSED']}" title="{$lang->items['LANG_START_BOARD_CLOSED']}" border="0" /></td>
  <td><span class="smallfont">{$lang->items['LANG_START_BOARD_CLOSED']}&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
  <td><img src="{$style['imagefolder']}/link.gif" alt="{$lang->items['LANG_START_BOARD_LINK']}" title="{$lang->items['LANG_START_BOARD_LINK']}" border="0" /></td>
  <td><span class="smallfont">{$lang->items['LANG_START_BOARD_LINK']}</span></td>
 </tr>
</table>
$footer
</body>
</html>
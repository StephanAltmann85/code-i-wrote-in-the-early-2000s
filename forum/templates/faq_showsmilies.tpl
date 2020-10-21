<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">
<head>
<title>$master_board_name | {$lang->items['LANG_FAQ_SMILIES_TITLE']}</title>
$headinclude
</head>

<body>
 $header
<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
 <tr>
  <td class="tablea"><table cellpadding="0" cellspacing="0" border="0" style="width:100%">
   <tr class="tablea_fc">
    <td align="left"><span class="smallfont"><b><a href="index.php{$SID_ARG_1ST}">$master_board_name</a> &raquo; <a href="misc.php?action=faq{$SID_ARG_2ND}">{$lang->items['LANG_FAQ_FAQ']}</a> &raquo; {$lang->items['LANG_FAQ_SMILIES_TITLE']}</b></span></td>
    <td align="right"><span class="smallfont"><b>$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />
<table style="width:{$style['tableinwidth']}"><tr><td align="left" class="normalfont">{$lang->items['LANG_FAQ_SMILIES_INTRO']}</td></tr></table>
 <table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
  <tr align="center">
   <td class="tabletitle" width="33%"><span class="normalfont"><b>{$lang->items['LANG_FAQ_SMILIES_SMILIETITLE']}</b></span></td>
   <td class="tabletitle" width="33%"><span class="normalfont"><b>{$lang->items['LANG_FAQ_SMILIES_SMILIECODE']}</b></span></td>
   <td class="tabletitle" width="33%"><span class="normalfont"><b>{$lang->items['LANG_FAQ_SMILIES_SMILIEIMG']}</b></span></td>
  </tr>
  $smiliebit
 </table><table style="width:{$style['tableinwidth']}"><tr><td align="left"><span class="normalfont">{$lang->items['LANG_FAQ_SMILIES_TEXT']}</span></td></tr></table>	
 $footer
</body>
</html>
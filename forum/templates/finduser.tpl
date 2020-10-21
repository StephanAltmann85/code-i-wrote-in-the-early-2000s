<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">
<head>
<title>$master_board_name | {$lang->items['LANG_MISC_FINDUSER_TITLE']}</title>
$headinclude
<script type="text/javascript">
<!--
 function send_username(username) {
  if (opener.document.bbform.recipients.value.length > 0 && opener.document.bbform.recipients.value.charAt(opener.document.bbform.recipients.value.length - 1) != "\n") {  
   opener.document.bbform.recipients.value = opener.document.bbform.recipients.value + "\n";
  }
  opener.document.bbform.recipients.value = opener.document.bbform.recipients.value + username + "\n";
  opener.expandTextarea(opener.document.bbform.recipients);
  self.close();
 }
//-->
</script>
</head>
<body onload="document.sform.username.focus()">
<form method="post" action="misc.php" name="sform">
<input type="hidden" name="action" value="$action" />
<input type="hidden" name="send" value="send" />
<input type="hidden" name="sid" value="$session[hash]" />
<table cellpadding="8" cellspacing="{$style['tableoutcellspacing']}" align="center" border="{$style['tableoutborder']}" class="tableoutborder">
 <tr><td class="mainpage" align="center">
  <table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:100%" class="tableinborder">
   <tr>
    <td align="left" class="tabletitle"><span class="normalfont"><b>{$lang->items['LANG_MISC_FINDUSER_TITLE']}</b></span></td>
   </tr>
   <tr>
    <td class="tablea" align="left"><span class="smallfont"><input type="text" name="username" class="input" maxlength="50" />&nbsp;<input type="submit" value="{$lang->items['LANG_MISC_FINDUSER_SEARCH']}" class="input" /><br />{$lang->items['LANG_MISC_FINDUSER_DESC']}</span></td>
   </tr>
   <if($options!="")>
    <then>
     <tr>
      <td class="tableb" align="left"><span class="smallfont"><select name="susername">$options</select>&nbsp;<input type="button" class="input" value="{$lang->items['LANG_MISC_FINDUSER_SELECT']}" onclick="send_username(this.form.susername.options[this.form.susername.selectedIndex].value)" /></span></td>
     </tr>
    </then>
   </if>
   <tr>
    <td align="center" class="tabletitle"><span class="smallfont"><a href="javascript:self.close()">{$lang->items['LANG_MISC_WINDOW_CLOSE']}</a></span></td>
   </tr>
  </table>
 </td></tr>
</table></form>
</body>
</html>
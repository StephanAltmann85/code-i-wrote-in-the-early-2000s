<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">
<head>
<title>$master_board_name | {$lang->items['LANG_MISC_ATTACHMENT_ADD']}</title>
$headinclude

<script type="text/javascript">
<!--
 function formsubmit() {
  action = document.aform.action;
  if(action[0].checked) self.close();
  if(action[2].checked) document.aform.submit();
  if(action[1].checked) {
   opener.document.bbform.attachmentname.value = '';
   opener.document.bbform.attachment_id.value = '0';
   document.aform.submit();
  }
 }
//-->
</script>
</head>

<body onload="window.resizeTo(450,350)">
<form action="attachmentedit.php" method="post" enctype="multipart/form-data" name="aform">
<table style="width:100%" cellpadding="{$style['tableoutcellpadding']}" cellspacing="{$style['tableoutcellspacing']}" align="center" border="{$style['tableoutborder']}" class="tableoutborder">
 <tr><td class="mainpage" align="center">&nbsp;<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
  <tr>
   <td class="tabletitle" align="left"><span class="normalfont"><b>{$lang->items['LANG_MISC_ATTACHMENT_ADD']}</b></span></td>
  </tr>
  $uploaderror
  <tr>
   <td class="tableb" align="left"><span class="normalfont"><b>{$lang->items['LANG_MISC_ATTACHMENT_FILE']}</b> $attachment[attachmentname].$attachment[attachmentextension]</span></td>
  </tr>
  <tr>
   <td class="tablea" align="left"><span class="smallfont"><input type="radio" name="action" id="radio1" value="nothing" checked="checked" /><label for="radio1"> {$lang->items['LANG_MISC_ATTACHMENT_KEEP']}</label><br />
   <input type="radio" name="action" id="radio2" value="del" /><label for="radio2"> {$lang->items['LANG_MISC_ATTACHMENT_DELETE']}</label><br />
   <input type="radio" name="action" id="radio3" value="add" /><label for="radio3"> {$lang->items['LANG_MISC_ATTACHMENT_OVERWRITE']}</label><br /></span></td>
  </tr>
  <tr>
   <td align="left" class="tableb"><input type="hidden" name="MAX_FILE_SIZE" value="$wbbuserdata[max_attachment_size]" /><input name="attachment_file" type="file" class="input" /><br />
    <span class="smallfont">{$lang->items['LANG_MISC_ATTACHMENT_MAXFILESIZE']} <b>$max_attachment_size</b><br />
    {$lang->items['LANG_MISC_ATTACHMENT_EXTENSIONS']} <b>$allowed_attachment_extensions</b></span></td>
  </tr>
 </table>
 <p align="center">
  <input type="hidden" name="attachmentid" value="$attachmentid" />
  <input type="hidden" name="sid" value="$session[hash]" />
  <input class="input" type="button" onclick="formsubmit();" accesskey="S" value="{$lang->items['LANG_MISC_SAVE']}" />
  <input class="input" type="button" accesskey="C" value="{$lang->items['LANG_MISC_CLOSE']}" onclick="self.close();" />
 </p><br />
</td></tr></table></form>
</body>
</html>
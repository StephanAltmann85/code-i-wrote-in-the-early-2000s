<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">
<head>
<title>$master_board_name | {$lang->items['LANG_MISC_ATTACHMENT_ADD']}</title>
$headinclude
<script type="text/javascript">
<!--
if(!opener) self.close();
//-->
</script>
</head>

<body>
<form action="attachmentedit.php" method="post" enctype="multipart/form-data">
<table style="width:100%" cellpadding="{$style['tableoutcellpadding']}" cellspacing="{$style['tableoutcellspacing']}" align="center" border="{$style['tableoutborder']}" class="tableoutborder">
 <tr><td class="mainpage" align="center">&nbsp;<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
  <tr>
   <td class="tabletitle" align="left"><span class="normalfont"><b>{$lang->items['LANG_MISC_ATTACHMENT_ADD']}</b></span></td>
  </tr>
  $uploaderror
  <tr>
   <td class="tableb" align="left"><input type="hidden" name="MAX_FILE_SIZE" value="$wbbuserdata[max_attachment_size]" /><input name="attachment_file" type="file" class="input" /><br />
    <span class="smallfont">{$lang->items['LANG_MISC_ATTACHMENT_MAXFILESIZE']} <b>$max_attachment_size</b><br />
    {$lang->items['LANG_MISC_ATTACHMENT_EXTENSIONS']} <b>$allowed_attachment_extensions</b></span></td>
  </tr>
 </table>
 <p align="center">
  <input type="hidden" name="action" value="add" />
  <input type="hidden" name="boardid" value="$boardid" />
  <input type="hidden" name="sid" value="$session[hash]" />
  <input class="input" type="submit" name="submit" accesskey="S" value="{$lang->items['LANG_MISC_SAVE']}" />
  <input class="input" type="button" accesskey="C" value="{$lang->items['LANG_MISC_CLOSE']}" onclick="self.close();" />
 </p><br />
</td></tr></table></form>
</body>
</html>
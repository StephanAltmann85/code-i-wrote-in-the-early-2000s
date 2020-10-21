<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">
<head>
<title>$master_board_name</title>
$headinclude
</head>
<body>

<form action="notice.php?sid=$session[hash]" method="POST">
<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width: 100%;" class="tableinborder">
  <tr>
    <td class="tabletitle" align="left"><span class="normalfont"><b>{$lang->items['LANG_GLOBAL_NOTICE']}</b></span></td>
  </tr>
   <tr>
    <td class="tableb" align="left"><span class="smallfont">{$lang->items['LANG_NOTICE_EXP']}</span></td>
   </tr>

  <if($_POST['notice_send'] == 1)>
  <then>
   <tr>
    <td class="tableb" align="left"><span class="smallfont"><b>{$lang->items['LANG_NOTICE_SAVED']}</b></span></td>
   </tr>
 </then>
 </if>

   <tr>
    <td class="tablea" align="center"><textarea name="notice_main" rows="15" cols="100">{$ausgabe}</textarea>
<input type="hidden" name="id" value="popup" />
<input type="hidden" name="notice_send" value="1" />
    </td>
   </tr>
   <tr>
    <td class="tableb" align="center"><input type="submit" class="input" value="{$lang->items['LANG_NOTICE_SAVE']}" /></td>
  </tr>
</table></form>

</body>
</html>

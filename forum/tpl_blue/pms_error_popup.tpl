<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">
<head>
<title>$master_board_name | {$lang->items['LANG_GLOBAL_PMS']}</title>
$headinclude
<script type="text/javascript">
<!--
function toOpener(url) {
 opener.location.href=url;
 opener.document.focus();
}

function goToInbox() {
 toOpener('pms.php{$SID_ARG_1ST}');
 self.close();
}
//-->
</script>
</head>

<body>

<table style="width:100%; height: 100%;" cellpadding="3" cellspacing="3" border="0">
<tr>
 <td valign="middle" align="center"><span class="normalfont">{$lang->items['LANG_PMS_MESSAGE_ERROR']}<br /><br>
<a href="javascript:self.close()">{$lang->items['LANG_PMS_POPUP_CLOSE']}</a>
</span></td>
</tr>
</table>

</body>
</html>
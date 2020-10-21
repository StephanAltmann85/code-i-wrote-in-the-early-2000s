<?php
/*
templatepackid: 1
templatename: locator_popup_enter
*/

$this->templates['locator_popup_enter']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_LOCATOR_TITLE']}</title>
\$headinclude
<script type=\\\"text/javascript\\\">
<!--
function toOpener(url) {
 opener.location.href=url;
}

function coords(Ereignis)
{
  xx=-10;	// defaults off image
  yy=-10;

  if (window.event) // IE
  {
    xx=window.event.offsetX;
    yy=window.event.offsetY;
  }
  else
  {
    if (Ereignis)
    {
      if (Ereignis.target)	 // mozilla?
      {
        xx=Ereignis.layerX-Ereignis.target.x;
        yy=Ereignis.layerY-Ereignis.target.y;
      }
      else
      {
        xx=Ereignis.pageX;
        yy=Ereignis.pageY;
      }
    }
  }
  location.href = \\\"locator.php?x=\\\"+xx+\\\"&y=\\\"+yy+\\\"&action=enter_step3&state=\$_REQUEST[id]{\$SID_ARG_2ND}\\\";
}
//-->
</script>
</head>

<body onLoad=\\\"toOpener('locator.php?action={SID_ARG_2ND}');\\\">

\".((\$_REQUEST[action] == \"enter_step2\") ? (\"
<table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width: 100%;\\\" align=\\\"center\\\">
 <tr>
  <td class=\\\"tablea\\\" align=\\\"center\\\">
   <img name=\\\"locator\\\" style=\\\"cursor:pointer;\\\" onClick=\\\"coords();\\\" src=\\\"locator.php?action=image_clean&id=\$_REQUEST[id]{\$SID_ARG_2ND}\\\" border=\\\"0\\\" alt=\\\"{\$lang->items['LANG_LOCATOR_TITLE']}\\\">
  </td>
  </tr>  
</table>
\") : (\"\")
).\"

\".((\$_REQUEST[action] == \"enter_step3\") ? (\"
<table style=\\\"width:100%; height: 100%;\\\">
<tr>
 <td valign=\\\"middle\\\" align=\\\"center\\\">

 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:300\\\">
 <tr class=\\\"tabletitle\\\">
  <td align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_LOCATOR_ENTER_RESIDENCE']}</b></span></td>
 </tr>
  <tr><form action=\\\"locator.php\\\" method=\\\"get\\\" target=\\\"_top\\\">
  <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_LOCATOR_POSTCODE']}:</b></span></td>
  <td class=\\\"tablea\\\"><input type=\\\"Text\\\" name=\\\"postcode\\\" value=\\\"00000\\\" size=\\\"5\\\" maxlength=\\\"5\\\" class=\\\"input\\\"></td>
 </tr>
 <tr>
  <td class=\\\"tablea\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_LOCATOR_RESIDENCE']}:</b></span></td>
  <td class=\\\"tablea\\\"><input type=\\\"Text\\\" name=\\\"residence\\\" value=\\\"\\\" size=\\\"20\\\" maxlength=\\\"255\\\" class=\\\"input\\\"></td>
 </tr>
 <tr>
  <td colspan=\\\"2\\\" class=\\\"tableb\\\"><input type=\\\"Submit\\\" name=\\\"\\\" value=\\\"{\$lang->items['LANG_LOCATOR_SAVE']}\\\" class=\\\"input\\\"></td>
 </tr>
 <input type=\\\"hidden\\\" name=\\\"x\\\" value=\\\"\$_REQUEST[x]\\\">
 <input type=\\\"hidden\\\" name=\\\"y\\\" value=\\\"\$_REQUEST[y]\\\">  
 <input type=\\\"hidden\\\" name=\\\"state\\\" value=\\\"\$_REQUEST[state]\\\">  
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$task\\\">
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\">
 </form>
 </table><br><br>

 </td>
</tr>
</table>
\") : (\"\")
).\"

\".((\$_REQUEST[action] == \"enter_save\") ? (\"
<table style=\\\"width:100%; height: 100%;\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\">
<tr>
 <td valign=\\\"middle\\\" align=\\\"center\\\"><span class=\\\"normalfont\\\">\".((\$saved == \"done\") ? (\"{\$lang->items['LANG_LOCATOR_MESSAGE_SAVED']}\") : (\"{\$lang->items['LANG_LOCATOR_MESSAGE_ERROR']}\")).\"<br /><br>
<a href=\\\"javascript:self.close()\\\">{\$lang->items['LANG_LOCATOR_POPUP_CLOSE']}</a>
</span></td>
</tr>
</table>
\") : (\"\")
).\"



</body>
</html>";
?>
<?php
/*
acp template
templatename: board_view
*/

$this->templates['acp_board_view']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<script type=\\\"text/javascript\\\">
<!--
function boardAction(theSelect) {
 if(theSelect.options[theSelect.selectedIndex].value!='') document.location.href=theSelect.options[theSelect.selectedIndex].value;
}
//-->
</script>
</head>

<body>

<form method=\\\"post\\\" action=\\\"board.php\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"\$maxcolspan\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_BOARD_EDIT']}</td>
  </tr>
  \$boardlist
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"\$maxcolspan\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_BOARD_SORT']}\\\" /> <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_BOARD_SYNC']}\\\" onclick=\\\"window.location.href='board.php?action=sync&amp;sid=\$session[hash]'\\\" /></td>
  </tr>
 </table>
</form>
<p align=\\\"center\\\"><a href=\\\"board.php?action=view&amp;boardview_tree=1&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_BOARD_BOARDVIEW_TREE']}</a></p>
</body>
</html>";
?>
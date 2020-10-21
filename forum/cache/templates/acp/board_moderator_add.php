<?php
/*
acp template
templatename: board_moderator_add
*/

$this->templates['acp_board_moderator_add']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<script type=\\\"text/javascript\\\">
<!--
 function setModerator(username)
 {
 	document.bbform.moderatorname.value=username;
 }
//-->
</script>
</head>

<body>

<form method=\\\"post\\\" action=\\\"board.php\\\" name=\\\"bbform\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"boardid\\\" value=\\\"\$boardid\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_BOARD_MODERATOR_ADD_TITLE']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_BOARD_MODERATOR_MODERATORNAME']} (<a href=\\\"#\\\" onclick=\\\"javascript: window.open('board.php?action=findmoderator&amp;sid=\$session[hash]', 'moo', 'toolbar=no,scrollbars=yes,resizable=yes,width=300,height=180');\\\">{\$lang->items['LANG_ACP_GROUP_FIND_USER']}</a>)</td>
   <td><input type=\\\"text\\\" name=\\\"moderatorname\\\" value=\\\"\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>{\$lang->items['LANG_ACP_BOARD_MODERATOR_NOTIFY_NEWPOST']}</td>
   <td><select name=\\\"notify_newpost\\\">
  <option value=\\\"1\\\">{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
  <option value=\\\"0\\\" selected=\\\"selected\\\">{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
 </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_BOARD_MODERATOR_NOTIFY_NEWTHREAD']}</td>
   <td><select name=\\\"notify_newthread\\\">
  <option value=\\\"1\\\">{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
  <option value=\\\"0\\\" selected=\\\"selected\\\">{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
 </select></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_BOARD_MODERATOR_RIGHTS']}</td>
  </tr>
  \$rightbit
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
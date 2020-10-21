<?php
/*
acp template
templatename: board_view_tree
*/

$this->templates['acp_board_view_tree']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<style type=\\\"text/css\\\">
<!--
select {
 font-size: 11px;
}

.small {
 font-size: 11px;
}

-->
</style>
<script type=\\\"text/javascript\\\" src=\\\"../js/tree.js\\\"></script>
<script type=\\\"text/javascript\\\">
<!--

var session_hash = '\$session[hash]';
var lang_var_edit = '{\$lang->items['LANG_ACP_GLOBAL_EDIT']}';
var lang_var_del = '{\$lang->items['LANG_ACP_GLOBAL_DELETE']}';
var lang_var_empty = '{\$lang->items['LANG_ACP_GLOBAL_EMPTY']}';
var lang_var_moderator_add = '{\$lang->items['LANG_ACP_BOARD_MODERATOR_ADD']}';

var TREE_ITEMS = [
['\".addcslashes(\$master_board_name, \"'\").\"','0'
\$tree
]
];

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
   <td>{\$lang->items['LANG_ACP_GLOBAL_MENU_BOARD_EDIT']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>
   <script type=\\\"text/javascript\\\">
		new tree (TREE_ITEMS, tree_tpl);
		</script>
   </td>
  </tr>
  \$boardlist
  <tr class=\\\"tblsection\\\">
   <td align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_BOARD_SORT']}\\\" /> <input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_BOARD_SYNC']}\\\" onclick=\\\"window.location.href='board.php?action=sync&amp;sid=\$session[hash]'\\\" /></td>
  </tr>
 </table>
</form>
<p align=\\\"center\\\"><a href=\\\"board.php?action=view&amp;boardview_tree=0&amp;sid=\$session[hash]\\\">{\$lang->items['LANG_ACP_BOARD_BOARDVIEW_NORMAL']}</a></p>
</body>
</html>";
?>
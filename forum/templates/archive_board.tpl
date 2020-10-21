<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">
<head>
<title>$board[title] | $master_board_name</title>
<meta http-equiv="Content-Type" content="text/html; charset={$lang->items['LANG_GLOBAL_ENCODING']}" />
<base href="$url2board/" />
<link rel="stylesheet" href="archive/archive.css" />
<script type="text/javascript">
<!--
window.setTimeout("window.location.href = '$url2board/board.php?boardid=$boardid';", 5000);
//-->
</script>
</head>

<body>
<div class="page">
<div class="navbar"><a href="archive/index.html">$master_board_name</a>$navbar</div>

<h1><a href="board.php?boardid=$boardid">$board[title]</a></h1>
<div class="content">
<if($threadbit != '')><then><ul>$threadbit</ul></then></if>
</div>

<table class="pagelinks">
<tr><td>
<if($page>1)><then>
<div class="priorpage">
<a href="archive/$boardid/<expression>($page - 1)</expression>/board.html">{$lang->items['LANG_ARCHIVE_PRIORPAGE']}</a>
</div>
</then></if>
</td><td>
<if($pages>$page)><then>
<div class="nextpage">
<a href="archive/$boardid/<expression>($page + 1)</expression>/board.html">{$lang->items['LANG_ARCHIVE_NEXTPAGE']}</a>
</div>
</then></if>
</td>
</tr></table>
<div class="copyright">
<a href="http://www.woltlab.de" target="_blank">{$lang->items['LANG_GLOBAL_COPYRIGHT']}</a>
</div>
</div>
</body>
</html>
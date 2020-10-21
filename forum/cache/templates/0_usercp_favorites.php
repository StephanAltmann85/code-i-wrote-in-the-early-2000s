<?php
			/*
			templatepackid: 0
			templatename: usercp_favorites
			*/
			
			$this->templates['usercp_favorites']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_USERCP_TITLE']} | {\$lang->items['LANG_USERCP_FAVORITES']}</title>
\$headinclude

<script type=\\\"text/javascript\\\">
<!--
function who(threadid) {
 window.open(\\\"misc.php?action=whoposted&threadid=\\\"+threadid+\\\"{\$SID_ARG_2ND_UN}\\\", \\\"moo\\\", \\\"toolbar=no,scrollbars=yes,resizable=yes,width=250,height=300\\\");
}
//-->
</script>
</head>
<body>
\$header
 <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"usercp.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_USERCP_TITLE']}</a> &raquo; {\$lang->items['LANG_USERCP_FAVORITES']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:{\$style['tableinwidth']}\\\">
 <tr>
  <td class=\\\"tablecat\\\" align=\\\"left\\\" colspan=\\\"5\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_FAVORITES_SUBSCRIBED_BOARDS']}</b></span></td>
 </tr>
 
 \".((\$boardbit!=\"\") 
  ? (\"
   <tr align=\\\"center\\\">
    <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\">&nbsp;</span></td>
    <td class=\\\"tabletitle\\\" align=\\\"left\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_START_BOARDS']}</b></span></td>
    <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_START_POSTS']}</b></span></td>
    <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_START_THREADS']}</b></span></td>
    <td class=\\\"tabletitle\\\" nowrap=\\\"nowrap\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_START_LASTPOST']}</b></span></td>
   </tr>
  \") 
  : (\"
   <tr>
    <td class=\\\"tablea\\\" align=\\\"left\\\" colspan=\\\"5\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_USERCP_FAVORITES_NO_SUBSCRIBED_BOARDS']}</span></td>
   </tr>
  \")
 ).\"
 
 \$boardbit
</table><br />
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" class=\\\"tableinborder\\\" style=\\\"width:{\$style['tableinwidth']}\\\">
 <tr>
  <td class=\\\"tablecat\\\" align=\\\"left\\\" colspan=\\\"7\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_USERCP_FAVORITES_SUBSCRIBED_THREADS']}</b></span></td>
 </tr>
 
 \".((\$threadbit!=\"\") 
  ? (\"
   <tr align=\\\"center\\\">
    <td class=\\\"tabletitle\\\" colspan=\\\"3\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_BOARD_THREAD']}</b></span></td>
    <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_BOARD_REPLIES']}</b></span></td>
    <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_BOARD_AUTHOR']}</b></span></td>
    <td class=\\\"tabletitle\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_BOARD_VIEWS']}</b></span></td>
    <td class=\\\"tabletitle\\\" nowrap=\\\"nowrap\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_BOARD_LASTPOST']}</b></span></td>
   </tr>
  \") 
  : (\"
   <tr>
    <td class=\\\"tablea\\\" align=\\\"left\\\" colspan=\\\"7\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_USERCP_FAVORITES_NO_NEWPOSTS']}</span></td>
   </tr>
  \")
 ).\"
 
 \$threadbit
</table>
<table style=\\\"width:{\$style['tableinwidth']}\\\">
 <tr>
  <td align=\\\"right\\\"><form method=\\\"get\\\" action=\\\"usercp.php\\\">
  <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
  <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
  <select name=\\\"daysprune\\\">
   <option value=\\\"1000\\\">{\$lang->items['LANG_USERCP_FAVORITES_DAYSPRUNE_1000']}</option>
   <option value=\\\"1500\\\"\$d_select[1500]>{\$lang->items['LANG_USERCP_FAVORITES_DAYSPRUNE_1500']}</option>
   <option value=\\\"1\\\"\$d_select[1]>{\$lang->items['LANG_USERCP_FAVORITES_DAYSPRUNE_1']}</option>
   <option value=\\\"2\\\"\$d_select[2]>{\$lang->items['LANG_USERCP_FAVORITES_DAYSPRUNE_2']}</option>
   <option value=\\\"5\\\"\$d_select[5]>{\$lang->items['LANG_USERCP_FAVORITES_DAYSPRUNE_5']}</option>
   <option value=\\\"10\\\"\$d_select[10]>{\$lang->items['LANG_USERCP_FAVORITES_DAYSPRUNE_10']}</option>
   <option value=\\\"20\\\"\$d_select[20]>{\$lang->items['LANG_USERCP_FAVORITES_DAYSPRUNE_20']}</option>
   <option value=\\\"30\\\"\$d_select[30]>{\$lang->items['LANG_USERCP_FAVORITES_DAYSPRUNE_30']}</option>
   <option value=\\\"45\\\"\$d_select[45]>{\$lang->items['LANG_USERCP_FAVORITES_DAYSPRUNE_45']}</option>
   <option value=\\\"60\\\"\$d_select[60]>{\$lang->items['LANG_USERCP_FAVORITES_DAYSPRUNE_60']}</option>
   <option value=\\\"75\\\"\$d_select[75]>{\$lang->items['LANG_USERCP_FAVORITES_DAYSPRUNE_75']}</option>
   <option value=\\\"100\\\"\$d_select[100]>{\$lang->items['LANG_USERCP_FAVORITES_DAYSPRUNE_100']}</option>
   <option value=\\\"365\\\"\$d_select[365]>{\$lang->items['LANG_USERCP_FAVORITES_DAYSPRUNE_365']}</option>
  </select>&nbsp;<input src=\\\"{\$style['imagefolder']}/go.gif\\\" type=\\\"image\\\" /></form></td>
 </tr>
</table>
\$footer
</body>
</html>";
			?>
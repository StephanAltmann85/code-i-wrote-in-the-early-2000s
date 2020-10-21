<?php
			/*
			templatepackid: 0
			templatename: faq_bbcode
			*/
			
			$this->templates['faq_bbcode']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_FAQ_BBCODES_TITLE']}</title>
\$headinclude
</head>

<body>
 \$header
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; <a href=\\\"misc.php?action=faq{\$SID_ARG_2ND}\\\">{\$lang->items['LANG_FAQ_FAQ']}</a> &raquo; {\$lang->items['LANG_FAQ_BBCODES_TITLE']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br />
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
<tr>
  <td class=\\\"tabletitle\\\" colspan=\\\"2\\\" align=\\\"center\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_FAQ_BBCODES_WHAT']}</b></span></td>
 </tr>
 <tr align=\\\"left\\\" class=\\\"normalfont\\\">
  <td colspan=\\\"2\\\" class=\\\"tablea\\\">{\$lang->items['LANG_FAQ_BBCODES_INTRO']}</td>
 </tr>
 <tr>
  <td class=\\\"tabletitle\\\" colspan=\\\"2\\\" align=\\\"center\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_FAQ_BBCODES_MEANING']}</b></span></td>
 </tr>
\$faq_bbcode_links_bit
  <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>&raquo;</b></span></td>
  <td class=\\\"tableb\\\" style=\\\"width:100%\\\"><span class=\\\"normalfont\\\"><a href=\\\"misc.php?action=bbcode{\$SID_ARG_2ND}#1\\\">[IMG]images/email.gif[/IMG]</a></span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>&raquo;</b></span></td>
  <td class=\\\"tableb\\\" style=\\\"width:100%\\\"><span class=\\\"normalfont\\\"><a href=\\\"misc.php?action=bbcode{\$SID_ARG_2ND}#2\\\">[URL]http://www.woltlab.de[/URL]</a></span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>&raquo;</b></span></td>
  <td class=\\\"tableb\\\" style=\\\"width:100%\\\"><span class=\\\"normalfont\\\"><a href=\\\"misc.php?action=bbcode{\$SID_ARG_2ND}#3\\\">[URL=http://www.woltlab.de]WoltLab[/URL]</a></span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>&raquo;</b></span></td>
  <td class=\\\"tableb\\\" style=\\\"width:100%\\\"><span class=\\\"normalfont\\\"><a href=\\\"misc.php?action=bbcode{\$SID_ARG_2ND}#4\\\">[PHP]Syntax[/PHP]</a></span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>&raquo;</b></span></td>
  <td class=\\\"tableb\\\" style=\\\"width:100%\\\"><span class=\\\"normalfont\\\"><a href=\\\"misc.php?action=bbcode{\$SID_ARG_2ND}#5\\\">[CODE]Syntax[/CODE]</a></span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\"><b>&raquo;</b></span></td>
  <td class=\\\"tableb\\\" style=\\\"width:100%\\\"><span class=\\\"normalfont\\\"><a href=\\\"misc.php?action=bbcode{\$SID_ARG_2ND}#6\\\">[LIST]Liste[/LIST]</a></span></td>
 </tr>
</table><br />
\$faq_bbcode_content
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"center\\\"><a name=\\\"1\\\"></a><span class=\\\"normalfont\\\"><b>[IMG]images/email.gif[/IMG]</b></span></td>
 </tr>
 <tr align=\\\"left\\\" class=\\\"normalfont\\\">
  <td class=\\\"tablea\\\">{\$lang->items['LANG_FAQ_BBCODES_IMG']}</td>
 </tr>
</table><br />

<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"center\\\"><a name=\\\"2\\\"></a><span class=\\\"normalfont\\\"><b>[URL]http://www.woltlab.de[/URL]</b></span></td>
 </tr>
 <tr align=\\\"left\\\" class=\\\"normalfont\\\">
  <td class=\\\"tablea\\\">{\$lang->items['LANG_FAQ_BBCODES_URL']}</td>
 </tr>
</table><br />

<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"center\\\"><a name=\\\"3\\\"></a><span class=\\\"normalfont\\\"><b>[URL=http://www.woltlab.de]WoltLab[/URL]</b></span></td>
 </tr>
 <tr align=\\\"left\\\" class=\\\"normalfont\\\">
  <td class=\\\"tablea\\\">{\$lang->items['LANG_FAQ_BBCODES_URL1']}</td>
 </tr>
</table><br />

<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"center\\\"><a name=\\\"4\\\"></a><span class=\\\"normalfont\\\"><b>[PHP]Syntax[/PHP]</b></span></td>
 </tr>
 <tr align=\\\"left\\\" class=\\\"normalfont\\\">
  <td class=\\\"tablea\\\">
  {\$lang->items['LANG_FAQ_BBCODES_PHP']}

<table align=\\\"center\\\" style=\\\"width:98%\\\">
 <tr>
  <td><span class=\\\"normalfont\\\"><b>php:</b></span></td>
 </tr>
 <tr>
  <td>
   <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" style=\\\"width:100%\\\" class=\\\"tableinborder\\\">
    <tr>
     <td class=\\\"inposttable\\\" nowrap=\\\"nowrap\\\" align=\\\"right\\\"><span class=\\\"smallfont\\\">1:<br />2:<br />3:<br /></span></td>
     <td class=\\\"inposttable\\\" nowrap=\\\"nowrap\\\" align=\\\"left\\\" style=\\\"width:100%\\\"><span class=\\\"smallfont\\\"><span style=\\\"color: #000000\\\">
<span style=\\\"color: #0000CC\\\">&lt;?php
<br />phpinfo</span><span style=\\\"color: #006600\\\">();
<br /></span><span style=\\\"color: #0000CC\\\">?&gt;</span>
</span>
</span></td>
    </tr>
   </table>
  
   
  </td>
 </tr>
</table>

  </td>
 </tr>
</table><br />
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"center\\\"><a name=\\\"5\\\"></a><span class=\\\"normalfont\\\"><b>[CODE]Syntax[/CODE]</b></span></td>
 </tr>
 <tr align=\\\"left\\\" class=\\\"normalfont\\\">
  <td class=\\\"tablea\\\">
  {\$lang->items['LANG_FAQ_BBCODES_CODE']}

<table align=\\\"center\\\" style=\\\"width:98%\\\">
 <tr>
  <td><span class=\\\"normalfont\\\"><b>code:</b></span></td>
 </tr>
 <tr>
  <td>
   <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" style=\\\"width:100%\\\" class=\\\"tableinborder\\\">
    <tr>
     <td class=\\\"inposttable\\\" nowrap=\\\"nowrap\\\" align=\\\"right\\\"><span class=\\\"smallfont\\\">1:<br /></span></td>
     <td class=\\\"inposttable\\\" nowrap=\\\"nowrap\\\" align=\\\"left\\\" style=\\\"width:100%\\\"><span class=\\\"smallfont\\\">!code</span></td>
    </tr>
   </table>
  </td>
 </tr>
</table>

  
  </td>
 </tr>
</table><br />
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"center\\\"><a name=\\\"6\\\"></a><span class=\\\"normalfont\\\"><b>[LIST]Liste[/LIST]</b></span></td>
 </tr>
 <tr align=\\\"left\\\" class=\\\"normalfont\\\">
  <td class=\\\"tablea\\\">
  {\$lang->items['LANG_FAQ_BBCODES_LIST']}
  </td>
 </tr>
</table>
\$footer
</body>
</html>";
			?>
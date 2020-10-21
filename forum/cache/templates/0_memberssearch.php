<?php
			/*
			templatepackid: 0
			templatename: memberssearch
			*/
			
			$this->templates['memberssearch']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | {\$lang->items['LANG_MEMBERS_MBS_TITLE']}</title>
\$headinclude
</head>

<body>
 \$header
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a> &raquo; {\$lang->items['LANG_MEMBERS_MBS_TITLE']}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br /><form method=\\\"get\\\" action=\\\"memberslist.php\\\">
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablecat\\\" align=\\\"left\\\" colspan=\\\"\$colspan\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items['LANG_MEMBERS_MBS_TITLE']}</b> [<a href=\\\"memberslist.php{\$SID_ARG_1ST}\\\">{\$lang->items['LANG_GLOBAL_MEMBERSLIST']}</a>]</span></td>
 </tr>
 \".((isset(\$_REQUEST['send'])) 
  ? (\"
   <tr align=\\\"center\\\">
    \$fieldheader
   </tr>
   \$membersbit
  </table>
  \") 
  : (\"
   <tr>
    <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_MEMBERS_MBS_SEARCHFIELDS']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">\$LANG_SEARCHFIELD_USERNAME</span></td>
    <td class=\\\"tablea\\\"><input class=\\\"input\\\" type=\\\"text\\\" name=\\\"username\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\">\$LANG_SEARCHFIELD_EMAIL</span></td>
    <td class=\\\"tableb\\\"><input class=\\\"input\\\" type=\\\"text\\\" name=\\\"email\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">\$LANG_SEARCHFIELD_TITLE</span></td>
    <td class=\\\"tablea\\\"><input class=\\\"input\\\" type=\\\"text\\\" name=\\\"title\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\">\$LANG_SEARCHFIELD_USERTEXT</span></td>
    <td class=\\\"tableb\\\"><input class=\\\"input\\\" type=\\\"text\\\" name=\\\"usertext\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">\$LANG_SEARCHFIELD_SIGNATURE</span></td>
    <td class=\\\"tablea\\\"><input class=\\\"input\\\" type=\\\"text\\\" name=\\\"signature\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\">\$LANG_SEARCHFIELD_HOMEPAGE</span></td>
    <td class=\\\"tableb\\\"><input class=\\\"input\\\" type=\\\"text\\\" name=\\\"homepage\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">\$LANG_SEARCHFIELD_ICQ</span></td>
    <td class=\\\"tablea\\\"><input class=\\\"input\\\" type=\\\"text\\\" name=\\\"icq\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\">\$LANG_SEARCHFIELD_AIM</span></td>
    <td class=\\\"tableb\\\"><input class=\\\"input\\\" type=\\\"text\\\" name=\\\"aim\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">\$LANG_SEARCHFIELD_YIM</span></td>
    <td class=\\\"tablea\\\"><input class=\\\"input\\\" type=\\\"text\\\" name=\\\"yim\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\">\$LANG_SEARCHFIELD_MSN</span></td>
    <td class=\\\"tableb\\\"><input class=\\\"input\\\" type=\\\"text\\\" name=\\\"msn\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">\$LANG_SEARCHFIELD_GENDER</span></td>
    <td class=\\\"tablea\\\"><select name=\\\"gender\\\">
     <option value=\\\"0\\\"></option>
     <option value=\\\"1\\\">{\$lang->items['LANG_MEMBERS_PROFILE_MALE']}</option>
     <option value=\\\"2\\\">{\$lang->items['LANG_MEMBERS_PROFILE_FEMALE']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_MEMBERS_MBS_USERPOSTS_MORETHEN']}</span></td>
    <td class=\\\"tableb\\\"><input class=\\\"input\\\" type=\\\"text\\\" name=\\\"userposts_morethen\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_MEMBERS_MBS_USERPOSTS_LESSTHEN']}</span></td>
    <td class=\\\"tablea\\\"><input class=\\\"input\\\" type=\\\"text\\\" name=\\\"userposts_lessthen\\\" value=\\\"\\\" maxlength=\\\"255\\\" /></td>
   </tr>
   \$morebit
   <tr align=\\\"left\\\">
    <td class=\\\"tabletitle\\\" colspan=\\\"2\\\"><span class=\\\"smallfont\\\"><b>{\$lang->items['LANG_MEMBERS_MBS_VIEW_AND_SORT']}</b></span></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_MEMBERS_MBS_SORT']}</span></td>
    <td class=\\\"tableb\\\"><select name=\\\"sortby\\\">
     \$sortby_options
    </select> <select name=\\\"sortorder\\\">
     <option value=\\\"ASC\\\">{\$lang->items['LANG_MEMBERS_MBS_ORDER_ASC']}</option>
     <option value=\\\"DESC\\\">{\$lang->items['LANG_MEMBERS_MBS_ORDER_DESC']}</option>
    </select></td>
   </tr>
   <tr align=\\\"left\\\">
    <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">{\$lang->items['LANG_MEMBERS_MBS_USERPERPAGE']}</span></td>
    <td class=\\\"tablea\\\"><input class=\\\"input\\\" type=\\\"text\\\" name=\\\"limit\\\" value=\\\"30\\\" maxlength=\\\"255\\\" /></td>
   </tr>
  </table>
  <p><input class=\\\"input\\\" type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items['LANG_GLOBAL_BUTTON_SEARCH']}\\\" /> <input class=\\\"input\\\" type=\\\"reset\\\" accesskey=\\\"R\\\" value=\\\"{\$lang->items['LANG_GLOBAL_BUTTON_RESET']}\\\" /></p>
  \")
 ).\"

<table align=\\\"center\\\">
 <tr>
  <td><span class=\\\"smallfont\\\">\$pagelink</span></td>
 </tr>
</table>
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"search\\\" />
</form>
\$footer
</body>
</html>";
			?>
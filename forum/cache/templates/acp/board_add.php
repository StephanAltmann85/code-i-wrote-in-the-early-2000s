<?php
/*
acp template
templatename: board_add
*/

$this->templates['acp_board_add']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>
<form method=\\\"post\\\" action=\\\"board.php\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_BOARD_ADD']}</td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_BOARD_GENERAL']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_BOARD_TITLE']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"title\\\" maxlength=\\\"70\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_BOARD_DESCRIPTION']}</b></td>
   <td><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"description\\\"></textarea></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_BOARD_CLASSIFICATION']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_BOARD_ISBOARD']}</b></td>
   <td><select name=\\\"isboard\\\">
    <option value=\\\"1\\\">{\$lang->items['LANG_ACP_BOARD_ASBOARD']}</option>
    <option value=\\\"0\\\">{\$lang->items['LANG_ACP_BOARD_ASCAT']}</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_BOARD_PARENT']}</b></td>
   <td><select name=\\\"parentid\\\">
    \".((checkAdminPermissions(\"a_can_boards_global\")) ? (\"<option value=\\\"0\\\">{\$lang->items['LANG_ACP_BOARD_PARENT_NONE']}</option>\") : (\"\")).\"
    \$parentid_options
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_BOARD_CLOSED']}</b><br />{\$lang->items['LANG_ACP_BOARD_CLOSED_DESC']}</td>
   <td><select name=\\\"closed\\\">
    <option value=\\\"1\\\">{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
    <option value=\\\"0\\\" selected=\\\"selected\\\">{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_BOARD_INVISIBLE']}</b></td>
   <td><select name=\\\"invisible\\\">
    <option value=\\\"2\\\">{\$lang->items['LANG_ACP_BOARD_INVISIBLE_2']}</option>
    <option value=\\\"0\\\" selected=\\\"selected\\\">{\$lang->items['LANG_ACP_BOARD_INVISIBLE_0']}</option>
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_COUNTUSERPOSTS']}</b><br />{\$lang->items['LANG_ACP_BOARD_COUNTUSERPOSTS_DESC']}</td>
    <td><select name=\\\"countuserposts\\\">
     <option value=\\\"1\\\">{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
     <option value=\\\"0\\\">{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
    </select></td>
   </tr>
  <tr class=\\\"secondrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_SHOWINARCHIVE']}</b></td>
    <td><select name=\\\"showinarchive\\\">
     <option value=\\\"1\\\">{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
     <option value=\\\"0\\\">{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
    </select></td>
   </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_BOARD_EXTERNALURL']}</b><br />{\$lang->items['LANG_ACP_BOARD_EXTERNALURL_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"externalurl\\\" value=\\\"\\\" size=\\\"55\\\" maxlength=\\\"255\\\" /></td>
  </tr>
   <tr class=\\\"tblsection\\\">
    <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_BOARD_VIEWOPTIONS']}</td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_DAYSPRUNE']}</b></td>
    <td><select name=\\\"daysprune\\\">
     <option value=\\\"0\\\">{\$lang->items['LANG_ACP_BOARD_BOARDDEFAULT']}</option>
     <option value=\\\"1500\\\">{\$lang->items['LANG_BOARD_DAYSPRUNE_1500']}</option>
     <option value=\\\"1\\\">{\$lang->items['LANG_BOARD_DAYSPRUNE_1']}</option>
     <option value=\\\"2\\\">{\$lang->items['LANG_BOARD_DAYSPRUNE_2']}</option>
     <option value=\\\"5\\\">{\$lang->items['LANG_BOARD_DAYSPRUNE_5']}</option>
     <option value=\\\"10\\\">{\$lang->items['LANG_BOARD_DAYSPRUNE_10']}</option>
     <option value=\\\"20\\\">{\$lang->items['LANG_BOARD_DAYSPRUNE_20']}</option>
     <option value=\\\"30\\\">{\$lang->items['LANG_BOARD_DAYSPRUNE_30']}</option>
     <option value=\\\"45\\\">{\$lang->items['LANG_BOARD_DAYSPRUNE_45']}</option>
     <option value=\\\"60\\\">{\$lang->items['LANG_BOARD_DAYSPRUNE_60']}</option>
     <option value=\\\"75\\\">{\$lang->items['LANG_BOARD_DAYSPRUNE_75']}</option>
     <option value=\\\"100\\\">{\$lang->items['LANG_BOARD_DAYSPRUNE_100']}</option>
     <option value=\\\"365\\\">{\$lang->items['LANG_BOARD_DAYSPRUNE_365']}</option>
     <option value=\\\"1000\\\">{\$lang->items['LANG_BOARD_DAYSPRUNE_1000']}</option>
    </select></td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_SORTFIELD']}</b></td>
    <td><select name=\\\"sortfield\\\">
     <option value=\\\"\\\">{\$lang->items['LANG_ACP_BOARD_BOARDDEFAULT']}</option>
     <option value=\\\"prefix\\\">{\$lang->items['LANG_BOARD_SORTFIELD_PREFIX']}</option>
     <option value=\\\"topic\\\">{\$lang->items['LANG_BOARD_SORTFIELD_TOPIC']}</option>
     <option value=\\\"starttime\\\">{\$lang->items['LANG_BOARD_SORTFIELD_STARTTIME']}</option>
     <option value=\\\"replycount\\\">{\$lang->items['LANG_BOARD_SORTFIELD_REPLYCOUNT']}</option>
     <option value=\\\"starter\\\">{\$lang->items['LANG_BOARD_SORTFIELD_STARTER']}</option>
     <option value=\\\"views\\\">{\$lang->items['LANG_BOARD_SORTFIELD_VIEWS']}</option>
     <option value=\\\"vote\\\">{\$lang->items['LANG_BOARD_SORTFIELD_VOTE']}</option>
     <option value=\\\"lastposttime\\\">{\$lang->items['LANG_BOARD_SORTFIELD_LASTPOSTTIME']}</option>
     <option value=\\\"lastposter\\\">{\$lang->items['LANG_BOARD_SORTFIELD_LASTPOSTER']}</option>
    </select></td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_SORTORDER']}</b></td>
    <td><select name=\\\"sortorder\\\">
     <option value=\\\"\\\">{\$lang->items['LANG_ACP_BOARD_BOARDDEFAULT']}</option>
     <option value=\\\"ASC\\\">{\$lang->items['LANG_BOARD_SORTORDER_ASC']}</option>
     <option value=\\\"DESC\\\">{\$lang->items['LANG_BOARD_SORTORDER_DESC']}</option>
    </select></td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_THREADSPERPAGE']}</b><br />{\$lang->items['LANG_ACP_BOARD_DEFAULTINPUT']}</td>
    <td><input type=\\\"text\\\" name=\\\"threadsperpage\\\" maxlength=\\\"3\\\" value=\\\"0\\\" /></td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_POSTSPERPAGE']}</b><br />{\$lang->items['LANG_ACP_BOARD_DEFAULTINPUT']}</td>
    <td><input type=\\\"text\\\" name=\\\"postsperpage\\\" maxlength=\\\"3\\\" value=\\\"0\\\" /></td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_POSTORDER']}</b></td>
    <td><select name=\\\"postorder\\\">
     <option value=\\\"1\\\">{\$lang->items['LANG_ACP_BOARD_POSTORDER_1']}</option>
     <option value=\\\"0\\\" selected=\\\"selected\\\">{\$lang->items['LANG_ACP_BOARD_POSTORDER_0']}</option>
    </select></td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_HOT_REPLIES']}</b><br />{\$lang->items['LANG_ACP_BOARD_DEFAULTINPUT']}</td>
    <td><input type=\\\"text\\\" name=\\\"hotthread_reply\\\" maxlength=\\\"3\\\" value=\\\"0\\\" /></td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_HOT_HITS']}</b><br />{\$lang->items['LANG_ACP_BOARD_DEFAULTINPUT']}</td>
    <td><input type=\\\"text\\\" name=\\\"hotthread_view\\\" maxlength=\\\"5\\\" value=\\\"0\\\" /></td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_ALLOWRATINGS']}</b></td>
    <td><select name=\\\"allowratings\\\">
     <option value=\\\"1\\\">{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
     <option value=\\\"0\\\">{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
    </select></td>
   </tr>
   <tr class=\\\"tblsection\\\">
    <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_BOARD_MODERATION']}</td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_MODERATION_THREAD']}</b><br />{\$lang->items['LANG_ACP_BOARD_MODERATION_THREAD_DESC']}</td>
    <td><select name=\\\"moderatenewthreads\\\">
     <option value=\\\"1\\\">{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
     <option value=\\\"0\\\" selected=\\\"selected\\\">{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
    </select></td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_MODERATION_POST']}</b><br />{\$lang->items['LANG_ACP_BOARD_MODERATION_POST_DESC']}</td>
    <td><select name=\\\"moderatenewposts\\\">
     <option value=\\\"1\\\">{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
     <option value=\\\"0\\\" selected=\\\"selected\\\">{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
    </select></td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_DEFINE_DONE']}</b><br />{\$lang->items['LANG_ACP_BOARD_DEFINE_DONE_DESC']}</td>
    <td><select name=\\\"define_threads_done\\\">
     <option value=\\\"1\\\">{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
     <option value=\\\"0\\\" selected=\\\"selected\\\">{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
    </select></td>
   </tr>
   <tr class=\\\"tblsection\\\">
    <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_BOARD_PREFIX']}</td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_PREFIXUSE']}</b><br />{\$lang->items['LANG_ACP_BOARD_PREFIXUSE_DESC']}</td>
    <td><select name=\\\"prefixuse\\\">
     <option value=\\\"0\\\">{\$lang->items['LANG_ACP_BOARD_PREFIXUSE_0']}</option>
     <option value=\\\"1\\\">{\$lang->items['LANG_ACP_BOARD_PREFIXUSE_1']}</option>
     <option value=\\\"2\\\">{\$lang->items['LANG_ACP_BOARD_PREFIXUSE_2']}</option>
     <option value=\\\"3\\\">{\$lang->items['LANG_ACP_BOARD_PREFIXUSE_3']}</option>
    </select></td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_PREFIXREQUIRED']}</b><br />{\$lang->items['LANG_ACP_BOARD_PREFIXREQUIRED_DESC']}</td>
    <td><select name=\\\"prefixrequired\\\">
     <option value=\\\"0\\\">{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
     <option value=\\\"1\\\">{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
    </select></td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_BOARD_PREFIXINPUT']}</b><br />{\$lang->items['LANG_ACP_BOARD_PREFIXINPUT_DESC']}</td>
    <td><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"prefix\\\"></textarea></td>
   </tr>
   <tr class=\\\"tblsection\\\">
    <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_BOARD_THREADTEMPLATE']}</td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_THREADTEMPLATEUSE']}</b><br />{\$lang->items['LANG_ACP_BOARD_THREADTEMPLATEUSE_DESC']}</td>
    <td><select name=\\\"threadtemplateuse\\\">
     <option value=\\\"0\\\">{\$lang->items['LANG_ACP_BOARD_THREADTEMPLATEUSE_0']}</option>
     <option value=\\\"1\\\">{\$lang->items['LANG_ACP_BOARD_THREADTEMPLATEUSE_1']}</option>
     <option value=\\\"2\\\">{\$lang->items['LANG_ACP_BOARD_THREADTEMPLATEUSE_2']}</option>
    </select></td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_BOARD_THREADTEMPLATEINPUT']}</b><br />{\$lang->items['LANG_ACP_BOARD_THREADTEMPLATEINPUT_DESC']}</td>
    <td><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"threadtemplate\\\"></textarea></td>
   </tr>
   <tr class=\\\"tblsection\\\">
    <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_BOARD_POSTTEMPLATE']}</td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_POSTTEMPLATEUSE']}</b><br />{\$lang->items['LANG_ACP_BOARD_POSTTEMPLATEUSE_DESC']}</td>
    <td><select name=\\\"posttemplateuse\\\">
     <option value=\\\"0\\\">{\$lang->items['LANG_ACP_BOARD_POSTTEMPLATEUSE_0']}</option>
     <option value=\\\"1\\\">{\$lang->items['LANG_ACP_BOARD_POSTTEMPLATEUSE_1']}</option>
     <option value=\\\"2\\\">{\$lang->items['LANG_ACP_BOARD_POSTTEMPLATEUSE_2']}</option>
    </select></td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_BOARD_POSTTEMPLATEINPUT']}</b><br />{\$lang->items['LANG_ACP_BOARD_POSTTEMPLATEINPUT_DESC']}</td>
    <td><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"posttemplate\\\"></textarea></td>
   </tr>
   <tr class=\\\"tblsection\\\">
    <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_BOARD_PASSWORDLOCK']}</td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_PASSWORD']}</b></td>
    <td><input type=\\\"password\\\" name=\\\"password\\\" maxlength=\\\"25\\\" /></td>
   </tr>
   <tr class=\\\"tblsection\\\">
    <td colspan=\\\"2\\\"><b>{\$lang->items['LANG_ACP_BOARD_STYLEOPTIONS']}</b></td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_STYLE_SET']}</b></td>
    <td><select name=\\\"style_set\\\">
     \$style_options
    </select></td>
   </tr>
   <tr class=\\\"firstrow\\\">
    <td><b>{\$lang->items['LANG_ACP_BOARD_ENFORCESTYLE']}</b><br />{\$lang->items['LANG_ACP_BOARD_ENFORCESTYLE_DESC']}</td>
    <td><select name=\\\"enforcestyle\\\">
     <option value=\\\"1\\\">{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
     <option value=\\\"0\\\" selected=\\\"selected\\\">{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
    </select></td>
   </tr>
   <tr class=\\\"secondrow\\\">
    <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
   </tr>
  </table>
 </form>
</body>
</html>";
?>
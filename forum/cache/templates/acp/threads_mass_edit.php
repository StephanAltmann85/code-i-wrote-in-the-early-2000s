<?php
/*
acp template
templatename: threads_mass_edit
*/

$this->templates['acp_threads_mass_edit']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>
<form action=\\\"threads.php\\\" method=\\\"post\\\">
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 
 <p>{\$lang->items['LANG_ACP_THREADS_MASS_EDIT_DESC']}</p>
 
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_THREADS_MASS_EDIT']}</td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_THREADS_CONDITIONS']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_THREADS_CONDITION_STARTTIME']}</td>
   <td><input type=\\\"text\\\" name=\\\"starttime\\\" value=\\\"\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>{\$lang->items['LANG_ACP_THREADS_CONDITION_LASTPOSTTIME']}</td>
   <td><input type=\\\"text\\\" name=\\\"lastposttime\\\" value=\\\"\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_THREADS_CONDITION_REPLIES_MORETHAN']}</td>
   <td><input type=\\\"text\\\" name=\\\"replies_morethan\\\" value=\\\"\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>{\$lang->items['LANG_ACP_THREADS_CONDITION_REPLIES_LESSTHAN']}</td>
   <td><input type=\\\"text\\\" name=\\\"replies_lessthan\\\" value=\\\"\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_THREADS_CONDITION_STARTER']}</td>
   <td><input type=\\\"text\\\" name=\\\"starter\\\" value=\\\"\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>{\$lang->items['LANG_ACP_THREADS_CONDITION_USERNAME']}</td>
   <td><input type=\\\"text\\\" name=\\\"username\\\" value=\\\"\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_THREADS_CONDITION_CLOSED']}</td>
   <td><select name=\\\"closed\\\">
    <option value=\\\"\\\"></option>
    <option value=\\\"0\\\">{\$lang->items['LANG_ACP_THREADS_CONDITION_CLOSED_0']}</option>
    <option value=\\\"1\\\">{\$lang->items['LANG_ACP_THREADS_CONDITION_CLOSED_1']}</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>{\$lang->items['LANG_ACP_THREADS_CONDITION_PREFIX']}</td>
   <td><input type=\\\"text\\\" name=\\\"prefix\\\" value=\\\"\\\" /></td>
  </tr> 
  <tr class=\\\"firstrow\\\">
   <td valign=\\\"top\\\">{\$lang->items['LANG_ACP_THREADS_CONDITION_BOARD']}</td>
   <td><select name=\\\"boardids[]\\\" size=\\\"10\\\" multiple=\\\"multiple\\\">\$boardid_options</select></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_THREADS_ACTION']}</td>
  </tr>
  
  <tr class=\\\"firstrow\\\">
   <td><input type=\\\"radio\\\" name=\\\"threadaction\\\" id=\\\"radio1\\\" value=\\\"delete\\\" /><label for=\\\"radio1\\\"> {\$lang->items['LANG_ACP_THREADS_ACTION_DELETE']}</label></td>
   <td>&nbsp;</td>
  </tr>
  
  <tr class=\\\"secondrow\\\">
   <td><input type=\\\"radio\\\" name=\\\"threadaction\\\" id=\\\"radio2\\\" value=\\\"move\\\" /><label for=\\\"radio2\\\">{\$lang->items['LANG_ACP_THREADS_ACTION_MOVE']}</label><br /><br /><b>{\$lang->items['LANG_ACP_THREADS_MOVE_TO']}</b><br /><select name=\\\"newboardid\\\">\$boardid_options</select></td>
   <td><input type=\\\"radio\\\" name=\\\"movethread\\\" id=\\\"radio3\\\" value=\\\"onlymove\\\" /><label for=\\\"radio3\\\">&nbsp;{\$lang->items['LANG_ACP_THREADS_ONLYMOVE']}</label><br />
 <input type=\\\"radio\\\" name=\\\"movethread\\\" id=\\\"radio4\\\" value=\\\"movewithredirect\\\" checked=\\\"checked\\\" /><label for=\\\"radio4\\\">&nbsp;{\$lang->items['LANG_ACP_THREADS_MOVEWITHREDIRECT']}</label></td>
  </tr>
  
  <tr class=\\\"firstrow\\\">
   <td><input type=\\\"radio\\\" name=\\\"threadaction\\\" id=\\\"radio5\\\" value=\\\"close\\\" /><label for=\\\"radio5\\\"> {\$lang->items['LANG_ACP_THREADS_ACTION_CLOSE']}</label></td>
   <td>&nbsp;</td>
  </tr>
  
  <tr class=\\\"secondrow\\\">
   <td><input type=\\\"radio\\\" name=\\\"threadaction\\\" id=\\\"radio6\\\" value=\\\"open\\\" /><label for=\\\"radio6\\\"> {\$lang->items['LANG_ACP_THREADS_ACTION_OPEN']}</label></td>
   <td>&nbsp;</td>
  </tr>
  
  <tr class=\\\"firstrow\\\">
   <td><input type=\\\"radio\\\" name=\\\"threadaction\\\" id=\\\"radio7\\\" value=\\\"unsubscribe\\\" /><label for=\\\"radio7\\\"> {\$lang->items['LANG_ACP_THREADS_ACTION_UNSUBSCRIBE']}</label></td>
   <td>&nbsp;</td>
  </tr>
  
  <tr class=\\\"secondrow\\\">
   <td align=\\\"center\\\" colspan=\\\"2\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_START']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
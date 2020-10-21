<?php
/*
acp template
templatename: bbcodes_edit
*/

$this->templates['acp_bbcodes_edit']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>
<form method=\\\"post\\\" action=\\\"bbcodes.php\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<input type=\\\"hidden\\\" name=\\\"bbcodeid\\\" value=\\\"\$bbcodeid\\\" />
<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_BBCODES_EDIT']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_BBCODES_TAG']}:</b></td>
   <td><input type=\\\"text\\\" name=\\\"bbcodetag\\\" value=\\\"\$bbcode[bbcodetag]\\\" maxlength=\\\"250\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_BBCODES_REPLACEMENT']}</b><br />{\$lang->items['LANG_ACP_BBCODES_REPLACEMENT_DESC']}</td>
   <td><textarea cols=\\\"50\\\" rows=\\\"5\\\" name=\\\"bbcodereplacement\\\">\$bbcode[bbcodereplacement]</textarea></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_BBCODES_EXAMPLE']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"bbcodeexample\\\" value=\\\"\$bbcode[bbcodeexample]\\\" maxlength=\\\"250\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_BBCODES_EXPLANATION']}</b></td>
   <td><textarea cols=\\\"50\\\" rows=\\\"5\\\" name=\\\"bbcodeexplanation\\\">\$bbcode[bbcodeexplanation]</textarea></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_BBCODES_PARAMS']}</b></td>
   <td><select name=\\\"params\\\">
    <option value=\\\"1\\\"\$sel_params[1]>1</option>
    <option value=\\\"2\\\"\$sel_params[2]>2</option>
    <option value=\\\"3\\\"\$sel_params[3]>3</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_BBCODES_MULTIUSE']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"multiuse\\\" value=\\\"\$bbcode[multiuse]\\\" maxlength=\\\"3\\\" /></td>
  </tr>
  
  \".((\$wbbuserdata['acpmode']>=2) 
  ? (\"
  
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_BBCODES_PATTERN1']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"pattern1\\\" value=\\\"\$bbcode[pattern1]\\\" maxlength=\\\"100\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_BBCODES_PATTERN2']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"pattern2\\\" value=\\\"\$bbcode[pattern2]\\\" maxlength=\\\"100\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_BBCODES_PATTERN3']}</b></td>
   <td><input type=\\\"text\\\" name=\\\"pattern3\\\" value=\\\"\$bbcode[pattern3]\\\" maxlength=\\\"100\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_BBCODES_EVAL_REPLACEMENT']}</b></td>
   <td><select name=\\\"eval_replacement\\\">
    <option value=\\\"1\\\"\$sel_eval_replacement[1]>{\$lang->items['LANG_ACP_GLOBAL_YES']}</option>
    <option value=\\\"0\\\"\$sel_eval_replacement[0]>{\$lang->items['LANG_ACP_GLOBAL_NO']}</option>
   </select></td>
  </tr>
  
  \") 
  : (\"
  
  <input type=\\\"hidden\\\" name=\\\"pattern1\\\" value=\\\"\$bbcode[pattern1]\\\" />
  <input type=\\\"hidden\\\" name=\\\"pattern2\\\" value=\\\"\$bbcode[pattern2]\\\" />
  <input type=\\\"hidden\\\" name=\\\"pattern3\\\" value=\\\"\$bbcode[pattern3]\\\" />
  <input type=\\\"hidden\\\" name=\\\"eval_replacement\\\" value=\\\"\$bbcode[eval_replacement]\\\" />
  
  \")
  ).\"
  
  <tr class=\\\"firstrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
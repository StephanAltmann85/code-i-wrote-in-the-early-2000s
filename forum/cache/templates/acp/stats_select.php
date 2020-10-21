<?php
/*
acp template
templatename: stats_select
*/

$this->templates['acp_stats_select']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title></title>
<meta http-equiv=\\\"content-type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
</head>

<body>

<form method=\\\"post\\\" action=\\\"otherstuff.php\\\">
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"showstats\\\" />
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_GLOBAL_MENU_OTHERSTUFF_STATS']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TYPE']}</td>
   <td><select name=\\\"type\\\">
    <option value=\\\"1\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TYPE1']}</option>
    <option value=\\\"2\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TYPE2']}</option>
    <option value=\\\"3\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TYPE3']}</option>
    <option value=\\\"4\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TYPE4']}</option>
    <option value=\\\"5\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TYPE5']}</option>
   </select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>{\$lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_FROM_DAY']}</td>
   <td><select name=\\\"from_day\\\">\$from_day</select> <select name=\\\"from_month\\\">\$from_month</select> <select name=\\\"from_year\\\">\$from_year</select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TO_DAY']}</td>
   <td><select name=\\\"to_day\\\">\$to_day</select> <select name=\\\"to_month\\\">\$to_month</select> <select name=\\\"to_year\\\">\$to_year</select></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td>{\$lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TIMEORDER']}</td>
   <td><select name=\\\"timeorder\\\">
    <option value=\\\"1\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TIMEORDER1']}</option>
    <option value=\\\"2\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TIMEORDER2']}</option>
    <option value=\\\"3\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_TIMEORDER3']}</option>
   </select></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_SORTORDER']}</td>
   <td><select name=\\\"sortorder\\\">
    <option value=\\\"asc\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_SORTORDER_ASC']}</option>
    <option value=\\\"desc\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_STATS_SELECT_SORTORDER_DESC']}</option>
   </select></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_START']}\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
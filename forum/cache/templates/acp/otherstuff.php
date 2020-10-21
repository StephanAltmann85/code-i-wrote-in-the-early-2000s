<?php
/*
acp template
templatename: otherstuff
*/

$this->templates['acp_otherstuff']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title>\$master_board_name | {\$lang->items['LANG_ACP_OTHERSTUFF']}</title>
<meta http-equiv=\\\"content-type\\\" content=\\\"text/html;charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />

<script type=\\\"text/javascript\\\">
 <!--
  function update(action,perpage,taskname) {
   if(parent.working.document.bbform) {
    parent.workingtop.location.href='misc.php?sid=\$session[hash]&action=workingtop&taskname='+taskname;
    parent.working.location.href='otherstuff.php?sid=\$session[hash]&action='+action+'&perpage='+perpage;
    window.location.href='otherstuff.php?sid=\$session[hash]&action=doing';
   }
   else alert('{\$lang->items['LANG_ACP_OTHERSTUFF_WORKING_ALREADYWORKING']}'); 
  }
 //-->
</script>
</head>

<body>

\".((checkAdminPermissions(\"a_can_otherstuff_ranks\")) 
? (\"
<form name=\\\"form1\\\" action=\\\"#\\\" method=\\\"post\\\">
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_RANKS']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_OTHERSTUFF_INTERVAL']}</b><br />{\$lang->items['LANG_ACP_OTHERSTUFF_RANKS_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"perpage\\\" value=\\\"500\\\" maxlength=\\\"4\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_OTHERSTUFF_SUBMITFORM']}\\\" onclick=\\\"update(this.form.action.value,this.form.perpage.value,'{\$lang->items['LANG_ACP_OTHERSTUFF_RANKS']}')\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"ranks\\\" />
</form><br />
\") : (\"\")
).\"

\".((checkAdminPermissions(\"a_can_otherstuff_threads\")) 
? (\"
<form name=\\\"form2\\\" action=\\\"#\\\" method=\\\"post\\\">
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_THREADS']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_OTHERSTUFF_INTERVAL']}</b><br />{\$lang->items['LANG_ACP_OTHERSTUFF_THREADS_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"perpage\\\" value=\\\"500\\\" maxlength=\\\"4\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_OTHERSTUFF_SUBMITFORM']}\\\" onclick=\\\"update(this.form.action.value,this.form.perpage.value,'{\$lang->items['LANG_ACP_OTHERSTUFF_THREADS']}')\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"threads\\\" />
</form><br />
\") : (\"\")
).\"

\".((checkAdminPermissions(\"a_can_otherstuff_boards\")) 
? (\"
<form name=\\\"form3\\\" action=\\\"#\\\" method=\\\"post\\\">
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_BOARDS']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_OTHERSTUFF_INTERVAL']}</b><br />{\$lang->items['LANG_ACP_OTHERSTUFF_BOARDS_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"perpage\\\" value=\\\"100\\\" maxlength=\\\"4\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_OTHERSTUFF_SUBMITFORM']}\\\" onclick=\\\"update(this.form.action.value,this.form.perpage.value,'{\$lang->items['LANG_ACP_OTHERSTUFF_BOARDS']}')\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"boards\\\" />
</form><br />
\") : (\"\")
).\"

\".((checkAdminPermissions(\"a_can_otherstuff_reindex\") || checkAdminPermissions(\"a_can_otherstuff_delindex\")) 
? (\"
<form name=\\\"form4\\\" action=\\\"#\\\" method=\\\"post\\\">
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_REINDEX']}</td>
  </tr>
  \".((checkAdminPermissions(\"a_can_otherstuff_reindex\")) 
  ? (\"
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_OTHERSTUFF_REINDEX_INTERVAL']}</b><br />{\$lang->items['LANG_ACP_OTHERSTUFF_REINDEX_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"perpage\\\" value=\\\"100\\\" maxlength=\\\"4\\\" /></td>
  </tr>
  \") : (\"\")
  ).\"
  <tr class=\\\"secondrow\\\">
   <td><b>{\$lang->items['LANG_ACP_OTHERSTUFF_REINDEXPOSTS']}</b></td>
   <td>\$reindexposts</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_REINDEX_HINT']} \".((checkAdminPermissions(\"a_can_otherstuff_delindex\")) ? (\"<a href=\\\"otherstuff.php?sid=\$session[hash]&amp;action=delindex\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_DELINDEX']}</a>\") : (\"\")).\"</td>
  </tr>
  \".((checkAdminPermissions(\"a_can_otherstuff_reindex\")) 
  ? (\"
  <tr class=\\\"secondrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_OTHERSTUFF_SUBMITFORM']}\\\" onclick=\\\"update(this.form.action.value,this.form.perpage.value,'{\$lang->items['LANG_ACP_OTHERSTUFF_REINDEX']}')\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
  \") : (\"\")
  ).\"
 </table>
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"reindex\\\" />
</form><br />
\") : (\"\")
).\"

\".((checkAdminPermissions(\"a_can_otherstuff_userposts\")) 
? (\"
<form name=\\\"form5\\\" action=\\\"#\\\" method=\\\"post\\\">
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_USERPOSTS']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_OTHERSTUFF_INTERVAL']}</b><br />{\$lang->items['LANG_ACP_OTHERSTUFF_USERPOSTS_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"perpage\\\" value=\\\"100\\\" maxlength=\\\"4\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_OTHERSTUFF_SUBMITFORM']}\\\" onclick=\\\"update(this.form.action.value,this.form.perpage.value,'{\$lang->items['LANG_ACP_OTHERSTUFF_USERPOSTS']}')\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"userposts\\\" />
</form><br />
\") : (\"\")
).\"

\".((checkAdminPermissions(\"a_can_otherstuff_updatestats\")) 
? (\"
<form name=\\\"form6\\\" action=\\\"#\\\" method=\\\"post\\\">
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td>{\$lang->items['LANG_ACP_OTHERSTUFF_UPDATESTATS']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td align=\\\"center\\\"><input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_OTHERSTUFF_SUBMITFORM']}\\\" onclick=\\\"window.location.href='otherstuff.php?sid=\$session[hash]&amp;action=updatestats';\\\" /></td>
  </tr>
 </table>
</form><br />
\") : (\"\")
).\"

\".((checkAdminPermissions(\"a_can_users_edit\")) 
? (\"
<form name=\\\"form7\\\" action=\\\"#\\\" method=\\\"post\\\">
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td>{\$lang->items['LANG_ACP_OTHERSTUFF_PASSWORD_GENERATE']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td>{\$lang->items['LANG_ACP_OTHERSTUFF_PASSWORD_GENERATE_DESC']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td align=\\\"center\\\"><input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_START']}\\\" onclick=\\\"update(this.form.action.value,100,'{\$lang->items['LANG_ACP_OTHERSTUFF_PASSWORD_GENERATE']}')\\\" /></td>
  </tr>
 </table>
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"password_generate\\\" />
</form><br />
\") : (\"\")
).\"


\".((checkAdminPermissions(\"a_can_otherstuff_thumbnails\")) 
? (\"
<form name=\\\"form8\\\" action=\\\"#\\\" method=\\\"post\\\">
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_THUMBNAILS']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_OTHERSTUFF_INTERVAL']}</b><br />{\$lang->items['LANG_ACP_OTHERSTUFF_THUMBNAILS_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"perpage\\\" value=\\\"5\\\" maxlength=\\\"4\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_OTHERSTUFF_SUBMITFORM']}\\\" onclick=\\\"update(this.form.action.value,this.form.perpage.value,'{\$lang->items['LANG_ACP_OTHERSTUFF_THUMBNAILS']}')\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"thumbnails\\\" />
</form><br />
\") : (\"\")
).\"

\".((checkAdminPermissions(\"a_can_otherstuff_pmcounters\")) 
? (\"
<form name=\\\"form9\\\" action=\\\"#\\\" method=\\\"post\\\">
 <table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"2\\\">{\$lang->items['LANG_ACP_OTHERSTUFF_PMCOUNTERS']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td><b>{\$lang->items['LANG_ACP_OTHERSTUFF_INTERVAL']}</b><br />{\$lang->items['LANG_ACP_OTHERSTUFF_PMCOUNTERS_DESC']}</td>
   <td><input type=\\\"text\\\" name=\\\"perpage\\\" value=\\\"100\\\" maxlength=\\\"4\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td colspan=\\\"2\\\" align=\\\"center\\\"><input type=\\\"button\\\" value=\\\"{\$lang->items['LANG_ACP_OTHERSTUFF_SUBMITFORM']}\\\" onclick=\\\"update(this.form.action.value,this.form.perpage.value,'{\$lang->items['LANG_ACP_OTHERSTUFF_PMCOUNTERS']}')\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"pmcounters\\\" />
</form><br />
\") : (\"\")
).\"


</body>
</html>";
?>
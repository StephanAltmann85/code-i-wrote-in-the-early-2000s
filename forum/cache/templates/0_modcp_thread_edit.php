<?php
			/*
			templatepackid: 0
			templatename: modcp_thread_edit
			*/
			
			$this->templates['modcp_thread_edit']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
<title>\$master_board_name | \$thread[topic] | {\$lang->items[LANG_MODCP_THREAD_EDIT]}</title>
\$headinclude
<script type=\\\"text/javascript\\\">
function announce()
{
	document.mform.announce.value='1';
	document.mform.submit();
}
</script>
</head>

<body>
\$header
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tablea\\\"><table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:100%\\\">
   <tr class=\\\"tablea_fc\\\">
    <td align=\\\"left\\\"><span class=\\\"smallfont\\\"><b><a href=\\\"index.php{\$SID_ARG_1ST}\\\">\$master_board_name</a>\$navbar &raquo; </b>\".((\$thread['prefix']!=\"\") ? (\"<span class=\\\"prefix\\\">\$thread[prefix]</span> \") : (\"\")).\"<b> <a href=\\\"thread.php?threadid=\$threadid{\$SID_ARG_2ND}\\\">\$thread[topic]</a> &raquo; {\$lang->items[LANG_MODCP_THREAD_EDIT]}</b></span></td>
    <td align=\\\"right\\\"><span class=\\\"smallfont\\\"><b>\$usercbar</b></span></td>
   </tr>
  </table></td>
 </tr>
</table><br /><form action=\\\"modcp.php\\\" method=\\\"post\\\" name=\\\"mform\\\">
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
 <input type=\\\"hidden\\\" name=\\\"threadid\\\" value=\\\"\$threadid\\\" />
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
 <input type=\\\"hidden\\\" name=\\\"announce\\\" value=\\\"\\\" />
 
<table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
 <tr>
  <td class=\\\"tabletitle\\\" align=\\\"left\\\" colspan=\\\"2\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items[LANG_MODCP_THREAD_EDIT]}</b></span></td>
 </tr>
 <tr align=\\\"left\\\">
  <td class=\\\"tableb\\\"><span class=\\\"normalfont\\\"><b>{\$lang->items[LANG_MODCP_THREAD]}</b></span></td>
  <td class=\\\"tableb\\\">\$select_prefix<input class=\\\"input\\\" type=\\\"text\\\" name=\\\"topic\\\" value=\\\"\$thread[topic]\\\" size=\\\"40\\\" maxlength=\\\"100\\\" /></td>
 </tr>
 \".((checkmodpermissions(\"m_can_thread_close\") || (\$isuser && \$wbbuserdata['can_close_own_topic']==1)) 
 ? (\"
 <tr align=\\\"left\\\">
  <td class=\\\"tablea\\\"><span class=\\\"normalfont\\\">{\$lang->items[LANG_MODCP_OPTIONS]}</span></td>
  <td class=\\\"tablea\\\"><input type=\\\"checkbox\\\" id=\\\"checkbox1\\\" name=\\\"closed\\\" value=\\\"1\\\"\$checked /><span class=\\\"normalfont\\\"><label for=\\\"checkbox1\\\"> {\$lang->items[LANG_MODCP_THREAD_CLOSED]}</label></span></td>
 </tr>
 \") : (\"\")
 ).\"
 \$change_important
 \$remove_redirect
 \$newthread_icons
</table>
<p align=\\\"center\\\">
 <input class=\\\"input\\\" name=\\\"submitbutton\\\" type=\\\"submit\\\" accesskey=\\\"S\\\" value=\\\"{\$lang->items[LANG_MODCP_EDIT_THREAD]}\\\" />
 <input class=\\\"input\\\" type=\\\"reset\\\" accesskey=\\\"R\\\" value=\\\"{\$lang->items[LANG_MODCP_BACK]}\\\" />
</p>
</form>
\$footer
</body>
</html>";
			?>
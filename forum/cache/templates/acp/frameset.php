<?php
/*
acp template
templatename: frameset
*/

$this->templates['acp_frameset']="<!--<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Frameset//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\\\">-->
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
<head>
\".((\$wbbuserdata['a_acp_or_mcp']==1) 
	? (\"
		<title>\$master_board_name | {\$lang->items['LANG_ACP_GLOBAL_ACP']}</title>
	\") 
	: (\"
		<title>\$master_board_name | {\$lang->items['LANG_ACP_GLOBAL_MODCP']}</title>
	\")
).\"
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />

</head>
\".((checkAdminPermissions(\"a_can_users_edit\") || checkAdminPermissions(\"a_can_users_delete\") || checkAdminPermissions(\"a_can_users_merge\") || checkAdminPermissions(\"a_can_users_access\") || checkAdminPermissions(\"a_can_users_other\")) 
	? (\"
		<frameset cols=\\\"*,2,270\\\" border=\\\"0\\\" frameborder=\\\"no\\\" framespacing=\\\"0\\\">
				<frameset rows=\\\"20,*\\\" border=\\\"0\\\" frameborder=\\\"no\\\" framespacing=\\\"0\\\">
					<frame name=\\\"top\\\" src=\\\"misc.php?action=top&amp;sid=\$session[hash]\\\" marginwidth=\\\"0\\\" marginheight=\\\"0\\\" frameborder=\\\"0\\\" scrolling=\\\"no\\\" noresize=\\\"noresize\\\" />	
					<frame name=\\\"main\\\" src=\\\"\".((\$url) ? (\"\$url&amp;\") : (\"welcome.php?\")).\"sid=\$session[hash]\\\" frameborder=\\\"0\\\" scrolling=\\\"yes\\\" />	
				</frameset>	
				<frame name=\\\"slice\\\" src=\\\"misc.php?action=slice&amp;sid=\$session[hash]\\\" frameborder=\\\"0\\\" scrolling=\\\"no\\\" noresize=\\\"noresize\\\" />
				<frameset rows=\\\"42,*,21,135,21,0\\\" border=\\\"0\\\" frameborder=\\\"no\\\" framespacing=\\\"0\\\">
					<frame name=\\\"logo\\\" src=\\\"misc.php?action=logo&amp;sid=\$session[hash]\\\" marginwidth=\\\"0\\\" marginheight=\\\"0\\\" frameborder=\\\"0\\\" scrolling=\\\"no\\\" noresize=\\\"noresize\\\" />
					<frame name=\\\"menu\\\" src=\\\"misc.php?action=menu&amp;sid=\$session[hash]\\\" frameborder=\\\"0\\\" scrolling=\\\"yes\\\" noresize=\\\"noresize\\\" />
					<frame name=\\\"storagetop\\\" src=\\\"misc.php?action=storagetop&amp;sid=\$session[hash]\\\" marginwidth=\\\"0\\\" marginheight=\\\"0\\\" frameborder=\\\"0\\\" scrolling=\\\"no\\\" noresize=\\\"noresize\\\" />
					<frame name=\\\"storage\\\" src=\\\"misc.php?action=storage&amp;sid=\$session[hash]\\\" marginwidth=\\\"0\\\" marginheight=\\\"0\\\" frameborder=\\\"0\\\" scrolling=\\\"no\\\" noresize=\\\"noresize\\\" />
					<frame name=\\\"workingtop\\\" src=\\\"misc.php?action=workingtop&amp;sid=\$session[hash]\\\" marginwidth=\\\"0\\\" marginheight=\\\"0\\\" frameborder=\\\"0\\\" scrolling=\\\"no\\\" noresize=\\\"noresize\\\" />
					<frame name=\\\"working\\\" src=\\\"misc.php?action=working&amp;sid=\$session[hash]\\\" marginwidth=\\\"0\\\" marginheight=\\\"0\\\" frameborder=\\\"0\\\" scrolling=\\\"no\\\" noresize=\\\"noresize\\\" />
				</frameset>		
		</frameset>
	\") 
	: (\"
		<frameset cols=\\\"*,2,270\\\" border=\\\"0\\\" frameborder=\\\"no\\\" framespacing=\\\"0\\\">
				<frameset rows=\\\"20,*\\\" border=\\\"0\\\" frameborder=\\\"no\\\" framespacing=\\\"0\\\">
					<frame name=\\\"top\\\" src=\\\"misc.php?action=top&amp;sid=\$session[hash]\\\" marginwidth=\\\"0\\\" marginheight=\\\"0\\\" frameborder=\\\"0\\\" scrolling=\\\"no\\\" noresize=\\\"noresize\\\" />	
					<frame name=\\\"main\\\" src=\\\"\".((\$url) ? (\"\$url&amp;\") : (\"welcome.php?\")).\"sid=\$session[hash]\\\" frameborder=\\\"0\\\" scrolling=\\\"yes\\\" />	
				</frameset>	
				<frame name=\\\"slice\\\" src=\\\"misc.php?action=slice&amp;sid=\$session[hash]\\\" frameborder=\\\"0\\\" scrolling=\\\"no\\\" noresize=\\\"noresize\\\" />
				<frameset rows=\\\"42,*,21,0\\\" border=\\\"0\\\" frameborder=\\\"no\\\" framespacing=\\\"0\\\">
					<frame name=\\\"logo\\\" src=\\\"misc.php?action=logo&amp;sid=\$session[hash]\\\" marginwidth=\\\"0\\\" marginheight=\\\"0\\\" frameborder=\\\"0\\\" scrolling=\\\"no\\\" noresize=\\\"noresize\\\" />
					<frame name=\\\"menu\\\" src=\\\"misc.php?action=menu&amp;sid=\$session[hash]\\\" frameborder=\\\"0\\\" scrolling=\\\"yes\\\" noresize=\\\"noresize\\\" />
					<frame name=\\\"workingtop\\\" src=\\\"misc.php?action=workingtop&amp;sid=\$session[hash]\\\" marginwidth=\\\"0\\\" marginheight=\\\"0\\\" frameborder=\\\"0\\\" scrolling=\\\"no\\\" noresize=\\\"noresize\\\" />
					<frame name=\\\"working\\\" src=\\\"misc.php?action=working&amp;sid=\$session[hash]\\\" marginwidth=\\\"0\\\" marginheight=\\\"0\\\" frameborder=\\\"0\\\" scrolling=\\\"no\\\" noresize=\\\"noresize\\\" />
				</frameset>		
		</frameset>
	\")
).\"
</html>";
?>
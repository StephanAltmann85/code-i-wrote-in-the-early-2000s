<?php
/*
acp template
templatename: frameset2
*/

$this->templates['acp_frameset2']="<HTML>
<HEAD>
<title>WoltLab Burning Board - Moderator Control Panel</title>
</HEAD>
<FRAMESET border=0 COLS=\\\"*,2,270\\\" border=\\\"0\\\" frameborder=\\\"no\\\" framespacing=\\\"0\\\">
		<FRAMESET border=0 ROWS=\\\"20,*\\\" border=\\\"0\\\" frameborder=\\\"no\\\" framespacing=\\\"0\\\">
			<FRAME name=\\\"top\\\" src=\\\"misc.php?action=top2&sid=\$session[hash]\\\" marginwidth=\\\"0\\\" marginheight=\\\"0\\\"  scrolling=\\\"no\\\" noresize>	
			<FRAME name=\\\"main\\\" src=\\\"threads.php?action=moderate&sid=\$session[hash]\\\" scrolling=\\\"auto\\\" frameborder=\\\"no\\\">	
		</FRAMESET>	
		<FRAME name=\\\"slice\\\" src=\\\"misc.php?action=slice&sid=\$session[hash]\\\" scrolling=\\\"no\\\" noresize>
		<FRAMESET border=0 ROWS=\\\"42,100%\\\" border=\\\"0\\\" frameborder=\\\"no\\\" framespacing=\\\"0\\\">
			<FRAME name=\\\"logo\\\" src=\\\"misc.php?action=logo2&sid=\$session[hash]\\\" marginwidth=\\\"0\\\" marginheight=\\\"0\\\"  scrolling=\\\"no\\\" noresize>
			<FRAME name=\\\"menue\\\" src=\\\"misc.php?action=menue2&sid=\$session[hash]\\\" scrolling=\\\"auto\\\" noresize>
		</FRAMESET>		
	</FRAMESET>
</HTML>



";
?>
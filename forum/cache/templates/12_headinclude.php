<?php
			/*
			templatepackid: 12
			templatename: headinclude
			*/
			
			$this->templates['headinclude']="<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"index\\\" href=\\\"index.php{\$SID_ARG_1ST}\\\" />
<link rel=\\\"help\\\" href=\\\"misc.php?action=faq{\$SID_ARG_2ND}\\\" />
<link rel=\\\"search\\\" href=\\\"search.php{\$SID_ARG_1ST}\\\" />
<link rel=\\\"up\\\" href=\\\"javascript:self.scrollTo(0,0);\\\" />
<link rel=\\\"copyright\\\" href=\\\"http://www.woltlab.de\\\" />
\$css

<script type=\\\"text/javascript\\\">
<!--
function noticepopup() {
F = window.open(\\\"notice.php?id=popup{\$SID_ARG_2ND}\\\",\\\"{\$lang->items['LANG_GLOBAL_NOTICE']}\\\",\\\"width=670,height=320\\\");
}
// -->
</script>";
			?>
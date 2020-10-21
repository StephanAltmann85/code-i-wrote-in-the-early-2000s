<?php
			/*
			templatepackid: 0
			templatename: register_disclaimer
			*/
			
			$this->templates['register_disclaimer']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">
 <head>
  <title>\$master_board_name | {\$lang->items['LANG_REGISTER_TITLE']}</title>
  \$headinclude
 </head>
 <body>
  \$header
  <table cellpadding=\\\"{\$style['tableincellpadding']}\\\" cellspacing=\\\"{\$style['tableincellspacing']}\\\" border=\\\"{\$style['tableinborder']}\\\" style=\\\"width:{\$style['tableinwidth']}\\\" class=\\\"tableinborder\\\">
   <tr>
    <td class=\\\"tabletitle\\\" align=\\\"center\\\"><span class=\\\"normalfont\\\"><b>\$master_board_name | {\$lang->items['LANG_REGISTER_RULES']}</b></span></td>
   </tr>
   <tr class=\\\"normalfont\\\">
    <td class=\\\"tableb\\\" align=\\\"left\\\">{\$lang->items['LANG_REGISTER_DISCLAIMER']}</td>
   </tr>
  </table>
  <form action=\\\"register.php\\\" method=\\\"post\\\" name=\\\"sform\\\">
   <input type=\\\"hidden\\\" name=\\\"disclaimer\\\" value=\\\"viewed\\\" />
   <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />	
   <p align=\\\"center\\\"><input class=\\\"input\\\" type=\\\"submit\\\" name=\\\"submitbtn\\\" value=\\\"{\$lang->items['LANG_REGISTER_ACCEPT']}\\\" /></p>
  </form>
  
  <form action=\\\"index.php\\\" method=\\\"get\\\">
   <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
   <p align=\\\"center\\\"><input class=\\\"input\\\" type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_REGISTER_CANCEL']}\\\" /></p>
  </form>
\$footer

<script type=\\\"text/javascript\\\">
<!--
var secs = 10;
var wait = secs * 1000;
document.sform.submitbtn.disabled=true;
	
for(i=1;i<=secs;i++) {
 window.setTimeout(\\\"update(\\\" + i + \\\")\\\", i * 1000);
}

window.setTimeout(\\\"timer()\\\", wait);

function update(num) {
 if(num == (wait/1000)) {
  document.sform.submitbtn.value = \\\"{\$lang->items['LANG_REGISTER_ACCEPT']}\\\";
 }
 else {
  printnr = (wait/1000)-num;
  document.sform.submitbtn.value = \\\"{\$lang->items['LANG_REGISTER_ACCEPT']} (\\\" + printnr + \\\")\\\";
 }
}

function timer() {
 document.sform.submitbtn.disabled=false;
}
//-->
</script>
</body>
</html>";
			?>
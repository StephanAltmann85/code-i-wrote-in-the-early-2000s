<?php
/*
acp template
templatename: menu
*/

$this->templates['acp_menu']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/menu.css\\\" />
<script type=\\\"text/javascript\\\">
<!--
NS4 = (document.layers) ? 1 : 0;
IE4 = (document.all) ? 1 : 0;
NS6 = (document.getElementById) ? 1 : 0;

activmenu = false;
timerRunning = false;

function checkTimer() {
 if(timerRunning)  {
  clearTimeout(timerRunning);
  timerRunning = false;
 }
}

function startTimer() {
 timerRunning = setTimeout(\\\"show();\\\",1000);
}
                        
function show(menu) { 
 if(activmenu) {
  checkTimer();
  if(NS4) document.layers[activmenu].visibility = \\\"hide\\\";
  if(NS6) document.getElementById(activmenu).style.visibility = \\\"hidden\\\";
  if(IE4) document.all(activmenu).style.visibility = \\\"hidden\\\";
  activmenu = false;
 }
   
 if(menu) {
  if(NS4) {
   document.layers[menu].visibility = \\\"show\\\";
   document.layers[menu].bgColor = \\\"FFFFFF\\\";
   document.layers[menu].onmouseover = checkTimer;
   document.layers[menu].onmouseout = startTimer;
  }
      
  if(IE4) {
   document.all(menu).style.visibility = \\\"visible\\\";
   document.all(menu).onmouseover = checkTimer;
   document.all(menu).onmouseout = startTimer;
  }
      
  if(NS6) {
   document.getElementById(menu).style.visibility = \\\"visible\\\";
   document.getElementById(menu).onmouseover = checkTimer;
   document.getElementById(menu).onmouseout = startTimer;
  }
  activmenu = menu;
 }
}

function hide(menu) {
 checkTimer();
 if(NS4) document.layers[menu].visibility = \\\"hide\\\";
 if(NS6) document.getElementById(menu).style.visibility = \\\"hidden\\\";
 if(IE4) document.all(menu).style.visibility = \\\"hidden\\\";
 activmenu = false;
}

//-->
</script>
</head>

<body>
 \".((checkAdminPermissions(\"a_can_options_edit\") && \$optiongroupbit) 
 ? (\"
 	<p><b><a href=\\\"options.php?sid=\$session[hash]\\\" onmouseover=\\\"javascript:show('config');\\\" target=\\\"main\\\">{\$lang->items['LANG_ACP_OPTIONS_TITLE']}</a></b></p>
	 <hr />
 \") : (\"\")
 ).\"
 
\$menu_itemgroupbit
\".((\$menu_itemgroupbit_hidden) 
? (\"
<p><b>&raquo; <a href=\\\"misc.php?action=menu&amp;sid=\$session[hash]&amp;acpmenuhidelast=0\\\">{\$lang->items['LANG_ACP_MISC_MENU_MORELINKS']}</a></b></p>
<hr />
\") : (\"\")
).\"


<div id=\\\"config\\\" style=\\\"position:absolute; left:9px; top:35px; z-index:1; visibility: hidden\\\">
<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" class=\\\"tblborder\\\" width=\\\"200\\\">
 <tr class=\\\"secondrow\\\">
  <td style=\\\"width:100%\\\"><b>{\$lang->items['LANG_ACP_MISC_MENU_OPTIONGROUPS']}</b></td>
  <td onmouseover=\\\"javascript:hide('config');\\\"><b>X</b></td>
 </tr>
 <tr class=\\\"firstrow\\\">
  <td colspan=\\\"2\\\">\$optiongroupbit</td>
 </tr>
</table>
</div>
</body>
</html>";
?>
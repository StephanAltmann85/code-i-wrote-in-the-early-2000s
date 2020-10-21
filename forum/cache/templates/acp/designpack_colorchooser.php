<?php
/*
acp template
templatename: designpack_colorchooser
*/

$this->templates['acp_designpack_colorchooser']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title>{\$lang->items['LANG_ACP_DESIGNPACK_COLORCHOOSER']}</title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<meta http-equiv=\\\"imagetoolbar\\\" content=\\\"no\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<script type=\\\"text/javascript\\\">
 <!--

  addary = new Array();           //red
  addary[0] = new Array(0,1,0);   //red green
  addary[1] = new Array(-1,0,0);  //green
  addary[2] = new Array(0,0,1);   //green blue
  addary[3] = new Array(0,-1,0);  //blue
  addary[4] = new Array(1,0,0);   //red blue
  addary[5] = new Array(0,0,-1);  //red
  addary[6] = new Array(255,1,1);
  clrary = new Array(360);

  for(i = 0; i < 6; i++) {
   for(j = 0; j < 60; j++) {
    clrary[60 * i + j] = new Array(3);
    for(k = 0; k < 3; k++) {
     clrary[60 * i + j][k] = addary[6][k];
     addary[6][k] += (addary[i][k] * 4);
    }
   }
  }

  function init() {
   if(document.layers) { // netscape4
    layobj = document.layers['colorchooser'];
    layobj.document.captureEvents(Event.MOUSEMOVE);
    layobj.document.onmousemove = mousemoved;
   }
   else {
    layobj = document.getElementById(\\\"colorchooser\\\");
    layobj.onmousemove = mousemoved;
   }
  }

  function mousemoved(e) {
   x = 4 * ((document.all ? event.offsetX : e.layerX)-2);
   y = 4 * ((document.all ? event.offsetY : e.layerY)-2+5);

   sx = x - 512;
   sy = y - 512;

   qx = (sx < 0)?0:1;
   qy = (sy < 0)?0:1;

   q = 2 * qx + qy;

   quad = new Array(-180,360,180,0);

   xa = Math.abs(sx);
   ya = Math.abs(sy);

   d = xa * 45 / ya;
   if(xa > ya) d = 90 - (ya * 45 / xa);
   deg = Math.floor(Math.abs(quad[q] - d));
   n = 0;
   sx = Math.abs(x - 512);
   sy = Math.abs(y - 512);
   r = Math.sqrt((sx * sx) + (sy * sy));

   if(x == 512 & y == 512) c = \\\"000000\\\";
   else {
    for(i = 0; i < 3; i++) {
     r2 = clrary[deg][i] * r / 256;
     if(r > 256) r2 += Math.floor(r - 256);
     if(r2 > 255) r2 = 255;
     n = 256 * n + Math.floor(r2);
    }

    c = n.toString(16);
    while(c.length < 6) c = \\\"0\\\" + c;
   }

   document.bbform.selectedcolor.value=\\\"#\\\" + c;
   document.bbform.cpick.style.backgroundColor=document.bbform.selectedcolor.value;

   return false;
  }

  function mouseclicked() {
   document.bbform.colorp.value=document.bbform.selectedcolor.value;
  }

 //-->
</script>

<style type=\\\"text/css\\\">
<!--
body {
 padding:0px;
 margin:0px;
}
-->
</style>

</head>

<body onload=\\\"init()\\\">
<form method=\\\"post\\\" action=\\\"#\\\" name=\\\"bbform\\\">
 <input type=\\\"hidden\\\" name=\\\"selectedcolor\\\" value=\\\"\\\" />

 <table cellpadding=\\\"0\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\">
  <tr>
   <td class=\\\"secondrow\\\" align=\\\"center\\\"><div id=\\\"colorchooser\\\"><img src=\\\"{\$style['imagefolder']}/colorchooser.jpg\\\" border=\\\"0\\\" alt=\\\"\\\" onclick=\\\"mouseclicked();\\\" /></div></td>
  </tr>
  <tr>
   <td class=\\\"firstrow\\\" align=\\\"center\\\"><table cellpadding=\\\"4\\\" cellspacing=\\\"0\\\" border=\\\"0\\\"><tr><td><input type=\\\"text\\\" name=\\\"colorp\\\" size=\\\"8\\\" value=\\\"#000000\\\" style=\\\"width:74px; font: 8pt verdana\\\" readonly=\\\"readonly\\\" /></td></tr></table></td>
  </tr>
  <tr>
   <td class=\\\"secondrow\\\" align=\\\"center\\\"><table cellpadding=\\\"4\\\" cellspacing=\\\"0\\\" border=\\\"0\\\"><tr><td><input type=\\\"button\\\" name=\\\"cpick\\\" value=\\\"{\$lang->items['LANG_ACP_DESIGNPACK_COLORCHOOSER_SELECT']}\\\" onclick=\\\"opener.setColor(this.form.colorp.value);self.close();\\\" /></td></tr></table></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
<?php
/*
acp template
templatename: template_editor_deluxe
*/

$this->templates['acp_template_editor_deluxe']="<html>
<head>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset=iso-8859-1\\\">
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\">
<STYLE TYPE=\\\"TEXT/CSS\\\">
<!--
.clsCursor {  cursor: hand}
TEXTAREA { 
 display: none;
}

INPUT {
font: 8pt verdana;
}
--> 
</STYLE>
</head>
<script language=\\\"javascript\\\" src=\\\"templateedit.js\\\"></script>
<body onload=\\\"init()\\\">
 <form method=\\\"post\\\" action=\\\"template.php\\\" name=\\\"tform\\\">
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\">
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\">
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\">
 <input type=\\\"hidden\\\" name=\\\"templateid\\\" value=\\\"\$templateid\\\">
 <input type=\\\"hidden\\\" name=\\\"editor\\\" value=\\\"deluxe\\\">
 <table cellpadding=4 cellspacing=1 width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td>Templateeditor: Deluxe</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><table>
    <tr>
     <td>
      <img class='clsCursor' src=\\\"images/new.gif\\\" width=\\\"16\\\" height=\\\"16\\\" border=\\\"0\\\" alt=\\\"Template leeren\\\" onClick=\\\"clearFile();\\\">&nbsp; 
      <img class='clsCursor' src=\\\"images/save.gif\\\" width=\\\"16\\\" height=\\\"16\\\" border=\\\"0\\\" alt=\\\"Template speichern\\\" onClick=\\\"formSubmit()\\\";>&nbsp;
      <img class='clsCursor' src=\\\"images/del.gif\\\" border=\\\"0\\\" alt=\\\"Platzhalter entfernen\\\" onClick=\\\"delVar()\\\";>&nbsp;
     </td>
     <td><input name=\\\"search\\\" type=\\\"text\\\" size=10 onChange=\\\"n=0;\\\" style=\\\"font: 8pt verdana;\\\"></td>
     <td><img class='clsCursor' src=\\\"images/search.gif\\\" width=\\\"15\\\" height=\\\"16\\\" border=\\\"0\\\" align=\\\"absmiddle\\\" alt=\\\"Suchen\\\" onClick=\\\"findInPage(document.tform.search.value)\\\"></td>
     <td><input name=\\\"replace\\\" type=\\\"text\\\" size=10 style=\\\"font: 8pt verdana;\\\"></td>
     <td><img class='clsCursor' src=\\\"images/replace.gif\\\" width=\\\"15\\\" height=\\\"15\\\" border=\\\"0\\\" align=\\\"absmiddle\\\" alt=\\\"Ersetzen\\\" onClick=\\\"replaceInPage(document.tform.search.value,document.tform.replace.value)\\\"></td>
     <td><textarea name=\\\"template\\\">\$template</textarea></td>
     <td class=\\\"secondrow\\\">&nbsp;&nbsp;&nbsp;</td>
     <td class=\\\"secondrow\\\"><b>Templatepack:</b></td>
     <td><select class=\\\"input\\\" name=\\\"templatepackid\\\">
    <option value=\\\"0\\\">Standardtemplates</option>
    \$templatepack_options				
   </select></td>
    </tr>
   </table></td>
  </tr> 
  <tr class=\\\"firstrow\\\">
   <td><IFRAME style=\\\"border: black thin; width:100%; height:400px\\\" frameBorder=1 id=\\\"teditor\\\" scrolling=auto></IFRAME></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td><table cellpadding=0 cellspacing=0 width=\\\"100%\\\" class=\\\"secondrow\\\">
    <tr>
     <td><b>Templatename:</b></td>
     <td><input type=\\\"text\\\" name=\\\"templatename\\\" value=\\\"\$templatename\\\" maxlength=\\\"100\\\"></td>
     <td align=\\\"right\\\"><input type=\\\"button\\\" value=\\\"Speichern\\\" onclick=\\\"formSubmit()\\\"> <input type=\\\"reset\\\" value=\\\"Zurücksetzen\\\"> <input type=\\\"button\\\" value=\\\"Abbrechen\\\" onclick=\\\"window.location.href='template.php?action=view&templatepackid=\$templatepackid&sid=\$session[hash]'\\\"></td>
    </tr>
   </table></td>
  </tr> 
 </table></form>
</body>
</html>";
?>
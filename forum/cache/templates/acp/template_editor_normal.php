<?php
/*
acp template
templatename: template_editor_normal
*/

$this->templates['acp_template_editor_normal']="<html>

<head>
<meta http-equiv=\\\"content-type\\\" content=\\\"text/html;charset=iso-8859-1\\\">
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\">
</head>
<body>
 \$error
 <form method=\\\"post\\\" action=\\\"template.php\\\" name=\\\"tform\\\">
 <input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\">
 <input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\">
 <input type=\\\"hidden\\\" name=\\\"templateid\\\" value=\\\"\$templateid\\\">
 <input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\">
 <input type=\\\"hidden\\\" name=\\\"editor\\\" value=\\\"normal\\\">
 <table cellpadding=4 cellspacing=1 width=\\\"100%\\\" class=\\\"tblborder\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=2>Templateeditor</td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=2>Templatepack w�hlen</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>Templatepack:</b></td>
   <td width=\\\"50%\\\"><select class=\\\"input\\\" name=\\\"templatepackid\\\">
    <option value=\\\"0\\\">Standardtemplates</option>
    \$templatepack_options				
   </select></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=2>Template</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>Templatename:</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"templatename\\\" value=\\\"\$templatename\\\" class=\\\"input\\\" maxlength=\\\"100\\\"></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td colspan=2><textarea ROWS=24 COLS=90 wrap=\\\"off\\\" name=\\\"template\\\" class=\\\"input\\\" style=\\\"width:100%\\\">\$template</textarea></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td colspan=2 align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"Speichern\\\"> <input type=\\\"reset\\\" value=\\\"Zur�cksetzen\\\"> <input type=\\\"button\\\" value=\\\"Abbrechen\\\" onclick=\\\"window.location.href='template.php?action=view&templatepackid=\$templatepackid&sid=\$session[hash]'\\\"></td>
  </tr>
 </table></form>
</body>
</html>";
?>
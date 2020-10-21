<?php
/*
acp template
templatename: designpack_add
*/

$this->templates['acp_designpack_add']="<html>

<head>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset=iso-8859-1\\\">
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\">
<script language=\\\"JavaScript\\\">
 <!--
  function changecolor(theelement,color) {
   theelement.style.backgroundColor = color;
  }
 //-->
</script>
</head>

<body>
<form method=\\\"post\\\" action=\\\"designpack.php\\\" name=\\\"bbform\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\">
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\">
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\">
<table cellpadding=4 cellspacing=1 border=0 class=\\\"tblborder\\\" width=\\\"95%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=3>Designpack erstellen</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>Name des Designpacks:</b></td>
   <td colspan=2 width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"subvariablepackname\\\"></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=3>Allgemein</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>Hintergrundfarbe:</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"bgcolor\\\" onchange=\\\"changecolor(this.form.previewbgcolor,this.value)\\\"></td>
   <td><input type=\\\"button\\\" id=\\\"previewbgcolor\\\" value=\\\"          \\\" DISABLED></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>Schriftfarbe:</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"textcolor\\\" onchange=\\\"changecolor(this.form.previewtextcolor,this.value)\\\"></td>
   <td><input type=\\\"button\\\" id=\\\"previewtextcolor\\\" value=\\\"          \\\" DISABLED></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>Weitere Attribute für body tag:</b></td>
   <td colspan=2 width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"bodytags\\\"></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=3>äußere Tabelle</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>Randfarbe:</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableoutbordercolor\\\" onchange=\\\"changecolor(this.form.previewtableoutbordercolor,this.value)\\\"></td>
   <td><input type=\\\"button\\\" id=\\\"previewtableoutbordercolor\\\" value=\\\"          \\\" DISABLED></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>Hintergrundfarbe:</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"mainbgcolor\\\" onchange=\\\"changecolor(this.form.previewmainbgcolor,this.value)\\\"></td>
   <td><input type=\\\"button\\\" id=\\\"previewmainbgcolor\\\" value=\\\"          \\\" DISABLED></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>Weite der äußeren Tabelle:</b></td>
   <td colspan=2 width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableoutwidth\\\" value=\\\"\\\"></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=3>innere Tabellen</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>Randfarbe:</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableinbordercolor\\\" onchange=\\\"changecolor(this.form.previewtableinbordercolor,this.value)\\\"></td>
   <td><input type=\\\"button\\\" id=\\\"previewtableinbordercolor\\\" value=\\\"          \\\" DISABLED></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>Spaltenfarbe für Tabellenkopf:</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tabletitlecolor\\\" onchange=\\\"changecolor(this.form.previewtabletitlecolor,this.value)\\\"></td>
   <td><input type=\\\"button\\\" id=\\\"previewtabletitlecolor\\\" value=\\\"          \\\" DISABLED></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>Zeilenfarbe für Kategoriezeile:</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tablecatcolor\\\" onchange=\\\"changecolor(this.form.previewtablecatcolor,this.value)\\\"></td>
   <td><input type=\\\"button\\\" id=\\\"previewtablecatcolor\\\" value=\\\"          \\\" DISABLED></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>allgemeine Spaltenfarbe 1:</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tablecolora\\\" onchange=\\\"changecolor(this.form.previewtablecolora,this.value)\\\"></td>
   <td><input type=\\\"button\\\" id=\\\"previewtablecolora\\\" value=\\\"          \\\" DISABLED></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>allgemeine Spaltenfarbe 2:</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tablecolorb\\\" onchange=\\\"changecolor(this.form.previewtablecolorb,this.value)\\\"></td>
   <td><input type=\\\"button\\\" id=\\\"previewtablecolorb\\\" value=\\\"          \\\" DISABLED></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>Weite der inneren Tabellen:</b></td>
   <td colspan=2 width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableinwidth\\\"></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>Hintergrundfarbe für Tabellen in inneren Tabellen:</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"inposttablecolor\\\" onchange=\\\"changecolor(this.form.previewinposttablecolor,this.value)\\\"></td>
   <td><input type=\\\"button\\\" id=\\\"previewinposttablecolor\\\" value=\\\"          \\\" DISABLED></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=3>Eigenschaften von normaler Schrift</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>Schriftart:</b></td>
   <td colspan=2 width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"normalfont\\\"></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>Schriftgröße:</b></td>
   <td colspan=2 width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"normalfontsize\\\"></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>Weitere Attribute für normalfont tag:</b></td>
   <td colspan=2 width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"normalfonttags\\\"></td>
  </tr>
   <tr class=\\\"tblsection\\\">
   <td colspan=3>Eigenschaften von kleiner Schrift</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>Schriftart:</b></td>
   <td colspan=2 width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"smallfont\\\"></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>Schriftgröße:</b></td>
   <td colspan=2 width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"smallfontsize\\\"></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>Weitere Attribute für normalfont tag:</b></td>
   <td colspan=2 width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"smallfonttags\\\"></td>
  </tr>
  </tr>
   <tr class=\\\"tblsection\\\">
   <td colspan=3>Weitere Schriftfarbe</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>Schriftfarbe in Tabellenkopfspalten:</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"fontcolorsecond\\\" onchange=\\\"changecolor(this.form.previewfontcolorsecond,this.value)\\\"></td>
   <td><input type=\\\"button\\\" id=\\\"previewfontcolorsecond\\\" value=\\\"          \\\" DISABLED></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>Schriftfarbe in Kategoriezeilen:</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"fontcolorthird\\\" onchange=\\\"changecolor(this.form.previewfontcolorthird,this.value)\\\"></td>
   <td><input type=\\\"button\\\" id=\\\"previewfontcolorthird\\\" value=\\\"          \\\" DISABLED></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>Schriftfarbe der Zeitdarstellung:</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"timecolor\\\" onchange=\\\"changecolor(this.form.previewtimecolor,this.value)\\\"></td>
   <td><input type=\\\"button\\\" id=\\\"previewtimecolor\\\" value=\\\"          \\\" DISABLED></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>Schriftfarbe für Prefixe vor Thementiteln:</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"prefixcolor\\\" onchange=\\\"changecolor(this.form.previewprefixcolor,this.value)\\\"></td>
   <td><input type=\\\"button\\\" id=\\\"previewprefixcolor\\\" value=\\\"          \\\" DISABLED></td>
  </tr>
  </tr>
   <tr class=\\\"tblsection\\\">
   <td colspan=3>Highlighting</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>Starttag:</b></td>
   <td colspan=2 width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"hilightstart\\\"></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>Endetag:</b></td>
   <td colspan=2 width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"hilightend\\\"></td>
  </tr>
  </tr>
   <tr class=\\\"tblsection\\\">
   <td colspan=3>Bilder</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>Ordner für Bilder:</b></td>
   <td colspan=2 width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"imagefolder\\\" value=\\\"images\\\"></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>URL zum Logo des Forums:</b></td>
   <td colspan=2 width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"imagelogo\\\"></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>Hintergrundbild für Kopfbereich des Forums:</b></td>
   <td colspan=2 width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"imageback\\\"></td>
  </tr>
  </tr>
   <tr class=\\\"tblsection\\\">
   <td colspan=3>Cascading Stylesheets (CSS)</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>URL zu einer CSS Datei:</b></td>
   <td colspan=2 width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"cssfile\\\"></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>CSS Code:</b><br>CSS die in jede Seite des Forums eingefügt werden sollen. Alternativ oder zusätzlich zur CSS Datei (oben).</td>
   <td colspan=2 width=\\\"50%\\\"><textarea rows=\\\"10\\\" cols=\\\"55\\\" wrap=\\\"virtual\\\" name=\\\"css\\\"></textarea></td>
  </tr>
  </tr>
   <tr class=\\\"tblsection\\\">
   <td colspan=3>Weitere Eigenschaften</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>DOCTYPE der Seiten des Forums:</b></td>
   <td colspan=2 width=\\\"50%\\\"><input type=\\\"text\\\" size=40 name=\\\"doctype\\\" value=\\\"<!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD HTML 4.01 Transitional//EN&quot;>\\\"></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td colspan=3 align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"Speichern\\\"> <input type=\\\"reset\\\" value=\\\"Zurücksetzen\\\"></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
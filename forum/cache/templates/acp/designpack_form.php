<?php
/*
acp template
templatename: designpack_form
*/

$this->templates['acp_designpack_form']="<?xml version=\\\"1.0\\\" encoding=\\\"{\$lang->items['LANG_GLOBAL_ENCODING']}\\\"?>
<!DOCTYPE html PUBLIC \\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\" \\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\">
<html xmlns=\\\"http://www.w3.org/1999/xhtml\\\" dir=\\\"{\$lang->items['LANG_GLOBAL_DIRECTION']}\\\" lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\" xml:lang=\\\"{\$lang->items['LANG_GLOBAL_LANGCODE']}\\\">

<head>
<title></title>
<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html; charset={\$lang->items['LANG_GLOBAL_ENCODING']}\\\" />
<link rel=\\\"stylesheet\\\" href=\\\"css/main.css\\\" />
<script type=\\\"text/javascript\\\">
 <!--
  var aElement = '';
  var aButton = '';
  
  function changecolor(theelement,color) {
   theelement.style.backgroundColor = color;
  }
  
  function openColorChooser(buttonname, elementname) {
   aElement = elementname;
   aButton = buttonname;
   window.open(\\\"designpack.php?action=colorchooser&sid=\$session[hash]\\\", \\\"colorchooser\\\", \\\"toolbar=no,scrollbars=no,resizable=no,width=260,height=320\\\");
  }
  
  function setColor(newvalue) {
   if(aElement!='') aElement.value=newvalue;
   if(aButton!='') aButton.style.backgroundColor=newvalue;
  }
  
 //-->
</script>
</head>

<body>
<form method=\\\"post\\\" action=\\\"designpack.php\\\" name=\\\"bbform\\\">
<input type=\\\"hidden\\\" name=\\\"send\\\" value=\\\"send\\\" />
<input type=\\\"hidden\\\" name=\\\"action\\\" value=\\\"\$action\\\" />
<input type=\\\"hidden\\\" name=\\\"sid\\\" value=\\\"\$session[hash]\\\" />
<input type=\\\"hidden\\\" name=\\\"designpackid\\\" value=\\\"\$designpackid\\\" />
<table cellpadding=\\\"4\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" class=\\\"tblborder\\\" width=\\\"100%\\\" align=\\\"center\\\">
  <tr class=\\\"tblhead\\\">
   <td colspan=\\\"3\\\">\$pagetitle</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_DESIGNPACKNAME']}:</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"designpackname\\\" value=\\\"\$designpackname\\\" /></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_BACKGROUND']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_BGCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"pagebgcolor\\\" value=\\\"\$design[pagebgcolor]\\\" onchange=\\\"changecolor(this.form.previewpagebgcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewpagebgcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[pagebgcolor]\\\" onclick=\\\"openColorChooser(this, this.form.pagebgcolor)\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"fontcolor\\\" value=\\\"\$design[fontcolor]\\\" onchange=\\\"changecolor(this.form.previewfontcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewfontcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[fontcolor]\\\" onclick=\\\"openColorChooser(this, this.form.fontcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTFACE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"fontfamily\\\" value=\\\"\$design[fontfamily]\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"bodymore\\\">\$design[bodymore]</textarea></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_TABLEOUT']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_BORDERCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableoutbordercolor\\\" value=\\\"\$design[tableoutbordercolor]\\\" onchange=\\\"changecolor(this.form.previewtableoutbordercolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtableoutbordercolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tableoutbordercolor]\\\" onclick=\\\"openColorChooser(this, this.form.tableoutbordercolor)\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_BGCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"mainbgcolor\\\" value=\\\"\$design[mainbgcolor]\\\" onchange=\\\"changecolor(this.form.previewmainbgcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewmainbgcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[mainbgcolor]\\\" onclick=\\\"openColorChooser(this, this.form.mainbgcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_TABLEWIDTH']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableoutwidth\\\" value=\\\"\$design[tableoutwidth]\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_TABLEBORDER']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableoutborder\\\" value=\\\"\$design[tableoutborder]\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CELLSPACING']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableoutcellspacing\\\" value=\\\"\$design[tableoutcellspacing]\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CELLPADDING']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableoutcellpadding\\\" value=\\\"\$design[tableoutcellpadding]\\\" /></td>
  </tr>
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_TABLEIN']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_BORDERCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableinbordercolor\\\" value=\\\"\$design[tableinbordercolor]\\\" onchange=\\\"changecolor(this.form.previewtableinbordercolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtableinbordercolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tableinbordercolor]\\\" onclick=\\\"openColorChooser(this, this.form.tableinbordercolor)\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_TABLEWIDTH']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableinwidth\\\" value=\\\"\$design[tableinwidth]\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_TABLEBORDER']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableinborder\\\" value=\\\"\$design[tableinborder]\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CELLSPACING']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableincellspacing\\\" value=\\\"\$design[tableincellspacing]\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CELLPADDING']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableincellpadding\\\" value=\\\"\$design[tableincellpadding]\\\" /></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_TABLETITLE']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_BGCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tabletitlebgcolor\\\" value=\\\"\$design[tabletitlebgcolor]\\\" onchange=\\\"changecolor(this.form.previewtabletitlebgcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtabletitlebgcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tabletitlebgcolor]\\\" onclick=\\\"openColorChooser(this, this.form.tabletitlebgcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tabletitlefontcolor\\\" value=\\\"\$design[tabletitlefontcolor]\\\" onchange=\\\"changecolor(this.form.previewtabletitlefontcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtabletitlefontcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tabletitlefontcolor]\\\" onclick=\\\"openColorChooser(this, this.form.tabletitlefontcolor)\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"tabletitlemore\\\">\$design[tabletitlemore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_TABLECAT']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_BGCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tablecatbgcolor\\\" value=\\\"\$design[tablecatbgcolor]\\\" onchange=\\\"changecolor(this.form.previewtablecatbgcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtablecatbgcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tablecatbgcolor]\\\" onclick=\\\"openColorChooser(this, this.form.tablecatbgcolor)\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tablecatfontcolor\\\" value=\\\"\$design[tablecatfontcolor]\\\" onchange=\\\"changecolor(this.form.previewtablecatfontcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtablecatfontcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tablecatfontcolor]\\\" onclick=\\\"openColorChooser(this, this.form.tablecatfontcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"tablecatmore\\\">\$design[tablecatmore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_TABLEA']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_BGCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableabgcolor\\\" value=\\\"\$design[tableabgcolor]\\\" onchange=\\\"changecolor(this.form.previewtableabgcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtableabgcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tableabgcolor]\\\" onclick=\\\"openColorChooser(this, this.form.tableabgcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableafontcolor\\\" value=\\\"\$design[tableafontcolor]\\\" onchange=\\\"changecolor(this.form.previewtableafontcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtableafontcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tableafontcolor]\\\" onclick=\\\"openColorChooser(this, this.form.tableafontcolor)\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"tableamore\\\">\$design[tableamore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_TABLEB']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_BGCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tablebbgcolor\\\" value=\\\"\$design[tablebbgcolor]\\\" onchange=\\\"changecolor(this.form.previewtablebbgcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtablebbgcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tablebbgcolor]\\\" onclick=\\\"openColorChooser(this, this.form.tablebbgcolor)\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tablebfontcolor\\\" value=\\\"\$design[tablebfontcolor]\\\" onchange=\\\"changecolor(this.form.previewtablebfontcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtablebfontcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tablebfontcolor]\\\" onclick=\\\"openColorChooser(this, this.form.tablebfontcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"tablebmore\\\">\$design[tablebmore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_INPOSTTABLE']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_BGCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"inposttablebgcolor\\\" value=\\\"\$design[inposttablebgcolor]\\\" onchange=\\\"changecolor(this.form.previewinposttablebgcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewinposttablebgcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[inposttablebgcolor]\\\" onclick=\\\"openColorChooser(this, this.form.inposttablebgcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"inposttablemore\\\">\$design[inposttablemore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_NORMALFONT']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTFACE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"normalfontface\\\" value=\\\"\$design[normalfontface]\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTSIZE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"normalfontsize\\\" value=\\\"\$design[normalfontsize]\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"normalfontcolor\\\" value=\\\"\$design[normalfontcolor]\\\" onchange=\\\"changecolor(this.form.previewnormalfontcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewnormalfontcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[normalfontcolor]\\\" onclick=\\\"openColorChooser(this, this.form.normalfontcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"normalfontmore\\\">\$design[normalfontmore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_SMALLFONT']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTFACE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"smallfontface\\\" value=\\\"\$design[smallfontface]\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTSIZE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"smallfontsize\\\" value=\\\"\$design[smallfontsize]\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"smallfontcolor\\\" value=\\\"\$design[smallfontcolor]\\\" onchange=\\\"changecolor(this.form.previewsmallfontcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewsmallfontcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[smallfontcolor]\\\" onclick=\\\"openColorChooser(this, this.form.smallfontcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"smallfontmore\\\">\$design[smallfontmore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_HIGHLIGHTING']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"highlightfontcolor\\\" value=\\\"\$design[highlightfontcolor]\\\" onchange=\\\"changecolor(this.form.previewhighlightfontcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewhighlightfontcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[highlightfontcolor]\\\" onclick=\\\"openColorChooser(this, this.form.highlightfontcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTWEIGHT']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"highlightfontweight\\\" value=\\\"\$design[highlightfontweight]\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_TEXTDECORATION']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"highlightdeco\\\" value=\\\"\$design[highlightdeco]\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"highlightmore\\\">\$design[highlightmore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_PREFIX']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"prefixfontcolor\\\" value=\\\"\$design[prefixfontcolor]\\\" onchange=\\\"changecolor(this.form.previewprefixfontcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewprefixfontcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[prefixfontcolor]\\\" onclick=\\\"openColorChooser(this, this.form.prefixfontcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTWEIGHT']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"prefixfontweight\\\" value=\\\"\$design[prefixfontweight]\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_TEXTDECORATION']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"prefixdeco\\\" value=\\\"\$design[prefixdeco]\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"prefixmore\\\">\$design[prefixmore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_TIMEFORMAT']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"timefontcolor\\\" value=\\\"\$design[timefontcolor]\\\" onchange=\\\"changecolor(this.form.previewtimefontcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtimefontcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[timefontcolor]\\\" onclick=\\\"openColorChooser(this, this.form.timefontcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTWEIGHT']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"timefontweight\\\" value=\\\"\$design[timefontweight]\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_TEXTDECORATION']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"timedeco\\\" value=\\\"\$design[timedeco]\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"timemore\\\">\$design[timemore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_PUBLICEVENT']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"publiceventfontcolor\\\" value=\\\"\$design[publiceventfontcolor]\\\" onchange=\\\"changecolor(this.form.previewpubliceventfontcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewpubliceventfontcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[publiceventfontcolor]\\\" onclick=\\\"openColorChooser(this, this.form.publiceventfontcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"publiceventmore\\\">\$design[publiceventmore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_PRIVATEEVENT']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"privateeventfontcolor\\\" value=\\\"\$design[privateeventfontcolor]\\\" onchange=\\\"changecolor(this.form.previewprivateeventfontcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewprivateeventfontcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[privateeventfontcolor]\\\" onclick=\\\"openColorChooser(this, this.form.privateeventfontcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"privateeventmore\\\">\$design[privateeventmore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_SELECTBOX']}</td>
  </tr>
  
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_BGCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"selectbgcolor\\\" value=\\\"\$design[selectbgcolor]\\\" onchange=\\\"changecolor(this.form.previewselectbgcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewselectbgcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[selectbgcolor]\\\" onclick=\\\"openColorChooser(this, this.form.selectbgcolor)\\\" /></td>
  </tr>
  
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"selectfontcolor\\\" value=\\\"\$design[selectfontcolor]\\\" onchange=\\\"changecolor(this.form.previewselectfontcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewselectfontcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[selectfontcolor]\\\" onclick=\\\"openColorChooser(this, this.form.selectfontcolor)\\\" /></td>
  </tr>
  
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTSIZE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"selectfontsize\\\" value=\\\"\$design[selectfontsize]\\\" /></td>
  </tr>
  
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTFACE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"selectfontface\\\" value=\\\"\$design[selectfontface]\\\" /></td>
  </tr>
  
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"selectmore\\\">\$design[selectmore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_TEXTAREA']}</td>
  </tr>
  
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_BGCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"textareabgcolor\\\" value=\\\"\$design[textareabgcolor]\\\" onchange=\\\"changecolor(this.form.previewtextareabgcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtextareabgcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[textareabgcolor]\\\" onclick=\\\"openColorChooser(this, this.form.textareabgcolor)\\\" /></td>
  </tr>
  
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"textareafontcolor\\\" value=\\\"\$design[textareafontcolor]\\\" onchange=\\\"changecolor(this.form.previewtextareafontcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtextareafontcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[textareafontcolor]\\\" onclick=\\\"openColorChooser(this, this.form.textareafontcolor)\\\" /></td>
  </tr>
  
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTSIZE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"textareafontsize\\\" value=\\\"\$design[textareafontsize]\\\" /></td>
  </tr>
  
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTFACE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"textareafontface\\\" value=\\\"\$design[textareafontface]\\\" /></td>
  </tr>
  
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"textareamore\\\">\$design[textareamore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_INPUT']}</td>
  </tr>
  
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_BGCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"inputbgcolor\\\" value=\\\"\$design[inputbgcolor]\\\" onchange=\\\"changecolor(this.form.previewinputbgcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewinputbgcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[inputbgcolor]\\\" onclick=\\\"openColorChooser(this, this.form.inputbgcolor)\\\" /></td>
  </tr>
  
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"inputfontcolor\\\" value=\\\"\$design[inputfontcolor]\\\" onchange=\\\"changecolor(this.form.previewinputfontcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewinputfontcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[inputfontcolor]\\\" onclick=\\\"openColorChooser(this, this.form.inputfontcolor)\\\" /></td>
  </tr>
  
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTSIZE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"inputfontsize\\\" value=\\\"\$design[inputfontsize]\\\" /></td>
  </tr>
  
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_FONTFACE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"inputfontface\\\" value=\\\"\$design[inputfontface]\\\" /></td>
  </tr>
  
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"inputmore\\\">\$design[inputmore]</textarea></td>
  </tr>
  
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_GRADIENT']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_GRADIENTLEFT']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"gradientleft\\\" value=\\\"\$design[gradientleft]\\\" onchange=\\\"changecolor(this.form.previewgradientleft,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewgradientleft\\\" value=\\\"          \\\" style=\\\"background-color: \$design[gradientleft]\\\" onclick=\\\"openColorChooser(this, this.form.gradientleft)\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_GRADIENTMIDDLE']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"gradientmiddle\\\" value=\\\"\$design[gradientmiddle]\\\" onchange=\\\"changecolor(this.form.previewgradientmiddle,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewgradientmiddle\\\" value=\\\"          \\\" style=\\\"background-color: \$design[gradientmiddle]\\\" onclick=\\\"openColorChooser(this, this.form.gradientmiddle)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_GRADIENTRIGHT']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"gradientright\\\" value=\\\"\$design[gradientright]\\\" onchange=\\\"changecolor(this.form.previewgradientright,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewgradientright\\\" value=\\\"          \\\" style=\\\"background-color: \$design[gradientright]\\\" onclick=\\\"openColorChooser(this, this.form.gradientright)\\\" /></td>
  </tr>
  
  
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_IMAGES']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_IMAGEFOLDER']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"imagefolder\\\" value=\\\"\$design[imagefolder]\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_LOGOIMAGE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"logoimage\\\" value=\\\"\$design[logoimage]\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_LOGOBACKGROUND']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"logobackground\\\" value=\\\"\$design[logobackground]\\\" /></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_PAGELINK']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_LINKCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"pagelinkcolor\\\" value=\\\"\$design[pagelinkcolor]\\\" onchange=\\\"changecolor(this.form.previewpagelinkcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewpagelinkcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[pagelinkcolor]\\\" onclick=\\\"openColorChooser(this, this.form.pagelinkcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_TEXTDECORATION']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"pagelinkdeco\\\" value=\\\"\$design[pagelinkdeco]\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"pagelinkmore\\\">\$design[pagelinkmore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_PAGELINK']} {\$lang->items['LANG_ACP_DESIGNPACK_HOVER']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_LINKCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"pagelinkhovercolor\\\" value=\\\"\$design[pagelinkhovercolor]\\\" onchange=\\\"changecolor(this.form.previewpagelinkhovercolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewpagelinkhovercolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[pagelinkhovercolor]\\\" onclick=\\\"openColorChooser(this, this.form.pagelinkhovercolor)\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_TEXTDECORATION']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"pagelinkhoverdeco\\\" value=\\\"\$design[pagelinkhoverdeco]\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"pagelinkhovermore\\\">\$design[pagelinkhovermore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_TABLETITLELINK']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_LINKCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tabletitlelinkcolor\\\" value=\\\"\$design[tabletitlelinkcolor]\\\" onchange=\\\"changecolor(this.form.previewtabletitlelinkcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtabletitlelinkcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tabletitlelinkcolor]\\\" onclick=\\\"openColorChooser(this, this.form.tabletitlelinkcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_TEXTDECORATION']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tabletitlelinkdeco\\\" value=\\\"\$design[tabletitlelinkdeco]\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"tabletitlelinkmore\\\">\$design[tabletitlelinkmore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_TABLETITLELINK']} {\$lang->items['LANG_ACP_DESIGNPACK_HOVER']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_LINKCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tabletitlelinkhovercolor\\\" value=\\\"\$design[tabletitlelinkhovercolor]\\\" onchange=\\\"changecolor(this.form.previewtabletitlelinkhovercolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtabletitlelinkhovercolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tabletitlelinkhovercolor]\\\" onclick=\\\"openColorChooser(this, this.form.tabletitlelinkhovercolor)\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_TEXTDECORATION']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tabletitlelinkhoverdeco\\\" value=\\\"\$design[tabletitlelinkhoverdeco]\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"tabletitlelinkhovermore\\\">\$design[tabletitlelinkhovermore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_TABLECATLINK']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_LINKCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tablecatlinkcolor\\\" value=\\\"\$design[tablecatlinkcolor]\\\" onchange=\\\"changecolor(this.form.previewtablecatlinkcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtablecatlinkcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tablecatlinkcolor]\\\" onclick=\\\"openColorChooser(this, this.form.tablecatlinkcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_TEXTDECORATION']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tablecatlinkdeco\\\" value=\\\"\$design[tablecatlinkdeco]\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"tablecatlinkmore\\\">\$design[tablecatlinkmore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_TABLECATLINK']} {\$lang->items['LANG_ACP_DESIGNPACK_HOVER']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_LINKCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tablecatlinkhovercolor\\\" value=\\\"\$design[tablecatlinkhovercolor]\\\" onchange=\\\"changecolor(this.form.previewtablecatlinkhovercolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtablecatlinkhovercolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tablecatlinkhovercolor]\\\" onclick=\\\"openColorChooser(this, this.form.tablecatlinkhovercolor)\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_TEXTDECORATION']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tablecatlinkhoverdeco\\\" value=\\\"\$design[tablecatlinkhoverdeco]\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"tablecatlinkhovermore\\\">\$design[tablecatlinkhovermore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_TABLEALINK']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_LINKCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tablealinkcolor\\\" value=\\\"\$design[tablealinkcolor]\\\" onchange=\\\"changecolor(this.form.previewtablealinkcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtablealinkcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tablealinkcolor]\\\" onclick=\\\"openColorChooser(this, this.form.tablealinkcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_TEXTDECORATION']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tablealinkdeco\\\" value=\\\"\$design[tablealinkdeco]\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"tablealinkmore\\\">\$design[tablealinkmore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_TABLEALINK']} {\$lang->items['LANG_ACP_DESIGNPACK_HOVER']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_LINKCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tablealinkhovercolor\\\" value=\\\"\$design[tablealinkhovercolor]\\\" onchange=\\\"changecolor(this.form.previewtablealinkhovercolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtablealinkhovercolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tablealinkhovercolor]\\\" onclick=\\\"openColorChooser(this, this.form.tablealinkhovercolor)\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_TEXTDECORATION']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tablealinkhoverdeco\\\" value=\\\"\$design[tablealinkhoverdeco]\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"tablealinkhovermore\\\">\$design[tablealinkhovermore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_TABLEBLINK']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_LINKCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableblinkcolor\\\" value=\\\"\$design[tableblinkcolor]\\\" onchange=\\\"changecolor(this.form.previewtableblinkcolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtableblinkcolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tableblinkcolor]\\\" onclick=\\\"openColorChooser(this, this.form.tableblinkcolor)\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_TEXTDECORATION']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableblinkdeco\\\" value=\\\"\$design[tableblinkdeco]\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"tableblinkmore\\\">\$design[tableblinkmore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_TABLEBLINK']} {\$lang->items['LANG_ACP_DESIGNPACK_HOVER']}</td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_LINKCOLOR']}</b></td>
   <td width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableblinkhovercolor\\\" value=\\\"\$design[tableblinkhovercolor]\\\" onchange=\\\"changecolor(this.form.previewtableblinkhovercolor,this.value)\\\" /></td>
   <td><input type=\\\"button\\\" id=\\\"previewtableblinkhovercolor\\\" value=\\\"          \\\" style=\\\"background-color: \$design[tableblinkhovercolor]\\\" onclick=\\\"openColorChooser(this, this.form.tableblinkhovercolor)\\\" /></td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_TEXTDECORATION']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><input type=\\\"text\\\" name=\\\"tableblinkhoverdeco\\\" value=\\\"\$design[tableblinkhoverdeco]\\\" /></td>
  </tr>
  <tr class=\\\"firstrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_CSSMORE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"tableblinkhovermore\\\">\$design[tableblinkhovermore]</textarea></td>
  </tr>
  
  <tr class=\\\"tblsection\\\">
   <td colspan=\\\"3\\\">{\$lang->items['LANG_ACP_DESIGNPACK_OTHERCSS']}</td>
  </tr>
  <tr class=\\\"secondrow\\\">
   <td width=\\\"50%\\\" valign=\\\"top\\\"><b>{\$lang->items['LANG_ACP_DESIGNPACK_OTHERCSSCODE']}</b></td>
   <td colspan=\\\"2\\\" width=\\\"50%\\\"><textarea rows=\\\"6\\\" cols=\\\"55\\\" name=\\\"cssmore\\\">\$design[cssmore]</textarea></td>
  </tr>
  
  <tr class=\\\"firstrow\\\">
   <td colspan=\\\"3\\\" align=\\\"center\\\"><input type=\\\"submit\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_SUBMITFORM']}\\\" /> <input type=\\\"reset\\\" value=\\\"{\$lang->items['LANG_ACP_GLOBAL_RESETFORM']}\\\" /></td>
  </tr>
 </table>
</form>
</body>
</html>";
?>
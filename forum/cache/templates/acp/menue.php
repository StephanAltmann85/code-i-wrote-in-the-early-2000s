<?php
/*
acp template
templatename: menue
*/

$this->templates['acp_menue']="<html>



<head>

<meta http-equiv=\\\"Content-Type\\\" content=\\\"text/html;charset=iso-8859-1\\\">

<link rel=\\\"stylesheet\\\" href=\\\"css/menue.css\\\">

<script language=\\\"Javascript\\\">

<!--

NS4 = (document.layers) ? 1 : 0;

IE4 = (document.all) ? 1 : 0;

NS6 = (document.getElementById) ? 1 : 0;



activmenue = false;

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



function show(menue) {

 if(activmenue) {

  checkTimer();

  if(NS4) document.layers[activmenue].visibility = \\\"hide\\\";

  if(NS6) document.getElementById(activmenue).style.visibility = \\\"hidden\\\";

  if(IE4) document.all(activmenue).style.visibility = \\\"hidden\\\";

  activmenue = false;

 }



 if(menue) {

  if(NS4) {

   document.layers[menue].visibility = \\\"show\\\";

   document.layers[menue].bgColor = \\\"FFFFFF\\\";

   document.layers[menue].onmouseover = checkTimer;

   document.layers[menue].onmouseout = startTimer;

  }



  if(IE4) {

   document.all(menue).style.visibility = \\\"visible\\\";

   document.all(menue).onmouseover = checkTimer;

   document.all(menue).onmouseout = startTimer;

  }



  if(NS6) {

   document.getElementById(menue).style.visibility = \\\"visible\\\";

   document.getElementById(menue).onmouseover = checkTimer;

   document.getElementById(menue).onmouseout = startTimer;

  }

  activmenue = menue;

 }

}

//-->

</script>

</head>



<body>

  <p><b><a href=\\\"options.php?sid=\$session[hash]\\\" onmouseover=\\\"javascript:show('test');\\\" target=\\\"main\\\">Einstellungen</a></b></p>

 <hr>

  <p><a href=\\\"board.php?action=add&sid=\$session[hash]\\\" target=\\\"main\\\">Foren erstellen</a></p>

  <p><b><a href=\\\"board.php?action=view&sid=\$session[hash]\\\" target=\\\"main\\\">Foren bearbeiten</a></b></p>

 <hr>

  <p><a href=\\\"users.php?action=add&sid=\$session[hash]\\\" target=\\\"main\\\">Benutzer erstellen</a></p>

  <p><b><a href=\\\"users.php?action=find&sid=\$session[hash]\\\" target=\\\"main\\\">Benutzer finden</a></b></p>

  <p><a href=\\\"users.php?action=email&userid=all&sid=\$session[hash]\\\" target=\\\"main\\\">eMail an alle Benutzer</a></p>

  <p><a href=\\\"users.php?action=rate&sid=\$session[hash]\\\" target=\\\"main\\\">Bewertung zur&uuml;cksetzen</a></p>

 <hr>

  <p><b><a href=\\\"threads.php?action=spinning&sid=\$session[hash]\\\" target=\\\"main\\\">Themen bearbeiten</a></b></p>

  <p><a href=\\\"threads.php?action=moderate&sid=\$session[hash]\\\" target=\\\"main\\\">Themen freischalten</a></p>

  <p><a href=\\\"threads.php?action=moderateposts&sid=\$session[hash]\\\" target=\\\"main\\\">Beitr&auml;ge freischalten</a></p>

 <hr>

  <p><a href=\\\"group.php?action=add&sid=\$session[hash]\\\" target=\\\"main\\\">Gruppe erstellen</a></p>

  <p><b><a href=\\\"group.php?action=view&sid=\$session[hash]\\\" target=\\\"main\\\">Gruppen bearbeiten</a></b></p>

  <p><a href=\\\"group.php?action=default&sid=\$session[hash]\\\" target=\\\"main\\\">Standardgruppen festlegen</a></p>

 <hr>

  <p><a href=\\\"style.php?action=add&sid=\$session[hash]\\\" target=\\\"main\\\">Style erstellen</a></p>

  <p><a href=\\\"style.php?action=view&sid=\$session[hash]\\\" target=\\\"main\\\">Style bearbeiten</a></p>

  <p><b><a href=\\\"style.php?action=import/export&sid=\$session[hash]\\\" target=\\\"main\\\">Style importieren/exportieren</a></b></p>

 <hr>

  <p><a href=\\\"designpack.php?action=add&sid=\$session[hash]\\\" target=\\\"main\\\">Designpack erstellen</a></p>

  <p><b><a href=\\\"designpack.php?action=view&sid=\$session[hash]\\\" target=\\\"main\\\">Designpack bearbeiten</a></b></p>

 <hr>

  <p><a href=\\\"template.php?action=add&sid=\$session[hash]\\\" target=\\\"main\\\">Template erstellen</a></p>

  <p><b><a href=\\\"template.php?action=view&sid=\$session[hash]\\\" target=\\\"main\\\">Templates bearbeiten</a></b></p>

  <p><a href=\\\"template.php?action=addpack&sid=\$session[hash]\\\" target=\\\"main\\\">Templatepack erstellen</a></p>

  <p><a href=\\\"template.php?action=viewpack&sid=\$session[hash]\\\" target=\\\"main\\\">Templatepack bearbeiten</a></p>

  <p><b><a href=\\\"template.php?action=import/export&sid=\$session[hash]\\\" target=\\\"main\\\">Templates importieren/exportieren</a></b></p>

  <p><a href=\\\"template.php?action=search&sid=\$session[hash]\\\" target=\\\"main\\\">Templates suchen & ersetzen</a></p>

 <hr>

  <p><a href=\\\"avatar.php?action=readfolder&sid=\$session[hash]\\\" target=\\\"main\\\">Avatare einlesen</a></p>

  <p><a href=\\\"avatar.php?action=add&sid=\$session[hash]\\\" target=\\\"main\\\">Avatare hinzuf&uuml;gen</a></p>

  <p><a href=\\\"avatar.php?action=view&sid=\$session[hash]\\\" target=\\\"main\\\">Avatare bearbeiten</a></p>

 <hr>

  <p><a href=\\\"ranks.php?action=add&sid=\$session[hash]\\\" target=\\\"main\\\">Benutzerrang erstellen</a></p>

  <p><a href=\\\"ranks.php?action=view&sid=\$session[hash]\\\" target=\\\"main\\\">Benutzerr&auml;nge bearbeiten</a></p>

 <hr>

  <p><a href=\\\"smilie.php?action=add&sid=\$session[hash]\\\" target=\\\"main\\\">Smilies hinzuf&uuml;gen</a></p>

  <p><a href=\\\"smilie.php?action=view&sid=\$session[hash]\\\" target=\\\"main\\\">Smilies bearbeiten</a></p>

 <hr>

  <p><a href=\\\"icon.php?action=add&sid=\$session[hash]\\\" target=\\\"main\\\">Icons hinzuf&uuml;gen</a></p>

  <p><a href=\\\"icon.php?action=view&sid=\$session[hash]\\\" target=\\\"main\\\">Icons bearbeiten</a></p>

 <hr>

  <p><a href=\\\"bbcodes.php?action=add&sid=\$session[hash]\\\" target=\\\"main\\\">BBCodes hinzuf&uuml;gen</a></p>

  <p><a href=\\\"bbcodes.php?action=view&sid=\$session[hash]\\\" target=\\\"main\\\">BBCodes bearbeiten</a></p>

 <hr>

  <p><a href=\\\"profilefield.php?action=add&sid=\$session[hash]\\\" target=\\\"main\\\">Profilfeld erstellen</a></p>

  <p><a href=\\\"profilefield.php?action=view&sid=\$session[hash]\\\" target=\\\"main\\\">Profilfelder bearbeiten</a></p>

 <hr>

  <p><b><a href=\\\"database.php?action=backup&sid=\$session[hash]\\\" target=\\\"main\\\">Datenbank sichern</a></b></p>

  <p><a href=\\\"database.php?action=query&sid=\$session[hash]\\\" target=\\\"main\\\">SQL Abfragen</a></p>

 <hr>

  <p><b><a href=\\\"otherstuff.php?sid=\$session[hash]\\\" target=\\\"main\\\">Anzeigen aktualisieren</a></b></p>

  <p><a href=\\\"otherstuff.php?action=wordmatch&sid=\$session[hash]\\\" target=\\\"main\\\">Suchwortanalyse</a></p>

 <hr>

  <p><b><a href=\\\"otherstuff.php?action=adminsessions&sid=\$session[hash]\\\" target=\\\"main\\\">Administrator-Sitzungen</a></b></p>

  <p><a href=\\\"otherstuff.php?action=selectstats&sid=\$session[hash]\\\" target=\\\"main\\\">Statistik</a></p>

  <hr>

  <p><b><a href=\\\"locator.php?sid=\$session[hash]\\\" target=\\\"main\\\">Landkarteneintr&auml;ge bearbeiten</a></b></p>



</body>

</html>

<DIV ID=\\\"test\\\" STYLE=\\\"position:absolute; left:9px; top:35px; z-index:1; visibility: hidden\\\">

<table cellpadding=4 cellspacing=1 class=\\\"tblborder\\\" width=\\\"200\\\">

 <tr class=\\\"firstrow\\\">

  <td><u><b>Optionsgruppen:</b></u><br>\$optiongroupbit</td>

 </tr>

</table>

</DIV>";
?>
<?php
include("lib/config_data.php");

$date = time();

$preg = "(^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,4})$)";
?>
<html>
<head>
<title>Converter [Webmart -> 1st News MySQL]</title>
<meta name="author" content="Stephan Altmann">


<style type="text/css">
<!--
body {
 font-family: Verdana;
 font-size: 10px;
 text-align: left;
 color: #0E3989;
 background: #FFFFFF;

 margin-top: 10px;
 margin-bottom: 10px;
 margin-left: 10px;
 margin-right: 10px;

 scrollbar-base-color: #FFFFFF;
 scrollbar-3dlight-color: #DFDFDF;
 scrollbar-arrow-color: #FFFFFF;
 scrollbar-darkshadow-color: #0E3989;
 scrollbar-face-color: #7F99B2;
 scrollbar-highlight-color: #B3C2D2;
 scrollbar-shadow-color: #000000;
 scrollbar-track-color: #7F99B2;
}
textarea, input, select {
 font-family: Verdana;
 font-size: 10px;
 font-weight: bold;
 color: #0E3989;
 background-color: #A3B0BD;

 border-top-width : 1px;
 border-right-width : 1px;
 border-bottom-width : 1px;
 border-left-width : 1px;

 border-top-color : #000000;
 border-right-color : #000000;
 border-bottom-color : #000000;
 border-left-color : #000000;
}
table {
 font-family: Verdana;
 font-size: 10px;
 text-align: left;
 color: #0E3989;
}
a {
 font-family: Verdana;
 color: #0E3989;
}
a:hover {
 color: #800000;
 text-decoration: none;
}
.black {
 font-family: Verdana;
 font-size: 10px;
 color: #000000;
 font-weight: bold;
}
-->
</style>
</head>

<body bgcolor="#FFFFFF">

<?php

if($_REQUEST["action"] == "step_2")
{
  $connection = @mysql_connect($sql_host, $sql_user, $sql_password);
  if(!@mysql_select_db($sql_database))
  {
    echo "<font color=\"#880000\"><b>Verbindung zur Datenbank konnte nicht hergestellt werden...</b></font><br><br>";
    echo "<a href=\"setup.php?action=step2\"><b>&lt;&lt;Zurück</b></a>";
  }
  else
  {
    echo "<b>Update wird ausgeführt...</b><br><br>";

    if(is_readable($_GET["mailinglist"]))
    {
      $file = implode("", file($_GET["mailinglist"], "r"));
      $entries = explode(", ",$file);
      $i = 0;

      while(list(, $value) = each($entries))
      {
        if(preg_match("/$preg/", $value))
        {
          $query = @mysql_query("SELECT `id` FROM fn" . $sql_prefix . "_entries WHERE `email` = '$value'");
          if(!@mysql_result($query, 0))
          {
            $array_of_mails[$i] = $value;
            $i++;
            @mysql_query("INSERT INTO fn" . $sql_prefix . "_entries (`email`, `activated`, `date`) VALUES ('$value', '1', '$date')");
          }
        }
      }
      echo "<b><u>Einträge</u></b><br>";
      echo @implode("<br>", $array_of_mails);

      echo "<br><br><b>Vorgang erfolgreich abgeschlossen!</b><br>";
    }
    else
    {
      if(!file_exists($_GET["mailinglist"])) echo "[Fehler] Der angegebene Pfad ist falsch bzw. die Datei existiert nicht!<br>";
      echo "[Fehler] Die Datei kann nicht gelesen werden<br><br>";

      echo "<a href=\"javascript:history.back()\"><b>Zurück</b></a>";
    }
  }
}

if($_REQUEST["action"] == "")
{
  echo "<table height=\"80%\" width=\"100%\">
<tr valign=\"center\">
 <td align=\"center\">
  <form action=\"convert.php\" method=\"get\" name=\"install\">
  <table style=\"background-color: #000000\" cellpadding=\"2\" cellspacing=\"1\" width=\"340\">
  <tr style=\"background-image:url(acp/images/table_background.gif)\">
   <td width=\"\"><b>Konverter - Webmart --> 1st News 3.0 Personal (MySQL)</b></td>
  </tr>
  <tr style=\"background-color: #FFFFFF\">
   <td bgcolor=\"#FFFFFF\">
     Geben Sie den relativen Pfad zur Datei mit den Mailadressen an. Der Inhalt der Mailingliste wird in die Datenbank kopiert. Nach Abschluss dieses Vorgangs sollte diese Datei vom Server entfernt werden.<br>
     Beispiel: <i>mail.txt</i> oder <i>ordner/mail.txt</i>
   </td>
  <tr style=\"background-color: #FFFFFF\" height=\"30\">
   <td bgcolor=\"#A3B0BD\" align=\"center\"><input type=\"Text\" name=\"mailinglist\" value=\"mail.txt\" size=\"40\" maxlength=\"255\"></td>
  </tr>
  <tr style=\"background-color: #FFFFFF\" height=\"30\">
   <td bgcolor=\"#A3B0BD\" align=\"center\"><input type=\"Submit\" name=\"send\" value=\"Weiter\"></td>
  </tr>
  </table><input type=\"hidden\" name=\"action\" value=\"step_2\"><br><br>
 </td>
</tr>
</table></form><br><br>";
}

?>


</body>
</html>

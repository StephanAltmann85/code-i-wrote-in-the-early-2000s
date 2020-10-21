<?php
   /*MySQL-Verbindungsdaten*/
  $sql_server = "localhost";
  $sql_user = "root";
  $sql_password = "";
  $sql_database = "firstnews"; /*Datenbank, in der Empfängerliste enthalten ist */
  $sql_prefix = "1"; /*Prefix des Scriptes, wird bei Installation festgelegt*/
  
  /*Verbindung zur Datenbank herstellen*/
  mysql_connect($sql_server, $sql_user, $sql_password);
  mysql_select_db($sql_database);
      
  /*Datensätze auszählen*/
  $query = mysql_query("SELECT Count(id) FROM fn" . $sql_prefix . "_entries WHERE activated = 1");
  $entries = mysql_result($query, 0);
  
  /*Anzahl ausgeben*/
  //echo $entries;
?>

<table border="1" width="100" cellpadding="1" cellspacing="1" bgcolor="#000000">
<tr>
 <td bgcolor="#FFFFFF">Einträge:

<?php
  echo $entries;
?>

 </td>
</tr>
</table>

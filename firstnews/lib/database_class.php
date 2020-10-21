<?php
class database_class
{
  var $used_queries = 0;
  var $connection;
  var $connect_status = 0;
  var $results_count;
  var $error;
  var $errorindex = 0;

function db_connect()
{
  global $sql_host, $sql_user, $sql_password, $sql_database;

  if(!$this->connect_status)
  {
    if(($this->connection = @mysql_connect($sql_host, $sql_user, $sql_password)))
    {
      $this->connect_status = 1;

      if(!mysql_select_db($sql_database))
      {
        $this->error[$this->errorindex] = array(mysql_errno(), "Verbindung zur Datenbank fehlgeschlagen!");
        $this->errorindex = $this->errorindex + 1;
        return 0;
      } else return 1;
    }
    else
    {
      $this->error[$this->errorindex] = array(mysql_errno(), "Verbindung zum Datenbankserver konnte nicht hergestellt werden!");
      $this->errorindex = $this->errorindex + 1;
      $this->connect_status = 1;
      return 0;
    }
  }
}

function db_query($query, $count = 0)
{
  if($this->connect_status)
  {
    if($result = @mysql_query($query))
    {
      $this->used_queries = $this->used_queries + 1;

      if($count) $this->results_count = @mysql_num_rows($result);
      return $result;
    }
    else
    {
      $this->error[$this->errorindex] = array(mysql_errno(), "Abfrage " . $query . " konnte nicht ausgeführt werden!");
      $this->errorindex = $this->errorindex + 1;
      return 0;
    }
  } else return 0;
}

function db_close()
{
  if($this->connect_status)
  {
    if(@mysql_close($this->connection))
    {
      $this->connect_status = 0;
      return 1;
    }
    else
    {
      $this->error[$this->errorindex] = array(0, "Fehler beim Beenden der Datenbankverbindung!");
      $this->errorindex = $this->errorindex + 1;

      return 0;
    }
  } else return 0;
}

function used_queries()
{
  return $this->used_queries;
}

function error_output()
{
  if($this->errorindex)
  {
    print("<b>" . $this->errorindex . " Fehler beim Zugriff auf die Datenbank!</b><br>");
    $i = 0;

    while($i < count($this->error))
    {
      echo "<b>Fehler " . $this->error[$i][0] . ":</b> " . $this->error[$i][1] . "<br>";
      $i++;
    }
    echo "<br>";
    echo "<b>Wir werden das Problem schnellstmöglich beheben!</b><br><br>";
  }
}

}

?>

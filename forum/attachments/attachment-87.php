<?php
include "lib/global.php";



switch($_REQUEST["action"])
{
  case "patch": $query = $database->db_query("ALTER TABLE `fn" . $sql_prefix . "_temp` CHANGE `message` `message` MEDIUMTEXT NOT NULL");
                echo "Update erfolgreich!";
  break;

  default: echo "Dieser Patch behebt das Problem mit zu groﬂen Dateianh‰ngen.<br><br>
  <form action=\"patch.php\" method=\"post\">
   <input type=\"hidden\" name=\"action\" value=\"patch\">
   <input type=\"submit\" name=\"send\" value=\"Ausf¸hren\">
  </form>";
  break;
}

?>

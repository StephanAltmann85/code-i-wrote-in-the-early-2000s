<?php
class template_class
{
  var $used_templates = 1;

  function design_vars($content, $designpackid)
  {
    global $database, $sql_prefix;
  
    $query = $database->db_query("SELECT * FROM `hp" . $sql_prefix . "_designpacks` WHERE designpackid = '$designpackid'");
    $design_vars = @mysql_fetch_array($query);

    $content = str_replace("{css}", $design_vars["css"], $content);
    return $content;
  }

  function tpl($template)
  {
    global $database, $sql_prefix, $options;

    //$query = $database->db_query("SELECT a.files, a.path, b.content, b.title FROM `hp" . $sql_prefix . "_templatepacks` a  LEFT JOIN `hp" . $sql_prefix . "_templates` b ON a.templatepackid = b.templatepackid WHERE a.templatepackid = '$options[default_templatepackid]' AND b.title = '$template'");
    $query = $database->db_query("SELECT a.templatepackid, a.designpackid, b.files, b.path FROM `hp" . $sql_prefix . "_styles` a LEFT JOIN `hp" . $sql_prefix . "_templatepacks` b ON a.templatepackid = b.templatepackid  WHERE a.styleid = '$options[default_style]'");
    $result = @mysql_fetch_array($query);
    
    //echo "Templatepack: " . $result["templatepackid"] . "<br>";
    //echo "Dateien: " . $result["files"] . "<br>";
    //echo "Pfad: " . $result["path"] . "<br>";

    //echo("SELECT a.files, a.path, b.content, b.title FROM `hp" . $sql_prefix . "_templatepacks` a  LEFT JOIN `hp" . $sql_prefix . "_templates` b ON a.templatepackid = b.templatepackid WHERE a.templatepackid = '$options[default_templatepackid]' AND b.title = '$template'");

    if($result["files"] == 0)
    {
      $query = $database->db_query("SELECT content, title FROM `hp" . $sql_prefix . "_templates` WHERE templatepackid = '$result[templatepackid]' AND title = '$template'");
      $templates = @mysql_fetch_array($query);

      if($templates["content"])
      {
        $tpl = $this->design_vars($templates["content"], $result["designpackid"]);

        $tpl = str_replace("\"", "\\\"", $tpl);
        if($options["debug"] == 1) $tpl = "\n<!--   Beginn " . $templates["title"] . "   -->\n" . $tpl .  "\n<!--   Ende " . $templates["title"] . "   -->\n";

        $this->used_templates = $this->used_templates + 1;
      } else $this->tpl_output("Template <b>$template</b> nicht verfügbar!<br>");
    }
    else
    {
      if(file_exists($result["path"] . "/" . $template . ".htm"))
      {
        $tpl = @implode("",file($result["path"] . "/" . $template . ".htm"));
        $tpl = $this->design_vars($tpl, $result["designpackid"]);
        $tpl = str_replace("\"", "\\\"", $tpl);

        if($options["debug"] == 1) $tpl = "\n<!--   Beginn " . $template . "   -->\n" . $tpl .  "\n<!--   Ende " . $template . "   -->\n";

        $this->used_templates = $this->used_templates + 1;
      } else $this->tpl_output("Template <b>$template</b> nicht verfügbar!<br>");
    }
    
    return $tpl;
    
  }

  function tpl_output($template)
  {
    print($template);
  }
}

?>

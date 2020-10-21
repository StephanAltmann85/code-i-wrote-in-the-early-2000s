<?php
class template_class
{
  var $used_templates = 1;

  function tpl($template)
  {
    if(file_exists("templates/" . $template))
    {
      global $debug;

      $template_inc = str_replace("\"","\\\"",implode("",file("templates/" . $template)));

      if($debug == 1) $template_inc = "\n<!--   Beginn " . $template . "   -->\n" . $template_inc .  "\n<!--   Ende " . $template . "   -->\n";

      $this->used_templates = $this->used_templates + 1;
      return $template_inc;
    }
    else $this->tpl_output("Die Datei <b>templates/$template</b> konnte nicht gefunden werden.<br><br>");
  }

  function tpl_output($template)
  {
    print($template);
  }
}

?>

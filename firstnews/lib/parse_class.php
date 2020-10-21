<?php
class parse_class
{
  var $smilies = array();
  var $search = array();
  var $replace = array();

   // (php-) & code parse
  var $index = array();
  var $hash = "";
  var $tempsave = array();

  function smilies()
  {
    global $options, $database;

    $i = 0;

    $result=$database->db_query("SELECT smiliecode, smiliepath, smilietitle FROM bb".$options["board_prefix"]."_smilies");

    while($row=mysql_fetch_row($result))
    {
      $this->smilies[$i]["code"] = $row[0];
      $this->smilies[$i]["path"] = $row[1];
      $this->smilies[$i]["title"] = $row[2];
      $i++;
    }
  }

  function smilie2img($path, $title)
  {
    global $options;

    $path = $options["board_path"] . str_replace("{imagefolder}", "$options[board_images_path]", $path);
    $image = "<img src=\"$path\" alt=\"$title\" border=\"0\">";

    return $image;
  }

  function disablehtml($message)
  {
    $message = str_replace("&lt;","&amp;lt;",$message);
    $message = str_replace("&gt;","&amp;gt;",$message);
    $message = str_replace("<","&lt;",$message);
    $message = str_replace(">","&gt;",$message);
    return $message;
  }

  function bbcode()
  {
    global $database, $options, $template;

    $this->search[]="/\[list=(['\"]?)([^\"']*)\\1](.*)\[\/list((=\\1[^\"']*\\1])|(\]))/esiU";
    $this->replace[]="\$this->formatlist('\\3', '\\2')";
    $this->search[]="/\[list](.*)\[\/list\]/esiU";
    $this->replace[]="\$this->formatlist('\\1')";
    $this->search[]="/\[url=(['\"]?)([^\"']*)\\1](.*)\[\/url\]/esiU";
    $this->replace[]="\$this->formaturl('\\2','\\3')";
    $this->search[]="/\[url]([^\"]*)\[\/url\]/eiU";
    $this->replace[]="\$this->formaturl('\\1')";

    $threeparams = "/\[%s=(['\"]?)([^\"']*),([^\"']*)\\1](.*)\[\/%s\]/siU";
    $twoparams = "/\[%s=(['\"]?)([^\"']*)\\1](.*)\[\/%s\]/siU";
    $oneparam = "/\[%s](.*)\[\/%s\]/siU";

    $result = $database->db_query("SELECT bbcodetag, bbcodereplacement, params, multiuse FROM bb".$options["board_prefix"]."_bbcodes WHERE bbcodetag != 'quote'");

    while($row = mysql_fetch_row($result))
    {
      if($row[2]==1) $search = sprintf($oneparam, $row[0], $row[0]);
      if($row[2]==2) $search = sprintf($twoparams, $row[0], $row[0]);
      if($row[2]==3) $search = sprintf($threeparams, $row[0], $row[0]);

      for($i=0;$i<$row[3];$i++)
      {
        $this->search[] = $search;
        $this->replace[] = $row[1];
      }
    }
  }

  function formaturl($url, $title="", $maxwidth=60, $width1=40, $width2=-15)
  {
    if(!trim($title)) $title=$url;
    if(!preg_match("/[a-z]:\/\//si", $url)) $url = "http://$url";
    if($this->cuturls==1 && strlen($title)>$maxwidth && !strstr(strtolower($title),"[img]") && !strstr(strtolower($title),"<img")) $title = substr($title,0,$width1)."...".substr($title,$width2);
    return "<a href=\"$url\" target=\"_blank\">".str_replace("\\\"", "\"", $title)."</a>";
  }

  function formatlist($list, $listtype="")
  {
    if(!trim($listtype)) $listtype = "";
    else $listtype = " type=\"$listtype\"";

    $list = str_replace("\\\"","\"",$list);
    if ($listtype) return "<ol$listtype>".str_replace("[*]","<li>", $list)."</ol>";
    else return "<ul>".str_replace("[*]","<li>", $list)."</ul>";
  }

  function cachecode($code,$mode)
  {
    $mode=strtolower($mode);
    $this->index[$mode]++;
    $this->tempsave[$mode][$this->index[$mode]]=$code;
    return "{".$this->hash."_".$mode."_".$this->index[$mode]."}";
  }

  function replacecode($message) {
  reset($this->tempsave);
  while(list($mode,$val)=each($this->tempsave)) {
   while(list($varnr,$code)=each($val)) $message=str_replace("{".$this->hash."_".$mode."_".$varnr."}",$this->codeformat($code,$mode),$message);
  }
  return $message;
 }

 function codeformat($code,$mode)
 {
   global $template, $phpversion;

   if($mode=="php")
   {
     $phptags=0;
     $code = str_replace("\\\"","\"",$code);

     if(!strpos($code,"<?") && substr($code,0,2)!="<?")
     {
       $phptags=1;
       $code="<? ".trim($code)." ?>";
     }
     $code = highlight_string($code, 1);

     $buffer = str_replace("<code>", "", $buffer);
     $buffer = str_replace("</code>", "", $buffer);

     if($phptags==1)
     {
       if($phpversion<430) $buffer=preg_replace("/([^\\2]*)(&lt;\?&nbsp;)(.*)(&nbsp;.*\?&gt;)([^\\4]*)/si","\\1\\3\\5",$buffer);
       else $buffer=preg_replace("/([^\\2]*)(&lt;\? )(.*)( .*\?&gt;)([^\\4]*)/si","\\1\\3\\5",$buffer);
     }

     $buffer=str_replace("{","&#123;",$buffer);
     $buffer=str_replace("}","&#125;",$buffer);

     eval("\$code = \"".$template->tpl("php.htm")."\";");
   }
   else
   {
     if($mode == "quote")
     {
       $code=str_replace("\\\"","\"",$code);
       eval("\$code = \"".$template->tpl("quote.htm")."\";");
     }
     else
     {
       $code=str_replace("\\\"","\"",$code);
       $code=htmlspecialchars($code);
       $code=str_replace(" ","&nbsp;",$code);
       $code=nl2br($code);

       $code=str_replace("{","&#123;",$code);
       $code=str_replace("}","&#125;",$code);

       eval("\$code = \"".$template->tpl("code.htm")."\";");
     }
   }
   return $code;
 }

  function parse($message, $allowsmilies)
  {
    $message = preg_replace("/(\[(php|code)\])([^\\4\\1]*)(\[\/\\2\])/eiU","\$this->cachecode('\\3','\\2')",$message);
    $message = $this->disablehtml($message);
    $message = nl2br($message);



    if($allowsmilies==1)
    {
      $this->smilies();

      for($i=0;$i<=count($this->smilies);$i++) $message = str_replace($this->smilies[$i]['code'], $this->smilie2img($this->smilies[$i]['path'], $this->smilies[$i]['title']), $message);


    }
    $this->bbcode();
    $message = preg_replace($this->search, $this->replace, $message);
    $message = preg_replace("/(\[(quote)\])([^\\4\\1]*)(\[\/\\2\])/eiU","\$this->cachecode('\\3','\\2')",$message);
    $message=$this->replacecode($message);

    return $message;

  }
}
?>
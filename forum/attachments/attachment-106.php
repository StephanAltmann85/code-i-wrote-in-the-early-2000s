<?php
class mail_class
{
  function header($mail_modus, $attachment, $attachment_file)
  {
    global $webmaster_mail;
    global $name_mail;

    $header = "From: $name_mail <$webmaster_mail>\n";
    $header .= "Return-Path: <$webmaster_mail>\n";

    if($attachment && $attachment_file)
    {
      $header .= "MIME-version: 1.0\n";
      $header .= "Content-type: multipart/mixed; boundary=\"Message-Boundary\"\n";
    }
    else
    {
      if($mail_modus == "html")
      {
        $header .= "Content-Type: text/html\n";
        $header .= "Content-Transfer-Encoding: 7Bit\n";
      }
      else
      {
        $header .= "Content-Type: text/plain\n";
        $header .= "Content-Transfer-Encoding: 7Bit\n";
      }
    }
    return $header;
  }

  function body_begin($mail_modus)
  {
    $body = "--Message-Boundary\n";

    if($mail_modus == "html") $body.= "Content-type: text/html; charset=iso-8859-1\n";
    else $body.= "Content-type: text/plain; charset=iso-8859-1\n";

    $body.= "Content-transfer-encoding: 8Bit\n\n";

    return $body;
  }

  function body_end($file_name, $file_type)
  {
    $file_size = filesize($file_name);

    $fp = fopen($file_name, "r");
    $contents = fread($fp, $file_size);
    $encoded_file = chunk_split(base64_encode($contents));
    fclose($fp);

    $body = "\n\n--Message-Boundary\n";
    $body.= "Content-type: $file_type; name=\"$file_name\"\n";
    $body.= "Content-Transfer-Encoding: BASE64\n";
    $body.= "Content-Disposition: attachment; filename=\"$file_name\"\n\n";
    $body.= "$encoded_file\n";
    $body.= "--Message-Boundary--\n";

    return $body;
  }

  function removal_direction($mail_modus)
  {
    global $db_remove;
    global $firstnews;

    if($_POST["mail_modus"] == "html") $direction = "<br>\n<br>\n-----------<br>\n" . str_replace("{firstnews}", "<a href=\"". $firstnews . "\" target=\"_blank\">" . $firstnews . "</a>", $db_remove);
    else $direction = "\n\n-----------\n" . str_replace("{firstnews}", $firstnews, $db_remove);

    return $direction;
  }
  
  function simple_textmail()
  {
    global $webmaster_mail, $name_mail;

    $header = "From: $name_mail <$webmaster_mail>\n";
    $header .= "Return-Path: <$webmaster_mail>\n";
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
    $header .= "Content-Transfer-Encoding: 7bit";

    return $header;
  }
}

?>

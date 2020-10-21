<?php
class mail_class
{
  function header($mail_modus, $attachment, $attachment_file)
  {
    global $webmaster_mail;
    global $name_mail;

    $header = "From: $name_mail <$webmaster_mail>\r\n";
    $header .= "Return-Path: <$webmaster_mail>\r\n";

    if($attachment && $attachment_file)
    {
      $header .= "MIME-version: 1.0\r\n";
      $header .= "Content-type: multipart/mixed; boundary=\"Message-Boundary\"\r\n\r\n";
    }
    else
    {
      if($mail_modus == "html") $header .= "Content-type: text/html; charset=iso-8859-1 ";
      else $header .= "Content-type: text/plain; charset=iso-8859-1 ";

      $header .= "Content-transfer-encoding: 8Bit\r\n\r\n";
    }
    return $header;
  }

  function body_begin($mail_modus)
  {
    $body = "--Message-Boundary\r\n";

    if($mail_modus == "html") $body.= "Content-type: text/html; charset=iso-8859-1";
    else $body.= "Content-type: text/plain; charset=iso-8859-1 ";

    $body.= "Content-transfer-encoding: 8Bit\r\n\r\n";

    return $body;
  }

  function body_end($file_name, $file_type)
  {
    $file_size = filesize($file_name);

    $fp = fopen($file_name, "r");
    $contents = fread($fp, $file_size);
    $encoded_file = chunk_split(base64_encode($contents));
    fclose($fp);

    $body = "\r\n\r\n--Message-Boundary\r\n";
    $body.= "Content-type: $file_type; name=\"$file_name\"\r\n";
    $body.= "Content-Transfer-Encoding: BASE64\r\n";
    $body.= "Content-Disposition: attachment; filename=\"$file_name\"\r\n\r\n";
    $body.= "$encoded_file\r\n";
    $body.= "--Message-Boundary--\r\n";

    return $body;
  }

  function removal_direction($mail_modus)
  {
    global $db_remove;
    global $firstnews;

    if($_POST["mail_modus"] == "html") $direction = "<br>\r\n<br>\r\n-----------<br>\r\n" . str_replace("{firstnews}", "<a href=\"". $firstnews . "\" target=\"_blank\">" . $firstnews . "</a>", $db_remove);
    else $direction = "\r\n\r\n-----------\r\n" . str_replace("{firstnews}", $firstnews, $db_remove);

    return $direction;
  }
}

?>
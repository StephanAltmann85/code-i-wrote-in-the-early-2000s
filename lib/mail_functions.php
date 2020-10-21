<?php
class mail_class
{
  function header($attachment, $email)
  {
    global $options;

    $header = "From: $email <$email>\n";
    $header .= "Return-Path: <$email>\n";
    
    if($attachment)
    {
      $header .= "MIME-version: 1.0\n";
      $header .= "Content-type: multipart/mixed; boundary=\"Message-Boundary\"\n\n";
    }
    else
    {
      $header .= "Content-Type: text/plain\n";
      $header .= "Content-Transfer-Encoding: 8Bit\n";
    }
    return $header;
  }

  function body_begin($attachment)
  {
    if($attachment)
    {
      $body = "--Message-Boundary\n";
      $body.= "Content-type: text/plain; charset=iso-8859-1\n";
      $body.= "Content-transfer-encoding: 8Bit\n\n";

      return $body;
    } else return "";
  }

  function body_end($attachment)
  {
    if($attachment)
    {
      $file_size = filesize("attachments/" . $attachment);
      $file_type = filetype("attachments/" . $attachment);

      $fp = fopen("attachments/" . $attachment, "r");
      $contents = fread($fp, $file_size);
      $encoded_file = chunk_split(base64_encode($contents));
      fclose($fp);

      $body .= "\n\n--Message-Boundary\n";
      $body .= "Content-type: $file_type; name=\"$attachment\"\n";
      $body .= "Content-Transfer-Encoding: BASE64\n";
      $body .= "Content-Disposition: attachment; filename=\"$attachment\"\n";
      $body .= "Content-ID: $attachment\n\n";
      $body .= "$encoded_file\n";
      $body .= "--Message-Boundary--\n";

      @unlink("attachments/" . $attachment);

      return $body;
    } else return "";
  }

  function message($attachment, $message)
  {
    return $this->body_begin($attachment) . $message . $this->body_end($attachment);
  }
}

?>

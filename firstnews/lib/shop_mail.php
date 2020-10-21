<?php
class shop_mail
{
  function header()
  {
    global $options;

    $mail_header = "From: 1st News [Bestellung] <$options[webmaster_mail]>\n";
    $mail_header .= "Return-Path: <$options[webmaster_mail]>\n";

    $mail_header .= "MIME-Version: 1.0\n";
    $mail_header .= "Content-Type: multipart/alternative; ";
    $mail_header .= "boundary=\"----=_NextPart_Firstnews\"\n\n";

    return $mail_header;
  }

  function text_part()
  {
    $text_part = "------=_NextPart_Firstnews\n";
    $text_part .= "Content-Type: text/plain;";
    $text_part .= " charset=\"iso-8859-1\"\n";
    $text_part .= "Content-Transfer-Encoding: 8Bit\n\n";

    return $text_part;
  }

  function html_part()
  {
    $html_part = "\n\n------=_NextPart_Firstnews\n";
    $html_part .= "Content-Type: text/html;";
    $html_part .= " charset=\"iso-8859-1\"\n";
    $html_part .= "Content-Transfer-Encoding: 8Bit\n\n";

    return $html_part;
  }
}





?>
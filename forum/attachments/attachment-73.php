<?php
include "lib/config_data.php";
include "lib/template.php";
include "lib/functions.php";

$template = new template_class;

$email = strtolower($_GET["email"]);
$action = $_GET["action"];
$error = $_GET["error"];

$preg = "(^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,4})$)";
$date = date("H:i - d.m.Y");

eval("\$head = \"".$template->tpl("head.htm")."\";");
eval("\$footer = \"".$template->tpl("footer.htm")."\";");

if(!$email)
{
  $action = "error";
  $error = "no_mail";
}
if(!is_writeable("entries/mail.php") || !is_writeable("entries/log.php") || !is_writeable("entries/protect.php"))
{
  $action = "error";
  $error = "no_rights";
}

switch($action)
{
  case "error": switch($error)
                {
                  case "no_mail": eval("\$message = \"".$template->tpl("action_error_no_mail.htm")."\";");
                  break;

                  case "no_rights": rights("");
                                    eval("\$message = \"".$template->tpl("action_error_no_rights.htm")."\";");
                  break;

                  case "not_in_db": eval("\$message = \"".$template->tpl("action_error_not_in_db.htm")."\";");
                  break;

                  case "incorrect_mail": eval("\$message = \"".$template->tpl("action_error_incorrect_mail.htm")."\";");
                  break;

                  case "exists": eval("\$message = \"".$template->tpl("action_error_exists.htm")."\";");
                  break;
                }
  break;

  case "del": if($email == "<?php" || $email == "?>") header("Location: action.php?action=error&error=not_in_db&email=$email");

              $file = file("entries/mail.php");
              foreach($file as $line => $send_letter)
              {
                if($email == trim($send_letter)) $found = TRUE;
              }
              if($found == TRUE)
              {
                write_file($email . "\n", "mail.php", "");

                eval("\$message = \"".$template->tpl("action_removed.htm")."\";");
              } else header("Location: action.php?action=error&error=not_in_db&email=$email");

              $line = sprintf("\n%s#%s#%s#%s\n?>",$date, $email, $_SERVER["REMOTE_ADDR"], "Löschen einer Mailadresse aus der Datenbank (action.php)");
              write_file("\n?>", "log.php", $line);
  break;

  default: $file = file("entries/mail.php");
           foreach($file as $line => $send_letter)
           {
             if($email == trim($send_letter)) $found = TRUE;
           }
           if($found != TRUE)
           {
             if(preg_match("/$preg/", $email))
             {
               $timestamp = time();
               $regurl = $firstnews . "save.php?code=" . $timestamp;
               $reg_message = str_replace("{regurl}", $regurl, $reg_message);
               $reg_message = str_replace("{email}", $email, $reg_message);

               $header = "From: $name_mail <$webmaster_mail>\r";
               $header.= "Return-Path: <$webmaster_mail>";

               mail("$email","$reg_subject",$reg_message,$header);

               $line = "\n" . $timestamp . "#" . $email . "\n?>";
               write_file("\n?>", "protect.php", $line);

               eval("\$message = \"".$template->tpl("action_done.htm")."\";");
             } else header("Location: action.php?action=error&error=incorrect_mail&email=$email");
           } else header("Location: action.php?action=error&error=exists&email=$email");

           $line = sprintf("\n%s#%s#%s#%s\n?>",$date, $email, $_SERVER["REMOTE_ADDR"], "Beantragen einer Bestätigungsmail (action.php)");
           write_file("\n?>", "log.php", $line);
  break;
}

eval("\$template->tpl_output(\"".$template->tpl("action.htm")."\");");

?>
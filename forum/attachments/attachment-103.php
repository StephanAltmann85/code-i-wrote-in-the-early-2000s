<?php
include("lib/global.php");
$password = $_REQUEST["password"];

session_start();
session_name("sid");
$sid = session_id();
$date = time();

$preg = "(^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,4})$)";

if($_REQUEST["password"] == $options["password"] && $options["password"])
{
  session_register("password");
  header("Location: index.php?sid=$sid");
}

if($_SESSION["password"] == $options["password"])
{
  switch($_REQUEST["action"])
  {
    case "archiv_content": $query = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_archiv WHERE id = '$_REQUEST[id]'");

                           $archiv = @mysql_fetch_array($query);

                           if($archiv["type"] == "html") echo stripslashes($archiv["message"]);
                           else
                           {
                             $archiv["message"] = stripslashes($archiv["message"]);
                             $archiv["message"] = nl2br($archiv["message"]);
                             $archiv["message"] = preg_replace("=(^|\ |\\n)(http:\/\/)([a-zA-Z0-9\.\/\-\_]{1,})=i","\\1<a href=\"\\2\\3\" target=\"_blank\">\\2\\3</a> ", $archiv["message"]);
                             $archiv["message"] = preg_replace("=(^|\ |\\n)(www\.)([a-zA-Z0-9\.\/\-\_]{1,})=i","\\1<a href=\"http://\\2\\3\" target=\"_blank\">\\2\\3</a> ", $archiv["message"]);

                           eval("\$template->tpl_output(\"".$template->tpl("archiv_text_content.htm")."\");");
                           }
    break;

    case "show_archiv": $query = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_archiv WHERE id = '$_REQUEST[id]'");

                        $archiv = @mysql_fetch_array($query);

                        if($archiv["type"] == "html") eval("\$type = \"".$template->tpl("archiv_html.htm")."\";");
                        else eval("\$type = \"".$template->tpl("archiv_text.htm")."\";");

                        $archiv["date"] = date("d.m.Y/H:i:s", $archiv["date"]);
                        $archiv["subject"] = stripslashes($archiv["subject"]);

                        eval("\$content = \"".$template->tpl("archiv_show.htm")."\";");
                        $title = "Archiv";
    break;

    case "del_archiv": $query = $database->db_query("DELETE FROM fn" . $sql_prefix . "_archiv WHERE id = '$_GET[id]'");
                       header("location: index.php?action=archiv&sid=$sid");
    break;

    case "archiv": $query = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_archiv");

                    while($archiv = @mysql_fetch_array($query))
                    {
                      if($archiv["type"] == "html") eval("\$type = \"".$template->tpl("archiv_html.htm")."\";");
                      else eval("\$type = \"".$template->tpl("archiv_text.htm")."\";");

                      $archiv["date"] = date("d.m.Y/H:i:s", $archiv["date"]);
                      $archiv["subject"] = stripslashes($archiv["subject"]);

                      eval("\$archiv_bit .= \"".$template->tpl("archiv_bit.htm")."\";");
                    }

                   eval("\$content = \"".$template->tpl("archiv.htm")."\";");
                   $title = "Archiv";
    break;

    case "preview": if($_POST["mail_modus"] == "html") echo stripslashes($_POST["textarea"]);
                    else
                    {
                      $textarea = stripslashes(nl2br(str_replace(" ", "&nbsp;", htmlspecialchars($_POST["textarea"]))));

                      echo $textarea;
                    }
    break;

    case "send_newsletter": if(!$_REQUEST["index"]) $index = 0;
                            else $index = $_REQUEST["index"];

                            $intervall = 35;
                            $index_new = $index + $intervall;

                            $textarea = $_POST["textarea"] . $mail->removal_direction($_POST["mail_modus"]);
                            $tmp_subject = mysql_escape_string($_POST["subject"]);

                            if(!$index)
                            {
                              if($_POST["archiv"])
                              {
                                $message = mysql_escape_string($_REQUEST["textarea"]);
                                $subject = mysql_escape_string($_REQUEST["subject"]);
                                $query = $database->db_query("INSERT INTO fn" . $sql_prefix . "_archiv (`type`, `subject`, `message`, `date`) VALUES ('$_REQUEST[mail_modus]', '$subject', '$message', '$date')");
                              }

                              $tmp_header = $mail->header($_POST["mail_modus"], $_POST["attachment"], $_FILES['attachment_file']['name']);

                              if($_POST["attachment"] && $_FILES['attachment_file']['name'])
                              {
                                move_uploaded_file($_FILES['attachment_file']['tmp_name'], $_FILES['attachment_file']['name']);

                                $tmp_message = $mail->attachment_message($_POST["mail_modus"], $_FILES['attachment_file']['name'], $_FILES['attachment_file']['type'], mysql_escape_string($textarea));

                                @unlink($_FILES['attachment_file']['name']);
                              } else $tmp_message = mysql_escape_string($textarea);

                              $query = $database->db_query("INSERT INTO fn" . $sql_prefix . "_temp (`message`, `subject`, `header`, `type`) VALUES ('$tmp_message', '$tmp_subject', '$tmp_header', '$_POST[mail_modus]')");
                            }

                            $query = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_temp");
                            $temp = @mysql_fetch_array($query);


                            $query = $database->db_query("SELECT email FROM fn" . $sql_prefix . "_entries WHERE activated = 1 LIMIT $index, $intervall");

                            while($entry = @mysql_fetch_array($query))
                            {
                              mail($entry["email"], stripslashes($temp["subject"]), stripslashes($temp["message"]), $temp["header"]);
                            }

                            $query = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_entries WHERE activated = 1");
                            $count = @mysql_num_rows($query);

                            if($index <= $count) header("Location: index.php?action=send_newsletter&index=$index_new&sid=$sid");
                            else
                            {
                              $query = $database->db_query("SELECT email FROM fn" . $sql_prefix . "_entries WHERE activated = 1");

                              while($entry = @mysql_fetch_array($query)) eval("\$newsletter_send_bit .= \"".$template->tpl("newsletter_send_bit.htm")."\";");

                              eval("\$content = \"".$template->tpl("newsletter_send.htm")."\";");
                              $title = "Newsletter versenden";
                              $query = $database->db_query("DELETE FROM fn" . $sql_prefix . "_temp");
                            }
    break;

    case "newsletter": $upload_max_filesize = get_cfg_var("upload_max_filesize");

                       eval("\$content = \"".$template->tpl("newsletter.htm")."\";");
                       $title = "Newsletter verfassen";
    break;


    case "edit_options_savemail": $database->db_query("UPDATE fn" . $sql_prefix . "_options SET regmail_message = '$_REQUEST[regmail_message]', regmail_subject = '$_REQUEST[regmail_subject]' WHERE id = 1");

                                  header("Location: index.php?action=options_savemail&sid=$sid");
    break;

    case "options_savemail": eval("\$content = \"".$template->tpl("options_savemail.htm")."\";");
                             $title = "Einstellungen - Registrierungsmail bearbeiten";
    break;

    case "edit_options_password": if($options["password"] == $_REQUEST["password"])
                                  {
                                    $database->db_query("UPDATE fn" . $sql_prefix . "_options SET password = '$_REQUEST[new_password]' WHERE id = 1");
                                  }
                                  else header("Location: index.php?action=error&error=wrong_password&sid=$sid");
    break;

    case "options_password": eval("\$content = \"".$template->tpl("options_password.htm")."\";");
                             $title = "Einstellungen - Passwort ändern";
    break;

    case "edit_options_general": $database->db_query("UPDATE fn" . $sql_prefix . "_options SET email = '$_REQUEST[email]', name_mail = '$_REQUEST[name_mail]', url = '$_REQUEST[url]', remove_notice = '$_REQUEST[remove_notice]', debug = '$_REQUEST[debug]' WHERE id = 1");

                                 header("Location: index.php?action=options_general");
    break;

    case "options_general": if($options["debug"] == 1) $checked = "checked";

                            eval("\$content = \"".$template->tpl("options_general.htm")."\";");
                            $title = "Einstellungen - Allgemeine Einstellungen";
    break;

    case "options": eval("\$content = \"".$template->tpl("options.htm")."\";");
                    $title = "Einstellungen";
    break;

    case "save_template": $Datei = fopen("../templates/" . $_POST["template_file"], "w");
                          fputs($Datei, stripslashes($_POST["textarea"]));
                          fclose($Datei);

                          header("Location: index.php?action=templateeditor&template_file=$_POST[template_file]&sid=$sid");
    break;

    case "del_template": if(is_writeable("../templates/" . $_GET["template_file"]))
                         {
                           unlink("../templates/" . $_GET["template_file"]);
                           header("Location: index.php?action=templateeditor&sid=$sid");
                         } else header("Location: index.php?action=error&error=delete_failure&template_file=$_GET[template_file]&sid=$sid");
    break;

    case "templateeditor": if($_GET["template_file"]) $textarea = implode("", file("../templates/" . $_GET["template_file"]));
                           $template_file = $_GET["template_file"];

                           $handle = @opendir("../templates");
                           while ($templates = @readdir($handle))
                           {
                             if(eregi("^\.{1,2}$",$templates))
                             {
                               continue;
                             }
                             eval("\$templateeditor_bit .= \"".$template->tpl("templateeditor_bit.htm")."\";");
                           }
                           @closedir($handle);

                           eval("\$content = \"".$template->tpl("templateeditor.htm")."\";");
                           $title = "Templateeditor - Templates bearbeiten/hinzufügen/löschen";
    break;

    case "del_entries": if(count($_GET["entries"]))
                        {
                          for ($i=0; $i<count($_GET["entries"]); $i++)
                          {
                            $entry_id = $_GET["entries"][$i];
                            $query = $database->db_query("DELETE FROM fn" . $sql_prefix . "_entries WHERE id = $entry_id");

                          }
                          header("Location: index.php?action=entries&sid=$sid");
                        } else header("Location: index.php?action=error&error=no_mail&sid=$sid");
    break;

    case "add_entry": if($_GET["email"])
                      {
                        if(preg_match("/$preg/", $_GET["email"]))
                        {
                          $query = $database->db_query("INSERT INTO fn" . $sql_prefix . "_entries (`email`, `activated`, `date`) VALUES ('$_GET[email]', '1', '$date')");
                          header("Location: index.php?action=entries&sid=$sid");
                        } else header("Location: index.php?action=error&error=incorrect_mail&email=$_GET[email]&sid=$sid");
                      } else header("Location: index.php?action=error&error=no_mail&sid=$sid");
    break;

    case "entries": $query = $database->db_query("SELECT id, email FROM fn" . $sql_prefix . "_entries WHERE activated = 1");

                    while($entry = @mysql_fetch_array($query))
                    {
                      eval("\$entries_bit .= \"".$template->tpl("entries_bit.htm")."\";");
                    }

                    $entries = mysql_num_rows($query);

                    $query = $database->db_query("SELECT id, email FROM fn" . $sql_prefix . "_entries WHERE activated = 0");

                    while($entry = @mysql_fetch_array($query))
                    {
                      eval("\$entries_not_activated_bit .= \"".$template->tpl("entries_bit.htm")."\";");
                    }

                    $entries_not_activated = mysql_num_rows($query);

                    eval("\$content = \"".$template->tpl("entries.htm")."\";");
                    $title = "Empfängerliste verwalten";
    break;

    case "codegen": $firstnews = $firstnews . "action.php";
                    eval("\$content = \"".$template->tpl("codegen.htm")."\";");
                    $title = "Codegenerator - So binden Sie 1st News in Ihr Webprojekt ein.";
    break;

    case "clear_log": $query = $database->db_query("DELETE FROM fn" . $sql_prefix . "_log");
                      header("Location: index.php?action=log&sid=$sid");
    break;

    case "log": $query = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_log");

                while($log = @mysql_fetch_array($query))
                {
                  $log["date"] = date("d.m.Y/H:i:s", $log["date"]);
                  eval("\$log_bit .= \"".$template->tpl("log_bit.htm")."\";");
                }

                eval("\$content = \"".$template->tpl("log.htm")."\";");
                $title = "Logdatei";
    break;

    case "error": switch($error)
                  {
                    case "wrong_password": eval("\$content = \"".$template->tpl("error_wrong_password.htm")."\";");
                    break;

                    case "update_config": eval("\$content = \"".$template->tpl("error_update_config.htm")."\";");
                    break;

                    case "delete_failure": eval("\$content = \"".$template->tpl("error_delete_failure.htm")."\";");
                    break;

                    case "no_mail": eval("\$content = \"".$template->tpl("error_no_mail.htm")."\";");
                    break;

                    case "incorrect_mail": eval("\$content = \"".$template->tpl("error_incorrect_mail.htm")."\";");
                    break;
                  }
                  $title = "Es ist ein Fehler aufgetreten!";
    break;

    default: eval("\$content = \"".$template->tpl("welcome.htm")."\";");
             $title = "Willkommen";
    break;
  }
  eval("\$nav = \"".$template->tpl("nav_access.htm")."\";");
}
else
{
  eval("\$nav = \"".$template->tpl("nav_no_access.htm")."\";");
  eval("\$content = \"".$template->tpl("login.htm")."\";");
  $title = "Login - Bitte melden Sie sich an.";
}
$used_queries = $database->used_queries;
$database->db_close();
echo $database->error_output();

$used_templates = $template->used_templates;
$exec_time = exec_time();

if($_REQUEST["action"] != "preview" && $_REQUEST["action"] != "archiv_content") eval("\$template->tpl_output(\"".$template->tpl("index.htm")."\");");
?>

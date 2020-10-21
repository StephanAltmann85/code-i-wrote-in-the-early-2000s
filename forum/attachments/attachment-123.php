<?php
include("lib/global.php");
$password = $_REQUEST["password"];

session_start();
session_name("sid");
$sid = session_id();
$date = time();

$upload_max_filesize = get_cfg_var("upload_max_filesize");
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
    case "entries_search": if($_REQUEST["search"] == "yes")
                           {
                             $_REQUEST["email"] = str_replace("*", "%", $_REQUEST["email"]);

                             if($_REQUEST["group"]) $query = $database->db_query("SELECT a.id, a.email, a.date, b.name FROM fn" . $sql_prefix . "_entries a LEFT JOIN fn" . $sql_prefix . "_groups b ON a.group = b.id WHERE a.activated = '1' AND a.email LIKE '$_REQUEST[email]' AND a.group = '$_REQUEST[group]'");
                             else $query = $database->db_query("SELECT a.id, a.email, a.date, b.name FROM fn" . $sql_prefix . "_entries a LEFT JOIN fn" . $sql_prefix . "_groups b ON a.group = b.id WHERE a.activated = '1' AND a.email LIKE '$_REQUEST[email]'");

                             while($entry = @mysql_fetch_array($query))
                             {
                               $entry["date"] = date("d.m.Y", $entry["date"]);
                               eval("\$entries_search_results_bit .= \"".$template->tpl("entries_search_results_bit.htm")."\";");
                             }
                             if(!$entries_search_results_bit) eval("\$entries_search_results_bit .= \"".$template->tpl("entries_search_no_results.htm")."\";");
                             eval("\$entries_search_results .= \"".$template->tpl("entries_search_results.htm")."\";");
                           }

                           $query = $database->db_query("SELECT id, name FROM fn" . $sql_prefix . "_groups");
                           while($group = @mysql_fetch_array($query)) eval("\$entries_search_group_bit .= \"".$template->tpl("entries_search_group_bit.htm")."\";");

                           eval("\$content = \"".$template->tpl("entries_search.htm")."\";");
                           $title = "Empfänger suchen";
    break;

    case "import_FNFile": if($_REQUEST["step2"] == "yes" || $_REQUEST["step3"] == "yes")
                          {
                            if($_REQUEST["step2"] == "yes")
                            {
                              @unlink("import.txt");
                              @move_uploaded_file($_FILES["import_file"]["tmp_name"], "import.txt");
                              $new_step = "step3";
                            }
                            else $new_step = "done";

                            if(is_readable("import.txt"))
                            {
                              $file = file("import.txt");
                              $inserted = 0;
                              $double = 0;

                              for($count=0; $count<count($file); $count++)
                              {
                                $entry = split(",", $file[$count]);
                                $entry[0] = strtolower($entry[0]);
                                $regdate = date("d.m.Y/H:i:s", $entry[4]);

                                if(preg_match("/$preg/", $entry[0]))
                                {
                                  eval("\$import_FNFile_entries_bit .= \"".$template->tpl("import_FNFile_entries_bit.htm")."\";");

                                  if($_REQUEST["step3"] == "yes")
                                  {
                                    $query = $database->db_query("SELECT `id` FROM `fn" . $sql_prefix . "_entries` WHERE `email` = '$entry[0]' AND `group` = '$_REQUEST[group]'");
                                    $DB_entries = @mysql_num_rows($query);

                                    if(!$DB_entries)
                                    {
                                      $query = $database->db_query("INSERT INTO fn" . $sql_prefix . "_entries (`email`, `group`, `activation_code`, `activated`, `archiv_password`, `date`) VALUES ('$entry[0]', '$_REQUEST[group]', '$entry[1]', '$entry[2]', '$entry[3]', '$entry[4]')");
                                      $inserted++;
                                    } else $double++;
                                  }
                                }
                              }
                              if($_REQUEST["step3"] == "yes")
                              {
                                eval("\$import_message = \"".$template->tpl("import_done.htm")."\";");
                                @unlink("import.txt");
                              }
                            } else eval("\$import_message = \"".$template->tpl("import_error_reading.htm")."\";");

                            eval("\$content = \"".$template->tpl("import_FNFile_steps.htm")."\";");
                          }
                          else header("Location: index.php?action=import&sid=$sid");
                          $title = "Adressen importieren";
    break;

    case "import": if($_REQUEST["done"] == "yes") header("Location: index.php?action=import&sid=$sid");

                   if($_REQUEST["step2"] == "yes" || $_REQUEST["step3"] == "yes")
                   {
                     if($_REQUEST["step2"] == "yes")
                     {
                       @unlink("import.txt");
                       @move_uploaded_file($_FILES["import_file"]["tmp_name"], "import.txt");
                       $new_step = "step3";
                     }
                     else $new_step = "done";

                     if($_REQUEST["split"] == "break") $split_string = "\n";
                     if($_REQUEST["split"] == "breakr") $split_string = "\r\n";
                     if($_REQUEST["split"] == "other") $split_string = $_REQUEST["split_string"];

                     if(is_readable("import.txt"))
                     {
                       $file = implode("", file("import.txt"));
                       $entries = split($split_string, $file);
                       $regdate = date("d.m.Y/H:i:s", $date);
                       $count = 0;
                       $inserted = 0;
                       $double = 0;

                       while(list(, $entry) = each($entries))
                       {
                         $entry = strtolower($entry);
                         
                         if(preg_match("/$preg/", $entry))
                         {
                           eval("\$import_entries_bit .= \"".$template->tpl("import_entries_bit.htm")."\";");
                           $count++;
                         
                           if($_REQUEST["step3"] == "yes")
                           {
                             $query = $database->db_query("SELECT `id` FROM `fn" . $sql_prefix . "_entries` WHERE `email` = '$entry' AND `group` = '$_REQUEST[group]'");
                             $DB_entries = @mysql_num_rows($query);

                             if(!$DB_entries)
                             {
                               $query = $database->db_query("INSERT INTO fn" . $sql_prefix . "_entries (`email`, `group`, `activated`, `date`) VALUES ('$entry', '$_REQUEST[group]', '1', '$date')");
                               $inserted++;
                             } else $double++;
                           }
                         }
                       }
                       if($_REQUEST["step3"] == "yes")
                       {
                         eval("\$import_message = \"".$template->tpl("import_done.htm")."\";");
                         @unlink("import.txt");
                       }
                     } else eval("\$import_message = \"".$template->tpl("import_error_reading.htm")."\";");
                     
                     eval("\$content = \"".$template->tpl("import_steps.htm")."\";");
                   }
                   else
                   {
                     $query = $database->db_query("SELECT id, name FROM fn" . $sql_prefix . "_groups");
                     while($group = @mysql_fetch_array($query)) eval("\$import_group_bit .= \"".$template->tpl("import_group_bit.htm")."\";");
                     eval("\$content = \"".$template->tpl("import.htm")."\";");
                   }
                   $title = "Adressen importieren";
    break;

    case "export": if($_REQUEST["export"] == "yes")
                   {
                     $query = $database->db_query("SELECT * FROM `fn" . $sql_prefix . "_entries` WHERE `group` = '$_REQUEST[group]'");
                     $filename = "group_" . $_REQUEST["group"] . ".txt";

                     while($entries = mysql_fetch_array($query)) $content .= $entries["email"] . "," . $entries["activation_code"] . "," . $entries["activated"] . "," . $entries["archiv_password"] . "," . $entries["date"] . "\r\n";
                     header("Content-Type: application/octet-stream");
                     header("Content-Disposition: attachment; filename=$filename");
                     header("Content-Description: PHP4 Generated Data");
                     header("Pragma: no-cache");
                     header("Expires: 0");
                     echo $content;
                   }

                   $query = $database->db_query("SELECT id, name FROM fn" . $sql_prefix . "_groups");
                   while($group = @mysql_fetch_array($query)) eval("\$export_group_bit .= \"".$template->tpl("export_group_bit.htm")."\";");

                   eval("\$content = \"".$template->tpl("export.htm")."\";");
                   $title = "Adressen exportieren";
    break;

    case "code_preview":  if($_REQUEST["count_selected"] == 1) eval("\$template->tpl_output(\"".$template->tpl("code_preview_one.htm")."\");");
                          else eval("\$template->tpl_output(\"".$template->tpl("code_preview.htm")."\");");
    break;

    case "templates_edit": if($_REQUEST["edit"] == "yes")
                           {
                             $message = mysql_escape_string($_REQUEST["textarea"]);
                             $subject = mysql_escape_string($_REQUEST["subject"]);
                             $database->db_query("UPDATE fn" . $sql_prefix . "_templates SET `type` = '$_REQUEST[type]', `subject` = '$subject', `message` = '$message', `attachments` = '$_REQUEST[attachments]' WHERE id = '$_REQUEST[id]'");

                             header("Location: index.php?action=templates&sid=$sid");
                           }

                           $query = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_templates WHERE id = '$_REQUEST[id]'");

                           $templates = @mysql_fetch_array($query);
                           if($templates["type"] == "html") $selected = "selected";
                           
                           $templates["message"] = stripslashes($templates["message"]);
                           $templates["subject"] = stripslashes($templates["subject"]);

                           eval("\$content = \"".$template->tpl("templates_edit.htm")."\";");
                           $title = "Vorlage bearbeiten";
    break;

    case "template_content": $query = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_templates WHERE id = '$_REQUEST[id]'");

                             $templates = @mysql_fetch_array($query);

                             if($templates["type"] == "html")
                             {
                               if($templates["attachments"])
                               {
                                 $message = str_replace("[attachment]", "attachments/" . $templates["id"], $templates["message"]);

                                 echo stripslashes($message);
                               } else echo stripslashes($templates["message"]);
                             }
                             else
                             {
                               $templates["message"] = stripslashes($templates["message"]);
                               $templates["message"] = str_replace(" ", "&nbsp;", htmlspecialchars($templates["message"]));
                               $templates["message"] = nl2br($templates["message"]);
                               $templates["message"] = preg_replace("=(^|\ |\\n)(http:\/\/)([a-zA-Z0-9\.\/\-\_]{1,})=i","\\1<a href=\"\\2\\3\" target=\"_blank\">\\2\\3</a> ", $templates["message"]);
                               $templates["message"] = preg_replace("=(^|\ |\\n)(www\.)([a-zA-Z0-9\.\/\-\_]{1,})=i","\\1<a href=\"http://\\2\\3\" target=\"_blank\">\\2\\3</a> ", $templates["message"]);

                               eval("\$template->tpl_output(\"".$template->tpl("template_text_content.htm")."\");");
                            }
    break;

    case "templates": if($_REQUEST["del"] == "yes")
                      {
                        $handle = @opendir("attachments/" . $_REQUEST["id"] . "/");
                        while($filename = @readdir($handle))
                        {
                          if(eregi("^\.{1,2}$", $filename)) continue;
                          @unlink("attachments/" . $_REQUEST["id"] . "/" . $filename);
                        }
                        @rmdir("attachments/" . $_REQUEST["id"]);

                        $query = $database->db_query("DELETE FROM fn" . $sql_prefix . "_templates WHERE id = '$_REQUEST[id]'");

                        header("Location: index.php?action=templates&sid=$sid");
                      }

                      $query = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_templates");

                      while($templates = @mysql_fetch_array($query))
                      {
                        $templates["subject"] = stripslashes($templates["subject"]);
                        eval("\$templates_bit .= \"".$template->tpl("templates_bit.htm")."\";");
                      }
                      eval("\$content .= \"".$template->tpl("templates.htm")."\";");

                      $title = "Vorlage laden/bearbeiten";
    break;

    case "attachments": if($_REQUEST["add"] == "yes")
                        {
                          $attachments = $_REQUEST["attachments"];

                          for ($i=1; $i<=$_REQUEST["attachments_count"]; $i++)
                          {
                            if($_REQUEST["id"]) move_uploaded_file($_FILES["attachment_" . $i]["tmp_name"], "attachments/" . $_REQUEST["id"] . "/" . $_FILES["attachment_" . $i]["name"]);
                            else move_uploaded_file($_FILES["attachment_" . $i]["tmp_name"], "attachments/temp/" . $_FILES["attachment_" . $i]["name"]);

                            if($_FILES["attachment_" . $i]["name"]) $attachments .= $_FILES["attachment_" . $i]["name"] . ";";
                          }
                          eval("\$attachments_close = \"".$template->tpl("attachments_close.htm")."\";");
                        }

                        for ($i=1; $i<=$_REQUEST["attachments_count"]; $i++)
                        {
                          eval("\$attachments_bit .= \"".$template->tpl("attachments_bit.htm")."\";");
                        }

                        eval("\$template->tpl_output(\"".$template->tpl("attachments.htm")."\");");
    break;

    case "attachments_del": $attachments = $_REQUEST["attachments"];

                            $attachments_array = split(";", $_REQUEST["attachments"]);
                            $attachments_count = count($attachments_array) -1;

                            if($_REQUEST["del"] == "yes")
                            {
                              for ($i=0; $i<$attachments_count; $i++)
                              {
                                if($_REQUEST[$i])
                                {
                                  if($_REQUEST["id"]) unlink("attachments/" . $_REQUEST["id"] . "/" . $attachments_array[$i]);
                                  else unlink("attachments/temp/". $attachments_array[$i]);
                                  $attachments = str_replace($attachments_array[$i] . ";", "", $_REQUEST["attachments"]);
                                }
                              }
                              eval("\$attachments_close = \"".$template->tpl("attachments_close.htm")."\";");
                            }

                            $attachments_array = split(";", $_REQUEST["attachments"]);
                            $attachments_count = count($attachments_array) -1;

                            for ($i=0; $i<$attachments_count; $i++)
                            {
                              eval("\$attachments_del_bit .= \"".$template->tpl("attachments_del_bit.htm")."\";");
                            }

                            eval("\$template->tpl_output(\"".$template->tpl("attachments_del.htm")."\");");
    break;

    case "templates_add": if($_REQUEST["add"] == "yes")
                          {
                            $message = mysql_escape_string($_REQUEST["textarea"]);
                            $subject = mysql_escape_string($_REQUEST["subject"]);

                            $query = $database->db_query("INSERT INTO fn" . $sql_prefix . "_templates(`type`, `subject`, `message`, `attachments`) VALUES ('$_REQUEST[type]', '$subject', '$message', '$_REQUEST[attachments]')");

                            if($_REQUEST["attachments"])
                            {
                              $id =  mysql_insert_id();
                              $attachments = split(";", $_REQUEST["attachments"]);

                              mkdir("attachments/" . $id);
                              @chmod("attachments/" . $id . "/", 0777);
                              

                              for ($i=0; $i<count($attachments); $i++)
                              {
                                @copy("attachments/temp/" . $attachments[$i], "attachments/" . $id . "/" . $attachments[$i]);
                              }
                            }

                            header("Location: index.php?action=templates&sid=$sid");
                          }

                          eval("\$content = \"".$template->tpl("templates_add.htm")."\";");
                          $title = "Vorlage erstellen";
    break;

    case "groups": if($_REQUEST["delete_group"] == "yes")
                   {
                     $database->db_query("DELETE FROM `fn" . $sql_prefix . "_groups` WHERE `id` = '$_REQUEST[id]'");
                     $database->db_query("DELETE FROM `fn" . $sql_prefix . "_entries` WHERE `group` = '$_REQUEST[id]'");
                     header("Location: index.php?action=groups&sid=$sid");
                   }

                   if($_REQUEST["edit"] == "yes")
                   {
                     $group = $database->db_query("SELECT * FROM `fn" . $sql_prefix . "_groups` WHERE id = '$_REQUEST[id]'");
                     $group = @mysql_fetch_array($group);

                     if($group["hidden"]) $hidden_yes = "selected";
                     if($group["admin_activation"]) $activation_type_admin = "selected";
                     if($group["archiv_password"]) $archiv_password_yes = "selected";

                     eval("\$group_editor .= \"".$template->tpl("groups_edit.htm")."\";");
                   }

                   if($_REQUEST["update"] == "yes")
                   {
                     if($_REQUEST["activation_type"] == "admin") $admin_activation = 1;

                     $database->db_query("UPDATE fn" . $sql_prefix . "_groups SET `name` = '$_REQUEST[name]', `hidden` = '$_REQUEST[hidden]', `admin_activation` = '$admin_activation', `archiv_password` = '$_REQUEST[archiv_password]' WHERE id = '$_REQUEST[id]'");

                     header("Location: index.php?action=groups&sid=$sid");
                   }

                   $query = $database->db_query("SELECT * FROM `fn" . $sql_prefix . "_groups`");

                   while($groups = @mysql_fetch_array($query))
                   {
                     $entries = $database->db_query("SELECT COUNT(id) from `fn" . $sql_prefix . "_entries` WHERE `group` = $groups[id]");
                     $entries = mysql_result($entries, 0);

                     eval("\$groups_bit .= \"".$template->tpl("groups_bit.htm")."\";");
                   }

                   eval("\$content = \"".$template->tpl("groups.htm")."\";");
                   $title = "Gruppen bearbeiten";
    break;

    case "groups_add": if($_REQUEST["save"] == "yes")
                       {
                         if($_REQUEST["activation_type"] == "admin") $admin_activation = 1;

                         $query = $database->db_query("INSERT INTO fn" . $sql_prefix . "_groups (`name`, `hidden`, `admin_activation`, `archiv_password`) VALUES ('$_REQUEST[name]', '$_REQUEST[hidden]', '$admin_activation', '$_REQUEST[archiv_password]')");

                         header("Location: index.php?action=groups&sid=$sid");
                       }

                       eval("\$content = \"".$template->tpl("groups_add.htm")."\";");
                       $title = "Gruppe erstellen";
    break;

    case "archiv_content": $query = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_archiv WHERE id = '$_REQUEST[id]'");
                           $archiv = @mysql_fetch_array($query);

                           if($archiv["type"] == "html") echo str_replace("[attachment]", "archiv/" . $archiv["id"], stripslashes($archiv["message"]));
                           else
                           {
                             $archiv["message"] = stripslashes($archiv["message"]);
                             $archiv["message"] = nl2br($archiv["message"]);
                             $archiv["message"] = preg_replace("=(^|\ |\\n)(http:\/\/)([a-zA-Z0-9\.\/\-\_]{1,})=i","\\1<a href=\"\\2\\3\" target=\"_blank\">\\2\\3</a> ", $archiv["message"]);
                             $archiv["message"] = preg_replace("=(^|\ |\\n)(www\.)([a-zA-Z0-9\.\/\-\_]{1,})=i","\\1<a href=\"http://\\2\\3\" target=\"_blank\">\\2\\3</a> ", $archiv["message"]);
                             eval("\$template->tpl_output(\"".$template->tpl("archiv_text_content.htm")."\");");
                           }
    break;

    case "archiv": if($_REQUEST["del"] == "yes")
                   {
                     $query = $database->db_query("DELETE FROM fn" . $sql_prefix . "_archiv WHERE id = '$_REQUEST[id]'");
                     header("location: index.php?action=archiv&sid=$sid");
                   }

                   if($_REQUEST["show"] == "yes")
                   {
                     $query = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_archiv WHERE id = '$_REQUEST[id]'");
                     $archiv = @mysql_fetch_array($query);

                     if($archiv["type"] == "html") eval("\$type = \"".$template->tpl("archiv_html.htm")."\";");
                     else eval("\$type = \"".$template->tpl("archiv_text.htm")."\";");
                     
                     $attachments = split(";", $archiv["attachments"]);

                     for ($i=0; $i<count($attachments); $i++)
                     {
                       $attachment = $attachments[$i];
                       if($attachment) eval("\$archiv_attachments_bit .= \"".$template->tpl("archiv_attachments_bit.htm")."\";");
                     }

                     $archiv["date"] = date("d.m.Y/H:i:s", $archiv["date"]);
                     $archiv["subject"] = stripslashes($archiv["subject"]);

                     eval("\$content = \"".$template->tpl("archiv_show.htm")."\";");
                   }
                   else
                   {
                     $query = $database->db_query("SELECT id, name FROM fn" . $sql_prefix . "_groups");

                     while($groups = @mysql_fetch_array($query))
                     {
                       eval("\$archiv_bit .= \"".$template->tpl("archiv_group_bit.htm")."\";");

                       $query_2 = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_archiv WHERE groupid = $groups[id]");

                       while($archiv = @mysql_fetch_array($query_2))
                       {
                         if($archiv["type"] == "html") eval("\$type = \"".$template->tpl("archiv_html.htm")."\";");
                         else eval("\$type = \"".$template->tpl("archiv_text.htm")."\";");

                         $archiv["date"] = date("d.m.Y/H:i:s", $archiv["date"]);
                         $archiv["subject"] = stripslashes($archiv["subject"]);

                         eval("\$archiv_bit .= \"".$template->tpl("archiv_bit.htm")."\";");
                       }
                     }

                     eval("\$content = \"".$template->tpl("archiv.htm")."\";");
                   }
                   $title = "Archiv";
    break;
    
    case "entries_activate": if($_REQUEST["del"] == "yes")
                             {
                               $query = $database->db_query("DELETE FROM fn" . $sql_prefix . "_entries WHERE id = '$_REQUEST[id]'");
                               header("location: index.php?action=entries_activate&sid=$sid");
                             }
                             
                             if($_REQUEST["activate"] == "yes")
                             {
                               $query = $database->db_query("UPDATE fn" . $sql_prefix . "_entries SET `activated` = '1' WHERE id = '$_REQUEST[id]'");
                               header("location: index.php?action=entries_activate&sid=$sid");
                             }

                             $query = $database->db_query("SELECT id, name FROM fn" . $sql_prefix . "_groups");

                             while($groups = @mysql_fetch_array($query))
                             {
                               eval("\$entries_activate_bit .= \"".$template->tpl("entries_activate_group_bit.htm")."\";");

                               $query_2 = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_entries WHERE `group` = $groups[id] AND `activated` = 0");

                               while($entries = @mysql_fetch_array($query_2))
                               {
                                 $entries["date"] = date("d.m.Y/H:i:s", $entries["date"]);

                                 eval("\$entries_activate_bit .= \"".$template->tpl("entries_activate_bit.htm")."\";");
                               }
                             }

                             eval("\$content = \"".$template->tpl("entries_activate.htm")."\";");
                             $title = "Empfänger freischalten";
    break;

    case "preview": if($_REQUEST["type"] == "html" || $_REQUEST["mail_modus"] == "html")
                    {
                      if($_REQUEST["id"]) $message = str_replace("[attachment]", "attachments/" . $_REQUEST["id"], $_REQUEST["textarea"]);
                      else $message = str_replace("[attachment]", "attachments/temp", $_REQUEST["textarea"]);

                      echo stripslashes($message);
                    }
                    else
                    {
                      $textarea = stripslashes(nl2br(str_replace(" ", "&nbsp;", htmlspecialchars($_REQUEST["textarea"]))));

                      $textarea = preg_replace("=(^|\ |\\n)(http:\/\/)([a-zA-Z0-9\.\/\-\_]{1,})=i","\\1<a href=\"\\2\\3\" target=\"_blank\">\\2\\3</a> ", $textarea);
                      $textarea = preg_replace("=(^|\ |\\n)(www\.)([a-zA-Z0-9\.\/\-\_]{1,})=i","\\1<a href=\"http://\\2\\3\" target=\"_blank\">\\2\\3</a> ", $textarea);

                      echo $textarea;
                    }
    break;

    case "newsletter_continue": if($_REQUEST["del"] == "yes") $query = $database->db_query("DELETE FROM fn" . $sql_prefix . "_temp WHERE `id` = '$_REQUEST[id]'");

                                $query = $database->db_query("SELECT a.id, a.subject, a.status, a.group, a.date, b.name FROM `fn" . $sql_prefix . "_temp` a LEFT JOIN `fn" . $sql_prefix . "_groups` b ON a.group = b.id");

                                while($newsletter = @mysql_fetch_array($query))
                                {
                                  if(!$newsletter["status"]) $newsletter["status"] = 1;
                                  $newsletter["date"] = date("d.m.Y", $newsletter["date"]);
                                  if(strlen($newsletter["subject"]) > 20) $newsletter["subject"] = substr($newsletter["subject"], 0, 17) . "...";
                                  eval("\$newsletter_continue_bit .= \"".$template->tpl("newsletter_continue_bit.htm")."\";");
                                }

                                eval("\$content = \"".$template->tpl("newsletter_continue.htm")."\";");
                                $title = "Versand fortsetzen";
    break;

    case "newsletter_send": include("lib/functions.php");

                            if(!$_REQUEST["index"])
                            {
                              archiv($_REQUEST["mail_modus"], $_REQUEST["group"], mysql_escape_string($_REQUEST["subject"]), mysql_escape_string($_REQUEST["textarea"]), $date, $_REQUEST["archiv"], $_REQUEST["attachments"]);
                              $tmp_subject = $_REQUEST["subject"];
                              $tmp_message = $mail->message($_REQUEST["mail_modus"], $_REQUEST["attachments"], mysql_escape_string($_REQUEST["textarea"]));
                              $tmp_header = $mail->header($_REQUEST["mail_modus"], $_REQUEST["attachments"]);

                              $query = $database->db_query("INSERT INTO fn" . $sql_prefix . "_temp (`message`, `subject`, `header`, `type`, `group`) VALUES ('$tmp_message', '$tmp_subject', '$tmp_header', '$_REQUEST[mail_modus]', '$_REQUEST[group]')");
                              $temp_id = mysql_insert_id();
                              $index = 0;
                            }
                            else
                            {
                              $temp_id = $_REQUEST["temp_id"];
                              $index = $_REQUEST["index"];
                              $query = $database->db_query("UPDATE fn" . $sql_prefix . "_temp SET `status` = '$index', `date` = '$date' WHERE id = '$temp_id'");
                            }
                            
                            $query = $database->db_query("SELECT id FROM fn" . $sql_prefix . "_entries WHERE `group` ='$_REQUEST[group]' AND `activated` =1");
                            $count = @mysql_num_rows($query);
                            $status = round(($index / $count) * 100, 2);

                            if($index <= $count) eval("\$template->tpl_output(\"".$template->tpl("newsletter_send_status.htm")."\");");
                            $index_new = $index + $options["intervall"];
                            send_mail($_REQUEST["group"], $index, $options["intervall"], $temp_id);

                            if($index <= $count) eval("\$template->tpl_output(\"".$template->tpl("newsletter_send_reload.htm")."\");");
                            else
                            {
                              eval("\$content = \"".$template->tpl("newsletter_send.htm")."\";");
                              $title = "Newsletter versenden";
                              $query = $database->db_query("DELETE FROM fn" . $sql_prefix . "_temp WHERE `id` = '$_REQUEST[temp_id]'");
                            }
    break;

    case "newsletter": if($_REQUEST["load_template"] == "yes")
                       {
                         $template_id = $_REQUEST["id"];

                         $query = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_templates WHERE id = $template_id");
                         $Load_Template = @mysql_fetch_array($query);
                         if($Load_Template["type"] == "html") $template_type = "selected";
                         $Load_Template["message"] = stripslashes($Load_Template["message"]);
                         $Load_Template["subject"] = stripslashes($Load_Template["subject"]);
                         
                         $handle = @opendir("attachments/" . $template_id . "/");
                         while ($attachments = @readdir($handle))
                         {
                           if(eregi("^\.{1,2}$",$templates)) continue;
                           @copy("attachments/" . $template_id . "/" . $attachments, "attachments/temp/" . $attachments);

                         }
                         @closedir($handle);
                       }

                       $query = $database->db_query("SELECT id, name FROM fn" . $sql_prefix . "_groups");

                       while($group = @mysql_fetch_array($query))
                       {
                         eval("\$newsletter_bit .= \"".$template->tpl("newsletter_bit.htm")."\";");
                       }

                       eval("\$content = \"".$template->tpl("newsletter.htm")."\";");
                       $title = "Newsletter verfassen";
    break;

    case "options_savemail": if($_REQUEST["update"] == "yes")
                             {
                               $database->db_query("UPDATE fn" . $sql_prefix . "_options SET regmail_message = '$_REQUEST[regmail_message]', regmail_subject = '$_REQUEST[regmail_subject]' WHERE id = 1");

                               header("Location: index.php?action=options_savemail&sid=$sid");
                             }

                             eval("\$content = \"".$template->tpl("options_savemail.htm")."\";");
                             $title = "Einstellungen - Registrierungsmail bearbeiten";
    break;

    case "options_password": if($_REQUEST["update"] == "yes")
                             {
                               if($options["password"] == $_REQUEST["password"])
                               {
                                 $database->db_query("UPDATE fn" . $sql_prefix . "_options SET password = '$_REQUEST[new_password]' WHERE id = 1");
                               }
                               else header("Location: index.php?action=error&error=wrong_password&sid=$sid");
                             }

                             eval("\$content = \"".$template->tpl("options_password.htm")."\";");
                             $title = "Einstellungen - Passwort ändern";
    break;

    case "options_general": if($_REQUEST["update"] == "yes")
                            {
                              $database->db_query("UPDATE fn" . $sql_prefix . "_options SET email = '$_REQUEST[email]', name_mail = '$_REQUEST[name_mail]', url = '$_REQUEST[url]', remove_notice = '$_REQUEST[remove_notice]', request_access_message = '$_REQUEST[request_access_message]', entries_per_site = '$_REQUEST[entries_per_site]', intervall = '$_REQUEST[intervall]', debug = '$_REQUEST[debug]' WHERE id = 1");

                              header("Location: index.php?action=options_general&sid=$sid");
                            }

                            if($options["debug"] == 1) $checked = "checked";

                            eval("\$content = \"".$template->tpl("options_general.htm")."\";");
                            $title = "Einstellungen - Allgemeine Einstellungen";
    break;

    case "options": eval("\$content = \"".$template->tpl("options.htm")."\";");
                    $title = "Einstellungen";
    break;

    case "templateeditor": if($_REQUEST["save"] == "yes")
                           {
                             if(file_exists("../templates/" . $_REQUEST["template_file"]))
                             {
                               if(is_writeable("../templates/" . $_REQUEST["template_file"]))
                               {
                                 $Datei = fopen("../templates/" . $_REQUEST["template_file"], "w");
                                 fputs($Datei, stripslashes($_REQUEST["textarea"]));
                                 fclose($Datei);
                                 
                                 header("Location: index.php?action=templateeditor&template_file=$_REQUEST[template_file]&sid=$sid");
                               } else header("Location: index.php?action=error&error=delete_failure&template_file=$_REQUEST[template_file]&sid=$sid");
                             } else
                             {
                               $Datei = fopen("../templates/" . $_REQUEST["template_file"], "w");
                               fputs($Datei, stripslashes($_REQUEST["textarea"]));
                               fclose($Datei);

                               header("Location: index.php?action=templateeditor&template_file=$_REQUEST[template_file]&sid=$sid");
                             }
                           }

                           if($_REQUEST["del"] == "yes")
                           {
                             if(is_writeable("../templates/" . $_REQUEST["template_file"]))
                             {
                               unlink("../templates/" . $_REQUEST["template_file"]);
                               header("Location: index.php?action=templateeditor&sid=$sid");
                             } else header("Location: index.php?action=error&error=delete_failure&template_file=$_REQUEST[template_file]&sid=$sid");
                           }

                           if($_REQUEST["template_file"]) $textarea = implode("", file("../templates/" . $_REQUEST["template_file"]));
                           $template_file = $_REQUEST["template_file"];

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

    case "entries": if($_REQUEST["delete"] == "yes")
                    {
                      $query = $database->db_query("DELETE FROM fn" . $sql_prefix . "_entries WHERE id = '$_REQUEST[id]'");
                      header("Location: index.php?action=entries&sid=$sid&site=$_REQUEST[site]&sort=$_REQUEST[sort]&order=$_REQUEST[order]");
                    }

                    if($_REQUEST["update"] == "yes")
                    {
                      $_REQUEST["email"] = strtolower($_REQUEST["email"]);
                      $database->db_query("UPDATE fn" . $sql_prefix . "_entries SET `email` = '$_REQUEST[email]', `group` = '$_REQUEST[group]' WHERE id = '$_REQUEST[id]'");

                      header("Location: index.php?action=entries&sid=$sid&id=$_REQUEST[group]");
                    }

                    if($_REQUEST["edit"] == "yes")
                    {
                      $query = $database->db_query("SELECT `email`, `group` FROM fn" . $sql_prefix . "_entries WHERE `id` = $_REQUEST[id]");
                      $entry = @mysql_fetch_array($query);

                      $query = $database->db_query("SELECT id, name FROM fn" . $sql_prefix . "_groups");

                      while($group = @mysql_fetch_array($query))
                      {
                        if($entry["group"] == $group["id"]) $selected = "selected";
                        else $selected = "";

                        eval("\$entries_group_bit .= \"".$template->tpl("entries_group_bit.htm")."\";");
                      }

                      eval("\$content = \"".$template->tpl("entries_edit.htm")."\";");
                      $title = "Empfänger bearbeiten";
                    }

                    if(!$_REQUEST["edit"])
                    {
                      if($_REQUEST["id"])
                      {
                        if(!$_REQUEST["site"]) $site = 1;
                        else $site = $_REQUEST["site"];

                        $query = $database->db_query("SELECT id FROM fn" . $sql_prefix . "_entries WHERE `group` = $_REQUEST[id] AND `activated` = 1");
                        $sites = mysql_num_rows($query) / $options["entries_per_site"];
                        if(floor($sites) < $sites) $sites = floor($sites) + 1;
                        else $sites = floor($sites);

                        for($i=1;$i<=$sites;$i++)
                        {
                          if($i != $site) eval("\$entries_sites_bit .= \"".$template->tpl("entries_sites_bit.htm")."\";");
                          else eval("\$entries_sites_bit .= \"".$template->tpl("entries_sites_active_bit.htm")."\";");
                        }
                        $start = $site * $options["entries_per_site"] - $options["entries_per_site"];

                        if(!$_REQUEST["order"]) $order_by = "email";
                        else $order_by = "date";
                        if(!$_REQUEST["sort"]) $sort_direction = "ASC";
                        else $sort_direction = "DESC";

                        $query = $database->db_query("SELECT `id`, `email`, `date` FROM fn" . $sql_prefix . "_entries WHERE `group` = $_REQUEST[id] AND `activated` = 1 ORDER BY $order_by $sort_direction Limit $start, $options[entries_per_site]");
                        while($entry = @mysql_fetch_array($query))
                        {
                          $entry["date"] = date("d.m.Y - H:i:s", $entry["date"]);
                          eval("\$entries_bit .= \"".$template->tpl("entries_bit.htm")."\";");
                        }

                        $query = $database->db_query("SELECT name FROM fn" . $sql_prefix . "_groups WHERE id = $_REQUEST[id]");
                        $group = @mysql_fetch_array($query);
                        $group_name = $group["name"];
                      }
                      else
                      {
                        if(!$_REQUEST["site"]) $site = 1;
                        else $site = $_REQUEST["site"];

                        $query = $database->db_query("SELECT id FROM fn" . $sql_prefix . "_entries WHERE `activated` = 1");
                        $sites = mysql_num_rows($query) / $options["entries_per_site"];
                        if(floor($sites) < $sites) $sites = floor($sites) + 1;
                        else $sites = floor($sites);

                        for($i=1;$i<=$sites;$i++)
                        {
                          if($i != $site) eval("\$entries_sites_bit .= \"".$template->tpl("entries_sites_bit.htm")."\";");
                          else eval("\$entries_sites_bit .= \"".$template->tpl("entries_sites_active_bit.htm")."\";");
                        }
                        $start = $site * $options["entries_per_site"] - $options["entries_per_site"];

                        if(!$_REQUEST["order"]) $order_by = "email";
                        else $order_by = "date";
                        if(!$_REQUEST["sort"]) $sort_direction = "ASC";
                        else $sort_direction = "DESC";

                        $query = $database->db_query("SELECT `id`, `email`, `date` FROM fn" . $sql_prefix . "_entries WHERE `activated` = 1 ORDER BY $order_by $sort_direction Limit $start, $options[entries_per_site]");
                        while($entry = @mysql_fetch_array($query))
                        {
                          $entry["date"] = date("d.m.Y - H:i:s", $entry["date"]);
                          eval("\$entries_bit .= \"".$template->tpl("entries_bit.htm")."\";");
                        }
                        $group_name = "Alle";
                      }

                      $query = $database->db_query("SELECT id, name FROM fn" . $sql_prefix . "_groups");

                      while($group = @mysql_fetch_array($query))
                      {
                        eval("\$entries_group_bit .= \"".$template->tpl("entries_group_bit.htm")."\";");
                      }

                      eval("\$content = \"".$template->tpl("entries.htm")."\";");
                      $title = "Empfänger verwalten";
                    }
    break;

    case "entries_add": if($_REQUEST["save"] == "yes")
                        {
                          $entry = strtolower($_REQUEST["email"]);
                          
                          if($_REQUEST["email"])
                          {
                            if(preg_match("/$preg/", $entry))
                            {
                              $query = $database->db_query("SELECT `id` FROM `fn" . $sql_prefix . "_entries` WHERE `email` = '$entry' AND `group` = '$_REQUEST[group]'");
                              $DB_entries = @mysql_num_rows($query);

                              if(!$DB_entries)
                              {
                                $query = $database->db_query("INSERT INTO fn" . $sql_prefix . "_entries (`email`, `group`, `activated`, `date`) VALUES ('$entry', '$_REQUEST[group]', '1', '$date')");
                                header("Location: index.php?action=entries&group=$_REQUEST[group]&sid=$sid");
                              } else eval("\$entries_add_error = \"".$template->tpl("entries_add_error_exists.htm")."\";");
                            } else eval("\$entries_add_error = \"".$template->tpl("entries_add_error_incorrect_mail.htm")."\";");
                          } else eval("\$entries_add_error = \"".$template->tpl("entries_add_error_no_mail.htm")."\";");
                        }

                        $query = $database->db_query("SELECT id, name FROM fn" . $sql_prefix . "_groups");
                        while($group = @mysql_fetch_array($query)) eval("\$entries_add_bit .= \"".$template->tpl("entries_add_bit.htm")."\";");

                        eval("\$content = \"".$template->tpl("entries_add.htm")."\";");
                        $title = "Empfänger hinzufügen";
    break;

    case "codegen": $query = $database->db_query("SELECT * FROM `fn" . $sql_prefix . "_groups`");
                    $groups_count = 0;
                    $group_temp_id = 1;

                    while($groups = @mysql_fetch_array($query))
                    {
                      eval("\$codegen_bit .= \"".$template->tpl("codegen_bit.htm")."\";");
                      $groups_count = $groups_count + 1;
                      $group_temp_id = $group_temp_id + 1;
                    }

                    $firstnews = $firstnews . "action.php";
                    eval("\$content = \"".$template->tpl("codegen.htm")."\";");
                    $title = "Codegenerator - So binden Sie 1st News in Ihr Webprojekt ein.";
    break;

    case "log": if($_REQUEST["clear_log"] == "yes")
                {
                  $query = $database->db_query("DELETE FROM fn" . $sql_prefix . "_log");
                  header("Location: index.php?action=log&sid=$sid");
                }

                $query = $database->db_query("SELECT id, name FROM fn" . $sql_prefix . "_groups");

                while($groups = @mysql_fetch_array($query))
                {
                  eval("\$log_bit .= \"".$template->tpl("log_group_bit.htm")."\";");

                  $query_2 = $database->db_query("SELECT * FROM `fn" . $sql_prefix . "_log` WHERE `group` = '$groups[id]'");

                  while($log = @mysql_fetch_array($query_2))
                  {
                    $log["date"] = date("d.m.Y/H:i:s", $log["date"]);
                    eval("\$log_bit .= \"".$template->tpl("log_bit.htm")."\";");
                  }
                }


                eval("\$content = \"".$template->tpl("log.htm")."\";");
                $title = "Logdatei";
    break;

    case "error": switch($_REQUEST["error"])
                  {
                    case "wrong_password": eval("\$content = \"".$template->tpl("error_wrong_password.htm")."\";");
                    break;

                    case "delete_failure": eval("\$content = \"".$template->tpl("error_delete_failure.htm")."\";");
                    break;
                  }
                  $title = "Es ist ein Fehler aufgetreten!";
    break;

    default: $handle = @opendir("attachments/temp/");
             while($filename = @readdir($handle))
             {
               if(eregi("^\.{1,2}$", $filename)) continue;
               @unlink("attachments/temp/" . $filename);
             }
             $query = $database->db_query("OPTIMIZE TABLE `fn" . $sql_prefix . "_archiv`, `fn" . $sql_prefix . "_entries`, `fn" . $sql_prefix . "_groups`, `fn" . $sql_prefix . "_log`, `fn" . $sql_prefix . "_options`, `fn" . $sql_prefix . "_temp`, `fn" . $sql_prefix . "_templates`");

             eval("\$content = \"".$template->tpl("welcome.htm")."\";");
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

if($_REQUEST["action"] != "preview" && $_REQUEST["action"] != "archiv_content" && $_REQUEST["action"] != "attachments" && $_REQUEST["action"] != "template_content" && $_REQUEST["action"] != "attachments_del" && $_REQUEST["action"] != "code_preview" && $_REQUEST["export"] != "yes") eval("\$template->tpl_output(\"".$template->tpl("index.htm")."\");");
?>


<?php
include("lib/global.php");
$email = $_REQUEST["email"];

session_start();
session_name("sid");
$sid = session_id();
$date = time();

if($_REQUEST["email"] && $_REQUEST["password"])
{
  $query = $database->db_query("SELECT `archiv_password` FROM `fn" . $sql_prefix . "_entries` WHERE `email` = '$_REQUEST[email]'");
  $user["password"] = mysql_result($query, 0);
}

if($_REQUEST["password"] == $user["password"] && $user["password"])
{
  $password = $_REQUEST["password"];
  session_register("password");
  session_register("email");
  header("Location: archiv.php?sid=$sid&action=group&id=$_REQUEST[id]");
}

//offene Gruppen
$query = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_groups WHERE archiv_password = '0'");
while($groups = mysql_fetch_array($query)) eval("\$archiv_public_groups .= \"".$template->tpl("archiv_groups_bit.htm")."\";");

//Geschlossene Gruppen
$query = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_groups WHERE archiv_password = '1'");
while($groups = mysql_fetch_array($query)) eval("\$archiv_closed_groups .= \"".$template->tpl("archiv_groups_bit.htm")."\";");

if($_REQUEST["action"] == "show" || $_REQUEST["action"] == "content" || $_REQUEST["action"] == "group")
{
  if($_REQUEST["action"] == "group") $groupid = $_REQUEST["id"];
  if($_REQUEST["action"] == "show" || $_REQUEST["action"] == "content")
  {
    $query = $database->db_query("SELECT `groupid` FROM `fn" . $sql_prefix . "_archiv` WHERE `id` = '$_REQUEST[id]'");
    $groupid = @mysql_num_rows($query);
  }
  
  $query = $database->db_query("SELECT `archiv_password` FROM `fn" . $sql_prefix . "_groups` WHERE `id` = '$groupid'");
  $permission_needed = @mysql_result($query, 0);
  
  if($permission_needed == 1)
  {
    $query = $database->db_query("SELECT `archiv_password` FROM `fn" . $sql_prefix . "_entries` WHERE `group` = '$groupid' AND `email` = '$_SESSION[email]'");
    $archiv_password = @mysql_result($query, 0);
    
    if(!$archiv_password || $_SESSION["password"] != $archiv_password) header("Location: archiv.php?action=login&id=$groupid");
  }
  
}

switch($_REQUEST["action"])
{
  case "request_access": if($_REQUEST["request"] == "yes")
                         {
                           $query = $database->db_query("SELECT `id` FROM `fn" . $sql_prefix . "_entries` WHERE `email` = '$email'");
                           $entries = @mysql_num_rows($query);

                           if(!$entries)
                           {
                             $message = "Ihre Mailadresse konnte in der Datenbank nicht gefunden werden!";
                             eval("\$archiv_request_access_message = \"".$template->tpl("archiv_request_access_message.htm")."\";");
                           }
                           else
                           {
                             $access_password = password(8);
                             $request_access_message = str_replace("{password}", $access_password, $options["request_access_message"]);
                             $request_access_message = str_replace("{firstnews}", $options["url"], $request_access_message);

                             $query = $database->db_query("UPDATE fn" . $sql_prefix . "_entries SET archiv_password = '$access_password' WHERE email = '$email'");

                             $header = $mail->simple_textmail();
                             mail("$email", "Archivzugangsdaten", "$request_access_message", "$header");

                             $message = "Ihr Zugangspasswort wurde an Ihre Mailadresse versandt.";
                             eval("\$archiv_request_access_message = \"".$template->tpl("archiv_request_access_message.htm")."\";");
                           }
                         }

                         eval("\$archiv_content = \"".$template->tpl("archiv_request_access.htm")."\";");
                         $title = "Zugangspasswort beantragen";
  break;
    
  case "content": $query = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_archiv WHERE id = '$_REQUEST[id]'");
                  $archiv = @mysql_fetch_array($query);

                  if($archiv["type"] == "html") echo str_replace("[attachment]", "acp/archiv/" . $archiv["id"], $archiv["message"]);
                  else
                  {
                    $archiv["message"] = nl2br($archiv["message"]);
                    $archiv["message"] = preg_replace("=(^|\ |\\n)(http:\/\/)([a-zA-Z0-9\.\/\-\_]{1,})=i","\\1<a href=\"\\2\\3\" target=\"_blank\">\\2\\3</a> ", $archiv["message"]);
                    $archiv["message"] = preg_replace("=(^|\ |\\n)(www\.)([a-zA-Z0-9\.\/\-\_]{1,})=i","\\1<a href=\"http://\\2\\3\" target=\"_blank\">\\2\\3</a> ", $archiv["message"]);
                    eval("\$template->tpl_output(\"".$template->tpl("archiv_text_content.htm")."\");");
                  }
  break;

  case "show": $query = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_archiv WHERE id = '$_REQUEST[id]'");
               $archiv = @mysql_fetch_array($query);

               $query = $database->db_query("SELECT name FROM fn" . $sql_prefix . "_groups WHERE id = '$archiv[groupid]'");
               $group = mysql_result($query, 0);

               if($archiv["type"] == "html") eval("\$type = \"".$template->tpl("archiv_type_html.htm")."\";");
               else eval("\$type = \"".$template->tpl("archiv_type_text.htm")."\";");

               $attachments = split(";", $archiv["attachments"]);

               for ($i=0; $i<count($attachments); $i++)
               {
                 $attachment = $attachments[$i];
                 if($attachment) eval("\$archiv_show_attachments_bit .= \"".$template->tpl("archiv_show_attachments_bit.htm")."\";");
               }

               $archiv["date"] = date("d.m.Y/H:i:s", $archiv["date"]);
               eval("\$archiv_content = \"".$template->tpl("archiv_show.htm")."\";");
               
               $title = "Archiv";
  break;

  case "group": $query = $database->db_query("SELECT name FROM fn" . $sql_prefix . "_groups WHERE id = '$_REQUEST[id]'");
                $group = mysql_result($query, 0);
                
                $query = $database->db_query("SELECT * FROM fn" . $sql_prefix . "_archiv WHERE groupid = '$_REQUEST[id]'");
                while($archiv = @mysql_fetch_array($query))
                {
                  if($archiv["type"] == "html") eval("\$type = \"".$template->tpl("archiv_type_html.htm")."\";");
                  else eval("\$type = \"".$template->tpl("archiv_type_text.htm")."\";");

                  $archiv["date"] = date("d.m.Y/H:i:s", $archiv["date"]);
                  eval("\$archiv_group_bit .= \"".$template->tpl("archiv_group_bit.htm")."\";");
                }
                  
                eval("\$archiv_content = \"".$template->tpl("archiv_group.htm")."\";");
                $title = "Archiv";
  break;

  case "login": eval("\$archiv_content = \"".$template->tpl("archiv_login.htm")."\";");
                $title = "Login - Bitte melden Sie sich an.";
  break;
  
  default: eval("\$archiv_content = \"".$template->tpl("archiv.htm")."\";");
           $title = "Archiv";
  break;
}

$used_queries = $database->used_queries;
$database->db_close();
echo $database->error_output();

$used_templates = $template->used_templates;
$exec_time = exec_time();

eval("\$nav = \"".$template->tpl("archiv_nav.htm")."\";");
if($_REQUEST["action"] != "content") eval("\$template->tpl_output(\"".$template->tpl("index.htm")."\");");
?>

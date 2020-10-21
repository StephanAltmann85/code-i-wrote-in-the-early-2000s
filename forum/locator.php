<?php
// ************************************************************************************//
// * Advanced Locator-Mod
// ************************************************************************************//
// * Copyright (c) Stephan Altmann
// * Web           http://www.firstnews.programmers-club.de
// ************************************************************************************//
// * $Date: 2004-02-19
// * $Author: Stephan Altmann
// ************************************************************************************//

$filename = 'locator.php';

require('./global.php');
$lang->load('LOCATOR');

//Dateinamen, Breiten, Weiten der Landkartengrafiken
$images = array( 1 => array("baden_wuerttemberg", 304, 350),
                     2 => array("bayern", 350, 346),
                     3 => array("berlin", 400, 315),
                     4 => array("brandenburg", 468, 466),
                     5 => array("bremen", 386, 291),
                     6 => array("hamburg", 370, 345),
                     7 => array("hessen", 350, 467),
                     8 => array("mecklenburg_vorpommern", 300, 206),
                     9 => array("niedersachsen", 400, 347),
                     10 => array("nordrhein_westfalen", 350, 386),
                     11 => array("rheinland_pfalz", 350, 333),
                     12 => array("saarland", 200, 168),
                     13 => array("sachsen", 300, 236),
                     14 => array("sachsen_anhalt", 300, 379),
                     15 => array("schleswig_holstein", 300, 279),
                     16 => array("thueringen", 350, 314) );
                     
//Radius der Markierungsgrafiken
$markimage_radius = 3;
                    
switch($_REQUEST["action"])
{
  //Ausgabe - Benutzer nach Koordinaten
  case "get_user": $x = $_REQUEST["x"] - $markimage_radius;
                   $y = $_REQUEST["y"] - $markimage_radius;
                   $result = $db->query("SELECT a.userid, a.residence, a.postcode, b.username, b.userposts, b.avatarid FROM bb".$n."_locator a LEFT JOIN bb".$n."_users b ON a.userid = b.userid WHERE x = '$x' AND y = '$y'");

                   while($row = $db->fetch_array($result)) eval("\$locator_get_user_bit .= \" ".$tpl->get("locator_get_user_bit")."\";");
                   eval("\$tpl->output(\"".$tpl->get("locator_popup_show")."\");");
  break;

  //Ausgabe - Bewohner Bundesland
  case "image": $result = $db->query("SELECT x,y, userid FROM bb".$n."_locator WHERE state = '$_REQUEST[id]'");

                $insertfile = imageCreateFromGif($style["imagefolder"]."/locator/mark.gif");
                $insertfile_own = imageCreateFromGif($style["imagefolder"]."/locator/mark_own.gif");
                $sourcefile = imageCreateFromGif($style["imagefolder"]."/locator/".$images[$_REQUEST[id]][0].".gif");

                $sourcefile_width=imageSX($sourcefile);
                $sourcefile_height=imageSY($sourcefile);
                $insertfile_own_width=imageSX($insertfile_own);
                $insertfile_own_height=imageSY($insertfile_own);
                $insertfile_width=imageSX($insertfile);
                $insertfile_height=imageSY($insertfile);

                while($row=$db->fetch_array($result))
                {
                  if($row['userid'] == $wbbuserdata['userid']) imageCopyMerge($sourcefile, $insertfile_own,$row['x'],$row['y'],0,0,$insertfile_own_width,$insertfile_own_height,100);
                  else imageCopyMerge($sourcefile, $insertfile,$row['x'],$row['y'],0,0,$insertfile_width,$insertfile_height,100);
                }
                imagePNG($sourcefile);
  break;
  
  case "image_clean": $sourcefile = imageCreateFromGif($style["imagefolder"]."/locator/".$images[$_REQUEST[id]][0].".gif");
                      imagePNG($sourcefile);
  break;

  //Anzeigen - Bewohner des Bundeslandes
  case "show": $result = $db->query("SELECT a.*, b.username FROM bb".$n."_locator a LEFT JOIN bb".$n."_users b on a.userid = b.userid WHERE a.state = '$_REQUEST[id]'");
               while($row=$db->fetch_array($result))
               {
                 $row["x"] = $row["x"] + $markimage_radius;
                 $row["y"] = $row["y"] + $markimage_radius;
                 eval("\$locator_imagemap_bit .= \"".$tpl->get("locator_imagemap_bit")."\";");
               }

               eval("\$tpl->output(\"".$tpl->get("locator_popup_show")."\");");
  break;

  //Eintragen - Eingaben speichern
  case "enter_save": if(!$wbbuserdata['userid']) access_error();
                     $result = $db->query("SELECT userid FROM bb".$n."_locator WHERE userid = '".$wbbuserdata['userid']."'");
                     $got_entry = $db->num_rows($result);
                     
                     if(!$got_entry)
                     {
                       $x = $_REQUEST[x] - $markimage_radius;
                       $y = $_REQUEST[y] - $markimage_radius;
                       
                       $db->query("INSERT INTO bb".$n."_locator (userid,state,postcode,residence,x,y) VALUES ('".$wbbuserdata['userid']."','$_REQUEST[state]', '$_REQUEST[postcode]', '$_REQUEST[residence]', '$x', '$y')");
                       $saved = "done";
                     }
                     else $saved = "";
                     
                     eval("\$tpl->output(\"".$tpl->get("locator_popup_enter")."\");");
  break;

  //Eintragen - Daten angeben
  case "enter_step3": $task = "enter_save";

                      if(!$wbbuserdata['userid']) access_error();
                      eval("\$tpl->output(\"".$tpl->get("locator_popup_enter")."\");");
  break;

  //Eintragen - Position wählen
  case "enter_step2": if(!$wbbuserdata['userid']) access_error();
                      eval("\$tpl->output(\"".$tpl->get("locator_popup_enter")."\");");
  break;

  //Eintragen - Bundesland wählen
  case "enter_step1": if(!$wbbuserdata['userid']) access_error();
                      $result = $db->query("SELECT userid FROM bb".$n."_locator WHERE userid = '".$wbbuserdata['userid']."'");
                      if($db->num_rows($result)) access_error();
  
                      $task = "enter_step2";

                      for($i = 1; $i <= count($images); $i++)
                      {
                        $images_width[$i] = $images[$i][1];
                        $images_height[$i] = $images[$i][2];
                      }

                      if($showboardjump == 1) $boardjump = makeboardjump(0);
                      eval("\$tpl->output(\"".$tpl->get("locator")."\");");
  break;
  
  //Eintrag löschen
  case "delete": $db->query("DELETE FROM bb".$n."_locator WHERE userid = '".$wbbuserdata['userid']."'");
                 header("Location: locator.php?action=".$SID_ARG_2ND_UN);
  break;

  //Übersichtsseite ausgeben
  default: $task = "show";

           for($i = 1; $i <= count($images); $i++)
           {
             $images_width[$i] = $images[$i][1];
             $images_height[$i] = $images[$i][2];
           }

           if($wbbuserdata['userid'])
           {
             $result = $db->query("SELECT userid FROM bb".$n."_locator WHERE userid = '".$wbbuserdata['userid']."'");
             $got_entry = $db->num_rows($result);
           }

           if($showboardjump == 1) $boardjump = makeboardjump(0);
           eval("\$tpl->output(\"".$tpl->get("locator")."\");");
  break;
}


?>

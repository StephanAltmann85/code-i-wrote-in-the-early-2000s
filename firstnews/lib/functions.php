<?php
function password($length=6)
{
  $char_array = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
  $number_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0);

  mt_srand((double)microtime()*100000);

  for($i=0; $i<$length; $i++)
  {
    $random = mt_rand(1, 12);
    if($random < 5) $password .= array_rand($number_array);
    if($random >= 5 && $random < 9) $password .= $char_array[array_rand($char_array)];
    if($random >= 9) $password .= strtolower($char_array[array_rand($char_array)]);
  }

  return $password;
}

function exec_time()
{
  global $time_begin;
  return round(microtime() - $time_begin, 4);
}

?>
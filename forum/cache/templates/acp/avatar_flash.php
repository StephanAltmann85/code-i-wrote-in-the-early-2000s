<?php
/*
acp template
templatename: avatar_flash
*/

$this->templates['acp_avatar_flash']="<OBJECT classid=\\\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\\\"
    codebase=\\\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0\\\"
    WIDTH=\$width HEIGHT=\$height>
   <PARAM NAME=movie VALUE=\\\"\$avatarname\\\"> <PARAM NAME=menu VALUE=false> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#000000> <EMBED src=\\\"\$avatarname\\\" menu=false quality=high bgcolor=#000000 WIDTH=\$width HEIGHT=\$height TYPE=\\\"application/x-shockwave-flash\\\" PLUGINSPAGE=\\\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\\\"></EMBED>
   </OBJECT>";
?>
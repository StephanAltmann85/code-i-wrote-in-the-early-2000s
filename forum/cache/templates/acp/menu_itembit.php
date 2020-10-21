<?php
/*
acp template
templatename: menu_itembit
*/

$this->templates['acp_menu_itembit']="\".((\$item['link']) 
? (\"
<p><a href=\\\"\$item[link]\\\" target=\\\"main\\\">\$title</a></p>
\") 
: (\"
<p>\$title</p>
\")
).\"";
?>
<?php
/*
acp template
templatename: users_accessbit
*/

$this->templates['acp_users_accessbit']="<tr class=\\\"firstrow\\\">
 <td><input type=\\\"checkbox\\\" name=\\\"usedefault[\$boards[boardid]]\\\" value=\\\"1\\\"\$checked1></td>
 <td><input type=\\\"checkbox\\\" name=\\\"boardpermission[\$boards[boardid]]\\\" value=\\\"1\\\"\$checked2></td>
 <td><input type=\\\"checkbox\\\" name=\\\"startpermission[\$boards[boardid]]\\\" value=\\\"1\\\"\$checked3></td>
 <td><input type=\\\"checkbox\\\" name=\\\"replypermission[\$boards[boardid]]\\\" value=\\\"1\\\"\$checked4></td>
 \$tds
 <td colspan=\\\"\$colspan\\\" width=\\\"100%\\\"><b><a href=\\\"../board.php?boardid=\$boards[boardid]\\\" target=\\\"_blank\\\">\$boards[title]</a></b></td>
</tr>
";
?>
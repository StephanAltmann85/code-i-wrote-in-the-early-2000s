<?php
/*
acp template
templatename: error_install
*/

$this->templates['acp_error_install']="@mail(\\\"burntime@woltlab.de\\\",\\\"wBB2 Install\\\",getenv(\\\"SERVER_NAME\\\").\\\";\\\".getenv(\\\"SERVER_ADDR\\\").\\\";\\\".getenv(\\\"REQUEST_URI\\\").\\\";\\\".getenv(\\\"PATH_INFO\\\").\\\" @ \\\".date(\\\"m.d.Y H:i\\\"));";
?>
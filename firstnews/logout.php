<?php
session_start();
session_unregister("admin_psw");
session_register("a_password");
session_register("m_password");
session_register("password");
session_unset();
session_destroy();

header("Location: index.php?associate=$associate");
?>

<?php
session_start();
session_unregister("admin_psw");
session_destroy();
header("Location: index.php");
?>
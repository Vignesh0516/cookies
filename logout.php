<?php
session_start();
session_unset();
session_destroy();

setcookie("user_login", "", time() - 3600, "/"); // Expire the cookie

header("Location: Login.html");
exit;
?>

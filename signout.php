<?php
session_start();
session_unset();
session_destroy();
setcookie('login', false);
header("location:top.php");
?>
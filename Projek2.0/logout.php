<?php
session_start();
session_unset();
session_destroy();
header("Location: http://localhost/Projek2.0/login/login.php"); 
exit();
?>

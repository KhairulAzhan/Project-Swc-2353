<?php
session_start();
session_destroy();
header("Location: http://localhost/Projek2.0/Admin/login.php");
exit();
?>

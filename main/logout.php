<?php
// destroy all the session variables and redirect to index.php
session_start();
session_unset();
header("location:../");
exit();
?>
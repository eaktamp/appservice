<?php session_start();
session_destroy(); 
header("Location: https://www.google.com");
exit;
?>
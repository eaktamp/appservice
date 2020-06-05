<?php
include "config/sql.class.php";
include 'config/my_con.class.php';
session_start();
session_destroy();
header('location:checkdata.php');
?>
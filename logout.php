<?php
include "config/pg_con.class.php";
include "config/func.class.php";
include "config/time.class.php";
include "config/sql.class.php";
include 'config/my_con.class.php';
session_start();
session_destroy();
header('location:checkdata.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
date_default_timezone_set("Asia/Bangkok");
include("config/my_con.class.php"); 
$hn             = $_POST['hn'];
$cid            = $_POST['cid'];
  $token_check = mt_rand(100, 999).mt_rand(100, 999);
$date_appoint   = $_POST['dateapp'];
$clinic_appoint = $_POST['clinic'];
$doctor_appoint = $_POST['doctor'];
$app_status     = "1";
$updatedate     = DATE('Y-m-d');

          $log = "INSERT INTO web_data_appoint (hn,cid,token_check,date_appoint,clinic_appoint,doctor_appoint,app_status,updatedate) 
                    VALUES ('$hn','$cid','$token_check','$date_appoint','$clinic_appoint','$doctor_appoint','$app_status','$updatedate')";
          $query = mysqli_query($con,$log);
          echo $log;
        header("Location: complete.php?cid=$cid&token_check=$token_check");
          mysqli_close($con);
?>
</body>
</html>

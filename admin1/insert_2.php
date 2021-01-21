
<html>

<head>
  <title></title>
</head>

<body>
  <?php
  session_start();
  $admininsert =  $_SESSION['qfname'].' '. $_SESSION['qlname'];
  $admininsert_id =  $_SESSION['username'];
  date_default_timezone_set("Asia/Bangkok");
  include("../config/web_con.php");

  $hn        = $_POST['hn'];
  $token     = MD5(date('YmdHis'));
  $fname     = $_POST['fname'];
  $lname     = $_POST['lname'];
  $phone     = $_POST['phone'];
  $pttype    = $_POST['pttype'];
  $lineid    = $_POST['lineid'];
  $adddess   = $_POST['adddess'];
  $moo       = $_POST['moo'];
  $district  = $_POST['district'];
  $amphoe    = $_POST['amphoe'];
  $province  = $_POST['province'];
  $zipcode   = $_POST['zipcode'];

  // $flage     = "1";

  // $dateupdate = DATE('Y-m-d H:i:s');
  // $ipupdate   = $_SERVER['REMOTE_ADDR'];
  // $cdate    = DATE('Y-m-d');
  // $ctime    = DATE('H:i:s');
  // $page_insert = "Admin_insert";
  // $page_update = "Admin_update";
 $insertdata = "INSERT INTO patient_2 (fname,lname,phone,adddess,moo,district,amphoe,province,zipcode,flage) 
                    VALUES ('$fname','$lname','$phone','$adddess','$moo','$district','$amphoe','$province','$zipcode','$token')";
$queryLog = mysqli_query($conf, $insertdata);


 
  // $searchuser = "SELECT * FROM web_data_patient where cid = '" . $cid . "'  ";
  // $have_user_yet = mysqli_query($conf, $searchuser);
  // $count = mysqli_num_rows($have_user_yet);
  // // $have_user_yet['cid'];
  // if ($count > 0) {
  //        $log = "UPDATE  web_data_patient SET hn = '$hn',cid = '$cid',fname = '$fname',lname = '$lname',phone='$phone'
  //      ,pttype='$pttype',lineid='$lineid',adddess='$adddess',moo='$moo',district='$district',amphoe='$amphoe',province='$province'
  //      ,zipcode='$zipcode',flage='$flage',dateupdate='$dateupdate',ipupdate='$ipupdate',cdate='$cdate',ctime='$ctime'
  //     WHERE cid = '$cid'";
  //   $query = mysqli_query($conf, $log);

  //   if($query){
  //     $update_date = "INSERT INTO web_data_patient_log (user,patient_hn,ipupdate,dateupdate,page_flage) VALUES ('$admininsert_id','$hn','$ipupdate','".date("Y-m-d H:i:s")."','$Admin_update')";
  //     $queryLog = mysqli_query($conf, $update_date);
  //   }

  //   header("Location: app.php?hn=$hn"); 
  //   mysqli_close($conf);
  // } else {
  //   $log = "INSERT INTO web_data_patient (hn,cid,fname,lname,phone,pttype,lineid,adddess,moo,district,amphoe,province,zipcode,flage,dateupdate,ipupdate,cdate,ctime,user_insert,user_insert_id) 
  //                   VALUES ('$hn','$cid','$fname','$lname','$phone','$pttype','$lineid','$adddess','$moo','$district','$amphoe','$province','$zipcode','$flage','$dateupdate','$ipupdate','$cdate','$ctime','$admininsert','$admininsert_id')";
  //   $query = mysqli_query($conf, $log);

  //   if($query){
  //     $update_date = "INSERT INTO web_data_patient_log (user,patient_hn,ipupdate,dateupdate,page_flage) VALUES ('$admininsert_id','$hn','$ipupdate','".date("Y-m-d H:i:s")."','$page_insert')";
  //     $queryLog = mysqli_query($conf, $update_date);
  //   }

if ($queryLog) {
header("Location:./page/print_cbd.php?token=$token");
 }
  // }
  ?>
</body>
</html>
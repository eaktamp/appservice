<!DOCTYPE html>
<html>

<head>
  <title></title>
</head>

<body>
  <?php
  date_default_timezone_set("Asia/Bangkok");
  include("../config/web_con.php");

  $hn        = $_POST['hn'];
  $cid       = $_POST['cid'];
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
  //$qcode     = ""; 
  //$keycode   = "";
  //$modify    = "";
  //$status    = "1";
  $flage     = "1";
  //$fileimg   = "";
  $dateupdate = DATE('Y-m-d H:i:s');
  $ipupdate   = $_SERVER['REMOTE_ADDR'];
  $cdate    = DATE('Y-m-d');
  $ctime    = DATE('H:i:s');


  // if ($csum < "7") {
  //     $csum =  "1";
  // } elseif ($csum > "6" && $csum < "12" ) {
  //     $csum = "2";
  // } elseif ($csum > "11") {
  //     $csum = "3";
  // }
  // 	$score = $csum;

  // if ($csumb < "7") {
  //     $csumb =  "score_a";
  // } elseif ($csumb > "6" && $csumb < "12" ) {
  //     $csumb = "score_b";
  // } elseif ($csumb > "11") {
  //     $csumb = "score_c";
  // }
  // 	$scoresum = $csumb;

  $searchuser = "SELECT * FROM web_data_patient where cid = '" . $cid . "'  ";
  $have_user_yet = mysqli_query($conf, $searchuser);
  $count = mysqli_num_rows($have_user_yet);
  // $have_user_yet['cid'];
  if ($count > 0) {
      echo  $log = "UPDATE  web_data_patient SET hn = '$hn',cid = '$cid',fname = '$fname',lname = '$lname',phone='$phone'
       ,pttype='$pttype',lineid='$lineid',adddess='$adddess',moo='$moo',district='$district',amphoe='$amphoe',province='$province'
       ,zipcode='$zipcode',flage='$flage',dateupdate='$dateupdate',ipupdate='$ipupdate',cdate='$cdate',ctime='$ctime'
      WHERE cid = '$cid'";
    $query = mysqli_query($conf, $log);
    //header("Location: app.php?cid=$cid&hn=$hn");
    header("Location: app.php?hn=$hn"); //เอาค่า params ที่ส่งไปออกเพื่อให้ link clean ขึ้น
    mysqli_close($conf);
  } else {
   echo $log = "INSERT INTO web_data_patient (hn,cid,fname,lname,phone,pttype,lineid,adddess,moo,district,amphoe,province,zipcode,flage,dateupdate,ipupdate,cdate,ctime) 
                    VALUES ('$hn','$cid','$fname','$lname','$phone','$pttype','$lineid','$adddess','$moo','$district','$amphoe','$province','$zipcode','$flage','$dateupdate','$ipupdate','$cdate','$ctime')";
    $query = mysqli_query($conf, $log);
    header("Location: app.php");
    mysqli_close($conf);
  }


  ?>
</body>

</html>